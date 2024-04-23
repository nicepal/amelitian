<?php
//$response = $this->customlib->getResponse();
//$enquiry_type = $this->customlib->getenquiryType();
//$Source = $this->customlib->getComplaintSource();
//$Reference = $this->customlib->getReference();
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <!-- Horizontal Form -->
        <?php // print_r($enquiry_data); ?>
        <form  action="<?php echo site_url('admin/enquiry') ?>" id="myForm1"  method="post"  class="ptt10">
            <div class="row">
            
            <div class="col-sm-4">
                    <div class="form-group">
                        <label for="pwd">Type of Admission</label> 
                        <select name="adm_type" class="form-control"  >
                            <option value=""><?php echo $this->lang->line('select') ?></option>
                            <option value="Residential" <?php if ($enquiry_data['adm_type'] ==  "Residential") { ?> selected="" <?php } ?>>Residential</option>
                            <option value="Semi-residential" <?php if ($enquiry_data['adm_type'] ==  "Semi-residential") { ?> selected="" <?php } ?>>Semi-residential</option>

                        </select>                                      
                    </div><!--./form-group-->
                </div>   


            <div class="col-sm-4">
                    <div class="form-group">
                        <label for="pwd"><?php echo $this->lang->line('reference'); ?></label>   
                        <select name="reference" class="form-control">
                            <option value=""><?php echo $this->lang->line('select') ?></option>
                            <?php foreach ($Reference as $key => $value) { ?>
                                <option value="<?php echo $value['reference']; ?>" <?php if (set_value('reference', $enquiry_data['reference']) == $value['reference']) { ?>selected=""<?php } ?>><?php echo $value['reference']; ?></option>    
                            <?php }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('reference'); ?></span>
                    </div>
                </div>    
                <div class="col-sm-4">

                    <div class="form-group">
                        <label for="pwd"><?php echo $this->lang->line('source'); ?></label><small class="req"> *</small>
                        <select name="source" class="form-control">
                            <option value=""><?php echo $this->lang->line('select') ?></option>
                            <?php foreach ($source as $key => $value) { ?>
                                <option value="<?php echo $value['source']; ?>"<?php
                                if ($enquiry_data['source'] == $value['source']) {
                                    echo "selected";
                                }
                                ?>><?php echo $value['source']; ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                </div>      

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="pwd"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>  
                        <input type="text" class="form-control" id="name_value" value="<?php echo set_value('name', $enquiry_data['name']); ?>" name="name">
                        <span class="text-danger" id="name"></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="pwd"><?php echo $this->lang->line('phone'); ?></label><small class="req"> *</small>
                        <input id="number" name="contact" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact', $enquiry_data['contact']); ?>" />
                        <span class="text-danger"><?php echo form_error('contact'); ?></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('email'); ?></label>
                        <input type="text" value="<?php echo set_value('email', $enquiry_data['email']); ?>" name="email" class="form-control">
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="email"><?php echo $this->lang->line('address'); ?></label> 
                        <textarea name="address" class="form-control"><?php echo set_value('address', trim($enquiry_data['address'])) ?></textarea>
                        <span class="text-danger"><?php echo form_error('address'); ?></span>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="email"><?php echo $this->lang->line('description'); ?></label>
                        <textarea name="description" class="form-control" ><?php echo set_value('description', $enquiry_data['description']); ?></textarea>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="pwd"><?php echo $this->lang->line('note'); ?></label> 
                        <textarea name="note" class="form-control" ><?php echo set_value('note', $enquiry_data['note']); ?></textarea>

                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="pwd"><?php echo $this->lang->line('number_of_child'); ?></label>
                        <select class="form-control no_of_child1" name="no_of_child">
                            <option value=""><?php echo $this->lang->line('select') ?></option>
                            <?php foreach(range(1,4) as $val){ ?>
                                <option <?php echo (set_value('no_of_child', $enquiry_data['no_of_child']) == $val)?(' selected="selected"'):(''); ?> value="<?php echo $val; ?>"><?php echo $val; ?></option>
                            <?php } ?>
                        </select>
                    </div><!--./form-group--> 
                </div>  
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="pwd"><?php echo $this->lang->line('date'); ?></label>
                        <input type="text" id="date_edit" name="date" class="form-control date" value="<?php
                        if (!empty($enquiry_data['date'])) {
                            echo set_value('date', date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($enquiry_data['date'])));
                        }
                        ?>" readonly="">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="pwd"><?php echo $this->lang->line('next_follow_up_date'); ?></label>
                        <input type="text" id="date_of_call_edit" name="follow_up_date"class="form-control date" value="<?php
                        if (!empty($enquiry_data['follow_up_date'])) {
                            echo set_value('follow_up_date', date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($enquiry_data['follow_up_date'])));
                        }
                        ?>" readonly="">
                    </div>

                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('assigned'); ?></label>
                        <select class="form-control" name="assigned">
                            <?php 
                            if($staffList && !empty($staffList)){
                            foreach($staffList as $val){ ?>
                                    <option <?php echo (set_value('assigned',$enquiry_data['assigned']) == $val['id'])?(' selected="selected"'):(''); ?> value="<?php echo $val['id']; ?>"><?php echo $val['user_type']." >> ".$val['name']; ?></option>
                            <?php } 
                            }?>
                        </select>
                    </div><!--./form-group-->
                </div>


                       
                <table class="table table-bordered table-hover">
                <thead>
                <tr>
                        <th>Student Name</th>
                        <th>Date Of Birth</th>
                        <th>Class</th>
                        <th>Aadhar#</th>
                    </tr>
                </thead>
                <tbody class="studentBody1">
                    <tr class="studentRow1 hide">
                        <td>
                        <input type="text" class="form-control" name="student_name[]">
                        </td>
                        <td>
                        <input type="text" class="form-control" name="date_of_birth[]">
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
                  <?php if($enquiry_student){ 
                         foreach($enquiry_student as $key => $val){ ?>
                            <tr class="studentRow">
                                <td>
                                <input type="text" class="form-control" value="<?php echo $val['name']; ?>" name="student_name[]">
                                </td>
                                <td>
                                <input type="text" class="form-control" value="<?php echo $val['dob']; ?>" name="date_of_birth[]">
                                </td>
                                <td>
                                <!-- <input type="text" class="form-control" name="class[]"> -->
                                <select class="form-control" name="class[]">
                                    <option value=""><?php echo $this->lang->line('select') ?></option>
                                    <?php foreach($classlist as $class){ ?>
                                        <option <?php echo ($class['class'] == $val['class'])?(' selected="selected"'):(''); ?> value="<?php echo $class['class']; ?>"><?php echo $class['class']; ?></option>
                                    <?php } ?>
                                </select>
                                </td>
                                <td>
                                <input type="text" class="form-control"  value="<?php echo $val['adhar_no']; ?>" name="adhar_no[]">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>  

                <div class="row">    
                    <div class="box-footer col-md-12">

                        <a onclick="postRecord(<?php echo $enquiry_data['id'] ?>)" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></a>
                    </div>
                </div>  
            </div><!--./row--> 

           

        </form>
    </div><!--./col-md-12-->



</div><!--./row--> 

<script>

$(".no_of_child1").on("change",function(){
        $(".studentRowAdded1").remove();
        let no_of_child = $(this).val();
        for(let i = 0; i < no_of_child; i++){
            let clone = $(".studentRow1").clone();
            clone = $(clone).addClass('studentRowAdded1');
            clone = $(clone).removeClass('studentRow1').removeClass('hide');
            clone = $(clone).addClass("studentRow1"+i);
           $(".studentBody1").append(clone);
           console.log(clone);
        }
    });
</script>