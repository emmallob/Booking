<?php

class Events extends Booking {

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

            $stmt = $this->db->prepare("
                SELECT a.*,
                FROM events a
                WHERE a.client_guid = ? AND a.deleted = ?
            ");
            $stmt->execute([$params->clientId, 0]);

            /** Begin an empty array of the result */
            $data = [];

            /** Count the number of rows found */
            if($stmt->rowCount() > 0) {
                
                /** Loop through the results */
                while($result = $stmt->fetch(PDO::FETCH_OBJ)) {

                    // unset the id from the result set
                    unset($result->id);

                    $data[] = $result;

                }
            }

            return $data;


        } catch(\Exception $e) {
            return [];
        }

    }

    /**
     * Add a new event
     * 
     * When the department guid is set and not empty, there is a check to validate it 
     * When the ticket guid is set and not empty, there is a check to validate that also
     * 
     * The booking start time and endtime is also validated for consistency.
     * 
     * The same applies to the values for event is payable and multiple booking
     * 
     * @param stdClass      $params                 A composite of variables
     * @param String $params->event_title           This is the event title
     * @param String $params->department_guid       The department that is organizing this event
     * @param String $params->event_date            The date on which the event will come off
     * @param String $params->start_time            The time for the event
     * @param String $params->end_time              The expected end time for the event
     * @param String $params->booking_starttime     The date and time on which the booking will start
     * @param String $params->booking_endtime       The date and time on which the booking will end
     * @param String $params->event_is_payable      Is the event payable?
     * @param String $params->ticket_guid           If payable then what is the ticket that will be sold for this event
     * @param String $params->multiple_booking      Can a user perform a multiple booking with the same contact number
     * @param String $params->maximum_booking       Whats the maximum number of booking that the user can perform
     * @param String $params->description           Any additional information to be posted for this event.
     * 
     * @return Array
     */
    public function addItem(stdClass $params) {

        // ensure that new lines are replaced with breaks
        $params->description = !empty($params->description) ? nl2br($params->description) : null;

        $params->multiple_booking = !empty($params->multiple_booking) ? $params->multiple_booking : 0;
        $params->event_is_payable = !empty($params->event_is_payable) ? $params->event_is_payable : 0;

        // departments checker 
        if(!empty($params->department_guid) && empty($this->pushQuery("id", "departments", "department_guid='{$params->department_guid}' AND client_guid='{$params->clientId}' AND status='1'"))) {
            return "Sorry! An invalid department guid was submitted.";
        }

        // tickets checker
        if(!empty($params->ticket_guid) && empty($this->pushQuery("id", "tickets", "ticket_guid='{$params->ticket_guid}' AND client_guid='{$params->clientId}' AND status='1'"))) {
            // return "Sorry! An invalid tickets guid was submitted.";
        }

        // check if the event already exist using the name, date and start time
        if(!empty($this->pushQuery("id", "events", "event_title='{$params->event_title}' AND event_date='{$params->event_date}' AND start_time='{$params->start_time}' AND client_guid='{$params->clientId}' AND status='pending'"))) {
            return "Sorry! A duplicate event has been submitted.";
        }

        // check the start date
        if(strtotime($params->event_date) < strtotime(date("Y-m-d"))) {
            return "Sorry! The event date should either be today or a day after.";
        }

        // check the event date and the booking start and end dates
        $book_start = date("Y-m-d", strtotime($params->booking_starttime));
        $book_end = date("Y-m-d", strtotime($params->booking_endtime));

        // if the booking start is lesser than the event date
        if(strtotime($book_start) > strtotime($params->event_date)) {
            return "Sorry! The booking start date should not be before the Event Date";
        }

        // if the booking end time is before the start time then an error should pop up
        if(strtotime($book_start) > strtotime($book_end)) {
            return "Sorry! The booking end date should be after the start date";
        }

        // if the booking end time is after the event date
        if(strtotime($book_end) > strtotime($params->event_date)) {
            return "Sorry! The booking end date should be before or on the Event date";
        }

        /** check the multiple_booking value */
        if(!empty($params->multiple_booking) && !in_array($params->multiple_booking, [0, 1])) {
            return "The multiple_booking should have a value of 0 or 1";
        }

        /** check the event_is_payable value */
        if(!empty($params->event_is_payable) && !in_array($params->event_is_payable, [0, 1])) {
            return "The event_is_payable should have a value of 0 or 1";
        }

        /** Confirm that the maximum booking value is a numeric integer */
        if(!preg_match("/^[0-9]+$/", $params->maximum_booking)) {
            return "Sorry! The maximum booking value must be an integer";
        }

        // check the event date and the booking start and end dates
        $book_start = date("Y-m-d H:i", strtotime($params->booking_starttime));
        $book_end = date("Y-m-d H:i", strtotime($params->booking_endtime));

        // halls configuration
        if(!empty($params->halls_guid)) {
            // get the first item in the array
            if(is_array($params->halls_guid)) {
                // get the array item
                $halls_guid = $params->halls_guid[0];
                $halls_list = [];

                // loop through each item and check if the hall really exists
                foreach($halls_guid as $eachHall) {
                    
                    // query the database for the information on this hall
                    $query = $this->pushQuery("configuration, hall_name", "halls", "hall_guid='{$eachHall}' AND client_guid='{$params->clientId}' AND deleted='0'");

                    // confirm that the query did not return an error
                    if(empty($query)) {
                        $hall_bug = true;
                        break;
                    } else {
                        // append to the halls list
                        $halls_list[$eachHall] = [
                            "name" => $query[0]->hall_name,
                            "conf" => $query[0]->configuration
                        ];
                    }
                }
                // return error
                if(isset($hall_bug)) {
                    return "Sorry! An invalid hall guid was parsed.";
                }
            }
        }

        try {

            /** 32 random string for the guid */
            $guid = random_string("alnum", 32);

            $this->db->beginTransaction();

            /** Execute the statement */
            $stmt = $this->db->prepare("
                INSERT INTO events 
                SET client_guid = ?, event_guid = ?, event_title = ?, 
                ".(isset($halls_guid) ? "halls_guid='".implode(",", $halls_guid)."'," : null)."
                event_date = ?, start_time = ?, end_time = ?, booking_start_time = ?, booking_end_time = ?,
                ".(!empty($params->event_is_payable) ? "is_payable='{$params->event_is_payable}'," : null)."
                ".(!empty($params->department_guid) ? "department_guid='{$params->department_guid}'," : null)."
                ".(!empty($params->multiple_booking) ? "allow_multiple_booking='{$params->multiple_booking}'," : null)."
                ".(!empty($params->maximum_booking) ? "maximum_multiple_booking='{$params->maximum_booking}'," : null)."
                ".(isset($attachment) ? "attachment='{$attachment}'," : null)."
                ".(!empty($params->description) ? "description='{$params->description}'," : null)."
                ".(!empty($params->ticket_guid) ? "ticket_guid='{$params->ticket_guid}'," : null)."
                created_by = ?
            ");
            
            /** Execute */
            if($stmt->execute([
                $params->clientId, $guid, $params->event_title, $params->event_date, 
                $params->start_time, $params->end_time, $book_start, $book_end, $params->userId
            ])) {
                
                /** Insert the halls list */
                if(isset($halls_list)) {
                    /** Loop through the list */
                    foreach($halls_list as $key => $value) {
                        $this->db->query("
                            INSERT INTO events_halls_configuration 
                            SET event_guid = '{$guid}',hall_guid = '{$key}', `configuration` = '{$value["conf"]}',
                            `hall_name` = '{$value["name"]}'
                        ");
                    }
                }

                /** Log the user activity */
                $this->userLogs('events', $guid, 'Created a new Event.');

                /** Commit the transaction */
                $this->db->commit();

                /** Format the response to parse */
                return [
                    "state" => 200,
                    "msg" => "Event details was successfully inserted"
                ];
            }

        } catch(PDOException $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }

    }

}