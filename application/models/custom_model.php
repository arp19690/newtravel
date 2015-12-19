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

            $post_activities_records = $model->fetchSelectedData('*', TABLE_POST_ACTIVITIES, array('pa_post_id' => $post_id));
            $output['post_activities'] = $post_activities_records;

            $post_featured_records = $model->fetchSelectedData('*', TABLE_POST_FEATURED, array('pf_post_id' => $post_id, 'pf_status' => '1', 'pf_end_date >' => date('Y-m-d H:i:s')));
            $output['post_featured'] = $post_featured_records;

            $post_regions_records = $model->fetchSelectedData('*', TABLE_POST_REGIONS, array('pr_post_id' => $post_id));
            $output['post_regions'] = $post_regions_records;

            $post_comments_records = $model->fetchSelectedData('*', TABLE_POST_COMMENTS, array('pcm_post_id' => $post_id));
            $output['post_comments'] = $post_comments_records;

            $post_costs_records = $model->fetchSelectedData('*', TABLE_POST_COSTS, array('cost_post_id' => $post_id));
            $output['post_costs'] = $post_costs_records;
            $total_cost = 0;
            if (!empty($post_costs_records))
            {
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

    public function get_featured_trips($fields = 'p.post_url_key')
    {
        $sql = "SELECT " . $fields . " FROM `post_featured` as pf LEFT JOIN posts as p ON p.post_id = pf.pf_post_id LEFT JOIN post_featured_master as pfm on pfm.pfm_id = pf.pf_pfm_id WHERE p.post_status = '1' and p.post_published = '1' and pf.pf_status = '1' and pfm.pfm_status = '1' and pf_end_date > '" . date('Y-m-d H:i:s') . "' ORDER BY pfm.pfm_amount";
        $records = $this->db->query($sql)->result_array();
        return $records;
    }

}
