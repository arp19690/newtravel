<?php

class Messages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!isset($this->session->userdata["user_id"]))
        {
            redirect(base_url());
        }
    }

    public function index()
    {
        if ($this->input->get('username'))
        {
            $this->thread($this->input->get('username'));
        }
        else
        {
            $this->inbox();
        }
    }

    public function inbox()
    {
        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $custom_model = new Custom_model();
        $records = $custom_model->get_inbox_list($user_id);

        $page_title = 'My Chats';
        $input_arr = array(
            base_url() => 'Home',
            '#' => $page_title,
        );
        $breadcrumbs = get_breadcrumbs($input_arr);

        $data["breadcrumbs"] = $breadcrumbs;
        $data["chat_list_records"] = $records;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $page_title . ' | ' . SITE_NAME;
        $this->template->write_view("content", "pages/messages/list", $data);
        $this->template->render();
    }

    public function thread($username)
    {
        if ($username)
        {
            $model = new Common_model();
            $custom_model = new Custom_model();
            $data = array();
            $user_id = $this->session->userdata["user_id"];
            $user_to_records = $model->fetchSelectedData('user_id, user_fullname', TABLE_USERS, array('user_username' => $username));
            $records = $custom_model->get_chat_history($user_id, $user_to_records[0]['user_id']);
            $chat_list_records = $custom_model->get_inbox_list($user_id);

//            Marking previous messages as read
            if (!empty($records))
            {
                $latest_message_id = $records[count($records) - 1]['message_id'];
                $this->mark_previous_messages_as_read($latest_message_id, $user_id, $user_to_records[0]['user_id']);
            }

            $to_user_fullname = stripslashes($user_to_records[0]['user_fullname']);
            $page_title = $to_user_fullname;
            $input_arr = array(
                base_url() => 'Home',
                base_url('my-chats') => 'My Chats',
                '#' => $page_title,
            );
            $breadcrumbs = get_breadcrumbs($input_arr);

            $data["breadcrumbs"] = $breadcrumbs;
            $data["chat_list_records"] = $chat_list_records;
            $data["records"] = $records;
            $data["page_title"] = $page_title;
            $data["to_user_fullname"] = $to_user_fullname;
            $data['meta_title'] = $page_title . ' | ' . SITE_NAME;
            $data['display_thread'] = TRUE;
            $this->template->write_view("content", "pages/messages/list", $data);
            $this->template->render();
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

    public function sendMessageAjax()
    {
        $json_data = array('status' => 'error', 'message' => 'An error occurred');
        if (isset($this->session->userdata["user_id"]) && $this->input->post())
        {
            $user_id = $this->session->userdata["user_id"];
            $model = new Common_model();
            $arr = $this->input->post();

            $data_array = array(
                "message_user_from" => $user_id,
                "message_user_to" => getEncryptedString($arr["message_to_enc"], 'decode'),
                'message_timestamp' => time(),
                "message_text" => addslashes($arr["message_content"]),
                "message_ipaddress" => USER_IP,
                "message_useragent" => USER_AGENT
            );
            $model->insertData(TABLE_MESSAGES, $data_array);
            $json_data = array('status' => 'success', 'message' => 'Message sent');
        }

        $json_data = json_encode($json_data);
        echo $json_data;
        return $json_data;
    }

    public function getLatestChatsAjax($other_username_enc, $latest_timestamp)
    {
        $json_data = array('status' => 'error', 'message' => 'An error occurred');
        if (isset($this->session->userdata["user_id"]))
        {
            $custom_model = new Custom_model();
            $model = new Common_model();

            $user_id = $user_from = $this->session->userdata["user_id"];
            $other_username = getEncryptedString($other_username_enc, 'decode');
            $to_user_records = $model->fetchSelectedData('user_id', TABLE_USERS, array('user_username' => $other_username));
            if (!empty($to_user_records))
            {
                $user_to = $to_user_records[0]['user_id'];
                $where_str = 'm1.`message_user_from` in (' . $user_from . ',' . $user_to . ') and m1.`message_user_to` in (' . $user_from . ',' . $user_to . ') AND m1.message_deleted = "0" AND m1.message_timestamp >= ' . $latest_timestamp;
                $chat_records = $custom_model->get_chat_history($user_from, $user_to, $fields = NULL, $where_str);

                $str = NULL;
                if (!empty($chat_records))
                {
                    $str = $chat_records;

                    //            Marking previous messages as read
                    $latest_message_id = $chat_records[count($chat_records) - 1]['message_id'];
                    $this->mark_previous_messages_as_read($latest_message_id, $user_id, $user_to);
                }
                $json_data = array('status' => 'success', 'message' => 'Success', 'data' => $str);
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

}
