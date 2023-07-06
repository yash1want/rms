
var optionEl = $('#free_option_arr').val();
var newOption = optionEl+'<div class="err_cv"></div>';
var selectedOpt = "";

$(document).ready(function() {

    EmploymentWages.fieldValidation();
    EmploymentWages.employmentWagesIPostValidation();

    calStaffTotal();
    upAddMoreBtn();
    upRemBtn();
    upRemBtnAll();

    $('#reason_tbl').on('click', '#add_more_btn', function() {
        var rws = $('#reason_tbl tbody tr').length;
        var reasons = $('#reasons_len').val();
        if (rws < reasons) {
            addMoreRw();
        }
    });
    
    $('#reason_tbl').on('click', '.rem_btn', function(){

        var rwId = $(this).closest('tr').attr('id');
        remRw(rwId);

    });

});

function addMoreRw() {
    
    var cRw = $('#reason_tbl tbody tr:last').attr('id');
    var cRwArr = cRw.split('-');
    var nRw = parseInt(cRwArr[1]) + parseInt(1);

    selectEle = newOption.replace(/rwStringPurpose/g,nRw);

    // var selectEleLastKey = '<input type="hidden" name="stop_res_last_key[]" id="sto_res_last_key-rwStringPurpose" value="">';
    // var selectEleLastVal = '<input type="hidden" name="stop_res_last_val[]" id="sto_res_last_val-rwStringPurpose" value="">';

    // selectEleLastKey = selectEleLastKey.replace(/rwStringPurpose/g,nRw);
    // selectEleLastVal = selectEleLastVal.replace(/rwStringPurpose/g,nRw);

    var rwCon = "<tr id='rw-"+nRw+"'><td>"+selectEle+"</td><td><div class='input text'><input type='text' name='no_of_days_"+nRw+"' id='no_of_days_"+nRw+"' class='form-control form-control-sm no_of_days number-fields'></div><div class='err_cv'></div></td><td><button type='button' class='btn btn-sm rem_btn'><i class='fa fa-times'></i></button></td></tr>";

    $('#reason_tbl tbody').append(rwCon);
    upAddMoreBtn();
    upRemBtn();

}

function upAddMoreBtn(){

	var tRw = $('#reason_tbl tbody tr').length;
    var reasons = $('#reasons_len').val();
	if(tRw == reasons){
		$('#add_more_btn').hide();
	} else {
		$('#add_more_btn').show();
	}

}

function upRemBtn(){

	var tRw = $('#reason_tbl tbody tr').length;
	if(tRw == 2){
		$('#reason_tbl tbody tr:first .rem_btn').removeAttr('disabled');
	} else if(tRw == 1) {
		$('#reason_tbl tbody tr:first .rem_btn').attr('disabled','true');
	}

}


function remRw(rwId){

    /*
	var selId = rwId.split('-');
	var selectId = "stoppage_reason-"+selId[1];
	var curId = selId[1];
	var selOption = $('#'+rwId+' .select_reason').val();
	var selText = $('#'+rwId+' .select_reason option[value="'+selOption+'"]').text();

	if(!selOption.trim()){

	} else {

		$('.select_reason').not('#'+rwId+' .select_reason').append("<option value='"+selOption+"'>"+selText+"</option>");
		var selectedOptn='<option value="'+selOption+'">'+selText+'</option>';
		newOption = newOption.replace(selectedOptn, "");
		newOption = newOption.replace("</select>", '<option value="'+selOption+'">'+selText+'</option></select>');

	}
    */

	$('#' + rwId).remove();
    upAddMoreBtn();
    upRemBtn();
    upRw();

}

function upRw() {

    var rws = $('#reason_tbl tbody tr').length;
    var rwId = 1;
    for (var i=0; i < rws; i++) {

        var rw = $('#reason_tbl tbody tr').eq(i);
        rw.find('.select_reason').attr({name: 'reason_'+rwId, id: 'reason_'+rwId});
        rw.find('.no_of_days').attr({name: 'no_of_days_'+rwId, id: 'no_of_days_'+rwId});
        rw.attr('id', 'rw-'+rwId);

        rwId++;

    }

}

function calStaffTotal() {

    var whollyEmp = 0;
    var whollyNum = 0;
    var whollyEmpIn = $('#employmentWages .wholly-emp-tot');
    $.each(whollyEmpIn, function(key) {
        whollyEmp += parseInt(whollyEmpIn.eq(key).val());
        whollyNum = (whollyEmpIn.eq(key).val() == '') ? 1 : whollyNum;
    });
    
    var partlyEmp = 0;
    var partlyNum = 0;
    var partlyEmpIn = $('#employmentWages .partly-emp-tot');
    $.each(partlyEmpIn, function(key) {
        partlyEmp += parseInt(partlyEmpIn.eq(key).val());
        partlyNum = (whollyEmpIn.eq(key).val() == '') ? 1 : partlyNum;
    });

    whollyEmp = (whollyNum > 0) ? '' : whollyEmp;
    partlyEmp = (partlyNum > 0) ? '' : partlyEmp;
    $('#TOTAL_WHOLLY').val(whollyEmp);
    $('#TOTAL_PARTLY').val(partlyEmp);

}

function upRemBtnAll(){

	var tRw = $('#reason_tbl tbody tr').length;
    if (tRw > 1) {
		$('#reason_tbl tbody tr .rem_btn').removeAttr('disabled');
    } else {
		$('#reason_tbl tbody tr:first .rem_btn').attr('disabled','true');
    }

}