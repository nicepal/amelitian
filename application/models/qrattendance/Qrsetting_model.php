<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Qrsetting_model extends MY_Model
{



    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }



    public function qrcode_attendance($admission_no, $date,$in_out=null)
    {
        $sql    = "SELECT staff.id,staff.employee_id,staff.name,null as `middlename`,staff.surname,'staff' as `table_type`,Null as class_id,Null as class ,Null as section_id, null as section, null as roll_no, null as admission_date, staff.image as student_image, contact_no as  `mobile_no`, email,  null as admission_no , father_name, mother_name, null as guardian_name,null as dob, `staff_designation`.`designation`, `department`.`department_name` as `department`, `roles`.`id` as `role_id`, `roles`.`name` as `role`,staff.gender,IFNULL(staff_attendance.id, 0 ) as `attendance_id`,staff.dob,IFNULL(staff_attendance_type.long_lang_name, 0 ) as `long_lang_name`
        FROM `staff` 
        LEFT JOIN `staff_designation` ON `staff_designation`.`id` = `staff`.`designation` 
        LEFT JOIN `staff_roles` ON `staff_roles`.`staff_id` = `staff`.`id`
        LEFT JOIN `roles` ON `roles`.`id` = `staff_roles`.`role_id` 
        LEFT JOIN `department` ON `department`.`id` = `staff`.`department` 
        LEFT JOIN `staff_attendance` ON `staff_attendance`.`staff_id` = `staff`.`id` and staff_attendance.date='" . $date . "'  and staff_attendance.in_out='" . $in_out . "' 
        LEFT JOIN `staff_attendance_type` ON `staff_attendance_type`.`id` = `staff_attendance`.`staff_attendance_type_id`  
        WHERE employee_id=" . $this->db->escape($admission_no) . " UNION SELECT students.id, student_session.id as `student_session_id`, students.firstname, 
        students.middlename, students.lastname, 'student' as `table_type`, classes.id as `class_id`, classes.class, sections.id as `section_id`, sections.section, 
        students.roll_no, students.admission_date,
        students.image,students.mobileno,students.email,students.admission_no,father_name,mother_name,guardian_name,dob, null as designation,  null as  department,
          null as role_id, null as role,students.gender,IFNULL(student_attendences.id,0) as `attendance_id`,students.dob,IFNULL(attendence_type.long_lang_name, 0 ) 
          as `long_lang_name` FROM `students` JOIN `student_session` ON `student_session`.`student_id` = `students`.`id` JOIN `classes` ON 
          `student_session`.`class_id` = `classes`.`id` JOIN `sections` ON `sections`.`id` = `student_session`.`section_id` LEFT JOIN `hostel_rooms` ON 
          `hostel_rooms`.`id` = `students`.`hostel_room_id` LEFT JOIN `hostel` ON `hostel`.`id` = `hostel_rooms`.`hostel_id` LEFT JOIN `room_types` ON 
          `room_types`.`id` = `hostel_rooms`.`room_type_id` LEFT JOIN `vehicle_routes` ON `vehicle_routes`.`id` = `student_session`.`vehroute_id` 
          LEFT JOIN `route_pickup_point` ON `route_pickup_point`.`id` = `student_session`.`route_pickup_point_id` LEFT JOIN `pickup_point` ON 
          `route_pickup_point`.`pickup_point_id` = `pickup_point`.`id` LEFT JOIN `transport_route` ON `vehicle_routes`.`route_id` = `transport_route`.`id` 
          LEFT JOIN `vehicles` ON `vehicles`.`id` = `vehicle_routes`.`vehicle_id` LEFT JOIN `school_houses` ON `school_houses`.`id` = `students`.`school_house_id` 
          LEFT JOIN `users` ON `users`.`user_id` = `students`.`id` LEFT JOIN `student_attendences` ON `student_attendences`.`student_session_id` = `student_session`.`id` 
          and student_attendences.date='" . $date . "'and student_attendences.in_out='" . $in_out . "' LEFT JOIN `attendence_type` ON `attendence_type`.`id` = `student_attendences`.`attendence_type_id`  
          WHERE `student_session`.`session_id` = '" . $this->current_session . "' AND `users`.`role` = 'student' AND `students`.`is_active` = 'yes' AND 
          `students`.`admission_no` = " . $this->db->escape($admission_no);

        $query  = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result;
        } else {
            return false;
        }
    }

    public function getQRAttendanceStudentAttendanceType($id = null)
    {
        $this->db->select('attendence_type.*')->from('attendence_type');

        $this->db->where('for_qr_attendance', 1);
        $this->db->order_by('id');

        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }


    public function getQRAttendanceStaffAttendanceType($id = null)
    {
        $this->db->select('staff_attendance_type.*')->from('staff_attendance_type');

        $this->db->where('for_qr_attendance', 1);
        $this->db->order_by('id');

        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }




    public function get()
    {
        $this->db->select('*');
        $this->db->from('QR_code_settings');
        $this->db->order_by('QR_code_settings.id');
        $query = $this->db->get();
        return $query->row();
    }

    public function add($data)
    {

        $this->db->trans_begin();

        $q = $this->db->get('QR_code_settings');

        if ($q->num_rows() > 0) {
            $results = $q->row();
            $this->db->where('id', $results->id);
            $this->db->update('QR_code_settings', $data);
            $message = UPDATE_RECORD_CONSTANT . " On QR Attendance settings id " . $results->id;
            $action = "Update";
            $record_id = $results->id;
            $this->log($message, $record_id, $action);
        } else {

            $this->db->insert('QR_code_settings', $data);
            $id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On QR Attendance settings id " . $id;
            $action = "Insert";
            $record_id = $id;
            $this->log($message, $record_id, $action);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }


    public function onlineaStaffttendence($data)
    {

        $this->db->where('staff_id', $data['staff_id']);
        $this->db->where('date', $data['date']);
        $this->db->where('in_out', $data['in_out']);
        $q = $this->db->get('staff_attendance');

        if ($q->num_rows() == 0) {
            $this->db->insert('staff_attendance', $data);
            return ['status' => 1, 'msg' => ''];
        }else{
            $return_result = $q->row();
            return ['status' => 0, 'data' => $return_result, 'msg' => ''];
        }
       
    }
    public function onlineStudentattendence($data)
    {
    
        $this->db->where('student_session_id', $data['student_session_id']);
        $this->db->where('date', $data['date']);
        $this->db->where('in_out', $data['in_out']);
        $q = $this->db->get('student_attendences');

        if ($q->num_rows() == 0) {
            $this->db->insert('student_attendences', $data);
            return ['status' => 1, 'msg' => ''];
        } else {
            $return_result = $q->row();
            return ['status' => 0, 'data' => $return_result, 'msg' => ''];
        }
    }
}
