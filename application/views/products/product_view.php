<h2><?php echo $heading; ?></h2>
<hr>
<div id="buttons">
<a href="<?php echo site_url('products/edit/'.$master[0]->id);?>" class="button"><span class="edit">Edit</span></a>
<a href="<?php echo site_url('products/delete/'.$master[0]->id);?>" class="button" id="delete"><span class="delete">Delete</span></a>
</div>
<hr>
	<dl>
        <dt>Product:</dt>
        <dd><?php echo $master[0]->prodname;?></dd>
        <dt>Code:</dt>
        <dd><?php echo $master[0]->code;?></dd>
        <dt>Product Type:</dt>
        <dd><?php echo $master[0]->ptname;?></dd>
		<dt>Product Category:</dt>
        <dd><?php echo $master[0]->pcname;?></dd>
        <dt>Warehouse:</dt>
        <dd><?php echo $master[0]->wname;?></dd>
        <dt>Base Unit:</dt>
        <dd><?php echo $master[0]->base_unit . ' ' . $master[0]->uname;?></dd>
        <dt>Retail Price:</dt>
        <dd><?php echo $master[0]->retail_price;?></dd>
        <dt>Commision:</dt>
        <dd><?php echo $master[0]->commision;?></dd>
        <dt>Is Saleable:</dt>
        <dd><?php echo $master[0]->is_saleable;?></dd>
        <dt>Alert Qty.:</dt>
        <dd><?php echo $master[0]->alert_quantity. ' ' . $master[0]->uname;?></dd>  
        <dt>Status:</dt>
        <dd><?php echo $master[0]->status;?></dd>
        <dt>Date of Entry:</dt>
        <dd><?php echo $master[0]->dateofentry;?></dd>   
	</dl>

<hr>
<span class="label"><input type="button" value="Back" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></span>
<div id="deldialog"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete selected record?</div>