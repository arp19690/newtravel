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

    public function getFacebookLoginUrl($redirect_uri = FACEBOOK_CALLBACK_URL, $appId = FACEBOOK_APP_ID, $secretId = FACEBOOK_SECRET_ID)
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
        $output_status = 'success';
        $access_token_value = NULL;

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
            $output_message = $user = $response->getGraphUser();

            // The OAuth 2.0 client handler helps us manage access tokens
            $oAuth2Client = $fb->getOAuth2Client();
            $access_token_value = (string) $oAuth2Client->getLongLivedAccessToken($accessToken)->getValue();
        } catch (Facebook\Exceptions\FacebookResponseException $e)
        {
//            echo 'Graph returned an error: ' . $e->getMessage();
            $output_message = $e->getMessage();
            $output_status = 'error';
        } catch (Facebook\Exceptions\FacebookSDKException $e)
        {
//            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            $output_message = $e->getMessage();
            $output_status = 'error';
        }

        return array('status' => $output_status, 'data' => $output_message, 'accessToken' => $access_token_value);
    }

}
