$(document).ready(function(){
	
	$('#form_id').on('blur', '.prop_recovery', function(){
 		var id = $(this).attr('id');
	    DoCalculation(id);
 	});
 	$('#form_id').on('blur', '.prop_tot', function(){
 		var id = $(this).attr('id');
	    CalculateProposedWaste(id);
 	});

 	function DoCalculation(elementId)
 	{
 		var single_id = elementId.split('-');
        var field_val  = $('#'+elementId).val();
        var fieldOne  = $('#'+single_id[0]+'-prop_dump_handling_quant-'+single_id[2]).val();
		
        if(!isNaN(fieldOne)){
			if(Number(field_val) <= Number(fieldOne))
			{
				$('#'+elementId).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('This value/quantity will be equal to or less than "Proposed Dump Handling Quantity (t) (A)"');
				 $('#'+elementId).val('');
				 $('#'+elementId).addClass('is-invalid');
			}
		}
 	}
 	function CalculateProposedWaste(elementId)
 	{
 		var single_id = elementId.split('-');
 		var field_val  = $('#'+elementId).val();
 		var fieldOne  = $('#'+single_id[0]+'-prop_dump_handling_quant-'+single_id[2]).val();
 		var fieldTwo  = $('#'+single_id[0]+'-prop_recovery_saleable_min-'+single_id[2]).val();
 		
 		var total = parseFloat(fieldOne) - parseFloat(fieldTwo);

 		if(!isNaN(total)){
			if(Number(field_val) == Number(Math.abs(total)))
			{
				$('#'+elementId).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('For Proposed Waste Quantity (t) (A-B) (Proposed Dump Handling Quantity (t) (A) - Proposed Recovery of Saleable Mineral (t)(B)) is not validating. Kindly correct before proceeding');
				 $('#'+elementId).val('');
				 $('#'+elementId).addClass('is-invalid');
			}
		}
 	}

});