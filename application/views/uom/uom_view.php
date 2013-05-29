<script type="text/javascript">

$(document).ready(function() {
        jQuery("#grid6").jqGrid({
            url:'<?php echo site_url('uom/grid');?>',
            datatype: "json",
            mtype: "post",
            height: "100%",
            autowidth: true,
            colNames:['Index','Unit of Measure','Description'],
            colModel:[
                {name: "id",index:"id",width:25, sorttype:"int", align:"center",editable: false,editrules:{edithidden:true,readonly:true}},
                {name: "uname",index:"uname",width:45, sorttype:"text", editable:true, edittype: "text", editrules:{required:true}},
                {name: "description",index:"description", sorttype:"text", editable:true, edittype: "textarea", editrules:{required:false}}
            ],
            gridview: true,
            pager: "#pager",
            viewrecords: true,
            sortname: "id",
            sortorder: "asc",
            rownumbers: true,
            jsonReader: {
                page: function (obj) { return 1; },
                total: function (obj) { return 1; },
                records: function (obj) { return obj.rows.length; }
            }
        });

		jQuery("#grid6").jqGrid('navGrid','#pager',
        	{edit:true,add:true,del:true}, //options
       		{reloadAfterSubmit:false, closeAfterEdit:true,url:'<?php echo site_url("uom/edit");?>'}, // edit options
        	{reloadAfterSubmit:true, closeAfterAdd:true,url:'<?php echo site_url("uom/insert");?>'}, // add options
       		{reloadAfterSubmit:false,url:'<?php echo site_url("uom/delete");?>' }, // del options
       		{}
      	);
}); 


</script>

<h2><?php echo $heading; ?></h2>
<hr>

<table id="grid6" cellpadding="0" cellspacing="0"></table>
<div id="pager" class="scroll" style="text-align: center;"></div>