<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>i2Donate - Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>skins/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/responsive.css">
    <!-- modernizr css -->
    <script src="<?php echo base_url(); ?>skins/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-bg">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="<?php echo base_url(); ?>user/logincheck" name="login" method="post">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                        <!--<p>Hello there, Sign in and start managing your Admin Template</p>-->
                    </div>
                    <?php if($this->session->flashdata('login_message')) { ?>
                        <div role="alert" class="alert alert-danger">
                            <strong><i class="fa fa-close fa-fw"></i> <?php echo $this->session->flashdata('login_message'); ?></strong>
                        </div>
                    <?php } ?>	
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="test" name="username" id="exampleInputEmail1" required>
                            <i class="ti-user"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" id="exampleInputPassword1" required>
                            <i class="ti-lock"></i>
                        </div>
                        <!--<div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div>-->
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                        <!--<div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="register.html">Sign up</a></p>
                        </div>-->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?php echo base_url(); ?>skins/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url(); ?>skins/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="<?php echo base_url(); ?>skins/js/plugins.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/scripts.js"></script>
</body>

</html>