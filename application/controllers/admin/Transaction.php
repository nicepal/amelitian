<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaction extends Admin_Controller {

    protected $balance_group;
    protected $balance_type;
    protected $setting_result;

    function __construct() {
        parent::__construct();
        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    function searchtransaction() {

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');

        $data['title'] = 'Search Expense';
        $data['searchlist'] = $this->customlib->get_searchtype();
        $data['search_type'] = $search_type = '';


        $search = $this->input->post('search_type');


        if (isset($_POST['search_type']) && $_POST['search_type'] != '') {

            $dates = $this->customlib->get_betweendate($_POST['search_type']);
            $data['search_type'] = $_POST['search_type'];
        } else {

            $dates = $this->customlib->get_betweendate('this_year');
            $data['search_type'] = $search_type = 'this_year';
        }

        $dateformat = $this->customlib->getSchoolDateFormat();

        $date_from = $dates['from_date'];
        $date_to = $dates['to_date'];

        $data['collection_title'] = $this->lang->line('collection') . " " . $this->lang->line('report') . " " . $this->lang->line('from') . " " . date($this->customlib->getSchoolDateFormat(), strtotime($date_from)) . " To " . date($this->customlib->getSchoolDateFormat(), strtotime($date_to));
        $data['income_title'] = $this->lang->line('income') . " " . $this->lang->line('report') . " " . $this->lang->line('from') . " " . date($this->customlib->getSchoolDateFormat(), strtotime($date_from)) . " To " . date($this->customlib->getSchoolDateFormat(), strtotime($date_to));
        $data['expense_title'] = $this->lang->line('expense') . " " . $this->lang->line('report') . " " . $this->lang->line('from') . " " . date($this->customlib->getSchoolDateFormat(), strtotime($date_from)) . " To " . date($this->customlib->getSchoolDateFormat(), strtotime($date_to));
        $data['payroll_title'] = $this->lang->line('payroll') . " " . $this->lang->line('report') . " " . $this->lang->line('from') . " " . date($this->customlib->getSchoolDateFormat(), strtotime($date_from)) . " To " . date($this->customlib->getSchoolDateFormat(), strtotime($date_to));
        $date_from = date('Y-m-d', strtotime($date_from));
        $date_to = date('Y-m-d', strtotime($date_to));
        $expenseList = $this->expense_model->search("", $date_from, $date_to);

        $result = $this->payroll_model->getbetweenpayrollReport($date_from, $date_to);

        $incomeList = $this->income_model->search("", $date_from, $date_to);
        $feeList = $this->studentfeemaster_model->getFeeBetweenDate($date_from, $date_to);
        $data['expenseList'] = $expenseList;
        $data['incomeList'] = $incomeList;
        $data['feeList'] = $feeList;
        $data['payrollList'] = $result;



        $this->load->view('layout/header', $data);
        $this->load->view('admin/transaction/searchtransaction', $data);
        $this->load->view('layout/footer', $data);
    }

    
    public function findPreviousBalanceFees($session_id, $class_id, $section_id, $current_session) {

        $studentlist = $this->student_model->getPreviousSessionStudent($session_id, $class_id, $section_id);

        $is_update = false;
        $student_Array = array();
        if (!empty($studentlist)) {
            $student_comma_seprate = array();

            foreach ($studentlist as $student_list_key => $student_list_value) {
               
                $obj = new stdClass();
                $obj->name = $this->customlib->getFullName($student_list_value->firstname,$student_list_value->middlename,$student_list_value->lastname,$this->sch_setting_detail->middlename,$this->sch_setting_detail->lastname);
                $obj->admission_no = $student_list_value->admission_no;
                $obj->roll_no = $student_list_value->roll_no;
                $obj->father_name = $student_list_value->father_name;
                $obj->student_session_id = $student_list_value->current_student_session_id;
                $obj->student_previous_session_id = $student_list_value->previous_student_session_id;
               
                if (strtotime($student_list_value->admission_date) == 0) {
                    $obj->admission_date = "";
                } else {
                    $obj->admission_date = date($this->customlib->getSchoolDateFormat(), $this->customlib->dateYYYYMMDDtoStrtotime($student_list_value->admission_date));
                }


                $student_Array[] = $obj;
                $student_comma_seprate[] = $student_list_value->current_student_session_id;
            }

            $student_session_array = "(" . implode(",", $student_comma_seprate) . ")";
            $record_exists = $this->studentfeemaster_model->getBalanceMasterRecord($this->balance_group, $student_session_array);

            if (!empty($record_exists)) {
                $is_update = true;
                foreach ($student_Array as $stkey => $eachstudent) {

                    $eachstudent->balance = $this->findValueExists($record_exists, $eachstudent->student_session_id);
                }
            } else {
                foreach ($student_Array as $stkey => $eachstudent) {


                    //==========================
                    $student_total_fees = array();
                    if ($eachstudent->student_previous_session_id != "") {

                        $student_total_fees = $this->studentfeemaster_model->getPreviousStudentFees($eachstudent->student_previous_session_id);
                    }

                    if (!empty($student_total_fees)) {
                        $totalfee = 0;
                        $deposit = 0;
                        $discount = 0;
                        $balance = 0;
                        foreach ($student_total_fees as $student_total_fees_key => $student_total_fees_value) {
                            if (!empty($student_total_fees_value->fees)) {
                                foreach ($student_total_fees_value->fees as $each_fee_key => $each_fee_value) {
                                    $totalfee = $totalfee + $each_fee_value->amount;

                                    $amount_detail = json_decode($each_fee_value->amount_detail);
                                    if ($amount_detail != null) {
                                        foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                                            $deposit = $deposit + $amount_detail_value->amount;
                                            $discount = $discount + $amount_detail_value->amount_discount;
                                        }
                                    }
                                }
                            }
                        }

                        $eachstudent->balance = $totalfee - ($deposit + $discount);
                    } else {
                        $eachstudent->balance = "0";
                    }
                    //===================
                }
            }
        }

        return json_encode(array('student_Array' => $student_Array, 'is_update' => $is_update));
    }
    function studentacademicreport() {

        if (!$this->rbac->hasPrivilege('balance_fees_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');
        $this->session->set_userdata('subsub_menu', 'Reports/finance/studentacademicreport');
        $data['title'] = 'student fee';
        $class = $this->class_model->get();
        $data['sch_setting'] = $this->sch_setting_detail;
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['classlist'] = $class;
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $feetype = $this->input->post('feetype');
        $feetype_arr = $this->input->post('feetype_arr');
        $data['section_list'] = $this->section_model->getClassBySection($this->input->post('class_id'));
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|xss_clean');


        if ($this->form_validation->run() == false) {
            $data['student_due_fee'] = array();
            $data['resultarray'] = array();

            $data['class_id'] = "";
            $data['section_id'] = "";
            $data['feetype'] = "";
            $data['feetype_arr'] = array();
        } else {
            $student_Array = array(); 

            $section = array();

            $classlist = $this->student_model->getAllClassSection($class_id, $section_id);

            foreach ($classlist as $key => $value) {
                $classid = $value['class_id'];
                $sectionid = $value['section_id'];

                $studentlist =         $this->student_model->reportClassSection($classid,$value['section_id']);
                $setting_result = $this->setting_model->get();
                $current_session = $setting_result[0]['session_id'];
                $data['current_session'] = $current_session;

                $pre_session = $this->session_model->getPreSession($current_session);

                $student_Array = array();
                if (!empty($pre_session)) {
                    $student_Array = json_decode($this->findPreviousBalanceFees($pre_session->id, $class_id, $section_id, $current_session));

                   
                }
                // dd($student_Array);
                // echo $this->db->last_query();
                // dd($studentPreviouslist);
                $previousFeeRecords = array();
                if($student_Array){
                    foreach($student_Array->student_Array as $key => $val){
                   
                        $previousFeeRecords[$val->admission_no] = $val;
                    }
                }
                $student_Array = array();
                if (!empty($studentlist)) {
                    foreach ($studentlist as $key => $eachstudent) {
                        $obj = new stdClass();
                        $obj->name = $this->customlib->getFullName($eachstudent['firstname'],$eachstudent['middlename'],$eachstudent['lastname'],$this->sch_setting_detail->middlename,$this->sch_setting_detail->lastname);
                        $obj->class = $eachstudent['class'];
                        $obj->section = $eachstudent['section'];
                        $obj->admission_no = $eachstudent['admission_no'];
                        $obj->roll_no = $eachstudent['roll_no'];
                        $obj->father_name = $eachstudent['father_name'];
                        $obj->mother_name = $eachstudent['mother_name'];
                        $obj->guardian_name = $eachstudent['guardian_name'];
                        $obj->mother_phone = $eachstudent['mother_phone'];
                        $obj->guardian_phone = $eachstudent['guardian_phone'];
                        $obj->category = $eachstudent['category'];
                        $obj->mobileno = $eachstudent['mobileno'];
                        $obj->admission_no = $eachstudent['admission_no'];
                        $student_session_id = $eachstudent['student_session_id'];
                        $student_total_fees = $this->studentfeemaster_model->getStudentFees($student_session_id);

                        if (!empty($student_total_fees)) {


                            $totalfee = 0;
                            $deposit = 0;
                            $discount = 0;
                            $balance = 0;
                            $fine = 0;
                            foreach ($student_total_fees as $student_total_fees_key => $student_total_fees_value) {


                                if (!empty($student_total_fees_value->fees)) {
                                    foreach ($student_total_fees_value->fees as $each_fee_key => $each_fee_value) {
                                        $totalfee = $totalfee + $each_fee_value->amount;

                                        $amount_detail = json_decode($each_fee_value->amount_detail);

                                        if (is_object($amount_detail)) {
                                            foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                                                $deposit = $deposit + $amount_detail_value->amount;
                                                $fine = $fine + $amount_detail_value->amount_fine;
                                                $discount = $discount + $amount_detail_value->amount_discount;
                                            }
                                        }
                                    }
                                }
                            }

                            $obj->totalfee = $totalfee;
                            $obj->payment_mode = "N/A";
                            $obj->deposit = $deposit;
                            $obj->fine = $fine;
                            $obj->discount = $discount;
                            $obj->balance = $totalfee - ($deposit + $discount);
                        } else {

                            $obj->totalfee = 0;
                            $obj->payment_mode = 0;
                            $obj->deposit = 0;
                            $obj->fine = 0;
                            $obj->balance = 0;
                            $obj->discount = 0;
                        }

                       

                        if ($obj->balance > 0) {
                            $student_Array[] = $obj;
                        }
                    }
                }
                $classlistdata[$value['class_id']][] = array('class_name' => $value['class'], 'section' => $value['section_id'], 'section_name' => $value['section'], 'result' => $student_Array);

            }



            $data['student_due_fee'] = $student_Array;
            $data['resultarray'] = $classlistdata;

            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $data['feetype'] = $feetype;
            $data['feetype_arr'] = $feetype_arr;
            $data['previousFeeRecords'] = $previousFeeRecords;
        }

        $this->load->view('layout/header', $data);
        $this->load->view('admin/transaction/studentAcademicReport', $data);
        $this->load->view('layout/footer', $data);
    }

}

?>