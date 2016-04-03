<?php

class Email_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load DB here
        $this->load->database();
    }

    public function sendMail($to_email, $subject, $message)
    {
        $redis_functions = new Redisfunctions();
        $this->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $from_email = $redis_functions->get_site_setting('SITE_EMAIL');
        $from_name = $redis_functions->get_site_setting('SITE_NAME');

        $this->email->from($from_email, $from_name);
        $this->email->to($to_email);

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send())
        {
            $model = new Common_model();
            $data_array = array(
                'es_to_email' => $to_email,
                'es_subject' => addslashes($subject),
                'es_message' => addslashes($message),
                'es_from_email' => $from_email,
                'es_ipaddress' => USER_IP
            );
            return $model->insertData(TABLE_EMAILS_SENT, $data_array);
        }
        else
        {
            return FALSE;
        }
    }

    public function invoice_template($invoice_data_array)
    {
        $email_subject = 'Payment confirmed #' . $invoice_data_array['payment_reference_number'];
        $redis_functions = new Redisfunctions();
        $str = '<!doctype html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <title>A simple, clean, and responsive HTML invoice template</title>

                        <style>
                        .invoice-box{
                            max-width:800px;
                            margin:auto;
                            padding:30px;
                            border:1px solid #eee;
                            box-shadow:0 0 10px rgba(0, 0, 0, .15);
                            font-size:16px;
                            line-height:24px;
                            font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                            color:#555;
                        }

                        .invoice-box table{
                            width:100%;
                            line-height:inherit;
                            text-align:left;
                        }

                        .invoice-box table td{
                            padding:5px;
                            vertical-align:top;
                        }

                        .invoice-box table tr td:nth-child(2){
                            text-align:right;
                        }

                        .invoice-box table tr.top table td{
                            padding-bottom:20px;
                        }

                        .invoice-box table tr.top table td.title{
                            font-size:45px;
                            line-height:45px;
                            color:#333;
                        }

                        .invoice-box table tr.information table td{
                            padding-bottom:40px;
                        }

                        .invoice-box table tr.heading td{
                            background:#eee;
                            border-bottom:1px solid #ddd;
                            font-weight:bold;
                        }

                        .invoice-box table tr.details td{
                            padding-bottom:20px;
                        }

                        .invoice-box table tr.item td{
                            border-bottom:1px solid #eee;
                        }

                        .invoice-box table tr.item.last td{
                            border-bottom:none;
                        }

                        .invoice-box table tr.total td:nth-child(2){
                            border-top:2px solid #eee;
                            font-weight:bold;
                        }

                        @media only screen and (max-width: 600px) {
                            .invoice-box table tr.top table td{
                                width:100%;
                                display:block;
                                text-align:center;
                            }

                            .invoice-box table tr.information table td{
                                width:100%;
                                display:block;
                                text-align:center;
                            }
                        }
                        </style>
                    </head>

                    <body>
                        <div class="invoice-box">
                            <table cellpadding="0" cellspacing="0">
                                <tr class="top">
                                    <td colspan="2">
                                        <table>
                                            <tr>
                                                <td class="title"><img src="' . IMAGES_PATH . '/logo.png" style="width:100%; max-width:300px;"></td>

                                                <td>
                                                    Invoice #: ' . $invoice_data_array['payment_reference_number'] . '<br>
                                                    Created: ' . $invoice_data_array['payment_created_on'] . '
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr class="information">
                                    <td colspan="2">
                                        <table>
                                            <tr>
                                                <td>' . $redis_functions->get_site_setting('SITE_NAME') . '</td>
                                                <td>' . stripslashes($invoice_data_array['payer_user_fullname']) . '<br>' . $invoice_data_array['payer_user_email'] . '</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr class="heading">
                                    <td>Payment Method</td>
                                    <td>Transaction #</td>
                                </tr>

                                <tr class="details">
                                    <td>Paypal</td>
                                    <td>' . $invoice_data_array['payment_txn_id'] . '</td>
                                </tr>

                                <tr class="heading">
                                    <td>
                                        Post
                                    </td>

                                    <td>
                                        Price
                                    </td>
                                </tr>

                                <tr class="item">
                                    <td>' . stripslashes($invoice_data_array['post_title']) . '</td>
                                    <td>' . get_currency_symbol($invoice_data_array['payment_currency']) . number_format($invoice_data_array['payment_amount'], 2) . '</td>
                                </tr>

                                <tr class="total">
                                    <td></td>
                                    <td>Total: ' . get_currency_symbol($invoice_data_array['payment_currency']) . number_format($invoice_data_array['payment_amount'], 2) . '</td>
                                </tr>
                            </table>
                        </div>
                    </body>
                    </html>';

        return array('email_subject' => $email_subject, 'email_message' => $str);
    }

}
