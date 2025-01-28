<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visitors extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("Visitors_model");
        $this->load->library('mailsmsconf');

    }


    public function verify_recaptcha($recaptchaResponse) {
        $recaptchaSecretKey = '6LccTG8pAAAAAOlgZnSISOVCDNXMosLjZWXW50Gd'; // Replace with your actual Secret Key
    
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
            'secret'   => $recaptchaSecretKey,
            'response' => $recaptchaResponse,
        ];
    
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
    
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);
        return $result['success'];
    }



    public function ajax_fetch() {
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $search_value = $this->input->post('search')['value']; // Get search value from DataTables

        $data = $this->Visitors_model->paginated_visitors_list($start, $limit, $search_value);
        $total_records = $this->Visitors_model->get_total_visitors_count($search_value);
        $output = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_records,
            "recordsFiltered" => $total_records,
            "data" => $data
        );
        echo json_encode($output);
    }
    
    function index($page=1) {

        // dd($this->uri->segment(4));
        if (!$this->rbac->hasPrivilege('visitor_book', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'front_office');
        $this->session->set_userdata('sub_menu', 'admin/visitors');
        $this->form_validation->set_rules('purpose', $this->lang->line('purpose'), 'required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('permission_by', $this->lang->line('permission_by'), 'required');
        $this->form_validation->set_rules('file', $this->lang->line('file'), 'callback_handle_upload[file]');
        $this->form_validation->set_rules('g-recaptcha-response', 'reCAPTCHA', 'required|callback_verify_recaptcha');
        $this->form_validation->set_message('g-recaptcha-response', 'Captcha error');

        if ($this->form_validation->run() == FALSE) {
            // $data['visitor_list'] = $this->Visitors_model->visitors_list();
            $data['visitor_list'] = array();
            // $data['pagination_links'] = $this->pagination->create_links();

            $data['Purpose'] = $this->Visitors_model->getPurpose();
            // $data['pagination_links'] = $this->pagination->create_links();

            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/visitorview', $data);
            $this->load->view('layout/footer');
        } else {
            
            $otp = rand(0000,9999);

            // $options = array(
            //     'To Meet Management',
            //     'To Meet Teacher',
            //     'To pay School Fee',
            //     'To Meet Principal',
            //     'To Meet Child within Campus',
            //     'To Take Child Outside Campus'
            // );
            // if(!in_array($this->input->post('purpose'),$options) == false){
            //     die('Something Went Wront');
            // }
            // if (preg_match('/<[^>]*>|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $this->input->post('name'))) {
            //     die('Something Went Wront');
            // }

            $visitors = array(
                'admission_no' => $this->input->post('admission_no'),
                'purpose' => $this->input->post('purpose'),
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'id_proof' => $this->input->post('id_proof'),
                'permission_by' => $this->input->post('permission_by'),
                'outing_reason' => $this->input->post('outing_reason'),
                'no_of_pepple' => $this->input->post('pepples'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'return_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('return_date'))),
                'in_time' => $this->input->post('time'),
                'out_time' => $this->input->post('out_time'),
                'note' => $this->input->post('note'),
                'otp' => $otp,
                'guardian_phone' => $this->input->post("guardian_phone"),
                'otp_status' => 0,
                'resend_time' => time(),
                'added_by' => $this->session->userdata("admin")['id']
            );

            $visitor_id = $this->Visitors_model->add($visitors);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = 'id' . $visitor_id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/front_office/visitors/" . $img_name);
                $this->Visitors_model->image_add($visitor_id, $img_name);
            }

            if($this->input->post('purpose') == "To Meet Child within Campus" || $this->input->post('purpose') == "To Take Child Outside Campus"){
                $sender_details = array('contact_no' => $this->input->post('guardian_phone'), 'otp' => $otp);
                $this->mailsmsconf->mailsms('outpass', $sender_details);
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/visitors');
        }
    }

    public function delete($id) {
        if (!$this->rbac->hasPrivilege('visitor_book', 'can_delete')) {
            access_denied();
        }

        $this->Visitors_model->delete($id);
    }

    public function edit($id) {
        if (!$this->rbac->hasPrivilege('visitor_book', 'can_edit')) {
            access_denied();
        }

        $this->form_validation->set_rules('purpose', $this->lang->line('purpose'), 'required');

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'required');

        $this->form_validation->set_rules('file', $this->lang->line('file'), 'callback_handle_upload[file]');
        if ($this->form_validation->run() == FALSE) {

            $data['Purpose'] = $this->Visitors_model->getPurpose();
            $data['visitor_list'] = $this->Visitors_model->visitors_list();
            $data['visitor_data'] = $this->Visitors_model->visitors_list($id);
            $this->load->view('layout/header');
            $this->load->view('admin/frontoffice/visitoreditview', $data);
            $this->load->view('layout/footer');
        } else {

            $visitors = array(
                'purpose' => $this->input->post('purpose'),
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'id_proof' => $this->input->post('id_proof'),
                'no_of_pepple' => $this->input->post('pepples'),
                'permission_by' => $this->input->post('permission_by'),
                'outing_reason' => $this->input->post('outing_reason'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'return_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('return_date'))),
                'in_time' => $this->input->post('time'),
                'out_time' => $this->input->post('out_time'),
                'note' => $this->input->post('note'),
                'added_by' => $this->session->userdata("admin")['id']

            );
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);

                $img_name = 'id' . $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/front_office/visitors/" . $img_name);
                $this->Visitors_model->image_update($id, $img_name);
            }

            

            $this->Visitors_model->update($id, $visitors);
            redirect('admin/visitors');
        }
    }

    public function details($id) {
        if (!$this->rbac->hasPrivilege('visitor_book', 'can_view')) {
            access_denied();
        }

        $data['data'] = $this->Visitors_model->visitors_list($id);
        $this->load->view('admin/frontoffice/Visitormodelview', $data);
    }

    public function resendOTP($id,$no){

        $data = $this->Visitors_model->visitors_list($id);
        $time = time() - $data['resend_time'];
        if($time >= 60){
            $otp = rand(0000,9999);
            $this->Visitors_model->simple_update($id,array("otp" => $otp,'resend_time'=>time()));

            $sender_details = array('contact_no' => $no, 'otp' => $otp);
            $this->mailsmsconf->mailsms('outpass', $sender_details);
            echo 'success';
        }else{
            $otpTime = 60-$time;
            echo 'you can resend otp after '.$otpTime.' seconds!';
        }

    }
    public function verifyOtp($id){
        if (!$this->rbac->hasPrivilege('visitor_book', 'can_view')) {
            access_denied();
        }

        $data['data'] = $this->Visitors_model->visitors_list($id);
        $data['visitor_id'] = $id;
        $this->load->view('admin/frontoffice/verifyOtpModel', $data);
    }

    public function submitVerifyOtp($id){
        $otp = $this->input->post("otp");
        $data = $this->Visitors_model->visitors_list($id);
        if($data['otp'] == $otp){
            $this->Visitors_model->simple_update($id,array("otp_status" => 1));
            echo 'success';

        }else{
            echo 'OTP is not valid!';
        }
    }

    public function get_student_record($admission_no=''){
        if($admission_no){
            $class                   = $this->class_model->get();
            $data['classlist']       = $class;
    
            $carray   = array();
    
            if (!empty($data["classlist"])) {
                foreach ($data["classlist"] as $ckey => $cvalue) {
    
                    $carray[] = $cvalue["id"];
                }
            }
            $records = $this->student_model->searchFullText($admission_no,$carray);
            if($records){
                // $counter = 0;
                    echo '<div class="row">';
                    foreach($records as $record){
                        // if($counter == 0){

                        // die(print_r($record));
                        // if($record['guardian_phone'] == ""){
                        //     echo '<div class="alert alert-danger">Guardian No# is not available</div>';
                        // }
                        
                        echo '<div class="col-sm-6 hover-profile">';
                        echo '<input type="hidden" name="guardian_phone" id="guardian_phone" value="'.$record['guardian_phone'].'">';
                        echo '<input type="hidden" name="admission_no" id="admission_no" value="'.$record['admission_no'].'">';
                    echo '<div class="box-body box-profile" style="font-size:12px;">';
                    if(is_file($record['image'])){
                        $image = $record['image'];
                    }else{
                        $image = "/uploads/student_images/default_male.jpg";
                    }
                    echo '<img class="profile-user-img img-responsive img-circle" src="'.base_url($image).'" alt="User profile picture">';

                    echo '<h3 class="profile-username text-center"><a target=_blank"" href="'.base_url('student/view/'.$record['id']).'">'.$record['firstname'].' '.$record['lastname'].'</a></h3>

                        <ul class="list-group list-group-unbordered">


                        <li class="list-group-item listnoback">
                        <b>Admission No</b> <a class="pull-right text-aqua">'.$record['admission_no'].'</a>
                        </li>

                        <li class="list-group-item listnoback">
                        <b>Roll Number</b> <a class="pull-right text-aqua">'.$record['roll_no'].'</a>
                        </li>
                                            <li class="list-group-item listnoback">
                        <b>Class</b> <a class="pull-right text-aqua">'.$record['class'].'</a>
                        </li>
                        <li class="list-group-item listnoback">
                        <b>Section</b> <a class="pull-right text-aqua">'.$record['section'].'</a>
                        </li>
                                            <li class="list-group-item listnoback">
                        <b>RTE</b> <a class="pull-right text-aqua">'.$record['rte'].'</a>
                        </li>
                                            <li class="list-group-item listnoback">
                        <b>Gender</b> <a class="pull-right text-aqua">'.$record['gender'].'</a>
                        </li>
                        </ul>
                        </div>';
                        echo '</div>';
                        // echo '<div class="col-sm-6">';
                        // echo '<div class="box-body box-profile" style="font-size:12px;">';
                        // if(is_file($record['father_pic'])){
                        //     $image1 = $record['father_pic'];
                        // }else{
                        //     $image1 = "/uploads/student_images/default_male.jpg";
                        // }
                        // echo '<img class="profile-user-img img-responsive img-circle" src="'.base_url($image1).'" alt="User profile picture">';

                        // echo '<h3 class="profile-username text-center">'.$record['father_name'].'</h3>
        
                        //     <ul class="list-group list-group-unbordered">
        
        
                        //     <li class="list-group-item listnoback">
                        //     <b>Father Name</b> <a class="pull-right text-aqua">'.$record['father_name'].'</a>
                        //     </li>
        
                        //     <li class="list-group-item listnoback">
                        //     <b>Guardian Name</b> <a class="pull-right text-aqua">'.$record['guardian_name'].'</a>
                        //     </li>
                        //                         <li class="list-group-item listnoback">
                        //     <b>Guardian Relation</b> <a class="pull-right text-aqua">'.$record['guardian_relation'].'</a>
                        //     </li>
                        //     <li class="list-group-item listnoback">
                        //     <b>Guardian Phone</b> <a class="pull-right text-aqua">'.$record['guardian_phone'].'</a>
                        //     </li>
                        //             <!--            <li class="list-group-item listnoback">
                        //     <b>RTE</b> <a class="pull-right text-aqua">'.$record['rte'].'</a>
                        //     </li>
                        //                         <li class="list-group-item listnoback">
                        //     <b>Gender</b> <a class="pull-right text-aqua">'.$record['gender'].'</a>
                        //     </li> -->
                        //     </ul>
                        //     </div>';
                        // echo '</div>';

                        // echo '<div class="col-sm-12"><div class="col-sm-4">';
                        // if(is_file($record['mother_pic'])){
                        //     $image2 = $record['mother_pic'];
                        // }else{
                        //     $image2 = "/uploads/student_images/default_male.jpg";
                        // }
                        //     echo '<img class="profile-user-img img-responsive img-circle" src="'.base_url($image2).'" alt="User profile picture">
                        //     <h3 class="profile-username text-center">Mother Picture</h3>';
                        // echo '</div>';

                        // echo '<div class="col-sm-4">';
                        // if(is_file($record['guardian_pic'])){
                        //     $image3 = $record['guardian_pic'];
                        // }else{
                        //     $image3 = "/uploads/student_images/default_male.jpg";
                        // }
                            // echo '<img class="profile-user-img img-responsive img-circle" src="'.base_url($image3).'" alt="User profile picture">
                            // <h3 class="profile-username text-center">Guardian Picture</h3>';
                        // echo '</div></div>';
                        // $counter++;

                    // }
                    // echo '</div>';
                }
                echo '</div>';
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
    public function get_student_record_id($admission_no=''){
        if($admission_no){
            $class                   = $this->class_model->get();
            $data['classlist']       = $class;
    
            $carray   = array();
    
            if (!empty($data["classlist"])) {
                foreach ($data["classlist"] as $ckey => $cvalue) {
    
                    $carray[] = $cvalue["id"];
                }
            }
            $records = $this->student_model->searchFullText($admission_no,$carray);
            if($records){
                
                // echo $records[0]['id'];
                $student_record = $records[0];
                $resultlist         = $this->student_model->searchFullText($records[0]['admission_no']);
                $count = 1;
                foreach ($resultlist as $student) {
                    $student_due_fee = $this->studentfeemaster_model->getStudentFees($student['student_session_id']);
                    $fee_paid = 0;
                    $fee_discount = 0;
                    $fee_fine = 0;
                    $fees_fine_amount = 0;
                    $total_amount = 0;
                    $total_balance_amount = 0;

                    $newBalance = 0;
                    $newTotalFeePaid = 0;
                    $total_fees_fine_amount = 0;
                    foreach ($student_due_fee as $key => $fee) {

                        foreach ($fee->fees as $fee_key => $fee_value) {
                            
                            if (!empty($fee_value->amount_detail)) {
                                $fee_deposits = json_decode(($fee_value->amount_detail));

                                foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                    $fee_paid = $fee_paid + $fee_deposits_value->amount;
                                    $fee_discount = $fee_discount + $fee_deposits_value->amount_discount;
                                    $fee_fine = $fee_fine + $fee_deposits_value->amount_fine;
                                }
                            }
                            if (($fee_value->due_date != "0000-00-00" && $fee_value->due_date != NULL) && (strtotime($fee_value->due_date) < strtotime(date('Y-m-d')))) {
                                $fees_fine_amount=$fee_value->fine_amount;
                                // $total_fees_fine_amount=$total_fees_fine_amount+$fee_value->fine_amount;
                           }

                          
                            $total_amount = $total_amount + $fee_value->amount;
                            // $total_discount_amount = $total_discount_amount + $fee_discount;
                            // $total_deposite_amount += $total_deposite_amount + $fee_paid + $fee_discount;
                            // $total_fine_amount += $total_fine_amount + $fee_fine;
                            // $feetype_balance += $fee_value->amount - ($fee_paid);
                            $total_balance_amount += $total_amount + $fee_paid;
                        }
                     
                    }

                  
                    $newTotalFeePaid = $fee_paid + $fee_discount;
                    $student_record['total_amount'] = $total_amount;
                    $student_record['newTotalFeePaid'] = $newTotalFeePaid;
                    $student_record['final'] = $total_amount-$newTotalFeePaid;

                }
                echo json_encode($student_record);

                
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }

    public function download($documents) {
        $this->load->helper('download');
        $filepath = "./uploads/front_office/visitors/" . $documents;
        $data = file_get_contents($filepath);
        $name = $documents;
        force_download($name, $data);
    }

    public function imagedelete($id, $image) {
        if (!$this->rbac->hasPrivilege('visitor_book', 'can_delete')) {
            access_denied();
        }
        $this->Visitors_model->image_delete($id, $image);
    }

    public function check_default($post_string) {
        return $post_string == "" ? FALSE : TRUE;
    }

    public function handle_upload($str,$var)
    {

        $image_validate = $this->config->item('file_validate');
        $result = $this->filetype_model->get();
        if (isset($_FILES[$var]) && !empty($_FILES[$var]['name'])) {

            $file_type         = $_FILES[$var]['type'];
            $file_size         = $_FILES[$var]["size"];
            $file_name         = $_FILES[$var]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->file_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->file_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            if ($files = filesize($_FILES[$var]['tmp_name'])) {

                if (!in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $result->file_size) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }

            } else {
                $this->form_validation->set_message('handle_upload', "File Type / Extension Error Uploading  Image");
                return false;
            }

            return true;
        }
        return true;

    }

}
