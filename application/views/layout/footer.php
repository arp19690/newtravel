<?php
$redis_functions = new Redisfunctions();
$featured_trips = $redis_functions->get_featured_trips();
$latest_trips = $redis_functions->get_latest_trips();
?>
<footer class="footer-a">
    <div class="wrapper-padding">
        <div class="section">
            <div class="footer-lbl">Featured trips</div>
            <div class="footer-tours">
                <!-- // -->
                <?php
                if (!empty($featured_trips))
                {
                    $i = 0;
                    foreach ($featured_trips as $post_url_key)
                    {
                        $trip_details = $redis_functions->get_trip_details($post_url_key);
                        $trip_title = stripslashes($trip_details['post_title']);
                        $trip_description = getNWordsFromString(stripslashes($trip_details['post_description']), 20);
                        $trip_primary_image = base_url(getImage($trip_details['post_primary_image']));
                        $trip_url = getTripUrl($trip_details['post_url_key']);
                        $trip_total_cost = get_currency_symbol($trip_details['post_currency']) . $trip_details['post_total_cost'];
                        ?>
                        <div class="footer-tour">
                            <div class="footer-tour-l">
                                <a href="<?php echo $trip_url; ?>">
                                    <img alt="<?php echo $trip_title; ?>" src="<?php echo $trip_primary_image; ?>" />
                                </a>
                            </div>
                            <div class="footer-tour-r">
                                <div class="footer-tour-a"><?php echo $trip_title; ?></div>
                                <div class="footer-tour-b"><?php echo $trip_description; ?></div>
                                <div class="footer-tour-c"><?php echo $trip_total_cost; ?></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php
                        $i++;
                        if ($i > 4)
                        {
                            break;
                        }
                    }
                }
                ?>
            </div>
        </div>
        <div class="section">
            <div class="footer-lbl">Latest trips</div>
            <div class="footer-tours">
                <!-- // -->
                <?php
                if (!empty($latest_trips))
                {
                    $i = 0;
                    foreach ($latest_trips as $post_url_key)
                    {
                        $trip_details = $redis_functions->get_trip_details($post_url_key);
                        $trip_title = stripslashes($trip_details['post_title']);
                        $trip_description = getNWordsFromString(stripslashes($trip_details['post_description']), 20);
                        $trip_primary_image = base_url(getImage($trip_details['post_primary_image']));
                        $trip_url = getTripUrl($trip_details['post_url_key']);
                        $trip_total_cost = get_currency_symbol($trip_details['post_currency']) . $trip_details['post_total_cost'];
                        ?>
                        <div class="footer-tour">
                            <div class="footer-tour-l">
                                <a href="<?php echo $trip_url; ?>">
                                    <img alt="<?php echo $trip_title; ?>" src="<?php echo $trip_primary_image; ?>" />
                                </a>
                            </div>
                            <div class="footer-tour-r">
                                <div class="footer-tour-a"><?php echo $trip_title; ?></div>
                                <div class="footer-tour-b"><?php echo $trip_description; ?></div>
                                <div class="footer-tour-c"><?php echo $trip_total_cost; ?></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php
                        $i++;
                        if ($i > 4)
                        {
                            break;
                        }
                    }
                }
                ?>
            </div>
        </div>
        <div class="section">
            <div class="footer-lbl">Facebook Page</div>
            <div class="twitter-wiget">
                <div class="fb-page" data-href="<?php echo $redis_functions->get_site_setting('FACEBOOK_SOCIAL_LINK'); ?>" data-tabs="timeline" data-height="280" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $redis_functions->get_site_setting('FACEBOOK_SOCIAL_LINK'); ?>"><a href="<?php echo $redis_functions->get_site_setting('FACEBOOK_SOCIAL_LINK'); ?>"><?php echo $redis_functions->get_site_setting('SITE_NAME'); ?></a></blockquote></div></div>
            </div>
        </div>
        <div class="section">
            <div class="footer-lbl">Company</div>
            <?php
            $company_arr = array(
                base_url('static/about-us') => 'About us',
//                base_url('static/how-it-works') => 'How it works',
                base_url('static/terms-and-conditions') => 'Terms &amp; Conditions',
                base_url('static/privacy-policy') => 'Privacy Policy',
                base_url('static/contact-us') => 'Contact us',
            );

            foreach ($company_arr as $url => $text)
            {
                ?>
                <div class="footer-tour">
                    <div class="footer-tour-l company-footer">
                        <div class="footer-tour-a"><a href="<?php echo $url; ?>"><?php echo $text; ?></a></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="clear"></div>
</footer>

<footer class="footer-b">
    <div class="wrapper-padding">
        <div class="footer-left">&copy; Copyright <?php echo date('Y'); ?>. All rights reserved.</div>
        <div class="footer-social">
            <a href="<?php echo $redis_functions->get_site_setting('TWITTER_SOCIAL_LINK'); ?>" target="_blank" class="social-twitter track-external-redirect"></a>
            <a href="<?php echo $redis_functions->get_site_setting('FACEBOOK_SOCIAL_LINK'); ?>" target="_blank" class="social-facebook track-external-redirect"></a>
        </div>
        <div class="clear"></div>
    </div>
</footer>

<!-- // scripts // -->
<script src="<?php echo JS_PATH; ?>/idangerous.swiper.js"></script>
<script src="<?php echo JS_PATH; ?>/slideInit.js"></script>
<script src="<?php echo JS_PATH; ?>/jqeury.appear.js"></script>  
<script src="<?php echo JS_PATH; ?>/script.js"></script>
<script src="<?php echo JS_PATH; ?>/owl.carousel.min.js"></script>
<script src="<?php echo JS_PATH; ?>/custom.select.js"></script>  
<script src="<?php echo JS_PATH; ?>/jquery-ui.min.js"></script>
<!--<script type="text/javascript" src="<?php echo JS_PATH; ?>/twitterfeed.js"></script>-->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>/application.js"></script>
<!-- \\ scripts \\ --> 

</body>  
</html> 