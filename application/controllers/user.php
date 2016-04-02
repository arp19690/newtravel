<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redis_functions = new Redisfunctions();
    }

    public function index()
    {
        $this->myAccount();
    }

    public function myAccount()
    {
        if (isset($this->session->userdata["user_id"]))
        {
            $data = array();
            $model = new Common_model();
            $user_id = $this->session->userdata["user_id"];
            $username = $this->session->userdata["user_username"];

            if ($this->input->post())
            {
                $arr = $this->input->post();
//                prd($arr);
                if (isset($arr["btn_submit"]))
                {
                    $user_dob = NULL;
                    if (!empty($arr['dob_dd']) && !empty($arr['dob_mm']) && !empty($arr['dob_yy']))
                    {
                        $user_dob = $arr['dob_yy'] . '-' . $arr['dob_mm'] . '-' . $arr['dob_dd'];
                    }

                    $location_details = get_location_details_from_google(trim($arr['user_location']));
                    $location_lat_long = getLatLonByAddress(trim($arr['user_location']));
                    $data_array = array(
                        'user_fullname' => addslashes($arr['user_fullname']),
                        'user_gender' => addslashes($arr['user_gender']),
                        'user_location' => addslashes($arr['user_location']),
                        'user_city' => $location_details['city'],
                        'user_state' => $location_details['state'],
                        'user_country' => $location_details['country'],
                        'user_location' => trim($arr['user_location']),
                        'user_latitude' => $location_lat_long['latitude'],
                        'user_longitude' => $location_lat_long['longitude'],
                        'user_tagline' => addslashes($arr['user_tagline']),
                        'user_about' => addslashes($arr['user_about']),
                        'user_relationship_status' => addslashes($arr['user_relationship_status']),
                        'user_dob' => $user_dob,
                    );

                    if (isset($arr['user_username']))
                    {
                        $username = trim($arr['user_username']);
                        $checkUsername = $model->is_exists("user_id", TABLE_USERS, array("username" => $username, "user_id !=" => $user_id));

                        if (!empty($checkUsername))
                        {
                            $this->session->set_flashdata("error", "That username is already taken. Please choose another.");
                        }
                        else
                        {
                            $data_array['user_username'] = $username;
                            $data_array['user_changed_username'] = '1';
                        }
                    }

                    $this->session->set_flashdata("success", "Personal details updated successfully");
                    $model->updateData(TABLE_USERS, $data_array, array("user_id" => $user_id));

                    // updating redis keys now
                    $this->redis_functions->set_user_profile_data($username);

                    @$this->session->set_userdata("user_fullname", trim($arr["user_fullname"]));
                    @$this->session->set_userdata("user_username", $username);
                }
                redirect(base_url('my-account'));
            }
            else
            {
                $record = $this->redis_functions->get_user_profile_data($username);
                $page_title = $record["user_fullname"];

                $input_arr = array(
                    base_url() => 'Home',
                    '#' => $page_title,
                );
                $breadcrumbs = get_breadcrumbs($input_arr);

                $data["record"] = $record;
                $data["breadcrumbs"] = $breadcrumbs;
                $data["page_title"] = $page_title;
                $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
                $this->template->write_view("content", "pages/user/my-account", $data);
                $this->template->render();
            }
        }
        else
        {
            require_once APPPATH . 'controllers/index.php';
            $index_controller = new Index();
            $index_controller->login();
        }
    }

    public function viewProfile($username)
    {
        $data = array();
        $model = new Common_model();
        $custom_model = new Custom_model();
        $pageNotFound = FALSE;
        if ($username)
        {
            $record = $model->is_exists("*", TABLE_USERS, array("username" => $username));
            if (!empty($record))
            {
                $record = $record[0];
                $pageNotFound = TRUE;

                $is_friend = FALSE;
                $is_accepted = "0";
                if (isset($this->session->userdata["user_id"]))
                {
//                        $is_friend_record = $model->is_exists("friend_id, is_accepted", TABLE_FRIENDS, array("sent_from" => $this->session->userdata["user_id"], "sent_to" => $record["user_id"]));
                    $is_friend_record = $custom_model->isFriend($this->session->userdata["user_id"], $record["user_id"], "friend_id, is_accepted");
                    if (!empty($is_friend_record))
                    {
                        $is_friend = TRUE;
                        $is_accepted = $is_friend_record[0]["is_accepted"];
                    }
                }

                $trips_record = $model->fetchSelectedData("trip_title, url_key", TABLE_TRIPS, array("trip_user_id" => $record["user_id"], "trip_status" => "1"), "trip_id", "DESC", "0,5");
//                    prd($trips_record);

                $my_connects_record = $custom_model->getMyFriends($record["user_id"], "first_name, last_name, user_facebook_id, username, user_id", "0,8");

                $data["meta_title"] = ucwords($record["first_name"] . " " . $record["last_name"]) . " | " . $this->redis_functions->get_site_setting('SITE_NAME');
                $data["meta_description"] = getNWordsFromString($record["user_bio"], 30);
                $data["record"] = $record;
                $data["is_friend"] = $is_friend;
                $data["is_accepted"] = $is_accepted;
                $data["trips_record"] = $trips_record;
                $data["my_connects_record"] = $my_connects_record;
                $data["my_connects_totalcount"] = $custom_model->getMyFriendsCount($record["user_id"]);

                $this->template->write_view("content", "pages/user/view-profile", $data);
                $this->template->render();
            }
        }

        if ($pageNotFound == FALSE)
        {
            $this->template->write_view("content", "pages/index/page-not-found", $data);
            $this->template->render();
        }
    }

    public function changePassword()
    {
        if (isset($this->session->userdata['user_id']))
        {
            $data = array();
            $model = new Common_model();
            $user_id = $this->session->userdata['user_id'];

            if ($this->input->post())
            {
                $arr = $this->input->post();
                $new_password = $arr['new_password'];
                $confirm_password = $arr['confirm_password'];

                if (strcmp($new_password, $confirm_password) == 0)
                {
                    // passwords match
                    $model->updateData(TABLE_USERS, array('user_password' => md5($confirm_password)), array('user_id' => $user_id));
                    $this->session->set_flashdata('success', '<strong>Success!</strong> Your password has been changed');
                    redirect(base_url('change-password'));
                }
                else
                {
                    // passwords do not match
                    $this->session->set_flashdata('error', '<strong>Sorry!</strong> Passwords you have entered does not match');
                    redirect(base_url('change-password'));
                }
            }

            $data['meta_title'] = 'Change Password | ' . $this->redis_functions->get_site_setting('SITE_NAME');
            $this->template->write_view("content", "pages/user/change-password", $data);
            $this->template->render();
        }
        else
        {
            redirect(base_url('forgotPassword'));
        }
    }

    public function changeProfilePicture()
    {
        if (isset($this->session->userdata['user_id']) && !empty($_FILES) && $_FILES['user_img']['size'] > 0 && $_FILES['user_img']['error'] == 0)
        {
            $model = new Common_model();
            $user_id = $this->session->userdata['user_id'];
            $user_record = $model->fetchSelectedData('user_profile_picture, user_username', TABLE_USERS, array('user_id' => $user_id));
            $user_record = $user_record[0];

            $redirect_url = base_url('my-account');
            if ($this->input->post('next'))
            {
                $redirect_url = $this->input->post('next');
            }

            $source = $_FILES['user_img']['tmp_name'];
            $destination = USER_IMG_PATH . "/" . getEncryptedString($user_id . time()) . ".jpg";

            $this->load->library('SimpleImage');
            $simpleImage = new SimpleImage();
            $simpleImage->uploadImage($source, $destination, USER_IMG_WIDTH, USER_IMG_HEIGHT);

//            removing older picture
            @unlink($user_record['user_profile_picture']);

            $model->updateData(TABLE_USERS, array('user_profile_picture' => $destination), array('user_id' => $user_id));
            $this->session->set_flashdata('success', '<strong>Success!</strong> Your profile picture has been changed');

            // updating redis keys now
            $this->redis_functions->set_user_profile_data($user_record['user_username']);

            redirect($redirect_url);
        }
        else
        {
            redirect(base_url('login'));
        }
    }

}
