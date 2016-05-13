<?php
$redis_functions = new Redisfunctions();

if (!isset($meta_title))
    $meta_title = $redis_functions->get_site_setting('SITE_TITLE');

if (!isset($meta_keywords))
    $meta_keywords = $redis_functions->get_site_setting('SEO_KEYWORDS');

if (!isset($meta_description))
    $meta_description = $redis_functions->get_site_setting('SEO_DESCRIPTION');

if (!isset($meta_logo_image))
    $meta_logo_image = IMAGES_PATH . "/logo.jpg";

//clearstatcache();
//$this->output->set_header('Expires: Tue, 01 Jan 2000 00:00:00 GMT');
//$this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
//$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
//$this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
//$this->output->set_header('Pragma: no-cache');
//    prd($meta_logo_image);

$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
$path = $controller . "/" . $action;
?>
<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $meta_title; ?></title>
        <meta name="keywords" content="<?php echo $meta_keywords; ?>" />
        <meta name="description" content="<?php echo $meta_description; ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/> 
        <meta property="og:url" content="<?php echo current_url(); ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo $meta_title; ?>" />
        <meta property="og:description" content="<?php echo $meta_description; ?>" />
        <meta property="og:image" content="<?php echo $meta_logo_image; ?>" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:site_name" content="<?php echo $redis_functions->get_site_setting('SITE_NAME'); ?>" />

        <!--Adding Favicons below-->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo IMAGES_PATH; ?>/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo IMAGES_PATH; ?>/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMAGES_PATH; ?>/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo IMAGES_PATH; ?>/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMAGES_PATH; ?>/favicons/favicon-16x16.png">

        <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/jquery-ui.css"/>
        <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/owl.carousel.css"/>
        <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/idangerous.swiper.css"/>
        <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/jquery.formstyler.css"/>  
        <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/style.css" />
        <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/custom.css" />
        <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/fonts.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="<?php echo JS_PATH; ?>/jquery.1.7.1.js"></script>
    </head>
    <body class="<?php echo $path == 'index/index' ? 'index-page' : ''; ?>" itemscope itemtype="http://schema.org/WebPage">
        <div id="fb-root"></div>
        <script>
            var js_base_url = '<?php echo base_url(); ?>';
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '<?php echo $redis_functions->get_site_setting('FACEBOOK_APP_ID'); ?>',
                    xfbml: true,
                    version: 'v2.5'
                });
            };

            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <?php
        if (!isset($this->session->userdata['user_id']))
        {
            echo '<div class="overlay"></div>';
            $this->load->view('layout/authorize-popups');
        }

        $addressee_name = 'there';
        if (isset($this->session->userdata["user_fullname"]) && !empty($this->session->userdata["user_fullname"]))
        {
            $split_name = explode(' ', $this->session->userdata["user_fullname"]);
            $addressee_name = ucwords($split_name[0]);
        }
        ?>

        <header id="top">
            <div class="notification-area">
                <?php
                if ($this->session->flashdata('success'))
                {
                    echo '<div class="message-box-d">' . $this->session->flashdata('success') . '</div>';
                }
                if ($this->session->flashdata('warning'))
                {
                    echo '<div class="message-box-b">' . $this->session->flashdata('warning') . '</div>';
                }
                if ($this->session->flashdata('error'))
                {
                    echo '<div class="message-box-c">' . $this->session->flashdata('error') . '</div>';
                }
                ?>
            </div>
            <div class="header-a">
                <div class="wrapper-padding">			
                    <div class="header-phone hidden">
                        <div id="late-night">
                            <span style="background: none;padding: 0;">&nbsp;&nbsp;Hey <?php echo $addressee_name; ?>, we love these late hours too!</span>
                        </div>
                        <div id="early-morning">
                            <span style="background: none;padding: 0;">&nbsp;&nbsp;Good morning <?php echo $addressee_name; ?>, let's go running?</span>
                        </div>
                    </div>
                    <div class="header-social">
                        <a href="<?php echo $redis_functions->get_site_setting('TWITTER_SOCIAL_LINK'); ?>" target="_blank" class="social-twitter track-external-redirect"></a>
                        <a href="<?php echo $redis_functions->get_site_setting('FACEBOOK_SOCIAL_LINK'); ?>" target="_blank" class="social-facebook track-external-redirect"></a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="header-b">
                <?php $this->load->view('layout/navigation'); ?>
            </div>	
        </header>