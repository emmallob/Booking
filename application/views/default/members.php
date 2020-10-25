<?php 
$page_title = "Members";

require "headtags.php";
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="users"></i></div>
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
                        List of all Members
                    </div>
                    <?php if($accessObject->hasAccess("add", "members")) { ?>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>members-add" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus"></i>&nbsp;Add</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body">
                <?php if(!$accessObject->hasAccess("list", "members")) { ?>
                    <?= pageNotFound($baseUrl) ?>
                <?php } else { ?>
                    <?= form_loader() ?>
                    <div class="datatable table-responsive">
                        <table width="100%" class="table membersList table-hover" data-toggle="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>UNIQUEID</th>
                                    <th>FULLNAME</th>
                                    <th>CLASS</th>
                                    <th>GENDER</th>
                                    <th>DOB</th>
                                    <th>CONTACT</th>
                                    <th>EMAIL</th>
                                    <th>ACTION</th>
                                </tr>
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