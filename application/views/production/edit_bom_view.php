<script type="text/javascript">

	//Remove Product Function
	function removeProduct(id) 
	{
		var toremove = id;
		$.post("<?php echo site_url('boms/remove_product'); ?>",
				   {id:id},
				   function(data){
					   	  $('#' + toremove).remove();
						  $("div.quick_message").text(data.message);
						  setTimeout(function() {
							  $("div.quick_message").empty();	
							}, 4000);
				   },"json"
				   
			   );
		return false;	
	}
	
	$(document).ready(function() {

		//Inline Edit
		$('.quantity').editable('<?php echo site_url('boms/edit_qty'); ?>', {
		    	indicator : 'Saving...',
		    	tooltip   : 'Click to edit...',
		    	id : 'id',
		    	name : 'quantity'
		});
	});	



</script>
<h2><?php echo $heading; ?></h2>
<hr>
<div class="quick_message"></div>	
<div id="buttons">
<a href="<?php echo site_url('boms/delete/'.$master[0]->id);?>" class="button"><span class="delete">Delete</span></a>
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
    	<th></th>
    	<th></th>
    </tr>
<?php if (isset($details) && is_array($details) && count($details) > 0):?>
	<?php foreach($details as $row):?>
	<tr id="<?php echo $row->id;?>">
			<td><?php echo $row->prodname;?></td>
			<td><?php echo $row->pcname;?></td>
			<td class="quantity" id="<?php echo $row->id;?>"><?php echo $row->quantity;?></td>
			<td class="left"><?php echo $row->uname;?></td>
			<td><span class="removeprod" onclick="removeProduct('<?php echo $row->id;?>');">&nbsp;</span></td>
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