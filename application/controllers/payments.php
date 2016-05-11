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
        if ($this->input->get('tkey') && $this->input->get('fkey'))
        {
            $model = new Common_model();
            $redis_functions = new Redisfunctions();
            $trip_url_key = $this->input->get('tkey');
            $featured_plan_key = $this->input->get('fkey');
            $post_details = $redis_functions->get_trip_details($trip_url_key);
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
                                <input type="hidden" name="item_number_1" value="' . $trip_url_key . '">
                                <input type="hidden" name="amount_1" value="' . round($feature_plan_details[0]['pfm_amount'], 2) . '">
                                <input type="hidden" name="currency_code" value="' . strtoupper($feature_plan_details[0]['pfm_currency']) . '">
                                <input type="hidden" name="email" value="' . $this->session->userdata["user_email"] . '">
                                <input type="hidden" name="rm" value="2">
                                <input type="hidden" name="cpp_logo_image" value="' . (IMAGES_PATH . '/logo_paypal.png') . '">
                                <input type="hidden" name="return" value="' . base_url('trip/paypal-success?trip_url_key=' . $trip_url_key . '&plan_key=' . $featured_plan_key . '&id=' . $user_id_enc) . '">
                                <input type="hidden" name="cancel_return" value="' . base_url('trip/paypal-cancel?trip_url_key=' . $trip_url_key . '&plan_key=' . $featured_plan_key . '&id=' . $user_id_enc) . '">
                              </form>';

                $form_str .= '<script type="text/javascript" src="' . JS_PATH . '/jquery.1.7.1.js"></script>
                                        <script type="text/javascript">
                                        function submit_form()
                                        {
                                            $(".paypal-form").submit();
                                        }
                                        $(document).ready(function () {
                                            submit_form();

                                            // re-submitting form in 40 seconds
                                            setInterval(function(){submit_form();}, 40000);
                                        });
                                    </script>';

                echo $form_str;
            }
            else
            {
                $this->session->set_flashdata('error', 'An error occurred. Please try again.');
                redirect(getTripUrl($trip_url_key));
            }
        }
        else
        {
            display_404_page();
        }
    }

    public function paypal_cancel()
    {
        if ($this->input->get('trip_url_key') && $this->input->get('plan_key') && $this->input->get('id'))
        {
            $user_id = $this->session->userdata['user_id'];
            if ($user_id == getEncryptedString($this->input->get('id'), 'decode'))
            {
                $model = new Common_model();
                $redis_functions = new Redisfunctions();
                $trip_url_key = $this->input->get('trip_url_key');
                $featured_plan_key = $this->input->get('plan_key');

                $post_details = $redis_functions->get_trip_details($trip_url_key);
                $feature_plan_details = $model->fetchSelectedData('pfm_amount, pfm_currency', TABLE_FEATURED_MASTER, array('pfm_key' => $featured_plan_key));

                if (!empty($post_details) && !empty($feature_plan_details))
                {
                    if ($post_details['post_user_id'] == $user_id)
                    {
                        $data_array = array(
                            'payc_user_id' => $user_id,
                            'payc_post_url_key' => $trip_url_key,
                            'payc_featured_plan' => $featured_plan_key,
                            'payc_ipaddress' => USER_IP,
                            'payc_useragent' => USER_AGENT
                        );
                        $model->insertData(TABLE_PAYMENTS_CANCELED, $data_array);
                        $this->session->set_flashdata('error', 'Unsuccessful payment attempt. Please try again.');
                        redirect(getTripUrl($trip_url_key));
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
        if ($this->input->get('trip_url_key') && $this->input->get('plan_key') && $this->input->get('id') && $this->input->post())
        {
            if ($this->input->post('item_number1') == $this->input->get('trip_url_key'))
            {
                $user_id = $this->session->userdata['user_id'];
                $user_email = $this->session->userdata['user_email'];
                if ($user_id == getEncryptedString($this->input->get('id'), 'decode'))
                {
                    $model = new Common_model();
                    $redis_functions = new Redisfunctions();
                    $trip_url_key = $this->input->get('trip_url_key');
                    $featured_plan_key = $this->input->get('plan_key');

                    $post_details = $redis_functions->get_trip_details($trip_url_key);
                    $feature_plan_details = $model->fetchSelectedData('*', TABLE_FEATURED_MASTER, array('pfm_key' => $featured_plan_key));

                    if (!empty($post_details) && !empty($feature_plan_details))
                    {
                        if ($post_details['post_user_id'] == $user_id)
                        {
                            $paypal_data = $this->input->post();
                            $payment_reference_number = getUniquePaymentReferenceNumber(getEncryptedString($paypal_data['txn_id']));
                            $payment_created_on = date('Y-m-d H:i:s');
                            $data_array = array(
                                'payment_reference_number' => $payment_reference_number,
                                'payment_user_id' => $user_id,
                                'payment_pfm_id' => $feature_plan_details[0]['pfm_id'],
                                'payment_post_id' => $post_details['post_id'],
                                'payment_txn_id' => $paypal_data['txn_id'],
                                'payment_amount' => $paypal_data['payment_gross'],
                                'payment_payer_email' => $paypal_data['payer_email'],
                                'payment_receiver_email' => $paypal_data['receiver_email'],
                                'payment_status' => '1',
                                'payment_json' => json_encode($paypal_data),
                                'payment_created_on' => $payment_created_on
                            );
                            $is_exists = $model->fetchSelectedData('payment_id', TABLE_PAYMENTS, array('payment_post_id' => $post_details['post_id'], 'payment_txn_id' => $paypal_data['txn_id']));
                            if (empty($is_exists))
                            {
                                $model->insertData(TABLE_PAYMENTS, $data_array);
                                $this->session->set_flashdata('success', 'Payment successful');
                            }
                            else
                            {
                                $this->session->set_flashdata('error', 'Transaction ID already exists');
                                redirect(getTripUrl($trip_url_key));
                            }

                            // Adding post to featured table
                            if ($this->add_post_to_featured($post_details['post_id'], $feature_plan_details[0]['pfm_id']) == FALSE)
                            {
                                $this->session->set_flashdata('error', 'Unauthorized access to post');
                                redirect(getTripUrl($trip_url_key));
                            }

                            // Updating redis table here
                            $redis_functions->set_trip_details($trip_url_key);
                            $redis_functions->set_featured_trips();

                            // Sending invoice email here
                            if (USER_IP != '127.0.0.1')
                            {
                                $invoice_data_array = array(
                                    'payment_reference_number' => $payment_reference_number,
                                    'payment_created_on' => $payment_created_on,
                                    'payer_user_fullname' => $this->session->userdata['user_fullname'],
                                    'payer_user_email' => $user_email,
                                    'payment_txn_id' => $paypal_data['txn_id'],
                                    'post_title' => $post_details['post_title'],
                                    'pfm_title' => $feature_plan_details['pfm_title'],
                                    'payment_currency' => 'USD',
                                    'payment_amount' => $paypal_data['payment_gross']
                                );
                                $email_model = new Email_model();
                                $invoice_html_data = $email_model->invoice_template($invoice_data_array);
                                $email_model->sendMail($user_email, $invoice_html_data['email_subject'], $invoice_html_data['email_message']);
                            }

                            $page_title = 'Payment confirmed';
                            $input_arr = array(
                                base_url() => 'Home',
                                '#' => $page_title,
                            );
                            $breadcrumbs = get_breadcrumbs($input_arr);

                            $data["post_details"] = $post_details;
                            $data["feature_plan_details"] = $feature_plan_details[0];
                            $data["payment_reference_number"] = $payment_reference_number;
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

    public function add_post_to_featured($post_id, $pfm_id)
    {
        $model = new Common_model();
        $user_id = $this->session->userdata['user_id'];
        $is_valid = $model->fetchSelectedData('post_id', TABLE_POSTS, array('post_id' => $post_id, 'post_user_id' => $user_id));
        if (!empty($is_valid))
        {
            $featured_plan_details = $model->fetchSelectedData('pfm_hours', TABLE_FEATURED_MASTER, array('pfm_id' => $pfm_id));
            $featured_hours = $featured_plan_details[0]['pfm_hours'];
            $start_timestamp = time();
            $end_timestamp = $start_timestamp + (($featured_hours) * 60 * 60);

            // disabling all the previous featured post for same post id
            $model->updateData(TABLE_POST_FEATURED, array('pf_status' => '0'), array('pf_post_id' => $post_id));

            $data_array = array(
                'pf_post_id' => $post_id,
                'pf_start_date' => date('Y-m-d H:i:s', $start_timestamp),
                'pf_end_date' => date('Y-m-d H:i:s', $end_timestamp),
                'pf_pfm_id' => $pfm_id,
                'pf_created_on' => date('Y-m-d H:i:s')
            );
            return $model->insertData(TABLE_POST_FEATURED, $data_array);
        }
        else
        {
            return FALSE;
        }
    }

}
