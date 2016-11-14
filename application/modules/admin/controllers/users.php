<?php

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $model = new Common_model();
        $data["alldata"] = $model->fetchSelectedData("*", TABLE_USERS, array('user_role_id' => '2'));
//            prd($data);

        $this->template->write_view("content", "users/user-list", $data);
        $this->template->render();
    }

    public function updateUserStatus($user_id, $status_code)
    {
        if ($user_id)
        {
            $model = new Common_model();
            $model->updateData(TABLE_USERS, array('user_status' => $status_code), array('user_id' => $user_id));
            $this->session->set_flashdata("success", "User status updated");
        }

        $next_url = base_url_admin("users");
        if ($this->input->get('next'))
        {
            $next_url = $this->input->get('next');
        }
        redirect($next_url);
    }

    public function userLog($user_type = 'user')
    {
        $model = new Common_model();
        $data = array();

        if ($user_type == 'user')
        {
            $where_arr = array('ul_login_type !=' => 'admin');
        }
        else
        {
            $where_arr = array('ul_login_type' => 'admin');
        }

        $record = $model->getAllDataFromJoin("ul.*, user_fullname, user_id", TABLE_USER_LOG . " as ul", array(TABLE_USERS . " as u" => "user_id = ul_user_id"), "LEFT", $where_arr);
        $data["alldata"] = $record;
        $data["page_heading"] = ucwords($user_type) . ' Log';

        $this->template->write_view("content", "users/user-log", $data);
        $this->template->render();
    }

    public function administrators()
    {
        $model = new Common_model();
        $data = array();

        $record = $model->fetchSelectedData('user_id, user_fullname, user_username, user_email, user_status', TABLE_USERS, array('user_role_id' => '1'));
        $data["alldata"] = $record;

        $this->template->write_view("content", "users/admin-list", $data);
        $this->template->render();
    }

    public function add_edit_administrator($user_id = NULL)
    {
        $model = new Common_model();

        if ($this->input->post())
        {
            $arr = $this->input->post();
            $username = str_replace(' ', '', strtolower($arr['user_username']));
            $user_email = str_replace(' ', '', strtolower($arr['user_email']));

            $username_where = array('user_username' => $username);
            if ($user_id != NULL)
            {
                $username_where['user_id !='] = $user_id;
            }

            $username_exists = $model->is_exists('user_id', TABLE_USERS, $username_where);
            if (empty($username_exists))
            {
                $email_where = array('user_email' => $user_email);
                if ($user_id != NULL)
                {
                    $email_where['user_id !='] = $user_id;
                }

                $email_exists = $model->is_exists('user_id', TABLE_USERS, $email_where);
                if (empty($email_exists))
                {
                    $data_array = array(
                        'user_fullname' => addslashes($arr['user_fullname']),
                    );

                    if ($user_id == NULL)
                    {
                        $user_password = rand(111111, 999999);
                        $data_array['user_password'] = md5($user_password);
                        $data_array['user_created_on'] = date('Y-m-d H:i:s');
                        $data_array['user_email'] = addslashes($user_email);
                        $data_array['user_username'] = addslashes($username);
                        $data_array['user_role_id'] = '1';

                        $model->insertData(TABLE_USERS, $data_array);
                        $this->session->set_flashdata('success', 'New administrator added');

                        if (USER_IP != '127.0.0.1')
                        {
                            $email_model = new Email_model();
                            $email_message = 'You have been added as an Administrator on ' . SITE_NAME . '<br/><br/>Admin panel URL:- ' . base_url_admin() . '<br/>Username: ' . $username . '<br/>Password: ' . $user_password;
                            $email_model->sendMail($user_email, 'Welcome Administrator - ' . SITE_NAME, $email_message);
                        }
                    }
                    else
                    {
                        $model->updateData(TABLE_USERS, $data_array, array('user_id' => $user_id, 'user_role_id' => '1'));
                        $this->session->set_flashdata('success', 'Administrator details updated');
                    }

                    redirect(base_url_admin('users/administrators'));
                }
                else
                {
                    $this->session->set_flashdata('error', 'Email already exists');
                    redirect(base_url_admin('users/add_edit_administrator'));
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Username already exists');
                redirect(base_url_admin('users/add_edit_administrator'));
            }
        }
        else
        {
            $record = array();
            $form_heading = 'Add Administrator';

            if ($user_id != NULL)
            {
                $record = $model->fetchSelectedData("*", TABLE_USERS, array("user_id" => $user_id, 'user_role_id' => '1'))[0];
                $form_heading = 'Edit Administrator';
            }

            $data["record"] = $record;
            $data["form_heading"] = $form_heading;

            $this->template->write_view("content", "users/admin-form", $data);
            $this->template->render();
        }
    }

}
