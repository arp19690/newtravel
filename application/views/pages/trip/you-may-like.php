<?php
if (!empty($you_may_like_records))
{
    ?>
    <div class="h-liked">
        <div class="h-liked-lbl">You May Also Like</div>
        <div class="h-liked-row">
            <?php
            foreach ($you_may_like_records as $ykey => $yvalue)
            {
                $post_title = stripslashes($yvalue['post_title']);
                $post_primary_image = base_url(getImage($yvalue['post_primary_image']));
                $post_url = getTripUrl($yvalue['post_url_key']);
                $post_total_cost = get_currency_symbol($yvalue['post_currency']) . $yvalue['post_total_cost'];
                ?>
                <!-- // -->
                <div class="h-liked-item">
                    <div class="h-liked-item-i">
                        <div class="h-liked-item-l">
                            <a href="<?php echo $post_url; ?>"><img alt="<?php echo $post_title; ?>" src="<?php echo $post_primary_image; ?>"></a>
                        </div>
                        <div class="h-liked-item-c">
                            <div class="h-liked-item-cb">
                                <div class="h-liked-item-p">
                                    <div class="h-liked-title"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></div>
                                    <div class="h-liked-rating">
                                        <nav class="stars">
                                            <ul>
                                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/star-b.png" /></a></li>
                                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/star-b.png" /></a></li>
                                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/star-b.png" /></a></li>
                                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/star-b.png" /></a></li>
                                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/star-a.png" /></a></li>
                                            </ul>
                                            <div class="clear"></div>
                                        </nav>
                                    </div>
                                    <div class="h-liked-foot">
                                        <span class="h-liked-price"><?php echo $post_total_cost; ?></span>
                                        <span class="h-liked-comment">Budget</span>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>	
                </div>
                <!-- \\ -->
                <?php
            }
            ?>
        </div>			
    </div>
    <?php
}