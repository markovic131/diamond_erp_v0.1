<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('tasks/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('tasks/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>
<hr>
	<dl>
        <dt>Name:</dt>
        <dd><?php echo $master[0]->taskname;?></dd>
        <dt>Base Unit:</dt>
        <dd><?php echo $master[0]->base_unit .' '.$master[0]->uname;?></dd>
        <dt>Basic Rate Unit:</dt>
        <dd><?php echo $master[0]->rate_per_unit;?></dd>
        <dt>Rate Unit Bonus:</dt>
        <dd><?php echo ($master[0]->rate_per_unit_bonus == NULL ? '-' : $master[0]->rate_per_unit_bonus);?></dd>
        <dt>Status:</dt>
        <dd><?php echo $master[0]->status;?></dd>
        <dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>
        
        <dt>Note:</dt>
        <dd><?php echo ($master[0]->description == NULL ? '-' : $master[0]->description);?></dd>   
	</dl>

<hr>
<span class="label"><input type="button" value="Back" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>