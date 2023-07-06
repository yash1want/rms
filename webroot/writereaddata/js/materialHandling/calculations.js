$(document).ready(function () {

	var formFullLabelArr = {
		"sale_ore": "Saleable ore from ROM (t)",
		"sale_rec": "Saleable Ore recovered from dump workings (t)",
		"tot_sale": "Total Saleable Ore (t)(=B+D)",
		"rom_qnt": "Total ROM quantity (t) ",
		"prop_dump": "Proposed Dump Handling Quantity (t)",
		"tot_qnt": "Total Quantity Handled (t) (=A+C)",
	};
	$('#form_id').on('blur', '.cal_tot', function () {
		var id = $(this).attr('id');
		GetTotal(id);
	});
	$('#form_id').on('blur', '.tot_sale', function () {
		var id = $(this).attr('id');
		DoCalculation(id, 'sale_ore', 'sale_rec');
	});
	$('#form_id').on('blur', '.tot_qnt', function () {
		var id = $(this).attr('id');
		DoCalculation(id, 'rom_qnt', 'prop_dump');
	});

	// Added on 17-05-2022 by Shweta Apale
	$('#form_id').on('blur', '.sale_ore', function () {
		var id = $(this).attr('id');
		DoCompareSaleableWithTotalRom(id);
	});

	// Added on 17-05-2022 by Shweta Apale
	$('#form_id').on('blur', '.sale_rec', function () {
		var id = $(this).attr('id');
		DoCompareSaleableRecoverdWithDumpWorking(id);
	});
	
	// Added on 14-06-2022 by Shweta Apale change request start
	$('#form_id').on('blur', '.cal_tot_rom', function () {
		var id = $(this).attr('id');
		DoCompareTotalRomWithReseverQuantity(id);
	});
	//End

	function GetTotal(elementId) {
		var single_id = elementId.split('-');
		
		var elementValue = $('#' + elementId).val();
		var total = 0;
		$("." + single_id[1]).each(function () {
			var Fvalue = ($(this).val()) == '' ? 0 : $(this).val();
			total += parseFloat(Fvalue);
			
			total1 = Number(total).toFixed(2);
		});		
		
		if (total > 0) {
			if (Number(total1) == Number(elementValue)) {
				$('#' + elementId).removeClass('is-invalid');
				return true;
			} else {
				showAlrt('Total is not validating. Kindly correct before proceeding');
				$('#' + elementId).val('');
				$('#' + elementId).addClass('is-invalid');
			}
		}

	}
	function DoCalculation(elementId, fieldOne, fieldTwo) {
		var single_id = elementId.split('-');
		var elementValue = $('#' + elementId).val();
		var fieldOneValue = $('#' + single_id[0] + '-' + fieldOne + '-' + single_id[2]).val();
		var fieldTwoValue = $('#' + single_id[0] + '-' + fieldTwo + '-' + single_id[2]).val();

		var total = parseFloat(fieldOneValue) + parseFloat(fieldTwoValue);

		if (!isNaN(total)) {
			if (Number(total) == Number(elementValue)) {
				$('#' + elementId).removeClass('is-invalid');
				return true;
			} else {

				showAlrt('For ' + formFullLabelArr[single_id[1]] + ' (' + formFullLabelArr[fieldOne] + ' + ' + formFullLabelArr[fieldTwo] + ' ) is not validating . Kindly correct before proceeding');
				$('#' + elementId).val('');
				$('#' + elementId).addClass('is-invalid');
			}
		}
	}

	//  To compare Saleable ore with total ROM made by Shweta Apale on 17-05-2022
	function DoCompareSaleableWithTotalRom(elementId) {
		var single_id = elementId.split('-');
		var elementValue = $('#' + elementId).val();
		var fieldOneValue = $('#' + single_id[0] + '-rom_qnt-' + single_id[2]).val();
		var fieldTwoValue = $('#' + single_id[0] + '-sale_ore-' + single_id[2]).val();
		
		if (parseFloat(fieldTwoValue) > parseFloat(fieldOneValue)) {
			showAlrt('Saleable ore from ROM (t) should be less than or equal to Total ROM quantity (t) . Kindly correct before proceeding');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}

	//  To compare Saleable recovered with dump working made by Shweta Apale on 17-05-2022
	function DoCompareSaleableRecoverdWithDumpWorking(elementId) {
		var single_id = elementId.split('-');
		var elementValue = $('#' + elementId).val();
		var fieldOneValue = $('#' + single_id[0] + '-prop_dump-' + single_id[2]).val();
		var fieldTwoValue = $('#' + single_id[0] + '-sale_rec-' + single_id[2]).val();

		if (parseFloat(fieldTwoValue) > parseFloat(fieldOneValue)) {
			showAlrt('Saleable ore recovered from dump working should be less than or equal to Proposed Dump Handling Quantity (t) . Kindly correct before proceeding');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}
	
	// Added by Shweta Apale on  14-06-2022 change request start
	function DoCompareTotalRomWithReseverQuantity(elementId){
		var total_rom = $('#'+elementId).val();
		var reserve_qt = $('#reserveQuantity').val();
		
		var minType  = $('#mintype').val(); //Added on 17-08-2022 by Shweta Apale
		
		//console.log(total_rom);
		//console.log(reserve_qt);
		
		if(parseFloat(total_rom) > parseFloat(reserve_qt)){
			if(minType == 'oc') { //Added on 17-08-2022 by Shweta Apale
				showAlrt('Total ROM Quantity (t) should be less than equal to Reserve Quantity(t)[2A.2.4.12 Calculation of Reserve I] . Kindly correct before proceeding');
			} else {
				showAlrt('Total ROM Quantity (t) should be less than equal to Reserve Quantity(t)[2B.2.4.12 Calculation of Reserve I] . Kindly correct before proceeding');
			}
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}
	//end	

});