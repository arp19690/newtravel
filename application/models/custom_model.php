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

            $post_media_records = $model->fetchSelectedData('*', TABLE_POST_MEDIA, array('pm_post_id' => $post_id));
            $output['post_media'] = $post_media_records;
        }
        return $output;
    }

}
