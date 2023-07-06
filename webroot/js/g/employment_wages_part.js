
$(document).ready(function(){

    EmploymentWagesPart2.fieldValidation();
    EmploymentWagesPart2.validateBigFormula();

    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();

    var sDate = startDate.split('-');
    var sDD = sDate[2];
    var sMM = sDate[1];
    var sYY = sDate[0];
    sDate = sDD+'-'+sMM+'-'+sYY;
    
    var eDate = endDate.split('-');
    var eDD = eDate[2];
    var eMM = eDate[1];
    var eYY = eDate[0];
    eDate = eDD+'-'+eMM+'-'+eYY;

    $(function() {
        $(".date").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $(".date").datepicker("option", "minDate", sDate);
        $(".date").datepicker("option", "maxDate", eDate);

    });
    

    // $("#WORKING_BELOW_DATE").prop('readonly', 'readonly');
    // $("#WORKING_ALL_DATE").prop('readonly', 'readonly');

    // var fromReturnYearForCal = "2020";
    // var toReturnYearForCal = parseInt(fromReturnYearForCal) + 1;
    // Utilities.datePicker(".date", fromReturnYearForCal, toReturnYearForCal);
    
    getTotal('direct');
    getTotal('contract');
    getTotal('man');
    getTotalDays();
    getTotal('male');
    getTotal('female');
    getTotal('per_tot');
    getTotal('wages');
    
    $('.direct').on('blur', function() {
        getTotal('direct');
        getTotalEmployeeDirect(this.id);
        getTotal("man");
		getTotalDays();			   
    });

    $('.contract').on('blur', function() {
        getTotal('contract');
        getTotalEmployeeDirect(this.id);
        getTotal("man");
		getTotalDays();			   
    });

    $('.man').on('blur', function() {
        getTotal("man");
    });
    
    $('.days').on('blur', function() {
        // getTotal("days");
        getTotalDays();
    });
    
    $('.male').on('blur', function() {
        getTotal('male');
        getTotalPersonsDirect(this.id);
        getTotal("per_tot");
    });
    
    $('.female').on('blur', function() {
        getTotal('female');
        getTotalPersonsDirect(this.id);
        getTotal("per_tot");
    });

    $('.per_tot').on('blur', function() {
        getTotal("per_tot");
    });
    
    $('.wages').on('blur', function() {
        getTotal("wages");
    });

    // Validating "2(C)/3 = 4(C)" formula checkpoint
    $('#employmentWagesPart2').on('submit', function() {

        var belowManTot = parseInt($('#BELOW_FOREMAN_MAN_TOT').val());
        var openManTot = parseInt($('#OC_FOREMAN_MAN_TOT').val());
        var aboveManTot = parseInt($('#ABOVE_CLERICAL_MAN_TOT').val());
        var belowDays = parseInt($('#BELOW_FOREMAN_DAYS').val());
        var openDays = parseInt($('#OC_FOREMAN_DAYS').val());
        var aboveDays = parseInt($('#ABOVE_CLERICAL_DAYS').val());
        var belowTotal = parseFloat($('#BELOW_FOREMAN_PER_TOTAL').val());
        var openTotal = parseFloat($('#OC_FOREMAN_PER_TOTAL').val());
        var aboveTotal = parseFloat($('#ABOVE_CLERICAL_PER_TOTAL').val());

        // 2c / 3 = 4c
        var belowManTotDays = belowManTot / belowDays;
        var belowManTotDaysOriginal = (isNaN(belowManTotDays)) ? 0 : belowManTotDays;
        var belowManTotDaysArr = belowManTotDaysOriginal.toString().split('.');
        var belowManTotDaysLowerLimit = (belowManTotDaysArr.length === 2) ? belowManTotDaysArr[0] : belowManTotDaysOriginal;
        var belowManTotDaysUpperLimit = (belowManTotDaysArr.length === 2) ? parseInt(belowManTotDaysArr[0]) + 1 : belowManTotDaysOriginal;
        // if (belowManTotDays != belowTotal) {
        // Added upperlimit and lowerlimit for allowing nearby rounded values - Aniket G [22-05-2023]
        if (belowTotal < belowManTotDaysLowerLimit || belowTotal > belowManTotDaysUpperLimit) {
            alert('For Below Ground 2(C)/(3) = 4(C) is not validating. Kindly correct before proceeding');
            $('#BELOW_FOREMAN_MAN_TOT').addClass('is-invalid');
            $('#BELOW_FOREMAN_DAYS').addClass('is-invalid');
            $('#BELOW_FOREMAN_PER_TOTAL').addClass('is-invalid');
            return false;
        } else {
            $('#BELOW_FOREMAN_MAN_TOT').removeClass('is-invalid');
            $('#BELOW_FOREMAN_DAYS').removeClass('is-invalid');
            $('#BELOW_FOREMAN_PER_TOTAL').removeClass('is-invalid');
        }

        var openManTotDays = openManTot / openDays;
        var openManTotDaysOriginal = (isNaN(openManTotDays)) ? 0 : openManTotDays;
        var openManTotDaysArr = openManTotDaysOriginal.toString().split('.');
        var openManTotDaysLowerLimit = (openManTotDaysArr.length === 2) ? openManTotDaysArr[0] : openManTotDaysOriginal;
        var openManTotDaysUpperLimit = (openManTotDaysArr.length === 2) ? parseInt(openManTotDaysArr[0]) + 1 : openManTotDaysOriginal;

        // if (openManTotDays != openTotal) {
        // Added upperlimit and lowerlimit for allowing nearby rounded values - Aniket G [22-05-2023]
        if (openTotal < openManTotDaysLowerLimit || openTotal > openManTotDaysUpperLimit) {
            alert('For Opencast 2(C)/(3) = 4(C) is not validating. Kindly correct before proceeding');
            $('#OC_FOREMAN_MAN_TOT').addClass('is-invalid');
            $('#OC_FOREMAN_DAYS').addClass('is-invalid');
            $('#OC_FOREMAN_PER_TOTAL').addClass('is-invalid');
            return false;
        } else {
            $('#OC_FOREMAN_MAN_TOT').removeClass('is-invalid');
            $('#OC_FOREMAN_DAYS').removeClass('is-invalid');
            $('#OC_FOREMAN_PER_TOTAL').removeClass('is-invalid');
        }

        var aboveManTotDays = aboveManTot / aboveDays;
        var aboveManTotDaysOriginal = (isNaN(aboveManTotDays)) ? 0 : aboveManTotDays;
        var aboveManTotDaysArr = aboveManTotDaysOriginal.toString().split('.');
        var aboveManTotDaysLowerLimit = (aboveManTotDaysArr.length === 2) ? aboveManTotDaysArr[0] : aboveManTotDaysOriginal;
        var aboveManTotDaysUpperLimit = (aboveManTotDaysArr.length === 2) ? parseInt(aboveManTotDaysArr[0]) + 1 : aboveManTotDaysOriginal;
        // if (aboveManTotDays != aboveTotal) {
        // Added upperlimit and lowerlimit for allowing nearby rounded values - Aniket G [22-05-2023]
        if (aboveTotal < aboveManTotDaysLowerLimit || aboveTotal > aboveManTotDaysUpperLimit) {
            alert('For Above Ground 2(C)/(3) = 4(C) is not validating. Kindly correct before proceeding');
            $('#ABOVE_CLERICAL_MAN_TOT').addClass('is-invalid');
            $('#ABOVE_CLERICAL_DAYS').addClass('is-invalid');
            $('#ABOVE_CLERICAL_PER_TOTAL').addClass('is-invalid');
            return false;
        } else {
            $('#ABOVE_CLERICAL_MAN_TOT').removeClass('is-invalid');
            $('#ABOVE_CLERICAL_DAYS').removeClass('is-invalid');
            $('#ABOVE_CLERICAL_PER_TOTAL').removeClass('is-invalid');
        }
        return true;

    });

});


