<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Messages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!isset($this->session->userdata["user_id"]))
        {
            redirect(base_url());
        }
        $this->redis_functions = new Redisfunctions();
    }

    public function index()
    {
        if ($this->input->get('username'))
        {
            $this->thread($this->input->get('username'));
        }
        else
        {
            $custom_model = new Custom_model();
            $user_id = $this->session->userdata["user_id"];
            $records = $custom_model->get_inbox_list($user_id);
            if (!empty($records))
            {
                redirect(base_url('my-chats?username=' . $records[0]['from_username']));
            }
            else
            {
                $this->inbox();
            }
        }
    }

    public function inbox()
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $custom_model = new Custom_model();
        $redis_functions = new Redisfunctions();
        $records = $custom_model->get_inbox_list($user_id);
        $unread_chats_username = $redis_functions->get_unread_chats_username($this->session->userdata["user_username"]);

        $page_title = 'My Chats';
        $input_arr = array(
            base_url() => 'Home',
            '#' => $page_title,
        );
        $breadcrumbs = get_breadcrumbs($input_arr);

        $data["breadcrumbs"] = $breadcrumbs;
        $data["chat_list_records"] = $records;
        $data["unread_chats_username"] = $unread_chats_username;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $page_title . ' | ' . SITE_NAME;
        $this->template->write_view("content", "pages/messages/list", $data);
        $this->template->render();
    }

    public function thread($username)
    {
        if ($username)
        {
            if ($username != $this->session->userdata["user_username"])
            {
                $custom_model = new Custom_model();
                $redis_functions = new Redisfunctions();
                $data = array();
                $user_id = $this->session->userdata["user_id"];
                $user_to_records = $redis_functions->get_user_profile_data($username);
                $records = $custom_model->get_chat_history($user_id, $user_to_records['user_id']);
                $chat_list_records = $custom_model->get_inbox_list($user_id);

//            Setting and getting unread chats username to redis 
                $redis_functions->set_unread_chats_username($this->session->userdata["user_username"]);
                $unread_chats_username = $redis_functions->get_unread_chats_username($this->session->userdata["user_username"]);

//            Marking previous messages as read
                if (!empty($records))
                {
                    $latest_message_id = $records[count($records) - 1]['message_id'];
                    $this->mark_previous_messages_as_read($latest_message_id, $user_id, $user_to_records['user_id']);
                }

                $to_user_fullname = stripslashes($user_to_records['user_fullname']);
                $to_user_username = stripslashes($user_to_records['user_username']);
                $page_title = $to_user_fullname;
                $input_arr = array(
                    base_url() => 'Home',
                    base_url('my-chats') => 'My Chats',
                    '#' => $page_title,
                );
                $breadcrumbs = get_breadcrumbs($input_arr);

                $data["breadcrumbs"] = $breadcrumbs;
                $data["chat_list_records"] = $chat_list_records;
                $data["unread_chats_username"] = $unread_chats_username;
                $data["records"] = $records;
                $data["page_title"] = $page_title;
                $data["to_user_fullname"] = $to_user_fullname;
                $data["to_user_username"] = $to_user_username;
                $data['meta_title'] = $page_title . ' | ' . $this->redis_functions->get_site_setting('SITE_NAME');
                $data['display_thread'] = TRUE;
                $this->template->write_view("content", "pages/messages/list", $data);
                $this->template->render();
            }
            else
            {
                $this->session->set_flashdata('error', 'You should socialize more and not just chat with yourself');
                redirect(base_url('my-chats'));
            }
        }
        else
        {
            redirect(base_url('my-chats'));
        }
    }

    public function mark_previous_messages_as_read($latest_message_id, $me_user_id, $other_user_id)
    {
        $model = new Common_model();
        $where_cond_arr = array(
            'message_user_from' => $other_user_id,
            'message_user_to' => $me_user_id,
            'message_id <= ' => $latest_message_id
        );
        return $model->updateData(TABLE_MESSAGES, array('message_read' => '1'), $where_cond_arr);
    }

    public function send_message_ajax()
    {
        $json_data = array('status' => 'error', 'message' => 'An error occurred');
        if (isset($this->session->userdata["user_id"]) && $this->input->post())
        {
            $user_id = $this->session->userdata["user_id"];
            $model = new Common_model();
            $redis_functions = new Redisfunctions();
            $arr = $this->input->post();

            $other_username = getEncryptedString($arr["to_username"], 'decode');
            $other_user_records = $redis_functions->get_user_profile_data($other_username);
            if (!empty($other_user_records) && !empty($arr["message_text"]) && $other_user_records['user_id'] != $user_id)
            {
                $data_array = array(
                    "message_user_from" => $user_id,
                    "message_user_to" => $other_user_records['user_id'],
                    'message_timestamp' => time(),
                    "message_text" => addslashes($arr["message_text"]),
                    "message_ipaddress" => USER_IP,
                    "message_useragent" => USER_AGENT
                );
                $model->insertData(TABLE_MESSAGES, $data_array);
                $json_data = array('status' => 'success', 'message' => 'Message sent');
            }
            else
            {
                $json_data = array('status' => 'error', 'message' => 'Not a valid action');
            }
        }

        $json_data = json_encode($json_data);
        echo $json_data;
        return $json_data;
    }

    public function get_unread_chats_ajax($other_username_enc, $latest_timestamp)
    {
        $json_data = array('status' => 'error', 'message' => 'An error occurred');
        if (isset($this->session->userdata["user_id"]))
        {
            $custom_model = new Custom_model();
            $redis_functions = new Redisfunctions();

            $user_id = $this->session->userdata["user_id"];
            $other_username = getEncryptedString($other_username_enc, 'decode');
            $other_user_records = $redis_functions->get_user_profile_data($other_username);
            if (!empty($other_user_records))
            {
                $other_user_id = $other_user_records['user_id'];
                $where_str = 'm1.`message_user_from` = ' . $other_user_id . ' and m1.`message_user_to` = ' . $user_id . ' AND m1.message_deleted = "0" AND m1.message_timestamp > ' . $latest_timestamp;
                $chat_records = $custom_model->get_chat_history($user_id, $other_user_id, $fields = NULL, $where_str);

                $str = $latest_message_timestamp = NULL;
                if (!empty($chat_records))
                {
                    $str = $chat_records;

                    //            Marking previous messages as read
                    $latest_message_id = $chat_records[count($chat_records) - 1]['message_id'];
                    $latest_message_timestamp = $chat_records[count($chat_records) - 1]['message_timestamp'];
                    $this->mark_previous_messages_as_read($latest_message_id, $user_id, $other_user_id);
                }
                $json_data = array('status' => 'success', 'message' => 'Success', 'data' => $str, 'latest_timestamp' => $latest_message_timestamp);
            }
            else
            {
                $json_data = array('status' => 'error', 'message' => 'Not a valid choice');
            }
        }

        $json_data = json_encode($json_data);
        echo $json_data;
        return $json_data;
    }

    public function delete_conversation($other_username)
    {
        if (isset($this->session->userdata["user_id"]))
        {
            $redis_functions = new Redisfunctions();

            $user_id = $this->session->userdata["user_id"];
            $me_username = $this->session->userdata["user_username"];
            $other_user_records = $redis_functions->get_user_profile_data($other_username);
            if (!empty($other_user_records))
            {
                $other_user_id = $other_user_records['user_id'];
                $model = new Common_model();
                $where_cond_arr = array(
                    'message_user_from' => $other_user_id,
                    'message_user_to' => $user_id,
                    'message_user_to' => $other_user_id,
                    'message_user_from' => $user_id,
                );

                $chat_records = $model->fetchSelectedData('message_id', TABLE_MESSAGES, $where_cond_arr);
                if (!empty($chat_records))
                {
                    $message_id_arr = array();
                    foreach ($chat_records as $chat_value)
                    {
                        $message_id_arr[] = $chat_value['message_id'];
                    }
                    
                    $redis_functions->set_deleted_message_ids($me_username, $message_id_arr);
                    $this->session->set_flashdata('success', 'Your conversation with ' . stripslashes($other_user_records['user_fullname']) . ' marked as deleted');
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'An error occurred. Please try again later.');
            }
            redirect(base_url('my-chats'));
        }
        else
        {
            display_404_page();
        }
    }

}
