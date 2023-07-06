/**
 * F-SERIES FORM VALIDATIONS
 * @version 30th JUN 2021
 * @author Aniket Ganvir
 */

// $(document).ready(function(){
//     custom_validations.init();
// });

/* mine details */
$(document).ready(function(){

    $('#frmMineDetails').on('submit', function(){
        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmMineDetails');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
        var fieldStatus = formFieldStatus('#frmMineDetails');
        returnFormStatus = (fieldStatus == 'invalid') ? false : returnFormStatus;
        return returnFormStatus;
    });

});

/* name and address */
$(document).ready(function(){

    $('#frmNameAddress').on('submit', function(){
        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmNameAddress');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
        return returnFormStatus;
    });

});

/* details of rent/royalty */
$(document).ready(function(){

    $('#frmRentDetails').on('submit', function(){
        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmRentDetails');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus; 
        return returnFormStatus;
    });

});

/* working details */
$(document).ready(function(){

    // $('#frmWorkingDetails').on('submit', function(){

    //     var returnFormStatus = true;
    //     var returnEmptyStatus = formEmptyStatus('frmWorkingDetails');
    //     returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
        
    //     var returnSelEmptyStatus = formSelEmptyStatus('frmWorkingDetails');
    //     returnFormStatus = (returnSelEmptyStatus == 'invalid') ? false : returnFormStatus;
        
	// 	var monthD = $('#month_days').val();
	// 	var mineWorkedD = $('#f_total_no_days').val();
	// 	var reasonRw = $('.working_det_table tbody tr').length;
	// 	var reasonD = 0;
	// 	for(var i=1; i<=reasonRw; i++){
	// 		reasonD += parseInt($('#frmWorkingDetails tbody tr:nth-child('+i+') td').eq(1).find('input').val());
	// 	}
	// 	var inputD = parseInt(mineWorkedD) + parseInt(reasonD);
	// 	if(monthD != inputD){
    //         $('#f_total_no_days').addClass('is-invalid');
    //         // $('#f_total_no_days').parent().parent().find('.err_cv:first').text('Invalid days');
            
    //         var reasonRw = $('.working_det_table tbody tr').length;
    //         var reasonD = 0;
    //         for(var i=1; i<=reasonRw; i++){
    //             $('#frmWorkingDetails tbody tr:nth-child('+i+') td').eq(1).find('input').addClass('is-invalid');
    //         }

	// 		showAlrt('Total no. of days in month not matching with total no. of entered days');
	// 		return false;
	// 	}
        
    //     return returnFormStatus;

    // });

});

