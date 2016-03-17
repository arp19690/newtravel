<?php
$redis_functions = new Redisfunctions();
?>

<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title"><span>Review your trip</span></div>
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
                                <div class="booking-left">

                                    <h2>Successfully posted</h2>
                                    <div class="comlete-alert" style="margin-top: 0;">
                                        <div class="comlete-alert-a">
                                            <b>Kindly review your post.</b>
                                            <span>Let your friends know about it. <a href="#" onclick="fb_share_dialog('<?php echo current_url(); ?>');"><span class="fa fa-share"></span> Share now.</a></span>
                                        </div>
                                    </div>

                                    <div class="complete-info">
                                        <div class="complete-txt">
                                            <div class="clear">
                                                <h2 class="pull-left"><?php echo $page_title; ?></h2>
                                                <a href="<?php echo base_url('trip/post/edit/1/' . $post_details['post_url_key']); ?>" class="pull-right a-no-underline"><span class="fa fa-pencil"></span> Edit Post</a>
                                            </div>

                                            <div class="clear">
                                                <p><?php echo stripslashes($post_details['post_description']); ?></p>
                                            </div>
                                        </div>

                                        <div class="complete-devider"></div>

                                        <?php
                                        if (!empty($post_details->post_regions))
                                        {
                                            ?>
                                            <h2>Your Itinerary Information:-</h2>
                                            <div class="complete-info-table" style="width: 95%;margin: auto;">
                                                <?php
                                                foreach ($post_details->post_regions as $key => $value)
                                                {
                                                    ?>
                                                    <div class="complete-info-i">
                                                        <div class="complete-info-l" style="width: 250px;">
                                                            <p style="margin: 0;">From: <strong><?php echo stripslashes($value->pr_source_location); ?></strong></p>
                                                            <p style="margin: 0 0 0 35px;">(23-12-2015)</p>
                                                        </div>
                                                        <div class="complete-info-r" style="display: inline-block;">
                                                            <p style="margin: 0;">To: <strong><?php echo stripslashes($value->pr_destination_location); ?></strong></p>
                                                            <p style="margin: 0 0 0 20px;">(23-12-2015)</p>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="complete-devider"></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }

                                        if (!empty($post_details->post_costs))
                                        {
                                            ?>
                                            <h2>Your Budget Information:-</h2>
                                            <div class="complete-info-table" style="width: 95%;margin: auto;">
                                                <?php
                                                foreach ($post_details->post_costs as $key => $value)
                                                {
                                                    ?>
                                                    <div class="complete-info-i">
                                                        <div class="complete-info-l"><?php echo get_currency_symbol($value->cost_currency) . $value->cost_amount; ?></div>
                                                        <div class="complete-info-r"><?php echo stripslashes($value->cost_title); ?></div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="complete-devider"></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
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
                        $this->load->view('pages/trip/post/featured-select-sidebar');
                    }

//                    $this->load->view('pages/trip/post/traveler-info-sidebar', array('post_records' => $post_details));
                    $this->load->view('pages/trip/post-right-sidebar', array('post_records' => $post_details));
                    ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>	
    </div>  
</div>