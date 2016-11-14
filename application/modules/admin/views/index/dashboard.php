<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-home4 position-left"></i> Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <?php $this->load->view('layout/admin/notification-section'); ?>

        <!-- Quick stats boxes -->
        <div class="row">
            <div class="col-lg-4">

                <!-- Members online -->
                <div class="panel bg-teal-400">
                    <div class="panel-body">
                        <h3 class="no-margin"><?php echo number_format($total_users); ?></h3>
                        Total Users
                    </div>
                </div>
                <!-- /members online -->

            </div>

            <div class="col-lg-4">

                <!-- Current server load -->
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <h3 class="no-margin">0</h3>
                        Total Reports Generated
                    </div>
                </div>
                <!-- /current server load -->

            </div>

            <div class="col-lg-4">

                <!-- Today's revenue -->
                <div class="panel bg-blue-400">
                    <div class="panel-body">
                        <h3 class="no-margin">$18,390</h3>
                        Total Earnings
                    </div>
                </div>
                <!-- /today's revenue -->

            </div>
        </div>
        <!-- /quick stats boxes -->
    </div>
    <!-- /content area -->

</div>
<!-- /main content -->