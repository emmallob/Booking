<?php 
$page_title = "Events";

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
                        List of all Events
                    </div>
                    <?php if($accessObject->hasAccess("add", "events")) { ?>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>events-add" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus"></i>&nbsp;Add</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body">
                <?php if(!$accessObject->hasAccess("list", "events")) { ?>
                    <?= pageNotFound($baseUrl) ?>
                <?php } else { ?>
                    <?= form_loader() ?>
                    <div class="datatable table-responsive">
                        <table width="100%" class="table eventsList table-hover" data-toggle="datatable">
                            <thead>
                                <th width="6%">&#8470;</th>
                                <th>Event Title</th>
                                <th width="12%">Event Date</th>
                                <th>Summary Details</th>
                                <th width="12%">&#8470; Booked</th>
                                <th width="14%">&#8470; of Seats</th>
                                <th width="10%">Status</th>
                                <th width="15%"></th>
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