/* average daily employment */
$(document).ready(function(){

    $('#frmDailyAverage').on('focusout', '.cvOn', function(){

        // var inFieldVal = $(this).val();
        // $(this).val(parseFloat(inFieldVal).toFixed(1));

        // var inFieldValArr = inFieldVal.split('.');
        // var nonDecimalVal = inFieldValArr[0];
        // if(nonDecimalVal.length > 4){
        //     $(this).addClass('is-invalid');
		// 	showAlrt('Please enter a value less than or equal to <b>9999.9</b>');
        // }

    });

	$('#frmDailyAverage').on('submit', function(){
		
		$('#frmDailyAverage table input').removeClass('is-invalid');
        $('#frmDailyAverage #d_avg_table thead .d_dvg_work_place_total th').find('input').removeClass('is-invalid');
        
        var emptyStatus = formEmptyStatus('frmDailyAverage');

		var returnFormStatus = true;
		var wpRw = $('#frmDailyAverage #d_avg_table tbody .d_avg_work_place').length;

		var d_male = 0;
		var d_female = 0;
		var c_male = 0;
		var c_female = 0;
		var s_direct = 0;
		var s_contract = 0;
		for(var i=1;i<=wpRw;i++){

			d_male = parseFloat(d_male) + parseFloat($('#d_avg_table tbody .d_avg_work_place:nth-child('+i+') td').eq(1).find('input').val());
			d_female = parseFloat(d_female) + parseFloat($('#d_avg_table tbody .d_avg_work_place:nth-child('+i+') td').eq(2).find('input').val());
			c_male = parseFloat(c_male) + parseFloat($('#d_avg_table tbody .d_avg_work_place:nth-child('+i+') td').eq(3).find('input').val());
			c_female = parseFloat(c_female) + parseFloat($('#d_avg_table tbody .d_avg_work_place:nth-child('+i+') td').eq(4).find('input').val());
			s_direct = parseFloat(s_direct) + parseFloat($('#d_avg_table tbody .d_avg_work_place:nth-child('+i+') td').eq(5).find('input').val());
			s_contract = parseFloat(s_contract) + parseFloat($('#d_avg_table tbody .d_avg_work_place:nth-child('+i+') td').eq(6).find('input').val());

		}
		d_male = d_male.toFixed(1);
		d_female = d_female.toFixed(1);
		c_male = c_male.toFixed(1);
		c_female = c_female.toFixed(1);
		s_direct = s_direct.toFixed(1);
		s_contract = s_contract.toFixed(1);

		var d_male_tot = $('#d_avg_table thead .d_dvg_work_place_total th').eq(1).find('input').val();
		var d_female_tot = $('#d_avg_table thead .d_dvg_work_place_total th').eq(2).find('input').val();
		var c_male_tot = $('#d_avg_table thead .d_dvg_work_place_total th').eq(3).find('input').val();
		var c_female_tot = $('#d_avg_table thead .d_dvg_work_place_total th').eq(4).find('input').val();
		var s_direct_tot = $('#d_avg_table thead .d_dvg_work_place_total th').eq(5).find('input').val();
		var s_contract_tot = $('#d_avg_table thead .d_dvg_work_place_total th').eq(6).find('input').val();
		d_male_tot = parseFloat(d_male_tot).toFixed(1);
		d_female_tot = parseFloat(d_female_tot).toFixed(1);
		c_male_tot = parseFloat(c_male_tot).toFixed(1);
		c_female_tot = parseFloat(c_female_tot).toFixed(1);
		s_direct_tot = parseFloat(s_direct_tot).toFixed(1);
		s_contract_tot = parseFloat(s_contract_tot).toFixed(1);

        var returnTotalStatus = true;
		if(d_male_tot != d_male){
			showInputAlrt(1);
			returnTotalStatus = false;
		}
		if(d_female_tot != d_female){
			showInputAlrt(2);
			returnTotalStatus = false;
		}
		if(c_male_tot != c_male){
			showInputAlrt(3);
			returnTotalStatus = false;
		}
		if(c_female_tot != c_female){
			showInputAlrt(4);
			returnTotalStatus = false;
		}
		if(s_direct_tot != s_direct){
			showInputAlrt(5);
			returnTotalStatus = false;
		}
		if(s_contract_tot != s_contract){
			showInputAlrt(6);
			returnTotalStatus = false;
		}

		if(returnTotalStatus == false){
			showAlrt('<b>Total</b> are not matching !');
            returnFormStatus = false;
		}
        
        if(emptyStatus == 'invalid'){ returnFormStatus = false; }

		return returnFormStatus;

	});
});

function showInputAlrt(eqId){

	$('#d_avg_table thead .d_dvg_work_place_total th').eq(eqId).find('input').addClass('is-invalid');

}

/* type of ore */
$(document).ready(function(){
    
    $('#frmMineDetails').ready(function(){

        var isHematite = $('#ore_is_hematite').val();
        var isMagnetite = $('#ore_is_magnetite').val();
        if (isHematite == '') {
            $('#F_HEMATITE').prop('checked', false);
        }
        if (isMagnetite == '') {
            $('#F_MAGNETITE').prop('checked', false);
        }

    });

    $('#frmMineDetails').on('submit', function(){

        $('#frmMineDetails table tbody tr input').removeClass('is-invalid');
        var returnFormStatus = true;

        if($("#frmMineDetails #F_HEMATITE").prop('checked') == false && $("#frmMineDetails #F_MAGNETITE").prop('checked') == false){
            showInputFieldAlrt('frmMineDetails', '#F_HEMATITE', '1', '1');
            showInputFieldAlrt('frmMineDetails', '#F_MAGNETITE', '1', '2');
            showAlrt('Please Select Type of ore Produced');
            returnFormStatus = false;
        }

        return returnFormStatus;
        
    });

});

