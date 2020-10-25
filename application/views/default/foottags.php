    <?php global $loadedJS; ?>
    <footer class="footer mt-auto footer-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 small">Copyright &copy; <?= config_item("site_name") ?> <?= date("Y"); ?></div>
                <div class="col-md-6 text-md-right small">
                    <a href="<?= $baseUrl ?>pages/privacy-policy">Privacy Policy</a>
                    &#xB7;
                    <a href="<?= $baseUrl ?>pages/terms-and-conditions">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
    </div>
    <?php if(in_array($SITEURL[0], ["sms-list", "emails-list"])) { ?>
    <div class="modal fade" id="sendMessageModal" data-backdrop="static" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="p-b-5 semi-bold">Send Message</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">Do you want to proceed in sending this message?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="modal fade" id="deleteModal" data-backdrop="static" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="p-b-5 semi-bold">Delete Item</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">Are you sure you want to proceed with this request? You cannot reverse this action once it has been confirmed.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <?php if(in_array($SITEURL[0], ["sms-list"])) { ?>
    <div class="modal fade" id="topupFormModal" data-backdrop="static" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="p-b-5 semi-bold">Topup Form</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="javascript:void(0)" autocomplete="Off" id="topup-form" class="needs-validation" novalidate="" method="post">
                    <div class="modal-body">
                        <?= form_loader(); ?>
                        <div class="form-row">
                            <div class="col-lg-5 col-md-5">
                                <label for="title">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">GH¢</span>
                                    </div>
                                    <input type="number" name="topup-amount" id="topup-amount" value="" max="1000" placeholder="Maximum of GH¢1000.00" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-1"></div>
                            <div class="col-lg-5 col-md-5">
                                <label for="title">SMS Unit</label>
                                <div class="input-group">
                                    <input type="text" name="topup-unit" id="topup-unit" readonly value="0" class="form-control">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Units</span>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="customer_id" value="null" class="customer_id">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary submit-form" type="submit">
                            <span class="mdi mdi-coins"></span> Top Up
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="email-notification" style="display:none">
        <div class="d-flex row justify-content-between">
            <div class="content"></div>
            <div><i class="fa font-18px fa-times-circle"></i></div>
        </div>
    </div>
    <?php if(in_array($SITEURL[0], ["activity-logs", "profile"])) { ?>
    <div class="modal fade" id="DefaultModalWindow" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="form-content-loader" style="display: none;">
                    <div class="offline-content text-center">
                        <p><i class="fa fa-spin fa-spinner fa-3x"></i></p>
                    </div>
                </div>
                <div class="modal-header clearfix ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" style="font-size:12px"></i></button>
                    <h5 class="p-b-5"><span class="semi-bold"></span></h5>
                </div>
                <div class="default-content text-center">
                    Populating Data... <br><i class="fa fa-spin fa-spinner fa-1x"></i>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cons" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php global $rootDir, $SITEURL; ?>
    <script>var baseUrl = "<?= $rootDir ?>";</script>
    <script src="<?= "{$baseUrl}assets/js/jquery.js" ?>" type="text/javascript" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <?php if(in_array($SITEURL[0], ["dashboard", "reports", "index"])) { ?>
    <script src="<?= $rootDir ?>assets/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <?php } ?>
    <script src="<?= $rootDir ?>assets/libs/datatables/js/datatable.min.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/datatables/js/datatable.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/select/select.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/sweetalert/sweetalert.js" crossorigin="anonymous"></script>
    <script src="<?= $baseUrl; ?>assets/libs/trix/trix.js"></script>
    <script src="<?= $rootDir ?>assets/js/scripts.js"></script>
    <?php if(in_array($SITEURL[0], ["endpoints"])) { ?>
    <script src="<?= $rootDir ?>assets/js/endpoints.js"></script>
    <?php } ?>
    <script src="<?= $rootDir; ?>assets/js/magnify.js"></script>
    <?php if(in_array($SITEURL[0], ["events-add", "events-edit", "halls-add", "halls-edit", "emails-compose"])) { ?>
    <script src="<?= $rootDir ?>assets/libs/summernote/dist/summernote-bs4.min.js"></script>
    <?php } ?>
    <script src="<?= $rootDir ?>assets/js/tojson.js"></script>
    <script src="<?= $rootDir ?>assets/js/cookies.js"></script>
    <script src="<?= $rootDir ?>assets/js/booking.js"></script>
    <?php if(in_array($SITEURL[0], ["sms-list"])) { ?>
    <script src="<?= $rootDir ?>assets/js/communication.js"></script>
    <?php } ?>
    <?php 
    if(isset($loadedJS)) {
        foreach($loadedJS as $eachJS) { ?>
            <script src="<?= $baseUrl; ?><?= $eachJS ?>"></script>
        <?php } ?>
    <?php } ?>
    <script>
        confirmNotice("dashboard");
        <?php if(confirm_url_id(0, "events-edit") && isset($eventData)) { ?>
        <?php if(!in_array($eventData->state, ["pending"])) { ?>
        $(function() {
            $(`form[id="saveRecordWithAttachment"] *`).prop("disabled", true);
        })
        <?php } else { ?>
        deleteItem();
        <?php } ?>
        <?php } ?>
        <?php if(confirm_url_id(0, "users-add")) { ?>
        $(`input[name="email"]`).on('keyup', function() {
            username = $(this).val().split("@")[0];
            $(`input[name="username"]`).val(username);
        });
        <?php } ?>
        <?php if(isset($_GET["end_id"]) && preg_match("/^[a-z0-9]+$/", $_GET["end_id"])) { ?>
            // $(`button[data-function="update"][data-item="<?= $_GET["end_id"] ?>"]`).trigger("click");
        <?php } ?>
    </script>
</body>
</html>
