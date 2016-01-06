<div class="two-colls-right-b">
    <div class="padding">

        <?php $this->load->view('pages/trip/listing/list-header-sort-bar'); ?>

        <div class="catalog-row grid">
            <?php
            $redis_functions = new Redisfunctions();
            if (!empty($post_records))
            {
                foreach ($post_records as $key => $value)
                {
                    $post_url_key = $value['post_url_key'];
                    $post_details = $redis_functions->get_trip_details($post_url_key);
                    $post_title = stripslashes($post_details['post_title']);
                    $post_description = getNWordsFromString(stripslashes($post_details['post_description']), 20);
                    $post_primary_image = base_url(getImage($post_details['post_primary_image']));
                    $post_url = getTripUrl($post_details['post_url_key']);
                    $post_total_cost = get_currency_symbol($post_details['post_currency']) . $post_details['post_total_cost'];
                    $post_start_end_date_string = '--';
                    if (!empty($post_details['post_start_date']) && !empty($post_details['post_end_date']))
                    {
                        $post_date_format = 'd M Y';
                        $post_start_end_date_string = date($post_date_format, strtotime($post_details['post_start_date'])) . ' - ' . date($post_date_format, strtotime($post_details['post_end_date']));
                    }
                    $post_total_days = number_format($post_details['post_total_days']);
                    ?>
                    <!-- // -->
                    <div class="offer-slider-i catalog-i tour-grid fly-in">
                        <a href="<?php echo $post_url; ?>" class="offer-slider-img">
                            <img alt="<?php echo $post_title; ?>" src="<?php echo $post_primary_image; ?>">
                            <span class="offer-slider-overlay">
                                <span class="offer-slider-btn">view details</span><span></span>
                            </span>
                        </a>
                        <div class="offer-slider-txt">
                            <div class="offer-slider-link"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></div>
                            <div class="offer-slider-l">
                                <div class="offer-slider-location">Duration : <?php echo $post_total_days; ?> days</div>
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
                            <div class="offer-slider-r">
                                <b><?php echo $post_total_cost; ?></b>
                                <span>trip budget</span>
                            </div>
                            <div class="offer-slider-devider"></div>								
                            <div class="clear"></div>
                            <div class="offer-slider-lead"><?php echo $post_description; ?></div>
                            <a href="<?php echo $post_url; ?>" class="cat-list-btn">Select</a>
                        </div>
                    </div>
                    <!-- \\ -->
                    <?php
                }
            }
            else
            {
                
            }
            ?>

        </div>

        <div class="clear"></div>

        <div class="pagination">
            <a class="active" href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <div class="clear"></div>
        </div>            
    </div>
</div>