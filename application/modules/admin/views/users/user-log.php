<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-users position-left"></i> <?php echo $page_heading; ?></h4>
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
                        <h5 class="panel-title"><?php echo $page_heading; ?></h5>
                    </div>

                    <div class="panel-body">
                        <table class="table datatable-pagination dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Login Time</th>
                                    <th>Logout Time</th>
                                    <th>IP Address</th>
                                    <th>OS - Browser</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($alldata as $key => $value)
                                {
                                    $user_fullname = stripslashes($value['user_fullname']);
                                    ?>
                                    <tr>
                                        <td><?php echo $user_fullname; ?></td>
                                        <td><?php echo date('d M Y g:i A', strtotime($value['ul_login_timestamp'])); ?></td>
                                        <td><?php echo $value['ul_logout_timestamp'] == NULL ? 'NA' : (date('d M Y g:i A', strtotime($value['ul_logout_timestamp']))); ?></td>
                                        <td><?php echo $value['ul_ipaddress']; ?></td>
                                        <td><?php echo getClientOS($value['ul_useragent']) . ' - ' . getClientBrowserName($value['ul_useragent']); ?></td>
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