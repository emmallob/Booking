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
        
        global $accessObject;

        try {

            $condition = !empty($params->event_guid) ? "AND a.event_guid='{$params->event_guid}'" : null;

            $stmt = $this->db->prepare("
                SELECT a.*,
                    (
                        SELECT COUNT(*) FROM events_booking b WHERE b.event_guid = a.event_guid AND b.deleted = '0'
                    ) AS booked_count,
                    (
                        SELECT b.department_name FROM departments b WHERE b.department_guid = a.department_guid
                    ) AS department_name,
                    (
                        SELECT GROUP_CONCAT(b.hall_guid) FROM events_halls_configuration b WHERE b.event_guid = a.event_guid
                    ) AS event_halls
                FROM events a
                WHERE a.client_guid = ? AND a.deleted = ? {$condition}
                ORDER BY DATE(a.event_date)    DESC
            ");
            $stmt->execute([$params->clientId, 0]);

            /** Begin an empty array of the result */
            $data = [];
            $i = 0;

            /** Halls class object */
            $hallObject = load_class("halls", "controllers");

            /** Count the number of rows found */
            if($stmt->rowCount() > 0) {
                
                /** Loop through the results */
                while($result = $stmt->fetch(PDO::FETCH_OBJ)) {

                    $i++;

                    // unset the id from the result set
                    unset($result->id);

                    // get each hall information
                    $halls = $this->stringToArray($result->event_halls);

                    /** Begin an empty array */
                    $halls_array = [];
                    $hall_seats = "";
                    $seats = 0;

                    /** Loop through the list of halls */
                    foreach($halls as $eachHall) {

                        /** Load the hall information */
                        $hallInfo = $hallObject->listEventHalls($eachHall, $result->event_guid, true);
                        
                        /** Cofirm that the hall information is not empty */
                        if(!empty($hallInfo)) {
                            $halls_array[] = $hallInfo;
                            $seats += count($hallInfo->configuration["labels"]);
                            $hall_seats .= "<a href='{$this->baseUrl}halls-configuration/{$eachHall}'>".count($hallInfo->configuration["labels"])."</a> + ";
                        }
                    }
                    
                    /** Add additional information */
                    $result->row_id = $i;
                    $result->seats = trim($hall_seats," + ") ." = ".$seats;
                    $result->event_halls = $halls_array;

                    // event state configuration
                    if($result->state == "pending") {
                        $result->status = "<span class='badge badge-primary'>Pending</span>";
                    } elseif($result->state == "in-progress") {
                        $result->status = "<span class='badge badge-sucess'>In Progress</span>";
                    } elseif($result->state == "cancelled") {
                        $result->status = "<span class='badge badge-danger'>Cancelled</span>";
                    } else {
                        $result->status = "<span class='badge badge-warning'>Past</span>";
                    }
                    $action = "";

                    if($accessObject->hasAccess('update', 'events')) {
                        if(in_array($result->state, ["pending"])) {
                            $action .= "<a href='{$this->baseUrl}events-edit/{$result->event_guid}' title='Edit the details of this event' class='btn btn-outline-success btn-sm'><i class='fa fa-edit'></i></a>";
                        } else {
                            $action .= "<a href='{$this->baseUrl}events-edit/{$result->event_guid}' title='View this event' class='btn btn-outline-success btn-sm'><i class='fa fa-eye'></i></a>";
                        }
                    }

                    /** Access Permissions Check */
                    if($accessObject->hasAccess('delete', 'events')) {
                        /** Cancel Event */
                        if(in_array($result->state, ["pending"])) {
                            $action .= "&nbsp;<a href='javascript:void(0)' title=\"Click to cancel.\" class=\"btn btn-sm btn-outline-warning delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-msg=\"Are you sure you want to cancel this event?\" data-item=\"cancel-event\" data-item-id=\"{$result->event_guid}\"><i class='fa fa-times'></i></a>";
                        }
                        /** If no one has booked and it is still pending */
                        if($result->booked_count == 0 && $result->state == "pending") {
                            $action .= "&nbsp;<a href='javascript:void(0)' title=\"Click to delete this event.\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-msg=\"Are you sure you want to delete this event?\" data-item=\"event\" data-item-id=\"{$result->event_guid}\"><i class='fa fa-trash'></i></a>";
                        }
                    }

                    $action .= "&nbsp;<a href='{$this->baseUrl}events-insight/{$result->event_guid}' title='View insights for this event' class='btn btn-outline-primary btn-sm'><i class='fa fa-chart-bar'></i></a>";

                    $result->event_details = "
                        <strong>Booking Starts:</strong> {$result->booking_start_time}<br>
                        <strong>Booking Ends:</strong> {$result->booking_end_time}<br>
                        ".(!empty($result->department_name) ? "<strong>Department:</strong> {$result->department_name} <br>" : null)."
                    ";
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
        if(!empty($params->ticket_guid) && ($params->ticket_guid != "null") && empty($this->pushQuery("id", "tickets", "ticket_guid='{$params->ticket_guid}' AND client_guid='{$params->clientId}' AND status='1'"))) {
            return "Sorry! An invalid tickets guid was submitted.";
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
                    $query = $this->pushQuery("`configuration`, `hall_name`, `rows`, `columns`", "halls", "hall_guid='{$eachHall}' AND client_guid='{$params->clientId}' AND deleted='0'");

                    // confirm that the query did not return an error
                    if(empty($query)) {
                        $hall_bug = true;
                        break;
                    } else {
                        // append to the halls list
                        $halls_list[$eachHall] = [
                            "name" => $query[0]->hall_name,
                            "conf" => $query[0]->configuration,
                            "rows" => $query[0]->rows,
                            "columns" => $query[0]->columns
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
                created_by = ?, event_slug = ?
            ");
            
            /** Execute */
            if($stmt->execute([
                $params->clientId, $guid, $params->event_title, $params->event_date, 
                $params->start_time, $params->end_time, $book_start, $book_end, 
                $params->userId, create_slug($params->event_title)
            ])) {
                
                /** Insert the halls list */
                if(isset($halls_list)) {
                    /** Loop through the list */
                    foreach($halls_list as $key => $value) {
                        $this->db->query("
                            INSERT INTO events_halls_configuration 
                            SET event_guid = '{$guid}',hall_guid = '{$key}', `configuration` = '{$value["conf"]}',
                            `hall_name` = '{$value["name"]}', `rows` = '{$value["rows"]}', `columns` = '{$value["columns"]}'
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

    /**
     * Update an existing event details
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
     * @param String $params->event_guid            The unique guid of this event
     * 
     * @return Array
     */
    public function updateItem(stdClass $params) {

        // ensure that new lines are replaced with breaks
        $params->description = !empty($params->description) ? nl2br($params->description) : null;

        $params->multiple_booking = !empty($params->multiple_booking) ? $params->multiple_booking : 0;
        $params->event_is_payable = !empty($params->event_is_payable) ? $params->event_is_payable : 0;

        // departments checker 
        if(!empty($params->department_guid) && empty($this->pushQuery("id", "departments", "department_guid='{$params->department_guid}' AND client_guid='{$params->clientId}' AND status='1'"))) {
            return "Sorry! An invalid department guid was submitted.";
        }

        // tickets checker
        if(!empty($params->ticket_guid) && ($params->ticket_guid != "null") && empty($this->pushQuery("id", "tickets", "ticket_guid='{$params->ticket_guid}' AND client_guid='{$params->clientId}' AND status='1'"))) {
            return "Sorry! An invalid tickets guid was submitted.";
        }

        // check if the event already exist using the name, date and start time
        if(empty($this->pushQuery("id", "events", "event_guid='{$params->event_guid}' AND client_guid='{$params->clientId}'"))) {
            return "Sorry! An invalid event guid has been supplied.";
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

            $this->db->beginTransaction();

            /** Execute the statement */
            $stmt = $this->db->prepare("
                UPDATE events 
                SET event_title = ?, event_slug = ?
                ".(isset($halls_guid) ? ", halls_guid='".implode(",", $halls_guid)."'" : null)."
                ,event_date = ?, start_time = ?, end_time = ?, booking_start_time = ?, booking_end_time = ?
                ".(!empty($params->event_is_payable) ? ",is_payable='{$params->event_is_payable}'" : null)."
                ".(!empty($params->department_guid) ? ",department_guid='{$params->department_guid}'" : null)."
                ".(!empty($params->multiple_booking) ? ",allow_multiple_booking='{$params->multiple_booking}'" : null)."
                ".(!empty($params->maximum_booking) ? ",maximum_multiple_booking='{$params->maximum_booking}'" : null)."
                ".(isset($attachment) ? ",attachment='{$attachment}'" : null)."
                ".(!empty($params->description) ? ",description='{$params->description}'" : null)."
                ".(!empty($params->ticket_guid) ? ",ticket_guid='{$params->ticket_guid}'" : null)."
                WHERE client_guid = ? AND event_guid = ?
            ");
            
            /** Execute */
            if($stmt->execute([
                $params->event_title, create_slug($params->event_title), $params->event_date, 
                $params->start_time, $params->end_time, $book_start, $book_end, 
                $params->clientId, $params->event_guid
            ])) {
                
                /** Insert the halls list */
                if(isset($halls_list)) {
                    /** Delete all records */
                    $this->db->query("DELETE FROM events_halls_configuration WHERE event_guid = '{$params->event_guid}'");
                    /** Loop through the list */
                    foreach($halls_list as $key => $value) {
                        $this->db->query("
                            INSERT INTO events_halls_configuration 
                            SET event_guid = '{$params->event_guid}',hall_guid = '{$key}', `configuration` = '{$value["conf"]}',
                            `hall_name` = '{$value["name"]}'
                        ");
                    }
                }

                /** Log the user activity */
                $this->userLogs('events', $params->event_guid, 'Updated the event details.');

                /** Commit the transaction */
                $this->db->commit();

                /** Format the response to parse */
                return [
                    "state" => 200,
                    "msg" => "Event details was successfully updated"
                ];
            }

        } catch(PDOException $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }

    }

}