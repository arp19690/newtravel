<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-image3 position-left"></i> Update Logo</h4>
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
                        <h5 class="panel-title">Update Logo</h5>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <fieldset class="content-group">

                                <div class="form-group">
                                    <label class="control-label col-lg-2">Current Logo</label>
                                    <div class="col-lg-10">
                                        <img src="<?php echo IMAGES_PATH; ?>/logo.png" alt="<?php echo SITE_NAME; ?>" width="190" style="max-width: 190px;"/>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top: 30px;">
                                    <label class="control-label col-lg-2">Replace Logo</label>
                                    <div class="col-lg-10">
                                        <input type="file" name="new_logo" class="form-control" required="required"/>
                                        <span class="help-block"><strong>Width: </strong><?php echo LOGO_WIDTH; ?>px, <strong>Height: </strong><?php echo LOGO_HEIGHT; ?>px</span>
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