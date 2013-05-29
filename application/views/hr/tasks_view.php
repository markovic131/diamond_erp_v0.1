<h2><?php echo $heading?></h2>
<hr>
<a href="<?php echo site_url('tasks/insert');?>" class="button"><span class="add">New</span></a>
<?php $this->load->view($flashes); ?>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
		<th></th>
		<th>Task</th>
		<th>Base Unit</th>
		<th>Unit Rate</th>
		<th>Unit Rate Bonus</th>
		<th>Status</th>
		<th></th>
	</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo anchor('tasks/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
			<td><?php echo $row->taskname;?></td>
			<td><?php echo $row->base_unit . ' ' . $row->uname;?></td>
			<td><?php echo $row->rate_per_unit;?></td>
			<td><?php echo $row->rate_per_unit_bonus;?></td>
			<td align="center"><?php echo $row->status;?></td>
			<td class="functions">
				<?php echo anchor('tasks/edit/'.$row->id,'&nbsp;','class="edit_icon"');?> | 
				<?php echo anchor('tasks/delete/'.$row->id,'&nbsp;','class="del_icon"');?>
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