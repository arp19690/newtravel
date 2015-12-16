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

    public function add_new($step = 1, $url_key = NULL)
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();

        switch ($step)
        {
            case 1:
                $this->add_new_step_one();
                break;
            case 2:
                $this->add_new_step_two($url_key);
                break;
        }
    }

    public function add_new_step_one()
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();

            $trip_title = addslashes($arr['trip_title']);
            $trip_description = addslashes($arr['trip_description']);
            $trip_url_key = get_trip_url_key($trip_title);

            $trip_data_array = array(
                'post_user_id' => $user_id,
                'post_title' => $trip_title,
                'post_description' => $trip_description,
                'post_created_on' => date('Y-m-d H:i:s'),
                'post_ipaddress' => USER_IP,
                'post_useragent' => USER_AGENT,
                'post_url_key' => $trip_url_key
            );
            $post_id = $model->insertData(TABLE_POSTS, $trip_data_array);

            if (!empty($arr['activities']))
            {
                $model->deleteData(TABLE_POST_ACTIVITIES, array('pa_post_id' => $post_id));
                foreach ($arr['activities'] as $activity_id)
                {
                    $model->insertData(TABLE_POST_ACTIVITIES, array('pa_post_id' => $post_id, 'pa_activity_id' => $activity_id));
                }
            }

            // setting post details to redis
            $this->redis_functions->set_post_details($trip_url_key);

            redirect(base_url('trip/post/edit/2/' . $trip_url_key));
        }
        else
        {
            $activity_master = $this->redis_functions->get_activity_master();

            $input_arr = array(
                base_url() => 'Home',
                base_url('trips') => 'Trips',
                '#' => 'Post new trip',
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

    public function add_new_step_two($url_key)
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();
            prd($arr);

            // setting post details to redis
            $this->redis_functions->set_post_details($url_key);

            redirect(base_url('trip/post/edit/3/' . $url_key));
        }
        else
        {
            $post_details = $this->redis_functions->set_post_details($url_key);
            $post_title = stripslashes($post_details['post_title']);

            $input_arr = array(
                base_url() => 'Home',
                base_url('trips') => 'Trips',
                '#' => $post_title,
            );
            $breadcrumbs = get_breadcrumbs($input_arr);

            $data["breadcrumbs"] = $breadcrumbs;
            $data["page_title"] = $post_title;
            $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
            $this->template->write_view("content", "pages/trip/post/step-2", $data);
            $this->template->render();
        }
    }

}
