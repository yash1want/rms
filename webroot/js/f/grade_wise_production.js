
$(document).ready(function(){

    $('.dispatches_rom').on('focusout', function() {

        var elId = $(this).attr('id');
        var elIdArr = elId.split('-');
        var id = elIdArr[1];
        checkDispatchExmine(id, 'despatch');

    });
    
    $('.exmine_rom').on('focusout', function() {

        var elId = $(this).attr('id');
        var elIdArr = elId.split('-');
        var id = elIdArr[1];
        checkDispatchExmine(id, 'exmine');

    });

    $('#frmGradeWiseProduction').on('submit', function() {
        checkDispatchExmineAll();
    });

	$('#frmGradeWiseProduction').on('focusout', 'input:not(.cvNotReq, .pmvForProdCheck)', function(){

		var inFieldVal = $(this).val();
		if(inFieldVal != ''){
			$(this).val(round3Fixed(inFieldVal));
		} 

	});
	
	$('#frmGradeWiseProduction').on('focusout', 'input:not(.cvNotReq).pmvForProdCheck', function(){

		var inFieldVal = $(this).val();
		if(inFieldVal != ''){
			$(this).val(parseFloat(inFieldVal).toFixed(2));
		} 

	});

	
	$('#frmGradeWiseProduction').on('focusout', 'input.pmvForProdCheck', function(){

		var inFieldVal = $(this).val();
		var inId = $(this).attr('id');
		var inIdArr = inId.split('-');
		var rowId = inIdArr[1];

		if(inFieldVal == '0.00'){
			var prodVal = $('#frmGradeWiseProduction #production-'+rowId).val();
			if(prodVal > 0){
				$(this).addClass('is-invalid');
				$(this).parent().next('.err_cv').text('Field is required as Production is greater than 0');
			} else {
				$(this).removeClass('is-invalid');
            }
		} 

	});
    
    $("#frmGradeWiseProduction").submit(function () {
        var pmv_1 = $("#pmv-1").val();
        var pmv_2 = $("#pmv-2").val();
        var pmv_3 = $("#pmv-3").val();

        var pmv_error = 0;
        if (pmv_2 < pmv_1) {
            pmv_error++;
        }
        else if (pmv_3 < pmv_1 && pmv_3 < pmv_2) {
            pmv_error++;
        }

        if (pmv_error > 0) {
            alert("Lesser price reported for higher grade");
        }
    });


    //THE BELOW VALIDATIONS IS APPLIED FOR THE SHOW ALERT IF THE CLOSING STOCK VALUE IS MISMATCHED
    //BY THE FORMULAE THAT IS : CLOSING STOCK = OPENING STOCK + PRODUCTION - DESPATCHES
    //BY AKASH ON 28-01-2022
    $('.closingStock ').on('focusout', function(){ 

        var inId = $(this).attr('id');
        var inIdArr = inId.split('-');
        var rowId = inIdArr[1];

        var openingStockVal = parseFloat($("#opening_stock-" + rowId).val());
        var productionStockVal = parseFloat($("#production-" + rowId).val());
        var despatchesVal = parseFloat($("#despatches-" + rowId).val());
        var closingStockVal = parseFloat($("#closing_stock-" + rowId).val());
        
        var total = round3Fixed(((openingStockVal + productionStockVal) - despatchesVal));
        
        if (!isNaN(total) && !isNaN(closingStockVal)) {
               
            if (closingStockVal != total) {

                $('#closing_stock-' + rowId).parent().next('.err_cv').text('Closing Stock total calculation is not matched!');
                $('#closing_stock-' + rowId).addClass("is-invalid");
                $("#closing_stock-" + rowId).click(function(){$("#closing_stock-" + rowId).parent().next('.err_cv').hide().text;$("#closing_stock-" + rowId).removeClass("is-invalid");});
                showAlrt('Closing Stock total calculation is not matched!');
            } else {
                $('#closing_stock-' + rowId).removeClass("is-invalid");
            }
        }

    });

    //THIS BELOW VALIDATIONS ARE APPLIED FOR THE EX-MINE SALE VALUE SHOULD NOT BE ZERO IF THE PRODUCTION OR DESPATCH VALUES ARE ENTERED
    //BY AKASH ON 28-01-2022
    $('.pmvForProdCheck').on('focusout', function(){ 

        var inId = $(this).attr('id');
        var inIdArr = inId.split('-');
        var rowId = inIdArr[1];
      
        var productionStockVal = parseFloat($("#production-" + rowId).val());
        var despatchesVal = parseFloat($("#despatches-" + rowId).val());
        var exminepriceval = parseFloat($("#pmv-" + rowId).val());
        
        if (productionStockVal || despatchesVal > 0) {

            if (exminepriceval <= 0) {

                $('#pmv-' + rowId).parent().next('.err_cv').text('Ex-Mine Price should be greater than 0');
                $('#pmv-' + rowId).addClass("is-invalid");
                $("#pmv-" + rowId).click(function(){$("#pmv-" + rowId).parent().next('.err_cv').hide().text;$("#pmv-" + rowId).removeClass("is-invalid");});
                showAlrt('Ex-Mine Price should be greater than 0');
            }  
        }
    
    });


    //THE BELOW VALIDATIONS IS APPLIED FOR THE SHOW ALERT IF THE CLOSING STOCK VALUE IS MISMATCHED
    //BY THE PREVIOUS CLOSING STOCK VALUE
    //BY AKASH ON 28-01-2022
    $('.openingStock ').on('click', function(){ 
        
        var inId = $(this).attr('id');
        var inIdArr = inId.split('-');
        var rowId = inIdArr[1];
        var openingStock = parseFloat($("#opening_stock-" + rowId).val());

        if (!isNaN(openingStock)) {

            $('#opening_stock-' + rowId).on('focusout', function(){
    
                var newopeningStock = parseFloat($("#opening_stock-" + rowId).val());
                if (openingStock != newopeningStock) {
    
                    $('#opening_stock-' + rowId).parent().next('.err_cv').text('Opening Stock is not matched with previous closing month stock');
                    $('#opening_stock-' + rowId).addClass("is-invalid");
                    $("#opening_stock-" + rowId).click(function(){$("#opening_stock-" + rowId).parent().next('.err_cv').hide().text;$("#opening_stock-" + rowId).removeClass("is-invalid");});
                    return false;
                } else {
                    $('#opening_stock-' + rowId).removeClass("is-invalid");
                }
            });
        }
    });

});

