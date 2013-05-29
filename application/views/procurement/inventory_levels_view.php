<h2><?php echo $heading?></h2>
<hr>
<?php $this->load->view($flashes); ?>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
		<th>Product</th>
		<th>Category</th>
		<th>Quantity</th>
		<th>Average Price</th>
		<th>Max. Price</th>
		<th>Last Level Update</th>
	</tr>
	<?php foreach($results as $row):?>
		<tr <?php echo ($row->alert_quantity >= $row->quantity ? ' class="red" '  : '');?>>
			<td><?php echo $row->prodname;?></td>
			<td><?php echo $row->pcname;?></td>
			<td><?php echo $row->quantity.' '.$row->uname;?></td>
			<td><?php echo round($row->price,1).' per '.$row->uname;?></td>
			<td><?php echo round($row->maxprice,1).' per '.$row->uname;?></td>
			<td><?php echo $row->dateofentry;?></td>
		</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="10" class="no_records"><span class="warning">No Records Found!</span></td>
	</tr>
<?php endif;?>
</table>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>