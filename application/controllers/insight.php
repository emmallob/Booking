<?php

class Insight extends Booking {


    // preset some variables
    public $start_date;
    public $end_date;
    public $group_by;
    public $date_format;

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

            $params->tree = (isset($params->tree)) ? $this->stringToArray($params->tree) : ["list", "booking_summary", "detail", "booking_count", "overall_summary"];

            $data = [];
            $i = 0;

            // if the user did not specify vouchers as part of the request
            if(!in_array("vouchers", $params->tree)) {

                // run the query
                $stmt = $this->db->prepare("
                    SELECT 
                        a.event_guid, a.event_title, a.event_date, a.start_time, a.end_time, a.booking_start_time, a.booking_end_time,
                        a.is_payable, a.allow_multiple_booking, a.maximum_multiple_booking, a.description,
                        (SELECT b.ticket_title FROM tickets b WHERE b.ticket_guid = a.ticket_guid) AS ticket_applicable,
                        a.state, a.created_on, 
                        (
                            SELECT COUNT(*) FROM events_booking b WHERE b.event_guid = a.event_guid AND b.deleted = '0'
                        ) AS booked_count,
                        (
                            SELECT COUNT(*) FROM events_booking b WHERE b.event_guid = a.event_guid AND b.deleted = '0' AND b.status='1'
                        ) AS confirmed_count,
                        (
                            SELECT b.department_name FROM departments b WHERE b.department_guid = a.department_guid
                        ) AS department_name,
                        (
                            SELECT GROUP_CONCAT(b.hall_guid) FROM events_halls_configuration b WHERE b.event_guid = a.event_guid
                        ) AS event_halls
                    FROM events a
                    WHERE a.client_guid = ? AND a.deleted = ? {$condition}
                    ORDER BY DATE(a.event_date) ".(isset($params->order) ? $params->order : "DESC")."
                ");
                $stmt->execute([$params->clientId, 0]);

                // loop through the request
                while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                    
                    // booked list
                    if(in_array("list", $params->tree)) {
                        $data[$i]['booking_list'] = $this->bookedList($result->event_guid, $params->remote);
                    }

                    if(in_array("booking_summary", $params->tree)) {
                        $data[$i]['booking_summary'] = $this->summaryDetails($result->event_guid, $params->clientId);
                    }
                    
                    if(in_array("booking_count", $params->tree)) {
                        $data[$i]['booking_count'] = [
                            "event_title" => $result->event_title . " (". date("jS F", strtotime($result->event_date)) . ")",
                            "booked_count" => $result->booked_count,
                            "confirmed_count" => $result->confirmed_count
                        ];
                    }
                        
                    if(in_array("detail", $params->tree)) {
                        $data[$i]['detail'] = $result;
                    }

                    $i++;
                    
                }

            }

            // vouchers query
            if(in_array("vouchers", $params->tree)) {
                // load the voucher report
                $results['voucher_report'] = $this->voucherReport($params);
            } else {

                /** Set the result */
                $results['data'] = $data;
            }

            /** If the overall_summary is parsed */
            if(in_array("overall_summary", $params->tree)) {
                $results['overall_summary'] = $this->allInsight($params->clientId);
            }

