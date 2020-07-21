<?php

class Communication extends Booking {

    private $_key = "rMOWeGxqRy3MOqa683c4hUbnv";
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Check the account sms balance and send back
     * 
     * @param $params->clientId     This is the unique id of the client account
     * 
     * @return String
     */
    public function checkBalance(stdClass $params) {
        
        $balance = 0;

        //prepare your url
        if (empty($params->clientId)) {

            $url = "https://apps.mnotify.net/smsapi/balance?key={$this->_key}";

            $balance = $this->_curlSMSAPI($url);

        } else {
            $stmt = $this->pushQuery("sms_units", "sms_subscribers", "client_guid = '{$params->clientId}'");

            $balance = ($stmt != false) ? $stmt[0]->sms_units : 0;
        }

        return [
            "balance" => $balance, 
            "show_balance" => $balance." SMS Units"
        ];
        
    }

    /**
     * A method to send SMS
     *
     * @param String $message Pass message to send
     * @param String $to      Pass recipients number
     *
     * @return String $result
     */
    public function sendSMS($message, $to) {
        
        //defining the parameters
        $to = $to;
        $msg = urlencode($message);
        $sender_id = $this->session->smsSenderId;

        //prepare your url
        $url = "https://apps.mnotify.net/smsapi?key={$this->_key}&to={$to}&msg={$msg}&sender_id={$sender_id}";

        $response = $this->_curlSMSAPI($url);

        return $response;
    }

    /**
     * A method to execute API curl call
     *
     * @param String $url Pass call url
     *
     * @return String $result
     */
    private function _curlSMSAPI($url) {
        $this->_message = "1009";

        if (!empty($url)) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

            $this->_message = curl_exec($ch);

            curl_close ($ch);
        }

