<h2><?php echo $heading; ?></h2>
<hr>

<table class="data_forms">
<?php echo form_open('partners/insert');?>
<tr>

    <td class="label"><?php echo form_label('Company: ');?></td>
    <td><?php echo form_input('company', set_value('company'));?></td>
	<td class="label"><?php echo form_label('Code: ');?></td>
    <td><?php echo form_input('code', set_value('code'));?></td>
    
</tr>
<tr>
	<td class="label"><?php echo form_label('Contact Person: ');?></td>
    <td><?php echo form_input('contperson', set_value('contperson'));?></td> 
    <td class="label"><?php echo form_label('Partner Type: ');?></td>
    <td><?php echo form_dropdown('partner_type_fk',$partners);?></td>
</tr>
<tr>
<td colspan="4"><hr></td>
</tr>

<tr>
    <td class="label"><?php echo form_label('Address: ');?></td>
    <td><?php echo form_input('address', set_value('address'));?></td>

   	<td class="label"><?php echo form_label('City: ');?></td>
    <td><?php echo form_dropdown('postalcode_fk',$postalcodes);?></td>
    
</tr>
<tr>
	<td class="label"><?php echo form_label('Phone: ');?></td>
    <td><?php echo form_input('phone1', set_value('phone1'));?></td>

    <td class="label"><?php echo form_label('Phone 2: ');?></td>
    <td><?php echo form_input('phone2', set_value('phone2'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Fax: ');?></td>
    <td><?php echo form_input('fax', set_value('fax'));?></td>


    <td class="label"><?php echo form_label('Mobile: ');?></td>
    <td><?php echo form_input('mobile', set_value('mobile'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Email: ');?></td>
    <td><?php echo form_input('email', set_value('email'));?></td>
    <td class="label"><?php echo form_label('Web Site: ');?></td>
    <td><?php echo form_input('web', set_value('web'));?></td>
</tr>
<tr>
<td colspan="4"><hr></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Bank: ');?></td>
    <td><?php echo form_input('bank');?></td>
   	<td class="label"><?php echo form_label('Account.No: ');?></td>
    <td><?php echo form_input('account_no', set_value('account_no'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Tax Number: ');?></td>
    <td><?php echo form_input('tax_no', set_value('tax_no'));?></td>
</tr>
<tr>
<td colspan="4"><hr></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('User Group: ');?></td>
    <td><?php echo form_dropdown('ugroup_fk',$ugroups);?></td>
</tr>
<tr>
	
    <td class="label"><?php echo form_label('Username: ');?></td>
    <td><?php echo form_input('username', set_value('username'));?></td>
</tr>
<tr>
   	<td class="label"><?php echo form_label('Password: ');?></td>
    <td><?php echo form_password('password','');?></td>
</tr>
<tr>
<td colspan="4"><hr></td>
</tr>
<tr>
	<td colspan=4 class="label"><?php echo form_submit('','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
</table>
<?php echo form_close();?>

<?php echo validation_errors(); ?>















