<?php 
$page_title = "Booking History";

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
    }

}
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="sunset"></i></div>
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
    <div class="container-fluid event-guid mt-n10" data-event-guid="<?= $eventsId ?>">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8">
                        List of all members who have booked for the event
                    </div>
                    <?php if($itemFound) { ?>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="javascript:void(0)" data-event-guid="<?= $eventsId ?>" class="btn btn-sm download-file btn-outline-danger"><i class="fa fa-file-pdf"></i></a>
                        <a href="javascript:void(0)" data-event-guid="<?= $eventsId ?>" class="btn btn-sm download-file btn-outline-success"><i class="fa fa-file-excel"></i></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body">
                <?php if(!$itemFound || !$accessObject->hasAccess("update", "events")) { ?>
                    <?= pageNotFound($baseUrl) ?>
                <?php } else { ?>
                    <?= form_loader() ?>
                    <div class="row" id="bookedEventDetails">
                        <div class="col-lg-6 mb-5 col-md-6">
                            <label for="event_title">Event Title</label>
                            <input type="text" class="form-control" name="event_title">
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <label for="event_date">Event Date</label>
                            <input type="text" name="event_date" id="event_date" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <label for="event_time">Event Time</label>
                            <input type="text" name="event_time" id="event_time" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="datatable table-responsive">
                                <table width="100%" class="table bookedEventList table-hover" data-toggle="datatable">
                                    <thead>
                                        <th width="6%">&#8470;</th>
                                        <th>Hall</th>
                                        <th>Fullname</th>
                                        <th>Contact Number</th>
                                        <th>Address</th>
                                        <th>Seat</th>
                                        <th width="10%"></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>