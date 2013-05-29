<script type="text/javascript">
	//Dropdown menu populating! PRODUCTS
	$.getJSON("<?php echo site_url('products/dropdown/no'); ?>", function(result) {
	    var optionsValues = "<select id='product'>";
	    JSONObject = result;
	    optionsValues += '<option value="">' + '--' + '</option>';
	    $.each(result, function() {
	            optionsValues += '<option value="' + this.id + '">' + this.prodname + '</option>';
	    });
	    optionsValues += '</select>';
	    var options = $("select#product");
	    options.replaceWith(optionsValues);  
	});
	$(document).ready(function() {
		$("#date, #uname, #code, #category").attr("disabled", "disabled");
		$("input#code").val("");
		$("input#category").val("");
		$("input#uname").val("");
		
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
					$("input#category").val('');  
					$("input#uname").val('');
					$("input#prodname_fk").val('');   
					return false;	
				}
			  $("input[name=prodname_fk]").val(JSONObject[this.selectedIndex-1].id);
			  $("input#code").val(JSONObject[this.selectedIndex-1].code);  
			  $("input#category").val(JSONObject[this.selectedIndex-1].pcname);  
			  $("input#uname").val(JSONObject[this.selectedIndex-1].uname);
			});
		
				
			    	
	});

</script>

<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open('inventory/insert');?>
<tr>
    <td class="label"><?php echo form_label('Order Date:');?></td>
    <td><?php echo form_input('dateoforder',set_value('dateoforder'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Vendor: ');?></td>
    <td><?php echo form_dropdown('partner_fk',$vendors, set_value('partner_fk'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Product Code: ');?></td>
    <td><?php echo form_input(array('id'=>'code'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Product: ');?></td>
    <td><select id="product"></select></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Category: ');?></td>
    <td><?php echo form_input(array('id'=>'category'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Quantity: ');?></td>
    <td><?php echo form_input('quantity',set_value('quantity'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('UOM: ');?></td>
    <td><?php echo form_input(array('id'=>'uname'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Price: ');?></td>
    <td><?php echo form_input('price', set_value('price'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Expiration Date:');?></td>
    <td><?php echo form_input('dateofexpiration',set_value('dateofexpiration')); ?></td>
</tr>

<tr>
    <td class="label"><?php echo form_label('Comment: ');?></td>
    <td><textarea name="comments" rows="5"></textarea></td>
</tr>
<tr>
    <td colspan="4">
	    <?php echo form_hidden('received_by',$this->session->userdata('userid'));?>
	    <?php echo form_hidden('prodname_fk');?>
    </td>
</tr>
<tr>
    <td colspan=4 class="label"><?php echo form_submit('','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php echo form_close();?>
</table>
<?php echo validation_errors(); ?>















