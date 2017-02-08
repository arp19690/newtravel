<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Staticpage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redis_functions = new Redisfunctions();
    }

    public function index($page_key = 'about-us')
    {
        $data = array();
        $content_data = (object) $this->redis_functions->get_static_page_content($page_key);
        if (!empty($content_data))
        {
            $page_title = stripslashes($content_data->sp_title);
            $page_content = stripslashes($content_data->sp_text);

            $input_arr = array(
                base_url() => 'Home',
                '#' => $page_title,
            );
            $breadcrumbs = get_breadcrumbs($input_arr);

            $data["content"] = $page_content;
            $data["breadcrumbs"] = $breadcrumbs;
            $data["page_title"] = $page_title;
            $data['meta_title'] = $page_title . " - " . $this->redis_functions->get_site_setting('SITE_NAME');
            $data['meta_description'] = strip_tags(getNWordsFromString($page_content, 50));

            $this->template->write_view("content", "pages/staticpage/static-content", $data);
            $this->template->render();
        }
        else
        {
            display_404_page();
        }
    }

    public function contact()
    {
        if ($this->input->post())
        {
            $arr = $this->input->post();
//                prd($arr);

            if (isset($arr["btn_submit"]))
            {
                $data = array();

                $model = new Common_model();
                $request_id = getUniqueContactRequestID();

                $data_array = array(
                    'wc_request_id' => $request_id,
                    'wc_fullname' => addslashes($arr['full_name']),
                    'wc_email' => addslashes($arr['user_email']),
                    'wc_message' => addslashes($arr['message']),
                    'wc_ipaddress' => USER_IP,
                    'wc_useragent' => USER_AGENT,
                    'wc_created_on' => date('Y-m-d H:i:s')
                );
                $model->insertData(TABLE_WEBSITE_CONTACT, $data_array);

                if (USER_IP != '127.0.0.1')
                {
                    $email_model = new Email_model();

                    // message to us
                    $message = '
                                                <strong>Full Name: </strong>' . ucwords($arr["full_name"]) . '<br/>
                                                <strong>Email: </strong>' . $arr["user_email"] . '<br/>
                                                <strong>Contact: </strong>' . $arr["user_contact"] . '<br/>
                                                <strong>Location: </strong>' . $arr["user_location"] . '<br/><br/>
                                                <strong>Request ID: </strong>' . $request_id . '<br/><br/>
                                                <strong>Message: </strong>' . $arr["user_message"] . '<br/>
                                                ';
                    $email_model->sendMail($this->redis_functions->get_site_setting('SITE_EMAIL'), "New message via " . $this->redis_functions->get_site_setting('SITE_NAME'), $message);
                }

                $this->session->set_flashdata('success', 'Your message has been delivered successfully');
                redirect(base_url('static/contact-us'));
            }
        }
        else
        {
            $data = array();
            $page_title = "Contact us";

            $input_arr = array(
                base_url() => 'Home',
                '#' => $page_title,
            );
            $breadcrumbs = get_breadcrumbs($input_arr);

            $data["meta_title"] = $page_title . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
            $data["meta_description"] = 'Get in touch with us if you have any queries or feedback for us. We would love to hear from you.';
            $data["breadcrumbs"] = $breadcrumbs;

            $this->template->write_view("content", "pages/staticpage/contact-us", $data);
            $this->template->render();
        }
    }

    public function updateSitemap()
    {
        $this->ci = & get_instance();
        $this->ci->load->database();
        $this->ci->load->model('Common_model');
//            $model = $this->ci->Common_model;
        $model = new Common_model();

        $xml = '<?xml version = "1.0" encoding = "UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";
        $xml .= '<url><loc>' . base_url() . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>weekly</changefreq><priority>1.00</priority></url>' . "\n";

        // all the static links
        $static_links_without_base_url = array('contact-us', 'about-us', 'how-it-works', 'privacy-policy', 'terms', 'login', 'register', 'forgot-password');
        foreach ($static_links_without_base_url as $slKey => $slValue)
        {
            $xml .= '<url><loc>' . base_url($slValue) . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>weekly</changefreq><priority>0.85</priority></url>' . "\n";
        }

        // all the active posts
        $trip_records = $model->fetchSelectedData('post_url_key', TABLE_POSTS, array('post_status' => '1'));
        foreach ($trip_records as $trKey => $trValue)
        {
            $trip_url = getTripUrl($trValue['post_url_key']);
            $xml .= '<url><loc>' . $trip_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>weekly</changefreq><priority>0.85</priority></url>' . "\n";
        }

        // all the active users
        $user_records = $model->fetchSelectedData('user_username', TABLE_USERS, array('user_status' => '1'));
        foreach ($user_records as $urKey => $urValue)
        {
            $public_profile_url = getPublicProfileUrl($urValue['user_username']);
            $xml .= '<url><loc>' . $public_profile_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>weekly</changefreq><priority>0.85</priority></url>' . "\n";
        }

        $xml .= '</urlset>';
//            prd($xml);

        $file = fopen((APPPATH . '/../sitemap.xml'), 'w');
        fwrite($file, $xml);
        fclose($file);
        echo "Sitemap generated successfully";
        die;
    }

}
