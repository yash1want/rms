$(document).ready(function(){
	var first_submit_year = $('#first_submit_data').val();
	var data_1 = parseInt(first_submit_year)+1;
	var data_2 = parseInt(first_submit_year)+2;
	var data_3 = parseInt(first_submit_year)+3;
	var data_4 = parseInt(first_submit_year)+4;
	var data_5 = parseInt(first_submit_year)+5;
	
	$('#year_1').html(first_submit_year+'-'+data_1);
	$('#year_2').html(data_1+'-'+data_2);
	$('#year_3').html(data_2+'-'+data_3);
	$('#year_4').html(data_3+'-'+data_4);
	$('#year_5').html(data_4+'-'+data_5);
});