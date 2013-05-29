<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('job_orders/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('job_orders/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>
<hr>
	<dl>
        <dt>Employee:</dt>
        <dd><?php echo $master[0]->lname.' '.$master[0]->fname;?></dd>
        <dt>Product:</dt>
        <dd><?php echo ($master[0]->prodname == NULL ? '-' : $master[0]->prodname);?></dd>
        <dt>Task:</dt>
        <dd><?php echo $master[0]->taskname;?></dd>
        <dt>Assigned Qty:</dt>
        <dd><?php echo $master[0]->assigned_quantity . ' ' . $master[0]->uname ;?></dd>
        <dt>Final Qty:</dt>
        <dd><?php echo ($master[0]->final_quantity == NULL ? '-' : ($master[0]->final_quantity. ' ' . $master[0]->uname));?></dd>
        <dt>Defect Qty:</dt>
        <dd><?php echo ($master[0]->defect_quantity == NULL ? '-' : ($master[0]->defect_quantity. ' ' . $master[0]->uname));?></dd>
        <dt>Shift:</dt>
        <dd><?php echo ($master[0]->shift == NULL ? '-' : $master[0]->shift);?></dd>
        <dt>Due Date:</dt>
        <dd><?php echo ($master[0]->datedue == NULL ? '-' : $master[0]->datedue);?></dd>
        <dt>Description:</dt>
        <dd><?php echo ($master[0]->description == NULL ? '-' : $master[0]->description);?></dd>
        <dt>Status:</dt>
        <dd><?php echo $master[0]->status;?></dd>
        <dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>   
	</dl>

<hr>
<span class="label"><input type="button" value="Back" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>