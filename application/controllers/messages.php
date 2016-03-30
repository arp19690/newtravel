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
        $this->inbox();
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
        $data["records"] = $records;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $page_title . ' | ' . SITE_NAME;
        $data["active_class"] = "inbox";
        $this->template->write_view("content", "pages/messages/list", $data);
        $this->template->render();
    }

    public function outbox()
    {
        redirect(base_url('messages/inbox'));

        $data = array();
        $user_id = $this->session->userdata["user_id"];
        $model = new Common_model();
        $custom_model = new Custom_model();
        $data["record"] = $custom_model->getOutboxList($user_id);

        $data["page_title"] = "Outbox";
        $data['meta_title'] = 'Outbox | ' . SITE_NAME;
        $data["active_class"] = "outbox";
        $this->template->write_view("content", "pages/messages/list", $data);
        $this->template->render();
    }

    public function thread($username)
    {
        if ($username)
        {
            $data = array();
            $user_id = $this->session->userdata["user_id"];
            $model = new Common_model();
            $custom_model = new Custom_model();

            $is_username_valid = $model->is_exists('user_id', TABLE_USERS, array('username' => $username));
            if (!empty($is_username_valid))
            {
                $message_from = $is_username_valid[0]['user_id'];
                $model->updateData(TABLE_MESSAGES, array("message_read" => "1"), array("message_from" => $message_from, "message_to" => $user_id));

                $getUserNameRecord = $model->fetchSelectedData("first_name,last_name,username", TABLE_USERS, array("user_id" => $message_from));
                $full_name = $getUserNameRecord[0]["first_name"] . " " . $getUserNameRecord[0]["last_name"];

                $allThreadMessages = $custom_model->getThreadMessages($user_id, $message_from);
//                prd($allThreadMessages);

                $data["meta_title"] = "Messages | " . $full_name . " | " . SITE_NAME;
                $data["page_title"] = "Chat with <a href='" . $getUserNameRecord[0]["username"] . "'>" . $full_name . "</a>";
                $data["message_to"] = $message_from;
                $data["record"] = $allThreadMessages;
                $this->template->write_view("content", "pages/messages/thread", $data);
                $this->template->render();
            }
            else
            {
                redirect(base_url('my-account'));
            }
        }
        else
        {
            redirect(base_url('messages'));
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
