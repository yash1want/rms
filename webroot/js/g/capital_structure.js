
$(document).ready(function() {

    upRemBtn();
    upRemBtnAll();
    calcInstitutionCount();

    CapStruc.fieldValidation();

    $('#capStrucTable').on('click', '#add_more_btn', function() {
        addMoreRw();
    });
    
    $('#capStrucTable').on('click', '.rem_btn', function(){
        var rwId = $(this).closest('tr').attr('id');
        remRw(rwId);
    });

});

function addMoreRw() {
    
    var cRw = $('#capStrucTable tbody tr:last').attr('id');
    var cRwArr = cRw.split('-');
    var nRw = parseInt(cRwArr[1]) + parseInt(1);

    var rwCon = '<tr id="rw-'+nRw+'"><td><div class="input text"><input type="text" name="institute_name_'+nRw+'" class="form-control form-control-sm number-fields-small institution" id="institute_name_'+nRw+'" value="" autocomplete="off"></div><div class="err_cv"></div></td>';
    rwCon += '<td><div class="input text"><input type="text" name="loan_amount_'+nRw+'" class="form-control form-control-sm number-fields-small loan" id="loan_amount_'+nRw+'" value="" autocomplete="off"></div><div class="err_cv"></div></td>';
    rwCon += '<td><div class="input text"><input type="text" name="interest_rate_'+nRw+'" class="form-control form-control-sm number-fields-small interest" id="interest_rate_'+nRw+'" value="" autocomplete="off"></div><div class="err_cv"></div></td>';
    rwCon += '<td><button type="button" class="btn btn-sm rem_btn"><i class="fa fa-times"></i></button></td></tr>';

    $('#capStrucTable tbody').append(rwCon);
    upRemBtn();
    calcInstitutionCount();

}

function upRemBtn(){

	var tRw = $('#capStrucTable tbody tr').length;
	if(tRw == 2){
		$('#capStrucTable tbody tr:first .rem_btn').removeAttr('disabled');
	} else if(tRw == 1) {
		$('#capStrucTable tbody tr:first .rem_btn').attr('disabled','true');
	}

}

function remRw(rwId){

	$('#' + rwId).remove();
    upRemBtn();
    upRw();
    calcInstitutionCount();

}

function upRw() {

    var rws = $('#capStrucTable tbody tr').length;
    var rwId = 1;
    for (var i=0; i < rws; i++) {

        var rw = $('#capStrucTable tbody tr').eq(i);
        rw.find('.institution').attr({name: 'institute_name_'+rwId, id: 'institute_name_'+rwId});
        rw.find('.loan').attr({name: 'loan_amount_'+rwId, id: 'loan_amount_'+rwId});
        rw.find('.interest').attr({name: 'interest_rate_'+rwId, id: 'interest_rate_'+rwId});
        rw.attr('id', 'rw-'+rwId);

        rwId++;

    }

}

function upRemBtnAll(){

	var tRw = $('#capStrucTable tbody tr').length;
    if (tRw > 1) {
		$('#capStrucTable tbody tr .rem_btn').removeAttr('disabled');
    } else {
		$('#capStrucTable tbody tr:first .rem_btn').attr('disabled','true');
    }

}

function calcInstitutionCount() {

	var tRw = $('#capStrucTable tbody tr').length;
    $('#institutionCount').val(tRw);

}
