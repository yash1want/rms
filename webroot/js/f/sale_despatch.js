
$(document).ready(function(){
    
    $('#table_container_1').ready(function() {
        $('#table_container_1').addClass('w_100 o_x_auto');
        $('#table_1').addClass('w_120');
    });
	
    $('#frmSalesDespatches #table_container_1').ready(function(){
        
        checkNilEntry();
        checkNatureOfDispatch();

    })

    $('#frmSalesDespatches').on('change', '.client_type', function(){
        var fieldId = $(this).attr('id');
        natureofdispatch(fieldId);
    });
    
    $('#frmSalesDespatches').on('click', '#addmorebtn #add_more', function(){
        
        $('#frmSalesDespatches #table_1').ready(function() {
            checkNatureOfDispatch();
        });

    });

    
    $('#frmSalesDespatches').on('change', '.sale_despatch_grade', function(){

        var curEl = $(this).attr('id');
        var curElArr = curEl.split('-');
        var curElRw = curElArr.length;
        var tblRw = curElArr[curElRw - 1];
        var grade = $(this).val();
     
        if(grade == 'NIL'){

            
            
            if($('#row_container-'+tblRw+' td').eq(1).find("select option[value='NIL']").length == 0){
                $('#row_container-'+tblRw+' td').eq(1).find('select').append($('<option></option>').attr('value','NIL').text('NIL'));
            }

            $('#row_container-'+tblRw+' td').eq(1).find('select').val('NIL').prop('disabled', true);
            $('#row_container-'+tblRw+' td').eq(2).find('.auto-comp').val('0').prop('disabled', true);
            $('#row_container-'+tblRw+' td').eq(3).find('input').val('NIL').prop('disabled', true);
            $('#row_container-'+tblRw+' td').eq(4).find('input').val('0.000').prop('disabled', true);
            $('#row_container-'+tblRw+' td').eq(5).find('input').val('0.00').prop('disabled', true);
            
            if($('#row_container-'+tblRw+' td').eq(6).find("select option[value='NIL']").length == 0){
                $('#row_container-'+tblRw+' td').eq(6).find('select').append($('<option></option>').attr('value','NIL').text('NIL'));
            }

            $('#row_container-'+tblRw+' td').eq(6).find('select').val('NIL').prop('disabled', true);
            $('#row_container-'+tblRw+' td').eq(7).find('input').val('0.000').prop('disabled', true);
            $('#row_container-'+tblRw+' td').eq(8).find('input').val('0.00').prop('disabled', true);

            remSaleDespatchRow();

        } else {
             

            upSaleDespatchRow();
            
            if($('#row_container-'+tblRw+' td').eq(1).find("select option[value='NIL']").length != 0){
                $('#row_container-'+tblRw+' td').eq(1).find("select option[value='NIL']").remove();
                
                if($('#row_container-'+tblRw+' td').eq(6).find("select option[value='NIL']").length != 0){
                    $('#row_container-'+tblRw+' td').eq(6).find("select option[value='NIL']").remove();
                }
                
                $('#row_container-'+tblRw+' td').eq(1).find('select').prop('disabled', false);
                $('#row_container-'+tblRw+' td').eq(2).find('.auto-comp').prop('disabled', false);
                $('#row_container-'+tblRw+' td').eq(3).find('input').prop('disabled', false);
                $('#row_container-'+tblRw+' td').eq(4).find('input').prop('disabled', false);
                $('#row_container-'+tblRw+' td').eq(5).find('input').prop('disabled', false);

                $('#row_container-'+tblRw+' td').eq(6).find('select').val('');
                $('#row_container-'+tblRw+' td').eq(7).find('input').val('');
                $('#row_container-'+tblRw+' td').eq(8).find('input').val('');
                

            }

        }

    });

    $("#reason_1").focusout(function (event) {
        if ($(this).val() != '') {
            var dataToAppend = "<div class='mt-2 position-absolute'> Reason for increase/decrease in Production </div>";
            $(this).parent().next('.err_cv').html(dataToAppend);
            event.preventDefault();
        }
    });
    
    $("#reason_2").focusout(function (event) {
        if ($(this).val() != '') {
            var dataToAppend = "<div class='mt-2 position-absolute'> Reason for increase/decrease in Ex-mine price </div>";
            $(this).parent().next('.err_cv').html(dataToAppend);
            event.preventDefault();
        }
    });


    //For the sales / dispatch Quantity is positive or entered  - the sale value should not be zero validation 
    //Also for the export despatch quantity is ewntered the fob value should not be zero alrt validation 
    //added on 07-01-2022 by Akash 
    $('#frmSalesDespatches').on('focusout', '.s_des_input', function(){

        var curEl = $(this).attr('id');
        var curElArr = curEl.split('-');
        var curElRw = curElArr.length;
        var tblRw = curElArr[curElRw - 1];
    
        var quantityDP = $('#ta-quantity-' +tblRw).val();
        var sale_valueDP = $('#ta-sale_value-'+tblRw).val();
        var clientType = $('#ta-client_type-'+tblRw).val();
        var forExportQunatity = $('#'+tblRw).val(); 
        var fobvalue = $('#'+tblRw).val();
        
        //For Domestic
        if (clientType == 'DOMESTIC SALE' || clientType == 'DOMESTIC TRANSFER') {
			if (sale_valueDP != '') {

				if (quantityDP > 0) {
		
					if (parseFloat(sale_valueDP) == 0) {
		
						showAlrt("Sale Value should not be zero if quantity is entered!");
						$('#ta-sale_value-'+tblRw).val('');
					} 
					else if(parseFloat(quantityDP) > parseFloat(sale_valueDP))
					{
						showAlrt("Sale Value must exceed quantity");
						$('#ta-sale_value-'+tblRw).val('');
					}
				}
			}
        }

        //For Export
        if (fobvalue != '') {

            if (forExportQunatity > 0) {
    
                if (parseFloat(fobvalue) == 0.00) {
    
                    showAlrt("F.O.B.  Value should not be zero");
                }
            }
        }


    });
    
});

