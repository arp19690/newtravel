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
                        ?>
                        <div class="offer-slider">
                            <div class="fly-in offer-slider-c">
                                <div id="offers-a" class="owl-slider">
                                    <!-- // -->
                                    <div class="offer-slider-i">
                                        <a class="offer-slider-img" href="<?php echo $trip_url; ?>">
                                            <img alt="<?php echo $trip_title; ?>" src="<?php echo $trip_primary_image; ?>" />
                                            <span class="offer-slider-overlay">
                                                <span class="offer-slider-btn">view details</span>
                                            </span>
                                        </a>
                                        <div class="offer-slider-txt">
                                            <div class="offer-slider-link"><a href="<?php echo $trip_url; ?>"><?php echo $trip_title; ?></a></div>
                                            <div class="offer-slider-l">
                                                <div class="offer-slider-location"><?php echo $trip_start_end_date_string; ?></div>
                                            </div>
                                            <div class="offer-slider-r align-right">
                                                <b><?php echo $trip_total_cost; ?></b>
                                                <span>budget</span>
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
                            <map id="imgmap201410281607" name="imgmap201410281607">
                                <!--img alt="" usemap="#imgmap201410281607" width="347" height="177" src="<?php echo IMAGES_PATH; ?>/world.png" id="imgmap201410281607">
                            <area id="africa" shape="poly" alt="africa" title="" coords="183,153,173,129,176,115,170,107,163,97,145,98,138,85,141,75,149,63,161,58,169,57,173,56,172,61,182,65,185,62,199,65,204,77,211,89,212,92,222,92,221,96,210,110,207,117,221,125,217,141,203,138,192,152" href="" />
                            <area id="asia" shape="poly" alt="asia" title="" coords="256,96,259,93,260,83,269,76,277,86,281,96,278,102,289,116,304,111,309,99,295,87,306,70,312,58,311,47,316,39,308,33,306,27,319,29,329,40,331,28,340,20,336,15,311,14,289,11,282,10,280,12,258,10,250,4,236,8,227,12,218,11,223,16,225,23,220,37,222,43,217,45,221,49,221,56,201,58,199,63,202,70,208,79,214,89,225,86,233,77,236,72,247,79" href="" />
                            <area id="europe" shape="poly" alt="europe" title="" coords="191,56,177,55,170,46,157,56,149,54,157,38,171,31,168,20,183,11,197,14,220,16,220,32,218,42,213,47,219,55" href="" />
                            <area id="austalia" shape="poly" alt="australia" title="" coords="302,155,315,150,322,153,327,162,335,161,342,154,342,108,328,103,321,110,326,119,313,128,297,138,296,151" href="" />
                            <area id="north-america" shape="poly" alt="north_america" title="" coords="58,94,55,84,52,79,52,75,42,68,56,67,61,75,66,72,65,61,82,49,90,46,100,42,102,36,102,29,99,21,111,15,115,28,131,18,140,17,156,2,154,0,96,1,90,3,88,9,74,11,66,8,53,8,50,12,35,13,28,10,5,15,0,18,1,32,13,28,22,31,21,42,14,53,18,68,25,76,31,84,40,89" href="" />
                            <area id="south-america" shape="poly" alt="south_america" title="" coords="62,102,68,89,81,92,99,101,99,106,105,109,118,113,117,122,113,126,110,140,103,143,97,156,88,165,75,169,71,137,70,131,56,121,54,113,56,106" href="" /-->
                            </map>						
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