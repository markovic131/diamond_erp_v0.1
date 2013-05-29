<script>
	$(document).ready(function() {
		$( "#datefrom" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url()."assets/calendar.gif" ;?>",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$( "#dateto" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url()."assets/calendar.gif" ;?>",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
	});
</script>
<h2><?php echo $heading?></h2>
<hr>
<table class="data_forms">
<tr> 
    <td class="label"><?php $this->load->view($flashes); ?></td>
   	<td><?php echo form_open('employees/payroll');?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('Employee:');?></td>
    <td><?php echo form_dropdown('employee',$employees, set_value('employee')); ?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('From:');?></td>
    <td><?php echo form_input('datefrom',(!isset($datefrom) ? '' : $datefrom),'id="datefrom"'); ?></td>
</tr>
<tr>
    <td class="label"><?php echo form_label('To:');?></td>
    <td><?php echo form_input('dateto',(!isset($dateto) ? '' : $dateto),'id="dateto"'); ?></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td><?php echo form_submit('submit','Calculate');?></td>
</tr>
</table>
    <?php echo form_close();?>

<?php $this->load->view($flashes); ?>
<hr>
<table class="master_table">
<?php if (isset($results) && is_array($results) && count($results)):?>
	<tr>
		<th>Tasks</th>
		<th>Total Quantity</th>
		<th>Unit Rate</th>
		<th>Total</th>
		<th></th>
	</tr>
	<?php foreach($results as $row):?>
		<tr>
			<td><?php echo $row->taskname;?></td>
			<td><?php echo $row->final_quantity . ' ' . $row->uname;?></td>
			<td><?php echo $row->rate_per_unit;?></td>
			<td><?php echo $row->rate_per_unit * $row->final_quantity;?></td>
			<td>&nbsp;</td>
		</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="10" class="no_records"><span class="warning">No Records Found!</span></td>
	</tr>
<?php endif;?>
</table>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>