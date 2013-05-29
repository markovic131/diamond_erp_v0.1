<h2><?php echo $heading?></h2>
<hr>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Currency Code</th>
		<th>Letter Code</th>
		<th>Capital</th>	
</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td class="code" align="center"><?php echo $row->id;?></td>
			<td><?php echo $row->name;?></td>
			<td><?php echo $row->cc;?></td>
			<td><?php echo $row->lc2;?></td>
			<td><?php echo $row->capital;?></td>
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
