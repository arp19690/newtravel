<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trip extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redis_functions = new Redisfunctions();
    }

    public function index()
    {
        if (isset($this->session->userdata["user_id"]))
        {
            $this->add_new();
        }
        else
        {
            display_404_page();
        }
    }

    public function add_new($step = 1, $url_key = NULL)
    {
        if (isset($this->session->userdata["user_id"]))
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
        else
        {
            require_once APPPATH . 'controllers/index.php';
            $index_controller = new Index();
            $index_controller->login();
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
                $post_records = (array) $this->redis_functions->get_trip_details($url_key);
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
                // adding self to the travelers list
                $this->add_user_as_traveler_to_post($post_id, $user_id);
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
            $this->redis_functions->set_trip_details($trip_url_key);

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
                $post_records = (array) $this->redis_functions->get_trip_details($url_key);
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
        $trip_details = $this->redis_functions->get_trip_details($url_key);
        $post_title = stripslashes($trip_details['post_title']);
        $post_id = $trip_details['post_id'];

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();

            if (isset($arr['post_source']) && !empty($arr['post_source']))
            {
                $model->deleteData(TABLE_POST_REGIONS, array('pr_post_id' => $post_id));
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
            $this->redis_functions->set_trip_details($url_key);

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
            $data["post_records"] = $trip_details;
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
        $trip_details = $this->redis_functions->get_trip_details($url_key);
        $post_title = stripslashes($trip_details['post_title']);
        $post_id = $trip_details['post_id'];

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();

            if (isset($arr['cost_amount']) && !empty($arr['cost_amount']))
            {
                $model->deleteData(TABLE_POST_COSTS, array('cost_post_id' => $post_id));
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
            $this->redis_functions->set_trip_details($url_key);

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
            $data["post_records"] = $trip_details;
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
        $trip_details = $this->redis_functions->get_trip_details($url_key);
        $post_title = stripslashes($trip_details['post_title']);
        $post_id = $trip_details['post_id'];

        if ($this->input->post() && isset($user_id))
        {
            $arr = $this->input->post();

            // To update existing media data
            if (!empty($arr['existing_media_id']) && isset($arr['existing_media_id']))
            {
                foreach ($arr['existing_media_id'] as $existing_key => $existing_value)
                {
                    $pm_id = getEncryptedString($existing_value, 'decode');
                    $pm_media_title = addslashes($arr['existing_media_title'][$existing_key]);
                    $model->updateData(TABLE_POST_MEDIA, array('pm_media_title' => $pm_media_title), array('pm_post_id' => $post_id, 'pm_id' => $pm_id));
                }
            }

            // To upload fresh/new selected media
            if (!empty($arr['media_type']) && isset($arr['media_type']))
            {
                foreach ($arr['media_type'] as $key => $media_type)
                {
                    $media_filename = NULL;
                    $image_i = 0;
                    if ($media_type == 'image')
                    {
                        $file_tmpSource = $_FILES['media_image']['tmp_name'][$key];
                        if (!empty($file_tmpSource) && isset($file_tmpSource))
                        {
                            $ext = getFileExtension($_FILES['media_image']['name'][$key]);
                            if (isValidImageExt($ext))
                            {
                                $random_number = rand(1000, 9999999);
                                $media_filename = str_replace('//', '/', $this->redis_functions->get_site_setting('POST_IMAGE_PATH') . $url_key . '-' . $random_number . '.' . $ext);

                                if (uploadImage($file_tmpSource, $media_filename, $this->redis_functions->get_site_setting('POST_IMAGE_WIDTH'), $this->redis_functions->get_site_setting('POST_IMAGE_HEIGHT')))
                                {
                                    $new_filename = NULL;
                                }
                            }
                        }
                        $image_i++;
                    }
                    elseif ($media_type == 'video')
                    {
                        if (!empty($arr['media_video'][$key]))
                        {
                            $media_filename = $arr['media_video'][$key];
                        }
                    }

                    // inserting data here
                    if ($media_filename != NULL)
                    {
                        $data_array = array(
                            'pm_post_id' => $post_id,
                            'pm_primary' => (($image_i == 1 && strtolower($media_type) == 'image') ? '1' : '0'),
                            'pm_media_type' => strtolower($media_type),
                            'pm_media_title' => addslashes($arr['media_type']),
                            'pm_media_url' => $media_filename,
                            'pm_ipaddress' => USER_IP,
                            'pm_useragent' => USER_AGENT,
                            'pm_created_on' => date('Y-m-d H:i:s')
                        );
                        $model->insertData(TABLE_POST_MEDIA, $data_array);
                    }
                }
            }

            // setting post details to redis
            $this->redis_functions->set_trip_details($url_key);
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
            $data["post_records"] = $trip_details;
            $data["page_title"] = $post_title;
            $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
            $this->template->write_view("content", "pages/trip/post/step-4", $data);
            $this->template->render();
        }
    }

    public function review($url_key)
    {
        $model = new Common_model();
        if (isset($this->session->userdata["user_id"]))
        {
            $user_id = $this->session->userdata["user_id"];
            $is_valid = $model->fetchSelectedData('post_id', TABLE_POSTS, array('post_url_key' => $url_key, 'post_user_id' => $user_id));
            if (!empty($is_valid))
            {
                $trip_details = $this->redis_functions->get_trip_details($url_key);
                $post_title = stripslashes($trip_details['post_title']);
                if (!empty($trip_details))
                {
                    $input_arr = array(
                        base_url() => 'Home',
                        base_url('trips') => 'Trips',
                        '#' => 'Review - ' . $post_title,
                    );
                    $breadcrumbs = get_breadcrumbs($input_arr);

                    $data["post_details"] = $trip_details;
                    $data["breadcrumbs"] = $breadcrumbs;
                    $data["page_title"] = $post_title;
                    $data['meta_title'] = 'Review - ' . $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
                    $this->template->write_view("content", "pages/trip/post/review", $data);
                    $this->template->render();
                }
                else
                {
                    display_404_page();
                }
            }
            else
            {
                display_404_page();
            }
        }
        else
        {
            display_404_page();
        }
    }

    public function removeMediaAjax($url_key)
    {
        if ($this->input->get('id'))
        {
            $pm_id = getEncryptedString($this->input->get('id'), 'decode');
            if ($this->removePostMedia($url_key, $pm_id) == TRUE)
            {
                $output = array('status' => 'success', 'message' => 'Media successfully removed.');
            }
            else
            {
                $output = array('status' => 'error', 'message' => 'An error occurred. Please try again.');
            }
        }
        else
        {
            $output = array('status' => 'error', 'message' => 'Invalid URL or Parameter passed');
        }

        $output = json_encode($output);
        echo $output;
        return $output;
    }

    public function removePostMedia($url_key, $pm_id = NULL)
    {
        $model = new Common_model();
        $post_records = $model->fetchSelectedData('post_id', TABLE_POSTS, array('post_url_key' => $url_key));
        $post_media_where_arr = array('pm_post_id' => $post_records[0]['post_id']);
        if ($pm_id != NULL)
        {
            $post_media_where_arr['pm_id'] = $pm_id;
        }
        $post_media_records = $model->fetchSelectedData('pm_id, pm_media_type, pm_media_url', TABLE_POST_MEDIA, $post_media_where_arr);
        if (!empty($post_media_records))
        {
            foreach ($post_media_records as $key => $value)
            {
                if ($value['pm_media_type'] == 'image')
                {
                    $new_path = $this->redis_functions->get_site_setting('POST_IMAGE_DELETED_PATH');
                    $original_filename = explode('/', $value['pm_media_url']);
                    $count_exploded = count($original_filename);
                    $new_filename = str_replace('//', '/', $new_path . '/' . $original_filename[$count_exploded - 1]);
                    copy($value['pm_media_url'], $new_filename);
                    @unlink($value['pm_media_url']);
                    $model->updateData(TABLE_POST_MEDIA, array('pm_media_url' => $new_filename, 'pm_status' => '2'), array('pm_post_id' => $post_records[0]['post_id'], 'pm_id' => $value['pm_id']));
                }

                if ($pm_id == NULL)
                {
                    // updating the status as deleted for both video and image here itself
                    $model->updateData(TABLE_POST_MEDIA, array('pm_status' => '2'), array('pm_post_id' => $post_records[0]['post_id']));
                }
                else
                {
//                    If the media is known
                    $model->updateData(TABLE_POST_MEDIA, array('pm_status' => '2'), array('pm_post_id' => $post_records[0]['post_id'], 'pm_id' => $pm_id));
                }
            }

            // Updating trip's redis data here
            $this->redis_functions->set_trip_details($url_key);
        }
        return TRUE;
    }

    public function add_user_as_traveler_to_post($post_id, $user_id)
    {
        $model = new Common_model();
        $fields = 'user_fullname, user_email, user_dob, user_gender, user_city, user_region, user_country, user_location, user_languages_known';
        $user_record = $model->fetchSelectedData($fields, TABLE_USERS, array('user_id' => $user_id));
        $data_array = array(
            'pt_post_id' => $post_id,
            'pt_traveler_name' => $user_record[0]['user_fullname'],
            'pt_traveler_email' => $user_record[0]['user_email'],
            'pt_traveler_age' => getAge($user_record[0]['user_dob']),
            'pt_traveler_gender' => $user_record[0]['user_gender'],
            'pt_traveler_user_id' => $user_id,
            'pt_traveler_city' => $user_record[0]['user_city'],
            'pt_traveler_region' => $user_record[0]['user_region'],
            'pt_traveler_country' => $user_record[0]['user_country'],
            'pt_traveler_location' => $user_record[0]['user_location'],
            'pt_traveler_languages_known' => $user_record[0]['user_languages_known'],
            'pt_added_by' => $user_id
        );
        $model->insertData(TABLE_POST_TRAVELERS, $data_array);
        return TRUE;
    }

    public function all_posts($view_type = 'list', $page = 1)
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
                $post_records[] = $redis_functions->get_trip_details($url_key);
            }
        }

        $input_arr = array(
            base_url() => 'Home',
            '#' => $page_title,
        );
        $breadcrumbs = get_breadcrumbs($input_arr);

        $data["post_records"] = $post_records;
        $data["view_type"] = $view_type;
        $data["page"] = $page;
        $data["breadcrumbs"] = $breadcrumbs;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
        $this->template->write_view("content", "pages/trip/listing/list-page", $data);
        $this->template->render();
    }

    public function my_posts($view_type = 'list', $page = 1)
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();
        $page_title = 'Trips I\'ve Posted';

        $whereConsStr = array('post_user_id' => $user_id);
        $limit = getPaginationLimit($page, TRIPS_PAGINATION_LIMIT);
        $post_records = $model->fetchSelectedData('post_url_key', TABLE_POSTS, $whereConsStr, 'post_id', 'DESC', $limit);

        $input_arr = array(
            base_url() => 'Home',
            '#' => $page_title,
        );
        $breadcrumbs = get_breadcrumbs($input_arr);

        $data["post_records"] = $post_records;
        $data["view_type"] = $view_type;
        $data["page"] = $page;
        $data["breadcrumbs"] = $breadcrumbs;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
        $this->template->write_view("content", "pages/trip/listing/list-page", $data);
        $this->template->render();
    }

    public function trip_details($post_url_key)
    {
        $post_details = $this->redis_functions->get_trip_details($post_url_key);
        if (!empty($post_details))
        {
            $data = array();
            $page_title = stripslashes($post_details['post_title']);

            $input_arr = array(
                base_url() => 'Home',
                base_url('trips') => 'Trips',
                '#' => $page_title,
            );
            $breadcrumbs = get_breadcrumbs($input_arr);

            $data["post_details"] = $post_details;
            $data["breadcrumbs"] = $breadcrumbs;
            $data["page_title"] = $page_title;
            $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
            $data['meta_description'] = getNWordsFromString(stripslashes($post_details['post_description']), 150);
            $this->template->write_view("content", "pages/trip/trip-detail", $data);
            $this->template->render();
        }
        else
        {
            display_404_page();
        }
    }

    public function delete_trip($post_url_key)
    {
        if (isset($this->session->userdata["user_id"]))
        {
            $user_id = $this->session->userdata["user_id"];
            $model = new Common_model();
            $where_cond_arr = array('post_url_key' => $post_url_key, 'post_user_id' => $user_id, 'post_status !=' => '2');
            $post_details = $model->fetchSelectedData('post_id, post_title', TABLE_POSTS, $where_cond_arr);
            if (!empty($post_details))
            {
                $model->updateData(TABLE_POSTS, array('post_status' => '3'), $where_cond_arr);
                $this->redis_functions->remove_trip_details($post_url_key);
                $this->session->set_flashdata('success', stripslashes($post_details[0]['post_title']), ' successfully deleted');
            }
            else
            {
                $this->session->set_flashdata('error', 'No such posts found to be deleted');
            }
            redirect(base_url('my-trips/list'));
        }
        else
        {
            display_404_page();
        }
    }

    public function search($view_type = 'list', $page = 1)
    {
        $model = new Common_model();
        $custom_model = new Custom_model();
        $params = $this->input->get();

        $user_id = isset($this->session->userdata['user_id']) == TRUE ? $this->session->userdata['user_id'] : NULL;
        $search_location = !empty($params['search_location']) == TRUE ? addslashes($params['search_location']) : NULL;
        $search_travelers = !empty($params['search_travelers']) == TRUE ? addslashes($params['search_travelers']) : NULL;
        $search_date_start = !empty($params['search_date_start']) == TRUE ? date('Y-m-d', strtotime($params['search_date_start'])) : NULL;
        $search_date_end = !empty($params['search_date_end']) == TRUE ? date('Y-m-d', strtotime($params['search_date_end'])) : NULL;
        $search_budget_min = !empty($params['search_budget_min']) == TRUE ? $params['search_budget_min'] : NULL;
        $search_budget_max = !empty($params['search_budget_max']) == TRUE ? $params['search_budget_max'] : NULL;
        $search_duration = !empty($params['search_duration']) == TRUE ? $params['search_duration'] : NULL;
        $search_travel_medium = !empty($params['search_travel_medium']) == TRUE ? $params['search_travel_medium'] : NULL;

        $data_array = array(
            'ps_user_id' => $user_id,
            'ps_location' => $search_location,
            'ps_travelers' => $search_travelers,
            'ps_date_start' => $search_date_start,
            'ps_date_end' => $search_date_end,
            'ps_budget_min' => $search_budget_min,
            'ps_budget_max' => $search_budget_max,
            'ps_duration' => json_encode($search_duration),
            'ps_travel_medium' => json_encode($search_travel_medium),
            'ps_url' => addslashes(current_url()),
            'ps_params' => json_encode($params),
            'ps_ipaddress' => USER_IP,
            'ps_useragent' => USER_AGENT
        );

        if ($model->is_exists('ps_id', TABLE_POST_SEARCHES, $data_array) == FALSE)
        {
            $model->insertData(TABLE_POST_SEARCHES, $data_array);
        }

        $order_by = get_post_mysql_sort_by(@$params['sort']);
        $group_by = 'p.post_id';
        $where_cond_str = '1';
//        Location
        if (!empty($search_location))
        {
            $where_cond_str .= ' AND (pr_source_location = "' . $search_location . '" or pr_destination_location = "' . $search_location . '")';
        }
//        Dates
        if (!empty($search_date_start))
        {
            $where_cond_str .= ' AND pr_from_date >= "' . $search_date_start . '"';
        }
        if (!empty($search_date_end))
        {
            $where_cond_str .= ' AND pr_to_date <= "' . $search_date_end . '"';
        }
//        Costs
        if (!empty($search_budget_min))
        {
            $where_cond_str .= ' AND cost_amount >= "' . $search_budget_min . '"';
        }
        if (!empty($search_budget_max))
        {
            $where_cond_str .= ' AND cost_amount <= "' . $search_budget_max . '"';
        }
//        Travellers
        if (!empty($search_travelers))
        {
            $search_travelers = str_replace('+', '', $search_travelers);
            if ($search_travelers <= 0)
            {
                $search_travelers = 1;
            }
            $group_by = 'p.post_id HAVING COUNT(pt_post_id) >= ' . $search_travelers;
        }

        $search_results = $custom_model->get_search_results('p.post_url_key', $where_cond_str, $order_by,$group_by);

        $input_arr = array(
            base_url() => 'Home',
            '#' => 'Search',
        );
        $breadcrumbs = get_breadcrumbs($input_arr);
        $page_title = 'Search results';

        $data["post_records"] = $search_results;
        $data["view_type"] = $view_type;
        $data["page"] = $page;
        $data["breadcrumbs"] = $breadcrumbs;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
        $this->template->write_view("content", "pages/trip/listing/list-page", $data);
        $this->template->render();
    }

    public function search_query($view_type = 'list', $page = 1)
    {
        $model = new Common_model();
        $custom_model = new Custom_model();
        if ($this->input->get('q'))
        {
            $params = $this->input->get();
            $query = $params['q'];
            $user_id = isset($this->session->userdata['user_id']) == TRUE ? $this->session->userdata['user_id'] : NULL;

            if ($model->is_exists('ps_id', TABLE_POST_SEARCHES, array('ps_user_id' => $user_id, 'ps_query' => addslashes($query), 'ps_timestamp >=' => date('Y-m-d'))) == FALSE)
            {
                $data_array = array(
                    'ps_user_id' => $user_id,
                    'ps_query' => addslashes($query),
                    'ps_url' => addslashes(current_url()),
                    'ps_params' => json_encode($params),
                    'ps_ipaddress' => USER_IP,
                    'ps_useragent' => USER_AGENT
                );
                $model->insertData(TABLE_POST_SEARCHES, $data_array);
            }

            $order_by = get_post_mysql_sort_by(@$params['sort']);
            $group_by = 'p.post_id';
            $where_cond_str = '1';
            $search_results = $custom_model->get_search_results('p.post_url_key', $where_cond_str, $order_by,$group_by);

            $input_arr = array(
                base_url() => 'Home',
                '#' => 'Search',
            );
            $breadcrumbs = get_breadcrumbs($input_arr);
            $page_title = 'Search results';

            $data["post_records"] = $search_results;
            $data["view_type"] = $view_type;
            $data["page"] = $page;
            $data["breadcrumbs"] = $breadcrumbs;
            $data["page_title"] = $page_title;
            $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
            $this->template->write_view("content", "pages/trip/listing/list-page", $data);
            $this->template->render();
        }
        else
        {
            display_404_page();
        }
    }

}
