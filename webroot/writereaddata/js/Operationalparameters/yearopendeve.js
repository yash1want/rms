// Created by Shweta Apale on 19-05-2022

$(document).ready(function () {
    setTimeout(function () {
        var tot_topsoil = $('#tot_topsoil').val();
        var tot_overburden_volume = $('#tot_overburden_volume').val();
        var tot_overburden_quant = $('#tot_overburden_quant').val();
        var tot_rom_volumne = $('#tot_rom_volumne').val();
        var tot_rom_quant = $('#tot_rom_quant').val();

            $('#addMoreRow').prepend("<tr><td colspan='3' class='text-right'><b>Total : </b></td><td><div><input name='tot_topsoil' type='text' id='tot-total_topsoil_volume' class='form-control input-field cvOn  cvNum tot-topsoil cvFloatRestrict' value='" + tot_topsoil + "' cvfloat='999999999999.99'></div><div class='err_cv'></div></td><td><div><input name='tot_overburden_volume' type='text' id='tot-total_overburden_volume' class='form-control input-field cvOn cvNum tot-over_vol cvFloatRestrict' value='" + tot_overburden_volume + "' cvfloat='999999999999.99'></div><div class='err_cv'></div></td><td><div><input name='tot_overburden_quant' type='text' id='tot-total_overburden_quantity' class='form-control input-field cvOn cvNum tot-over_quant cvFloatRestrict' value='" + tot_overburden_quant + "' cvfloat='999999999999.99'></div><div class='err_cv'></div></td><td><div><input name='tot_rom_volumne' type='text' id='tot-total_rom_volume' class='form-control input-field cvOn cvNum tot-rom_vol cvFloatRestrict' value='" + tot_rom_volumne + "' cvfloat='999999999999.99'></div><div class='err_cv'></div></td><td><div><input name='tot_rom_quant' type='text' id='tot-total_rom_quantity' class='form-control input-field cvOn cvNum tot-rom_quant cvFloatRestrict' value='" + tot_rom_quant + "' cvfloat='999999999999.99'></div><div class='err_cv'></div></td></tr>");
      
    }, 100);

    $('#form_id').on('blur', '.tot-topsoil', function () {
		var id = $(this).attr('id');
		doTotalCalculation(id);
	});

    $('#form_id').on('blur', '.tot-over_vol', function () {
		var id = $(this).attr('id');
		doTotalCalculation(id);
	});

    $('#form_id').on('blur', '.tot-over_quant', function () {
		var id = $(this).attr('id');
		doTotalCalculation(id);
	});

    $('#form_id').on('blur', '.tot-rom_vol', function () {
		var id = $(this).attr('id');
		doTotalCalculation(id);
	});

    $('#form_id').on('blur', '.tot-rom_quant', function () {
		var id = $(this).attr('id');
		doTotalCalculation(id);
	});

    // To blank total fields on clicking Add More button 
	$('#form_id').on('click', '#add_more', function () {
		var id = $(this).attr('id');
		doTotalBlank(id);
	});
	
	// Added on 14-06-2022 by Shweta Apale
	$('#form_id').on('blur', '.tot-rom_quant', function () {
		var id = $(this).attr('id');
		DoCompareTotalRomQntyWithReseverQuantity(id);
	});

	// Total fields auto calculation
	// Added on 30-09-2022 to handle the UAT 2 Issue #20
	$('#form_id').on('click blur keyup change cut copy paste', '.input-field', function(){
		var inName = $(this).attr('name');
		inTotalArr = ['total_topsoil_volume[]','total_overburden_volume[]','total_overburden_quantity[]','total_rom_volume[]','total_rom_quantity[]'];
		if($.inArray(inName, inTotalArr) !== -1){
			doTotalAutoCalculation(inName);
		}
	});

});

function doTotalCalculation(fieldId){
    var sum_prop = 0;
	var fieldName = fieldId.split('-');
	_fieldName = fieldName[1];

	$("input[name='" + _fieldName + "[]']").each(function () {
		if($(this).val() != ''){
			sum_prop += ($(this).val() != '') ? parseFloat($(this).val()) : 0;
			
			sum_prop1 = Number(sum_prop).toFixed(2);
		}
	});	
	
	var getTotal = $('#' + fieldId).val();
 
	if (!isNaN(getTotal)) {
		if (parseFloat(getTotal) == parseFloat(sum_prop1)) {
			$('#' + fieldId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#' + fieldId).val('0');
			$('#' + fieldId).addClass('is-invalid');
		}
	}

}

// To blank total fields on clicking Add More button 
function doTotalBlank(elementId) {  
	$('#tot-total_topsoil_volume').val('');
	$('#tot-total_topsoil_volume').addClass('is-invalid cvOn cvReq');

	$('#tot-total_overburden_volume').val('');
	$('#tot-total_overburden_volume').addClass('is-invalid cvOn cvReq');

	$('#tot-total_overburden_quantity').val('');
	$('#tot-total_overburden_quantity').addClass('is-invalid cvOn cvReq');

    $('#tot-total_rom_volume').val('');
	$('#tot-total_rom_volume').addClass('is-invalid cvOn cvReq');

    $('#tot-total_rom_quantity').val('');
	$('#tot-total_rom_quantity').addClass('is-invalid cvOn cvReq');

}

// Added by Shweta Apale on  14-06-2022
function DoCompareTotalRomQntyWithReseverQuantity(elementId) {
	var total_rom = $('#' + elementId).val();
	var reserve_qt = $('#reserveQuantity').val();

	if (parseFloat(total_rom) > parseFloat(reserve_qt)) {
		showAlrt('Total ROM Quantity (t) should be less than equal to Reserve Quantity(t)[2A.2.4.12 Calculation of Reserve I] . Kindly correct before proceeding');
		$('#' + elementId).val('');
		$('#' + elementId).addClass('is-invalid');
	}
}

function doTotalAutoCalculation(inName){
	var inTotalName = '';
	switch(inName){
		case 'total_topsoil_volume[]': inTotalName = 'tot-total_topsoil_volume'; break;
		case 'total_overburden_volume[]': inTotalName = 'tot-total_overburden_volume'; break;
		case 'total_overburden_quantity[]': inTotalName = 'tot-total_overburden_quantity'; break;
		case 'total_rom_volume[]': inTotalName = 'tot-total_rom_volume'; break;
		case 'total_rom_quantity[]': inTotalName = 'tot-total_rom_quantity'; break;
	}
	var inNameLen = $('#form_id input[name="'+inName+'"]').length;
	var inTotal = 0;
	for(let i=0; i<inNameLen; i++) {
		var inTotalRw = ($('#form_id input[name="'+inName+'"]').eq(i).val() != '') ? $('#form_id input[name="'+inName+'"]').eq(i).val() : 0;
		inTotal += parseFloat(inTotalRw);
	}
	if(inTotalName == 'tot-total_rom_quantity'){
		var total_rom = inTotal.toFixed(2);
		var reserve_qt = $('#reserveQuantity').val();
		if (parseFloat(total_rom) > parseFloat(reserve_qt)) {
			$('#form_id #'+inTotalName).val('');
			$('#form_id #'+inTotalName).addClass('is-invalid');
			showAlrt('Total ROM Quantity (t) should be less than equal to Reserve Quantity(t)[2A.2.4.12 Calculation of Reserve I] . Kindly correct before proceeding');
		} else {
			$('#form_id #'+inTotalName).val(inTotal.toFixed(2));
		}
	}else{
		$('#form_id #'+inTotalName).val(inTotal.toFixed(2));
	}
}