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
<?php echo form_open('employees/insert');?>
<tr>

    <td class="label"><?php echo form_label('First Name: ');?></td>
    <td><?php echo form_input('fname', set_value('fname'));?></td>
    <td class="label"><?php echo form_label('Last Name: ');?></td>
    <td><?php echo form_input('lname', set_value('lname'));?></td>
</tr>
<tr>

</tr>
<tr>
	<?php $dob = array('name'=>'dateofbirth','id'=>'datepicker');?>
    <td class="label"><?php echo form_label('Date of Birth: ');?></td>
    <td><?php echo form_input($dob);?></td>
	<td class="label"><?php echo form_label('SSN: ');?></td>
    <td><?php echo form_input('ssn', set_value('ssn'));?></td>
</tr>
<tr>    
	 <td class="label"><?php echo form_label('Gender: ');?></td>
    <td><?php echo form_dropdown('gender',array('m'=>'Male','f'=>'Female'));?></td>   
    <td class="label"><?php echo form_label('Marital Status: ');?></td>
    <td><?php echo form_dropdown('mstatus',array(''=>'--','single'=>'Single','married'=>'Married','divorced'=>'Divorced'));?></td>
  
</tr>
<tr>
	<td colspan="4"><hr></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Address: ');?></td>
    <td><?php echo form_input('address', set_value('address'));?></td>
   	<td class="label"><?php echo form_label('City: ');?></td>
    <td><?php echo form_dropdown('postcode_fk',$postalcodes);?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Phone: ');?></td>
    <td><?php echo form_input('phone', set_value('phone'));?></td>


    <td class="label"><?php echo form_label('Mobile: ');?></td>
    <td><?php echo form_input('mobile', set_value('mobile'));?></td>
</tr>
<tr>
   	<td class="label"><?php echo form_label('Company Mobile: ');?></td>
    <td><?php echo form_input('comp_mobile', set_value('comp_mobile'));?></td>

    <td class="label"><?php echo form_label('Email: ');?></td>
    <td><?php echo form_input('email', set_value('email'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Bank: ');?></td>
    <td><?php echo form_input('bank');?></td>
   	<td class="label"><?php echo form_label('Account Number: ');?></td>
    <td><?php echo form_input('account_no');?></td>
</tr>
<tr>
	<td colspan="4"><hr></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Possition: ');?></td>
    <td><?php echo form_dropdown('poss_fk',$possitions);?></td>
    <td class="label"><?php echo form_label('Manager: ');?></td>
    <td><?php echo form_dropdown('manager_fk',$managers);?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('User Group: ');?></td>
    <td><?php echo form_dropdown('ugroup_fk',$ugroups);?></td>
    <td class="label"><?php echo form_label('Code: ');?></td>
    <td><?php echo form_input('code','', set_value('code'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Username: ');?></td>
    <td><?php echo form_input('username','', set_value('username'));?></td>
</tr>
<tr>
   	<td class="label"><?php echo form_label('Password: ');?></td>
    <td><?php echo form_password('password','');?></td>
</tr>

<tr>
	<td colspan="4"><hr></td>
</tr>

<tr>
	<td><?php echo form_label('Note: ');?></td>
</tr>

<tr>
    <td colspan="4"><textarea name="note" style="width: 570px; height: 100px;"><?php echo set_value('note'); ?></textarea></td>
</tr>
<tr>
    <td colspan=4 class="label"><?php echo form_submit('','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
</table>
<?php echo form_close();?>

<?php echo validation_errors(); ?>















