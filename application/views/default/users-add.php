<?php
// set the page title
$page_title = "Add Admin User";

global $usersClass, $session, $bookingClass, $userId;

// fetch the perfect brand id for the facebook page to display
require_once 'headtags.php';

$userFound = false;
$manageUsers = $accessObject->hasAccess('manage', 'users');

// reset the userid if the user has admin privileges
$userId = ($manageUsers) ? $userId : $session->userId;

// create a new object of the industry class
$thisUser = $usersClass->get_user_basic($userId, $session->clientId);

// create additional objects
$access_levels = $usersClass->get_access_levels();

// get the suer brands
$genders = $usersClass->get_user_genders();
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
                    <?php if($manageUsers) { ?>
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>users">Users</a></li>
                    <?php } ?>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="container-fluid mt-n10">
        <?php if(!$manageUsers) { ?>
            <?= pageNotFound($baseUrl) ?>
        <?php } else { ?>
        <form id="saveRecordWithAttachment" class="userManagerForm" method="POST" role="form" autocomplete="off" enctype="multipart/form-data" novalidate="novalidate" action="<?= $baseUrl.'api/users/add'; ?>">
            <div class="row">
                <div class="col-lg-9 col-md-8">
                    <div id="lift">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row" style="width:100%">
                                    <div class="col-lg-8 col-md-8">Bio Information</div>
                                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                                        <a href="<?= $baseUrl ?>users" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i>&nbsp;List Users</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?= form_loader(); ?>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="fullname">Fullname <span class="required">*</span></label>
                                            <input type="text" name="fullname" id="fullname" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">Email Address <span class="required">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="username">Username <span class="required">*</span></label>
                                            <input title="Please leave blank" readonly placeholder="Username will be automatically created" type="text" class="form-control profile-input" style="color:black" name="username">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="contact">Contact Number</label>
                                            <input type="text" name="contact" id="contact" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="access_level">Access Permissions <span class="required">*</span></label>
                                            <select <?php if(!$accessObject->hasAccess('accesslevel', 'users')) { ?>disabled="disabled"<?php } else { ?> name="access_level_id"<?php } ?> class="selectpicker form-control">
                                            <option value="null">Select Access Level</option>
                                            <?php
                                            if(!empty($access_levels)){
                                                foreach ($access_levels as $level){
                                                    $accessId = $level["id"];
                                                    $levelName = $level["access_level_name"];
                                                    echo "<option value='$accessId'>$levelName</option>";
                                                }
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php if($accessObject->hasAccess('manage', 'users') || ($session->userId == $userId)) { ?>
                                    <div class="col-lg-12 border-top pt-3 border-default text-right mt-3">
                                        <div class="clearfix"></div>
                                        <input type="hidden" value="" name="user_guid" id="user_guid" class="form-control">
                                        <button class="btn btn-sm btn-primary" type="submit" name="submit" id="save_settings_button">Add User</button>
                                    </div>
                                    <?php } ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div id="liftSizing">
                        <div class="card mb-4">
                            <div class="card-header">User Password</div>
                            <div class="card-body">
                                <p class="text-center"><em>Password Will be automatically created and sent via the email provided</em></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="nav-sticky">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav flex-column" id="stickyNav">
                                    <li class="nav-item"><a class="nav-link" href="#lift">Bio Information</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#liftSizing">Password</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card social-card share  full-width m-b-10 no-border" data-social="item">
                            <div class="card-header clearfix">
                                <h6 class="text-success fs-12 text-center">Details of Access Level Privileges</h6>
                            </div>
                            <div class="card-body pr-3">
                                <div class="row">
                                    <div class="col-lg-12 mt-3 col-md-12 access_level_content">
                                        <div class="text-center"><em>No privileges selected</em></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php } ?>
    </div>

</main>
<?php require "foottags.php"; ?>