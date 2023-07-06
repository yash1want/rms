$(document).ready(function () {

	$('#form_id').ready(function () {

		$("select[name='through_action[]']").each(function () {
			var id1 = $(this).attr('id');
			PreShowHideColumn(id1, 'auction_captive_use', 'auction_ncaptive_use');
		});
		$("select[name='auction_captive_use[]']").each(function () {
			var id2 = $(this).attr('id');
			PreShowHideColumn(id2, 'through_action', 'auction_ncaptive_use');
		});
		$("select[name='auction_ncaptive_use[]']").each(function () {
			var id3 = $(this).attr('id');
			PreShowHideColumn(id3, 'auction_captive_use', 'through_action');
		});
	});


	$('#form_id').on('change', '.action', function () {
		var id = $(this).attr('id');
		showHideColumn(id, 'auction_captive_use', 'auction_ncaptive_use');
	});
	$('#form_id').on('change', '.captive', function () {
		var id = $(this).attr('id');
		showHideColumn(id, 'through_action', 'auction_ncaptive_use');
	});
	$('#form_id').on('change', '.ncaptive', function () {
		var id = $(this).attr('id');
		showHideColumn(id, 'auction_captive_use', 'through_action');
	});
	function PreShowHideColumn(elementId, fieldOne, fieldTwo) {
		var single_id = elementId.split('-');
		var elementVal = $('#' + elementId).val();
		if (elementVal == '1') {
			setTimeout(function () {
				$('#' + single_id[0] + '-' + fieldOne + '-' + single_id[2]).attr('readonly', true);
				$('#' + single_id[0] + '-' + fieldTwo + '-' + single_id[2]).attr('readonly', true);
				$('#' + single_id[0] + '-' + fieldOne + '-' + single_id[2]).html('<option value="2">no</option>');
				$('#' + single_id[0] + '-' + fieldTwo + '-' + single_id[2]).html('<option value="2">no</option>');
			}, 100);
		}
	}
});
function showHideColumn(elementId, fieldOne, fieldTwo) {
	var single_id = elementId.split('-');
	var elementVal = $('#' + elementId).val();

	// console.log(single_id);
	console.log(elementVal);

	if (elementVal == '1') {
		$('#' + single_id[0] + '-' + fieldOne + '-' + single_id[2]).attr('readonly', true);
		$('#' + single_id[0] + '-' + fieldTwo + '-' + single_id[2]).attr('readonly', true);

		$('#' + single_id[0] + '-' + fieldOne + '-' + single_id[2]).html('<option value="2">no</option>');
		$('#' + single_id[0] + '-' + fieldTwo + '-' + single_id[2]).html('<option value="2">no</option>');
	} else {

		$('#' + single_id[0] + '-' + fieldOne + '-' + single_id[2]).attr('readonly', false);
		$('#' + single_id[0] + '-' + fieldTwo + '-' + single_id[2]).attr('readonly', false);

		$('#' + single_id[0] + '-' + fieldOne + '-' + single_id[2]).html('<option value="">--select--</option><option value="1">yes</option><option value="2">no</option>');
		$('#' + single_id[0] + '-' + fieldTwo + '-' + single_id[2]).html('<option value="">--select--</option><option value="1">yes</option><option value="2">no</option>');
	}

}




  









