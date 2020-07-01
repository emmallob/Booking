<?php 
$page_title = "Add Hall";

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
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>halls">Halls</a></li>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n10">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8"></div>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>halls" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i>&nbsp;List Halls</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <form action="<?= $baseUrl ?>api/halls/add" method="POST" >
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="hall_name">Hall Name <span class="required">*</span></label>
                                        <input type="text" name="hall_name" id="hall_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="hall_rows">Hall Rows <span class="required">*</span></label>
                                        <input type="number" min="1" name="hall_rows" id="hall_rows" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="hall_columns">Hall hall_Columns <span class="required">*</span></label>
                                        <input type="number" min="1" name="hall_columns" id="hall_columns" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="temp_seats">Estimated Seats</label>
                                        <input type="text" disabled name="temp_seats" name="temp_seats" id="temp_seats" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="description">Hall Facilities</label>
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12"><hr></div>
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-sm btn-outline-success"><i class="fa fa-save"></i>&nbsp; Save Record</button>
                            </div>
                        </div>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>