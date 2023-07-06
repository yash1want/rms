// Created by Shweta Apale on 19-05-2022

$(document).ready(function () {
    $('#form_id').on('blur', '.top_stored', function () {
		var id = $(this).attr('id');
        console.log(id);
		doSubstractCalculation(id);
	});
});

function doSubstractCalculation(elementId){
    var single_id = elementId.split('-');
	var field_val = $('#' + elementId).val();

	var fieldOne = $('#' + single_id[0] + '-top_soil_generated-' + single_id[2]).val();
	var fieldTwo = $('#' + single_id[0] + '-top_soil_utilized-' + single_id[2]).val();
	var total = parseFloat(fieldOne) - parseFloat(fieldTwo);
	console.log(total);

	if (!isNaN(total)) {
		if (Number(field_val) == Number(total)) {
			$('#' + elementId).removeClass('is-invalid');
			return true;

		} else {
			showAlrt('For Top Soil Stored (m³) = Top Soil Generated (m³) - Top Soil Utilized (m³)) is not validating. Kindly correct before proceeding');
			$('#' + elementId).val('');
			$('#' + elementId).addClass('is-invalid');
		}
	}
}