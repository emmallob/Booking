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

            $condition = !empty($params->ticket_guid) ? "AND a.ticket_guid='{$params->ticket_guid}'" : null;

            $stmt = $this->db->prepare("
                SELECT a.*, a.ticket_guid AS guid,  a.ticket_title AS title,
                    (
                        SELECT COUNT(*) FROM tickets_listing b WHERE b.ticket_guid = a.ticket_guid
                        AND b.status = 'used'
                    ) AS number_used
                FROM tickets a
                WHERE a.client_guid = ? AND a.status = ? {$condition}
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

                    $action = "";

                    // check the status
                    if(!$result->activated) {
                        $action = "&nbsp; <a href='javascript:void(0)' data-redirect='tickets' data-item='ticket_guid' data-guid='{$result->guid}' data-url='api/tickets/activate' title='Click to Activate this Ticket' class='btn btn-outline-primary btn-sm activate-item'><i class='fa fa-check'></i></a>";
                    }

                    // do not show the delete button once at least one person has used the ticket
                    if(!$result->number_used) {
                        $action .= "&nbsp; <a href='javascript:void(0)' data-title=\"Delete Ticket\" title=\"Click to delete this Ticket.\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-msg=\"Are you sure you want to delete this ticket?\" data-item=\"ticket\" data-item-id=\"{$result->guid}\"><i class='fa fa-trash'></i></a> ";   
                    }

                    $result->action = $action;
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
            $this->userLogs('tickets', $ticket_guid, "Generated {$quantity} tickets for an Event.");
            
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
}