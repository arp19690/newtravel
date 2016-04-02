<!-- main-cont -->
<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title"><?php echo stripslashes($post_details['post_title']); ?> - <span>Payment confirmed</span></div>
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
                                    <h2><?php echo stripslashes($feature_plan_details['pfm_title']); ?></h2>

                                    <div class="comlete-alert">
                                        <div class="comlete-alert-a">
                                            <b>Thank You. Your Payment has been confirmed.</b>
                                            <span>And your post has been added to our featured list</span>
                                        </div>
                                    </div>

                                    <div class="complete-info">
                                        <div class="complete-txt">
                                            <h2>Payment Info</h2>
                                            <p>You post <a href="<?php echo getTripUrl($post_details['post_url_key']); ?>"><?php echo stripslashes($post_details['post_title']); ?></a> has been added to our featured list until <?php echo date('d-M-Y g:i A', time() + ($feature_plan_details['pfm_hours'] * 60 * 60)); ?></p>
                                            <p>Your payment reference number is <strong>#<?php echo $payment_reference_number; ?></strong></p>
                                        </div>

                                        <div class="complete-devider"></div>

                                        <div class="complete-txt final">
                                            <h2>Share it with your friends</h2>
                                            <p>Let your friends know about it. Spread out a word about your post on your Facebook wall.</p>
                                            <div class="complete-txt-link"><a href="<?php echo getShareWithFacebook(getTripUrl($post_details['post_url_key'])); ?>" target="_blank">Click here to share</a></div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="sp-page-r">
                    <?php
                    echo get_google_ad();
                    ?>
                </div>
                <div class="clear"></div>
            </div>

        </div>	
    </div>  
</div>
<!-- /main-cont -->