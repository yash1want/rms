/*$(document).ready(function(){
	$('#form_id').on('blur', '.grand_total', function(){
 		var id = $(this).attr('id');
	    doCalculation(id,'total_area');
 	});

});

function doCalculation(elementId,elementName)
{
	var sum_prop= 0;
	var elementValue = $('#'+elementId).val(); 
	 
	$("input[name='"+elementName+"[]']").each(function () {
		sum_prop += parseFloat($(this).val());
	});

	if(!isNaN(sum_prop)){
		if(Number(sum_prop) == Number(elementValue))
		{
			$('#'+elementId).removeClass('is-invalid');
			return true;
		}else{
				
			showAlrt(' G1+G2+G3+G4(Ha) is not validating. Kindly correct before proceeding');
			$('#'+elementId).val('');
			$('#'+elementId).addClass('is-invalid');
		}
	}
}
*/

// Added by Shweta Apale on 15-06-2022 start
$(document).ready(function () {

	$('#form_id').on('blur', '.total_area', function () {
		var id = $(this).attr('id');
		doCalculation(id);
	});
	$('#form_id').on('blur', '.tot-forest_area', function () {
		var id = $(this).attr('id');
		var elementClass = 'tot-forest_area';
		doTotalCalculation(id, elementClass);
	});
	$('#form_id').on('blur', '.tot-non_forest_area', function () {
		var id = $(this).attr('id');
		var elementClass = 'tot-non_forest_area';
		doTotalCalculation(id, elementClass);
	});
	$('#form_id').on('blur', '.tot-forest', function () {
		var id = $(this).attr('id');
		var elementClass = 'tot-forest';
		doTotalCalculation(id, elementClass);
	});
	$('#form_id').on('blur', '.tot-non_forest', function () {
		var id = $(this).attr('id');
		var elementClass = 'tot-non_forest';
		doTotalCalculation(id, elementClass);
	});


});

function doCalculation(elementId) {
	var single_id = elementId.split('-');
	var field_val = $('#' + elementId).val();
	var FindClass = $('#' + elementId).hasClass('tot');
	var TotalLeaseArea = $('#lease_area').val();
	var fieldOne = $('#locrnr-' + single_id[1]).val();
	var fieldTwo = $('#disrnr-' + single_id[1]).val();
	var total = parseFloat(fieldOne) + parseFloat(fieldTwo);
	
	total = Number(total).toFixed(4); // Changed by Shweta Apale on 18-11-2022 toFixed(2) to  toFixed(4) Suggested by Tarun Sir to allow 4 decimal

	if (!isNaN(total)) {
		if (Number(field_val) == Number(total)) {

			if (FindClass) {
				if (Number(TotalLeaseArea) == Number(total)) {
					$('#' + elementId).removeClass('is-invalid');
					return true;
				} else {
					 
					if (elementId == 'remarkrnr-7') {
						if (Number(TotalLeaseArea) != Number(total)) {
							showAlrt('Total Area (Ha) should be matched with "Lease Area" from the chapter 1- Geology "1.Lease Details" section field  -" Lease Details (Ha)"');
						}
					} else {
						showAlrt('Total is not validating. Kindly correct before proceeding');
					}

					$('#' + elementId).val('');
					$('#' + elementId).addClass('is-invalid');
				}
			} else {
				$('#' + elementId).removeClass('is-invalid');
				return true;
			}
		} 
		else {		
			if (elementId == 'remarkrnr-7') {
				if (Number(TotalLeaseArea) != Number(field_val)) {
					showAlrt('Total Area (Ha) should be matched with "Lease Area" from the chapter 1- Geology "1.Lease Details" section field  -" Lease Details (Ha)"');
				}
			} else {
				showAlrt('Total is not validating. Kindly correct before proceeding');
			}

			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}
}

function doTotalCalculation(elementId, elementClass) {	
	var sum_prop = 0;
	var _elementId = elementClass.split('-');
	var fieldName = _elementId[1];
	$("input[name='" + fieldName + "[]']").each(function () {
		var element_id = $(this).attr('id');
		var FindClass = $('#' + element_id).hasClass(elementClass);
		if (!FindClass) {
			sum_prop += parseFloat($(this).val());
			
			sum_prop1 = Number(sum_prop).toFixed(4); // Changed by Shweta Apale on 18-11-2022 toFixed(2) to  toFixed(4) Suggested by Tarun Sir to allow 4 decimal
		}
	});
	
	var getTotal = $('#' + elementId).val();
	var gt = Number(getTotal).toFixed(4); // Changed by Shweta Apale on 18-11-2022 toFixed(2) to  toFixed(4) Suggested by Tarun Sir to allow 4 decimal
	
	if (gt == sum_prop1) {
		$('#' + elementId).removeClass('is-invalid');
		return true;
	} else {
		showAlrt('Total is not validating. Kindly correct before proceeding');
		$('#' + elementId).val('');
		$('#' + elementId).addClass('is-invalid');
	}

}


$(document).ready(function(){

	// show alert on saving when user entered mineralised area is mis-matched from auto calculated mineralised area
	// added on 02-08-2022 by Aniket
	$('#btnSubmit').on('click',function(e){

		var calMinArea = calPotMinArea();
		var entMinArea = parseFloat($('#locrnr').val()).toFixed(2);

		if(calMinArea != entMinArea){
			if(confirm('Potentially Mineralised area (Ha) is mismatched from total auto-calculated value '+calMinArea+'. Are you sure to continue?')){
				return true;
			} else {
				return false;
			}
		}

	});

});

function calPotMinArea(){

	var inRws = $('#table_container_1 .min_area_input').length;
	var calMinArea = 0;
	for (let i=0; i < inRws; i++){
		var inVal = $('#table_container_1 .min_area_input').eq(i).val();
		inVal = (inVal == '') ? 0 : inVal;
		calMinArea = parseFloat(calMinArea) + parseFloat(inVal);
	}

	return calMinArea.toFixed(2);

}