function oreFrmValidate() {
    if (document.getElementById('F_HEMATITE').checked || document.getElementById('F_MAGNETITE').checked)
        return true;
    else {
        alert("Please Select Type of ore Produced.");
        return false;
    }
}

/* rom production */
$(document).ready(function(){

    $('#frmRomStocks').on('submit', function(){
        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmRomStocks');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus; 
        return returnFormStatus;
    });

});

/* grade-wise production */
$(document).ready(function(){

    $('#frmGradeWiseProduction').on('submit', function(){

        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmGradeWiseProduction');

		var gradeRw = $('#table-gradewise-prod tbody .tbody-tr').length;
		var validStatus = true;
		var romGrade = $('#rom_grade').val();
		
		if(romGrade == 0){
			for(var i=1; i<=gradeRw; i++){
				var opnStock = $('#tbody-tr-'+i+' td').find('.openingStock').val();
				var prod = $('#tbody-tr-'+i+' td').find('.productionForTot').val();
				var desp = $('#tbody-tr-'+i+' td').find('.dispatches').val();
				var clStock = round3Fixed($('#tbody-tr-'+i+' td').find('.closingStock').val());

				var totOpnStock = ((parseFloat(opnStock) + parseFloat(prod)) - parseFloat(desp)).toFixed(3);
				if(totOpnStock != clStock){
					showInputAlrt(i);
					validStatus = false;
				}
			}
		}
		
		// if(form_no != 1 && form_no != 4){
		if(romGrade == 0){
			if(validStatus == false){
				showAlrt('Closing stock must be same as <br><b>(Opening Stock + Production) - Despatches</b> !');
			}		
		}

		//validate ex-mine price if respective production is greater than 0
		if(romGrade == 0){
			var inRw = $('#frmGradeWiseProduction .pmvForProdCheck').length;
			for(var n=1; n<= inRw; n++){

				var exmine = parseFloat($('#pmv-'+n).val());
				var prod = parseFloat($('#production-'+n).val());
				if(exmine == 0.00 && prod > 0){
					$('#pmv-'+n).addClass('is-invalid');
					showAlrt('Field is required as Production is greater than 0');
					validStatus = false;
				}

			}
		}

        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
        returnFormStatus = (validStatus == false) ? false : returnFormStatus;
        
        return returnFormStatus;

    });

});

