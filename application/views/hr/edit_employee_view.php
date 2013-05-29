<script>
	$(document).ready(function() {
		$( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url()."assets/calendar.gif" ;?>",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			maxDate: +0,
			changeYear: true,
			yearRange: "1900:2000"
		});
	});
</script>
<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open('employees/edit/'. $employee['0']->id);?>
<tr>

    <td class="label"><?php echo form_label('First Name: ');?></td>
    <td><?php echo form_input('fname', set_value('fname', $employee['0']->fname));?></td>
    <td class="label"><?php echo form_label('Last Name: ');?></td>
    <td><?php echo form_input('lname', set_value('lname', $employee['0']->lname));?></td>
</tr>
<tr>

</tr>
<tr>
	<?php $dob = array('name'=>'dateofbirth','id'=>'datepicker');?>
    <td class="label"><?php echo form_label('Date of Birth: ');?></td>
    <td><?php echo form_input($dob, set_value('dateofbirth', $employee['0']->dateofbirth));?></td>
	<td class="label"><?php echo form_label('SSN: ');?></td>
    <td><?php echo form_input('ssn', set_value('ssn', $employee['0']->ssn));?></td>
</tr>
<tr>    
	 <td class="label"><?php echo form_label('Gender: ');?></td>
    <td><?php echo form_dropdown('gender',array('m'=>'Male','f'=>'Female'), $employee['0']->gender);?></td>   
    <td class="label"><?php echo form_label('Marital Status: ');?></td>
    <td><?php echo form_dropdown('mstatus',array(''=>'--','single'=>'Single','married'=>'Married','divorced'=>'Divorced'), $employee['0']->mstatus);?></td>
  
</tr>
<tr>
	<td colspan="4"><hr></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Address: ');?></td>
    <td><?php echo form_input('address', set_value('address', $employee['0']->address));?></td>
   	<td class="label"><?php echo form_label('City: ');?></td>
    <td><?php echo form_dropdown('postcode_fk',$postalcodes, set_value('postcode_fk', $employee['0']->postcode_fk));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Phone: ');?></td>
    <td><?php echo form_input('phone', set_value('phone', $employee['0']->phone));?></td>


    <td class="label"><?php echo form_label('Mobile: ');?></td>
    <td><?php echo form_input('mobile', set_value('mobile', $employee['0']->mobile));?></td>
</tr>
<tr>
   	<td class="label"><?php echo form_label('Company Mobile: ');?></td>
    <td><?php echo form_input('comp_mobile', set_value('comp_mobile', $employee['0']->comp_mobile));?></td>

    <td class="label"><?php echo form_label('Email: ');?></td>
    <td><?php echo form_input('email', set_value('email', $employee['0']->email));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Bank: ');?></td>
    <td><?php echo form_input('bank', set_value('bank', $employee['0']->bank));?></td>
   	<td class="label"><?php echo form_label('Account Number: ');?></td>
    <td><?php echo form_input('account_no', set_value('account_no', $employee['0']->account_no));?></td>
</tr>
<tr>
	<td colspan="4"><hr></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Possition: ');?></td>
    <td><?php echo form_dropdown('poss_fk',$possitions, set_value('poss_fk', $employee['0']->poss_fk));?></td>
    <td class="label"><?php echo form_label('Manager: ');?></td>
    <td><?php echo form_dropdown('manager_fk',$managers, set_value('manager_fk', $employee['0']->manager_fk));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('User Group: ');?></td>
    <td><?php echo form_dropdown('ugroup_fk',$ugroups, set_value('ugroup_fk', $employee['0']->ugroup_fk));?></td>
    <td class="label"><?php echo form_label('Code: ');?></td>
    <td><?php echo form_input('code', set_value('code', $employee['0']->code));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Username: ');?></td>
    <td><?php echo form_input('username', set_value('username', $employee['0']->username));?></td>
    <td class="label"><?php echo form_label('Status: ');?></td>
    <td><?php echo form_dropdown('status',array('active'=>'Active','inactive'=>'Inactive'),set_value('status', $employee['0']->status));?></td>
</tr>
<tr>
   	<td class="label"><?php echo form_label('Password: ');?></td>
    <td><?php echo form_password('password');?></td>
</tr>

<tr>
	<td colspan="4"><hr></td>
</tr>

<tr>
	<td><?php echo form_label('Note: ');?></td>
</tr>

<tr>
    <td colspan="4"><textarea name="note" style="width: 570px; height: 100px;"><?php echo set_value('note',$employee['0']->note); ?></textarea></td>
</tr>

<tr>
    <td colspan=4 class="label"><?php echo form_submit('submit','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php echo form_close();?>
</table>
<?php echo validation_errors(); ?>















