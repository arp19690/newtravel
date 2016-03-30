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

            $to_user_fullname=stripslashes($user_to_records[0]['user_fullname']);
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

    public function getLatestChatsAjax($other_user_id_enc, $last_timestamp)
    {
        $json_data = array('status' => 'error', 'message' => 'An error occurred');
        if (isset($this->session->userdata["user_id"]) && $other_user_id_enc && $last_timestamp)
        {
            $user_id = $this->session->userdata["user_id"];
            $other_user_id = getEncryptedString($other_user_id_enc, 'decode');
            $custom_model = new Custom_model();
            $fields = 'message_id, message_text, message_read, message_user_from, message_user_to, message_timestamp';
            $chat_records = $custom_model->getLatestChatsAjax($fields, $user_id, $other_user_id, $last_timestamp);

            $str = NULL;
            if (!empty($chat_records))
            {
                $str = json_encode($chat_records);
            }
            $json_data = array('status' => 'success', 'message' => $str);
        }

        $json_data = json_encode($json_data);
        echo $json_data;
        return $json_data;
    }

}
