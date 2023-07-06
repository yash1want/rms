
$(document).ready(function() {

// alert("hello");
    $('#ticketTable').on('click', '#add_more_btn', function() {

       addMoreRw();
    });
    
    $('#ticketTable').on('click', '.rem_btn', function(){
        var rwId = $(this).closest('tr').attr('id');
        
        remRw(rwId);

    });


function addMoreRw() {
     
    var cRw = $('#ticketTable tbody tr:last').attr('id');
    
    if (typeof cRw === 'undefined') {
    
        var cRw = 'rw-1';
    }
    
   
    var cRwArr = cRw.split('-');
    var nRw = parseInt(cRwArr[1]) + parseInt(1);
    
    var rwCon = '<tr id="rw-'+nRw+'"><td class="text-center srno">'+nRw+'</td>';
    rwCon += '<td><div class="input text"><input type="file" name="add_more_attachment[]"  class="form-control" id="add_more_attachment" value="" autocomplete="off"></div><div class="err_cv"></div></td>';
    rwCon += '<td><div class="input textarea"><textarea name="add_more_description[]" class="form-control" id="add_more_description" placeholder="Enter Description" maxlength="10000" value="" autocomplete="off"></textarea></div><div class="err_cv"></div></td>';
    rwCon += '<td><button type="button" class="btn btn-sm rem_btn"><i class="fa fa-times"></i></button></td></tr>';

    $('#ticketTable tbody').append(rwCon);
        

    $('#ticketTable tbody tr').each(function(i) {
        $(this).find('.srno').text(i + 1);
        $(this).attr('id', 'rw-' + (i + 1));
    });
    upRemBtn();
    calcInstitutionCount();

}

function upRemBtn(){

    var tRw = $('#ticketTable tbody tr').length;
    if(tRw == 2){
        $('#ticketTable tbody tr:first .rem_btn').removeAttr('disabled');
    } else if(tRw == 1) {
        $('#ticketTable tbody tr:first .rem_btn').attr('disabled','true');
    }

}

function remRw(rwId){

    $('#' + rwId).remove();
    updateSerialNo();

}

function updateSerialNo() {
    
    $('#ticketTable tbody tr').each(function(i) {
        $(this).find('.srno').text(i + 1);
        $(this).attr('id', 'rw-' + (i + 1));
    });
}

function upRw() {

    var rws = $('#ticketTable tbody tr').length;
    var rwId = 1;
    for (var i=0; i < rws; i++) {

        var rw = $('#ticketTable tbody tr').eq(i);
        rw.find('.institution').attr({name: 'institute_name_'+rwId, id: 'institute_name_'+rwId});
        rw.find('.loan').attr({name: 'loan_amount_'+rwId, id: 'loan_amount_'+rwId});
        rw.find('.interest').attr({name: 'interest_rate_'+rwId, id: 'interest_rate_'+rwId});
        rw.attr('id', 'rw-'+rwId);

        rwId++;

    }
    updateSerialNo();

}

function upRemBtnAll(){

    var tRw = $('#ticketTable tbody tr').length;
    if (tRw > 1) {
        $('#ticketTable tbody tr .rem_btn').removeAttr('disabled');
    } else {
        $('#ticketTable tbody tr:first .rem_btn').attr('disabled','true');
    }

}

function calcInstitutionCount() {

    var tRw = $('#ticketTable tbody tr').length;
    $('#institutionCount').val(tRw);

}

});
