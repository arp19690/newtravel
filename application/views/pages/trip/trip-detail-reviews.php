<?php
$post_ratings = $post_details['post_ratings'];
$post_aggregate_ratings = number_format($post_details['post_aggregate_ratings'], 1);
?>
<!-- // content-tabs-i // -->
<div class="content-tabs-i">
    <div class="reviews-a">

        <div class="reviews-c">
            <div class="reviews-l">
                <div class="reviews-total"><?php echo $post_aggregate_ratings; ?>/5.0</div>
                <nav class="reviews-total-stars">
                    <ul>
                        <?php
                        for ($aggregate_i = 1; $aggregate_i <= $post_aggregate_ratings; $aggregate_i++)
                        {
                            echo '<li><img alt="' . $aggregate_i . '" src="' . IMAGES_PATH . '/r-stars-total-b.png"></li>';
                        }

                        for ($blank_aggregate_i = 1; $blank_aggregate_i <= (5 - $post_aggregate_ratings); $blank_aggregate_i++)
                        {
                            echo '<li><img alt="' . ($post_aggregate_ratings + $blank_aggregate_i) . '" src="' . IMAGES_PATH . '/r-stars-total-a.png"></li>';
                        }
                        ?>
                    </ul>
                    <div class="clear"></div>
                </nav>
            </div>
        </div>
        <div class="clear"></div>

        <div class="reviews-devider"></div>

        <div class="review-form">
            <h2>Your Review:</h2>

            <form action="" method="post">
                <div class="review-rangers-row">
                    <div class="review-ranger">
                        <label>Review</label>
                        <div class="review-ranger-r">
                            <div class="slider-range-min"></div>
                            <input type="hidden" name="review_stars" class="review_stars"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="clearfix" style="margin-bottom: 20px;">
                    <label style="display: inline-block;">Recommended</label>
                    <div class="input" style="margin-left: 20px;display: inline-block;">
                        <input type="radio" name="recommended" value="1" id="recom_yes" checked="checked"/>&nbsp;<label for="recom_yes" style="display: inline-block;">Yes</label>
                        <input type="radio" name="recommended" value="0" id="recom_no" style="margin-left: 20px;"/>&nbsp;<label for="recom_no" style="display: inline-block;">No</label>
                    </div>
                </div>

                <div class="clearfix">
                    <div class="booking-form-i">
                        <label>Comment:</label>
                        <div class="textarea"><textarea name="review_comment" placeholder="Write your review comment"/></textarea></div>
                    </div>
                </div>

                <div class="clearfix">
                    <button type="submit" class="review-send">Submit Review</button>
                </div>   
            </form>
        </div>   

        <div class="hotel-reviews-devider"></div>

        <div class="guest-reviews">
            <h2>User Reviews:</h2>
            <div class="guest-reviews-row">
                <?php
                if (!empty($post_ratings))
                {
                    foreach ($post_ratings as $value)
                    {
                        $value = (array) $value;
                        $user_profile_picture = base_url(getImage($value['user_profile_picture']));
                        $user_fullname = stripslashes($value['user_fullname']);
                        $user_username = stripslashes($value['user_username']);
                        $user_country = stripslashes($value['user_country']);
                        $review_comment = stripslashes($value['rating_comment']);
                        $review_stars = number_format(stripslashes($value['rating_stars']), 1);
                        $recommended = stripslashes($value['rating_recommended']);
                        $blank_stars = 5 - $review_stars;
                        ?>
                        <!-- // -->
                        <div class="guest-reviews-i">
                            <div class="guest-reviews-a">
                                <div class="guest-reviews-l">
                                    <div class="guest-reviews-img">
                                        <span><?php echo $review_stars; ?></span>
                                        <img alt="<?php echo $user_fullname; ?>" src="<?php echo $user_profile_picture; ?>">
                                    </div>
                                </div>
                                <div class="guest-reviews-r">
                                    <div class="guest-reviews-rb">
                                        <div class="guest-reviews-b">
                                            <div class="guest-reviews-bl">
                                                <div class="guest-reviews-blb">
                                                    <div class="guest-reviews-lbl"><?php echo $user_fullname; ?></div>
                                                    <div class="guest-reviews-lbl-a">from <?php echo $user_country; ?></div>
                                                    <div class="guest-reviews-txt"><?php echo $review_comment; ?></div>
                                                </div>
                                                <br class="clear" />
                                            </div>
                                        </div>
                                        <div class="guest-reviews-br">  													
                                            <div class="guest-reviews-padding">
                                                <nav>
                                                    <ul>
                                                        <?php
                                                        for ($star_i = 1; $star_i <= $review_stars; $star_i++)
                                                        {
                                                            echo '<li><img alt="' . $star_i . '" src="' . IMAGES_PATH . '/g-star-b.png"></li>';
                                                        }

                                                        for ($blank_star_i = 1; $blank_star_i <= $blank_stars; $blank_star_i++)
                                                        {
                                                            echo '<li><img alt="' . ($review_stars + $blank_star_i) . '" src="' . IMAGES_PATH . '/g-star-a.png"></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </nav>
                                                <div class="guest-rating"><?php echo $review_stars; ?>/5.0</div>
                                                <div class="clear"></div>
                                                <?php echo $recommended == '1' ? '<div class="guest-rating-txt">Recommended</div>' : ''; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <br class="clear" />
                                </div>
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
                    <div class="guest-reviews-i"><p>No reviews found</p></div>
                    <?php
                }
                ?>
            </div>         
        </div>		
    </div>
</div>
<!-- \\ content-tabs-i \\ -->

<script>

    $(document).ready(function () {
        $('.review-ranger').each(function () {
            var $this = $(this);
            var $index = $(this).index();
            if ($index == '0') {
                var $val = '3.0'
            }
//            else if ($index == '1') {
//                var $val = '3.8'
//            } else if ($index == '2') {
//                var $val = '2.8'
//            } else if ($index == '3') {
//                var $val = '4.8'
//            } else if ($index == '4') {
//                var $val = '4.3'
//            } else if ($index == '5') {
//                var $val = '5.0'
//            }
            $this.find('.slider-range-min').slider({
                range: "min",
                step: 1.0,
                value: $val,
                min: 0.5,
                max: 5.0,
                create: function (event, ui) {
                    $this.find('.ui-slider-handle').append('<span class="range-holder"><i></i></span>');
                },
                slide: function (event, ui) {
                    $this.find(".range-holder i").text(ui.value);
                    $this.find(".review_stars").val(ui.value);
                }
            });
            $this.find(".range-holder i").text($val);
            $this.find(".review_stars").val($val);
        });
    });
</script>