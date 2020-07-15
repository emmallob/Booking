<?php

class Reservations extends Booking {

    /** Output */
    private $output = [];

    /**
     * Initialize the parent class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method lists items from the database table
     * 
     * The events to be listed in this reservation module are only those that the booking end time is not yet time.
     * 
     * @param stdClass $params              This is a composite of several dataset to be used for the query
     * 
     * @return Object
     */
    public function listItems(stdClass $params, $bypass = false) {
        
        try {
            /** Query to append */
            $queryAppend = null;

            $condition = !empty($params->event_guid) ? "AND a.event_guid='{$params->event_guid}'" : null;

            /** Confirm that the userid was set */
            if(isset($params->loggedInUser)) {
                $queryAppend = "
                    ,(
                        SELECT COUNT(*) 
                        FROM events_booking b 
                        WHERE 
                            b.created_by = '{$params->loggedInUser}' AND b.event_guid = a.event_guid
                    ) AS user_booking_count,
                    (
                        SELECT GROUP_CONCAT(hall_guid) 
                        FROM events_booking b 
                        WHERE 
                            b.created_by = '{$params->loggedInUser}' AND b.event_guid = a.event_guid
                    ) AS user_halls_booked
                "; 
            }

            /** If the request is to bypass */
            $bypass_query = !($bypass) ? "AND (TIMESTAMP(a.booking_end_time) > CURRENT_TIME()) AND a.state != 'past'" : null;

            /** Make the query for the list of events */
            $stmt = $this->db->prepare("
                SELECT 
                    a.event_guid, a.event_title, a.event_date, a.start_time, a.end_time, 
                    a.booking_start_time, a.booking_end_time, a.is_payable, a.allow_multiple_booking,
                    a.maximum_multiple_booking, a.attachment, a.description, a.state,
                    (
                        SELECT COUNT(*) FROM events_booking b WHERE b.event_guid = a.event_guid AND b.deleted = '0'
                    ) AS booked_count,
                    (
                        SELECT b.department_name FROM departments b WHERE b.department_guid = a.department_guid
                    ) AS department_name,
                    (
                        SELECT GROUP_CONCAT(b.hall_guid) FROM events_halls_configuration b WHERE b.event_guid = a.event_guid
                    ) AS event_halls
                    {$queryAppend}
                FROM events a
                WHERE 
                    a.deleted = ? {$bypass_query} AND a.client_guid = ? {$condition}
                ORDER BY DATE(a.event_date) ASC
            ");
            $stmt->execute([0, $params->clientId]);

            $result = [];

            /** Halls class object */
            $hallObject = load_class("halls", "controllers");

            while($results = $stmt->fetch(PDO::FETCH_OBJ)) {

                // get each hall information
                $halls = $this->stringToArray($results->event_halls);
                
                /** Begin an empty array */
                $halls_array = [];
                $hall_seats = "";
                $seats = 0;

                /** Loop through the list of halls */
                foreach($halls as $eachHall) {
                    
                    /** Load the hall information */
                    $hallInfo = $hallObject->listEventHalls($eachHall, $results->event_guid, true);
                    
                    /** Cofirm that the hall information is not empty */
                    if(!empty($hallInfo)) {
                        $halls_array[] = $hallInfo;
                        $seats += count($hallInfo->configuration["labels"]);
                        $hall_seats .= "<a href='{$this->baseUrl}halls-configuration/{$eachHall}'>".count($hallInfo->configuration["labels"])."</a> + ";
                    }
                }

                /** Add additional information */
                $results->seats = $seats;
                $results->event_halls = $halls_array;

                $result[] = $results;
            }

            return $result;

        } catch(\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Contact / Ticket Booking Count
     * 
     * @param String $event_guid        This is the event to check
     * @param String $contact           This is the contact number to verify
     * 
     * @return Int
     */
    public function countBooking($event_guid, $contact) {

        try {
            
            /** Make the query for the list of events */
            $stmt = $this->db->prepare("
                SELECT a.id,
                    (
                        SELECT COUNT(*) 
                        FROM events_booking b 
                        WHERE 
                            b.created_by = ? AND b.event_guid = a.event_guid
                    ) AS user_booking_count
                FROM events a
                WHERE 
                    a.deleted = ? AND a.event_guid= ?
                ORDER BY DATE(a.event_date) ASC
            ");
            $stmt->execute([$contact, 0, $event_guid]);

            return ($stmt->rowCount() > 0) ? $stmt->fetch(PDO::FETCH_OBJ)->user_booking_count : 0;

        } catch(PDOException $e) {
            return 0;
        }
    }

    /**
     * This method reserves a set for a user
     * 
     * @param stdClass  $params                     This is a composite of several dataset to be used for the query
     * @param String    $params->booking_details    An array that contains the seat_id, contact number fullname and address
     * @param String    $params->event_guid         The Event Guid
     * @param String    $params->hall_guid          The Hall Guid for the hall currently been booked
     * @param String    $params->hall_guid_key      The hall guid key for easy reference
     * 
     * @return Array
     */
    public function reserveSeat(stdClass $parameters) {
        
        try {

            /** load the event details */ 
            $eventData = $this->listItems($parameters);

            /** Return if event could not be found */
            if(empty($eventData)) {
                return;
            }

            /** Get the first key */
            $eventData = $eventData[0];

            /** Validate the user credentials */
            if(!is_array($parameters->booking_details)) {
                return "Sorry! The booking details must be a valid array";
            }

            /** confirm event exits */
            if(empty($eventData)) {
                return "Sorry! An invalid event guid has been parsed.";
            }

            /** Confirm if a valid ticket has been parsed if its a paid event */
            if($eventData->is_payable && empty($this->session->eventTicketValidated)) {
                return "This is a paid event and requires a valid ticket to be used for booking";
            }

            /** Confirm if a valid ticket has been parsed if its a paid event */
            if($eventData->is_payable && !empty($this->session->eventTicketValidated) && ($this->session->eventTicketValidatedId != $parameters->event_guid)) {
                return "The ticket could not be validated";
            }

            /** confirm that the hall is actually a part of the list of halls for this event */
            if(!in_array($parameters->hall_guid, array_column($eventData->event_halls, "guid"))) {
                return "An invalid hall guid has been parsed";
            }

            $this->db->beginTransaction();

            /** Loop through the list of booking details parsed by the user */
            foreach($parameters->booking_details as $eachItem) {

                /** Explode the data string */
                $item = explode("||", $eachItem);

                /** Confirm that it has four part */
                if(!isset($item[3])) {
                    return "Sorry an invalid array data has been parsed. Accepted (seat_id||fullname||contact||address)";
                    break;
                }

                /** Ensure that the seat has not already been booked */
                if(!isset($eventData->event_halls[$parameters->hall_guid_key]->configuration["labels"][$item[0]])) {
                    return "Sorry! The selected seat has already been booked.";
                    break;
                }

                /** Validate the contact number */
                if(!preg_match("/^[+0-9]+$/", $item[2])) {
                    return "Sorry please enter a valid contact number for Seat ".$eventData->event_halls[$parameters->hall_guid_key]->configuration["labels"][$item[0]];
                    break;
                }

                /** Confirm the contact has not reached the maximum booking count */
                if($this->countBooking($parameters->event_guid, $item[2]) == $eventData->maximum_multiple_booking) {
                    return "Sorry! The contact {$item[2]} has already been used to book {$eventData->maximum_multiple_booking} times and cannot be used again.";
                    break;
                }

                /** Get the seat name */
                $seatName = $eventData->event_halls[$parameters->hall_guid_key]->configuration["labels"][$item[0]];

                /** Insert the booking record */
                $stmt = $this->db->prepare("
                    INSERT INTO events_booking SET event_guid = ?, hall_guid = ?, seat_guid = ?, seat_name = ?,
                    ".(($eventData->is_payable) ? "ticket_guid = '{$this->session->eventTicketValidatedTicket}', ticket_serial = '{$this->session->eventTicketValidatedSerial}'," : null)."
                    fullname = ?, created_by = ?, address = ?, user_agent = ?
                    ".(!empty($this->session->loggedInUser) ? ", booked_by='{$this->session->loggedInUser}'" : null)."
                ");
                $stmt->execute([$parameters->event_guid, $parameters->hall_guid, $item[0], $seatName, $item[1], $item[2], $item[3], "{$this->platform}|{$this->browser}"]);

                /** 
                 * Commence the count for the halls configuration for this event
                 * This will prevent any further update on the halls to affect this particular event structure
                */
                $this->db->query("UPDATE events_halls_configuration SET commenced = '1' WHERE event_guid='{$parameters->event_guid}' AND hall_guid='{$parameters->hall_guid}'");

                /** Alltime booking count for the hall */
                $this->db->query("UPDATE halls SET overall_booking=(overall_booking+1) WHERE hall_guid = '{$parameters->hall_guid}'");

                /** Remove the seat from the list of available seats and append to the blocked list */
                $this->removeAvailableSeat($parameters, $item[0], $parameters->hall_guid);
            }

            /** Set the event ticket as having been used */
            if($eventData->is_payable) {
                /** Update the ticket status */
                $this->db->query("UPDATE tickets_listing SET `status`='used', used_date=now() WHERE ticket_guid='{$this->session->eventTicketValidatedTicket}' AND ticket_serial='{$this->session->eventTicketValidatedSerial}'");

                /** Increment the ticket used count */
                $this->db->query("UPDATE tickets SET number_left = (number_generated-1) WHERE ticket_guid = '{$this->session->eventTicketValidatedTicket}'");
            }

            /** Commit the pending transactions */
            $this->db->commit();
            
            /** print a success message */
            return "perfect";

        } catch(\Exception $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }

    }

    /**
     * Remove a seat from the list of available seats and append to the blocked list
     * afterwards update the database table column
     */
    private function removeAvailableSeat(stdClass $parameters, $seat_key, $hall_guid) {

        try {

            /** load the event details */ 
            $eventData = $this->listItems($parameters);

            /** halls configuration list */
            $hallsConf = $eventData[0]->event_halls[$parameters->hall_guid_key]->configuration;

            /** Blocked new list */
            $hallsConf["blocked"][] = $seat_key;

            /** Remove the item from the array value in the available seats */
            unset($hallsConf["labels"][$seat_key]);

            $hallsConf = json_encode($hallsConf);

            /** Update the database accordingly */
            $stmt = $this->db->prepare("UPDATE events_halls_configuration SET `configuration` = '{$hallsConf}' WHERE `event_guid` = '{$parameters->event_guid}' AND `hall_guid`='{$hall_guid}'");
            return $stmt->execute();

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Check the seats booked for a hall for an event
     * 
     * @param stdClass $params                      This is an object of the various parameters
     * @param String $params->event_guid            This is the unique event id
     * @param String $params->hall_guid             This is the id for the hall to query
     * @param String $params->client_guid           This is the unique id for the client account
     * 
     * @return Int
     */
    public function bookedCount(stdClass $params) {

        try {

            $stmt = $this->db->prepare("
                SELECT COUNT(*) AS booked_count
                FROM events_booking a
                LEFT JOIN events b ON b.event_guid = a.event_guid 
                WHERE a.event_guid = ? AND a.hall_guid = ? AND b.client_guid = ?
            ");
            $stmt->execute([$params->event_guid, $params->hall_guid, $params->client_guid]);

            return ($stmt->rowCount() > 0) ? $stmt->fetch(PDO::FETCH_OBJ)->booked_count : 0;
            
        } catch(PDOException $e) {

        }

    }

    /**
     * Unbook a seat
     * 
     * @param String $event_guid                This is the unique id for the event
     * @param String $rowId                     This is the id for the booked seat to reverse
     * @param String $clientId                  The unique id for this client record
     * 
     * @return String
     */
    public function unbookSeat($event_guid, $rowId, $clientId) {
        /** Get the record from the database */
        $parameters = (Object) [
            "event_guid" => $event_guid,
            "clientId" => $clientId
        ];

        /** load the event details */ 
        $eventData = $this->listItems($parameters, true);

        /** Get the first key */
        if(empty($eventData)) {
            return;
        }

        /** Set the event data */
        $eventData = $eventData[0];

        /** Booking record */
        $bookingData = $this->pushQuery("*", "events_booking", "event_guid='{$event_guid}' AND id='{$rowId}'");

        /** Get the first key */
        if(empty($bookingData)) {
            return;
        }

        /** Set the event data */
        $bookingData = $bookingData[0];

        /** Get the halls list */
        $hallsList = array_column($eventData->event_halls, "guid");

        /** Get the current hall key */
        $hallKey = array_search($bookingData->hall_guid, $hallsList);

        /** Load the data at that key */
        $hallData = $eventData->event_halls[$hallKey];
        $hallConf = $hallData->configuration;

        /** Get the key from the blocked list */
        $seatKey = array_search($bookingData->seat_guid, $hallConf['blocked']);

        /** return if the seat was not found */
        if(!isset($hallConf['blocked'][$seatKey])) {
            return;
        }

        /** Unset the key */
        unset($hallConf['blocked'][$seatKey]);

        /** Append to the available seats */
        $hallConf['labels'][$bookingData->seat_guid] = $bookingData->seat_name;

        try {

            /** update the database accordingly */
            $stmt = $this->db->prepare("UPDATE events_halls_configuration SET `configuration` = ? WHERE `event_guid` = ? AND `hall_guid`=?");
            $stmt->execute([json_encode($hallConf), $event_guid, $bookingData->hall_guid]);

            /** Update the user record */
            $stmt = $this->db->prepare("UPDATE events_booking SET `deleted` = ? WHERE `id` = ?");
            $stmt->execute([1, $rowId]);

            return "great";

        } catch(PDOException $e) {
            return "denied";
        }
    }

}