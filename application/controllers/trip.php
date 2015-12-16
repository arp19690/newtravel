<?php

class Trip extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
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

        $data["page_title"] = "Post new trip";
        $data['meta_title'] = $data["page_title"] . ' | ' . SITE_NAME;
        $this->template->write_view("content", "pages/trip/post", $data);
        $this->template->render();
    }

}
