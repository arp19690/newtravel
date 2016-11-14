<?php

class Faq extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('admin');
    }

    public function index()
    {
        $model = new Common_model();
        $data["alldata"] = $model->getAllData("*", TABLE_FAQ);
//            prd($data);

        $this->template->write_view("content", "faq/faq-list", $data);
        $this->template->render();
    }

    public function add($faq_id = NULL)
    {
        $model = new Common_model();
        if ($this->input->post())
        {
            $arr = $this->input->post();

            $data_array = array(
                'faq_question' => addslashes($arr['faq_question']),
                'faq_answer' => addslashes($arr['faq_answer']),
            );

            if ($faq_id == NULL)
            {
                $model->insertData(TABLE_FAQ, $data_array);
                $this->session->set_flashdata("success", "FAQ added successfully");
            }
            else
            {
                $model->updateData(TABLE_FAQ, $data_array, array("faq_id" => $faq_id));
                $this->session->set_flashdata("success", "FAQ updated successfully");
            }
            redirect(base_url_admin("faq"));
        }
        else
        {
            if ($faq_id != NULL)
            {
                $record = $model->fetchSelectedData("*", TABLE_FAQ, array("faq_id" => $faq_id));
//                prd($record);
                $data["record"] = $record[0];
            }
            $data["form_heading"] = ($faq_id == NULL ? "Add" : "Edit" ) . " FAQ";
            $data["form_action"] = base_url_admin("faq/add/$faq_id");

            $this->template->write_view("content", "faq/faq-form", $data);
            $this->template->render();
        }
    }

    public function updateFAQStatus($faq_id, $status_code)
    {
        if ($faq_id)
        {
            $model = new Common_model();
            $model->updateData(TABLE_FAQ, array('faq_status' => $status_code), array('faq_id' => $faq_id));
            $this->session->set_flashdata("success", "FAQ Status updated");
        }

        $next_url = base_url_admin("faq");
        if ($this->input->get('next'))
        {
            $next_url = $this->input->get('next');
        }
        redirect($next_url);
    }

}
