<div class="main-cont">	
    <div class="inner-page">
        <div class="inner-breadcrumbs" style="margin: 0;">
            <div class="content-wrapper">
                <div class="page-title"><?php echo $page_title; ?></div>
                <?php
                if (isset($breadcrumbs) && !empty($breadcrumbs))
                {
                    echo $breadcrumbs;
                }
                ?>
                <div class="clear"></div>
            </div>		
        </div>

        <div class="contacts-page-holder">
            <div class="contacts-page">
                <div class="contacts-colls">
                    <div class="contacts-colls-l">
                        <!--Ads will appear here-->
                        <?php echo get_google_ad(); ?>
                        <div class="clear"></div>
                    </div>

                    <div class="contacts-colls-r">
                        <div class="contacts-colls-rb">
                            <div class="contact-colls-lbl"><?php echo $page_title; ?></div>
                            <div class="booking-form">
                                <form id="contact_form" action="<?php echo base_url('forgot-password'); ?>">
                                    <div class="booking-form-i">
                                        <label>Your registered email:</label>
                                        <div class="input"><input type="email" name="user_email" placeholder="Enter you email" required="required" /></div>
                                    </div>
                                    <div class="clear"></div>
                                    <button type="submit" class="contacts-send">Submit</button>
                                    <a href="<?php echo base_url('login'); ?>" style="margin-left: 25px;" class="a-no-underline">Login</a>
                                    <div class="clear"></div>
                                </form>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>	
            </div>
        </div>
    </div>
</div>