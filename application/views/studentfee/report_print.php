<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Student Report Card</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 	crossorigin="anonymous">
<style>
body{
    font-size: 14px;
    padding:10px;
	}
td {
	border: 1px solid #726E6D;
	padding: 8px;
 
}
thead >tr > td {
	font-weight:bold !important;
	text-align:center !important;
	background:#4f7e33 !important;
	color:#fff !important;
}
table {
	border-collapse: collapse;
}
.yellow >td {
	background:#ffefcb !important;
}
.footer {
	text-align:right;
	font-weight:bold;
}
li {
	list-style-position: inside;
}
.note span {
	margin-left:25px;
	font-size:12px;
}
@media only screen and (max-width: 600px) {
  body {
  font-size:12px;
  }
  table{width:100%!important;}
}

</style>
</head>
<body>

    <!--  Report card here -->
<?php if($resultlist){ 
    
        foreach($resultlist as $key => $val){ 

            $subjects = array();

            $this->db->select('exam_group_class_batch_exam_students.*, 
                    exam_group_class_batch_exams.exam, 
                    exam_group_class_batch_exams.id as exam_id, 
                    exam_group_class_batch_exams.exam_group_id');
            $this->db->from('exam_group_class_batch_exam_students');
            $this->db->join('exam_group_class_batch_exams', 'exam_group_class_batch_exams.id = exam_group_class_batch_exam_students.exam_group_class_batch_exam_id');
            $this->db->where('exam_group_class_batch_exam_students.student_id', $val['id']);
            $this->db->where('exam_group_class_batch_exam_students.student_session_id', $val['student_session_id']);
            $query = $this->db->get();
            $res = $query->result_array(); // Get result as array
            $val['subjects_parent'] = $res;
            foreach ($res as $rs) {
                $this->db->select('egs.id as exam_subject_id, egr.*,egs.subject_id,subjects.name as subject_name,egs.min_marks,egs.max_marks');
                $this->db->from('exam_group_class_batch_exam_subjects as egs');
                $this->db->join("subjects",'subjects.id = egs.subject_id');
                $this->db->join('exam_group_class_batch_exam_students as egstu', 'egstu.exam_group_class_batch_exam_id = egs.exam_group_class_batch_exams_id AND egstu.student_session_id = '.$rs['student_session_id']);
                $this->db->join('exam_group_exam_results as egr', 
                    'egr.exam_group_class_batch_exam_student_id = egstu.id 
                     AND egr.exam_group_class_batch_exam_subject_id = egs.id');
                $this->db->where('egs.exam_group_class_batch_exams_id', $rs['exam_id']);
                // $this->db->where("exam_group_class_batch_exam_students.student_session_id",$rs['student_session_id']);
                $query2 = $this->db->get();                                  
                $res2 = $query2->result_array(); // or result() for objects
                $resultData = array();
                foreach($res2 as $kkk){
                    $resultData[$kkk['subject_id']] =  $kkk;
                    $subjects[$kkk['subject_id']] = $kkk['subject_name'];

                }
                // dd($resultData);
                $val['subjects'][$rs['exam_id']] = $resultData;
            }
            // print_r($val);
            // die();
            ?>
    <div class=" text-center pt-5">
        <div class="row">
            <div class="col">
            <h1>Montessori Elite EM School</h1>
            <h4>Consolidated Report Card</h4>
            </div>
        </div>
    </div>
    <div class=" pb-5">
        <div class="row">
            <table class="table" align="center" cellspacing="0" cellpadding="0">
            <col width="125">
            <col width="122">
            <col width="77">
            <col width="64" span="3">
            <col width="191">
            <tr height="39" align="center">
                <td colspan="2" height="39" width="247">
                <b>Class: <?php echo $val['class']; ?> (<?php echo $val['section']; ?>)</b>
                </td>
                <td colspan="5" width="460">
                <b>Academic Session: <?php echo $sch_setting->session; ?></b>
                </td>
            </tr>
            <tr height="27">
                <td colspan="3" height="27">NAME OF STUDENT :    <?php echo $val['firstname']; ?> <?php echo $val['lastname']; ?></td>
                <td colspan="4">Roll No               :    AASS25WS511425</td>
            </tr>
            <tr height="26">
                <td colspan="3" height="26">FATHER'S NAME      :    <?php echo $val['father_name']; ?></td>
                <td colspan="4" width="383">DATE OF BIRTH:    <?php echo $val['dob']; ?></td>
            </tr>
            <tr height="23">
                <td colspan="3" height="23">MOTHER'S NAME    :    <?php echo $val['mother_name']; ?></td>
                <td colspan="4" width="383">ATTENDANCE   :    <?php get_attendance_summary( $val['student_session_id'],$sessionData); ?>
                </td>
            </tr>
            <tr height="23">
                <td colspan="3" height="23">ADDRESS                  : <?php echo $val['current_address']??$val['permanent_address']; ?></td>
                <td colspan="4"></td>
            </tr>
            </table>
            <table align="center" class="table">
            <thead>
                <tr>
                <td colspan="1">Scholastic </td>
                <?php  foreach($val['subjects_parent'] as $subs){ ?>
                            <td colspan="3"> <?php echo $subs['exam'] ?></td>
                        <?php } ?>
                <td colspan="2"> Overall </td>
                </tr>
            </thead>
            <tbody>
                <tr class="yellow">
                    <td><strong>Subject</strong> </td>
                   
                    <?php  foreach($val['subjects_parent'] as $subs){ ?>
                            <td>Int </td>
                            <td> Ext </td>
                            <td> Total </td>
                        <?php } ?>
                    <td> <strong> Grand Total</strong> </td>
                    <td rowspan="2"> <strong> Grand</strong> </td>
                </tr>
               
                <?php 
                $counter = 0;
                // dd($subjects);
                foreach($subjects as $subject_id_key => $subject_name){
                    if($counter == 0){ ?>
                        <tr class="yellow">
                            <td></td>
                            <?php  
                           $grand_total_header=0;

                            foreach($val['subjects_parent'] as $subs){
                                 $interal = $val['subjects'][$subs['exam_id']][$subject_id_key]['min_marks'];
                                 $external = $val['subjects'][$subs['exam_id']][$subject_id_key]['max_marks'];
                                ?>
                                <td><?php echo $interal; ?></td>
                                <td><?php echo $external; ?></td>
                                <td><?php $sum = $interal+$external;
                                echo $sum;
                                $grand_total_header+= $sum;
                                ?></td>
                            <?php } ?>

                            <td><strong> <?php echo $grand_total_header; ?></strong> </td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td><strong><?php echo $subject_name; ?></strong></td>
                    <?php  
                    $grand_total_row = 0;
                    foreach($val['subjects_parent'] as $subs){ 
                            $interal = $val['subjects'][$subs['exam_id']][$subject_id_key]['internal_marks'];
                            $external = $val['subjects'][$subs['exam_id']][$subject_id_key]['external_marks'];
                        ?>
                        <td> <?php echo $interal; ?></td>
                        <td> <?php echo $external; ?> </td>
                        <td> <?php $sum_row =  $interal+$external; 
                        echo $sum_row;
                        $grand_total_row+= $sum_row;
                        ?> </td>
                    <?php } ?>
                   

                    <td> <strong> <?php echo $grand_total_row; ?></strong> </td>
                    <td> <strong> <?php echo getGrade($grand_total_header,$grand_total_row); ?></strong> </td>
                </tr>
            <?php $counter++; 
                } ?>
               
            </tbody>
            <tfoot>
                <tr>
                <td colspan="2" class="footer">OVERALL MARKS </td>
                <td> 600/1200 </td>
                <td colspan="3" class="footer">PERCENTAGE</td>
                <td colspan="2">87%</td>
                <td colspan="2" class="footer">RESULT</td>
                <td colspan="2">Pass </td>
                </tr>
            </table>
            <!-- <table class="table">
            <thead>
                <tr>
                <td>Co-Scholastic Areas: (5 Points Grading Scale A,A+,B,B+,C) </td>
                <td> Term 1 </td>
                <td> Term III </td>
                </tr>
            </thead>
            <tbody>
                <tr class=" ">
                <td>GAME </td>
                <td>A </td>
                <td> B</td>
                </tr>
                <tr class=" ">
                <td>CONFIDENCE </td>
                <td>A </td>
                <td> B</td>
                </tr>
                <tr class=" ">
                <td>UNIFORM </td>
                <td>A </td>
                <td> B</td>
                </tr>
                <tr class=" ">
                <td>DISCIPLINE </td>
                <td>A </td>
                <td> B</td>
                </tr>
                <tr class=" ">
                <td>REGULARITY & PUNCTUALITY </td>
                <td>A </td>
                <td> B</td>
                </tr>
                <tr class=" ">
                <td>P.T </td>
                <td>A </td>
                <td> B</td>
                </tr>
            </tbody>
            </table>
            <p class="note">
            <strong>
                <span> A+ =Excellent </span>
                <span>A =Very Good </span>
                <span>B+ =Average Result </span>
                <span> B =Need Encouragement </span>
                <span> C =NeedAttention</span>
            </strong> -->
            </p>
            <!-- <table class="table">
            <thead>
                <tr>
                <td>ATTENDANCE </td>
                <td> Term 1 </td>
                <td> Term II </td>
                </tr>
            </thead>
            <tbody>
                <tr class=" ">
                <td>TOTAL WORKING DAYS: </td>
                <td>100 </td>
                <td>100</td>
                </tr>
                <tr class=" ">
                <td>TOTAL ATTENDANCE: </td>
                <td>80 </td>
                <td>90</td>
                </tr>
            </tbody>
            </table> -->
            <p class="note">
            <strong>
                <span> Promoted to Class: <span style="text-decoration: underline;"><?php echo getNextClass($val['class']); ?></span></span>
                <span>SCHOOL WILL RE-OPEN ON: <span style="text-decoration: underline;">June <?php echo date("Y",time())+1 ?></span> </span>
                <span>AT <span style="text-decoration: underline;">Montessori Elite EM School </span></span>
            </strong>
            </p>
            <table class="table" align="center">
            <tr>
                <td>
                <strong>CLASS TEACHER'S REMARKS</strong>
                </td>
                <td colspan="3">
                <strong>Remarks Of Class Teacher Should Put Here</strong>
                </td>
            </tr>
            <tbody>
                <tr class=" ">
                <td rowspan="2">
                    <strong>DATE</strong>
                    <br> <?php echo date("d-m-Y",time()); ?>
                </td>
                <td></td>
                <td></td>
                </tr>
                <tr class=" ">
                <td></td>
                <td>SIGNATURE OF CLASS TEACHER </td>
                <td>SIGNATURE OF PRINCIPAL</td>
                </tr>
            </tbody>
            </table>
            <p>
            <br>
            </p>
            <h5>Rules:</h5>
            <ol>
            <li>The students are expected to keep this card neat and clean.</li>
            <li>In case the card is lost the duplicate card will be issued on payment of extra report card fee.</li>
            <li> Promotion will be granted on the weight of both examinations. To pass the monthly tests is also compulsory.</li>
            <li> For any complaint at any point, kindly contact personally.</li>
            </ol>
            <p>
            <hr>
            </p>
            <h5 class="text-center">
            <strong>Instructions</strong>
            </h5>
            <p>
            <strong>Grading scale for scholastic areas: Grades are awarded on a 8-point grading scale as follows:</strong>
            </p>
            <table align="center" class="table">
            <tr>
                <td>
                <strong>Marks Range in (%)</strong>
                </td>
                <td>91-100</td>
                <td> 81-90 </td>
                <td> 71-80 </td>
                <td> 61-70 </td>
                <td> 51-60 </td>
                <td> 41-50 </td>
                <td> 33-40 </td>
                <td>21-32 </td>
                <td>0-20 </td>
            </tr>
            <tr>
                <td>
                <strong>Grade</strong>
                </td>
                <td>A1 </td>
                <td> A2 </td>
                <td>B1 </td>
                <td>B2 </td>
                <td>C1 </td>
                <td>C2</td>
                <td>D </td>
                <td>E1 </td>
                <td>E2 </td>
            </tr>
            </table>
        </div>
    </div>
    <?php  } ?>
<?php  } ?>

</body>
</html>