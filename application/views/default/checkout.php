<?php 
// if the 3rd paramters is not parsed
(!confirm_url_id(2) && !confirm_url_id(1, 'callback')) ? server_log() : null;

// if not a callback request
if(!confirm_url_id(1, 'callback')) {

    // set the variables
    $token = xss_clean($SITEURL[1]);
    $request = xss_clean($SITEURL[2]);
    
    // create a new object
    $tellerObj = load_class("teller", "controllers");
    
    // make the request
    switch($request) {
        case "sms": 
            $query = $bookingClass->getAllRows(
                "sms_purchases a LEFT JOIN settings b ON b.client_guid = a.client_guid", 
                "a.package_price, a.transaction_id, b.client_email AS email, a.client_guid",
                "a.request_status = 'Pending' AND a.request_unique_id='{$token}'"
            );
            $column = "package_price";
            $isDescription = "Make payment for the SMS Topup.";
            $tellerObj->callback_url = $config->base_url("checkout/callback/{$token}/sms");
            break;
        default:
            $query = [];
        break;
    }

    // if the request is empty then show the error message
    (empty($query)) ? server_log() : null;
    
    // get the data
    $queryData = $query[0];
    $isAmount = $queryData->$column;

    // save the transaction id in a session
    $session->_oid_TransactionId = $queryData->transaction_id;
    $session->_oid_ClientId = $queryData->client_guid;
    $session->_oid_TokenId = $token;

    // create a checkout url to be used
    $checkoutRequest = $tellerObj->theTellerProcessor($isAmount, $queryData->email, $queryData->transaction_id, $isDescription);

    // Check Response Code & Execute
    if (isset($checkoutRequest['code']) && ($checkoutRequest['code'] == '200')) {
        
        // If there is a second authentication
        if (isset($checkoutRequest['checkout_url'])) {
            // No VBV Required (Redirect the user to the)
            header("location: {$checkoutRequest['checkout_url']}");
            exit;
        }

    } else {
        // set the header status code
        http_response_code(503);
        // print the error response code
        print '<p>Failed To Process Payment! Please check your internet connection and try again.</p>';
    }
}
// process a callback request
else {
    // if the callback has been set and the 3rd parameter has not been set
    (!confirm_url_id(3)) ? server_log() : null;
    
    // if the second parameter is not equal to the session value
    (!confirm_url_id(2, $session->_oid_TokenId)) ? server_log() : null;

    // verify the content parsed
    if (isset($_GET['status'], $_GET['code'], $_GET['transaction_id'])) {
        
        // confirm that the transaction id parsed is equal to the session value
        if (($_GET['transaction_id'] == $session->_oid_TransactionId)) {
            
            // check the response code parsed
            if ($_GET['code'] == '000' && $_GET['status'] == 'approved') {
                // update the database table
                if(confirm_url_id(3, "sms")) {
                    // update the database table
                    $stmt = $booking->prepare("
                        UPDATE sms_purchases SET 
                            request_status = 'Processed', status = '1',
                            previous_balance = (SELECT sms_capacity FROM sms_purchases WHERE request_unique_id = '{$session->_oid_TokenId}'),
                            current_balance = (
                                (SELECT sms_capacity FROM sms_purchases WHERE request_unique_id = '{$session->_oid_TokenId}') +
                                (SELECT sms_units FROM sms_subscribers WHERE client_guid = '{$session->_oid_ClientId}')
                            )
                        WHERE request_unique_id = '{$session->_oid_TokenId}'
                    ");
                    // execute the statement
                    if($stmt->execute()) {

                        // update the subscribers information
                        $stmt = $booking->prepare("
                            UPDATE sms_subscribers SET sms_units = ((
                                SELECT sms_capacity FROM sms_purchases WHERE request_unique_id = '{$session->_oid_TokenId}'
                            ) + sms_units) WHERE client_guid = '{$session->_oid_ClientId}'
                        ");
                        // execute the statement
                        if($stmt->execute()) {
                            // unset the session variables
                            $session->remove(["_oid_TransactionId", "_oid_TokenId", "_oid_ClientId"]);

                            // print the success message
                            print 'Payment was successfully processed. Redirecting';
                            
                            // redirect
                            print "<script>setTimeout(() => {
                                window.location.href='".$config->base_url("settings/sms-topup")."'
                            }, 2000);</script>";
                        }                       

                    }
                }
            } elseif ($status == 'vbv required') {
                // redirect the user to the verification panel
                if (isset($_GET["reason"])) {
                    // No VBV Required (Redirect the user to the)
                    header("location: {$_GET["reason"]}");
                    exit;
                }
            } elseif($status == 'cancelled') {
                // unacceptable query made
                http_response_code(401);
                // print the error response code
                print 'Failed To Process Payment! The request was cancelled.';
            } else {
                // set the header status code
                http_response_code(503);
                // print the error response code
                print 'Failed To Process Payment! Please check your internet connection and try again.';
            }
        }

    } else {
        // set the header status code
        http_response_code(401);
        // print the error response code
        print 'Failed To Process Payment! Request not recognized.';
    }

}
?>