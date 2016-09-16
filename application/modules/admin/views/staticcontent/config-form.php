<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-users position-left"></i> <?php echo $form_heading; ?></h4>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <?php $this->load->view('layout/admin/notification-section'); ?>

        <!-- Collapsible lists -->
        <div class="row">
            <div class="col-md-12">

                <!-- Collapsible list -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><?php echo $form_heading; ?></h5>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="" method="post">
                            <fieldset class="content-group">

                                <div class="form-group">
                                    <label class="control-label col-lg-2">Configuration Name</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="setting_title" value="<?php echo stripslashes($record['setting_title']); ?>" class="form-control" required="required"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">Value</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="setting_value" value="<?php echo stripslashes($record['setting_value']); ?>" class="form-control" required="required"/>
                                    </div>
                                </div>

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