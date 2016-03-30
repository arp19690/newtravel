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
                <div style="display: inline-block;max-width: 35%;width: 100%;">
                    <div class="h-liked">
                        <div class="h-liked-row">
                            <?php
                            if (!empty($records))
                            {
                                foreach ($records as $key => $value)
                                {
                                    $user_fullname = stripslashes($value['to_fullname']);
                                    $message_text = getNWordsFromString(stripslashes($value['message_text']),20);
                                    $user_profile_picture = base_url(getImage($value['to_profile_picture']));
                                    $message_date_time = date('d M Y H:i:s', $value['message_timestamp']);
                                    ?>
                                    <!-- // -->
                                    <div class="h-liked-item">
                                        <div class="h-liked-item-i">
                                            <a href="#">
                                                <div class="h-liked-item-l">
                                                    <img alt="<?php echo $user_fullname ?>" src="<?php echo $user_profile_picture; ?>">
                                                </div>
                                                <div class="h-liked-item-c">
                                                    <div class="h-liked-item-cb">
                                                        <div class="h-liked-item-p">
                                                            <div class="h-liked-price"><?php echo $user_fullname ?></div>
                                                            <div class="h-liked-title"><?php echo $message_text ?></div>
                                                            <div class="h-liked-foot">
                                                                <span class="h-liked-comment"><?php echo $message_date_time;?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                            </a>
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
                                <div class="h-liked-item">
                                    <p class="text-center">No chats found</p>
                                </div>
                                <?php
                            }
                            ?>
                        </div>			
                    </div>
                </div>

                <div style="display: inline-block;max-width: 74%">

                </div>
            </div>
        </div>
    </div>
</div>