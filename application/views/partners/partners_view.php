<h2><?php echo $heading?></h2>
<hr>
<a href="<?php echo site_url('partners/insert');?>" class="button"><span class="add">New</span></a>
<?php $this->load->view($flashes); ?>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
		<th></th>
		<th>Code</th>
		<th>Company</th>
		<th>Contact Person</th>
		<th>Type</th>
		<th>Phone</th>
		<th>Status</th>
		<th></th>
	</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo anchor('partners/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
			<td><?php echo $row->code;?></td>
			<td><?php echo $row->company;?></td>
			<td><?php echo $row->contperson;?></td>
			<td><?php echo $row->ptype;?></td>
			<td><?php echo $row->phone1;?></td>
			<td align="center"><?php echo $row->status;?></td>
			<td class="functions">
				<?php echo anchor('partners/edit/'.$row->id,'&nbsp;','class="edit_icon"');?> | 
				<?php echo anchor('partners/delete/'.$row->id,'&nbsp;','class="del_icon"');?>
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