<?php
$post_title = stripslashes($post_records['post_title']);
$post_description = stripslashes($post_records['post_description']);
$post_primary_image = base_url(getImage($post_records['post_primary_image']));
$post_url = getTripUrl($post_records['post_url_key']);
$post_total_cost = get_currency_symbol($post_records['post_currency']) . $post_records['post_total_cost'];
$post_start_end_date_string = '--';
if (!empty($post_records['post_start_date']) && !empty($post_records['post_end_date']))
{
    $post_date_format = 'd M Y';
    $post_start_end_date_string = date($post_date_format, strtotime($post_records['post_start_date'])) . ' - ' . date($post_date_format, strtotime($post_records['post_end_date']));
}
$post_total_days = number_format($post_records['post_total_days']);

$post_region_cities = array();
if (!empty($post_records['post_regions']))
{
    foreach ($post_records['post_regions'] as $region_key => $region_value)
    {
        if (!in_array($region_value->pr_source_city, $post_region_cities))
        {
            $post_region_cities[] = $region_value->pr_source_city;
        }
    }
}
?>
<div class="checkout-coll">
    <div class="checkout-head">
        <div class="checkout-headl">
            <?php
            if (!empty($post_records['post_primary_image']) && file_exists($post_records['post_primary_image']))
            {
                ?>
                <a href="#"><img alt="<?php echo $post_title; ?>" src="<?php echo base_url($post_records['post_primary_image']); ?>"></a>
                <?php
            }
            ?>
        </div>
        <div class="checkout-headr">
            <div class="checkout-headrb">
                <div class="checkout-headrp">
                    <div class="chk-left">
                        <div class="chk-lbl"><a href="#"><?php echo $post_title; ?></a></div>
                        <div class="chk-lbl-a"><?php echo implode(' > ', $post_region_cities); ?></div>
                    </div>

                    <!--                    <div class="chk-right">
                                            <a href="#"><img alt="" src="<?php echo IMAGES_PATH; ?>/chk-edit.png"></a>
                                        </div>-->
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="chk-lines">
        <div class="chk-line">
            <span class="chk-nights"><?php echo number_format($post_total_days); ?> days</span>
            <span class="chk-dates"><?php echo $post_start_end_date_string; ?></span>
        </div>
        <div class="chk-line">
            1 STANDARD FAMILY ROOM FOR <span class="chk-persons">3 PERSONS</span>
        </div>
    </div>

    <div class="chk-details">
        <h2>Details</h2>
        <div class="chk-detais-row">
            <div class="chk-line">
                <span class="chk-l">Room type:</span>
                <span class="chk-r">Standard family</span>
                <div class="clear"></div>
            </div>
            <div class="chk-line">
                <span class="chk-l">price:</span>
                <span class="chk-r">200$</span>
                <div class="clear"></div>
            </div>
            <div class="chk-line">
                <span class="chk-l">3 nights stay</span>
                <span class="chk-r">600$</span>
                <div class="clear"></div>
            </div>
            <div class="chk-line">
                <span class="chk-l">taxes and fees per night</span>
                <span class="chk-r">3.52$</span>
                <div class="clear"></div>
            </div>
        </div>
        <div class="chk-total">
            <div class="chk-total-l">Total Price</div>
            <div class="chk-total-r"><?php echo $post_total_cost; ?></div>
            <div class="clear"></div>
        </div>					
    </div>
</div>