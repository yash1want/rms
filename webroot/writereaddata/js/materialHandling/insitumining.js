$(document).ready(function(){

	var commentloginuser = $('#commentloginuser').val(); // Added by Shweta Apale on 24-05-2022
		
	$('#form_id').on('focusout', '.total_handle', function(){  //rom_quant
 		var id = $(this).attr('id');
	    doTotalHandlingCalculation(id);
 	});
	// commented below logic coz this is now auto-calculated and freezed - Aniket G [2022-10-31]
 	// $('#form_id').on('focusout', '.min_reject', function(){
 	// 	var id = $(this).attr('id');
	//     doRomQntCalculation(id);
 	// });
	$('#form_id').on('focusout blur', '.rom_quant, .rom_quant_saleable_min', function(){
		var id = $(this).attr('id');
		doRomQntAutoCalculation(id);
	});
	// commented below logic coz this is now auto-calculated and freezed - Aniket G [2022-10-31]
 	// $('#form_id').on('focusout', '.ob_ore', function(){
 	// 	var id = $(this).attr('id');
	//     doObOreCalculation(id);
 	// });
 	$('#form_id').on('focusout blur', '.waste_quant, .rom_quant', function(){
 		var id = $(this).attr('id');
	    doObOreAutoCalculation(id);
 	});
	
	// Added by Shweta Apale on 24-05-2023 start
	if(commentloginuser == 1) { 
		$('#table_1').ready(function () { console.log('here');
		var len = $('.waste_quant').length;
		for(var i = 0 ; i < len; i++){
			var id = $('.waste_quant').eq(i).attr('id');		
			doObOreAutoCalculation(id);
		}
		});
	}
	// End

	// commented below logic coz this is now auto-calculated and freezed - Aniket G [2022-10-31]
 	// $('#form_id').on('focusout', '.tot_insi', function(){
 	// 	var id = $(this).attr('id');
	//     getTotal(id);
 	// });
 	$('#form_id').on('change focusout blur', '.waste_quant, .rom_quant, .total_handle, .rom_quant_saleable_min', function(){
		var id = $(this).attr('id');
	   doGrandTotalAutoCal(id);
	});
	
	// Added on 14-06-2022 by Shweta Apale
	// $('#form_id').on('blur', '.tot_insi_rom', function () {
	// 	var id = $(this).attr('id');
	// 	DoCompareTotalRomQntyWithReseverQuantity(id);
	// });
});
function doTotalHandlingCalculation(elementId)
{
	var single_id = elementId.split('-');
    var field_val  = $('#'+elementId).val();
    //var fieldOne  = $('#'+single_id[0]+'-total_handling-'+single_id[2]).val(); 
	var fieldOne  = $('#'+single_id[0]+'-rom_quant-'+single_id[2]).val(); 
	
    var fieldTwo  = $('#'+single_id[0]+'-waste_quant-'+single_id[2]).val();
	//var total = parseFloat(fieldTwo) + parseFloat(field_val);
	
	var total = parseFloat(fieldTwo) + parseFloat(fieldOne);
	total = total.toFixed(2); // added on 30-09-2022
	//console.log(total);
	//if(parseFloat(fieldOne) == parseFloat(total))
	if(parseFloat(field_val) == parseFloat(total))
	{
		$('#'+elementId).removeClass('is-invalid');
		return true;
	}else{
		
		showAlrt('Total Handling (t) = Waste Quantity (t) + ROM Quantity (t) is not validating. Kindly correct before proceeding'); // mentioned the formula in the alert, added on 30-09-2022 by Aniket G.
		//alert(' Total Handling (t) is not validating. Kindly correct before proceeding ');
		$('#'+elementId).val('0');
		$('#'+elementId).addClass('is-invalid');
	}
	
}
function doRomQntCalculation(elementId)
{
	var single_id = elementId.split('-');
    var field_val  = $('#'+elementId).val();
    var fieldOne  = $('#'+single_id[0]+'-rom_quant-'+single_id[2]).val();
    var fieldTwo  = $('#'+single_id[0]+'-rom_quant_saleable_min-'+single_id[2]).val();
	var total = parseFloat(fieldTwo) + parseFloat(field_val);
	// total = total.toFixed(2); // added on 30-09-2022
	totalRounded = total.toFixed(2);
	var totalArr = total.toString().split('.');
	var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
	
	// if(parseFloat(fieldOne) == parseFloat(total))
	if(Number(fieldOne) == Number(totalRounded) || Number(fieldOne) == Number(totalTruncated)) // Validate both Rounded & Truncated values - Aniket G [18-10-2022]
	{
		$('#'+elementId).removeClass('is-invalid');
		return true;
	}else{
		
		showAlrt('ROM Quantity (t) = ROM Quantity Saleable Mineral (t) + ROM Quantity Mineral Reject (t) is not validating. Kindly correct before proceeding'); // mentioned the formula in the alert, added on 30-09-2022 by Aniket G.
		//alert(' Total Handling (t) is not validating. Kindly correct before proceeding ');
		$('#'+elementId).val('0');
		$('#'+elementId).addClass('is-invalid');
	}
	
}

