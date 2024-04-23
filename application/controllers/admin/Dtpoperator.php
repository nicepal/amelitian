 <?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dtpoperator extends Admin_Controller {

    public $exam_type = array();
    private $sch_current_session = "";

    public function __construct() {
        parent::__construct();
        $this->load->library('encoding_lib');
        $this->load->library('mailsmsconf');
        $this->exam_type = $this->config->item('exam_type');
        $this->sch_current_session = $this->setting_model->getCurrentSession();
        $this->attendence_exam = $this->config->item('attendence_exam');
        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('exam_group', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'Examinations/dtp');
        $data['title'] = 'Add Batch';
        $data['title_list'] = 'Recent Batch';
        // $data['examType'] = $this->exam_type;
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $examgroup_result = $this->examgroup_model->get();
        $data['examgrouplist'] = $examgroup_result;
        $data['exam_id'] = $this->input->post("exam_id");
        $data['subject_id'] = $this->input->post("subject_id");
        $data['class_id'] = $this->input->post("class_id");
        $data['section_id'] = $this->input->post("section_id");
        $data['examgroup_id'] = $this->input->post("examgroup_id");
        $data['examStudents'] = array();
        
        $this->form_validation->set_rules('examgroup_id', $this->lang->line('exams').' '.$this->lang->line('group'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('exam_id', $this->lang->line('exam') . " " . $this->lang->line('type'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            // echo validation_errors();
            
        } else {
            $data['examStudents'] = $this->examstudent_model->searchExamStudentsDTP($data['class_id'],$data['section_id'],$data['exam_id'],$data['subject_id']);
            $data['examSubjects'] = $this->examstudent_model->getExamSubjects($data['subject_id'],$data['exam_id']);
            // query();
            // dd($data['examSubjects'],1);
        }
        // die();

        $this->load->view('layout/header', $data);
        $this->load->view('admin/dtpoperator/index', $data);
        $this->load->view('layout/footer', $data);
        
    }


    public function addExamResult(){
        $result = $this->input->post("result");
        foreach($result as $key => $val){
            foreach($val as $k => $v){
                $insertRecord = array(
                    'exam_group_class_batch_exam_student_id' => $key,
                    'exam_group_class_batch_exam_subject_id' => $k,
                    'attendence' => ($v['internal'] == "A" || $v['external'] == "A")?('Absent'):('Present'),
                    'internal_marks' => ($v['internal'] != "A")?($v['internal']):('A'),
                    'external_marks' => ($v['external'] != "A")?($v['external']):('A'),
                    'get_marks' => ($v['internal'] != "A" && $v['external'] !=  "A")?($v['internal']+$v['external']):(0),
                    'note' => ''
                );


                // Check if the record with the given ID exists in the database
                $existingRecord = $this->db->get_where('exam_group_exam_results', array('exam_group_class_batch_exam_student_id' => $key,"exam_group_class_batch_exam_subject_id" => $k))->row_array();
                
                if ($existingRecord) {
                    // Update the existing record
                    $this->db->where('exam_group_class_batch_exam_student_id', $key);
                    $this->db->where('exam_group_class_batch_exam_subject_id', $k);
                    $this->db->update('exam_group_exam_results', $insertRecord);
                } else {
                    // Insert a new record
                    $this->db->insert('exam_group_exam_results', $insertRecord);
                }


            }
        }
        redirect(base_url("admin/dtpoperator"));

    }

    

}