function getTotal(field) {
    
    var totalValue = 0;
    var multiplicationValue = 0;
    $('.'+field).each(function() {

        var field_id = this.id;

        if($('#'+field_id).val() != '') {
            totalValue = totalValue+parseFloat($('#'+field_id).val());
            if(field == 'days' || field == 'direct' || field == 'contract'){
                var splittedFieldId = field_id.split('_');
                var manTotId = splittedFieldId[0]+'_'+splittedFieldId[1]+'_MAN_TOT';
                var daysId  = splittedFieldId[0]+'_'+splittedFieldId[1]+'_DAYS';
                //alert($('#'+daysId).val());
                if($('#'+daysId).val() != '' && $('#'+daysId).val() != 0) {
                    multiplicationValue = parseFloat(multiplicationValue)+parseFloat($('#'+daysId).val()) * parseFloat($('#'+manTotId).val());
                    var finalValue = parseFloat(multiplicationValue)/parseFloat($('#TOTAL_MAN').val());
                    finalValue = Math.round(finalValue);

                    $('#TOTAL_DAYS').val(finalValue);
                }
                
            }
        }
    });

    var field_new = field.toUpperCase();

    //  alert('else');
    if(field_new != 'DAYS'){
        if(field_new == 'WAGES'){
            var totValue = Utilities.roundOff2(totalValue)
        }
        else{
            var totValue = Utilities.roundOff1(totalValue)
        }
        $('#TOTAL_'+field_new).val(totValue);
        if(field_new == 'FEMALE' || field_new == 'MALE') {
            var totalMale   = $('#TOTAL_MALE').val();
            var totalFemale = $('#TOTAL_FEMALE').val();
            var calculatedTotal = parseFloat(totalMale)+parseFloat(totalFemale);
            var calTotal = Utilities.roundOff1(calculatedTotal);
            //console.log(calTotal);
            $('#TOTAL_PERSONS').val(calTotal);
            //$('#BELOW_FOREMAN_PER_TOTAL').val(calTotal);
        }
        // $('#TOTAL_'+field_new).val(totalValue.toFixed(1));
        // $('#TOTAL_'+field_new).val(totalValue.toFixed(1));
    }

    /*if(field_new == 'DAYS' || field_new == 'DIRECT' || field_new == 'CONTRACT'){
        var totalPersonsVal = parseFloat($('#TOTAL_MAN').val())/parseFloat($('#TOTAL_DAYS').val());
        $('#TOTAL_PERSONS').val(totalPersonsVal);
    }*/

}

