<?php
$post_title = stripslashes($post_details['post_title']);
$post_description = stripslashes($post_details['post_description']);
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
//prd($post_details);
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
                                <div class="mm-tabs-wrapper">
                                    <!-- // tab item // -->
                                    <div class="tab-item">
                                        <div class="tab-gallery-big">
                                            <img alt="<?php echo $page_title; ?>" src="<?php echo getImage($post_details['post_primary_image']); ?>">
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
                                </div>

                                <div class="content-tabs">
                                    <div class="content-tabs-head last-item">
                                        <nav>
                                            <ul>
                                                <li><a class="active" href="#">DESCRIPTION</a></li>
                                                <li><a href="#" class="reviews-tab-href">reviews</a></li>
                                                <li><a href="#" class="tabs-lamp"></a></li>
                                            </ul>
                                        </nav>

                                        <div class="clear"></div>
                                    </div>
                                    <div class="content-tabs-body">
                                        <!-- // content-tabs-i // -->
                                        <div class="content-tabs-i">
                                            <div class="clear">
                                                <h2>Description</h2>
                                                <div>
                                                    <?php echo $post_description; ?>
                                                </div>
                                            </div>

                                            <div class="clear" style="margin-top:40px;">
                                                <h2>Facilities</h2>
                                                <ul class="preferences-list-alt">
                                                    <?php
                                                    foreach ($post_details['post_activities'] as $key => $value)
                                                    {
                                                        echo '<li class="' . $value->am_icon . '">' . stripslashes($value->am_title) . '</li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>

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

                                        <?php $this->load->view('pages/trip/trip-detail-faq'); ?>

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
                            <div class="h-detail-lbl-a"><?php echo $page_title; ?></div>
                            <div class="h-detail-lbl-b"><?php echo $post_start_end_date_string; ?></div>
                        </div>
                        <div class="h-tour">
                            <div class="tour-icon-txt"><?php echo $post_details['post_travel_mediums_string']; ?></div>
                            <div class="tour-icon-person"><?php echo count($post_details['post_travelers']) . ' traveler' . (count($post_details['post_travelers']) == 1 ? '' : 's'); ?></div>
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
                        <?php
                        if (isset($this->session->userdata['user_id']) && $this->session->userdata['user_id'] != $post_details['post_user_id'])
                        {
                            ?>
                            <a href="#" class="wishlist-btn">
                                <span class="wishlist-btn-l"><i></i></span>
                                <span class="wishlist-btn-r">Add to wish list</span>
                                <div class="clear"></div>
                            </a>
                            <a href="#" class="book-btn">
                                <span class="book-btn-l"><i></i></span>
                                <span class="book-btn-r">book now</span>
                                <div class="clear"></div>
                            </a>
                            <?php
                        }
                        ?>
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

<script src="<?php echo JS_PATH; ?>/bxSlider.js"></script> 
<script type="text/javascript">
    $(document).ready(function () {
        $('.custom-select').customSelect();
        $('.review-ranger').each(function () {
            var $this = $(this);
            var $index = $(this).index();
            if ($index == '0') {
                var $val = '3.0'
            } else if ($index == '1') {
                var $val = '3.8'
            } else if ($index == '2') {
                var $val = '2.8'
            } else if ($index == '3') {
                var $val = '4.8'
            } else if ($index == '4') {
                var $val = '4.3'
            } else if ($index == '5') {
                var $val = '5.0'
            }
            $this.find('.slider-range-min').slider({
                range: "min",
                step: 0.1,
                value: $val,
                min: 0.1,
                max: 5.1,
                create: function (event, ui) {
                    $this.find('.ui-slider-handle').append('<span class="range-holder"><i></i></span>');
                },
                slide: function (event, ui) {
                    $this.find(".range-holder i").text(ui.value);
                }
            });
            $this.find(".range-holder i").text($val);
        });

        $('#reasons-slider').bxSlider({
            infiniteLoop: true,
            speed: 500,
            mode: 'fade',
            minSlides: 1,
            maxSlides: 1,
            moveSlides: 1,
            auto: true,
            slideMargin: 0
        });

        $('#gallery').bxSlider({
            infiniteLoop: true,
            speed: 500,
            slideWidth: 108,
            minSlides: 1,
            maxSlides: 6,
            moveSlides: 1,
            auto: false,
            slideMargin: 7
        });

        $(function () {
            $(document.body).on('appear', '.fly-in', function (e, $affected) {
                $(this).addClass("appeared");
            });
            $('.fly-in').appear({force_process: true});
        });

        $('.h-add-review').click(function (e) {
            e.preventDefault();
            $('.reviews-tab-href').click();
        });
    });
</script>