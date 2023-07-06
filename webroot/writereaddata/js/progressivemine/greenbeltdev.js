 $(document).ready(function(){
 	setTimeout(function() {
	  $("#addmorebtn").remove();
	  	$('#ta-survival_rate-1').on('blur', function() {
		    var rate = $(this).val();
		    if(Number(rate) > 100)
		    {
		    	$('#ta-survival_rate-1').parent().parent().find('.err_cv:first').text('value should not be greater than 100');
		    }
		});
	}, 100);
 	
});
