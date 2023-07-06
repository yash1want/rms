$(document).ready(function () {
	$('#form_id').on('change', '.lease_grnt', function () {
		var id = $(this).attr('id');
		checkDuplication(id);
	});
	$('#form_id').on('blur', '.exe_date', function () {
		var id = $(this).attr('id');
		checkExeDate(id);
	});

	$('#form_id').on('change', '.grant_from', function () {
		var id = $(this).attr('id');
		var single_id = id.split('-');
		var elementVal = (single_id[0] + '-registration_date-' + single_id[2])
		printFromDate(elementVal);
	});

	$('#form_id').on('change', '.reg_date', function () {
		var id = $(this).attr('id');
		checkFromDateRegDateEqual(id);
	});

});

function checkDuplication(elementId) {
	var single_id = elementId.split('-');
	var elementVal = $('#' + elementId).val();

	$("select[name='lease_grant_number[]']").each(function () {
		var grantId = $(this).attr('id');
		var grant_single_id = grantId.split('-');
		var grantVal = $(this).val();

		if (grantId != elementId) {
			if (grantVal == elementVal) {
				showAlrt('This grant has been already selected');
				$('#' + elementId).val('');
				$('#' + elementId).addClass('is-invalid');
			} else {
				$('#' + elementId).removeClass('is-invalid');
			}

			if (elementVal == '2' && grantVal == '1') {
				var grant_to_date = $('#' + grant_single_id[0] + '-grant_to-' + grant_single_id[2]).val();
				$('#' + single_id[0] + '-grant_from-' + single_id[2]).attr('min', grant_to_date);
			} else if (elementVal == '3' && grantVal == '2') {
				var grant_to_date = $('#' + grant_single_id[0] + '-grant_to-' + grant_single_id[2]).val();
				$('#' + single_id[0] + '-grant_from-' + single_id[2]).attr('min', grant_to_date);
			} else if (elementVal == '4' && grantVal == '3') {
				var grant_to_date = $('#' + grant_single_id[0] + '-grant_to-' + grant_single_id[2]).val();
				$('#' + single_id[0] + '-grant_from-' + single_id[2]).attr('min', grant_to_date);
			} else if (elementVal == '5' && grantVal == '4') {
				var grant_to_date = $('#' + grant_single_id[0] + '-grant_to-' + grant_single_id[2]).val();
				$('#' + single_id[0] + '-grant_from-' + single_id[2]).attr('min', grant_to_date);
			} else if (elementVal == '6' && grantVal == '5') {
				var grant_to_date = $('#' + grant_single_id[0] + '-grant_to-' + grant_single_id[2]).val();
				$('#' + single_id[0] + '-grant_from-' + single_id[2]).attr('min', grant_to_date);
			} else if (elementVal == '7' && grantVal == '6') {
				var grant_to_date = $('#' + grant_single_id[0] + '-grant_to-' + grant_single_id[2]).val();
				$('#' + single_id[0] + '-grant_from-' + single_id[2]).attr('min', grant_to_date);
			}


		}
	});
}

function checkExeDate(elementId) {
	var single_id = elementId.split('-');
	var elementVal = $('#' + elementId).val();

	var grant_from = $('#' + single_id[0] + '-grant_from-' + single_id[2]).val();
	var execution_date = $('#' + single_id[0] + '-execution_date-' + single_id[2]).val();
	var registration_date = $('#' + single_id[0] + '-registration_date-' + single_id[2]).val();
	var grnt_no = $('#' + single_id[0] + '-lease_grant_number-' + single_id[2]).val();

	if (grnt_no == '1') {
		var _grant_from = new Date(grant_from);
		var _execution_date = new Date(execution_date);
		var _registration_date = new Date(registration_date);

		if (grant_from == execution_date) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		} else if (grant_from == registration_date) {
			$('#' + elementId).removeClass('is-invalid');
			return true;
		}
		else {
			showAlrt('Lease registration date / Lease deed execution date should be equal to From date');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}

	function checkFromDate(elementId) {
		var single_id = elementId.split('-');
		var elementVal = $('#' + elementId).val();
		console.log(single_id);
	}

}

// To print on changing From Date on Registration Date  13-05-2022 Shweta Apale
function printFromDate(elementId) {
	var single_id = elementId.split('-');
	var elementVal = $('#' + elementId);
	var grant_from = $('#' + single_id[0] + '-grant_from-' + single_id[2]).val();

	elementVal.val(grant_from);
}

// To check From Date is equal to Registration Date 13-05-2022 Shweta Apale
function checkFromDateRegDateEqual(elementId) {
	var single_id = elementId.split('-');
	var elementVal = $('#' + elementId);

	var grant_from = $('#' + single_id[0] + '-grant_from-' + single_id[2]).val();
	var registration_date = $('#' + single_id[0] + '-registration_date-' + single_id[2]).val();

	var _grant_from = new Date(grant_from);
	var _registration_date = new Date(registration_date);

	if (grant_from != registration_date) {
		showAlrt('Lease registration date should be equal to From date');
		$('#' + elementId).val();
		$('#' + elementId).addClass('is-invalid');
	}


}