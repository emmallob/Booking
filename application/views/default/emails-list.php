<?php 
$page_title = "Communication > Emails";

require "headtags.php";
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i class="fa fa-comments"></i></div>
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
                    <div class="col-lg-8 col-md-8"><button class='btn btn-outline-success btn-sm' data-request='execute-emails'>Execute Pending Emails</button> <span class="execute-loader"></span></div>
                    <?php if($accessObject->hasAccess("manage", "communications")) { ?>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>emails-compose" class="btn btn-sm btn-outline-primary"><i class="fa fa-reply"></i>&nbsp;Send Mail</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?= form_loader() ?>
            <?php if(!$accessObject->hasAccess("manage", "communications")) { ?>
                <div class="card-body">
                    <?= pageNotFound($baseUrl) ?>
                </div>
            <?php } else { ?>
                <div class="card-body">
                    <div class="btn-toolbar row justify-content-between" role="toolbar">
                        <div class="btn-group action-buttons">
                            <span class="active-msg"></span>
                        </div>
                        <div class="float-right d-flex">
                            <div class="btn-group ml-1">
                                <button type="button" class="btn btn-outline-success hidden go-back">
                                    <i class="fas fa-arrow-alt-circle-left"></i> Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body mails-listing hidden table-responsive">
                    <table data-none="No mails available to display." class="table dataTable emailsList table-bordered">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th class="text-left">Subject</th>
                                <th>Message</th>
                                <th width="17%">Date</th>
                                <th width="12%"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="mails-content"></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>