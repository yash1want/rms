$(document).ready(function () {

	var loginusertype = $('#loginusertype').val(); // Added by Shweta Apale on 26-12-2022
	
	var commentloginuser = $('#commentloginuser').val(); // Added by Shweta Apale on 24-05-2022

	setTimeout(function () {
		var tot_overburden_quant = $('#tot_overburden_quant').val();
		var tot_rom_quantity = $('#tot_rom_quantity').val();
		var tot_mineral_reject = $('#tot_mineral_reject').val();
		var tot_main_production = $('#tot_main_production').val();
		var tot_prod_associated = $('#tot_prod_associated').val();


		$('#addMoreRow').append("<tr><td colspan='9' class='text-right'><b>Total : </b></td><td><div><input name='tot_overburden_quant' type='text' id='total_overburden_quant' class='form-control input-field cvOn cvNum cvNotReq year_tot' value='" + tot_overburden_quant + "' readonly></div><div class='err_cv'></div></td><td colspan='1'>&nbsp;</td><td><div><input name='tot_rom_quantity' type='text' id='total_rom_quantity' class='form-control input-field cvOn cvNum year_tot cvNotReq' value='" + tot_rom_quantity + "' readonly></div><div class='err_cv'></div></td><td colspan='1'>&nbsp;</td><td><div><input name='tot_mineral_reject' type='text' id='total_mineral_reject' class='form-control input-field cvOn cvNum year_tot cvNotReq' value='" + tot_mineral_reject + "' readonly></div><div class='err_cv'></div></td><td><div><input name='tot_main_production' type='text' id='total_main_production' class='form-control input-field cvOn cvNum year_tot cvNotReq' value='" + tot_main_production + "' readonly></div><div class='err_cv'></div></td><td><div><input name='tot_prod_associated' type='text' id='total_prod_associated' class='form-control input-field cvOn cvNum year_tot cvNotReq' value='" + tot_prod_associated + "' readonly></div><div class='err_cv'></div></td></tr>");

	}, 100);
	
	// now validate total on submit also, added on 10-08-2022 by Aniket
	// $('#form_id').on('submit', function(e) {
	// 	if (getTotal('tot_overburden_quant') == true && getTotal('tot_rom_quantity') == true && getTotal('tot_mineral_reject') == true && getTotal('tot_main_production') == true && getTotal('tot_prod_associated') == true) {
			
	// 		return true;
	// 	} else {
	// 		e.preventDefault();
	// 	}
	// });

	$('#form_id').on('blur', '.overbur_qnt', function () {
		var id = $(this).attr('id');
		doOverBurdenQntCalculation(id);
	});
	$('#form_id').on('blur', '.rom_qnt', function () {
		var id = $(this).attr('id');
		doRomQntCalculation(id);
	});
	$('#form_id').on('blur', '.min_reject', function () {
		var id = $(this).attr('id');
		doMinRejectCalculation(id);
	});
	$('#form_id').on('blur', '.prod_assoc', function () {
		var id = $(this).attr('id');
		doProdAssocCalculation(id);
	});
	// $('#form_id').on('blur', '.year_tot', function () {
	// 	var id = $(this).attr('id');
	// 	getTotal(id);
	// });

	$('#form_id').on('blur', '.recovery', function () {
		var id = $(this).attr('id');
		var rec_value = $(this).val();
		if (rec_value != "") {
			if (Number(rec_value) > 0 && Number(rec_value) <= 1) {
				$('#' + id).removeClass('is-invalid');
				return true;
			}
			else {
				showAlrt("Recovery value should be greater than 0 and less than equal to 1");
				$('#' + id).val('');
				$('#' + id).addClass('is-invalid');
			}
		}

	});

	// To calculate Obe to ore ration added by Shweta Apale on 17-05-2022
	/*$('#form_id').on('blur', '.obe_ore', function () {
		var id = $(this).attr('id');
		// console.log(id);
		doObeOrecCalculation(id);
	});*/
	
	// To auto fetch Ob to Ore ration value by Shweta Apale on 29-09-2022
	$('#form_id').on('change', '.rom_qnt ', function () {
		var id = $(this).attr('id');
		var single_id = id.split('-');
		var elementVal = (single_id[0] + '-obe_to_ore_ratio-' + single_id[2]);
		doObeOrecCalculation(elementVal);
	});
	
	
	// To blank total fields on clicking Add More button by Shweta Apale on 09-06-2022
	$('#form_id').on('click', '#add_more', function () {
		var id = $(this).attr('id');
		//console.log(id);
		doTotalBlank(id);
	});
	
	$('#form_id').on('blur click input change', '.bulk_den_over, .overbur_vol', function () {
		var id = $(this).attr('id');
		doOverBurdenQntAutoCal(id);
	});
	
	$('#form_id').on('blur click input change', '.bulk_den_mineral, .rom_volume', function () {
		var id = $(this).attr('id');
		doRomQntAutoCal(id);
	});
	
	$('#form_id').on('blur click', '.rom_qnt, .recovery', function () {
		var id = $(this).attr('id');
		doMinRejectAutoCal(id);
	});
	
	$('#form_id').on('blur click', '.min_reject, .main_production, .rom_quantity', function () {
		var id = $(this).attr('id');
		doProdAssocAutoCal(id);
	});
	
	// Auto calculate the freezed field "OB to Ore Ratio (ton/m3)" - New UAT Issue #26 - Aniket [09-11-2022]
	$('#form_id').on('blur click', '.bulk_den_over, .bulk_den_mineral, .overbur_vol, .overbur_qnt, .rom_volume, .recovery, .min_reject, .main_production, .prod_assoc, .obe_ore', function () {
		var id = $(this).attr('id');
		doObeOrecAutoCal(id);
	});
	
	// Added by Shweta Apale on 24-05-2023 start
	if(commentloginuser == 1) { 
		$('#table_1').ready(function () {
		var len = $('.bulk_den_over').length;
		for(var i = 0 ; i < len; i++){
			var id = $('.bulk_den_over').eq(i).attr('id');		
			doObeOrecAutoCal(id);
		}
		});
	}
	// End
	
		
	if(loginusertype == 'primaryuser') {	 // Added by Shweta Apale on 26-12-2022	 to avoid validation of total on MMS User side
		// Do grant total auto calcuation (New UAT Issue List #26) - Aniket [10-11-2022][c]
		$('#form_id').on('blur click input change', '.overbur_qnt', function () {
			doYearTotAutoCal('overburden_quant');
		});
		
		$('#form_id').on('blur click input change', '.rom_qnt', function () {
			doYearTotAutoCal('rom_quantity');
		});
		
		$('#form_id').on('blur click input change', '.min_reject', function () {
			doYearTotAutoCal('mineral_reject');
		});
		
		$('#form_id').on('blur click input change', '.main_production', function () {
			doYearTotAutoCal('main_production');
		});
		
		$('#form_id').on('blur click input change', '.prod_assoc', function () {
			doYearTotAutoCal('prod_associated');
		});
	}

});
function doOverBurdenQntCalculation(elementId) {
	var single_id = elementId.split('-');
	var field_val = $('#' + elementId).val();
	var fieldOne = $('#' + single_id[0] + '-bulk_density_overburden-' + single_id[2]).val();
	var fieldTwo = $('#' + single_id[0] + '-overburden_volume-' + single_id[2]).val();
	var total = parseFloat(fieldOne) * parseFloat(fieldTwo);
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
	if (!isNaN(total)) {
		if (Number(field_val) == Number(totalRounded) || Number(field_val) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt(' Over Burden Quantity(t) is not validating. Kindly correct before proceeding ');
			$('#' + elementId).val(totalRounded);
		}
	} else {
		showAlrt(' Over Burden Quantity(t) is not validating. Kindly correct before proceeding ');
		$('#' + elementId).val('');
	}
}

