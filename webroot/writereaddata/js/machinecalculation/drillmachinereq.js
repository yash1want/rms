$(document).ready(function () {


  $('#form_id').on('blur', '.meter_yield', function () {
    var elementId = $(this).attr('id');
    GetMeterTotal(elementId);
  });
  $('#form_id').on('blur', '.drill_req', function () {
    var elementId = $(this).attr('id');
    GetDrillReqTotal(elementId);
  });
  $('#form_id').on('blur', '.drill_hour', function () {
    var elementId = $(this).attr('id');
    GetDrillHourTotal(elementId);
  });
  // Commented below validation call as validation removal requested by IBM division through doc "Validation changes for Required No. of Drills"
  // via mail dated 23-01-2023 - Aniket G [23-01-2023]
  // $('#form_id').on('blur', '.drill_number', function () {
  //   var elementId = $(this).attr('id');
  //   GetDrillNumberTotal(elementId);
  // });
  function GetMeterTotal(elementId) {
    var single_id = elementId.split('-');
    var elementValue = $('#' + elementId).val();

    var fieldOneValue = $('#' + single_id[0] + '-hole_yield-' + single_id[2]).val();
    var fieldTwoValue = $('#' + single_id[0] + '-hole_depth-' + single_id[2]).val();

    // console.log(fieldOneValue);
    // console.log(fieldTwoValue);

    var total = parseFloat(fieldOneValue) / parseFloat(fieldTwoValue);
		totalRounded = total.toFixed(2);
		var totalArr = total.toString().split('.');
		var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
    if (!isNaN(total)) {
      // if (Number(total) == Number(elementValue)) {
      if (Number(elementValue) == Number(totalRounded) || Number(elementValue) == Number(totalTruncated)) {
        $('#' + elementId).removeClass('is-invalid');
        return true;
      } else {

        showAlrt('For Yield per Meter (t/m) (Yield per Hole (t)  / Depth of Hole) is not validating . Kindly correct before proceeding');
        $('#' + elementId).val('');
        $('#' + elementId).addClass('is-invalid');
      }
    }
  }
  function GetDrillReqTotal(elementId) {
    var single_id = elementId.split('-');
    var elementValue = $('#' + elementId).val();
    var Workingdays = $('#Workingdays').val();

    var fieldOneValue = $('#' + single_id[0] + '-annual_target_known-' + single_id[2]).val();
    var fieldTwoValue = $('#' + single_id[0] + '-meter_yield-' + single_id[2]).val();

    var total = parseFloat(fieldOneValue) / parseFloat(fieldTwoValue) / parseFloat(Workingdays);
		totalRounded = total.toFixed(2);
		var totalArr = total.toString().split('.');
		var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;
    if (!isNaN(total)) {
      // if (Number(total) == Number(elementValue)) {
      if (Number(elementValue) == Number(totalRounded) || Number(elementValue) == Number(totalTruncated)) {
        $('#' + elementId).removeClass('is-invalid');
        return true;
      } else {

        showAlrt('For Drilling Requirement per Day (m) (Annual Target Known(t)  / Yield per Meter (t/m) / Average Working Days ) is not validating . Kindly correct before proceeding');
        $('#' + elementId).val('');
        $('#' + elementId).addClass('is-invalid');
      }
    }
  }
  function GetDrillHourTotal(elementId) {
    var single_id = elementId.split('-');
    var elementValue = $('#' + elementId).val();

    var fieldOneValue = $('#' + single_id[0] + '-drill_req_per_shift-' + single_id[2]).val();
    var effectiveShiftHr = parseInt($('#Effshift').val());
    var effectiveShiftMn = parseInt($('#EffSftmin').val());

    var hrTwo = effectiveShiftMn / 60;
    hrTwo = hrTwo.toFixed(2);
    effectiveShiftHr = parseInt(effectiveShiftHr) + parseFloat(hrTwo);

    var total = parseFloat(fieldOneValue) / parseFloat(effectiveShiftHr);
		totalRounded = total.toFixed(2);
		var totalArr = total.toString().split('.');
		var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;

    if (!isNaN(total)) {
      // if (Number(total) == Number(elementValue)) {
      if (Number(elementValue) == Number(totalRounded) || Number(elementValue) == Number(totalTruncated)) {
        $('#' + elementId).removeClass('is-invalid');
        return true;
      } else {

        showAlrt('For Rate of Drilling per Hours (m/hr) (Drilling Requirement per Shif t(m) / Effective Shift Time ) is not validating . Kindly correct before proceeding');
        $('#' + elementId).val('');
        $('#' + elementId).addClass('is-invalid');
      }
    }
  }
  function GetDrillNumberTotal(elementId) {
    var single_id = elementId.split('-');
    var elementValue = $('#' + elementId).val();

    var fieldOneValue = $('#' + single_id[0] + '-annual_target_known-' + single_id[2]).val();
    var fieldTwoValue = $('#' + single_id[0] + '-drill_req_per_day-' + single_id[2]).val();
    var fieldThreeValue = $('#' + single_id[0] + '-meter_yield-' + single_id[2]).val();
    var fieldFourValue = $('#Workingdays').val();

    // console.log(fieldOneValue);
    // console.log(fieldTwoValue);
    // console.log(fieldThreeValue);
    // console.log(fieldFourValue);

    var total = parseFloat(fieldOneValue) / (parseFloat(fieldTwoValue) * parseFloat(fieldThreeValue) * parseFloat(fieldFourValue));
		totalRounded = total.toFixed(2);
		var totalArr = total.toString().split('.');
		var totalTruncated = (totalArr.length == 2) ? totalArr[0] + '.' + totalArr[1].toString().substr(0, 2) : total;

    // console.log(total);

    if (!isNaN(total)) {
      // if (Number(total) == Number(elementValue)) {
      if (Number(elementValue) == Number(totalRounded) || Number(elementValue) == Number(totalTruncated)) {
        $('#' + elementId).removeClass('is-invalid');
        return true;
      } else {

        showAlrt('For Required Number of Drills (m/c) is not validating . Kindly correct before proceeding');
        $('#' + elementId).val('');
        $('#' + elementId).addClass('is-invalid');
      }
    }
  }


});