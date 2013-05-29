<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('employees/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('employees/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>
<hr>
	<dl>
        <dt>Name:</dt>
        <dd><?php echo $master[0]->lname. ' '. $master[0]->fname;?></dd>
        <dt>Code:</dt>
        <dd><?php echo $master[0]->code;?></dd>
        <dt>Date of birth:</dt>
        <dd><?php echo $master[0]->dateofbirth;?></dd>
        <dt>SSN:</dt>
        <dd><?php echo $master[0]->ssn;?></dd>
        <dt>Gender:</dt>
        <dd><?php echo ($master[0]->gender == 'm' ? 'Male' : 'Female');?></dd>
        <dt>Marital status:</dt>
        <dd><?php echo $master[0]->mstatus;?></dd>

        <dt>Address:</dt>
        <dd><?php echo ($master[0]->address == NULL ? '-' : $master[0]->address);?></dd>
        <dt>City:</dt>
        <dd><?php echo ($master[0]->name == NULL ? '-' : $master[0]->name);?></dd>
        <dt>Zip Code:</dt>
        <dd><?php echo ($master[0]->postalcode == NULL ? '-' : $master[0]->postalcode);?></dd>
        <dt>Phone:</dt>
        <dd><?php echo ($master[0]->phone == NULL ? '-' : $master[0]->phone);?></dd>
        <dt>Mobile:</dt>
        <dd><?php echo ($master[0]->mobile == NULL ? '-' : $master[0]->mobile);?></dd>
        <dt>Company Mobile:</dt>
        <dd><?php echo ($master[0]->comp_mobile == NULL ? '-' : $master[0]->comp_mobile);?></dd>
        <dt>Email:</dt>
        <dd><?php echo ($master[0]->email == NULL ? '-' : $master[0]->email);?></dd>

        <dt>Bank:</dt>
        <dd><?php echo ($master[0]->bank == NULL ? '-' : $master[0]->bank);?></dd>
        <dt>Account no.:</dt>
        <dd><?php echo ($master[0]->account_no == NULL ? '-' : $master[0]->account_no);?></dd>
 
 		<dt>Possition:</dt>
        <dd><?php echo ($master[0]->possition == NULL ? '-' : $master[0]->possition);?></dd>
        <dt>User Group:</dt>
        <dd><?php echo ($master[0]->ugroup == NULL ? '-' : $master[0]->ugroup);?></dd>
        <dt>Username:</dt>
        <dd><?php echo ($master[0]->username == NULL ? '-' : $master[0]->username);?></dd>
        <dt>Status:</dt>
        <dd><?php echo $master[0]->status;?></dd>
        <dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->hire_date;?></dd>
        
        <dt>Note:</dt>
        <dd><?php echo ($master[0]->note == NULL ? '-' : $master[0]->note);?></dd>   
	</dl>

<hr>
<span class="label"><input type="button" value="Back" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>