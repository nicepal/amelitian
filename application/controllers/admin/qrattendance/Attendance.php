<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    require_once(APPPATH . 'core/MY_Addon_QRAttendanceController.php');

class Attendance extends MY_Addon_QRAttendanceController
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
      
        if (!$this->rbac->hasPrivilege('qr_code_attendance', 'can_view')) {
            access_denied();
        }

     
        $this->session->set_userdata('top_menu', 'qrattendance');
        $this->session->set_userdata('sub_menu', 'admin/qrattendance/attendance/index');

        $this->load->library('media_storage');
        $data          = array();
        $setting = $this->qrsetting_model->get();
        $data['setting'] = json_encode($setting);
        $data['version'] = $this->config->item('version');
        $this->load->view('layout/header');
        $this->load->view('admin/qrattendance/index', $data);
        $this->load->view('layout/footer');
    }

    public function getProfileDetail()
    {
        $this->load->library('media_storage');
        $data          = array();
        $setting = $this->qrsetting_model->get();
        $data['setting'] = $setting;
        $admission_no = $this->input->post('text');
        $data['sch_setting']  = $this->setting_model->getSetting();
        $date = date('Y-m-d');
        $student = $this->qrsetting_model->qrcode_attendance($admission_no, $date);
    
        $data['student'] = $student;
        $msg = "";
        if (!$student) {
            $status = 0;
            $msg = $this->lang->line('invalid_qr_code_barcode_please_try_again_or_contact_to_admin');
        } else {

            $status = ($student->attendance_id > 0) ? 2 : 1;
            $msg = ($student->attendance_id > 0) ? $this->lang->line('attendance_has_been_already_submitted') : "";
            if ($student->table_type == "student") {
                $attendencetypes             = $this->qrsetting_model->getQRAttendanceStudentAttendanceType();
                $data['attendencetypeslist'] = $attendencetypes;
                $profile_type = 'student';
                $data['profile_type'] = $profile_type;
            } elseif ($student->table_type == "staff") {
                $attendencetypes             = $this->qrsetting_model->getQRAttendanceStaffAttendanceType();
                $data['attendencetypeslist'] = $attendencetypes;
                $profile_type = 'staff';
                $data['profile_type'] = $profile_type;
            }
            $data['student'] = $student;
        }

        $data['status'] = $status;

        $page  = $this->load->view('admin/qrattendance/_getProfileDetail', $data, true);
        echo json_encode(['page' => $page, 'status' => $status, 'msg' => $msg]);
    }

    public function saveAttendance()
    {
        $this->load->library('media_storage');

        $this->form_validation->set_rules('attendance_for', $this->lang->line('attendance_type'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('record_id', $this->lang->line('attendance_type'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('attendence_type_id', $this->lang->line('attendance_type'), 'required|trim|xss_clean');
        $data = array();
        $status="";

        if ($this->form_validation->run() == false) {

            $data = array(
                'attendance_for'               => form_error('attendance_for'),
                'record_id'                    => form_error('record_id'),
                'attendence_type_id'           => form_error('attendence_type_id')
            );
            $array = array('status' => 0, 'error' => $data);
            echo json_encode($array);
        } else {

            $student_session_id = $this->input->post('record_id');
            $record_data = $this->student_model->biometric_attendance($student_session_id);
            $s= getLocation();
            
            $biometric_device_data = [
                "uid" => '',
                "user_id" => '',
                "t" => '',
                "ip" => getIP(),
                "serial_number" => '',
                "country" => $s->country??'invalid',
                "city" => $s->city??'invalid',
                "region" => $s->region??'invalid',
                "latitude" => $s->latitude??'invalid',
                "longitude" => $s->longitude??'invalid',
             
            ];

            if ($this->input->post('attendance_for') == "student") {

                $insert_record = array(
                    'date'                  => date('Y-m-d'),
                    'student_session_id'    => $student_session_id,
                    'attendence_type_id'    => $this->input->post('attendence_type_id'),
                    'qrcode_attendance'     => 1,
                    'remark'                => '',
                    'created_at'            => date('Y-m-d H:i:s'),
                    'biometric_device_data' => json_encode($biometric_device_data),
                    'user_agent' => getAgentDetail(),

                );

                $insert_result = $this->qrsetting_model->onlineStudentattendence($insert_record);
                $status=$insert_result['status'];

            } elseif ($this->input->post('attendance_for') == "staff") {

                $insert_record = array(
                    'date'                  => date('Y-m-d'),
                    'staff_id'               => $record_data->id,
                    'staff_attendance_type_id'    => $this->input->post('attendence_type_id'),
                    'qrcode_attendance'  => 1,
                    'remark'                => '',
                    'created_at'            => date('Y-m-d H:i:s'),
                    'biometric_device_data' => json_encode($biometric_device_data),
                    'user_agent' => getAgentDetail(),

                );

                $insert_result = $this->qrsetting_model->onlineaStaffttendence($insert_record);
               $status=$insert_result['status'];
              
            }
            if ($status) {
                echo json_encode(array('status' => 1,  'msg' => $this->lang->line('success_message'),'record' => $insert_record));
            } else {
                echo json_encode(array('status' => 0,  'msg' => $this->lang->line('attendance_already_submitted')));
            }
        }
    }
}
