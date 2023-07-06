$(document).ready(function(){
	var Eid = $('input[name=exist_min_method]:checked').attr('id');
	var Pid = $('input[name=prop_min_method]:checked').attr('id');
	$('#'+Eid).trigger('keyup'); 
	$('#'+Pid).trigger('keyup'); 

});