// Auto calculate the field "Over Burden Quantity (t)" - New UAT Issue #26 - Aniket [09-11-2022]
function doOverBurdenQntAutoCal(elementId) {
	var single_id = elementId.split('-');
	var bulkDenOverburden = $('#' + single_id[0] + '-bulk_density_overburden-' + single_id[2]).val();
	var overburdenVol = $('#' + single_id[0] + '-overburden_volume-' + single_id[2]).val();
	var overburdenQnt = $('#' + single_id[0] + '-overburden_quant-' + single_id[2]).val();
	var total = parseFloat(bulkDenOverburden) * parseFloat(overburdenVol);
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
	if (!isNaN(total)) {
		if (Number(overburdenQnt) == Number(totalRounded) || Number(overburdenQnt) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			$('#' + single_id[0] + '-overburden_quant-' + single_id[2]).val(totalRounded);
			doYearTotAutoCal('overburden_quant');
		}
	}
}

function doRomQntCalculation(elementId) {
	var single_id = elementId.split('-');
	var field_val = $('#' + elementId).val();
	var fieldOne = $('#' + single_id[0] + '-rom_volume-' + single_id[2]).val();
	var fieldTwo = $('#' + single_id[0] + '-bulk_density_mineral-' + single_id[2]).val();
	var total = parseFloat(fieldOne) * parseFloat(fieldTwo);
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;

	if (!isNaN(total)) {
		if (Number(field_val) == Number(totalRounded) || Number(field_val) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt(' ROM Quantity (t) is not validating. Kindly correct before proceeding ');
			$('#' + elementId).val(totalRounded);
		}
	} else {
		showAlrt(' ROM Quantity (t) is not validating. Kindly correct before proceeding ');
		$('#' + elementId).val('');
	}
}

