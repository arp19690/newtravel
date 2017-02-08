<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Redisfunctions
{

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->database();
        $this->ci->load->model('Common_model');
    }

    public function get_featured_trips()
    {
        $custom_model = new Custom_model();
        $records = $custom_model->get_featured_trips('p.post_url_key');
        return $records;
    }

    public function get_latest_trips()
    {
        $custom_model = new Custom_model();
        $records = $custom_model->get_latest_trips('p.post_url_key');
        return $records;
    }

    public function get_all_trips()
    {
        $custom_model = new Custom_model();
        $where_cond_str = 'p.post_published = "1"';
        $records = $custom_model->get_search_results('p.post_url_key', $where_cond_str);
        return $records;
    }

    public function is_featured_trip($url_key)
    {
        $featured_trips = (array) $this->get_featured_trips();
        $output = in_array($url_key, $featured_trips);
        return $output;
    }

    public function get_travel_mediums()
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('*', TABLE_TRAVEL_MEDIUMS, array('tm_status' => '1'), 'tm_title');
        return $records;
    }

    public function get_trip_details($url_key)
    {
        $custom_model = new Custom_model();
//        $custom_model->verify_trip_status($url_key);
        $trip_details = $custom_model->get_trip_detail($url_key);
        return $trip_details;
    }

    public function get_activity_master()
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('*', TABLE_ACTIVITIES_MASTER);
        return $records;
    }

    public function get_site_setting($key_name)
    {
        $key_name = strtoupper($key_name);
        $model = new Common_model();
        $records = $model->fetchSelectedData('setting_key, setting_value', TABLE_SETTINGS, array('setting_key' => $key_name));
        return $records[0]['setting_value'];
    }

    public function get_static_page_content($key_name)
    {
        $key_name = strtolower($key_name);
        $model = new Common_model();
        $records = $model->fetchSelectedData('sp_key, sp_title, sp_text', TABLE_STATIC_PAGES, array('sp_status' => '1', 'sp_key' => $key_name));
        return $records[0];
    }

    public function get_user_profile_data($username, $fields = NULL)
    {
        $custom_model = new Custom_model();
        $records = $custom_model->get_user_profile_data($username, $fields);
        return $records;
    }

    public function get_unread_chats_username($username)
    {
        $custom_model = new Custom_model();
        $user_profile_data = $this->get_user_profile_data($username);
        $records = $custom_model->get_unread_chats_username($user_profile_data['user_id']);
        return $records;
    }

    public function get_trip_faqs()
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('faq_id, faq_question, faq_answer', TABLE_FAQ, array('faq_type' => 'trip', 'faq_status' => '1'), 'faq_order');
        return $records;
    }

    public function get_deleted_message_ids($username)
    {
        return NULL;
    }

}
