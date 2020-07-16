<?php
// set the page title
$page_title = "User Profile";

global $usersClass, $session, $bookingClass, $userId;

// fetch the perfect brand id for the facebook page to display
require_once 'headtags.php';

$userFound = false;
$manageUsers = $accessObject->hasAccess('manage', 'users');

// if the user id was parsed
if(confirm_url_id(1)) {
    $userId = xss_clean($SITEURL[1]);
}

// reset the userid if the user has admin privileges
$userId = ($manageUsers) ? $userId : $session->userId;

// create a new object of the industry class
$thisUser = $usersClass->get_user_basic($userId, $session->clientId);

// ensure that a user id was parsed
if(!empty($thisUser)) {
    // get the user found to true
    $userFound = true;
    
    // create additional objects
    $access_levels = $usersClass->get_access_levels();

    // get the suer brands
    $genders = $usersClass->get_user_genders();

    $thisUserAccess = json_decode($thisUser->permissions, true)["permissions"];
    $thisAccessLevel = json_decode($thisUser->access_level_permissions, true)["permissions"];

    // set the user id in a session
    $session->currentUserId = $userId;
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
                    <?php if($manageUsers) { ?>
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>users">Users</a></li>
                    <?php } ?>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div id="lift">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row" style="width:100%">
                                <div class="col-lg-8 col-md-8">Bio Information</div>
                                <?php if($manageUsers) { ?>
                                <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                                    <a href="<?= $baseUrl ?>users" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i>&nbsp;List Users</a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <form id="saveRecordWithAttachment" class="userManagerForm" method="POST" role="form" autocomplete="off" enctype="multipart/form-data" novalidate="novalidate" action="<?= $baseUrl.'api/users/update'; ?>">
                                <div class="row">
                                    <?= form_loader(); ?>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="fullname">Fullname <span class="required">*</span></label>
                                            <input type="text" value="<?= $thisUser->name ?? null ?>" name="fullname" id="fullname" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="username">Username <span class="required">*</span></label>
                                            <input type="text" value="<?= $thisUser->username ?? null ?>" name="username" id="username" readonly class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">Email Address <span class="required">*</span></label>
                                            <input type="email" value="<?= $thisUser->email ?? null ?>" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="contact">Contact Number</label>
                                            <input type="hidden" value="<?= $userId ?>" name="user_guid" id="user_guid" class="form-control">
                                            <input type="text" name="contact" id="contact" value="<?= $thisUser->contact ?? null ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="access_level_id">Access Permissions <span class="required">*</span></label>
                                            <select <?php if(!$accessObject->hasAccess('accesslevel', 'users') || ($manageUsers && ($session->userId == $userId))) { ?>disabled="disabled"<?php } else { ?> name="access_level_id"<?php } ?> class="selectpicker form-control">
                                            <option value="null">Select Access Level</option>
                                            <?php
                                            if(!empty($access_levels)){
                                                foreach ($access_levels as $level){
                                                    $accessId = $level["access_level_id"];
                                                    $levelName = $level["access_level_name"];
                                                    $selected = $accessId == $thisUser->access_level ? 'selected' : '';
                                                    echo "<option value='$accessId' {$selected}>$levelName</option>";
                                                }
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 pl-3">
                                        <div class="row">
                                            <?php if($accessObject->hasAccess('accesslevel', 'users')) { ?>
                                                <div class="col-lg-12"><hr></div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-12"><h5>User Privileges Management</h5></div>
                                                        <?php
                                                        // access level list
                                                        foreach ($thisAccessLevel as $key => $value) {
                                                            $header = ucwords(str_replace("_", " ", $key));
                                                            print "<div class='col-lg-4 mb-2 col-md-4' ".(($session->userId == $userId) ? "title='You cannot alter the number of permissions for your Account as An Administrator.'" : null).">";
                                                            print "<h6 style='font-weight:bolder; font-size:14px'>".$header."</h6>";
                                                            foreach($value as $nkey => $nvalue) {
                                                                print "<div>";
                                                                print "<input ".(isset($thisUserAccess[$key][$nkey]) && ($thisUserAccess[$key][$nkey] == 1) ? "checked" : null )." ".(($session->userId == $userId) ? "disabled='disabled'" : null)." type='checkbox' class='custom-checkbox' name='access_level[$key][$nkey][]'>";
                                                                print "<label class='cursor' for='access_level[$key][$nkey]'>".ucfirst($nkey)."</label>";
                                                                print "</div>";
                                                            }
                                                            print "</div>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if($accessObject->hasAccess('manage', 'users') || ($session->userId == $userId)) { ?>
                                    <div class="col-lg-12 border-top pt-3 border-default text-right mt-3">
                                        <div class="clearfix"></div>
                                        <button class="btn btn-sm btn-primary" type="submit" name="submit" id="save_settings_button">Update Profile</button>
                                    </div>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="liftSizing">
                    <div class="card mb-4">
                        <div class="card-header">Change Password</div>
                        <div class="card-body">
                            <form action="<?= $baseUrl ?>api/users/change_password" class="appForm" method="POST">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password">Password <span class="required">*</span></label>
                                            <input type="password" name="password" id="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password_2">Confirm Password <span class="required">*</span></label>
                                            <input type="hidden" value="<?= $userId ?>" name="user_guid" id="user_guid" class="form-control">
                                            <input type="password" name="password_2" id="password_2" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 border-top pt-3 border-default text-right mt-3">
                                        <div class="clearfix"></div>
                                        <button class="btn btn-sm btn-primary" type="submit" name="submit">Change Password</button>
                                    </div>
                                </div>
                            </form>
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
                    <div class="card">
                        <div class="card social-card share  full-width m-b-10 no-border" data-social="item">
                            <div class="card-header clearfix">
                                <h6 class="text-success pull-left">Account Summary <i class="fa fa-circle text-success"></i></h6>
                            </div>
                            <div class="card-body pr-3">
                                <div class="row">
                                    <div class="col-lg-7 col-md-7"><h6>Access Level:</h6></div>
                                    <div class="col-lg-5 col-md-5 text-right"><h6><?= $thisUser->access_level_name; ?></h6></div>
                                </div>
                                <hr class="mb-3">
                                <div class="row">
                                    <div class="col-lg-7 col-md-7"><h6>Username:</h6></div>
                                    <div class="col-lg-5 col-md-5 text-right"><h6><?= $thisUser->username; ?></h6></div>
                                </div>
                                <hr class="mb-3">
                                <div class="row">
                                    <div class="col-lg-7 col-md-7"><h6>Date Created:</h6></div>
                                    <div class="col-lg-5 col-md-5 text-right"><h6><?= $thisUser->created_on ?></h6></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6"><h6>Last Login:</h6></div>
                                    <div class="col-lg-6 col-md-6 text-right"><h6> <?= $thisUser->last_login ?></h6></div>
                                </div>
                                <hr class="mb-0">
                                <div class="row mt-3">
                                    <div class="col-lg-12 col-md-12"><h6 class="mb-0"><?= ($session->userId == $userId) ? "Activity Logs:" : "Activity Logs of {$thisUser->name}"; ?></h6></div>
                                    <table class="table">
                                        <tbody>
                                            <?php 
                                            $activities = $booking->prepare("SELECT * FROM users_activity_logs WHERE user_guid=? AND DATE(date_recorded) = CURDATE() ORDER BY id DESC LIMIT 10");
                                            $activities->execute([$userId]);
                                            while($result = $activities->fetch(PDO::FETCH_OBJ)) { ?>
                                            <tr title="Activity Performed using: <?= $result->user_agent; ?>">
                                                <td>
                                                    <?= $result->description ?> @ <?= $result->date_recorded; ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if(($session->userRole === 1) || ($session->userId == $userId)) { ?>
                                    <div class="col-lg-12 text-center">
                                        <span class="text-success view-user-activity cursor" title="Click to view detail user activity history" data-user-id="<?= $userId ?>">View More</span>
                                    </div>
                                    <?php } ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>