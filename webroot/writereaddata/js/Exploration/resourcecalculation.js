$(document).ready(function () {
	setTimeout(function () {
		var rom_tot = $('#tot_volume').val();
		var saleable_tot = $('#tot_res_quant').val();
		$('#addMoreRow').prepend("<tr><td colspan='5' class='text-right'><b>Total : </b></td><td><div><input name='total_volume' type='text' id='tot-volume' class='form-control input-field cvOn cvNum tot-volume' value='" + rom_tot + "'></div><div class='err_cv'></div></td><td>&nbsp;</td><td><div><input name='total_res_quant' type='text' id='tot-res_quant' class='form-control input-field cvOn cvNum tot-res_quant' value='" + saleable_tot + "'></div><div class='err_cv'></div></td><td colspan='6'>&nbsp;</td></tr>");
	}, 100);
	$('#form_id').on('blur', '.tot', function () {
		var id = $(this).attr('id');
		doCalculation(id);
	});
	$('#form_id').on('blur', '.tot-volume', function () {
		var id = $(this).attr('id');
		doTotalCalculation(id);
	});
	$('#form_id').on('blur', '.tot-res_quant', function () {
		var id = $(this).attr('id');
		//console.log(id);
		doTotalCalculation(id);
	});

	// To blank total fields on clicking Add More button by Shweta Apale on 17-05-2022
	$('#form_id').on('click', '#add_more', function () {
		var id = $(this).attr('id');
		doTotalBlank(id);
	});

	// $('#table_1').ready(function(){
	// 	disabledTotalField();
	// });
	
});
function doCalculation(elementId) {
	var single_id = elementId.split('-');
	var field_val = $('#' + elementId).val();

	var fieldOne = $('#' + single_id[0] + '-volume-' + single_id[2]).val();
	var fieldTwo = $('#' + single_id[0] + '-res_quant-' + single_id[2]).val();
	var total = parseFloat(fieldOne) + parseFloat(fieldTwo);
	//console.log(total);

	if (!isNaN(total)) {
		if (Number(field_val) == Number(total)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;

		} else {
			showAlrt('For Total (Volume (m³) + Resource Quantity (t)) is not validating. Kindly correct before proceeding');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}
}
function doTotalCalculation(fieldId) {

	var sum_prop = 0;
	var sum_prop1;
	var sum_prop_trunc = 0;

	var fieldName = fieldId.split('-');
	_fieldName = fieldName[1];
	
	//console.log(_fieldName);
	$("input[name='" + _fieldName + "[]']").each(function () {
		sum_prop += parseFloat($(this).val());
		sum_prop1 = Number(sum_prop).toFixed(5); // Changed toFixed(2) to toFixed(5) on 23-06-2023 by Shweta Apale

		var thisValue = parseFloat($(this).val());
		var thisValueArr = thisValue.toString().split('.');
		
		// Changed length == 2 to length == 5 on 23-06-2023 by Shweta Apale
		sum_prop_trunc += parseFloat((thisValueArr.length == 5) ? thisValueArr[0] + '.' + thisValueArr[1].toString().substr(0, 5) : thisValue);
	});
	
	var sum_prop_truncArr = sum_prop_trunc.toString().split('.');
	
	// Changed length == 2 to length == 5 on 23-06-2023 by Shweta Apale
	var sum_prop_truncated = (sum_prop_truncArr.length == 5) ? sum_prop_truncArr[0] + '.' + sum_prop_truncArr[1].toString().substr(0, 5) : sum_prop_trunc;

	var getTotal = $('#' + fieldId).val();

	console.log('tofixed: '+sum_prop1);
	console.log('truncated: '+sum_prop_truncated);

	if (!isNaN(getTotal)) {
		if (Number(getTotal) == Number(sum_prop1) || Number(getTotal) == Number(sum_prop_truncated)) {
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
	$('#tot-volume').val('');
	$('#tot-volume').addClass('is-invalid cvOn cvReq');

	$('#tot-res_quant').val('');
	$('#tot-res_quant').addClass('is-invalid cvOn cvReq');

}

function disabledTotalField(){
	
	var disabledAttr = $('#ta-cross_sec_block-1').attr('disabled');
	if (typeof disabledAttr !== 'undefined' && disabledAttr !== false) {
		$('#tot-volume').attr('disabled');
		$('#tot-res_quant').attr('disabled');
	}
	
}