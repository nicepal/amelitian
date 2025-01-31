<div class="content-wrapper" style="min-height: 348px;">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>

.selected-profile{
    background-color:#eaeaea;
        cursor:pointer;
        border:solid 1px #999999;
}
    .hover-profile:hover{
        background-color:#eaeaea;
        cursor:pointer;
        border:solid 1px #999999;
    }
      #loader {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .windows8 {
	position: relative;
	width: 78px;
	height:78px;
	margin:auto;
}

.windows8 .wBall {
	position: absolute;
	width: 74px;
	height: 74px;
	opacity: 0;
	transform: rotate(225deg);
		-o-transform: rotate(225deg);
		-ms-transform: rotate(225deg);
		-webkit-transform: rotate(225deg);
		-moz-transform: rotate(225deg);
	animation: orbit 6.96s infinite;
		-o-animation: orbit 6.96s infinite;
		-ms-animation: orbit 6.96s infinite;
		-webkit-animation: orbit 6.96s infinite;
		-moz-animation: orbit 6.96s infinite;
}

.windows8 .wBall .wInnerBall{
	position: absolute;
	width: 10px;
	height: 10px;
	background: rgb(0,0,0);
	left:0px;
	top:0px;
	border-radius: 10px;
}

.windows8 #wBall_1 {
	animation-delay: 1.52s;
		-o-animation-delay: 1.52s;
		-ms-animation-delay: 1.52s;
		-webkit-animation-delay: 1.52s;
		-moz-animation-delay: 1.52s;
}

.windows8 #wBall_2 {
	animation-delay: 0.3s;
		-o-animation-delay: 0.3s;
		-ms-animation-delay: 0.3s;
		-webkit-animation-delay: 0.3s;
		-moz-animation-delay: 0.3s;
}

.windows8 #wBall_3 {
	animation-delay: 0.61s;
		-o-animation-delay: 0.61s;
		-ms-animation-delay: 0.61s;
		-webkit-animation-delay: 0.61s;
		-moz-animation-delay: 0.61s;
}

.windows8 #wBall_4 {
	animation-delay: 0.91s;
		-o-animation-delay: 0.91s;
		-ms-animation-delay: 0.91s;
		-webkit-animation-delay: 0.91s;
		-moz-animation-delay: 0.91s;
}

.windows8 #wBall_5 {
	animation-delay: 1.22s;
		-o-animation-delay: 1.22s;
		-ms-animation-delay: 1.22s;
		-webkit-animation-delay: 1.22s;
		-moz-animation-delay: 1.22s;
}



@keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		transform: rotate(180deg);
		animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		transform: rotate(300deg);
		animation-timing-function: linear;
		origin:0%;
	}

	30% {
		opacity: 1;
		transform:rotate(410deg);
		animation-timing-function: ease-in-out;
		origin:7%;
	}

	39% {
		opacity: 1;
		transform: rotate(645deg);
		animation-timing-function: linear;
		origin:30%;
	}

	70% {
		opacity: 1;
		transform: rotate(770deg);
		animation-timing-function: ease-out;
		origin:39%;
	}

	75% {
		opacity: 1;
		transform: rotate(900deg);
		animation-timing-function: ease-out;
		origin:70%;
	}

	76% {
	opacity: 0;
		transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		transform: rotate(900deg);
	}
}

@-o-keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		-o-transform: rotate(180deg);
		-o-animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		-o-transform: rotate(300deg);
		-o-animation-timing-function: linear;
		-o-origin:0%;
	}

	30% {
		opacity: 1;
		-o-transform:rotate(410deg);
		-o-animation-timing-function: ease-in-out;
		-o-origin:7%;
	}

	39% {
		opacity: 1;
		-o-transform: rotate(645deg);
		-o-animation-timing-function: linear;
		-o-origin:30%;
	}

	70% {
		opacity: 1;
		-o-transform: rotate(770deg);
		-o-animation-timing-function: ease-out;
		-o-origin:39%;
	}

	75% {
		opacity: 1;
		-o-transform: rotate(900deg);
		-o-animation-timing-function: ease-out;
		-o-origin:70%;
	}

	76% {
	opacity: 0;
		-o-transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		-o-transform: rotate(900deg);
	}
}

