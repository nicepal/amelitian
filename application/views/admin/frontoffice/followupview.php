<div class="content-wrapper" style="min-height: 348px;">  
    <section class="content-header">
        <h1>
            <i class="fa fa-ioxhost"></i> <?php echo $this->lang->line('front_office'); ?></h1> 
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="col-md-12">
                        <?php echo $this->session->flashdata('msg') ?>
                    </div>
                    <form role="form" action="<?php echo site_url('admin/followup') ?>" method="post" class="">
                        <div class="box-body row">

                            <?php echo $this->customlib->getCSRF(); ?>

                           

                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">  
                                    <label><?php echo $this->lang->line('source'); ?></label>
                                    <select  id="source" name="source" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select') ?></option>

                                        <?php foreach ($sourcelist as $key => $value) { ?>
                                            <option <?php
                                            if ($value["source"] == $source_select) {
                                                echo "selected";
                                            }
                                            ?> value="<?php echo $value["source"] ?>"><?php echo $value["source"] ?></option>
                                            <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('source'); ?></span>
                                </div>  
                            </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('enquiry')." ".$this->lang->line('from'); ?> <?php echo $this->lang->line('date'); ?></label>
                                   
                                        
                                        
                                        <input type="text" autocomplete="off" name="from_date" class="form-control  date"  value="<?php  echo set_value('from_date') ?>">
                                    </div><span class="text-danger"><?php echo form_error('from_date'); ?></span>
                              
                            </div> 

                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('enquiry')." ".$this->lang->line('to'); ?> <?php echo $this->lang->line('date'); ?></label>
                                   
                                        
                                        
                                        <input type="text" autocomplete="off" name="to_date" class="form-control  date"  value="<?php  echo set_value('to_date') ?>">
                                    </div><span class="text-danger"><?php echo form_error('to_date'); ?></span>
                              
                            </div> 
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">  
                                    <label><?php echo $this->lang->line('status'); ?></label>
                                    <select  id="status" name="status" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <option value="all" <?php
                                        if ($status == "all") {
                                            echo "selected";
                                        }
                                        ?>><?php echo $this->lang->line('all') ?></option>
                                                <?php foreach ($enquiry_status as $enkey => $envalue) {
                                                    ?>
                                            <option <?php
                                            if ($enkey == $status) {
                                                echo "selected";
                                            }
                                            ?> value="<?php echo $enkey ?>"><?php echo $envalue ?></option>

                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('status'); ?></span>
                                </div>  
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                        </div>     
                    </form>
                    <div class="ptt10">

                        <div class="bordertop">
                            <div class="box-header with-border">
                                <h3 class="box-title titlefix"> <?php echo $this->lang->line('admission_followup'); ?></h3>
                                <div class="box-tools pull-right">
                                    <?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_add')) { ?>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?></button> 
                                    <?php } ?>      
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="download_label"><?php echo $this->lang->line('admission_enquiry'); ?> <?php echo $this->lang->line('list'); ?></div>
                                <div class="mailbox-messages">
                                    <div class="table-responsive">  
                                        <table class="table table-hover table-striped table-bordered" id="enquirytable">
                                            <thead>
                                                <tr>

                                                    <th><?php echo $this->lang->line('name'); ?>
                                                    </th>
                                                    <th><?php echo $this->lang->line('phone'); ?>
                                                    </th>
                                                    <th><?php echo $this->lang->line('source'); ?>
                                                    </th>

                                                    <th><?php echo $this->lang->line('enquiry'); ?> <?php echo $this->lang->line('date'); ?></th>
                                                    <th><?php echo $this->lang->line('last_follow_up_date'); ?></th>
                                                    <th><?php echo $this->lang->line('next_follow_up_date'); ?>
                                                    </th>
                                                    <th><?php echo $this->lang->line('status'); ?>
                                                    </th>
                                                    <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                if (empty($enquiry_list)) {
                                                    ?>
                                                    <?php
                                                } else {
                                                    foreach ($enquiry_list as $key => $value) {
                                                        $current_date = date("Y-m-d");
                                                        $next_date = $value["next_date"];
                                                        if (empty($next_date)) {

                                                            $next_date = $value["follow_up_date"];
                                                        }

                                                        if ($next_date < $current_date) {
                                                            $class = "class='danger'";
                                                        } else {
                                                            $class = "";
                                                        }
                                                        ?>
                                                        <tr <?php echo $class ?>>

                                                            <td class="mailbox-name"><?php echo $value['name']; ?></td>
                                                            <td class="mailbox-name"><?php echo $value['contact']; ?> </td>
                                                            <td class="mailbox-name"><?php echo $value['source']; ?></td>

                                                            <td class="mailbox-name"> <?php
                                                                if (!empty($value["date"])) {
                                                                    echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date']));
                                                                }
                                                                ?></td>

                                                            <td class="mailbox-name"> <?php
                                                                if (!empty($value["followupdate"])) {
                                                                    echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['followupdate']));
                                                                }
                                                                ?></td>
                                                            <td class="mailbox-name"> <?php
                                                                if (!empty($next_date)) {
                                                                    echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($next_date));
                                                                }
                                                                ?></td>

                                                            <td> <?php echo $enquiry_status[$value["status"]] ?></td>              
                                                            <td class="mailbox-date text-right">
                                                                <?php if ($this->rbac->hasPrivilege('follow_up_admission_enquiry', 'can_view')) { ?>
                                                                    <a class="btn btn-default btn-xs" onclick="follow_up('<?php echo $value['id']; ?>', '<?php echo $value['status']; ?>');"  data-target="#follow_up" data-toggle="modal"  title="<?php echo $this->lang->line('follow_up_admission_enquiry'); ?>">
                                                                        <i class="fa fa-phone"></i>
                                                                    </a>
                                                                <?php }
                                                                ?>
                                                                <?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_edit')) { ?>
                                                                    <a  onclick="getRecord('<?php echo $value['id']; ?>', '<?php echo $value['status']; ?>')" class="btn btn-default btn-xs" data-target="#myModaledit" data-toggle="modal"   title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i>
                                                                    </a> 
                                                                <?php }
                                                                ?>
                                                                <?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_delete')) { ?>
                                                                    <a data-placement="left" href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_enquiry('<?php echo $value["id"] ?>')" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                                        <i class="fa fa-remove"></i>
                                                                    </a>
                                                                <?php }
                                                                ?>

                                                            </td>


                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table><!-- /.table -->
                                    </div>  
                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div>  
            </div>

    </section>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="box-title"> <?php echo $this->lang->line('admission_followup'); ?></h4> 
                </div>

                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="formadd" method="post" class="ptt10">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <label for="pwd">Search By Admission No</label>  <small class="req"> *</small>
                                            <input type="text" placeholder="Search By Roll Number, Enroll Number etc" class="form-control admission_no" id="admission_no" value="<?php echo set_value('admission_no'); ?>" name="admission_no_search">
                                            <span class="text-danger"><?php echo form_error('admission_no'); ?></span>
                                            <small class="text-danger">Press enter to get student record</small>                                    
                                        </div><!--./form-group-->
                                    </div> 
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <span class="view_btn">

                                            </span>
                                        </div>
                                    </div>
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Total Fee</th>
                                            <th>Total Paid</th>
                                            <th>Total Due</th>
                                        </tr>
                                        <tr>
                                            <td><span class="total_fee"></span></td>
                                            <td><span class="total_paid"></span></td>
                                            <td><span class="total_due"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                    
                              
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>  
                                            <input type="text" id="name_add" autocomplete="off" class="form-control" value="<?php echo set_value('name'); ?>" name="name">
                                            <span id="name_add_error" class="text-danger"></span>
                                        </div>

                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('phone'); ?></label><small class="req"> *</small> 
                                            <input id="number" autocomplete="off" name="contact" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact'); ?>" />

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('email'); ?></label>
                                            <input type="text" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                                        </div>
                                    </div>   
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email"><?php echo $this->lang->line('address'); ?></label> 
                                            <textarea name="address" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                        </div> 
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email"><?php echo $this->lang->line('description'); ?></label>
                                            <textarea name="description" class="form-control" ><?php echo set_value('description'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">

                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('note'); ?></label> 
                                            <textarea name="note" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('number_of_child'); ?></label>
                                            <!-- <input type="number" class="form-control" min="1" value="<?php echo set_value('no_of_child'); ?>" name="no_of_child"> -->
                                            <select class="form-control no_of_child" name="no_of_child">
                                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach(range(1,4) as $val){ ?>
                                                    <option <?php echo (set_value('no_of_child') == $val)?(' selected="selected"'):(''); ?> value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div><!--./form-group--> 
                                    </div> 
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('date'); ?></label>
                                            <input type="text" id="date" name="date" class="form-control date" value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="">
                                            <span id="date_add_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    
                                   

                                    <div class="col-sm-3 hide">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('next_follow_up_date'); ?></label>
                                            <input type="text" id="date_of_call" name="follow_up_date"class="form-control date" value="<?php echo set_value('follow_up_date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('assigned'); ?></label>
                                            <!-- <input type="text" value="<?php echo set_value('assigned'); ?>" name="assigned" class="form-control"> -->
                                            <select class="form-control" name="assigned">
                                                <?php 
                                                if($staffList && !empty($staffList)){
                                                foreach($staffList as $val){ ?>
                                                        <option value="<?php echo $val['id']; ?>"><?php echo $val['user_type']." >> ".$val['name']; ?></option>
                                                <?php } 
                                                }?>
                                            </select>
                                        </div><!--./form-group-->
                                    </div>  

                                    <!-- <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('class'); ?></label> 
                                            <select name="class" class="form-control"  >
                                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                                <?php
                                                foreach ($class_list as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>" <?php if (set_value('class') == $value['id']) { ?> selected="" <?php } ?>><?php echo $value['class'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>                                            
                                        </div>
                                    </div>   -->
                  

                                     
                                </div><!--./row--> 
                                <table class="table table-bordered table-hover">
                                   <thead>
                                    <tr>
                                            <th>Student Name</th>
                                            <th>Date Of Birth</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                        </tr>
                                   </thead>
                                   <tbody class="studentBody">
                                      <tr class="studentRow hide">
                                         <td>
                                            <input type="text" class="form-control" name="student_name[]">
                                         </td>
                                         <td>
                                            <input type="text" class="form-control date" name="date_of_birth[]">
                                         </td>
                                         <td>
                                            <!-- <input type="text" class="form-control" name="class[]"> -->
                                            <select class="form-control" name="class[]">
                                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach($classlist as $class){ ?>
                                                    <option value="<?php echo $class['class']; ?>"><?php echo $class['class']; ?></option>
                                                <?php } ?>
                                            </select>
                                         </td>
                                         <td>
                                            <input type="text" class="form-control" name="adhar_no[]">
                                         </td>
                                      </tr>
                                   </tbody>
                                </table>  
                            </form>                       
                        </div><!--./col-md-12-->       

                    </div><!--./row--> 
                    <div class="row">    
                        <div class="box-footer col-md-12">
                            <a  onclick="saveEnquiry()" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="box-title">Edit <?php echo $this->lang->line('admission_followup'); ?></h4>

                </div>
                <div class="modal-body pt0 pb0" id="getdetails">
                    <div id="alert_message">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="follow_up" tabindex="-1" role="dialog" aria-labelledby="follow_up">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" onclick="update()" data-dismiss="modal">&times;</button>
                    <h4 class="box-title"><?php echo $this->lang->line('admission_followup'); ?></h4>
                </div>
                <div class="modal-body pt0 pb0" id="getdetails_follow_up">
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$(document).ready(function() {
            $('#admission_no').keydown(function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault(); // Prevent the default form submission

                    let val = $(this).val();
                        $("#studentDetails").empty('');
                        if(val != ""){
                            $.ajax({
                                url: '<?php echo base_url(); ?>admin/visitors/get_student_record_id/' + val,
                                success: function (result) {
                                    if(result == 0){
                                        $(".view_btn").empty();
                                        $('.total_fee').text(0);
                                        $('.total_paid').text(0);
                                        $('.total_due').text(0);
                                        $("#hidden_student_id").remove();
                                        $("#hidden_admission_no").remove();
                                        alert("Admission # is not correct");
                                        $("#admission_no").val('');
                                    }else{
                                        let res = JSON.parse(result);
                                        let input_admission = '<input type="hidden" id="hidden_admission_no" name="admission_no" value="'+res.admission_no+'">';
                                        let input = '<input type="hidden" id="hidden_student_id" name="student_id" value="'+res.id+'">';
                                        $(".view_btn").empty();
                                        let btn = '<a target="_blank" href="<?php echo base_url('student/view/'); ?>'+res.id+'" class="btn btn-primary mt20">View Student</a>';
                                        $(".view_btn").html(btn);
                                        $('#admission_no').after(input);
                                        $('#admission_no').after(input_admission);
                                        $('#name_add').val(res.guardian_name);
                                        $('input[name="email"]').val(res.email);
                                        $('textarea[name="address"]').val(res.address);
                                        $('#number').val(res.guardian_phone);
                                        $(".no_of_child").val(1).change();
                                        $('input[name="student_name[]"]').eq(1).val(res.firstname+" "+res.lastname);
                                        $('input[name="date_of_birth[]"]').eq(1).val(res.dob);
                                        $('select[name="class[]"]').eq(1).val(res.class).change();
                                        $('input[name="adhar_no[]"]').eq(1).val(res.section);
                                        $('.total_fee').text(res.total_amount);
                                        $('.total_paid').text(res.newTotalFeePaid);
                                        $('.total_due').text(res.final);
                                    }
                                }
                            });
                        }
                }
            });
        });

    $(document).ready(function () {
    $(".no_of_child").on("change",function(){
        $(".studentRowAdded").remove();
        let no_of_child = $(this).val();
        for(let i = 0; i < no_of_child; i++){
            let clone = $(".studentRow").clone();
            clone = $(clone).addClass('studentRowAdded');
            clone = $(clone).removeClass('studentRow').removeClass('hide');
            clone = $(clone).addClass("studentRow"+i);
           $(".studentBody").append(clone);
           console.log(clone);
        }
    });


      moment.lang('en', {
          week: { dow: start_week }
        });
     $('#enquiry_date').daterangepicker(
        {
           
            locale: {
                    format: calendar_date_time_format
                }
        });
        // $('#enquiry_date').daterangepicker({
        //     separator: " TOOOO ",
        //     locale: {
        //         format: calendar_date_time_format
        //     }
        // });

        // $('#enquiry_date').on('apply.daterangepicker', function (ev, picker) {
        //     $(this).val(picker.startDate.format(calendar_date_time_format) + ' - ' + picker.endDate.format(calendar_date_time_format));
        // });

        // $('#enquiry_date').on('cancel.daterangepicker', function (ev, picker) {
        //     $(this).val('');
        // });
    });

    function getRecord(id, status) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/followup/details/' + id + '/' + status,
            success: function (result) {
                $('#getdetails').html(result);
            }
        });
    }
	
    function postRecord(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/followup/editpost/' + id,
            type: 'POST',
            data: $("#myForm1").serialize(),
            dataType: 'json',
            success: function (data) {

                if (data.status == "fail") {

                    var message = "";
                    $.each(data.error, function (index, value) {

                        message += value;
                    });
                    errorMsg(message);
                } else {

                    successMsg(data.message);
                    window.location.reload(true);
                }
            },
            error: function () {
                alert("Fail")
            }
        });

    }

    function saveEnquiry() {


        $.ajax({
            url: '<?php echo base_url(); ?>admin/followup/add/',
            type: 'POST',
            dataType: 'json',
            data: $("#formadd").serialize(),
            success: function (data) {
                if (data.status == "fail") {

                    var message = "";
                    $.each(data.error, function (index, value) {

                        message += value;
                    });
                    errorMsg(message);
                } else {

                    successMsg(data.message);
                    window.location.reload(true);
                }

            },
            error: function () {
                alert("Fail")
            }
        });


    }


    function delete_enquiry(id) {

        if (confirm('<?php echo $this->lang->line('delete_confirm') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/followup/delete/' + id,
                type: 'POST',
                dataType: 'json',

                success: function (data) {
                    if (data.status == "fail") {

                        var message = "";
                        $.each(data.error, function (index, value) {

                            message += value;
                        });
                        errorMsg(message);
                    } else {

                        successMsg(data.message);
                        window.location.reload(true);
                    }

                }
            })
        }
    }

    function follow_up(id, status) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/followup/follow_up/' + id + '/' + status,
            success: function (data) {
                $('#getdetails_follow_up').html(data);
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/followup/follow_up_list/' + id,
                    success: function (data) {
                        $('#timeline').html(data);
                    },
                    error: function () {
                        alert("Fail")
                    }
                });
            },
            error: function () {
                alert("Fail")
            }
        });
    }

    function update() {

        window.location.reload(true);
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#enquirytable").DataTable({
            searching: true,
            paging: true,
            bSort: true,
            info: false,
            dom: "Bfrtip",
            buttons: [

                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'Copy',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'CSV',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'PDF',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'

                    }
                },

                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    title: $('.download_label').html(),
                    customize: function (win) {
                        $(win.document.body)
                                .css('font-size', '10pt');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    titleAttr: 'Columns',
                    title: $('.download_label').html(),
                    postfixButtons: ['colvisRestore']
                },
            ]
        });
    });
</script>