function getTotalEmployeeDirect(elementId){
    var splittedId   = elementId.split('_');
    var commomField  = splittedId[0]+'_'+splittedId[1];
    var totalFieldId = commomField+'_MAN_TOT';
    var dirVal= ($("#"+commomField+"_DIRECT").val()=='') ? 0 : parseFloat($("#"+commomField+"_DIRECT").val());
    var contVal= ($("#"+commomField+"_CONTRACT").val()=='') ? 0 : parseFloat($("#"+commomField+"_CONTRACT").val());

    var total = dirVal+contVal ;
    $("#"+totalFieldId).val(total.toFixed(1));
}
//function added by shalini Date: 11/01/2021
function getTotalPersonsDirect(elementId){
    
    var splittedId   = elementId.split('_');
    var commomField  = splittedId[0]+'_'+splittedId[1];
    var totalFieldId = commomField+'_PER_TOTAL';
    var dirVal=($("#"+commomField+"_MALE").val()=='')? 0 : parseFloat($("#"+commomField+"_MALE").val());
    var contVal=($("#"+commomField+"_FEMALE").val()=='')? 0 : parseFloat($("#"+commomField+"_FEMALE").val());
    var total = dirVal+contVal ;
    /*console.log(dirVal);
    console.log(contVal);
    console.log(total);*/
    $("#"+totalFieldId).val(total.toFixed(1));
}
//end

