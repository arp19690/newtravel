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
                // meta info
                $this->add_new_step_one($url_key);
                break;
            case 2:
                // regions
                $this->add_new_step_two($url_key);
                break;
            case 3:
                // budgets
                $this->add_new_step_three($url_key);
                break;
            case 4:
                // media
                $this->add_new_step_four($url_key);
                break;
        }
    }

    public function add_new_step_one($url_key = NULL)
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();

            $trip_title = addslashes($arr['trip_title']);
            $trip_description = addslashes($arr['trip_description']);

            $post_id = NULL;
            if ($url_key != NULL)
            {
                $post_records = (array) $this->redis_functions->get_post_details($url_key);
                $post_id = $post_records['post_id'];
            }
            $trip_url_key = get_trip_url_key($trip_title, $post_id);

            $trip_data_array = array(
                'post_user_id' => $user_id,
                'post_title' => $trip_title,
                'post_description' => $trip_description,
                'post_created_on' => date('Y-m-d H:i:s'),
                'post_ipaddress' => USER_IP,
                'post_useragent' => USER_AGENT,
                'post_url_key' => $trip_url_key
            );

            if ($url_key == NULL)
            {
                $post_id = $model->insertData(TABLE_POSTS, $trip_data_array);
            }
            else
            {
                $model->updateData(TABLE_POSTS, $trip_data_array, array('post_url_key' => $trip_url_key, 'post_id' => $post_id));
            }

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

            if ($url_key == NULL)
            {
                $page_title = 'Post new trip';
            }
            else
            {
                $post_records = (array) $this->redis_functions->get_post_details($url_key);
                $page_title = $post_records['post_title'];
                $data["post_records"] = $post_records;
            }

            $input_arr = array(
                base_url() => 'Home',
                base_url('trips') => 'Trips',
                '#' => $page_title,
            );
            $breadcrumbs = get_breadcrumbs($input_arr);

            $data["activity_master"] = $activity_master;
            $data["breadcrumbs"] = $breadcrumbs;
            $data["page_title"] = $page_title;
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
        $post_details = $this->redis_functions->get_post_details($url_key);
        $post_title = stripslashes($post_details->post_title);
        $post_id = $post_details->post_id;

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();

            if (isset($arr['post_source']) && !empty($arr['post_source']))
            {
                $i = 1;
                foreach ($arr['post_source'] as $key => $source_value)
                {
                    $post_source = $source_value;
                    $post_destination = $arr['post_destination'][$key];
                    $from_date = $arr['date_from_yy'][$key] . '-' . $arr['date_from_mm'][$key] . '-' . $arr['date_from_dd'][$key];
                    $to_date = $arr['date_to_yy'][$key] . '-' . $arr['date_to_mm'][$key] . '-' . $arr['date_to_dd'][$key];
                    $travel_medium = $arr['travel_medium'][$key];

                    // now fetching LAT-LONG
                    $post_source_lat_long = getLatLonByAddress($post_source);
                    $post_destination_lat_long = getLatLonByAddress($post_destination);

                    // fetching address details from google
                    $post_source_address_details = get_location_details_from_google($post_source);
                    $post_destination_address_details = get_location_details_from_google($post_destination);

                    $data_array = array(
                        'pr_post_id' => $post_id,
                        'pr_order_number' => $i,
                        'pr_source_location' => addslashes($post_source),
                        'pr_destination_location' => addslashes($post_destination),
                        'pr_source_city' => addslashes($post_source_address_details['city']),
                        'pr_source_region' => addslashes($post_source_address_details['state']),
                        'pr_source_country' => addslashes($post_source_address_details['country']),
                        'pr_source_latitude' => addslashes($post_source_lat_long['latitude']),
                        'pr_source_longitude' => addslashes($post_source_lat_long['longitude']),
                        'pr_destination_city' => addslashes($post_destination_address_details['city']),
                        'pr_destination_region' => addslashes($post_destination_address_details['state']),
                        'pr_destination_country' => addslashes($post_destination_address_details['country']),
                        'pr_destination_latitude' => addslashes($post_destination_lat_long['latitude']),
                        'pr_destination_longitude' => addslashes($post_destination_lat_long['longitude']),
                        'pr_from_date' => $from_date,
                        'pr_to_date' => $to_date,
                        'pr_travel_medium' => $travel_medium
                    );
                    $model->insertData(TABLE_POST_REGIONS, $data_array);

                    $i++;
                }
            }

            // setting post details to redis
            $this->redis_functions->set_post_details($url_key);

            redirect(base_url('trip/post/edit/3/' . $url_key));
        }
        else
        {
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

    public function add_new_step_three($url_key)
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();
        $post_details = $this->redis_functions->get_post_details($url_key);
        $post_title = stripslashes($post_details->post_title);
        $post_id = $post_details->post_id;

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();

            if (isset($arr['cost_amount']) && !empty($arr['cost_amount']))
            {
                foreach ($arr['cost_amount'] as $key => $amount)
                {
                    $post_cost = round($amount, 2);
                    $post_title = addslashes($arr['cost_title'][$key]);
                    $post_currency = addslashes($arr['cost_currency'][$key]);

                    $data_array = array(
                        'cost_post_id' => $post_id,
                        'cost_title' => $post_title,
                        'cost_title' => $post_title,
                        'cost_amount' => $post_cost,
                        'cost_currency' => $post_currency,
                    );
                    $model->insertData(TABLE_POST_COSTS, $data_array);
                }
            }

            // setting post details to redis
            $this->redis_functions->set_post_details($url_key);

            redirect(base_url('trip/post/edit/4/' . $url_key));
        }
        else
        {
            $input_arr = array(
                base_url() => 'Home',
                base_url('trips') => 'Trips',
                '#' => $post_title,
            );
            $breadcrumbs = get_breadcrumbs($input_arr);

            $data["breadcrumbs"] = $breadcrumbs;
            $data["page_title"] = $post_title;
            $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
            $this->template->write_view("content", "pages/trip/post/step-3", $data);
            $this->template->render();
        }
    }

    public function add_new_step_four($url_key)
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();
        $post_details = $this->redis_functions->get_post_details($url_key);
        $post_title = stripslashes($post_details->post_title);
        $post_id = $post_details->post_id;

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();
            prd($arr);

            // setting post details to redis
            $this->redis_functions->set_post_details($url_key);

            redirect(base_url('trip/review/' . $url_key));
        }
        else
        {
            $input_arr = array(
                base_url() => 'Home',
                base_url('trips') => 'Trips',
                '#' => $post_title,
            );
            $breadcrumbs = get_breadcrumbs($input_arr);

            $data["breadcrumbs"] = $breadcrumbs;
            $data["page_title"] = $post_title;
            $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
            $this->template->write_view("content", "pages/trip/post/step-4", $data);
            $this->template->render();
        }
    }

    public function review($url_key)
    {
        
    }

}
