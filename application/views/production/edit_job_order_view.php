<script type="text/javascript">

	//Dropdown menu populating! PRODUCTS
	$.getJSON("<?php echo site_url('products/dropdown/yes'); ?>", function(result) {
	    var optionsValues = "<select id='products'>";
	    JSONObject = result;
	    optionsValues += '<option value="">' + '--' + '</option>';
	    $.each(result, function() {
	           
	          //Selected the correct value retreived from the database
	            if (this.id == <?php echo $job_order['0']->prodname_fk;?>){
	            	 optionsValues += '<option value="' + this.id + '" selected="selected">' + this.prodname + '</option>';
	            	 $("input[name=prodname_fk]").val(this.id);   
	            }
	            else {
	            	 optionsValues += '<option value="' + this.id + '">' + this.prodname + '</option>';
	            }
	    });
	    optionsValues += '</select>';
	    var options = $("select#products");
	    options.replaceWith(optionsValues);  
	});
	
	//Dropdown menu populating! TASKS
	$.getJSON("<?php echo site_url('tasks/dropdown'); ?>", function(result) {
	    var optionsValues = "<select id='tasks'>";
	    JSONObject2 = result;
	    optionsValues += '<option value="">' + '--' + '</option>';
	    $.each(result, function() {
		        //Selected the correct value retreived from the database
	            if (this.id == <?php echo $job_order['0']->task_fk;?>){
	            	 optionsValues += '<option value="' + this.id + '" selected="selected">' + this.taskname + '</option>';
	            	 $("input#uname").val(this.uname);
	            	 $("input[name=task_fk]").val(this.id);   
	            }
	            else {
	            	optionsValues += '<option value="' + this.id + '">' + this.taskname + '</option>';
	            }
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
		$( "input[name=datecompleted]" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url()."assets/calendar.gif" ;?>",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			minDate: +0,
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
		
		//OnChange for Products dropdown menu
		$("select#products").live('change',function() {
				if(this.selectedIndex == '')
				{ 
					$("input[name=prodname_fk]").val('');   
					return false;	
				}
			  $("input[name=prodname_fk]").val(JSONObject[this.selectedIndex-1].id);
			});	 	    	
	});

</script>

<h2><?php echo $heading; ?></h2>
<hr>
<table class="data_forms">
<?php echo form_open('job_orders/edit/'. $job_order[0]->id);?>
<tr>
    <td class="label"><?php echo form_label('Employee: ');?></td>
    <td><?php echo form_dropdown('assigned_to',$employees, set_value('assigned_to',$job_order['0']->assigned_to));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Due Date:');?></td>
    <td><?php echo form_input('datedue',set_value('datedue',$job_order['0']->datedue)); ?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Date Completed:');?></td>
    <td><?php echo form_input('datecompleted',set_value('datecompleted',$job_order['0']->datecompleted)); ?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Task: ');?></td>
    <td><select id="tasks"></select></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Assigned Qty: ');?></td>
    <td><?php echo form_input('assigned_quantity',set_value('assigned_quantity',$job_order['0']->assigned_quantity));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('UOM: ');?></td>
    <td><?php echo form_input(array('id'=>'uname','value' => set_value('uname',$job_order['0']->uname)));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Final Qty: ');?></td>
    <td><?php echo form_input('final_quantity',set_value('final_quantity',$job_order['0']->final_quantity));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Defect Qty: ');?></td>
    <td><?php echo form_input('defect_quantity',set_value('defect_quantity',$job_order['0']->defect_quantity));?></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('JO Status:');?></td>
	<td><?php echo form_dropdown('jstatus_fk',$jstatus,set_value('jstatus_fk', $job_order['0']->jstatus_fk));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Product: ');?></td>
    <td><select id="products"></select></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Shift: ');?></td>
    <td><?php echo form_dropdown('shift',array(''=>'--','1'=>'1st','2'=>'2nd','3'=>'3rd'), set_value('shift',$job_order['0']->shift));?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Description: ');?></td>
    <td><textarea name="description" rows="5"></textarea></td>
</tr>
<tr>
	<td class="label"><?php echo form_label('Status:');?></td>
	<td><?php echo form_dropdown('status',array('active'=>'Active','inactive'=>'Inactive'), set_value('status', $job_order['0']->status));?></td>
</tr>
<tr>
    <td colspan="4">
    	<?php echo form_hidden('prodname_fk');?>
	    <?php echo form_hidden('task_fk');?>
    </td>
</tr>
<tr>
    <td colspan=4 class="label"><?php echo form_submit('submit','Save');?>
	<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
</tr>
<?php echo form_close();?>
</table>
<?php echo validation_errors(); ?>