function checkDispatchExmine(id, input) {
    
    var despatch = $('#despatches_rom-'+id).val();
    var exmine = $('#pmv_rom-'+id).val();

    if (despatch.length > 0 && exmine.length > 0) {
        despatch = parseInt(despatch);
        exmine = parseInt(exmine);

        if (input == 'despatch') {
            if (despatch > 0 && exmine < 1) {
                showAlrt('Kindly check Dispatches as Ex-mine price is "0"!');
            }
            if (despatch < 1 && exmine > 0) {
                showAlrt('Kindly check Dispatches as Ex-mine price is positive!');
            }
        }

        if (input == 'exmine') {
            if (despatch > 0 && exmine < 1) {
                showAlrt('Kindly check Ex-mine price as Dispatches is positive!');
            }
            if (despatch < 1 && exmine > 0) {
                showAlrt('Kindly check Ex-mine price as Dispatches is "0"!');
            }
        }

    }

}

function checkDispatchExmineAll() {

    var warning = false;
    var despatchMoreThanExmine = false;
    var despatchLessThanExmine = false;
    $('.dispatches_rom').each(function() {

        var rwId = $(this).attr('id');
        var rwIdArr = rwId.split('-');
        var id = rwIdArr[1];
        var despatch = parseInt($(this).val());
        var exmine = parseInt($('#pmv_rom-'+id).val());
        
        if (despatch > 0 && exmine < 1) {
            warning = true;
            despatchMoreThanExmine = true;
        }
        if (despatch < 1 && exmine > 0) {
            warning = true;
            despatchLessThanExmine = true;
        }

    });

    if (warning == true) {
        if (despatchMoreThanExmine == true) {
            alert('Kindly check, Dispatches is positive and Ex-mine price is "0"');
        }
        if (despatchLessThanExmine == true) {
            alert('Kindly check, Dispatches is "0" and Ex-mine price is positive');
        }
    }

}

