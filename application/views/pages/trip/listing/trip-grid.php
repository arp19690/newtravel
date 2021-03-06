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
                    $value = (array) $value;
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

                    $post_region_cities = array();
                    if (!empty($post_details['post_regions']))
                    {
                        foreach ($post_details['post_regions'] as $region_key => $region_value)
                        {
                            if (!in_array($region_value['pr_source_city'], $post_region_cities))
                            {
                                $post_region_cities[] = $region_value['pr_source_city'];
                            }
                        }
                    }
                    ?>
                    <!-- // -->
                    <div class="offer-slider-i catalog-i tour-grid fly-in" itemscope itemtype="http://schema.org/Event">
                        <a href="<?php echo $post_url; ?>" class="offer-slider-img trip-a-tag" itemprop="url">
                            <img itemprop="image" alt="<?php echo $post_title; ?>" src="<?php echo $post_primary_image; ?>">
                            <span class="offer-slider-overlay">
                                <span class="offer-slider-btn"><span class="fa fa-search"></span>&nbsp;&nbsp;View details</span><span></span>
                            </span>
                            <?php
                            if (!empty($post_details['post_featured']))
                            {
                                ?>
                                <div class="img-featured-tag">
                                    <p class="img-featured-text"><span class="fa fa-star"></span>&nbsp;Featured</p>
                                </div>
                                <?php
                            }
                            ?>
                        </a>
                        <div class="offer-slider-txt">
                            <div class="offer-slider-link"><a href="<?php echo $post_url; ?>"><span itemprop="name"><?php echo $post_title; ?></span></a></div>
                            <div class="offer-slider-l">
                                <div class="offer-slider-location">Duration : <?php echo $post_total_days; ?> days</div>
                                <div class="hidden">
                                    <span itemprop="validFrom" content="<?php echo $post_details['post_start_date']; ?>T00:01"></span>
                                    <span itemprop="validThrough" content="<?php echo $post_details['post_end_date']; ?>T23:59"></span>
                                </div>
                                <meta itemprop="duration" content="<?php echo $post_total_days; ?>D" />
                                <div class="offer-slider-location"><?php echo implode(' > ', $post_region_cities); ?></div>
                            </div>
                            <div class="offer-slider-r" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <div itemprop="priceCurrency" content="<?php echo strtoupper($post_details['post_currency']); ?>">
                                    <div itemprop="price" content="<?php echo number_format($post_details['post_total_cost'], 2); ?>"><b><?php echo $post_total_cost; ?></b></div>
                                    <span>trip budget</span>
                                </div>
                            </div>
                            <div class="offer-slider-devider"></div>								
                            <div class="clear"></div>
                            <div class="offer-slider-lead" itemprop="description"><?php echo $post_description; ?></div>
                            <div class="clear text-center margin-top-20">
                                <a href="<?php echo $post_url; ?>" class="btn"><span class="fa fa-search"></span>&nbsp;&nbsp;View details</a>
                            </div>
                            <div class="clear text-center margin-top-20">
                                <a class="btn" style="padding: 5px 15px;" href="<?php echo base_url('trip/post/edit/1/' . stripslashes($post_details['post_url_key'])); ?>"><span class="fa fa-pencil"></span>&nbsp;&nbsp;Edit</a>   
                                <a class="btn" style="padding: 5px 15px;" href="<?php echo base_url('trip/delete/' . stripslashes($post_details['post_url_key'])); ?>" onclick="return confirm('Sure you want to delete your trip?');"><span class="fa fa-trash"></span>&nbsp;&nbsp;Delete</a>   
                            </div>
                        </div>
                    </div>
                    <!-- \\ -->
                    <?php
                }
            }
            else
            {
                ?>
                <div class="cat-list-item tour-item fly-in">
                    <h4 style="font-weight: normal;text-align: center;font-family: sans-serif;"> No results found</h4>
                </div>
                <?php
            }
            ?>

        </div>

        <div class="clear"></div>
        <?php $this->load->view('pages/trip/listing/pagination'); ?>     
    </div>
</div>