$(document).ready(function(){
	$('#form_id').on('blur', '.total_bore', function(){
 		var id = $(this).attr('id');
	    doCalculation(id,'drilled_boreholes');
 	});
 	$('#form_id').on('blur', '.total_mtr', function(){
 		var id = $(this).attr('id');
	    doCalculation(id,'total_mtr');
 	});
	
});
function doCalculation(elementId,field)
{
	var single_id = elementId.split('-');
 	var elementValue = $('#'+elementId).val();
 	var fieldOneValue  = $('#'+single_id[0]+'-core_'+field+'-'+single_id[2]).val();
 	var fieldTwoValue  = $('#'+single_id[0]+'-noncore_'+field+'-'+single_id[2]).val();

	var total = parseFloat(fieldOneValue) + parseFloat(fieldTwoValue);
	if(!isNaN(total)){
		if(Number(total) == Number(elementValue))
		{
			$('#'+elementId).removeClass('is-invalid');
			return true;
		}else{
				
			showAlrt('Total is not validating. Kindly correct before proceeding');
			 $('#'+elementId).val('');
			 $('#'+elementId).addClass('is-invalid');
		}
	}
}