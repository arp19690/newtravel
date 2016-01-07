<?php
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

<!-- main-cont -->
<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title"><?php echo $page_title; ?></div>
                <?php
                if (isset($breadcrumbs) && !empty($breadcrumbs))
                {
                    echo $breadcrumbs;
                }
                ?>
                <div class="clear"></div>
            </div>

            <div class="sp-page">
                <div class="sp-page-a">
                    <div class="sp-page-l">
                        <div class="sp-page-lb">
                            <div class="sp-page-p">
                                <div class="h-tabs">
                                    <div class="h-tabs-left">
                                        <div class="h-tab-i active">
                                            <a href="#" class="h-tab-item-01">
                                                <i></i>
                                                <span>photos</span>
                                                <span class="clear"></span>
                                            </a>
                                        </div>
                                        <div class="h-tab-i">
                                            <a href="#" class="h-tab-item-03">
                                                <i></i>
                                                <span>calendar</span>
                                                <span class="clear"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="h-tabs-right">
                                        <a href="#">
                                            <i></i>
                                            <span>more tours</span>
                                            <div class="clear"></div>
                                        </a>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="mm-tabs-wrapper">
                                    <!-- // tab item // -->
                                    <div class="tab-item">
                                        <div class="tab-gallery-big">
                                            <img alt="" src="img/tour-big.jpg">
                                        </div>
                                        <div class="tab-gallery-preview">
                                            <div id="gallery">
                                                <?php
                                                if (!empty($post_details['post_media']->images))
                                                {
                                                    foreach ($post_details['post_media']->images as $key => $value)
                                                    {
                                                        $image_src = getImage($value->pm_media_url);
                                                        ?>
                                                        <div class="gallery-i <?php echo $value->pm_primary == '1' ? 'active' : ''; ?>">
                                                            <a href="<?php echo $image_src; ?>"><img alt="<?php echo $page_title; ?>" src="<?php echo $image_src; ?>"><span></span></a>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- \\ tab item \\ -->	
                                    <!-- // tab item // -->
                                    <div class="tab-item">
                                        <div class="calendar-tab">
                                            <div class="calendar-tab-select">
                                                <label>Select month</label>
                                                <select class="custom-select">
                                                    <option>january 2015</option>
                                                    <option>january 2015</option>
                                                    <option>january 2015</option>
                                                </select>
                                            </div>


                                            <div class="tab-calendar-colls">
                                                <div class="tab-calendar-collsl">
                                                    <div class="tab-calendar-collslb">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <td>sun</td>
                                                                    <td>mon</td>
                                                                    <td>tue</td>
                                                                    <td>wed</td>
                                                                    <td>thu</td>
                                                                    <td>fri</td>
                                                                    <td>sat</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="date-passed"><span><label></label></span></td>
                                                                    <td class="date-passed"><span><label></label></span></td>
                                                                    <td class="date-passed"><span><label></label></span></td>
                                                                    <td><span><label>1</label></span></td>
                                                                    <td><span><label>2</label></span></td>
                                                                    <td><span><label>3</label></span></td>
                                                                    <td><span><label>4</label></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span><label>5</label></span></td>
                                                                    <td><span><label>6</label></span></td>
                                                                    <td><span><label>7</label></span></td>
                                                                    <td><span><label>8</label></span></td>
                                                                    <td><span><label>9</label></span></td>
                                                                    <td><span><label>10</label></span></td>
                                                                    <td><span><label>11</label></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span><label>12</label></span></td>
                                                                    <td><span><label>13</label></span></td>
                                                                    <td><span><label>14</label></span></td>
                                                                    <td><span><label>15</label></span></td>
                                                                    <td><span><label>16</label></span></td>
                                                                    <td><span><label>17</label></span></td>
                                                                    <td><span><label>18</label></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span><label>19</label></span></td>
                                                                    <td><span><label>20</label></span></td>
                                                                    <td><span><label>21</label></span></td>
                                                                    <td><span><label>22</label></span></td>
                                                                    <td><span><label>23</label></span></td>
                                                                    <td><span><label>24</label></span></td>
                                                                    <td><span><label>25</label></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span><label>26</label></span></td>
                                                                    <td class="date-available"><span><label>27</label></span></td>
                                                                    <td class="date-available"><span><label>28</label></span></td>
                                                                    <td class="date-available"><span><label>29</label></span></td>
                                                                    <td class="date-unavailable"><span><label>30</label></span></td>
                                                                    <td class="date-unavailable"><span><label>31</label></span></td>
                                                                    <td class="date-passed"><span><label></label></span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                            </div>
                                            <div class="tab-calendar-collsr">
                                                <div class="tab-calendar-s">

                                                    <div class="map-symbol passed">
                                                        <div class="map-symbol-l"></div>
                                                        <div class="map-symbol-r">Date past</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="map-symbol available">
                                                        <div class="map-symbol-l"></div>
                                                        <div class="map-symbol-r">available</div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="map-symbol unavailable">
                                                        <div class="map-symbol-l"></div>
                                                        <div class="map-symbol-r">unavailable</div>
                                                        <div class="clear"></div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="clear"></div>

                                        </div>
                                    </div>
                                    <!-- \\ tab item \\ -->	

                                </div>

                                <div class="content-tabs">
                                    <div class="content-tabs-head last-item">
                                        <nav>
                                            <ul>
                                                <li><a class="active" href="#">DESCRIPTION</a></li>
                                                <li><a href="#">Preferences</a></li>
                                                <li><a href="#">reviews</a></li>
                                                <li><a href="#">THINGS TO DO</a></li>
                                                <li><a href="#" class="tabs-lamp"></a></li>
                                            </ul>
                                        </nav>

                                        <div class="clear"></div>
                                    </div>
                                    <div class="content-tabs-body">
                                        <!-- // content-tabs-i // -->
                                        <div class="content-tabs-i">
                                            <h2>Hotel Description</h2>
                                            <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui. voluptatem sequi nesciunt. Neque porro quisqua. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam</p>
                                            <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p>
                                            <div class="tab-reasons">
                                                <h2>4 Reasons to Choose Andrassy Rhai Hotel</h2>
                                                <div class="tab-reasons-h">
                                                    <!-- // -->
                                                    <div class="tab-reasons-i reasons-01">
                                                        <b>fully responsive</b>
                                                        <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia.</p>
                                                    </div>
                                                    <!-- \\ -->
                                                    <!-- // -->
                                                    <div class="tab-reasons-i reasons-02">
                                                        <b>757 verified reviews</b>
                                                        <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia.</p>
                                                    </div>
                                                    <!-- \\ -->
                                                    <!-- // -->
                                                    <div class="tab-reasons-i reasons-03">
                                                        <b>Manage your bookings online</b>
                                                        <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia.</p>
                                                    </div>
                                                    <!-- \\ -->
                                                    <!-- // -->
                                                    <div class="tab-reasons-i reasons-04">
                                                        <b>Booking is safe</b>
                                                        <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia.</p>
                                                    </div>
                                                    <!-- \\ -->
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="facilities">
                                                    <h2>Facilities of Hotel</h2>
                                                    <table>
                                                        <tr>
                                                            <td class="facilities-a">Food & Drink</td>
                                                            <td class="facilities-b">Breakfast in the Room</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="facilities-a">Internet</td>
                                                            <td class="facilities-b"><span class="facility-label">Free! WiFi is available in all areas and is free of charge.</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="facilities-a">Parking</td>
                                                            <td class="facilities-b">Vending Machine (drinks), 24-Hour Front Desk, Express Check-in/Check-out</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="facilities-a">Languages</td>
                                                            <td class="facilities-b">Italian, French, Spanish, English, Arabic</td>
                                                        </tr>
                                                    </table>	
                                                </div>
                                            </div>
                                        </div>
                                        <!-- \\ content-tabs-i \\ -->
                                        <!-- // content-tabs-i // -->
                                        <div class="content-tabs-i">
                                            <h2>Hotel Facilities</h2>
                                            <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. </p>
                                            <ul class="preferences-list">
                                                <li class="internet">High-speed Internet</li>
                                                <li class="conf-room">Conference room</li>
                                                <li class="play-place">Play Place</li>
                                                <li class="restourant">Restourant</li>
                                                <li class="bar">Bar</li>
                                                <li class="doorman">Doorman</li>
                                                <li class="kitchen">Kitchen</li>
                                                <li class="spa">Spa services</li>
                                                <li class="bike">Bike Rental</li>
                                                <li class="entertaiment">Entertaiment</li>
                                                <li class="hot-tub">Hot Tub</li>
                                                <li class="pool">Swimming Pool</li>
                                                <li class="parking">Free parking</li>
                                                <li class="gym">Gym</li>
                                                <li class="tv">TV</li>
                                                <li class="pets">Pets allowed</li>
                                                <li class="handicap">Handicap</li>
                                                <li class="secure">Secure </li>
                                            </ul>
                                            <div class="clear"></div>
                                            <div class="preferences-devider"></div>
                                            <h2>Alternative Style</h2>
                                            <p>Quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt eque porro quisqua.</p>
                                            <ul class="preferences-list-alt">
                                                <li class="internet">High-speed Internet</li>
                                                <li class="parking">Free parking</li>
                                                <li class="gym">Gym</li>
                                                <li class="restourant">Restourant</li>
                                                <li class="pets">Pets allowed</li>
                                                <li class="pool">Swimming Pool</li>
                                                <li class="kitchen">Kitchen</li>
                                                <li class="conf-room">Conference room</li>
                                                <li class="bike">Bike Rental</li>
                                                <li class="entertaiment">Entertaiment</li>
                                                <li class="bar">Bar</li>
                                                <li class="secure">Secure</li>
                                            </ul>
                                            <div class="clear"></div>
                                        </div>
                                        <!-- \\ content-tabs-i \\ -->
                                        <!-- // content-tabs-i // -->
                                        <div class="content-tabs-i">
                                            <div class="reviews-a">

                                                <div class="reviews-c">
                                                    <div class="reviews-l">
                                                        <div class="reviews-total">4.7/5.0</div>
                                                        <nav class="reviews-total-stars">
                                                            <ul>
                                                                <li><a href="#"><img alt="" src="img/r-stars-total-b.png"></a></li>
                                                                <li><a href="#"><img alt="" src="img/r-stars-total-b.png"></a></li>
                                                                <li><a href="#"><img alt="" src="img/r-stars-total-b.png"></a></li>
                                                                <li><a href="#"><img alt="" src="img/r-stars-total-b.png"></a></li>
                                                                <li><a href="#"><img alt="" src="img/r-stars-total-a.png"></a></li>
                                                            </ul>
                                                            <div class="clear"></div>
                                                        </nav>
                                                    </div>
                                                    <div class="reviews-r">
                                                        <div class="reviews-rb">
                                                            <div class="reviews-percents">
                                                                <label>4.7 out of 5 stars</label>
                                                                <div class="reviews-percents-i"><span></span></div>
                                                            </div>
                                                            <div class="reviews-percents">
                                                                <label>100% clients recommeted</label>
                                                                <div class="reviews-percents-i"><span></span></div>
                                                            </div>
                                                        </div>
                                                        <br class="clear" />
                                                    </div>
                                                </div>
                                                <div class="clear"></div>

                                                <div class="reviews-devider"></div>

                                                <div class="hotel-reviews">
                                                    <h2>Hotel Facilities</h2>
                                                    <div class="hotel-reviews-row">
                                                        <!-- // -->
                                                        <div class="hotel-reviews-i">
                                                            <div class="hotel-reviews-left">Cleanlines</div>
                                                            <nav class="hotel-reviews-right">
                                                                <ul>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                </ul>
                                                            </nav>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                        <!-- // -->
                                                        <div class="hotel-reviews-i">
                                                            <div class="hotel-reviews-left">Price</div>
                                                            <nav class="hotel-reviews-right">
                                                                <ul>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-a.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-a.png"></a></li>
                                                                </ul>
                                                            </nav>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                        <!-- // -->
                                                        <div class="hotel-reviews-i">
                                                            <div class="hotel-reviews-left">Sleep Quality</div>
                                                            <nav class="hotel-reviews-right">
                                                                <ul>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-a.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-a.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-a.png"></a></li>
                                                                </ul>
                                                            </nav>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                        <!-- // -->
                                                        <div class="hotel-reviews-i">
                                                            <div class="hotel-reviews-left">Service & Stuff</div>
                                                            <nav class="hotel-reviews-right">
                                                                <ul>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-a.png"></a></li>
                                                                </ul>
                                                            </nav>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                        <!-- // -->
                                                        <div class="hotel-reviews-i">
                                                            <div class="hotel-reviews-left">Location</div>
                                                            <nav class="hotel-reviews-right">
                                                                <ul>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                </ul>
                                                            </nav>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                        <!-- // -->
                                                        <div class="hotel-reviews-i">
                                                            <div class="hotel-reviews-left">Comfort</div>
                                                            <nav class="hotel-reviews-right">
                                                                <ul>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-b.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-a.png"></a></li>
                                                                    <li><a href="#"><img alt="" src="img/sstar-a.png"></a></li>
                                                                </ul>
                                                            </nav>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>

                                                <div class="hotel-reviews-devider"></div>

                                                <div class="guest-reviews">
                                                    <h2>Guest Reviews</h2>
                                                    <div class="guest-reviews-row">
                                                        <!-- // -->
                                                        <div class="guest-reviews-i">
                                                            <div class="guest-reviews-a">
                                                                <div class="guest-reviews-l">
                                                                    <div class="guest-reviews-img">
                                                                        <span>5.0</span>
                                                                        <img alt="" src="img/guest-01.png">
                                                                    </div>
                                                                </div>
                                                                <div class="guest-reviews-r">
                                                                    <div class="guest-reviews-rb">
                                                                        <div class="guest-reviews-b">
                                                                            <div class="guest-reviews-bl">
                                                                                <div class="guest-reviews-blb">
                                                                                    <div class="guest-reviews-lbl">Gabriela King</div>
                                                                                    <div class="guest-reviews-lbl-a">from United Kingdom</div>
                                                                                    <div class="guest-reviews-txt">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt.</div>
                                                                                </div>
                                                                                <br class="clear" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="guest-reviews-br">  													
                                                                            <div class="guest-reviews-padding">
                                                                                <nav>
                                                                                    <ul>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-a.png"></li>
                                                                                    </ul>
                                                                                </nav>
                                                                                <div class="guest-rating">4,5/5.0</div>
                                                                                <div class="clear"></div>
                                                                                <div class="guest-rating-txt">Recomended</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br class="clear" />
                                                                </div>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                        <!-- // -->
                                                        <div class="guest-reviews-i">
                                                            <div class="guest-reviews-a">
                                                                <div class="guest-reviews-l">
                                                                    <div class="guest-reviews-img">
                                                                        <span>5.0</span>
                                                                        <img alt="" src="img/guest-02.png">
                                                                    </div>
                                                                </div>
                                                                <div class="guest-reviews-r">
                                                                    <div class="guest-reviews-rb">
                                                                        <div class="guest-reviews-b">
                                                                            <div class="guest-reviews-bl">
                                                                                <div class="guest-reviews-blb">
                                                                                    <div class="guest-reviews-lbl">Robert Dowson</div>
                                                                                    <div class="guest-reviews-lbl-a">from Austria</div>
                                                                                    <div class="guest-reviews-txt">Qoluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. </div>
                                                                                </div>
                                                                                <br class="clear" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="guest-reviews-br">  													
                                                                            <div class="guest-reviews-padding">
                                                                                <nav>
                                                                                    <ul>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-a.png"></li>
                                                                                    </ul>
                                                                                </nav>
                                                                                <div class="guest-rating">4,5/5.0</div>
                                                                                <div class="clear"></div>
                                                                                <div class="guest-rating-txt">Recomended</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br class="clear" />
                                                                </div>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                        <!-- // -->
                                                        <div class="guest-reviews-i">
                                                            <div class="guest-reviews-a">
                                                                <div class="guest-reviews-l">
                                                                    <div class="guest-reviews-img">
                                                                        <span>4.4</span>
                                                                        <img alt="" src="img/guest-03.png">
                                                                    </div>
                                                                </div>
                                                                <div class="guest-reviews-r">
                                                                    <div class="guest-reviews-rb">
                                                                        <div class="guest-reviews-b">
                                                                            <div class="guest-reviews-bl">
                                                                                <div class="guest-reviews-blb">
                                                                                    <div class="guest-reviews-lbl">Mike Tyson</div>
                                                                                    <div class="guest-reviews-lbl-a">from France</div>
                                                                                    <div class="guest-reviews-txt">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores</div>
                                                                                </div>
                                                                                <br class="clear" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="guest-reviews-br">  													
                                                                            <div class="guest-reviews-padding">
                                                                                <nav>
                                                                                    <ul>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-a.png"></li>
                                                                                    </ul>
                                                                                </nav>
                                                                                <div class="guest-rating">4,5/5.0</div>
                                                                                <div class="clear"></div>
                                                                                <div class="guest-rating-txt">Recomended</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br class="clear" />
                                                                </div>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                        <!-- // -->
                                                        <div class="guest-reviews-i">
                                                            <div class="guest-reviews-a">
                                                                <div class="guest-reviews-l">
                                                                    <div class="guest-reviews-img">
                                                                        <span>5.0</span>
                                                                        <img alt="" src="img/guest-04.png">
                                                                    </div>
                                                                </div>
                                                                <div class="guest-reviews-r">
                                                                    <div class="guest-reviews-rb">
                                                                        <div class="guest-reviews-b">
                                                                            <div class="guest-reviews-bl">
                                                                                <div class="guest-reviews-blb">
                                                                                    <div class="guest-reviews-lbl">Lina King</div>
                                                                                    <div class="guest-reviews-lbl-a">from United Kingdom</div>
                                                                                    <div class="guest-reviews-txt">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores</div>
                                                                                </div>
                                                                                <br class="clear" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="guest-reviews-br">  													
                                                                            <div class="guest-reviews-padding">
                                                                                <nav>
                                                                                    <ul>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-b.png"></li>
                                                                                        <li><img alt="" src="img/g-star-a.png"></li>
                                                                                    </ul>
                                                                                </nav>
                                                                                <div class="guest-rating">4,5/5.0</div>
                                                                                <div class="clear"></div>
                                                                                <div class="guest-rating-txt">Recomended</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br class="clear" />
                                                                </div>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <!-- \\ -->
                                                    </div>
                                                    <a href="#" class="guest-reviews-more">load more reviews</a>

                                                    <div class="review-form">
                                                        <h2>Live Review</h2>
                                                        <label>User Name:</label>
                                                        <input type="text" value="" />
                                                        <label>Your Review:</label>
                                                        <textarea></textarea>

                                                        <div class="review-rangers-row">
                                                            <div class="review-ranger">
                                                                <label>Cleanlines</label>
                                                                <div class="review-ranger-r">
                                                                    <div class="slider-range-min"></div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="review-ranger">
                                                                <label>Service & Stuff</label>
                                                                <div class="review-ranger-r">
                                                                    <div class="slider-range-min"></div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="review-ranger">
                                                                <label>Price</label>
                                                                <div class="review-ranger-r">
                                                                    <div class="slider-range-min"></div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="review-ranger">
                                                                <label>Location</label>
                                                                <div class="review-ranger-r">
                                                                    <div class="slider-range-min"></div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="review-ranger">
                                                                <label>Sleep Quality</label>
                                                                <div class="review-ranger-r">
                                                                    <div class="slider-range-min"></div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="review-ranger">
                                                                <label>Comfort</label>
                                                                <div class="review-ranger-r">
                                                                    <div class="slider-range-min"></div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                        <label>Evaluation</label>
                                                        <select class="custom-select">
                                                            <option>&nbsp;</option>
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                        </select>
                                                        <label>When did you travel?</label>
                                                        <input type="text" value="" />
                                                        <button class="review-send">Submit Review</button>
                                                    </div>              
                                                </div>		
                                            </div>
                                        </div>
                                        <!-- \\ content-tabs-i \\ -->
                                        <!-- // content-tabs-i // -->
                                        <div class="content-tabs-i">
                                            <h2>Things to do</h2>
                                            <p class="small">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. </p>
                                            <div class="todo-devider"></div>
                                            <div class="todo-row">
                                                <!-- // -->
                                                <div class="cat-list-item">
                                                    <div class="cat-list-item-l">
                                                        <a href="#"><img alt="" src="img/todo-01.jpg"></a>
                                                    </div>
                                                    <div class="cat-list-item-r">
                                                        <div class="cat-list-item-rb">
                                                            <div class="cat-list-item-p">
                                                                <div class="cat-list-content">
                                                                    <div class="cat-list-content-a">
                                                                        <div class="cat-list-content-l">
                                                                            <div class="cat-list-content-lb">
                                                                                <div class="cat-list-content-lpadding">
                                                                                    <div class="offer-slider-link"><a href="#">Totam rem aperiam, eaque ipsa quae</a></div>
                                                                                    <div class="offer-rate">Exelent</div>
                                                                                    <p>Voluptatem quia voluptas sit aspernatur aut odit  aut figut, sed quia consequuntur magni dolores eos qui  voluptatem sequi nescuint. Neque porro quisqua. Sed ut perspiciatis  unde omnis ste.</p>
                                                                                </div>
                                                                            </div>
                                                                            <br class="clear">
                                                                        </div>
                                                                    </div>
                                                                    <div class="cat-list-content-r">
                                                                        <div class="cat-list-content-p">
                                                                            <nav class="stars">
                                                                                <ul>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                </ul>
                                                                                <div class="clear"></div>
                                                                            </nav>
                                                                            <div class="cat-list-review">31 reviews</div>
                                                                            <a href="#" class="todo-btn">Read more</a>  
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
                                                <!-- // -->
                                                <div class="cat-list-item">
                                                    <div class="cat-list-item-l">
                                                        <a href="#"><img alt="" src="img/todo-02.jpg"></a>
                                                    </div>
                                                    <div class="cat-list-item-r">
                                                        <div class="cat-list-item-rb">
                                                            <div class="cat-list-item-p">
                                                                <div class="cat-list-content">
                                                                    <div class="cat-list-content-a">
                                                                        <div class="cat-list-content-l">
                                                                            <div class="cat-list-content-lb">
                                                                                <div class="cat-list-content-lpadding">
                                                                                    <div class="offer-slider-link"><a href="#">Invertore veitatis et quasi architecto</a></div>
                                                                                    <div class="offer-rate">Exelent</div>
                                                                                    <p>Voluptatem quia voluptas sit aspernatur aut odit  aut figut, sed quia consequuntur magni dolores eos qui  voluptatem sequi nescuint. Neque porro quisqua. Sed ut perspiciatis  unde omnis ste.</p>
                                                                                </div>
                                                                            </div>
                                                                            <br class="clear">
                                                                        </div>
                                                                    </div>
                                                                    <div class="cat-list-content-r">
                                                                        <div class="cat-list-content-p">
                                                                            <nav class="stars">
                                                                                <ul>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                </ul>
                                                                                <div class="clear"></div>
                                                                            </nav>
                                                                            <div class="cat-list-review">31 reviews</div>
                                                                            <a href="#" class="todo-btn">Read more</a>  
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
                                                <!-- // -->
                                                <div class="cat-list-item">
                                                    <div class="cat-list-item-l">
                                                        <a href="#"><img alt="" src="img/todo-03.jpg"></a>
                                                    </div>
                                                    <div class="cat-list-item-r">
                                                        <div class="cat-list-item-rb">
                                                            <div class="cat-list-item-p">
                                                                <div class="cat-list-content">
                                                                    <div class="cat-list-content-a">
                                                                        <div class="cat-list-content-l">
                                                                            <div class="cat-list-content-lb">
                                                                                <div class="cat-list-content-lpadding">
                                                                                    <div class="offer-slider-link"><a href="#">Dolores eos qui ratione voluptatem</a></div>
                                                                                    <div class="offer-rate">Exelent</div>
                                                                                    <p>Voluptatem quia voluptas sit aspernatur aut odit  aut figut, sed quia consequuntur magni dolores eos qui  voluptatem sequi nescuint. Neque porro quisqua. Sed ut perspiciatis  unde omnis ste.</p>
                                                                                </div>
                                                                            </div>
                                                                            <br class="clear">
                                                                        </div>
                                                                    </div>
                                                                    <div class="cat-list-content-r">
                                                                        <div class="cat-list-content-p">
                                                                            <nav class="stars">
                                                                                <ul>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                </ul>
                                                                                <div class="clear"></div>
                                                                            </nav>
                                                                            <div class="cat-list-review">31 reviews</div>
                                                                            <a href="#" class="todo-btn">Read more</a>  
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
                                                <!-- // -->
                                                <div class="cat-list-item">
                                                    <div class="cat-list-item-l">
                                                        <a href="#"><img alt="" src="img/todo-04.jpg"></a>
                                                    </div>
                                                    <div class="cat-list-item-r">
                                                        <div class="cat-list-item-rb">
                                                            <div class="cat-list-item-p">
                                                                <div class="cat-list-content">
                                                                    <div class="cat-list-content-a">
                                                                        <div class="cat-list-content-l">
                                                                            <div class="cat-list-content-lb">
                                                                                <div class="cat-list-content-lpadding">
                                                                                    <div class="offer-slider-link"><a href="#">Neque porro quisquaem est qui dolorem</a></div>
                                                                                    <div class="offer-rate">Exelent</div>
                                                                                    <p>Voluptatem quia voluptas sit aspernatur aut odit  aut figut, sed quia consequuntur magni dolores eos qui  voluptatem sequi nescuint. Neque porro quisqua. Sed ut perspiciatis  unde omnis ste.</p>
                                                                                </div>
                                                                            </div>
                                                                            <br class="clear">
                                                                        </div>
                                                                    </div>
                                                                    <div class="cat-list-content-r">
                                                                        <div class="cat-list-content-p">
                                                                            <nav class="stars">
                                                                                <ul>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                    <li><a href="#"><img alt="" src="img/todostar-a.png"></a></li>
                                                                                </ul>
                                                                                <div class="clear"></div>
                                                                            </nav>
                                                                            <div class="cat-list-review">31 reviews</div>
                                                                            <a href="#" class="todo-btn">Read more</a>  
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
                                            </div>
                                            <a href="#" class="guest-reviews-more">Load more reviews</a>
                                        </div>
                                        <!-- \\ content-tabs-i \\ -->
                                        <!-- // content-tabs-i // -->
                                        <div class="content-tabs-i">
                                            <h2>FAQ</h2>
                                            <p class="small">Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. </p>
                                            <div class="todo-devider"></div>
                                            <div class="faq-row">
                                                <!-- // -->
                                                <div class="faq-item">
                                                    <div class="faq-item-a">
                                                        <span class="faq-item-left">Totam rem aperiam, eaquie ipsa quae?</span>
                                                        <span class="faq-item-i"></span>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="faq-item-b">
                                                        <div class="faq-item-p">
                                                            Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia aspernatur aut odit aut fugit consequuntur magni dolores eos qui voluptatem sequi nesciunt. aspernatur aut odit aut fugit  
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- \\ -->
                                                <!-- // -->
                                                <div class="faq-item">
                                                    <div class="faq-item-a">
                                                        <span class="faq-item-left">Dolores eos qui ratione voluptatem sequi nescuin?</span>
                                                        <span class="faq-item-i"></span>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="faq-item-b">
                                                        <div class="faq-item-p">
                                                            Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia aspernatur aut odit aut fugit consequuntur magni dolores eos qui voluptatem sequi nesciunt. aspernatur aut odit aut fugit  
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- \\ -->
                                                <!-- // -->
                                                <div class="faq-item">
                                                    <div class="faq-item-a">
                                                        <span class="faq-item-left">Neque porro quisquam est, qui dolorem ipsum?</span>
                                                        <span class="faq-item-i"></span>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="faq-item-b">
                                                        <div class="faq-item-p">
                                                            Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia aspernatur aut odit aut fugit consequuntur magni dolores eos qui voluptatem sequi nesciunt. aspernatur aut odit aut fugit  
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- \\ -->
                                                <!-- // -->
                                                <div class="faq-item">
                                                    <div class="faq-item-a">
                                                        <span class="faq-item-left">Dolor sit amet consectutur adipisci velit, sed?</span>
                                                        <span class="faq-item-i"></span>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="faq-item-b">
                                                        <div class="faq-item-p">
                                                            Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia aspernatur aut odit aut fugit consequuntur magni dolores eos qui voluptatem sequi nesciunt. aspernatur aut odit aut fugit  
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- \\ -->
                                                <!-- // -->
                                                <div class="faq-item">
                                                    <div class="faq-item-a">
                                                        <span class="faq-item-left">Consectetur, adipisci velit, sed quia non numquam?</span>
                                                        <span class="faq-item-i"></span>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="faq-item-b">
                                                        <div class="faq-item-p">
                                                            Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia aspernatur aut odit aut fugit consequuntur magni dolores eos qui voluptatem sequi nesciunt. aspernatur aut odit aut fugit  
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- \\ -->
                                            </div>
                                        </div>
                                        <!-- \\ content-tabs-i \\ -->

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="sp-page-r">
                    <div class="h-detail-r">
                        <div class="h-detail-lbl">
                            <div class="h-detail-lbl-a">Amazing France Tour</div>
                            <div class="h-detail-lbl-b">11 nov 2015 - 22 now 2015</div>
                        </div>
                        <div class="h-tour">
                            <div class="tour-item-icons">
                                <img alt="" src="img/tour-icon-01.png">
                                <span class="tour-item-plus"><img alt="" src="img/tour-icon.png"></span>
                                <img alt="" src="img/tour-icon-02.png">
                            </div>
                            <div class="tour-icon-txt">Air + bus</div>
                            <div class="tour-icon-person">2 persons</div>
                            <div class="clear"></div>
                        </div>
                        <div class="h-detail-stars">
                            <ul class="h-stars-list">
                                <li><a href="#"><img alt="" src="img/hd-star-b.png"></a></li>
                                <li><a href="#"><img alt="" src="img/hd-star-b.png"></a></li>
                                <li><a href="#"><img alt="" src="img/hd-star-b.png"></a></li>
                                <li><a href="#"><img alt="" src="img/hd-star-b.png"></a></li>
                                <li><a href="#"><img alt="" src="img/hd-star-a.png"></a></li>
                            </ul>
                            <div class="h-stars-lbl">156 reviews</div>
                            <a href="#" class="h-add-review">add review</a>
                            <div class="clear"></div>
                        </div>
                        <div class="h-details-text">
                            <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. </p>
                            <p>Neque porro quisqua. Sed ut perspiciatis unde omnis ste natus error sit voluptatem.</p>
                        </div>
                        <a href="#" class="wishlist-btn">
                            <span class="wishlist-btn-l"><i></i></span>
                            <span class="wishlist-btn-r">ADD TO wish list</span>
                            <div class="clear"></div>
                        </a>
                        <a href="#" class="book-btn">
                            <span class="book-btn-l"><i></i></span>
                            <span class="book-btn-r">book now</span>
                            <div class="clear"></div>
                        </a>
                    </div>

                    <div class="h-help">
                        <div class="h-help-lbl">Need Sparrow Help?</div>
                        <div class="h-help-lbl-a">We would be happy to help you!</div>
                        <div class="h-help-phone">2-800-256-124 23</div>
                        <div class="h-help-email">sparrow@mail.com</div>
                    </div>

                    <div class="reasons-rating">
                        <div id="reasons-slider">
                            <!-- // -->
                            <div class="reasons-rating-i">
                                <div class="reasons-rating-txt">Sed ut perspiciatis unde omnis iste natus sit voluptatem accusantium doloremque laudantium, totam.</div>
                                <div class="reasons-rating-user">
                                    <div class="reasons-rating-user-l">
                                        <img alt="" src="img/r-user.png">
                                        <span>5.0</span>
                                    </div>
                                    <div class="reasons-rating-user-r">
                                        <b>Gabriela King</b>
                                        <span>from United Kingdom</span>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <!-- \\ -->
                            <!-- // -->
                            <div class="reasons-rating-i">
                                <div class="reasons-rating-txt">Sed ut perspiciatis unde omnis iste natus sit voluptatem accusantium doloremque laudantium, totam.</div>
                                <div class="reasons-rating-user">
                                    <div class="reasons-rating-user-l">
                                        <img alt="" src="img/r-user.png">
                                        <span>5.0</span>
                                    </div>
                                    <div class="reasons-rating-user-r">
                                        <b>Robert Dowson</b>
                                        <span>from Austria</span>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <!-- \\ -->
                            <!-- // -->
                            <div class="reasons-rating-i">
                                <div class="reasons-rating-txt">Sed ut perspiciatis unde omnis iste natus sit voluptatem accusantium doloremque laudantium, totam.</div>
                                <div class="reasons-rating-user">
                                    <div class="reasons-rating-user-l">
                                        <img alt="" src="img/r-user.png">
                                        <span>5.0</span>
                                    </div>
                                    <div class="reasons-rating-user-r">
                                        <b>Mike Tyson</b>
                                        <span>from France</span>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <!-- \\ -->
                        </div>
                    </div>

                    <div class="h-liked">
                        <div class="h-liked-lbl">You May Also Like</div>
                        <div class="h-liked-row">
                            <!-- // -->
                            <div class="h-liked-item">
                                <div class="h-liked-item-i">
                                    <div class="h-liked-item-l">
                                        <a href="#"><img alt="" src="img/like-01.jpg"></a>
                                    </div>
                                    <div class="h-liked-item-c">
                                        <div class="h-liked-item-cb">
                                            <div class="h-liked-item-p">
                                                <div class="h-liked-title"><a href="#">Andrassy Thai Hotel</a></div>
                                                <div class="h-liked-rating">
                                                    <nav class="stars">
                                                        <ul>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-a.png" /></a></li>
                                                        </ul>
                                                        <div class="clear"></div>
                                                    </nav>
                                                </div>
                                                <div class="h-liked-foot">
                                                    <span class="h-liked-price">850$</span>
                                                    <span class="h-liked-comment">avg/night</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>	
                            </div>
                            <!-- \\ -->
                            <!-- // -->
                            <div class="h-liked-item">
                                <div class="h-liked-item-i">
                                    <div class="h-liked-item-l">
                                        <a href="#"><img alt="" src="img/like-02.jpg"></a>
                                    </div>
                                    <div class="h-liked-item-c">
                                        <div class="h-liked-item-cb">
                                            <div class="h-liked-item-p">
                                                <div class="h-liked-title"><a href="#">Campanile Cracovie</a></div>
                                                <div class="h-liked-rating">
                                                    <nav class="stars">
                                                        <ul>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-a.png" /></a></li>
                                                        </ul>
                                                        <div class="clear"></div>
                                                    </nav>
                                                </div>
                                                <div class="h-liked-foot">
                                                    <span class="h-liked-price">964$</span>
                                                    <span class="h-liked-comment">avg/night</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>	
                            </div>
                            <!-- \\ -->
                            <!-- // -->
                            <div class="h-liked-item">
                                <div class="h-liked-item-i">
                                    <div class="h-liked-item-l">
                                        <a href="#"><img alt="" src="img/like-03.jpg"></a>
                                    </div>
                                    <div class="h-liked-item-c">
                                        <div class="h-liked-item-cb">
                                            <div class="h-liked-item-p">
                                                <div class="h-liked-title"><a href="#">Ermin's Hotel</a></div>
                                                <div class="h-liked-rating">
                                                    <nav class="stars">
                                                        <ul>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-b.png" /></a></li>
                                                            <li><a href="#"><img alt="" src="img/star-a.png" /></a></li>
                                                        </ul>
                                                        <div class="clear"></div>
                                                    </nav>
                                                </div>
                                                <div class="h-liked-foot">
                                                    <span class="h-liked-price">500$</span>
                                                    <span class="h-liked-comment">avg/night</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>	
                            </div>
                            <!-- \\ -->
                        </div>			
                    </div>

                    <div class="h-reasons">
                        <div class="h-liked-lbl">Reasons to Book with us</div>
                        <div class="h-reasons-row">
                            <!-- // -->
                            <div class="reasons-i">
                                <div class="reasons-h">
                                    <div class="reasons-l">
                                        <img alt="" src="img/reasons-a.png">
                                    </div>
                                    <div class="reasons-r">
                                        <div class="reasons-rb">
                                            <div class="reasons-p">
                                                <div class="reasons-i-lbl">Awesome design</div>
                                                <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequunt.</p>
                                            </div>
                                        </div>
                                        <br class="clear" />
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <!-- \\ -->	
                            <!-- // -->
                            <div class="reasons-i">
                                <div class="reasons-h">
                                    <div class="reasons-l">
                                        <img alt="" src="img/reasons-b.png">
                                    </div>
                                    <div class="reasons-r">
                                        <div class="reasons-rb">
                                            <div class="reasons-p">
                                                <div class="reasons-i-lbl">carefylly handcrafted</div>
                                                <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequunt.</p>
                                            </div>
                                        </div>
                                        <br class="clear" />
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <!-- \\ -->	
                            <!-- // -->
                            <div class="reasons-i">
                                <div class="reasons-h">
                                    <div class="reasons-l">
                                        <img alt="" src="img/reasons-c.png">
                                    </div>
                                    <div class="reasons-r">
                                        <div class="reasons-rb">
                                            <div class="reasons-p">
                                                <div class="reasons-i-lbl">sustomer support</div>
                                                <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequunt.</p>
                                            </div>
                                        </div>
                                        <br class="clear" />
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <!-- \\ -->				
                        </div>
                    </div>


                </div>
                <div class="clear"></div>
            </div>

        </div>	
    </div>  
</div>
<!-- /main-cont -->