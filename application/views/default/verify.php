<?php
#FETCH SOME GLOBAL FUNCTIONS
global $session, $usersClass, $booking;

$baseUrl = $config->base_url();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>Verify Account - <?= config_item("site_name") ?></title>
        <link href="<?= $baseUrl ?>assets/css/styles.css" rel="stylesheet" />
        <link href='<?= "{$baseUrl}assets/libs/sweetalert/sweetalert.css" ?>' rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/x-icon" href="<?= $baseUrl ?>assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="<?= $baseUrl ?>assets/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
        <style>
        .bg {
            background-image: url('<?= $baseUrl ?>assets/img/bg.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        main {
            margin-top: 100px;
        }

        footer.footer {
            background: #3a2e2b;
            height: 3rem;
        }
        </style>
    </head>
    <body class="bg-primary bg">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center">
                                        <h3 class="font-weight-light my-4">
                                            <?= (isset($_GET["password"])) ? "Reset Password" : (confirm_url_id(1, "account") ? "Account Verification" : "Unknown Request") ?>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        
                                        <?php
                                        global $session;

                                        $forms = load_class('form_validation', 'libraries');
                                        $access_token = random_string('alnum', '45');
                                        $session->set("access_token", $access_token);

                                        /** If the user is reseting the password */
                                        if(isset($_GET["password"]) && !confirm_url_id(1)) {

                                            // confirm that the code has been set
                                            if(isset($_GET["token"])) {

                                                // set the code variable
                                                $code = xss_clean($_GET["token"]);

                                                // validate the code
                                                if($forms->min_length($code, 30)) {

                                                    // continue processing the form
                                                    $stmt = $booking->query("SELECT * FROM users_reset_request WHERE request_token='$code' AND token_status='PENDING' LIMIT 1");

                                                    // count the number of rows found
                                                    if($stmt->rowCount()) {

                                                        // using for each loop to get the results
                                                        foreach($stmt as $results) {
                                                            
                                                            // set the variables
                                                            $expiry_time = $results["expiry_time"];
                                                            $username = $results["username"];
                                                            $user_id = $results["user_guid"];
                                                            $session->set("resetAccess_Token", $code);
                                                            $session->set("resetUserId", $user_id);
                                                            
                                                            // confirm that the token hasnt yet expired
                                                            if($expiry_time > time()) {
                                                                // display the reset form here
                                                                ?>
                                                                <form style="width: 100%" id="authForm" autocomplete="Off" class="p-t-15" method="post" action="<?= $baseUrl; ?>auth/reset">
                                                                    <!-- START Form Control-->
                                                                    <div class="form-group form-group-default">
                                                                        <label>Enter Password</label>
                                                                        <div class="controls">
                                                                            <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END Form Control-->
                                                                    <!-- START Form Control-->
                                                                    <div class="form-group form-group-default">
                                                                        <label>Confirm Password</label>
                                                                        <div class="controls">
                                                                            <input type="password" class="form-control" name="password2" placeholder="Confirm Password" required>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="user_guid" value="<?php print base64_encode($user_id); ?>">
                                                                    <input type="hidden" name="access_token" value="<?= base64_encode($code); ?>">
                                                                    <button class="btn btn-primary btn-cons m-t-10 btn-block" id="submit-button" type="submit">Reset Password</button>
                                                                    <hr style="border-color: #b9b9b9">
                                                                    
                                                                </form>
                                                            <?php
                                                            } else {
                                                                // update the database and set the token status to expired
                                                                $booking->query("UPDATE users_reset_request SET token_status='EXPIRED' WHERE request_token='{$code}' AND username='{$username}' AND user_guid='{$user_id}' LIMIT 1");

                                                                // log the user activity
                                                                $bookingClass->userLogs("password_reset", $user_id, "{$username} supplied an expired Password Reset Access Token for processing.", $user_id, null);

                                                                // print an error message 
                                                                print_msg("danger", "Sorry! The password reset token has expired. Please <a href='{$baseUrl}recover'><strong>click here</strong></a> to request for a new token.");
                                                            }
                                                        }
                                                    }  else {
                                                        // print an error message 
                                                        print_msg("danger", "Sorry! An invalid password reset token was submitted.");
                                                    }
                                                } else {
                                                    // print an error message 
                                                    print_msg("danger", "Sorry! An invalid password reset token was submitted.");
                                                }
                                            } else {
                                                // print an error message 
                                                print_msg("danger", "Sorry! An invalid password reset token was submitted.");
                                            }

                                        } elseif(isset($_GET["token"]) and confirm_url_id(1, 'account')) {
                                            // get the token
                                            $code = xss_clean($_GET["token"]);
                                            ?>
                                            <?php
                                            // if the code is at least 40 characters long 
                                            if(strlen($code) >= 40) {

                                                // make the query
                                                $stmt = $booking->prepare("
                                                    SELECT 
                                                        a.client_guid, a.name, a.email, a.user_type, a.username,
                                                        a.verify_token, b.subscription, a.id, a.user_guid
                                                    FROM users a
                                                        LEFT JOIN users_accounts b ON b.client_guid = a.client_guid
                                                    WHERE a.verify_token = ?
                                                ");
                                                $stmt->execute([$code]);

                                                // verification successful
                                                if($stmt->rowCount()) {

                                                    // loop through the result fetched
                                                    while($results = $stmt->fetch(PDO::FETCH_OBJ)) {

                                                        // update the user status
                                                        $booking->query("UPDATE users SET status='1', verify_token=NULL WHERE id = '{$results->id}'");
                                                        $session->access_token = null;

                                                        // run this section if the user type is holder
                                                        if($results->user_type == "holder") {

                                                            // update the user information
                                                            $setupInfo = json_decode($results->subscription);
                                                            
                                                            // set the items
                                                            $setupInfo->verified = 1;
                                                            $session->activated = 1;

                                                            // unset the access token
                                                            $booking->query("UPDATE users_accounts SET subscription='".json_encode($setupInfo)."' WHERE client_guid = '{$results->client_guid}'");

                                                            // log the user activity
                                                            $bookingClass->userLogs("setup-verify", $results->clientId, "Has verified the Email Address for this Admin User Account.", $results->user_guid, $results->client_guid);

                                                            // print the success message						  
                                                            if($usersClass->logged_InControlled()) {
                                                                // print the success message. Redirect to the dashboard if the user is already logged in
                                                                print_msg("success", "Congrats! Your account has successfully been verified. You will be redirected in a second.");
                                                                redirect( $baseUrl, 'refresh:1000');
                                                                exit(-1);
                                                            } else {
                                                                // log the user out of all other sessions
                                                                $session->userLoggedIn = null;
                                                                $session->userId = null;
                                                                
                                                                // print the success message. Redirect to the Login page if the user is not logged in
                                                                print_msg("success", "Congrats! Your account has successfully been verified. You can now proceed to <a href='".$baseUrl."'>Login</a>");
                                                                redirect( $baseUrl, 'refresh:1000');
                                                                exit(-1);
                                                            }
                                                        } else {
                                                            // log the user out of all other sessions
                                                            $session->userLoggedIn = null;
                                                            $session->userId = null;

                                                            // log the user activity
                                                            $bookingClass->userLogs("account-verify", $results->user_guid, "Verified the Email Address attached to this Account.", $results->user_guid, $results->client_guid);

                                                            // confirm if the user already has one account
                                                            if($bookingClass->userAccountsCount($results->email) > 1) {
                                                                // Print the success message. Redirect to the Login page if the user is not logged in
                                                                print_msg("success", "Congrats! Your account has successfully been verified. You can now proceed to <a href='".$baseUrl."'>Login</a>");
                                                                redirect( $baseUrl, 'refresh:3000');
                                                                exit(-1);
                                                            } else {
                                                                // set an expiry time and reset token
                                                                $expiry_time = $expiry_time = time()+(60*60*1);
                                                                $token = random_string('alnum', mt_rand(40, 75));

                                                                // generate a password reset token and insert into the database
                                                                $stmt = $booking->prepare("INSERT INTO users_reset_request SET username='{$results->username}', user_guid='{$results->user_guid}', request_token='{$token}', user_agent='NIL', expiry_time='{$expiry_time}'");
                                                                $stmt->execute();

                                                                // log the user out
                                                                print_msg("success", "Congrats! Your account has successfully been verified. Please wait while you are redirected to reset your password.");
                                                                redirect( $baseUrl . 'verify?password&token='.$token, 'refresh:3000');
                                                                exit(-1);
                                                            }
                                                        }
                                                    }
                                                } else {
                                                        print_msg("danger", "Sorry! An invalid authorization token was submitted.");
                                                }
                                            } else {
                                                print_msg("danger", "Sorry! An invalid authorization token was submitted.");
                                            }
                                        } else {
                                            print_msg("danger", "Sorry! An unknown request was parsed.");
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer mt-auto footer-dark">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; <?= config_item("site_name") ?> <?= date("Y") ?></div>
                            <div class="col-md-6 text-md-right small">
                                <a href="<?= $baseUrl ?>pages/privacy-policy">Privacy Policy</a>
                                &#xB7;
                                <a href="<?= $baseUrl ?>pages/terms-and-conditions">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?= $baseUrl ?>assets/js/jquery.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/libs/sweetalert/sweetalert.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/js/login.js"></script>
        <sb-customizer project="sb-admin-pro"></sb-customizer>
    </body>
</html>
