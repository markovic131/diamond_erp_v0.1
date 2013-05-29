<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('boms/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('boms/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>
<hr>
	<dl>
        <dt>Product:</dt>
        <dd><?php echo $master[0]->prodname;?></dd>

        <dt>Quantity:</dt>
        <dd><?php echo $master[0]->quantity.' '.$master[0]->uname;?></dd>
        
        <dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>   
	</dl>

<table class="master_table">
    <tr>
    	<th>Product</th>
    	<th>Category</th>
    	<th>Quantity</th>
    </tr>
<?php if (isset($details) && is_array($details) && count($details) > 0):?>
	<?php foreach($details as $row):?>
	<tr>
			<td><?php echo $row->prodname;?></td>
			<td><?php echo $row->pcname;?></td>
			<td><?php echo $row->quantity. ' ' .$row->uname;?></td>
	</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="9" align="center">No Records!</td>
	</tr>
<?php endif;?>

</table>
<hr>
<span class="label"><input type="button" value="Back" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>