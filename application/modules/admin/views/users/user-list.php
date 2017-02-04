<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-users position-left"></i> Users</h4>
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
                        <h5 class="panel-title">All Users</h5>
                    </div>

                    <div class="panel-body">
                        <table class="table datatable-pagination dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Image</th>
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
                                    $user_image = base_url(getImage($value["user_profile_picture"]));
                                    ?>
                                    <tr>
                                        <td><img src="<?php echo $user_image; ?>" alt="<?php echo $user_fullname; ?>" class="img-circle" style="max-width:75px;"/></td>
                                        <td>
                                            <?php echo $user_fullname; ?>
                                            <?php
                                            if (!empty($value['user_facebook_id']))
                                            {
                                                echo '<div class="help-block"><p><a href="' . getFacebookUserLink($value['user_facebook_id']) . '" target="_blank"><span class="icon-facebook"></span>acebook user</a></p></div>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $user_username; ?></td>
                                        <td><?php echo $value['user_email']; ?></td>
                                        <td class="text-<?php echo $value['user_status'] == '1' ? 'success' : 'danger'; ?>"><?php echo $value['user_status'] == '1' ? 'Active' : (($value['user_status'] == '0') ? 'Inactive' : (($value['user_status'] == '2') ? 'Banned' : 'NA')); ?></td>
                                        <td><a href="<?php echo base_url_admin('users/updateUserStatus/' . $value['user_id'] . '/' . ($value['user_status'] == '1' ? '0' : '1')); ?>" class="btn btn-<?php echo $value['user_status'] == '1' ? 'danger' : 'success'; ?>" onclick="return confirm('Sure to change <?php echo $user_fullname; ?>\'s status');"><?php echo $value['user_status'] == '1' ? 'Inactivate' : 'Activate'; ?></a></td>
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