$(document).ready(function(){
	setTimeout(function() {
 		var rom_tot = $('#total_rom-tot').val();
 		var saleable_tot = $('#saleable_unsaleable-tot').val();
 		var mineral_tot = $('#mine_reject-tot').val();
	  $('#addMoreRow').prepend("<tr><td colspan='6' class='text-right'><b>Total : </b></td><td><div><input name='total_rom_tot' type='text' id='total_rom_tot' class='form-control input-field cvOn cvNotReq cvNum rom_tot' value='"+rom_tot+"'></div><div class='err_cv'></div></td><td><div><input name='Saleable_unsaleable_tot' type='text' id='Saleable_unsaleable_tot' class='form-control input-field cvOn cvNotReq cvNum saleable_tot' value='"+saleable_tot+"'></div><div class='err_cv'></div></td><td><div><input name='mine_reject_tot' type='text' id='mine_reject_tot' class='form-control input-field cvOn cvNotReq cvNum mineral_tot' value='"+mineral_tot+"'></div><div class='err_cv'></div></td><td colspan='5'>&nbsp;</td></tr>");
	}, 100);

	$('#form_id').on('blur', '.tot_rom', function(){
 		var id = $(this).attr('id');
	    DoCalculation(id);
 	});
 	$('#form_id').on('blur', '.min_reject', function(){
 		var id = $(this).attr('id');
	    DoMineralCalculation(id);
 	});
 	$('#form_id').on('blur', '.rom_tot', function(){
 		var id = $(this).attr('id');
 		var elementValue = $(this).attr('name');
	    getFinalTotal(id,elementValue);
 	});
 	$('#form_id').on('blur', '.saleable_tot', function(){
 		var id = $(this).attr('id');
 		var elementValue = $(this).attr('name');
	    getFinalTotal(id,elementValue);
 	});
 	$('#form_id').on('blur', '.mineral_tot', function(){
 		var id = $(this).attr('id');
 		var elementValue = $(this).attr('name');
	    getFinalTotal(id,elementValue);
 	});

	// Added on 14-06-2022 by Shweta Apale change request start
	$('#form_id').on('blur', '.rom_tot', function () {
		var id = $(this).attr('id');
		DoCompareTotalRomABWithReseverQuantity(id);
	});
	//end
	
 	function DoCalculation(elementId)
 	{
 		var single_id = elementId.split('-');
 		var field_val  = $('#'+elementId).val();
 		var fieldOne  = $('#'+single_id[0]+'-from_stops-'+single_id[2]).val();
 		var fieldTwo  = $('#'+single_id[0]+'-from_development-'+single_id[2]).val();
 		
 		var total = parseFloat(fieldOne) + parseFloat(fieldTwo);

 		if(!isNaN(total)){
			if(Number(field_val) == Number(total))
			{
				$('#'+elementId).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('For Total ROM (A+B) (From Stopes(A) + From Development(B)) is not validating. Kindly correct before proceeding');
				 $('#'+elementId).val('');
				 $('#'+elementId).addClass('is-invalid');
			}
		}
 	}
 	function DoMineralCalculation(elementId)
 	{
		 console.log(elementId);
 		var single_id = elementId.split('-');
 		var field_val  = $('#'+elementId).val();
 		var fieldOne  = $('#'+single_id[0]+'-total_rom-'+single_id[2]).val();
 		var fieldTwo  = $('#'+single_id[0]+'-Saleable_unsaleable-'+single_id[2]).val();
 		
		 console.log(field_val);
		 console.log(fieldTwo);

 		var total = parseFloat(field_val) + parseFloat(fieldTwo);
		 console.log(total);
 		if(!isNaN(total)){
			if(Number(total) == Number(fieldOne))
			{
				$('#'+elementId).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt(' ( Saleable/Usable Mineral (t) + Mineral Reject (t)) should be equal to Total ROM (A+B). Kindly correct before proceeding');
				 $('#'+elementId).val('');
				 $('#'+elementId).addClass('is-invalid');
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
			sum_prop += parseFloat($(this).val());
			
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
	
	// Added by Shweta Apale on  14-06-2022 change request start
	function DoCompareTotalRomABWithReseverQuantity(elementId){
		var total_rom = $('#'+elementId).val();
		var reserve_qt = $('#reserveQuantity').val();

		if(parseFloat(total_rom) > parseFloat(reserve_qt)){
			showAlrt('Total of Total ROM(A+B) should be less than equal to Reserve Quantity(t)[2B.2.4.12 Calculation of Reserve I] . Kindly correct before proceeding');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}
	//end


});