<?php

class Staticcontent extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('admin');
    }

    public function index()
    {
        $model = new Common_model();
        $data["alldata"] = $model->getAllData("sp_id, sp_title", TABLE_STATIC_PAGES);
//            prd($data);

        $this->template->write_view("content", "staticcontent/static-list", $data);
        $this->template->render();
    }

    public function edit($sp_id)
    {
        $model = new Common_model();
        if ($sp_id)
        {
            if ($this->input->post())
            {
                $arr = $this->input->post();

                $data_array = array(
                    'sp_title' => addslashes($arr['sp_title']),
                    'sp_text' => addslashes($arr['sp_text']),
                );

                $model->updateData(TABLE_STATIC_PAGES, $data_array, array("sp_id" => $sp_id));
                $this->session->set_flashdata("success", "Static page updated successfully");
                redirect(base_url_admin("staticcontent"));
            }
            else
            {
                $record = $model->fetchSelectedData("*", TABLE_STATIC_PAGES, array("sp_id" => $sp_id));
//                prd($record);
                $data["record"] = $record[0];
                $data["form_heading"] = "Edit Static Content";
                $data["form_action"] = base_url("admin/staticcontent/edit/$sp_id");

                $this->template->write_view("content", "staticcontent/static-form", $data);
                $this->template->render();
            }
        }
        else
        {
            redirect(base_url("admin/staticcontent"));
        }
    }

    public function editconfiguration($setting_id)
    {
        $model = new Common_model();
        if ($setting_id)
        {
            if ($this->input->post())
            {
                $arr = $this->input->post();

                $data_array = array(
                    'setting_title' => addslashes($arr['setting_title']),
                    'setting_value' => addslashes($arr['setting_value']),
                );

                $model->updateData(TABLE_SETTINGS, $data_array, array("setting_id" => $setting_id));
                $this->session->set_flashdata("success", "Configuration updated successfully");
                redirect(base_url_admin("staticcontent/configurations"));
            }
            else
            {
                $record = $model->fetchSelectedData("*", TABLE_SETTINGS, array("setting_id" => $setting_id));
//                prd($record);
                $data["record"] = $record[0];
                $data["form_heading"] = "Edit Configuration";
                $data["form_action"] = base_url_admin("staticcontent/editconfiguration/$setting_id");

                $this->template->write_view("content", "staticcontent/config-form", $data);
                $this->template->render();
            }
        }
    }

    public function configurations()
    {
        $model = new Common_model();
        $data["alldata"] = $model->getAllData("*", TABLE_SETTINGS);
//            prd($data);

        $this->template->write_view("content", "staticcontent/config-list", $data);
        $this->template->render();
    }

    public function updatelogo()
    {
        if (isset($_FILES) && !empty($_FILES))
        {
            $file_ext = getFileExtension($_FILES['new_logo']['name']);
            if (in_array($file_ext, array('png', 'jpg', 'jpeg')))
            {
                if ($_FILES['new_logo']['size'] > 0)
                {
                    $destination = str_replace(SITE_BASE_URL, '', IMAGES_PATH) . '/logo.png';
                    uploadImage($_FILES['new_logo']['tmp_name'], $destination, LOGO_WIDTH, LOGO_HEIGHT);
                    $this->session->set_flashdata("success", "Logo successfully changed");
                }
            }
            else
            {
                $this->session->set_flashdata("error", "Invalid image file format");
            }
            redirect(base_url_admin("staticcontent/updatelogo"));
        }
        else
        {
            $data = array();
            $this->template->write_view("content", "staticcontent/update-logo", $data);
            $this->template->render();
        }
    }

}
