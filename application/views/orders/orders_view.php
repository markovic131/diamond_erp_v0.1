<script type="text/javascript">
	$(document).ready(function() {
		//On change triggers AJAX POST call to corresponding function
		$("select#status").live('change',function() {
			
			var id = $(this).attr('name');
			var ostatus_fk = $(this).val();
			
			$.post("<?php echo site_url('orders/set_status'); ?>",
					   {id:id,ostatus_fk:ostatus_fk},
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
	});
</script>
<div class="quick_message_filter"></div>
<h2><?php echo $heading?></h2>
<hr>
<a href="<?php echo site_url('orders/insert');?>" class="button"><span class="add">New</span></a>
<?php $this->load->view($flashes); ?>
<div class="filers"> 
    <?php $this->load->view($flashes); ?>
    <?php echo form_open('orders/index');?>
    <?php echo form_label('Customer:');?>
    <?php echo form_dropdown('partner_fk', $customers, set_value('partner_fk')); ?>
    <?php echo form_label('Order Status:');?>
    <?php echo form_dropdown('ostatus_fk', $order_status, set_value('ostatus_fk')); ?>
    <?php echo form_submit('','Filter');?>
    <?php echo form_close();?>
</div>
<table class="master_table">   
<?php if (isset($results) && is_array($results) && count($results) > 0):?>
	<tr>
    	<th></th>
    	<th>Order Date</th>
    	<th>Customer</th>
    	<th>Desired Shipping</th>
    	<th>Date Shipped</th>
    	<th>Order Status</th>
    	<th></th>
    </tr>
	<?php foreach($results as $row):?>
	<tr>
			<td class="code" align="center"><?php echo anchor('orders/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
			<td><?php echo mdate('%d/%m/%Y',mysql_to_unix($row->dateofentry));?></td>
			<td><?php echo $row->company;?></td>
			<td><?php echo ($row->desiredshipping == NULL ? '-' : mdate('%d/%m/%Y',mysql_to_unix($row->desiredshipping))); ?></td>
			<td><?php echo (($row->dateshipped == NULL) || ($row->dateshipped == '0000-00-00') ? '-' : mdate('%d/%m/%Y',mysql_to_unix($row->dateshipped))); ?></td>
			<td><?php echo form_dropdown($row->id, $order_status,set_value($row->id,$row->ostatus_fk),'id="status"'); ?></td>
			<td class="functions">
				<?php echo anchor('orders/edit/'.$row->id,'&nbsp;','class="edit_icon"');?> | 
				<?php echo anchor('orders/delete/'.$row->id,'&nbsp;','class="del_icon"');?>
			</td>
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