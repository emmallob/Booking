<?php
#FETCH SOME GLOBAL FUNCTIONS
global $SITEURL, $config, $session, $usersClass, $accessObject;
global $page_title, $DB, $offices;

#REDIRECT THE USER IF NOT LOGGED IN
if(!$usersClass->logged_InControlled()) {
	require "login.php";
	exit(-1);
}

// set the default variables
$baseUrl = $rootDir = $config->base_url();
$userId = $session->userId;
$brandId = null;

// load the user data
$userData = (Object) $usersClass->item_by_id("users", $userId);
$clientData = $bookingClass->clientData($session->clientId);

// if the userdata is empty the remove all sessions
if(!isset($userData->name)) {
	$session->destroy();
	require "login.php";
	exit(-1);
}

// user settings
$userSettings = json_decode($userData->dashboard_settings);

// get the user preferred theme color
$userPreferedTheme = $userSettings->theme;

// save the current page in session
$session->set("current_url", current_url());

// create a new object for the access level
$accessObject->userId = $userId;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta name="theme-color" content="#ffffff">
	<meta content="" name="description" />
	<title><?= $page_title; ?> | <?= config_item('site_name') ?></title>
	<link rel="icon" type="image/png" sizes="16x16" href='<?= "{$baseUrl}assets/img/favicon.png" ?>'>
	<link rel="mask-icon" href='<?= "{$baseUrl}assets/img/favicon.png" ?>' color="#da532c">
	<link rel="shortcut icon" href='<?= "{$baseUrl}assets/img/favicon/favicon.ico" ?>'>
	<link href='<?= "{$baseUrl}assets/css/styles.css" ?>' rel="stylesheet" type="text/css" />
	<link href='<?= "{$baseUrl}assets/libs/datatables/css/datatable.css" ?>' rel="stylesheet" type="text/css" />
	<link href='<?= "{$baseUrl}assets/libs/select/select.css" ?>' rel="stylesheet" type="text/css" />
	<link href='<?= "{$baseUrl}assets/libs/sweetalert/sweetalert.css" ?>' rel="stylesheet" type="text/css" />
	<link href='<?= "{$baseUrl}assets/css/custom.css" ?>' rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/libs/summernote/dist/summernote-bs4.css">
	<script data-search-pseudo-elements defer src="<?= $baseUrl ?>assets/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
	<script src="<?= $baseUrl ?>assets/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
	<style>
		.bg {
            /*background-image: url('<?= $baseUrl ?>assets/img/bg.jpg'); */
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
	</style>
</head>
<body class="nav-fixed dashboard bg <?= $userSettings->navbar ?> <?= $userSettings->theme ?> <?= (!empty($session->clientId)) ? "menu-pin" : null ?>">
	<div id="current_url" value="<?= $session->current_url; ?>"></div>
	<nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
		<a class="navbar-brand d-none d-sm-block" href="<?= $baseUrl ?>"><?= config_item("site_name") ?></a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
		<form autocomplete="Off" class="form-inline mr-auto d-none d-lg-block" method="GET" action="<?= $baseUrl ?>search">
			<input class="form-control form-control-solid mr-sm-2" type="search" name="q" placeholder="Search" aria-label="Search" />
		</form>
		<ul class="navbar-nav align-items-center ml-auto">
			<li class="nav-item dropdown no-caret mr-3 dropdown-notifications">
				<a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell"></i></a>
				<div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
					<h6 class="dropdown-header dropdown-notifications-header"><i class="mr-2" data-feather="bell"></i>Activity Logs Center</h6>
					<a class="dropdown-item dropdown-notifications-item" href="#!">
					<div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
					<div class="dropdown-notifications-item-content">
						<div class="dropdown-notifications-item-content-details">December 29, 2019</div>
						<div class="dropdown-notifications-item-content-text">This is an alert message. It&apos;s nothing serious, but it requires your attention.</div>
					</div></a>
					<a class="dropdown-item dropdown-notifications-item" href="#!">
						<div class="dropdown-notifications-item-icon bg-info"><i data-feather="bar-chart"></i></div>
						<div class="dropdown-notifications-item-content">
						<div class="dropdown-notifications-item-content-details">December 22, 2019</div>
						<div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click here to view!</div>
						</div>
					</a>
					<a class="dropdown-item dropdown-notifications-item" href="#!">
						<div class="dropdown-notifications-item-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
						<div class="dropdown-notifications-item-content">
						<div class="dropdown-notifications-item-content-details">December 8, 2019</div>
						<div class="dropdown-notifications-item-content-text">Critical system failure, systems shutting down.</div>
						</div>
					</a>
					<a class="dropdown-item dropdown-notifications-item" href="#!">
						<div class="dropdown-notifications-item-icon bg-success"><i data-feather="user-plus"></i></div>
						<div class="dropdown-notifications-item-content">
						<div class="dropdown-notifications-item-content-details">December 2, 2019</div>
						<div class="dropdown-notifications-item-content-text">New user request. Woody has requested access to the organization.</div>
						</div>
					</a>
					<a class="dropdown-item dropdown-notifications-footer" href="<?= $baseUrl ?>activity-logs">View All Activity Logs</a>
				</div>
			</li>
			<li class="nav-item dropdown no-caret mr-3 dropdown-user">
				<a class="btn btn-icon btn-transpadrent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img width="60px" class="curve" src="<?= $baseUrl ?><?= $userData->image ?>"/>
				</a>
				<div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
					<h6 class="dropdown-header d-flex align-items-center">
						<img class="dropdown-user-img" src="<?= $baseUrl ?><?= $userData->image ?>" />
						<div class="dropdown-user-details">
							<div class="dropdown-user-details-name"><?= $userData->name ?></div>
							<div class="dropdown-user-details-email"><?= $userData->email ?></div>
						</div>
					</h6>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?= $baseUrl ?>profile">
						<div class="curve dropdown-item-icon"><i data-feather="user"></i></div> Profile
					</a>
					<a class="dropdown-item" href="<?= $baseUrl ?>activity-logs">
						<div class="dropdown-item-icon"><i data-feather="list"></i></div> Activity Logs
					</a>
					<?php if($accessObject->hasAccess("manage", "account")) { ?>
					<a class="dropdown-item" href="<?= $baseUrl ?>configuration">
						<div class="dropdown-item-icon"><i data-feather="settings"></i></div> Settings
					</a>
					<?php } ?>
					<a class="dropdown-item data-logout" href="javascript:void(0)">
						<div class="dropdown-item-icon"><i data-feather="log-out"></i></div>Logout
					</a>
				</div>
			</li>
		</ul>
	</nav>
	<div id="layoutSidenav">
		<div id="layoutSidenav_nav">
			<nav class="sidenav shadow-right sidenav-light">
				<div class="sidenav-menu">
					<div class="nav accordion" id="accordionSidenav">
						<div class="sidenav-menu-heading">Core</div>
						<a class="nav-link collapsed" href="<?= $baseUrl ?>dashboard">
							<div class="nav-link-icon"><i data-feather="activity"></i></div>
							Dashboard
						</a>
						<div class="sidenav-menu-heading">Interface</div>
						<?php if($accessObject->hasAccess("list", "halls")) { ?>
						<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseHalls" aria-expanded="false" aria-controls="collapseHalls">
							<div class="nav-link-icon"><i data-feather="package"></i></div>
							Halls
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= in_array($SITEURL[0], ["halls", "halls-add", "halls-edit", "halls-configuration"]) ? "show" : null ?>" id="collapseHalls" data-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
								<a class="nav-link" href="<?= $baseUrl ?>halls">List Halls</a>
								<?php if($accessObject->hasAccess("list", "halls")) { ?>
								<a class="nav-link" href="<?= $baseUrl ?>halls-add">Add Hall</a>
								<?php } ?>
							</nav>
						</div>
						<?php } ?>
						<?php if($accessObject->hasAccess("list", "events")) { ?>
						<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
							<div class="nav-link-icon"><i data-feather="layout"></i></div>
							Events
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= in_array($SITEURL[0], ["events", "events-add", "events-edit"]) ? "show" : null ?>" id="collapseLayouts" data-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
								<a class="nav-link" href="<?= $baseUrl ?>events">List Events</a>
								<?php if($accessObject->hasAccess("add", "events")) { ?>
								<a class="nav-link" href="<?= $baseUrl ?>events-add">Add Event</a>
								<?php } ?>
							</nav>
						</div>
						<?php } ?>
						<?php if($accessObject->hasAccess("list", "tickets")) { ?>					
						<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
							<div class="nav-link-icon"><i data-feather="tool"></i></div>
							Tickets
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= in_array($SITEURL[0], ["tickets", "tickets-list", "tickets-sell", "tickets-generate", "tickets-assign"]) ? "show" : null ?>" id="collapseUtilities" data-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav">
								<a class="nav-link" href="<?= $baseUrl ?>tickets">Tickets</a>
								<?php if($accessObject->hasAccess("generate", "tickets")) { ?>
								<a class="nav-link" href="<?= $baseUrl ?>tickets-generate">Generate</a>
								<?php } ?>
								<?php if($accessObject->hasAccess("sell", "tickets")) { ?>
								<a class="nav-link" href="<?= $baseUrl ?>tickets-sell">Sell Ticket</a>
								<a class="nav-link" href="<?= $baseUrl ?>tickets-list">Sales List</a>
								<?php } ?>
							</nav>
						</div>
						<?php } ?>
						<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
							<div class="nav-link-icon"><i data-feather="repeat"></i></div>
							Reservation
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= in_array($SITEURL[0], ["reservation"]) ? "show" : null ?>" id="collapseFlows" data-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav"><a class="nav-link" target="_blank" href="<?= $baseUrl ?>reservation/<?= $clientData->client_abbr ?>">Reserve Seat</a></nav>
						</div>
						<?php if($accessObject->hasAccess("list", "departments")) { ?>
						<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDepartments" aria-expanded="false" aria-controls="collapseDepartments">
							<div class="nav-link-icon"><i data-feather="book"></i></div>
							Departments
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= in_array($SITEURL[0], ["departments", "departments-add", "departments-edit"]) ? "show" : null ?>" id="collapseDepartments" data-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav">
								<a class="nav-link" href="<?= $baseUrl ?>departments">Departments</a>
								<?php if($accessObject->hasAccess("add", "departments")) { ?>
								<a class="nav-link" href="<?= $baseUrl ?>departments-add">Add Department</a>
								<?php } ?>
							</nav>
						</div>
						<?php } ?>
						<div class="sidenav-menu-heading">Addons</div>
						<?php if($accessObject->hasAccess("manage", "communications")) { ?>
						<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseCommunication" aria-expanded="false" aria-controls="collapseCommunication">
							<div class="nav-link-icon"><i class="fas fa-comments"></i></div>
							Communications
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= in_array($SITEURL[0], ["sms-list", "emails-list", "emails-compose"]) ? "show" : null ?>" id="collapseCommunication" data-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav">
								<a class="nav-link" href="<?= $baseUrl ?>sms-list"> SMS List</a>
								<a class="nav-link" href="<?= $baseUrl ?>emails-list">Emails List</a>
								<a class="nav-link" href="<?= $baseUrl ?>emails-compose">Compose Email</a>
							</nav>
						</div>
						<?php } ?>
						<a class="nav-link" href="<?= $baseUrl ?>profile">
							<div class="nav-link-icon"><i data-feather="user"></i></div>
							Profile
						</a>
						<?php if($accessObject->hasAccess("manage", "users")) { ?>
						<a class="nav-link" href="<?= $baseUrl ?>users">
							<div class="nav-link-icon"><i data-feather="users"></i></div>
							User Management
						</a>
						<?php } ?>
						<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseReports" aria-expanded="false" aria-controls="collapseReports">
							<div class="nav-link-icon"><i class="fa fa-chart-bar"></i></div>
							Reports
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= in_array($SITEURL[0], ["events-report", "tickets-report"]) ? "show" : null ?>" id="collapseReports" data-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav">
								<?php if($accessObject->hasAccess("reports", "tickets")) { ?>
								<a class="nav-link" href="<?= $baseUrl ?>tickets-report">Tickets</a>
								<?php } ?>
								<a class="nav-link" href="<?= $baseUrl ?>events-report">Events</a>
							</nav>
						</div>


						<?php if($accessObject->hasAccess("manage", "account")) { ?>
						<a class="nav-link" href="<?= $baseUrl ?>configuration">
							<div class="nav-link-icon"><i data-feather="filter"></i></div>
							Settings
						</a>
						<?php } ?>
					</div>
				</div>
				<div class="sidenav-footer p-2 bg-white">
					<div class="sidenav-footer-content" style="width: 100%">
						<div class="sidenav-footer-subtitle">:</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="progress mb-2">
									<div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<p align="center">20 Days left for your Trial</p>
							</div>
						</div>
					</div>
				</div>
				<div class="sidenav-footer">
					<div class="sidenav-footer-content">
						<div class="sidenav-footer-subtitle">Logged in as:</div>
						<div class="sidenav-footer-title"><?= $userData->name ?></div>
					</div>
				</div>
			</nav>
		</div>
		<div id="layoutSidenav_content">