<script type="text/javascript">

	var products = [];
	
	// Function that updates product table (which contains "No records!" in your image attached)
	function updateTable() {
		
	  // This variable should contain table where the records should be shown, adjust the selector accordingly
	  var table = $("table#detail")[0];
	  //alert(table);
	  
	  // Remove all the rows (except the first one - header row)
	  while (table.rows.length > 1)
	    table.deleteRow(1);
	    
	  // Add as many rows as there are number of products in the array
	  while (table.rows.length < products.length + 1) {
	    var row = table.insertRow(-1);
	    // Add as many cells to the new row as there are in the header row
	    while (row.cells.length < table.rows[0].cells.length)
	      row.insertCell(-1);
	  }
	    
	  // Update information
	  for (var i = 0; i < products.length; i++) {
	    table.rows[i + 1].cells[0].innerHTML = i+1;
	    //table.rows[i + 1].cells[1].innerHTML = products[i].id;
	    table.rows[i + 1].cells[1].innerHTML = products[i].prodname;
	    table.rows[i + 1].cells[2].innerHTML = products[i].quantity;
	    table.rows[i + 1].cells[3].innerHTML = products[i].uname;
	    table.rows[i + 1].cells[4].innerHTML = "<a href=\"javascript:void(0)\" class=\"del_icon\" onclick=\"removeRecord(" + i + ")\">&nbsp;</a>";
	  }
	}
	
	// 'index' refers to an index of the object inside the 'products' array
	function removeRecord(index) {
	  products.splice(index, 1);
	  updateTable();
	}

	//Dropdown menu populating! PRODUCTS
	$.getJSON("<?php echo site_url('products/dropdown/yes'); ?>", function(result) {
        var optionsValues = "<select id='product'>";
        JSONObject2 = result;
        optionsValues += '<option value="">' + '--' + '</option>';
        $.each(result, function() {
                optionsValues += '<option value="' + this.id + '">' + this.prodname + '</option>';
        });
        optionsValues += '</select>';
        var options = $("select#product");
        options.replaceWith(optionsValues);  
    });
    
	// Dropdown menu populating! COMPONENTS
	$.getJSON("<?php echo site_url('products/dropdown/no'); ?>", function(result) {
        var optionsValues = "<select id='component'>";
        JSONObject = result;
        optionsValues += '<option value="">' + '--' + '</option>';
        $.each(result, function() {
                optionsValues += '<option value="' + this.id + '">' + this.prodname + '</option>';
        });
        optionsValues += '</select>';
        var options = $("select#component");
        options.replaceWith(optionsValues);  
    });
	
	$(document).ready(function() {
			    
		$("#uname, #category, #code, #uom, #date, #prodname_fk").attr("disabled", "disabled");
		$("input#uom").val("");
		$("input#category").val("");
		$("input#code").val("");
		$("input#uname").val("");
		//OnChange for Products dropdown menu
		$("select#product").live('change',function() {
				if(this.selectedIndex == '')
				{ 
					$("input#uname").val('');  
					return false;	
				} 
			  $("input#uname").val(JSONObject2[this.selectedIndex-1].uname);
			});	
		
		//OnChange for Components dropdown menu
		$("select#component").live('change',function() {
				if(this.selectedIndex == '')
				{
					$("input#code").val('');  
					$("input#category").val('');  
					$("input#uom").val('');  
					return false;	
				}
			  $("input#code").val(JSONObject[this.selectedIndex-1].code);  
			  $("input#category").val(JSONObject[this.selectedIndex-1].pcname);  
			  $("input#uom").val(JSONObject[this.selectedIndex-1].uname);
			});			
			//Functions following the click of "ADD" button
			$("#add").click(function(){

			  var prodname_fk = $("select#component").val();
			  var prodname = $("select#component option:selected").text(); //only for display reasons
			  var quantity = $("#quantity").val(); 
			  var uom = $("#uom").val(); //only for display reasons

				  //VALIDATION: Checks if the product or quantity has not been selected
				  if (quantity == '' || prodname_fk == '')
				  {
				    alert("Please select component and quantity!");
				    return false;
				  }
				  else if (quantity == 0)
				  {
					alert("Please enter valid quantity!");
					$("#quantity").focus();
					return false;
				  }
				  //-------------------------------------------------------------------
			  
			  // Check if product already exists and increase it's quantity instead of adding new record
			  var exists = false;
			  for (var i = 0; i < products.length; i++) {
			    // I assume ID is the key that should be matched inside the list of products
			    if (products[i].id == prodname_fk) {
			      exists = true;
			      // quantity is converted to number to make sure the number is increased instead of concatenating the numbers as strings
			      products[i].quantity += Number(quantity);
			      break;
			    }
			  }
			  //Pushes the Objects(products [id,quantity,prodname,uom]) into the Array  
			  if (!exists)
			    products.push({ id: prodname_fk, prodname: prodname, uname:uom, quantity: Number(quantity) });
			    
			  // Update the information of the product table (please refer to the function declared above)
			  updateTable();

			  //Emptys the product and quantity of the COMPONENTS after successfull ADD
			  $("select#component").val("");
			  $("#quantity").val("");
			  return false;
			});

			//SUBMITS the data to the Server
			$("#bom").submit(function(){
				var prodname_fk = $("select#product").val(); 
				var quantity = $("input[name=quantity]").val();

				if (quantity == '' || prodname_fk == '')
				  {
				    alert("Please select product and quantity!");
				    $("select[name=product]").focus();
				    return false;
				  }
				  else if (quantity <= 0)
				  {
					  alert("Please enter valid quantity!");
					  $("input[name=quantity]").focus();
					  return false;
				  }

				  if(products.lenght == 0)
				  {
					  alert("Please add at least one component!");
					  $("select#component").focus();
				      return false;
				  }

					//Converts the JavaScript array into JSON object
					var components = JSON.stringify(products);
					//POSTs the JSON object (with components) along with prodname_fk(master) and quantity(master)
					$.post("<?php echo site_url('boms/insert'); ?>",
						   {components:components,prodname_fk:prodname_fk,quantity:quantity},
						   function(data){
							   //Upon execution of the php scirpt, redirects to BOMS, with corresponding success/error message (Flash)
							   	location.replace("<?php echo site_url('boms'); ?>");
						   },"json"
						   
					   );
				return false;   
			});
			

	});