/* pulverisation */
$(document).ready(function(){

    $('#frmPulverisation').ready(function(){
        
		// custom_validations.pulverisationValidation();
		custom_validations.meshValidation();
		// custom_validations.pulverisationValidation();
		custom_validations.pulverisationPostValidation();

    });
	
	$('#frmPulverisation').on('focusout', '.tot_qty', function(){
		
		var tot_qty = parseFloat($(this).val()).toFixed(3);
		$(this).removeClass('is-invalid');
		
		var p_quant  = parseFloat($(this).closest('tr').find('.p_quant').val()).toFixed(3);
		
		if(p_quant != 'NaN'){			
			if(parseFloat(p_quant) > parseFloat(tot_qty)){				
				showAlrt("More quantity of pulvarised mineral produce than the total quantity of mineral pulvarised");
				//$(this).val('').addClass('is-invalid');
				//$(this).closest('tr').find('.p_quant').val('').addClass('is-invalid');
			}
		}
		
	});
	
	$('#frmPulverisation').on('focusout', '.p_quant', function(){
		
		var p_quant = parseFloat($(this).val()).toFixed(3);
		$(this).removeClass('is-invalid');
		
		var tot_qty  = parseFloat($(this).closest('tr').find('.tot_qty').val()).toFixed(3);
		
		if(tot_qty != 'NaN'){	
			if(parseFloat(p_quant) > parseFloat(tot_qty)){
				
				showAlrt("More quantity of pulvarised mineral produce than the total quantity of mineral pulvarised");
				//$(this).val('').addClass('is-invalid');
				//$(this).closest('tr').find('.tot_qty').val('').addClass('is-invalid');
			}
		}
		
	});
	
	
	$('#frmPulverisation').on('focusout', '.s_quant', function(){
		
		
		
	});
    
	$('#frmPulverisation').on('click', '.pulver_radio', function(){
		var pulverRadioVal = $(this).val();
		if(pulverRadioVal == '1'){
			$('#pulver_table').show();
		} else {
			$('#pulver_table').hide();
		}
	});

    $('#frmPulverisation').on('submit', function(){

        var returnFormStatus = true;
        var formStatus = 'valid';
		var error = false;
		
        var is_pulv = $("#frmPulverisation input[name='is_pulverised']:checked").val();
        if(is_pulv == 1){

            var emptyStatus = formEmptyStatus('frmPulverisation');
            if(emptyStatus == 'invalid'){ returnFormStatus = false; }
            
            var inRw = $("#frmPulverisation #table_1 .table_body tr").length;

            for(var i=1;i<=inRw;i++){

                var grade = $('#frmPulverisation #table_1 .table_body tr:nth-child('+i+') td').eq(0).find('select').val();
				
				var tot_qty = parseFloat($("#ta-f_mineral_tot_qty-"+i).val()).toFixed(3);
				var p_quant = parseFloat($("#ta-f_produced_quantity-"+i).val()).toFixed(3);
			
				if(parseFloat(p_quant) > parseFloat(tot_qty)){
					//$("#ta-f_mineral_tot_qty-"+i).val('').addClass('is-invalid');
					//$("#ta-f_produced_quantity-"+i).val('').addClass('is-invalid');
					error = true;
				}
			
                if(grade == ''){
                    showInputFieldAlrt('frmPulverisation', 'select', i, 0);
                    formStatus = 'invalid';
                }
                
                if(formStatus == 'invalid') { returnFormStatus = false; }
                
            }

        }
		if(error == true){
			alert("More quantity of pulvarised mineral produce than the total quantity of mineral pulvarised");
			//returnFormStatus = false;
		}
        
        if(returnFormStatus == false){
            showAlrt('Invalid data !');
        }

        return returnFormStatus;
    });

});

/* details of deductions */
$(document).ready(function(){

    $('#frmDeductionsDetails').on('submit', function(){

        $('#frmDeductionsDetails table tbody tr input').removeClass('is-invalid');
        $('#frmDeductionsDetails table tbody tr textarea').removeClass('is-invalid');
        var returnFormStatus = true;
        var formStatus = 'valid';

        var formStatus = formEmptyStatus('frmDeductionsDetails');
        if(formStatus == 'invalid'){ returnFormStatus = false; }
        
        var trans_remark = $('#frmDeductionsDetails #trans_remark').val();
        var trans_cost = $('#frmDeductionsDetails #trans_cost').val();
        if(trans_remark == '' && trans_cost > 0) { showInputFieldAlrt('frmDeductionsDetails', 'textarea', '1', '2'); returnFormStatus = false; }
        
        var railway_remark = $('#frmDeductionsDetails #railway_remark').val();
        var railway_freight = $('#frmDeductionsDetails #railway_freight').val();
        if(railway_remark == '' && railway_freight > 0) { showInputFieldAlrt('frmDeductionsDetails', 'textarea', '3', '2'); returnFormStatus = false; }
        
        var port_remark = $('#frmDeductionsDetails #port_remark').val();
        var port_handling = $('#frmDeductionsDetails #port_handling').val();
        if(port_remark == '' && port_handling > 0) { showInputFieldAlrt('frmDeductionsDetails', 'textarea', '4', '2'); returnFormStatus = false; }
        
        var other_remark = $('#frmDeductionsDetails #other_remark').val();
        var other_cost = $('#frmDeductionsDetails #other_cost').val();
        if(other_remark == '' && other_cost > 0) { showInputFieldAlrt('frmDeductionsDetails', 'textarea', '7', '2'); returnFormStatus = false; }

		var tranCost = jQuery.trim($("#trans_cost").val());
		var loadingCost = jQuery.trim($("#loading_charges").val());
		var railFright = jQuery.trim($("#railway_freight").val());
		var portHandling = jQuery.trim($("#port_handling").val());
		var samplingCharge = jQuery.trim($("#sampling_cost").val());
		var plotRent = jQuery.trim($("#plot_rent").val());
		var otherRent = jQuery.trim($("#other_cost").val());
		var enteredTotal = parseFloat(jQuery.trim($("#total_prod").val()));
		var prodTotal = parseFloat(tranCost) + parseFloat(loadingCost) + parseFloat(railFright) + parseFloat(portHandling) + parseFloat(samplingCharge) + parseFloat(plotRent) + parseFloat(otherRent);
		prodTotal = Math.round(prodTotal * 100) / 100;
		if (enteredTotal != prodTotal) {
            showInputFieldAlrt('frmDeductionsDetails', 'input', '8', '1');
            showAlrt('Entered value is not equal to the calculated total.');
            returnFormStatus = false;
		}
        
        if(returnFormStatus == false){
            showAlrt('Invalid data !');
        }

        return returnFormStatus;
        
    });

});

