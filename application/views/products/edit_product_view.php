
<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open('products/edit/'. $product['0'] -> id); ?>
<tr>
	<td class="label"><?php echo form_label('Name:');?></td>
	<td><?php echo form_input('prodname', set_value('prodname', $product['0']-> prodname ));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Code:');?></td>
	<td><?php echo form_input('code', set_value('code', $product['0']->code));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Product Type:');?></td>
	<td><?php echo form_dropdown('ptname_fk', $product_types, set_value('ptname_fk', $product['0']->ptname_fk));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Product Category:');?></td>
	<td><?php echo form_dropdown('pcname_fk', $product_cates, set_value('pcname_fk', $product['0']->pcname_fk));?></td>
</tr>

<tr>
	<td class="label"><?php echo form_label('Warehouse:');?></td>
	<td><?php echo form_dropdown('wname_fk', $warehouses, set_value('wname_fk', $product['0']->wname_fk));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Base Unit:');?></td>
	<td><?php echo form_input('base_unit', set_value('base_unit', $product['0']->base_unit));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Unit of Measure:');?></td>
	<td><?php echo form_dropdown('uname_fk', $uoms, set_value('uname_fk', $product['0']->uname_fk));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Retail Price:');?></td>
	<td><?php echo form_input('retail_price', set_value('retail_price', $product['0']->retail_price));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Commision:');?></td>
	<td><?php echo form_input('commision', set_value('commision', $product['0']->commision));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Order Alert Qty:');?></td>
	<td><?php echo form_input('alert_quantity', set_value('alert_quantity', $product['0']->alert_quantity));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Description:');?></td>
	<td><textarea name="description" rows="5"><?php echo $product['0']->description;?></textarea></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Salable:');?></td>
	<td><?php echo form_dropdown('is_saleable',array('1'=>'Yes','0'=>'No'), set_value('is_saleable', $product['0']->is_saleable));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Status:');?></td>
	<td><?php echo form_dropdown('status',array('active'=>'Active','inactive'=>'Inactive'), set_value('status', $product['0']->status));?></td>
</tr>
<tr>
    <td colspan=4 class="label"><?php echo form_submit('submit','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php form_close();?>

</table>
<?php echo validation_errors(); ?>