// Do auto calculation for ROM Quantity Mineral Reject (t) (New UAT Issue List #23) - Aniket G [31-10-2022]
function doRomQntAutoCalculation(elementId)
{
	var single_id = elementId.split('-');
    var romQnt = $('#'+single_id[0]+'-rom_quant-'+single_id[2]).val();
    var romQntSalMin = $('#'+single_id[0]+'-rom_quant_saleable_min-'+single_id[2]).val();
    // var romQntMinRej = $('#'+single_id[0]+'-rom_quant_min_reject-'+single_id[2]).val();
	romQnt = (romQnt != '') ? romQnt : 0;
	romQntSalMin = (romQntSalMin != '') ? romQntSalMin : 0;
	var romQntMinRej = parseFloat(romQnt) - parseFloat(romQntSalMin);
	romQntMinRejRounded = romQntMinRej.toFixed(2);
	var romQntMinRejArr = romQntMinRej.toString().split('.');
	// var romQntMinRejTruncated = (romQntMinRejArr.length == 2) ? romQntMinRejArr[0] + '.' + romQntMinRejArr[1].toString().substr(0, 2) : romQntMinRej;

	if(romQntMinRejRounded < 0){
		$('#'+elementId).val('');
		$('#'+elementId).addClass('is-invalid');
		showAlrt('<b>ROM Quantity Saleable Mineral (t)</b> should be smaller than <b>ROM Quantity (t)</b>');
	}else{
		$('#'+elementId).removeClass('is-invalid');
		$('#'+single_id[0]+'-rom_quant_min_reject-'+single_id[2]).val(romQntMinRejRounded);
	}
	doGrandTotalAutoCal('ta-rom_quant_min_reject-1');
	
}
function doObOreCalculation(elementId)
{
	var single_id = elementId.split('-');
    var field_val  = $('#'+elementId).val();
    var fieldOne  = $('#'+single_id[0]+'-waste_quant-'+single_id[2]).val();
    var fieldTwo  = $('#'+single_id[0]+'-rom_quant-'+single_id[2]).val();
	var total = parseFloat(fieldTwo) / parseFloat(fieldOne);
	total = total.toFixed(2); //added on 05-08-2022
	
	if(parseFloat(field_val) == parseFloat(total))
	{
		$('#'+elementId).removeClass('is-invalid');
		return true;
	}else{
		
		showAlrt('Ore to OB Ratio (ROM Quantity / Waste Quantity) is not validating. Kindly correct before proceeding');
		//alert(' Total Handling (t) is not validating. Kindly correct before proceeding ');
		$('#'+elementId).val('0');
		$('#'+elementId).addClass('is-invalid');
	}
}

// Do auto calculation for Ore to OB Ratio (New UAT Issue List #23) - Aniket G [31-10-2022]
function doObOreAutoCalculation(elementId)
{
	var single_id = elementId.split('-');
    var romQnt = $('#'+single_id[0]+'-rom_quant-'+single_id[2]).val();
    var wasteQnt = $('#'+single_id[0]+'-waste_quant-'+single_id[2]).val();
	var oreToObRatio = ''; 
	if(romQnt != '' && wasteQnt != ''){
		if(wasteQnt > 0 && romQnt > 0){
			// oreToObRatio = parseFloat(romQnt) / parseFloat(wasteQnt); Commented on 17-05-2023 by Shweta Apale
			oreToObRatio = parseFloat(wasteQnt) / parseFloat(romQnt); // Changed on 17-05-2023 by Shweta Apale
			oreToObRatio = oreToObRatio.toFixed(2);
		}else if(wasteQnt == 0 || romQnt == 0){ // Changed && condition to || on 25-05-2023 by Shweta Apale
			oreToObRatio = 0;
		}
		// $('#'+elementId).removeClass('is-invalid');
		$('#'+single_id[0]+'-ob_ore_ratio-'+single_id[2]).val(oreToObRatio);
	}

}
function getTotal(elementId)
{
	var _elementId = elementId.split('-');
	var _elementName = _elementId[1];
	var _total = 0;
	$("input[name='"+_elementName+"[]']").each(function () {
		if($(this).val() != ''){
			_total += parseFloat($(this).val());
			
			_total1 = Number(_total).toFixed(2);
			
			//console.log(_total1);
		}
	});
	
	console.log(_total1);
	
	
	var _elementValue = parseFloat($('#'+elementId).val());
	
	//console.log(_elementValue);
	if(!isNaN(_elementValue))
	{
		if(parseFloat(_elementValue) == parseFloat(_total1))
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

// Added by Shweta Apale on  14-06-2022
function DoCompareTotalRomQntyWithReseverQuantity(elementId){
	var total_rom = $('#'+elementId).val();
	var reserve_qt = $('#reserveQuantity').val();
	
	console.log(total_rom);
	console.log(reserve_qt);
	
	if(parseFloat(total_rom) > parseFloat(reserve_qt)){
		showAlrt('Total ROM Quantity (t) should be less than equal to Reserve Quantity(t)[2A.2.4.12 Calculation of Reserve I] . Kindly correct before proceeding');
		$('#' + elementId).val('');
		$('#' + elementId).addClass('is-invalid');
	}
}

// Do grant total auto calculation (New UAT Issue List #23) - Aniket G [31-10-2022][c]
function doGrandTotalAutoCal(elementId){
	var idArr = elementId.split('-');
	var elName = idArr[1];
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

	if(elName == 'rom_quant'){
		var reserveQnt = $('#reserveQuantity').val();
		if(Number(grandTotal) > Number(reserveQnt)){
			showAlrt('<b>Total ROM Quantity (t)</b> should be less than equal to <b>Reserve Quantity(t)[2A.2.4.12 Calculation of Reserve I]</b>. Kindly correct before proceeding');
			$('#'+elementId).val('');
			$('#'+elementId).addClass('is-invalid');
			$('#tot-'+elName).addClass('is-invalid');
		}else{
			$('#'+elementId).removeClass('is-invalid');
			$('#tot-'+elName).removeClass('is-invalid');
			$('#tot-'+elName).val(grandTotal);
		}
	}else{
		$('#'+elementId).removeClass('is-invalid');
		$('#tot-'+elName).removeClass('is-invalid');
		$('#tot-'+elName).val(grandTotal);
	}
}