// Auto calculate the field "ROM Quantity (t)" - New UAT Issue #26 - Aniket [09-11-2022]
function doRomQntAutoCal(elementId) {
	var single_id = elementId.split('-');
	var romVol = $('#' + single_id[0] + '-rom_volume-' + single_id[2]).val();
	var bulDenMin = $('#' + single_id[0] + '-bulk_density_mineral-' + single_id[2]).val();
	var romQnt = $('#' + single_id[0] + '-rom_quantity-' + single_id[2]).val();
	var total = parseFloat(romVol) * parseFloat(bulDenMin);
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;

	if (!isNaN(total)) {
		if (Number(romQnt) == Number(totalRounded) || Number(romQnt) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			$('#' + single_id[0] + '-rom_quantity-' + single_id[2]).val(totalRounded);
			doYearTotAutoCal('rom_quantity');
		}
	}
}

function doMinRejectCalculation(elementId) {
	var single_id = elementId.split('-');
	var field_val = $('#' + elementId).val();
	var fieldOne = $('#' + single_id[0] + '-rom_quantity-' + single_id[2]).val();
	var fieldTwo = $('#' + single_id[0] + '-recovery-' + single_id[2]).val();
	var total = parseFloat(fieldOne) - (parseFloat(fieldOne) * parseFloat(fieldTwo));
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
	if (!isNaN(total)) {
		if (Number(field_val) == Number(totalRounded) || Number(field_val) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt(' Mineral Reject (t) is not validating. Kindly correct before proceeding ');
			$('#' + elementId).val(totalRounded);
		}
	} else {
		showAlrt(' Mineral Reject (t) is not validating. Kindly correct before proceeding ');
		$('#' + elementId).val('');
	}
}

// Auto calculate the field "ROM Quantity (t)" - New UAT Issue #26 - Aniket [09-11-2022]
function doMinRejectAutoCal(elementId) {
	var single_id = elementId.split('-');
	var romQnt = $('#' + single_id[0] + '-rom_quantity-' + single_id[2]).val();
	var recovery = $('#' + single_id[0] + '-recovery-' + single_id[2]).val();
	var minReject = $('#' + single_id[0] + '-mineral_reject-' + single_id[2]).val();
	var total = parseFloat(romQnt) - (parseFloat(romQnt) * parseFloat(recovery));
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
	if (!isNaN(total)) {
		if (Number(minReject) == Number(totalRounded) || Number(minReject) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			$('#' + single_id[0] + '-mineral_reject-' + single_id[2]).val(totalRounded);
			doYearTotAutoCal('mineral_reject');
		}
	}
}

function doProdAssocCalculation(elementId) {
	var single_id = elementId.split('-');
	var field_val = $('#' + elementId).val();
	var fieldOne = $('#' + single_id[0] + '-rom_quantity-' + single_id[2]).val();
	var fieldTwo = $('#' + single_id[0] + '-mineral_reject-' + single_id[2]).val();
	var fieldThree = $('#' + single_id[0] + '-main_production-' + single_id[2]).val();
	field_val = (field_val != '') ? field_val : 0;
	var total = parseFloat(field_val) + parseFloat(fieldTwo) + parseFloat(fieldThree);
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
	if (!isNaN(total)) {
		if (Number(fieldOne) == Number(totalRounded) || Number(fieldOne) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			var prodAssocCalculated = parseFloat(fieldOne) - (parseFloat(fieldTwo) + parseFloat(fieldThree));
			prodAssocCalculatedRounded = prodAssocCalculated.toFixed(2);
			if(prodAssocCalculatedRounded < 0){
				showAlrt(' "Production Associated (t)" should not be negative');
				$('#' + single_id[0] + '-prod_associated-' + single_id[2]).val('');
				doYearTotAutoCal('prod_associated');
			}else{
				showAlrt(' "Mineral Reject (t) + Production Main (t) + Production Associated (t)" should be equal to "ROM Quantity (t)". Kindly correct before proceeding ');
				$('#' + elementId).val(prodAssocCalculatedRounded);
			}
		}
	} else {
		showAlrt(' "Mineral Reject (t) + Production Main (t) + Production Associated (t)" should be equal to "ROM Quantity (t)". Kindly correct before proceeding ');
		$('#' + elementId).val('');
	}
}

