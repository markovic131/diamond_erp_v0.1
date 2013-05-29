<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open('tasks/edit/'. $task['0']->id);?>
<tr>
    <td class="label"><?php echo form_label('Task Name: ');?></td>
    <td><?php echo form_input('taskname', set_value('taskname', $task['0']-> taskname ));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Base Unit: ');?></td>
    <td><?php echo form_input('base_unit', set_value('base_unit', $task['0']-> base_unit ));?></td>
  </tr>
<tr>
    <td class="label"><?php echo form_label('UOM: ');?></td>
    <td><?php echo form_dropdown('uname_fk',$uoms, set_value('uname_fk', $task['0']-> uname_fk ));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Unit Rate: ');?></td>
    <td><?php echo form_input('rate_per_unit', set_value('rate_per_unit', $task['0']-> rate_per_unit ));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Unit Rate Bonus: ');?></td>
    <td><?php echo form_input('rate_per_unit_bonus', set_value('rate_per_unit_bonus', $task['0']-> rate_per_unit_bonus ));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Description: ');?></td>
    <td><textarea name="description" rows="5"><?php echo $task['0']-> description;?></textarea> 
    </td>
    
</tr>
<tr>
	<td class="label"><?php echo form_label('Status:');?></td>
	<td><?php echo form_dropdown('status',array('active'=>'Active','inactive'=>'Inactive'), set_value('status', $task['0']->status));?></td>
</tr>
<tr>
    <td colspan=4 class="label"><?php echo form_submit('submit','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php echo form_close();?>
</table>
<?php echo validation_errors(); ?>















