<?php 
$page_title = "Departments";

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
                        List of Departments/Organizations within the institution.
                    </div>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>departments-add" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus"></i>&nbsp;Add</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="datatable table-responsive">
                    <table class="table table-hover departmentsList" data-toggle="datatable">
                        <thead>
                            <th width="6%">&#8470;</th>
                            <th width="23%">Department Name</th>
                            <th>Description</th>
                            <th width="13%">Pending Events</th>
                            <th width="13%">&#8470; of Events</th>
                            <th width="10%"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>