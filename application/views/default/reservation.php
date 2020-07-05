<?php 
// preset the base url
$baseUrl = $config->base_url();

// get the current client guid
$accountFound = false;

// if theAccount variable is empty then get the clientGUID
if(confirm_url_id(1)) {
    // assign the uid in the url
    $theId = xss_clean($SITEURL[1]);
    
    // run a query to check if the url really exists
    $thisAccount = $bookingClass->pushQuery("*", "users_accounts", "client_abbr='{$theId}' AND status='1'");

    // check if the result is not empty
    if(!empty($thisAccount)) {
        // this account
        $accountFound = true;
        $thisAccount = $thisAccount[0];
        $session->theAccountGUID = $theId;

        // events object
        $eventsObj = load_class("reservations", "controllers");

        // userId to be set in cookies
        $userId = isset($_COOKIE["loggedInUser"]) ? xss_clean($_COOKIE["loggedInUser"]) : null;

        $params = [];
        $params["clientId"] = $thisAccount->client_guid;
        
        /** parse the user id if it has been set in the cookie */
        $params["loggedInUser"] = $userId;
        
        // convert the params to object
        $param = (Object) $params;

        // get the list of all events
        $eventsList = $eventsObj->listItems($param);
    }

} 

// several multiple checks will be runned on this page for reserving of seats
// it will handle all forms of requests and using url queries, will determine what to do
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>Reserve Seat - <?= config_item("site_name") ?></title>
        <link href="<?= $baseUrl ?>assets/css/styles.css" rel="stylesheet" />
        <link href="<?= $baseUrl ?>assets/css/booking.css" rel="stylesheet" />
        <link href='<?= "{$baseUrl}assets/libs/sweetalert/sweetalert.css" ?>' rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/x-icon" href="<?= $baseUrl ?>assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="<?= $baseUrl ?>assets/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="row justify-content-center">
                        <?php
                        // confirm that the account really exists
                        if(!$accountFound) {
                            // page was not found
                            // print the page not found error message
                            print '<div class="col-lg-5">';
                            print pageNotFound($baseUrl);
                            print '</div>';
                        } else { ?>
                        <div class="col-lg-12 bg-default booking-main">
                            <div class="row m-1">
                                <div class="pt-2 col-lg-12 col-md-12">
                                    <table width="100%">
                                        <tr>
                                            <td class="logo-td"><img class="header-logo" src="<?= $baseUrl ?><?= $thisAccount->logo ?>" alt=""></td>
                                            <td>
                                                <h1><?= $thisAccount->name ?></h1>
                                            </td>
                                            <td class="text-right user-account">
                                                <i class="fa fa-user"></i> <span class="loggedInUser"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="containedfkar"> -->

                            <div style="width:90%" class="mt-3 row">
                                <?php
                                // get the list of events
                                foreach($eventsList as $eachEvent) {
                                    ?>
                                    <div class="col-lg-3 mb-2">
                                        <div class="card cursor">
                                            <div class="card-header"><?= date("l jS F, Y", strtotime($eachEvent->event_date)) ?></div>
                                            <div class="card-body">
                                                <div class="border-bottom pb-2">
                                                    <strong><?= $eachEvent->event_title ?></strong>
                                                    <?php if(isset($eachEvent->user_booking_count) && ($eachEvent->user_booking_count > 0)) { ?>
                                                    <span class="booked" title="Event has been Booked"><i class="fa text-success fa-check-circle"></i></span>
                                                    <?php } ?>
                                                </div>
                                                <div style="display: inline-flex">
                                                    <div style="text-overflow:ellipsis; overflow:hidden; height: 4rem">
                                                        <em><?= $eachEvent->description ?>...</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        <!-- </div> -->

                        <?php } ?>
                    </div>
                </main>
            </div>
            <div class="bg-primary" id="layoutAuthentication_footer">
                <footer style="height: 3rem;" class="footer mt-auto footer-dark">
                    <div class="container-fluid">
                        <div class="row text-white">
                            <div class="col-md-6 small">Copyright &copy; <a href="<?= $baseUrl ?>" target="_blank"><?= config_item("site_name") ?></a> <?= date("Y") ?></div>
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
        <script src="<?= $baseUrl ?>assets/js/Cookies.js"></script>
        <script src="<?= $baseUrl ?>assets/js/reserve.js"></script>
        <sb-customizer project="sb-admin-pro"></sb-customizer>
    </body>
</html>
