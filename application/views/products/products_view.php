<h2><?php echo $heading?></h2>
<hr>
<a href="<?php echo site_url('products/insert');?>" class="button"><span class="add">New</span></a>
<div class="filers">
    <?php $this->load->view($flashes); ?>
    <?php echo form_open('products');?>
    <?php echo form_label('Type:');?>
    <?php echo form_dropdown('ptname_fk', $types, set_value('ptname_fk')); ?>
    <?php echo form_label('Category:');?>
    <?php echo form_dropdown('pcname_fk',$categories, set_value('pcname_fk')); ?>
    <?php echo form_label('Warehouse:');?>
    <?php echo form_dropdown('wname_fk', $warehouses, set_value('wname_fk')); ?>
    <?php echo form_submit('','Filter');?>
    <?php echo form_close();?>
</div>
<?php $this->load->view($flashes); ?>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
		<th></th>
		<th>Code</th>
		<th>Name</th>
		<th>Type</th>
		<th>Category</th>
		<th>Warehouse</th>
		<th>Base Unit</th>
		<th>Stock Alert Qty.</th>
		<th>Status</th>
		<th></th>
	</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo anchor('products/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
			<td><?php echo $row->code;?></td>
			<td><?php echo $row->prodname;?></td>
			<td><?php echo $row->ptname;?></td>
			<td><?php echo $row->pcname;?></td>
			<td><?php echo $row->wname;?></td>
			<td><?php echo $row->base_unit.' '.$row->uname;?></td>
			<td align="center"><?php echo ($row->alert_quantity == 0 || $row->alert_quantity == NULL ? '-' : $row->alert_quantity); ?></td>
			<td align="center"><?php echo $row->status;?></td>
			<td class="functions">
				<?php echo anchor('products/edit/'.$row->id,'&nbsp;','class="edit_icon"');?> | 
				<?php echo anchor('products/delete/'.$row->id,'&nbsp;','class="del_icon"');?>
			</td>
		</tr>

	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="10" class="no_records"><span class="warning">No Records Found!</span></td>
	</tr>
<?php endif;?>
</table>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>