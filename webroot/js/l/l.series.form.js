/**
 * L-SERIES FORM VALIDATIONS
 * @version 13TH JUL 2021
 * @author Aniket Ganvir
 */

/* trading activity */
$(document).ready(function(){

    activityDetailsValidation.fieldValidation();
    activityDetailsValidation.countryOnQuantityCheck();

    //autocomplete country list
	// $('#frmActivityDetails').on("input", '.import_country', function(){

	// 	var inField = $(this).val();
	// 	var inData = $(this).parent().parent().find('.sugg-box');
    //     var getUrl = $('#get_country_url').val();

	// 	if (inField !== "") {
	// 		$.ajax({
	// 			url: getUrl,
	// 			type: "POST",
	// 			cache: false,
	// 			beforeSend: function (xhr) {
	// 				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
	// 			},
	// 			data: {'input':inField},
	// 			success:function(data){
    //                 if(data != ''){
    //                     inData.html(data);
    //                     inData.fadeIn();
    //                 }
	// 			}  
	// 		});
	//     } else {
	// 		inData.html("");  
	// 		inData.fadeOut();
	//     }

	// });

    //autocomplete registration number
	$('#frmActivityDetails').on("input", '.supplier_registration, .buyer_registration', function(){

		var inField = $(this).val();
		var inData = $(this).parent().parent().find('.sugg-box');
        var getUrl = $('#get_regno_url').val();

		if (inField !== "") {
			$.ajax({
				url: getUrl,
				type: "POST",
				cache: false,
				beforeSend: function (xhr) {
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				},
				data: {'app_id':inField},
				success:function(data){
                    if(data != ''){
                        inData.html(data);
                        inData.fadeIn();
                    }
				}  
			});
	    } else {
			inData.html("");  
			inData.fadeOut();
	    }

	});
    		
    $('#frmActivityDetails').on("click",".sugg-box ul li", function(){
        var inputField = $(this).closest('.sugg-box').parent().find('input');
        var suggestBox = $(this).closest('.sugg-box');
        inputField.val($(this).text());
        suggestBox.fadeOut("fast");
    });

    $('#frmActivityDetails').on('change', '.mineral', function(){

        var c_row = $('#frmActivityDetails #mineral_cnt').val();
        if(c_row > 1){

            var curMin = $(this).val();
            if(curMin != ''){
                var curEl = $(this).attr('id');
                var curElArr = curEl.split('_');
                var curElId = curElArr[1];
                for(var rw=1; rw<=c_row; rw++){
                    if(curElId != rw){
                        var othrMin = $('#trad_ac_tbl #mineral_'+rw).val();
                        if(othrMin == curMin){
                            showAlrt('This mineral name has been already selected');
                            $(this).prop('selectedIndex',0);
                        }
                    }
                }
            }

        }

    });
    
    $('#frmActivityDetails').on('change', '.grade', function(){

        var c_row = $('#frmActivityDetails #mineral_cnt').val();

        var curGrd = $(this).val();
        if(curGrd != ''){

            var curEl = $(this).attr('id');
            var curElArr = curEl.split('_');
            var curElId = curElArr[1]+'_'+curElArr[2];
            for(var rw=1; rw<=c_row; rw++){

                var gradeRw = $('#frmActivityDetails #grade_cnt_'+rw).val();
                for(var cn=1; cn<=gradeRw; cn++){

                    nElId = rw+'_'+cn;
                    if(curElId != nElId){
                        var othrGrd = $('#trad_ac_tbl #grade_'+nElId).val();
                        if(othrGrd == curGrd){
                            showAlrt('This mineral grade name has been already selected');
                            $(this).prop('selectedIndex',0);
                        }
                    }

                }
            }
        }

    });

    $('#frmActivityDetails').on('submit', function(){

        $('#frmActivityDetails').find('select').not(':hidden').not('select[disabled]').removeClass('is-invalid');
        $('#frmActivityDetails').find('input').not(':hidden').not('select[disabled]').removeClass('is-invalid');
        var returnFormStatus = true;
        var formStatus = 'valid';
        var formSelStatus = 'valid';

        var emptyStatus = formEmptyStatus('frmActivityDetails');

        var selRw = $('#frmActivityDetails').find('select').not(':hidden').not('select[disabled]').length;
        for(var i=0;i<selRw;i++){
            var selField = $('#frmActivityDetails').find('select').not(':hidden').not('select[disabled]').eq(i).val();
            if(selField == ''){
                showElAlrt('frmActivityDetails', 'select', i);
                formSelStatus = 'invalid';
            }
        }

        if(formSelStatus == 'invalid'){
            showAlrt('Select Options in all Select Boxes. <br>If No <b>Mineral/Grade</b> then Select <b>NIL</b>');
        }

        //closing stock validations
        var secNo = $('#frmActivityDetails #section_no').val();
        var minCnt = $('#frmActivityDetails #mineral_cnt').val();
        var closingStockStatus = 'valid';
        var importFieldStatus = 'valid';
        for(var i=1; i<=minCnt; i++){

            var grdcnt = $('#grade_cnt_'+i).val();
            for(var n=1; n<=grdcnt; n++){

                var opnQnt = $('#opening_stock_quantity_'+i+'_'+n).val();

                var supCnt = $('#supplier_table_'+i+'_'+n+'_1 tbody tr').length;
                var supQnt = 0;
                for(var m=1; m<=supCnt; m++){
                    supQnt += parseFloat($('#supplier_quantity_'+i+'_'+n+'_'+m).val());
                }
                
                var impCnt = $('#import_table_'+i+'_'+n+'_1 tbody tr').length;
                var impQnt = 0;
                for(var m=1; m<=impCnt; m++){
                    impQnt += parseFloat($('#import_quantity_'+i+'_'+n+'_'+m).val());

                    var impQntCurrent = parseFloat($('#import_quantity_'+i+'_'+n+'_'+m).val());
                    var impCntCurrent = $('#import_country_'+i+'_'+n+'_'+m).val();
                    var impValCurrent = $('#import_value_'+i+'_'+n+'_'+m).val();

                    if(impQntCurrent > 0){
                        if(impCntCurrent == ''){
                            showAlrtByEl('#frmActivityDetails', '#import_country_'+i+'_'+n+'_'+m);
                            importFieldStatus = 'invalid';
                        }
                        if(impValCurrent == ''){
                            showAlrtByEl('#frmActivityDetails', '#import_value_'+i+'_'+n+'_'+m);
                            importFieldStatus = 'invalid';
                        }
                    }
                }
                
                if(secNo == 3){
                    var consQnt = $('#consumeQuantity_'+i+'_'+n).val();
                }
                
                var buyerCnt = $('#buyer_table_'+i+'_'+n+'_1 tbody tr').length;
                var buyerQnt = 0;
                for(var m=1; m<=buyerCnt; m++){
                    buyerQnt += parseFloat($('#buyer_quantity_'+i+'_'+n+'_'+m).val());
                }
                
                var closQnt = $('#closing_stock_'+i+'_'+n).val();

                if(secNo == 3){
                    var comboQnt = (parseFloat(opnQnt) + parseFloat(supQnt.toFixed(3)) + parseFloat(impQnt.toFixed(3))) - (parseFloat(consQnt) + parseFloat(buyerQnt.toFixed(3)));
                } else {
                    var comboQnt = (parseFloat(opnQnt) + parseFloat(supQnt.toFixed(3)) + parseFloat(impQnt.toFixed(3))) - parseFloat(buyerQnt.toFixed(3));
                }

                comboQnt = comboQnt.toFixed(3);
                closQnt = parseFloat(closQnt).toFixed(3);
                if(comboQnt != closQnt){
                    console.log('opnQnt: ' + parseFloat(opnQnt));
                    console.log('supQnt: ' + parseFloat(supQnt.toFixed(3)));
                    console.log('impQnt: ' + parseFloat(impQnt.toFixed(3)));
                    console.log('consQnt: ' + parseFloat(consQnt));
                    console.log('buyerQnt: ' + parseFloat(buyerQnt.toFixed(3)));
                    console.log('comboQnt: ' + comboQnt);
                    console.log('closQnt: ' + closQnt);
                    closingStockStatus = 'invalid';
                    $('#closing_stock_'+i+'_'+n).addClass('is-invalid');
                }

            }

        }
        
        if(closingStockStatus == 'invalid'){
            closStkMsg = (secNo == 3) ? "Closing stock value not equal to <br><b>(opening stock + purchased + imported) - (consumed + sold)</b>" : "Closing stock value not equal to <br><b>(opening stock + purchased + imported) - dispatches</b>";
            // alert(closStkMsg);
            showAlrt(closStkMsg);
            returnFormStatus = false;
        }
        
        if(importFieldStatus == 'invalid'){
            showAlrt('Fields are required, <b>Import quantity</b> is greater than <b>0</b>');
            returnFormStatus = false;
        }

        if(formStatus == 'invalid') { returnFormStatus = false; }
        if(emptyStatus == 'invalid'){ returnFormStatus = false; }

        return returnFormStatus;
    });

});

