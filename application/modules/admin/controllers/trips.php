<?php

class Trips extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $post_records = array();
        $redis_functions = new Redisfunctions();
        $page_title = 'All Trips';

        $all_post_url_keys = $redis_functions->get_all_trips();
        if (!empty($all_post_url_keys))
        {
            foreach ($all_post_url_keys as $url_key)
            {
                $post_records[] = $redis_functions->get_trip_details($url_key["post_url_key"]);
            }
        }
      
        $data["alldata"] = $post_records;
//            prd($data);

        $this->template->write_view("content", "trips/trip-list", $data);
        $this->template->render();
    }

}
