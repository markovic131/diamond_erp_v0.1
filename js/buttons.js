$(document).ready(function() {
	
	//Disable the form Submit button, preventing multiple inserts
	$('form').submit(function() {
	    $(this).submit(function() {
	        return false;
	    });
	    return true;
	});
	
		
});

