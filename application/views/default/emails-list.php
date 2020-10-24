<?php 
$page_title = "Communication > Emails";

// additional css and javascript files
$loadedJS = [
    "assets/js/suggestion.js",
    "assets/js/attachments.js",
    "assets/js/emails.js"
];

$loadedCSS = [
    "assets/css/suggestion.css",
    "assets/css/emails.css",
];

require "headtags.php";

// if the user has permissions
$sendEmail = $accessObject->hasAccess("manage", "communications");

// create new object
$filesObj = load_class("files", "controllers");

/** Set parameters for the data to attach */
$form_params = (object) [
    "module" => "emails",
    "userData" => $userData,
    "item_id" => "emails",
    "no_footer" => true,
    "no_padding" => true
];
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i class="fa fa-comments"></i></div>
                    <span><?= $page_title ?></span>
                </h1>
                <ol class="breadcrumb mt-4 mb-0">
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n15">
        <?= form_loader() ?>
        <?php if(!$sendEmail) { ?>
            <div class="card-body">
                <?= pageNotFound($baseUrl) ?>
            </div>
        <?php } else { ?>
            <div class="card-body">
                <div class="btn-toolbar row justify-content-between" role="toolbar">
                    <div class="btn-group action-buttons">
                        <span class="active-msg"></span>
                    </div>
                    <div class="float-right d-flex">
                        <div class="btn-group ml-1">
                            <button type="button" class="btn btn-outline-success hidden go-back">
                                <i class="fas fa-arrow-alt-circle-left"></i> Back
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slim-scroll p-1 pt-0">
                
                <div class="row inbox-wrapper mt-0 pt-0">
                    <div class="col-lg-12">
                        <div class="card">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-lg-3 email-aside border-lg-right">
                                <div class="aside-content">
                                <div class="aside-header">
                                    <button class="navbar-toggle" data-target=".aside-nav" data-toggle="collapse" type="button"><span class="icon"><i data-feather="chevron-down"></i></span></button><span class="title">Mail Service</span>
                                    <p class="description"><?= $userData->email ?></p>
                                </div>
                                <?php if($sendEmail) { ?>
                                <div class="aside-compose"><a class="btn btn-primary btn-block" id="send_mail" href="javascript:void(0)">Compose Email</a></div>
                                <?php } ?>
                                <div class="aside-nav <?= !$sendEmail ? "mt-3" : "" ?> collapse">
                                    <ul class="nav" data-email-duty="list">
                                    <li class="active"><a data-email-duty="list" data-email-value="inbox" href="javascript:void(0)"><span class="icon"><i data-feather="inbox"></i></span>Inbox<span class="badge badge-danger-muted text-white font-weight-bold float-right" data-mails-count="inbox">0</span></a></li>
                                    <li><a data-email-duty="list" data-email-value="sent" href="javascript:void(0)"><span class="icon"><i data-feather="mail"></i></span data-email-label-count="sent">Sent Mail</a></li>
                                    <li><a data-email-duty="list" data-email-value="important" href="javascript:void(0)"><span class="icon"><i data-feather="briefcase"></i></span>Important</a></li>
                                    <?php if($sendEmail) { ?>
                                    <li><a data-email-duty="list" data-email-value="draft" href="javascript:void(0)"><span class="icon"><i data-feather="file"></i></span>Drafts <span class="badge badge-primary text-white font-weight-bold float-right" data-mails-count="draft">0</span></a></li>
                                    <?php } ?>
                                    <li><a data-email-duty="list" data-email-value="favorite" href="javascript:void(0)"><span class="icon"><i data-feather="star"></i></span>Favorite <span class="badge badge-warning text-white font-weight-bold float-right" data-mails-count="favorite">0</span></a></li>
                                    <li><a data-email-duty="list" data-email-value="trash" href="javascript:void(0)"><span class="icon"><i data-feather="trash"></i></span>Trash </a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <div class="col-lg-9 email-content">
                                <div class="email-inbox-header">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div id="email-content-filters" class="email-title mb-2 mb-md-0"><span class="icon"><i data-feather="inbox"></i></span> Inbox <span class="new-messages">(<span data-mails-count="unread_count">0</span> new messages)</span> </div>
                                    </div>
                                    <div class="d-none d-md-block col-lg-6">
                                        <div class="email-search">
                                            <div class="input-group input-search">
                                                <input class="form-control email-search-item" name="search" type="text" placeholder="Search mail...">
                                                <span class="input-group-btn">
                                                    <button style="height:42px; border-radius: 0px 5px 5px 0px" class="btn btn-outline-secondary btn-block email-search-btn"><i data-feather="search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div id="email-content-filters" class="email-filters d-flex align-items-center justify-content-between flex-wrap">
                                    
                                    <div class="email-filters-left flex-wrap d-none d-md-flex">
                                        <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="data-email-checkall form-check-input">
                                        </label>
                                        </div>
                                        <div class="btn-group ml-3">
                                        <button class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" type="button"> With selected <span class="caret"></span></button>
                                        <div class="dropdown-menu" role="menu">
                                            <button class="dropdown-item" data-email-change="state" data-email-value="mark_as_read" href="javascript:void(0)">Mark as read</button>
                                            <button class="dropdown-item font-weight-bolder" data-email-change="state" data-email-value="mark_as_unread" href="javascript:void(0)">Mark as unread</button>
                                            <a class="dropdown-item text-warning" data-email-change="state" data-email-value="favorite" href="javascript:void(0)">Set as Favorite</a>
                                            <div class="dropdown-divider"></div>
                                            <button class="dropdown-item text-success" data-email-change="state" data-email-value="important" href="javascript:void(0)">Mark as Important</button>
                                            <div class="dropdown-divider"></div>
                                            <button class="dropdown-item hidden" data-email-change="state" data-email-value="inbox" href="javascript:void(0)">Move to Inbox</button>
                                            <button class="dropdown-item" data-email-change="state" data-email-value="trash" href="javascript:void(0)">Move to Trash</button>
                                            <button class="dropdown-item text-danger" data-email-change="state" data-email-value="delete" href="javascript:void(0)">Delete</button>
                                        </div>
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="email-list">
                                    <?= absolute_loader() ?>
                                    <div id="emails-content-listing" class="emails-content-listing slim-scroll"></div>
                                    <div id="emails-content-display"></div>
                                </div>

                                <?php if($sendEmail) { ?>
                                <div class="send-email-content hidden">
                                    <div class="email-head">
                                        <div class="email-head-title d-flex align-items-center">
                                            <span data-feather="edit" class="icon-md mr-2"></span>
                                            New message
                                        </div>
                                    </div>
                                    <div class="email-compose-fields">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Subject</div>
                                                </div>
                                                <input id="mail_subject" name="mail_subject" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <div id="recipients_list" data-toggle="suggestions" name="recipients_list" class="form-control"></div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Cc</div>
                                                </div>
                                                <div id="cc_list" name="cc_list" data-toggle="suggestions" class="form-control"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="row">

                                                        <div class="col-lg-12 mb-3">
                                                            <trix-editor name="email_content slim-scroll mb-3" id="email_content"></trix-editor>                                                
                                                        </div>

                                                        <div class="col-sm-9 pl-2 p-0">
                                                            <div class="d-flex">
                                                                <div class="btn-group dropup">
                                                                    <button class="btn btn-primary send-button" data-request="inbox">Send</button>
                                                                    <button type="button" class="btn p-2 btn-primary btn-icon-text dropdown-toggle" data-toggle="dropdown"></button>
                                                                    <div class="dropdown-menu" data-function="email" x-placement="bottom-start">
                                                                        <button class="dropdown-item hidden" data-action="schedule_now" href="javascript:void(0)">Schedule Now</button>
                                                                        <button class="dropdown-item" data-action="schedule_send" href="javascript:void(0)">Schedule Send</button>
                                                                    </div>
                                                                </div>
                                                                <div class="ml-2">
                                                                <input type="hidden" name="mail_request" id="mail_request" value="send_now">
                                                                <input type="datetime-local" value="<?= date("Y-m-d\TH:i:s") ?>" name="schedule_date" id="schedule_date" class="form-control hidden">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 text-right p-0">
                                                            <button type="discard" class="btn discard-button"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 p-0">
                                                    <?= $filesObj->comments_form_attachment_placeholder($form_params) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                            </div>
                            
                        </div>
                        </div>
                    </div>
                </div>

                <?= discard_form("discard_email_content", "center-top"); ?>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="mails-content"></div>
                </div>
            </div>
        <?php } ?>
    </div>

</main>
<?php require "foottags.php"; ?>