<?php 
$page_title = "Update Hall";

require "headtags.php";

$itemFound = false;

$hallId = (confirm_url_id(1)) ? xss_clean($SITEURL[1]) : null;

// if the department was found
if($hallId) {

    // load the hall data
    $hallData = $bookingClass->pushQuery("*", "halls", "hall_guid='{$hallId}' && client_guid='{$session->clientId}' AND deleted='0'");
    
    // confirm that data was found
    if(!empty($hallData)) {
        
        // set the found state
        $itemFound = true;

        // set the variables
        $hallData = $hallData[0];

    }

}
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="home"></i></div>
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
                <?php if(!$itemFound || !$accessObject->hasAccess("update", "halls")) { ?>
                    <?= pageNotFound($baseUrl) ?>
                <?php } else { ?>
                <form autocomplete="Off" action="<?= $baseUrl ?>api/halls/update" method="POST" class="appForm">
                    <div class="row">
                        <?= form_loader() ?>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="hall_name">Hall Name <span class="required">*</span></label>
                                        <input type="text" value="<?= $hallData->hall_name; ?>" name="hall_name" id="hall_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="hall_rows">Hall Rows <span class="required">*</span></label>
                                        <input type="number" value="<?= $hallData->rows; ?>" min="1" name="hall_rows" id="hall_rows" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="hall_columns">Hall Columns <span class="required">*</span></label>
                                        <input type="number" value="<?= $hallData->columns; ?>" min="1" name="hall_columns" id="hall_columns" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="temp_seats">Available Seats</label>
                                        <input type="text" disabled value="<?= $hallData->seats; ?>" name="temp_seats" name="temp_seats" id="temp_seats" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cards">
                                        <div class="form-group">
                                            <label for="description">Hall Facilities</label>
                                            <textarea name="description" data-editor="summernote" id="description" class="form-control" cols="30" rows="4"><?= $hallData->facilities; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12"><hr></div>
                            <div class="col-lg-12">
                                <input type="hidden" name="hall_guid" value="<?= $hallData->hall_guid; ?>">
                                <a href="<?= $baseUrl ?>halls-configuration/<?= $hallId ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-sitemap"></i> &nbsp; Configure Hall Seats</a>
                                <button class="btn float-right btn-sm btn-outline-success"><i class="fa fa-save"></i>&nbsp; Save Record</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>