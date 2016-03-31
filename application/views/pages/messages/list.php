<?php
$redis_functions = new Redisfunctions();
$my_profile = $redis_functions->get_user_profile_data($this->session->userdata['user_username']);
?>

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
    .chat-l-div .h-liked-item-i{padding: 5px;}
    .h-liked-item-i.active, .chat-l-div .h-liked-item-i:hover{background-color: #eae8e8;}
    .h-liked-price a{color: #ff7200;text-decoration: none;}
    .h-liked-comment{font-size: 10px;}
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
                            if (!empty($chat_list_records))
                            {
                                foreach ($chat_list_records as $key => $value)
                                {
                                    $username = $value['to_username'];
                                    $user_fullname = stripslashes($value['to_fullname']);
                                    $message_text = getNWordsFromString(stripslashes($value['message_text']), 20);
                                    $user_profile_picture = base_url(getImage($value['to_profile_picture']));
                                    $message_date_time = get_message_timestamp_readable($value['message_timestamp']);
                                    ?>
                                    <!-- // -->
                                    <div class="h-liked-item" style="padding-bottom:10px; margin-bottom: 10px;">
                                        <div class="h-liked-item-i <?php echo isset($_GET['username']) == TRUE ? ($_GET['username'] == $username ? 'active' : NULL) : NULL; ?>">
                                            <a href="<?php echo base_url('my-chats?username=' . $username); ?>">
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

                <?php
                if (isset($display_thread) && $display_thread == TRUE)
                {
                    ?>
                    <div class="chat-r-div">
                        <div class="h-liked">
                            <div class="h-liked-lbl"><?php echo $to_user_fullname; ?></div>
                            <div class="h-liked-row">
                                <div class="h-liked-item">
                                    <div class="h-liked-item-i">
                                        <div class="chat-log">
                                            <?php
                                            $latest_timestamp = time();
                                            if (!empty($records))
                                            {
                                                foreach ($records as $key => $value)
                                                {
                                                    $from_fullname = stripslashes($value['from_fullname']);
                                                    $from_profile_picture = base_url(getImage($value['from_profile_picture']));
                                                    $from_username = stripslashes($value['from_username']);
                                                    $message_text = getNWordsFromString(stripslashes($value['message_text']), 20);
                                                    $message_date_time = get_message_timestamp_readable($value['message_timestamp']);
                                                    $latest_timestamp = $value['message_timestamp'];
                                                    ?>
                                                    <!-- // -->
                                                    <div class="h-liked-item">
                                                        <div class="h-liked-item-i">
                                                            <div class="h-liked-item-l">
                                                                <a href="<?php echo base_url('user/' . $from_username); ?>"><img alt="<?php echo $from_fullname ?>" src="<?php echo $from_profile_picture; ?>"></a>
                                                            </div>
                                                            <div class="h-liked-item-c">
                                                                <div class="h-liked-item-cb">
                                                                    <div class="h-liked-item-p">
                                                                        <div class="h-liked-price"><a href="<?php echo base_url('user/' . $from_username); ?>"><?php echo $from_fullname ?></a></div>
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
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="h-liked-item">
                                                    <p class="text-center">No chat records found between You &amp; <?php echo $to_user_fullname; ?></p>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <span class="new-chats-here"></span>
                                        </div>

                                        <div class="input-message-div">
                                            <textarea name="message" placeholder="Type your message here..." data-to-username="<?php echo getEncryptedString($to_user_username); ?>" class="my-message" onfocus="remove_notification_from_title();"></textarea>
                                            <input type="hidden" name="latest_timestamp" class="latest_timestamp" value="<?php echo $latest_timestamp; ?>"/>
                                            <a href="#" class="btn btn-orange send-msg-btn">Send</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <audio id="chatAudio"><source src="<?php echo base_url('assets/front/notify.wav'); ?>" type="audio/wav"></audio>
                        <?php
                    }
                    ?>
            </div>
        </div>
    </div>
</div>


<!--If in a particular thread, then only execute this part of the code-->
<?php
if (isset($_GET['username']))
{
    ?>
    <script type="text/javascript">
        function get_unread_chats(other_username_enc, latest_timestamp, chat_html)
        {
            var output_data = null;
            var chat_url = '<?php echo base_url('messages/get_unread_chats_ajax'); ?>/' + other_username_enc + '/' + latest_timestamp;
            $.ajax({
                dataType: 'json',
                url: chat_url,
                async: false,
                success: function (response) {
                    if (response != null)
                    {
                        if (response['status'] == 'success')
                        {
                            var chat_records = response['data'];
                            if (chat_records != null)
                            {
                                output_data = '';
                                $.each(chat_records, function (key, value) {
                                    chat_html = chat_html.replace('{{username}}', value['from_username']);
                                    chat_html = chat_html.replace('{{fullname}}', value['from_fullname']);
                                    chat_html = chat_html.replace('{{fullname}}', value['from_fullname']);
                                    chat_html = chat_html.replace('{{message_text}}', value['message_text']);
                                    chat_html = chat_html.replace('{{message_date_time}}', value['message_time_readable']);
                                    chat_html = chat_html.replace('{{profile_picture}}', value['from_profile_picture']);
                                    output_data += chat_html;
                                });

                                // Append the new chat now
                                if (output_data != null)
                                {
                                    $('.new-chats-here').append(output_data);
                                    // Scroll to bottom of the chat
                                    scroll_to_bottom('.chat-log');
                                }

                                // Now updating latest timestamp
                                if (response['latest_timestamp'] != null)
                                {
                                    $('input.latest_timestamp').val(response['latest_timestamp']);
                                }

                                // to ring a notification when the textarea is not selected
                                if (!$(".my-message").is(":focus"))
                                {
                                    $('#chatAudio')[0].play();
                                    var title_original_text = $('title').html();
                                    $('title').html("(" + chat_records.length + ") " + title_original_text);
                                    //                        document.title = "(1) " + title_original_text;
                                }
                            }
                        }
                        else if (response['status'] == 'error')
                        {
                            console.log(response['message']);
                            alert(response['message']);
                        }
                    }
                    return False;
                }
            });
        }

        function send_new_chat(to_username, message_text, chat_html)
        {
            var chat_url = '<?php echo base_url('messages/send_message_ajax'); ?>';
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: chat_url,
                data: {'to_username': to_username, 'message_text': message_text},
                success: function (response) {
                    if (response != null)
                    {
                        if (response['status'] == 'success')
                        {
                            console.log(response['message']);
                            chat_html = chat_html.replace('{{username}}', '<?php echo $this->session->userdata["user_username"]; ?>');
                            chat_html = chat_html.replace('{{fullname}}', '<?php echo $my_profile['user_fullname']; ?>');
                            chat_html = chat_html.replace('{{fullname}}', '<?php echo $my_profile['user_fullname']; ?>');
                            chat_html = chat_html.replace('{{message_text}}', message_text);
                            chat_html = chat_html.replace('{{message_date_time}}', '<?php echo get_message_timestamp_readable(time()); ?>');
                            chat_html = chat_html.replace('{{profile_picture}}', '<?php echo $my_profile['user_profile_picture']; ?>');
                            $('.new-chats-here').append(chat_html);
                            // Scroll to bottom of the chat
                            scroll_to_bottom('.chat-log');
                            // Emptying the text box
                            $('.my-message').val('');
                            // Updating the latest timestamp
                            $('input.latest_timestamp').val('<?php echo time(); ?>');
                        }
                        else if (response['status'] == 'error')
                        {
                            console.log(response['message']);
                            alert(response['message']);
                        }
                    }
                }
            });
        }

        // to clear the notification text i.e (1) from the title tag
        function remove_notification_from_title()
        {
            var title_text = $('title').html();
            title_text = title_text.replace(/\d+/, "");
            title_text = title_text.replace("() ", "");
            $('title').html(title_text);
        }

        $(document).ready(function () {
            var new_chat_html = '<div class="h-liked-item"><div class="h-liked-item-i"><div class="h-liked-item-l"><a href="<?php echo base_url('user'); ?>/{{username}}"><img alt="{{fullname}}" src="{{profile_picture}}"></a></div><div class="h-liked-item-c"><div class="h-liked-item-cb"><div class="h-liked-item-p"><div class="h-liked-price"><a href="<?php echo base_url('user'); ?>/{{username}}">{{fullname}}</a></div><div class="h-liked-title">{{message_text}}</div><div class="h-liked-foot"><span class="h-liked-comment">{{message_date_time}}</span></div></div></div><div class="clear"></div></div></div><div class="clear"></div></div>'

            // Scroll to bottom of the chat
            scroll_to_bottom('.chat-log');

            // Now running AJAX frequecntly to see if any new chats came in
            setInterval(function () {
                var other_username_enc = '<?php echo getEncryptedString($_GET['username']); ?>';
                var latest_timestamp = $('input.latest_timestamp').val();
                get_unread_chats(other_username_enc, latest_timestamp, new_chat_html);
            }, 1500);

            // Send message here
            $('.send-msg-btn').click(function (e) {
                e.preventDefault();
                var message_text = $('.my-message').val();
                if (message_text != '')
                {
                    var to_username = $('.my-message').attr('data-to-username');
                    send_new_chat(to_username, message_text, new_chat_html);
                }
            });

            // While typing, if press enter submit chat
            $('.my-message').keypress(function (e) {
                var key = e.which;
                if (key == 13)  // the enter key code
                {
                    $('.send-msg-btn').click();
                    return false;
                }
            });
        });
    </script>
    <?php
}
?>