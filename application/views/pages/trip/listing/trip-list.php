<div class="two-colls-right-b">
    <div class="padding">

        <?php $this->load->view('pages/trip/listing/list-header-sort-bar'); ?>

        <div class="catalog-row">
            <?php
            $redis_functions = new Redisfunctions();
            if (!empty($post_records))
            {
                foreach ($post_records as $key => $value)
                {
                    $post_url_key = $value['post_url_key'];
                    $post_details = $redis_functions->get_trip_details($post_url_key);
                    $post_title = stripslashes($post_details['post_title']);
                    $post_description = getNWordsFromString(stripslashes($post_details['post_description']), 40);
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
                    <div class="cat-list-item tour-item fly-in">
                        <div class="cat-list-item-l">
                            <a href="<?php echo $post_url; ?>"><img alt="<?php echo $post_title; ?>" src="<?php echo $post_primary_image; ?>"></a>
                        </div>
                        <div class="cat-list-item-r">
                            <div class="cat-list-item-rb">
                                <div class="cat-list-item-p">
                                    <div class="cat-list-content">
                                        <div class="cat-list-content-a">
                                            <div class="cat-list-content-l">
                                                <div class="cat-list-content-lb">
                                                    <div class="cat-list-content-lpadding">
                                                        <div class="tour-item-a">
                                                            <div class="tour-item-lbl"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></div>
                                                            <div class="tour-item-date"><?php echo $post_start_end_date_string; ?></div>
                                                        </div>
                                                        <div class="tour-item-devider"></div>
                                                        <div class="tour-item-b">
                                                            <p><?php echo $post_description; ?></p>
                                                            <div class="tour-item-footer">
                                                                <div class="tour-i-holder">
                                                                    <div class="tour-item-icons">
                                                                        <?php
                                                                        if (!empty($post_details->post_media->images))
                                                                        {
                                                                            foreach ($post_details->post_media->images as $key => $value)
                                                                            {
                                                                                echo '<img alt="' . $post_title . '" src="' . getimagesize($value['pm_media_url']) . '">';
                                                                            }
                                                                        }
                                                                        ?>
        <!--                                                                        <img alt="" src="<?php echo IMAGES_PATH; ?>/tour-icon-01.png">
                                                                        <span class="tour-item-plus"><img alt="" src="<?php echo IMAGES_PATH; ?>/tour-icon.png"></span>
                                                                        <img alt="" src="<?php echo IMAGES_PATH; ?>/tour-icon-02.png">-->
                                                                    </div>
                                                                    <div class="tour-icon-txt">Via : <?php echo $post_details['post_travel_mediums_string']; ?></div>
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div class="tour-duration">Trip Duration : <?php echo $post_total_days; ?> days</div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br class="clear">
                                            </div>
                                        </div>
                                        <div class="cat-list-content-r">
                                            <div class="cat-list-content-p">
                                                <?php
                                                count($post_details['post_comments']) > 0 ? '<div class="cat-list-review">' . number_format(count($post_details['post_comments'])) . ' reviews</div>' : ''
                                                ?>
                                                <div class="offer-slider-r">
                                                    <b><?php echo $post_total_cost; ?></b>
                                                    <span>trip budget</span>
                                                </div>           
                                                <a class="cat-list-btn" href="<?php echo $post_url; ?>">View</a>   
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                            <br class="clear">
                        </div>
                        <div class="clear"></div>
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

        <?php $this->load->view('pages/trip/listing/pagination'); ?>

    </div>
</div>