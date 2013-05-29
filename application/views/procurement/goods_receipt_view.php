<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('inventory/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('inventory/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>	
<hr>
	<dl>
        <dt>Received on:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>
        <dt>Received by:</dt>
        <dd><?php echo $master[0]->lname. ' '.$master[0]->fname;?></dd>
        <dt>Order date:</dt>
        <dd><?php echo ($master[0]->dateoforder == NULL ? '-' : $master[0]->dateoforder);?></dd>
        <dt>Vendor:</dt>
        <dd><?php echo $master[0]->company;?></dd>
        <dt>Product:</dt>
        <dd><?php echo $master[0]->prodname;?></dd>
        <dt>Quantity:</dt>
        <dd><?php echo $master[0]->quantity .' '.  $master[0]->uname;?></dd>
        <dt>Price:</dt>
        <dd><?php echo ($master[0]->price == NULL ? '-' : $master[0]->price);?></dd>
        <dt>Expiration date:</dt>
        <dd><?php echo ($master[0]->dateofexpiration == NULL ? '-' : $master[0]->dateofexpiration);?></dd>
        <dt>Expires in:</dt>
        <dd>
        <?php 
        if(!isset($master[0]->dateofexpiration) && timespan(time(),mysql_to_unix($master[0]->dateofexpiration)) == '1 Second') 
        	echo '-';
        elseif (isset($master[0]->dateofexpiration) && timespan(time(),mysql_to_unix($master[0]->dateofexpiration)) == '1 Second')
        	echo 'Expired';
        else
        	echo timespan(time(),mysql_to_unix($master[0]->dateofexpiration)); 
        
        ?></dd>
        <dt>Status:</dt>
        <dd><?php echo $master[0]->status;?></dd>
        <dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>   
	</dl>

<hr>
<span class="label"><input type="button" value="Back" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>