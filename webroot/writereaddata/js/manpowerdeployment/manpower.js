$(document).ready(function(){
	$('#form_id').on('change', '.total_person', function(){
 		var id = $(this).attr('id');
	    DoCalculation(id);
 	});

	$('#form_id').on('change', '.total_person_engaged', function(){
 		var id = $(this).attr('id');
	    DoCalculationTotalPerson(id);
 	});

 	$('#form_id').on('blur', '.mach_req', function(){
 		var id = $(this).attr('id');
	    var shift_day =  $('#no_shift_per_day').val();
	    $(this).val(shift_day);
 	});
 	$('#form_id').on('blur', '.avg_working', function(){
 		var id = $(this).attr('id');
	    CalculateAvgWorking(id);
 	});
 	$('#form_id').on('blur', '.mat_per_shift', function(){
 		var id = $(this).attr('id');
	    var mat_shift_day =  $('#mat_hand_per_shift').val();
	    $(this).val(mat_shift_day);
 	});

	function DoCalculation(fieldId)
	{
		var _fieldId = fieldId.split('-');
        var field_tot  = $('#'+fieldId).val();
		var fieldOne  = $('#shift_one_persons').val();
		var fieldTwo  = $('#shift_two_persons').val();
		var fieldThree  = $('#shift_three_persons').val();
		var fieldFour  = $('#general_shift_persons').val();
		
		var total = parseFloat(fieldOne) + parseFloat(fieldTwo) + parseFloat(fieldThree)+ parseFloat(fieldFour);
		//console.log(achievement);
		if(!isNaN(total)){
			if(Number(field_tot) == Number(total))
			{
				$('#'+fieldId).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('Total No. of Persons per day is not validating. Kindly correct before proceeding');
				 $('#'+fieldId).val('');
				 $('#'+fieldId).addClass('is-invalid');
			}
		}
	}
	function CalculateAvgWorking(elementId)
	{
		
		var shift_day =  $('#no_shift_per_day').val();
		var TotalPerson = 0;
		$("input[name='total_per_day_persons[]']").each(function () {
    		TotalPerson += parseInt($(this).val());
		});

		var avg_working = parseFloat(TotalPerson) / parseFloat(shift_day);
		if(!isNaN(avg_working))
		{
			$('#'+elementId).val(avg_working);
		}		
	}

	
	function DoCalculationTotalPerson(fieldId)
	{
		var _fieldId = fieldId.split('-');
        var field_tot  = $('#'+fieldId).val();

		var fieldOne  = $('#shift_one_persons').val();
		var fieldTwo  = $('#shift_two_persons').val();
		var fieldThree  = $('#shift_three_persons').val();
		var fieldFour  = $('#general_shift_persons').val();

		var total = parseFloat(fieldOne) + parseFloat(fieldTwo) + parseFloat(fieldThree)+ parseFloat(fieldFour);
		if(!isNaN(total)){
			if(Number(field_tot) == Number(total))
			{
				$('#'+fieldId).removeClass('is-invalid');
				return true;
			}else{
					
				showAlrt('Total No. of Persons per day is not validating. Kindly correct before proceeding');
				 $('#'+fieldId).val('');
				 $('#'+fieldId).addClass('is-invalid');
			}
		}
	}

});