        return $this->_message;
    }

    /**
     * A method to deduct total unit used from main sms unit
     *
     * @param String $totalUsed Pass total units used
     *
     * @return String $this->_message
     */
    public function reduceSMSUnit($totalUsed, $clientId) {
        $stmt = $this->db->prepare(
            "UPDATE sms_subscribers 
                SET sms_units = (sms_units-$totalUsed)
                WHERE client_guid = '{$clientId}'"
        );

        return $stmt->execute();

    }

    /**
     * Get the recipient category
     */
    public function recipientCategory(stdClass $params) {
        
        switch ($params->recipient) {

            case "allContacts":

                $link = "SELECT COUNT(DISTINCT b.created_by) AS total_count,
                    GROUP_CONCAT(DISTINCT b.created_by separator ',') AS recipients
                    FROM events_booking b WHERE b.deleted='0' AND b.client_guid = '{$params->clientId}'";

                $stmt = $this->db->prepare("{$link}");

                if ($stmt->execute()) {

                    $data = $stmt->fetch(PDO::FETCH_OBJ);

                    $message = '
                    <div class="input-group mt-4">
                        <div class="input-group-prepend append-lists" data-total-contacts="'.$data->total_count.'" data-recipient-lists="'.$data->recipients.'">
                            <span class="input-group-text">Total Contacts</span>
                        </div>
                        <input type="text" value="'.$data->total_count.' Contacts" readonly class="form-control">
                    </div>';
                }

                break;

            case "specificContact":

                // confirm that the event exist
                $usersList = $this->pushQuery("CONCAT(created_by,'|',fullname,'|',event_guid,'|',status) AS recipient", "events_booking", "deleted='0' AND client_guid='{$params->clientId}'");

                // count the number of rows found
                if(empty($usersList)) {
                    return "Sorry! No recipients were found for the selected category.";
                }
                // contacts list
                $contacts_list = [];

                // get the list of contacts depending on the data parsed
                foreach($usersList as $eachUser) {
                    // explode the text
                    $expl = explode('|', $eachUser->recipient);

                    // dealing with duplicates
                    // confirm if the contact number has not already been added to a list
                    if(!in_array($expl[0], $contacts_list)) {
                        $recipient_list[] = [
                            'fullname' => $expl[1],
                            'contact' => $expl[0],
                            'category' => ($expl[3] == 0) ? 'Booked' : 'Confirmed',
                            'event_guid' => $expl[2]
                        ];
                        $contacts_list[] = $expl[0];
                    }
                }

                $message = "
                    <label>Select Recipient</label>
                    <select class=\"form-control select2\" multiple=\"multiple\" data-placeholder=\"Select Recipient\" name=\"recipient-lists\">
                        <option label=\"-- Select Recipient --\"></option>";

                foreach($recipient_list as $data) {

                    $message .= "<option value=\"{$data['contact']}\">{$data['fullname']} ({$data['contact']})</option>";

                }

                $message .= "</select>";
                $status = 200;

                break;

            case "specificEvent":

                $link = "SELECT event_guid, event_title, event_date FROM events WHERE deleted='0' AND client_guid = '{$params->clientId}'";

                $stmt = $this->db->prepare("{$link}");

                if ($stmt->execute()) {

                    $message = "<div class='row'>
                        <div class='col-lg-12'>
                        <div class='form-group'>
                        <label>Select Event - <small><em>Booked / Confirmed to Receive Mail</em></small></label>
                        <select class=\"form-control pqSelect\" data-placeholder=\"Select Event\" name=\"recipient-lists\">
                            <option label=\"-- Select  Event--\"></option>";
                    while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                        $message .= "<option value=\"{$data->event_guid}\">{$data->event_title}</option>";
                    }
                    $message .= "</select>";
                    $message .= "</div></div>";
                    $message .= "<div class='col-lg-12'>";
                    $message .= "<div class='form-group m-0'>
                                    <input type='checkbox' name='category_list' value='booked_list' id='booked_list' class='custom-checkbox'>
                                    <label for='booked_list'>Booked Audience</label>
                                </div>";
                    $message .= "<div class='form-group m-0'>
                                    <input type='checkbox' name='category_list' value='confirmed_list' id='confirmed_list' class='custom-checkbox'>
                                    <label for='confirmed_list'>Confirmed Audience</label>
                                </div>";
                    $message .= "</div></div>";
                    $status = 200;
                }

                break;

            default:
                break;
        }

        return $message;
    }

    /**
     * Get the SMS History
     * 
     * @param $params->group        The group of messages to list
     * @param $params->client_guid  The client guid for filtering the record
     * @param $params->limit        The limit to get the messages
     * 
     * @return Array
     */
    public function smsHistory(stdClass $params) {

        // confirm that the group parameter has been parsed
        if ($params->group == "single") {
            $condition = " && recipient_group = 'Single Contact'";
        } else if ($params->group == "bulk") {
            $condition = " && recipient_group IN ('All Contacts', 'Selected Contacts')";
        } else {
            $condition = "";
        }

        // fetch the user messages history
        if($params->group == "single") {
            
            return;

            $singleMsgs = $this->db->prepare("
                SELECT DISTINCT a.contact_id, a.sms_status,
                    a.message, a.history_id, a.date_sent, 
                    CONCAT(b.firstname, ' ', b.lastname) AS fullname,
                    (
                        SELECT COUNT(*) 
                        FROM messages_history c 
                        WHERE c.contact_id = a.contact_id
                        AND status = '1'
                    ) AS messages_count
                FROM messages_history a
                LEFT JOIN customers b ON b.customer_id = a.contact_id
                WHERE 
                    a.clientId = ? AND a.status = ? AND (LENGTH(a.contact_id) > 5)
                    AND a.msg_type = 'sms'
                GROUP BY a.contact_id ORDER BY a.id DESC
            ");
            $singleMsgs->execute([$params->clientId, 1]);

            $i = 0;
            $message = array();

            while ($data = $singleMsgs->fetch(PDO::FETCH_OBJ)) {
                $i++;

                $date = date('d M', strtotime($data->date_sent));

                $messagesHistory = $this->pushQuery(
                    "messages_history",
                    "message, date_sent, sms_status",
                    "contact_id = '{$data->contact_id}'"
                );

                $message[$data->history_id] = [
                    "recipientName" => $data->fullname,
                    "recipients" => $data->contact_id,
                    "list" => "
                    <a data-history='".json_encode($messagesHistory)."' href=\"javascript:void(0)\" class=\"media\" data-history-id=\"{$data->contact_id}\">
                        <div class=\"media-left\">
                            <div class=\"avatar-box thumb-md align-self-center mr-2\">
                                <span class=\"avatar-title bg-primary rounded-circle\">
                                    <i class=\"fab fa-quinscape\"></i>
                                </span>
                            </div>
                        </div><!-- media-left -->
                        <div class=\"media-body\">
                            <div>
                                <h6>{$data->fullname}</h6>
                                <p>".nl2br(htmlspecialchars_decode(limit_words($data->message, 4)))."...</p>
                            </div>
                            <div>
                                <span>{$date}</span>
                                <span>{$data->messages_count}</span>
                            </div>
                        </div><!-- end media-body -->
                    </a> <!--end media-->"
                ];
            }

            return $message;

        }

        // group messages
        elseif($params->group == "bulk") {

            $multipleMsgs = $this->db->prepare("
                SELECT a.*
                FROM messages a
                WHERE a.client_guid = ? AND a.message_type = 'sms'
                ORDER BY a.id DESC
            ");
            $multipleMsgs->execute([$params->clientId]);

            $i = 0;
            $message = array();

            while ($data = $multipleMsgs->fetch(PDO::FETCH_OBJ)) {
                $i++;

                $date = date('d M', strtotime($data->created_on));
                $fulldate = date('jS F Y \a\t H:iA', strtotime($data->created_on));
                $list = json_decode($data->recipient_list, true);
                $status = $this->stringToArray($data->recipient_status);
                $category = ($data->related_item == "event") ? "specificEvent" : "specificContact";

                $eachRecipient = [];
                for($i = 0; $i < count($list); $i++) {
                    $eachRecipient[] = [
                        'fullname' => $list[$i]['fullname'],
                        'contact' => $list[$i]['contact'],
                        'message_status' => $status[$i] ?? 'pending'
                    ];
                }

                $message[$data->unique_guid] = [
                    "recipientName" => $data->subject,
                    "recipients" => !empty($data->related_guid) ? $data->related_guid : array_column($list, "contact"),
                    "unique_guid" => $data->unique_guid,
                    "category" => $category,
                    "date_sent" => $date,
                    "full_date" => $fulldate,
                    "list" => "<a style='text-decoration:none' data-recipients-info='".json_encode($eachRecipient)."' href=\"javascript:void(0)\" data-message=\"{$data->message}\" class=\"media\" data-bulk-history-id=\"{$data->unique_guid}\">
                        <div class=\"media-left\">
                            <div class=\"avatar-box thumb-md align-self-center mr-2\">
                                <span class=\"avatar-title bg-primary rounded-circle\">
                                    <i class=\"fab fa-quinscape\"></i>
                                </span>
                            </div>
                        </div><!-- media-left -->
                        <div class=\"media-body\">
                            <div>
                                <h6>{$data->subject}</h6>
                                <p>Message sent to...</p>
                            </div>
                            <div>
                                <span>{$date}</span>
                                <span>{$data->recipient_count}</span>
                            </div>
                        </div>
                    </a>"
                ];
            }

            return $message;
        }

    }

    /**
     * Send SMS Message
     */
    public function smsSend(stdClass $params) {
        
        $logMessage = 'Sent messages to some contacts';

        if (!empty($params->message)) {
            //: Recipients list
            $recipient_list = [];

            // send message to specific audience for a specific event
            if (($params->category == "specificEvent")) {

                // ensure that the recipient list is not empty
                if(!isset($params->recipients)) {
                    return "Sorry! The event guid cannot be empty.";
                }

                // the people to receive the message
                $recipient_group = (isset($params->data)) ? $this->stringToArray($params->data) : ["booked_list", "confirmed_list"];

                // confirm that the event exist
                $eventData = $this->pushQuery("id, event_title, booking_start_time", "events", "event_guid='{$params->recipients}' AND client_guid='{$params->clientId}' AND deleted='0' LIMIT 1");

                // count the number of rows found
                if(empty($eventData)) {
                    return "Sorry! An invalid event guid has been supplied.";
                }

                // get the list of contacts depending on the data parsed
                if(in_array("booked_list", $recipient_group)) {
                    $usersList = $this->pushQuery("fullname, created_by AS contact", "events_booking", "event_guid='{$params->recipients}' AND client_guid='{$params->clientId}' AND deleted='0' AND status='0'");
                    foreach($usersList as $eachUser) {
                        $eachUser->category = 'Booked';
                        $recipient_list[] = $eachUser;
                    }
                }

                if(in_array("confirmed_list", $recipient_group)) {
                    $usersList = $this->pushQuery("fullname, created_by AS contact", "events_booking", "event_guid='{$params->recipients}' AND client_guid='{$params->clientId}' AND deleted='0' AND status='1'");
                    foreach($usersList as $eachUser) {
                        $eachUser->category = 'Confirmed';
                        $recipient_list[] = $eachUser;
                    }
                }

                // generate a common id
                $commonID = random_string('alnum', 32);

                // confirm that the event exist
                $commonData = $this->pushQuery("unique_guid, recipient_count", "messages", "related_item='event' AND related_guid='{$params->recipients}' AND client_guid='{$params->clientId}' LIMIT 1");

                // count the number of rows found
                if(!empty($commonData)) {
                    // $commonID = ($commonData[0]->recipient_count == count($recipient_list)) ? $commonData[0]->unique_guid : $commonID;
                }
                $related_item = 'event';
                $logMessage = "Send out an SMS to ".count($recipient_list)." contacts for the event: ".$eventData[0]->event_title;
            }

            // send messages to all contacts 
            elseif (($params->category == "allContacts")) {

                // the people to receive the message
                $recipient_group = (isset($params->data)) ? $this->stringToArray($params->data) : ["booked_list", "confirmed_list"];

                // confirm that the event exist
                $usersList = $this->pushQuery("CONCAT(created_by,'|',fullname,'|',event_guid,'|',status) AS recipient", "events_booking", "deleted='0' AND client_guid='{$params->clientId}'");

                // count the number of rows found
                if(empty($usersList)) {
                    return "Sorry! No recipients were found for the selected category.";
                }
                // contacts list
                $contacts_list = [];

                // get the list of contacts depending on the data parsed
                foreach($usersList as $eachUser) {
                    // explode the text
                    $expl = explode('|', $eachUser->recipient);

                    // dealing with duplicates
                    // confirm if the contact number has not already been added to a list
                    if(!in_array($expl[0], $contacts_list)) {
                        $recipient_list[] = [
                            'fullname' => $expl[1],
                            'contact' => $expl[0],
                            'category' => ($expl[3] == 0) ? 'Booked' : 'Confirmed',
                            'event_guid' => $expl[2]
                        ];
                        $contacts_list[] = $expl[0];
                    }
                }
                
                // generate a common id
                $commonID = random_string('alnum', 32);

                $related_item = 'contacts';
                $params->recipients = null;
                $logMessage = "Send out an SMS to all ".count($recipient_list)." contacts in the database.";
            }

            $recipientCount = count($recipient_list);

            if(!$recipientCount) {
                return "Sorry! The recipients count cannot be nil.";
            }

            $smsMsg = strip_tags($params->message);
            $smsUnit = round(strlen($smsMsg) / 145);

            $smsUnit = $smsUnit == 0 ? 1 : $smsUnit;

            $unit = (isset($params->unit)) ? $params->unit : $smsUnit;

            // Check Total Units To Use
            $totalUnitInvolved = ($recipientCount * $unit);

            // Check Company SMS Credit Left
            if ($this->checkBalance($params) < $totalUnitInvolved) {
                return "Sorry! Your Balance Is Insufficient To Send This Message.";
            }
            
            // Prepare Message & Recipient Details In Database
            $stmt = $this->db->prepare("
                INSERT INTO messages SET client_guid = ?, unique_guid = ?, related_item = ?, related_guid = ?, message_type = ?, 
                recipient_count = ?, recipient_list = ?, message = ?, subject = ?, created_by = ?, sms_units = ?
            ");

            if ($stmt->execute([
                $params->clientId, $commonID, $related_item, $params->recipients, 'sms', $recipientCount, 
                json_encode($recipient_list), $params->message, $logMessage, 
                $params->userId, $totalUnitInvolved
            ])) {

                // Reduce The Total Units Used
                $this->reduceSMSUnit($totalUnitInvolved, $params->clientId);

                /** Log the user activity */
                $this->userLogs('sms', $params->recipients, $logMessage, $params->userId, $params->clientId);

                return [
                    "result" => "Message Successfully Sent.",
                    "recipient_id" => $commonID
                ];
            }

        } else {
            return "Error processing request.";
        }

    }

}
?>