/* sales despatches */
$(document).ready(function(){

    $('#frmSalesDespatches').on('submit', function(){

        $('textarea').removeClass('is-invalid');
        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmSalesDespatches');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
        
        var returnSelEmptyStatus = formSelEmptyStatus('frmSalesDespatches');
        returnFormStatus = (returnSelEmptyStatus == 'invalid') ? false : returnFormStatus;

		var checkRequired = $("#reason_1").val();
		if (checkRequired == '') {
            returnFormStatus = false;
            $("#reason_1").addClass('is-invalid');
			showAlrt('Reason for increase/decrease in Production (Required)');
		}
		var checkRequired2 = $("#reason_2").val();
		if (checkRequired2 == '') {
            returnFormStatus = false;
            $("#reason_2").addClass('is-invalid');
			showAlrt('Reason for increase/decrease in Ex-mine price (Required)');
		}
        
        return returnFormStatus;

    });

});

/* rom production ore */
$(document).ready(function(){
    
    $(document).on('change','#frmRomStocksOre .metal-box', function(){

        var metalBox = $(this).val();
        if(metalBox == 'NIL'){
            var nilStatus = confirm("Selecting NIL in the Metal Content/Grade will automatically put 0 in corresponding Quantity and Grade.\nAre you sure want to continue?");
            if(nilStatus == true){
                var elId = $(this).attr('id');
                var elArr = elId.split('_');
                var elRw = elArr[3];
                var gradeNm = elArr[0]+'_'+elArr[1]+'_grade_'+elRw;
                var quantityFieldId = "f_" + elArr[0] + "_" + elArr[1] + "_qty";

                $('#frmRomStocksOre #'+gradeNm).val('0.00');
                $('#frmRomStocksOre #'+quantityFieldId).val('0.00');
            } else {
                $(this).val('');
            }
        }

    });

    $(document).on('submit','#frmRomStocksOre',function(){

        $('#frmRomStocksOre').find('select').not(':hidden').not('select[disabled]').removeClass('is-invalid');
        $('#frmRomStocksOre').find('input').not(':hidden').not('select[disabled]').removeClass('is-invalid');
        var returnFormStatus = true;
        var formStatus = 'valid';
        var formSelStatus = 'valid';

        var emptyStatus = formEmptyStatus('frmRomStocksOre');

        var selRw = $('#frmRomStocksOre').find('select').not(':hidden').not('select[disabled]').length;
        for(var i=0;i<selRw;i++){
            var selField = $('#frmRomStocksOre').find('select').not(':hidden').not('select[disabled]').eq(i).val();
            if(selField == ''){
                showElAlrt('frmRomStocksOre', 'select', i);
                formSelStatus = 'invalid';
            }
        }

        if(formSelStatus == 'invalid'){
            showAlrt('Select Options in all Select Boxes. <br>If No <b>Metal Content/Grade</b> then Select <b>NIL</b>');
        }
        
        if(formStatus == 'invalid') { returnFormStatus = false; }
        if(emptyStatus == 'invalid'){ returnFormStatus = false; }

        // estProdF5Validation: function ()
        var cum_prod = document.getElementById('cum_prod').value;
        var estimated_prod = document.getElementById('estimated_prod').value;
        var prod_value = document.getElementById('f_prod_tot_qty').value;
        var form_entry_total = parseFloat(prod_value);
        var total_prod = parseFloat(cum_prod) + form_entry_total;
        if (total_prod > estimated_prod){
            alert('Cumulative production of ROM exceeded the approved production for the financial year');
        }

        // qtyTotal: function ()
        // opening stock
        var totalQtyStatus = true;
        var opnDevQty = $('#frmRomStocksOre #f_open_dev_qty').val();
        var opnStopQty = $('#frmRomStocksOre #f_open_stop_qty').val();
        var opnCastQty = $('#frmRomStocksOre #f_open_cast_qty').val();
        var opnTotQty = $('#frmRomStocksOre #f_open_tot_qty').val();
        var opnQtySum = parseFloat(opnDevQty) + parseFloat(opnStopQty) + parseFloat(opnCastQty);
        opnQtySum = (opnQtySum).toFixed(3);
        opnTotQty = parseFloat(opnTotQty).toFixed(3);
        if(opnQtySum != opnTotQty){
            $('#frmRomStocksOre #f_open_tot_qty').addClass('is-invalid').val('');
            totalQtyStatus = false;
        }
        
        // production
        var prodDevQty = $('#frmRomStocksOre #f_prod_dev_qty').val();
        var prodStopQty = $('#frmRomStocksOre #f_prod_stop_qty').val();
        var prodCastQty = $('#frmRomStocksOre #f_prod_cast_qty').val();
        var prodTotQty = $('#frmRomStocksOre #f_prod_tot_qty').val();
        var prodQtySum = parseFloat(prodDevQty) + parseFloat(prodStopQty) + parseFloat(prodCastQty);
        prodQtySum = (prodQtySum).toFixed(3);
        prodTotQty = parseFloat(prodTotQty).toFixed(3);
        if(prodQtySum != prodTotQty){
            $('#frmRomStocksOre #f_prod_tot_qty').addClass('is-invalid').val('');
            totalQtyStatus = false;
        }
        
        // closing stock
        var closDevQty = $('#frmRomStocksOre #f_close_dev_qty').val();
        var closStopQty = $('#frmRomStocksOre #f_close_stop_qty').val();
        var closCastQty = $('#frmRomStocksOre #f_close_cast_qty').val();
        var closTotQty = $('#frmRomStocksOre #f_close_tot_qty').val();
        var closQtySum = parseFloat(closDevQty) + parseFloat(closStopQty) + parseFloat(closCastQty);
        closQtySum = (closQtySum).toFixed(3);
        closTotQty = parseFloat(closTotQty).toFixed(3);
        if(closQtySum != closTotQty){
            $('#frmRomStocksOre #f_close_tot_qty').addClass('is-invalid').val('');
            totalQtyStatus = false;
        }

        if(totalQtyStatus == false){ showAlrt('Please enter the correct total !'); returnFormStatus = false; }

        return returnFormStatus;

    });

});