function showInputAlrt(eqId){

	$('#d_avg_table thead .d_dvg_work_place_total th').eq(eqId).find('input').addClass('is-invalid');

}

/* common empty field validations */
function formEmptyStatus(formId){
    
    var formStatus = 'valid';
    $('#'+formId).find('input').not(':hidden,:button').not('input[disabled]').removeClass('is-invalid');
    var inRw = $('#'+formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').length;
    for(var i=0;i<inRw;i++){
        var inField = $('#'+formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').eq(i).val();
        if(inField == ''){
            showFieldAlrt(formId, i);
            formStatus = 'invalid';
        }
    }

    if(formStatus == 'invalid'){
        showAlrt('Invalid data !');
    }

    return formStatus;

}

/* validation related alert messages */
function showAlrt(msg){

	remAlrt();
	var alrtCon = '<div class="toast alrt-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">';
	alrtCon += '<div class="alrt-body">';
	alrtCon += '<i class="fa fa-exclamation-triangle"></i>';
	alrtCon += '<span> '+msg+'</span>';
	alrtCon += '</div>';
	alrtCon += '</div>';
	$('.alrt-div').append(alrtCon);
    $('.toast').toast('show');

}

function remAlrt(){
	$('.alrt-div .hide').remove();
}

function showFieldAlrt(formId, eqId){

    $('#'+formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').eq(eqId).addClass('is-invalid');

}

function showInputFieldAlrt(formId, inEl, nrId, eqId){

    $('#'+formId+' table tr:nth-child('+nrId+') td').eq(eqId).find(inEl).addClass('is-invalid');

}

function showElAlrt(formId, elNm, eqId){

    $('#'+formId).find(elNm).not(':hidden,:button').not('input[disabled]').eq(eqId).addClass('is-invalid');

}

function showAlrtByEl(formEl, inputEl){
    $(formEl).find(inputEl).addClass('is-invalid');
    $(formEl).find(inputEl).parent().next('.err_cv').text('Field is required');
}
