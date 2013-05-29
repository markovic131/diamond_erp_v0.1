$(document).ready(function(){
	
		$("#deldialog").hide();
		
		$("#delete, .del_icon").click(function() {
			
			var link = $(this).attr('href');
			
			//$("#deldialog").css('display','inline');
			$("#deldialog").dialog({ modal: true,
				resizable: false,
				position: 'center',
				title:'Delete',
				buttons: {
					"Delete": function() { window.location.href = link;},
					"Cancel": function() { $(this).dialog('close'); },	
			 	}
			 });
			return false;
			
		});

});