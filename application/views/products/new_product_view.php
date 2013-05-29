<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open_multipart('products/insert'); ?>
<tr>
	<td class="label"><?php echo form_label('Name:');?></td>
	<td><?php echo form_input('prodname', set_value('prodname'));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Code:');?></td>
	<td><?php echo form_input('code', set_value('code'));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Image:');?></td>
	<td><?php echo form_upload('image');?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Product Type:');?></td>
	<td><?php echo form_dropdown('ptname_fk', $product_types);?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Product Category:');?></td>
	<td><?php echo form_dropdown('pcname_fk', $product_cates);?></td>
</tr>

<tr>
	<td class="label"><?php echo form_label('Warehouse:');?></td>
	<td><?php echo form_dropdown('wname_fk', $warehouses);?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Base Unit:');?></td>
	<td><?php echo form_input('base_unit', set_value('base_unit'));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Unit of Measure:');?></td>
	<td><?php echo form_dropdown('uname_fk', $uoms);?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Retail Price:');?></td>
	<td><?php echo form_input('retail_price', set_value('retail_price'));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Commision:');?></td>
	<td><?php echo form_input('commision', set_value('commision'));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Order Alert Qty:');?></td>
	<td><?php echo form_input('alert_quantity', set_value('alert_quantity'));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Description:');?></td>
	<td><textarea name="description" rows="5"></textarea></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Salable:');?></td>
	<td><?php echo form_dropdown('is_saleable', array('1'=>'Yes','0'=>'No'));?></td>
</tr>
<tr>
	<td colspan=4 class="label"><?php echo form_submit('','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php form_close();?>

</table>
<?php echo validation_errors(); ?>