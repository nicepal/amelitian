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
        $data['post'] = $this->input->post();
        
        $idss = $data['post']['examgroup_id'];
        $result = array_filter($data['examgrouplist'], function($exam) use ($idss) {
            if($exam->id === $idss){
                return $exam;
            }
        });
        $result = array_values($result);

        $data['exam_group_data'] = (array)$result[0];
        $this->load->view('layout/header', $data);
        $this->load->view('admin/dtpoperator/index', $data);
        $this->load->view('layout/footer', $data);
        
    }



    public function sendResultSms(){

        
        $data = (array)json_decode($this->input->post('data'));
        $external = (array)$this->input->post('external');
        $internal = (array)$this->input->post('internal');
        $examgroup = $this->input->post("examgroup");
       
           $class_name = '';
            $flag = true;
            $total = 0;
            $counter = 0;
            $exam_group_data = '';
            $total_marks = 0;
            foreach($data as $k => $v){
              
                $total_marks = $total_marks + $data[$k]->max_marks;
                if($counter == 0 ){
                    $class_name = $data[$k]->class_name;
                    $marks_for_1_to_5_subjects = array(
                        'student_name'  => $data[$k]->student_name,
                        'class_name'    => $data[$k]->class_name,
                        'tel_mark' => 0,
                        'hin_mark' => 0,
                        'eng_mark' => 0,
                        'mat_mark' => 0,
                        'evs_mark' => 0,
                        'com_mark' => 0,
                        'civ_mark' => 0,
                        'zoo_mark' => 0,
                        'bot_mark' => 0,
                        'phy_edu_mark' => 0,
                        'gam_mark' => 0,
                        'dan_mark' => 0,
                        'tel_san_mark' => 0,
                        'hin_san_mark' => 0,
                        'total' => 0,
                        'percentage' => 0,
                        'contact_no' => '',
                        'student_id' => 0
                    );
                    $exam_group_data = $data[$k]->exam_group_data;
                }
                    $internalMarks = ($internal[$k] != "A")?($internal[$k]):('A');
                    $externalMarks = ($external[$k] != "A")?($external[$k]):('A');

                    $marks_for_1_to_5_subjects['contact_no']= $v->guardian_phone;
                    $marks_for_1_to_5_subjects['student_id']= $v->student_id;

                    $sumValA = ($internalMarks != 'A')?($internalMarks):(0);
                    $sumValB = ($externalMarks != 'A')?($externalMarks):(0);
                    $sum =  $sumValA + $sumValB;
                //    dd(array($sumValA,$sumValB));
                    $total = $total + $sum;
                     if($v->subject == "TELUGU"){
                        $marks_for_1_to_5_subjects['tel_mark'] = $sum;
                    }
                    if($v->subject == "ENGLISH"){
                        $marks_for_1_to_5_subjects['eng_mark'] = $sum;
                    }
                    if($v->subject == "MATHEMATICS"){
                        $marks_for_1_to_5_subjects['mat_mark'] = $sum;
                    }
                    if($v->subject == "HINDI"){
                        $marks_for_1_to_5_subjects['hin_mark'] = $sum;
                    }
                    if($v->subject == "EVS"){
                        $marks_for_1_to_5_subjects['evs_mark'] = $sum;
                    }

                    if($v->subject == "COMPUTER"){
                        $marks_for_1_to_5_subjects['com_mark'] = $sum;
                    }

                    if($v->subject == "SOCIAL SCIENCE"){
                        $marks_for_1_to_5_subjects['soc_sci_mark'] = $sum;
                    }

                    if($v->subject == "SCIENCE"){
                        $marks_for_1_to_5_subjects['sci_mark'] = $sum;
                    }

                    if($v->subject == "PHYSICS"){
                        $marks_for_1_to_5_subjects['phy_mark'] = $sum;
                    }
                    if($v->subject == "CHEMISTRY"){
                        $marks_for_1_to_5_subjects['che_mark'] = $sum;
                    }

                    if($v->subject == "PHYSICS"){
                        $marks_for_1_to_5_subjects['phy_mark'] = $sum;
                    }

                    if($v->subject == "CIVIL"){
                        $marks_for_1_to_5_subjects['civ_mark'] = $sum;
                    }

                    if($v->subject == "ZOOLOGY"){
                        $marks_for_1_to_5_subjects['zoo_mark'] = $sum;
                    }

                    if($v->subject == "BOTANY"){
                        $marks_for_1_to_5_subjects['bot_mark'] = $sum;
                    }

                    if($v->subject == "PHYSICAL EDUCATION"){
                        $marks_for_1_to_5_subjects['phy_edu_mark'] = $sum;
                    }

                    if($v->subject == "GAMES"){
                        $marks_for_1_to_5_subjects['gam_mark'] = $sum;
                    }

                    if($v->subject == "Dance"){
                        $marks_for_1_to_5_subjects['dan_mark'] = $sum;
                    }

                    if($v->subject == "TELUGU / SANSKRIT"){
                        $marks_for_1_to_5_subjects['tel_san_mark'] = $sum;
                    }

                    if($v->subject == "HINDI / SANSKRIT"){
                        $marks_for_1_to_5_subjects['hin_san_mark'] = $sum;
                    }

                    $counter++;
            }
            

            // Send msg 
            $marks_for_1_to_5_subjects['total'] = $total;
            $percentage = ($total / $total_marks) * 100;
            $marks_for_1_to_5_subjects['percentage'] = number_format($percentage,2);

            $classOneToFive = array(
            'I CLASS',
            'II CLASS',
            'III CLASS',
            'IV CLASS',
            'V CLASS'
           );
           $classSixToTen = array(
            'VI CLASS',
            'VII CLASS',
            'VIII CLASS',
            'IX CLASS',
            'X CLASS'
           );

           $classElevenToTwelve = array(
            'XI',
            'XII'
           );
          
            if($sum > 0){
                if(strstr($exam_group_data,'Periodic') == true){
                    $this->session->set_userdata("template_id",'168600');
                        
                    echo "SUM1: $sum <br />";
                    echo $class_name;
                    echo "<br />";
                    var_dump($this->mailsmsconf->mailsms('p_marks_for_6_to_10', $marks_for_1_to_5_subjects));

                    }else{
                    if(in_array($class_name,$classOneToFive)){
                        $this->session->set_userdata("template_id",'168920');
                        
                        echo "SUM1: $sum <br />";
                        echo $class_name;
                        echo "<br />";
                        var_dump($this->mailsmsconf->mailsms('marks_for_1_to_5', $marks_for_1_to_5_subjects));
                    }elseif(in_array($class_name,$classSixToTen)){
                        $this->session->set_userdata("template_id",'168599');

                        echo "SUM2: $sum <br />";
                        echo $class_name;
                        echo "<br />";
                        if (strpos($examgroup, "periodic") !== false) {
                            var_dump($this->mailsmsconf->mailsms('p_marks_for_6_to_10', $marks_for_1_to_5_subjects));
                        }else{
                            var_dump($this->mailsmsconf->mailsms('marks_for_6_to_10', $marks_for_1_to_5_subjects));

                        }
                    }else if(in_array($class_name,$classElevenToTwelve)){
                        $this->session->set_userdata("template_id",'167640');

                        echo "SUM1: $sum <br />";
                        echo $class_name;
                        echo "<br />";
                        var_dump($this->mailsmsconf->mailsms('marks_for_11_to_12', $marks_for_1_to_5_subjects));

                    }
                }
            }
        
        // }

    }

    public function addExamResult(){
        $result = $this->input->post("result");
        $student_name = $this->input->post("student_name");
        $class_name = $this->input->post("class_name");
        foreach($result as $key => $val){
              $marks_for_1_to_5_subjects = array(
                'student_name' => $student_name[$key],
                'class_name' => $class_name[$key],
                'tel_mark' => 0,
                'hin_mark' => 0,
                'eng_mark' => 0,
                'mat_mark' => 0,
                'evs_mark' => 0,
                'com_mark' => 0,

                'civ_mark' => 0,
                'zoo_mark' => 0,
                'bot_mark' => 0,
                'phy_edu_mark' => 0,
                'gam_mark' => 0,
                'dan_mark' => 0,
                'tel_san_mark' => 0,
                'hin_san_mark' => 0,
                
                'total' => 0,
                'percentage' => 0,
                'contact_no' => '',
                'student_id' => 0
            );
            $flag = true;
            $total = 0;
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
                echo "$key, $k <br />";
                // Check if the record with the given ID exists in the database
                $existingRecord = $this->db->get_where('exam_group_exam_results', array('exam_group_class_batch_exam_student_id' => $key,"exam_group_class_batch_exam_subject_id" => $k))->row_array();
                // dd($existingRecord);
                if ($existingRecord) {
                    // Update the existing record
                    $this->db->where('exam_group_class_batch_exam_student_id', $key);
                    $this->db->where('exam_group_class_batch_exam_subject_id', $k);
                    $this->db->update('exam_group_exam_results', $insertRecord);
                } else {

                    $internalMarks = ($v['internal'] != "A")?($v['internal']):('A');
                    $externalMarks = ($v['external'] != "A")?($v['external']):('A');
                    $marks_for_1_to_5_subjects['contact_no']= $v['guardian_phone'];
                    $marks_for_1_to_5_subjects['student_id']= $v['student_id'];
                    $sumValA = ($internalMarks != 'A')?($internalMarks):(0);
                    $sumValB = ($externalMarks != 'A')?($externalMarks):(0);
                    $sum =  $sumValA + $sumValB;
                    $total = $total + $sum;

                    if($v['subject'] == "TELUGU"){
                        $marks_for_1_to_5_subjects['tel_mark'] = $sum;
                    }
                    if($v['subject'] == "ENGLISH"){
                        $marks_for_1_to_5_subjects['eng_mark'] = $sum;
                    }
                    if($v['subject'] == "MATHEMATICS"){
                        $marks_for_1_to_5_subjects['mat_mark'] = $sum;
                    }
                    if($v['subject'] == "HINDI"){
                        $marks_for_1_to_5_subjects['hin_mark'] = $sum;
                    }
                    if($v->subject == "HINDI"){
                        $marks_for_1_to_5_subjects['hin_mark'] = $sum;
                    }
                    if($v->subject == "EVS"){
                        $marks_for_1_to_5_subjects['evs_mark'] = $sum;
                    }

                    if($v['subject'] == "SOCIAL SCIENCE"){
                        $marks_for_1_to_5_subjects['soc_sci_mark'] = $sum;
                    }

                    if($v['subject'] == "SCIENCE"){
                        $marks_for_1_to_5_subjects['sci_mark'] = $sum;
                    }

                    if($v['subject'] == "PHYSICS"){
                        $marks_for_1_to_5_subjects['phy_mark'] = $sum;
                    }
                    if($v['subject'] == "CHEMISTRY"){
                        $marks_for_1_to_5_subjects['che_mark'] = $sum;
                    }

                    if($v['subject'] == "PHYSICS"){
                        $marks_for_1_to_5_subjects['phy_mark'] = $sum;
                    }

                    if($v['subject'] == "CIVIL"){
                        $marks_for_1_to_5_subjects['civ_mark'] = $sum;
                    }

                    if($v['subject'] == "ZOOLOGY"){
                        $marks_for_1_to_5_subjects['zoo_mark'] = $sum;
                    }

                    if($v['subject'] == "BOTANY"){
                        $marks_for_1_to_5_subjects['bot_mark'] = $sum;
                    }

                    if($v['subject'] == "PHYSICAL EDUCATION"){
                        $marks_for_1_to_5_subjects['phy_edu_mark'] = $sum;
                    }

                    if($v['subject'] == "GAMES"){
                        $marks_for_1_to_5_subjects['gam_mark'] = $sum;
                    }

                    if($v['subject'] == "Dance"){
                        $marks_for_1_to_5_subjects['dan_mark'] = $sum;
                    }

                    if($v['subject'] == "TELUGU / SANSKRIT"){
                        $marks_for_1_to_5_subjects['tel_san_mark'] = $sum;
                    }

                    if($v['subject'] == "HINDI / SANSKRIT"){
                        $marks_for_1_to_5_subjects['hin_san_mark'] = $sum;
                    }

                    
                    // Insert a new record
                    $this->db->insert('exam_group_exam_results', $insertRecord);
                }


            }
            
            // Send msg 
            $marks_for_1_to_5_subjects['total'] = $total;
            $percentage = ($total / 600) * 100;
            $marks_for_1_to_5_subjects['percentage'] = number_format($percentage,2);

           $classOneToFive = array(
            'I CLASS',
            'II CLASS',
            'III CLASS',
            'IV CLASS',
            'V CLASS'
           );
           $classSixToTen = array(
            'VI CLASS',
            'VII CLASS',
            'VIII CLASS',
            'IX CLASS',
            'X CLASS'
           );

           $classElevenToTwelve = array(
            'XI',
            'XII'
           );

            if($sum > 0){
                if(in_array($class_name[$key],$classOneToFive)){
                 
                    // $this->mailsmsconf->mailsms('marks_for_1_to_5', $marks_for_1_to_5_subjects);
                }elseif(in_array($class_name[$key],$classSixToTen)){
                  
                    // $this->mailsmsconf->mailsms('marks_for_6_to_10', $marks_for_1_to_5_subjects);
                }else if(in_array($class_name[$key],$classElevenToTwelve)){
                    
                //    $this->mailsmsconf->mailsms('marks_for_11_to_12', $marks_for_1_to_5_subjects);

                }
            }
        }
        redirect(base_url("admin/dtpoperator"));

    }

    

}