function getTotalDays() {
    var endDate = $('#end_date').val();
    var eDate = endDate.split('-');
    var eYY = eDate[0];
    var total =0;
    var daysOne = $('#BELOW_FOREMAN_DAYS').val();
    var daysTwo = $('#OC_FOREMAN_DAYS').val();
    var daysThree = $('#ABOVE_CLERICAL_DAYS').val();


    var totManBE = $('#BELOW_FOREMAN_MAN_TOT').val();
    var totManOC = $('#OC_FOREMAN_MAN_TOT').val();
    var totManAB = $('#ABOVE_CLERICAL_MAN_TOT').val();

    totManBE = (totManBE == '') ? 0 : totManBE;
    totManOC = (totManOC == '') ? 0 : totManOC;
    totManAB = (totManAB == '') ? 0 : totManAB;
    daysOne = (daysOne == '') ? 0 : daysOne;
    daysTwo = (daysTwo == '') ? 0 : daysTwo;
    daysThree = (daysThree == '') ? 0 : daysThree;

    var daysValOne = parseFloat(totManBE) * parseFloat(daysOne);

    var daysValTwo = parseFloat(totManOC) * parseFloat(daysTwo);
    var daysValThree = parseFloat(totManAB) * parseFloat(daysThree);

    // Added by Shalini D to get Avg value 12-02-2022
    daysOneCount = 1 ;
    daysTwoCount = 1 ;
    daysThreeCount = 1;

    if(daysValOne == 0) {
        daysOneCount = 0;
        daysOne = 0;
    }
    if(daysValTwo == 0) {
        daysTwoCount = 0;
        daysTwo = 0;
    }
    if(daysValThree == 0) {
        daysThreeCount = 0;
        daysThree = 0;
    }

    var totalDaysCount = parseFloat(daysOneCount) + parseFloat(daysTwoCount) + parseFloat(daysThreeCount);
    //end
   
    var total = parseFloat(daysOne) + parseFloat(daysTwo) + parseFloat(daysThree);

    var total_day = Number(total)/Number(totalDaysCount);  // Added by Shweta Apale to get Avg value 22-01-2022
    var total_days = (isNaN(total_day)) ? 0 : total_day.toFixed(3);
    
    var max_days = 365;
    if( (eYY % 4 == 0 ) && (eYY % 100 != 0 ) )
    {
        max_days = 366;
    }
    if(Number(total_days) > Number(max_days))
    {
        $('#BELOW_FOREMAN_DAYS').val('0');
        $('#OC_FOREMAN_DAYS').val('0');
        $('#ABOVE_CLERICAL_DAYS').val('0');
        $('#TOTAL_DAYS').val("0");
         var dataToAppend = "<div class='mt-2 position-absolute'> Total "+max_days+" days allowed </div>";
            $('#TOTAL_DAYS').parent().next('.err_cv').html(dataToAppend);
            return false;
    }else
    {

        if($('#BELOW_FOREMAN_DAYS').val().indexOf('.')!=-1){
            $('#BELOW_FOREMAN_DAYS').val('0');
            return false;
        }
        if($('#OC_FOREMAN_DAYS').val().indexOf('.')!=-1){
            $('#OC_FOREMAN_DAYS').val('0');
            return false;
        }
        if($('#ABOVE_CLERICAL_DAYS').val().indexOf('.')!=-1){
            $('#ABOVE_CLERICAL_DAYS').val('0');
            return false;
        }
        $('#TOTAL_DAYS').val(parseFloat(total_days));
        $('#TOTAL_DAYS').parent().next('.err_cv').html('');

    }
    
}
