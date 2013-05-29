<h2><?php echo $heading?></h2>
<hr>
<a href="<?php echo site_url('employees/insert');?>" class="button"><span class="add">New</span></a>
<div class="filers">  
    <?php $this->load->view($flashes); ?>
    <?php echo form_open('employees/index');?>
    <?php echo form_label('Possition:');?>
    <?php echo form_dropdown('poss_fk', $possitions, set_value('poss_fk')); ?>
    <?php echo form_label('User Group:');?>
    <?php echo form_dropdown('ugroup_fk', $ugroups, set_value('ugroup_fk')); ?>
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
		<th>Possition</th>
		<th>Department</th>
		<th>User Group</th>
		<th>Company Mobile</th>
		<th>Mobile</th>
		<th>Status</th>
		<th></th>
	</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo anchor('employees/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
			<td><?php echo $row->code;?></td>
			<td><?php echo $row->fname. ' '.$row->lname;?></td>
			<td><?php echo $row->possition;?></td>
			<td><?php echo $row->department;?></td>
			<td><?php echo ($row->ugroup == NULL ? '-' : $row->ugroup);?></td>
			<td><?php echo ($row->comp_mobile == NULL ? '-' : $row->comp_mobile);?></td>
			<td><?php echo ($row->mobile == NULL ? '-' : $row->mobile);?></td>
			<td align="center"><?php echo $row->status;?></td>
			<td class="functions">
				<?php echo anchor('employees/edit/'.$row->id,'&nbsp;','class="edit_icon"');?> | 
				<?php echo anchor('employees/delete/'.$row->id,'&nbsp;','class="del_icon"');?>
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