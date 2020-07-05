<?php 
$page_title = "Add Event";

require "headtags.php";
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
    <div class="container-fluid mt-n10" id="eventsManager">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8"></div>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>events" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i>&nbsp;List Events</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <?php if(!$accessObject->hasAccess("add", "events")) { ?>
                <?= pageNotFound($baseUrl) ?>
            <?php } else { ?>
                <form autocomplete="Off" action="<?= $baseUrl ?>api/events/add" method="POST" class="appForm" enctype="multipart/form-data">
                    <div class="row">
                        <?= form_loader() ?>
                        <div class="col-lg-8 col-md-8">
                            <div class="form-group">
                                <label for="event_title">Event Title <span class="required">*</span></label>
                                <input type="text" name="event_title" id="event_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="department_guid">Department / Organization</label>
                                <select name="department_guid" id="department_guid" class="form-control selectpicker">
                                    <option value="null">Select Department or Group or Organization</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="event_date">Event Date <span class="required">*</span></label>
                                <input type="date" name="event_date" id="event_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="start_time">Start Time <span class="required">*</span></label>
                                <input type="time" name="start_time" id="start_time" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="end_time">End Time <span class="required">*</span></label>
                                <input type="time" name="end_time" id="end_time" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="bookink_starttime">Booking Start Time <span class="required">*</span></label>
                                <input type="datetime-local" name="booking_starttime" id="booking_starttime" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="booking_endtime">Booking End Time <span class="required">*</span></label>
                                <input type="datetime-local" name="booking_endtime" id="booking_endtime" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-group">
                                <label for="halls_guid">Available Halls</label>
                                <select name="halls_guid" id="halls_guid" multiple class="form-control selectpicker">
                                    <option value="null">Select Halls for this Event</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="event_is_payable">Is Payable</label>
                                            <select name="event_is_payable" id="event_is_payable" class="form-control selectpicker">
                                                <option value="0">Free Event</option>
                                                <option value="1">Paid Event</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cards hidden">
                                        <div class="form-group">
                                            <label for="ticket_guid">Event Ticket <i title="Select tickets that will be sold for this event" data-toggle="tooltip" class="fa fa-info"></i></label>
                                            <select name="ticket_guid" id="ticket_guid" class="form-control selectpicker2 ticket_guid">
                                                <option value="null">Select Event Ticket</option>
                                                <option data-item="add_ticket" value="add-new">Add Ticket</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="multiple_booking">Multiple Booking</label>
                                            <select name="multiple_booking" id="multiple_booking" class="form-control selectpicker">
                                                <option value="0">Disallow Multiple Booking</option>
                                                <option value="1">Allow Multiple Booking</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cards hidden">
                                        <div class="form-group">
                                            <label for="maximum_booking">Maximum Booking <i title="Maximum number of times that a user can use a single contact number to book" data-toggle="tooltip" class="fa fa-info"></i></label>
                                            <input type="number" name="maximum_booking" value="3" id="maximum_booking" max="10" class="form-control">
                                        </div>
                                    </div>
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="attachment">Event Attachment <small><em>(Attach an image or video)</em></small></label>
                                            <input type="file" name="attachment" id="attachment" class="form-control" accept="image/x-png,image/gif,image/jpeg,video/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="description">Event Description</label>
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="7"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12"><hr></div>
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-sm btn-outline-success"><i class="fa fa-save"></i>&nbsp; Save Record</button>
                        </div>
                    </div>
                </form>
            <?php } ?>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>