// Auto calculate the field "Production Associated (t)" - New UAT Issue #26 - Aniket [09-11-2022]
function doProdAssocAutoCal(elementId) {
	var single_id = elementId.split('-');
	var romQnt = $('#' + single_id[0] + '-rom_quantity-' + single_id[2]).val();
	var minReject = $('#' + single_id[0] + '-mineral_reject-' + single_id[2]).val();
	var mainProd = $('#' + single_id[0] + '-main_production-' + single_id[2]).val();
	var prodAssoc = $('#' + single_id[0] + '-prod_associated-' + single_id[2]).val();
	prodAssoc = (prodAssoc != '') ? prodAssoc : 0;
	var total = parseFloat(prodAssoc) + parseFloat(minReject) + parseFloat(mainProd);
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
	if (!isNaN(total)) {
		if (Number(romQnt) == Number(totalRounded) || Number(romQnt) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			var prodAssocCalculated = parseFloat(romQnt) - (parseFloat(minReject) + parseFloat(mainProd));
			prodAssocCalculatedRounded = prodAssocCalculated.toFixed(2);
			if(prodAssocCalculatedRounded < 0){
				showAlrt(' "Production Associated (t)" should not be negative');
				$('#' + single_id[0] + '-prod_associated-' + single_id[2]).val('');
				doYearTotAutoCal('prod_associated');
			}else{
				$('#' + single_id[0] + '-prod_associated-' + single_id[2]).val(prodAssocCalculatedRounded);
				doYearTotAutoCal('prod_associated');
			}
		}
	}
}
function getTotal(elementId) {
	var _elementId = elementId.split('_');
	var _elementName = _elementId[1] + '_' + _elementId[2];
	var _total = 0;
	var fieldFilledStatus = false;
	$("input[name='" + _elementName + "[]']").each(function () {
		if ($(this).val() !== '') {
			_total += parseFloat($(this).val());
			fieldFilledStatus = true;
		}
	});

	if (fieldFilledStatus == false) { return true; }
	

	
	var elementIdTotal = elementId;
	
		if(elementId == 'tot_overburden_quant'){ elementIdTotal = 'total_overburden_quant'; }
		if(elementId == 'tot_rom_quantity'){ elementIdTotal = 'total_rom_quantity'; }
		if(elementId == 'tot_mineral_reject'){ elementIdTotal = 'total_mineral_reject'; }
		if(elementId == 'tot_main_production'){ elementIdTotal = 'total_main_production'; }
		if(elementId == 'tot_prod_associated'){ elementIdTotal = 'total_prod_associated'; }
		
		
		
		
		
console.log(elementIdTotal);	 
	var _elementValue = parseFloat($('#' + elementIdTotal).val());
	_total = _total.toFixed(2);
	console.log('total : '+_total);
	 console.log('val : '+_elementValue);
	// console.log(elementId);
	if (!isNaN(_elementValue) || fieldFilledStatus == true) {
		if (parseFloat(_elementValue) == parseFloat(_total)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#' + elementId).val('0');
			$('#' + elementId).addClass('is-invalid');
		}
	}

}

