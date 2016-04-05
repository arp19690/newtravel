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

<!-- main-cont -->
<div class="main-cont">
    <div class="body-wrapper" itemscope itemtype="http://schema.org/Event">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title" itemprop="name"><?php echo $page_title; ?></div>
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
                                            <img alt="<?php echo $page_title; ?>" src="<?php echo base_url(getImage($post_details['post_primary_image'])); ?>">
                                        </div>
                                        <div class="tab-gallery-preview">
                                            <div id="gallery" itemscope itemtype="http://schema.org/Product">
                                                <?php
                                                if (!empty($post_details['post_media']->images))
                                                {
                                                    foreach ($post_details['post_media']->images as $key => $value)
                                                    {
                                                        $image_src = base_url(getImage($value->pm_media_url));
                                                        ?>
                                                        <div class="gallery-i <?php echo $value->pm_primary == '1' ? 'active' : ''; ?>">
                                                            <a href="<?php echo $image_src; ?>"><img itemprop="image" alt="<?php echo $page_title; ?>" src="<?php echo $image_src; ?>"><span></span></a>
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
                                                <h2>Description:</h2>
                                                <div itemprop="description">
                                                    <?php echo $post_description; ?>
                                                </div>
                                            </div>

                                            <div class="clear" style="margin-top:40px;">
                                                <h2>Activities:</h2>
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

                                        <?php
                                        $this->load->view('pages/trip/trip-detail-reviews');
                                        $this->load->view('pages/trip/trip-detail-faq');
                                        ?>

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
                            <div class="h-detail-lbl-b" style="margin-top:5px;"><?php echo implode(' > ', $post_region_cities); ?></div>
                        </div>
                        <div class="h-tour">
                            <div class="tour-icon-txt"><?php echo $post_details['post_travel_mediums_string']; ?></div>
                            <div class="tour-icon-person"><?php echo count($post_details['post_travelers']) . ' traveler' . (count($post_details['post_travelers']) == 1 ? '' : 's'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <div class="h-detail-stars">
                            <ul class="h-stars-list">
                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/hd-star-b.png"></a></li>
                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/hd-star-b.png"></a></li>
                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/hd-star-b.png"></a></li>
                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/hd-star-b.png"></a></li>
                                <li><a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/hd-star-a.png"></a></li>
                            </ul>
                            <div class="h-stars-lbl">156 reviews</div>
                            <a href="#" class="h-add-review">add review</a>
                            <div class="clear"></div>
                        </div>
                        <div class="h-details-text">
                            <p><?php echo $post_description; ?></p>
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
                                        <img alt="" src="<?php echo IMAGES_PATH; ?>/r-user.png">
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
                                        <img alt="" src="<?php echo IMAGES_PATH; ?>/r-user.png">
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
                                        <img alt="" src="<?php echo IMAGES_PATH; ?>/r-user.png">
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
                                        <a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/like-01.jpg"></a>
                                    </div>
                                    <div class="h-liked-item-c">
                                        <div class="h-liked-item-cb">
                                            <div class="h-liked-item-p">
                                                <div class="h-liked-title"><a href="#">Andrassy Thai Hotel</a></div>
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
                                        <a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/like-02.jpg"></a>
                                    </div>
                                    <div class="h-liked-item-c">
                                        <div class="h-liked-item-cb">
                                            <div class="h-liked-item-p">
                                                <div class="h-liked-title"><a href="#">Campanile Cracovie</a></div>
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
                                        <a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/like-03.jpg"></a>
                                    </div>
                                    <div class="h-liked-item-c">
                                        <div class="h-liked-item-cb">
                                            <div class="h-liked-item-p">
                                                <div class="h-liked-title"><a href="#">Ermin's Hotel</a></div>
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