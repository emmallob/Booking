<?php 
$page_title = "Sell Tickets";

require "headtags.php";
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="airplay"></i></div>
                    <span><?= $page_title ?></span>
                </h1>
                <ol class="breadcrumb mt-4 mb-0">
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n10" id="ticketsManager">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8">
                        Sell out Tickets to Audience
                    </div>
                </div>
            </div>
            <div class="card-body">
            <?php if(!$accessObject->hasAccess("sell", "tickets")) { ?>
                <?= pageNotFound($baseUrl) ?>
            <?php } else { ?>
                <?= form_loader() ?>
                <form autocomplete="Off" action="<?= $baseUrl ?>api/tickets/sell" method="POST" class="appForm">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="cards">
                                <div class="form-group">
                                    <label for="event_guid">Select Event to Sell Ticket <span class="required">*</span></label>
                                    <select name="event_guid" id="event_guid" class="form-control selectpicker">
                                        <option value="null">Select Event</option>
                                    </select>
                                </div>
                            </div>
                            <div class="cards">
                                <div class="form-group">
                                    <label for="ticket_guid">Select The Ticket <span class="required">*</span></label>
                                    <select name="ticket_guid" id="ticket_guid" class="form-control selectpicker">
                                        <option value="null">Select Ticket</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="fullname">Fullname <span class="required">*</span></label>
                                <input type="text" name="fullname" id="fullname" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact Number <span class="required">*</span></label>
                                <input type="text" maxlength="32" name="contact" id="contact" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="sample-data"></div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12 text-right">
                            <button type="submit" class="btn btn-outline-success btn-sm">Sell Ticket</button>
                        </div>
                    </div>
                </form>
            <?php } ?>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>