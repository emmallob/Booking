<?php
//: set the page header type
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");

global $followinClass, $SITEURL;

// incoming inputs from the request
// and convert the request into an array using the PHP Standard Input
$incomingData = json_decode( file_get_contents("php://input"), true );

// get the request method that was parsed by the user
$requestMethod = strtoupper( $_SERVER["REQUEST_METHOD"] );

// get the request url for pattern matching and request payload matching
$requestUri = $_SERVER["REQUEST_URI"];

// example http://testurl.com/api/smp/facebook
$inner_url = ( isset($SITEURL[1]) ) ? $SITEURL[1] : null;  // smp
$outer_url = ( isset($SITEURL[2]) ) ? $SITEURL[2] : null; // facebook

// initiate an empty array of the parameters parsed
$userId = $session->userId;
$clientId = $session->clientId;

// set the global variables
$bookingClass->user_guid = $userId;
$bookingClass->clientId = $clientId;

$remote = false;

// load the user data
$userData = (Object) $usersClass->item_by_id("users", $userId);

// init the params variable
$params = [];

// confirm that the incoming data is not empty
if( !empty($incomingData) ) {

    // loop through the list if its a valid array
    if( is_array($incomingData) ) {

        // populate the user data using the request method parsed
        // however first of all loop through the data
        foreach( $incomingData as $key => $value ) {

            // if the value is not an array in itself
            if( !is_array($value))  {

                // add to list if the value is not empty
                if(!empty($value)) {
                    $params[$key] = xss_clean($value);
                }
            }
            // else if the value is an array then loop through the array
            elseif( is_array($value) ) {
                
                // perform the loop
                foreach( $value as $nkey => $nvalue ) {
                    
                    //: add the data to the array list
                    if(!is_array($nvalue)) {
                        
                        // only add to list if the value is not empty
                        if(!empty($nvalue)) {
                            $params[$key][$nkey] = xss_clean($nvalue);
                        }
                    } else {

                        // loop through the array values
                        foreach($nvalue as $hhKey => $hhValue) {
                           
                            // only add to list if the value is not empty
                            if(!empty($hhValue)) {
                                $params[$key][$nkey][$hhKey] = is_array($hhValue) ? array_map('xss_clean', $hhValue) : $hhValue;
                            }
                        }

                    }
                    
                }

            }

        }
        
    }
}

else if( empty($incomingData) && in_array($inner_url, ["halls", "users", "events", "tickets", "reports", "reservations", "insight", "sms", "emails"]) && ($requestMethod == "GET") ) {
    // empty the parameters list
    $params = [];

    // run this section if the content is not empty
    if(!empty($_GET)) {
        // loop through the url items
        foreach($_GET as $key => $value) {
            // only parse if the value is not empty
            if( !empty($value) ) {
                // append the parameters
                $params[$key] = xss_clean(strip_tags($value));
            }
        }
    }
}

else if(
    empty($incomingData) && 
    (
        (($inner_url == "emails") && ($outer_url == "attach") && ($requestMethod == "POST")) ||
        (($inner_url == "account") && ($outer_url == "update") && ($requestMethod == "POST")) ||
        (($inner_url == "users") && ($outer_url == "add") && ($requestMethod == "POST")) ||
        (($inner_url == "users") && ($outer_url == "update") && ($requestMethod == "POST")) ||
        (($inner_url == "halls") && ($outer_url == "configure") && ($requestMethod == "POST")) ||
        (($inner_url == "events") && ($outer_url == "add") && ($requestMethod == "POST")) || 
        (($inner_url == "events") && ($outer_url == "update") && ($requestMethod == "POST")) ||
        (($inner_url == "reservations") && ($outer_url == "reserve") && ($requestMethod == "POST")) 
    )
) {
    // empty the parameters list
    $params = [];

    // run this section if the content is not empty
    if(!empty($_POST)) {
        // loop through the url items
        foreach($_POST as $key => $value) {
            // only parse if the value is not empty
            if(!empty($value) || in_array($key, ["hall_guid_key"])) {
                // append the parameters
                $params[$key] = is_array($value) ? $value : xss_clean($value);
            }
        }
    }
    
    // if the files is not empty
    if(!empty($_FILES)) {
        // append files to the parameters
        foreach($_FILES as $key => $value) {
            // only parse if the value is not empty
            if(!empty($value)) {
                // append the parameters
                $params[$key] = is_array($value) ? $value : xss_clean($value);
            }
        }
    }
}

/* Usage of the Api Class */
$Api = load_class('api', 'controllers', 
    ["userId" => $userId, "clientId" => $clientId]
);

// echo json_encode($params);exit; 
/**
 * Test examples using the inner url of users
 */
$Api->inner_url = $inner_url;
$Api->outer_url = $outer_url;
$Api->method = $requestMethod;

/* Run a check for the parameters and method parsed by the user */
$paramChecker = $Api->keysChecker($params);

// in continuing your script then you can also do the following
// if an error was found
if( $paramChecker['code'] !== 100) {
    // check the message to parse
    $paramChecker['data']['result'] = $paramChecker['data']['result'] ?? $paramChecker['description'];

    // print the json output
    echo json_encode($paramChecker);
} else {
    /** 
     * you can call the class to process your request here
     * you can run an if statement to check which class to call
     * 
     * Example for users
     */
    // run the request
    $ApiRequest = $Api->apiHandler($params, $remote);

    // print out the response
    echo json_encode($ApiRequest);
}
?>