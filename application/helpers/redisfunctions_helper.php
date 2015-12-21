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
        $this->ci->redis = new CI_Redis();
    }

    public function auto_set_redis_keys()
    {
        $this->set_featured_trips();
        $this->set_site_settings();
        $this->set_activity_master();
        $this->set_static_page_content();
        $this->set_travel_mediums();
    }

    public function set_user_details($username)
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('*', TABLE_USERS, array('user_username' => $username));
        if (count($records) > 0)
        {
            $this->ci->redis->hSet('users', $username, json_encode($records[0]));
        }

        return $records[0];
    }

    public function get_user_details($username)
    {
        $output = array();
        if ($this->ci->redis->hExists('users', $username) == TRUE)
        {
            $output = (array) json_decode($this->ci->redis->hGet('users', $username));
        }
        else
        {
            $output = $this->set_user_details($username);
        }

        return $output;
    }

    public function set_featured_trips()
    {
        $key_array = array();
        $custom_model = new Custom_model();
        $records = $custom_model->get_featured_trips('p.post_url_key');
        if (count($records) > 0)
        {
            foreach ($records as $value)
            {
                $key_array[] = $value['post_url_key'];
            }
            $this->ci->redis->set('featured_trips', json_encode($key_array));
        }

        return $key_array;
    }

    public function get_featured_trips()
    {
        $output = json_decode($this->ci->redis->get('featured_trips'));
        return $output;
    }

    public function is_featured_trip($url_key)
    {
        $featured_trips = (array) $this->get_featured_trips();
        $output = in_array($url_key, $featured_trips);
        return $output;
    }

    public function set_travel_mediums()
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('*', TABLE_TRAVEL_MEDIUMS, array('tm_status' => '1'), 'tm_title');
        if (count($records) > 0)
        {
            $this->ci->redis->set('travel_mediums', json_encode($records));
        }

        return $records;
    }

    public function get_travel_mediums()
    {
        $output = array();
        if ($this->ci->redis->exists('travel_mediums') == TRUE)
        {
            $output = (array) json_decode($this->ci->redis->get('travel_mediums'));
        }
        else
        {
            $this->set_travel_mediums();
        }

        return $output;
    }

    public function set_trip_details($url_key)
    {
        $custom_model = new Custom_model();
        $custom_model->verify_trip_status($url_key);
        $trip_details = $custom_model->get_trip_detail($url_key);
        if (count($trip_details) > 0)
        {
            $this->ci->redis->hSet('trips', $url_key, json_encode($trip_details));
        }

        return $trip_details;
    }

    public function get_trip_details($url_key)
    {
        $output = array();
        if ($this->ci->redis->hExists('trips', $url_key) == TRUE)
        {
            $output = json_decode($this->ci->redis->hGet('trips', $url_key));
        }
        else
        {
            $this->set_trip_details($url_key);
        }

        return $output;
    }

    public function set_activity_master()
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('*', TABLE_ACTIVITIES_MASTER);
        if (count($records) > 0)
        {
            $this->ci->redis->set('activities_master', json_encode($records));
        }

        return $records;
    }

    public function get_activity_master()
    {
        $output = array();
        if ($this->ci->redis->exists('activities_master') == TRUE)
        {
            $output = (array) json_decode($this->ci->redis->get('activities_master'));
        }
        else
        {
            $this->set_activity_master();
        }
        return $output;
    }

    public function set_site_settings()
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('setting_key, setting_value', TABLE_SETTINGS);
        if (count($records) > 0)
        {
            foreach ($records as $value)
            {
                $setting_value = $value["setting_value"];
                $setting_key = $value["setting_key"];

                $this->ci->redis->hSet('site_settings', strtoupper($setting_key), $setting_value);
            }
        }

        return $records;
    }

    public function get_site_setting($key_name)
    {
        $key_name = strtoupper($key_name);
        if ($this->ci->redis->hExists('site_settings', $key_name) == TRUE)
        {
            $output = $this->ci->redis->hGet('site_settings', $key_name);
        }
        else
        {
//            setting all the site constants again
            $this->set_site_settings();
            $output = $this->get_site_setting($key_name);
        }
        return $output;
    }

    public function set_static_page_content()
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('sp_key, sp_text', TABLE_STATIC_PAGES);
        if (count($records) > 0)
        {
            foreach ($records as $value)
            {
                $sp_key = $value["sp_key"];
                $sp_text = $value["sp_text"];

                $this->ci->redis->hSet('static_pages', strtolower($sp_key), json_encode($sp_text));
            }
        }

        return $records;
    }

    public function get_static_page_content($key_name)
    {
        $key_name = strtolower($key_name);
        if ($this->ci->redis->hExists('static_pages', $key_name) == TRUE)
        {
            $output = json_decode($this->ci->redis->hGet('static_pages', $key_name));
        }
        else
        {
//            setting all the static page contents again
            $this->set_static_page_content();
            $output = $this->get_site_setting($key_name);
        }
        return $output;
    }

    public function set_user_profile_data($username, $fields = NULL)
    {
        if ($fields == NULL)
        {
            $fields = 'user_fullname, user_username, user_email, user_city, user_state, user_country, user_location, user_latitude, user_longitude, user_dob, user_gender, user_relationship_status, user_about, user_tagline, user_profile_picture, user_facebook_id, user_languages_known';
        }

        $model = new Common_model();
        $records = $model->fetchSelectedData($fields, TABLE_USERS, array('user_username' => $username));
        if (!empty($records))
        {
            $records = $records[0];
            $this->ci->redis->hSet('user_profile', $records['user_username'], json_encode($records));
        }
        return $records;
    }

    public function get_user_profile_data($username)
    {
        if ($this->ci->redis->hExists('user_profile', $username) == TRUE)
        {
            $output = json_decode($this->ci->redis->hGet('user_profile', $username));
        }
        else
        {
            $this->set_user_profile_data($username);
            $output = $this->get_user_profile_data($username);
        }
        return $output;
    }

    public function delete_all_hash_keys($hash_name, $hash_keys)
    {
        foreach ($hash_keys as $key_name)
        {
            $this->ci->redis->hDel($hash_name, $key_name);
        }
    }

}
