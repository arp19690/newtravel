<div class="main-cont">	
    <div class="inner-page">
        <div class="inner-breadcrumbs" style="margin: 0;">
            <div class="content-wrapper">
                <div class="page-title">My Account</div>
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
                            <div class="contact-colls-lbl">Personal Information</div>
                            <div class="booking-form">
                                <form id="contact_form" action="" method="post">
                                    <div class="booking-form-i">
                                        <label>Full Name:</label>
                                        <div class="input"><input type="text" name="user_fullname" placeholder="Enter your full name" required="required" value="<?php echo stripslashes($record['user_fullname']); ?>" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <label>Your city:</label>
                                        <div class="input"><input type="text" name="user_location" placeholder="Enter your city" class="gMapLocation-cities" value="<?php echo stripslashes($record['user_location']); ?>"/></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <input type="hidden" name="user_gender" class="user_gender_input" value="<?php echo $record['user_gender']; ?>"/>
                                        <div class="form-sex">
                                            <label>Male/Female:</label>
                                            <div class="sex-type <?php echo $record['user_gender'] == 'male' ? 'chosen' : ''; ?>" data-value="male">M</div>
                                            <div class="sex-type <?php echo $record['user_gender'] == 'female' ? 'chosen' : ''; ?>" data-value="female">F</div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <button type="submit" name="btn_submit" class="contacts-send">Update</button>
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