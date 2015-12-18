<?php
$redis_functions = new Redisfunctions();
$post_details = $redis_functions->get_post_details($url_key);
?>
<div class="checkout-coll">
    <div class="checkout-head">
        <div class="chk-left">
            <div class="chk-lbl"><p>Travelers</p></div>
            <div class="chk-lbl-a">People accompanying you on your trip.</div>
        </div>
        <div class="chk-right">

        </div>
        <div class="clear"></div>
    </div>
    <div class="chk-details">
        <div class="chk-detais-row">
            <?php
            $post_travelers = $post_details->post_travelers;
            if (!empty($post_travelers))
            {
                foreach ($post_travelers as $key => $value)
                {
//                                if (isset($this->session->userdata["user_id"]) && @$this->session->userdata["user_id"] == $value->pt_traveler_user_id)
//                                {
//                                    continue;
//                                }
//                                else
//                                {
                    ?>
                    <div class="chk-line">
                        <span class="chk-l"><?php echo stripslashes($value->pt_traveler_name) ?>:</span>
                        <span class="chk-r"><?php echo $value->pt_traveler_country; ?></span>
                        <div class="clear"></div>
                    </div>
                    <?php
//                                }
                }
            }
            ?>					
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>