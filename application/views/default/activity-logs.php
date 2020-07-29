<?php 
$page_title = "Activity Logs";

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
                        The list of activities logs
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="datatable table-responsive">
                        <table width="100%" class="table activityLogs table-hover" data-toggle="datatable">
                            <thead>
                                <th width="6%">#</th>
                                <th width="10%">Page</th>
                                <th>Description</th>
                                <th width="25%">User Agent</th>
                                <th width="15%" style="text-align:left">Date Created</th>
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