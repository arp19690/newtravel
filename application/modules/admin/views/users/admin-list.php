<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-users position-left"></i> Administrators</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo base_url_admin('users/add_edit_administrator'); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>New Admin</span></a>
                </div>
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
                        <h5 class="panel-title">All Administrators</h5>
                    </div>

                    <div class="panel-body">
                        <table class="table datatable-pagination dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($alldata as $key => $value)
                                {
                                    $user_fullname = stripslashes($value['user_fullname']);
                                    $user_username = stripslashes($value['user_username']);
                                    ?>
                                    <tr>
                                        <td><?php echo $user_fullname; ?></td>
                                        <td><?php echo $user_username; ?></td>
                                        <td><?php echo $value['user_email']; ?></td>
                                        <td class="text-<?php echo $value['user_status'] == '1' ? 'success' : 'danger'; ?>"><?php echo $value['user_status'] == '1' ? 'Active' : (($value['user_status'] == '0') ? 'Inactive' : (($value['user_status'] == '2') ? 'Banned' : 'NA')); ?></td>
                                        <td>
                                            <a href="<?php echo base_url_admin('users/add_edit_administrator/' . $value['user_id']); ?>" class="btn btn-warning">Edit</a>
                                            <a href="<?php echo base_url_admin('users/updateUserStatus/' . $value['user_id'] . '/' . ($value['user_status'] == '1' ? '0' : '1')); ?>?next=<?php echo current_url();?>" class="btn btn-<?php echo $value['user_status'] == '1' ? 'danger' : 'success'; ?>" onclick="return confirm('Sure to change <?php echo $user_fullname; ?>\'s status');"><?php echo $value['user_status'] == '1' ? 'Inactivate' : 'Activate'; ?></a>
                                        </td>
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