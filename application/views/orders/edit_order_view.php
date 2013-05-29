<script type="text/javascript">

	//Remove Product Function
	function removeProduct(id) 
	{
		var toremove = id;
		$.post("<?php echo site_url('orders/remove_product'); ?>",
				   {id:id},
				   function(data){
					   	  $('#' + toremove).remove();
						  $("div.quick_message").text(data.message);
						  setTimeout(function() {
							  $("div.quick_message").empty();	
							}, 4000);
				   },"json"
				   
			   );
	}

	//Add Product Function
	function addProduct(id) 
	{
		var order_fk = id;
		var prodname_fk = $("select[name=newprod]").val();
		var quantity = $("input[name=qty]").val();

		 if (quantity == '' || prodname_fk == '')
		  {
		    alert("Please select product and quantity!");
		    return false;
		  }
		  else if (quantity == 0)
		  {
			alert("Please enter valid quantity!");
			$("input[name=qty]").focus();
			return false;
		  }

		//Searches if product alredy exists
		//var exsisting = $(".master_table tr#" + prodname_fk).length;
		//jQuery.fn.exists = function(){return jQuery(this).length>0;}
		//var x = $("td#" + prodname_fk).exists();
		//alert(exsisting);
		//return false;

		$.post("<?php echo site_url('orders/add_product'); ?>",
				   {order_fk:order_fk,prodname_fk:prodname_fk,quantity:quantity},
				   function(data){
					   			$("div.quick_message").text(data.message);
								  setTimeout(function() {
									  $("div.quick_message").empty();	
								}, 4000);
								$("select[name=newprod]").val("");
								$("input[name=qty]").val("");
								location.reload();	   	   
				   },"json"
			);
		return false;
	}
	
	$(document).ready(function() {
		//Date Pickers
		$( "input[name=desiredshipping]" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url()."assets/calendar.gif" ;?>",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			minDate: +0,
		});
		$( "input[name=dateshipped]" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url()."assets/calendar.gif" ;?>",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			minDate: +0,
		});
		
		$('.quantity').editable('<?php echo site_url('orders/edit_qty'); ?>', {
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
<?php echo form_open('orders/edit/'.$master[0]->id);?>
<div class="buttons">

<a href="<?php echo site_url('orders/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
<?php echo form_submit('submit','Save','class="save"'); ?>
</div>
<hr>
	<table class="data_forms">	
	
		
        <tr>
        	<td><?php echo form_label('Customer: ');?></td>
            <td><?php echo form_dropdown('partner_fk', $partners,set_value('partner_fk',$master[0]->partner_fk)); ?></td>
            <td><?php echo form_label('Desired Shipping: ');?></td>
            <td><?php echo form_input('desiredshipping',set_value('desiredshipping',$master[0]->desiredshipping)); ?></td>
        </tr>
        <tr>
        	<td><?php echo form_label('Order Status: ');?></td>
            <td><?php echo form_dropdown('ostatus_fk',$order_status,set_value('ostatus_fk',$master[0]->ostatus_fk)); ?></td>
            <td><?php echo form_label('Date Shipped: ');?></td>
            <td><?php echo form_input('dateshipped',set_value('dateshipped',$master[0]->dateshipped)); ?></td>
        </tr>
        <tr>
       		 <td colspan="4"><?php echo form_label('Comments: ');?></td>
        </tr>
        <tr>
            <td colspan="4"><textarea name="comments" class="comments" id="comments"><?php echo $master[0]->comments; ?></textarea></td>
        </tr>
        <tr>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
           <td colspan="4">Product: <?php echo form_dropdown('newprod',$products,'id="newprod"')?>
            Quantity: <?php echo form_input('qty')?>
      		<span class="add_icon" onclick="addProduct(<?php echo $master[0]->id;?>);">&nbsp;</span></td>
		</tr> 
		<tr>
            <td colspan="4"><hr></td>
        </tr>

	<?php echo form_close();?>
	</table >

<table class="master_table">
    <tr>
    	<th>Product</th>
    	<th>Category</th>
    	<th>Quantity</th>
    	<th></th>
    	<th>Delivered Qty</th>
    	<th>Returned Qty</th>
    	<th></th>
    </tr>
<?php if (isset($details) && is_array($details) && count($details) > 0):?>
	<?php foreach($details as $row):?>
	<tr id="<?php echo $row->id;?>">
			
			<td><?php echo $row->prodname;?></td>
			<td><?php echo $row->pcname;?></td>
			<td class="quantity" id="<?php echo $row->id;?>"><?php echo $row->quantity;?></td>
			<td class="left"><?php echo $row->uname;?></td>
			<td><?php echo ($row->delivered_quantity == NULL ? '-' : $row->delivered_quantity); ?></td>
			<td><?php echo ($row->returned_quantity == NULL ? '-' : $row->returned_quantity); ?></td>
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
<span class="label"><input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>