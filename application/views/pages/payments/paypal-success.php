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
                                        <h2>Your Personal Information</h2>

                                        <div class="complete-txt">
                                            <h2>Payment Info</h2>
                                            <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. Que porro quisqua. Sed ut perspiciatis unde omnis ste natus error sit voluptatem.</p>
                                            <div class="complete-txt-link"><a href="#">Payment is made by Via Paypal.</a></div>
                                        </div>

                                        <div class="complete-devider"></div>

                                        <div class="complete-txt final">
                                            <h2>Booking Details</h2>
                                            <p>Qoluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. Que porro quisqua. Sed ut perspiciatis unde omnis ste natus error.</p>
                                            <div class="complete-txt-link"><a href="#">Your Hotel Info</a></div>
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