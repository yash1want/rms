$(document).ready(function () {


	$('#form_id').on('blur', '.working_days', function () {
		var id = $(this).attr('id');
		DoCalculation(id);
	});

	$('#form_id').on('blur', '.key', function () {
		var id = $(this).attr('id');
		DoMaterialCalculation(id);
	});

	$('#form_id').on('blur', '.mat_hand', function () {
		DoMaterialCalculation();
	});
	$('#form_id').on('change', '.shiftT', function () {
		DoMaterialCalculation();
	});
	$('#form_id').on('blur', '.reSum', function () {
		var id = $(this).attr('id');
		DoHandlingReqCalculation(id);
	});

	function DoCalculation(elementId) {
		// console.log(elementId);
		var total_quantity = $('#total_quantity').val();

		//  console.log(total_quantity);
		var elementValue = $('#' + elementId).val();
		var material_handle = 0;
		if (Number(elementValue) > 365) {
			$('#' + elementId).val('0');
			//$('#' + elementId).parent().parent().find('.err_cv:first').text('Max working day should be 365');
			showAlrt('Max working day should be 365');
			//return false;

		} else if (total_quantity != '' && elementValue != '') {
			material_handle = parseFloat(total_quantity) / parseFloat(elementValue);
			material_handle = material_handle.toFixed(2);
		}
		$('#Num2').val(material_handle);
	}

	function DoMaterialCalculation() {
		var sum = parseInt(document.getElementById('Sum').value);
		var eff_shift_hr = parseInt(document.getElementById('Effshift').value);
		var eff_shift_min = parseInt(document.getElementById('Effshiftmin').value);
		var shift_min = (eff_shift_min == '2') ? "30" : '00';
		switch (eff_shift_hr) {
			case 5:
				eff_time = "8";
				break;
			case 4:
				eff_time = "7";
				break;
			case 3:
				eff_time = "6";
				break;
			case 2:
				eff_time = "5";
				break;
			case 1:
				eff_time = "4";
				break;
			default:
				eff_time = "8";
		}
		var _time = eff_time + '.' + shift_min;
		var handlingReq = sum / _time;
		var handReq = handlingReq.toFixed(2);

		$('#Sum2').val(handReq);

		// document.getElementById("Sum2").value = handlingReq.toFixed(2);
	}

	function DoHandlingReqCalculation(elementId) {
		var num1 = parseInt(document.getElementById("Num1").value);
		var num2 = parseInt(document.getElementById("Num2").value);
		var _Sum = num2 / num1;
		var sum = _Sum.toFixed(2);
		// console.log(_Sum);
		// document.getElementById("Sum").value = _Sum.toFixed(2);

		// console.log(s);
		$('#Sum').val(sum);
	}
	
	$('#Num1').on('click',function(){
		$('#Num1').removeClass('is-invalid');
	});

	$('#Num1').on('change',function(){

		var shifts = $(this).val();
		if(shifts != ''){
			if(parseFloat(shifts) < 0 || parseFloat(shifts) > 3){
				$('#Num1').val('');
				$('#Num1').addClass('is-invalid');
				showAlrt('Allow only number not greater than 3');
			}
		}

	});

});