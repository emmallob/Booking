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
     * @return Array
     */
    public function listItems(stdClass $params) {
        
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
                    ) AS user_booking_count
                "; 
            }

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
                    (TIMESTAMP(a.booking_end_time) > CURRENT_TIME()) AND a.deleted = ? 
                    AND a.state = ? AND a.client_guid = ? {$condition}
                ORDER BY DATE(a.event_date) ASC
            ");
            $stmt->execute([0, "pending", $params->clientId]);

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
                    // set the hall_guid parameter
                    $params->hall_guid = $eachHall;

                    /** Load the hall information */
                    $hallInfo = $hallObject->listItems($params, true);
                    
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
     * This method reserves a set for a user
     * 
     * @param stdClass $params              This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function reserveSeat(stdClass $params) {
        
        try {

            

        } catch(\Exception $e) {
            return [];
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

}