<?php
// set the page title
$page_title = "Account Configuration";

global $usersClass, $session, $bookingClass, $userId;

// fetch the perfect brand id for the facebook page to display
require_once 'headtags.php';

$manageAccount = $accessObject->hasAccess('manage', 'account');

// this only done for admin account holders
if($accessObject->hasAccess('subscription', 'account')) {
    $countryClass = load_class("country", "controllers");
    $all_countries = $countryClass->all_countries();

    // load the user session key to be used for all the queries
    $accountInfo = $bookingClass->clientData($session->clientId);

    // check the number of brands added compared to what the user is permitted to add
    $cSubscribe = json_decode( $accountInfo->subscription, true );
}
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="user"></i></div>
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
        <?php if(!$manageAccount) { ?>
            <?= pageNotFound($baseUrl) ?>
        <?php } else { ?>
        <div class="row">
            <form id="saveRecordWithAttachment" class="userManagerForm" method="POST" role="form" autocomplete="off" enctype="multipart/form-data" novalidate="novalidate" action="<?= $baseUrl.'api/account/update'; ?>">
                <div class="row">
                    <div class="col-lg-9 col-md-8">
                        <div id="lift">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="row" style="width:100%">
                                        <div class="col-lg-8 col-md-8">Account Information</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Logo</label>
                                                <input type="file" name="logo" id="logo" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <img class="curve" width="100px" src="<?= $baseUrl.$accountInfo->account_logo ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group pb-3">
                                                <label>COMPANY NAME <span class="required">*</span></label>
                                                <input style="color:black" type="text" class="form-control profile-input" name="name" value="<?= $accountInfo->name ?>" placeholder="" aria-required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group pb-3">
                                                <label>Contact Number</label>
                                                <input style="color:black" type="text" value="<?= $accountInfo->phone ?>" class="form-control profile-input" name="phone" placeholder="" aria-required="true">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group pb-3">
                                                <label>Email Address</label>
                                                <input style="color:black" type="email" value="<?= $accountInfo->email ?>" class="form-control profile-input" name="email" placeholder="" aria-required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-6">
                                            <div class="form-group pb-3">
                                                <label>Country</label>
                                                <select class="form-control" name="country" id="country_select">
                                                    <option value="0" selected class="text-muted">Select Country</option>
                                                    <?php 
                                                    if(!empty($all_countries)){
                                                        foreach ($all_countries as $key => $cntry){ ?>
                                                            <option <?= ($accountInfo->country == $cntry["id"]) ? "selected" : null; ?> value="<?= $cntry["id"] ?>"><?= $cntry["country_name"] ?></option>
                                                        <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group pb-3">
                                                <div class="form-group form-group-default-selectFx">
                                                    <label>City</label>
                                                    <input style="color:black" type="text" value="<?= $accountInfo->city ?>" name="city" id="city_select" class="form-control profile-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 border-top pt-3 border-default text-right mt-1 pr-0">
                                        <button class="btn btn-primary" type="submit" name="submit">Update Account</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="nav-sticky">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav flex-column" id="stickyNav">
                                        <li class="nav-item"><a class="nav-link" href="#lift">Account Information</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card pr-0 social-card share  curve full-width m-b-10 no-border" data-social="item">
                                <div class="card-header clearfix">
                                    <h5 class="text-success pull-left fs-12">Account Summary <i class="fa fa-circle text-success fs-11"></i></h5>
                                </div>
                                <div class="card-body pr-2 pl-2">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7"><h6>Subscription:</h6></div>
                                        <div class="col-lg-5 col-md-5 text-right"><h6><?= ucfirst($cSubscribe["account_type"]) ?></h6></div>
                                        <div class="col-lg-7 col-md-7"><h6>Expiry:</h6></div>
                                        <div class="col-lg-5 col-md-5 text-right"><h6><?= date("jS M Y", strtotime($cSubscribe["expiry_date"])) ?></h6></div>
                                        <div class="col-lg-7 col-md-7"><h6>Total Halls:</h6></div>
                                        <div class="col-lg-5 col-md-5 text-right"><h6><?= $cSubscribe["halls"] ?></h6></div>
                                        <div class="col-lg-7 col-md-7"><h6>Total Users:</h6></div>
                                        <div class="col-lg-5 col-md-5 text-right"><h6><?= $cSubscribe["users"] ?></h6></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8"><h6>Active Halls:</h6></div>
                                        <div class="col-lg-4 col-md-4 text-right"><h6><?= $cSubscribe["halls_created"] ?></h6></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8"><h6>Account Users:</h6></div>
                                        <div class="col-lg-4 col-md-4 text-right"><h6><?= $cSubscribe["users_created"] ?></h6></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7"><h6>Date Created:</h6></div>
                                        <div class="col-lg-5 col-md-5 text-right"><h6><?= date("jS M Y", strtotime($accountInfo->date_created)) ?></h6></div>
                                    </div>                                            
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="datatable table-responsive">
                    <table class="table smsTopupList dataTable" data-toggle="datatable">
                        <thead class="text-capitalize">
                            <tr>
                                <th width="5%">ID</th>
                                <th>Request Date</th>
                                <th>Request By</th>
                                <th>Amount</th>
                                <th>SMS Unit</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="10%"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</main>
<?php require "foottags.php"; ?>