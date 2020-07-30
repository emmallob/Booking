<?php 
$page_title = "Tickets Sold";

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
    <div class="container-fluid mt-n10">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8">
                        The list of tickets that have been sold out
                    </div>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>tickets-sell" class="btn btn-sm btn-outline-primary"><i class="fa fa-award"></i>&nbsp;Sell Ticket</a>
                        <a href="<?= $baseUrl ?>tickets-report" class="btn btn-sm btn-outline-success"><i class="fa fa-chart-bar"></i>&nbsp;Generate Report</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= form_loader() ?>
                <div class="row">
                    <div class="datatable table-responsive">
                        <table width="100%" class="table ticketsSoldList table-hover" data-toggle="datatable">
                            <thead>
                                <th width="6%">#</th>
                                <th width="15%">Fullname</th>
                                <th>Contact</th>
                                <th>Email Address</th>
                                <th width="23%">Event Title</th>
                                <th>Ticket</th>
                                <th>Amount</th>
                                <th width="15%" style="text-align:left">Date Created</th>
                                <th width="10%">Status</th>
                                <th></th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>var user_id = '<?= $session->userId ?>';</script>
</main>
<?php require "foottags.php"; ?>