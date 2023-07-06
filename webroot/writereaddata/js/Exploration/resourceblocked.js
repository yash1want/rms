$(document).ready(function () {
	setTimeout(function () {
		var cross_tot = $('#tot_cross_sec_block').val();
		var mintype = $('#mintype').val();
		var rom_tot = $('#tot_vol').val();
		var saleable_tot = $('#tot_quant').val();


		if (mintype == 'ug') {
			//$('#addMoreRow').prepend("<tr><td colspan='2' class='text-right'><b>Total : </b></td><td><div><input name='total_cross_sec_block' type='text' id='total_cross_sec_block' class='form-control input-field cvOn  cvNum tot_cross' value='" + cross_tot + "'></div><div class='err_cv'></div></td><td colspan='3'>&nbsp;</td><td><div><input name='total_volume' type='text' id='tot-volume' class='form-control input-field cvOn cvNum tot-volume' value='" + rom_tot + "'></div><div class='err_cv'></div></td><td>&nbsp;</td><td><div><input name='total_res_quant' type='text' id='tot-res_quant' class='form-control input-field cvOn cvNum tot-res_quant' value='" + saleable_tot + "'></div><div class='err_cv'></div></td><td colspan='6'>&nbsp;</td></tr>");
			
			$('#addMoreRow').prepend("<tr><td colspan='6' class='text-right'><b>Total : </b></td><td><div><input name='total_volume' type='text' id='tot-volume' class='form-control input-field cvOn cvNum tot-volume' value='" + rom_tot + "'></div><div class='err_cv'></div></td><td>&nbsp;</td><td><div><input name='total_res_quant' type='text' id='tot-res_quant' class='form-control input-field cvOn cvNum tot-res_quant' value='" + saleable_tot + "'></div><div class='err_cv'></div></td><td colspan='6'>&nbsp;</td></tr>");
			
			// $('#addMoreRow').prepend("<tr><td colspan='6' class='text-right'><b>Total : </b></td><td><div><input name='total_volume' type='text' id='tot-volume' class='form-control input-field cvOn cvNotReq cvNum tot-volume' value='" + rom_tot + "'></div><div class='err_cv'></div></td><td>&nbsp;</td><td><div><input name='total_res_quant' type='text' id='tot-res_quant' class='form-control input-field cvOn cvNotReq cvNum tot-res_quant' value='" + saleable_tot + "'></div><div class='err_cv'></div></td><td colspan='6'>&nbsp;</td></tr>");
		}
		else { 
			$('#addMoreRow').prepend("<tr><td colspan='6' class='text-right'><b>Total : </b></td><td><div><input name='total_volume' type='text' id='tot-volume' class='form-control input-field cvOn cvNotReq cvNum tot-volume' value='" + rom_tot + "'></div><div class='err_cv'></div></td><td>&nbsp;</td><td><div><input name='total_res_quant' type='text' id='tot-res_quant' class='form-control input-field cvOn cvNotReq cvNum tot-res_quant' value='" + saleable_tot + "'></div><div class='err_cv'></div></td><td colspan='6'>&nbsp;</td></tr>");
		}
	}, 100);
	$('#form_id').on('blur', '.tot_cross', function () {
		var id = $(this).attr('id');
		getFinalTotal(id);
	});
	$('#form_id').on('blur', '.tot-volume', function () {
		var id = $(this).attr('id');
		doTotalCalculation(id);
	});
	$('#form_id').on('blur', '.tot-res_quant', function () {
		var id = $(this).attr('id');
		doTotalCalculationResQuant(id);
	});

	// To blank total fields on clicking Add More button by Shweta Apale on 17-05-2022
	$('#form_id').on('click', '#add_more', function () {
		var id = $(this).attr('id');
		doTotalBlank(id);
	});

});
function getFinalTotal(elementId) {
	var sum_prop = 0;
	var fieldName = elementId.split('_');
	fieldName = fieldName[1] + '_' + fieldName[2] + '_' + fieldName[3];
	$("input[name='" + fieldName + "[]']").each(function () {
		sum_prop += parseFloat($(this).val());
	});
	var getTotal = $('#' + elementId).val();
	if (!isNaN(getTotal)) {
		if (Number(getTotal) == Number(sum_prop)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#' + elementId).val('0');
			$('#' + elementId).addClass('is-invalid');
		}
	}
}
function doTotalCalculation(fieldId) {

	var sum_prop = 0;
	var fieldName = fieldId.split('-');
	_fieldName = fieldName[1];
	
	// console.log("input[name='" + _fieldName + "[]']");

	$("input[name='" + _fieldName + "[]']").each(function () {
		sum_prop += parseFloat($(this).val());
	});
	
	// Added on 10-08-2022 start
	sum = sum_prop;
	sum = sum.toFixed(2); 
	// End
		
	var getTotal = $('#' + fieldId).val();
	
	if (!isNaN(getTotal)) {
		//if (parseFloat(getTotal) == parseFloat(sum_prop)) {
			if (parseFloat(getTotal) == parseFloat(sum)) {
			$('#' + fieldId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#' + fieldId).val('0');
			$('#' + fieldId).addClass('is-invalid');
		}
	}
}

function doTotalCalculationResQuant(fieldId) {

	var sum_prop = 0;
	var fieldName = fieldId.split('-');
	_fieldName = fieldName[1];
	
	// console.log("input[name='" + _fieldName + "[]']");

	$("input[name='" + _fieldName + "[]']").each(function () {
		sum_prop += parseFloat($(this).val());
	});
	
	// Added on 10-08-2022 start
	sum = sum_prop;
	sum = sum.toFixed(5); 
	// End
		
	var getTotal = $('#' + fieldId).val();
	
	if (!isNaN(getTotal)) {
		//if (parseFloat(getTotal) == parseFloat(sum_prop)) {
			if (parseFloat(getTotal) == parseFloat(sum)) {
			$('#' + fieldId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#' + fieldId).val('0');
			$('#' + fieldId).addClass('is-invalid');
		}
	}
}

// To blank total fields on clicking Add More button by Shweta Apale on 17-05-2022
function doTotalBlank(elementId) {
	$('#total_cross_sec_block').val('');
	$('#total_cross_sec_block').addClass('is-invalid cvOn cvReq');

	$('#tot-volume').val('');
	$('#tot-volume').addClass('is-invalid cvOn cvReq');

	$('#tot-res_quant').val('');
	$('#tot-res_quant').addClass('is-invalid cvOn cvReq');

}