function round3Fixed(value) {
	value = +value;

	if (isNaN(value))
	return NaN;

	value = value.toString().split('e');
	value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + 3) : 3)));

	value = value.toString().split('e');
	return (+(value[0] + 'e' + (value[1] ? (+value[1] - 3) : -3))).toFixed(3);
}


jQuery(document).ready(function () {

    
    $("#frmGradeWiseProduction").validate({
        onsubmit: true,
        onkeyup: false
    });

    
   
    $("#submit").click(function (event) {

        // FOR CHECKING THE VALIDATION OPENING STOCK + PRODUCTION - DISPATCHES = CLOSING STOCK -- ADDED BY UD
        var productionElementList = $(".productionForTot");
        var elementCount = productionElementList.length
        var prevClosingStock = $('#preClosingStocks').val();

        var total = 0;
        var errorCount = 0;
        var errorCount2 = 0;
        var prodID = [];
        var exMinePrice = [];

        for (var i = 0; i < elementCount; i++) {

            var elementId = productionElementList[i].id;
            var splitedElementId = elementId.split("-");
            var elementIdSecondChar = splitedElementId[1];
            var openingStockVal = parseFloat($("#opening_stock-" + elementIdSecondChar).val());
            var productionStockVal = parseFloat($("#production-" + elementIdSecondChar).val());
            var despatchesVal = parseFloat($("#despatches-" + elementIdSecondChar).val());
            var closingStockVal = parseFloat($("#closing_stock-" + elementIdSecondChar).val());
            var exminepriceval = parseFloat($("#pmv-" + elementIdSecondChar).val());
            // var total = parseFloat(parseFloat(openingStockVal) + parseFloat(productionStockVal)) - parseFloat(despatchesVal);
            var total = round3Fixed(((openingStockVal + productionStockVal) - despatchesVal));
        
            if (productionStockVal || despatchesVal > 0) {

                if(exminepriceval == 0){

                    errorCount++;
                    exMinePrice.push(elementIdSecondChar);
                }
                    
            }
             
            if (!isNaN(total) && !isNaN(closingStockVal)) {
               
                if (closingStockVal != total) {
                    errorCount++;
                    prodID.push(elementIdSecondChar);
                }

            } else if (isNaN(openingStockVal) || isNaN(productionStockVal) || isNaN(despatchesVal) || isNaN(closingStockVal)) {
                errorCount2 = 1;
            }
        }
        
        //TAKING THE ERROR COUNT AND ADDING ERROR TEXT AND IF ERROR IS ZERO PROCEDD TO THE SUBMIT
        if (errorCount > 0) {

            if (exMinePrice.length > 0) {

                $.each( exMinePrice, function( i, val ) {

                    $('#pmv-' + val).parent().next('.err_cv').text('Ex-Mine Price should not be zero!!');
                    $('#pmv-' + val).addClass("is-invalid");
                    $("#pmv-" + val).click(function(){$("#pmv-" + val).parent().next('.err_cv').hide().text;$("#pmv-" + val).removeClass("is-invalid");});
                });
            
                showAlrt("Ex-Mine Price should not be zero!!");
                event.preventDefault();
            }


            if (prodID.length > 0) {

                $.each( prodID, function( i, val ) {

                    $('#closing_stock-' + val).parent().next('.err_cv').text('Closing Stock total calculation is not matched!');
                    $('#closing_stock-' + val).addClass("is-invalid");
                    $("#closing_stock-" + val).click(function(){$("#closing_stock-" + val).parent().next('.err_cv').hide().text;$("#closing_stock-" + val).removeClass("is-invalid");});
                });
            
                showAlrt("Some of the Closing Stock are not correct! Please Verify");
                event.preventDefault();
            }  

        } else if (errorCount2 == 1) {

            var checkForFormNo = $('#form_no').val();
            if (checkForFormNo == 1 || checkForFormNo == 4) {
                alert("If Production is 0, Plese enter 0 in Lumps, Fines and Concentrates.");
            } else {
                alert("All fields are Required. Kindly enter data in all fields.")
                event.preventDefault();
            }
        
        } else {

            // if (confirm("Opening Stock + Production Stock - Dispatches should be equal to Closing Stock in all Rows. Please rectify the errors before proceding.")) {
            
            // } else {
            //     event.preventDefault();
            // }

        }



    });




    // $("#F_Reasons_REASON_1").focusout(function (event) {
    //     if ($(this).val() != '') {
    //         var dataToAppend = "<span style='color: #000'> Reason for increase/decrease in Production </span>";
    //         $("#incDecReason").html(dataToAppend);
    //         event.preventDefault();
    //     }
    // });
    
    // $("#F_Reasons_REASON_2").focusout(function (event) {
    //     if ($(this).val() != '') {
    //         var dataToAppend = "<span style='color: #000'> Reason for increase/decrease in Ex-mine price </span>";
    //         $("#exMineIncDesc").html(dataToAppend);
    //         event.preventDefault();
    //     }
    // });

    /**
     * IN THE BELOW CODE IN cCheckForZero
     * THE ID OF SPAN IS ADDED TO IDENTIFY THE SPAN WHICH IS CLICKED
     * 
     * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
     * @version 10th Feb 2014
     **/

    // ADDED BY UDAY FOR PRODUCTON VALIDATION FOR CHECKING IF THE OTHER FIELDS 
    // ARE 0 OR NOT AND IF THEN EMPTY THEM
    $.validator.addMethod("cRequired", $.validator.methods.required,
    		$.validator.format("Field is required"));
    $.validator.addMethod("cNumber", $.validator.methods.number, $.validator.format("Please enter numeric digits only"));
    jQuery.validator.addMethod("cCheckForZero", function (value, element) {
        var elementValue = parseFloat(value)
        var elementId = element.id;
        var splitedElementId = elementId.split("_");
        var elementIdSecondChar = splitedElementId[1];
        var exMineId = "#pmv-" + elementIdSecondChar;
        
        if (elementValue > 0) {
            if ($(exMineId).val() == parseFloat(0)) {
                var found = $(exMineId).parent().find("span");
                if (found.length == 0) {

                    var foundDiv = $(exMineId).parent().find("div");
                  
                    if (foundDiv.length > 0) {
                        $(exMineId).parent().find("div").remove();
                    }
                    
                    var message = "<span id = " + "span" + elementIdSecondChar + " style='color: red'><br/>Field is required as Production is greater than 0</span>";                                                                    
                    $(exMineId).after(message);                                                                    
                }
            }
        }
        else {
            $(exMineId).parent().find("span").remove();
            $(exMineId).parent().find("div").remove();
            var openingStockId = "#opening_stock-" + elementIdSecondChar;
            openingStockValue = $(openingStockId).val();
            pmvValue = $(exMineId).val();
            if (openingStockValue == parseFloat(0)) {
                $("#despatches-" + elementIdSecondChar).val("0.000");
                $("#closing_stock-" + elementIdSecondChar).val("0.000");
                $(exMineId).val("0.00");
            }
        }
        return true;
    }, "");

    $.validator.addClassRules("productionForTot", {
        cRequired: true,
        cNumber: true,
        cCheckForZero: true
    });

    // THIS CODE IS ADDED AS THE PREVIOUS ONE WAS A MIXTURE OF JS AND PHP AND 
    // WAS GIVING A LOT OF ERRORS 
    // @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
    // @version 10th Feb 2014
    $.validator.addClassRules("dispatches", {
        cRequired: true,
        cNumber: true                                                                
    });

    // $.validator.addMethod("closingStockFormula", function (index, value)
    // {
    // 	var elementId = value.id;
    // 	var elementIdSplit = elementId.split("_");
    // 	var rowAlphaNo = elementIdSplit[1];
    // 	var opening_stock = new Number(parseFloat($("#opening_stock-" + rowAlphaNo).val()));
    // 	var production_stock = new Number(parseFloat($("#production-" + rowAlphaNo).val()));
    // 	var despatch = new Number(parseFloat($("#despatches-" + rowAlphaNo).val()));

    // 	var temp = parseFloat(opening_stock.toFixed(3)) + parseFloat(production_stock.toFixed(3)) - parseFloat(despatch.toFixed(3));
    // 	var closing_stock = parseFloat($("#closing_stock-" + rowAlphaNo).val());
    // 	temp = parseFloat(temp.toFixed(3));
    // 	if (temp != closing_stock)
    // 		return false;
    // 	else
    // 		return true;

    // }, "Closing stock is not valid");

    $.validator.addClassRules("closingStock", {
        cRequired: true,
        cNumber: true,
        // closingStockFormula: true                                                               
    });


    /**
     * IN THE BELOW CODE IN dCheckPmvForZero
     * THE ID OF SPAN IS ADDED TO IDENTIFY THE SPAN WHICH IS CLICKED
     * 
     * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
     * @version 10th Feb 2014
     **/
    $.validator.addMethod("dRequired", $.validator.methods.required,
    		$.validator.format("Field is required"));
    $.validator.addMethod("dNumber", $.validator.methods.number, $.validator.format("Please enter numeric digits only"));
    jQuery.validator.addMethod("dCheckPmvForZero", function (value, element) {

        var elementValue = parseFloat(value)
        var elementId = element.id;
        var splitedElementId = elementId.split("_");
        var elementIdSecondChar = splitedElementId[1];
        var exProductionId = "#production-" + elementIdSecondChar;
        var productionValue = parseFloat($(exProductionId).val());

        if (elementValue > 0) {
            
            if (productionValue > 0) {
                if (value > 0) {
                    $("#span" + elementIdSecondChar).remove();
                }
            }
            
        }
        else if (elementValue == 0) {
            if (productionValue > 0) {
                $("#span" + elementIdSecondChar).remove();
                var exPmv1 = "#" + elementId;
                var message = "<span id = " + "span" + elementIdSecondChar + " style='color: red'><br/>Field is required as Production is greater than 0</span>";
                $(exPmv1).after(message);
            }
        }
        else {
            
            var exPmv = "#pmv-" + elementIdSecondChar;
            var found = $(exPmv).parent().find("span");
            
            if (productionValue > 0 && found.length > 0) {
                $("#span" + elementIdSecondChar).remove();
            }
            else if (productionValue == 0) {
                $("#span" + elementIdSecondChar).remove();
            }
            
        }
        if ($("#span" + elementIdSecondChar).length > 0) {
            return false;
        }
        else                                                          
            return true;
    }, "");

    $.validator.addClassRules("pmvForProdCheck", {
        dRequired: true,
        dNumber: true,
        dCheckPmvForZero: true,
        lesserPrice: true
    });

    $.validator.addMethod("eRequired", $.validator.methods.required, $.validator.format("Field is required"));
    $.validator.addMethod("eNumber", $.validator.methods.number, $.validator.format("Please enter numeric digits only"));
    jQuery.validator.addMethod("eCheckOpeninngStockForZero", function (value, element) {
        var elementValue = parseFloat(value)
        var elementId = element.id;
        var splitedElementId = elementId.split("_");
        var elementIdSecondChar = splitedElementId[1];
        var exProductionId = "#production-" + elementIdSecondChar;
        var productionValue = parseFloat($(exProductionId).val());
        if (value == 0 || isNaN(value)) {
            if (productionValue == 0) {
                $("#despatches-" + elementIdSecondChar).val("0.000");
                $("#closing_stock-" + elementIdSecondChar).val("0.000");
                $("#pmv-" + elementIdSecondChar).val("0.00");

            }
        }

        return true;
    }, "");


    $.validator.addClassRules("openingStock", {
        eRequired: true,
        eNumber: true,
        eCheckOpeninngStockForZero: true
    });

});

