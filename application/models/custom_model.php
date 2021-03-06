<?php

class Custom_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load DB here
        $this->load->database();
    }

    public function get_trip_detail($url_key)
    {
        $output = array();
        $model = new Common_model();
        $post_records = $model->fetchSelectedData('*', TABLE_POSTS, array('post_url_key' => $url_key));
        if (!empty($post_records))
        {
            $post_id = $post_records[0]['post_id'];
            $output = $post_records[0];

            $output['post_user_username'] = $model->fetchSelectedData('user_username', TABLE_USERS, array('user_id' => $post_records[0]['post_user_id']))[0]['user_username'];

            $post_activities_records = $model->getAllDataFromJoin('*', TABLE_POST_ACTIVITIES . ' as pa', array(TABLE_ACTIVITIES_MASTER . ' as am' => 'am.am_id = pa.pa_activity_id'), 'INNER', array('pa_post_id' => $post_id, 'am_status' => '1'), 'am_title');
            $output['post_activities'] = $post_activities_records;

            $post_featured_records = $model->fetchSelectedData('*', TABLE_POST_FEATURED, array('pf_post_id' => $post_id, 'pf_status' => '1', 'pf_end_date >' => date('Y-m-d H:i:s')));
            $output['post_featured'] = $post_featured_records;

            $post_regions_records = $model->fetchSelectedData('*', TABLE_POST_REGIONS, array('pr_post_id' => $post_id));
            $output['post_regions'] = $post_regions_records;
            $output['post_travel_mediums'] = array();
            $output['post_travel_mediums_string'] = NULL;
            if (!empty($post_regions_records))
            {
                $tmp_arr = array();
                foreach ($post_regions_records as $key => $value)
                {
                    $travel_mediums = $records = $model->fetchSelectedData('tm_title, tm_icon', TABLE_TRAVEL_MEDIUMS, array('tm_status' => '1', 'tm_id' => $value['pr_travel_medium']));
                    if (!empty($travel_mediums))
                    {
                        $title = stripslashes($travel_mediums[0]['tm_title']);
                        $icon = stripslashes($travel_mediums[0]['tm_icon']);

                        if (!in_array($title, $tmp_arr))
                        {
                            $tmp_arr[] = $title;
                        }

                        $output['post_travel_mediums'][] = array(
                            'title' => $title,
                            'icon' => $icon,
                        );
                    }
                }
                $output['post_travel_mediums_string'] = implode(' + ', $tmp_arr);
            }

            $output['post_start_date'] = NULL;
            $output['post_end_date'] = NULL;
            $output['post_total_days'] = NULL;
            $post_start_end_date_record = $model->fetchSelectedData('min(pr_from_date) as start_date, max(`pr_to_date`) as end_date', TABLE_POST_REGIONS, array('pr_post_id' => $post_id));
            if (!empty($post_start_end_date_record))
            {
                $output['post_start_date'] = $post_start_end_date_record[0]['start_date'];
                $output['post_end_date'] = $post_start_end_date_record[0]['end_date'];
                $output['post_total_days'] = round((strtotime($post_start_end_date_record[0]['end_date']) - strtotime($post_start_end_date_record[0]['start_date'])) / (3600 * 24));
            }

            $post_comments_records = $model->getAllDataFromJoin('rating_stars, rating_comment, rating_updated_on, rating_status, user_username, user_fullname, user_profile_picture, user_country, rating_recommended', TABLE_POST_RATINGS, array(TABLE_USERS => 'user_id = rating_user_id'), 'LEFT', array('rating_post_id' => $post_id), 'rating_id', 'DESC');
            $output['post_ratings'] = $post_comments_records;

            $post_aggregate_comments_records = $model->fetchSelectedData('SUM(rating_stars)/COUNT(rating_id) as aggregate_reviews', TABLE_POST_RATINGS, array('rating_post_id' => $post_id));
            $output['post_aggregate_ratings'] = number_format($post_aggregate_comments_records[0]['aggregate_reviews'], 1);

            $post_costs_records = $model->fetchSelectedData('*', TABLE_POST_COSTS, array('cost_post_id' => $post_id));
            $output['post_costs'] = $post_costs_records;
            $total_cost = 0;
            $post_currency = DEFAULT_CURRENCY;
            if (!empty($post_costs_records))
            {
                $post_currency = $post_costs_records[0]['cost_currency'];
                foreach ($post_costs_records as $value)
                {
                    $total_cost = $total_cost + $value['cost_amount'];
                }
            }
            $output['post_currency'] = $post_currency;
            $output['post_total_cost'] = $total_cost;

            $post_travelers_records = $model->fetchSelectedData('*', TABLE_POST_TRAVELERS, array('pt_post_id' => $post_id, 'pt_removed_by' => NULL));
            $output['post_travelers'] = $post_travelers_records;

            $post_images_records = $model->fetchSelectedData('*', TABLE_POST_MEDIA, array('pm_post_id' => $post_id, 'pm_media_type' => 'image', 'pm_status' => '1'));
            $output['post_media']['images'] = $post_images_records;
            $output['post_primary_image'] = NULL;
            if (!empty($post_images_records))
            {
                foreach ($post_images_records as $value)
                {
                    if ($value['pm_primary'] == '1')
                    {
                        $output['post_primary_image'] = $value['pm_media_url'];
                        break;
                    }
                }
            }

            $post_videos_records = $model->fetchSelectedData('*', TABLE_POST_MEDIA, array('pm_post_id' => $post_id, 'pm_media_type' => 'video', 'pm_status' => '1'));
            $output['post_media']['videos'] = $post_videos_records;

            // adding you may like data below
//            $you_may_like = $this->get_you_may_like($url_key);
//            $output['you_may_like'] = $you_may_like;
        }
        return $output;
    }

    public function verify_trip_status($url_key)
    {
        $model = new Common_model();
        $post_details = $this->get_trip_detail($url_key);
        if (!empty($post_details))
        {
            if (isset($this->session->userdata["user_id"]) && $post_details['post_user_id'] == @$this->session->userdata["user_id"])
            {
                $post_published = '1';

                $required_keys = array(
                    'post_title' => 'Please enter a title',
                    'post_url_key' => 'Please enter a title',
                    'post_regions' => 'Please enter your itinerary information',
                );

                foreach ($required_keys as $key => $error_message)
                {
                    if (isset($post_details[$key]))
                    {
                        if (empty($post_details[$key]))
                        {
                            $post_published = '0';
                            $this->session->set_flashdata('error', $error_message);
                            break;
                        }
                    }
                }

                $model->updateData(TABLE_POSTS, array('post_published' => $post_published), array('post_url_key' => $url_key));
            }
        }
        return TRUE;
    }

    public function get_featured_trips($fields = 'p.post_url_key', $limit = '0, 20')
    {
        $sql = "SELECT " . $fields . " FROM `post_featured` as pf LEFT JOIN posts as p ON p.post_id = pf.pf_post_id LEFT JOIN post_featured_master as pfm on pfm.pfm_id = pf.pf_pfm_id WHERE p.post_status = '1' and p.post_published = '1' and pf.pf_status = '1' and pfm.pfm_status = '1' and pf_end_date > '" . date('Y-m-d H:i:s') . "' ORDER BY pfm.pfm_amount LIMIT " . $limit;
        $records = $this->db->query($sql)->result_array();
        return $records;
    }

    public function get_latest_trips($fields = 'p.post_url_key', $limit = '0, 4')
    {
        $sql = "SELECT " . $fields . " FROM posts as p WHERE p.post_status = '1' and p.post_published = '1' ORDER BY p.post_id DESC LIMIT " . $limit;
        $records = $this->db->query($sql)->result_array();
        return $records;
    }

    public function get_search_results($fields = 'p.post_url_key', $where_cond_str = '1', $order_by = NULL, $group_by = NULL, $limit = '0, 1000')
    {
        if ($order_by == NULL)
        {
            $order_by = 'p.post_title ASC';
        }

        if ($group_by == NULL)
        {
            $group_by = 'p.post_id';
        }

        $output = array();
        $sql = 'SELECT ' . $fields . ' FROM `posts` as p 
                    left join post_regions as pr on pr.pr_post_id = p.post_id
                    left join post_costs as pc on pc.cost_post_id = p.post_id
                    left join post_travelers as pt on pt.pt_post_id = p.post_id
                    WHERE ' . $where_cond_str . '
                    GROUP BY ' . $group_by . ' 
                    ORDER BY ' . $order_by . ' LIMIT ' . $limit;
        $records = $this->db->query($sql)->result_array();

        if (!empty($records))
        {
            foreach ($records as $value)
            {
                $output[] = $this->get_trip_detail($value['post_url_key']);
            }
        }

        return $output;
    }

    public function get_min_and_max_cost_amounts()
    {
        $sql = 'select min(cost_amount) as min_cost, max(cost_amount) as max_cost from post_costs';
        $records = $this->db->query($sql)->result_array();
        return $records[0];
    }

    public function get_inbox_list($user_id, $fields = NULL)
    {
        $model = new Common_model();
        $redis_functions = new Redisfunctions();
        $me_username = $model->fetchSelectedData('user_username', TABLE_USERS, array('user_id' => $user_id))[0]['user_username'];
        $deleted_message_ids = $redis_functions->get_deleted_message_ids($me_username);
        if ($fields == NULL)
        {
            $fields = 'm1.message_id, m1.message_text, m1.message_timestamp, 
                            if(to_user.user_id = ' . $user_id . ', from_user.user_username, to_user.user_username) as from_username,
                            if(to_user.user_id = ' . $user_id . ', from_user.user_fullname, to_user.user_fullname) as from_fullname,
                            if(to_user.user_id = ' . $user_id . ', from_user.user_profile_picture, to_user.user_profile_picture) as from_profile_picture';
        }

        $where_str = '(m1.`message_user_from` = ' . $user_id . ' OR m1.`message_user_to` = ' . $user_id . ') AND m2.message_id is NULL';
        if (!empty($deleted_message_ids))
        {
            $imploded_message_id = implode(',', $deleted_message_ids);
            $where_str.=' AND (m1.message_id NOT IN (' . $imploded_message_id . ') OR m2.message_id NOT IN (' . $imploded_message_id . ')) ';
        }

        $sql = 'SELECT * FROM (SELECT ' . $fields . ' FROM ' . TABLE_MESSAGES . ' as m1 
                    left join ' . TABLE_MESSAGES . ' as m2 on m2.`message_user_from` = m1.`message_user_from` and m2.`message_user_to` = m1.`message_user_to` and m2.message_id > m1.message_id
                    left join users as to_user on to_user.user_id = m1.`message_user_to`
                    left join users as from_user on from_user.user_id = m1.`message_user_from`
                    WHERE ' . $where_str . ' 
                    ORDER BY m1.message_id desc) as x GROUP BY x.from_username';
        $records = $this->db->query($sql)->result_array();
        return $records;
    }

    public function get_chat_history($user_from, $user_to, $fields = NULL, $where_str = NULL, $limit = '1000')
    {
        $model = new Common_model();
        $redis_functions = new Redisfunctions();
        $me_username = $model->fetchSelectedData('user_username', TABLE_USERS, array('user_id' => $user_from))[0]['user_username'];
        $deleted_message_ids = $redis_functions->get_deleted_message_ids($me_username);

        if ($fields == NULL)
        {
            $fields = 'm1.message_id, m1.message_text, m1.message_timestamp, FROM_UNIXTIME(m1.message_timestamp, "%d %b %Y %h:%i %p") as message_time_readable, from_user.user_fullname as from_fullname, to_user.user_fullname, from_user.user_profile_picture as from_profile_picture, from_user.user_username as from_username';
        }

        if ($where_str == NULL)
        {
            $where_str = 'm1.`message_user_from` in (' . $user_from . ',' . $user_to . ') and m1.`message_user_to` in (' . $user_from . ',' . $user_to . ')';
        }

        if (!empty($deleted_message_ids))
        {
            $imploded_message_id = implode(',', $deleted_message_ids);
            $where_str.=' AND m1.message_id NOT IN (' . $imploded_message_id . ') ';
        }

        $sql = 'SELECT ' . $fields . ' FROM ' . TABLE_MESSAGES . ' as m1 left join users as from_user on from_user.user_id = m1.`message_user_from` left join users as to_user on to_user.user_id = m1.`message_user_to` WHERE ' . $where_str . ' ORDER BY message_id DESC LIMIT ' . $limit;
        $records = $this->db->query($sql)->result_array();
        if (!empty($records))
        {
            $records = array_reverse($records);
        }
        return $records;
    }

    public function get_unread_chats_username($me_user_id)
    {
        $output = array();
        $model = new Common_model();
        $redis_functions = new Redisfunctions();
        $me_username = $model->fetchSelectedData('user_username', TABLE_USERS, array('user_id' => $me_user_id))[0]['user_username'];
        $deleted_message_ids = $redis_functions->get_deleted_message_ids($me_username);

        $where_str = '`message_user_to` = ' . $me_user_id . ' and `message_read` = "0"';
        if (!empty($deleted_message_ids))
        {
            $imploded_message_id = implode(',', $deleted_message_ids);
            $where_str.=' AND message_id NOT IN (' . $imploded_message_id . ')';
        }

        $sql = 'select distinct user_username as from_username from ' . TABLE_MESSAGES . ' left join `users` on user_id = `message_user_from` where ' . $where_str;
        $records = $this->db->query($sql)->result_array();
        if (!empty($records))
        {
            foreach ($records as $value)
            {
                $output[] = $value['from_username'];
            }
        }

        return $output;
    }

    public function get_you_may_like($current_url_key, $max_results = 5)
    {
        $redis_functions = new Redisfunctions();
        $post_details = $redis_functions->get_trip_details($current_url_key);
        $post_regions = $post_from_dates = $post_to_dates = $post_activities = $where_arr = $output_data = array();

        // Adding post regions to where str
        if (!empty($post_details['post_regions']))
        {
            foreach ($post_details['post_regions'] as $region_key => $region_value)
            {
                $post_regions[] = $region_value->pr_source_region;
                $post_regions[] = $region_value->pr_destination_region;

                // Adding from and to date of the trip to match
                $post_from_dates[] = $region_value->pr_from_date;
                $post_to_dates[] = $region_value->pr_to_date;
            }
        }

        // Adding post activities
        if (!empty($post_details['post_activities']))
        {
            foreach ($post_details['post_activities'] as $activity_key => $activity_value)
            {
                $post_activities[] = $activity_value->pa_activity_id;
            }
        }

        if (!empty($post_regions))
        {
            $imploded_regions = '"' . implode('", "', array_unique($post_regions)) . '"';
            $where_arr[] = 'pr.pr_source_region IN (' . $imploded_regions . ')';
            $where_arr[] = 'pr.pr_destination_region IN (' . $imploded_regions . ')';
        }

        if (!empty($post_from_dates))
        {
            $imploded_from_dates = '"' . implode('", "', array_unique($post_from_dates)) . '"';
            $where_arr[] = 'pr.pr_from_date IN (' . $imploded_from_dates . ')';
        }

        if (!empty($post_to_dates))
        {
            $imploded_to_dates = '"' . implode('", "', array_unique($post_to_dates)) . '"';
            $where_arr[] = 'pr.pr_to_date IN (' . $imploded_to_dates . ')';
        }

        if (!empty($post_activities))
        {
            $imploded_activities = '"' . implode('", "', array_unique($post_activities)) . '"';
            $where_str[] = 'pa.pa_activity_id IN (' . $imploded_activities . ')';
        }

        if (!empty($where_str))
        {
            $where_str = 'p.post_url_key != "' . $current_url_key . '" AND (' . implode(' OR ', $where_arr) . ')';
            $records = $search_results = $this->get_search_results('p.post_url_key', $where_str, NULL, NULL, $max_results);
            if (!empty($records))
            {
                foreach ($records as $value)
                {
                    $output_data[] = $redis_functions->get_trip_details($value['post_url_key']);
                }
            }
        }
        return $output_data;
    }

    public function get_user_profile_data($username, $user_fields = NULL)
    {
        if ($user_fields == NULL)
        {
            $user_fields = 'user_id, user_fullname, user_username, user_email, user_city, user_state, user_country, user_location, user_latitude, user_longitude, user_dob, user_gender, user_relationship_status, user_about, user_tagline, user_profile_picture, user_facebook_id, user_languages_known';
        }

        $model = new Common_model();
        $records = $model->fetchSelectedData($user_fields, TABLE_USERS, array('user_username' => $username));
        if (!empty($records))
        {
            $records = $records[0];
        }

        // to fetch trips posted by the user
        $trips_posted_records = $model->fetchSelectedData('post_id, post_url_key, post_published', TABLE_POSTS, array('post_user_id' => $records['user_id']), 'post_id', 'DESC');
        $records['trips_posted'] = $trips_posted_records;

        // to fetch the trips owner has joined
//        $records['trips_joined'] = $this->get_joined_trips($username);
        // to fetch user's wishlist
        $wishlist_records = $model->getAllDataFromJoin('post_url_key', TABLE_WISHLIST, array(TABLE_POSTS => 'post_id = wishlist_post_id'), 'LEFT', array('wishlist_status' => '1', 'post_published' => '1', 'wishlist_user_id' => $records['user_id']), 'wishlist_id', 'DESC');
        $records['my_wishlist'] = $wishlist_records;

        return $records;
    }

    public function get_joined_trips($username)
    {
        $output_arr = array();
        $redis_functions = new Redisfunctions();
        $user_profile_data = $redis_functions->get_user_profile_data($username);
        if (!empty($user_profile_data))
        {
            $user_id = $user_profile_data['user_id'];
            $sql = 'SELECT p.post_url_key, p.post_published, p.post_status FROM ' . TABLE_POSTS . ' as p 
                    left join ' . TABLE_POST_TRAVELERS . ' as pt on pt.pt_post_id = p.post_id
                    WHERE pt_traveler_user_id = ' . $user_id . ' AND p.post_user_id != ' . $user_id . ' 
                    GROUP BY p.post_id';
            $output_arr = $this->db->query($sql)->result_array();
        }
        return $output_arr;
    }

}
