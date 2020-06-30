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
    </div>
    <?php global $rootDir, $SITEURL; ?>
    <script src="<?= "{$baseUrl}assets/js/jquery.js" ?>" type="text/javascript" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/datatables/js/datatable.min.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/libs/datatables/js/datatable.js" crossorigin="anonymous"></script>
    <script src="<?= $rootDir ?>assets/js/scripts.js"></script>
    <script src="<?= $rootDir ?>assets/js/cookies.js"></script>
    <script src="<?= $rootDir ?>assets/demo/chart-area-demo.js"></script>
    <script src="<?= $rootDir ?>assets/demo/chart-bar-demo.js"></script>
    <script src="<?= $rootDir ?>assets/js/booking.js"></script>
    <sb-customizer project="sb-admin-pro"></sb-customizer>
    <script>
        confirmNotice("dashboard");
    </script>
</body>
</html>
