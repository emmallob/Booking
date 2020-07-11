<?php 
$page_title = "Booking History";

require "headtags.php";
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
    <div class="container-fluid event-guid mt-n10" data-event-guid="<?= (confirm_url_id(1) ? xss_clean($SITEURL[1]) : null) ?>">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8">
                        List of all members who have booked for the event
                    </div>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="javascript:void(0)" class="btn btn-sm download-file btn-outline-danger"><i class="fa fa-file-pdf"></i></a>
                        <a href="javascript:void(0)" class="btn btn-sm download-file btn-outline-success"><i class="fa fa-file-excel"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if(!$accessObject->hasAccess("list", "events")) { ?>
                    <?= pageNotFound($baseUrl) ?>
                <?php } else { ?>
                    <?= form_loader() ?>
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
                <?php } ?>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>