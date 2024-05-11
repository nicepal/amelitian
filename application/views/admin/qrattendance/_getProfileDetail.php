<?php
if($status){
?>
<form action="<?php echo site_url('admin/qrattendance/saveAttendance'); ?>" method="POST" id="add_attendance">
  <input type="hidden" name="prev_attendance" value="<?php echo $student->attendance_id; ?>" id="prev_attendance">

  <?php
  
  if ($profile_type == "student") {
  ?>
    <input type="hidden" name="attendance_for" value="student">
    <input type="hidden" name="record_id" value="<?php echo $student->employee_id; ?>">
    <h4 class="text text-primary text-center qrtitle"><?php echo $this->lang->line('student'); ?></h4>
    <div class="row gutters-sm">
      <div class="col-md-12 mb-3">
        <div class="card shadow-none">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <?php
              if (!empty($student->student_image)) {
               $image_url = $this->media_storage->getImageURL($student->student_image);
              } else {

                if ($student->gender == 'Female') {
                  $image_url = $this->media_storage->getImageURL("uploads/student_images/default_female.jpg");
                } else {
                  $image_url = $this->media_storage->getImageURL("uploads/student_images/default_male.jpg");
                }
                
              }
              ?>
              <img src="<?php echo $image_url; ?>" alt="<?php echo $this->customlib->getFullName($student->name, $student->middlename, $student->surname, $sch_setting->middlename, $sch_setting->lastname); ?>" class="rounded-circle" width="150">
              <div class="mt-3">
                <h3><?php echo $this->customlib->getFullName($student->name, $student->middlename, $student->surname, $sch_setting->middlename, $sch_setting->lastname); ?> (<?php echo $student->admission_no; ?>)</h3>
                
                <p class="text-muted font-size-sm"><?php echo $student->class . " (" . $student->section . ")" ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
 
    </div>
    <div class="row">
      <?php
      if (($student->attendance_id) <= 0) {

        if (!$setting->auto_attendance) {
      ?>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="input-type"><?php echo $this->lang->line('mark_attendance_as'); ?></label>
                  <div id="input-type" class="row">
                    <?php
                    foreach ($attendencetypeslist as $attendance_key => $attendance_value) {
                    ?>
                      <div class="col-sm-4">
                        <label class="radio-inline radio-sm-block">
                          <input name="attendance_type" class="attendance " id="attendance<?php echo $attendance_value['id'] ?>" value="<?php echo $attendance_value['id'] ?>" type="radio" autocomplete="off" <?php echo ($attendance_value['id'] == "1") ? "checked='checked'" : "" ?>>
                          <b class="vertical-middle"><?php echo $this->lang->line(strtolower($attendance_value['type'])) ; ?></b> </label>
                      </div>
                    <?php
                    }
                    ?>

                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <button class="btn btn-sm btn-info add_attendance" type="submit" data-attendance_for="student" data-record_id="<?php echo $student->employee_id; ?>" title="<?php echo $this->lang->line('save'); ?>" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('submit_attendance') ?>"> <?php echo $this->lang->line('submit_attendance') ?></button>
              </div>
            </div>
          </div>
        <?php
        }
      } else {
        ?>
        <div class="alert alert-info">
          <?php echo $this->lang->line(strtolower($student->long_lang_name)); ?> : <?php echo $this->lang->line('attendance_has_been_already_submitted') ?>  
        </div>
      <?php
      }
      ?>
    </div>
  <?php
  } else {
  ?>
    <input type="hidden" name="attendance_for" value="staff">
    <input type="hidden" name="record_id" value="<?php echo $student->employee_id; ?>">
    <h4 class="text text-primary text-center qrtitle"><?php echo $this->lang->line('staff'); ?></h4>
    <div class="row gutters-sm">
      <div class="col-md-12 mb-3">
        <div class="card shadow-none">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">            
            <?php
          
              if (!empty($student->student_image)) {
               $image_url = $this->media_storage->getImageURL("uploads/staff_images/" .$student->student_image);
              } else {

                if ($student->gender == 'Female') {
                  $image_url = $this->media_storage->getImageURL("uploads/staff_images/default_female.jpg");
                } else {
                  $image_url = $this->media_storage->getImageURL("uploads/staff_images/default_male.jpg");
                }
              }
              ?>
              <img src="<?php echo $image_url; ?>" alt="<?php echo $student->name . " " . $student->surname; ?>" class="rounded-circle" width="150">
              <div class="mt-3">
                <h3><?php echo $student->name . " " . $student->surname; ?> (<?php echo $student->employee_id; ?>)</h3>
                
                <p class="text-muted font-size-sm"><?php echo $student->role; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
 
    </div>
    <div class="row">

      <?php
      if (($student->attendance_id) <= 0) {
        if (!$setting->auto_attendance) {
      ?>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="input-type"><?php echo $this->lang->line('mark_attendance_as'); ?></label>
                  <div id="input-type" class="row">
                    <?php
                    foreach ($attendencetypeslist as $attendance_key => $attendance_value) {
                    ?>
                      <div class="col-sm-4">
                        <label class="radio-inline">
                          <input name="attendance_type" class="attendance" id="attendance<?php echo $attendance_value['id'] ?>" value="<?php echo $attendance_value['id'] ?>" type="radio" autocomplete="off" <?php echo ($attendance_value['id'] == "1") ? "checked='checked'" : "" ?>>
                          <?php echo $this->lang->line(strtolower($attendance_value['type'])) ; ?> </label>
                      </div>
                    <?php
                    }
                    ?>

                  </div>
                </div>
              </div>
              <div class="col-md-12">

                <button class="btn btn-sm btn-info add_attendance" type="submit" data-attendance_for="staff" data-record_id="<?php echo $student->employee_id; ?>" title="<?php echo $this->lang->line('save'); ?>" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('submit_attendance') ?>"> <?php echo $this->lang->line('submit_attendance') ?></button>
                
              </div>

            </div>
          </div>
        <?php
        }
      } else {
        ?>
        <div class="alert alert-info">
          <?php echo $this->lang->line(strtolower($student->long_lang_name)) ; ?> : <?php echo $this->lang->line('attendance_has_been_already_submitted') ?>
        </div>
      <?php
      }

      ?>
    </div>
  <?php

  }
  ?>

</form>
<?php 
}else{
  ?>
  <div class="alert alert-danger">
      <?php echo $this->lang->line('invalid_qr_code_barcode_please_try_again_or_contact_to_admin') ?>
  </div>
  <?php

}

?>
