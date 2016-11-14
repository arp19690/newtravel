<?php
$redis_functions = new Redisfunctions();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="NOINDEX, NOFOLLOW">
        <title>Admin Panel - <?php echo $redis_functions->get_site_setting('SITE_NAME'); ?></title>

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_ASSETS_PATH; ?>/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_ASSETS_PATH; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_ASSETS_PATH; ?>/css/core.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_ASSETS_PATH; ?>/css/components.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ADMIN_ASSETS_PATH; ?>/css/colors.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo ADMIN_ASSETS_PATH; ?>/js/core/libraries/jquery.min.js"></script>
    </head>

    <body class="bg-slate-800">

        <!-- Page container -->
        <div class="page-container login-container">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Content area -->
                    <div class="content">

                        <!-- Advanced login -->
                        <form action="" method="post">
                            <div class="panel panel-body login-form">
                                <div class="text-center">
                                    <div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>
                                    <h5 class="content-group-lg">Login to your account <small class="display-block">Enter your credentials</small></h5>
                                    <?php
                                    if ($this->session->flashdata('error'))
                                    {
                                        echo '<p class="text-danger">' . $this->session->flashdata('error') . '</p>';
                                    }
                                    ?>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="text" class="form-control" required="required" name="admin_username" placeholder="Username">
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="password" class="form-control" required="required" name="admin_password" placeholder="Password">
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn bg-blue btn-block">Login <i class="icon-circle-right2 position-right"></i></button>
                                </div>
                            </div>
                        </form>
                        <!-- /advanced login -->


                        <!-- Footer -->
                        <div class="footer text-white">
                            &copy; <?php echo date('Y'); ?>. <a href="<?php echo base_url(); ?>" class="text-white"><?php echo $redis_functions->get_site_setting('SITE_NAME'); ?></a>
                        </div>
                        <!-- /footer -->

                    </div>
                    <!-- /content area -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

        </div>
        <!-- /page container -->

        <script type="text/javascript" src="<?php echo ADMIN_ASSETS_PATH; ?>/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo ADMIN_ASSETS_PATH; ?>/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo ADMIN_ASSETS_PATH; ?>/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo ADMIN_ASSETS_PATH; ?>/js/plugins/forms/styling/uniform.min.js"></script>

        <script type="text/javascript" src="<?php echo ADMIN_ASSETS_PATH; ?>/js/core/app.js"></script>
        <script type="text/javascript" src="<?php echo ADMIN_ASSETS_PATH; ?>/js/pages/login.js"></script>
        <!-- /theme JS files -->
    </body>
</html>