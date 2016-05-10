<?php
$post_ratings = $post_details['post_ratings'];
if (!empty($post_ratings))
{
    $i = 0;
    foreach ($post_ratings as $value)
    {
        $value = (array) $value;
        $user_profile_picture = base_url(getImage($value['user_profile_picture']));
        $user_fullname = stripslashes($value['user_fullname']);
        $user_username = stripslashes($value['user_username']);
        $user_country = stripslashes($value['user_country']);
        $review_comment = stripslashes($value['rating_comment']);
        $review_stars = number_format(stripslashes($value['rating_stars']), 1);
        ?>

        <div class="reasons-rating">
            <div id="reasons-slider">
                <!-- // -->
                <div class="reasons-rating-i">
                    <div class="reasons-rating-txt"><?php echo $review_comment; ?></div>
                    <div class="reasons-rating-user">
                        <div class="reasons-rating-user-l">
                            <img alt="<?php echo $user_fullname; ?>" src="<?php echo $user_profile_picture; ?>">
                            <span><?php echo $review_stars; ?></span>
                        </div>
                        <div class="reasons-rating-user-r">
                            <b><?php echo $user_fullname; ?></b>
                            <span>from <?php echo $user_country; ?></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <!-- \\ -->
            </div>
        </div>
        <?php
        $i++;
        if ($i == 3)
        {
            break;
        }
    }
}