@-ms-keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		-ms-transform: rotate(180deg);
		-ms-animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		-ms-transform: rotate(300deg);
		-ms-animation-timing-function: linear;
		-ms-origin:0%;
	}

	30% {
		opacity: 1;
		-ms-transform:rotate(410deg);
		-ms-animation-timing-function: ease-in-out;
		-ms-origin:7%;
	}

	39% {
		opacity: 1;
		-ms-transform: rotate(645deg);
		-ms-animation-timing-function: linear;
		-ms-origin:30%;
	}

	70% {
		opacity: 1;
		-ms-transform: rotate(770deg);
		-ms-animation-timing-function: ease-out;
		-ms-origin:39%;
	}

	75% {
		opacity: 1;
		-ms-transform: rotate(900deg);
		-ms-animation-timing-function: ease-out;
		-ms-origin:70%;
	}

	76% {
	opacity: 0;
		-ms-transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		-ms-transform: rotate(900deg);
	}
}

@-webkit-keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		-webkit-transform: rotate(180deg);
		-webkit-animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		-webkit-transform: rotate(300deg);
		-webkit-animation-timing-function: linear;
		-webkit-origin:0%;
	}

	30% {
		opacity: 1;
		-webkit-transform:rotate(410deg);
		-webkit-animation-timing-function: ease-in-out;
		-webkit-origin:7%;
	}

	39% {
		opacity: 1;
		-webkit-transform: rotate(645deg);
		-webkit-animation-timing-function: linear;
		-webkit-origin:30%;
	}

	70% {
		opacity: 1;
		-webkit-transform: rotate(770deg);
		-webkit-animation-timing-function: ease-out;
		-webkit-origin:39%;
	}

	75% {
		opacity: 1;
		-webkit-transform: rotate(900deg);
		-webkit-animation-timing-function: ease-out;
		-webkit-origin:70%;
	}

	76% {
	opacity: 0;
		-webkit-transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		-webkit-transform: rotate(900deg);
	}
}

