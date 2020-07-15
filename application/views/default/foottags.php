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
    <script>
        confirmNotice("dashboard");
        <?php if(confirm_url_id(0, "events-edit") && isset($eventData)) { ?>
        <?php if(!in_array($eventData->state, ["pending"])) { ?>
        $(`form[class~="appForm"] *`).prop("disabled", true);
        <?php } ?>
        <?php } ?>
    </script>
</body>
</html>
