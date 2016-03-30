<style>
    .chat-l-div,.chat-r-div{height: calc(100%);display: inline-block;width: 100%;vertical-align: top;}
    .chat-l-div{max-width: 35%;height: 585px;overflow: auto;}
    .chat-r-div{max-width: 64%;}
    .input-message-div textarea{resize: none;width: 100%;border: 1px #e1e1e1 solid;box-shadow: 1px 1px 2px 0px rgba(50, 50, 50, 0.11);border-radius: 3px;font-size: 13px;padding: 5px 10px;}
    .input-message-div{width: 100%;display: inline-flex;margin-top: 30px;}
    .h-liked-row{display: inline-block;width: 100%;}
    .send-msg-btn{width: 50px;padding: 20px;}
    .chat-log{height: 390px;overflow: auto;margin-top: 20px;}
    .h-liked-comment,.h-liked-item-l{margin: 0;}
    .h-liked-item-i{padding: 5px;}
    .h-liked-item-i.active{background-color: #eae8e8;}
</style>

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
                <div class="chat-l-div">
                    <div class="h-liked" style="height: calc(100%);">
                        <div class="h-liked-lbl">All Chats</div>
                        <div class="h-liked-row">
                            <?php
                            if (!empty($records))
                            {
                                foreach ($records as $key => $value)
                                {
                                    $user_fullname = stripslashes($value['to_fullname']);
                                    $message_text = getNWordsFromString(stripslashes($value['message_text']), 20);
                                    $user_profile_picture = base_url(getImage($value['to_profile_picture']));
                                    $message_date_time = date('d M Y H:i:s', $value['message_timestamp']);
                                    ?>
                                    <!-- // -->
                                    <div class="h-liked-item" style="padding-bottom:10px; margin-bottom: 10px;">
                                        <div class="h-liked-item-i">
                                            <a href="#">
                                                <div class="h-liked-item-l" style="width:70px;">
                                                    <img alt="<?php echo $user_fullname ?>" src="<?php echo $user_profile_picture; ?>">
                                                </div>
                                                <div class="h-liked-item-c" style="margin: 0px 0px 0px 70px;">
                                                    <div class="h-liked-item-cb">
                                                        <div class="h-liked-item-p">
                                                            <div class="h-liked-price" style="font-size:14px;"><?php echo $user_fullname ?></div>
                                                            <div class="h-liked-title" style="font-size:12px;"><?php echo $message_text ?></div>
                                                            <div class="h-liked-foot">
                                                                <span class="h-liked-comment"><?php echo $message_date_time; ?></span>
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

                <div class="chat-r-div">
                    <div class="h-liked">
                        <div class="h-liked-lbl">You May Also Like</div>
                        <div class="h-liked-row">
                            <div class="h-liked-item">
                                <div class="h-liked-item-i">

                                    <div class="chat-log">

                                        <!-- // -->
                                        <div class="h-liked-item">
                                            <div class="h-liked-item-i">
                                                    <div class="h-liked-item-l">
                                                        <img alt="<?php echo $user_fullname ?>" src="<?php echo $user_profile_picture; ?>">
                                                    </div>
                                                    <div class="h-liked-item-c">
                                                        <div class="h-liked-item-cb">
                                                            <div class="h-liked-item-p">
                                                                <div class="h-liked-price"><?php echo $user_fullname ?></div>
                                                                <div class="h-liked-title"><?php echo $message_text ?></div>
                                                                <div class="h-liked-foot">
                                                                    <span class="h-liked-comment"><?php echo $message_date_time; ?></span>
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

                                    <div class="input-message-div">
                                        <textarea name="message" placeholder="Type your message here..."></textarea>
                                        <a href="#" class="btn btn-orange send-msg-btn">Send</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>