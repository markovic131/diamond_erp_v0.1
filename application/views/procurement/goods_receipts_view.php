<h2><?php echo $heading?></h2>
<hr>
<a href="<?php echo site_url('inventory/insert');?>" class="button"><span class="add">New</span></a>
<div class="filers">
    
    <?php $this->load->view($flashes); ?>
    <?php echo form_open('inventory/goods_receipts');?>
    <?php echo form_label('Product:');?>
    <?php echo form_dropdown('prodname_fk', $products, set_value('prodname_fk')); ?>
    <?php echo form_label('Vendor:');?>
    <?php echo form_dropdown('partner_fk', $vendors, set_value('partner_fk')); ?>
    <?php echo form_label('Category:');?>
    <?php echo form_dropdown('pcname_fk',$categories, set_value('pcname_fk')); ?>
    <?php echo form_submit('','Filter');?>
    <?php echo form_close();?>
</div>
<?php $this->load->view($flashes); ?>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
		<th></th>
		<th>Received</th>
		<th>Product</th>
		<th>Vendor</th>
		<th>Category</th>
		<th>Quantity</th>
		<th>Ordered</th>
		<th>Expiration</th>
		<th>Status</th>
		<th></th>
	</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo anchor('inventory/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
			<td><?php echo mdate('%d/%m/%Y',mysql_to_unix($row->dateofentry));?></td>
			<td><?php echo $row->prodname;?></td>
			<td><?php echo $row->company;?></td>
			<td><?php echo $row->pcname;?></td>
			<td><?php echo $row->quantity.' '.$row->uname;?></td>
			<td><?php echo (($row->dateoforder == NULL) || ($row->dateoforder == '0000-00-00') ? '-' : $row->dateoforder); ?></td>
			<td><?php echo (($row->dateofexpiration == NULL) || ($row->dateofexpiration == '0000-00-00') ? '-' : $row->dateofexpiration); ?></td>
			<td><?php echo $row->status;?></td>
			<td class="functions">
				<?php echo anchor('inventory/edit/'.$row->id,'&nbsp;','class="edit_icon"');?> | 
				<?php echo anchor('inventory/delete/'.$row->id,'&nbsp;','class="del_icon"');?>
			</td>
		</tr>
	<?php endforeach;?>
<?php else:?>
		<tr>
		<td colspan="10" class="no_records"><span class="warning">No Records Found!</span></td>
	</tr>
<?php endif;?>
</table>
<div class="pagination"><?php echo (isset($pagination) && $pagination == '') ? '' : 'Pages:'.$pagination; ?></div>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>