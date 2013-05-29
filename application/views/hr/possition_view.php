<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('possitions/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('possitions/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>
<hr>
	<dl>
        <dt>Possition Name:</dt>
        <dd><?php echo $master[0]->possition;?></dd>
        
        <dt>Department:</dt>
        <dd><?php echo $master[0]->department;?></dd>
        
        <dt>Base Salary:</dt>
        <dd><?php echo ($master[0]->base_salary == 0 ? '-' : $master[0]->base_salary);?></dd>
        
        <dt>Bonus:</dt>
        <dd><?php echo ($master[0]->bonus == 0 ? '-' : $master[0]->bonus . '%'); ?></dd>
        
        <dt>Commision:</dt>
        <dd><?php echo ($master[0]->commision == 0 ? '-' : $master[0]->commision. '%'); ?></dd>
        
        <dt>Requirements:</dt>
        <dd><?php echo ($master[0]->requirements == NULL ? '-' : $master[0]->requirements); ?></dd>
        
        <dt>Status:</dt>
        <dd><?php echo $master[0]->status;?></dd>
        
        <dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>
        
        <dt>Description:</dt>
        <dd><?php echo ($master[0]->description == NULL ? '-' : $master[0]->description);?></dd>   
	</dl>

<hr>
<span class="label"><input type="button" value="Back" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>