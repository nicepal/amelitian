<span class="logo-lg" style="width: 300px;
    margin-bottom: 50px;
    margin: 50px auto;
    display: block;"><img src="<?php echo base_url(); ?>uploads/school_content/admin_logo/<?php $this->setting_model->getAdminlogo();?>" alt="<?php echo $this->customlib->getAppName() ?>" /></span>
   

<table class="table table-striped"> 
    <tr>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('student_name'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php print_r($data['student_fullnames']); ?></td>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('class'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('class'); ?> (<?php echo $this->lang->line('section'); ?>)</td>
    </tr> 
    <tr>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('guardian_name'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php print_r($data['guardian_name']); ?></td>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('guardian_phone'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php print_r($data['guardian_phone']); ?></td>
    </tr>  
    <tr>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('purpose'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php print_r($data['purpose']); ?></td>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('visitor_name'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php print_r($data['name']); ?></td>
    </tr>
    <tr>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('visitor_phone'); ?></th>
        <td style="width:24%;text-align: left;"><?php print_r($data['contact']); ?></td>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('number_of_person'); ?></th>
        <td style="width:24%;text-align: left;"><?php print_r($data['no_of_pepple']); ?></td>
    </tr>
    <tr>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('date'); ?></th>
        <td style="width:24%;text-align: left;"><?php print_r(date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($data['date']))); ?></td>
       
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('out_time'); ?></th>
        <td style="width:24%;text-align: left;"><?php print_r($data['out_time']); ?></td>
    </tr>
    <tr>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('return_date'); ?></th>
        <td style="width:24%;text-align: left;"><?php print_r(date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($data['return_date']))); ?></td>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('in_time'); ?></th>
        <td style="width:24%;text-align: left;"><?php print_r($data['in_time']); ?></td>
    </tr>
    <tr>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('id')." ".$this->lang->line('card'); ?></th>
        <td style="width:24%;text-align: left;"><?php echo $data['id_proof']; ?></td>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('note'); ?></th>
        <td style="width:24%;text-align: left;"><?php print_r($data['note']); ?></td>
    </tr>
    <tr>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('permission_by'); ?></th>
        <td style="width:24%;text-align: left;"><?php echo $data['permission_by']; ?></td>
        <th style="width:24%;text-align: left;"><?php echo $this->lang->line('slip_generated_by'); ?></th>
        <td style="width:24%;text-align: left;"><?php echo $data['staff_name'].' '.$data['staff_surname']; ?></td>
    </tr>
</table>
<?php if(is_file("./uploads/front_office/visitors/".$data['image'])){ ?>
        <img  style="width:100px;height:100px;margin: auto;display: block;" src="<?php echo base_url("/uploads/front_office/visitors/".$data['image']); ?>">
    <?php } ?>
<div class="row" style="    margin-right: -5px;
    margin-left: -5px;">
    <div class="col-md-4" style="width: 30%;float: left;position: relative;
    min-height: 1px;
    padding-right: 5px;
    padding-left: 5px;text-align: center;">
        <h4 style="border-top: solid 2px #000;margin-top:100px;">Visitor Signature</h4>
    </div>
    <div class="col-md-4" style="width: 30%;float: left;position: relative;
    min-height: 1px;
    padding-right: 5px;
    padding-left: 5px;text-align: center;">
        <h4 style="border-top: solid 2px #000;margin-top:100px;">Getting Person Signature</h4>
    </div>
    <div class="col-md-4" style="width: 30%;float: left;position: relative;
    min-height: 1px;
    padding-right: 5px;
    padding-left: 5px;text-align: center;">
        <?php if($data['purpose'] == 'To Meet Child within Campus' || $data['purpose'] == 'To Take Child Outside Campus'){ ?>
            <?php if($data['otp_status'] == 1) {?>
                <img  style="width:170px;height:100px;margin: auto;display: block;" src="<?php echo base_url("/uploads/verified.png"); ?>">
            <?php }else{ ?>
                <img  style="width:100px;height:100px;margin: auto;display: block;" src="<?php echo base_url("/uploads/not-approved.png"); ?>">
            <?php } ?>
            <h4 style="border-top: solid 2px #000;margin-top:0px;">OTP Verification</h4>
        <?php } ?>
    </div>
</div>

<a href="javascript:void(0);" style="display:block;margin:auto;" onclick="printDiv();" id="printPageButton" class="btn btn-primary">Print Receipt</a>
<script>
    function printDiv() 
{
    $("#printPageButton").remove();
  var divToPrint=document.getElementById('getdetails');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><title>Visitor Logs</title><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>