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

            if (!empty($post_details) && !empty($feature_plan_details))
            {
                $form_str = '<form action="' . PAYPAL_FORM_URL . '" method="post" class="paypal-form">
                                <input type="hidden" name="charset" value="utf-8">
                                <input type="hidden" name="cmd" value="_cart">
                                <input type="hidden" name="upload" value="1">
                                <input type="hidden" name="business" value="' . PAYPAL_MERCHANT_EMAIL . '">
                                <input type="hidden" name="quantity_1" value="1">
                                <input type="hidden" name="item_name_1" value="' . $post_url_key . '">
                                <input type="hidden" name="item_number_1" value="' . $post_details['post_id'] . '">
                                <input type="hidden" name="amount_1" value="' . round($feature_plan_details[0]['pfm_amount'], 2) . '">
                                <input type="hidden" name="currency_code" value="' . strtoupper($feature_plan_details[0]['pfm_currency']) . '">
                                <input type="hidden" name="email" value="' . $this->session->userdata["user_email"] . '">
                                <input type="hidden" name="return" value="' . base_url('paypal-success?post_url_key=' . $post_url_key . '&plan_key=' . $featured_plan_key) . '">
                                <input type="hidden" name="cancel_return" value="' . base_url('paypal-cancel?post_url_key=' . $post_url_key . '&plan_key=' . $featured_plan_key) . '">
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

}
