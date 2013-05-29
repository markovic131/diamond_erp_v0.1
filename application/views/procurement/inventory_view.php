<h2><?php echo $heading?></h2>
<hr>

<?php echo anchor('boms/insert','New',array('id'=>'add'));?>
<?php $this->load->view($flashes); ?>
<hr>
<table class="master_table">

<tr>
	<th>Index</th>
	<th>Code</th>
	<th>Product</th>
	<th>Category</th>
	<th>Quantity</th>
	<th>UOM</th>
	<th>Date of Entry</th>
	<th>Status</th>
	<th></th>
</tr>
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo $row->id;?></td>
			<td class="code" align="center"><?php echo $row->code;?></td>
			<td><?php echo $row->prodname;?></td>
			<td><?php echo $row->pcname;?></td>
			<td><?php echo $row->quantity;?></td>
			<td><?php echo $row->uname;?></td>
			<td><?php echo $row->dateofentry;?></td>
			<td align="center"><?php echo $row->status;?></td>
			<td align="center">
				<?php echo anchor('boms/edit/'.$row->id,'edit');?> |
				<?php echo anchor('boms/delete/'.$row->id,'delete',array('id'=>'delete'));?>
			</td>
		</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="9" align="center">No Records!</td>
	</tr>
<?php endif;?>
</table>
<div id="deldialog">Delete selected record?</div>