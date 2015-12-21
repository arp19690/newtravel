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
                                <form id="contact_form" action="<?php echo base_url('register?next=' . current_url()); ?>">
                                    <div class="booking-form-i">
                                        <label>Full Name:</label>
                                        <div class="input"><input type="text" name="user_fullname" placeholder="Enter you full name" required="required" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <label>Your city:</label>
                                        <div class="input"><input type="text" name="user_location" placeholder="Enter you city" class="gMapLocation-cities" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <label>Email:</label>
                                        <div class="input"><input type="email" name="user_email" placeholder="Enter you email" required="required" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <label>Password:</label>
                                        <div class="input"><input type="password" name="user_password" placeholder="Enter your password" required="required" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <input type="hidden" name="user_gender" class="user_gender_input" value="male"/>
                                        <div class="form-sex">
                                            <label>Male/Female:</label>
                                            <div class="sex-type chosen" data-value="male">M</div>
                                            <div class="sex-type" data-value="female">F</div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <button type="submit" class="contacts-send">Register</button>
                                    <a href="<?php echo base_url('login'); ?>" style="margin-left: 25px;" class="a-no-underline">Already have an account?</a>
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
<script>
    $(document).ready(function () {
        $('.form-sex div.sex-type').click(function () {
            $('.form-sex div.sex-type').removeClass('chosen');
            $(this).addClass('chosen');
            var gender = $(this).attr('data-value');
            $('.user_gender_input').val(gender);
        });
    });
</script>