@-moz-keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		-moz-transform: rotate(180deg);
		-moz-animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		-moz-transform: rotate(300deg);
		-moz-animation-timing-function: linear;
		-moz-origin:0%;
	}

	30% {
		opacity: 1;
		-moz-transform:rotate(410deg);
		-moz-animation-timing-function: ease-in-out;
		-moz-origin:7%;
	}

	39% {
		opacity: 1;
		-moz-transform: rotate(645deg);
		-moz-animation-timing-function: linear;
		-moz-origin:30%;
	}

	70% {
		opacity: 1;
		-moz-transform: rotate(770deg);
		-moz-animation-timing-function: ease-out;
		-moz-origin:39%;
	}

	75% {
		opacity: 1;
		-moz-transform: rotate(900deg);
		-moz-animation-timing-function: ease-out;
		-moz-origin:70%;
	}

	76% {
	opacity: 0;
		-moz-transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		-moz-transform: rotate(900deg);
	}
}
        </style>
    <section class="content-header">
        <h1>
            <i class="fa fa-ioxhost"></i> <?php echo $this->lang->line('front_office'); ?></h1>
    </section>
    <section class="content">
        <div class="row">
            <?php if ($this->rbac->hasPrivilege('visitor_book', 'can_add')) {?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('visitor'); ?></h3>
                        </div><!-- /.box-header -->
                        <span id="studentDetails"></span>

                        <form id="form1" action="<?php echo site_url('admin/visitors') ?>"   method="post" accept-charset="utf-8" enctype="multipart/form-data" >
                            <div class="box-body">
                                <?php echo $this->session->flashdata('msg') ?>

                                <div class="form-group col-md-12">
                                    <label for="pwd">Search By Roll Number</label>  <small class="req"> *</small>
                                    <input type="text" placeholder="Search By Phone Number, Enroll Number, National Id, Local Id Etc." class="form-control admission_no" id="admission_no" value="<?php echo set_value('admission_no'); ?>" name="admission_no_search">
                                    <span class="text-danger"><?php echo form_error('admission_no'); ?></span>
                                    <small class="text-danger"><strong>Note:</strong> Press enter to get student record</small>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('purpose'); ?></label><small class="req"> *</small>

                                    <select name="purpose" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?> </option>
                                        <?php foreach ($Purpose as $key => $value) {?>

                                            <option value="<?php print_r($value['visitors_purpose']);?>"<?php if (set_value('purpose') == $value['visitors_purpose']) {?>selected=""<?php }?>><?php print_r($value['visitors_purpose']);?></option>
                                        <?php }?>

                                    </select>
                                    <span class="text-danger"><?php echo form_error('purpose'); ?></span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="outing_reason"><?php echo $this->lang->line('outing_reason'); ?></label><small class="req"> *</small>

                                    <select name="outing_reason" id="outing_reason" class="form-control">
                                        <option value="-"><?php echo $this->lang->line('select'); ?> </option>
                                        <option value="Holidays">Holidays</option>
                                        <option value="Health issue">Health issue</option>
                                        <option value="Home opening">Home opening</option>
                                        <option value="Marriage">Marriage</option>
                                        <option value="Birthday">Birthday</option>
                                        <option value="Other">Other</option>

                                    </select>
                                    <span class="text-danger"><?php echo form_error('outing_reason'); ?></span>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('name'); ?></label>  <small class="req"> *</small>
                                        <input type="text" class="form-control" value="<?php echo set_value('name'); ?>" name="name">
                                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                        <input type="text" class="form-control" value="<?php echo set_value('contact'); ?>" name="contact">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="pwd"><?php echo $this->lang->line('icard'); ?></label>
                                    <input type="text" class="form-control" value="<?php echo set_value('id_proof'); ?>" name="id_proof">

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email"><?php echo $this->lang->line('number_of_person'); ?></label>
                                        <input type="text" class="form-control" value="<?php echo set_value('pepples'); ?>" name="pepples">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="permission_by"><?php echo $this->lang->line('permission_by'); ?></label><small class="req"> *</small>

                                        <select name="permission_by" id="permission_by" class="form-control">
                                            <option value="-"><?php echo $this->lang->line('select'); ?> </option>
                                            <option value="Principal">Principal</option>
                                            <option value="Sameera madam">Sameera madam</option>
                                            <option value="Bharat sir">Bharat sir</option>
                                            <option value="Venkatesh sir">Venkatesh sir</option>
                                            <option value="Mangament">Mangament</option>

                                        </select>
                                        <span class="text-danger"><?php echo form_error('outing_reason'); ?></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('date'); ?></label><input type="text" id="date" class="form-control date" value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>"  name="date" readonly="">
                                            <span class="text-danger"><?php echo form_error('date'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('out_time'); ?></label>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="out_time" class="form-control timepicker" id="stime_" value="<?php echo set_value('out_time'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('out_time'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="return_date"><?php echo $this->lang->line('return_date'); ?></label><input type="text" id="return_date" class="form-control date" value="<?php echo set_value('return_date', date($this->customlib->getSchoolDateFormat())); ?>"  name="return_date" readonly="">
                                            <span class="text-danger"><?php echo form_error('return_date'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('in_time'); ?></label>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="time" class="form-control timepicker" id="stime_" value="<?php echo set_value('time'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('time'); ?></span>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <label for="pwd"><?php echo $this->lang->line('note'); ?></label>
                                    <textarea class="form-control" id="description" name="note" name="note" rows="3"><?php echo set_value('note'); ?></textarea>
                                    <span class="text-danger"><?php echo form_error('note'); ?></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('attach_document'); ?></label>
                                    <div><input class="filestyle form-control" type='file' name='file'  />
                                    </div>
                                    <span class="text-danger"><?php echo form_error('file'); ?></span></div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                            <!-- <div ></div> -->
                            
                            <span class="text-danger"><?php echo form_error('g-recaptcha-response'); ?></span>

                                <button type="submit" class="btn btn-info pull-right g-recaptcha" data-sitekey="6LccTG8pAAAAAGLh7FJSpcH4_o4HG4OR1C8vx4bX" data-callback='onSubmit' 
        data-action='submit'><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div><!--/.col (right) -->
                <!-- left column -->
            <?php }?>

            <div class="col-md-<?php
if ($this->rbac->hasPrivilege('visitor_book', 'can_add')) {
    echo "8";
} else {
    echo "12";
}
?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('visitor'); ?> <?php echo $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="loader">
                            <div class="windows8">
                                <div class="wBall" id="wBall_1">
                                    <div class="wInnerBall"></div>
                                </div>
                                <div class="wBall" id="wBall_2">
                                    <div class="wInnerBall"></div>
                                </div>
                                <div class="wBall" id="wBall_3">
                                    <div class="wInnerBall"></div>
                                </div>
                                <div class="wBall" id="wBall_4">
                                    <div class="wInnerBall"></div>
                                </div>
                                <div class="wBall" id="wBall_5">
                                    <div class="wInnerBall"></div>
                                </div>
                            </div>
                        </div>
                        <div class="download_label"><?php echo $this->lang->line('visitor'); ?> <?php echo $this->lang->line('list'); ?></div>
                        <div class="mailbox-messages table-responsive">
                            <table class="table table-hover table-striped table-bordered example" id="visitorTable">
                                <thead>
                                    
                                    <tr>
                                        <th><?php echo $this->lang->line('purpose'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('in_time'); ?></th>
                                        <th><?php echo $this->lang->line('out_time'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($visitor_list)) { ?>

                                        <?php } else { 
                                            foreach ($visitor_list as $key => $value) {  ?>
                                            <tr>
                                                <td class="mailbox-name"><?php echo $value['purpose']; ?></td>
                                                <td class="mailbox-name"><?php echo $value['name']; ?></td>
                                                <td class="mailbox-name"><?php echo $value['contact']; ?> </td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date'])); ?></td>
                                                <td class="mailbox-name"> <?php echo $value['in_time']; ?></td>
                                                <td class="mailbox-name"> <?php echo $value['out_time']; ?></td>
                                                <td class="mailbox-date pull-right">
                                                    <a data-placement="left" onclick="getRecord(<?php echo $value['id']; ?>)" class="btn btn-default btn-xs" data-target="#visitordetails" data-toggle="modal"  title="<?php echo $this->lang->line('view'); ?>"><i class="fa fa-reorder"></i></a>
                                                    <?php if ($value['image'] !== "") {?>
                                                        <a data-placement="left" href="<?php echo base_url(); ?>admin/visitors/download/<?php echo $value['image']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('download'); ?>">
                                                            <i class="fa fa-download"></i>
                                                        </a>  
                                                    <?php }?>
                                                    <?php if ($this->rbac->hasPrivilege('visitor_book', 'can_edit')) {?>
                                                        <a data-placement="left" href="<?php echo base_url(); ?>admin/visitors/edit/<?php echo $value['id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php }
        ?>

                                                    <?php if ($this->rbac->hasPrivilege('visitor_book', 'can_delete')) { ?>
                                                        <?php if ($value['image'] !== "") {?><a data-placement="left" href="<?php echo base_url(); ?>admin/visitors/imagedelete/<?php echo $value['id']; ?>/<?php echo $value['image']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                        <?php } else {?>
                                                            <a data-placement="left" href="<?php echo base_url(); ?>admin/visitors/delete/<?php echo $value['id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                    <?php
                                                            }
                                                        }
                                                        ?>
                                        <?php  if($value['purpose'] == "To Meet Child within Campus" || $value['purpose'] == "To Take Child Outside Campus"){ ?>
                                            <?php 
                                                
                                                if($value['otp_status'] == 0){ ?>
                                                <a onClick="verifyOtp(<?php echo $value['id']; ?>);" data-target="#otp" data-toggle="modal">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                                </td>

                                            </tr>
                                            <?php
}
                                            } ?>

                                </tbody>
                            </table><!-- /.table -->
                            <div id="pagination">
                                <!-- Pagination links will be inserted here -->
                                <?php //echo $pagination_links; ?>
                            </div>
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) col-8 end-->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- new END -->
<div id="visitordetails" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('details'); ?></h4>
            </div>
     
            <div class="modal-body" id="getdetails">
 
            </div>
        </div>
    </div>
</div>

<div id="otp" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog2">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('otp'); ?></h4>
            </div>
     
            <div class="modal-body" id="otpDetails">
 
            </div>
        </div>
    </div>
</div>
</div><!-- /.content-wrapper -->
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script type="text/javascript">

        $(function () {

            $(document).on("click", ".hover-profile", function() {
                if ($("#d_guardian_phone").length) {
                    $("#d_guardian_phone").remove();
                }

                if ($("#d_admission_no").length) {
                    $("#d_admission_no").remove();
                }
                $(".hover-profile").each(function() {
                    $(this).removeClass("selected-profile");
                });
                let admission_input = '<input type="hidden" name="admission_no" id="d_admission_no" value="'+$(this).find('#admission_no').val()+'">';
                let guardian_phone = '<input type="hidden" name="guardian_phone" id="d_guardian_phone" value="'+$(this).find('#guardian_phone').val()+'">';
                
                $('#form1').after(admission_input);
                $('#form1').after(guardian_phone);

                $(this).addClass("selected-profile");
                $('html, body').animate({
                    scrollTop: $('#form1').offset().top
                }, 1000);
         

            });

            $(".timepicker").timepicker({});
        });

        function getRecord(id) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/visitors/details/' + id,
                success: function (result) {

                    $('#getdetails').html(result);
                }

            });
        }

        function verifyOtp(id) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/visitors/verifyOtp/' + id,
                success: function (result) {

                    $('#otpDetails').html(result);
                }

            });
        }

        // $("#admission_no").on("blur",function(){
        //     let val = $(this).val();
        //     $("#studentDetails").empty('');
        //     if(val != ""){
        //         $.ajax({
        //             url: '<?php echo base_url(); ?>admin/visitors/get_student_record/' + val,
        //             success: function (result) {
        //                 if(result == 0){
        //                     alert("Admission # is not correct");
        //                     $("#admission_no").val('');
        //                 }else{
        //                     $('#studentDetails').html(result);
        //                 }
        //             }
        //         });
        //     }
        // });

        $(document).ready(function() {
            $('#admission_no').keydown(function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault(); // Prevent the default form submission

                    let val = $(this).val();
                        $("#studentDetails").empty('');
                        if(val != ""){
                            $.ajax({
                                url: '<?php echo base_url(); ?>admin/visitors/get_student_record/' + val,
                                success: function (result) {
                                    if(result == 0){
                                        alert("Admission # is not correct");
                                        $("#admission_no").val('');
                                    }else{
                                        $('#studentDetails').html(result);
                                    }
                                }
                            });
                        }
                }
            });
        });


