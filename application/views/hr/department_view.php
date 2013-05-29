<script type="text/javascript">
  //<![CDATA[
	$(document).ready(function() {
        jQuery("#grid6").jqGrid({
            url:'<?php echo site_url('departments/grid');?>',
            datatype: "json",
            mtype: "post",
            height: "100%",
            autowidth: true,
            colNames:['Index','Department'],
            colModel:[
                {name: "id",index:"id",width:20, sorttype:"int", align:"center",editable: false,editrules:{edithidden:true,readonly:true}},
                {name: "department",index:"department", sorttype:"text", editable:true, edittype: "text", editrules:{required:true}}
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
           		{reloadAfterSubmit:false, closeAfterEdit:true,url:'<?php echo site_url("departments/edit");?>'}, // edit options
            	{reloadAfterSubmit:true, closeAfterAdd:true,url:'<?php echo site_url("departments/insert");?>'}, // add options
           		{reloadAfterSubmit:false,url:'<?php echo site_url("departments/delete");?>' }, // del options
           		{}
        );
	});
    
//]]>

</script>
<h2><?php echo $heading?></h2>

<hr>
<table id="grid6" cellpadding="0" cellspacing="0"></table>
<div id="pager" class="scroll" style="text-align: center;"></div>