<?php
$redis_functions = new Redisfunctions();
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
$path = $controller . "/" . $action;
$unread_chats_count = 0;
if (isset($this->session->userdata['user_username']))
{
    $unread_chats_count = count($redis_functions->get_unread_chats_username($this->session->userdata['user_username']));
}
?>
<!-- // mobile menu // -->
<div class="mobile-menu">
    <nav>
        <ul>					
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <?php
            if ($path != 'index/login' && $path != 'index/register')
            {
                ?>
                <li><a href="<?php echo base_url('trip/post/add'); ?>" <?php echo isset($this->session->userdata['user_id']) == FALSE ? 'onclick="open_authorize_popup();"' : ''; ?>>Publish Your Trip</a></li>
                <?php
            }
            if (isset($this->session->userdata['user_id']))
            {
                ?>
                <li><a class="has-child" href="javascript:void(0)"><?php echo stripslashes($this->session->userdata['user_fullname']); ?></a>
                    <ul>
                        <li><a href="<?php echo base_url('my-chats'); ?>">My Chats <?php echo $unread_chats_count > 0 ? '(' . $unread_chats_count . ')' : ''; ?></a></li>
                        <li><a href="<?php echo base_url('my-account'); ?>">My Account</a></li>
                        <li><a href="<?php echo base_url('my-trips/list'); ?>">Trips I've Posted</a></li>
                        <li><a href="<?php echo base_url('joined-trips/list'); ?>">Trips I've Joined</a></li>
                        <li><a href="<?php echo base_url('my-wishlist/list'); ?>">My Wishlist</a></li>
                        <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>	
                    </ul>						
                </li>	
                <?php
            }
            else
            {
                if ($path != 'index/login' && $path != 'index/register')
                {
                    ?>
                    <li><a href="<?php echo base_url('login'); ?>" onclick="open_authorize_popup();">Login</a></li>
                    <?php
                }
            }
            ?>
        </ul>
    </nav>	
</div>
<!-- \\ mobile menu \\ -->

<div class="wrapper-padding">
    <div class="header-logo"><a href="<?php echo base_url(); ?>"><img alt="<?php echo $redis_functions->get_site_setting('SITE_NAME'); ?>" src="<?php echo IMAGES_PATH; ?>/logo.png" /></a></div>
    <div class="header-right">
        <div class="hdr-srch">
            <a href="#" class="hdr-srch-btn"></a>
        </div>
        <div class="hdr-srch-overlay">
            <div class="hdr-srch-overlay-a">
                <form action="<?php echo base_url('trip/search/query'); ?>">
                    <input type="text" name="q" placeholder="Start typing...">
                    <a href="#" class="srch-close"></a>
                </form>
                <div class="clear"></div>
            </div>
        </div>	
        <div class="hdr-srch-devider"></div>
        <a href="#" class="menu-btn"></a>
        <nav class="header-nav">
            <ul>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <?php
                if ($path != 'index/login' && $path != 'index/register')
                {
                    ?>
                    <li><a href="<?php echo base_url('trip/post/add'); ?>" <?php echo isset($this->session->userdata['user_id']) == FALSE ? 'onclick="open_authorize_popup();"' : ''; ?>>Publish Your Trip</a></li>
                    <?php
                }
                if (isset($this->session->userdata['user_id']))
                {
                    ?>
                    <li><a href="javascript:void(0)"><?php echo stripslashes($this->session->userdata['user_fullname']); ?></a>
                        <ul>
                            <li><a href="<?php echo base_url('my-chats'); ?>">My Chats <?php echo $unread_chats_count > 0 ? '(' . $unread_chats_count . ')' : ''; ?></a></li>
                            <li><a href="<?php echo base_url('my-account'); ?>">My Account</a></li>
                            <li><a href="<?php echo base_url('my-trips/list'); ?>">Trips I've Posted</a></li>
                            <li><a href="<?php echo base_url('joined-trips/list'); ?>">Trips I've Joined</a></li>
                            <li><a href="<?php echo base_url('my-wishlist/list'); ?>">My Wishlist</a></li>
                            <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
                        </ul>
                    </li>
                    <?php
                }
                else
                {
                    if ($path != 'index/login' && $path != 'index/register')
                    {
                        ?>
                        <li><a href="<?php echo base_url('login'); ?>" onclick="open_authorize_popup();">Login</a></li>
                        <?php
                    }
                }
                ?>
            </ul>
        </nav>
    </div>
    <div class="clear"></div>
</div>