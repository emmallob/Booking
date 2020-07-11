<?php

class Insight extends Booking {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * An important section of the application (reporting)
     * 
     * @param stdClass $params
     */
    public function generateInsight(stdClass $params) {
        
        try {
            
            $event_guid = !empty($params->event_guid) ? $this->inList($params->event_guid) : null;
            $condition = !empty($event_guid) ? "AND a.event_guid IN ". $event_guid : null;

            $stmt = $this->db->prepare("
                SELECT 
                    a.event_guid, a.event_date, a.start_time, a.end_time, a.booking_start_time, a.booking_end_time,
                    a.is_payable, a.allow_multiple_booking, a.maximum_multiple_booking, a.attachment, a.description,
                    (SELECT b.ticket_title FROM tickets b WHERE b.ticket_guid = a.ticket_guid) AS ticket_applicable,
                    a.state, a.created_on, 
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

            $data = [];
            while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                
                // booked list
                $result->bookedList = $this->bookedList($result->event_guid);
                $result->summary = $this->summaryDetails($result->event_guid);
                
                $data[] = $result;
            }

            return $data;

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get the booked list using the event guid
     * 
     * @param String $event_guid
     * 
     * @return Object
     */
    public function bookedList($event_guid) {

        try {

            $stmt = $this->db->prepare("
                SELECT 
                    seat_guid, ticket_guid, ticket_serial, booked_by, fullname, 
                    a.created_by AS contact, address, a.created_on, user_agent, b.hall_name,
                    CASE WHEN a.status IS NULL THEN 'booked' ELSE 'confirmed' END AS booked_state
                FROM events_booking a
                LEFT JOIN halls b ON b.hall_guid = a.hall_guid
                WHERE event_guid = '{$event_guid}' AND a.deleted = ?
            ");
            $stmt->execute([0]);

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    /** 
     * Generate other details for the event
     * 
     * @param String $event_guid
     * 
     * @return Object
     */
    public function summaryDetails($event_guid) {

        try {

            $stmt = $this->db->prepare("
                SELECT 
                    (
                        SELECT COUNT(*) FROM events_booking b WHERE b.event_guid = '{$event_guid}' AND b.deleted = '0'
                    ) AS booked_count,
                    (
                        SELECT COUNT(*) FROM events_booking b WHERE b.event_guid = '{$event_guid}' AND b.deleted = '0' AND b.status='1'
                    ) AS confirmed_count,
                    (
                        SELECT COUNT(*) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND sold_state = '1'
                    ) AS tickets_sold,
                    (
                        SELECT COUNT(*) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND sold_state = '1'
                    ) AS tickets_sold,
                    (
                        SELECT COUNT(*) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND status = 'booked'
                    ) AS tickets_used,
                    (
                        SELECT SUM(ticket_amount) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND sold_state = '1'
                    ) AS tickets_expected_funds,
                    (
                        SELECT SUM(ticket_amount) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND status = 'booked' AND sold_state = '1'
                    ) AS tickets_funds_realised
                FROM tickets_listing WHERE event_booked = '{$event_guid}'
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            return [
                "booking" => [
                    "total_booked" => [
                        "description" => "This is the total number of persons who have booked",
                        "value" => $result->booked_count
                    ],
                    "total_confirmed" => [
                        "description" => "This is the total number of persons who have booked and an admin have confirmed",
                        "value" => $result->confirmed_count
                    ]
                ],
                "funds" => [
                    "tickets_sold" => [
                        "description" => "The total number of tickets that have been sold for this event.",
                        "value" => $result->tickets_sold ?? 0,
                    ],
                    "tickets_used" => [
                        "description" => "The number of sold tickets that have been used.",
                        "value" => $result->tickets_used ?? 0,
                    ],
                    "tickets_expected_funds" => [
                        "description" => "The expected funds for all sold tickets (should none be returned for refund)",
                        "value" => $result->tickets_expected_funds ?? 0,
                    ],
                    "tickets_funds_realised" => [
                        "description" => "The actual amount realized from sale (These tickets have been used and booking confirmed)",
                        "value" => $result->tickets_funds_realised ?? 0,
                    ]
                ]
            ];

        } catch(PDOException $e) {

        }
    }

    /**
     * Booking counts
     * 
     * @param String $event_guid
     */
    public function bookingInsight($params) {

        $event_guid = !empty($params->event_guid) ? $this->inList($params->event_guid) : null;
        $condition = !empty($event_guid) ? "AND a.event_guid IN ". $event_guid : null;

        // format the date properly
        $dates = $this->dateRangeFormater($params->period);

        // assign the variables
        $dateFrom = $dates->start_date;
        $dateTo = $dates->end_date;
        $groupBy = $dates->group_by;

        // run the query
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) AS totalBooked
                DATE(a.created_on) AS dates,
                HOUR(a.created_on) AS hourOfDay,
                MONTH(a.created_on) AS monthOfSale
            FROM events_booking a 
            
            WHERE 
                (DATE(a.created_on) >= '{$dateFrom}' AND DATE(a.created_on) <= '{$dateTo}') 
                AND a.event
                GROUP BY {$groupBy}(a.created_on)
        ");

    }


    /**
     * This formats the correct date range
     *  
     * @param String    $datePeriod      This is the date period that was parsed
     * 
     * @return This     $this->start_date, $this->end_date;
     */
    private function dateRangeFormater($datePeriod) {

        // Check Sales Period
        switch ($datePeriod) {
            case 'this_week':
                $groupBy = "DATE";
                $format = "jS M Y";
                $dateFrom = date("Y-m-d", strtotime("today -6 days"));
                $dateTo = date("Y-m-d");
                break;
            case 'this_month':
                $groupBy = "DATE";
                $format = "jS M Y";
                $dateFrom = date("Y-m-01", strtotime("today"));
                $dateTo = date("Y-m-t", strtotime("today"));
                break;
            case 'last_30_days':
                $groupBy = "DATE";
                $format = "jS M Y";
                $dateFrom = date("Y-m-d", strtotime("-30 days"));
                $dateTo = date("Y-m-d");
                break;
            case 'last_3months':
                $groupBy = "MONTH";
                $format = "jS M Y";
                $dateFrom = date("Y-m-d", strtotime("today -3 months"));
                $dateTo = date("Y-m-d");
                break;
            case 'last_6months':
                $groupBy = "MONTH";
                $format = "jS M Y";
                $dateFrom = date("Y-m-d", strtotime("today -6 months"));
                $dateTo = date("Y-m-d");
                break;
            case 'last_month':
                $groupBy = "DATE";
                $format = "jS M Y";
                $dateFrom = date("Y-m-01", strtotime("-1 month"));
                $dateTo = date("Y-m-t", strtotime("-1 month"));
                break;
            case 'this_year':
                $groupBy = "MONTH";
                $format = "F";
                $dateFrom = date('Y-01-01');
                $dateTo = date('Y-m-d');
                break;
            default:
                break;
        }

        $this->start_date = $dateFrom;
        $this->end_date = $dateTo;
        $this->group_by = $groupBy;
        $this->date_format = $format;

        return $this;

    }
}