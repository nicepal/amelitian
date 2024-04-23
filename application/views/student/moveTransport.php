<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<style type="text/css">
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>

<div class="content-wrapper">  
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('student_information'); ?> <small><?php echo $this->lang->line('student1'); ?></small></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">
                        
                        <?php if ($this->session->flashdata('msg')) { ?> <div class="alert alert-success"> <?php echo $this->session->flashdata('msg') ?> </div> <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('student/move_transport') ?>" method="post" class="">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-sm-4">
                                            <div class="form-group"> 
                                                <label><?php echo $this->lang->line('class'); ?></label> <small class="req"> *</small> 
                                                <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    $count = 0;
                                                    foreach ($classlist as $class) {
                                                        ?>
                                                        <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                        <?php
                                                        $count++;
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                            </div>  
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('section'); ?></label>
                                                <select  id="section_id" name="section_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                            </div>   
                                        </div>

                                        <div class="col-md-4">
                                        <div class="form-group">
                                                        <label for="exampleInputEmail1">
        <?php echo $this->lang->line('route_list'); ?>
                                                        </label>
                                                        <select class="form-control" name="vehroute_id" id="vehroute_id">


                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                                <?php
                                                                foreach ($vehroutelist as $vehroute) {
                                                                    ?>
                                                                <optgroup label=" <?php echo $vehroute->route_title; ?>">
                                                                    <?php
                                                                    $vehicles = $vehroute->vehicles;
                                                                    if (!empty($vehicles)) {
                                                                        foreach ($vehicles as $key => $value) {

                                                                            $st = set_value('vehroute_id', $student['vehroute_id']) == $value->vec_route_id ? true : false;
                                                                            ?>

                                                                            <option value="<?php echo $value->vec_route_id ?>" <?php echo set_select('vehroute_id', $value->vec_route_id, $st); ?> data-fee="<?php echo $vehroute->fare; ?>">
                                                                            <?php echo $value->vehicle_no ?>
                                                                            </option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                </optgroup>
            <?php
        }
        ?>
                                                        </select>
                                                        <span class="text-danger"><?php echo form_error('vehroute_id'); ?></span>
                                                    </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_filter" class="search_filter btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </form>    
                                </div>  
                                
                            </div><!--./col-md-6-->
                            <div class="col-md-6">
                                <div class="row">
                                    <!-- <form role="form" action="<?php echo site_url('student/move_transport') ?>" method="post" class=""> -->
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-sm-6 col-md-offset-6">
                                        <div class="form-group">
                                                        <label for="exampleInputEmail1">
        <?php echo $this->lang->line('route_list'); ?>
                                                        </label>
                                                        <select class="form-control" name="vehroute_id2" id="vehroute_id2">


                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                                <?php
                                                                foreach ($vehroutelist as $vehroute) {
                                                                    ?>
                                                                <optgroup label=" <?php echo $vehroute->route_title; ?>">
                                                                    <?php
                                                                    $vehicles = $vehroute->vehicles;
                                                                    if (!empty($vehicles)) {
                                                                        foreach ($vehicles as $key => $value) {

                                                                            $st = set_value('vehroute_id2', $student['vehroute_id']) == $value->vec_route_id ? true : false;
                                                                            ?>

                                                                            <option value="<?php echo $value->vec_route_id ?>" <?php echo set_select('vehroute_id2', $value->vec_route_id, $st); ?> data-fee="<?php echo $vehroute->fare; ?>">
                                                                            <?php echo $value->vehicle_no ?>
                                                                            </option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                </optgroup>
            <?php
        }
        ?>
                                                        </select>
                                                        <span class="text-danger"><?php echo form_error('vehroute_id2'); ?></span>
                                                    </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="button" name="search" value="search_full" class="move_submit btn btn-primary pull-right btn-sm checkbox-toggle"> Move</button>
                                            </div>
                                        </div>
                                    <!-- </form> -->
                                </div>
                           </div><!--./col-md-6-->
                        </div><!--./row-->
                    </div>
                
                <?php
                if (isset($resultlist)) {
                    ?>
                    <div class="nav-tabs-custom border0 navnoshadow">
                      <div class="box-header ptbnull"></div>  
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i> <?php echo $this->lang->line('list'); ?>  <?php echo $this->lang->line('view'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="download_label"><?php echo $title; ?></div>
                            <div class="tab-pane active table-responsive no-padding" id="tab_1">
                                <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label>
                                                    <input type="checkbox" class="select_all_students">
                                                    Select All
                                                </label>
                                            </th>
                                            <th><?php echo $this->lang->line('admission_no'); ?></th>
									
                                            <th><?php echo $this->lang->line('student_name'); ?></th>
                                            <th><?php echo $this->lang->line('class'); ?></th>
											 <?php if ($sch_setting->father_name) {  ?>
                                            <th><?php echo $this->lang->line('father_name'); ?></th>
                                            <?php } ?>
                                            <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                            <th><?php echo $this->lang->line('gender'); ?></th>
											<?php if ($sch_setting->category) {
                                              ?>
                                              <?php if ($sch_setting->category) {  ?>
                                            <th><?php echo $this->lang->line('category'); ?></th>
											<?php }
                                             } if ($sch_setting->mobile_no) {
                                               ?>
                                            <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                            <?php 
                                        }
                                            if (!empty($fields)) {

                                                foreach ($fields as $fields_key => $fields_value) {
                                                    ?>
                                                    <th><?php echo $fields_value->name; ?></th>
                                                    <?php
                                                } 
                                            }
                                            ?>

                                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <script>
                                        $(document).on("click",".move_submit",function(){
                                            let counter = 0;
                                            let ids= '';
                                            $(".student_id_checkbox").each(function(){
                                                if($(this).is(":checked") == true){
                                                    ids += $(this).val()+',';
                                                    counter++;
                                                }
                                            });
                                            if(counter == 0){
                                                alert("Kindly select atleast one record!");
                                                return false;
                                            }else{
                                                let vehroute_id2 = $("#vehroute_id2 option:selected").val();
                                                // let class_id = $("#class_id option:selected").val();
                                                // let new_section = $("#move_to_section option:selected").val();
                                                $.ajax({
                                                    url:"<?php echo site_url('student/submit_move_transport') ?>",
                                                    type:"POST",
                                                    data:{vehroute_id:vehroute_id2,ids:ids},
                                                    success:function(){
                                                        $(".search_filter").trigger("click");
                                                    }

                                                })
                                            }
                                        });
                                        $(document).on("click",".select_all_students",function(){
                                            if($(this).is(":checked") == true){
                                                $(".student_id_checkbox").each(function(){
                                                    $(this).prop("checked",true);
                                                });
                                            }else{
                                                $(".student_id_checkbox").each(function(){
                                                    $(this).prop("checked",false);
                                                });
                                            }
                                        });
                                    </script>
                                    <tbody>
                                        <?php
                                        if (empty($resultlist)) {
                                             ?>
                                                             
                                            <?php
                                        } else {
                                            $count = 1;
                                            foreach ($resultlist as $student) {
                                                ?>
                                                <tr>
                                                    <td>
                                                    <label>
                                                        <input type="checkbox" name="student_id[]" class="student_id_checkbox" value="<?php echo $student['id']; ?>">
                                                        <?php //echo $student['admission_no']; ?>
                                                    </label>
                                                    </td>
                                                    <td>

                                                        <?php echo $student['admission_no']; ?>
                                                </td>
											
                                                    <td> 
                                                        
                                                        <a href="<?php echo base_url(); ?>student/view/<?php echo $student['id']; ?>"><?php echo $this->customlib->getFullName($student['firstname'],$student['middlename'],$student['lastname'],$sch_setting->middlename,$sch_setting->lastname); ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $student['class'] . "(" . $student['section'] . ")" ?></td>
                                                    <?php if ($sch_setting->father_name) {  ?>
													<td><?php echo $student['father_name']; ?></td>
													<?php }?>
                                                    <td><?php
                                                        if ($student["dob"] != null && $student["dob"]!='0000-00-00') {
                                                            echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob']));
                                                        }
                                                        ?></td>
                                                    <td><?php echo $student['gender']; ?></td>
													<?php if ($sch_setting->category) {  ?>
                                                    <td><?php echo $student['category']; ?></td>
													<?php } if ($sch_setting->mobile_no) {  ?>
                                                    <td><?php echo $student['mobileno']; ?></td>
                                                    <?php }
                                                    if (!empty($fields)) {

                                                        foreach ($fields as $fields_key => $fields_value) {
                                                              $display_field=$student[$fields_value->name];
                                                      if($fields_value->type == "link"){
  $display_field= "<a href=".$student[$fields_value->name]." target='_blank'>".$student[$fields_value->name]."</a>";

  }
                                                            ?>
                                                            <td>
                                                                <?php echo $display_field; ?>
                                                                    
                                                                </td>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                    <td class="pull-right">
                                                        <a target="_blank" href="<?php echo base_url(); ?>student/view/<?php echo $student['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" >
                                                            <i class="fa fa-reorder"></i>
                                                        </a>
                                                       
                                                    </td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>                           
                                                                                 
                                                            </div>                                                         
                                                            </div>
                                                          </div><!--./box box-primary -->   
                                                            <?php
                                                        }
                                                        ?>
                                                        </div>  
                                                        </div> 
                                                        </section>
                                                        </div>
                                                        <script type="text/javascript">

                                                           
                                                            function getSectionByClass(class_id, section_id) {
                                                                if (class_id != "" && section_id != "") {
                                                                    $('#section_id').html("");
                                                                    $("#move_to_section").html("");
                                                                    var base_url = '<?php echo base_url() ?>';
                                                                    var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                                                                    $.ajax({
                                                                        type: "GET",
                                                                        url: base_url + "sections/getByClass",
                                                                        data: {'class_id': class_id},
                                                                        dataType: "json",
                                                                        success: function (data) {
                                                                            $.each(data, function (i, obj)
                                                                            {
                                                                                var sel = "";
                                                                                if (section_id == obj.section_id) {
                                                                                    sel = "selected";
                                                                                }
                                                                                div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                                                                            });
                                                                            $('#section_id').append(div_data);
                                                                            $("#move_to_section").append(div_data);
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                            $(document).ready(function () {
                                                                var class_id = $('#class_id').val();
                                                                var section_id = '<?php echo set_value('section_id') ?>';
                                                                getSectionByClass(class_id, section_id);
                                                                $(document).on('change', '#class_id', function (e) {
                                                                    $('#section_id').html("");
                                                                    $("#move_to_section").html("");

                                                                    var class_id = $(this).val();
                                                                    var base_url = '<?php echo base_url() ?>';
                                                                    var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                                                                    $.ajax({
                                                                        type: "GET",
                                                                        url: base_url + "sections/getByClass",
                                                                        data: {'class_id': class_id},
                                                                        dataType: "json",
                                                                        success: function (data) {
                                                                            $.each(data, function (i, obj)
                                                                            {
                                                                                div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                                                                            });
                                                                            $('#section_id').append(div_data);
                                                                            $("#move_to_section").append(div_data);

                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>