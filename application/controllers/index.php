<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
        $custom_model=new Custom_model();
        $featured_trip_keys = $this->redis_functions->get_featured_trips('p.post_url_key', '0, 12');
        $latest_trip_keys = $custom_model->get_latest_trips('p.post_url_key', '0, 12');

        $page_title = $this->redis_functions->get_site_setting('SITE_TITLE');
        $data["featured_trip_keys"] = $featured_trip_keys;
        $data["latest_trip_keys"] = $latest_trip_keys;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $data["page_title"];
        $this->template->write_view("content", "pages/index/index", $data);
        $this->template->render();
    }

    public function external_redirect()
    {
        if ($this->input->get('url') == TRUE && !empty($this->input->get('url')))
        {
            $model = new Common_model();
            $url = addslashes($this->input->get('url'));
            $data_array = array(
                'er_url' => $url,
                'er_ipaddress' => USER_IP,
                'er_useragent' => USER_AGENT
            );

            if (isset($this->session->userdata['user_id']))
            {
                $data_array['er_user_id'] = $this->session->userdata['user_id'];
            }

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
                $page_title = 'Login';

                $input_arr = array(
                    base_url() => 'Home',
                    '#' => $page_title,
                );
                $breadcrumbs = get_breadcrumbs($input_arr);

                $data["breadcrumbs"] = $breadcrumbs;
                $data["page_title"] = $page_title;
                $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
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
                if ($this->input->get('next'))
                {
                    $redirect_url = $this->input->get('next');
                }
                $arr = $this->input->post();
//                prd($arr);

                $user_email = trim(strtolower($arr["user_email"]));
                $is_email_exists = $model->is_exists('user_id', TABLE_USERS, array('user_email' => $user_email));
                if (empty($is_email_exists))
                {
                    // valid email
                    $verification_code = substr(getEncryptedString($arr['user_email'] . $arr['user_gender'] . time()), 0, 30);
                    $user_username = getUniqueUsernameFromEmail($user_email);

                    $location_details = get_location_details_from_google(trim($arr['user_location']));
                    $location_lat_long = getLatLonByAddress(trim($arr['user_location']));

                    $data_array = array(
                        'user_fullname' => $arr['user_fullname'],
                        'user_gender' => strtolower($arr['user_gender']),
                        'user_username' => $user_username,
                        'user_email' => $user_email,
                        'user_password' => md5($arr['user_password']),
                        'user_ipaddress' => USER_IP,
                        'user_useragent' => USER_AGENT,
                        'user_created_on' => date('Y-m-d H:i:s'),
                        'user_status' => '0',
                        'user_verification_code' => $verification_code,
                        'user_city' => $location_details['city'],
                        'user_state' => $location_details['state'],
                        'user_country' => $location_details['country'],
                        'user_location' => trim($arr['user_location']),
                        'user_latitude' => $location_lat_long['latitude'],
                        'user_longitude' => $location_lat_long['longitude'],
                    );
                    $user_id = $model->insertData(TABLE_USERS, $data_array);

                    // updating redis keys now
                    $this->redis_functions->set_user_profile_data($user_username);

                    if (USER_IP != '127.0.0.1')
                    {
                        $verification_url = base_url('activate?code=' . $verification_code);
                        $this->load->library('EmailTemplates');
                        $EmailTemplates = new EmailTemplates();
                        $messageText = $EmailTemplates->registerEmail(ucwords($arr['user_fullname']), $verification_url);
                        $email_model = new Email_model();
                        $email_model->sendMail($arr['user_email'], 'Verification Email - ' . $this->redis_functions->get_site_setting('SITE_NAME'), $messageText);
                    }

                    $this->session->set_flashdata('success', '<strong>Success!</strong> We have sent you an email. Please verify your email address');
                    redirect($redirect_url);
                }
                else
                {
                    // invalid email    
                    $this->session->set_flashdata('error', '<strong>Oops!</strong> Email already exists');
                    $this->session->set_flashdata('post', $arr);
                    redirect(base_url('register?next=' . $this->input->get('next')));
                }
            }
            else
            {
                $page_title = 'Register';

                $input_arr = array(
                    base_url() => 'Home',
                    '#' => $page_title,
                );
                $breadcrumbs = get_breadcrumbs($input_arr);

                $data["breadcrumbs"] = $breadcrumbs;
                $data["page_title"] = $page_title;
                $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
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
                    $user_records = $model->fetchSelectedData('user_username', TABLE_USERS, array('verification_code' => $verification_code));
                    // activate now
                    $model->updateData(TABLE_USERS, array('user_status' => '1', 'verification_code' => ''), array('verification_code' => $verification_code));

                    // updating redis keys now
                    $this->redis_functions->set_user_profile_data($user_records[0]['user_username']);

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
                $user_email = trim(strtolower($arr['user_email']));

                $is_valid_email = $model->is_exists('user_id, user_status, user_fullname, user_username', TABLE_USERS, array('user_email' => $user_email));
                if (!empty($is_valid_email))
                {
                    // valid
                    $user_status = $is_valid_email[0]['user_status'];
                    if ($user_status == '1')
                    {
                        // active user
                        $full_name = ucwords($is_valid_email[0]['user_fullname']);
                        $new_password = substr(getEncryptedString($user_email . "-" . $user_status . time()), 0, 6);
                        $model->updateData(TABLE_USERS, array('user_password' => md5($new_password)), array('user_email' => $user_email));

                        // updating redis keys now
                        $this->redis_functions->set_user_profile_data($is_valid_email[0]['user_username']);

                        if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
                        {
                            $this->load->library('EmailTemplates');
                            $emailTemplate = new EmailTemplates();
                            $messageContent = $emailTemplate->forgot - password($full_name, $new_password);
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
                        redirect(base_url('forgot-password'));
                    }
                }
                else
                {
                    // invalid
                    $this->session->set_flashdata('error', 'No such record found.');
                    redirect(base_url('forgot-password'));
                }
            }
            else
            {
                $page_title = 'Forgot Password';

                $input_arr = array(
                    base_url() => 'Home',
                    '#' => $page_title,
                );
                $breadcrumbs = get_breadcrumbs($input_arr);

                $data["breadcrumbs"] = $breadcrumbs;
                $data["page_title"] = $page_title;
                $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
                $this->template->write_view("content", "pages/index/forgot-password", $data);
                $this->template->render();
            }
        }
        else
        {
            redirect(base_url('change-password'));
        }
    }

    public function login_with_facebook()
    {
        $this->load->library("SocialLib");
        $socialLib = new SocialLib();
        $next_url = base_url("my-account");
        if ($this->input->get("next"))
        {
            $next_url = $this->input->get("next");
        }
        $this->session->set_userdata("next_url", $next_url);
        redirect($socialLib->getFacebookLoginUrl());
    }

    public function facebookAuth($connect = FALSE)
    {
        if ($this->input->get('code'))
        {
            $this->load->library("SocialLib");
            $model = new Common_model();
            $socialLib = new SocialLib();
            $facebook_user_obj = $socialLib->getFacebookUserObject();
            if ($facebook_user_obj['status'] == 'success')
            {
                if (!empty($facebook_user_obj['data']))
                {
                    $facebook_id = $facebook_user_obj['data']['id'];
                    $facebook_access_token = $facebook_user_obj['accessToken'];
                    if ($connect == FALSE)
                    {
                        if (isset($facebook_user_obj['data']['email']))
                        {
                            $facebook_name = $facebook_user_obj['data']['name'];
                            $facebook_email = $facebook_user_obj['data']['email'];

                            $is_exists = $model->is_exists('user_password', TABLE_USERS, array('user_email' => $facebook_email, 'user_facebook_id' => $facebook_id));
                            if (empty($is_exists))
                            {
                                // get user profile picture here
                                $facebook_image_url = getFacebookUserImageSource($facebook_id, NULL, USER_IMG_WIDTH);
                                $new_image_path = USER_IMG_PATH . '/' . getEncryptedString($facebook_id . time()) . '.jpg';
                                copy($facebook_image_url, $new_image_path);

                                $user_password = md5($facebook_id . time());
                                $data_array = array(
                                    'user_fullname' => addslashes($facebook_name),
                                    'user_email' => $facebook_email,
                                    'user_facebook_id' => $facebook_id,
                                    'user_facebook_accesstoken' => $facebook_access_token,
                                    'user_facebook_array' => json_encode($facebook_user_obj),
                                    'user_created_on' => date('Y-m-d H:i:s'),
                                    'user_ipaddress' => USER_IP,
                                    'user_useragent' => USER_AGENT,
                                    'user_password' => $user_password,
                                    'user_username' => getUniqueUsernameFromEmail($facebook_email),
                                    'user_profile_picture' => $new_image_path
                                );
                                $model->insertData(TABLE_USERS, $data_array);
                                $this->session->set_flashdata('success', 'Welcome aboard, ' . $facebook_name);
                            }
                            else
                            {
                                $user_password = $is_exists[0]['user_password'];
                            }

                            // deciding the next url here
                            $next_url = base_url('my-account');
                            if (isset($this->session->userdata["next_url"]))
                            {
                                $next_url = $this->session->userdata["next_url"];
                                unset($this->session->userdata["next_url"]);
                            }

                            // loggin user in
                            $this->load->library('Login_auth');
                            $login_auth = new Login_auth();
                            $login_auth->login($facebook_email, $user_password, $next_url, base_url('login'));
                        }
                        else
                        {
                            $this->session->set_flashdata('error', 'Email required when logging in with Facebook');
                            redirect(base_url('login'));
                        }
                    }
                    elseif ($connect == 'connect' && isset($this->session->userdata['user_id']))
                    {
                        $user_id = $this->session->userdata['user_id'];
                        $next_url = base_url('my-account');
                        $is_exists = $model->is_exists('user_id', TABLE_USERS, array('user_id !=' => $user_id, 'user_facebook_id' => $facebook_id));
                        if (empty($is_exists))
                        {
                            $data_array = array(
                                'user_facebook_id' => $facebook_id,
                                'user_facebook_accesstoken' => $facebook_access_token,
                                'user_facebook_array' => json_encode($facebook_user_obj)
                            );
                            $model->updateData(TABLE_USERS, $data_array, array('user_id' => $this->session->userdata['user_id']));
                            $this->session->set_flashdata('success', 'Facebook account connected successfully');
                            if ($this->input->get('next'))
                            {
                                $next_url = $this->input->get('next');
                            }
                        }
                        else
                        {
                            $this->session->set_flashdata('error', 'Another user already exists with this Facebook account');
                        }
                        redirect($next_url);
                    }
                }
                else
                {
                    $this->session->set_flashdata('error', 'An error occurred. Please try again.');
                    redirect(base_url('login'));
                }
            }
            else
            {
                $this->session->set_flashdata('error', $facebook_user_obj['data']);
                redirect(base_url('login'));
            }
        }
        else
        {
            display_404_page();
        }
    }

    public function facebookConnect()
    {
        if ($this->input->get('code'))
        {
            $this->facebookAuth('connect');
        }
        else
        {
            $this->load->library("SocialLib");
            $socialLib = new SocialLib();
            redirect($socialLib->getFacebookLoginUrl(base_url('facebook-connect')));
        }
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
