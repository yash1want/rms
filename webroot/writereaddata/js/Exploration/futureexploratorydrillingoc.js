$(document).ready(function () {
  $('#form_id').on('blur', '.total_bore', function () {
    var id = $(this).attr('id');
    doCalculation(id);
  });

  // Added by Shweta Apale on 21-06-2022 Start
  $('#form_id').on('blur', '.total_mtr', function () {
    var id = $(this).attr('id');
    doCalculationMtr(id);
  });
  // End

});

function doCalculation(elementId) {
  var fieldId = elementId.split('-');
  var fieldValue = $('#' + elementId).val();
  var fieldOne = $('#ta-for_borehole_drilled-' + fieldId[2]).val();
  var fieldTwo = $('#ta-nfor_borehole_drilled-' + fieldId[2]).val();
  var total = parseFloat(fieldOne) + parseFloat(fieldTwo);


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

// Added by Shweta Apale on 21-06-2022 Start
function doCalculationMtr(elementId) {
  var fieldId = elementId.split('-');
  var fieldValue = $('#' + elementId).val();
  var fieldOne = $('#ta-for_total_mtr-' + fieldId[2]).val();
  var fieldTwo = $('#ta-nfor_total_mtr-' + fieldId[2]).val();
  var total = parseFloat(fieldOne) + parseFloat(fieldTwo);


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