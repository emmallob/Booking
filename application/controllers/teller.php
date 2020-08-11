<?php
// ensure this file is being included by a parent file
if( !defined( 'SITE_URL' ) && !defined( 'SITE_DATE_FORMAT' ) ) die( 'Restricted access' );

class Teller {

    private $_message = '';
    public $callback_url;

    private $teller_merchant_id = "TTM-00003086";
    private $teller_username = 'analitica5e8471d08d741';
    private $teller_api_key = 'ZjkyYzllZGM4ZWJiMDUzNGNkNjM0YmY1YjQxMDRhY2Q=';
    private $teller_endpoint = "https://test.theteller.net/checkout/initiate";


    public function __construct(){
        global $config;
        $this->config = $config;

    }

    /**
     * A method to process payment to The Teller
     *
     * @param String $isAmount      Pass the order total amount to pay.
     * @param String $isEmail       Pass the email of customer.
     * @param String $isOrderNumber Pass the email message.
     * @param String $isDescription Pass the description of the payment
     * 
     * @return Array
     */
    public function theTellerProcessor($isAmount, $isEmail = null, $isOrderNumber, $isDescription)
    {
        $this->_message = '';

        // Prepare Authentication
        $username = $this->teller_username;
        $api_key  = $this->teller_api_key;
        $basic_auth_key =  'Basic ' . base64_encode($username . ':' . $api_key);

        // Convert Amount
        $amount = $isAmount * 100;
        $amount = str_pad($amount, 12, '0', STR_PAD_LEFT);

        // Prepare Payload To Pass To Curl
        $payload = json_encode(
            [
                "merchant_id"   => $this->teller_merchant_id, 
                "transaction_id"=> $isOrderNumber,
                "desc"          => $isDescription,
                "amount"        => $amount,
                "redirect_url"  => $this->callback_url, 
                "email"         => (empty($isEmail)) ? "apis@analiticainnovare.net" : $isEmail
            ]
        );

        $curl = curl_init();

        curl_setopt_array(
            $curl, 
            array(
                CURLOPT_URL => $this->teller_endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CAINFO => dirname(__FILE__)."\cacert.pem",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: ".$basic_auth_key,
                    "Cache-Control: no-cache",
                    "Content-Type: application/json"
                ),
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);

        if ($err) {
            print "cURL Error #:" . $err;
        } else {
            $this->_message = json_decode($response, true);
        }

        return $this->_message;
    }

}
?>