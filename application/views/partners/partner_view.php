<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('partners/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('partners/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>
<hr>
	<dl>
        <dt>Company:</dt>
        <dd><?php echo $master[0]->company;?></dd>
        <dt>Code:</dt>
        <dd><?php echo $master[0]->code;?></dd>
        <dt>Contact Person:</dt>
        <dd><?php echo $master[0]->contperson;?></dd>
        <dt>Partner Type:</dt>
        <dd><?php echo $master[0]->ptype;?></dd>

        <dt>Address:</dt>
        <dd><?php echo $master[0]->address;?></dd>
        <dt>City:</dt>
        <dd><?php echo $master[0]->name;?></dd>
        <dt>Zip Code:</dt>
        <dd><?php echo $master[0]->postalcode;?></dd>
        <dt>Phone:</dt>
        <dd><?php echo ($master[0]->phone1 == NULL ? '-' : $master[0]->phone1);?></dd>
        <dt>Phone 2:</dt>
        <dd><?php echo ($master[0]->phone2 == NULL ? '-' : $master[0]->phone2);?></dd>
        <dt>Fax:</dt>
        <dd><?php echo ($master[0]->fax == NULL ? '-' : $master[0]->fax);?></dd>
        <dt>Mobile:</dt>
        <dd><?php echo ($master[0]->mobile == NULL ? '-' : $master[0]->mobile);?></dd>
        <dt>Email:</dt>
        <dd><?php echo ($master[0]->email == NULL ? '-' : $master[0]->email);?></dd>
        <dt>Web Site:</dt>
        <dd><?php echo ($master[0]->web == NULL ? '-' : $master[0]->web);?></dd>

        <dt>Bank:</dt>
        <dd><?php echo ($master[0]->bank == NULL ? '-' : $master[0]->bank);?></dd>
        <dt>Account no.:</dt>
        <dd><?php echo ($master[0]->account_no == NULL ? '-' : $master[0]->account_no);?></dd>
        <dt>Tax no.:</dt>
        <dd><?php echo ($master[0]->tax_no == NULL ? '-' : $master[0]->tax_no);?></dd>
 
        <dt>User Group:</dt>
       <dd><?php echo ($master[0]->ugroup == NULL ? '-' : $master[0]->ugroup);?></dd>
        <dt>Username:</dt>
        <dd><?php echo ($master[0]->username == NULL ? '-' : $master[0]->username);?></dd>
        <dt>Status:</dt>
        <dd><?php echo $master[0]->status;?></dd>
        <dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>   
	</dl>

<hr>
<span class="label"><input type="button" value="Back" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>