/* recoveries at concentrator */
$(document).ready(function(){

    $(document).on('change','#frmConReco .metal-box', function(){

        var metalBox = $(this).val();
        if(metalBox == 'NIL'){
            var nilStatus = confirm("Selecting NIL in the Metal Content/Grade will automatically put 0 in corresponding Quantity and Grade.\nAre you sure want to continue?");
            if(nilStatus == true){
                var elId = $(this).attr('id');
                var elArr = elId.split('_');
                var elRw = elArr[3];
                var metalEl = elArr[0]+'_'+elArr[1];
                $('#frmConReco #'+elArr[0]+'_'+elArr[1]+'_grade_'+elRw).val('0.00');
                if(metalEl == 'con_obt'){
                    $('#frmConReco #'+elArr[0]+'_'+elArr[1]+'_quantity_'+elRw).val('0.00');
                    $('#frmConReco #'+elArr[0]+'_'+elArr[1]+'_metal_value_'+elRw).val('0');
                } else if(metalEl == 'close_con'){
                    $('#frmConReco #'+elArr[0]+'_'+elArr[1]+'_quantity_'+elRw).val('0.00');
                }
            } else {
                $(this).val('');
            }
        }

    });

    $(document).on('submit','#frmConReco',function(){

        $('#frmConReco').find('select').not(':hidden').not('select[disabled]').removeClass('is-invalid');
        $('#frmConReco').find('input').not(':hidden').not('select[disabled]').removeClass('is-invalid');
        var returnFormStatus = true;
        var formSelStatus = 'valid';

        var emptyStatus = formEmptyStatus('frmConReco');

        var selRw = $('#frmConReco').find('select').not(':hidden').not('select[disabled]').length;
        for(var i=0;i<selRw;i++){
            var selField = $('#frmConReco').find('select').not(':hidden').not('select[disabled]').eq(i).val();
            if(selField == ''){
                showElAlrt('frmConReco', 'select', i);
                formSelStatus = 'invalid';
            }
        }

        if(formSelStatus == 'invalid'){
            showAlrt('Select Options in all Select Boxes. <br>If No <b>Metal Content/Grade</b> then Select <b>NIL</b>');
            returnFormStatus = false;
        }
        
        if(emptyStatus == 'invalid'){ returnFormStatus = false; }
        
        return returnFormStatus;

    });

});

