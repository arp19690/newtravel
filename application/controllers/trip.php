<?php

class Trip extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redis_functions = new Redisfunctions();
    }

    public function index()
    {
        $this->add_new();
    }

    public function add_new($step = 1)
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();

        switch ($step)
        {
            case 1:
                {
                    $this->add_new_step_one();
                    break;
                }
        }
    }

    public function add_new_step_one()
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();

        $activity_master = $this->redis_functions->get_activity_master();

        $input_arr = array(
            base_url() => 'Home',
            base_url('trips') => 'Trips',
            base_url('trips/post/new') => 'Post new trip',
        );
        $breadcrumbs = get_breadcrumbs($input_arr);

        $data["activity_master"] = $activity_master;
        $data["breadcrumbs"] = $breadcrumbs;
        $data["page_title"] = "Post new trip";
        $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
        $this->template->write_view("content", "pages/trip/post/step-1", $data);
        $this->template->render();
    }

}
