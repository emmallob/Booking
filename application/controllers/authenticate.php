<?php

class Authenticate extends Booking {

    public $status = false;
    public $redirect_url;
    public $error_response;
    public $success_response;

    public function processLogin($username, $password, $href = null) {

        global $booking, $session, $config;

        try {

            $stmt = $booking->prepare("
                SELECT 
                    u.id, u.password, u.user_guid, u.client_guid, u.access_level
                FROM users u
                WHERE 
                    (u.email=? OR u.username=?) AND u.status=? AND u.deleted=?
                LIMIT 1
            ");
            $stmt->execute([$username, $username, 1, 0]);

            // count the number of rows found
            if($stmt->rowCount() == 1) {

                // using the foreach to fetch the information
                while($results = $stmt->fetch(PDO::FETCH_OBJ)) {

                    // verify the password
                    if(password_verify($password, $results->password)) {

                        // set the status variable to true
                        $this->status = true;

                        // set the user sessions for the person to continue
                        $session->set("bokLoggedIn", random_string('alnum', 50));
                        $session->set("userId", $results->user_guid);
                        $session->set("accessLevel", $results->access_level);
                        $session->set("clientId", $results->client_guid);
                        
                        // unset session locked
                        $session->userSessionLocked = null;

                        // create a new object of the user agent library
                        $user_agent = load_class('user_agent', 'libraries');

                        #update the table
                        $ip = ip_address();
                        $br = $user_agent->browser."|".$user_agent->platform;

                        $stmt = $booking->prepare("UPDATE users SET last_login=now() WHERE id='{$results->id}'");
                        $stmt->execute();

                        $stmt = $booking->prepare("INSERT INTO users_login_history SET client_guid='{$results->client_guid}', username='$username', log_ipaddress='$ip', log_browser='$br', user_guid='".$results->user_guid."', log_platform='".$user_agent->agent."'");
                        $stmt->execute();

                        // redirect the user
                        $this->success_response = "Login successful. Redirecting";

                    } else {
                        $this->error_response = "Sorry! Invalid username/password";
                    }
                }
            } else {
                $this->error_response = "Sorry! Invalid username/password";
            }

        } catch(PDOException $e) {
            $this->error_response = "Sorry! Invalid username/password";
        }

        return $this;
    }

    public function sendPasswordResetToken($email_address) {

        global $booking, $config;

        $user_agent = load_class('user_agent', 'libraries');

        try {

            // begin transaction
            $this->db->beginTransaction();

            // query for the email address match
            // since there are multiple accounts for a user, we can fetch just one item from the list where
            // the deleted status is 0
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email='$email_address' AND deleted='0' LIMIT 1");
            $stmt->execute();

            // count the number of rows found
            if($stmt->rowCount() == 1) {

                // set the status variable to true
                $this->status = true;

                // using the foreach to fetch the information
                while($results = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    #assign variable
                    $user_id = $results["user_guid"];
                    $fullname = $results["name"];
                    $username = $results["username"];
                    $clientId = $results["client_guid"];

                    #create the reset password token
                    $request_token = random_string('alnum', mt_rand(60, 75));

                    #set the token expiry time to 1 hour from the moment of request
                    $expiry_time = time()+(60*60*1);

                    #update the table
                    $ip = $user_agent->ip_address();
                    $br = $user_agent->browser()." ".$user_agent->platform();

                    #deactivate all reset tokens
                    $stmt = $this->db->prepare("UPDATE users_reset_request SET token_status='ANNULED' WHERE username='{$username}' AND user_guid='{$user_id}' AND token_status='PENDING'");
                    $stmt->execute();

                    #remove the item from the mailing list
                    $stmt = $this->db->prepare("UPDATE users_email_list SET deleted='1' WHERE item_guid='{$user_id}' AND template_type='recovery'");
                    $stmt->execute();
                    
                    #process the form
                    $stmt = $this->db->prepare("INSERT INTO users_reset_request SET username='{$username}', user_guid='{$user_id}', request_token='$request_token', user_agent='$br|$ip', expiry_time='$expiry_time'");
                    $stmt->execute();
                    
                    #FORM THE MESSAGE TO BE SENT TO THE USER
                    $message = 'Hi '.$fullname.'<br>You have requested to reset your password at '.config_item('site_name');
                    $message .= '<br><br>Before you can reset your password please follow this link.<br><br>';
                    $message .= '<a class="alert alert-success" href="'.$config->base_url().'verify?password&token='.$request_token.'">Click Here to Reset Password</a>';
                    $message .= '<br><br>If it does not work please copy this link and place it in your browser url.<br><br>';
                    $message .= $config->base_url().'verify?password&token='.$request_token;

                    $reciepient = [
                        "recipients_list" => [
                            [
                                "fullname" => $fullname,
                                "email" => $email_address,
                                "customer_id" => $user_id
                            ]
                        ]
                    ];

                    // insert the email content to be processed by the cron job
                    $stmt = $this->db->prepare("
                        INSERT INTO users_email_list 
                        SET client_guid = ?, template_type = ?, item_guid   = ?, recipients_list = ?,
                            request_performed_by = ?, subject = ?, message = ?
                    ");
                    $stmt->execute([
                        $clientId, 'recovery', $user_id, json_encode($reciepient),
                        $user_id, "[".config_item('site_name')."] Change Password", $message
                    ]);

                    // insert the user activity
                    $this->userLogs("password_reset", $user_id, "{$fullname} requested for a password reset code.", $user_id, $clientId);
                    
                    // commit all transactions
                    $this->db->commit();

                    #record the password change request
                    return true;

                }

            } else {
                return false;
            }

        } catch(PDOException $e) {
            // rollback all transactions if at least one fails
            $this->db->rollBack();
            return $e->getMessage();
        }
    }

    public function resetUserPassword($password, $user_id, $username, $reset_token) {

        global $config;

        $user_agent = load_class('user_agent', 'libraries');

        try {

            $this->db->beginTransaction();

            // query the database for the record
            $stmt = $this->db->prepare("
                SELECT users.user_guid, users.client_guid, users.status, 
                users.username, reset.request_token as request_token, reset.user_guid, 
                users.email as email, users.name as name 
                FROM users, users_reset_request reset 
                WHERE users.user_guid=? AND users.status='1' 
                AND reset.request_token=? AND reset.user_guid=?
            ");
            $stmt->execute([$user_id, $reset_token, $user_id]);

            // count the number of rows found
            if($stmt->rowCount() == 1) {

                $this->status = true;
                    // using the foreach to fetch the information
                while($results = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    #assign variable
                    $user_id = $results["user_guid"];
                    $fullname = $results["name"];
                    $email = $results["email"];
                    $username = $results["username"];
                    $clientId = $results["client_guid"];                  

                    #update the table
                    $ip = ip_address();
                    $br = $user_agent->browser." ".$user_agent->platform;

                    #encrypt the password
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    
                    #deactivate all reset tokens
                    $stmt = $this->db->prepare("UPDATE users SET password=? WHERE user_guid=?");
                    $stmt->execute([$password, $user_id]);

                        #process the form
                    $stmt = $this->db->prepare("
                        UPDATE users_reset_request SET request_token=NULL, reset_date=now(), reset_agent='$br|$ip', token_status='USED', expiry_time='".time()."' WHERE request_token='$reset_token'
                    ");
                    $stmt->execute();

                    #record the activity
                    $this->userLogs("password_reset", $user_id, "You successfully changed your password.", $user_id, $clientId);
                   
                    //FORM THE MESSAGE TO BE SENT TO THE USER
                    $message = 'Hi '.$fullname.'<br>You have successfully changed your password at '.config_item('site_name');
                    $message .= '<br><br>Do ignore this message if your rightfully effected this change.<br>';
                    $message .= '<br>If not, do ';
                    $message .= '<a class="alert alert-success" href="'.$config->base_url().'recover">Click Here</a> if you did not perform this act.';

                    #send email to the user
                    $reciepient = [
                        "recipients_list" => [
                            [
                                "fullname" => $fullname,
                                "email" => $email,
                                "customer_id" => $user_id
                            ]
                        ]
                    ];

                    // add to the email list to be sent by a cron job
                    $stmt = $this->db->prepare("
                        INSERT INTO users_email_list 
                        SET client_guid = ?, template_type = ?, item_guid  = ?, recipients_list = ?, request_performed_by = ?, subject = ?, message = ?
                    ");
                    $stmt->execute([
                        $clientId, 'recovery', $user_id, json_encode($reciepient),
                        $user_id, "[".config_item('site_name')."] Change Password", $message
                    ]);

                    // insert the user activity
                    $this->userLogs("password_reset", $user_id, "{$fullname} successfully resetted the password.", $user_id, $clientId);

                    // commit all transactions
                    $this->db->commit();

                    #record the password change request
                    return true;

                }

            } else {
                return false;
            }

        } catch(PDOException $e) {
            // rollback all transactions if at least one fails
            $this->db->rollBack();
            return false;
        }
    }


    public function compare_password($password) {
        global $booking;
                #run the user set password against a list of known passwords
                #to see if there is any match
                #return true if the password was not found in the database table
        try {
                    #run the search query
            $stmt = $booking->prepare("SELECT * FROM users_passwords_log WHERE password='$password'");
            $stmt->execute();
                    #count the number of rows found
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {}
    }

}