function remSaleDespatchRow(){

	$('#frmSalesDespatches #table_1 .table_body tr:not(:first-child)').remove();
	$('#add_more').hide();
	$('#frmSalesDespatches #table_1 .table_body tr:first-child .remove_btn .remove_btn_btn').attr('disabled',true);

}

function upSaleDespatchRow(){

	$('#add_more').show();
}


function natureofdispatch(id){

	var result = id.split('-');
	var count = result[2];
    var nature = document.getElementById(id).value;

    if (nature != '') {
		$('.err_cv').text('');
        if (nature == 'EXPORT') {
            document.getElementById('ta-client_reg_no-' + count).disabled = true;
            document.getElementById('ta-client_name-' + count).disabled = true;
            document.getElementById('ta-quantity-' + count).disabled = true;
            document.getElementById('ta-sale_value-' + count).disabled = true;
            document.getElementById('ta-expo_country-' + count).disabled = false;
            // $('#ta-expo_country-' + count).val($('#ta-expo_country-' + count + ' option:first').val());
            document.getElementById('ta-expo_quantity-' + count).disabled = false;
            document.getElementById('ta-expo_fob-' + count).disabled = false;

            //clear the other entered fields
            document.getElementById('ta-client_reg_no-' + count).value = '';
            document.getElementById('ta-client_name-' + count).value = '';
            document.getElementById('ta-quantity-' + count).value = '';
            document.getElementById('ta-sale_value-' + count).value = '';
            document.getElementById('ta-suggestion_box-' + count).value = '';
        } else {
            document.getElementById('ta-client_reg_no-' + count).disabled = false;
            document.getElementById('ta-client_name-' + count).disabled = false;
            document.getElementById('ta-quantity-' + count).disabled = false;
            document.getElementById('ta-sale_value-' + count).disabled = false;
            document.getElementById('ta-expo_country-' + count).disabled = true;
            document.getElementById('ta-expo_quantity-' + count).disabled = true;
            document.getElementById('ta-expo_fob-' + count).disabled = true;

            //clear the other entered fields
            // document.getElementById('ta-expo_country-' + count).value = '';
            document.getElementById('ta-expo_quantity-' + count).value = '';
            document.getElementById('ta-expo_fob-' + count).value = '';
            document.getElementById('ta-suggestion_box-' + count).value = '';
        }
        
        if(count != 1){
            if($('#row_container-'+count+' td').eq(0).find("select option[value='NIL']").length != 0){
                $('#row_container-'+count+' td').eq(0).find("select option[value='NIL']").remove();
            }
            
            if($('#row_container-'+count+' td').eq(1).find("select option[value='NIL']").length != 0){
                $('#row_container-'+count+' td').eq(1).find("select option[value='NIL']").remove();
            }
            if($('#row_container-'+count+' td').eq(6).find("select option[value='NIL']").length != 0){
                $('#row_container-'+count+' td').eq(6).find("select option[value='NIL']").remove();
            }
        }
        
    }

}

