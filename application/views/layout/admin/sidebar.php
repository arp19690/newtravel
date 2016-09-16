<!-- Main sidebar -->
<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header"><span>Menu</span> <i class="icon-menu" title="Menu"></i></li>
                    <li class=""><a href="<?php echo base_url_admin(); ?>"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                    <li>
                        <a href="#"><i class="icon-users4"></i> <span>Users</span></a>
                        <ul>
                            <li><a href="<?php echo base_url_admin('users/administrators'); ?>"><i class="icon-user-tie"></i> Administrators</a></li>
                            <li><a href="<?php echo base_url_admin('users/userLog/admin'); ?>"><i class="icon-footprint"></i> Administrator Logs</a></li>
                            <li><a href="<?php echo base_url_admin('users'); ?>"><i class="icon-users"></i> Users</a></li>
                            <li><a href="<?php echo base_url_admin('users/userLog/user'); ?>"><i class="icon-footprint"></i> User Logs</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url_admin('pricing'); ?>"><i class="icon-credit-card"></i> <span>Pricing Plans</span></a></li>
                    <li>
                        <a href="#"><i class="icon-cog3"></i> <span>Settings</span></a>
                        <ul>
                            <li><a href="<?php echo base_url_admin('faq'); ?>"><i class="icon-envelop2"></i> FAQs</a></li>
                            <li><a href="<?php echo base_url_admin('testimonial'); ?>"><i class="icon-pencil"></i> Testimonials</a></li>
                            <li><a href="<?php echo base_url_admin('staticcontent/sample_report'); ?>"><i class="icon-file-empty"></i> Upload Sample Report</a></li>
                            <li><a href="<?php echo base_url_admin('staticcontent/configurations'); ?>"><i class="icon-wrench2"></i> Configurations</a></li>
                            <li><a href="<?php echo base_url_admin('staticcontent'); ?>"><i class="icon-copy2"></i> Static Pages</a></li>
                            <!--<li><a href="<?php echo base_url_admin('staticcontent/updatelogo'); ?>"><i class="icon-image3"></i> Update Logo</a></li>-->
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->