<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('orders/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('orders/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>
<hr>

	<dl>
		<dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>
        
        <dt>Company:</dt>
        <dd><?php echo $master[0]->company;?></dd>

        <dt>Desired Shipping:</dt>
        <dd><?php echo ($master[0]->desiredshipping == NULL ? '-' : $master[0]->desiredshipping); ?></dd>
        
        <dt>Date Shipped:</dt>
        <dd><?php echo ($master[0]->dateshipped == NULL ? '-' : $master[0]->dateshipped); ?></dd>
        
        <dt>Order Status:</dt>
        <dd><?php echo $master[0]->ostatus; ?></dd>
        
        <dt>Status:</dt>
        <dd><?php echo $master[0]->status; ?></dd>
        
        <dt>Comments:</dt>
        <dd><?php echo $master[0]->comments; ?></dd>          
	</dl>

<table class="master_table">
    <tr>
    	<th>Product</th>
    	<th>Category</th>
    	<th>Quantity</th>
    	<th>Delivered Qty</th>
    	<th>Returned Qty</th>
    </tr>
<?php if (isset($details) && is_array($details) && count($details) > 0):?>
	<?php foreach($details as $row):?>
	<tr>
			<td><?php echo $row->prodname;?></td>
			<td><?php echo $row->pcname;?></td>
			<td><?php echo $row->quantity. ' ' .$row->uname;?></td>
			<td><?php echo ($row->delivered_quantity == NULL ? '-' : $row->delivered_quantity); ?></td>
			<td><?php echo ($row->returned_quantity == NULL ? '-' : $row->returned_quantity); ?></td>
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