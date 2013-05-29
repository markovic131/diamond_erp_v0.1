<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open('possitions/insert');?>
<tr>
    <td class="label"><?php echo form_label('Possition Name: ');?></td>
    <td><?php echo form_input('possition', set_value('possition'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Department: ');?></td>
    <td><?php echo form_dropdown('dept_fk',$departments);?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Base Salary');?></td>
    <td><?php echo form_input('base_salary', set_value('base_salary'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Bonus(%):');?></td>
    <td><?php echo form_input('bonus', set_value('bonus'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Commision(%):');?></td>
    <td><?php echo form_input('commision', set_value('commision'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Requirements: ');?></td>
    <td><?php echo form_input('requirements', set_value('requirements'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Description: ');?></td>
    <td><textarea name="description" rows="5"></textarea></td>
</tr>
<tr>
    <td colspan=4 class="label"><?php echo form_submit('','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php echo form_close();?>
</table>
<?php echo validation_errors(); ?>















