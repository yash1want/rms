$(document).ready(function(){
	$('#form_id').on('change', '.shortage', function(){
 		var id = $(this).attr('id');
	    DoCalculation(id);
 	});

	function DoCalculation(fieldId)
	{
		var _fieldId = fieldId.split('-');
        var field_tot  = $('#'+fieldId).val();
		var fieldOne  = $('#'+_fieldId[0]+'-req_proposed-'+_fieldId[2]).val();
		var fieldTwo  = $('#'+_fieldId[0]+'-pos_existing_strength-'+_fieldId[2]).val();
		
		var total = parseFloat(fieldOne) - parseFloat(fieldTwo);
		//console.log(total);
		
		if(!isNaN(total)){
			//if(field_tot == Math.abs(total)) COmmented by Shweta Apale on 13-06-2022
			if(field_tot == total)
			{
				$('#'+fieldId).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('For (-) Shortage / (+) Excess ( Requirement / Proposed - In Position / Existing Strength ) is not validating. Kindly correct before proceeding');
				 $('#'+fieldId).val('');
				 $('#'+fieldId).addClass('is-invalid');
			}
		}
	}


});