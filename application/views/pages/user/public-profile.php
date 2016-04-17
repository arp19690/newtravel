<style>
    .about-content{background-color: #FFFFFF;padding: 40px 0;}
</style>
<div class="main-cont">	
    <div class="inner-page">
        <div class="inner-breadcrumbs" style="margin: 0;">
            <div class="content-wrapper">
                <div class="page-title"><?php echo stripslashes($page_title); ?></div>
                <?php
                if (isset($breadcrumbs) && !empty($breadcrumbs))
                {
                    echo $breadcrumbs;
                }
                ?>
                <div class="clear"></div>
            </div>		
        </div>

        <div class="about-content">
            <div class="content-wrapper">		
                <div class="tree-colls fly-in">
                    <div class="tree-colls-i about-text">
                        <div class="clear">
                            <img src="<?php echo base_url(getImage($record['user_profile_picture'])); ?>" alt="<?php echo stripslashes($record['user_fullname']); ?>"/>
                        </div>

                        <div class="clear">
                            <a href="<?php echo isset($this->session->userdata['user_id']) == TRUE ? 'some url' : '#'; ?>" class="btn btn-orange" onclick="<?php echo isset($this->session->userdata['user_id']) == TRUE ? '' : 'open_authorize_popup();'; ?>"><span class="fa fa-comments-o"></span>&nbsp;&nbsp;Send Message</a>
                        </div>
                    </div>

                    <div class="tree-colls-i about-text">
                        <div class="clear">
                            <h3 style="margin:0;">About Me:</h3>
                            <p><?php echo stripslashes($record['user_about']); ?></p>
                        </div>

                        <?php
                        if (!empty($record['user_country']))
                        {
                            ?>
                            <div class="clear">
                                <h3 style="margin:0;">Country:</h3>
                                <p><?php echo stripslashes($record['user_country']); ?></p>
                            </div>
                            <?php
                        }
                        ?>

                        <?php
                        if (!empty($record['user_dob']))
                        {
                            ?>
                            <div class="clear">
                                <h3 style="margin:0;">Gender<?php echo!empty($record['user_dob']) == TRUE ? ', Age' : ''; ?>:</h3>
                                <p><?php echo ucwords($record['user_gender']) . (!empty($record['user_dob']) == TRUE ? (', ' . getAge($record['user_dob'])) : ''); ?></p>
                            </div>
                            <?php
                        }
                        ?>

                        <?php
                        if (!empty($record['user_facebook_id']))
                        {
                            ?>
                            <div class="clear">
                                <h3 style="margin:0;">Social connection:</h3>
                                <p><a href="<?php echo getFacebookUserLink($record['user_facebook_id']); ?>" class="team-fb" target="_blank"></a></p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="counters tree-colls-i about-text">
                        <!-- // -->
                        <div class="clear" style="display: inline-block;">
                            <div class="counters-i">
                                <b class="numscroller" data-slno='1' data-min='0' data-max='<?php echo number_format(count($record['trips_posted'])); ?>' data-delay='0' data-increment="2">0</b>
                                <span>Trips posted</span>
                            </div>
                        </div>
                        <!-- \\ -->

                        <!-- // -->
                        <div class="clear" style="display: inline-block;">
                            <div class="counters-i">
                                <b class="numscroller" data-slno='1' data-min='0' data-max='<?php echo number_format(count($record['trips_joined'])); ?>' data-delay='0' data-increment="2">0</b>
                                <span>Trips joined</span>
                            </div>
                        </div>
                        <!-- \\ -->
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo JS_PATH; ?>/numscroller-1.0.js"></script>