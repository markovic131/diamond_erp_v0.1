<script type="text/javascript">
	//Dropdown menu populating! PRODUCTS
	$.getJSON("<?php echo site_url('products/dropdown/yes'); ?>", function(result) {
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
	//Dropdown menu populating! TASKS
	$.getJSON("<?php echo site_url('tasks/dropdown'); ?>", function(result) {
	    var optionsValues = "<select id='tasks'>";
	    JSONObject2 = result;
	    optionsValues += '<option value="">' + '--' + '</option>';
	    $.each(result, function() {
	            optionsValues += '<option value="' + this.id + '">' + this.taskname + '</option>';
	    });
	    optionsValues += '</select>';
	    var options = $("select#tasks");
	    options.replaceWith(optionsValues);  
	});
	$(document).ready(function() {
		$("#date, #uname, #code, #category").attr("disabled", "disabled");
		$("input#code").val("");
		$("input#category").val("");
		$("input#uname").val("");
		
		$( "input[name=datedue]" ).datepicker({
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
					$("input[name=prodname_fk]").val('');   
					return false;	
				}
			  $("input[name=prodname_fk]").val(JSONObject[this.selectedIndex-1].id);
			  $("input#code").val(JSONObject[this.selectedIndex-1].code);  
			  $("input#category").val(JSONObject[this.selectedIndex-1].pcname);  
			});
		//OnChange for Tasks dropdown menu
		$("select#tasks").live('change',function() {
				if(this.selectedIndex == '')
				{ 
					$("input#uname").val(''); 
					$("input[name=task_fk]").val('');   
					return false;	
				}
			  $("input[name=task_fk]").val(JSONObject2[this.selectedIndex-1].id);
			  $("input#uname").val(JSONObject2[this.selectedIndex-1].uname);  
			});
		
				
			    	
	});

</script>

<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open('job_orders/insert');?>
<tr>
    <td class="label"><?php echo form_label('Employee: ');?></td>
    <td><?php echo form_dropdown('assigned_to',$employees, set_value('assigned_to'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Due Date:');?></td>
    <td><?php echo form_input('datedue',set_value('datedue')); ?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Task: ');?></td>
    <td><select id="tasks"></select></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Assigned Qty: ');?></td>
    <td><?php echo form_input('assigned_quantity',set_value('assigned_quantity'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('UOM: ');?></td>
    <td><?php echo form_input(array('id'=>'uname'));?></td>
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
    <td class="label"><?php echo form_label('BOM: ');?></td>
    <td><?php echo form_dropdown('bom_fk',$boms, set_value('bom_fk'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Shift: ');?></td>
    <td><?php echo form_dropdown('shift',array(''=>'--','1'=>'1st','2'=>'2nd','3'=>'3rd'), set_value('shift'));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Description: ');?></td>
    <td><textarea name="description" rows="5"></textarea></td>
</tr>
<tr>
    <td colspan="4">
	    <?php echo form_hidden('assigned_by',$this->session->userdata('userid'));?>
	    <?php echo form_hidden('prodname_fk');?>
	    <?php echo form_hidden('task_fk');?>
    </td>
</tr>
<tr>
    <td colspan=4 class="label"><?php echo form_submit('','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php echo form_close();?>
</table>
<?php echo validation_errors(); ?>















