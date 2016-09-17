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
    <body>

        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo base_url_admin(); ?>">Admin Panel - <?php echo $redis_functions->get_site_setting('SITE_NAME'); ?></a>

                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <span><?php echo $this->session->userdata['admin_fullname']; ?></span>
                            <i class="caret"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo base_url_admin('changepassword'); ?>"><i class="icon-key"></i> Change Password</a></li>
                            <li><a href="<?php echo base_url_admin('logout'); ?>"><i class="icon-switch2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navbar -->


        <!-- Page container -->
        <div class="page-container">

            <!-- Page content -->
            <div class="page-content">

                <?php $this->load->view('layout/admin/sidebar'); ?>
