<?php
$redis_functions = new Redisfunctions();
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
$path = $controller . "/" . $action;
?>
<!-- // mobile menu // -->
<div class="mobile-menu">
    <nav>
        <ul>					
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url('trip/post/add'); ?>" <?php isset($this->session->userdata['user_id']) == TRUE ? 'onclick="open_authorize_popup();"' : ''; ?>>Publish Your Trip</a></li>
            <li><a class="has-child" href="javascript:void(0)"><?php echo stripslashes($this->session->userdata['user_fullname']); ?></a>
                <ul>
                    <li><a href="<?php echo base_url('chats'); ?>">My Chats</a></li>
                    <li><a href="<?php echo base_url('my-account'); ?>">My Account</a></li>
                    <li><a href="<?php echo base_url('my-trips/list'); ?>">My Trips</a></li>
                    <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>	
                </ul>						
            </li>	
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
                <input type="text" value="" placeholder="Start typing...">
                <a href="#" class="srch-close"></a>
                <div class="clear"></div>
            </div>
        </div>	
        <div class="hdr-srch-devider"></div>
        <a href="#" class="menu-btn"></a>
        <nav class="header-nav">
            <ul>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li><a href="<?php echo base_url('trip/post/add'); ?>" <?php echo isset($this->session->userdata['user_id']) == FALSE ? 'onclick="open_authorize_popup();"' : ''; ?>>Publish Your Trip</a></li>
                <?php
                if (isset($this->session->userdata['user_id']))
                {
                    ?>
                    <li><a href="javascript:void(0)"><?php echo stripslashes($this->session->userdata['user_fullname']); ?></a>
                        <ul>
                            <li><a href="<?php echo base_url('chats'); ?>">My Chats</a></li>
                            <li><a href="<?php echo base_url('my-account'); ?>">My Account</a></li>
                            <li><a href="<?php echo base_url('my-trips/list'); ?>">My Trips</a></li>
                            <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
                        </ul>
                    </li>
                    <?php
                }
                else
                {
                    ?>
                    <li><a href="<?php echo base_url('login'); ?>" onclick="open_authorize_popup();">Login</a></li>
                    <?php
                }
                ?>
            </ul>
        </nav>
    </div>
    <div class="clear"></div>
</div>