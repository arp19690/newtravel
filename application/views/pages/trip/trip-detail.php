<?php
$redis_functions = new Redisfunctions();

$post_owner_records = $redis_functions->get_user_profile_data($post_details['post_user_username']);
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
    <div class="body-wrapper">
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
                                            <div id="gallery" itemscope itemtype="http://schema.org/Event">
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
                                                <div itemprop="description"><?php echo $post_description; ?></div>
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
                    <?php
                    if (empty($post_details['post_featured']))
                    {
                        $this->load->view('pages/trip/post/get-featured-sidebar');
                    }
                    ?>

                    <div class="h-detail-r">
                        <div class="h-detail-lbl">
                            <div class="h-detail-lbl-a"><?php echo $page_title; ?></div>
                            <div class="hidden">
                                <span itemprop="validFrom" content="<?php echo $post_details['post_start_date']; ?>T00:01"></span>
                                <span itemprop="validThrough" content="<?php echo $post_details['post_end_date']; ?>T23:59"></span>
                            </div>
                            <div class="h-detail-lbl-b"><?php echo $post_start_end_date_string; ?></div>
                            <div class="h-detail-lbl-b" style="margin-top:5px;"><?php echo implode(' > ', $post_region_cities); ?></div>
                        </div>
                        <div class="h-tour">
                            <div class="tour-icon-txt"><?php echo $post_details['post_travel_mediums_string']; ?></div>
                            <div class="tour-icon-person"><?php echo count($post_details['post_travelers']) . ' traveler' . (count($post_details['post_travelers']) == 1 ? '' : 's'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <div class="h-tour">
                            <div class="tour-icon-txt">Posted by:</div>
                            <div class="tour-icon-txt"><a href="<?php echo base_url('user/' . stripslashes($post_owner_records['user_username'])); ?>" style="margin-left:10px;"><?php echo stripslashes($post_owner_records['user_fullname']); ?></a></div>
                            <div class="clear"></div>
                        </div>
                        <div class="h-detail-stars">
                            <?php
                            if (count($post_details['post_ratings']) > 0)
                            {
                                $post_aggregate_ratings = $post_details['post_aggregate_ratings'];
                                ?>
                                <ul class="h-stars-list">
                                    <?php
                                    for ($aggregate_i = 1; $aggregate_i <= $post_aggregate_ratings; $aggregate_i++)
                                    {
                                        echo '<li><img alt="' . $aggregate_i . '" src="' . IMAGES_PATH . '/hd-star-b.png"></li>';
                                    }

                                    for ($blank_aggregate_i = 1; $blank_aggregate_i <= (5 - $post_aggregate_ratings); $blank_aggregate_i++)
                                    {
                                        echo '<li><img alt="' . ($post_aggregate_ratings + $blank_aggregate_i) . '" src="' . IMAGES_PATH . '/hd-star-a.png"></li>';
                                    }
                                    ?>
                                </ul>
                                <?php
                            }
                            ?>
                            <div class="h-stars-lbl"><?php echo number_format(count($post_details['post_ratings'])); ?> review<?php echo count($post_details['post_ratings']) > 1 ? 's' : ''; ?></div>
                            <a href="#" class="h-add-review">add review</a>
                            <div class="clear"></div>
                        </div>
                        <div class="h-details-text">
                            <p><?php echo $post_description; ?></p>
                        </div>
                        <?php
                        if (@$this->session->userdata['user_id'] != $post_details['post_user_id'])
                        {
                            $wishlist_class_prefix = 'wishlist';
                            $wishlist_text = 'Add to wishlist';
                            if ($in_wishlist == TRUE)
                            {
                                $wishlist_class_prefix = 'book';
                                $wishlist_text = 'In your wishlist';
                            }

                            $interested_class_prefix = 'wishlist';
                            $interested_text = 'I am interested to join';
                            if ($is_interested == TRUE)
                            {
                                $interested_class_prefix = 'book';
                                $interested_text = 'You have joined';
                            }
                            ?>
                            <a href="<?php echo isset($this->session->userdata['user_id']) == TRUE ? (base_url('trip/add-to-wishlist/' . $post_details['post_url_key'])) : '#'; ?>" onclick="<?php echo isset($this->session->userdata['user_id']) == TRUE ? '' : 'open_authorize_popup();'; ?>" class="<?php echo $wishlist_class_prefix; ?>-btn">
                                <span class="<?php echo $wishlist_class_prefix; ?>-btn-l"><i></i></span>
                                <span class="<?php echo $wishlist_class_prefix; ?>-btn-r"><?php echo $wishlist_text; ?></span>
                                <div class="clear"></div>
                            </a>
                            <a href="<?php echo isset($this->session->userdata['user_id']) == TRUE ? (base_url('trip/show-interest/' . $post_details['post_url_key'])) : '#'; ?>" onclick="<?php echo isset($this->session->userdata['user_id']) == TRUE ? ($is_interested == TRUE ? 'return confirm(\'Sure you want to opt out?\');' : '') : 'open_authorize_popup();'; ?>" class="<?php echo $interested_class_prefix; ?>-btn">
                                <span class="<?php echo $interested_class_prefix; ?>-btn-l"><i></i></span>
                                <span class="<?php echo $interested_class_prefix; ?>-btn-r"><?php echo $interested_text; ?></span>
                                <div class="clear"></div>
                            </a>
                            <?php
                        }
                        ?>
                    </div>

                    <?php
                    $this->load->view('pages/trip/trip-detail-reasons');

                    if (!empty($post_details['you_may_like']))
                    {
                        $this->load->view('pages/trip/you-may-like', array('you_may_like_records' => $post_details['you_may_like']));
                    }
                    ?>
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