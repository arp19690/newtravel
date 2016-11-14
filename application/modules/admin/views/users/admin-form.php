<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-user-tie position-left"></i> <?php echo $form_heading; ?></h4>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <?php $this->load->view('layout/admin/notification-section'); ?>

        <!-- Collapsible lists -->
        <div class="row">
            <div class="col-md-6">

                <!-- Collapsible list -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><?php echo $form_heading; ?></h5>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="" method="post">
                            <fieldset class="content-group">

                                <div class="form-group">
                                    <label class="control-label col-lg-2">Full Name</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="user_fullname" value="<?php echo stripslashes(@$record['user_fullname']); ?>" class="form-control" required="required"/>
                                    </div>
                                </div>

                                <?php
                                if (empty($record))
                                {
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Username</label>
                                        <div class="col-lg-10">
                                            <input type="text" name="user_username" value="<?php echo stripslashes(@$record['user_username']); ?>" class="form-control" required="required"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Email</label>
                                        <div class="col-lg-10">
                                            <input type="email" name="user_email" value="<?php echo stripslashes(@$record['user_email']); ?>" class="form-control" required="required"/>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </fieldset>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /collapsible list -->

            </div>
        </div>
        <!-- /collapsible lists -->

    </div>
    <!-- /content area -->

</div>
<!-- /main content -->