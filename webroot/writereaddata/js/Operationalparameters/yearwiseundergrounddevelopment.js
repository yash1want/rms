 $(document).ready(function(){
 	setTimeout(function() {
 		var wst_qnt_tot = $('#wst_qnt_tot').val();
 		var min_qnt_tot = $('#min_qnt_tot').val();
 		
	  $('#addMoreRow').prepend("<tr><td colspan='12' class='text-right'><b>Total : </b></td><td><div><input name='waste_quantity_tot' type='text' id='waste_quantity_tot' class='form-control input-field cvOn cvNotReq cvNum wst_tot' value='"+wst_qnt_tot+"'></div><div class='err_cv'></div></td><td><div><input name='mineral_rom_quantity_tot' type='text' id='mineral_rom_quantity_tot' class='form-control input-field cvOn cvNotReq cvNum min_tot' value='"+min_qnt_tot+"'></div><div class='err_cv'></div></td><td>&nbsp;</td><td>&nbsp;</td></tr>");

	 	$('.wst_vol').on('blur', function() {
	        var id = $(this).attr('id');
	    	getTotal(id);
	    });
	    $('.min_vol').on('blur', function() {
	        var id = $(this).attr('id');
	    	getMineralTotal(id);
	    });
	    $('.wst_qnt').on('blur', function() {
	        var id = $(this).attr('id');
	    	getWasteQntTotal(id);
	    });
	    $('.min_qnt').on('blur', function() {
	        var id = $(this).attr('id');
	    	getMineralQntTotal(id);
	    });
	    $('.wst_tot').on('blur', function() {
	        var elementId = $(this).attr('id');
    		var elementName = $(this).attr('name');
	    	getWasteTotal(elementId,elementName);
	    });
	    $('.min_tot').on('blur', function() {
	        var elementId = $(this).attr('id');
    		var elementName = $(this).attr('name');
	    	getMineralRomTotal(elementId,elementName);
	    });

	}, 100);
	
	// To blank total fields on clicking Add More button by Shweta Apale on 13-06-2022
	$('#form_id').on('click', '#add_more', function () {
		var id = $(this).attr('id');
		doTotalBlank(id);
	});

});
    function getTotal(wst_vol)
    {	var single_id = wst_vol.split('-');
        var field_tot  = $('#'+wst_vol).val();
		var fieldOne  = $('#'+single_id[0]+'-running_mtr_zone_a-'+single_id[2]).val();
		var fieldTwo  = $('#'+single_id[0]+'-cross_section_c-'+single_id[2]).val();
		
		var total = parseFloat(fieldOne) * parseFloat(fieldTwo);
		totalRounded = total.toFixed(2);
		var totalArr = total.toString().split('.');
		var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
		if(!isNaN(total)){
			// if(field_tot == total)
			if(Number(field_tot) == Number(totalRounded) || Number(field_tot) == Number(totalTruncated)) // Validate both Rounded & Truncated values - Aniket G [17-10-2022]
			{
				$('#'+wst_vol).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('For Waste Volume (D = A * C) (m3) (Running Meter Waste Zone (m) * Cross Section (m2)) is not validating. Kindly correct before proceeding');
				 $('#'+wst_vol).val('');
				 $('#'+wst_vol).addClass('is-invalid');
			}
		}
    }
    function getMineralTotal(min_vol)
    {
    	var single_id = min_vol.split('-');
        var field_tot  = $('#'+min_vol).val();
		var fieldOne  = $('#'+single_id[0]+'-running_mtr_zone_b-'+single_id[2]).val();
		var fieldTwo  = $('#'+single_id[0]+'-cross_section_c-'+single_id[2]).val();
		
		var total = parseFloat(fieldOne) * parseFloat(fieldTwo);
		totalRounded = total.toFixed(2);
		var totalArr = total.toString().split('.');
		var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
		if(!isNaN(total)){
			// if(field_tot == total)
			if(Number(field_tot) == Number(totalRounded) || Number(field_tot) == Number(totalTruncated)) // Validate both Rounded & Truncated values - Aniket G [17-10-2022]
			{
				$('#'+min_vol).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('For Mineral (ROM) Volume (E = B * C)(m3) (Running Meterage in Mineral Zone (m) (B) * Cross Section (m2)) is not validating. Kindly correct before proceeding');
				 $('#'+min_vol).val('');
				 $('#'+min_vol).addClass('is-invalid');
			}
		}
    }
    function getWasteQntTotal(wst_qnt)
    {
    	var single_id = wst_qnt.split('-');
        var field_tot  = $('#'+wst_qnt).val();
		var fieldOne  = $('#'+single_id[0]+'-waste_volume-'+single_id[2]).val();
		var fieldTwo  = $('#'+single_id[0]+'-bulk_density_wate-'+single_id[2]).val();
		
		var total = parseFloat(fieldOne) * parseFloat(fieldTwo);
		totalRounded = total.toFixed(2);
		var totalArr = total.toString().split('.');
		var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
		if(!isNaN(total)){
			// if(field_tot == total)
			if(Number(field_tot) == Number(totalRounded) || Number(field_tot) == Number(totalTruncated)) // Validate both Rounded & Truncated values - Aniket G [17-10-2022]
			{
				$('#'+wst_qnt).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('For Waste Quantity(D * Density of the Waste Zone)(t) (Waste Volume (D = A * C) (m3) * Bulk Density of Waste (t/m3)) is not validating. Kindly correct before proceeding');
				 $('#'+wst_qnt).val('');
				 $('#'+wst_qnt).addClass('is-invalid');
			}
		}
    }
    function getMineralQntTotal(min_qnt)
    {
    	var single_id = min_qnt.split('-');
        var field_tot  = $('#'+min_qnt).val();
		var fieldOne  = $('#'+single_id[0]+'-mineral_rom_volume-'+single_id[2]).val();
		var fieldTwo  = $('#'+single_id[0]+'-bulk_density_mineral-'+single_id[2]).val();
		
		var total = parseFloat(fieldOne) * parseFloat(fieldTwo);
		totalRounded = total.toFixed(2);
		var totalArr = total.toString().split('.');
		var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
		if(!isNaN(total)){
			// if(field_tot == total)
			if(Number(field_tot) == Number(totalRounded) || Number(field_tot) == Number(totalTruncated)) // Validate both Rounded & Truncated values - Aniket G [17-10-2022]
			{
				$('#'+min_qnt).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('For Mineral (ROM) Quantity (E * Bulk Density)(t)	(D * Density of the Waste Zone)(t) (Waste Quantity * Bulk Density of Mineral (t/m3)) ) is not validating. Kindly correct before proceeding');
				 $('#'+min_qnt).val('');
				 $('#'+min_qnt).addClass('is-invalid');
			}
		}
    }
    function getWasteTotal(fieldId,fieldName)
    {
    	
    	var sum_prop= 0;
    	var _fieldName = fieldName.split('_'); 
    	_fieldName = _fieldName[0]+'_'+_fieldName[1]; 
    	$("input[name='"+_fieldName+"[]']").each(function () {
    		var _elementId = $(this).attr('id');
    		var nameFirst = _elementId.split('_');
			var curr_prop = ($(this).val() != '') ? $(this).val() : 0;
    		sum_prop += parseFloat(curr_prop);
    		
		});
		var getTotal = $('#'+fieldId).val();
		sum_propRounded = sum_prop.toFixed(2);
		var sum_propArr = sum_prop.toString().split('.');
		var sum_propArrTruncated = (sum_propArr.length == 2) ? sum_propArr[0] + '.' + sum_propArr[1].toString().substr(0, 2) : sum_prop;
		console.log('rouded: '+sum_propRounded);
		console.log('truncated: '+sum_propArrTruncated);
    	// if(getTotal==sum_prop)
    	if(Number(getTotal)==Number(sum_propRounded) || Number(getTotal)==Number(sum_propArrTruncated)) // Validate both Rounded & Truncated values - Aniket G [17-10-2022]
    	{
    		$('#'+fieldId).removeClass('is-invalid');
    		return true;
    	}else{
    		showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#'+fieldId).val('0');
			$('#'+fieldId).addClass('is-invalid');
    	}
    }
    function getMineralRomTotal(fieldId,fieldName)
    {
    	var sum_prop= 0;
    	var _fieldName = fieldName.split('_'); 
    	_fieldName = _fieldName[0]+'_'+_fieldName[1]+'_'+_fieldName[2]; 

    	$("input[name='"+_fieldName+"[]']").each(function () {
    		var _elementId = $(this).attr('id');
    		var nameFirst = _elementId.split('_');
			var curr_prop = ($(this).val() != '') ? $(this).val() : 0;
    		sum_prop += parseFloat(curr_prop);
    		
		});
		var getTotal = $('#'+fieldId).val();
		sum_propRounded = sum_prop.toFixed(2);
		var sum_propArr = sum_prop.toString().split('.');
		var sum_propArrTruncated = (sum_propArr.length == 2) ? sum_propArr[0] + '.' + sum_propArr[1].toString().substr(0, 2) : sum_prop;
    	// if(getTotal==sum_prop)
    	if(Number(getTotal)==Number(sum_propRounded) || Number(getTotal)==Number(sum_propArrTruncated)) // Validate both Rounded & Truncated values - Aniket G [17-10-2022]
    	{
    		$('#'+fieldId).removeClass('is-invalid');
    		return true;
    	}else{
    		showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#'+fieldId).val('0');
			$('#'+fieldId).addClass('is-invalid');
    	}
    }
	
	// To blank total fields on clicking Add More button by Shweta Apale on 13-06-2022
	function doTotalBlank(elementId) {
		$('#waste_quantity_tot').val('');
		$('#waste_quantity_tot').addClass('is-invalid cvOn cvReq');

		$('#mineral_rom_quantity_tot').val('');
		$('#mineral_rom_quantity_tot').addClass('is-invalid cvOn cvReq');
	}




 	
