$(document).ready(function(){
	
	$('#form_id').on('change', '.volume', function(){
 		var id = $(this).attr('id');
	    doCalculation(id);
 	});
 	
});

function doCalculation(elementId)
{
	var single_id = elementId.split('-');
    var field_val  = $('#'+elementId).val();

    var fieldOne  = $('#'+single_id[0]+'-length_m-'+single_id[2]).val(); 
    var fieldTwo  = $('#'+single_id[0]+'-width_m-'+single_id[2]).val(); 
    var fieldThree  = $('#'+single_id[0]+'-depth_m-'+single_id[2]).val(); 
    var total = parseFloat(fieldOne) * parseFloat(fieldTwo) * parseFloat(fieldThree);

	if(!isNaN(total)){
		if(Number(field_val) == Number(total))
		{
			$('#'+elementId).removeClass('is-invalid');
			return true;
			
		}else{
			showAlrt('For Total (Volume (m³) is not validating. Kindly correct before proceeding');
			 $('#'+elementId).val('');
			 $('#'+elementId).addClass('is-invalid');
		}
	}
}