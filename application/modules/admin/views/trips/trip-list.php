<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-users position-left"></i> All Trips</h4>
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
                        <h5 class="panel-title">All Trips</h5>
                    </div>

                    <div class="panel-body">
                        <table class="table datatable-pagination dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Username</th>
                                    <th>Budget</th>
                                    <th>Rating</th>
                                    <th>Last Updated</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($alldata as $key => $value)
                                {
                                    $post_title = stripslashes($value['post_title']);
                                    $user_username = stripslashes($value['post_user_username']);
                                    ?>
                                    <tr>
                                        <td><a href="<?php echo base_url_admin('trips/detail/' . $value['post_id']); ?>"><?php echo $post_title; ?></a></td>
                                        <td><?php echo $user_username; ?></td>
                                        <td><?php echo get_currency_symbol($value["post_currency"]) . $value["post_total_cost"]; ?></td>
                                        <td><?php echo $value["post_aggregate_ratings"]; ?></td>
                                        <td><?php echo $value["post_updated_on"]; ?></td>
                                        <td class="text-<?php echo $value['post_status'] == '1' ? 'success' : 'danger'; ?>"><?php echo $value['post_status'] == '1' ? 'Active' : (($value['post_status'] == '0') ? 'Inactive' : (($value['post_status'] == '2') ? 'Banned' : 'NA')); ?></td>
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