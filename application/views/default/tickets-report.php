<?php 
$page_title = "Tickets Report";

require "headtags.php";
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i class="fa fa-chart-bar"></i></div>
                    <span><?= $page_title ?></span>
                </h1>
                <ol class="breadcrumb mt-4 mb-0">
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n10">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8">
                        Generate reports of sold tickets
                    </div>
                    <?php if($accessObject->hasAccess("sell", "tickets")) { ?>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>tickets-list" class="btn btn-sm btn-outline-success"><i class="fa fa-list"></i> &nbsp; Sold Tickets</a>
                        <a href="<?= $baseUrl ?>tickets-sell" class="btn btn-sm btn-outline-primary"><i class="fa fa-award"></i> &nbsp; Sell</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body">
            <?php if(!$accessObject->hasAccess("list", "tickets")) { ?>
                <?= pageNotFound($baseUrl) ?>
            <?php } else { ?>
                <?= form_loader() ?>
                <div class="datatable table-responsive">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="ticket_status">Ticket Status</label>
                                <select name="ticket_status" id="ticket_status" class="form-control selectpicker">
                                    <option value="all">All Sold Tickets</option>
                                    <option value="pending">Pending</option>
                                    <option value="used">Used</option>
                                    <option value="invalid">Invalid</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="agent">Agent</label>
                                <select name="agent" id="agent" class="form-control selectpicker">
                                    <option value="all">All Agents</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>