$(document).ready(function(){

    var mineral = document.getElementById('mineral').value;

    if (mineral == "iron_ore" || mineral == "chromite") {                                                  
    
        var totalLumpAndFine = document.getElementById('prod_grade_array_count').value;
        custom_validations.F4ExMineCheck(totalLumpAndFine);
    }
    else {
        var checkFormTypeForGrade = document.getElementById('form_no').value;                                                   
        custom_validations.ExMineCheckForOther(checkFormTypeForGrade);

    }

	$('#frmGradeWiseProduction').ready(function(){
		
		// // fetch the previous month closing stocks and display it in present month opening stocks
		// var prevMonth = $('#prev_month').val();
		// var mineCode = $('#mine_code').val();
		// var returnType = $('#return_type').val();
		// var mineralName = $('#mineral_name').val();
		// var ironSubMin = $('#iron_sub_min').val();
		// var prevClosStockUrl = $('#prev_clo_stock_url').val();
		// var post_data = {prev_month: prevMonth, mine_code: mineCode, return_type: returnType, mineral: mineralName, iron_sub_min: ironSubMin};
		// $.ajax({
		// 	url: prevClosStockUrl,
		// 	type: 'POST',
		// 	beforeSend: function (xhr) {
		// 		xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
		// 	},
		// 	data: post_data,
		// 	success: function (response) {
		// 		var data = json_parse(response);
		// 		// THIS IS FOR MAKING THE PREVIOUS MONTH DATA IN THE CURRENT MONTH OPNING STOCK
		// 		// IT WAS CODED EARLIER... BEFORE ME .. SO I DIDN'T CHANGE . IT'S HARD CODED AND WILL NOT EFFECT ANYTHING...
		// 		var grades = new Array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17');
		// 		for (var j = 0; j < grades.length; j++) {
		// 			if ($("#opening_stock-" + grades[j]).val() == '')
		// 				$("#opening_stock-" + grades[j]).val(data[j]);
		// 		}
		// 	}
		// });

	});

});

