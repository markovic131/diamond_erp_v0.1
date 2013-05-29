<script type="text/javascript">

$(document).ready(function() {
        jQuery("#grid6").jqGrid({
            url:'<?php echo site_url('user_group/grid');?>',
            datatype: "json",
            mtype: "post",
            height: "100%",
            autowidth: true,
            colNames:['Index','User Group'],
            colModel:[
                {name: "id",index:"id",width:20, sorttype:"int", align:"center",editable: false,editrules:{edithidden:true,readonly:true}},
                {name: "ugroup",index:"ugroup", sorttype:"text", editable:true, edittype: "text", editrules:{required:true}}
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
           		{reloadAfterSubmit:false, closeAfterEdit:true,url:'<?php echo site_url("user_group/edit");?>'}, // edit options
            	{reloadAfterSubmit:true, closeAfterAdd:true,url:'<?php echo site_url("user_group/insert");?>'}, // add options
           		{reloadAfterSubmit:false,url:'<?php echo site_url("user_group/delete");?>' }, // del options
           		{}
        );
});
    


</script>
<h2><?php echo $heading; ?></h2>
<hr>

<table id="grid6" cellpadding="0" cellspacing="0"></table>
<div id="pager" class="scroll" style="text-align: center;"></div>