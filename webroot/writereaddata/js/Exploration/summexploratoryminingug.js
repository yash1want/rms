// Created by Shweta Apale on 21-06-2022 Start
$(document).ready(function () {
    $('#form_id').on('blur', '.totalVolume', function () {
        var id = $(this).attr('id');
        doCalculation(id);
    });

});

function doCalculation(elementId) {
    var fieldId = elementId.split('-');
    var fieldValue = $('#' + elementId).val();
    var fieldOne = $('#ta-length_m-' + fieldId[2]).val();
    var fieldTwo = $('#ta-width_m-' + fieldId[2]).val();
    var fieldThree = $('#ta-depth_m-' + fieldId[2]).val();
    var total = parseFloat(fieldOne) * parseFloat(fieldTwo) * parseFloat(fieldThree);


    if (!isNaN(total)) {
        if (Number(total) == Number(fieldValue)) {
            $('#' + elementId).removeClass('is-invalid');
            return true;
        } else {
            showAlrt('Total is not validating. Kindly correct before proceeding');
            $('#' + elementId).val('0');
            $('#' + elementId).addClass('is-invalid');
        }
    }
}
// End