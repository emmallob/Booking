<?php

class Tickets extends Booking {

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
     * @param stdClass $params              This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function listItems(stdClass $params) {
        
        try {
            
            $condition = "";
            $condition .= !empty($params->ticket_guid) ? " AND a.ticket_guid='{$params->ticket_guid}'" : null;

            // get the event tickets
            if(isset($params->event_guid)) {

                // check if the event already exist using the name, date and start time
                $eventData = $this->pushQuery("id, ticket_guid", "events", "event_guid='{$params->event_guid}' AND client_guid='{$params->clientId}'");

                // count the number of rows found
                if(!empty($eventData)) {
                    $eventData = $eventData[0];

                    // get the tickets list
                    $eventTickets = $eventData->ticket_guid;

                    // set the condition for the tickets
                    $condition .= " AND a.ticket_guid IN {$this->inList($eventTickets)}";
                }
                
            }
            
            // make the query
            $stmt = $this->db->prepare("
                SELECT a.*, a.ticket_guid AS guid,  a.ticket_title AS title, a.ticket_amount,
                    (
                        SELECT COUNT(*) FROM tickets_listing b WHERE b.ticket_guid = a.ticket_guid
                        AND b.status = 'used'
                    ) AS number_used
                FROM tickets a
                WHERE a.client_guid = ? AND a.status = ? {$condition} LIMIT {$params->limit}
            ");
            $stmt->execute([$params->clientId, 1]);

            /** Begin an empty array of the result */
            $data = [];
            $i = 0;

            /** Count the number of rows found */
            if($stmt->rowCount() > 0) {
                
                /** Loop through the results */
                while($result = $stmt->fetch(PDO::FETCH_OBJ)) {

                    $i++;
                    // unset the id from the result set
                    unset($result->id);
                    $result->row_id = $i;

                    $result->title = "{$result->title} (GHS{$result->ticket_amount})";

                    // if the request is made remotely
                    if(!$params->remote) {
                        
                        // set the action
                        $action = "<div class='text-center'>";

                        // check the status
                        if(!$result->activated) {
                            $action = "&nbsp; <a href='javascript:void(0)' data-redirect='tickets' data-item='ticket_guid' data-guid='{$result->guid}' data-url='api/tickets/activate' title='Click to Activate this Ticket' class='btn btn-outline-primary btn-sm activate-item'><i class='fa fa-check'></i></a>";
                        }

                        // do not show the delete button once at least one person has used the ticket
                        if(!$result->number_used) {
                            $action .= "&nbsp; <a href='javascript:void(0)' data-title=\"Delete Ticket\" title=\"Click to delete this Ticket.\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-msg=\"Are you sure you want to delete this ticket?\" data-item=\"ticket\" data-item-id=\"{$result->guid}\"><i class='fa fa-trash'></i></a> ";   
                        }

                        $action .= "</div>";

                        $result->action = $action;
                    }

                    // append to the list
                    $data[] = $result;

                }
            }

            return $data;


        } catch(\Exception $e) {
            return [];
        }

    }

    /**
     * This method lists getnerate a ticket
     * 
     * @param stdClass $params              This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function generateTickets(stdClass $params) {
        
        try {

            /** Format the data parsed */
            $initials = !empty($params->initials) ? strtoupper($params->initials) : null;
            $quantity = !empty($params->quantity) ? (int) $params->quantity : 100;
            $length = (int) $params->length;
            $length = ($length > 32) ? 32 : $length;

            $params->ticket_is_payable = !empty($params->ticket_is_payable) ? $params->ticket_is_payable : 0;
            $params->ticket_amount = !empty($params->ticket_amount) ? $params->ticket_amount : 0;
            
            /** check the paid state */
            if(!in_array($params->ticket_is_payable, [0, 1])) {
                return "The payable state should have a value of 0 or 1";
            }
            
            /** Ticket pricing */
            if($params->ticket_is_payable && empty($params->ticket_amount)) {
                return "Sorry, Please enter the price for the ticket";
            }

            /** Ticket amount */
            if(!empty($params->ticket_amount) && !preg_match("/^[0-9.]+$/", $params->ticket_amount)) {
                return "Sorry! Please enter a valid amount.";
            }

            /** Length of Tickets to Generate and the Length of Character Check */
            if($length < strlen($quantity)) {
                return "Sorry! The length of the Serial Number cannot be less than the Quantity to generate.";
            }

            /** Ticket guid */
            $ticket_guid = random_string("alnum", 32);

            /** If the quantity to generate is more than 10000 then let that be done by a cron job */
            $generated = ($params->quantity > 10000) ? "waiting" : "yes";

            /** Execute this section if the generated equals yes */
            if($generated == "yes") {
                /** Insert Query */
                $insertQuery = "INSERT INTO tickets_listing (`client_guid`, `ticket_guid`, `ticket_serial`, `ticket_amount`) VALUES";

                /** Tickets array */
                $tickets = [];

                /** Generate the tickets */
                for($i = 1; $i < ($quantity + 1); $i++) {
                    /** Generate the serial number */
                    $serial = $this->serialIdFormat($i);
                    $tickets[] = "{$initials}{$serial}";

                    /** Append to the insert query */ 
                    $insertQuery .= "('{$params->clientId}', '{$ticket_guid}', '{$initials}{$serial}', '{$params->ticket_amount}'),";    
                }
                /** Remove comma at the end of the string and append a semi column */
                $insertQuery = trim($insertQuery, ",").";";
            }
            
            /** Begin database transaction */
            $this->db->beginTransaction();

            /** Insert the record */
            $stmt = $this->db->prepare("INSERT INTO tickets SET 
                client_guid = ?, ticket_guid = ?, ticket_title = ?, number_generated = ?, is_payable = ?, 
                created_by = ?, `generated` = ?, ticket_amount = ?, number_left = ?
            ");
            $stmt->execute([
                $params->clientId, $ticket_guid, $params->ticket_title, $quantity, 
                $params->ticket_is_payable, $params->userId, $generated, 
                $params->ticket_amount, $quantity
            ]);
            
            /** Insert the tickets if it is true */
            if(isset($insertQuery)) {
                $this->db->query($insertQuery);
            }

            /** Log the user activity */
            $this->userLogs('tickets', $ticket_guid, "Generated {$quantity} tickets for an Event.", $params->userId, $params->clientId);
            
            /** Commit the statement */
            $this->db->commit();

            /** Slice a part of the result and push back */
            return [
                "state" => 200,
                "msg" => "Tickets were successfully generated",
                "data" => [
                    "list" => array_slice($tickets, 0, 10),
                    "guid" => $ticket_guid,
                    "item" => "ticket_guid",
                    "redirect" => "tickets",
                    "url" => "api/tickets/activate"
                ]
            ];

        } catch(\Exception $e) {
            $this->db->rollBack();
            return "Error processing request";
        }

    }   

