<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-copy2 position-left"></i> Static Content</h4>
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
                        <h5 class="panel-title">Static Content</h5>
                    </div>

                    <div class="panel-body">
                        <table class="table datatable-pagination dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Page</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($alldata as $key => $value)
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo stripslashes($value['sp_title']); ?></td>
                                        <td><a href="<?php echo base_url_admin('staticcontent/edit/' . $value['sp_id']); ?>" class="btn btn-warning">Edit</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
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