</script>
<h2><?php echo $heading; ?></h2>
<hr>
<div class="master_detail">
    <table class="data_forms">
        <?php echo form_open('',array('id'=>'bom'));?>
        <tr>
         	<td class="label"><?php echo form_label('Product: ');?></td>
            <td><select id="product"></select></td>

        	<td class="label"><?php echo form_label('Quantity: ');?></td>
            <td><?php echo form_input('quantity', set_value('quantity'));?></td>

           	<td class="label"><?php echo form_label('UOM: ');?></td>
            <td><?php echo form_input(array('id'=>'uname',set_value('uname')));?></td>      
        </tr>
        
        <tr>
            <td colspan="6"><hr></td>
        </tr>
    </table >

    <table class="data_forms_dyn">
    	<tr>
    		<td class="detail_header">Code</td>
    	    <td class="detail_header">Component</td>
    	    <td class="detail_header">Category</td>
    	    <td class="detail_header">Quantity</td>
    	    <td class="detail_header">UOM</td>
    	   
    	</tr>
    	<tr>
    		<td><?php echo form_input(array('id'=>'code','size'=>5));?></td>
    	    <td><select id="component"></select></td>
    	    <td><?php echo form_input(array('id'=>'category'));?></td>
    	    <td><?php echo form_input(array('id'=>'quantity','size'=>3));?></td>
    	    <td><?php echo form_input(array('id'=>'uom','size'=>5));?></td>
    	    
    	  	<td><a href="#" class="button" id="add"><span class="add">Add</span></a></td>
    	   
    	</tr>
    	<tr>
    		<td colspan="7"><hr></td>
    	</tr>
    
    
    </table>
    
	<table class="master_table" id="detail">
    	<tr>
    		<th></th>
    		<th>Component</th>
    		<th>Quantity</th>
    		<th>UOM</th>
    		<th></th>
    	</tr>
    
    </table>
    <table class="data_forms">
    	<tr>
    		<td ><hr></td>
    	</tr>
    	<tr>
    		<td class="label"><?php echo form_submit('','Save');?>
    		<input type="button" value="Cancel" onClick="document.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"></td>
    	</tr>
    </table>
</div>
<?php echo form_close();?>














