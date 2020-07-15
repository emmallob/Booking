<?php 
// preset the base url
$baseUrl = $config->base_url();

// get the current client guid
$accountFound = false;
$eventFound = false;
$eventId = null;

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
        
        // save in session
        if(!empty($userId)) {
            $session->loggedInUser = empty($session->loggedInUser) ? $userId : $session->loggedInUser;
        }

        // append more information
        $params = [];
        $params["clientId"] = $thisAccount->client_guid;
        $session->clientId = $thisAccount->client_guid;
        
        /** Parse the user id if it has been set in the cookie */
        $params["loggedInUser"] = $userId;
        
        /** Parse the event data if it has been set */
        if(confirm_url_id(3) && confirm_url_id(2, "halls")) {
            /** Assign the event guid */
            $eventId = xss_clean($SITEURL[3]);
        } elseif(confirm_url_id(4) && confirm_url_id(2, "book")) {
            /** Assign the event and hall guid */
            $eventId = xss_clean($SITEURL[3]);
            $hallId = xss_clean($SITEURL[4]);
        }

        /** Append the event id if the event id has been supplied */
        if(!empty($eventId)) {
            $params["event_guid"] = $eventId;
        }

        // convert the params to object
        $param = (Object) $params;

        // get the list of all events
        $eventData = $eventsObj->listItems($param);
        
        // confirm that the event has been found
        if(!empty($eventData) && !empty($eventId)) {
            $eventFound = true;
            $eventData = $eventData[0];
        }
        // print "<pre>";
        // print_r($eventData);exit;
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
                        
                        <div class="col-lg-12 bg-default booking-header">
                            <div class="row m-1">
                                <div class="pt-2 col-lg-12 col-md-12">
                                    <table width="100%">
                                        <tr>
                                            <td class="logo-td"><img class="header-logo" src="<?= $baseUrl ?><?= $thisAccount->logo ?>" alt=""></td>
                                            <td>
                                                <h1><a class="text-black-75" href="<?= $baseUrl ?>reservation/<?= $theId ?>"><?= $thisAccount->name ?></a></h1>
                                            </td>
                                            <td class="text-right user-account">
                                                <i class="fa fa-user"></i> <?= $session->loggedInUser ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php /** If the user wants to view the list of upcoming events */ if(!confirm_url_id(2, "halls") && !confirm_url_id(2, "book")) { ?>
                            <div style="width:90%" class="mt-3 row booking-events-list">
                                <?php
                                if(empty($eventData)) { ?>
                                <div class="col-lg-12 text-center">
                                    <p><em>There is currently no pending events. Please do check back later</em></p>
                                </div>
                                <?php } else {
                                // get the list of events
                                foreach($eventData as $eachEvent) {
                                    ?>
                                    <div data-url="<?= $baseUrl ?>reservation/<?= $theId ?>/halls/<?= $eachEvent->event_guid ?>" data-event-guid="<?= $eachEvent->event_guid ?>" title="Click to book the Event <?= $eachEvent->event_title ?>" class="col-lg-3 col-md-6 mb-2 event-selector">
                                        <div class="card cursor">
                                            <div class="card-header text-success"><?= date("l jS F, Y", strtotime($eachEvent->event_date)) ?></div>
                                            <div class="card-body mouse-hover">
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
                                                <div class="mt-2 border-top text-gray-700">
                                                    <i class="fa fa-clock"></i>
                                                    <strong><?= $eachEvent->start_time ?> </strong> to <strong><?= $eachEvent->end_time ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="modal fade" id="eventDialogModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Provide your phone number</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group col-sm-12">
                                                <div class="input-group">
                                                    <input autocomplete="Off" value="<?= $session->loggedInUser ?>" class="form-control" placeholder="Please enter your phone number" minlength="9" maxlength="13" type="text" name="contact_number">
                                                </div>
                                            </div>
                                            <input name="event_guid" type="hidden">
                                            <input type="hidden" name="event_halls_guid">
                                        </div>
                                        <div style="width:100%" class="mb-2">
                                            <div class="col-lg-12 p-3">
                                                <button type="button" class="btn border btn-sm float-left btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-sm float-right btn-primary">Proceed</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        <?php } ?>

                        <?php /** If the user has visited the halls list panel */ if(confirm_url_id(2, "halls")) { ?>
                            <?php if(!$eventFound) {
                                // page was not found
                                // print the page not found error message
                                print '<div class="col-lg-5">';
                                print pageNotFound($baseUrl);
                                print '</div>';
                            } else {
                                /** 
                                 * First confirm that its a paid or free event. If paid then display a field
                                 * to enter the ticket serial number for validation
                                 */
                                if($eventData->is_payable) {
                                    $showTicketForm = true;
                                }
                                
                                /** 
                                 * If a ticket applies to this event and there is no validation yet
                                 * Then show the form to validate the ticket
                                 */
                                if((isset($showTicketForm) && empty($session->eventTicketValidated))){ ?>
                                <div class="col-lg-4 m-1 col-md-6 mt-3" id="validateTicket">
                                    <div class="mb-4 text-center">
                                        <h2 class="text-uppercase border-bottom border-cyan-soft"><?= $eventData->event_title ?></h2>
                                    </div>
                                    <form autocomplete="Off" action="<?= $baseUrl ?>api/tickets/validate" class="appForm" method="POST">
                                        <div class="form-group text-center">
                                            <label for="ticket_guid">Enter the Ticket Serial Number</label>
                                            <input type="text" name="ticket_guid" id="ticket_guid" class="form-control text-center text-uppercase" maxlength="20">
                                        </div>
                                        <div class="form-group text-center">
                                            <input type="hidden" value="<?= $eventId ?>" name="event_guid" class="event_guid">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Validate Ticket</button>
                                        </div>
                                    </form>
                                </div>
                                <?php } else {
                                    /** 
                                     * If the session for event validation was set 
                                     * then confirm if id in that session is equal to the current id 
                                     */
                                    if(isset($showTicketForm) && !empty($session->eventTicketValidated) && ($session->eventTicketValidatedId != $eventId)) {
                                        // show the error message for a page not found
                                        print '<div class="col-lg-5">';
                                        print pageNotFound($baseUrl);
                                        print '</div>';
                                    } else {
                                    ?>
                                    <div style="width:90%" class="mt-3 row">
                                        <div class="mb-2 col-lg-12 text-center">
                                            <h2 class="text-uppercase border-bottom border-cyan-soft">
                                                <strong><?= $eventData->event_title ?></strong>
                                                <br>
                                                <small style="font-size: 15px">
                                                    <i class="fa fa-calendar"></i> <?= date("jS F, Y", strtotime($eventData->event_date)) ?>
                                                    | <i class="fa fa-clock"></i> <?= $eventData->start_time ?> to <?= $eventData->end_time ?>
                                                </small>
                                            </h2>
                                        </div>
                                        <?php
                                        /** Create an object */
                                        $hallStd = (Object) [];
                                        $hallStd->client_guid = $thisAccount->client_guid;
                                        $hallStd->event_guid = $eventId;

                                        /** Halls booked to array */
                                        $hallsBooked = $bookingClass->stringToArray($eventData->user_halls_booked, ",");

                                        /** List the halls available to the user by looping through it   */
                                        foreach($eventData->event_halls as $eachHall) {

                                            /** Append to the object variable */
                                            $hallStd->hall_guid = $eachHall->guid;
                                            ?>
                                            <div class="col-lg-3 col-md-6 mb-2 cursor" onclick="window.location.href='<?= $baseUrl ?>reservation/<?= $theId ?>/book/<?= $eventId ?>/<?= $eachHall->guid ?>'">
                                                <div class="card halls-listing mouse-hover">
                                                    <?php if(in_array($eachHall->guid, $hallsBooked)) { ?>
                                                    <span class="booked" title="Hall has already been booked"><i class="fa text-success fa-check-circle"></i></span>
                                                    <?php } ?>
                                                    <div class="card-header">
                                                        <h3 class="text-gray-600"><i class="fa fa-building"></i> &nbsp; <?= $eachHall->hall_name; ?></h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <strong><?= ($eachHall->seats - $eventsObj->bookedCount($hallStd)); ?></strong> out of <strong><?= $eachHall->seats ?></strong> available seats
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                                <div style="width:90%" class="mt-3 mb-4 row">
                                    <div class="col-lg-12 text-right">
                                        <a href="<?= $baseUrl ?>reservation/<?= $theId ?>"><i class="fa fa-list"></i>    Go Back</a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>

                        <?php /** If the user has visited the booking panel */ if(confirm_url_id(2, "book")) { ?>
                            <?php if(!$eventFound) {
                                // print the page not found error message
                                print '<div class="col-lg-5">';
                                print pageNotFound($baseUrl);
                                print '</div>';
                            } elseif(!in_array($hallId, array_column($eventData->event_halls, "guid"))) {
                                // print the page not found error message
                                print '<div class="col-lg-5">';
                                print pageNotFound($baseUrl);
                                print '</div>';
                            } else {
                                /** Get the halls list */
                                $hallsList = array_column($eventData->event_halls, "guid");

                                /** Get the current hall key */
                                $hallKey = array_search($hallId, $hallsList);

                                /** Load the data at that key */
                                $hallData = $eventData->event_halls[$hallKey];
                                $hallConf = $hallData->configuration;

                                /** Settings passed */
                                $settingsPassed = true;

                                /** Confirm that the user has not yet reached the number of booking to be done */
                                if(($eventData->user_booking_count == $eventData->maximum_multiple_booking) || isset($_GET["history"])) {
                            ?>
                            <div style="width:90%" class="mt-3 mb-4  row justify-content-center">
                                <div class="mt-2 bg-white p-3" style="box-shadow:0px 1px 2px #000">
                                    <div class="mb-2 col-lg-12 text-center">
                                        <h5 class="text-uppercase border-bottom border-cyan-soft">
                                            <div>
                                                <strong><?= $eventData->event_title ?></strong>
                                            </div>                                           
                                            <div class="mt-2 pb-2">
                                                <small style="font-size: 15px">
                                                    <i class="fa fa-calendar"></i> <?= date("jS F, Y", strtotime($eventData->event_date)) ?>
                                                    | <i class="fa fa-clock"></i> <?= $eventData->start_time ?> to <?= $eventData->end_time ?>
                                                </small>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p>You have reserved <?= $eventData->user_booking_count ?> out of <?= $eventData->maximum_multiple_booking ?> seats for this event with the provided contact number.</p>
                                        <h4 class="text-center">Booking History</h4>
                                        <div class="table-responsive">
                                            <table style="font-size:15px" class="table nowrap table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Name</th>
                                                        <th class="text-left">Seat</th>
                                                        <th>Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    /** Load the seats booked using this contact number */
                                                    $seatsBooked = $booking->prepare("
                                                        SELECT a.*,
                                                            (
                                                                SELECT b.hall_name FROM events_halls_configuration b
                                                                WHERE a.hall_guid = b.hall_guid AND b.event_guid = a.event_guid
                                                            ) AS hall_name,
                                                            (
                                                                SELECT b.configuration FROM events_halls_configuration b
                                                                WHERE a.hall_guid = b.hall_guid AND b.event_guid = a.event_guid
                                                            ) AS configuration
                                                        FROM events_booking a 
                                                        WHERE a.event_guid = ? AND a.created_by = ?
                                                    ");
                                                    $seatsBooked->execute([$eventId, $session->loggedInUser]);

                                                    /** Loop through the list */
                                                    while($result = $seatsBooked->fetch(PDO::FETCH_OBJ)) { ?>
                                                    <tr>
                                                        <td class="text-left"><?= $result->fullname ?></td>
                                                        <td class="text-left">
                                                            <strong>Hall</strong>: <?= $result->hall_name ?><br>
                                                            <strong>Seat</strong>: <?= $result->seat_guid ?>
                                                        </td>
                                                        <td><?= $result->id ?></td>
                                                    </tr>    
                                                    <?php }?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>

                                        <?php if($eventData->user_booking_count == $eventData->maximum_multiple_booking) { ?>
                                        <a href="<?= $baseUrl ?>reservation/<?= $theId ?>">
                                            Change <?= ($eventData->is_payable) ? "Ticket" : "Contact" ?>
                                        </a>
                                        <?php } else { ?>
                                        <a href="<?= $baseUrl ?>reservation/<?= $theId ?>/book/<?= $eventId ?>/<?= $hallId ?>">
                                            Book Seat
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div style="width:90%" class="mt-3 mb-4 row">
                                <div class="col-lg-9 mb-3 col-md-9" >
                                    <div class="mb-2 col-lg-12 text-center">
                                        <h4 class="text-uppercase border-bottom border-cyan-soft">
                                            <strong><?= $hallData->hall_name ?></strong>
                                        </h4>
                                    </div>
                                    <div style="padding:1rem" class="slim-scroll seats-table">
                                        <table class="p-0 m-0">
                                            <?php
                                            // start the counter
                                            $counter = 0;

                                            // draw the items
                                            for($i = 1; $i < $hallData->rows + 1; $i++) {
                                                print "<tr>\n";
                                                for($ii = 1; $ii < $hallData->columns + 1; $ii++) {
                                                    // label
                                                    $label = "{$i}_{$ii}";

                                                    // print header
                                                    print "<td data-label=\"{$label}\" class=\"width\">";

                                                    // confirm that it has not been removed
                                                    if(!in_array($label, $hallConf["removed"])) {
                                                        /** list the items */
                                                        print "<div data-label=\"{$label}\" ".(in_array($label, $hallConf["blocked"]) ? "" : null)." id=\"seat-item_{$label}\" class=\"p-2 mt-1 seat-item ".(in_array($label, $hallConf["blocked"]) ? "unavailable" : null)."\">
                                                            <span data-label=\"{$label}\" class=\"booking-item\">".(isset($hallConf["labels"][$label]) ? $hallConf["labels"][$label] : $counter)."</span>
                                                        </div>";
                                                    }
                                                    print "</td>\n";
                                                    // increment the counter
                                                    $counter++;
                                                }
                                                print "</tr>";
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-3 mt-2 col-md-3">
                                    <div class="mb-2 col-lg-12 text-center">
                                        <h6 class="text-uppercase border-bottom border-cyan-soft">
                                            <div>
                                                <strong><?= $eventData->event_title ?></strong>
                                            </div>                                           
                                            <div class="mt-2 pb-2">
                                                <small style="font-size: 15px">
                                                    <i class="fa fa-calendar"></i> <?= date("jS F, Y", strtotime($eventData->event_date)) ?>
                                                    | <i class="fa fa-clock"></i> <?= $eventData->start_time ?> to <?= $eventData->end_time ?>
                                                </small>
                                            </div>
                                        </h6>
                                    </div>
                                    <div class="mb-4 mt-3">
                                        <ul class="legend">
                                            <li>
                                                <div class="available">&nbsp;</div>
                                                <span>Available</span>
                                            </li>
                                            <li>
                                                <div class="selected">&nbsp;</div>
                                                <span>Selected</span>
                                            </li>
                                            <li>
                                                <div class="unavailable">&nbsp;</div>
                                                <span>Unavailable</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mt-4">
                                        <?php if($eventData->user_booking_count) { ?>
                                        <a href="<?= $baseUrl ?>reservation/<?= $theId ?>/book/<?= $eventId ?>/<?= $hallId ?>?history">
                                            View Booked Seats
                                        </a>
                                        <?php } ?>
                                    </div>
                                    <div class="mt-4 selected-seats">
                                        <h4>Selected Seats (<span>0</span>)</h4>
                                        <div class="selected-seats-content"></div>
                                        <div class="form-group mt-3 text-right">
                                            <button class="btn hidden btn-success btn-sm reserve-seat">Reserve</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div style="width:90%" class="mt-3 mb-4 row">
                                <div class="col-lg-12 text-center">
                                    <a href="<?= $baseUrl ?>reservation/<?= $theId ?>/halls/<?= $eventId ?>"><i class="fa fa-list"></i>  Go Back</a>
                                </div>
                            </div>

                            <?php } ?>
                        <?php } ?>

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
        <script>var baseUrl = "<?= $baseUrl ?>";</script>
        <?php if(isset($settingsPassed)) { ?>
        <script>
            var abbr = "<?= $theId ?>",
                maximumBooking = <?= $eventData->maximum_multiple_booking - $eventData->user_booking_count ?>,
                event_guid = "<?= $eventId ?>",
                hall_guid = "<?= $hallId ?>",
                hall_guid_key = <?= $hallKey ?>,
                bookingSelectedItems = new Array();
        </script>
        <?php } ?>
        <script src="<?= $baseUrl ?>assets/js/tojson.js"></script>
        <script src="<?= $baseUrl ?>assets/js/reserve.js"></script>
        <sb-customizer project="sb-admin-pro"></sb-customizer>
    </body>
</html>
