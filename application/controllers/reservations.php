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
                        SELECT b.department_name FROM departments b WHERE b.department_guid = a.department_guid
                    ) AS department_name,
                    (
                        SELECT GROUP_CONCAT(b.hall_guid) FROM events_halls_configuration b WHERE b.event_guid = a.event_guid
                    ) AS event_halls
                    {$queryAppend}
                FROM events a
                WHERE 
                    (TIMESTAMP(a.booking_end_time) > CURRENT_TIME()) AND a.deleted = ? AND a.state = ? AND a.client_guid = ?
                ORDER BY DATE(a.event_date) ASC
            ");
            $stmt->execute([0, "pending", $params->clientId]);

            $result = [];

            while($results = $stmt->fetch(PDO::FETCH_OBJ)) {
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

}