/* common empty field validations */
function formEmptyStatus(formId){
    
    var formStatus = 'valid';
    // $('#'+formId).find('input').not(':hidden,:button').not('input[disabled]').not('.cvNotReq').removeClass('is-invalid');
    $('#'+formId).find('input').not(':hidden,:button').removeClass('is-invalid');
    var inRw = $('#'+formId).find('input').not(':hidden,:button').not('input[disabled]').not('.cvNotReq').length;
    for(var i=0;i<inRw;i++){
        var inField = $('#'+formId).find('input').not(':hidden,:button').not('input[disabled]').not('.cvNotReq').eq(i).val();
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

/* common select dropdown validations */
function formSelEmptyStatus(formId){
    
    var formSelStatus = 'valid';
    // $('#'+formId).find('select').not(':hidden,:button').not('select[disabled]').not('.cvNotReq').removeClass('is-invalid');
    $('#'+formId).find('select').not(':hidden,:button').removeClass('is-invalid');
    var inRw = $('#'+formId).find('select').not(':hidden,:button').not('select[disabled]').not('.cvNotReq').length;
    for(var i=0;i<inRw;i++){
        var inField = $('#'+formId).find('select').not(':hidden,:button').not('select[disabled]').not('.cvNotReq').eq(i).val();
        if(inField == ''){
            showElAlrt(formId, 'select', i);
            formSelStatus = 'invalid';
        }
    }

    if(formSelStatus == 'invalid'){
        showAlrt('Please select valid option from dropdown!');
    }

    return formSelStatus;

}

/* common form field validations */
function formFieldStatus(formId){
    
    var formStatus = 'valid';

    var fieldRw = $(formId).find('input.cvOn').length;
    for(var i=0; i<fieldRw; i++){

        var inField = $(formId).find('input.cvOn').not(':hidden,:button').not('input[disabled]').eq(i);
        var inFieldVal = $(formId).find('input.cvOn').not(':hidden,:button').not('input[disabled]').eq(i).val();
        var inCl = $(formId).find('input.cvOn').not(':hidden,:button').not('input[disabled]').eq(i).attr('class');
        var inClArr = inCl.split(' ');
        
        if(jQuery.inArray('cvReq', inClArr) !== -1){
            
            if(inFieldVal == ''){
                inField.addClass('is-invalid');
                inField.parent().next('.err_cv').text('Field is required !');
                formStatus = 'invalid';
            }

        }
        
        if(jQuery.inArray('cvNum', inClArr) !== -1){

            if($.isNumeric(inFieldVal)){
                //
            } else {
                inField.addClass('is-invalid');
                inField.parent().next('.err_cv').text('Input should be numeric!');
                formStatus = 'invalid';
            }

        }
        
        if(jQuery.inArray('cvMaxLen', inClArr) !== -1){

            var maxLen = inField.attr('maxlength');

            if(inFieldVal.length > maxLen){
                inField.addClass('is-invalid');
                inField.parent().next('.err_cv').text('Maximum length should be '+maxLen);
                formStatus = 'invalid';
            }

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

    // $('#'+formId).find('input').not(':hidden,:button').not('input[disabled]').not('.cvNotReq').eq(eqId).addClass('is-invalid');
    $('#'+formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').eq(eqId).addClass('is-invalid');

}

function showInputFieldAlrt(formId, inEl, nrId, eqId){

    $('#'+formId+' table tr:nth-child('+nrId+') td').eq(eqId).find(inEl).addClass('is-invalid');

}

function showElAlrt(formId, elNm, eqId){

    $('#'+formId).find(elNm).not(':hidden,:button').not(elNm+'[disabled]').not('.cvNotReq').eq(eqId).addClass('is-invalid');

}

var Utilities = {
    roundOff: function () {
        jQuery.validator.addMethod("roundOff1", function (value, element) {
            var temp = new Number(value);
            element.value = (temp).toFixed(1);
            return true;
        }, "");

        jQuery.validator.addMethod("roundOff2", function (value, element) {
            var temp = new Number(value);
            element.value = (temp).toFixed(2);
            return true;
        }, "");

        jQuery.validator.addMethod("roundOff3", function (value, element) {
            var temp = new Number(value);
            element.value = (temp).toFixed(3);
            return true;
        }, "");
    },
    isFloat: function (value) {
        var msg = "";

        var is_float = /^[0-9.]*$/i.test(value);
        if (is_float == false)
            msg = "Please enter valid integer.";

        return msg;
    },
    roundOff2: function (value) {
        var temp_value = parseFloat(value);
        var round_off_value = temp_value.toFixed(2);

        if (round_off_value == 'NaN')
            round_off_value = '0.00';

        return round_off_value;
    },
    roundOff0: function (value) {
        var temp_value = parseFloat(value);
        var round_off_value = temp_value.toFixed(0);

        if (round_off_value == 'NaN')
            round_off_value = '0';

        return round_off_value;
    },
    roundOff1: function (value) {
        var temp_value = parseFloat(value);
        var round_off_value = temp_value.toFixed(1);

        if (round_off_value == 'NaN')
            round_off_value = '0';

        return round_off_value;
    },
    roundOff22: function (value) {
        var temp_value = parseFloat(value);
        var round_off_value = temp_value.toFixed(2);

        return round_off_value;
    },
    roundOff3: function (value) {
        var temp_value = parseFloat(value);
        var round_off_value = temp_value.toFixed(3);

        return round_off_value;
    },
    maxLength: function (value, len) {
        var msg = "";
        var max_len = value.length;

        if (max_len > len)
            //      msg = "Please enter less than or equal to " + len + " digits";
            msg = "Maximum grade value allowed is 99.99";

        return msg;
    },
    autoCompleteWidget: function () {
        $.widget("custom.catcomplete", $.ui.autocomplete, {
            _renderMenu: function (ul, items) {
                var self = this;
                $.each(items, function (index, item) {
                    self._renderItem(ul, item);
                });
            }
        });
    },
    datePicker: function (element, start_year) {
        if (start_year == null)
            start_year = 2011;

        var d = new Date();
        var cur_year = d.getFullYear();

        $(element).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy",
            nextText: "",
            prevText: "",
            yearRange: start_year + ":" + cur_year

        });
    },
    datePickerWithSlash: function (element, start_year) {
        if (start_year == null)
            start_year = 2011;

        var d = new Date();
        var cur_year = d.getFullYear();

        $(element).datepicker({
            changeMonth: true,
            changeYear: true,
            //      minDate: new Date(2011, 1 - 1, 1),
            dateFormat: "dd/mm/yy",
            nextText: "",
            prevText: "",
            yearRange: start_year + ":" + cur_year
        });
    },
    ajaxBlockUI: function () {
        $(document).ajaxStart($.blockUI({
            message: '<div><div class="autoLoder"></div><div class="autoLoadMsg">Just a moment...</div></div>'
        })).ajaxStop($.unblockUI);
    },
    objCount: function (obj) {
        var objCount = 0;
        for (var c in obj)
            objCount++;

        return objCount;
    },
    datePickerTillCurrentDate: function (element, start_year) {

        var d = new Date();
        var cur_year = d.getFullYear();
        //    var cur_date = d.getDate();
        //    var cur_month = d.getMonth();
        if (start_year == null)
            start_year = 1900;
        $(element).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy",
            nextText: "",
            prevText: "",
            minDate: new Date(start_year, 4 - 1, 01),
            maxDate: '+0d',
            yearRange: start_year + ":" + cur_year
        });
    }
}

