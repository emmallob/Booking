<?php 
// preset the base url
$baseUrl = $config->base_url();

#REDIRECT THE USER IF NOT LOGGED IN
if($usersClass->logged_InControlled()) {
	require "dashboard.php";
	exit(-1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>Login - <?= config_item("site_name") ?></title>
        <link href="<?= $baseUrl ?>assets/css/styles.css" rel="stylesheet" />
        <link href='<?= "{$baseUrl}assets/libs/sweetalert/sweetalert.css" ?>' rel="stylesheet" type="text/css" />
        <link rel="icon" type="image/x-icon" href="<?= $baseUrl ?>assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="<?= $baseUrl ?>assets/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
        <style>
        .bg {
            background-image: url('<?= $baseUrl ?>assets/img/bg.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        main {
            margin-top: 100px;
        }

        footer.footer {
            background: #3a2e2b;
            height: 3rem;
        }
        </style>
    </head>
    <body class="bg-primary bg">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="POST" id="authForm" action="<?= $baseUrl ?>auth/login">
                                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" id="inputEmailAddress" name="username" type="email" placeholder="Enter email address / Username" />
                                            </div>
                                            <div class="form-group"><label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" id="inputPassword" name="password" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox"><input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" /><label class="custom-control-label" for="rememberPasswordCheck">Remember password</label></div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="<?= $baseUrl ?>recover">Forgot Password?</a>
                                                <button class="btn btn-primary" type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer mt-auto footer-dark">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; <?= config_item("site_name") ?> <?= date("Y") ?></div>
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
        <script src="<?= $baseUrl ?>assets/js/jquery.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/libs/sweetalert/sweetalert.js" crossorigin="anonymous"></script>
        <script src="<?= $baseUrl ?>assets/js/login.js"></script>
        <sb-customizer project="sb-admin-pro"></sb-customizer>
    </body>
</html>
