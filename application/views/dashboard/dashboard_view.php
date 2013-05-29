<div id="dashboard_wrapper">
	<div id="dash_title"><span id="dash_title">Dashboard</span></div>
	<div id="dash_stats">
		<table id="dash_stats_table">
		<caption><span class="dash_caption">Overview</span></caption>
			<tr>
				<td>Total Number of Orders:</td>
			 	<td align="right"><?php echo $total_orders;?></td>
			</tr>
			<tr>
				<td>Pending Orders:</td>
			 	<td align="right"><?php echo $waiting_approval;?></td>
			</tr>
			<tr>
				<td>Number of Partners:</td>
			 	<td align="right"><?php echo $total_partners;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			 	<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Total Number of Job Orders:</td>
			 	<td align="right"><?php echo $total_jo;?></td>
			</tr>
			<tr>
				<td>Uncomplete Job Orders:</td>
			 	<td align="right"><?php echo $uncomplete_jo;?></td>
			</tr>
			<tr>
				<td>Number of Employees:</td>
			 	<td align="right"><?php echo $total_emp;?></td>
			</tr>
			<tr>
				<td>Number of Products:</td>
			 	<td align="right"><?php echo $total_prod;?></td>
			</tr>
		
		
		</table>
	
	
	</div>
	<div id="dash_job_orders">
	<table class="master_table">
	<caption><span class="dash_caption">Latest Job Orders</span></caption>
	<?php if (isset($results2) && is_array($results2) && count($results2)):?>
	<tr>
    	<th></th>
    	<th>Date of Entry</th>
    	<th>Due Date</th>
    	<th>Task</th>
    	<th>Product</th>
    	<th>Worker</th>
    	<th>Qty/Duration</th>
    	<th>Shift</th>
    	<th></th>
    </tr>
		<?php foreach($results2 as $row):?>
		<tr>
				<td class="code" align="center"><?php echo anchor('job_orders/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
				<td align="center"><?php echo ($row->dateofentry == NULL ? '-' : mdate('%d/%m/%Y',mysql_to_unix($row->dateofentry))); ?></td>
				<td align="center"><?php echo ($row->datedue == NULL ? '-' : mdate('%d/%m',mysql_to_unix($row->datedue))); ?></td>
				<td><?php echo $row->taskname;?></td>
				<td><?php echo ($row->prodname == NULL ? '-' : $row->prodname); ?></td>
				<td><?php echo substr($row->lname,0,1) . '. ' . $row->fname ;?></td>
				<td><?php echo $row->assigned_quantity.' '.$row->uname;?></td>
				<td><?php echo ($row->shift == NULL ? '-' : $row->shift); ?></td>
				<td class="functions">
					<?php echo anchor('job_orders/edit/'.$row->id,'&nbsp;','class="edit_icon"');?>
				</td>
		</tr>
		<?php endforeach;?>
		<?php else:?>
			<tr>
				<td colspan="9" class="no_records"><span class="warning">No Records Found!</span></td>
			</tr>
	<?php endif;?>
	</table>
	</div>
	
	<div id="dash_orders">
	<table class="master_table">
	<caption><span class="dash_caption">Last 10 Orders</span></caption>
	<?php if (isset($results) && is_array($results) && count($results)):?>
	 <tr>
    	<th></th>
    	<th>Order Date</th>
    	<th>Customer</th>
    	<th>Desired Shipping</th>
    	<th>Order Status</th>
    	<th></th>
    </tr>
		<?php foreach($results as $row):?>
		<tr>
				<td class="code" align="center"><?php echo anchor('orders/view/'.$row->id,'&nbsp;','class="view_icon"');?></td>
				<td><?php echo mdate('%d/%m/%Y',mysql_to_unix($row->dateofentry)); ?></td>
				<td><?php echo $row->company;?></td>
				<td><?php echo ($row->desiredshipping == NULL ? '-' : mdate('%d/%m/%Y',mysql_to_unix($row->desiredshipping))); ?></td>
				<td><?php echo ($row->ostatus == NULL ? '-' : $row->ostatus); ?></td>
				<td class="functions">
				<?php echo anchor('orders/edit/'.$row->id,'&nbsp;','class="edit_icon"');?>
			</td>
		</tr>
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="9" class="no_records"><span class="warning">No Records Found!</span></td>
		</tr>
	<?php endif;?>
	</table>
	</div>
	
</div>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>