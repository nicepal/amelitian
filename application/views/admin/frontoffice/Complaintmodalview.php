<table class="table table-striped">
    <?php // print_r($complaint_data); ?>
    <tr>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('student_name'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php print_r($complaint_data['firstname']); ?> <?php print_r($data['lastname']); ?></td>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('class'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php echo $complaint_data['class']; ?> (<?php echo $complaint_data['section']; ?>)</td>
    </tr> 
    <tr>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('guardian_name'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php print_r($complaint_data['guardian_name']); ?></td>
        <th style="width:24%;text-align: left;" class="border0"><?php echo $this->lang->line('guardian_phone'); ?></th>
        <td style="width:24%;text-align: left;" class="border0"><?php print_r($complaint_data['guardian_phone']); ?></td>
    </tr>  
    <tr>
        <th class="border0"><?php echo $this->lang->line('complain'); ?> #</th>
        <td class="border0"><?php print_r($complaint_data['id']); ?></td>
        <th class="border0"><?php echo $this->lang->line('complain_type'); ?></th>
        <td class="border0"><?php print_r($complaint_data['complaint_type']); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('source'); ?></th>
        <td><?php print_r($complaint_data['source']); ?></td>
        <th><?php echo $this->lang->line('name'); ?></th>
        <td><?php print_r($complaint_data['name']); ?></td>
    </tr>

    <tr>
        <th><?php echo $this->lang->line('phone'); ?></th>
        <td><?php print_r($complaint_data['contact']); ?></td>
        <th><?php echo $this->lang->line('date'); ?></th>
        <td><?php print_r(date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($complaint_data['date']))); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('description'); ?></th>
        <td><?php print_r($complaint_data['description']); ?></td>
        <th><?php echo $this->lang->line('action_taken'); ?></th>
        <td><?php print_r($complaint_data['action_taken']); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('assigned'); ?></th>
        <td><?php print_r($complaint_data['name'].' '.$complaint_data['surname']); ?></td>
        <th><?php echo $this->lang->line('note'); ?></th>
        <td><?php print_r($complaint_data['note']); ?></td>
    </tr>
</tbody>
</table>