$(document).ready(function(){

    $('#frmSalesDespatches').on('change', '.auto-comp', function(){

        var curEl = $(this).attr('id');
        var curElArr = curEl.split('-');
        var numRw = curElArr[2];
        var consigneeUrl = $('#consignee_url').val();

        setTimeout(function(){
            var reg_no = $('#ta-client_reg_no-'+numRw).val();
            var regArr = reg_no.split('/');
            if(regArr.length == 3 || regArr.length == 2)
            {
                var regNo = regArr[1];
            }else
            {
                var regNo = reg_no;
            }

                $.ajax({
                    type: 'POST',
                    url: consigneeUrl,
                    data: {	'reg_no': regNo,},
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    success: function(resp){
                        $('#ta-client_name-'+numRw).val(resp.trim());
                        $('#ta-client_name-'+numRw).attr('readonly',true);
                    }
                });
            
        }, 500);

    });

    $('#frmSalesDespatches').on('keyup', '.auto-comp', function(){

        var curEl = $(this).attr('id');
        var curElArr = curEl.split('-');
        var numRw = curElArr[2];
        var app_id = $(this).val();
        var appUrl = $('#app_id_url').val();
        $('#ta-client_name-'+numRw).attr('readonly',false);
        if (app_id !="") {
             
            var appidArr = app_id.split('/');
            if(appidArr.length == 3 || appidArr.length == 2)
            {
                app_id = appidArr[1];
            }else
            {
                app_id = app_id;
            }

            if(!isNaN(app_id) && app_id !=""){
                $.ajax({
                    url:appUrl,
                    type:"POST",
                    cache:false,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    data:{'app_id':app_id},
                    success:function(resp){
                        $("#ta-suggestion_box-"+numRw).empty();
                        $("#ta-suggestion_box-"+numRw).html(resp);
                        $("#ta-suggestion_box-"+numRw).fadeIn();
                    }  
                });
            }else{
                $("#ta-suggestion_box-"+numRw).html("");  
                $("#ta-suggestion_box-"+numRw).fadeOut();
            }

        }else{
            $("#ta-suggestion_box-"+numRw).html("");  
            $("#ta-suggestion_box-"+numRw).fadeOut();
        }

        // click one particular city name it's fill in textbox
        // $(document).on("click","li", function(){
        //   $('#ta-client_reg_no-'+numRw).val($(this).text());
        //   $('#ta-suggestion_box-'+numRw).fadeOut("fast");
        // });      988888

        $(document).on("click",".sugg-box ul li", function(){
            var sugBoxId = $(this).closest('.sugg-box').attr('id');
            var curBx = sugBoxId.split('-');
            var boxRw = curBx[2];
            $('#ta-client_reg_no-'+boxRw).val($(this).text());
            $('#ta-suggestion_box-'+boxRw).fadeOut("fast");
        });

    });

    // Hide the autosuggestion div on focusout - Aniket G [26-06-2023]
    $('#frmSalesDespatches').on('keydown keyup', '.auto-comp', function(){
        $('.sugg-box').hide();
    });

    
    // Hide the autosuggestion div on click of another fields - Aniket G [26-06-2023]
    $('body').on('click', function(event) {
        var clickedElement = $(event.target);
        if ((!clickedElement.hasClass('auto-comp') && clickedElement.parents('.auto-comp').length === 0) || (!clickedElement.hasClass('auto-comp') && clickedElement.parents('.auto-comp').length === 0)) {
            $('.sugg-box').hide();
        }
    });

});

