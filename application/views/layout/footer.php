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
            <div class="footer-lbl">Twitter widget</div>
            <div class="twitter-wiget">
                <div id="twitter-feed"></div>
            </div>
        </div>
        <div class="section">
            <div class="footer-lbl">newsletter sign up</div>
            <div class="footer-subscribe">
                <div class="footer-subscribe-a">
                    <input type="text" placeholder="you email" value="" />
                </div>
            </div>
            <button class="footer-subscribe-btn">Sign up</button>
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