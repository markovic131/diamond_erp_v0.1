<script type="text/javascript">
	$(document).ready(function() {
		//On change triggers AJAX POST call to corresponding function
		$("select#status").live('change',function() {
			
			var id = $(this).attr('name');
			var jstatus_fk = $(this).val();
			
			$.post("<?php echo site_url('job_orders/set_status'); ?>",
					   {id:id,jstatus_fk:jstatus_fk},
					   function(data){
						  // location.reload();
							  $("div.quick_message_filter").text(data.message);
							  setTimeout(function() {
								  $("div.quick_message_filter").empty();	
								}, 4000);
					   },"json"   
				   );
			return false;
		});
		//Inline Edit of Final Qunatity
		$('.quantity').editable('<?php echo site_url('job_orders/edit_final_qty'); ?>', {
	    	indicator : 'Saving...',
	    	tooltip   : 'Click to edit...',
	    	id : 'id',
	    	name : 'final_quantity'
	});
	});
</script>
<div class="quick_message_filter"></div>
<h2><?php echo $heading; ?></h2>
<hr>
<a href="<?php echo site_url('job_orders/insert');?>" class="button"><span class="add">New</span></a>
<div class="filers"> 
    <?php $this->load->view($flashes); ?>
    <?php echo form_open('job_orders/index');?>
    <?php echo form_label('Task:');?>
    <?php echo form_dropdown('task_fk', $tasks, set_value('task_fk')); ?>
    <?php echo form_label('Product:');?>
    <?php echo form_dropdown('prodname_fk', $products, set_value('prodname_fk')); ?>
    <?php echo form_label('Employee:');?>
    <?php echo form_dropdown('assigned_to', $employees, set_value('assigned_to')); ?>
    <?php echo form_label('Status:');?>
    <?php echo form_dropdown('jstatus_fk', $jostatus, set_value('jstatus_fk')); ?>
    <?php echo form_submit('','Filter');?>
    <?php echo form_close();?>
</div>
<table class="master_table">  
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
    	<th></th>
    	<th>Date of Entry</th>
    	<th>Due Date</th>
    	<th>Task</th>
    	<th>Product</th>
    	<th>Worker</th>
    	<th>Qty/Duration</th>
    	<th>Shift</th>
    	<th>Final Qty</th>
    	<th></th>
    	<th>Status</th>
    	<th></th>
    </tr>
	<?php foreach($results as $row):?>
	<tr id="<?php echo $row->id;?>">
			<td class="code" align="center"><?php echo anchor('job_orders/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
			<td align="center"><?php echo ($row->dateofentry == NULL ? '-' : mdate('%d/%m/%Y',mysql_to_unix($row->dateofentry))); ?></td>
			<td align="center"><?php echo ($row->datedue == NULL ? '-' : mdate('%d/%m',mysql_to_unix($row->datedue))); ?></td>
			<td><?php echo $row->taskname;?></td>
			<td><?php echo ($row->prodname == NULL ? '-' : $row->prodname); ?></td>
			<td><?php echo $row->lname . ' ' . $row->fname ;?></td>
			<td><?php echo $row->assigned_quantity.' '.$row->uname;?></td>
			<td><?php echo ($row->shift == NULL ? '-' : $row->shift); ?></td>
			<td class="quantity" id="<?php echo $row->id;?>"><?php echo ($row->final_quantity == NULL ? '-' : $row->final_quantity); ?></td>
			<td><?php echo $row->uname; ?></td>
			<td><?php echo form_dropdown($row->id,$jostatus,set_value($row->id,$row->jstatus_fk),'id="status"'); ?></td>
			<td class="functions">
				<?php echo anchor('job_orders/edit/'.$row->id,'&nbsp;','class="edit_icon"');?> | 
				<?php echo anchor('job_orders/delete/'.$row->id,'&nbsp;','class="del_icon"');?>
			</td>
	</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="13" class="no_records"><span class="warning">No Records Found!</span></td>
	</tr>
<?php endif;?>
</table>
<div class="pagination"><?php echo (isset($pagination) && $pagination == '') ? '' : 'Pages:'.$pagination; ?></div>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>