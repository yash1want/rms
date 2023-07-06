$(document).ready(function(){
 	setTimeout(function() {
 		var est_res_tot = $('#est_res-tot').val();
 		var prop_rom_tot = $('#prop_rom-tot').val();
	  $('#addMoreRow').prepend("<tr><td colspan='4' class='text-right'><b>Total : </b></td><td><div><input name='est_res_tot' type='text' id='est_res_tot' class='form-control input-field cvOn cvNotReq cvNum estimate_tot' value='"+est_res_tot+"'></div><div class='err_cv'></div></td><td><div><input name='prop_rom_tot' type='text' id='prop_rom_tot' class='form-control input-field cvOn cvNotReq cvNum propos_tot' value='"+prop_rom_tot+"'></div><div class='err_cv'></div></td><td colspan='5'>&nbsp;</td></tr>");
	}, 100);
	$('#form_id').on('blur', '.prop_rom', function(){
 		var id = $(this).attr('id');
	    doCalculation(id);
 	});
 	$('#form_id').on('blur', '.estimate_tot', function(){
 		var elementId = $(this).attr('id');
    	var elementName = $(this).attr('name');
	    getFinalTotal(elementId,elementName);
 	});
 	$('#form_id').on('blur', '.propos_tot', function(){
 		var elementId = $(this).attr('id');
    	var elementName = $(this).attr('name');
	    getFinalTotal(elementId,elementName);
 	});
		

	// To blank total fields on clicking Add More button by Shweta Apale on 13-06-2022
	$('#form_id').on('click', '#add_more', function () {
		var id = $(this).attr('id');
		doTotalBlank(id);
	});
	
	
	// Added on 14-06-2022 by Shweta Apale change request
	$('#form_id').on('blur', '.estimate_tot ', function () {
		var id = $(this).attr('id');
		DoCompareEstimateReserveStopesWithReseverQuantity(id);
	});

	// Added on 14-06-2022 by Shweta Apale change request
	$('#form_id').on('blur', '.propos_tot ', function () {
		var id = $(this).attr('id');
		DoCompareProposedRomWithReseverQuantity(id);
	});


});

function doCalculation(prop_rom)
{
	var single_id = prop_rom.split('-');
    var field_val  = $('#'+prop_rom).val();
    var fieldOne  = $('#'+single_id[0]+'-est_res-'+single_id[2]).val();
	
    if(!isNaN(fieldOne)){
		if(Number(field_val) <= Number(fieldOne))
		{
			$('#'+prop_rom).removeClass('is-invalid');
			return true;
		}else{
				
			showAlrt('This value/quantity will be equal to or less than "Estimated Reserve in Stope (t)" ');
			 $('#'+prop_rom).val('');
			 $('#'+prop_rom).addClass('is-invalid');
		}
	}
}
function getFinalTotal(fieldId,fieldName)
{
	
	var sum_prop= 0;
	var _fieldName = fieldName.split('_'); 
	_fieldName = _fieldName[0]+'_'+_fieldName[1]; 
	$("input[name='"+_fieldName+"[]']").each(function () {
		var _elementId = $(this).attr('id');
		var nameFirst = _elementId.split('_');
		if ($(this).val() != '') { //Added by Shweta Apale on 12-08-2022
			sum_prop += parseFloat($(this).val());
		}
		
	});
	var getTotal = $('#'+fieldId).val();
	if(!isNaN(getTotal))
	{
		if(Number(getTotal)==Number(sum_prop))
		{
			$('#'+fieldId).removeClass('is-invalid');
			return true;
		}else{
			showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#'+fieldId).val('0');
			$('#'+fieldId).addClass('is-invalid');
		}
	}
}


	// To blank total fields on clicking Add More button by Shweta Apale on 13-06-2022
	function doTotalBlank(elementId) {
		$('#est_res_tot').val('');
		$('#est_res_tot').addClass('is-invalid cvOn cvReq');

		$('#prop_rom_tot').val('');
		$('#prop_rom_tot').addClass('is-invalid cvOn cvReq');
	}
	
	
	// Added by Shweta Apale on  14-06-2022 change request
	function DoCompareEstimateReserveStopesWithReseverQuantity(elementId){
		var total_rom = $('#'+elementId).val();
		var reserve_qt = $('#reserveQuantity').val();
				
		console.log(total_rom);
		console.log(reserve_qt);

		if(parseFloat(total_rom) > parseFloat(reserve_qt)){
			showAlrt('Total of Estimated Reserve in Stope (t) should be less than equal to Reserve Quantity(t)[2B.2.4.12 Calculation of Reserve I] . Kindly correct before proceeding');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}

	// Added by Shweta Apale on  14-06-2022 change request
	function DoCompareProposedRomWithReseverQuantity(elementId){
		var total_rom = $('#'+elementId).val();
		var reserve_qt = $('#reserveQuantity').val();

		if(parseFloat(total_rom) > parseFloat(reserve_qt)){
			showAlrt('Total of Proposed ROM production from Stope (t) should be less than equal to Reserve Quantity(t)[2B.2.4.12 Calculation of Reserve I] . Kindly correct before proceeding');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}