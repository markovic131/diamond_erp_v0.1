<h2><?php echo $heading?></h2>
<hr>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
		<th>Code</th>
		<th>Company</th>
		<th>Contact Person</th>
		<th>Type</th>
		<th>Phone</th>
		<th>Status</th>
	</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo anchor('vendors/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
			<td><?php echo $row->company;?></td>
			<td><?php echo $row->contperson;?></td>
			<td><?php echo $row->ptype;?></td>
			<td><?php echo $row->phone1;?></td>
			<td align="center"><?php echo $row->status;?></td>

		</tr>
<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="10" class="no_records"><span class="warning">No Records Found!</span></td>
	</tr>
<?php endif;?>
</table>