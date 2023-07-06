$(document).ready(function(){
	
	$('#form_id').on('blur', '.total_area', function(){
 		var id = $(this).attr('id');
	    doCalculation(id);
 	});
 	$('#form_id').on('blur', '.tot-forest_area', function(){
 		var id = $(this).attr('id');
 		var elementClass = 'tot-forest_area';
	    doTotalCalculation(id,elementClass);
 	});
 	$('#form_id').on('blur', '.tot-non_forest_area', function(){
 		var id = $(this).attr('id');
 		var elementClass = 'tot-non_forest_area';
	    doTotalCalculation(id,elementClass);
 	});
 	$('#form_id').on('blur', '.tot-forest', function(){
 		var id = $(this).attr('id');
		//console.log(id);
 		var elementClass = 'tot-forest';
	    doTotalCalculation(id,elementClass);
 	});
 	$('#form_id').on('blur', '.tot-non_forest', function(){
 		var id = $(this).attr('id');
 		var elementClass = 'tot-non_forest';
	    doTotalCalculation(id,elementClass);
 	});
	
	
	$(".inforest").on("focusout",function(){
		var id = $(this).attr('id');
		$(".tot-forest_area").val('');
		$(".tot").val('');
		$(this).parent().parent().parent().find('.total_area').val('');
	});
	
	$(".innforest").on("focusout",function(){
		var id = $(this).attr('id');
		$(".tot-non_forest_area").val('');
		$(".tot").val('');
		$(this).parent().parent().parent().find('.total_area').val('');		
	});
 	

});
function doCalculation(elementId)
{
	var single_id = elementId.split('-');
    var field_val  = $('#'+elementId).val();
    var FindClass  = $('#'+elementId).hasClass('tot');
    var TotalLeaseArea  = $('#lease_area').val();
    var fieldOne  = $('#locrnr-'+single_id[1]).val();
    var fieldTwo  = $('#disrnr-'+single_id[1]).val();
    var total = parseFloat(fieldOne) + parseFloat(fieldTwo);
	total = total.toFixed(6); //added on 05-08-2022
//console.log(total);
    if(!isNaN(total)){
		if(Number(field_val) == Number(total))
		{
			if(FindClass)
			{
				if(Number(TotalLeaseArea)==Number(total)){
					$('#'+elementId).removeClass('is-invalid');
					return true;
				}else{
					
					if(elementId == 'remarkrnr-7'){
						
						showAlrt('Total Area (Ha) should be matched with "Lease Area" from the chapter 1- Geology "1.Lease Details" section field  -" Lease Details (Ha)"');
					}else{
						showAlrt('Total is not validating. Kindly correct before proceeding');
					}
					
					$('#'+elementId).val('');
					$('#'+elementId).addClass('is-invalid');
				}
			}else{

			$('#'+elementId).removeClass('is-invalid');
			return true;
			}
		}else{
				
			if(elementId == 'remarkrnr-7'){
				
				showAlrt('Total Area (Ha) should be matched with "Lease Area" from the chapter 1- Geology "1.Lease Details" section field  -" Lease Details (Ha)"');
			}else{
				showAlrt('Total is not validating. Kindly correct before proceeding');
			}
			
			 $('#'+elementId).val('');
			 $('#'+elementId).addClass('is-invalid');
		}
	}else{
		showAlrt('Total is not validating. Kindly correct before proceeding');
		$('#'+elementId).val('');
		$('#'+elementId).addClass('is-invalid');
	}
}


function doTotalCalculation(elementId,elementClass)
{
	console.log('hi');
	var sum_prop = 0;
	var _elementId = elementClass.split('-');
	var fieldName = _elementId[1];
	$("input[name='"+fieldName+"[]']").each(function () {
    	var element_id = $(this).attr('id');
		var FindClass  = $('#'+element_id).hasClass(elementClass);
		if(!FindClass)
		{
			sum_prop += parseFloat($(this).val());
		}	
		// Added on 10-08-2022 start
		sum = sum_prop;
		sum = sum.toFixed(6); 
		// End
		//console.log(sum_prop);
		..console.log(sum);
		
	});
	var getTotal = $('#'+elementId).val();
		//console.log(getTotal);
    	//if(getTotal==sum_prop) commented on 10-08-2022
			if(parseFloat(getTotal) == parseFloat(sum))
    	{
    		$('#'+elementId).removeClass('is-invalid');
    		return true;
    	}else{
    		showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#'+elementId).val('');
			$('#'+elementId).addClass('is-invalid');
    	}
	
}
