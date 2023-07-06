$(document).ready(function(){
	$('#form_id').on('blur', '.tot', function(){
 		var id = $(this).attr('id');
	    doCalculation(id);
 	});
 	$('#form_id').on('blur', '.grand_tot', function(){
 		var id = $(this).attr('id');
	    doTotalCalculation(id);
 	});

});


	
function doCalculation(elementId)
{
	var fieldId = elementId.split('-'); 
	var fieldValue = $('#'+elementId).val();
	var fieldOne = $('#forest_quant-'+fieldId[1]).val();
	var fieldTwo = $('#non_forest_quant-'+fieldId[1]).val();
	var total = parseFloat(fieldOne) + parseFloat(fieldTwo);

	if(!isNaN(total))
	{
		if(Number(total)==Number(fieldValue))
		{
			$('#'+elementId).removeClass('is-invalid');
			return true;
		}else{
			showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#'+elementId).val('0');
			$('#'+elementId).addClass('is-invalid');
		}
	}

}


function doTotalCalculation(elementId)
{
	var grandTotal =0;
	var fieldId = elementId.split('-'); 
	var fieldValue = $('#'+elementId).val();
	$("input[name='total[]']").each(function () {
		if($(this).val() != ''){
			grandTotal += parseFloat($(this).val());
			
			grandTotal1 = Number(grandTotal).toFixed(2);
		}
	});

	if(!isNaN(grandTotal))
	{
		if(Number(grandTotal1)==Number(fieldValue))
		{
			$('#'+elementId).removeClass('is-invalid');
			return true;
		}else{
			showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#'+elementId).val('0');
			$('#'+elementId).addClass('is-invalid');
		}
	}
}
