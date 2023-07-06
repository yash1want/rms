$(document).ready(function () {
	$('.deviation').on('blur', function () {
		var id = $(this).attr('id');
		getTotal(id);
	});

	function getTotal(deviation) {
		var sep_id = deviation.split('_');
		var deviationVal = $('#' + deviation).val();
		var activity_area = $('#' + sep_id[0] + '_prop_activity').val();
		var area_utilize = $('#' + sep_id[0] + '_area_utilize').val();

		// var total = parseInt(activity_area) - parseInt(area_utilize); Commented on 20-05-2022 by Shweta Apale as per formula
		var total = parseFloat(area_utilize) - parseFloat(activity_area); //changed to 'parseFloat' from 'parseInt' on 03-08-2022 by Aniket
		total = total.toFixed(2); // added on 09-08-2022 by Aniket
		deviationVal = parseFloat(deviationVal).toFixed(2); // added on 09-08-2022 by Aniket

		if (!isNaN(total)) {
			if (deviationVal == total) {
				$('#' + deviation).removeClass('is-invalid');
				return true;
			} else {
				showAlrt('For Deviation (Actual Area utilized in the proposal period - Area proposed under activity) is not validating. Kindly correct before proceeding');
				$('#' + deviation).val('0');
				$('#' + deviation).addClass('is-invalid');
			}
		}
	}
	$(".tot").on('blur', function () {
		var elementId = $(this).attr('id');
		var elementName = $(this).attr('name');
		updateSubTotal(elementName, elementId);
	});

	function updateSubTotal(fieldName, fieldId) {
		// Commented below total validation logic as new formula is provided by Bhattacharya Sir, IBM on 08-08-2022
		// which is Total = (Total area put to use(12) - Excavated area reclaimed(13) - Waste dump area reclaimed(14) + Undisturbed Area(15))
		// added on 09-08-2022 by Aniket
		// var sum_prop = 0;
		// $("input[name='" + fieldName + "']").each(function () {
		// 	var _elementId = $(this).attr('id');
		// 	var nameFirst = _elementId.split('_');

		// 	// Added extra condition for calculation because no need to total deviation so remove all id of deviation new formula implemented in new function named substractTotalDeviation on 20-05-2022 by Shweta Apale
		// 	if (nameFirst[0] !== 'tot' && _elementId !== 'mining_deviation' && _elementId !== 'mstor_deviation' && _elementId !== 'min_deviation' && _elementId !== 'town_deviation' && _elementId !== 'tail_deviation' && _elementId !== 'rail_deviation' && _elementId !== 'road_deviation' && _elementId !== 'infra_deviation' && _elementId !== 'ob_deviation' && _elementId !== 'top_deviation' && _elementId !== 'other_deviation' && _elementId !== 'use_deviation' && _elementId !== 'excav_deviation' && _elementId !== 'waste_deviation' && _elementId !== 'und_deviation' && _elementId !== 'tot_deviation') {
		// 		if($(this).val() !== ''){
		// 			sum_prop += parseFloat($(this).val());
		// 		}
		// 	}
		// });
		// var getTotal = $('#' + fieldId).val();
		// if (getTotal == sum_prop) {
		// 	$('#' + fieldId).removeClass('is-invalid');
		// 	return true;
		// } else {

		// 	showAlrt('Total is not validating. Kindly correct before proceeding');
		// 	$('#' + fieldId).val('0');
		// 	$('#' + fieldId).addClass('is-invalid');
		// }
		
		// no need to total deviation
		if(fieldId == 'tot_deviation') {
			return true;
		}

		var totAreaPutToUse;
		var excavatedAreaReclaimed;
		var wasteDumpAreaReclaimed;
		var undisturbedArea;
		switch(fieldId){
			case 'tot_beg_prop_perod':
				totAreaPutToUse = $('#use_beg_prop_perod').val();
				excavatedAreaReclaimed = $('#excav_beg_prop_perod').val();
				wasteDumpAreaReclaimed = $('#waste_beg_prop_perod').val();
				undisturbedArea = $('#und_beg_prop_perod').val();
				break;
			case 'tot_prop_activity':
				totAreaPutToUse = $('#use_prop_activity').val();
				excavatedAreaReclaimed = $('#excav_prop_activity').val();
				wasteDumpAreaReclaimed = $('#waste_prop_activity').val();
				undisturbedArea = $('#und_prop_activity').val();
				break;
			case 'tot_area_utilize':
				totAreaPutToUse = $('#use_area_utilize').val();
				excavatedAreaReclaimed = $('#excav_area_utilize').val();
				wasteDumpAreaReclaimed = $('#waste_area_utilize').val();
				undisturbedArea = $('#und_area_utilize').val();
				break;
		}
		
		var enteredTot = $('#' + fieldId).val();
		enteredTot = parseFloat(enteredTot).toFixed(2);
		var totCalculated = (parseFloat(totAreaPutToUse) - parseFloat(excavatedAreaReclaimed) - parseFloat(wasteDumpAreaReclaimed)) + parseFloat(undisturbedArea);
		totCalculated = parseFloat(totCalculated).toFixed(2);
		
		if (enteredTot == totCalculated) {
			$('#' + fieldId).removeClass('is-invalid');
			return true;
		} else {
			showAlrt('For Total (Total area put to use - Excavated area reclaimed - Waste dump area reclaimed + Undisturbed Area) is not validating. Kindly correct before proceeding');
			$('#' + fieldId).val('0');
			$('#' + fieldId).addClass('is-invalid');
		}

	}

	// Added by Shweta Apale on 20-05-2022 to Substract total Actual area utilized in the proposal period - total Area proposed under activity.
	$(".tot_deviation").on('blur', function () {
		var elementId = $(this).attr('id');
		var elementName = $(this).attr('name');
		console.log(elementId);
		substractTotalDeviation(elementName, elementId);
	});

	function substractTotalDeviation(elementName, elementId) {
		var tot_area_utilize = $('#tot_area_utilize').val();
		var tot_prop_activity = $('#tot_prop_activity').val();
		var deviationVal = $('#tot_deviation').val();

		var substract = parseFloat(tot_area_utilize) - parseFloat(tot_prop_activity); //changed to 'parseFloat' from 'parseInt' on 03-08-2022 by Aniket
		substract = substract.toFixed(2); // added on 09-08-2022 by Aniket
		deviationVal = parseFloat(deviationVal).toFixed(2); // added on 09-08-2022 by Aniket

		if (!isNaN(substract)) {
			if (deviationVal == substract) {
				$('#tot_deviation').removeClass('is-invalid');
				return true;
			} else {
				showAlrt('For Total Deviation (Total Actual Area utilized in the proposal period - Total Area proposed under activity) is not validating. Kindly correct before proceeding');
				$('#tot_deviation').val('0');
				$('#tot_deviation').addClass('is-invalid');
			}
		}

	}
});