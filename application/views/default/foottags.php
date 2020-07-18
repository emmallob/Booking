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
    <?php global $rootDir, $SITEURL; ?>
    <script src="<?= "{$baseUrl}assets/js/jquery.js" ?>" type="text/javascript" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/datatables/js/datatable.min.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/datatables/js/datatable.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/select/select.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/sweetalert/sweetalert.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/js/scripts.js"></script>
    <script>var baseUrl = "<?= $rootDir ?>";</script>
    <script src="<?= $rootDir ?>assets/js/tojson.js"></script>
    <script src="<?= $rootDir ?>assets/js/cookies.js"></script>
    <script src="<?= $rootDir ?>assets/js/booking.js"></script>
    <?php if(in_array($SITEURL[0], ["sms-list", "emails-list"])) { ?>
    <script src="<?= $rootDir ?>assets/js/communication.js"></script>
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
    </script>
</body>
</html>
