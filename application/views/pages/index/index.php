<?php
$redis_functions = new Redisfunctions();
?>
<div class="main-cont">
    <div class="body-padding">
        <?php $this->load->view('pages/index/slider'); ?>

        <div class="mp-offesr">
            <div class="wrapper-padding-a">
                <header class="fly-in" style="margin-bottom: 40px;text-align: center;">
                    <div class="offer-slider-lbl">Our featured trips</div>
                    <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui.</p>
                </header>
                <?php
                if (!empty($featured_trip_keys))
                {
                    $i = 1;
                    foreach ($featured_trip_keys as $post_url_key)
                    {
                        $trip_details = $redis_functions->get_trip_details($post_url_key);
                        $trip_title = stripslashes($trip_details['post_title']);
                        $trip_description = getNWordsFromString(stripslashes($trip_details['post_description']), 20);
                        $trip_primary_image = base_url(getImage($trip_details['post_primary_image']));
                        $trip_url = getTripUrl($trip_details['post_url_key']);
                        $trip_total_cost = get_currency_symbol($trip_details['post_currency']) . $trip_details['post_total_cost'];
                        $trip_start_end_date_string = '--';
                        if (!empty($trip_details['post_start_date']) && !empty($trip_details['post_end_date']))
                        {
                            $trip_date_format = 'd M Y';
                            $trip_start_end_date_string = date($trip_date_format, strtotime($trip_details['post_start_date'])) . ' - ' . date($trip_date_format, strtotime($trip_details['post_end_date']));
                        }

                        $post_region_cities = array();
                        if (!empty($trip_details['post_regions']))
                        {
                            foreach ($trip_details['post_regions'] as $region_key => $region_value)
                            {
                                if (!in_array($region_value->pr_source_city, $post_region_cities))
                                {
                                    $post_region_cities[] = $region_value->pr_source_city;
                                }
                            }
                        }
                        ?>
                        <div class="offer-slider" itemscope itemtype="http://schema.org/Event">
                            <div class="fly-in offer-slider-c">
                                <div id="offers-a" class="owl-slider">
                                    <!-- // -->
                                    <div class="offer-slider-i">
                                        <a itemprop="url" class="offer-slider-img trip-a-tag" href="<?php echo $trip_url; ?>">
                                            <img itemprop="image" alt="<?php echo $trip_title; ?>" src="<?php echo $trip_primary_image; ?>" />
                                            <span class="offer-slider-overlay">
                                                <span class="offer-slider-btn">view details</span>
                                            </span>
                                            <div class="img-featured-tag">
                                                <p class="img-featured-text"><span class="fa fa-star"></span>&nbsp;Featured</p>
                                            </div>
                                        </a>
                                        <div class="offer-slider-txt">
                                            <div class="offer-slider-link"><a href="<?php echo $trip_url; ?>"><span itemprop="name"><?php echo $trip_title; ?></span></a></div>
                                            <div class="offer-slider-l">
                                                <div class="hidden">
                                                    <span itemprop="validFrom" content="<?php echo $trip_details['post_start_date']; ?>T00:01"></span>
                                                    <span itemprop="validThrough" content="<?php echo $trip_details['post_end_date']; ?>T23:59"></span>
                                                </div>
                                                <div class="offer-slider-location"><?php echo $trip_start_end_date_string; ?></div>
                                                <div class="offer-slider-location"><?php echo implode(' > ', $post_region_cities); ?></div>
                                            </div>
                                            <div class="offer-slider-r align-right" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <div itemprop="priceCurrency" content="<?php echo strtoupper($trip_details['post_currency']); ?>">
                                                    <div itemprop="price" content="<?php echo number_format($trip_details['post_total_cost'], 2); ?>"><b><?php echo $trip_total_cost; ?></b></div>
                                                    <span>budget</span>
                                                </div>
                                            </div>
                                            <div class="offer-slider-devider"></div>								
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <!-- \\ -->
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                        if ($i > 12)
                        {
                            break;
                        }
                    }
                }
                ?>
            </div>
        </div>

        <div class="mp-b">
            <div class="wrapper-padding">
                <div class="fly-in mp-b-left">
                    <div class="mp-b-lbl">choose hotel by region</div>
                    <!-- // regions // -->
                    <div class="regions">
                        <div class="regions-holder">					
                            <div class="asia"></div>
                            <div class="africa"></div>
                            <div class="austalia"></div>
                            <div class="europe"></div>
                            <div class="north-america"></div>
                            <div class="south-america"></div>
                        </div>
                    </div>
                    <!-- // regions // -->
                    <nav class="regions-nav">
                        <ul>
                            <li><a class="europe" href="#">Europe</a></li>
                            <li><a class="asia" href="#">Asia</a></li>
                            <li><a class="north-america" href="#">North america</a></li>
                            <li><a class="south-america" href="#">south america</a></li>
                            <li><a class="africa" href="#">africa</a></li>
                            <li><a class="austalia" href="#">australia</a></li>		
                        </ul>
                    </nav>
                </div>
                <div class="fly-in mp-b-right">
                    <div class="mp-b-lbl">reasons to book with us</div>
                    <div class="reasons-item-a">
                        <div class="reasons-lbl">Awesome design</div>
                        <div class="reasons-txt">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui. </div>
                    </div>
                    <div class="reasons-item-b">
                        <div class="reasons-lbl">carefully handcrafted</div>
                        <div class="reasons-txt">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui. </div>
                    </div>
                    <div class="clear"></div>
                    <div class="reasons-item-c">
                        <div class="reasons-lbl">fully responsive</div>
                        <div class="reasons-txt">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui. </div>
                    </div>
                    <div class="reasons-item-d">
                        <div class="reasons-lbl">fully responsive</div>
                        <div class="reasons-txt">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui. </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

    </div>

</div>