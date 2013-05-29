<script type="text/javascript">
	//Dropdown menu populating! PRODUCTS
	$.getJSON("<?php echo site_url('products/dropdown/no'); ?>", function(result) {
	    var optionsValues = "<select id='product'>";
	    JSONObject = result;
	    optionsValues += '<option value="">' + '--' + '</option>';
	    $.each(result, function() {
		    if(<?php echo $goods_receipt['0']->prodname_fk;?> == this.id){
		       optionsValues += '<option value="' + this.id + '" selected="selected">' + this.prodname + '</option>';
		    }
		    else{
	           optionsValues += '<option value="' + this.id + '">' + this.prodname + '</option>';
		    }
	    });
	    optionsValues += '</select>';
	    var options = $("select#product");
	    options.replaceWith(optionsValues);  
	});
	$(document).ready(function() {
		
		$("#date, #uname, #received_by, #code").attr("disabled", "disabled");
		
		$( "input[name=dateoforder]" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url()."assets/calendar.gif" ;?>",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			maxDate: +0,
		});
		$( "input[name=dateofexpiration]" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url()."assets/calendar.gif" ;?>",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			minDate: +0,
		});

		//OnChange for Products dropdown menu
		$("select#product").live('change',function() {
				if(this.selectedIndex == '')
				{
					$("input#code").val('');  
					$("input#uname").val('');
					$("input#prodname_fk").val('');   
					return false;	
				}
			  $("input[name=prodname_fk]").val(JSONObject[this.selectedIndex-1].id);
			  $("input#code").val(JSONObject[this.selectedIndex-1].code);  
			  $("input#uname").val(JSONObject[this.selectedIndex-1].uname);
			});
	});

</script>

<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open('inventory/edit/'. $goods_receipt['0'] -> id);?>
<tr>
    <td class="label"><?php echo form_label('Received on: ');?></td>
    <td><?php echo form_input(array('id'=>'date','value'=> $goods_receipt['0']->dateofentry));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Received by: ');?></td>
    <td><?php echo form_input(array('id'=>'received_by', 'value' => set_value('code',$goods_receipt['0']->fname.' '.$goods_receipt['0']->lname)));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Order Date:');?></td>
    <td><?php echo form_input('dateoforder',set_value('dateoforder',$goods_receipt['0']->dateoforder));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Vendor: ');?></td>
    <td><?php echo form_dropdown('partner_fk',$vendors, set_value('partner_fk',$goods_receipt['0']->partner_fk));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Product Code: ');?></td>
    <td><?php echo form_input(array('id'=>'code', 'value' => set_value('code',$goods_receipt['0']->code))); ?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Product: ');?></td>
    <td><select id="product" name="prodname_fk"></select></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Quantity: ');?></td>
    <td><?php echo form_input('quantity',set_value('quantity',$goods_receipt['0']->quantity));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('UOM: ');?></td>
    <td><?php echo form_input(array('id'=>'uname','value'=> $goods_receipt['0']->uname));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Price: ');?></td>
    <td><?php echo form_input('price', set_value('price',$goods_receipt['0']->price));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Expiration Date:');?></td>
    <td><?php echo form_input('dateofexpiration',set_value('dateofexpiration',$goods_receipt['0']->dateofexpiration)); ?></td>
</tr>

<tr>
    <td class="label"><?php echo form_label('Comment: ');?></td>
    <td><textarea name="comments" rows="5"><?php echo $goods_receipt['0']->comments;?></textarea></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Status:');?></td>
	<td><?php echo form_dropdown('status',array('active'=>'Active','inactive'=>'Inactive'), set_value('status', $goods_receipt['0']->status));?></td>
</tr>
<tr>
    <td colspan="4">
	    <?php echo form_hidden(array('prodname_fk' => $goods_receipt['0']->prodname_fk));?>
    </td>
</tr>
<tr>
    <td colspan=4 class="label"><?php echo form_submit('submit','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php echo form_close();?>
</table>
<?php echo validation_errors(); ?>















