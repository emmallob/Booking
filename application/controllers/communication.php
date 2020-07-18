<?php

class Communication extends Booking {

    private $_key = "rMOWeGxqRy3MOqa683c4hUbnv";
    
    public function __construct()
    {
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
    public function sendSMS($message, $to)
    {
        
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
    private function _curlSMSAPI($url)
    {
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
    public function reduceSMSUnit($totalUsed, $clientId)
    {
        $stmt = $this->db->prepare(
            "UPDATE sms_subscribers 
                SET sms_units = (sms_units-$totalUsed)
                WHERE client_guid = '{$clientId}'"
        );

        return $stmt->execute();

    }

}
?>