    /**
     * This method activates a ticket
     * 
     * @param stdClass $params     This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function activateTicket(stdClass $params) {
        
        try {

            /** Prepare the statement */
            $stmt = $this->db->prepare("
                UPDATE tickets SET activated = ? WHERE client_guid = ? AND ticket_guid = ?
            ");

            /** Log the user activity */
            $this->userLogs('tickets', $params->ticket_guid, "Activated the ticket.", $params->userId, $params->clientId);

            return $stmt->execute([1, $params->clientId, $params->ticket_guid]);

        } catch(\Exception $e) {
            return false;
        }

    }

    /**
     * This method validates the ticket and sets the sessions
     * 
     * @param StdClass  $params
     * @param String    $params->ticket_guid        The ticket id
     * @param String    $params->event_guid         The event guid
     * 
     * @return Bool
     */
    public function validateTicket(stdClass $params) {

        /** confirm a valid event guid was parsed */
        $eventData = $this->pushQuery("*", "events", "event_guid='{$params->event_guid}'");

        /** Get the first key */
        if(empty($eventData)) {
            return "Invalid Event ID was parsed";
        }

        /** Limit the length to 32 */
        $params->ticket_guid = substr($params->ticket_guid, 0, 32);

        /** Set the event data */
        $eventData = $eventData[0];

        /** confirm that a valid ticket was parsed */
        $ticketData = $this->pushQuery("*", "tickets_listing", "ticket_serial='{$params->ticket_guid}' AND sold_state = '1'");

        /** Get the first key */
        if(empty($ticketData)) {
            return "An invalid Ticket Serial Number was submitted for processing";
        }

        /** Set the event data */
        $ticketData = $ticketData[0];

        /** Convert the event tickets into an array */
        $eventTickets = $this->stringToArray($eventData->ticket_guid);

        /** Confirm that the ticket applies to the current event */
        if(!in_array($ticketData->ticket_guid, $eventTickets)) {
            return "An invalid Ticket Serial Number was submitted for processing";
        }

        /** Confirm that the ticket is not already used */
        if($ticketData->status != "pending") {
            return "Sorry! This ticket has already been used.";
        }       

        /** Set the sessions */
        $this->session->eventTicketValidated = random_string("alnum", 20);
        $this->session->eventTicketValidatedSerial = $params->ticket_guid;
        $this->session->eventTicketValidatedTicket = $ticketData->ticket_guid;
        $this->session->eventTicketValidatedId = $params->event_guid;


        /** Return success */
        return "Ticket successfully validated";

    }

    /**
     * Sell out tickets to a user
     * 
     * @param String $params->ticket_guid       The id of the ticket
     * @param String $params->event_guid        The id of the event guid
     * @param String $params->fullname          The fullname of the user
     * @param String $params->email             The email address of the user
     * @param String $params->contact           The contact number of the user
     * 
     * @return Array
     */
    public function sellTicket(stdClass $params) {

        // confirm valid contact number
		if(!preg_match("/^[0-9+]+$/", $params->contact) || (strlen($params->contact) < 10)) {
			return "Sorry! An invalid contact number was entered";
		}

		// confirm valid email address
		if(isset($params->email) && !filter_var($params->email, FILTER_VALIDATE_EMAIL)) {
			return "Sorry! An invalid email address was entered";
		}

        // check if the event already exist using the name, date and start time
        $eventData = $this->pushQuery("id, event_title, event_date", "events", "event_guid='{$params->event_guid}' AND client_guid='{$params->clientId}' AND deleted='0'");

        // count the number of rows found
        if(empty($eventData)) {
            return "Sorry! An invalid event guid has been supplied.";
        }

        // check if the ticket already exist using the name, date and start time
        $ticketData = $this->pushQuery("id", "tickets", "ticket_guid='{$params->ticket_guid}' AND client_guid='{$params->clientId}' AND status='1'");

        // count the number of rows found
        if(empty($ticketData)) {
            return "Sorry! An invalid ticket guid has been supplied.";
        }

        // make a request for at least on ticket
        $ticketsList = $this->pushQuery("ticket_serial, id, ticket_amount", "tickets_listing", "ticket_guid='{$params->ticket_guid}' AND client_guid='{$params->clientId}' AND sold_state='0' AND status='pending' ORDER BY RAND() LIMIT 1");
        
        // count the number of rows found
        if(empty($ticketsList)) {
            return "Sorry! There are no available tickets under this category.";
        }

        // begin a transaction
        $this->db->beginTransaction();

        try {

            // update the ticket details
            $stmt = $this->db->prepare("UPDATE tickets_listing SET bought_by = ?, sold_by = ?, sold_state = ? WHERE client_guid = ? AND ticket_serial = ?");
            $stmt->execute(["{$params->fullname} - {$params->contact}", $params->userId, 1, $params->clientId, $ticketsList[0]->ticket_serial]);

            // update the main ticket sold and left counts
            $stmt = $this->db->prepare("UPDATE tickets SET number_sold = (number_sold + 1), number_left = (number_left - 1) WHERE ticket_guid = ?");
            $stmt->execute([$params->ticket_guid]);

            // insert the purchase information
            $stmt = $this->db->prepare("INSERT INTO ticket_purchases SET ticket_id = ?, event_id = ?, fullname = ?, contact = ?, email = ?");
            $stmt->execute([$ticketsList[0]->id, $eventData[0]->id, $params->fullname, $params->contact, $params->email ?? null]);

            // set the recipient details
            $recipient = [
                "recipients_list" => [
                    ["fullname" => $params->fullname,"email" => ($params->email) ?? null,"contact" => $params->contact]
                ]
            ];

            // form the message to be sent to the user
            $message = "Hi {$params->fullname}, <br>Your Serial Number for the Event: {$eventData[0]->event_title} 
            scheduled on {$eventData[0]->event_date} is {$ticketsList[0]->ticket_serial}. Thank you.";
            
            // insert the email content to be processed by the cron job
            $stmt = $this->db->prepare("INSERT INTO email_list SET client_guid = ?, template_type = ?, item_guid = ?, recipients_list = ?, request_performed_by = ?, subject = ?, message = ?");
            $stmt->execute([$params->clientId, 'ticket', $ticketsList[0]->ticket_serial, json_encode($recipient), $params->userId, "Event: {$eventData[0]->event_title} Ticket", $message]);

            // insert the user activity
            $this->userLogs("ticket", $ticketsList[0]->ticket_serial, "Event: {$eventData[0]->event_title} Ticket was sold out to {$params->fullname}", $params->userId, $params->clientId);
            
            // commit the statement
            $this->db->commit();

            // return the success response
            return [
                "event_data" => [
                    "Event Name" => $eventData[0]->event_title,
                    "Event Date" => $eventData[0]->event_date,
                    "Serial Number" => $ticketsList[0]->ticket_serial,
                    "Ticket Amount" => $ticketsList[0]->ticket_amount
                ],
                "result" => "Congrats! The request was successfully processed."
            ];

        } catch(PDOException $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Sales list
     */
    public function listSales(stdClass $params) {
        try {
            
            $condition = !empty($params->serial) ? " AND b.ticket_serial='{$params->serial}'" : null;

			$stmt = $this->db->prepare("SELECT 
                (SELECT event_title b FROM events b WHERE b.id = a.event_id) AS event_title,
                b.ticket_amount, b.ticket_serial, b.status,
                a.fullname, a.contact, a.email, a.date_created
                FROM ticket_purchases a
                LEFT JOIN tickets_listing b ON b.id = a.ticket_id
                WHERE b.client_guid = ? {$condition}
                ORDER BY a.id DESC LIMIT {$params->limit}
            ");
            $stmt->execute([$params->clientId]);

			$i = 0;
			$results = [];
            while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
				
				$i++;
                $result->status = ucfirst($result->status);
				$result->row_id = $i;
				$results[] = $result;
			}

            return $results;

        } catch(PDOException $e) {
            return false;
        }
    }

}