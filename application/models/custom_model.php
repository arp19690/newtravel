<?php

class Custom_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load DB here
        $this->load->database();
    }

    public function get_post_detail($url_key)
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

            $post_regions_records = $model->fetchSelectedData('*', TABLE_POST_REGIONS, array('pr_post_id' => $post_id));
            $output['post_regions'] = $post_regions_records;

            $post_comments_records = $model->fetchSelectedData('*', TABLE_POST_COMMENTS, array('pcm_post_id' => $post_id));
            $output['post_comments'] = $post_comments_records;

            $post_costs_records = $model->fetchSelectedData('*', TABLE_POST_COSTS, array('cost_post_id' => $post_id));
            $output['post_costs'] = $post_costs_records;

            $post_travelers_records = $model->fetchSelectedData('*', TABLE_POST_TRAVELERS, array('pt_post_id' => $post_id));
            $output['post_travelers'] = $post_travelers_records;

            $post_images_records = $model->fetchSelectedData('*', TABLE_POST_MEDIA, array('pm_post_id' => $post_id, 'pm_media_type' => 'image', 'pm_status' => '1'));
            $output['post_media']['images'] = $post_images_records;

            $post_videos_records = $model->fetchSelectedData('*', TABLE_POST_MEDIA, array('pm_post_id' => $post_id, 'pm_media_type' => 'video', 'pm_status' => '1'));
            $output['post_media']['videos'] = $post_videos_records;
        }
        return $output;
    }

    public function verify_post_status($url_key)
    {
        $model = new Common_model();
        $post_details = $this->get_post_detail($url_key);

        if (isset($this->session->userdata["user_id"]) && $post_details['post_user_id'] == @$this->session->userdata["user_id"])
        {
            $post_published = 1;
            if (empty($post_details['post_title']) || empty($post_details['post_url_key']) || empty($post_details['post_regions']) || empty($post_details['post_user_id']))
            {
                $post_published = 0;
            }
            $model->updateData(TABLE_POSTS, array('post_published' => $post_published), array('post_url_key' => $url_key));
            $this->redis_functions->set_post_details($url_key);
        }
        return TRUE;
    }

}
