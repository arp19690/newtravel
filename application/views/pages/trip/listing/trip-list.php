<div class="two-colls-right-b" itemscope itemtype="http://schema.org/Event">
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

                    $post_region_cities = array();
                    if (!empty($post_details['post_regions']))
                    {
                        foreach ($post_details['post_regions'] as $region_key => $region_value)
                        {
                            if (!in_array($region_value->pr_source_city, $post_region_cities))
                            {
                                $post_region_cities[] = $region_value->pr_source_city;
                            }
                        }
                    }
                    ?>
                    <!-- // -->
                    <div class="cat-list-item tour-item fly-in" itemscope itemtype="http://schema.org/Product">
                        <div class="cat-list-item-l">
                            <a itemprop="url" href="<?php echo $post_url; ?>" class="trip-a-tag">
                                <img itemprop="image" alt="<?php echo $post_title; ?>" src="<?php echo $post_primary_image; ?>">
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
                                                            <div class="tour-item-lbl" itemprop="name"><a itemprop="url" href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></div>
                                                            <div class="tour-item-date"><?php echo $post_start_end_date_string; ?></div>
                                                            <div class="tour-item-date" style="margin-top: 4px;"><?php echo implode(' > ', $post_region_cities); ?></div>
                                                        </div>
                                                        <div class="tour-item-devider"></div>
                                                        <div class="tour-item-b">
                                                            <p><span itemprop="description"><?php echo $post_description; ?></span></p>
                                                            <div class="tour-item-footer">
                                                                <div class="tour-i-holder">
                                                                    <div class="tour-icon-txt">Via : <?php echo $post_details['post_travel_mediums_string']; ?></div>
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div class="tour-duration">Trip Duration : <?php echo $post_total_days; ?> days</div>
                                                                <meta itemprop="duration" content="<?php echo $post_total_days; ?>D" />
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
                                                count($post_details['post_ratings']) > 0 ? ('<div class="cat-list-review">' . number_format(count($post_details['post_ratings'])) . ' reviews</div>') : ''
                                                ?>
                                                <div class="offer-slider-r" itemscope itemtype="http://schema.org/Offer">
                                                    <div itemprop="priceCurrency" content="<?php echo strtoupper($post_details['post_currency']); ?>">
                                                        <div itemprop="price" content="<?php echo number_format($post_details['post_total_cost'], 2); ?>"><b><?php echo $post_total_cost; ?></b></div>
                                                        <span>trip budget</span>
                                                    </div>
                                                </div>           
                                                <a itemprop="url" class="cat-list-btn" href="<?php echo $post_url; ?>"><span class="fa fa-search"></span>&nbsp;&nbsp;View</a>   
                                                <a class="btn btn-orange margin-top-10" href="<?php echo base_url('trip/post/edit/1/' . stripslashes($post_details['post_url_key'])); ?>"><span class="fa fa-pencil"></span>&nbsp;&nbsp;Edit</a>   
                                                <a class="text-center display-block margin-top-40 clr-light-grey no-text-decoration" href="<?php echo base_url('trip/delete/' . stripslashes($post_details['post_url_key'])); ?>" onclick="return confirm('Sure you want to delete your trip?');"><span class="fa fa-trash"></span>&nbsp;&nbsp;Delete</a>   
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
                ?>
                <div class="cat-list-item tour-item fly-in">
                    <h4 style="font-weight: normal;text-align: center;font-family: 'Raleway';"> No results found</h4>
                </div>
                <?php
            }
            ?>

        </div>

        <div class="clear"></div>

        <?php $this->load->view('pages/trip/listing/pagination'); ?>

    </div>
</div>