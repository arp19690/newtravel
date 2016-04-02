<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payments extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redis_functions = new Redisfunctions();

        if (!isset($this->session->userdata["user_id"]))
        {
            redirect(base_url());
        }
    }

    public function index()
    {
        display_404_page();
    }

    public function payment_for_featured_post()
    {
        if ($this->input->get('post_url_key') && $this->input->get('plan_key'))
        {
            $model = new Common_model();
            $redis_functions = new Redisfunctions();
            $post_url_key = $this->input->get('post_url_key');
            $featured_plan_key = $this->input->get('plan_key');
            $post_details = $redis_functions->get_trip_details($post_url_key);
            $feature_plan_details = $model->fetchSelectedData('pfm_amount, pfm_currency', TABLE_FEATURED_MASTER, array('pfm_key' => $featured_plan_key));

            $user_id_enc = getEncryptedString($this->session->userdata["user_id"]);

            if (!empty($post_details) && !empty($feature_plan_details))
            {
                $form_str = '<div style="width:100%;display:inline-block;text-align:center;margin-top:12%;font-family:sans-serif;">
                                    <img src="' . IMAGES_PATH . '/loader.gif" alt="Loading..."/>
                                    <h3 style="margin:10px 0;">Please wait while we redirect you to payment gateway.</h3>
                                    <p style="margin:0;">Do not press back button or refresh the page.</p>
                                    </div>';

                $form_str .= '<form action="' . PAYPAL_FORM_URL . '" method="post" class="paypal-form">
                                <input type="hidden" name="charset" value="utf-8">
                                <input type="hidden" name="cmd" value="_cart">
                                <input type="hidden" name="upload" value="1">
                                <input type="hidden" name="business" value="' . PAYPAL_MERCHANT_EMAIL . '">
                                <input type="hidden" name="quantity_1" value="1">
                                <input type="hidden" name="item_name_1" value="' . $post_details['post_title'] . '">
                                <input type="hidden" name="item_number_1" value="' . $post_url_key . '">
                                <input type="hidden" name="amount_1" value="' . round($feature_plan_details[0]['pfm_amount'], 2) . '">
                                <input type="hidden" name="currency_code" value="' . strtoupper($feature_plan_details[0]['pfm_currency']) . '">
                                <input type="hidden" name="email" value="' . $this->session->userdata["user_email"] . '">
                                <input type="hidden" name="rm" value="2">
                                <input type="hidden" name="return" value="' . base_url('trip/paypal-success?post_url_key=' . $post_url_key . '&plan_key=' . $featured_plan_key . '&id=' . $user_id_enc) . '">
                                <input type="hidden" name="cancel_return" value="' . base_url('trip/paypal-cancel?post_url_key=' . $post_url_key . '&plan_key=' . $featured_plan_key . '&id=' . $user_id_enc) . '">
                              </form>';

                $form_str .= '<script type="text/javascript" src="' . JS_PATH . '/jquery.1.7.1.js"></script>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $(".paypal-form").submit();
                                            });
                                        </script>';

                echo $form_str;
            }
            else
            {
                $this->session->set_flashdata('error', 'An error occurred. Please try again.');
                redirect(getTripUrl($post_url_key));
            }
        }
        else
        {
            display_404_page();
        }
    }

    public function paypal_cancel()
    {
        if ($this->input->get('post_url_key') && $this->input->get('plan_key') && $this->input->get('id'))
        {
            $user_id = $this->session->userdata['user_id'];
            if ($user_id == getEncryptedString($this->input->get('id'), 'decode'))
            {
                $model = new Common_model();
                $redis_functions = new Redisfunctions();
                $post_url_key = $this->input->get('post_url_key');
                $featured_plan_key = $this->input->get('plan_key');

                $post_details = $redis_functions->get_trip_details($post_url_key);
                $feature_plan_details = $model->fetchSelectedData('pfm_amount, pfm_currency', TABLE_FEATURED_MASTER, array('pfm_key' => $featured_plan_key));

                if (!empty($post_details) && !empty($feature_plan_details))
                {
                    if ($post_details['post_user_id'] == $user_id)
                    {
                        $data_array = array(
                            'payc_user_id' => $user_id,
                            'payc_post_url_key' => $post_url_key,
                            'payc_featured_plan' => $featured_plan_key,
                            'payc_ipaddress' => USER_IP,
                            'payc_useragent' => USER_AGENT
                        );
                        $model->insertData(TABLE_PAYMENTS_CANCELED, $data_array);
                        $this->session->set_flashdata('error', 'Unsuccessful payment attempt. Please try again.');
                        redirect(getTripUrl($post_url_key));
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Unauthorized access');
                        display_404_page();
                    }
                }
                else
                {
                    $this->session->set_flashdata('error', 'No such records found');
                    display_404_page();
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Invalid request');
                display_404_page();
            }
        }
        else
        {
            $this->session->set_flashdata('error', 'Invalid request');
            display_404_page();
        }
    }

    public function paypal_success()
    {
        if ($this->input->get('post_url_key') && $this->input->get('plan_key') && $this->input->get('id') && $this->input->post())
        {
            if ($this->input->post('item_number1') == $this->input->get('post_url_key'))
            {
                $user_id = $this->session->userdata['user_id'];
                if ($user_id == getEncryptedString($this->input->get('id'), 'decode'))
                {
                    $model = new Common_model();
                    $redis_functions = new Redisfunctions();
                    $post_url_key = $this->input->get('post_url_key');
                    $featured_plan_key = $this->input->get('plan_key');

                    $post_details = $redis_functions->get_trip_details($post_url_key);
                    $feature_plan_details = $model->fetchSelectedData('pfm_id, pfm_amount, pfm_currency', TABLE_FEATURED_MASTER, array('pfm_key' => $featured_plan_key));

                    if (!empty($post_details) && !empty($feature_plan_details))
                    {
                        if ($post_details['post_user_id'] == $user_id)
                        {
                            $paypal_data = $this->input->post();
                            $data_array = array(
                                'payment_user_id' => $user_id,
                                'payment_pfm_id' => $feature_plan_details[0]['pfm_id'],
                                'payment_post_id' => $post_details['post_id'],
                                'payment_txn_id' => $paypal_data['txn_id'],
                                'payment_amount' => $paypal_data['payment_gross'],
                                'payment_payer_email' => $paypal_data['payer_email'],
                                'payment_receiver_email' => $paypal_data['receiver_email'],
                                'payment_status' => '1',
                                'payment_json' => json_encode($paypal_data),
                                'payment_created_on' => date('Y-m-d H:i:s')
                            );
                            $model->insertData(TABLE_PAYMENTS, $data_array);
                            $this->session->set_flashdata('success', 'Payment successful');

                            $page_title = 'Payment success';
                            $input_arr = array(
                                base_url() => 'Home',
                                '#' => $page_title,
                            );
                            $breadcrumbs = get_breadcrumbs($input_arr);

                            $data["post_details"] = $post_details;
                            $data["feature_plan_details"] = $feature_plan_details[0];
                            $data["breadcrumbs"] = $breadcrumbs;
                            $data["page_title"] = $page_title;
                            $data['meta_title'] = $data["page_title"] . ' - ' . $this->redis_functions->get_site_setting('SITE_NAME');
                            $this->template->write_view("content", "pages/payments/paypal-success", $data);
                            $this->template->render();
                        }
                        else
                        {
                            $this->session->set_flashdata('error', 'Unauthorized access');
                            display_404_page();
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'No such records found');
                        display_404_page();
                    }
                }
                else
                {
                    $this->session->set_flashdata('error', 'Invalid request');
                    display_404_page();
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Invalid request');
                display_404_page();
            }
        }
        else
        {
            $this->session->set_flashdata('error', 'Invalid request');
            display_404_page();
        }
    }

}
