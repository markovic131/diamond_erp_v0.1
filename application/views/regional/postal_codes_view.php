<h2><?php echo $heading?></h2>
<hr>
<a href="<?php echo site_url('regional/postal_code_insert');?>" class="button"><span class="add">New</span></a>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
		<th>ID</th>
		<th>Postal Code</th>
		<th>City</th>
		<th>Country</th>
		<th>Country Symbol</th>
		<th>Status</th>
		<th></th>
	</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo $row->id;?></td>
			<td><?php echo $row->postalcode;?></td>
			<td><?php echo $row->name;?></td>
			<td><?php echo $row->countryname;?></td>
			<td><?php echo $row->symbol;?></td>
			<td align="center"><?php echo $row->status;?></td>
			<td class="functions"> 
				<?php echo anchor('postal_code/delete/'.$row->id,'&nbsp;','class="del_icon"');?>
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
<?php