function checkGradeTotal() {
    var openOcRom = new Number(jQuery.trim($("#openOcRom").val()));
    var prodOcRom = new Number(jQuery.trim($("#prodOcRom").val()));
    var closeOcRom = new Number(jQuery.trim($("#closeOcRom").val()));
    var openUgRom = new Number(jQuery.trim($("#openUgRom").val()));
    var prodUgRom = new Number(jQuery.trim($("#prodUgRom").val()));
    var closeUgRom = new Number(jQuery.trim($("#closeUgRom").val()));
    var openDwRom = new Number(jQuery.trim($("#openDwRom").val()));
    var prodDwRom = new Number(jQuery.trim($("#prodDwRom").val()));
    var closeDwRom = new Number(jQuery.trim($("#closeDwRom").val()));

    // THIS IS HARD-CODED ARRAY, i USED IT IN THE NEW LOGIC, BUT DON'T WORRY IT WILL LET YOU INCLUDE CONCENTRATE IN THE TOTAL
    var grades = new Array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17');
    // HERE I AM TAKING THE TOTAL OF LUMPS AND FINES ONLY, AS WE DON'T WANT TO INCLUDE CONCENTRATE IN THE TOTAL
    var lumpAndFineTot = jQuery.trim($("#prod_grade_array_count").val());

    /* @author: Uday Shankar Singh
     * EARLIER THE ABOVE CODE IS LIKE BELOW, BUT NOW THEY DON'T WANT TO INCLUDE
     * CONCENTRATION IN TOTAL, SO I REMOVED 'M FROM THE LIST '
     * PLEASE USE THE BELOW CODE IF NEEDED AND ALSO DON'T DELETE IT 
     * UNTIL U R REALLY SURE ABOUT WHAT U R DOING
     * var grades = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
     **/
    var totalProduction = new Number(0);
    var totalDespatches = new Number(0);
    //        for(var j = 0; j<grades.length; j++){
    for (var j = 0; j < lumpAndFineTot; j++) {
        var temp_prod = new Number(jQuery.trim($("#production-" + grades[j]).val()));
        totalProduction += temp_prod;
    }
    var totalProdRom = prodOcRom + prodUgRom + prodDwRom;
    var totalOpeningStock = openOcRom + openUgRom + openDwRom;

    $('.welcome-page-name').next().slideToggle("fast");
    //if total production entered is greater than ROM
    /**
     * CHANGED THE CODE FOR COMPARING THE FLOATING POINT NUMBER
     * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
     * @version 21st Nov 2014
     *
     * ADDED THE VARIABLES AND THEN COMPARING THE RESULT FOR FOR SHOWING THE ALERT
     * @version Dec 8th 2014 
     *
     **/

    var totalProductionCheck = parseFloat(Utilities.roundOff3(totalProduction));
    var romProductionCheck = parseFloat(Utilities.roundOff3(totalProdRom)) + parseFloat(Utilities.roundOff3(totalOpeningStock));

    if (totalProductionCheck <= romProductionCheck) {
        return true;                                                           
    } else {
        alert('Total of Grade-wise Production is greater than ROM production + ROM Opening Stock');
        return false;
    }
}

$(document).ready(function(){

    $('#frmGradeWiseProduction').ready(function(){
        
        // f3Validation.avgGradeValidation();

        var returnType = $('#return_type').val();
        if (returnType == "ANNUAL") {
            custom_validations.closeIconClick();
        }

    });

});


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