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
        if (!in_array($region_value['pr_source_city'], $post_region_cities))
        {
            $post_region_cities[] = $region_value['pr_source_city'];
        }
    }
}
?>

<div class="checkout-coll">
    <div class="checkout-head">
        <div class="checkout-headl" itemscope itemtype="http://schema.org/Event">
            <?php
            if (!empty($post_records['post_primary_image']) && file_exists($post_records['post_primary_image']))
            {
                ?>
                <a itemprop="url" href="<?php echo $post_url; ?>" target="_blank"><img itemprop="image" alt="<?php echo $post_title; ?>" src="<?php echo base_url($post_records['post_primary_image']); ?>" style="display: inline-block;width: 100%;"></a>
                <?php
            }
            ?>
        </div>
        <div class="checkout-headr">
            <div class="checkout-headrb">
                <div class="checkout-headrp">
                    <div class="chk-left">
                        <div class="chk-lbl"><a href="<?php echo $post_url; ?>" target="_blank"><span itemprop="name"><?php echo $post_title; ?></span></a></div>
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
            <div class="hidden">
                <span itemprop="validFrom" content="<?php echo $post_records['post_start_date']; ?>T00:01"></span>
                <span itemprop="validThrough" content="<?php echo $post_records['post_end_date']; ?>T23:59"></span>
            </div>
            <meta itemprop="duration" content="<?php echo $post_total_days; ?>D" />
            <span class="chk-nights"><?php echo number_format($post_total_days); ?> days</span>
            <span class="chk-dates"><?php echo $post_start_end_date_string; ?></span>
        </div>
        <div class="chk-line" itemprop="description"><?php echo $post_description; ?></div>
    </div>

    <div class="chk-details">
        <?php
        if (!empty($post_records['post_activities']))
        {
            ?>
            <h2>Activities:</h2>
            <div class="chk-detais-row">
                <?php
                foreach ($post_records['post_activities'] as $activity_key => $activity_value)
                {
                    ?>
                    <div class="chk-line">
                        <span class="chk-l"><a href="<?php echo base_url('activities/' . $activity_value['am_url_key']); ?>" target="_blank" style="text-decoration: none;color: #4a90a4;font-weight: bold;"><?php echo $activity_value['am_title']; ?></a></span>
                        <div class="clear"></div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
        <div class="clear"></div>

        <?php
        if (!empty($post_records['post_regions']))
        {
            ?>
            <h2>Locations:</h2>
            <div class="chk-detais-row">
                <?php
                foreach ($post_records['post_regions'] as $region_key => $region_value)
                {
                    ?>
                    <div class="chk-line">
                        <span class="chk-l"><a href="<?php echo base_url('cities/' . $region_value['pr_source_city']); ?>" target="_blank" style="text-decoration: none;color: #4a90a4;font-weight: bold;"><?php echo $region_value['pr_source_city']; ?></a></span>
                        <span class="chk-r"><a href="<?php echo base_url('countries/' . $region_value['pr_source_country']); ?>" target="_blank" style="text-decoration: none;color: #4a90a4;"><?php echo $region_value['pr_source_country']; ?></a></span>
                        <div class="clear"></div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
        <div class="clear"></div>

        <?php
        if (!empty($post_records['post_travelers']))
        {
            ?>
            <h2>Travelers:</h2>
            <div class="chk-detais-row">
                <?php
                foreach ($post_records['post_travelers'] as $traveler_key => $traveler_value)
                {
                    ?>
                    <div class="chk-line">
                        <span class="chk-l" style="font-weight: bold;"><?php echo $traveler_value['pt_traveler_name']; ?></span>
                        <span class="chk-r" style="font-weight: bold;"><?php echo ucwords($traveler_value['pt_traveler_gender']) . ' (' . $traveler_value['pt_traveler_age'] . ')'; ?></span>
                        <div class="clear"></div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
        <div class="clear"></div>
        <div class="chk-total" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <div class="chk-total-l">Budget:</div>
            <div class="chk-total-r" itemprop="price" content="<?php echo number_format($post_records['post_total_cost'], 2); ?>"><?php echo $post_total_cost; ?></div>
            <div class="clear"></div>
        </div>					
    </div>
</div>