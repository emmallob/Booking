<?php 
$page_title = "Update Event";

require "headtags.php";

$itemFound = false;

$eventsId = (confirm_url_id(1)) ? xss_clean($SITEURL[1]) : null;

// if the department was found
if($eventsId) {

    // load the hall data
    $eventData = $bookingClass->pushQuery(
        "a.*,
            (
                SELECT COUNT(*) FROM events_booking b WHERE b.event_guid = a.event_guid AND b.deleted = '0'
            ) AS booked_count,
            (
                SELECT b.department_name FROM departments b WHERE b.department_guid = a.department_guid
            ) AS department_name,
            (
                SELECT GROUP_CONCAT(b.hall_guid) FROM events_halls_configuration b WHERE b.event_guid = a.event_guid
            ) AS event_halls", 
        "events a", 
        "a.event_guid='{$eventsId}' && a.client_guid='{$session->clientId}' AND a.deleted='0'"
    );
    // confirm that data was found
    if(!empty($eventData)) {
        
        // set the found state
        $itemFound = true;

        // set the variables
        $eventData = $eventData[0];
        $hallsList = $bookingClass->stringToArray($eventData->event_halls);

        $eventData->booking_start_time = date("Y-m-d\TH:i:s", strtotime($eventData->booking_start_time));
        $eventData->booking_end_time = date("Y-m-d\TH:i:s", strtotime($eventData->booking_end_time));

        $eventAttachments = $bookingClass->pushQuery("a.*", "events_media a", "a.event_guid='{$eventsId}' && a.client_guid='{$session->clientId}' AND a.status='1'");
    }

}
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="box"></i></div>
                    <span><?= $page_title ?></span>
                </h1>
                <ol class="breadcrumb mt-4 mb-0">
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>events">Events</a></li>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n10">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8"></div>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>events" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i>&nbsp;List Events</a>
                        <?php if($itemFound) { ?>
                        <a href="<?= $baseUrl ?>events-insight/<?= $eventsId ?>" class="btn btn-sm btn-outline-success"><i class="fa fa-chart-bar"></i> &nbsp; Booked List</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <?php if(!$itemFound || !$accessObject->hasAccess("update", "events")) { ?>
                <?= pageNotFound($baseUrl) ?>
            <?php } else { ?>
                <form autocomplete="Off" id="saveRecordWithAttachment" action="<?= $baseUrl ?>api/events/update" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <?= form_loader() ?>
                        <div class="col-lg-8 col-md-8">
                            <div class="form-group">
                                <label for="event_title">Event Title <span class="required">*</span></label>
                                <input value="<?= $eventData->event_title ?>" type="text" name="event_title" id="event_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="department_guid">Department / Organization</label>
                                <select name="department_guid" id="department_guid" class="form-control selectpicker">
                                    <option value="null">Select Department or Group or Organization</option>
                                    <?php 
                                    // get the halls list
                                    $items_list = $bookingClass->pushQuery("department_name, department_guid", "departments", "client_guid='{$session->clientId}' AND status='1'");
                                    foreach($items_list as $eachItem) {
                                        print "<option ".(($eventData->department_guid == $eachItem->department_guid) ? "selected" : null)." value='{$eachItem->department_guid}'>{$eachItem->department_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="event_date">Event Date <span class="required">*</span></label>
                                <input type="date" value="<?= $eventData->event_date ?>" name="event_date" id="event_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="start_time">Start Time <span class="required">*</span></label>
                                <input value="<?= $eventData->start_time ?>" type="time" name="start_time" id="start_time" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="end_time">End Time <span class="required">*</span></label>
                                <input type="time" value="<?= $eventData->end_time ?>" name="end_time" id="end_time" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="bookink_starttime">Booking Start Time <span class="required">*</span></label>
                                <input type="datetime-local" value="<?= $eventData->booking_start_time ?>" name="booking_starttime" id="booking_starttime" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="booking_endtime">Booking End Time <span class="required">*</span></label>
                                <input type="datetime-local" value="<?= $eventData->booking_end_time ?>" name="booking_endtime" id="booking_endtime" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-group">
                                <label for="halls_guid">Available Halls</label>
                                <select name="halls_guid" id="halls_guid" multiple class="form-control selectpicker">
                                    <option value="null">Select Halls for this Event</option>
                                    <?php 
                                    // get the halls list
                                    $items_list = $bookingClass->pushQuery("hall_name, hall_guid", "halls", "client_guid='{$session->clientId}' AND status='1'");
                                    foreach($items_list as $eachItem) {
                                        print "<option ".((in_array($eachItem->hall_guid, $hallsList)) ? "selected" : null)." value='{$eachItem->hall_guid}'>{$eachItem->hall_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="cards">
                                <div class="form-group">
                                    <label for="description">Event Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3"><?= $eventData->description ?></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <?php 
                                    // event state configuration
                                    if($eventData->state == "pending") {
                                        print "<span class='badge badge-primary'>Event is Pending</span>";
                                    } elseif($eventData->state == "in-progress") {
                                        print "<span class='badge badge-success'>Event is In Progress</span>";
                                    } elseif($eventData->state == "cancelled") {
                                        print "<span class='badge badge-danger'>Event has been Cancelled</span>";
                                    } else {
                                        print "<span class='badge badge-warning'>Event is Past</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="event_is_payable">Is Payable</label>
                                            <select name="event_is_payable" id="event_is_payable" class="form-control selectpicker">
                                                <option <?= (!$eventData->is_payable) ? "selected" : null ?> value="0">Free Event</option>
                                                <option <?= ($eventData->is_payable) ? "selected" : null ?> value="1">Paid Event</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cards <?= (!$eventData->is_payable) ? "hidden" : null ?>">
                                        <div class="form-group">
                                            <label for="ticket_guid">Event Ticket <i title="Select tickets that will be sold for this event" data-toggle="tooltip" class="fa fa-info"></i></label>
                                            <select name="ticket_guid" id="ticket_guid" class="form-control selectpicker ticket_guid">
                                                <option value="null">Select Event Ticket</option>
                                                <?php 
                                                // get the halls list
                                                $items_list = $bookingClass->pushQuery("ticket_title, ticket_guid", "tickets", "client_guid='{$session->clientId}' AND status='1'");
                                                foreach($items_list as $eachItem) {
                                                    print "<option ".(($eventData->ticket_guid == $eachItem->ticket_guid) ? "selected" : null)." value='{$eachItem->ticket_guid}'>{$eachItem->ticket_title}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="multiple_booking">Multiple Booking</label>
                                            <select  name="multiple_booking" id="multiple_booking" class="form-control selectpicker">
                                                <option <?= (!$eventData->allow_multiple_booking) ? "selected" : null ?> value="0">Disallow Multiple Booking</option>
                                                <option <?= ($eventData->allow_multiple_booking) ? "selected" : null ?> value="1">Allow Multiple Booking</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cards <?= (!$eventData->allow_multiple_booking) ? "hidden" : null ?>">
                                        <div class="form-group">
                                            <label for="maximum_booking">Maximum Booking <i title="Maximum number of times that a user can use a single contact number to book" data-toggle="tooltip" class="fa fa-info"></i></label>
                                            <input type="number" value="<?= $eventData->maximum_multiple_booking ?>" name="maximum_booking" value="3" id="maximum_booking" max="10" class="form-control">
                                        </div>
                                    </div>
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="attachment">Event Attachment <small><em>(Attach multiple images or video)</em></small></label>
                                            <input type="file" name="attachment[]" multiple id="attachment" class="form-control" accept="image/x-png,image/gif,image/jpeg,video/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <div class="row text-center attachment">
                                        <?php 
                                        if(!empty($eventAttachments)) {
                                            // loop through each item
                                            foreach($eventAttachments as $eachMedia) {
                                                // convert to an object
                                                $media = json_decode($eachMedia->media_data);
                                                // get the media and display
                                                $media_content = "<div data-item-id='{$eventsId}_{$eachMedia->id}' class='col-lg-4 mb-3 col-md-6'>";
                                                if(in_array($media->type, ["video/mp4"])) {
                                                    $media_content .= "<video height='200px' class='border' width='100%' src='{$baseUrl}{$media->media}' controls='true'></video>";
                                                } else {
                                                    $media_content .= "<img height='200px' class='border' width='100%' src='{$baseUrl}{$media->media}'>";
                                                }
                                                $media_content .= "<div>
                                                    <a href='javascript:void(0)' data-title='Delete Event Media' data-item='event-media' data-item-id='{$eventsId}_{$eachMedia->id}' class='btn btn-outline-danger delete-item'><i class='fa fa-trash'></i></a>
                                                </div>";
                                                $media_content .= "</div>";

                                                // print the media item
                                                print $media_content;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12"><hr></div>
                        <?php if(in_array($eventData->state, ["pending"])) { ?>
                        <div class="col-lg-12 text-right">
                            <input type="hidden" name="event_guid" value="<?= $eventsId ?>">
                            <button class="btn btn-sm btn-outline-success"><i class="fa fa-save"></i>&nbsp; Save Record</button>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            <?php } ?>
            </div>
        </div>
    </div>
</main>
<?php require "foottags.php"; ?>