// To calculate Obe to ore ration added by Shweta Apale on 17-05-2022
function doObeOrecCalculation(elementId) {
	var single_id = elementId.split('-');
	var field_val = $('#' + elementId).val();
	var fieldOne = $('#' + single_id[0] + '-rom_quantity-' + single_id[2]).val();
	var fieldTwo = $('#' + single_id[0] + '-overburden_volume-' + single_id[2]).val();
	var total = parseFloat(fieldOne) / parseFloat(fieldTwo);
	totalRounded = total.toFixed(4);
	var tphArr = total.toString().split('.');
	var tphTruncated = (tphArr.length == 2) ? tphArr[0] + '.' + tphArr[1].toString().substr(0,4) : total;

	// console.log(fieldOne);
	// console.log(fieldTwo);
	// console.log(total);
	
	// console.log(totalRounded);
	// console.log(tphTruncated);
	
	$('#' + elementId).val(totalRounded);	
	
	/*if (!isNaN(total)) {
		// if (Number(field_val) == Number(total)) {
		if (Number(field_val) == Number(totalRounded) || Number(field_val) == Number(tphTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
		//$('#' + elementId).val(totalRounded);		
			return true;
		} else {
			showAlrt(' Ore to OB Ratio is not validating. Please calculate value " Ore to OB ratio = ROM Quantity / Over Burden Volume". Kindly correct before proceeding ');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}*/

}

// Auto calculate the field "OB to Ore Ratio (ton/m3)" - New UAT Issue #26 - Aniket [09-11-2022]
function doObeOrecAutoCal(elementId) {
	var single_id = elementId.split('-');
	var romWQnt = $('#' + single_id[0] + '-rom_quantity-' + single_id[2]).val();
	var overBurdenVol = $('#' + single_id[0] + '-overburden_volume-' + single_id[2]).val();
	var obeOre = $('#' + single_id[0] + '-obe_to_ore_ratio-' + single_id[2]).val();
	// var total = parseFloat(romWQnt) / parseFloat(overBurdenVol); Commented on 17-05-2023 by Shweta Apale

	// Added on 25-05-2023 by Shweta Apale start
	if (romWQnt == 0 || overBurdenVol == 0) {
		var total = 0;
	} else {
		var total = parseFloat(overBurdenVol) / parseFloat(romWQnt); // Changed on 17-05-2023 by Shweta Apale
	}
	//end

	totalRounded = total.toFixed(4);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 4) : total;
	if (!isNaN(total)) {
		if (Number(obeOre) == Number(totalRounded) || Number(obeOre) == Number(totalTruncated)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else {
			$('#' + single_id[0] + '-obe_to_ore_ratio-' + single_id[2]).val(totalRounded);
		}
	}else{
		$('#' + single_id[0] + '-obe_to_ore_ratio-' + single_id[2]).val('');
	}
}

// To blank total fields on clicking Add More button by Shweta Apale on 09-06-2022
function doTotalBlank(elementId) {
	$('#total_overburden_quant').val('');
	$('#total_overburden_quant').addClass('is-invalid cvOn cvNotReq');

	$('#total_rom_quantity').val('');
	$('#total_rom_quantity').addClass('is-invalid cvOn cvNotReq');

	$('#total_mineral_reject').val('');
	$('#total_mineral_reject').addClass('is-invalid cvOn cvNotReq');

	$('#total_main_production').val('');
	$('#total_main_production').addClass('is-invalid cvOn cvNotReq');

	$('#total_prod_associated').val('');
	$('#total_prod_associated').addClass('is-invalid cvOn cvNotReq');
}

// Do grant total auto calculation of "Total Year" (New UAT Issue List #26) - Aniket [10-11-2022]
function doYearTotAutoCal(elName){

	switch(elName){
		case 'overburden_quant': grandTotalElId = 'total_overburden_quant'; break;
		case 'rom_quantity': grandTotalElId = 'total_rom_quantity'; break;
		case 'mineral_reject': grandTotalElId = 'total_mineral_reject'; break;
		case 'main_production': grandTotalElId = 'total_main_production'; break;
		case 'prod_associated': grandTotalElId = 'total_prod_associated'; break;
	}
	
	var elRows = $('input[name="'+elName+'[]"]').length;
	var grandTotal = Number(0);
	for(var i=0; i < elRows; i++){
		var elVal = $('input[name="'+elName+'[]"]').eq(i).val();
		elVal = (elVal != '') ? elVal : 0;
		var elValArr = elVal.toString().split('.');
		var elValTruncated = (elValArr.length == 2) ? elValArr[0] + '.' + elValArr[1].toString().substr(0, 2) : elVal;
		grandTotal += parseFloat(elValTruncated);
	}
	grandTotal = grandTotal.toFixed(2);

	$('#form_id #'+grandTotalElId).removeClass('is-invalid');
	$('#form_id #'+grandTotalElId).val(grandTotal);

}