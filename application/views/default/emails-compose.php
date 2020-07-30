<?php 
$page_title = "Communication > Compose Mail";

require "headtags.php";

$msgFound = false;

// If the tempAttachment session is empty
if(empty($session->tempAttachment)) {
    $session->set("tempAttachment", random_string('alnum', 14));
}
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
                    <div class="col-lg-8 col-md-8"></div>
                </div>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="" tabindex="-1" role="dialog" aria-hidden="true">        
                            <div class="card mb-0 p-3">
                                <form autocomplete="Off" method="POST" class="submitEmailForm" id="composeMail" action="<?= $baseUrl.'apis/emails/send'; ?>">
                                    <?= form_loader(); ?>
                                    <div class="form-group mb-3">
                                        <style>
                                            .table {
                                                padding: 0px!important;
                                                border: 0px;
                                            }
                                            .table td, .table th {
                                                padding-bottom: 5px;
                                                border: 0px;
                                            }
                                        </style>
                                        <div class="row">
                                            <div class="col-auto pr-1">
                                                <div class="input-group-prepend" style="height:37px;">
                                                    <span style="border-radius:6px 0px 0px 6px" class="input-group-text btn-block" id="basic-addon1">From</span>
                                                </div>
                                            </div>
                                            <div class="input-group pl-0 col-lg-3">
                                                <select name="send_from"  style="width:200px" id="send_from" class="selectpicker">
                                                    <option selected value="emmallob14@gmail.com">Emmanuel Obeng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2 sent-to-listing">
                                            <div class="input-group col-lg-12">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">To</span>
                                                </div>
                                                <input placeholder="List of Members to Send Mail To" type="text" name="send_to" id="send_to" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="input-group col-lg-12 mailSubject">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Subject</span>
                                                </div>
                                                <input type="text" value="<?= ($msgFound) ? "RE: ". $msgDetails->subject : null ?>" name="subject" class="subject form-control" placeholder="Subject of Message">
                                            </div>
                                        </div>

                                    </div><!--end form-group-->
                                    <div class="row mb-3">
                                        <div class="col-lg-8">
                                            <div class="message_content_container" style="width: 100%">
                                                <textarea data-height="250" data-editor-height="380" data-width="800" name="message_content" data-editor="summernote" class="col-lg-12 form-control message-content">
                                                    <?= 
                                                        ($msgFound) ? 
                                                            "<br><br>---------- Forwarded message ---------<br>"
                                                        . "From: {$clientData->client_name} <{$msgDetails->sent_via}><br>
                                                            Date: ".date("D, M d, Y \at h:iA", strtotime($msgDetails->sent_via))."<br>
                                                            Subject: {$msgDetails->subject}<br>
                                                            To: {$msgDetails->recipient}<br><br>"
                                                        . $msgDetails->message : null
                                                    ?>
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <h4 class="page-title text-center">Attach Documents</h4>
                                            <div class="dropzone border p-3 text-center" style="height: 445px">
                                                <span>Maximum allowed file size is 25 MB</span> <hr>
                                                <input type="file" class="form-control" name="mail_attachment" id="mail_attachment">
                                                <div class="upload-area"  id="uploadfile">
                                                    <p>Drag and Drop file here<br/>Or<br/>Click to select file</p>
                                                    <small></small>
                                                </div>

                                                <div class="text-left p-3 email-attachments mt-2 slim-scroll" style="height: 180px; overflow-y: auto; overflow-x: hidden;"></div>

                                                <div class="total-upload-size"></div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="close-button text-left">
                                            <button type="reset" class="btn discard-mail btn-danger" data-dismiss="modal" aria-label="Close">
                                                Discard
                                            </button> 
                                        </div>
                                        <div class="text-right text-right">
                                            <button type="submit" class="btn btn-primary">
                                                Send Message <i class="far fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>