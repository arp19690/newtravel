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
                        <div class="clear">
                            <img src="<?php echo getImage($record['user_profile_picture']); ?>" alt="<?php echo stripslashes($record['user_fullname']); ?>" style="width:250px;"/>
                        </div>

                        <div class="clear">
                            <form action="<?php echo base_url('user/changeProfilePicture'); ?>" method="post" enctype="multipart/form-data" class="img-upload-form">
                                <input type="hidden" name="next" value="<?php echo current_url(); ?>"/>
                                <label for="user_img" class="hightile-a" style="padding:10px;cursor:pointer;margin: 0;">Change Image</label>
                                <input type="file" name="user_img" id="user_img" style="display:none;"/>
                            </form>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="contacts-colls-r">
                        <div class="contacts-colls-rb">
                            <div class="contact-colls-lbl">Personal Information</div>
                            <div class="booking-form">
                                <form id="contact_form" action="" method="post">
                                    <div class="clear">
                                        <div class="booking-form-i">
                                            <label>Full Name:</label>
                                            <div class="input"><input type="text" name="user_fullname" placeholder="Enter your full name" required="required" value="<?php echo stripslashes($record['user_fullname']); ?>" /></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Your email:</label>
                                            <div class="input"><?php echo stripslashes($record['user_email']); ?></div>
                                        </div>
                                    </div>

                                    <div class="clear">
                                        <div class="booking-form-i">
                                            <input type="hidden" name="user_gender" class="user_gender_input" value="<?php echo $record['user_gender']; ?>"/>
                                            <div class="form-sex">
                                                <label>Male/Female:</label>
                                                <div class="sex-type <?php echo $record['user_gender'] == 'male' ? 'chosen' : ''; ?>" data-value="male">M</div>
                                                <div class="sex-type <?php echo $record['user_gender'] == 'female' ? 'chosen' : ''; ?>" data-value="female">F</div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Relationship status:</label>
                                            <div class="form-calendar-b">
                                                <select class="custom-select" required="required" name="user_relationship_status">
                                                    <option value="single" <?php echo $record['user_relationship_status'] == 'single' ? 'selected="selected"' : ''; ?>>Single</option>
                                                    <option value="married" <?php echo $record['user_relationship_status'] == 'married' ? 'selected="selected"' : ''; ?>>Married</option>
                                                    <option value="in a relationship" <?php echo $record['user_relationship_status'] == 'in a relationship' ? 'selected="selected"' : ''; ?>>In a relationship</option>
                                                    <option value="complicated" <?php echo $record['user_relationship_status'] == 'complicated' ? 'selected="selected"' : ''; ?>>complicated</option>
                                                    <option value="widowed" <?php echo $record['user_relationship_status'] == 'widowed' ? 'selected="selected"' : ''; ?>>widowed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clear">
                                        <div class="booking-form-i">
                                            <label>Your city:</label>
                                            <div class="input"><input type="text" name="user_location" placeholder="Enter your city" class="gMapLocation-cities" value="<?php echo stripslashes($record['user_location']); ?>"/></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Occupation:</label>
                                            <div class="input"><input type="text" name="user_tagline" placeholder="What's your occupation" value="<?php echo stripslashes($record['user_tagline']); ?>"/></div>
                                        </div>
                                        <div class="clear"></div>

                                        <div class="booking-form-i">
                                            <label>About you:</label>
                                            <div class="textarea"><textarea name="user_about" placeholder="Write something about yourself"/><?php echo stripslashes($record['user_about']); ?></textarea></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <div class="form-calendar" style="float: none;">
                                                <label>Date of Birth:</label>
                                                <?php
                                                $dob_dd = '';
                                                $dob_mm = '';
                                                $dob_yy = '';
                                                if (!empty($record['user_dob']))
                                                {
                                                    $exploded_dob = explode('-', $record['user_dob']);

                                                    $dob_dd = $exploded_dob[2];
                                                    $dob_mm = $exploded_dob[1];
                                                    $dob_yy = $exploded_dob[0];
                                                }
                                                ?>
                                                <div class="form-calendar-a">
                                                    <select class="custom-select" required="required" name="dob_dd">
                                                        <option value="">dd</option>
                                                        <?php
                                                        for ($dd_i = 1; $dd_i <= 31; $dd_i++)
                                                        {
                                                            echo '<option value="' . $dd_i . '" ' . ($dob_dd == $dd_i ? 'selected="selected"' : '' ) . '>' . $dd_i . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-calendar-a">
                                                    <select class="custom-select" required="required" name="dob_mm">
                                                        <option value="">mm</option>
                                                        <?php
                                                        for ($mm_i = 1; $mm_i <= 12; $mm_i++)
                                                        {
                                                            $mm_i = sprintf("%02d", $mm_i);
                                                            echo '<option value="' . $mm_i . '" ' . ($dob_mm == $mm_i ? 'selected="selected"' : '') . '>' . $mm_i . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-calendar-a">
                                                    <select class="custom-select" required="required" name="dob_yy">
                                                        <option value="">year</option>
                                                        <?php
                                                        for ($yy_i = 1947; $yy_i <= date('Y'); $yy_i++)
                                                        {
                                                            echo '<option value="' . $yy_i . '" ' . ($dob_yy == $yy_i ? 'selected="selected"' : '') . '>' . $yy_i . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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

        $('#user_img').change(function () {
            var img_value = $(this).val();
            if (img_value != '')
            {
                $('.img-upload-form').submit();
            }
        });
    });
</script>