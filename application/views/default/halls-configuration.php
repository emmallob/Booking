<?php 
$page_title = "Configure Hall Seats";

require "headtags.php";

$hallId = (confirm_url_id(1)) ? xss_clean($SITEURL[1]) : null;

$itemFound = false;
$removedSeats = [];
$blockedSeats = [];

$counter = 1;

// if the hall was found
if($hallId) {

    // load the hall data
    $hallData = $bookingClass->pushQuery("*", "halls", "hall_guid='{$hallId}' && client_guid='{$session->clientId}'");
    
    // confirm that data was found
    if(!empty($hallData)) {
        // set the found state
        $itemFound = true;

        // set the variables
        $hallData = $hallData[0];

        // reset the data
        $hallConf = !empty($hallData->configuration) ? json_decode($hallData->configuration, true) : [];
        
        // set some additional variables
        if(!empty($hallConf)) {
            $removedSeats = $hallConf['removed'];
            $blockedSeats = $hallConf['blocked'];
            $seatLabels = $hallConf['labels'];
        }
    }

}
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
                        <a href="<?= $baseUrl ?>halls-edit/<?= $hallId ?>" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i>&nbsp;Update Hall</a>
                        <a href="<?= $baseUrl ?>halls" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i>&nbsp;List Halls</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <?php if(!$itemFound || !$accessObject->hasAccess("configure", "halls")) { ?>
                    <?= pageNotFound($baseUrl) ?>
                <?php } else { ?>
                <div class="row hall-configuration">
                    <div class="col-lg-12">
                        <div class="justify-content-around">
                            <div class="col-lg-5 p-0 m-0 col-md-8">
                                <div class="form-group">
                                    <label for="hall_name">Hall Name <span class="required">*</span></label>
                                    <input type="text" value="<?= $hallData->hall_name ?>" name="hall_name" disabled id="hall_name" class="form-control">
                                </div>
                            </div>
                            <div>
                                <div class="seats-table slim-scroll">
                                    <?= form_loader() ?>
                                    <table class="p-0 m-0">
                                    <?php
                                    // draw the items
                                    for($i = 1; $i < $hallData->rows + 1; $i++) {
                                        print "<tr>\n";
                                        for($ii = 1; $ii < $hallData->columns + 1; $ii++) {
                                            // label
                                            $label = "{$i}_{$ii}";

                                            // print header
                                            print "<td data-label=\"{$label}\" class=\"width\">";

                                            // confirm that it has not been removed
                                            if(!in_array($label, $removedSeats)) {
                                                print "<div data-label=\"{$label}\" id=\"seat-item_{$label}\" class=\"p-2 mt-1 seat-item border ".(in_array($label, $blockedSeats) ? "blocked" : null)."\">
                                                    {$counter}
                                                    <input value='".(isset($seatLabels[$label]) ? $seatLabels[$label] : null)."' class=\"form-control p-0\" data-label=\"{$label}\" ".(in_array($label, $blockedSeats) ? "disabled='disabled'" : null).">
                                                </div>";
                                            }
                                            print "</td>\n";
                                            // increment the counter
                                            $counter++;
                                        }
                                        print "</tr>";
                                    }
                                    ?>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="hall_guid" value="<?= $hallId ?>">
                                    <div class="row mt-3 p-0 text-center jusstify-content-around">
                                        <div class="mt-2">
                                            <button data-toggle="tooltip" type="submit" class="btn btn-outline-success" title="Save the current settings"><i class="fa fa-save"></i> &nbsp; Save</button>
                                            <button data-toggle="tooltip" type="remove" class="btn btn-outline-warning" title="Remove all selected Seats">Remove Seats</button>
                                            <button data-toggle="tooltip" type="block" class="btn btn-outline-danger" title="Block selected Seats">Block Seats</button>
                                            <button data-toggle="tooltip" type="reset" data-item-id="<?= $hallId ?>" class="btn btn-outline-default reset-hall border" title="Reset hall">Reset Hall</button>
                                        </div>
                                        <div style="width:300px;" class="text-right mt-2">
                                            <button type="unblock" class="btn hidden btn-outline-secondary">Unblock</button>
                                            <button type="restore" class="btn hidden btn-outline-primary">Restore</button>
                                        </div>
                                    </div>
                                </div>  
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