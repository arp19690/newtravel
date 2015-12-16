<?php

class Index extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redis_functions = new Redisfunctions();
    }

    public function index()
    {
        $data = array();
        $model = new Common_model();
        $custom_model = new Custom_model();

        $this->template->write_view("content", "pages/index/index", $data);
        $this->template->render();
    }

    public function external_redirect()
    {
        if ($this->input->get('url') == TRUE && !empty($this->input->get('url')))
        {
            $url = addslashes($this->input->get('url'));
            $data_array = array(
                'er_url' => $url,
                'er_ipaddress' => USER_IP,
                'er_useragent' => USER_AGENT
            );
            $model = new Common_model();
            $model->insertData(TABLE_EXTERNAL_REDIRECTS, $data_array);
            redirect($url);
        }
        else
        {
            redirect(base_url());
        }
    }

    public function login()
    {
        if (!isset($this->session->userdata['user_id']))
        {
            $data = array();
            $model = new Common_model();

            if ($this->input->post())
            {
                $redirect_url = base_url();
                if ($this->input->get('next'))
                {
                    $redirect_url = $this->input->get('next');
                }
                $arr = $this->input->post();
                $user_email = $arr["user_email"];
                $user_password = $arr["user_password"];
                if (empty($user_password))
                {
                    $this->session->set_flashdata('error', '<strong>Oops!</strong> Please input password');
                    $redirect_url = base_url('login?next=' . $redirect_url);
                }

                // account activated
                $is_valid = $model->is_exists('user_id, user_username, user_status', TABLE_USERS, array('user_email' => $user_email, 'user_password' => md5($user_password)));
                if (!empty($is_valid))
                {
                    // valid

                    $user_status = $is_valid[0]['user_status'];

                    if ($user_status == '0')
                    {
                        // account not activated
                        $this->session->set_flashdata('error', '<strong>Oops!</strong> Looks like your account is not activated yet');
                        redirect(base_url('login?next=' . $redirect_url));
                        die;
                    }

                    $Login_auth = new Login_auth();
                    $Login_auth->login($user_email, md5($user_password), $redirect_url, base_url('login?next=' . $redirect_url));
                }
                else
                {
                    // invalid
                    $this->session->set_flashdata('error', '<strong>Oops!</strong> Invalid email and/or password');
                    $redirect_url = base_url('login?next=' . $redirect_url);
                }

                redirect($redirect_url);
            }
            else
            {
                $data['meta_title'] = 'Login - ' . $this->redis_functions->get_site_setting('SITE_NAME');
                $this->template->write_view("content", "pages/index/login", $data);
                $this->template->render();
            }
        }
        else
        {
            redirect('my-account');
        }
    }

    public function register()
    {
        if (!isset($this->session->userdata['user_id']))
        {
            $data = array();
            $model = new Common_model();

            if ($this->input->post())
            {
                $redirect_url = base_url();
//                if ($this->input->get('next'))
//                {
//                    $redirect_url = $this->input->get('next');
//                }
                $arr = $this->input->post();
//                    prd($arr);

                $user_email = $arr["user_email"];
                $username = $arr["username"];

                $is_email_exists = $model->is_exists('user_id', TABLE_USERS, array('user_email' => $user_email));
                if (empty($is_email_exists))
                {
                    // valid email
                    $is_username_exists = $model->is_exists('user_id', TABLE_USERS, array('username' => $username));
                    if (empty($is_username_exists))
                    {
                        // valid username

                        $verification_code = substr(getEncryptedString($arr['username'] . $arr['user_gender'] . time()), 0, 30);

                        $data_array = array(
                            'first_name' => $arr['first_name'],
                            'last_name' => $arr['last_name'],
                            'user_gender' => $arr['user_gender'],
                            'username' => $arr['username'],
                            'user_email' => $arr['user_email'],
                            'user_password' => md5($arr['user_password']),
                            'user_ipaddress' => USER_IP,
                            'user_agent' => USER_AGENT,
                            'user_status' => '0',
                            'verification_code' => $verification_code,
                        );
                        $model->insertData(TABLE_USERS, $data_array);
                        $user_id = $this->db->insert_id();

                        if (!empty($_FILES) && $_FILES['user_img']['size'] > 0 && $_FILES['user_img']['error'] == 0)
                        {
                            $source = $_FILES['user_img']['tmp_name'];
                            $destination = USER_IMG_PATH . "/" . getEncryptedString($user_id) . ".jpg";

                            @unlink($destination);

                            $this->load->library('SimpleImage');
                            $simpleImage = new SimpleImage();
                            $simpleImage->uploadImage($source, $destination, USER_IMG_WIDTH, USER_IMG_HEIGHT);
                        }

                        if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
                        {
                            $verification_url = base_url('activate?code=' . $verification_code);
                            $this->load->library('EmailTemplates');
                            $EmailTemplates = new EmailTemplates();
                            $messageText = $EmailTemplates->registerEmail(ucwords($arr['first_name'] . " " . $arr['last_name']), $verification_url);
                            $email_model = new Email_model();
                            $email_model->sendMail($arr['user_email'], 'Verification Email - ' . $this->redis_functions->get_site_setting('SITE_NAME'), $messageText);
                        }

                        $this->session->set_flashdata('success', '<strong>Success!</strong> We have sent you an email. Please verify your email address');
                        redirect(base_url('login'));
                    }
                    else
                    {
                        // invalid username                            
                        $this->session->set_flashdata('error', '<strong>Oops!</strong> Username already exists');
                        $this->session->set_flashdata('post', $arr);
                        redirect(base_url('register'));
                    }
                }
                else
                {
                    // invalid email    
                    $this->session->set_flashdata('error', '<strong>Oops!</strong> Email already exists');
                    $this->session->set_flashdata('post', $arr);
                    redirect(base_url('register'));
                }
            }
            else
            {
                $data['meta_title'] = 'Register - ' . $this->redis_functions->get_site_setting('SITE_NAME');
                $this->template->write_view("content", "pages/index/register", $data);
                $this->template->render();
            }
        }
        else
        {
            redirect('my-account');
        }
    }

    public function activate()
    {
        if (!isset($this->session->userdata['user_id']) && $this->input->get('code'))
        {
            $verification_code = $this->input->get('code');
            $model = new Common_model();
            $is_valid = $model->is_exists('user_status', TABLE_USERS, array('verification_code' => $verification_code));
            if (!empty($is_valid))
            {
                // valid
                $user_status = $is_valid[0]['user_status'];
                if ($user_status == '1')
                {
                    // already activated
                    $this->session->set_flashdata('error', 'Your account is already activated.');
                    redirect(base_url('login'));
                }
                else
                {
                    // activate now
                    $model->updateData(TABLE_USERS, array('user_status' => '1', 'verification_code' => ''), array('verification_code' => $verification_code));
                    $this->session->set_flashdata('success', '<strong>Welcome!</strong> Your account now active.');
                    redirect(base_url('login'));
                }
            }
            else
            {
                // invalid
                $this->session->set_flashdata('error', 'No such record found.');
                redirect(base_url('login'));
            }
        }
        else
        {
            redirect(base_url('login'));
        }
    }

    public function forgotPassword()
    {
        if (!isset($this->session->userdata['user_id']))
        {
            $data = array();
            $model = new Common_model();
            if ($this->input->post())
            {
                $arr = $this->input->post();
                $user_email = $arr['user_email'];

                $is_valid_email = $model->is_exists('user_id, user_status, first_name, last_name', TABLE_USERS, array('user_email' => $user_email));
                if (!empty($is_valid_email))
                {
                    // valid
                    $user_status = $is_valid_email[0]['user_status'];
                    if ($user_status == '1')
                    {
                        // active user
                        $full_name = ucwords($is_valid_email[0]['first_name'] . " " . $is_valid_email[0]['last_name']);
                        $new_password = substr(getEncryptedString($user_email . "-" . $user_status . time()), 0, 6);
                        $model->updateData(TABLE_USERS, array('user_password' => md5($new_password)), array('user_email' => $user_email));

                        if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
                        {
                            $this->load->library('EmailTemplates');
                            $emailTemplate = new EmailTemplates();
                            $messageContent = $emailTemplate->forgotPassword($full_name, $new_password);
                            $email_model = new Email_model();
                            $email_model->sendMail($user_email, 'Forgot Password - ' . $this->redis_functions->get_site_setting('SITE_NAME'), $messageContent);
                        }

                        $this->session->set_flashdata('error', '<strong>Success!</strong> We have sent you a new password on your email. Please check');
                        redirect(base_url('login'));
                    }
                    else
                    {
                        // account not active
                        $this->session->set_flashdata('error', '<strong>Sorry!</strong> Your account is not active');
                        redirect(base_url('forgotPassword'));
                    }
                }
                else
                {
                    // invalid
                    $this->session->set_flashdata('error', 'No such record found.');
                    redirect(base_url('forgotPassword'));
                }
            }
            else
            {
                $data['meta_title'] = 'Forgot Password - ' . $this->redis_functions->get_site_setting('SITE_NAME');
                $this->template->write_view("content", "pages/index/forgot-password", $data);
                $this->template->render();
            }
        }
        else
        {
            redirect(base_url('change-password'));
        }
    }

    public function loginwithfacebook()
    {
        if (!isset($this->session->userdata["user_id"]))
        {
            if ($this->input->get('next'))
            {
                @$this->session->set_userdata("next_url", $this->input->get('next'));
            }

            $this->load->library('SocialLib');
            $socialLib = new SocialLib();
            $login_url = $socialLib->getFacebookLoginUrl();
            redirect($login_url);
        }
        else
        {
            $this->logout();
        }
    }

    public function facebookAuth()
    {
        $this->load->library("SocialLib");
        $socialLib = new SocialLib();
        $socialLib->loginWithFacebook();
    }

    public function logout()
    {
        if (isset($this->session->userdata["user_id"]))
        {
            $loginAuth = new Login_auth();
            $loginAuth->logout();
        }
        redirect(base_url());
    }

    public function pagenotfound()
    {
        $data = array();

        $data['meta_title'] = 'Page Not Found - ' . $this->redis_functions->get_site_setting('SITE_NAME');
        $this->template->write_view("content", "pages/index/page-not-found", $data);
        $this->template->render();
    }

}
