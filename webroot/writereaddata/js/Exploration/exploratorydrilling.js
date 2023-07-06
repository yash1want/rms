$(document).ready(function(){
	
	$('#form_id').on('blur', '.tot_borehole', function(){
 		var id = $(this).attr('id');
	    doCalculation(id);
 	});
 	$('#form_id').on('blur', '.tot_meter', function(){
 		var id = $(this).attr('id');
	    doMeterCalculation(id);
 	});
});
function doCalculation(elementId)
{
	var single_id = elementId.split('-');
    var field_val  = $('#'+elementId).val();
    var fieldOne  = $('#'+single_id[0]+'-core_drilled_boreholes-'+single_id[2]).val();
    var fieldTwo  = $('#'+single_id[0]+'-noncore_drilled_boreholes-'+single_id[2]).val();
    var total = parseFloat(fieldOne)+parseFloat(fieldTwo);
    
    if(!isNaN(total)){
		if(Number(field_val) == Number(total))
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
function doMeterCalculation(elementId)
{
	var single_id = elementId.split('-');
    var field_val  = $('#'+elementId).val();
    var fieldOne  = $('#'+single_id[0]+'-core_total_mtr-'+single_id[2]).val();
    var fieldTwo  = $('#'+single_id[0]+'-noncore_total_mtr-'+single_id[2]).val();
    var total = parseFloat(fieldOne)+parseFloat(fieldTwo);
    
    if(!isNaN(total)){
		if(Number(field_val) == Number(total))
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