function checkNilEntry(){
    
    var gradeCode = $('#frmSalesDespatches #ta-grade_code-1').val();
    
    if(gradeCode == 'NIL'){

        var tblRw = 1;
        
        if($('#row_container-'+tblRw+' td').eq(1).find("select option[value='NIL']").length == 0){
            $('#row_container-'+tblRw+' td').eq(1).find('select').append($('<option></option>').attr('value','NIL').text('NIL'));
        }

        $('#row_container-'+tblRw+' td').eq(1).find('select').val('NIL').prop('disabled', true);
        $('#row_container-'+tblRw+' td').eq(2).find('.auto-comp').val('0').prop('disabled', true);
        $('#row_container-'+tblRw+' td').eq(3).find('input').val('NIL').prop('disabled', true);
        $('#row_container-'+tblRw+' td').eq(4).find('input').val('0.000').prop('disabled', true);
        $('#row_container-'+tblRw+' td').eq(5).find('input').val('0.00').prop('disabled', true);
        
        if($('#row_container-'+tblRw+' td').eq(6).find("select option[value='NIL']").length == 0){
            $('#row_container-'+tblRw+' td').eq(6).find('select').append($('<option></option>').attr('value','NIL').text('NIL'));
        }

        $('#row_container-'+tblRw+' td').eq(6).find('select').val('NIL').prop('disabled', true);
        $('#row_container-'+tblRw+' td').eq(7).find('input').val('0.000').prop('disabled', true);
        $('#row_container-'+tblRw+' td').eq(8).find('input').val('0.00').prop('disabled', true);


        

        remSaleDespatchRow();

    }
    
}

function checkNatureOfDispatch(){
    
    var lenn = $('#table_1 .table_body tr').length;

    var i;
    for(i=1; i <= lenn; i++){
        var gradeCode = $('#ta-grade_code-'+i).val();
        if(gradeCode != 'NIL'){
            var currentRow = 'ta-client_type-' + i;
            natureofdispatch(currentRow);
        }
    }

}

// $(document).ready(function () {
// 	custom_validations.despatchGetUserByName("/monthly/getUserByConsigneeName");
// 	custom_validations.despatchGetUserByRegNo("/monthly/getUserByRegNo");

// 	var returnType = "<?php //echo $returnType; ?>";
// 	if (returnType == "ANNUAL") {
// 		custom_validations.closeIconClick();
// 	}

// 	// var checkFormTypeForF5 = "<?php //echo $formType; ?>";
// 	// var checkF5ForNil = "<?php //echo $checkF5ForNil; ?>";
// 	// if(checkFormTypeForF5 == 'F5'){
// 	// custom_validations.F5AutoFillForZeroProduction(checkF5ForNil);
// 	// }
// });

// custom_validations.init();


custom_validations.salesAndDispatchValidation();

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

$(document).ready(function() {
  
  
  
   $('#frmSalesDespatches').on('keyup', '.numeric-input', function(){
     
     var lenn = $('.table_body tr').length;
    
     var tblRw;
    
    for(tblRw=1; tblRw <= lenn; tblRw++){
  
            var trans_cost = parseFloat($('#ta-trans_cost-' + tblRw).val()) || 0;  
            var loading_charges = parseFloat($('#ta-loading_charges-' + tblRw).val()) || 0; 
            var railway_freight = parseFloat($('#ta-railway_freight-' + tblRw).val()) || 0; 
            var port_handling = parseFloat($('#ta-port_handling-' + tblRw).val()) || 0;  
            var sampling_cost = parseFloat($('#ta-sampling_cost-' + tblRw).val()) || 0; 
            var plot_rent = parseFloat($('#ta-plot_rent-' + tblRw).val()) || 0; 
            var other_cost = parseFloat($('#ta-other_cost-' + tblRw).val()) || 0;  
            
            var total = trans_cost + loading_charges + railway_freight + port_handling + sampling_cost + plot_rent + other_cost; 
             
            $('#ta-total_prod-' + tblRw).val(total); 

    } 
  });
});