            /** Return the data */
            return $results;

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
    public function bookedList($event_guid, $remote) {

        try {

            $stmt = $this->db->prepare("
                SELECT 
                    a.id, a.seat_guid, a.seat_name, ticket_guid, ticket_serial, booked_by, fullname, 
                    a.created_by AS contact, address, a.created_on, user_agent, b.hall_name,
                    CASE WHEN a.status IS NULL THEN 'booked' ELSE 'confirmed' END AS booked_state, a.status
                FROM events_booking a
                LEFT JOIN halls b ON b.hall_guid = a.hall_guid
                WHERE event_guid = '{$event_guid}' AND a.deleted = ? ORDER BY seat_guid
            ");
            $stmt->execute([0]);

            $i = 0;
            $data = [];
            while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                $i++;
                $result->row_id = $i;

                // show this link if not a remote (api) request
                if(!$remote) {
                    if(!$result->status) {
                        $result->action = "
                            <a href='javascript:void(0)' class='delete-item btn btn-sm btn-outline-success' title='Click to confirm attendance' data-title='Confirm Booking' data-item=\"confirm-booking\" data-item-id='{$event_guid}_{$result->id}'><i class=\"fa fa-check\"></i></a>
                            <a href='javascript:void(0)' class='delete-item btn btn-sm btn-outline-danger' title='Click to unbook seat' data-title='Unbook Seat' data-item=\"remove-booking\" data-item-id='{$event_guid}_{$result->id}'><i class=\"fa fa-trash\"></i></a>
                        ";
                    } else {
                        $result->action = "<span class='text-success'>{$result->booked_state}</span>";
                    }
                }

                $data[] = $result;
            }

            return $data;

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
    public function summaryDetails($event_guid, $client_guid) {

        try {

            $stmt = $this->db->prepare("
                SELECT
                    (
                        SELECT SUM(ticket_amount) AS overall_funds_realised 
                        FROM tickets_listing WHERE sold_state = '1' AND client_guid = '{$client_guid}'
                    ) AS overall_funds_realised,
                    (
                        SELECT COUNT(*) FROM tickets_listing WHERE sold_state = '1' AND client_guid = '{$client_guid}'
                    ) AS overall_tickets_sold,
                    (
                        SELECT COUNT(*) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND sold_state = '1'
                    ) AS tickets_sold,
                    (
                        SELECT COUNT(*) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND status = 'used'
                    ) AS tickets_used,
                    (
                        SELECT COUNT(*) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND status = 'invalid'
                    ) AS invalid_tickets,
                    (
                        SELECT SUM(ticket_amount) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND sold_state = '1'
                    ) AS tickets_expected_funds,
                    (
                        SELECT SUM(ticket_amount) FROM tickets_listing WHERE event_booked = '{$event_guid}' AND status = 'used' AND sold_state = '1'
                    ) AS tickets_funds_realised
                FROM tickets_listing WHERE client_guid = '{$client_guid}'
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            return [
                "funds" => [
                    "overall_funds_realised" => [
                        "description" => "This is the accumulated funds realized from the sale of tickets",
                        "value" => [
                            "funds" => $result->overall_funds_realised,
                            "count" => $result->overall_tickets_sold
                        ]
                    ],
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
                    ],
                    "invalid_tickets" => [
                        "description" => "These are tickets that were sold however was returned and destroyed",
                        "value" => $result->invalid_tickets ?? 0
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
     * Summary insight
     * This generates all time data counts for all activities
     * 
     * @return Array
     */
    public function allInsight($client_guid) {
        try {

            $stmt = $this->db->prepare("
                SELECT
                    (
                        SELECT SUM(ticket_amount) AS overall_funds_realised 
                        FROM tickets_listing WHERE sold_state = '1' AND status != 'invalid' AND client_guid = '{$client_guid}'
                    ) AS overall_funds_realised_from_sale,
                    (
                        SELECT SUM(ticket_amount) AS overall_funds_realised 
                        FROM tickets_listing WHERE status='used' AND sold_state = '1' AND client_guid = '{$client_guid}'
                    ) AS overall_funds_realised,
                    (
                        SELECT COUNT(ticket_amount) AS overall_funds_realised 
                        FROM tickets_listing WHERE sold_state = '1' AND status != 'invalid' AND client_guid = '{$client_guid}'
                    ) AS tickets_sold,
                    (
                        SELECT COUNT(*) FROM events WHERE deleted='0' AND client_guid = '{$client_guid}'
                    ) AS events_count,
                    (
                        SELECT COUNT(*) FROM halls WHERE deleted='0' AND client_guid = '{$client_guid}'
                    ) AS halls_count,
                    (
                        SELECT COUNT(*) FROM tickets WHERE status='1' AND client_guid = '{$client_guid}'
                    ) AS tickets_count,
                    (
                        SELECT COUNT(*) FROM users WHERE deleted='0' AND client_guid = '{$client_guid}'
                    ) AS users_count,
                    (
                        SELECT COUNT(DISTINCT b.created_by) FROM events_booking b WHERE b.deleted='0' AND b.client_guid = '{$client_guid}'
                    ) AS audience_count,
                    (
                        SELECT COUNT(*) FROM departments WHERE status='1' AND client_guid = '{$client_guid}'
                    ) AS departments_count
                FROM events a WHERE a.client_guid = '{$client_guid}' AND deleted='0'
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            return $result;

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
    

    /**
     * Make a better date format
     */ 
    private function makeDate($period) {
        
        /** Properly format the period */
        $date = explode("to", $period);

        /** If the date is not not */
        if(!isset($date[1])) {
            
            // confirm if the first item is a valid date
            if($this->validDate($date[0])) {
                
                // preset the variables
                $this->start_date = $date[0];
                $this->end_date = $date[0];
                $this->group_by = "DATE";
                $this->date_format = "jS M Y";
                
                return $this;
            }

            // return empty
            return;
        } else {
            // confirm if the first item is a valid date
            if($this->validDate($date[0])) {
                // preset the variables
                $this->start_date = trim($date[0]);
            }

            if($this->validDate($date[1])) {
                $this->end_date = trim($date[1]);
            }
            // set other items
            $days_count = $this->listDays($this->start_date, $this->end_date);
            
            // group by
            if(count($days_count) > 90) {
                $this->group_by = "MONTH";
            } else {
                $this->group_by = "DATE";
            }
            $this->date_format = "jS M Y";
            
            return $this;
        }
    }

    /**
     * This formats the correct date range
     *  
     * @param String    $datePeriod      This is the date period that was parsed
     * 
     * @return This     $this->start_date, $this->end_date;
     */
    private function dateFormat($period) {

        // check the date format
        $dateFrame = $this->makeDate($period);

        // if the date frame is empty
        if(empty($dateFrame)) {

            // Check Sales Period
            switch ($period) {
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
                    $groupBy = "DATE";
                    $format = "jS M Y";
                    $dateFrom = date("Y-m-d", strtotime("today -6 days"));
                    $dateTo = date("Y-m-d");
                    break;
            }

            // set the date
            $this->start_date = $dateFrom;
            $this->end_date = $dateTo;
            $this->group_by = $groupBy;
            $this->date_format = $format;
        }

    }

    /**
     * Generate voucher reports
     * 
     * @param String $params->clientId          This is the client id to load the records
     * @param String $params->period            This is a unique period for time range calculation 
     *          This can be dates separated with the keyword "to" or predefined timeframe
     * @param String $params->user_guid         This is the id of the user agent
     * 
     * @param Array
     */
    private function voucherReport(stdClass $params) {
        
        $period = isset($params->period) ? $params->period : "this_week";
        $period = $this->dateFormat($period);

        

    }

}