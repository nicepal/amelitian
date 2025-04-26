<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ResultReport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('smsgateway');
        $this->load->library('mailsmsconf');
        $this->load->model('Examgroup_model');
        $this->search_type        = $this->config->item('search_type');
        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    public function index()
    {
       

        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title']           = 'Student Search';
        $class                   = $this->class_model->get();
        $data['classlist']       = $class;
        $button                  = $this->input->post('search');
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['sch_setting']     = $this->sch_setting_detail;

        // Sessions list 
        $session             = $this->session_model->getAllSession();
        $session_array       = $this->session->has_userdata('session_array');
        $data['sessionData'] = array('session_id' => 0);
        if ($session_array) {
            $data['sessionData'] = $this->session->userdata('session_array');
        } else {
            $setting             = $this->setting_model->get();
            $data['sessionData'] = array('session_id' => $setting[0]['session_id']);
        }
        $data['sessionList'] = $session;
        $examgroup_result = $this->examgroup_model->get();
        $data['examgrouplist'] = $examgroup_result;
        // =============
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentReport', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class       = $this->input->post('class_id');
            $section     = $this->input->post('section_id');
            $search      = $this->input->post('search');
            $search_text = $this->input->post('search_text');
            $session_id =  $this->input->post("session_id");
            if(isset($search)) {
                if ($search == 'search_filter') {
                  
                    $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
                    if ($this->form_validation->run() == false) {

                        $this->load->view('layout/header', $data);
                        $this->load->view('studentfee/studentReport', $data);
                        $this->load->view('layout/footer', $data);

                    } else {
                        $resultlist         = $this->student_model->searchByClassSection($class, $section);
                  
                        $data['resultlist'] = $resultlist;
                    }
                } else if ($search == 'search_full') {
                    $resultlist         = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
             
                // dd($data);
                // $this->load->view('layout/header', $data);
                $this->load->view('studentfee/report_print', $data);
                // $this->load->view('layout/footer', $data);
            }
        }
    }

}
