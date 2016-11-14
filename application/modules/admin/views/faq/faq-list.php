<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-envelop2 position-left"></i> FAQs</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo base_url_admin('faq/add'); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>New FAQ</span></a>
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
                        <h5 class="panel-title">All FAQs</h5>
                    </div>

                    <div class="panel-body">
                        <table class="table datatable-pagination dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($alldata as $key => $value)
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $value['faq_order']; ?></td>
                                        <td><?php echo stripslashes($value['faq_question']); ?></td>
                                        <td><?php echo getNWordsFromString(stripslashes($value['faq_answer']), 20); ?>...</td>
                                        <td class="text-<?php echo $value['faq_status'] == '1' ? 'success' : 'danger'; ?>"><?php echo $value['faq_status'] == '1' ? 'Active' : (($value['faq_status'] == '0') ? 'Inactive' : (($value['faq_status'] == '2') ? 'Deleted' : 'NA')); ?></td>
                                        <td>
                                            <a href="<?php echo base_url_admin('faq/add/' . $value['faq_id']); ?>" class="btn btn-warning">Edit</a>
                                            <a href="<?php echo base_url_admin('faq/updateFAQStatus/' . $value['faq_id'] . '/' . ($value['faq_status'] == '1' ? '0' : '1')); ?>" class="btn btn-<?php echo $value['faq_status'] == '1' ? 'danger' : 'success'; ?>" onclick="return confirm('Sure to change status');"><?php echo $value['faq_status'] == '1' ? 'Inactivate' : 'Activate'; ?></a>
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