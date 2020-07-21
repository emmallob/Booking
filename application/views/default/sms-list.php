<?php 
$page_title = "Communication > SMS";

require "headtags.php";
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
    <div class="container-fluid mt-n10">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-12 col-md-12">
                        <p class="float-right forSMS badge badge-dark font-13 p-2 mt-1" id="get-sms-balance"></p>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="col-12">
                        <div class="tab-content detail-list" id="pills-tabContent">
                            
                            <div class="content-loader">
                                <!-- <i class="fa fa-4x fa-pulse fa-spinner"></i> -->
                            </div>
                            
                            <div class="tab-pane fade show active" id="message_history">
                                <div class="row">
                                    <div class="chat-box-left col-lg-4 col-md-4">
                                        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                                            
                                            <li class="nav-item">
                                                <a class="nav-link active" id="group_chat_tab" data-toggle="pill" href="#compose">Compose</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="general_chat_tab" data-toggle="pill" href="#general_chat">
                                                    Multiple
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="group_chat_tab" data-toggle="pill" href="#single_chat">
                                                    Single
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content chat-list slimscroll" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="compose">
                                                <form role="form" method="POST" id="send-bulk-message-form" class="mt-3">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <label>Recipient Category</label>
                                                        <select data-message-type="sms" class="form-control select-rec-category selectpicker" name="recipientCategory">
                                                                <option label="-- Select Category --" value="null">-- Select Category --</option>
                                                                <option value="allContacts">All Contacts</option>
                                                                <option value="specificContact">Specific Contacts</option>
                                                                <option value="specificEvent">Specific Event</option>
                                                        </select>
                                                        <br>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12 show-recipient-cat"></div>
                                                        <input type="hidden" name="msg_type" value="sms">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade bulk-history-lists" data-group="bulk" id="general_chat"></div>
                                            <!--end general chat-->

                                            <div class="tab-pane fade single-history-lists" data-group="single" id="single_chat"></div>
                                        </div><!--end tab-content-->
                                    </div><!--end chat-box-left -->


                                    <div class="chat-box-right col-lg-8 col-md-8">
                                        <div class="chat-header">
                                            <a href="javascript:void(0)" class="media">
                                                <div class="avatar-box thumb-md align-self-center mr-2 d-none recipient-icon">
                                                    <span class="avatar-title bg-primary rounded-circle">
                                                        <i class="fa fa-3x fa-user"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body justify-content-between row">
                                                    <div class="col-lg-8 read-message d-none">
                                                        <h6 class="mb-1 mt-0 chat-recipient-title">
                                                        Please Select A Message</h6>
                                                        <p class="mb-0 chat-date"></p>
                                                    </div>
                                                    <p class="type-message d-none badge badge-soft-dark text-left col-2 font-13 p-2">SMS Cost: <span id="showSMSCost">0 Unit(s)</span></p>
                                                    <button class="col-lg-2 btn btn-sm d-none btn-primary top-up-sms top-up-sms-activate" style="height: 25px;margin-top: 5px;padding-top: 0px;padding-bottom: 0;">
                                                        Top Up <span class="mdi mdi-coins"></span>
                                                    </button>
                                                </div><!-- end media-body -->
                                            </a><!--end media-->
                                        </div><!-- end chat-header -->
                                        <div class="chat-body ">
                                            <div class="chat-detail slimscroll">

                                                <div class="media">
                                                    <div class="media-body">
                                                        <div class="chat-msg sms-message-sent">
                                                        </div>
                                                    </div><!--end media-body--> 
                                                </div> <!--end media-->
                                            </div>  <!-- end chat-detail -->                                               
                                        </div><!-- end chat-body -->
                                        <div class="chat-footer">
                                            <div class="row">                                                    
                                                <div class="col-12 col-md-12 mb-2">
                                                    <textarea class="form-control" id="smsText" form="send-bulk-message-form" style="min-height: 90px;border-radius: 20px;padding: 10px;" name="directMessage"></textarea>
                                                </div>
                                                <div class="col-12 pr-0 mr-0 row align-items-center">
                                                    <p style="color: dimgray; font-size: 12px;" class="col-lg-7 col-md-7">
                                                    (<b id="smsLength"></b>) Characters left - <b id="smsCount"></b> SMS Unit
                                                    </p>
                                                    <p class="col-lg-5 col-md-5 text-right">
                                                        <input type="hidden" name="selectedrecipients" value="null">
                                                        <input type="hidden" name="messageDirection" value="process_1">
                                                        <button class="btn btn-outline-primary send-message">Send</button>
                                                        <button class="btn btn-outline-danger d-none cancel-message">Cancel</button>
                                                    </p>
                                                </div>
                                            </div><!-- end row -->
                                        </div><!-- end chat-footer -->
                                    </div><!--end chat-box-right --> 
                                    <span class="current-viewer" data-contact-id></span>   
                                </div><!-- end row -->
                            </div><!--end education detail-->
                        </div>
                    </div>

            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>