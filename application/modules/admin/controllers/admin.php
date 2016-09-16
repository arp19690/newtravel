<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('admin');
        $this->admin_id = $this->session->userdata("admin_id");
    }

    public function index()
    {
        if (!$this->session->userdata("admin_id"))
        {
            if ($this->input->post())
            {
                $arr = $this->input->post();
                $admin_username = $arr["admin_username"];
                $admin_password = md5($arr["admin_password"]);
//                prd($arr);
                $AdminLogin_auth = new AdminLogin_auth();
                $AdminLogin_auth->login($admin_username, $admin_password, base_url_admin("dashboard"), base_url("admin"));
            }
            else
            {
                $this->load->view("index/login");
            }
        }
        else
        {
            $this->dashboard();
        }
    }

    public function dashboard()
    {
        $model = new Common_model();
        $custom_model=new Custom_model();
        $total_users = $model->getTotalCount('user_id', TABLE_USERS, array('user_status !=' => '2', 'user_role_id' => '2'))[0]['totalcount'];

        $data = array(
            'total_users' => $total_users
        );

        $this->template->write_view("content", "index/dashboard", $data);
        $this->template->render();
    }

    public function logout()
    {
        $AdminLogin_auth = new AdminLogin_auth();
        $AdminLogin_auth->logout($this->session->userdata("admin_id"));
    }

    public function changepassword()
    {
        if ($this->input->post())
        {
            $model = new Common_model();
            $arr = $this->input->post();
            $old_password = md5($arr["old_password"]);
            $new_password = md5($arr["new_password"]);
            $confirm_password = md5($arr["confirm_password"]);

            $whereCondArr = array(
                "user_id" => $this->admin_id,
                "user_password" => $old_password
            );

            $is_exists = $model->is_exists("user_id", TABLE_USERS, $whereCondArr);
            if (!empty($is_exists))
            {
                //update
                if (strcmp($new_password, $confirm_password) == 0)
                {
                    //update
                    $data_array = array(
                        "user_password" => $confirm_password
                    );
                    $model->updateData(TABLE_USERS, $data_array, $whereCondArr);
                    $this->session->set_flashdata('success', "Password changed");
                }
                else
                {
                    //new and confirm not match
                    $this->session->set_flashdata('error', "New password and confirm password fields does not match");
                }
            }
            else
            {
                //wrong old password
                $this->session->set_flashdata('error', "Old password does not match");
            }
            redirect(base_url_admin("changepassword"));
        }
        else
        {
            $this->template->write_view("content", "index/changepassword");
            $this->template->render();
        }
    }

}
