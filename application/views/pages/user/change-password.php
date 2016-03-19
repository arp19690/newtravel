<div class="main-cont">	
    <div class="inner-page">
        <div class="inner-breadcrumbs" style="margin: 0;">
            <div class="content-wrapper">
                <div class="page-title">Change Password</div>
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
                        <div class="clear"></div>
                    </div>

                    <div class="contacts-colls-r">
                        <div class="contacts-colls-rb">
                            <div class="contact-colls-lbl">Enter New Password</div>
                            <div class="booking-form">
                                <form id="contact_form" action="" method="post">
                                    <div class="clear">
                                        <div class="booking-form-i">
                                            <label>New Password:</label>
                                            <div class="input"><input type="password" name="new_password" placeholder="Enter new password" required="required" /></div>
                                        </div>
                                    </div>

                                    <div class="clear">
                                        <div class="booking-form-i">
                                            <label>Confirm Password:</label>
                                            <div class="input"><input type="password" name="confirm_password" placeholder="Confirm password" required="required" /></div>
                                        </div>
                                    </div>

                                    <div class="clear form-update-btn hidden">
                                        <button type="submit" name="btn_submit" class="contacts-send">Update</button>
                                    </div>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('input[type="password"]').keyup(function () {
            var new_pass = $('input[name="new_password"]').val();
            var confirm_pass = $('input[name="confirm_password"]').val();
            if (new_pass === confirm_pass && new_pass != null && confirm_pass != null)
            {
                $('.form-update-btn').removeClass('hidden');
            }
            else
            {
                $('.form-update-btn').addClass('hidden');
            }
        });
    });
</script>