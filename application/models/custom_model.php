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

            $post_comments_records = $model->fetchSelectedData('*', TABLE_POST_COMMENTS, array('pcm_post_id' => $post_id));
            $output['post_comments'] = $post_comments_records;

            $post_costs_records = $model->fetchSelectedData('*', TABLE_POST_COSTS, array('cost_post_id' => $post_id));
            $output['post_costs'] = $post_costs_records;
            $total_cost = 0;
            if (!empty($post_costs_records))
            {
                $output['post_currency'] = $post_costs_records[0]['cost_currency'];
                foreach ($post_costs_records as $value)
                {
                    $total_cost = $total_cost + $value['cost_amount'];
                }
            }
            $output['post_total_cost'] = $total_cost;

            $post_travelers_records = $model->fetchSelectedData('*', TABLE_POST_TRAVELERS, array('pt_post_id' => $post_id));
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
                $post_published = 1;

                $required_keys = array(
                    'post_title' => 'Please enter a title',
                    'post_url_key' => 'Please enter a title',
                    'post_regions' => 'Please enter your itinerary information',
                );

                foreach ($required_keys as $key => $error_message)
                {
                    if (empty($key))
                    {
                        $post_published = 0;
                        $this->session->set_flashdata('warning', $error_message);
                        break;
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

    public function get_search_results($fields = 'p.post_url_key', $where_cond_str = '1', $group_by = 'p.post_id', $order_by = 'p.post_title ASC')
    {
        $output = array();
        $sql = 'SELECT ' . $fields . ' FROM `posts` as p 
                    left join post_regions as pr on pr.pr_post_id = p.post_id
                    left join post_costs as pc on pc.cost_post_id = p.post_id
                    left join post_travelers as pt on pt.pt_post_id = p.post_id
                    WHERE ' . $where_cond_str . '
                    GROUP BY ' . $group_by . ' 
                    ORDER BY ' . $order_by;
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

    public function getLatestChatsAjax($fields, $user_id, $other_user_id, $last_timestamp)
    {
        $whereCondStr = '(message_user_to = ' . $user_id . ' OR message_user_to = ' . $other_user_id . ' OR message_user_from = ' . $user_id . ' OR message_user_from = ' . $other_user_id . ') AND message_timestamp >= ' . $last_timestamp;

//        Fetching latest messages
        $sql = 'SELECT ' . $fields . ' FROM ' . TABLE_MESSAGES . ' WHERE ' . $whereCondStr . ' ORDER BY message_id';
        $records = $this->db->query($sql)->result_array();

//        Updating them as read messages
        $update_sql = 'UPDATE ' . TABLE_MESSAGES . ' SET message_read = "1" WHERE message_user_to = ' . $user_id . ' AND message_timestamp >= ' . $last_timestamp;
        $this->db->query($update_sql)->result_array();

        return $records;
    }

    public function get_min_and_max_cost_amounts()
    {
        $sql = 'select min(cost_amount) as min_cost, max(cost_amount) as max_cost from post_costs';
        $records = $this->db->query($sql)->result_array();
        return $records[0];
    }

    public function get_inbox_list($user_id, $fields = 'm1.message_id, m1.message_text, m1.message_timestamp, to_user.user_fullname as to_fullname, to_user.user_profile_picture as to_profile_picture, to_user.user_username as to_username')
    {
        $sql = 'SELECT  ' . $fields . ' FROM `messages` as m1 
                    left join messages as m2 on m2.`message_user_from` = m1.`message_user_from` and m2.message_id > m1.message_id
                    left join users as from_user on from_user.user_id = m1.`message_user_from`
                    left join users as to_user on to_user.user_id = m1.`message_user_to`
                    WHERE m1.`message_user_from` = ' . $user_id . ' and m1.`message_user_to` != ' . $user_id . ' AND m2.message_id is NULL AND m1.message_deleted = "0"
                    GROUP BY m1.`message_user_to`';
        $records = $this->db->query($sql)->result_array();
        return $records;
    }

    public function get_chat_history($user_from, $user_to, $fields = NULL, $limit = '20')
    {
        if ($fields == NULL)
        {
            $fields = 'm1.message_id, m1.message_text, m1.message_timestamp, from_user.user_fullname as from_fullname, to_user.user_fullname, from_user.user_profile_picture as from_profile_picture, from_user.user_username as from_username';
        }
        $sql = 'SELECT ' . $fields . ' FROM `messages` as m1 left join users as from_user on from_user.user_id = m1.`message_user_from` left join users as to_user on to_user.user_id = m1.`message_user_to` WHERE m1.`message_user_from` in (' . $user_from . ',' . $user_to . ') and m1.`message_user_to` in (' . $user_from . ',' . $user_to . ') AND m1.message_deleted = "0" ORDER BY message_id DESC LIMIT ' . $limit;
        $records = $this->db->query($sql)->result_array();
        if (!empty($records))
        {
            $records = array_reverse($records);
        }
        return $records;
    }

}
