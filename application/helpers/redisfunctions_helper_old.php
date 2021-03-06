<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RedisfunctionsOLD
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
        $this->set_latest_trips();
        $this->set_site_settings();
        $this->set_activity_master();
        $this->set_static_page_content();
        $this->set_travel_mediums();
        $this->set_all_user_profile_data(1);
        $this->set_trip_faqs();
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
        $output = (array) json_decode($this->ci->redis->get('featured_trips'));
        return $output;
    }

    public function set_latest_trips()
    {
        $key_array = array();
        $custom_model = new Custom_model();
        $records = $custom_model->get_latest_trips('p.post_url_key');
        if (count($records) > 0)
        {
            foreach ($records as $value)
            {
                $key_array[] = $value['post_url_key'];
            }
            $this->ci->redis->set('latest_trips', json_encode($key_array));
        }

        return $key_array;
    }

    public function get_latest_trips()
    {
        $output = (array) json_decode($this->ci->redis->get('latest_trips'));
        return $output;
    }

    public function set_all_trips()
    {
        $key_array = array();
        $custom_model = new Custom_model();
        $where_cond_str = 'p.post_published = "1"';
        $records = $custom_model->get_search_results('p.post_url_key', $where_cond_str);
        if (count($records) > 0)
        {
            foreach ($records as $value)
            {
                $key_array[] = $value['post_url_key'];
            }
            $this->ci->redis->set('all_trips', json_encode($key_array));
        }

        return $key_array;
    }

    public function get_all_trips()
    {
        $output = array();
        if ($this->ci->redis->exists('all_trips') == TRUE)
        {
            $output = (array) json_decode($this->ci->redis->get('all_trips'));
        }
        else
        {
            $output = $this->set_all_trips();
        }

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
            $output = $this->set_travel_mediums();
        }

        return $output;
    }

    public function set_trip_details($url_key)
    {
        $custom_model = new Custom_model();
        $custom_model->verify_trip_status($url_key);
        $trip_details = $custom_model->get_trip_detail($url_key);
        if (!empty($trip_details))
        {
            $this->ci->redis->hSet('trips', $url_key, json_encode($trip_details));

            // now fetch the owner username and update user profiel date redis index key
            $model = new Common_model();
            $user_record = $model->fetchSelectedData('user_username', TABLE_USERS, array('user_id' => $trip_details['post_user_id']));
            if (!empty($user_record))
            {
                $this->set_user_profile_data($user_record[0]['user_username']);
            }
        }

        return $trip_details;
    }

    public function get_trip_details($url_key)
    {
        $output = array();
        if ($this->ci->redis->hExists('trips', $url_key) == TRUE)
        {
            $output = (array) json_decode($this->ci->redis->hGet('trips', $url_key));
        }
        else
        {
            $this->set_trip_details($url_key);
        }

        return $output;
    }

    public function remove_trip_details($url_key)
    {
        $this->ci->redis->hDel('trips', $url_key);
        $this->set_featured_trips();
        return TRUE;
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
        $records = $model->fetchSelectedData('sp_key, sp_title, sp_text', TABLE_STATIC_PAGES, array('sp_status' => '1'));
        if (count($records) > 0)
        {
            foreach ($records as $value)
            {
                $sp_key = $value["sp_key"];
                $output_data = array('page_title' => stripslashes($value["sp_title"]), 'content' => stripslashes($value["sp_text"]));

                $this->ci->redis->hSet('static_pages', strtolower($sp_key), json_encode($output_data));
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

    public function set_all_user_profile_data($user_status = 1)
    {
        $model = new Common_model();
        $fields = 'user_username';
        $where_cond_arr = array('user_status' => (string) $user_status);
        $records = $model->fetchSelectedData($fields, TABLE_USERS, $where_cond_arr);
        if (!empty($records))
        {
            foreach ($records as $value)
            {
                $this->set_user_profile_data($value['user_username']);
            }
        }
        return TRUE;
    }

    public function set_user_profile_data($username, $fields = NULL)
    {
        $custom_model = new Custom_model();
        $records = $custom_model->get_user_profile_data($username, $fields);
        if (!empty($records))
        {
            $this->ci->redis->hSet('user_profile', $records['user_username'], json_encode($records));
        }
        return $records;
    }

    public function get_user_profile_data($username)
    {
        if ($this->ci->redis->hExists('user_profile', $username) == TRUE)
        {
            $output = (array) json_decode($this->ci->redis->hGet('user_profile', $username));
        }
        else
        {
            $output = $this->set_user_profile_data($username);
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

    public function set_unread_chats_username($username)
    {
        $custom_model = new Custom_model();
        $user_profile_data = $this->get_user_profile_data($username);

        $records = $custom_model->get_unread_chats_username($user_profile_data['user_id']);
        $this->ci->redis->hSet('unread_chats_username', $username, json_encode($records));
        return $records;
    }

    public function get_unread_chats_username($username)
    {
        if ($this->ci->redis->hExists('unread_chats_username', $username) == TRUE)
        {
            $output = (array) json_decode($this->ci->redis->hGet('unread_chats_username', $username));
        }
        else
        {
            $output = $this->set_unread_chats_username($username);
        }
        return $output;
    }

    public function set_trip_faqs()
    {
        $model = new Common_model();
        $records = $model->fetchSelectedData('faq_id, faq_question, faq_answer', TABLE_FAQ, array('faq_type' => 'trip', 'faq_status' => '1'), 'faq_order');
        $this->ci->redis->set('trip_faqs', json_encode($records));
        return $records;
    }

    public function get_trip_faqs()
    {
        if ($this->ci->redis->exists('trip_faqs') == TRUE)
        {
            $output = json_decode($this->ci->redis->get('trip_faqs'));
        }
        else
        {
            $output = $this->set_trip_faqs();
        }
        return $output;
    }

    public function set_deleted_message_ids($username, $message_id_array)
    {
        $new_array = $message_id_array;
        $existing_message_id_arr = $this->get_deleted_message_ids($username);
        if ($existing_message_id_arr != FALSE)
        {
            $new_array = array_unique(array_merge($existing_message_id_arr, $message_id_array));
        }

        return $this->ci->redis->hSet('deleted_message_ids', $username, json_encode($new_array));
    }

    public function get_deleted_message_ids($username)
    {
        $records = FALSE;
        if ($this->ci->redis->hExists('deleted_message_ids', $username) == TRUE)
        {
            $records = (array) json_decode($this->ci->redis->hGet('deleted_message_ids', $username));
        }
        return $records;
    }

}
