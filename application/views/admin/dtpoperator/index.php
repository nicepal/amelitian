<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">  

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu"> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
	<!-- <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<style>
    .select2-container {
  min-width: 400px;
}

.select2-results__option {
  padding-right: 20px;
  vertical-align: middle;
}
.select2-results__option:before {
  content: "";
  display: inline-block;
  position: relative;
  height: 20px;
  width: 20px;
  border: 2px solid #e9e9e9;
  border-radius: 4px;
  background-color: #fff;
  margin-right: 20px;
  vertical-align: middle;
}
.select2-results__option[aria-selected=true]:before {
  font-family:fontAwesome;
  content: "\f00c";
  color: #fff;
  background-color: #f77750;
  border: 0;
  display: inline-block;
  padding-left: 3px;
}
.select2-container--default .select2-results__option[aria-selected=true] {
	background-color: #fff;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
	background-color: #eaeaeb;
	color: #272727;
}
.select2-container--default .select2-selection--multiple {
	margin-bottom: 10px;
}
.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
	border-radius: 4px;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
	border-color: #f77750;
	border-width: 2px;
}
.select2-container--default .select2-selection--multiple {
	border-width: 2px;
}
.select2-container--open .select2-dropdown--below {
	
	border-radius: 6px;
	box-shadow: 0 0 10px rgba(0,0,0,0.5);

}
.select2-selection .select2-selection--multiple:after {
	content: 'hhghgh';
}
</style>
    <!-- Main content -->
    <section class="content">
    <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">

                        <form role="form" action="" method="post" class="form-horizontal">

                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="form-group">
                              
                               <div class="col-md-12">
                                    <div class="col-sm-2">
                                            <!-- <div class="form-group"> -->
                                                <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                                <select id="class_id" name="class_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    foreach ($classlist as $class) {
                                                        ?>
                                                        <option value="<?php echo $class['id'] ?>" <?php
                                                        if (set_value('class_id') == $class['id']) {
                                                            echo "selected=selected";
                                                        }
                                                        ?>><?php echo $class['class'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                            <!-- </div> -->
                                        </div>

                                        <div class="col-sm-2">
                                            <!-- <div class="form-group"> -->
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                                <select  id="section_id" name="section_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                            <!-- </div> -->
                                        </div>
                                   
                                        <div class="col-sm-2">
                                            <label><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('group'); ?></label>
                                                <select  id="examgroup_id" name="examgroup_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php if (!empty($examgrouplist)) { 
                                                            foreach ($examgrouplist as $examgroup) { 
                                                                $selected = '';
                                                                if($examgroup_id ==  $examgroup->id){
                                                                    $selected = ' selected="selected"';
                                                                }
                                                                ?>
                                                            <option <?php echo $selected; ?> value="<?php echo $examgroup->id; ?>"><?php echo $examgroup->name; ?></option>
                                                        <?php } 
                                                        } ?>
                                                </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <label><?php echo $this->lang->line('exams'); ?></label>
                                                <select  id="exam_id" name="exam_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    
                                                </select>
                                        </div>

                                        <div class="col-sm-4">
                                            <label><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('subjects'); ?></label>
                                                <select  class="js-select2" multiple="multiple" id="subject_id" name="subject_id[]" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    
                                                </select>
                                        </div>

                               </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>


            </div>

        </div>
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('exam') . " " . $this->lang->line('group') . " " . $this->lang->line('list') ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-messages table-responsive">
                            <div class="download_label"> <?php echo $this->lang->line('exam') . " " . $this->lang->line('group') . " " . $this->lang->line('list') ?></div>
                            <form method="post" action="<?php echo base_url("admin/dtpoperator/addExamResult"); ?>">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td rowspan="2">Roll No</td>
                                        <td rowspan="2">Admission No</td>
                                        <td rowspan="2">Student Name</td>
                                        <?php foreach($examSubjects as $subject){ ?>
                                            <td colspan="2" style="text-align:center;border-right:solid 1px #ccc;"><?php echo $subject['name']; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <!-- <td></td> -->
                                        <?php foreach($examSubjects as $subject){ ?>
                                            <td style="text-align:center">Internal</td>
                                            <td style="text-align:center;border-right:solid 1px #ccc;">External</td>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($examStudents as $student){ 
                                        ?>
                                    <tr>
                                        <td><?php echo $student['roll_no'] ?></td>
                                        <td><?php echo $student['admission_no'] ?></td>
                                        <td><?php echo $student['firstname'] ?> <?php echo $student['lastname'] ?></td>
                                        
                                        <?php foreach($examSubjects as $subject){ 
                                            // echo $student['onlineexam_student_id'].' | '.$subject['exam_subject_id'];
                                            $resultInfo = $this->examresult_model->getSingleStudentExamResult($student['onlineexam_student_id'],$subject['exam_subject_id']);
                                            // dd($resultInfo,0);
                                            ?>
                                            <td style="<?php echo ($resultInfo['attendence'] == "Absent")?('background-color:#ff00002e'):(''); ?>">
                                                <input name="result[<?php echo $student['onlineexam_student_id']; ?>][<?php echo $subject['exam_subject_id']; ?>][internal]" value="<?php echo isset($resultInfo['internal_marks'])?($resultInfo['internal_marks']):('0'); ?>" type="text" class="form-control">
                                            </td>
                                            <td style="border-right:solid 1px #ccc;<?php echo ($resultInfo['attendence'] == "Absent")?('background-color:#ff00002e'):(''); ?>">
                                                <input name="result[<?php echo $student['onlineexam_student_id']; ?>][<?php echo $subject['exam_subject_id']; ?>][external]" value="<?php echo isset($resultInfo['external_marks'])?($resultInfo['external_marks']):('0'); ?>"  type="text" class="form-control">
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <input type="submit" class="btn btn-primary pull-right" value="Submit">
                            </form>
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->

        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
     var class_id = '<?php echo $class_id; ?>';
    var section_id = '<?php echo $section_id; ?>';
    getSectionByClass(class_id, section_id);
    getExamSubject(<?php echo $exam_id; ?>);
    all_records();

$(document).on('change', '#class_id', function (e) {
        $('#section_id').html("");
        var class_id = $(this).val();
        getSectionByClass(class_id, 0);
    });

    function getSectionByClass(class_id, section_id) {

        if (class_id !== "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url(); ?>';
            var div_data = '<option value="">Select</option>';


            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                beforeSend: function () {
                    $('#section_id').addClass('dropdownloading');
                },
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (section_id === obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                },
                complete: function () {
                    $('#section_id').removeClass('dropdownloading');
                }
            });
        }
    }

    

$(".js-select2").select2({
			closeOnSelect : false,
			placeholder : "Placeholder",
			allowHtml: true,
			allowClear: true,
			tags: true // создает новые опции на лету
		});
    $(document).on("change","#examgroup_id",function(){
        all_records();
    });
    function all_records() {
        var base_url = '<?php echo base_url(); ?>';

        $.ajax({
            type: "POST",
            url: base_url + "admin/examgroup/getexam",
            data: {examgroup_id: $('#examgroup_id').val()}, // serializes the form's elements.
            dataType: "JSON", // serializes the form's elements.
            beforeSend: function () {

            },
            success: function (data)
            {
               let html = '<option value="">Select</option>';
               for(let i = 0; i < data.examList.length; i++){
                let selected = '';
                let id = '<?php echo $exam_id; ?>';
                if(data.examList[i].id == id){
                    selected = ' selected="selected"';
                }
                html += '<option '+selected+' value="'+data.examList[i].id+'">'+data.examList[i].exam+'</option>';
               }
               $("#exam_id").html(html);

            },
            error: function (xhr) { // if error occured

                alert("Error occurred, Please try again");

            },
            complete: function () {

            }
        });
    }

    function getExamSubject(recordid){
        var base_url = '<?php echo base_url(); ?>';

        $.ajax({
            type: 'POST',
            url: baseurl + "admin/examgroup/getSubjectByExam",
            data: {'recordid': recordid},
            dataType: 'JSON',
            beforeSend: function () {
                // $this.button('loading');
            },
            success: function (data) {
                let html = '<option value="">Select</option>';
               for(let i = 0; i < data.exam_subjects.length; i++){
                let idArray = '<?php echo json_encode($subject_id); ?>';
                selected = '';
                if (idArray.includes(data.exam_subjects[i].id)) {
                    selected = '';
                    selected = ' selected="selected"';
                }

                html += '<option '+selected+' value="'+data.exam_subjects[i].id+'">'+data.exam_subjects[i].subject_name+'</option>';
               }
               $("#subject_id").html(html);
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
                $this.button('reset');
            },
            complete: function () {
                // $this.button('reset');
            }
        });
    }

    $(document).on('change', '#exam_id', function () {
        var $this = $(this);
        var recordid = $this.val();
        getExamSubject(recordid);
        // $('input[name=recordid]').val(recordid);
       

    });
</script>