<?php
$redis_functions = new Redisfunctions();
?>
<footer class="footer-a">
    <div class="wrapper-padding">
        <div class="section">
            <div class="footer-lbl">Company</div>
            <div class="footer-adress">Address: 58911 Lepzig Hore,<br />85000 Vienna, Austria</div>
            <div class="footer-phones">Telephones: +1 777 55-32-21</div>
            <div class="footer-email">E-mail: contacts@miracle.com</div>
            <div class="footer-skype">Skype: angelotours</div>
        </div>
        <div class="section">
            <div class="footer-lbl">Featured deals</div>
            <div class="footer-tours">
                <!-- // -->
                <div class="footer-tour">
                    <div class="footer-tour-l"><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/f-tour-01.jpg" /></a></div>
                    <div class="footer-tour-r">
                        <div class="footer-tour-a">amsterdam tour</div>
                        <div class="footer-tour-b">location: netherlands</div>
                        <div class="footer-tour-c">800$</div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- \\ -->
                <!-- // -->
                <div class="footer-tour">
                    <div class="footer-tour-l"><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/f-tour-02.jpg" /></a></div>
                    <div class="footer-tour-r">
                        <div class="footer-tour-a">Kiev tour</div>
                        <div class="footer-tour-b">location: ukraine</div>
                        <div class="footer-tour-c">550$</div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- \\ -->			
                <!-- // -->
                <div class="footer-tour">
                    <div class="footer-tour-l"><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/f-tour-03.jpg" /></a></div>
                    <div class="footer-tour-r">
                        <div class="footer-tour-a">vienna tour</div>
                        <div class="footer-tour-b">location: austria</div>
                        <div class="footer-tour-c">940$</div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- \\ -->
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
            <a href="<?php echo get_external_url($redis_functions->get_site_setting('TWITTER_SOCIAL_LINK')); ?>" target="_blank" class="social-twitter"></a>
            <a href="<?php echo get_external_url($redis_functions->get_site_setting('FACEBOOK_SOCIAL_LINK')); ?>" target="_blank" class="social-facebook"></a>
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
<script type="text/javascript" src="<?php echo JS_PATH; ?>/twitterfeed.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>/application.js"></script>
<!-- \\ scripts \\ --> 

</body>  
</html> 