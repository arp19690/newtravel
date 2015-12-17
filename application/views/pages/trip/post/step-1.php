<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title">Trip - <span><?php echo $page_title;?></span></div>
                <?php
                if (isset($breadcrumbs) && !empty($breadcrumbs))
                {
                    echo $breadcrumbs;
                }
                ?>
                <div class="clear"></div>
            </div>

            <div class="sp-page">
                <div class="sp-page-a">
                    <div class="sp-page-l">
                        <div class="sp-page-lb">
                            <div class="sp-page-p">
                                <div class="booking-left">
                                    <form method="POST" action="">
                                        <h2>Trip Information</h2>
                                        <div class="booking-form">
                                            <div class="booking-form-i">
                                                <label>Title:</label>
                                                <div class="input"><input type="text" name="trip_title" required="required" /></div>
                                            </div>
                                            <div class="booking-form-i">
                                                <label>Long Description:</label>
                                                <div class="textarea"><textarea name="trip_description" required="required" minlength="200"></textarea></div>
                                            </div>						
                                        </div>

                                        <div class="clear"></div>

                                        <div class="clear">
                                            <h2>Your trip includes:</h2>

                                            <div class="booking-form">
                                                <?php
                                                if (isset($activity_master) && !empty($activity_master))
                                                {
                                                    foreach ($activity_master as $key => $value)
                                                    {
                                                        ?>
                                                        <div class="checkbox">
                                                            <label><input name="activities[]" type="checkbox" value="<?php echo $value->am_id; ?>" /><?php echo $value->am_title; ?></label>
                                                        </div> 
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="booking-complete">
                                            <button type="submit" class="booking-complete-btn">NEXT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="sp-page-r">
                    <?php $this->load->view('pages/trip/post-right-sidebar'); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>	
    </div>  
</div>