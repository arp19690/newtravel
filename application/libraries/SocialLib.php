<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SocialLib
{

    public function __construct()
    {
        @session_start();
        $this->ci = & get_instance();
        $this->ci->load->database();
        $this->ci->load->model('Common_model');
    }

    public function getFacebookLoginUrl($appId = FACEBOOK_APP_ID, $secretId = FACEBOOK_SECRET_ID, $redirect_uri = FACEBOOK_CALLBACK_URL)
    {
        require_once APPPATH . "../assets/front/social/facebook/autoload.php";

        // Create our Application instance (replace this with your appId and secret).
        $facebook = new Facebook\Facebook([
            'app_id' => $appId,
            'app_secret' => $secretId,
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $facebook->getRedirectLoginHelper();
        $permissions = ['email', 'user_photos', 'user_friends']; // optional
        $loginUrl = $helper->getLoginUrl($redirect_uri, $permissions);

        return $loginUrl;
    }

    public function getFacebookUserObject()
    {
        require_once APPPATH . "../assets/front/social/facebook/autoload.php";

        // Create our Application instance (replace this with your appId and secret).
        $fb = new Facebook\Facebook([
            'app_id' => FACEBOOK_APP_ID,
            'app_secret' => FACEBOOK_SECRET_ID,
            'default_graph_version' => 'v2.5',
        ]);
        $helper = $fb->getRedirectLoginHelper();

        try
        {
            $accessToken = $helper->getAccessToken();
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
        } catch (Facebook\Exceptions\FacebookResponseException $e)
        {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e)
        {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();
        return $user;
    }

}