</script>

<script>
   function onSubmit(token) {
     document.getElementById("form1").submit();
   }

   $(document).ready(function() {

    

    // if (!$.fn.dataTable.isDataTable('#visitorTable')) {

        // $('#visitorTable').DataTable().destroy(); // Destroy the existing instance

        
        $('#visitorTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('admin/visitors/ajax_fetch'); ?>",
                "type": "POST"
            },
            "columns": [
                { "data": "purpose" },
                { "data": "name" },
                { "data": "contact" },
                { "data": "date" },
                { "data": "in_time" },
                { "data": "out_time" },
                {
                "data": null, // Use null to pass the entire row data
                "render": function (data, type, row) {
                    // Your logic to determine the action button
                    if (row.purpose === "To Meet Child within Campus" || row.purpose === "To Take Child Outside Campus") {
                        if (row.otp_status === "0") {
                            return `<a onClick="verifyOtp(${row.id});" data-target="#otp" data-toggle="modal">
                                        <i class="fa fa-envelope"></i>
                                    </a>
                                    <a  data-placement="left" onclick="getRecord(${row.id})" class="btn btn-default btn-xs" data-target="#visitordetails" data-toggle="modal"  title="View Record"><i class="fa fa-reorder"></i></a> 
`;
                        }
                        if (row.otp_status === "1") {
                            return `<i class="fa fa-check"></i>`;
                        }
                    }
                    return ''; // Return empty string if no button should be displayed
                }
            }
                // Add more columns as needed
            ],
            "pagingType": "full_numbers", // You can customize pagination type here
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "No records found",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "Showing 0 to 0 of 0 records",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                "search": "Search:"
            }
        });
 


    
});
 </script>
