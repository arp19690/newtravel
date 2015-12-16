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

    public function add_new()
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();

        $input_arr = array(
            base_url() => 'Home',
            base_url('trips') => 'Trips',
            base_url('trips/post/new') => 'Post new trip',
        );
        $breadcrumbs = get_breadcrumbs($input_arr);

        $data["breadcrumbs"] = $breadcrumbs;
        $data["page_title"] = "Post new trip";
        $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
        $this->template->write_view("content", "pages/trip/post", $data);
        $this->template->render();
    }

}
