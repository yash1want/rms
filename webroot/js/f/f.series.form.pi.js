function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}
/*Details of the Mine*/
$(document).ready(function () {
    $("#frmMineDetails").validate({
        rules: {
            "F[FAX_NO]": {
                required: true,
                number: true,
                min: 0,
                maxlength: 11
            },
            "F[PHONE_NO]": {
                required: true,
                number: true,
                min: 0,
                maxlength: 11
            },
            "F[MOBILE_NO]": {
                required: true,
                number: true,
                min: 0,
                maxlength: 10
            },
            "F[EMAIL]": {
                required: true,
                email: true
            }
        },
        errorElement: "div",
        onkeyup: false,
        messages: {
            "F[FAX_NO]": {
                required: "Please enter Fax number.",
                number: "Fax number is not valid."
            },
            "F[PHONE_NO]": {
                required: "Please enter Phone number.",
                number: "Phone number is not valid."
            },
            "F[MOBILE_NO]": {
                required: "Please enter mobile number.",
                number: "Mobile number is not valid."
            },
            "F[EMAIL]": {
                required: "Please enter email address.",
                email: "Email is not valid."
            }
        }
    });
});
/*Name and Address of Lessee/Owner */
$(document).ready(function () {
    $("#frmNameAddress").validate({
        rules: {
            "F[A_FAX_NO]": {
                required: true,
                number: true,
                min: 0,
                maxlength: 11
            },
            "F[A_PHONE_NO]": {
                required: true,
                number: true,
                min: 0,
                maxlength: 11
            },
            "F[A_MOBILE_NO]": {
                required: true,
                number: true,
                min: 0,
                maxlength: 10
            },
            "F[A_EMAIL]": {
                required: true,
                email: true
            }
        },
        errorElement: "div",
        onkeyup: false,
        messages: {
            "F[A_FAX_NO]": {
                required: "Please enter Fax number.",
                number: "Fax number is not valid."
            },
            "F[A_PHONE_NO]": {
                required: "Please enter Phone number.",
                number: "Phone number is not valid."
            },
            "F[A_MOBILE_NO]": {
                required: "Please enter mobile number.",
                number: "Mobile number is not valid."
            },
            "F[A_EMAIL]": {
                required: "Please enter email address.",
                email: "Please enter valid Email address."
            }
        }
    });
});

/*Details of Rent/ Royalty / Dead Rent paid*/
$(document).ready(function () {
    $("#frmRentDetails").validate({
        rules: {
            "f_past_surface_rent": {
                required: true,
                digits: true,
                maxlength: 12
            },
            "f_past_royalty": {
                required: true,
                digits: true,
                maxlength: 12
            },
            "f_past_dead_rent": {
                required: true,
                digits: true,
                maxlength: 12
            },
            "f_past_pay_dmf": {
                required: true,
                digits: true,
                maxlength: 12
            },
            "f_past_pay_nmet": {
                required: true,
                digits: true,
                maxlength: 12
            }
        },
        errorElement: "div",
        onkeyup: false,
        messages: {
            "f_past_surface_rent": {
                required: "Please enter the rent paid for the period."
            },
            "f_past_royalty": {
                required: "Please enter the royalty paid for the period."
            },
            "f_past_dead_rent": {
                required: "Please enter the rent paid for the period."
            },
            "f_past_pay_dmf": {
                required: "Please enter the rent paid for the period."
            },
            "f_past_pay_nmet": {
                required: "Please enter the rent paid for the period."
            }
        }
    });
});

/*frmWorkingDetails*/
$(document).ready(function () {
    $("#frmWorkingDetails").validate({
        rules: {
            "f_total_no_days": {
                required: true,
                number: true,
                maxlength: 2
            },
            "no_days_1": {
                number: true,
                required: function () {
                    if ($('#stoppage_reason-1').val() != '')
                        return true;
                    else
                        return false;
                },
                maxlength: 2

            },
            "stoppage_reason_1": {
                change: function () {
                    var reason1 = $('#stoppage_reason-1').val();
                    var reason2 = $('#stoppage_reason-2').val();
                    var reason3 = $('#stoppage_reason-3').val();
                    var reason4 = $('#stoppage_reason-4').val();
                    var reason5 = $('#stoppage_reason-5').val();
                    if (reason1 == reason2 || reason1 == reason3 || reason1 == reason4 || reason1 == reason5) {
                        $('#stoppage_reason-1').val('');

                    }
                }
            },
            "no_days_2": {
                number: true,
                required: function () {
                    if ($('#stoppage_reason_2').val() != '')
                        return true;
                    else
                        return false;
                },
                maxlength: 2
            },
            "stoppage_reason_2": {
                change: function () {
                    var reason1 = $('#stoppage_reason_1').val();
                    var reason2 = $('#stoppage_reason_2').val();
                    var reason3 = $('#stoppage_reason_3').val();
                    var reason4 = $('#stoppage_reason_4').val();
                    var reason5 = $('#stoppage_reason_5').val();
                    if (reason2 == reason1 || reason2 == reason3 || reason2 == reason4 || reason2 == reason5) {
                        $('#stoppage_reason_2').val('');

                    }
                }

            },
            "no_days_3": {
                number: true,
                required: function () {
                    if ($('#stoppage_reason_3').val() != '')
                        return true;
                    else
                        return false;
                },
                maxlength: 2
            },
            "stoppage_reason_3": {
                change: function () {
                    var reason1 = $('#stoppage_reason_1').val();
                    var reason2 = $('#stoppage_reason_2').val();
                    var reason3 = $('#stoppage_reason_3').val();
                    var reason4 = $('#stoppage_reason_4').val();
                    var reason5 = $('#stoppage_reason_5').val();
                    if (reason3 == reason1 || reason3 == reason2 || reason3 == reason4 || reason3 == reason5) {
                        $('#stoppage_reason_3').val('');

                    }
                }
            },
            "no_days_4": {
                number: true,
                required: function () {
                    if ($('#stoppage_reason_4').val() != '')
                        return true;
                    else
                        return false;
                },
                maxlength: 2
            },
            "stoppage_reason_4": {
                change: function () {
                    var reason1 = $('#stoppage_reason_1').val();
                    var reason2 = $('#stoppage_reason_2').val();
                    var reason3 = $('#stoppage_reason_3').val();
                    var reason4 = $('#stoppage_reason_4').val();
                    var reason5 = $('#stoppage_reason_5').val();
                    if (reason4 == reason1 || reason4 == reason2 || reason4 == reason3 || reason4 == reason5) {
                        $('#stoppage_reason_4').val('');
                    }
                }

            },
            "no_days_5": {
                number: true,
                required: function () {
                    if ($('#stoppage_reason_5').val() != '')
                        return true;
                    else
                        return false;
                },
                maxlength: 2
            },
            "stoppage_reason_5": {
                change: function () {
                    var reason1 = $('#stoppage_reason_1').val();
                    var reason2 = $('#stoppage_reason_2').val();
                    var reason3 = $('#stoppage_reason_3').val();
                    var reason4 = $('#stoppage_reason_4').val();
                    var reason5 = $('#stoppage_reason_5').val();
                    if (reason5 == reason1 || reason5 == reason2 || reason5 == reason3 || reason5 == reason4) {
                        $('#stoppage_reason_5').val('');
                    }
                }
            }
        },
        errorElement: "div",
        messages: {
            "F[NUM_OF_DAYS_MINE_WORKED]": {
                number: "Please enter number of days."
            }
        }
    });
});

/*$("#frmWorkingDetails").submit(function () {
 
 var noofdays1 = jQuery.trim($('#F_NO_DAYS_1').val());
 alert("Arrived");
 if(noofdays1 == ''||$('#F_STOPPAGE_SN_1').val()=='')
 {
 alert("reason1:"+$('#F_STOPPAGE_SN_1').val()+" days:"+$('#F_NO_DAYS_1').val());
 $('#F_NO_DAYS_1').val('');
 noofdays1 = 0;
 }
 
 var noofdays2 = jQuery.trim($('#F_NO_DAYS_2').val());
 if(noofdays2 == ''||$('#F_STOPPAGE_SN_2').val()=='')
 {
 $('#F_NO_DAYS_2').val('');
 noofdays2 = 0;
 }
 var noofdays3 = jQuery.trim($('#F_NO_DAYS_3').val());
 if(noofdays3 == ''||$('#F_STOPPAGE_SN_3').val()=='')
 {
 $('#F_NO_DAYS_3').val('');
 noofdays3 = 0;
 }
 var noofdays4 = jQuery.trim($('#F_NO_DAYS_4').val());
 if(noofdays4 == ''||$('#F_STOPPAGE_SN_4').val()=='')
 {
 $('#F_NO_DAYS_4').val('');
 noofdays4 = 0;
 }
 var noofdays5 = jQuery.trim($('#F_NO_DAYS_5').val());
 if(noofdays5 == ''||$('#F_STOPPAGE_SN_5').val()=='')
 {
 $('#F_NO_DAYS_5').val('');
 noofdays5 = 0;
 }
 
 
 var totaldays = parseInt(noofdays1) + parseInt(noofdays2) + parseInt(noofdays3) + parseInt(noofdays4) + parseInt(noofdays5);
 alert(totaldays)
 var month = $('#curmonth').val();
 var year = $('#curyear').val();
 var daysinmonth = daysInMonth(month,year);
 var actualdays = daysinmonth - $('#F_TOTAL_NO_DAYS').val();
 
 if(totaldays > actualdays){
 alert("Total of No. of days should not exceed total no of days in that particular month or No. of days mine worked.");
 return false;	
 }
 
 });*/


/*Average Daily*/
$(document).ready(function () {
    
    jQuery.validator.addMethod("roundOff1", function (value, element) {
        var temp = new Number(value);
        // alert(temp);
        element.value = (temp).toFixed(1);

        return true;
    }, "");

    $("#frmDailyAverage").validate({
        rules: {
            "f_open_male_avg_direct": {
                roundOff1: true,
                required: true,
                number: true,
                max: 9999.9,
                min: 0
            },
            "f_open_female_avg_direct": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                min: 0
            },
            "f_open_male_avg_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                min: 0
            },
            "f_open_female_avg_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                min: 0
            },
            "f_open_wage_direct": {
                required: true,
                number: true,
                roundOff1: true,
                max: 999999999.9,
                min: 0,
                //        digits: true,
                openWageDirectZero: true,
                openWageDirectMin: true,
                openWageDirectMax: true
            },
            "f_open_wage_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 999999999.9,
                min: 0,
                //        digits: true,
                openWageContractZero: true,
                openWageContractMin: true,
                openWageContractMax: true
            },
            "f_below_male_avg_direct": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                //        digits: true,
                min: 0
            },
            "f_below_female_avg_direct": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                //        digits: true,
                min: 0
            },
            "f_below_male_avg_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                //        digits: true,
                min: 0
            },
            "f_below_female_avg_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                //        digits: true,
                min: 0
            },
            "f_below_wage_direct": {
                required: true,
                number: true,
                roundOff1: true,
                max: 999999999.9,
                //        digits: true,
                min: 0,
                belowWageDirectZero: true,
                belowWageDirectMin: true,
                belowWageDirectMax: true
            },
            "f_below_wage_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 999999999.9,
                //        digits: true,
                min: 0,
                belowWageContractZero: true,
                belowWageContractMin: true,
                belowWageContractMax: true
            },
            "f_above_male_avg_direct": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                //        digits: true,
                min: 0
            },
            "f_above_female_avg_direct": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                //        digits: true,
                min: 0
            },
            "f_above_male_avg_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                //        digits: true,
                min: 0
            },
            "f_above_female_avg_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 9999.9,
                //        digits: true,
                min: 0
            },
            "f_above_wage_direct": {
                required: true,
                number: true,
                roundOff1: true,
                max: 999999999.9,
                //        digits: true,
                min: 0,
                aboveWageDirectZero: true,
                aboveWageDirectMin: true,
                aboveWageDirectMax: true
            },
            "f_above_wage_contract": {
                required: true,
                number: true,
                roundOff1: true,
                max: 999999999.9,
                //        digits: true,
                min: 0,
                aboveWageContractZero: true,
                aboveWageContractMin: true,
                aboveWageContractMax: true
            },
            // "F_Open[TOTAL_TECH_EMP]": {
            //     required: true,
            //     digits: true,
            //     maxlength: 4
            // },
            // "F_Open[TOTAL_SALARIES]": {
            //     required: true,
            //     number: true,
            //     maxlength: 12,
            //     totalMinSalary: true,
            //     totalMaxSalary: true
            // },
            "f_open_total_male_direct": {
                roundOff1: true,
                required: true,
                number: true
                        //        checkDirectTotalMale:true
            },
            "f_open_total_female_direct": {
                roundOff1: true,
                required: true,
                number: true
                        //        checkDirectTotalFemale:true        
            },
            "f_open_total_male_contract": {
                roundOff1: true,
                required: true,
                number: true
                        //        checkcontractTotalMale:true
            },
            "f_open_total_female_contract": {
                roundOff1: true,
                required: true,
                number: true
                        //        checkcontractTotalFemale:true
            },
            "f_open_total_direct": {
                required: true,
                roundOff1: true,
                number: true,
                maxlength: 13
                        //        recheckTotalDirectWage:true
            },
            "f_open_total_contract": {
                required: true,
                roundOff1: true,
                number: true,
                maxlength: 13
                        //        recheckTotalContractWage:true
            }
        },
        errorElement: "div",
        onkeyup: false,
        messages: {
            "f_open_male_avg_direct": {
                required: "Please enter direct male.",
                number: "Direct male should be integer."
            },
            "f_open_female_avg_direct": {
                required: "Please enter direct female.",
                number: "Direct female should be integer."
            },
            "f_open_male_avg_contract": {
                required: "Please enter contract male.",
                number: "Contract male should be integer."
            },
            "f_open_female_avg_contract": {
                required: "Please enter contract female.",
                number: "Contract female should be integer."
            },
            "f_open_wage_direct": {
                required: "Please enter direct wages.",
                number: "Direct wages should be integer."
            },
            "f_open_wage_contract": {
                required: "Please enter contract wages.",
                number: "Direct wages should be integer."
            },
            "f_below_male_avg_direct": {
                required: "Please enter direct male.",
                number: "Direct male should be integer."
            },
            "f_below_female_avg_direct": {
                required: "Please enter direct female.",
                number: "Direct female should be integer."
            },
            "f_below_male_avg_contract": {
                required: "Please enter contract male.",
                number: "Contract male should be integer."
            },
            "f_below_female_avg_contract": {
                required: "Please enter contract female.",
                number: "Contract female should be integer."
            },
            "f_below_wage_direct": {
                required: "Please enter direct wages.",
                number: "Direct wages should be integer."
            },
            "f_below_wage_contract": {
                required: "Please enter contract wages .",
                number: "Contract wages should be integer."
            },
            "f_above_male_avg_direct": {
                required: "Please enter direct male.",
                number: "Direct male should be integer."
            },
            "f_above_female_avg_direct": {
                required: "Please enter direct female.",
                number: "Direct female should be integer."
            },
            "f_above_male_avg_contract": {
                required: "Please enter contract male.",
                number: "Contract male should be integer."
            },
            "f_above_female_avg_contract": {
                required: "Please enter contract female.",
                number: "Contract female should be integer."
            },
            "f_above_wage_direct": {
                required: "Please enter direct wages.",
                number: "Direct wages should be integer."
            },
            "f_above_wage_contract": {
                required: "Please enter contract wages.",
                number: "Contract wages should be integer."
            },
            // "F_Open[TOTAL_TECH_EMP]": {
            //     required: "Please enter the total staffs.",
            //     number: "Total staffs should be integer."
            // },
            // "F_Open[TOTAL_SALARIES]": {
            //     required: "Please enter salary.",
            //     number: "Salary should be integer.",
            //     maxlength: "Please enter salary not more than 12 characters."
            // },
            "f_open_total_male_direct": {
                required: "Please enter total direct male.",
                number: "Total direct male should be integer"
            },
            "f_open_total_female_direct": {
                required: "Please enter total direct female.",
                number: "Total direct female should be integer"
            },
            "f_open_total_male_contract": {
                required: "Please enter total contract male.",
                number: "Total contract male should be integer"
            },
            "f_open_total_female_contract": {
                required: "Please enter total contract female.",
                number: "Total contract male should be integer"
            }
        }
    });

    $("#F_NUM_OF_DAYS_MINE_WORKED,input[id^=F_STOPPAGE_DAYS_]").blur(function () {
        if ($("#F_NUM_OF_DAYS_MINE_WORKED").val() && $("#F_STOPPAGE_DAYS_ONE").val() && $("#F_STOPPAGE_DAYS_TWO").val() && $("#F_STOPPAGE_DAYS_THREE").val() && $("#F_STOPPAGE_DAYS_FOUR").val() && $("#F_STOPPAGE_DAYS_FIVE").val()) {
            if (parseInt($("#F_NUM_OF_DAYS_MINE_WORKED").val()) < (parseInt($("#F_STOPPAGE_DAYS_ONE").val()) + parseInt($("#F_STOPPAGE_DAYS_TWO").val()) + parseInt($("#F_STOPPAGE_DAYS_THREE").val()) + parseInt($("#F_STOPPAGE_DAYS_FOUR").val()) + parseInt($("#F_STOPPAGE_DAYS_FIVE").val()))) {
                alert("Toatal number of days not match");
            }
        }
    });
});
/*part II iron_ore start*/
/*Production(frmRomStocks)start
 *UG comes in F-2 */
$(document).ready(function () {
    $("#frmRomStocks").validate({
        rules: {
            "f_open_oc_rom": {
                required: true,
                number: true,
                maxlength: 16
            },
            "f_prod_oc_rom": {
                required: true,
                number: true,
                maxlength: 16
            },
            "f_clos_oc_rom": {
                required: true,
                number: true,
                maxlength: 16,
                // closingStockROM: true
            },
            "f_open_dw_rom": {
                required: true,
                number: true,
                maxlength: 16
            },
            "f_prod_dw_rom": {
                required: true,
                number: true,
                maxlength: 16
            },
            "f_clos_dw_rom": {
                required: true,
                number: true,
                maxlength: 16,
                // closingStockROM: true
            },
            "f_open_ug_rom": {
                required: true,
                number: true,
                maxlength: 16
            },
            "f_prod_ug_rom": {
                required: true,
                number: true,
                maxlength: 16
            },
            "f_clos_ug_rom": {
                required: true,
                number: true,
                maxlength: 16,
                // closingStockROM: true
            }
        },
        errorElement: "div",
        onkeyup: false,
        messages: {
            "f_open_oc_rom": {
                required: "Please enter Opening stock.",
                number: "Opening stock should be number."
            },
            "f_prod_oc_rom": {
                required: "Please enter Production stock.",
                number: "Production Production should be number."
            },
            "f_clos_oc_rom": {
                required: "Please enter Closing  stock.",
                number: "Closing stock should be number."
            },
            "f_open_dw_rom": {
                required: "Please enter Opening stock.",
                number: "Opening stock should be number."
            },
            "f_prod_dw_rom": {
                required: "Please enter Production stock.",
                number: "Production Production should be number."
            },
            "f_clos_dw_rom": {
                required: "Please enter Closing  stock.",
                number: "Closing stock should be number."
            },
            "f_open_ug_rom": {
                required: "Please enter Opening stock.",
                number: "Opening stock should be number."
            },
            "f_prod_ug_rom": {
                required: "Please enter Production stock.",
                number: "Production Production should be number."
            },
            "f_clos_ug_rom": {
                required: "Please enter Closing  stock.",
                number: "Closing stock should be number."
            }
        }
    });
});
/*Production(frmRomStocks)end */
/*deductions_details: starts */
$(document).ready(function () {
    /*
    $("#frmDeductionsDetails").validate({
        rules: {
            "trans_cost": {
                required: true,
                number: true,
                maxlength: 7,
                roundOff2: true
            },
            "trans_remark": {
                transCostCheck: true,
                maxlength: 250
            },
            "loading_charges": {
                required: true,
                number: true,
                maxlength: 7,
                roundOff2: true
            },
            "railway_freight": {
                required: true,
                number: true,
                maxlength: 8,
                roundOff2: true
            },
            "railway_remark": {
                maxlength: 250,
                railwayCostCheck: true
            },
            "port_handling": {
                required: true,
                number: true,
                maxlength: 7,
                roundOff2: true
            },
            "port_remark": {
                maxlength: 250,
                portCostCheck: true
            },
            "sampling_cost": {
                required: true,
                number: true,
                maxlength: 7,
                roundOff2: true
            },
            "plot_rent": {
                required: true,
                number: true,
                maxlength: 7,
                roundOff2: true
            },
            "other_cost": {
                required: true,
                number: true,
                maxlength: 7,
                roundOff2: true
            },
            "other_remark": {
                maxlength: 250,
                otherCostCheck: true
            },
            "total_prod": {
                roundOff2: true,
                maxlength: 9,
                number: true,
                checkDeductionTotal: true
            }
        },
        errorElement: "div",
        onkeyup: false,
        messages: {
            "total_prod": {
                required: "Please enter Transportation Cost.",
                number: "Transportation Cost should be integer."
            },
            "loading_charges": {
                required: "Please enter Loading/Unloading Cost.",
                number: "Loading/Unloading should be integer."
            },
            "railway_freight": {
                required: "Please enter Railway Cost.",
                number: "Railway Cost should be integer."
            },
            "port_handling": {
                required: "Please enter Port Handling Cost.",
                number: "Port Handling Cost should be integer."
            },
            "sampling_cost": {
                required: "Please enter Sampling/Analysis Cost.",
                number: "Sampling/Analysis Cost should be integer."
            },
            "plot_rent": {
                required: "Please enter Plot Rent.",
                number: "Plot Rent should be integer."
            },
            "other_cost": {
                required: "Please enter Other charges.",
                number: "Other charges should be integer."
            },
            "trans_remark": {
                required: "This field is required."
            },
            "railway_remark": {
                required: "This field is required."
            },
            "port_remark": {
                required: "This field is required."
            },
            "other_remark": {
                required: "This field is required."
            }
        }
    });
    */
    
    $("#F_NUM_OF_DAYS_MINE_WORKED,input[id^=F_STOPPAGE_DAYS_]").blur(function () {
        if ($("#F_NUM_OF_DAYS_MINE_WORKED").val() && $("#F_STOPPAGE_DAYS_ONE").val() && $("#F_STOPPAGE_DAYS_TWO").val() && $("#F_STOPPAGE_DAYS_THREE").val() && $("#F_STOPPAGE_DAYS_FOUR").val() && $("#F_STOPPAGE_DAYS_FIVE").val()) {
            if (parseInt($("#F_NUM_OF_DAYS_MINE_WORKED").val()) < (parseInt($("#F_STOPPAGE_DAYS_ONE").val()) + parseInt($("#F_STOPPAGE_DAYS_TWO").val()) + parseInt($("#F_STOPPAGE_DAYS_THREE").val()) + parseInt($("#F_STOPPAGE_DAYS_FOUR").val()) + parseInt($("#F_STOPPAGE_DAYS_FIVE").val()))) {
                alert("Toatal number of days not match");
            }
        }
    });


    $("#F_TRANS_COST").blur(function () {
        if (document.getElementById("F_TRANS_COST").value == "")
        {
            document.getElementById("F_TRANS_COST").value = "0.00";
            document.getElementById("F_TRANS_COST").removeAttribute(required);
        }

    });


    $("#F_LOADING_CHARGES").blur(function () {

        if (document.getElementById("F_LOADING_CHARGES").value == "")
        {
            document.getElementById("F_LOADING_CHARGES").value = "0.00";
            document.getElementById("F_LOADING_CHARGES").removeAttribute(required);
        }
    });

    $("#F_RAILWAY_FREIGHT").blur(function () {

        if (document.getElementById("F_RAILWAY_FREIGHT").value == "")
        {
            document.getElementById("F_RAILWAY_FREIGHT").value = "0.00";
            document.getElementById("F_RAILWAY_FREIGHT").removeAttribute(required);
        }
    });

    $("#F_PORT_HANDLING").blur(function () {

        if (document.getElementById("F_PORT_HANDLING").value == "")
        {
            document.getElementById("F_PORT_HANDLING").value = "0.00";
            document.getElementById("F_PORT_HANDLING").removeAttribute(required);
        }
    });

    $("#F_SAMPLING_COST").blur(function () {

        if (document.getElementById("F_SAMPLING_COST").value == "")
        {
            document.getElementById("F_SAMPLING_COST").value = "0.00";
            document.getElementById("F_SAMPLING_COST").removeAttribute(required);
        }
    });

    $("#F_PLOT_RENT").blur(function () {

        if (document.getElementById("F_PLOT_RENT").value == "")
        {
            document.getElementById("F_PLOT_RENT").value = "0.00";
            document.getElementById("F_PLOT_RENT").removeAttribute(required);
        }
    });

    $("#F_OTHER_COST").blur(function () {

        if (document.getElementById("F_OTHER_COST").value == "")
        {
            document.getElementById("F_OTHER_COST").value = "0.00";
            document.getElementById("F_OTHER_COST").removeAttribute(required);
        }
    });

    /*deductions_details: end */



    /*
     *---Form F-6 validation goes here---
     *------by Pranav Sanvatsarkar-------
     *------Dated: Monday 23-04-2012-----
     */
    $(document).ready(function () {
        $("#frmF6GradeWise").validate({
            rules: {
                "F_Crude[OPEN_MINE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[OPEN_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[OPEN_OTHER]": {
                    required: false,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[TOTAL_OPEN]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkOpenCrudeTotal: true

                },
                "F_Crude[PROD_UG]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[PROD_OC]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[PROD_DW]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[TOTAL_PROD]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkProdCrudeTotal: true
                },
                "F_Crude[DESP_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[DESP_SALE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[TOTAL_DESP]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkDespCrudeTotal: true
                },
                "F_Crude[CLOS_MINE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[CLOS_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[CLOS_OTHER]": {
                    required: false,
                    number: true,
                    roundOff3: true
                },
                "F_Crude[TOTAL_CLOS]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkCloseCrudeTotal: true
                },
                "F_Crude[PMV]": {
                    required: true,
                    number: true,
                    roundOff2: true
                },
                "F_Incidental[OPEN_MINE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[OPEN_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[OPEN_OTHER]": {
                    required: false,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[TOTAL_OPEN]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkOpenIncidentalTotal: true
                },
                "F_Incidental[PROD_UG]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[PROD_OC]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[PROD_DW]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[TOTAL_PROD]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkProdIncidentalTotal: true
                },
                "F_Incidental[DESP_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[DESP_SALE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[TOTAL_DESP]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkProdDespTotal: true
                },
                "F_Incidental[CLOS_MINE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[CLOS_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[CLOS_OTHER]": {
                    required: false,
                    number: true,
                    roundOff3: true
                },
                "F_Incidental[TOTAL_CLOS]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkCloseIncidentalTotal: true
                },
                "F_Incidental[PMV]": {
                    required: true,
                    number: true,
                    roundOff2: true
                },
                "F_WasteMica[OPEN_MINE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[OPEN_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[OPEN_OTHER]": {
                    required: false,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[TOTAL_OPEN]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkOpenWasteTotal: true
                },
                "F_WasteMica[PROD_UG]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[PROD_OC]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[PROD_DW]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[TOTAL_PROD]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkProdWasteTotal: true
                },
                "F_WasteMica[DESP_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[DESP_SALE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[TOTAL_DESP]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkDespWasteTotal: true
                },
                "F_WasteMica[CLOS_MINE]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[CLOS_DRESS]": {
                    required: true,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[CLOS_OTHER]": {
                    required: false,
                    number: true,
                    roundOff3: true
                },
                "F_WasteMica[TOTAL_CLOS]": {
                    required: true,
                    number: true,
                    roundOff3: true,
                    checkCloseWasteTotal: true
                },
                "F_WasteMica[PMV]": {
                    required: true,
                    number: true,
                    roundOff2: true
                },
                "F_Crude[OPEN_OTHER_SPEC]": {
                    required: false
                },
                "F_Crude[CLOS_OTHER_SPEC]": {
                    required: false
                },
                "F_Crude[REASON_ONE]": {
                    required: true
                },
                "F_Crude[REASON_TWO]": {
                    required: true
                }
            },
            errorElement: "div",
            onkeyup: false,
            messages: {
                "F_Crude[OPEN_MINE]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_Crude[OPEN_DRESS]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_Crude[OPEN_OTHER]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_Incidental[OPEN_MINE]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_Incidental[OPEN_DRESS]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_Incidental[OPEN_OTHER]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_WasteMica[OPEN_MINE]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_WasteMica[OPEN_DRESS]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_WasteMica[OPEN_OTHER]": {
                    required: "Please enter opening stock.",
                    number: "Opening stock should be an integer."
                },
                "F_Crude[TOTAL_OPEN]": {
                    required: "Please enter total opening stock.",
                    number: "Total opening stock shiould be an integer."
                },
                "F_Incidental[TOTAL_OPEN]": {
                    required: "Please enter total opeing stock.",
                    number: "Total opening stock shiould be an integer."
                },
                "F_WasteMica[TOTAL_OPEN]": {
                    required: "Please enter total opeing stock.",
                    number: "Total opening stock shiould be an integer."
                },
                "F_Crude[PROD_UG]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_Crude[PROD_OC]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_Crude[PROD_DW]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_Incidental[PROD_UG]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_Incidental[PROD_OC]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_Incidental[PROD_DW]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_WasteMica[PROD_UG]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_WasteMica[PROD_OC]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_WasteMica[PROD_DW]": {
                    required: "Please enter production stock.",
                    number: "Production stock should be an integer."
                },
                "F_Crude[TOTAL_PROD]": {
                    required: "Please enter total production stock.",
                    number: "Total production stock shiould be an integer."
                },
                "F_Incidental[TOTAL_PROD]": {
                    required: "Please enter total production stock.",
                    number: "Total production stock shiould be an integer."
                },
                "F_WasteMica[TOTAL_PROD]": {
                    required: "Please enter total production stock.",
                    number: "Total production stock shiould be an integer."
                },
                "F_Crude[DESP_DRESS]": {
                    required: "Please enter despatches stock.",
                    number: "Despatches stock should be an integer."
                },
                "F_Crude[DESP_SALE]": {
                    required: "Please enter despatches stock.",
                    number: "Despatches stock should be an integer."
                },
                "F_Incidental[DESP_DRESS]": {
                    required: "Please enter despatches stock.",
                    number: "Despatches stock should be an integer."
                },
                "F_Incidental[DESP_SALE]": {
                    required: "Please enter despatches stock.",
                    number: "Despatches stock should be an integer."
                },
                "F_WasteMica[DESP_DRESS]": {
                    required: "Please enter despatches stock.",
                    number: "Despatches stock should be an integer."
                },
                "F_WasteMica[DESP_SALE]": {
                    required: "Please enter despatches stock.",
                    number: "Despatches stock should be an integer."
                },
                "F_Crude[TOTAL_DESP]": {
                    required: "Please enter total despatches stock.",
                    number: "Total despatches stock shiould be an integer."
                },
                "F_Incidental[TOTAL_DESP]": {
                    required: "Please enter total despatches stock.",
                    number: "Total despatches stock shiould be an integer."
                },
                "F_WasteMica[TOTAL_DESP]": {
                    required: "Please enter total despatches stock.",
                    number: "Total despatches stock shiould be an integer."
                },
                "F_Crude[OPEN_OTHER_SPEC]": {
                    required: "Please specify other point."
                },
                "F_Crude[CLOS_OTHER_SPEC]": {
                    required: "Please specify other point."
                },
                "F_Crude[CLOS_MINE]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_Crude[CLOS_DRESS]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_Crude[CLOS_OTHER]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_Incidental[CLOS_MINE]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_Incidental[CLOS_DRESS]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_Incidental[CLOS_OTHER]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_WasteMica[CLOS_MINE]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_WasteMica[CLOS_DRESS]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_WasteMica[CLOS_OTHER]": {
                    required: "Please enter closing stock.",
                    number: "Closing stock should be an integer."
                },
                "F_Crude[TOTAL_CLOS]": {
                    required: "Please enter total closing stock.",
                    number: "Total closing stock shiould be an integer."
                },
                "F_Incidental[TOTAL_CLOS]": {
                    required: "Please enter total closing stock.",
                    number: "Total closing stock shiould be an integer."
                },
                "F_WasteMica[TOTAL_CLOS]": {
                    required: "Please enter total closing stock.",
                    number: "Total closing stock shiould be an integer."
                },
                "F_Crude[PMV]": {
                    required: "Please enter Ex-mine price.",
                    number: "Ex-mine price should be number."
                },
                "F_Incidental[PMV]": {
                    required: "Please enter Ex-mine price.",
                    number: "Ex-mine price should be number."
                },
                "F_WasteMica[PMV]": {
                    required: "Please enter Ex-mine price.",
                    number: "Ex-mine price should be number."
                }
            }

        })
    })

});

/*
 *----------Production, dispatches and stocks validation ends here----------*
 */



/*
 *---------Production,despatches and stocks F-7 validation stuff goes here-------
 *-----
 *------By: Pranav Sanvatsarkar
 *-----
 */

$(document).ready(function () {
    $("#frmProdStockDis").validate({
        rules: {
            "f_rough_open_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_rough_open_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_rough_prod_oc_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_rough_prod_oc_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_rough_prod_ug_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_rough_prod_ug_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_rough_prod_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkProdNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_rough_prod_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkProdQuantTotal: true,
                min: 0,
                max: 999999999.999
            },
            "f_rough_desp_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkDespNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_rough_desp_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkRoughDespatches: true,
                min: 0,
                max: 999999999.999
            },
            "f_rough_clos_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkClosNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_rough_clos_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkClosQty: true,
                min: 0,
                max: 999999999.999
            },
            "f_rough_pmv_oc": {
                required: true,
                roundOff2: true,
                number: true,
                min: 0,
                max: 9999999999.99
            },
            "f_polished_open_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_polished_open_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_polished_prod_oc_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_polished_prod_oc_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_polished_prod_ug_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_polished_prod_ug_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_polished_prod_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkProdNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_polished_prod_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkProdQuantTotal: true,
                min: 0,
                max: 999999999.999
            },
            "f_polished_desp_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkDespNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_polished_desp_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkRoughDespatches: true,
                min: 0,
                max: 999999999.999
            },
            "f_polished_clos_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkClosNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_polished_clos_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkClosQty: true,
                min: 0,
                max: 999999999.999
            },
            "f_polished_pmv_oc": {
                required: true,
                roundOff2: true,
                number: true,
                min: 0,
                max: 9999999999.99
            },
            "f_industrial_open_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_industrial_open_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_industrial_prod_oc_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_industrial_prod_oc_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_industrial_prod_ug_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_industrial_prod_ug_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_industrial_prod_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkProdNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_industrial_prod_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkProdQuantTotal: true,
                min: 0,
                max: 999999999.999
            },
            "f_industrial_desp_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkDespNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_industrial_desp_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkRoughDespatches: true,
                min: 0,
                max: 999999999.999
            },
            "f_industrial_clos_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkClosNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_industrial_clos_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkClosQty: true,
                min: 0,
                max: 999999999.999
            },
            "f_industrial_pmv_oc": {
                required: true,
                roundOff2: true,
                number: true,
                min: 0,
                max: 9999999999.99
            },
            "f_other_open_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_other_open_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_other_prod_oc_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_other_prod_oc_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_other_prod_ug_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                min: 0,
                max: 9999999
            },
            "f_other_prod_ug_qty": {
                required: true,
                roundOff3: true,
                number: true,
                min: 0,
                max: 999999999.999
            },
            "f_other_prod_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkProdNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_other_prod_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkProdQuantTotal: true,
                min: 0,
                max: 999999999.999
            },
            "f_other_desp_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkDespNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_other_desp_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkRoughDespatches: true,
                min: 0,
                max: 999999999.999
            },
            "f_other_clos_tot_no": {
                required: true,
                number: true,
                digits: true, // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
                checkClosNoofStones: true,
                min: 0,
                max: 9999999
            },
            "f_other_clos_tot_qty": {
                required: true,
                roundOff3: true,
                number: true,
                checkClosQty: true,
                min: 0,
                max: 999999999.999
            },
            "f_other_pmv_oc": {
                required: true,
                roundOff2: true,
                number: true,
                min: 0,
                max: 9999999999.99
            }

        },
        onkeyup: false,
        errorElement: "div",
        messages: {
            "f_rough_open_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_rough_open_tot_qty": {
                required: "Please enter quantity"
            },
            "f_rough_prod_oc_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_rough_prod_oc_qty": {
                required: "Please enter quantity"
            },
            "f_rough_prod_ug_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_rough_prod_ug_qty": {
                required: "Please enter quantity"
            },
            "f_rough_prod_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_rough_prod_tot_qty": {
                required: "Please enter quantity"
            },
            "f_rough_desp_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_rough_desp_tot_qty": {
                required: "Please enter quantity"
            },
            "f_rough_clos_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_rough_clos_tot_qty": {
                required: "Please enter quantity"
            },
            "f_rough_pmv_oc": {
                required: "Please enter ex-mine price"
            },
            "f_polished_open_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_polished_open_tot_qty": {
                required: "Please enter quantity"
            },
            "f_polished_prod_oc_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_polished_prod_oc_qty": {
                required: "Please enter quantity"
            },
            "f_polished_prod_ug_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_polished_prod_ug_qty": {
                required: "Please enter quantity"
            },
            "f_polished_prod_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_polished_prod_tot_qty": {
                required: "Please enter quantity"
            },
            "f_polished_desp_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_polished_desp_tot_qty": {
                required: "Please enter quantity"
            },
            "f_polished_clos_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_polished_clos_tot_qty": {
                required: "Please enter quantity"
            },
            "f_polished_pmv_oc": {
                required: "Please enter ex-mine price"
            },
            "f_industrial_open_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_industrial_open_tot_qty": {
                required: "Please enter quantity"
            },
            "f_industrial_prod_oc_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_industrial_prod_oc_qty": {
                required: "Please enter quantity"
            },
            "f_industrial_prod_ug_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_industrial_prod_ug_qty": {
                required: "Please enter quantity"
            },
            "f_industrial_prod_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_industrial_prod_tot_qty": {
                required: "Please enter quantity"
            },
            "f_industrial_desp_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_industrial_desp_tot_qty": {
                required: "Please enter quantity"
            },
            "f_industrial_clos_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_industrial_clos_tot_qty": {
                required: "Please enter quantity"
            },
            "f_industrial_pmv_oc": {
                required: "Please enter ex-mine price"
            },
            "f_other_open_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_other_open_tot_qty": {
                required: "Please enter quantity"
            },
            "f_other_prod_oc_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_other_prod_oc_qty": {
                required: "Please enter quantity"
            },
            "f_other_prod_ug_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_other_prod_ug_qty": {
                required: "Please enter quantity"
            },
            "f_other_prod_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_other_prod_tot_qty": {
                required: "Please enter quantity"
            },
            "f_other_desp_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_other_desp_tot_qty": {
                required: "Please enter quantity"
            },
            "f_other_clos_tot_no": {
                required: "Please enter no. of stones",
                digits: "Decimal digits are not allowed" // FOR NOT ALLOWING THE DECIMAL DIGITS. @author Uday Shankar Singh and @version 13th Feb 2014
            },
            "f_other_clos_tot_qty": {
                required: "Please enter quantity"
            },
            "f_other_pmv_oc": {
                required: "Please enter ex-mine price"
            }

        }
    })
})
/*
 *---------ROM F7 validation stuff goes here-------
 *-----
 *------By: Pranav Sanvatsarkar
 *-----
 */

$(document).ready(function () {
    $("#frmRomStocksF7").validate({
        rules: {
            "F[OC_TYPE]": {
                required: true,
                checkOcType: true
            },
            "F[UG_TYPE]": {
                required: true,
                checkUgType: true
            }
            //COMMENTED AS NOW DECIMAL HAS TO ALLOW IN THE FORM -- UDAY SHANKAR SINGH, 3rd Jan 2014
            //      "F[OC_QTY]": {
            //        required: true,
            //        number: true,
            //        min: 0,
            //        max: 999999999999
            //      },
            //      "F[UG_QTY]": {
            //        required: true,
            //        number: true,
            //        min: 0,
            //        max: 999999999999
            //      }
        },
        onkeyup: false,
        errorElement: "div",
        messages: {
            "F[OC_TYPE]": {
                required: "Please select unit of quantity"
            },
            "F[UG_TYPE]": {
                required: "Please select unit of quantity"
            }
            //COMMENTED AS NOW DECIMAL HAS TO ALLOW IN THE FORM -- UDAY SHANKAR SINGH, 3rd Jan 2014
            //      "F[OC_QTY]": {
            //        required: "Please enter quantity"
            //      },
            //      "F[UG_QTY]": {
            //        required: "Please enter quantity"
            //      }
        }
    })

})

var custom_validations = {
    init: function () {
        this.workStoppageReasonChange();
        this.workStoppageDaysChange();
        this.totalWageCalculation();
        this.totalSalary();
        this.romStocks();
        this.gradeOpeningStock();
        this.gradeExMine();
        this.gradesRoundOff();
        this.deductionDetails();
        this.despatchCheck();
        this.exMineCheck();
        this.deductionCheck();
        this.saleCheck();
        this.pulCheck();
        this.gradePriceCheck();
        this.workingDetailsSaveNextValidation();
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
    workStoppageReasonChange: function () {

        //remove already selected items
        window.onload = function () {
            var stop_1 = $("#stop_1").val();
            var stop_2 = $("#stop_2").val();
            var stop_3 = $("#stop_3").val();
            var stop_4 = $("#stop_4").val();
            var stop_5 = $("#stop_5").val();

            var stoppage_1 = document.getElementById('F_STOPPAGE_SN_1');
            var stoppage_2 = document.getElementById('F_STOPPAGE_SN_2');
            var stoppage_3 = document.getElementById('F_STOPPAGE_SN_3');
            var stoppage_4 = document.getElementById('F_STOPPAGE_SN_4');
            var stoppage_5 = document.getElementById('F_STOPPAGE_SN_5');

            for (var i = 0; i < stoppage_1.options.length; i++) {
                if (stoppage_1.options[i].value == stop_1) {
                    stoppage_2.options[i].style.display = "none";
                    stoppage_3.options[i].style.display = "none";
                    stoppage_4.options[i].style.display = "none";
                    stoppage_5.options[i].style.display = "none";
                }
            }


            for (var i = 0; i < stoppage_2.options.length; i++) {
                if (stoppage_2.options[i].value == stop_2) {
                    stoppage_1.options[i].style.display = "none";
                    stoppage_3.options[i].style.display = "none";
                    stoppage_4.options[i].style.display = "none";
                    stoppage_5.options[i].style.display = "none";
                }
            }


            for (var i = 0; i < stoppage_3.options.length; i++) {
                if (stoppage_3.options[i].value == stop_3) {
                    stoppage_1.options[i].style.display = "none";
                    stoppage_2.options[i].style.display = "none";
                    stoppage_4.options[i].style.display = "none";
                    stoppage_5.options[i].style.display = "none";
                }
            }


            for (var i = 0; i < stoppage_4.options.length; i++) {
                if (stoppage_4.options[i].value == stop_4) {
                    stoppage_1.options[i].style.display = "none";
                    stoppage_2.options[i].style.display = "none";
                    stoppage_3.options[i].style.display = "none";
                    stoppage_5.options[i].style.display = "none";
                }
            }


            for (var i = 0; i < stoppage_5.options.length; i++) {
                if (stoppage_5.options[i].value == stop_5) {
                    stoppage_1.options[i].style.display = "none";
                    stoppage_2.options[i].style.display = "none";
                    stoppage_3.options[i].style.display = "none";
                    stoppage_4.options[i].style.display = "none";
                }
            }

            /****/
            stoppage_1.onchange = function () {
                if (this.selectedIndex == stoppage_2.selectedIndex ||
                        this.selectedIndex == stoppage_3.selectedIndex ||
                        this.selectedIndex == stoppage_4.selectedIndex ||
                        this.selectedIndex == stoppage_5.selectedIndex)
                    alert('You cant select the same reason more than once!');
            }

            stoppage_2.onchange = function () {
                if (this.selectedIndex == stoppage_1.selectedIndex ||
                        this.selectedIndex == stoppage_3.selectedIndex ||
                        this.selectedIndex == stoppage_4.selectedIndex ||
                        this.selectedIndex == stoppage_5.selectedIndex)
                    alert('You cant select the same reason more than once!');
            }

            stoppage_3.onchange = function () {
                if (this.selectedIndex == stoppage_1.selectedIndex ||
                        this.selectedIndex == stoppage_2.selectedIndex ||
                        this.selectedIndex == stoppage_4.selectedIndex ||
                        this.selectedIndex == stoppage_5.selectedIndex)
                    alert('You cant select the same reason more than once!');
            }

            stoppage_4.onchange = function () {
                if (this.selectedIndex == stoppage_1.selectedIndex ||
                        this.selectedIndex == stoppage_2.selectedIndex ||
                        this.selectedIndex == stoppage_3.selectedIndex ||
                        this.selectedIndex == stoppage_5.selectedIndex)
                    alert('You cant select the same reason more than once!');
            }

            stoppage_5.onchange = function () {
                if (this.selectedIndex == stoppage_1.selectedIndex ||
                        this.selectedIndex == stoppage_2.selectedIndex ||
                        this.selectedIndex == stoppage_3.selectedIndex ||
                        this.selectedIndex == stoppage_4.selectedIndex)
                    alert('You cant select the same reason more than once!');
            }
        }
    },
    validateAverageDaily: function () {

        // var directTotalMale=checkDirectTotalMale();
        //checkDirectTotalFemale();
        //  var belowWage=belowWageCalculation();
        //  var aboveWage=aboveWageCalculation();

        //  alert("directTotalMale:"+directTotalMale);
        // 
        if (openWage == true && belowWage == true && aboveWage == true)
            return true;
        else
            return false;
    },
    workStoppageDaysChange: function () {
        //NO OF DAYS 1
        $("#no_days_1").blur(function () {
            //if total no. of days is not filled
            //      if($("#F_TOTAL_NO_DAYS").val() == 0 || $("#F_TOTAL_NO_DAYS").val() == ''){
            if ($("#f_total_no_days").val() == '') {
                if ($(this).val() != 0) {
                    alert("Please enter total no. of days first");
                    $("#f_total_no_days").focus();
                    return;
                }
            }

            var stoppage_1 = document.getElementById('stoppage_reason-1');
            //if no. of days is entered and reason is not selected
            if ($(this).val() != 0) {
                if (stoppage_1.options.selectedIndex == 0) {
                    alert("Please select the reason");
                    return;
                }
            }


        });

        //NO OF DAYS 2
        $("#no_days_2").blur(function () {
            //if total no. of days is not filled
            if ($("#f_total_no_days").val() == '') {
                if ($(this).val() != 0) {
                    alert("Please enter total no. of days first");
                    $("#f_total_no_days").focus();
                    return;
                }
            }

            var stoppage_2 = document.getElementById('stoppage_reason_2');
            //if no. of days is entered and reason is not selected
            if ($(this).val() != 0) {
                if (stoppage_2.options.selectedIndex == 0) {
                    alert("Please select the reason");
                    return;
                }
            }

        });

        //NO OF DAYS 3
        $("#no_days_3").blur(function () {
            //if total no. of days is not filled
            if ($("#f_total_no_days").val() == '') {
                if ($(this).val() != 0) {
                    alert("Please enter total no. of days first");
                    $("#f_total_no_days").focus();
                    return;
                }
            }

            var stoppage_3 = document.getElementById('stoppage_reason_3');
            //if no. of days is entered and reason is not selected
            if ($(this).val() != 0) {
                if (stoppage_3.options.selectedIndex == 0) {
                    alert("Please select the reason");
                    return;
                }
            }

        });

        //NO OF DAYS 4
        $("#no_days_4").blur(function () {
            //if total no. of days is not filled
            if ($("#f_total_no_days").val() == '') {
                if ($(this).val() != 0) {
                    alert("Please enter total no. of days first");
                    $("#f_total_no_days").focus();
                    return;
                }
            }

            var stoppage_4 = document.getElementById('stoppage_reason_4');
            //if no. of days is entered and reason is not selected
            if ($(this).val() != 0) {
                if (stoppage_4.options.selectedIndex == 0) {
                    alert("Please select the reason");
                    return;
                }
            }

        });

        //NO OF DAYS 5
        $("#no_days_5").blur(function () {
            //if total no. of days is not filled
            if ($("#f_total_no_days").val() == '') {
                if ($(this).val() != 0) {
                    alert("Please enter total no. of days first");
                    $("#f_total_no_days").focus();
                    return;
                }
            }

            var stoppage_5 = document.getElementById('stoppage_reason_5');
            //if no. of days is entered and reason is not selected
            if ($(this).val() != 0) {
                if (stoppage_5.options.selectedIndex == 0) {
                    alert("Please select the reason");
                    return;
                }
            }

        });

    },
    openWageCalculation: function (total_days) {
        //OPENCAST
        //opencase direct wage calculation with male-female value=0
        jQuery.validator.addMethod("openWageDirectZero", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Open_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Open_FEMALE_AVG_DIRECT").val());

            if (dir_male_wage == 0 && dir_female_wage == 0) {
                if (value != 0)
                    return false;
                else
                    return true;
            }
            else
            {
                return true;
            }

        }, "Total wages for the month should be Rs.0"
                );
        // Opencast direct minimum wage calculation
        jQuery.validator.addMethod("openWageDirectMin", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Open_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Open_FEMALE_AVG_DIRECT").val());
            var total_dir_wage = value;
            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
            
            if (Number(dir_wage_avg) < 50) {
                $('#F_Open_WAGE_DIRECT').parent().next('.err_cv').text('Average daily wage is less than Rs.50');
                return true;
            }
            else {
                $('#F_Open_WAGE_DIRECT').parent().next('.err_cv').text('');
                return true;
            }

        }, "Average daily wage is less than Rs.50");

        // Opencast direct maximum wage calculation
        jQuery.validator.addMethod("openWageDirectMax", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Open_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Open_FEMALE_AVG_DIRECT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
			
			// Added by Pravin Bhakare on 21/7/18 to remove the condition for 2000 limit in F5 and H5
			var form_type = $.trim($(".form_sb_title").text());
			if(form_type == "FORM - F2" || form_type == "FORM - G2"){ 
				return true;
			}
			
            if (Number(dir_wage_avg) > 2000) {
                $('#F_Open_WAGE_DIRECT').parent().next('.err_cv').text('Average daily wage is greater than Rs.2000');
                return true;
            }
            else {
                return true;
            }

        }, "Average daily wage is greater than Rs.2000");

        // Opencast contract zero wage calculation
        jQuery.validator.addMethod("openWageContractZero", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Open_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Open_FEMALE_AVG_CONTRACT").val());
            if (dir_male_wage == 0 && dir_female_wage == 0)
            {
                if (value != 0)
                    return false;
                else
                    return true;
            }
            else
                return true;
        }, "Total wages for the month should be Rs.0");

        // Opencast contract minimum wage calculation
        jQuery.validator.addMethod("openWageContractMin", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Open_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Open_FEMALE_AVG_CONTRACT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
            if (Number(dir_wage_avg) < 50) {
                $('#F_Open_WAGE_CONTRACT').parent().next('.err_cv').text('Average daily wage is less than Rs.50');
                return true;
            }
            else {
                $('#F_Open_WAGE_CONTRACT').parent().next('.err_cv').text('');
                return true;
            }

        }, "Average daily wage is less than Rs.50");

        // Opencast contract maximum wage calculation
        jQuery.validator.addMethod("openWageContractMax", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Open_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Open_FEMALE_AVG_CONTRACT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
			
			// Added by Pravin Bhakare on 21/7/18 to remove the condition for 2000 limit in F5 and H5
			var form_type = $.trim($(".form_sb_title").text());
			if(form_type == "FORM - F2" || form_type == "FORM - G2"){ 
				return true;
			}
			
            var dir_wage_avg = total_dir_wage / temp;
            if (Number(dir_wage_avg) > 2000) {
                $('#F_Open_WAGE_CONTRACT').parent().next('.err_cv').text('Average daily wage is greater than Rs.2000');
                return true;
            }
            else {
                return true;
            }

        }, "Average daily wage is greater than Rs.2000"); 
    },
    belowWageCalculation: function (total_days) {

        // Below direct zero wage calculation
        jQuery.validator.addMethod("belowWageDirectZero", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Below_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Below_FEMALE_AVG_DIRECT").val());
            if (dir_male_wage == 0 && dir_female_wage == 0)
            {
                if (value != 0)
                    return false;
                else
                    return true;
            }
            else
                return true;
        }, "Total wages for the month should be Rs.0");

        // Below direct minimum wage calculation
        jQuery.validator.addMethod("belowWageDirectMin", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Below_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Below_FEMALE_AVG_DIRECT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
            if (Number(dir_wage_avg) < 50) {
                $('#F_Below_WAGE_DIRECT').parent().next('.err_cv').text('Average daily wage is less than Rs.50');
                return true;
            }
            else {
                $('#F_Below_WAGE_DIRECT').parent().next('.err_cv').text('');
                return true;
            }

        }, "Average daily wage is less than Rs.50");

        // Below direct maximum wage calculation
        jQuery.validator.addMethod("belowWageDirectMax", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Below_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Below_FEMALE_AVG_DIRECT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
			
			// Added by Pravin Bhakare on 21/7/18 to remove the condition for 2000 limit in F5 and H5
			var form_type = $.trim($(".form_sb_title").text());
			if(form_type == "FORM - F2" || form_type == "FORM - G2"){ 
				return true;
			}
			
            if (Number(dir_wage_avg) > 2000) {
                $('#F_Below_WAGE_DIRECT').parent().next('.err_cv').text('Average daily wage is greater than Rs.2000');
                return true;
            }
            else {
                return true;
            }

        }, "Average daily wage is greater than Rs.2000");

        // Below contract zero wage calculation
        jQuery.validator.addMethod("belowWageContractZero", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Below_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Below_FEMALE_AVG_CONTRACT").val());
            if (dir_male_wage == 0 && dir_female_wage == 0)
            {
                if (value != 0)
                    return false;
                else
                    return true;
            }
            else
                return true;
        }, "Total wages for the month should be Rs.0");

        // Below contract minimum wage calculation
        jQuery.validator.addMethod("belowWageContractMin", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Below_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Below_FEMALE_AVG_CONTRACT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;

            if (Number(dir_wage_avg) < 50) {
                $('#F_Below_WAGE_CONTRACT').parent().next('.err_cv').text('Average daily wage is less than Rs.50');
                return false;
            }
            else {
                $('#F_Below_WAGE_CONTRACT').parent().next('.err_cv').text('');
                return true;
            }

        }, "Average daily wage is less than Rs.50");

        // Below contract maximum wage calculation
        jQuery.validator.addMethod("belowWageContractMax", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Below_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Below_FEMALE_AVG_CONTRACT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
			
			// Added by Pravin Bhakare on 21/7/18 to remove the condition for 2000 limit in F5 and H5
			var form_type = $.trim($(".form_sb_title").text());
			if(form_type == "FORM - F2" || form_type == "FORM - G2"){ 
				return true;
			}
			
            if (Number(dir_wage_avg) > 2000) {
                $('#F_Below_WAGE_CONTRACT').parent().next('.err_cv').text('Average daily wage is greater than Rs.2000');
                return true;
            }
            else {
                return true;
            }

        }, "Average daily wage is greater than Rs.2000");

    },
    aboveWageCalculation: function (total_days) {

        // Above direct zero wage calculation
        jQuery.validator.addMethod("aboveWageDirectZero", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Above_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Above_FEMALE_AVG_DIRECT").val());
            if (dir_male_wage == 0 && dir_female_wage == 0)
            {
                if (value != 0)
                    return false;
                else
                    return true;
            }
            else
                return true;
        }, "Total wages for the month should be Rs.0");

        // Above direct minimum wage calculation
        jQuery.validator.addMethod("aboveWageDirectMin", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Above_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Above_FEMALE_AVG_DIRECT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
            if (Number(dir_wage_avg) < 50) {
                $('#F_Above_WAGE_DIRECT').parent().next('.err_cv').text('Average daily wage is less than Rs.50');
                return true;
            }
            else {
                $('#F_Above_WAGE_DIRECT').parent().next('.err_cv').text('');
                return true;
            }

        }, "Average daily wage is less than Rs.50");

        // Opencast direct maximum wage calculation
        jQuery.validator.addMethod("aboveWageDirectMax", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Above_MALE_AVG_DIRECT").val());
            var dir_female_wage = parseFloat($("#F_Above_FEMALE_AVG_DIRECT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
			
			// Added by Pravin Bhakare on 21/7/18 to remove the condition for 2000 limit in F5 and H5
			var form_type = $.trim($(".form_sb_title").text());
			if(form_type == "FORM - F2" || form_type == "FORM - G2"){ 
				return true;
			}
			
            var dir_wage_avg = total_dir_wage / temp;
            if (Number(dir_wage_avg) > 2000) {
                $('#F_Above_WAGE_DIRECT').parent().next('.err_cv').text('Average daily wage is greater than Rs.2000');
                return true;
            }
            else {
                return true;
            }

        }, "Average daily wage is greater than Rs.2000");


        // Above contract zero wage calculation
        jQuery.validator.addMethod("aboveWageContractZero", function (value, element) {

            var dir_male_wage = parseFloat($("#F_Above_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Above_FEMALE_AVG_CONTRACT").val());
            if (dir_male_wage == 0 && dir_female_wage == 0)
            {
                if (value != 0)
                    return false;
                else
                    return true;
            }
            else
                return true;
        }, "Total wages for the month should be Rs.0");

        // Above contract minimum wage calculation
        jQuery.validator.addMethod("aboveWageContractMin", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Above_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Above_FEMALE_AVG_CONTRACT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
            if (Number(dir_wage_avg) < 50) {
                $('#F_Above_WAGE_CONTRACT').parent().next('.err_cv').text('Average daily wage is less than Rs.50');
                return true;
            }
            else {
                $('#F_Above_WAGE_CONTRACT').parent().next('.err_cv').text('');
                return true;
            }

        }, "Average daily wage is less than Rs.50");

        // Above contract maximum wage calculation
        jQuery.validator.addMethod("aboveWageContractMax", function (value, element) {
            var dir_male_wage = parseFloat($("#F_Above_MALE_AVG_CONTRACT").val());
            var dir_female_wage = parseFloat($("#F_Above_FEMALE_AVG_CONTRACT").val());
            var total_dir_wage = value;

            var temp = (dir_male_wage + dir_female_wage) * total_days;
            var dir_wage_avg = total_dir_wage / temp;
			
			// Added by Pravin Bhakare on 21/7/18 to remove the condition for 2000 limit in F5 and H5
			var form_type = $.trim($(".form_sb_title").text());
			if(form_type == "FORM - F2" || form_type == "FORM - G2"){ 
				return true;
			}
			
            if (Number(dir_wage_avg) > 2000) {
                $('#F_Above_WAGE_CONTRACT').parent().next('.err_cv').text('Average daily wage is greater than Rs.2000');
                return true;
            }
            else {
                return true;
            }

        }, "Average daily wage is greater than Rs.2000");

    },
    totalWageCalculation: function () {

        jQuery.validator.addMethod("checkDirectTotalMale", function (value, element) {

            var openMaleDirectChange = jQuery.trim($("#F_Open_MALE_AVG_DIRECT").val());
            var belowMaleDirectChange = jQuery.trim($("#F_Below_MALE_AVG_DIRECT").val());
            var aboveMaleDirectChange = jQuery.trim($("#F_Above_MALE_AVG_DIRECT").val());
            var directMaletotal = jQuery.trim($("#F_Open_TOTAL_MALE_DIRECT").val());
            var maleDirectTotal = parseFloat(openMaleDirectChange) + parseFloat(belowMaleDirectChange) + parseFloat(aboveMaleDirectChange);
            maleDirectTotal = Math.round(maleDirectTotal * 10) / 10;

            if (parseFloat(maleDirectTotal) != parseFloat(value))
                return false;
            else
                return true;
        }, "Direct male total is not equal to calculated total");


        jQuery.validator.addMethod("checkDirectTotalFemale", function (value, element) {
            var openFemaleDirectChange = jQuery.trim($("#F_Open_FEMALE_AVG_DIRECT").val());
            var belowFemaleDirectChange = jQuery.trim($("#F_Below_FEMALE_AVG_DIRECT").val());
            var aboveFemaleDirectChange = jQuery.trim($("#F_Above_FEMALE_AVG_DIRECT").val());
            var directFemaletotal = jQuery.trim($("#F_Open_TOTAL_FEMALE_DIRECT").val());

            var FemaleDirectTotal = parseFloat(openFemaleDirectChange) + parseFloat(belowFemaleDirectChange) + parseFloat(aboveFemaleDirectChange);
            FemaleDirectTotal = Math.round(FemaleDirectTotal * 10) / 10;
            if (FemaleDirectTotal != value)
            {
                return false;
            }
            else
                return true;
        }, "Direct female total is not equal to calculated total");

        jQuery.validator.addMethod("checkcontractTotalMale", function (value, element) {
            var openMaleContractChange = jQuery.trim($("#F_Open_MALE_AVG_CONTRACT").val());
            var belowMaleContractChange = jQuery.trim($("#F_Below_MALE_AVG_CONTRACT").val());
            var aboveMaleContractChange = jQuery.trim($("#F_Above_MALE_AVG_CONTRACT").val());
            var contractMaletotal = jQuery.trim($("#F_Open_TOTAL_MALE_CONTRACT").val());

            var maleContractTotal = parseFloat(openMaleContractChange) + parseFloat(belowMaleContractChange) + parseFloat(aboveMaleContractChange);
            maleContractTotal = Math.round(maleContractTotal * 10) / 10;
            if (maleContractTotal != value)
            {
                return false;
            }
            else
                return true;
        }, "Contract male total is not equal to calculated total");


        //        var femaleContractTotal = parseFloat(openFemaleContract) + parseFloat(belowFemaleContract) + parseFloat(aboveFemaleContract);
        //        if(isNaN(femaleContractTotal)){
        //            var total4 = 0;
        //        }else{
        //            var total4 = femaleContractTotal;
        //        }
        //$("input#F_Open_TOTAL_FEMALE_CONTRACT").val(total4);

        jQuery.validator.addMethod("checkcontractTotalFemale", function (value, element) {
            var openFemaleContractChange = jQuery.trim($("#F_Open_FEMALE_AVG_CONTRACT").val());
            var belowFemaleContractChange = jQuery.trim($("#F_Below_FEMALE_AVG_CONTRACT").val());
            var aboveFemaleContractChange = jQuery.trim($("#F_Above_FEMALE_AVG_CONTRACT").val());
            var contractFemaletotal = jQuery.trim($("#F_Open_TOTAL_FEMALE_CONTRACT").val());

            var femaleContractTotal = parseFloat(openFemaleContractChange) + parseFloat(belowFemaleContractChange) + parseFloat(aboveFemaleContractChange);
            femaleContractTotal = Math.round(femaleContractTotal * 10) / 10;
            if (femaleContractTotal != value)
            {
                return false;
            }
            else
                return true;
        }, "Contract female total is not equal to calculated total");

        jQuery.validator.addMethod("recheckTotalDirectWage", function (value, element) {
            var openMaleDirectChange = jQuery.trim($("#F_Open_WAGE_DIRECT").val());
            var belowMaleDirectChange = jQuery.trim($("#F_Below_WAGE_DIRECT").val());
            var aboveMaleDirectChange = jQuery.trim($("#F_Above_WAGE_DIRECT").val());
            var directMaletotal = jQuery.trim($("#F_Open_TOTAL_DIRECT").val());
            var maleDirectTotal = parseFloat(openMaleDirectChange) + parseFloat(belowMaleDirectChange) + parseFloat(aboveMaleDirectChange);

            if (maleDirectTotal != value)
            {
                return false;
            } else
                return true;
        }, "Direct total wages for the month  is not equal to calculated total");

        jQuery.validator.addMethod("recheckTotalContractWage", function (value, element) {
            var openMaleContractChange = jQuery.trim($("#F_Open_WAGE_CONTRACT").val());
            var belowMaleContractChange = jQuery.trim($("#F_Below_WAGE_CONTRACT").val());
            var aboveMaleContractChange = jQuery.trim($("#F_Above_WAGE_CONTRACT").val());
            var contractMaletotal = jQuery.trim($("#F_Open_TOTAL_CONTRACT").val());
            var maleContractTotal = parseFloat(openMaleContractChange) + parseFloat(belowMaleContractChange) + parseFloat(aboveMaleContractChange);
            if (maleContractTotal != value)
            {
                return false;
            } else
                return true;
        }, "Contract total wages for the month  is not equal to calculated total");
    },
    totalSalary: function (total_days) {

        jQuery.validator.addMethod("techEmployees", function (value) {
            if (value == '')
                return false;
            else
                return true;
        }, "Please enter the total staffs.");

        // Total salaries paid to technical and supervisory staff
        jQuery.validator.addMethod("totalMinSalary", function (value, element) {
            var total_staffs = parseInt($("#F_Open_TOTAL_TECH_EMP").val());
            var tech_sup_salary = value;

            var avg = tech_sup_salary / (total_staffs * total_days);
            if (avg < 100)
                return false;
            else
                return true;

        }, "Average daily salary is less than Rs.100");


        /*    jQuery.validator.addMethod("totalMaxSalary", function( value, element ) {
         var total_staffs = parseInt($("#F_Open_TOTAL_TECH_EMP").val());
         var tech_sup_salary = value;
         
         var avg = tech_sup_salary/(total_staffs * total_days);
         if(avg > 2500)
         return false;
         else
         return true;
         
         }, "Average daily salary is greater than Rs.2500");
         
         
         jQuery.validator.addMethod("zeroMaxSalary",function(value,element){
         var total_staffs = parseInt($("#F_Open_TOTAL_TECH_EMP").val());
         var tech_sup_salary = value;
         
         if(total_staffs==0&&tech_sup_salary==0)
         {
         return true;
         }
         else
         {
         return false;
         }
         },"Average daily salary should be Rs.0");
         */

    },
    romStocks: function () {
        var ow_old = $("#f_open_oc_rom").val();
        var dw_old = $("#f_open_dw_rom").val();

        $("#f_open_oc_rom").blur(function () {
            if ($("#f_open_oc_rom").val() != ow_old) {
                if (ow_old != '')
                    alert("Please send an e-mail to IBM clarifying this variation");
            }
        });

        $("#f_open_dw_rom").blur(function () {
            if ($("#f_open_dw_rom").val() != dw_old) {
                if (dw_old != '')
                    alert("Please send an e-mail to IBM clarifying this variation");
            }
        });

        //comes in F-2
        var fu_old = $("#f_open_ug_rom").val();
        $("#f_open_ug_rom").blur(function () {
            if ($("#f_open_ug_rom").val() != fu_old) {
                if (fu_old != '')
                    alert("Please send an e-mail to IBM clarifying this variation");
            }
        });

        jQuery.validator.addMethod("closingStockROM", function (value, element) {
            var id = element.id;
            var tmp = id.substr(7, 2);
            var opening = $("#f_open_" + tmp + "_rom").val();
            var prod = $("#f_prod_" + tmp + "_rom").val();

            opening = parseFloat(opening);
            prod = parseFloat(prod);
            value = parseFloat(value);
            var temp = Utilities.roundOff3(opening + prod);
            if (value > temp)
                return false;
            else
                return true;

        }, "Closing stock should be less than or equal to Opening + Production");
        
    },
    gradeOpeningStock: function () {
        var _this = this;
        _this.x = false;

        var grades = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
        var old_val = new Array();

        window.onload = function () {
            for (var k = 0; k < grades.length; k++) {
                old_val[k] = $("#F_" + grades[k] + "_OPENING_STOCK").val();
            }

            for (var j = 0; j < grades.length; j++) {
                $("#F_" + grades[j] + "_OPENING_STOCK").keypress(function (e) {
                    if (e.keyCode != 9) {
                        var id = $(this).attr('id');
                        var selected_grade = id.charAt(2);

                        for (var i = 0; i < grades.length; i++) {
                            if (selected_grade == grades[i]) {
                                old_val = $("#F_" + grades[i] + "_OPENING_STOCK").val();
                                if (old_val == '')
                                    _this.old_val = null;
                            }
                        }

                        if (old_val[j] != "") {
                            if (_this.old_val != null)
                                _this.x = true;
                        }
                    }
                });

                $("#F_" + grades[j] + "_OPENING_STOCK").blur(function () {
                    if (_this.x == true)
                        alert("Please send an e-mail to IBM clarifying this variation");
                    _this.x = false;
                    _this.old_val = 'x';
                });
            }
        }
    },
    gradesRoundOff: function () {
        //round off to 3 decimals points for all fields and 2 decimal points to ex-mine price
        var types = new Array('OPENING_STOCK', 'PRODUCTION', 'DESPATCHES', 'CLOSING_STOCK');
        for (var i = 0; i < types.length; i++) {
            var grades = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
            for (var j = 0; j < grades.length; j++) {
                $("#F_" + grades[j] + "_" + types[i]).blur(function () {
                    var temp = new Number($(this).val());
                    $(this).val((temp).toFixed(3));
                });
            }
        }

        for (var j = 0; j < grades.length; j++) {
            $("#F_" + grades[j] + "_PMV").blur(function () {
                var temp = new Number($(this).val());
                $(this).val((temp).toFixed(2));
            });
        }
    },
    gradeExMine: function () {


        /*var grade = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
         for(var j = 0; j<grade.length; j++){
         $("#F_"+grade[j]+"_PMV").blur(function(){
         alert($("#F_"+grade[j]+"_PMV").val())
         
         var production = document.getElementById("F_"+grade[j]+"_PRODUCTION");
         console.log("F_"+grade[j]+"_PRODUCTION");
         if(production.value != ''){
         console.log(production.value)
         if(production.value > 0){
         alert("Ex-mine price should be greater than 0");
         production.value = "";
         }
         }
         });
         }
         
         jQuery.validator.addMethod("exMine", function( value, element ) {
         var temp = element.id;
         var prod_id = temp.replace("PMV", "PRODUCTION");  
         var production = document.getElementById(prod_id);
         if(production.value > 0 && value == '')
         return false;
         else
         return true;
         
         }, "xx");*/

        jQuery.validator.addMethod("checkDispatches", function (value, element) {
            var open = $('#F_A_OPENING_STOCK').val();
            var prod = $('#F_A_PRODUCTION').val();
            var dis = value;
            if (dis >= (open + prod))
                return false;
            else
                return true;
        }, "Dispatches should be less than than the total of Opening Stock & Production");
    },
    deductionDetails: function () {
        /*remarks becomes mandatory if value is entered
         jQuery.validator.addMethod("transportRemark", function( value, element ) {
         var transport_cost = $("#F_TRANS_COST").val();
         if(transport_cost != '' && value == '')
         return false;
         else
         return true;
         }, "Please enter the remarks");*/

        var deductions = new Array('F_TRANS_COST', 'F_LOADING_CHARGES', 'F_RAILWAY_FREIGHT', 'F_PORT_HANDLING', 'F_SAMPLING_COST', 'F_PLOT_RENT', 'F_OTHER_COST', 'F_TOTAL_PROD');
        for (var j = 0; j < deductions.length; j++) {
            $("#" + deductions[j]).blur(function () {
                //alert($(this).val());
                var result = /^[0-9]*$/i.test($(this).val());
                if (result == false)
                    return false;
                //        var temp = new Number ($(this).val());
                //        $(this).val((temp).toFixed(2));
            });
        }



        jQuery.validator.addMethod("roundOff1", function (value, element) {
            var temp = new Number(value);
            // alert(temp);
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
    despatchCheck: function () {

        $("#F_B_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_B_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_B_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_B_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });

        $("#F_A_DESPATCHES").blur(function () {
            //alert("dispatch blur");
            var opening_stock = new Number(jQuery.trim($("#F_A_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_A_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_A_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);

            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });

        $("#F_C_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_C_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_C_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_C_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });


        $("#F_D_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_D_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_D_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_D_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });


        $("#F_E_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_E_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_E_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_E_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });



        $("#F_F_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_F_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_F_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_F_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });


        $("#F_G_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_G_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_G_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_G_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });


        $("#F_H_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_H_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_H_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_H_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });

        $("#F_I_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_I_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_I_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_I_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });


        $("#F_J_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_J_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_J_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_J_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });


        $("#F_K_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_K_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_K_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_K_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });



        $("#F_L_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_L_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_L_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_L_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });


        $("#F_M_DESPATCHES").blur(function () {
            var opening_stock = new Number(jQuery.trim($("#F_M_OPENING_STOCK").val()));
            var production = new Number(jQuery.trim($("#F_M_PRODUCTION").val()));
            var tmp_despatch = jQuery.trim($("#F_M_DESPATCHES").val());
            var despatch = new Number(tmp_despatch);
            var tot = new Number(opening_stock + production);
            tot = Math.round(tot * 1000) / 1000;
            if (tot < despatch) {
                $(this).val('0.000');
                alert("Despatch should be less than the total of Opening Stock & Production");
            }
        });
    },
    gradePriceCheck: function () {

        //first: If production is 0, ex-mine price can be 0
        jQuery.validator.addMethod("nullPrice", function (value, element) {
            var id = element.id
            var grade = id.charAt(2);

            var prod = $("#F_" + grade + "_PRODUCTION").val();
            var production = parseFloat(prod);

            if (value != 0)
                return true;

            if (value == 0 && production == 0)
                return true;
            else
                return false;

        }, "Please enter the ex-mine price");


        //second: If production is not equal to 0 or null, ex-mine price should be > 0
        jQuery.validator.addMethod("notNullPrice", function (value, element) {
            var id = element.id
            var grade = id.charAt(2);

            var prod = $("#F_" + grade + "_PRODUCTION").val();
            var production = parseFloat(prod);

            if (value != 0)
                return true;

            if (value == 0 && production != 0)
                return false;
            else
                return true;

        }, "Please enter the ex-mine price");


        //third: If lower grade price is higher than the higher grade price - alert a msg
        //written on respective form functions below
    },
    exMineCheck: function () {
        /*$("#F_B_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_A_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         $("#F_C_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_B_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         $("#F_D_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_C_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         $("#F_E_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_D_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         $("#F_F_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_E_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         //no need this check with the next group values
         //    $("#F_G_PMV").blur(function(){
         //      var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_F_PMV").val()));
         //      if(prev_ex_mine_price > $(this).val()){
         //        var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         //        if(is_confirm == false)
         //          $(this).val('');
         //      }
         //    });
         
         $("#F_H_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_G_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         $("#F_I_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_H_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         $("#F_J_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_I_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         $("#F_K_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_J_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         
         $("#F_L_PMV").blur(function(){
         var prev_ex_mine_price = parseFloat(jQuery.trim($("#F_K_PMV").val()));
         if(prev_ex_mine_price > $(this).val()){
         var is_confirm = confirm("Ex-mine price is lesser than the previous entry. Continue?");
         if(is_confirm == false)
         $(this).val('');
         }
         });
         */

        //for concentrates this validation should not be implemented
    },
    /**
     * @author: UDAY SHANKAR SINGH
     * FUNCTION NOT IN USED ANY MORE AS I HAVE CREATED AS NEW COMMON FUNCTION IN F4ExMineCheck FOR BOTH
     * F1 AND F4 AND THIS FUNCTION CAN BE USED FOR OTHER grade_wise_production FORMS
     * SO WE CAN REMOVE IT LATER.
     **/
    F1ExMineCheck: function () {
        document.onready = function () {

            jQuery.validator.addMethod("lesserPrice", function (value, element) {

                if (parseFloat(value) == 0)
                    return true;

                var id = element.id
                var grade = id.charAt(2);

                //for lumps
                //take the current box grade index
                var lumps = new Array('A', 'B', 'C', 'D', 'E', 'F');
                for (var i = 0; i < lumps.length; i++) {
                    if (lumps[i] == grade)
                        var current_grade = i;
                }

                //collect all the previous grades
                var prev_values = new Array();
                for (var j = 0; j < current_grade; j++) {
                    var prev_grades = $('#F_' + lumps[j] + '_PMV').val();
                    prev_values.push(parseFloat(prev_grades));
                }

                //take all the previous lesser values
                var lesser_grades = new Array();
                for (var k = 0; k < prev_values.length; k++) {
                    if (parseFloat(value) <= prev_values[k]) {
                        lesser_grades.push(lumps[k]);
                    }
                }

                if (lesser_grades.length > 0)
                    alert("Ex-mine price is not more than lower grade's price");


                //for fines
                //take the current box grade index
                var fines = new Array('G', 'H', 'I', 'J', 'K', 'L');
                for (var i = 0; i < fines.length; i++) {
                    if (fines[i] == grade)
                        var current_fines_grade = i;
                }

                //collect all the previous grades
                var prev_fines_values = new Array();
                for (var j = 0; j < current_fines_grade; j++) {
                    var prev_fines_grades = $('#F_' + fines[j] + '_PMV').val();
                    prev_fines_values.push(parseFloat(prev_fines_grades));
                }

                //take all the previous lesser values
                var lesser_fines_grades = new Array();
                for (var k = 0; k < prev_fines_values.length; k++) {
                    if (parseFloat(value) <= prev_fines_values[k]) {
                        lesser_fines_grades.push(fines[k]);
                    }
                }

                if (lesser_fines_grades.length > 0)
                    alert("Ex-mine price is not more than lower grade's price");

                return true;

            }, "");


            $("#F_G_PMV").blur(function () {
                var lump = parseFloat(document.getElementById('F_A_PMV').value);
                var fine = parseFloat(document.getElementById('F_G_PMV').value);

                if (lump == 0 || fine == 0)
                    return;

                if (lump <= fine)
                    alert("Lesser or same price reported for lumps");
            });

            $("#F_H_PMV").blur(function () {
                var lump = parseFloat(document.getElementById('F_B_PMV').value);
                var fine = parseFloat(document.getElementById('F_H_PMV').value);

                if (lump == 0 || fine == 0)
                    return;

                if (lump <= fine)
                    alert("Lesser or same price reported for lumps");
            });

            $("#F_I_PMV").blur(function () {
                var lump = parseFloat(document.getElementById('F_C_PMV').value);
                var fine = parseFloat(document.getElementById('F_I_PMV').value);

                if (lump == 0 || fine == 0)
                    return;

                if (lump <= fine)
                    alert("Lesser or same price reported for lumps");
            });

            $("#F_J_PMV").blur(function () {
                var lump = parseFloat(document.getElementById('F_D_PMV').value);
                var fine = parseFloat(document.getElementById('F_J_PMV').value);

                if (lump == 0 || fine == 0)
                    return;

                if (lump <= fine)
                    alert("Lesser or same price reported for lumps");
            });

            $("#F_K_PMV").blur(function () {
                var lump = parseFloat(document.getElementById('F_E_PMV').value);
                var fine = parseFloat(document.getElementById('F_K_PMV').value);

                if (lump == 0 || fine == 0)
                    return;

                if (lump <= fine)
                    alert("Lesser or same price reported for lumps");
            });

            $("#F_L_PMV").blur(function () {
                var lump = parseFloat(document.getElementById('F_F_PMV').value);
                var fine = parseFloat(document.getElementById('F_L_PMV').value);

                if (lump == 0 || fine == 0)
                    return;

                if (lump <= fine)
                    alert("Lesser or same price reported for lumps");
            });
        }
    },
    F4ExMineCheck: function (totalLumpAndFine) {

        $(document).ready(function () {
            //since the grades change for each form, the id also changes
            //we use this function for F4 form alone
            jQuery.validator.addMethod("lesserPrice", function (value, element) {

                if (parseFloat(value) == 0)
                    return true;

                var id = element.id
                var grade = id.charAt(2);

                var lumpCount = parseInt(totalLumpAndFine) / 2;
                var startRange = 65;
                var endRange = parseInt(startRange) + parseInt(lumpCount);
                var charCodeRange = {
                    start: startRange,
                    end: endRange
                }

                //collect all the previous grades
                var prev_values = new Array();
                var charArray = new Array();
                for (var cc = charCodeRange.start; cc < charCodeRange.end; cc++) {
                    var correspondingChar = String.fromCharCode(cc);
                    var prev_grades = $('#F_' + correspondingChar + '_PMV').val();
                    prev_values.push(parseFloat(prev_grades));
                    charArray.push(correspondingChar);
                }

                //take all the previous lesser values
                var currentElementIdChar = element.id.split("_")[1];
                var charIndex = $.inArray(currentElementIdChar, charArray);

                var errorStatus = 0;
                for (var k = 0; k < charIndex; k++) {
                    if (parseFloat(value) <= prev_values[k]) {
                        errorStatus = 1;
                    }
                }
                //CHECK FOR THE EROR STATUS AND THEN ALERT ACCORDINGLY
                if (errorStatus == 1)
                    alert("Ex-mine price is not more than lower grade's price");

                //for fines
                // AS NUMBER OF LUMPS ARE ALWAYS EQUAL TO THE NUMBER OF FINES
                var lumpCount = parseInt(totalLumpAndFine) / 2;
                var fineStartRange = parseInt(65) + parseInt(lumpCount);
                var fineEndRange = parseInt(fineStartRange) + parseInt(lumpCount);
                var fineCharCodeRange = {
                    start: fineStartRange,
                    end: fineEndRange
                }

                //collect all the previous grades
                var prev_fine_values = new Array();
                var fineCharArray = new Array();
                for (var cf = fineCharCodeRange.start; cf < fineCharCodeRange.end; cf++) {
                    var correspondingFineChar = String.fromCharCode(cf);
                    var prev_fine_grades = $('#F_' + correspondingFineChar + '_PMV').val();
                    prev_fine_values.push(parseFloat(prev_fine_grades));
                    fineCharArray.push(correspondingFineChar);
                }

                //take all the previous lesser values
                var currentFineElementIdChar = element.id.split("_")[1];
                var fineCharIndex = $.inArray(currentFineElementIdChar, fineCharArray);

                var fineErrorStatus = 0;
                for (var k = 0; k < fineCharIndex; k++) {
                    if (parseFloat(value) <= prev_fine_values[k]) {
                        fineErrorStatus = 1;
                    }
                }
                //CHECK FOR THE EROR STATUS AND THEN ALERT ACCORDINGLY
                if (fineErrorStatus == 1)
                    alert("Ex-mine price is not more than lower grade's price");
                return true;

            }, "");

            /*********/

            $(".pmvForProdCheck").focusout(function () {
                var elementIdChar = $(this).attr("id").split("-")[1];
                var elementAsciiCode = elementIdChar.charCodeAt(0); //GETTING ASCII CODE
                var lumpCount = parseInt(totalLumpAndFine) / 2;

                var compareElementAsciiCheck = parseInt(65) + parseInt(lumpCount);

                if (elementAsciiCode >= compareElementAsciiCheck) {
                    var compareElement = parseInt(elementAsciiCode) - parseInt(lumpCount);
                    var compareElementChar = String.fromCharCode(compareElement); // GETTING CHAR
                    var compareElementId = '#F_' + compareElementChar + '_PMV'
                    var currentElementValue = parseFloat($(this).val());
                    var compareElementValue = parseFloat($(compareElementId).val());
                    if (compareElementValue <= currentElementValue && compareElementValue != 0 && currentElementValue != 0) {
                        alert("Lesser or same price reported for lumps");
                    }

                }

            });
        });

    },
    ExMineCheckForOther: function (checkFormTypeForGrade) {

        $(document).ready(function () {
            if (checkFormTypeForGrade == 'F3') {
                totalLumpAndFine = 6;
            }
            else {
                var totalGradesEle = $(".productionForTot");
                var totalLumpAndFine = totalGradesEle.length;
            }
            //since the grades change for each form, the id also changes
            //we use this function for F4 form alone
            jQuery.validator.addMethod("lesserPrice", function (value, element) {
                if (parseFloat(value) == 0)
                    return true;

                var id = element.id
                var grade = id.charAt(2);

                var lumpCount = parseInt(totalLumpAndFine);
                //        var lumpCount = parseInt(totalLumpAndFine) / 2;
                var startRange = 65;
                var endRange = parseInt(startRange) + parseInt(lumpCount);
                var charCodeRange = {
                    start: startRange,
                    end: endRange
                }

                //collect all the previous grades
                var prev_values = new Array();
                var charArray = new Array();
                for (var cc = charCodeRange.start; cc < charCodeRange.end; cc++) {
                    var correspondingChar = String.fromCharCode(cc);
                    var prev_grades = $('#F_' + correspondingChar + '_PMV').val();
                    prev_values.push(parseFloat(prev_grades));
                    charArray.push(correspondingChar);
                }

                //take all the previous lesser values
                var currentElementIdChar = element.id.split("_")[1];
                var charIndex = $.inArray(currentElementIdChar, charArray);

                var errorStatus = 0;
                for (var k = 0; k < charIndex; k++) {
                    if (parseFloat(value) <= prev_values[k]) {
                        errorStatus = 1;
                    }
                }
                //CHECK FOR THE EROR STATUS AND THEN ALERT ACCORDINGLY
                if (errorStatus == 1) {
                    $(document).unbind("alert");
                    alert("Ex-mine price is not more than lower grade's price");
                }


                return true;

            }, "");

            /*********/

            //      $(".pmvForProdCheck").focusout(function() {
            //        var elementIdChar = $(this).attr("id").split("_")[1];
            //        var elementAsciiCode = elementIdChar.charCodeAt(0); //GETTING ASCII CODE
            //        var lumpCount = parseInt(totalLumpAndFine) / 2;
            //
            //        var compareElementAsciiCheck = parseInt(65) + parseInt(lumpCount);
            //
            //        if (elementAsciiCode >= compareElementAsciiCheck) {
            //          var compareElement = parseInt(elementAsciiCode) - parseInt(lumpCount);
            //          var compareElementChar = String.fromCharCode(compareElement); // GETTING CHAR
            //          var compareElementId = '#F_' + compareElementChar + '_PMV'
            //          var currentElementValue = parseFloat($(this).val());
            //          var compareElementValue = parseFloat($(compareElementId).val());
            //          if (compareElementValue <= currentElementValue) {
            //            alert("Lesser or same price reported for lumps");
            //          }
            //
            //        }
            //
            //      });
        });

    },
    deductionCheck: function () {






        jQuery.validator.addMethod("transCostCheck", function (value, element) {
            var trans_cost = document.getElementById("F_TRANS_COST");
            if (trans_cost.value > 0 && value == '')
                return false;
            else
                return true;
        }, "This field is required.");

        jQuery.validator.addMethod("railwayCostCheck", function (value, element) {
            var rail_cost = document.getElementById('F_RAILWAY_FREIGHT');

            if (rail_cost.value > 0 && value == "")
                return false;
            else
                return true;
        }, "This field is required.");

        jQuery.validator.addMethod("portCostCheck", function (value, element) {
            var port_cost = document.getElementById('F_PORT_HANDLING');

            if (port_cost.value > 0 && value == "")
                return false;
            else
                return true;
        }, "This field is required.");

        jQuery.validator.addMethod("otherCostCheck", function (value, element) {
            var other_cost = document.getElementById('F_OTHER_COST');

            if (other_cost.value > 0 && value == "")
                return false;
            else
                return true;
        }, "This field is required.");

        jQuery.validator.addMethod("checkDeductionTotal", function (value, element) {

            var deductionTotal = new Number(jQuery.trim($("#F_TRANS_COST").val())) +
                    new Number(jQuery.trim($("#F_LOADING_CHARGES").val())) +
                    new Number(jQuery.trim($("#F_RAILWAY_FREIGHT").val())) +
                    new Number(jQuery.trim($("#F_PORT_HANDLING").val())) +
                    new Number(jQuery.trim($("#F_SAMPLING_COST").val())) +
                    new Number(jQuery.trim($("#F_PLOT_RENT").val())) +
                    new Number(jQuery.trim($("#F_OTHER_COST").val()));

            var total = new Number(jQuery.trim($("#F_TOTAL_PROD").val()));

            deductionTotal = Math.round(deductionTotal * 100) / 100;

            //      alert("entered:"+total+", calculated:"+deductionTotal);
            if (deductionTotal != total)
                return false;
            else
                return true;
        }, "Total deduction doesn't match with calculated total.");

        //    transCostCheck(document.getElementById('F_TRANS_REMARK'));
        //    railwayCostCheck(document.getElementById('F_RAILWAY_REMARK'));
        //    portCostCheck(document.getElementById('F_PORT_REMARK'));
        //    otherCostCheck(document.getElementById('F_OTHER_REMARK'));

    },
    despatchGetUserByName: function (url) {

        this.autoCompleteWidget();

        $(".reg_name").catcomplete({
            source: url,
            select: function (event, ui) {
                var reg_no = ui.item.reg_no;

                var reg_name_id = $(this).attr('id');
                var row_no = reg_name_id.slice(13);

                $('#F_CLIENT_REG_NO' + row_no).val(reg_no);

            }
        });

    },
    despatchGetUserByRegNo: function (url) {
        $(".reg_no").catcomplete({
            source: url,
            select: function (event, ui) {
                var cons_name = ui.item.cons_name;

                var reg_no_id = $(this).attr('id');
                var row_no = reg_no_id.slice(15);

                $('#F_CLIENT_NAME' + row_no).val(cons_name);
            }
        });
    },
    saleCheck: function () {
        var selected_rows = new Array();

        $(".sale_check").change(function () {
            var hidden_sel_rows = $('#selected_rows');

            var row = $(this).val();

            if (selected_rows.in_array(row) == false)
                selected_rows.push(row);

            if ($(this).is(':checked') == false)
                selected_rows.removeByValue(row)

            hidden_sel_rows.val(selected_rows);

        });

    },
    finalSubmit: function (final_submit_url, redirect_url) {


        /***** Added magnetite,hematite arguments by saranya raj 18th April 2016 *******************/
        //disable

       Utilities.ajaxBlockUI();
        $.ajax({
            url: final_submit_url,
            success: function (resp) {

//alert('here');die();
                var response = $.trim(resp);
                //if there are no errors
                if (response == "" || response == null) {
                    window.location = redirect_url;
                    return;
                }

                //if not list out the errors
                var data = response.split('|');
                /*
                 var table = document.getElementById('final-submit-error');
                 $(table).empty();
                 var empty_tr = document.createElement('tr');
                 empty_tr.innerHTML = "&nbsp;";
                 table.appendChild(empty_tr);
                 var empty_tr = document.createElement('tr');
                 empty_tr.innerHTML = "&nbsp;";
                 table.appendChild(empty_tr);*/
                var finalSubmitArray = new Array();
                finalSubmitArray += "<tr> <td style='height:5px'>&nbsp</td></tr>";
                for (var i = 0; i < data.length; i++) {
                    finalSubmitArray += "<tr><td align='left' style='text-align:left; color:#f00'>" + data[i] + "</td></tr>";
                }
                $("#final-submit-error").html(finalSubmitArray);
            }
        });
    },
    F6GradewiseValidation: function () {



    },
    F6GradewiseTotalCalculation: function () {

        var _this = this;
        _this.x = false;

        var grade_arr = new Array('Crude', 'Incidental', 'WasteMica');
        var old_val = new Array();


        window.onload = function () {

            for (var k = 0; k < grade_arr.length; k++) {
                old_val[k] = $("#F_" + grade_arr[k] + "_OPEN_MINE").val();
                old_val[k + 3] = $("#F_" + grade_arr[k] + "_OPEN_DRESS").val();
                old_val[k + 6] = $("#F_" + grade_arr[k] + "_OPEN_OTHER").val();
                old_val[k + 9] = $("#F_" + grade_arr[k] + "_TOTAL_OPEN").val();
            }


            for (var j = 0; j < grade_arr.length; j++) {
                $("#F_" + grade_arr[j] + "_OPEN_MINE").keypress(function (e) {
                    if (e.keyCode != 9) {
                        var id = $(this).attr('id');
                        var selected_grade = id.charAt(2);

                        for (var i = 0; i < grade_arr.length; i++) {
                            if (selected_grade == grade_arr[i]) {
                                old_val = $("#F_" + grade_arr[i] + "_OPEN_MINE").val();
                                if (old_val == '')
                                    _this.old_val = null;
                            }
                        }

                        if (old_val[j] != "") {
                            if (_this.old_val != null)
                                _this.x = true;
                        }
                    }
                });
                $("#F_" + grade_arr[j] + "_OPEN_DRESS").keypress(function (e) {
                    if (e.keyCode != 9) {
                        var id = $(this).attr('id');
                        var selected_grade = id.charAt(2);

                        for (var i = 0; i < grade_arr.length; i++) {
                            if (selected_grade == grade_arr[i]) {
                                old_val = $("#F_" + grade_arr[i] + "_OPEN_DRESS").val();
                                if (old_val == '')
                                    _this.old_val = null;
                            }
                        }

                        if (old_val[j] != "") {
                            if (_this.old_val != null)
                                _this.x = true;
                        }
                    }
                });
                $("#F_" + grade_arr[j] + "_OPEN_OTHER").keypress(function (e) {
                    if (e.keyCode != 9) {
                        var id = $(this).attr('id');
                        var selected_grade = id.charAt(2);

                        for (var i = 0; i < grade_arr.length; i++) {
                            if (selected_grade == grade_arr[i]) {
                                old_val = $("#F_" + grade_arr[i] + "_OPEN_OTHER").val();
                                if (old_val == '')
                                    _this.old_val = null;
                            }
                        }

                        if (old_val[j] != "") {
                            if (_this.old_val != null)
                                _this.x = true;
                        }
                    }
                });
                $("#F_" + grade_arr[j] + "_TOTAL_OPEN").keypress(function (e) {
                    if (e.keyCode != 9) {
                        var id = $(this).attr('id');
                        var selected_grade = id.charAt(2);

                        for (var i = 0; i < grade_arr.length; i++) {
                            if (selected_grade == grade_arr[i]) {
                                old_val = $("#F_" + grade_arr[i] + "_TOTAL_OPEN").val();
                                if (old_val == '')
                                    _this.old_val = null;
                            }
                        }

                        if (old_val[j] != "") {
                            if (_this.old_val != null)
                                _this.x = true;
                        }
                    }
                });
                $("#F_" + grade_arr[j] + "_OPEN_MINE").blur(function () {
                    if (_this.x == true)
                        alert("Please send an e-mail to IBM clarifying this variation");
                    _this.x = false;
                    _this.old_val = 'x';
                });
                $("#F_" + grade_arr[j] + "_OPEN_DRESS").blur(function () {
                    if (_this.x == true)
                        alert("Please send an e-mail to IBM clarifying this variation");
                    _this.x = false;
                    _this.old_val = 'x';
                });
                $("#F_" + grade_arr[j] + "_OPEN_OTHER").blur(function () {
                    if (_this.x == true)
                        alert("Please send an e-mail to IBM clarifying this variation");
                    _this.x = false;
                    _this.old_val = 'x';
                });
                $("#F_" + grade_arr[j] + "_TOTAL_OPEN").blur(function () {
                    if (_this.x == true)
                        alert("Please send an e-mail to IBM clarifying this variation");
                    _this.x = false;
                    _this.old_val = 'x';
                });
            }
        }

        jQuery.validator.addMethod("checkOpenCrudeTotal", function (value, element) {
            var crude_open_mine = document.getElementById("F_Crude_OPEN_MINE");
            var crude_dress_mine = document.getElementById("F_Crude_OPEN_DRESS");
            var crude_other_mine = document.getElementById("F_Crude_OPEN_OTHER");
            var crude_total_open = document.getElementById("F_Crude_TOTAL_OPEN");

            var data1 = parseFloat(crude_open_mine.value);
            var data2 = parseFloat(crude_dress_mine.value);
            var data3 = parseFloat(crude_other_mine.value);
            if (isNaN(data3)) {
                data3 = 0;
            }

            //      var open_total = parseFloat(crude_open_mine.value) + parseFloat(crude_dress_mine.value) + parseFloat(crude_other_mine.value);
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/
            var open_total = Utilities.roundOff3(data1 + data2 + data3);
            if (open_total == crude_total_open.value)
                return true;
            else
                return false;
        }, "Total opening stock doesn't match with calculated total");

        jQuery.validator.addMethod("checkOpenIncidentalTotal", function (value, element) {
            var incidental_open_mine = document.getElementById("F_Incidental_OPEN_MINE");
            var incidental_dress_mine = document.getElementById("F_Incidental_OPEN_DRESS");
            var incidental_other_mine = document.getElementById("F_Incidental_OPEN_OTHER");
            var incidental_total_open = document.getElementById("F_Incidental_TOTAL_OPEN");

            //      var open_total = parseFloat(incidental_open_mine.value)+parseFloat(incidental_dress_mine.value)
            //      +parseFloat(incidental_other_mine.value);

            var data1 = parseFloat(incidental_open_mine.value);
            var data2 = parseFloat(incidental_dress_mine.value);
            var data3 = parseFloat(incidental_other_mine.value);
            if (isNaN(data3)) {
                data3 = 0;
            }
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            //            var open_total = data1 + data2 + data3;
            var open_total = Utilities.roundOff3(data1 + data2 + data3);


            if (open_total == incidental_total_open.value)
                return true;
            else
                return false;
        }, "Total opening stock doesn't match with calculated total");

        jQuery.validator.addMethod("checkOpenWasteTotal", function (value, element) {
            var waste_open_mine = document.getElementById("F_WasteMica_OPEN_MINE");
            var waste_dress_mine = document.getElementById("F_WasteMica_OPEN_DRESS");
            var waste_other_mine = document.getElementById("F_WasteMica_OPEN_OTHER");
            var waste_total_open = document.getElementById("F_WasteMica_TOTAL_OPEN");

            //      var open_total = parseFloat(waste_open_mine.value)+parseFloat(waste_dress_mine.value)
            //      +parseFloat(waste_other_mine.value);

            var data1 = parseFloat(waste_open_mine.value);
            var data2 = parseFloat(waste_dress_mine.value);
            var data3 = parseFloat(waste_other_mine.value);
            if (isNaN(data3)) {
                data3 = 0;
            }
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            //            var open_total = data1 + data2 + data3;
            var open_total = Utilities.roundOff3(data1 + data2 + data3);

            if (open_total == waste_total_open.value)
                return true;
            else
                return false;
        }, "Total opening stock doesn't match with calculated total");




        jQuery.validator.addMethod("checkProdCrudeTotal", function (value, element) {
            var crude_open_mine = document.getElementById("F_Crude_PROD_UG");
            var crude_dress_mine = document.getElementById("F_Crude_PROD_OC");
            var crude_other_mine = document.getElementById("F_Crude_PROD_DW");
            var crude_total_open = document.getElementById("F_Crude_TOTAL_PROD");

            var open_total = parseFloat(crude_open_mine.value) + parseFloat(crude_dress_mine.value)
                    + parseFloat(crude_other_mine.value);
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == value)
                return true;
            else
                return false;
        }, "Total production stock doesn't match with calculated total");

        jQuery.validator.addMethod("checkProdIncidentalTotal", function (value, element) {
            var incidental_open_mine = document.getElementById("F_Incidental_PROD_UG");
            var incidental_dress_mine = document.getElementById("F_Incidental_PROD_OC");
            var incidental_other_mine = document.getElementById("F_Incidental_PROD_DW");
            var incidental_total_open = document.getElementById("F_Incidental_TOTAL_PROD");

            var open_total = parseFloat(incidental_open_mine.value) + parseFloat(incidental_dress_mine.value) + parseFloat(incidental_other_mine.value);
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == incidental_total_open.value)
                return true;
            else
                return false;
        }, "Total production stock doesn't match with calculated total");

        jQuery.validator.addMethod("checkProdWasteTotal", function (value, element) {
            var waste_open_mine = document.getElementById("F_WasteMica_PROD_UG");
            var waste_dress_mine = document.getElementById("F_WasteMica_PROD_OC");
            var waste_other_mine = document.getElementById("F_WasteMica_PROD_DW");
            var waste_total_open = document.getElementById("F_WasteMica_TOTAL_PROD");

            var open_total = parseFloat(waste_open_mine.value) + parseFloat(waste_dress_mine.value)
                    + parseFloat(waste_other_mine.value);
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == waste_total_open.value)
                return true;
            else
                return false;
        }, "Total production stock doesn't match with calculated total");





        jQuery.validator.addMethod("checkDespCrudeTotal", function (value, element) {
            var crude_dress_mine = document.getElementById("F_Crude_DESP_DRESS");
            var crude_sale_mine = document.getElementById("F_Crude_DESP_SALE");
            var crude_total_desp = document.getElementById("F_Crude_TOTAL_DESP");

            var open_total = parseFloat(crude_dress_mine.value) + parseFloat(crude_sale_mine.value);
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == crude_total_desp.value)
                return true;
            else
                return false;
        }, "Total despatches doesn't match with calculated total");

        jQuery.validator.addMethod("checkProdDespTotal", function (value, element) {
            var incidental_dress_mine = document.getElementById("F_Incidental_DESP_DRESS");
            var incidental_sale_mine = document.getElementById("F_Incidental_DESP_SALE");
            var incidental_total_desp = document.getElementById("F_Incidental_TOTAL_DESP");

            var open_total = parseFloat(incidental_dress_mine.value) + parseFloat(incidental_sale_mine.value);
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == incidental_total_desp.value)
                return true;
            else
                return false;
        }, "Total despatches doesn't match with calculated total");

        jQuery.validator.addMethod("checkDespWasteTotal", function (value, element) {
            var waste_dress_mine = document.getElementById("F_WasteMica_DESP_DRESS");
            var waste_sale_mine = document.getElementById("F_WasteMica_DESP_SALE");
            var waste_total_desp = document.getElementById("F_WasteMica_TOTAL_DESP");

            var open_total = parseFloat(waste_dress_mine.value) + parseFloat(waste_sale_mine.value);
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == waste_total_desp.value)
                return true;
            else
                return false;
        }, "Total despatches doesn't match with calculated total");




        jQuery.validator.addMethod("checkCloseCrudeTotal", function (value, element) {
            var crude_open_mine = document.getElementById("F_Crude_CLOS_MINE");
            var crude_dress_mine = document.getElementById("F_Crude_CLOS_DRESS");
            var crude_other_mine = document.getElementById("F_Crude_CLOS_OTHER");
            var crude_total_open = document.getElementById("F_Crude_TOTAL_CLOS");

            //      var open_total = parseFloat(crude_open_mine.value)+parseFloat(crude_dress_mine.value)
            //      +parseFloat(crude_other_mine.value);
            var data1 = parseFloat(crude_open_mine.value);
            var data2 = parseFloat(crude_dress_mine.value);
            var data3 = parseFloat(crude_other_mine.value);
            if (isNaN(data3)) {
                data3 = 0;
            }

            var open_total = data1 + data2 + data3;
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == crude_total_open.value)
                return true;
            else
                return false;
        }, "Total closing stock doesn't match with calculated total");

        jQuery.validator.addMethod("checkCloseIncidentalTotal", function (value, element) {
            var incidental_open_mine = document.getElementById("F_Incidental_CLOS_MINE");
            var incidental_dress_mine = document.getElementById("F_Incidental_CLOS_DRESS");
            var incidental_other_mine = document.getElementById("F_Incidental_CLOS_OTHER");
            var incidental_total_open = document.getElementById("F_Incidental_TOTAL_CLOS");

            //      var open_total = parseFloat(incidental_open_mine.value)+parseFloat(incidental_dress_mine.value)
            //      +parseFloat(incidental_other_mine.value);

            var data1 = parseFloat(incidental_open_mine.value);
            var data2 = parseFloat(incidental_dress_mine.value);
            var data3 = parseFloat(incidental_other_mine.value);
            if (isNaN(data3)) {
                data3 = 0;
            }

            var open_total = data1 + data2 + data3;
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == incidental_total_open.value)
                return true;
            else
                return false;
        }, "Total closing stock doesn't match with calculated total");

        jQuery.validator.addMethod("checkCloseWasteTotal", function (value, element) {
            var waste_open_mine = document.getElementById("F_WasteMica_CLOS_MINE");
            var waste_dress_mine = document.getElementById("F_WasteMica_CLOS_DRESS");
            var waste_other_mine = document.getElementById("F_WasteMica_CLOS_OTHER");
            var waste_total_open = document.getElementById("F_WasteMica_TOTAL_CLOS");

            //      var open_total = parseFloat(waste_open_mine.value)+parseFloat(waste_dress_mine.value)
            //      +parseFloat(waste_other_mine.value);
            var data1 = parseFloat(waste_open_mine.value);
            var data2 = parseFloat(waste_dress_mine.value);
            var data3 = parseFloat(waste_other_mine.value);
            if (isNaN(data3)) {
                data3 = 0;
            }

            var open_total = data1 + data2 + data3;
            /**
             * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
             * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 13th Feb 2014
             * 
             **/

            open_total = Utilities.roundOff3(open_total);

            if (open_total == waste_total_open.value)
                return true;
            else
                return false;
        }, "Total closing stock doesn't match with calculated total");

    },
    F6getOpeningStock: function () {

        if (document.getElementById('F_Crude_TOTAL_OPEN').value == '' && document.getElementById('F_Incidental_TOTAL_OPEN').value == '' && document.getElementById('F_WasteMica_TOTAL_OPEN').value == '')
        {
            document.getElementById('F_Crude_OPEN_MINE').value = $('#crude_clos_mine').val();
            document.getElementById('F_Incidental_OPEN_MINE').value = $('#incidental_clos_mine').val();
            document.getElementById('F_WasteMica_OPEN_MINE').value = $('#waste_clos_mine').val();
            document.getElementById('F_Crude_OPEN_DRESS').value = $('#crude_clos_dress').val();
            document.getElementById('F_Incidental_OPEN_DRESS').value = $('#incidental_clos_dress').val();
            document.getElementById('F_WasteMica_OPEN_DRESS').value = $('#waste_clos_dress').val();
            document.getElementById('F_Crude_OPEN_OTHER').value = $('#crude_clos_other').val();
            document.getElementById('F_Incidental_OPEN_OTHER').value = $('#incidental_clos_other').val();
            document.getElementById('F_WasteMica_OPEN_OTHER').value = $('#waste_clos_other').val();
            document.getElementById('F_Crude_TOTAL_OPEN').value = $('#crude_total_clos').val();
            document.getElementById('F_Incidental_TOTAL_OPEN').value = $('#incidental_total_clos').val();
            document.getElementById('F_WasteMica_TOTAL_OPEN').value = $('#waste_total_clos').val();
            document.getElementById('F_Crude_OPEN_OTHER_SPEC').value = $('#spec_clos').val();

        }
    },
    averageDailyCheckTotal: function (total_days) {
        /*
         var openDirectMale=document.getElementById('F_Open_MALE_AVG_DIRECT').value;
         var belowDirectMale=document.getElementById('F_Below_MALE_AVG_DIRECT').value;
         var aboveDirectMale=document.getElementById('F_Above_MALE_AVG_DIRECT').value;
         var totalDirectMale=document.getElementById('F_Open_TOTAL_MALE_DIRECT').value;
         var calTotalDirectMale=parseFloat(openDirectMale)+parseFloat(belowDirectMale)+parseFloat(aboveDirectMale);
         calTotalDirectMale=Math.round(calTotalDirectMale*10)/10;
         
         
         
         var openDirectFemale=document.getElementById('F_Open_FEMALE_AVG_DIRECT').value;
         var belowDirectFemale=document.getElementById('F_Below_FEMALE_AVG_DIRECT').value;
         var aboveDirectFemale=document.getElementById('F_Above_FEMALE_AVG_DIRECT').value;
         var totalDirectFemale=document.getElementById('F_Open_TOTAL_FEMALE_DIRECT').value;
         var calTotalDirectFemale=parseFloat(openDirectFemale)+parseFloat(belowDirectFemale)+parseFloat(aboveDirectFemale);
         calTotalDirectFemale=Math.round(calTotalDirectFemale*10)/10;
         
         var openContractMale=document.getElementById('F_Open_MALE_AVG_CONTRACT').value;
         var belowContractMale=document.getElementById('F_Below_MALE_AVG_CONTRACT').value;
         var aboveContractMale=document.getElementById('F_Above_MALE_AVG_CONTRACT').value;
         var totalContractMale=document.getElementById('F_Open_TOTAL_MALE_CONTRACT').value;
         var calTotalContractMale=parseFloat(openContractMale)+parseFloat(belowContractMale)+parseFloat(aboveContractMale);
         calTotalContractMale=Math.round(calTotalContractMale*10)/10;
         
         var openContractFemale=document.getElementById('F_Open_FEMALE_AVG_CONTRACT').value;
         var belowContractFemale=document.getElementById('F_Below_FEMALE_AVG_CONTRACT').value;
         var aboveContractFemale=document.getElementById('F_Above_FEMALE_AVG_CONTRACT').value;
         var totalContractFemale=document.getElementById('F_Open_TOTAL_FEMALE_CONTRACT').value;
         var calTotalContractFemale=parseFloat(openContractFemale)+parseFloat(belowContractFemale)+parseFloat(aboveContractFemale);
         calTotalContractFemale=Math.round(calTotalContractFemale*10)/10;
         
         var openDirectWage=document.getElementById('F_Open_WAGE_DIRECT').value;
         var belowDirectWage=document.getElementById('F_Below_WAGE_DIRECT').value;
         var aboveDirectWage=document.getElementById('F_Above_WAGE_DIRECT').value;
         var totalDirectWage=document.getElementById('F_Open_TOTAL_DIRECT').value;
         var calTotalDirectWage=parseFloat(openDirectWage)+parseFloat(belowDirectWage)+parseFloat(aboveDirectWage);
         calTotalDirectWage=Math.round(calTotalDirectWage*10)/10;
         
         var openContractWage=document.getElementById('F_Open_WAGE_CONTRACT').value;
         var belowContractWage=document.getElementById('F_Below_WAGE_CONTRACT').value;
         var aboveContractWage=document.getElementById('F_Above_WAGE_CONTRACT').value;
         var totalContractWage=document.getElementById('F_Open_TOTAL_CONTRACT').value;
         var calTotalContractWage=parseFloat(openContractWage)+parseFloat(belowContractWage)+parseFloat(aboveContractWage);
         calTotalContractWage=Math.round(calTotalContractWage*10)/10;
         */
        var totalEmp = document.getElementById('F_Open_TOTAL_TECH_EMP').value;
        var totalSal = document.getElementById('F_Open_TOTAL_SALARIES').value;
        var avgTotalMinSal = parseFloat(totalSal) / 100;
        var avgTotalMaxSal = parseFloat(totalSal) / 2500;
        var avgSal = totalEmp * total_days;

        /*
         if(totalDirectMale==''||totalDirectFemale==''||totalContractMale==''||totalContractFemale==''
         ||totalDirectWage==''||totalContractWage=='')
         {
         alert("Please enter total wages for the month");
         document.getElementById('F_Open_TOTAL_MALE_DIRECT').focus();
         return true;
         }
         else
         {
         if(totalDirectMale!=calTotalDirectMale||totalDirectFemale!=calTotalDirectFemale||totalContractMale
         !=calTotalContractMale||totalContractFemale!=calTotalContractFemale
         ||totalDirectWage!=calTotalDirectWage||totalContractWage!=calTotalContractWage){
         alert("Total wages for the month  is not equal to calculated total");
         document.getElementById('F_Open_TOTAL_MALE_DIRECT').focus();
         return true;
         }*/

        if (document.getElementById('F_Open_TOTAL_TECH_EMP').value == '')
        {
            alert("Please enter the total staffs.");
            return true;
        }
        if (document.getElementById('F_Open_TOTAL_SALARIES').value == '')
        {
            alert("Please enter salary.");
            return true;
        }
        if (avgTotalMaxSal > avgSal)
        {
            alert("Average daily salary of technical and supervisory staff is more than Rs. 2500");
            return true;
        }
        if (avgTotalMinSal < avgSal)
        {
            alert("Average daily salary of technical and supervisory staff is less than Rs. 100");
            return true;
        }
        else
        {
            return true;
        }
    },
    checkSalesDispatches: function () {

        //    var quantity = $(".f_quant");
        //    var sale_value = $(".s_value");
        //    var exp_quantity = $(".e_quant");
        //    var fob = $(".fob");
        //    
        //    for(var i=0; i<quantity.length; i++){
        //      var quant = $(quantity[i]).val();
        //      var is_num = /^\s*\d+\s*$/.test(quant);
        //      
        //      if(is_num == false)
        //        alert('Quantity should be an integer')
        //      
        //      if(is_num == false && quant != ''){
        //        alert('Quantity should be integer')
        //        return false;
        //      }
        //      
        //      var sale = $(sale_value[i]).val();
        //      var is_int = /^[0-9].+$/.test(sale);
        //      if(is_int == false && sale != ''){
        //        alert('Sale value should be integer')
        //        return false;
        //      }
        //      
        //      var exp_quant = $(exp_quantity[i]).val();
        //      var is_number = /^[0-9].+$/.test(exp_quant);
        //      if(exp_quant != ""){
        //        if(is_number == false){
        //          alert('Export quantity should be integer')
        //          return false;
        //        }
        //      }
        //      
        //      var exp_fob = $(fob[i]).val();
        //      var is_integer = /^[0-9].+$/.test(exp_fob);
        //      if(is_integer == false && exp_fob != ''){
        //        alert('FOB value should be integer')
        //        return false;
        //      }
        //    }

        return true;
    },
    checkRomClosingStock: function () {

        //call the estimated production validation on onsubmit action
        this.estProdF1Validation();

        var openingOpen = document.getElementById('f_open_oc_rom').value;
        var productionOpen = document.getElementById('f_prod_oc_rom').value;
        var closingOpen = parseFloat(document.getElementById('f_clos_oc_rom').value);

        var openingDump = document.getElementById('f_open_dw_rom').value;
        var productionDump = document.getElementById('f_prod_dw_rom').value;
        var closingDump = parseFloat(document.getElementById('f_clos_dw_rom').value);

        var actCloseOpen = Utilities.roundOff3(parseFloat(openingOpen) + parseFloat(productionOpen));
        var actCloseDump = Utilities.roundOff3(parseFloat(openingDump) + parseFloat(productionDump));

        if (closingOpen > actCloseOpen) {
            alert("Closing stock should be less than or equal to Opening + Production.");
            document.getElementById('f_clos_oc_rom').focus();
            return false;
        } else if (closingDump > actCloseDump) {
            alert("Closing stock should be less than or equal to Opening + Production.");
            document.getElementById('f_clos_dw_rom').focus();
            return false;
        } else {
            return true;
        }

    },
    natureofdispatch: function (id, count) {

        var nature = document.getElementById(id).value;

        if (nature != '') {
            if (nature == 'EXPORT') {
                document.getElementById('F_CLIENT_REG_NO' + count).disabled = true;
                document.getElementById('F_CLIENT_NAME' + count).disabled = true;
                document.getElementById('F_QUANTITY' + count).disabled = true;
                document.getElementById('F_SALE_VALUE' + count).disabled = true;
                document.getElementById('F_EXPO_COUNTRY' + count).disabled = false;
                document.getElementById('F_EXPO_QUANTITY' + count).disabled = false;
                document.getElementById('F_EXPO_FOB' + count).disabled = false;

                //clear the other entered fields
                document.getElementById('F_CLIENT_REG_NO' + count).value = '';
                document.getElementById('F_CLIENT_NAME' + count).value = '';
                document.getElementById('F_QUANTITY' + count).value = '';
                document.getElementById('F_SALE_VALUE' + count).value = '';
            } else {
                document.getElementById('F_CLIENT_REG_NO' + count).disabled = false;
                document.getElementById('F_CLIENT_NAME' + count).disabled = false;
                document.getElementById('F_QUANTITY' + count).disabled = false;
                document.getElementById('F_SALE_VALUE' + count).disabled = false;
                document.getElementById('F_EXPO_COUNTRY' + count).disabled = true;
                document.getElementById('F_EXPO_QUANTITY' + count).disabled = true;
                document.getElementById('F_EXPO_FOB' + count).disabled = true;

                //clear the other entered fields
                document.getElementById('F_EXPO_COUNTRY' + count).value = '';
                document.getElementById('F_EXPO_QUANTITY' + count).value = '';
                document.getElementById('F_EXPO_FOB' + count).value = '';
            }
        }
    },
    natureofdispatchF7: function (id, count) {
        var nature = document.getElementById(id).value;

        if (nature != '') {
            if (nature == 'EXPORT') {
                document.getElementById('F_CLIENT_REG_NO' + count).disabled = true;
                document.getElementById('F_CLIENT_NAME' + count).disabled = true;
                document.getElementById('F_INT_QTY' + count).disabled = true;
                document.getElementById('F_INT_VALUE' + count).disabled = true;
                document.getElementById('F_EXPO_COUNTRY' + count).disabled = false;
                document.getElementById('F_EXP_QTY' + count).disabled = false;
                document.getElementById('F_EXP_VALUE' + count).disabled = false;

                //clear the other entered fields
                document.getElementById('F_CLIENT_REG_NO' + count).value = '';
                document.getElementById('F_CLIENT_NAME' + count).value = '';
                document.getElementById('F_INT_QTY' + count).value = '';
                document.getElementById('F_INT_VALUE' + count).value = '';
            } else {
                document.getElementById('F_CLIENT_REG_NO' + count).disabled = false;
                document.getElementById('F_CLIENT_NAME' + count).disabled = false;
                document.getElementById('F_INT_QTY' + count).disabled = false;
                document.getElementById('F_INT_VALUE' + count).disabled = false;
                document.getElementById('F_EXPO_COUNTRY' + count).disabled = true;
                document.getElementById('F_EXP_QTY' + count).disabled = true;
                document.getElementById('F_EXP_VALUE' + count).disabled = true;

                //clear the other entered fields
                document.getElementById('F_EXPO_COUNTRY' + count).value = '';
                document.getElementById('F_EXP_QTY' + count).value = '';
                document.getElementById('F_EXP_VALUE' + count).value = '';
            }
        }
    },
    salesAndDispatchValidation: function () {
        $(document).ready(function () {
            $("#frmSalesDespatches").validate({
                onkeyup: false,
                onsubmit: true
            });

            //============================FOR F.O.B FIELD===============================
            
            $.validator.addMethod("roundOff2", function (value, element) {
                var temp = new Number(value);
                element.value = (temp).toFixed(2);
                return true;
            }, "");
            $.validator.addMethod("roundOff3", function (value, element) {
                var temp = new Number(value);
                element.value = (temp).toFixed(3);
                return true;
            }, "");

            $.validator.addMethod("cRequired", $.validator.methods.required,
                    $.validator.format("Field is required."));
            $.validator.addMethod("cNumber", $.validator.methods.number,
                    "Please enter numeric digits only");
            $.validator.addMethod("cMaxlength", $.validator.methods.maxlength,
                    $.validator.format("Max. length allowed is 13,2 digits"));
            $.validator.addMethod("cMax", $.validator.methods.max,
                    $.validator.format("Max. entered value length must be less then or equal to 13,2 digits"));

            $.validator.addClassRules("fob", {
                cRequired: true,
                cNumber: true,
                cMaxlength: 16,
                cMax: 9999999999999.99,
                roundOff2: true,
                expoSale: true
            });

            //=============================FOR SALE VALUE===============================
            $.validator.addClassRules("s_value", {
                cRequired: true,
                cNumber: true,
                cMaxlength: 16,
                cMax: 9999999999999.99,
                roundOff2: true,
                expoSale: true
            });

            //========================FOR EXPORT QUANTITY FIELD=========================
            $.validator.addMethod("bRequired", $.validator.methods.required,
                    $.validator.format("Field is required."));
            $.validator.addMethod("bNumber", $.validator.methods.number,
                    "Please enter numeric digits only");
            $.validator.addMethod("bMaxlength", $.validator.methods.maxlength,
                    $.validator.format("Max. length allowed is 13,3 digits"));
            $.validator.addMethod("bMax", $.validator.methods.max,
                    $.validator.format("Max. entered value length must be less then or equal to 13,3 digits"));

            $.validator.addClassRules("e_quant", {
                bRequired: true,
                bNumber: true,
                bMaxlength: 17,
                bMax: 9999999999999.999,
                roundOff3: true,
                domesticSale: true
            });

            //========================FOR DOMESTIC QUANTITY FIELD=======================
            $.validator.addClassRules("f_quant", {
                bRequired: true,
                bNumber: true,
                bMaxlength: 17,
                bMax: 9999999999999.999,
                roundOff3: true,
                domesticSale: true
            });

            $.validator.addClassRules("g_code", {
                bRequired: true
            });

            $.validator.addClassRules("c_type", {
                bRequired: true
            });
        });


        jQuery.validator.addMethod("domesticSale", function (value, element) {
            var id = element.id;

            //var tmp = id.substr(12,2);
            var tmp = id.substr(id.length - 1);
            var matches = tmp.match(/\d+/g);
            if (matches == null) {
                tmp = "";
            }

            var domQuant = parseFloat($("#F_QUANTITY" + tmp).val());
            var sale = $("#F_SALE_VALUE" + tmp);
            var domSale = sale.val();
            var grade = $("#F_GRADE_CODE" + tmp).val();
            var saleVal = $("#salesGradeArr" + grade).val();
            var natDis = $("#F_CLIENT_TYPE" + tmp).val();
            if (natDis != 'EXPORT' && natDis != 'CAPTIVE CONSUMPTION') {
                if (parseFloat(domQuant) > parseFloat(domSale)) {
                    alert("Sale value less than quantity. Sale value should be Sale Price x Quantity Sold");
                    return false;
                }
				
				if (parseFloat(domQuant) < 1) {
					
                    if ((parseFloat(domQuant) * parseFloat(saleVal)) > parseFloat(domSale)) {
                    alert("Sale value is less than ex-mine price");
                    return false;
                }
                }
				else {
				
                if (parseFloat(saleVal)  > parseFloat(domSale)) {
                    alert("Sale value is less than ex-mine price");
                    return false;
                }
				}
            }
            return true;
        }, "");

        jQuery.validator.addMethod("expoSale", function (value, element) {
            var id = element.id;
            //var tmp = id.substr(10,2);
            var tmp = id.substr(id.length - 1);
            var matches = tmp.match(/\d+/g);
            if (matches == null) {
                tmp = "";
            }

            var expoQuant = parseFloat($("#ta-expo_quantity-" + tmp).val());
            // var grade = $('#ta-grade_code-' + tmp).val();
            var saleVal = '';
            var expoSale = parseFloat($("#ta-expo_fob-" + tmp).val());
            var natDis = $('#ta-client_type-' + tmp).val();
            if (natDis == 'EXPORT') {
                if (parseFloat(expoQuant) > parseFloat(expoSale)) {
                    alert("F.O.B value less than quantity. Sale value should be Sale Price x Quantity Sold");
                    return false;
                }
                if (parseFloat(saleVal) >= parseFloat(expoSale))
                {
                    alert("F.O.B value is less than ex-mine price");
                    return false;
                }
            }
            return true;
        }, "");

    },
    salesAndDispatchF7Validation: function () {
        $(document).ready(function () {
            $("#frmSalesDespatches").validate({
                rules: {
                    "F[CLIENT_NAME]": {
                        required: true
                    },
                    "F[INT_QTY]": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY2": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY3": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY4": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY5": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY6": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY7": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY8": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY9": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY10": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY11": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY12": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY13": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY14": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY15": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY16": {
                        required: true,
                        number: true,
                        maxlength: 12
                    },
                    "F_INT_QTY17": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY18": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY19": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY20": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY21": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY22": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY23": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY24": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F_INT_QTY25": {
                        required: true,
                        number: true,
                        maxlength: 12,
                        min: 0
                    },
                    "F[INT_VALUE]": {
                        required: true,
                        number: true,
                        roundOff2: true,
                        domesticSale: true,
                        maxlength: 14,
                        min: 0
                    },
                    "F_INT_VALUE2": {
                        required: true,
                        number: true,
                        roundOff2: true,
                        domesticSale: true,
                        maxlength: 14,
                        min: 0

                    },
                    "F_INT_VALUE3": {
                        required: true,
                        number: true,
                        roundOff2: true,
                        domesticSale: true,
                        maxlength: 14,
                        min: 0
                    },
                    "F_INT_VALUE4": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE5": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE6": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE7": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE8": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE9": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE10": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE11": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE12": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE13": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE14": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE15": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE16": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE17": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE18": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE19": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE20": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE21": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE22": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE23": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE24": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F_INT_VALUE25": {
                        required: true,
                        number: true,
                        maxlength: 14,
                        roundOff2: true,
                        domesticSale: true,
                        min: 0
                    },
                    "F[EXP_QTY]": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY2": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY3": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY4": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY5": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY6": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY7": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY8": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY9": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY10": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY11": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY12": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY13": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY14": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY15": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY16": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY17": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY18": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY19": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY20": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY21": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY22": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY23": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY24": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F_EXP_QTY25": {
                        required: true,
                        number: true,
                        maxlength: 13,
                        roundOff3: true,
                        min: 0
                    },
                    "F[EXP_VALUE]": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE2": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE3": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE4": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE5": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE6": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE7": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE8": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE9": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE10": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE11": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE12": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE13": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE14": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE15": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE16": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE17": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE18": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE19": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE20": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE21": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE22": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE23": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE24": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    },
                    "F_EXP_VALUE25": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        roundOff2: true,
                        expoSale: true
                    }
                },
                errorElement: "span",
                onkeyup: false,
                messages: {
                    "F[INT_QTY]": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY2": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY3": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY4": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY5": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY6": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY7": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY8": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY9": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY10": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY11": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY12": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY13": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY14": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY15": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY16": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY17": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY18": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY19": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY20": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY21": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY22": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY23": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY24": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F_INT_QTY25": {
                        required: "Please enter Quantity.",
                        number: "Quantity should be integer."
                    },
                    "F[INT_VALUE]": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE2": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE3": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE4": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE5": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE6": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE7": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE8": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE9": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE10": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE11": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE12": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE13": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE14": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE15": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE16": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE17": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE18": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE19": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE20": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE21": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE22": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE23": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE24": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F_INT_VALUE25": {
                        required: "Please enter Sale value.",
                        number: "Sale value should be integer."
                    },
                    "F[EXP_QTY]": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY2": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY3": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY4": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY5": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY6": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY7": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY8": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY9": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY10": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY11": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY12": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY13": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY14": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY15": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY16": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY17": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY18": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY19": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY20": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY21": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY22": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY23": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY24": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F_EXP_QTY25": {
                        required: "Please enter Export Quantity.",
                        number: "Export Quantity should be integer."
                    },
                    "F[EXP_VALUE]": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE2": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE3": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE4": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE5": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE6": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE7": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE8": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE9": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE10": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE11": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE12": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE13": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE14": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE15": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE16": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE17": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE18": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE19": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE20": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE21": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE22": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE23": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE24": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    },
                    "F_EXP_VALUE25": {
                        required: "Please enter FOB Value.",
                        number: "FOB Value should be integer."
                    }
                }
            });
        });


        jQuery.validator.addMethod("domesticSale", function (value, element) {

            var id = element.id;
            var tmp = id.substr(11, 2);

            var domQuant = document.getElementById('F_INT_QTY' + tmp).value;
            var sale = document.getElementById('F_INT_VALUE' + tmp);
            var domSale = (sale.value);

            var natDis = document.getElementById('F_CLIENT_TYPE' + tmp).value;
            if (natDis != 'EXPORT') {
                if (domQuant > domSale) {
                    alert("Sale value is less than quantity. ");
                    document.getElementById('F_INT_VALUE' + tmp).value = "";
                    return true;
                } else {
                    return true;
                }
            }
        }, "");

        jQuery.validator.addMethod("expoSale", function (value, element) {
            var id = element.id;
            var tmp = id.substr(11, 2);
            var expoQuant = parseFloat($("#F_EXP_QTY" + tmp).val());
            var expoSale = parseFloat($("#F_EXP_VALUE" + tmp).val());
            var natDis = document.getElementById('F_CLIENT_TYPE' + tmp).value;

            if (natDis == 'EXPORT') {
                if (expoQuant > expoSale) {
                    //alert("F.O.B. value is less than quantity");
                    //document.getElementById('F_EXP_VALUE'+tmp).value="";
                    return true;
                }
                else {
                    return true;
                }
            }
        }, "");

    },
    pulCheck: function () {
        var selected_rows = new Array();

        $(".pul_check").change(function () {
            var hidden_sel_rows = $('#selected_rows');

            var row = $(this).val();

            if (selected_rows.in_array(row) == false)
                selected_rows.push(row);

            if ($(this).is(':checked') == false)
                selected_rows.removeByValue(row)

            hidden_sel_rows.val(selected_rows);
        });
    },
    romF7checkDespatches: function ()
    {
        jQuery.validator.addMethod("roundOff3", function (value, element) {
            var temp = new Number(value);
            element.value = (temp).toFixed(3);
            return true;
        }, "");

        jQuery.validator.addMethod("checkRoughDespatches", function (value, element) {
            var tmp = element.id;
            tmp = tmp.substr(0, 3);

            if (tmp == "F_R") {
                tmp = "F_Rough";
            }
            if (tmp == "F_P") {
                tmp = "F_Polished";
            }
            if (tmp == "F_I") {
                tmp = "F_Industrial";
            }
            if (tmp == "F_O") {
                tmp = "F_Other";
            }

            var open = parseFloat(document.getElementById(tmp + '_OPEN_TOT_QTY').value);
            var prodOpen = parseFloat(document.getElementById(tmp + '_PROD_OC_QTY').value);
            var prodUnder = parseFloat(document.getElementById(tmp + '_PROD_UG_QTY').value);
            var total = open + prodOpen + prodUnder;
            total = Math.round(total * 100) / 100;
            var despatch = parseFloat(document.getElementById(tmp + '_DESP_TOT_QTY').value);
            despatch = Math.round(despatch * 100) / 100;
            if (total >= despatch)
                return true;
            else {
                alert("Despatches should be less than or equal to opening+production");
                document.getElementById(tmp + '_DESP_TOT_QTY').value = "";
                return false;
            }
        }, "");


        jQuery.validator.addMethod("checkProdQuantTotal", function (value, element) {
            var tmp = element.id;
            tmp = tmp.substr(0, 3);

            if (tmp == "F_R") {
                tmp = "F_Rough";
            }
            if (tmp == "F_P") {
                tmp = "F_Polished";
            }
            if (tmp == "F_I") {
                tmp = "F_Industrial";
            }
            if (tmp == "F_O") {
                tmp = "F_Other";
            }
            var open = parseFloat(document.getElementById(tmp + '_PROD_OC_QTY').value);
            var under = parseFloat(document.getElementById(tmp + '_PROD_UG_QTY').value);
            var totalProd = parseFloat(document.getElementById(tmp + '_PROD_TOT_QTY').value);
            var total = open + under;
            total = Utilities.roundOff3(total);
            totalProd = Utilities.roundOff3(totalProd);

            if (total == totalProd)
                return true;
            else {
                alert("Production total quantity doesn't match with the calculated total");
                document.getElementById(tmp + '_PROD_TOT_QTY').value = "";
                return false;
            }
        }, "");



        jQuery.validator.addMethod("checkProdNoofStones", function (value, element) {
            var tmp = element.id;
            tmp = tmp.substr(0, 3);

            if (tmp == "F_R") {
                tmp = "F_Rough";
            }
            if (tmp == "F_P") {
                tmp = "F_Polished";
            }
            if (tmp == "F_I") {
                tmp = "F_Industrial";
            }
            if (tmp == "F_O") {
                tmp = "F_Other";
            }
            var open = parseFloat(document.getElementById(tmp + '_PROD_OC_NO').value);
            var under = parseFloat(document.getElementById(tmp + '_PROD_UG_NO').value);
            var totalProd = parseFloat(document.getElementById(tmp + '_PROD_TOT_NO').value);
            var total = open + under;
            //      total = Math.round(total * 100) / 100;
            //      totalProd = Math.round(totalProd * 100) / 100;
            //alert(open+"===="+under);
            total = Utilities.roundOff3(total);
            totalProd = Utilities.roundOff3(totalProd);
            if (total == totalProd)
                return true;
            else {
                alert("Production total of no. of stones doesn't match with the calculated total");
                document.getElementById(tmp + '_PROD_TOT_NO').value = "";
                return false;
            }
        }, "");



        jQuery.validator.addMethod("checkDespNoofStones", function (value, element) {
            var tmp = element.id;
            tmp = tmp.substr(0, 3);

            if (tmp == "F_R") {
                tmp = "F_Rough";
            }
            if (tmp == "F_P") {
                tmp = "F_Polished";
            }
            if (tmp == "F_I") {
                tmp = "F_Industrial";
            }
            if (tmp == "F_O") {
                tmp = "F_Other";
            }
            var open = parseFloat(document.getElementById(tmp + '_OPEN_TOT_NO').value);
            var prodOpen = parseFloat(document.getElementById(tmp + '_PROD_OC_NO').value);
            var prodUnder = parseFloat(document.getElementById(tmp + '_PROD_UG_NO').value);
            var total = open + prodOpen + prodUnder;
            total = Math.round(total * 100) / 100;
            var despatch = parseFloat(document.getElementById(tmp + '_DESP_TOT_NO').value);
            despatch = Math.round(despatch * 100) / 100;

            if (total >= despatch)
                return true;
            else {
                alert("Despatches should be less than or equal to opening+production");
                document.getElementById(tmp + '_DESP_TOT_NO').value = "";
                return false;
            }
        }, "");

        jQuery.validator.addMethod("checkClosNoofStones", function (value, element) {
            var tmp = element.id;
            tmp = tmp.substr(0, 3);

            if (tmp == "F_R") {
                tmp = "F_Rough";
            }
            if (tmp == "F_P") {
                tmp = "F_Polished";
            }
            if (tmp == "F_I") {
                tmp = "F_Industrial";
            }
            if (tmp == "F_O") {
                tmp = "F_Other";
            }
            var open = parseFloat(document.getElementById(tmp + '_OPEN_TOT_NO').value);
            var totProd = parseFloat(document.getElementById(tmp + '_PROD_TOT_NO').value);
            var desp = parseFloat(document.getElementById(tmp + '_DESP_TOT_NO').value);
            var entClos = parseFloat(document.getElementById(tmp + '_CLOS_TOT_NO').value);
            var calClos = open + totProd - desp;

            if (Utilities.roundOff3(entClos) == Utilities.roundOff3(calClos))
                return true;
            else
            {
                alert("Closing no. of stones doesn't match with the calculated total.");
                document.getElementById(tmp + '_CLOS_TOT_NO').value = "";
                return false;
            }
        }, "");


        jQuery.validator.addMethod("checkClosQty", function (value, element) {

            var tmp = element.id;
            tmp = tmp.substr(0, 3);

            if (tmp == "F_R") {
                tmp = "F_Rough";
            }
            if (tmp == "F_P") {
                tmp = "F_Polished";
            }
            if (tmp == "F_I") {
                tmp = "F_Industrial";
            }
            if (tmp == "F_O") {
                tmp = "F_Other";
            }
            var open = parseFloat(document.getElementById(tmp + '_OPEN_TOT_QTY').value);
            var totProd = parseFloat(document.getElementById(tmp + '_PROD_TOT_QTY').value);
            var desp = parseFloat(document.getElementById(tmp + '_DESP_TOT_QTY').value);
            var entClos = parseFloat(document.getElementById(tmp + '_CLOS_TOT_QTY').value);
            var calClos = open + totProd - desp;
            entClos = Math.round(entClos * 1000) / 1000;
            calClos = Math.round(calClos * 1000) / 1000;

            if (entClos == calClos)
                return true;
            else
            {
                alert("Closing quantity doesn't match with the calculated total.");
                document.getElementById(tmp + '_CLOS_TOT_QTY').value = "";
                return false;
            }
        }, "");
    },
    romF7checkROM: function () {
        jQuery.validator.addMethod("checkOcType", function (value) {
            //alert(value);
            if (value == 0)
                return false;
            else
                return true;
        }, "Please select type of unit.");

        jQuery.validator.addMethod("checkUgType", function (value) {
            if (value == 0)
                return false;
            else
                return true;
        }, "Please select type of unit.");
    },
    pulverisationValidation: function () {
        $("input:radio[name=is_pulverised]").click(function () {
            var value = $(this).val();
            //      event.preventDefault();
            if (value == 1) {
                $("#frmPulverisation").validate({
                    onkeyup: false,
                    onSubmit: true
                });

                //=========================FOR EX-FACTORY SALE VALUE========================
                jQuery.validator.addMethod("cRequired", jQuery.validator.methods.required,
                        "Field is required");
                jQuery.validator.addMethod("cNumber", jQuery.validator.methods.number,
                        "Please enter numeric digits only");
                jQuery.validator.addMethod("cMaxlength", jQuery.validator.methods.maxlength,
                        jQuery.format("Max. length allowed is 9,2 digits"));
                jQuery.validator.addMethod("cMax", jQuery.validator.methods.max,
                        jQuery.format("Max. entered value length must be less then or equal to 9,2 digits"));

                jQuery.validator.addClassRules("s_value", {
                    cRequired: true,
                    cNumber: true,
                    cMaxlength: 14,
                    cMax: 99999999999.99
                            //      roundOff2: true,
                            //      expoSale:true
                });
                //    
                //    
                jQuery.validator.addMethod("bRequired", jQuery.validator.methods.required,
                        "Field is required");
                jQuery.validator.addMethod("bNumber", jQuery.validator.methods.number,
                        "Please enter numeric digits only");
                jQuery.validator.addMethod("bMaxlength", jQuery.validator.methods.maxlength,
                        jQuery.format("Max. length allowed is 8,3 digits"));
                jQuery.validator.addMethod("bMax", jQuery.validator.methods.max,
                        jQuery.format("Max. entered value length must be less then or equal to 8,3 digits"));

                //==============================SOLD QUANTITY===============================
                $.validator.addClassRules("s_quant", {
                    bRequired: true,
                    bNumber: true,
                    bMaxlength: 13,
                    bMax: 999999999.999
                            //      roundOff3: true
                });
                //      
                //============================PRODUCED QUANTITY=============================
                $.validator.addClassRules("p_quant", {
                    bRequired: true,
                    bNumber: true,
                    bMaxlength: 13,
                    bMax: 999999999.999
                            //      roundOff3: true
                });

                //======================TOTAL QUANTITY OF MINERAL PULVERSIED================
                $.validator.addClassRules("pulverised", {
                    bRequired: true,
                    bNumber: true,
                    bMaxlength: 13,
                    bMax: 999999999.999
                            //      roundOff3: true
                });

                $.validator.addClassRules("tot_qty", {
                    bRequired: true,
                    bNumber: true,
                    bMaxlength: 13,
                    bMax: 999999999.999
                            //      roundOff3: true
                });
                //
                // for mesh size
                $.validator.addMethod("hRequired", $.validator.methods.required,
                        "Field is required");
                $.validator.addMethod("hMaxlength", $.validator.methods.maxlength,
                        $.validator.format("Max. length allowed is {0} digits"));

                $.validator.addClassRules("p_mesh_size", {
                    hRequired: true,
                    hMaxlength: 15
                });

                $.validator.addClassRules("s_mesh_size", {
                    hRequired: true,
                    hMaxlength: 15
                });
            }
            else if (value == 0) {
                //        $("#frmPulverisation").rules("remove");
                //        $("#frmPulverisation").validate({
                //          ignore: ".p_mesh_size"
                //        });
            }
        });
    },
    pulverisationPostValidation: function () {
        $("#frmPulverisation").submit(function (event) {

            var pulCheck = $('input[name=is_pulverised]:radio:checked').val();
            if (pulCheck == 1) {
                var inputField = $(".p_mesh_size");
                var elementCount = inputField.length;
                var pulErrorCount = 0;
                for (var i = 0; i < elementCount; i++) {
                    var elementId = inputField[i].id;
                    var elementValue = $("#" + elementId).val();
                    if (!elementValue) {
                        pulErrorCount++;
                    }
                }

                var inputField1 = $(".s_mesh_size");
                var elementCount1 = inputField1.length;
                var pulErrorCount1 = 0;
                for (var j = 0; j < elementCount1; j++) {
                    var elementId1 = inputField1[j].id;
                    var elementValue1 = $("#" + elementId1).val();
                    if (!elementValue1) {
                        pulErrorCount1++;
                    }
                }

                var inputField10 = $(".g_code");
                var elementCount10 = inputField10.length;
                var pulErrorCount10 = 0;
                for (var j1 = 0; j1 < elementCount10; j1++) {
                    var elementId10 = inputField10[j1].id;
                    var elementValue10 = $("#" + elementId10).val();
                    if (!elementValue10) {
                        pulErrorCount10++;
                    }
                }

                var inputField2 = $(".s_quant");
                var elementCount2 = inputField2.length;
                var pulErrorCount2 = 0;
                for (var l = 0; l < elementCount2; l++) {
                    var elementId2 = inputField2[l].id;
                    var elementValue2 = $("#" + elementId2).val();
                    if (!elementValue2) {
                        pulErrorCount2++;
                    }
                }

                var inputField3 = $(".p_quant");
                var elementCount3 = inputField3.length;
                var pulErrorCount3 = 0;
                for (var k = 0; k < elementCount3; k++) {
                    var elementId3 = inputField3[k].id;
                    var elementValue3 = $("#" + elementId3).val();
                    if (!elementValue3) {
                        pulErrorCount3++;
                    }
                }

                var inputField4 = $(".tot_qty");
                var elementCount4 = inputField4.length;
                var pulErrorCount4 = 0;
                for (var n = 0; n < elementCount4; n++) {
                    var elementId4 = inputField4[n].id;
                    var elementValue4 = $("#" + elementId4).val();
                    if (!elementValue4) {
                        pulErrorCount4++;
                    }
                }

                var inputField5 = $(".s_value");
                var elementCount5 = inputField5.length;
                var pulErrorCount5 = 0;
                for (var m = 0; m < elementCount5; m++) {
                    var elementId5 = inputField5[m].id;
                    var elementValue5 = $("#" + elementId5).val();
                    if (!elementValue5) {
                        pulErrorCount5++;
                    }
                }

                if (pulErrorCount10 > 0 || pulErrorCount > 0 || pulErrorCount1 > 0 || pulErrorCount2 > 0 || pulErrorCount3 > 0 || pulErrorCount4 > 0 || pulErrorCount5 > 0) {
                    alert("Please enter data in all open fields");
                    event.preventDefault();
                }
            }
        });
    },
    workingDetailsSaveNextValidation: function () {
        var _this = this;
        $("#frmWorkingDetails").submit(function (event) {
            var selectTags = document.getElementsByTagName('select');
            var count = 0;
            for (var i = 0; i < selectTags.length; i++) {
                var select_tag_value = $(selectTags[i]).val();
                if (select_tag_value != "") {
                    var element_id = selectTags[i].id;
                    var element_no = element_id.split("_");
                    var input_element_value = $("#F_NO_DAYS_" + element_no[3]).val();
                    //var input_element_value = $("#F_NO_DAYS" + element_no).val();
                    if (input_element_value == "")
                    {
                        count++;
                    }
                }
            }
            if (count > 0) {
                alert("Please enter no. of days for selected Reasons");
                event.preventDefault();
            }

            var days_check = _this.mineWorkingDaysNoCheck(count);
            var days_reason_check = _this.daysToReasonCheck();
            if (days_check == false || days_reason_check == false) {
                event.preventDefault();
            }
        });
    },
    mineWorkingDaysNoCheck: function (count) {

        var noofdays1 = $('#F_NO_DAYS_1').val();
        if (!noofdays1) {
            noofdays1 = 0;
        }
        var noofdays2 = $('#F_NO_DAYS_2').val();
        if (!noofdays2) {
            noofdays2 = 0;
        }
        var noofdays3 = $('#F_NO_DAYS_3').val();
        if (!noofdays3) {
            noofdays3 = 0;
        }
        var noofdays4 = $('#F_NO_DAYS_4').val();
        if (!noofdays4) {
            noofdays4 = 0;
        }
        var noofdays5 = $('#F_NO_DAYS_5').val();
        if (!noofdays5) {
            noofdays5 = 0;
        }

        var total_not_working_days = parseInt(noofdays1) + parseInt(noofdays2) + parseInt(noofdays3) + parseInt(noofdays4) + parseInt(noofdays5);

        var month = $('#curmonth').val();
        var year = $('#curyear').val();
        var days_in_month = parseInt(daysInMonth(month, year));

        var entered_working_days = $('#F_TOTAL_NO_DAYS').val();
        var not_working_days = parseInt(days_in_month) - parseInt(entered_working_days);


        if (entered_working_days == "") {
            alert("Please enter the number of days the mine worked.");
            $('#F_TOTAL_NO_DAYS').focus();
            return false;
        } else if (total_not_working_days != "") {
            if (total_not_working_days > not_working_days) {
                alert("Total of No. of days should not exceed total no of days mine not worked in the particular month.");
                $('#F_NO_DAYS_1').val("");
                $('#F_NO_DAYS_2').val("");
                $('#F_NO_DAYS_3').val("");
                $('#F_NO_DAYS_4').val("");
                $('#F_NO_DAYS_5').val("");
                return false;
            }
        }
        else if (entered_working_days < days_in_month) {
            if (noofdays1 == 0 && noofdays2 == 0 && noofdays3 == 0 && noofdays4 == 0 && noofdays5 == 0 && count == 0) {
                //        alert("Please select atleast one reason for not working");
                alert("No. of days mine worked is less than no. of days in the month. Reason(s) may be selected if work stoppage is due to specific reasons.");
            }
            return true;
        }
        else {
            return true;
        }
    },
    daysToReasonCheck: function () {
        var select_error = 0;
        for (var i = 1; i <= 5; i++) {
            if ($("#F_NO_DAYS_" + i).val() != "") {
                if ($("#F_STOPPAGE_SN_" + i).val() == "") {
                    select_error++;
                }
            }
        }
        if (select_error > 0) {
            alert("Please select the reason for entered days")
            return false;
        }
    },
    openStockFieldValidation: function () {

        $(".open_crude").focusout(function () {
            var open_identical_array = new Array('F_Crude_OPEN_MINE', 'F_Crude_OPEN_DRESS', 'F_Crude_OPEN_OTHER', 'F_Crude_TOTAL_OPEN');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }

            var value_1 = parseFloat(open_identical_value[0]);
            var value_2 = parseFloat(open_identical_value[1]);
            var value_3 = parseFloat(open_identical_value[2]);
            if (isNaN(value_3)) {
                value_3 = 0;
            }
            var value_4 = parseFloat(open_identical_value[3]);

            if (value_1 != "" && value_2 != "" && value_4 != "") {
                //      if(open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2]!= "" && open_identical_value[3] != ""){

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total opening stock doesn't match with calculated total");
                    $("#F_Crude_TOTAL_OPEN").val("");
                }

            }
        });

        $(".open_identical").focusout(function () {
            var open_identical_array = new Array('F_Incidental_OPEN_MINE', 'F_Incidental_OPEN_DRESS', 'F_Incidental_OPEN_OTHER', 'F_Incidental_TOTAL_OPEN');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }

            var value_1 = parseFloat(open_identical_value[0]);
            var value_2 = parseFloat(open_identical_value[1]);
            var value_3 = parseFloat(open_identical_value[2]);
            if (isNaN(value_3)) {
                value_3 = 0;
            }
            var value_4 = parseFloat(open_identical_value[3]);

            if (value_1 != "" && value_2 != "" && value_4 != "") {

                //      if(open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2]!= "" && open_identical_value[3] != ""){

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                //                if (value_4 && value_4 != (value_1 + value_2 + value_3)) {
                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total opening stock doesn't match with calculated total");
                    $("#F_Incidental_TOTAL_OPEN").val("");
                }

            }
        });

        $(".open_dress_mica").focusout(function () {
            var open_identical_array = new Array('F_WasteMica_OPEN_MINE', 'F_WasteMica_OPEN_DRESS', 'F_WasteMica_OPEN_OTHER', 'F_WasteMica_TOTAL_OPEN');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            //      if(open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2]!= "" && open_identical_value[3] != ""){
            var value_1 = parseFloat(open_identical_value[0]);
            var value_2 = parseFloat(open_identical_value[1]);
            var value_3 = parseFloat(open_identical_value[2]);
            if (isNaN(value_3)) {
                value_3 = 0;
            }
            var value_4 = parseFloat(open_identical_value[3]);

            if (value_1 != "" && value_2 != "" && value_4 != "") {

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                //                if (value_4 && value_4 != (value_1 + value_2 + value_3)) {
                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total opening stock doesn't match with calculated total");
                    $("#F_WasteMica_TOTAL_OPEN").val("");
                }

            }
        });

    },
    prodStockFieldValidation: function () {

        $(".prod_crude").focusout(function () {
            var open_identical_array = new Array('F_Crude_PROD_UG', 'F_Crude_PROD_OC', 'F_Crude_PROD_DW', 'F_Crude_TOTAL_PROD');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            if (open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2] != "" && open_identical_value[3] != "") {
                var value_1 = parseFloat(open_identical_value[0]);
                var value_2 = parseFloat(open_identical_value[1]);
                var value_3 = parseFloat(open_identical_value[2]);
                var value_4 = parseFloat(open_identical_value[3]);

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                //                if (value_4 && value_4 != (value_1 + value_2 + value_3)) {
                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total production stock doesn't match with calculated total");
                    $("#F_Crude_TOTAL_PROD").val("");
                }

            }
        });

        $(".prod_identical").focusout(function () {
            var open_identical_array = new Array('F_Incidental_PROD_UG', 'F_Incidental_PROD_OC', 'F_Incidental_PROD_DW', 'F_Incidental_TOTAL_PROD');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            if (open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2] != "" && open_identical_value[3] != "") {
                var value_1 = parseFloat(open_identical_value[0]);
                var value_2 = parseFloat(open_identical_value[1]);
                var value_3 = parseFloat(open_identical_value[2]);
                var value_4 = parseFloat(open_identical_value[3]);

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                //                if (value_4 && value_4 != (value_1 + value_2 + value_3)) {
                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total production stock doesn't match with calculated total");
                    $("#F_Incidental_TOTAL_PROD").val("");
                }

            }
        });

        $(".prod_dress_mica").focusout(function () {
            var open_identical_array = new Array('F_WasteMica_PROD_UG', 'F_WasteMica_PROD_OC', 'F_WasteMica_PROD_DW', 'F_WasteMica_TOTAL_PROD');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            if (open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2] != "" && open_identical_value[3] != "") {
                var value_1 = parseFloat(open_identical_value[0]);
                var value_2 = parseFloat(open_identical_value[1]);
                var value_3 = parseFloat(open_identical_value[2]);
                var value_4 = parseFloat(open_identical_value[3]);

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                //                if (value_4 && value_4 != (value_1 + value_2 + value_3)) {
                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total production stock doesn't match with calculated total");
                    $("#F_WasteMica_TOTAL_PROD").val("");
                }

            }
        });

    },
    dispatchesFieldValidation: function () {

        $(".dispatch_crude").focusout(function (event) {
            var open_identical_array = new Array('F_Crude_DESP_DRESS', 'F_Crude_DESP_SALE', 'F_Crude_TOTAL_DESP');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            if (open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2] != "") {
                var value_1 = parseFloat(open_identical_value[0]);
                var value_2 = parseFloat(open_identical_value[1]);
                var value_3 = parseFloat(open_identical_value[2]);

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                if (value_3 && value_3 != Utilities.roundOff3((value_1 + value_2))) {
                    alert("Total despatches doesn't match with calculated total");
                    $("#F_Crude_TOTAL_DESP").val("");
                }
                /**
                 * THE BELOW ELSE CONDITION IS ADDED FOR ADDING THE ONE MORE
                 * VALIDATION THAT IS MENTIONED IN THE SRS
                 * 
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 *
                 **/
                else if (value_3 && value_3 == Utilities.roundOff3((value_1 + value_2))) {
                    var corrOpenStTot = parseFloat($("#F_Crude_TOTAL_OPEN").val());
                    var corrProdStTot = parseFloat($("#F_Crude_TOTAL_PROD").val());
                    var openAndProdGrandTot = corrOpenStTot + corrProdStTot;
                    /**
                     * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                     * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                     * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                     * @version 13th Feb 2014
                     * 
                     **/

                    if (Utilities.roundOff3(openAndProdGrandTot) < value_3) {
                        alert("Total dispatch should not be more than Total production plus opening stock.");
                        $("#F_Crude_TOTAL_DESP").val("");
                        event.preventDefault();
                    }
                }

            }
        });

        $(".dispatch_incidental").focusout(function () {
            var open_identical_array = new Array('F_Incidental_DESP_DRESS', 'F_Incidental_DESP_SALE', 'F_Incidental_TOTAL_DESP');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            if (open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2] != "") {
                var value_1 = parseFloat(open_identical_value[0]);
                var value_2 = parseFloat(open_identical_value[1]);
                var value_3 = parseFloat(open_identical_value[2]);

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                if (value_3 && value_3 != Utilities.roundOff3((value_1 + value_2))) {
                    alert("Total despatches doesn't match with calculated total");
                    $("#F_Incidental_TOTAL_DESP").val("");
                }
                /**
                 * THE BELOW ELSE CONDITION IS ADDED FOR ADDING THE ONE MORE
                 * VALIDATION THAT IS MENTIONED IN THE SRS
                 * 
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 *
                 **/
                else if (value_3 && value_3 == Utilities.roundOff3((value_1 + value_2))) {
                    var corrOpenStTot = parseFloat($("#F_Incidental_TOTAL_OPEN").val());
                    var corrProdStTot = parseFloat($("#F_Incidental_TOTAL_PROD").val());
                    var openAndProdGrandTot = corrOpenStTot + corrProdStTot;
                    if (Utilities.roundOff3(openAndProdGrandTot) < value_3) {
                        alert("Total dispatch should not be more than Total production plus opening stock.");
                        $("#F_Incidental_TOTAL_DESP").val("");
                        event.preventDefault();
                    }
                }

            }
        });

        $(".dispatch_dress_mica").focusout(function () {
            var open_identical_array = new Array('F_WasteMica_DESP_DRESS', 'F_WasteMica_DESP_SALE', 'F_WasteMica_TOTAL_DESP');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            if (open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2] != "") {
                var value_1 = parseFloat(open_identical_value[0]);
                var value_2 = parseFloat(open_identical_value[1]);
                var value_3 = parseFloat(open_identical_value[2]);

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                if (value_3 && value_3 != Utilities.roundOff3((value_1 + value_2))) {
                    alert("Total despatches doesn't match with calculated total");
                    $("#F_WasteMica_TOTAL_DESP").val("");
                }
                /**
                 * THE BELOW ELSE CONDITION IS ADDED FOR ADDING THE ONE MORE
                 * VALIDATION THAT IS MENTIONED IN THE SRS
                 * 
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 *
                 **/
                else if (value_3 && value_3 == (value_1 + value_2)) {
                    var corrOpenStTot = parseFloat($("#F_WasteMica_TOTAL_OPEN").val());
                    var corrProdStTot = parseFloat($("#F_WasteMica_TOTAL_PROD").val());
                    var openAndProdGrandTot = corrOpenStTot + corrProdStTot;
                    if (Utilities.roundOff3(openAndProdGrandTot) < value_3) {
                        alert("Total dispatch should not be more than Total production plus opening stock.");
                        $("#F_WasteMica_TOTAL_DESP").val("");
                        event.preventDefault();
                    }
                }


            }
        });

    },
    closeStockFieldValidation: function () {

        $(".close_crude").focusout(function () {
            var open_identical_array = new Array('F_Crude_CLOS_MINE', 'F_Crude_CLOS_DRESS', 'F_Crude_CLOS_OTHER', 'F_Crude_TOTAL_CLOS');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            //      if(open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2]!= "" && open_identical_value[3] != ""){
            var value_1 = parseFloat(open_identical_value[0]);
            var value_2 = parseFloat(open_identical_value[1]);
            var value_3 = parseFloat(open_identical_value[2]);
            if (isNaN(value_3)) {
                value_3 = 0;
            }
            var value_4 = parseFloat(open_identical_value[3]);

            if (value_1 != "" && value_2 != "" && value_4 != "") {

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total closing stock doesn't match with calculated total");
                    $("#F_Crude_TOTAL_CLOS").val("");
                }

            }
        });

        $(".close_incidental").focusout(function () {
            var open_identical_array = new Array('F_Incidental_CLOS_MINE', 'F_Incidental_CLOS_DRESS', 'F_Incidental_CLOS_OTHER', 'F_Incidental_TOTAL_CLOS');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            //      if(open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2]!= "" && open_identical_value[3] != ""){
            var value_1 = parseFloat(open_identical_value[0]);
            var value_2 = parseFloat(open_identical_value[1]);
            var value_3 = parseFloat(open_identical_value[2]);
            if (isNaN(value_3)) {
                value_3 = 0;
            }
            var value_4 = parseFloat(open_identical_value[3]);

            if (value_1 != "" && value_2 != "" && value_4 != "") {

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total closing stock doesn't match with calculated total");
                    $("#F_Incidental_TOTAL_CLOS").val("");
                }

            }
        });

        $(".close_dress_mica").focusout(function () {
            var open_identical_array = new Array('F_WasteMica_CLOS_MINE', 'F_WasteMica_CLOS_DRESS', 'F_WasteMica_CLOS_OTHER', 'F_WasteMica_TOTAL_CLOS');

            var open_identical_length = open_identical_array.length;
            var open_identical_value = Array();
            for (var i = 0; i < open_identical_length; i++) {
                open_identical_value[i] = $("#" + open_identical_array[i]).val();
            }


            //      if(open_identical_value[0] != "" && open_identical_value[1] != "" && open_identical_value[2]!= "" && open_identical_value[3] != ""){
            var value_1 = parseFloat(open_identical_value[0]);
            var value_2 = parseFloat(open_identical_value[1]);
            var value_3 = parseFloat(open_identical_value[2]);
            if (isNaN(value_3)) {
                value_3 = 0;
            }
            var value_4 = parseFloat(open_identical_value[3]);

            if (value_1 != "" && value_2 != "" && value_4 != "") {

                /**
                 * THE BELOW TOTAL NOW HAS BEEN ROUND OFF TO 3 DIGITS AS EARLIER 
                 * IT WAS ROUNDING OF TO THE MAXIMUM LENGTH OF FLOAT ON ADDING
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 13th Feb 2014
                 * 
                 **/

                if (value_4 && value_4 != Utilities.roundOff3((value_1 + value_2 + value_3))) {
                    alert("Total closing stock doesn't match with calculated total");
                    $("#F_WasteMica_TOTAL_CLOS").val("");
                }

            }
        });

    },
    closeStockValidation: function () {
        /**
         * ADDED THE FUNCTION TO ROUND OFF THE TOTAL UP TO 3 DIGITS
         * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 13th Feb 2014
         * 
         **/
        $("#F_Crude_TOTAL_CLOS").focusout(function () {
            var close_stock = document.getElementById("F_Crude_TOTAL_CLOS").value;
            var open_stock = document.getElementById("F_Crude_TOTAL_OPEN").value;
            var production = document.getElementById("F_Crude_TOTAL_PROD").value;
            var dispatches = document.getElementById("F_Crude_TOTAL_DESP").value;

            var data = Utilities.roundOff3(parseFloat(open_stock) + parseFloat(production) - parseFloat(dispatches));
            //            console.log(data)
            //            console.log(close_stock)
            close_stock = Utilities.roundOff3(close_stock);
            if (close_stock != data) {
                alert("Total Opening Stock + Total Production - Total dispatches should be equal to Total Closing stock");
            }
        });

        $("#F_Incidental_TOTAL_CLOS").focusout(function () {
            var close_stock = document.getElementById("F_Incidental_TOTAL_CLOS").value;
            var open_stock = document.getElementById("F_Incidental_TOTAL_OPEN").value;
            var production = document.getElementById("F_Incidental_TOTAL_PROD").value;
            var dispatches = document.getElementById("F_Incidental_TOTAL_DESP").value;

            var data = Utilities.roundOff3(parseFloat(open_stock) + parseFloat(production) - parseFloat(dispatches));
            close_stock = Utilities.roundOff3(close_stock);
            if (close_stock != data) {
                alert("Total Opening Stock + Total Production - Total dispatches should be equal to Total Closing stock");
            }
        });

        $("#F_WasteMica_TOTAL_CLOS").focusout(function () {
            var close_stock = document.getElementById("F_WasteMica_TOTAL_CLOS").value;
            var open_stock = document.getElementById("F_WasteMica_TOTAL_OPEN").value;
            var production = document.getElementById("F_WasteMica_TOTAL_PROD").value;
            var dispatches = document.getElementById("F_WasteMica_TOTAL_DESP").value;

            var data = Utilities.roundOff3(parseFloat(open_stock) + parseFloat(production) - parseFloat(dispatches));
            close_stock = Utilities.roundOff3(close_stock);
            if (close_stock != data) {
                alert("Total Opening Stock + Total Production - Total dispatches should be equal to Total Closing stock");
            }
        });
    },
    f6PostValidation: function () {
        /**
         * ADDED THE FUNCTION TO ROUND OFF THE TOTAL UP TO 3 DIGITS
         * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 13th Feb 2014
         * 
         **/
        $("#frmF6GradeWise").submit(function (event) {
            var open_stock1 = document.getElementById("F_Crude_TOTAL_OPEN").value;
            var production1 = document.getElementById("F_Crude_TOTAL_PROD").value;
            var dispatches1 = document.getElementById("F_Crude_TOTAL_DESP").value;
            var close_stock1 = document.getElementById("F_Crude_TOTAL_CLOS").value;

            var open_stock2 = document.getElementById("F_Incidental_TOTAL_OPEN").value;
            var production2 = document.getElementById("F_Incidental_TOTAL_PROD").value;
            var dispatches2 = document.getElementById("F_Incidental_TOTAL_DESP").value;
            var close_stock2 = document.getElementById("F_Incidental_TOTAL_CLOS").value;

            var open_stock3 = document.getElementById("F_WasteMica_TOTAL_OPEN").value;
            var production3 = document.getElementById("F_WasteMica_TOTAL_PROD").value;
            var dispatches3 = document.getElementById("F_WasteMica_TOTAL_DESP").value;
            var close_stock3 = document.getElementById("F_WasteMica_TOTAL_CLOS").value;

            var count1 = 0;
            var data1 = Utilities.roundOff3(parseFloat(open_stock1) + parseFloat(production1) - parseFloat(dispatches1));
            if (close_stock1 != data1) {
                count1++;
            }

            var count2 = 0;
            var data2 = Utilities.roundOff3(parseFloat(open_stock2) + parseFloat(production2) - parseFloat(dispatches2));
            if (close_stock2 != data2) {
                count2++;
            }

            var count3 = 0;
            var data3 = Utilities.roundOff3(parseFloat(open_stock3) + parseFloat(production3) - parseFloat(dispatches3));
            if (close_stock3 != data3) {
                count3++;
            }
            //console.log(close_stock1)
            //console.log(close_stock2)
            //console.log(close_stock3)
            if (count1 > 0 || count2 > 0 || count3 > 0) {
                alert("Total Opening Stock + Total Production - Total dispatches should be equal to Total Closing stock");
                event.preventDefault();
            }

            // Checking for empty OTHER FIELDS in OPEN STOCK
            var other_fields_1 = new Array('F_Crude_OPEN_OTHER', 'F_Incidental_OPEN_OTHER', 'F_WasteMica_OPEN_OTHER');
            var other_fields_2 = new Array('F_Crude_CLOS_OTHER', 'F_Incidental_CLOS_OTHER', 'F_WasteMica_CLOS_OTHER');
            var other_fields_length_1 = other_fields_1.length;
            var other_fields_length_2 = other_fields_2.length;

            var other_fields_value_1 = Array();
            for (var i = 0; i < other_fields_length_1; i++) {
                other_fields_value_1[i] = $("#" + other_fields_1[i]).val();
            }

            var value_1 = parseInt(other_fields_value_1[0]);
            var value_2 = parseInt(other_fields_value_1[1]);
            var value_3 = parseInt(other_fields_value_1[2]);
            var other_field_error1 = 0;
            if (value_1 > 0 || value_2 > 0 || value_3 > 0) {
                var parent_field_value1 = document.getElementById("F_Crude_OPEN_OTHER_SPEC").value;
                if (parent_field_value1 == "") {
                    other_field_error1++;
                }
            }

            // Checking for empty OTHER FIELDS in CLOSE STOCK
            var other_fields_value_2 = Array();
            for (var j = 0; j < other_fields_length_2; j++) {
                other_fields_value_2[j] = $("#" + other_fields_2[j]).val();
            }

            var value_4 = parseInt(other_fields_value_2[0]);
            var value_5 = parseInt(other_fields_value_2[1]);
            var value_6 = parseInt(other_fields_value_2[2]);

            var other_field_error2 = 0;
            if (value_4 > 0 || value_5 > 0 || value_6 > 0) {
                var parent_field_value2 = document.getElementById("F_Crude_CLOS_OTHER_SPEC").value;
                if (parent_field_value2 == "") {
                    other_field_error2++;
                }
            }

            if (other_field_error1 > 0) {
                alert("Please enter data in at Opening stock any Other point field");
                event.preventDefault();
            }
            else if (other_field_error2 > 0) {
                alert("Please enter data in at Closing stock any Other point field");
                event.preventDefault();
            }


            //CHECKING FOR EX-MINE WITH RESPECT TO PRODUCTION
            var ex_mine_error1 = 0;
            if (production1 > 0) {
                var ex_mine1 = document.getElementById('F_Crude_PMV').value;
                if (ex_mine1 == 0 || ex_mine1 == "" || ex_mine1 < 0) {
                    ex_mine_error1++;
                }
            }

            var ex_mine_error2 = 0;
            if (production2 > 0) {
                var ex_mine2 = document.getElementById('F_Incidental_PMV').value;
                if (ex_mine2 == 0 || ex_mine2 == "" || ex_mine2 < 0) {
                    ex_mine_error2++;
                }
            }

            var ex_mine_error3 = 0;
            if (production3 > 0) {
                var ex_mine3 = document.getElementById('F_WasteMica_PMV').value;
                if (ex_mine3 == 0 || ex_mine3 == "" || ex_mine3 < 0) {
                    ex_mine_error3++;
                }
            }

            if (ex_mine_error1 > 0) {
                alert("Please enter valid crude Ex-mine price")
                event.preventDefault();
            }
            else if (ex_mine_error2 > 0) {
                alert("Please enter valid Waste/scrap mica obtained incidental to mining Ex-mine price")
                event.preventDefault();
            }
            else if (ex_mine_error3 > 0) {
                alert("Please enter valid Waste/scrap mica obtained after preliminary dressing Ex-mine price")
                event.preventDefault();
            }

        });
    },
    checkOpenOptionValidation: function () {
        $("#F_Crude_OPEN_OTHER").blur(function () {
            var current_value = $(this).val();
            if (current_value > 0) {
                var parent_value = document.getElementById("F_Crude_OPEN_OTHER_SPEC").value;
                if (parent_value == 0 || parent_value == "") {
                    alert("Please enter a value in at any Other point field");
                }
            }
        });

        $("#F_Incidental_OPEN_OTHER").blur(function () {
            var current_value = $(this).val();
            if (current_value > 0) {
                var parent_value = document.getElementById("F_Crude_OPEN_OTHER_SPEC").value;
                if (parent_value == 0 || parent_value == "") {
                    alert("Please enter a value in at any Other point field");
                }
            }
        });

        $("#F_WasteMica_OPEN_OTHER").blur(function () {
            var current_value = $(this).val();
            if (current_value > 0) {
                var parent_value = document.getElementById("F_Crude_OPEN_OTHER_SPEC").value;
                if (parent_value == 0 || parent_value == "") {
                    alert("Please enter a value in at any Other point field");
                }
            }
        });
    },
    checkCloseOptionValidation: function () {
        $("#F_Crude_CLOS_OTHER").blur(function () {
            var current_value = $(this).val();
            if (current_value > 0) {
                var parent_value = document.getElementById("F_Crude_CLOS_OTHER_SPEC").value;
                if (parent_value == 0 || parent_value == "") {
                    alert("Please enter a value in at any Other point field");
                }
            }
        });

        $("#F_Incidental_CLOS_OTHER").blur(function () {
            var current_value = $(this).val();
            if (current_value > 0) {
                var parent_value = document.getElementById("F_Crude_CLOS_OTHER_SPEC").value;
                if (parent_value == 0 || parent_value == "") {
                    alert("Please enter a value in at any Other point field");
                }
            }
        });

        $("#F_WasteMica_CLOS_OTHER").blur(function () {
            var current_value = $(this).val();
            if (current_value > 0) {
                var parent_value = document.getElementById("F_Crude_CLOS_OTHER_SPEC").value;
                if (parent_value == 0 || parent_value == "") {
                    alert("Please enter a value in at any Other point field");
                }
            }
        });
    },
    dailyEmploymentValidations: function () {

        // TOTAL CHECK FOR DIRECT MALE AND FEMALE EMPLOYMENT CALCULATION STARTS
        $(".open_direct_male").focusout(function () {
            var open_male_array = new Array('F_Open_MALE_AVG_DIRECT', 'F_Below_MALE_AVG_DIRECT', 'F_Above_MALE_AVG_DIRECT', 'F_Open_TOTAL_MALE_DIRECT');

            var open_male_count = open_male_array.length;
            var open_male_value = Array();
            for (var i = 0; i < open_male_count; i++) {
                open_male_value[i] = $("#" + open_male_array[i]).val();
            }

            var value_1 = parseFloat(open_male_value[0]);
            if (isNaN(value_1))
                value_1 = 0;
            var value_2 = parseFloat(open_male_value[1]);
            if (isNaN(value_2))
                value_2 = 0;
            var value_3 = parseFloat(open_male_value[2]);
            if (isNaN(value_3))
                value_3 = 0;
            var value_4 = parseFloat(open_male_value[3]);

            var calSum = parseFloat(value_1 + value_2 + value_3);
            var calSumRoundOff = Utilities.roundOff1(calSum);

            if (!isNaN(value_4) && (value_4 != calSumRoundOff)) {
                alert("Direct male total is not equal to calculated total");
                $("#F_Open_TOTAL_MALE_DIRECT").val("");
            }
        });

        $(".open_direct_female").focusout(function () {
            var open_female_array = new Array('F_Open_FEMALE_AVG_DIRECT', 'F_Below_FEMALE_AVG_DIRECT', 'F_Above_FEMALE_AVG_DIRECT', 'F_Open_TOTAL_FEMALE_DIRECT');

            var open_female_count = open_female_array.length;
            var open_female_value = Array();
            for (var i = 0; i < open_female_count; i++) {
                open_female_value[i] = $("#" + open_female_array[i]).val();
            }

            var value_1 = parseFloat(open_female_value[0]);
            if (isNaN(value_1))
                value_1 = 0;
            var value_2 = parseFloat(open_female_value[1]);
            if (isNaN(value_2))
                value_2 = 0;
            var value_3 = parseFloat(open_female_value[2]);
            if (isNaN(value_3))
                value_3 = 0;
            var value_4 = parseFloat(open_female_value[3]);
            //            if (isNaN(value_4))
            //                value_4 = 0;

            var calSum = parseFloat(value_1 + value_2 + value_3);
            var calSumRoundOff = Utilities.roundOff1(calSum);

            if (!isNaN(value_4) && (value_4 != calSumRoundOff)) {
                alert("Direct female total is not equal to calculated total");
                $("#F_Open_TOTAL_FEMALE_DIRECT").val("");
            }
            //      }
        });
        // END OF DIRECT MALE AND FEMALE EMPLOYMENT CALCULATION ENDS

        // TOTAL CHECK FOR CONTRACT MALE AND FEMALE EMPLOYMENT CALCULATION STARTS
        $(".contract_male").focusout(function () {
            var contract_male_array = new Array('F_Open_MALE_AVG_CONTRACT', 'F_Below_MALE_AVG_CONTRACT', 'F_Above_MALE_AVG_CONTRACT', 'F_Open_TOTAL_MALE_CONTRACT');

            var contract_male_count = contract_male_array.length;
            var contract_male_value = Array();
            for (var i = 0; i < contract_male_count; i++) {
                contract_male_value[i] = $("#" + contract_male_array[i]).val();
            }

            var value_1 = parseFloat(contract_male_value[0]);
            if (isNaN(value_1))
                value_1 = 0;
            var value_2 = parseFloat(contract_male_value[1]);
            if (isNaN(value_2))
                value_2 = 0;
            var value_3 = parseFloat(contract_male_value[2]);
            if (isNaN(value_3))
                value_3 = 0;
            var value_4 = parseFloat(contract_male_value[3]);
            //            if (isNaN(value_4))
            //                value_4 = 0;

            var calSum = parseFloat(value_1 + value_2 + value_3);
            var calSumRoundOff = Utilities.roundOff1(calSum);

            if (!isNaN(value_4) && (value_4 != calSumRoundOff)) {
                alert("Contract male total is not equal to calculated total");
                $("#F_Open_TOTAL_MALE_CONTRACT").val("");
            }
            //      }
        });

        $(".contract_female").focusout(function () {
            var contract_female_array = new Array('F_Open_FEMALE_AVG_CONTRACT', 'F_Below_FEMALE_AVG_CONTRACT', 'F_Above_FEMALE_AVG_CONTRACT', 'F_Open_TOTAL_FEMALE_CONTRACT');

            var contract_female_count = contract_female_array.length;
            var contract_female_value = Array();
            for (var i = 0; i < contract_female_count; i++) {
                contract_female_value[i] = $("#" + contract_female_array[i]).val();
            }

            var value_1 = parseFloat(contract_female_value[0]);
            if (isNaN(value_1))
                value_1 = 0;
            var value_2 = parseFloat(contract_female_value[1]);
            if (isNaN(value_2))
                value_2 = 0;
            var value_3 = parseFloat(contract_female_value[2]);
            if (isNaN(value_3))
                value_3 = 0;
            var value_4 = parseFloat(contract_female_value[3]);
            //            if (isNaN(value_4))
            //                value_4 = 0;

            var calSum = parseFloat(value_1 + value_2 + value_3);
            var calSumRoundOff = Utilities.roundOff1(calSum);

            if (!isNaN(value_4) && (value_4 != calSumRoundOff)) {
                alert("Contract female total is not equal to calculated total");
                $("#F_Open_TOTAL_FEMALE_CONTRACT").val("");
            }
            //      }
        });
        // END OF CONTRACT MALE AND FEMALE EMPLOYMENT CALCULATION ENDS

        // TOTAL CHECK FOR WAGES OF THE MONTH CALCULATION STARTS
        $(".direct_wages").focusout(function () {
            var contract_male_array = new Array('F_Open_WAGE_DIRECT', 'F_Below_WAGE_DIRECT', 'F_Above_WAGE_DIRECT', 'F_Open_TOTAL_DIRECT');

            var contract_male_count = contract_male_array.length;
            var contract_male_value = Array();
            for (var i = 0; i < contract_male_count; i++) {
                contract_male_value[i] = $("#" + contract_male_array[i]).val();
            }

            var value_1 = parseFloat(contract_male_value[0]);
            if (isNaN(value_1))
                value_1 = 0;
            var value_2 = parseFloat(contract_male_value[1]);
            if (isNaN(value_2))
                value_2 = 0;
            var value_3 = parseFloat(contract_male_value[2]);
            if (isNaN(value_3))
                value_3 = 0;
            var value_4 = parseFloat(contract_male_value[3]);
            //            if (isNaN(value_4))
            //                value_4 = 0;

            var calSum = parseFloat(value_1 + value_2 + value_3);
            var calSumRoundOff = Utilities.roundOff1(calSum);

            if (!isNaN(value_4) && (value_4 != calSumRoundOff)) {
                alert("Direct total wages for the month is not equal to calculated total");
                $("#F_Open_TOTAL_DIRECT").val("");
            }
            //      }
        });

        $(".contract_wages").focusout(function () {
            var contract_female_array = new Array('F_Open_WAGE_CONTRACT', 'F_Below_WAGE_CONTRACT', 'F_Above_WAGE_CONTRACT', 'F_Open_TOTAL_CONTRACT');

            var contract_female_count = contract_female_array.length;
            var contract_female_value = Array();
            for (var i = 0; i < contract_female_count; i++) {
                contract_female_value[i] = $("#" + contract_female_array[i]).val();
            }

            var value_1 = parseFloat(contract_female_value[0]);
            if (isNaN(value_1))
                value_1 = 0;
            var value_2 = parseFloat(contract_female_value[1]);
            if (isNaN(value_2))
                value_2 = 0;
            var value_3 = parseFloat(contract_female_value[2]);
            if (isNaN(value_3))
                value_3 = 0;
            var value_4 = parseFloat(contract_female_value[3]);
            //            if (isNaN(value_4))
            //                value_4 = 0;

            var calSum = parseFloat(value_1 + value_2 + value_3);
            var calSumRoundOff = Utilities.roundOff1(calSum);

            if (!isNaN(value_4) && (value_4 != calSumRoundOff)) {
                alert("Contract total wages for the month is not equal to calculated total");
                $("#F_Open_TOTAL_CONTRACT").val("");
            }
            //      }
        });
        // TOTAL CHECK FOR WAGES OF THE MONTH CALCULATION ENDS

    },
    dailyEmploymentPostValidation: function () {
        $("#frmDailyAverage").submit(function (event) {
            var all_input_field = document.getElementsByClassName("req");
            var count = 0;
            for (var i = 0; i < all_input_field.length; i++) {
                if (all_input_field[i]['value'] == "") {
                    count++;
                }
            }
            if (count > 0) {
                alert("Please enter all fields")
                event.preventDefault();
            }

        });
    },
    prodValueChangeAlertValidation: function () {
        var _this = this;
        //CRUDE fields CHANGE CHECKING LOGIC STARTS
        $(".prod_crude").focus(function () {
            var value = $(this).val();


            _this.prev_value = value;

        });

        $(".prod_crude").focusout(function () {
            var value = $(this).val();

            if (!isNaN(value)) {
                _this.new_value = Utilities.roundOff3(value);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {
                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        //CRUDE fields CHANGE CHECKING LOGIC ENDS

        // INCIDENTAL FIELDS CHANGE CHECKING LOGIC STARTS
        $(".prod_identical").focus(function () {
            var value = $(this).val();

            _this.prev_value = value;

        });

        $(".prod_identical").focusout(function () {
            var value = $(this).val();

            if (!isNaN(value)) {
                _this.new_value = Utilities.roundOff3(value);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {
                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        // INCIDENTAL FIELDS CHANGE CHECKING LOGIC ENDS

        // DRESS FIELDS CHANGE CHECKING LOGIC STARTS
        $(".prod_dress_mica").focus(function () {
            var value = $(this).val();

            _this.prev_value = value;

        });

        $(".prod_dress_mica").focusout(function () {
            var value = $(this).val();

            if (!isNaN(value)) {
                _this.new_value = Utilities.roundOff3(value);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {
                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        // DRESS FIELDS CHANGE CHECKING LOGIC ENDS


    },
    dispatchValueChangeAlertValidation: function () {
        var _this = this;

        // DISPATCHES CRUDE FIELDS CHANGE CHECKING LOGIC STARTS
        $(".dispatch_crude").focus(function () {

            var elementId = $(this).attr('id');

            var elementValue = $("#" + elementId).val();

            //var value = $(this).val();
            var prevValue = elementValue

            _this.prev_value = prevValue;

        });

        $(".dispatch_crude").focusout(function () {

            //var curValue = $(this).val();
            var curElementId = $(this).attr('id');
            var curValue = $("#" + curElementId).val();

            if (!isNaN(curValue)) {
                _this.new_value = Utilities.roundOff3(curValue);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {

                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        // DISPATCHES CRUDE FIELDS CHANGE CHECKING LOGIC ENDS

        // DISPATCHES INCIDENTAL FIELDS CHANGE CHECKING LOGIC STARTS
        $(".dispatch_incidental").focus(function () {
            var value = $(this).val();

            _this.prev_value = value;

        });

        $(".dispatch_incidental").focusout(function () {
            var value = $(this).val();

            if (!isNaN(value)) {
                _this.new_value = Utilities.roundOff3(value);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {
                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        // DISPATCHES INCIDENTAL FIELDS CHANGE CHECKING LOGIC ENDS

        // DISPATCHES DRESS MICA FIELDS CHANGE CHECKING LOGIC STARTS
        $(".dispatch_dress_mica").focus(function () {
            var value = $(this).val();

            _this.prev_value = value;

        });

        $(".dispatch_dress_mica").focusout(function () {
            var value = $(this).val();

            if (!isNaN(value)) {
                _this.new_value = Utilities.roundOff3(value);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {
                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        // DISPATCHES DRESS MICA FIELDS CHANGE CHECKING LOGIC ENDS

    },
    closeStockValueChangeAlertValidation: function () {
        var _this = this;

        // CLOSE STOCK CRUDE FIELDS CHANGE CHECKING LOGIC STARTS
        $(".open_crude").focus(function () {
            var value = $(this).val();


            _this.prev_value = value;

        });

        $(".open_crude").focusout(function () {
            var value = $(this).val();

            if (!isNaN(value)) {
                _this.new_value = Utilities.roundOff3(value);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {
                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        // CLOSE STOCK CRUDE FIELDS CHANGE CHECKING LOGIC ENDS

        // CLOSE STOCK INCIDENTAL FIELDS CHANGE CHECKING LOGIC STARTS
        $(".open_identical").focus(function () {
            var value = $(this).val();


            _this.prev_value = value;

        });

        $(".open_identical").focusout(function () {
            var value = $(this).val();

            if (!isNaN(value)) {
                _this.new_value = Utilities.roundOff3(value);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {
                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        // CLOSE STOCK INCIDENTAL FIELDS CHANGE CHECKING LOGIC ENDS

        // CLOSE STOCK DRESS MICA FIELDS CHANGE CHECKING LOGIC STARTS
        $(".open_dress_mica").focus(function () {
            var value = $(this).val();
            _this.prev_value = value;
        });

        $(".open_dress_mica").focusout(function () {
            var value = $(this).val();

            if (!isNaN(value)) {
                _this.new_value = Utilities.roundOff3(value);
            }

            if (!isNaN(_this.prev_value) && !isNaN(_this.new_value) && _this.prev_value != '' && _this.new_value != '') {
                if (_this.prev_value != _this.new_value) {
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        // CLOSE STOCK DRESS MICA FIELDS CHANGE CHECKING LOGIC ENDS

    },
    meshValidation: function () {
        $("#F_PRODUCED_MESH_SIZE").blur(function () {
            var field_length = $(this).val();
            if (field_length.length > 15) {
                alert("Maximum Mesh size value allowed is 15");
            }
        });

        $("#F_SOLD_MESH_SIZE").blur(function () {
            var field_length = $(this).val();
            if (field_length.length > 15) {
                alert("Maximum Mesh size value allowed is 15");
            }
        });
    },
    estProdF1Validation: function () {
        var cum_prod = document.getElementById('cum_prod').value;
        var estimated_prod = document.getElementById('estimated_prod').value;

        var prod_oc = document.getElementById('F_OPEN_OC_ROM').value;
        var prod_dw = document.getElementById('F_PROD_DW_ROM').value;

        var form_entry_total = parseFloat(prod_oc) + parseFloat(prod_dw);

        var total_prod = parseFloat(cum_prod) + form_entry_total;

        if (total_prod > estimated_prod)
            alert('Cumulative production of ROM exceeded the approved production for the financial year');
    },
    estProdF6Validation: function () {
        var cum_prod = document.getElementById('cum_prod').value;
        var estimated_prod = document.getElementById('estimated_prod').value;

        var prod_val = document.getElementById('F_Incidental_TOTAL_PROD').value;

        var form_entry_total = parseFloat(prod_val);

        var total_prod = parseFloat(cum_prod) + form_entry_total;

        if (total_prod > estimated_prod)
            alert('Cumulative production of ROM exceeded the approved production for the financial year');
    },
    estProdF7Validation: function () {
        var cum_prod = document.getElementById('cum_prod').value;
        var estimated_prod = document.getElementById('estimated_prod').value;

        var prod_oc = document.getElementById('F_OC_QTY').value;
        var prod_ug = document.getElementById('F_UG_QTY').value;

        var form_entry_total = parseFloat(prod_oc) + parseFloat(prod_ug);

        var total_prod = parseFloat(cum_prod) + form_entry_total;

        if (total_prod > estimated_prod)
            alert('Cumulative production of ROM exceeded the approved production for the financial year');
    },
    // below added checkF5ForNil in both the function i.e, salesDispatchRemoveFunctionality and click 
    //added by ganesh satav dated 9 july 2014
    salesDispatchRemoveFunctionality: function (checkF5ForNil) {
        $("#saleDispatchRemoveButton").click(function (checkF5ForNil) {
            selCheckBoxes = $('input:checkbox').filter(':checked')
            if (selCheckBoxes.length == 0)
                alert("Please select any one row")
            else {

                // GETTING ALL THE CHECKED CHECKBOXES AND THEN REMOVE THEM ALL
                var selCheckBoxes = $('input:checkbox').filter(':checked');
                $("#fcount").val(parseInt($('input:checkbox').length) - parseInt(selCheckBoxes.length));
                selCheckBoxes.closest('tr').remove();

                // GETTING ALL THE REMAINING CHECKBOXES AND COUNTING THEIR LENGTH
                var remCheckBoxes = $('input:checkbox');
                var remCheckBoxesLength = remCheckBoxes.length;

                // GETTING THE ALL INPUT OF PARTICULAR TYPE USING THEIR UNIQUE CLASS NAME
                var sale_check = $(".sale_check");
                var grade_codes = $(".g_code");
                var client_types = $(".c_type");
                var reg_names = $(".reg_name");
                var reg_nos = $(".reg_no");
                var quantity = $(".f_quant");
                var sale_values = $(".s_value");
                var exp_countries = $(".country");
                var exp_quantity = $(".e_quant");
                var fob = $(".fob");

                // LOOPS CHANGES THE ID AND NAME OF THE FIELDS AFTER DELETING THE ONE OR MORE ROWS
                for (var i = 0; i < remCheckBoxesLength; i++) {
                    var j = i + 1;
                    if (i == 0) {
                        $(sale_check[i]).attr('id', 'sale_check');
                        $(grade_codes[i]).attr('name', 'F[GRADE_CODE]');
                        $(grade_codes[i]).attr('id', 'F_GRADE_CODE');
                        $(client_types[i]).attr('name', 'F[CLIENT_TYPE]');
                        $(client_types[i]).attr('id', 'F_CLIENT_TYPE');
                        $(reg_names[i]).attr('name', 'F[CLIENT_NAME]');
                        $(reg_names[i]).attr('id', 'F_CLIENT_NAME');
                        $(reg_nos[i]).attr('name', 'F[CLIENT_REG_NO]');
                        $(reg_nos[i]).attr('id', 'F_CLIENT_REG_NO');
                        $(quantity[i]).attr('name', 'F[QUANTITY]');
                        $(quantity[i]).attr('id', 'F_QUANTITY');
                        $(sale_values[i]).attr('name', 'F[SALE_VALUE]');
                        $(sale_values[i]).attr('id', 'F_SALE_VALUE');
                        $(exp_countries[i]).attr('name', 'F[EXPO_COUNTRY]');
                        $(exp_countries[i]).attr('id', 'F_EXPO_COUNTRY');
                        $(exp_quantity[i]).attr('name', 'F[EXPO_QUANTITY]');
                        $(exp_quantity[i]).attr('id', 'F_EXPO_QUANTITY');
                        $(fob[i]).attr('name', 'F[EXPO_FOB]');
                        $(fob[i]).attr('id', 'F_EXPO_FOB');
                    } else {
                        //CHANGING THE NAME OF THE FIELDS
                        $(sale_check[i]).attr('id', 'sale_check_' + j);
                        $(grade_codes[i]).attr('name', 'F_GRADE_CODE' + j);
                        $(grade_codes[i]).attr('id', 'F_GRADE_CODE' + j);
                        $(client_types[i]).attr('name', 'F_CLIENT_TYPE' + j);
                        $(client_types[i]).attr('id', 'F_CLIENT_TYPE' + j);
                        $(reg_names[i]).attr('name', 'F_CLIENT_NAME' + j);
                        $(reg_names[i]).attr('id', 'F_CLIENT_NAME' + j);
                        $(reg_nos[i]).attr('name', 'F_CLIENT_REG_NO' + j);
                        $(reg_nos[i]).attr('id', 'F_CLIENT_REG_NO' + j);
                        $(quantity[i]).attr('name', 'F_QUANTITY' + j);
                        $(quantity[i]).attr('id', 'F_QUANTITY' + j);
                        $(sale_values[i]).attr('name', 'F_SALE_VALUE' + j);
                        $(sale_values[i]).attr('id', 'F_SALE_VALUE' + j);
                        $(exp_countries[i]).attr('name', 'F_EXPO_COUNTRY' + j);
                        $(exp_countries[i]).attr('id', 'F_EXPO_COUNTRY' + j);
                        $(exp_quantity[i]).attr('name', 'F_EXPO_QUANTITY' + j);
                        $(exp_quantity[i]).attr('id', 'F_EXPO_QUANTITY' + j);
                        $(fob[i]).attr('name', 'F_EXPO_FOB' + j);
                        $(fob[i]).attr('id', 'F_EXPO_FOB' + j);
                    }
                }
            }

            var dataLen = $(".g_code").length;
            if (dataLen == 1) {
                custom_validations.F5AutoFillForZeroProduction(checkF5ForNil);
            }
            //        custom_validations.F5AutoFillForZeroProduction(checkF5ForNil);


            return false;
        });
    },
    F5AutoFillForZeroProduction: function (checkF5ForNil) {
        $("#F_GRADE_CODE").unbind("change");
// below comment code by ganesh satav solving issues no 10
// 21st June 2014
        //       $("#F_GRADE_CODE").val("");  

        //   $("#F_GRADE_CODE").val("");

        if (checkF5ForNil == 0) {
            var dataLen = $(".g_code").length;
            if (dataLen > 1) {
                $(".g_code").find('option[value=0]').remove();
                $("#F_CLIENT_TYPE").find('option[value=NIL]').remove();
                $("#F_EXPO_COUNTRY").find('option[value=NIL]').remove();
                $("#F_EXPO_COUNTRY").find('option[value=0]').remove();
            }
            else {
                $("#F_GRADE_CODE").append(
                        $("<option></option>").html("NIL").val(0)
                        );

                $("#F_GRADE_CODE").val("");
                $("#F_CLIENT_TYPE").append(
                        $("<option></option>").html("NIL").val("NIL")
                        );

                $("#F_EXPO_COUNTRY").append(
                        $("<option></option>").html("NIL").val(0)
                        );
                var checkForEdit = $("#F_CLIENT_REG_NO").val();
                if (checkForEdit == 0 && checkForEdit != "") {
                    $("#F_EXPO_COUNTRY").val(0)
                    $("#F_CLIENT_TYPE").val('NIL');
                    $("#F_GRADE_CODE").val(0);

                }
            }
        }

        $("#F_GRADE_CODE").change(function () {
            var metalBoxVal = $(this).val();

            var fieldPartialNameArr = Array(
                    '#F_CLIENT_TYPE', '#F_CLIENT_REG_NO', '#F_CLIENT_NAME', '#F_QUANTITY', '#F_SALE_VALUE', '#F_EXPO_COUNTRY', '#F_EXPO_QUANTITY', '#F_EXPO_FOB'
                    );

            if (metalBoxVal == 0 && metalBoxVal != '') {
                $.each(fieldPartialNameArr, function (key, item) {
                    if (item == '#F_CLIENT_TYPE') {

                        $(item + " option[value='NIL']").remove();
                        $(item).append(
                                $("<option></option>").html("NIL").val("NIL")
                                );
                        $(item).val('NIL');

                    }
                    else if (item == '#F_CLIENT_NAME') {
                        $(item).val("NA");
                    }
                    else if (item == '#F_EXPO_COUNTRY') {
                        $(item + " option[value=0]").remove();
                        $(item).append(
                                $("<option></option>").html("NIL").val(0)
                                );
                        $(item).val(0)

                    }
                    else {
                        $(item).val(0);
                    }
                });
            }
            else {
                $("#F_CLIENT_TYPE option[value=NIL]").remove();
                $("#F_EXPO_COUNTRY option[value=0]").remove();
                $.each(fieldPartialNameArr, function (key, item) {
                    if (item != '#F_EXPO_COUNTRY' || item != '#F_EXPO_COUNTRY') {
                        $(item).val("");
                    }
                });
            }
        });

        //    $("#F_CLIENT_TYPE").change(function(){
        //      
        //      if($(this).val() != 'NIL'){
        //        var checkGradeVal = $("#F_GRADE_CODE").val();
        //        if(checkGradeVal == 0){
        //          $("#F_CLIENT_TYPE").val('NIL');
        //        }
        //      }
        //    });
    }

}

var f3Validation = {
    avgGradeValidation: function () {
        $("#F_A_AVERAGE_GRADE").blur(function () {
            var value = $(this).val();
            if (value < 0) {
                alert("Please enter valid average grade");
                $("#F_A_AVERAGE_GRADE").val("");
            }
            else if (value >= 40 && value != 0) {
                alert("Average grade is out of range");
                $("#F_A_AVERAGE_GRADE").val("");
            }
        });

        $("#F_B_AVERAGE_GRADE").blur(function () {
            var value = $(this).val();
            if (value < 0) {
                alert("Please enter valid average grade");
                $("#F_B_AVERAGE_GRADE").val("");
            }
            else if (value >= 45 || value < 40 && value != 0) {
                alert("Average grade is out of range");
                $("#F_B_AVERAGE_GRADE").val("");
            }
        });

        $("#F_C_AVERAGE_GRADE").blur(function () {
            var value = $(this).val();
            if (value < 0) {
                alert("Please enter valid average grade");
                $("#F_C_AVERAGE_GRADE").val("");
            }
            else if (value >= 50 || value < 45 && value != 0) {
                alert("Average grade is out of range");
                $("#F_C_AVERAGE_GRADE").val("");
            }
        });

        $("#F_D_AVERAGE_GRADE").blur(function () {
            var value = $(this).val();
            if (value < 0) {
                alert("Please enter valid average grade");
                $("#F_D_AVERAGE_GRADE").val("");
            }
            else if (value >= 55 || value < 50 && value != 0) {
                alert("Average grade is out of range");
                $("#F_D_AVERAGE_GRADE").val("");
            }
        });

        $("#F_E_AVERAGE_GRADE").blur(function () {
            var value = $(this).val();
            if (value < 0) {
                alert("Please enter valid average grade");
                $("#F_E_AVERAGE_GRADE").val("");
            }
            else if (value >= 60 || value < 55 && value != 0) {
                alert("Average grade is out of range");
                $("#F_E_AVERAGE_GRADE").val("");
            }
        });

        $("#F_F_AVERAGE_GRADE").blur(function () {
            var value = $(this).val();
            if (value < 0) {
                alert("Please enter valid average grade");
                $("#F_F_AVERAGE_GRADE").val("");
            }
            else if (value > 100 || value < 60 && value != 0) {
                alert("Average grade is out of range");
                $("#F_F_AVERAGE_GRADE").val("");
            }
        });


    },
    gradeHighLowValidation: function () {
        $("#frmGradeWiseProduction").submit(function () {
            var pmv_1 = $("#F_A_PMV").val();
            var pmv_2 = $("#F_B_PMV").val();
            var pmv_3 = $("#F_C_PMV").val();

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
    }
}


/**
 * Takes care of all the functionalities of F5 Rom form
 */
var f5Rom = {
    init: function (metal_url, data_url, display_table_url) {

        Utilities.ajaxBlockUI();
        this.qtyTotal();
        this.metalUrl = metal_url;
        this.dataUrl = data_url;
        this.displayTableUrl = display_table_url;

        this.romTables = new Array('open_dev', 'prod_dev', 'close_dev', 'open_stop', 'prod_stop', 'close_stop', 'open_cast', 'prod_cast', 'close_cast');
        this.romRenderTables();
        this.checkReason();

    },
    romRenderTables: function () {

        var _this = this;

        $.ajax({
            url: _this.metalUrl,
            type: 'POST',
            success: function (response) {
				
                _this.metals = json_parse(response);

                $.ajax({
                    url: _this.dataUrl,
                    type: 'POST',
                    success: function (rp) {
						
                        _this.data = json_parse(rp);
                        if (Object.keys(_this.data).length == 1) {
                            _this.createRomSubTables();
                        } else {
                            _this.renderEditForm();
                            _this.checkQuantityUpdation();
                            _this.checkOpenDevGradeUpdation();
                            _this.checkOpenCastGradeUpdation();

                        }
                        //call validation methods
                        _this.metalGradeTotal();
                        _this.validateDropDown();
                        _this.changeGradeTotal();
                        _this.dropDownValidation();
                        _this.formRomF5Validation();
                        _this.addBtn();
                        _this.f5PostValidation();
                        _this.checkGradeRequiredStar();
                        _this.checkMetalRequiredStar();
                        _this.quantityRoundToZero();
                        _this.checkClosingStock();
                        _this.autoFillForZeroProduction();
                    }
                });

            }
        });
    },
    createRomSubTables: function () {


        for (var i = 0; i < this.romTables.length; i++) {

            var tr = $(document.createElement('tr'));

            var metal_td = $(document.createElement('td'));

            var select_box = $(document.createElement('select'));
            select_box.attr('id', this.romTables[i] + "_metal_1");
            select_box.attr('name', this.romTables[i] + "_metal_1");
            select_box.attr('class', this.romTables[i] + "_metal metal-box");


            var dummy_option = $(document.createElement('option'));
            dummy_option.html("- Select -");
            dummy_option.val("");
            select_box.append(dummy_option);

            for (var j = 0; j < Object.keys(this.metals).length - 1; j++) { 
                var options = $(document.createElement('option'));
                options.html(this.metals[j]);
                options.val(this.metals[j]);
                select_box.append(options);
            }


            metal_td.append(select_box);
            tr.append(metal_td);

            var grade_td = $(document.createElement('td'));


            var grade = $(document.createElement('input'));
            grade.attr('id', this.romTables[i] + "_grade_1");
            grade.attr('name', this.romTables[i] + "_grade_1");
            grade.addClass(this.romTables[i] + "_grade grade-txtbox one_grade_more");
            grade_td.append(grade);
            tr.append(grade_td);

            var required_td = $(document.createElement('td'));
            required_td.attr('id', this.romTables[i] + "_required")
            tr.append(required_td);

            $('#' + this.romTables[i] + "_table").append(tr);
            //since this is a new record, initialize the count to 1 for all.
            var metal_count = document.getElementById(this.romTables[i] + "_metal_count");
            metal_count.value = 1;

        }

    },
    renderEditForm: function () {
        var _this = this;

        //for edit form initialize the metal count to 0 for all.
        for (var i = 0; i < this.romTables.length; i++) {
            var mc = document.getElementById(this.romTables[i] + "_metal_count");
            mc.value = 0;
        }

        for (var i = 0; i < Object.keys(_this.data).length-1; i++) {
            var sub_table = document.getElementById(this.data[i]['table'] + "_table");

            var tr = $(document.createElement('tr'));
            $('#' + this.data[i]['table'] + "_table").append(tr);

            var metal_td = $(document.createElement('td'));
            tr.append(metal_td);

            //hidden metal count
            var metal_count = document.getElementById(this.data[i]['table'] + "_metal_count");
            var prev_metal_count = metal_count.value;
            var inc_metal_count = parseInt(prev_metal_count) + 1;
            metal_count.value = inc_metal_count;

            //metal select box
            var select_box = $(document.createElement('select'));
            select_box.attr('id', this.data[i]['table'] + "_metal_" + inc_metal_count);
            select_box.attr('name', this.data[i]['table'] + "_metal_" + inc_metal_count);
            select_box.addClass(this.data[i]['table'] + "_metal metal-box");
            metal_td.append(select_box);

            var dummy_option = $(document.createElement('option'));
            dummy_option.html("- Select -");
            dummy_option.val("");
            select_box.append(dummy_option);

            for (var j = 0; j < Object.keys(this.metals).length - 1; j++) {
                var options = $(document.createElement('option'));
                options.html(this.metals[j]);
                options.val(this.metals[j]);
                select_box.append(options);
            }

            select_box.val(this.data[i]['metal']);

            //grade text box
            var grade_td = $(document.createElement('td'));
            tr.append(grade_td);

            var grade = $(document.createElement('input'));
            grade.attr('id', this.data[i]['table'] + "_grade_" + inc_metal_count);
            grade.attr('name', this.data[i]['table'] + "_grade_" + inc_metal_count);
            grade.addClass(this.data[i]['table'] + "_grade grade-txtbox");
            grade.val(this.data[i]['grade']);
            grade_td.append(grade);

            var required_td = $(document.createElement('td'));
            required_td.attr('id', this.romTables[i] + "_required")
            tr.append(required_td);


            if (prev_metal_count > 0) {
                //close button
                var close_td = $(document.createElement('td'));
                close_td.addClass("close-symbol");
                close_td.bind('click', function (id) {
                    /**
                     * REMOVED THIS RETURN FUNCTION AS THIS IS USED TO GET THE ID OF THE ELEMENT ON CLICK EVENT 
                     * BUT THE REMOVE BUTTON HAS ONLY CLASS AND THUS THIS IS CREATING PROBLEM WHILE DELETEING THE RECROR
                     * 
                     * ALSO ADDED THE BELOW 3 LINES FOR GETTING THE ID OF THE ELEMENT ON CLICK OF THE REMOVE
                     * 
                     * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
                     * @version 30th April 2014
                     **/
                    //          return function() { 
                    //rename the id and name for the other text and select boxes
                    var rowElementId = $(this).closest('tr').find('td:first select').attr('id');
                    var rowElementIdTemp = rowElementId.split("_");
                    var id = rowElementIdTemp[0] + "_" + rowElementIdTemp[1];



                    _this.renameBoxes(id);

                    //calculate underground display table
                    var grade_element_id = $(this).prev().prev().children().attr('id');
                    var work_type = _this.getWorkType(grade_element_id);
                    if (work_type != "cast") {
                        _this.reCalculateUndGradeTotal(grade_element_id, work_type);
                    } else {
                        _this.reCalculateCastGradeTotal(grade_element_id);
                    }

                    $(this).parent().remove();

                    //hidden metal count
                    var metal_count = document.getElementById(id + "_metal_count");
                    var prev_metal_count = metal_count.value;
                    var dec_metal_count = parseInt(prev_metal_count) - 1;
                    metal_count.value = dec_metal_count;
                    //          }
                });
                (this.data[i]['table']);
                tr.append(close_td);
            }


            //Display values in Quantity
            var tmp_table_id = "F_" + this.data[i]['table'].toUpperCase() + "_QTY";
            var quantity = document.getElementById(tmp_table_id);
            quantity.value = this.data[i]['tot_qty'];

        }

        //Display values in Reason
        var reason = document.getElementById("F_INC_REASON");
        reason.value = this.data[0]['reason'];

        //Total
        this.totalQuantity();

        //Metal Display Table
        this.displayTable();
    },
    addBtn: function () {
        var _this = this;
        for (var i = 0; i < this.romTables.length; i++) {
            var tbl = document.getElementById(this.romTables[i] + "_table");
            var btn = document.getElementById(this.romTables[i] + "_add_btn");

            btn.onclick = function (id) {
                return function (evt) {
                    var tbl = document.getElementById(id + "_table");
                    var new_row = $(document.createElement('tr'));
                    $('#' + id + "_table").append(new_row);

                    var metal_td = $(document.createElement('td'));
                    new_row.append(metal_td);

                    //hidden metal count
                    var metal_count = document.getElementById(id + "_metal_count");

                    var prev_metal_count = metal_count.value;
                    if (prev_metal_count == _this.metals.length) {
                        alert("Sorry! You can't add more than " + _this.metals.length + " metal content/grade");
                        return;
                    }
                    var inc_metal_count = parseInt(prev_metal_count) + 1;

                    metal_count.value = inc_metal_count;

                    //metal select box
                    var select_box = $(document.createElement('select'));
                    select_box.attr('id', id + "_metal_" + inc_metal_count);
                    select_box.attr('name', id + "_metal_" + inc_metal_count);
                    select_box.addClass(id + "_metal metal-box");
                    metal_td.append(select_box);

                    var dummy_option = $(document.createElement('option'));
                    dummy_option.html("- Select -");
                    dummy_option.val("");
                    select_box.append(dummy_option);

                    for (var j = 0; j < Object.keys(_this.metals).length - 1; j++) {
                        var options = $(document.createElement('option'));
                        options.html(_this.metals[j]);
                        options.val(_this.metals[j]);
                        select_box.append(options);
                    }

                    //grade box
                    var grade_td = $(document.createElement('td'));
                    new_row.append(grade_td);

                    var grade = $(document.createElement('input'));
                    grade.attr('id', id + "_grade_" + inc_metal_count);
                    grade.attr('name', id + "_grade_" + inc_metal_count);
                    grade.addClass(id + "_grade grade-txtbox");
                    grade_td.append(grade);

                    //close button
                    var close_td = $(document.createElement('td'));
                    close_td.addClass("close-symbol");
                    close_td.bind('click', function () {
                        //rename the id and name for the other text and select boxes



                        //calculate underground display table
                        var grade_element_id = $(this).prev().children().attr('id');
                        var work_type = _this.getWorkType(grade_element_id);

                        if (work_type != "cast") {
                            _this.reCalculateUndGradeTotal(grade_element_id, work_type);

                        } else {

                            _this.reCalculateCastGradeTotal(grade_element_id);

                        }

                        $(this).parent().remove();
                        _this.renameBoxes(id);

                        //hidden metal count
                        var metal_count = document.getElementById(id + "_metal_count");
                        var prev_metal_count = metal_count.value;
                        var dec_metal_count = parseInt(prev_metal_count) - 1;
                        metal_count.value = dec_metal_count;
                    });
                    new_row.append(close_td);

                    //call the validation for the new rows
                    _this.metalGradeTotal();
                    _this.validateDropDown();
                    _this.dropDownValidation();
                }
            }(this.romTables[i]);

        }
    },
    renameBoxes: function (id) {

        var existing_select_boxes = $("." + id + "_metal")
        var existing_text_boxes = $("." + id + "_grade")
        var counter_1 = 0; // CHANGED THE COUNTER START FROM 1 TO 0 AS THIS COUNTER IS ALSO INCREMENTING INSIDE THE LOOP SO NUMBERING IS COMING WRONG -- UDAY SANKAR SINGH 20th Jan 2014
        var counter12 = $(existing_select_boxes[0]).attr('id').split('_');

        for (var k = 0; k < existing_select_boxes.length; k++) {
            var count = counter_1 + 1;
            var counter12 = $(existing_select_boxes[k]).attr('id').split('_');

            $(existing_select_boxes[k]).attr('name', id + '_metal_' + count);
            $(existing_select_boxes[k]).attr('id', id + '_metal_' + count);

            $('#' + id + '_grade_' + counter12[3]).attr('name', id + '_grade_' + count);
            $('#' + id + '_grade_' + counter12[3]).attr('id', id + '_grade_' + count);
            counter_1++;
        }
    },
    totalQuantity: function () {
        var total_boxes = new Array('OPEN', 'PROD', 'CLOSE');
        for (var i = 0; i < total_boxes.length; i++) {

            var dev_tot = parseFloat($("#F_" + total_boxes[i] + "_DEV_QTY").val());
            var stop_tot = parseFloat($("#F_" + total_boxes[i] + "_STOP_QTY").val());
            var cast_tot = parseFloat($("#F_" + total_boxes[i] + "_CAST_QTY").val());

            var stock_total = document.getElementById('F_' + total_boxes[i] + '_TOT_QTY');
            // calculating total
            var total = dev_tot + stop_tot + cast_tot;
            //      stock_total.value = (total).toFixed(3);
            stock_total.value = total;

            var und_total = dev_tot + stop_tot;
            var und_type = total_boxes[i].toLowerCase();
            var und_qty_total = document.getElementById(und_type + '_und_qty_total');
            und_qty_total.className = "right";
            //      und_qty_total.innerHTML = (und_total).toFixed(3);
            und_qty_total.innerHTML = und_total;
        }
    },
    displayTable: function () {
        var _this = this;

        $.ajax({
            url: _this.displayTableUrl,
            type: 'POST',
            success: function (response) {
                var data = json_parse(response);

                //UNDERGROUND DISPLAY TABLE
                var und_stock = data.und_stock;
                var und_grade_data = new Array(und_stock.open, und_stock.prod, und_stock.close);
                var und_disp_tables = new Array('open_und', 'prod_und', 'close_und');

                for (var i = 0; i < und_grade_data.length; i++) {
                    $.each(und_grade_data[i], function (key, value) {
                        var und_total_table = document.getElementById(und_disp_tables[i] + '_metal_total');

                        var und_tr = document.createElement('tr');
                        und_total_table.appendChild(und_tr);

                        var und_metal_td = document.createElement('td');
                        und_metal_td.id = und_disp_tables[i] + "_" + key.toLowerCase();
                        und_metal_td.innerHTML = key;
                        und_tr.appendChild(und_metal_td);

                        var und_grade_td = document.createElement('td');
                        und_grade_td.id = und_disp_tables[i] + "_" + key.toLowerCase() + "_value";
                        und_grade_td.innerHTML = value;
                        und_tr.appendChild(und_grade_td);
                    });
                }

                //TOTAL DISPLAY TABLE
                var total_stock = data.total_stock;
                var total_grade_data = new Array(total_stock.open, total_stock.prod, total_stock.close);
                var total_disp_tables = new Array('open_total_table', 'prod_total_table', 'close_total_table');

                for (var i = 0; i < total_grade_data.length; i++) {
                    $.each(total_grade_data[i], function (key, value) {
                        var table = document.getElementById(total_disp_tables[i]);

                        var tr = document.createElement('tr');
                        table.appendChild(tr);

                        var metal_td = document.createElement('td');
                        metal_td.id = total_disp_tables[i] + "_" + key.toLowerCase();
                        metal_td.innerHTML = key;
                        tr.appendChild(metal_td);

                        var grade_td = document.createElement('td');
                        grade_td.id = total_disp_tables[i] + "_" + key.toLowerCase() + "_value";
                        grade_td.innerHTML = value;
                        tr.appendChild(grade_td);
                    });
                }
            }
        });
    },
    qtyTotal: function () {

        jQuery.validator.addMethod("qtyTotal", function (value, element) {

            var stock_type = (element.id).substr(2, 4);
            if (stock_type == "CLOS")
                stock_type = "CLOSE";

            var qtyDev = document.getElementById('F_' + stock_type + '_DEV_QTY');
            var qtyStop = document.getElementById('F_' + stock_type + '_STOP_QTY');

            var qtyDevValue = qtyDev.value;
            var qtyStopValue = qtyStop.value;

            if (qtyDevValue == "")
                qtyDevValue = 0

            if (qtyStopValue == "")
                qtyStopValue = 0

            var und_total = parseFloat(qtyDevValue) + parseFloat(qtyStopValue)
            und_total = (und_total).toFixed(3);

            var und_type = stock_type.toLowerCase();
            var und_qty_total = document.getElementById(und_type + '_und_qty_total');
            und_qty_total.innerHTML = und_total;

            var qtyCast = document.getElementById('F_' + stock_type + '_CAST_QTY');
            var qtyCastValue = qtyCast.value;

            if (qtyCastValue == "")
                qtyCastValue = 0;

            // for whole total alert

            var total_type1 = (element.id).split('_');
            var total_type = total_type1[2] + "_" + total_type1[3];
            if (total_type == "TOT_QTY") {
                var rom_total = parseFloat(und_total) + parseFloat(qtyCastValue);
                if (rom_total != value) {
                    alert("Please enter the correct total");
                    $(element).val('');
                    return false;
                }
            }

            return true;
        }, "");

    },
    getStockType: function (element_id) {

        var stock_type = (element_id).substr(0, 4);

        if (stock_type == "clos")
            stock_type = "close";


        return stock_type;
    },
    getWorkType: function (element_id) {

        var temp_dev = element_id.indexOf("dev");
        var temp_stop = element_id.indexOf("stop");
        var temp_cast = element_id.indexOf("cast");

        var work_type = "";
        if (temp_dev != -1)
            work_type = "dev";
        if (temp_stop != -1)
            work_type = "stop";
        if (temp_cast != -1)
            work_type = "cast";

        return work_type;
    },
    metalGradeTotal: function () {

        var _this = this;
        _this.hit_count = 0;

        $(".grade-txtbox").blur(function () {
            _this.hit_count++;

            var element_id = $(this).attr('id');
            _this.stock_type = _this.getStockType(element_id);
            _this.work_type = _this.getWorkType(element_id);
            // for grade validation called in validateGradeTotal

            var element_no1 = (element_id).split('_');
            var element_no = "_" + element_no1[3];

            var select_box_name = document.getElementById(_this.stock_type + "_" + _this.work_type + "_metal" + element_no);
            var select_box_value = select_box_name.value;
            //console.log(select_box_value)
            var is_valid_total = _this.validateGradeTotal(select_box_value);

            if (is_valid_total == true) {
                if (_this.hit_count == 1) {
                    // CALLING THE AUTO-CALCULATED TABLE FUNCTION
                    _this.formulaImplementation();
                    //COMMENTED THE BELOW TWO LINES AS THERE IS NO NEED OF THEM NOW... AS I AM CALLING THE RE-CALCULATE FUNCTION EVERY TIME NOW
                    // 10th FEB 2014
                    //                    _this.initializeGradeCalculation();
                    //                    _this.calculateCastUndGradeTotal();
                }
            }
        });

        //if grade value is changed, make it back to 0
        $('.grade-txtbox').change(function () {
            _this.hit_count = 0;
        });

    },
    validateDropDown: function () {
        var _this = this;
        $(".grade-txtbox").focus(function () {
            var element_id = $(this).attr('id');

            var temp_stock_no1 = (element_id).split('_');
            var temp_stock_no = "_" + temp_stock_no1[3];

            _this.stock_type = _this.getStockType(element_id);
            _this.work_type = _this.getWorkType(element_id);

            //creating the select box id based on the grade text box selected  F_OPEN_DEV_QTY
            var select_box_id = document.getElementById(_this.stock_type + "_" + _this.work_type + "_metal" + temp_stock_no);
            var value = select_box_id.value;
            if (value == "") {
               /* var dataToAppend ="Please select the metal first";
                $('#'+element_id).parent().next('.err_cv').html(dataToAppend);*/
                alert('Please select the metal first');
                select_box_id.focus();
                $('.error-check').val('1');
            }
            else {
                $('.error-check').val('0');
            }
        });
    },
    validateGradeTotal: function (select_box_value) {

        this.gradeTable = document.getElementById(this.stock_type + "_" + this.work_type + "_table");

        var grp_element_value = 0;
        // ADDED THE BELOW CODE FOR GETTING THE CHILDS OF THE TABLE AND THEN RUNING THE LOOP
        // PREVIOUS CONDITION gradeTable.childNodes.length IS NOT HELP FULL AS TABLE CONTAIN TBODY 
        // SO THE COUNT WILL ALWAYS BE 1
        var tableLengthForLoop = $("#" + this.stock_type + "_" + this.work_type + "_table").find("tr").length;
        for (var i = 1; i <= tableLengthForLoop; i++) {
            var grade_grp_element_id = this.stock_type + "_" + this.work_type + "_grade_" + i;
            var grade_grp_element = document.getElementById(grade_grp_element_id);
            grade_grp_element.value = Utilities.roundOff2(grade_grp_element.value);


            var grade_value = $.trim(grade_grp_element.value);

            // validating the grade for min and max values
            this.customGradeValidation(grade_grp_element_id, grade_value, select_box_value);

            grp_element_value += parseFloat(grade_value);
        }

        //grp percentage should not exceed 100%
        if (grp_element_value > 100) {
            var error_div = document.getElementById(this.stock_type + "_" + this.work_type + "_error");
            if (!error_div) {
                error_div = document.createElement('div');
                error_div.innerHTML = "Please enter the total value less than or equal to 100";
                error_div.id = this.stock_type + "_" + this.work_type + "_error";
                error_div.className = "error-msg-div";
                $(error_div).appendTo($(this.gradeTable).parent());
            }
            return false;
        } else {
            $("#" + this.stock_type + "_" + this.work_type + "_error").remove();
            return true;
        }
    },
    gradeValidation: function (grade_value) {
        var msg = "";

        var length_msg = Utilities.maxLength(grade_value, 5);

        if (length_msg == "")
            var is_valid = true;
        else
            is_valid = false;

        if (is_valid == false) {
            var error_div = document.getElementById(this.stock_type + "_" + this.work_type + "_error");
            if (!error_div) {
                error_div = document.createElement('div');
                error_div.innerHTML = length_msg;
                error_div.id = this.stock_type + "_" + this.work_type + "_error";
                error_div.className = "error-msg-div";
                $(error_div).appendTo($(this.gradeTable).parent());
            }
            return false;
        } else {
            $("#" + this.stock_type + "_" + this.work_type + "_error").remove();
            return true;
        }
    },
    customGradeValidation: function (grade_id, grade_value, select_box_value) {
        // console.log(grade_id + "-"+ grade_value + "-"+ select_box_value)
        if (this.hit_count != 1)
            return;
        //    this.hit_count++;

        var element_grade_id = grade_id;
        if (select_box_value != "") {
            if (grade_value >= 100) {
                alert("Maximum grade value allowed is 99.99");
                $("#" + element_grade_id).val("");
                $('#error-check').val('1');
            }
            else if (grade_value <= 0) {
                alert("Please enter grade value greater than 0");
                $("#" + element_grade_id).val("");
                $('#error-check').val('1');
            }
            else {
                $('#error-check').val('0');
            }

        }
    },
    calculateUndGradeTotal: function (element_id, stock_type, work_type_1) {
        this.total_percent = 0;
        var element_no1 = element_id.split("_");
        var element_no = element_no1[3];
        var metal_element_1 = document.getElementById(stock_type + "_" + work_type_1 + "_metal_" + element_no);
        var grade_element_1 = document.getElementById(stock_type + "_" + work_type_1 + "_grade_" + element_no);
        var metal_value_1 = metal_element_1.value;
        var grade_value_1 = grade_element_1.value;

        if (work_type_1 == "dev")
            var work_type_2 = "stop";
        else if (work_type_1 == "stop")
            work_type_2 = "dev";
        else if (work_type_1 == "cast")
            return;

        var total_qty_1 = document.getElementById("F_" + stock_type.toUpperCase() + "_" + work_type_1.toUpperCase() + "_QTY").value;
        var total_qty_2 = document.getElementById("F_" + stock_type.toUpperCase() + "_" + work_type_2.toUpperCase() + "_QTY").value;
        if (total_qty_1 == "")
            total_qty_1 = 0;
        if (total_qty_2 == "")
            total_qty_2 = 0;

        // CHANGED FOR MAKING SOME MODIFICATION IN FORMULA
        total_qty_1 = parseFloat(total_qty_1);
        total_qty_2 = parseFloat(total_qty_2);
        var und_total_qty = total_qty_1 + total_qty_2;
        var temp_1 = total_qty_1 * (grade_value_1 / 100);
        //        console.log(temp_1)

        //        var table = document.getElementById(stock_type + "_" + work_type_2 + "_table");
        var tableLengthForLoop = $("#" + stock_type + "_" + work_type_2 + "_table").find("tr").length;
        //        console.log(table.childNodes.length)
        //        console.log(stock_type + "_" + work_type_2 + "_table")
        var temp_2 = 0;
        for (var i = 1; i <= tableLengthForLoop; i++) {
            var metal_element_2 = document.getElementById(stock_type + "_" + work_type_2 + "_metal_" + i);
            var metal_value_2 = metal_element_2.value;
            var grade_element_2 = document.getElementById(stock_type + "_" + work_type_2 + "_grade_" + i);
            var grade_value_2 = grade_element_2.value;

            if (metal_value_1 == metal_value_2) {
                temp_2 = total_qty_2 * (grade_value_2 / 100);
            }
        }
        //        console.log(temp_2)
        //console.log("-----")
        //console.log(temp_1)
        //console.log(temp_2)
        //console.log(total_qty_1)
        //console.log(total_qty_2)
        //console.log("-----")
        // CHANGED FOR MAKING SOME MODIFICATION IN FORMULA
        var tp;
        if (temp_1 == 0)
            tp = (temp_2 / total_qty_2) * 100;
        else if (temp_2 == 0)
            tp = (temp_1 / total_qty_1) * 100;
        else
            tp = ((temp_1 + temp_2) / und_total_qty) * 100;
        tp = tp.toFixed(2);

        //once calculated assign these values to alter the underground display table
        this.total_percent = tp;
        this.stock_type = stock_type;
        this.metal = metal_value_1;
    },
    reCalculateUndGradeTotal: function (grade_element_id, work_type_1) {

        var stock_type = this.getStockType(grade_element_id);


        var element_no1 = grade_element_id.split('_');
        var element_no = element_no1[3];


        //  var metal_element = document.getElementById(stock_type + "_" + work_type_1 + "_metal_" + element_no);
        var metal_value_1 = $('#' + stock_type + "_" + work_type_1 + "_metal_" + element_no).val();


        if (work_type_1 == "dev")
            var work_type_2 = "stop";
        else if (work_type_1 == "stop")
            work_type_2 = "dev";
        else if (work_type_1 == "cast")
            return;

        var total_qty_1 = document.getElementById("F_" + stock_type.toUpperCase() + "_" + work_type_1.toUpperCase() + "_QTY").value;

        var total_qty_2 = document.getElementById("F_" + stock_type.toUpperCase() + "_" + work_type_2.toUpperCase() + "_QTY").value;

        if (total_qty_1 == "")
            total_qty_1 = 0;
        if (total_qty_2 == "")
            total_qty_2 = 0;

        var und_total_qty = parseFloat(total_qty_1) + parseFloat(total_qty_2);


        var table = document.getElementById(stock_type + "_" + work_type_2 + "_table");
        var temp = 0;

        for (var i = 1; i <= table.childNodes.length; i++) {
            var metal_element_2 = document.getElementById(stock_type + "_" + work_type_2 + "_metal_" + i);
            var metal_value_2 = metal_element_2.value;
            var grade_element_2 = document.getElementById(stock_type + "_" + work_type_2 + "_grade_" + i);
            var grade_value_2 = grade_element_2.value;


            if (metal_value_1 == metal_value_2) {
                temp = total_qty_2 * (grade_value_2 / 100);

            }
        }
        var tp = (temp / und_total_qty) * 100;
        tp = tp.toFixed(2);



        //once calculated assign these values to alter the underground display table
        this.total_percent = tp;
        this.stock_type = stock_type;
        this.metal = metal_value_1;

        var und_total_metal_td = document.getElementById(this.stock_type + "_und_" + this.metal.toLowerCase() + "_value");
        if (temp == 0) {
            $(und_total_metal_td).parent().remove();
        } else {
            und_total_metal_td.innerHTML = this.total_percent;
        }

    },
    calculateCastGradeTotal: function (element_id, stock_type) {
        //        console.log(element_id + "-" + stock_type)
        var work_type = this.getWorkType(element_id);
        if (work_type != "cast")
            return;

        var element_no1 = element_id.split('_');
        var element_no = element_no1[3];
        var metal_element_1 = document.getElementById(stock_type + "_cast_metal_" + element_no);
        //        console.log(element_id)
        //        console.log(stock_type + "_cast_metal_" + element_no)
        //        console.log(metal_element_1)
        var grade_element_1 = document.getElementById(stock_type + "_cast_grade_" + element_no);
        var metal_value_1 = metal_element_1.value;
        var grade_value_1 = grade_element_1.value;

        var total_qty_1 = document.getElementById("F_" + stock_type.toUpperCase() + "_CAST_QTY").value;
        var total_qty_2 = document.getElementById(stock_type + "_und_qty_total").innerHTML;
        //        var und_total_qty = parseFloat(total_qty_1) + parseFloat(total_qty_2);
        //        var temp_1 = total_qty_1 * (grade_value_1 / 100);

        // CHANGED FOR MAKING SOME MODIFICATION IN FORMULA
        total_qty_1 = parseFloat(total_qty_1);
        total_qty_2 = parseFloat(total_qty_2);
        var und_total_qty = total_qty_1 + total_qty_2;
        var temp_1 = total_qty_1 * (grade_value_1 / 100);


        //        var und_table = document.getElementById(stock_type + "_und_metal_total");
        var und_table_length = $("#" + stock_type + "_und_metal_total").find("tr").length;

        var temp_2 = 0;
        for (var i = 1; i <= und_table_length; i++) {
            var grade_element_2 = document.getElementById(stock_type + "_und_" + metal_value_1.toLowerCase() + "_value");
            if (grade_element_2) {
                var grade_value_2 = grade_element_2.innerHTML;
                temp_2 = total_qty_2 * (parseFloat(grade_value_2) / 100);
            }
        }
        var tp;
        if (temp_1 == 0)
            tp = (temp_2 / total_qty_2) * 100;
        else if (temp_2 == 0)
            tp = (temp_1 / total_qty_1) * 100;
        else
            tp = ((temp_1 + temp_2) / und_total_qty) * 100;
        tp = tp.toFixed(2);

        //once calculated assign these values to alter the total display table
        this.total_percent = tp;
        this.stock_type = stock_type;
        this.metal = metal_value_1;
    },
    calculateCastUndGradeTotal: function () {
        var stock_type = this.stock_type;

        var und_total_table = document.getElementById(stock_type + "_und_metal_total");
        for (var i = 0; i < und_total_table.childNodes.length; i++) {
            var metal_value_1 = und_total_table.childNodes[i].childNodes[0].innerHTML;
            var grade_value_1 = und_total_table.childNodes[i].childNodes[1].innerHTML;

            var total_qty_1 = document.getElementById(stock_type + "_und_qty_total").innerHTML;
            var total_qty_2 = document.getElementById("F_" + stock_type.toUpperCase() + "_CAST_QTY").value;
            var und_total_qty = parseFloat(total_qty_1) + parseFloat(total_qty_2);
            var temp_1 = total_qty_1 * (grade_value_1 / 100);

            var cast_value_table = document.getElementById(stock_type + "_cast_table")
            var temp_2 = 0;
            for (var j = 1; j <= cast_value_table.childNodes.length; j++) {
                var metal_element_2 = document.getElementById(stock_type + "_cast_metal_" + j);
                var metal_value_2 = metal_element_2.value;
                var grade_element_2 = document.getElementById(stock_type + "_cast_grade_" + j);
                var grade_value_2 = grade_element_2.value;

                if (metal_value_1 == metal_value_2) {
                    temp_2 = total_qty_2 * (grade_value_2 / 100);
                }
            }
            var tp = ((temp_1 + temp_2) / und_total_qty) * 100;
            tp = tp.toFixed(2);

            //once calculated assign these values to alter the total display table
            this.total_percent = tp;
            this.stock_type = stock_type;
            this.metal = metal_value_1;
            this.addRowTotalTable();
        }

        return;

    },
    reCalculateCastGradeTotal: function (grade_element_id) {

        var stock_type = this.getStockType(grade_element_id);

        var element_no1 = grade_element_id.split('_');
        var element_no = element_no1[3];

        var metal_element = document.getElementById(stock_type + "_cast_metal_" + element_no);
        var metal_value_1 = metal_element.value;

        var total_qty_1 = document.getElementById("F_" + stock_type.toUpperCase() + "_CAST_QTY").value;
        var total_qty_2 = document.getElementById(stock_type + "_und_qty_total").innerHTML;
        if (total_qty_1 == "")
            total_qty_1 = 0;
        if (total_qty_2 == "")
            total_qty_2 = 0;

        var und_total_qty = parseFloat(total_qty_1) + parseFloat(total_qty_2);

        var und_table = document.getElementById(stock_type + "_und_metal_total");
        var temp = 0;
        for (var i = 1; i <= und_table.childNodes.length; i++) {
            var grade_element_2 = document.getElementById(stock_type + "_und_" + metal_value_1.toLowerCase() + "_value");
            if (grade_element_2) {
                var grade_value_2 = grade_element_2.innerHTML;
                temp = total_qty_2 * (parseFloat(grade_value_2) / 100);
            }
        }
        var tp = (temp / und_total_qty) * 100;
        tp = tp.toFixed(2);

        var und_total_metal_td = document.getElementById(stock_type + "_total_table_" + metal_value_1.toLowerCase() + "_value");
        if (temp == 0) {
            $(und_total_metal_td).parent().remove();
        } else {
            und_total_metal_td.innerHTML = tp;
        }

    },
    addRowUndTable: function () {
        if (this.metal == "")
            return;

        var und_table_data = document.getElementById(this.stock_type + "_und_" + this.metal.toLowerCase() + "_value")
        if (und_table_data) {
            und_table_data.innerHTML = this.total_percent;
        } else {
            var und_total_table = document.getElementById(this.stock_type + "_und_metal_total")
            var und_tr = document.createElement('tr');
            und_total_table.appendChild(und_tr);

            var und_metal_td = document.createElement('td');
            und_metal_td.id = this.stock_type + "_und_" + this.metal.toLowerCase();
            und_metal_td.innerHTML = this.metal;
            und_tr.appendChild(und_metal_td);

            var und_grade_td = document.createElement('td');
            und_grade_td.id = this.stock_type + "_und_" + this.metal.toLowerCase() + "_value";
            und_grade_td.innerHTML = this.total_percent;
            und_tr.appendChild(und_grade_td);
        }

    },
    addRowTotalTable: function () {
        if (isNaN(this.total_percent))
            return;

        var total_table_data = document.getElementById(this.stock_type + "_total_table_" + this.metal.toLowerCase() + "_value")
        if (total_table_data) {
            total_table_data.innerHTML = this.total_percent;
        } else {
            var total_table = document.getElementById(this.stock_type + '_total_table');
            var total_tr = document.createElement('tr');
            total_table.appendChild(total_tr);

            var total_metal_td = document.createElement('td');
            total_metal_td.id = this.stock_type + "_total_table_" + this.metal.toLowerCase();
            total_metal_td.innerHTML = this.metal;
            total_tr.appendChild(total_metal_td);

            var total_grade_td = document.createElement('td');
            total_grade_td.id = this.stock_type + "_total_table_" + this.metal.toLowerCase() + "_value";
            total_grade_td.innerHTML = this.total_percent;
            total_tr.appendChild(total_grade_td);
        }
    },
    changeGradeTotal: function () {
        var _this = this;

        $('.tot-qty').blur(function () {

            // CALLING THE AUTO-CALCULATED TABLE FUNCTION
            _this.formulaImplementation();
        });
    },
    // NEW CREATED 10TH FEB 2014
    formulaImplementation: function () {
        var _this = this;

        var value = $(this).attr('value');
        // checking for the null and 0 quantity value before proceding 
        if (value === "") {
            // setting the check-error input to 1 for post validation check
            $('.error-check').val('1');

        } else {
            // if value is filled the changing the value of error field back to 0
            $('.error-check').val('0');

            var stockTypeElemArr = ["open", "prod", "close"];
            var workTypeElemArr = ["dev", "stop", "cast"];

            /**
             * RUNNING THE LOOP FOR REFERSHING THE AUTO CALCULATED IF ANY OF
             * THE QUANTITY BOX IS FOUCUED OUT.
             * THIS IS BECAUSE CURRENTLY, THE AUTO-CALCULATED TABLE OF THE 
             * QUANTITY THAT WE CLICKED ONLY GETS RE-FRESHED
             * 
             * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
             * @version 10th Feb 2014
             *
             **/

            $.each(stockTypeElemArr, function (index, stock_type) {
                var undTableName = "#" + stock_type + "_und_metal_total";
                var totalTableName = "#" + stock_type + "_total_table";
                $(undTableName).empty();
                $(totalTableName).empty();

                $.each(workTypeElemArr, function (index, work_type) {

                    var tableLengthForLoop = $("#" + stock_type + "_" + work_type + "_table").find("tr").length;
                    for (var i = 1; i <= tableLengthForLoop; i++) {
                        var grade_element_id = stock_type + "_" + work_type + "_grade_" + i;

                        //calculate for underground display table after changing the total
                        _this.calculateUndGradeTotal(grade_element_id, stock_type, work_type);
                        if (_this.total_percent != 0)
                            _this.addRowUndTable();

                        //calculate for total display table after changing the total
                        _this.calculateCastGradeTotal(grade_element_id, stock_type);
                        if (_this.total_percent != 0)
                            _this.addRowTotalTable();

                    }

                });
            });

        }
    },
    formRomF5Validation: function () {
        $(document).ready(function () {
            // $("#frmRomF5").validate({
            $("#frmRomStocksOre").validate({
                rules: {
                    // "F[OPEN_UND_QTY]": {
                    //     required: true,
                    //     number: true,
                    //     min: 1,
                    //     maxlength: 12
                    // },
                    // "F[PROD_UND_QTY]": {
                    //     required: true,
                    //     number: true,
                    //     min: 0,
                    //     maxlength: 12
                    // },
                    // "F[CLOSE_UND_QTY]": {
                    //     required: true,
                    //     number: true,
                    //     min: 0,
                    //     maxlength: 12
                    // },
                    "f_open_dev_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_prod_dev_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_close_dev_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_open_stop_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_prod_stop_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_close_stop_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_open_cast_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_prod_cast_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_close_cast_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 12,
                        // qtyTotal: true
                    },
                    "f_open_tot_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 13,
                        max: 9999999999999,
                        // qtyTotal: true
                    },
                    "f_prod_tot_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 13,
                        max: 9999999999999,
                        // qtyTotal: true
                    },
                    "f_close_tot_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        maxlength: 13,
                        max: 9999999999999,
                        // qtyTotal: true
                    }
                },
                errorElement: "div",
                onkeyup: false,
                messages: {
                    // "F[OPEN_UND_QTY]": {
                    //     required: "Please enter quantity",
                    //     number: "Quantity should be a number",
                    //     min: "Quantity should not be negative"
                    // },
                    // "F[PROD_UND_QTY]": {
                    //     required: "Please enter quantity",
                    //     number: "Quantity should be a number",
                    //     min: "Quantity should not be negative"
                    // },
                    // "F[CLOSE_UND_QTY]": {
                    //     required: "Please enter quantity",
                    //     number: "Quantity should be a number",
                    //     min: "Quantity should not be negative"
                    // },
                    "f_open_dev_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        max: "Maximum allowed digits are 12",
                        min: ""
                    },
                    "f_prod_dev_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be zero or negative"
                    },
                    "f_close_dev_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be zero or negative"
                    },
                    "f_open_stop_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be zero or negative"
                    },
                    "f_prod_stop_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be zero or negative"
                    },
                    "f_close_stop_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be zero or negative"
                    },
                    "f_open_cast_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be zero or negative"
                    },
                    "f_prod_cast_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be zero or negative"
                    },
                    "f_close_cast_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be zero or negative"
                    },
                    "f_open_tot_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be negative"
                    },
                    "f_prod_tot_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be negative"
                    },
                    "f_close_tot_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        min: "Quantity should not be negative"
                    }
                }
            })
        });
    },
    dropDownValidation: function () {
        var _this = this;

        $(".metal-box").change(function () {
            var value = $(this).val();

            var element_id = $(this).attr('id');
            var element_no1 = (element_id).split("_");
            var element_no = element_no1[3];
            _this.stock_type = _this.getStockType(element_id);
            _this.work_type = _this.getWorkType(element_id);

            // checking for maximum no of select boxes
            var dropdown_table = document.getElementById(_this.stock_type + "_" + _this.work_type + "_table");
            var dropdown_length = dropdown_table.childNodes.length;

            for (var i = 1; i <= dropdown_length; i++) {
                if (element_no != i) {
                    var selected_element_id = document.getElementById(_this.stock_type + "_" + _this.work_type + "_metal_" + i);
                    var selected_element_value = selected_element_id.value;

                    if (selected_element_value == value) {
                        alert('Sorry, you can not select one metal more than once');
                        $(this).val("");
                    }
                }
            }

            //            _this.initializeGradeCalculation();
            //            _this.calculateCastUndGradeTotal();
            _this.formulaImplementation();
            _this.hit_count = 0;
        });
    },
    initializeGradeCalculation: function () {
        var _this = this;

        var qty = document.getElementById("F_" + _this.stock_type.toUpperCase()
                + "_" + _this.work_type.toUpperCase() + "_QTY").value;
        if (qty == "")
            return;

        if (_this.work_type != "cast") {

            var und_value_table = document.getElementById(_this.stock_type + "_" + _this.work_type + "_table")
            var und_total_table = document.getElementById(_this.stock_type + "_und_metal_total")
            $(und_total_table).empty();
            for (var i = 1; i <= und_value_table.childNodes.length; i++) {
                var elem_id = _this.stock_type + "_" + _this.work_type + "_metal_" + i;
                //                _this.calculateUndGradeTotal(elem_id, _this.stock_type, _this.work_type);
                _this.formulaImplementation();
                _this.addRowUndTable();
            }

            if (_this.work_type == "dev")
                var work_type_2 = "stop";
            else if (_this.work_type == "stop")
                work_type_2 = "dev";
            else if (_this.work_type == "cast")
                work_type_2 = "cast";

            var und_value_table_2 = document.getElementById(_this.stock_type + "_" + work_type_2 + "_table")
            for (var i = 1; i <= und_value_table_2.childNodes.length; i++) {
                var elem_id_2 = _this.stock_type + "_" + work_type_2 + "_metal_" + i;
                //                _this.calculateUndGradeTotal(elem_id_2, _this.stock_type, work_type_2);
                _this.formulaImplementation();
                //                _this.calculateUndGradeTotal(elem_id_2, _this.stock_type, work_type_2);
                _this.addRowUndTable();
            }
        } else {
            //CAST TOTAL TABLE
            var cast_value_table = document.getElementById(_this.stock_type + "_cast_table")
            var cast_total_table = document.getElementById(_this.stock_type + "_total_table")
            $(cast_total_table).empty();

            for (var i = 1; i <= cast_value_table.childNodes.length; i++) {
                // ADDED _this.stock_type + "_ AS IN THE calculateCastGradeTotal 3 VALUES IS TABKE AFTER SPLIT AND IF WE 
                // DON'T SEND THE  STOCK TYPE IN THIS WAY THEN 3 ELEMENT IS ALWAYS EMPTY
                // 10th FEB 2014
                // Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                var elem_id = _this.stock_type + "_cast_element_" + i;
                //                var elem_id = "cast_element_" + i; //since we are going to take the i value alone, we can prepend any string
                //                _this.calculateCastGradeTotal(elem_id, _this.stock_type);
                _this.formulaImplementation();
                _this.addRowTotalTable();
            }

            _this.calculateCastUndGradeTotal();

        }

    },
    checkQuantityUpdation: function () {
        $('.tot-qty').focus(function () {
            this.old_quantity_id = $(this).attr('id');
            this.old_quantity_value = $(this).val();
        });
        $('.tot-qty').focusout(function () {
            this.new_quantity_id = $(this).attr('id');
            this.new_quantity_value = $(this).val();
            var elementClasses = $(this).attr('class');
            //            console.log(elementClasses)
            /**
             * CHANGED THE ALERT TO SHOW ONLY IN CASE OF OPENING STOCK.
             * THIS IS CHANGED ON IBM REQUEST AND IS AS PER THE SRS
             * @author Uday Shankar Singh
             * @version 17th FEB 2014
             * 
             **/
            var elementClassFoundFlag = false;
            var openingQtyArr = ["open_dev_qty", "open_stop_qty", "open_cast_qty"]
            $.each(openingQtyArr, function (index, value) {
                if (elementClasses.match(value)) {
                    elementClassFoundFlag = true;
                }
            });

            // SHOWING THE ALERT ONLY IF THE FLAG IS UP ELSE DON'T SHOW IT
            // @author Uday Shankar Singh
            // @version 17th FEFB 2014
            if (this.old_quantity_value != this.new_quantity_value) {
                if (elementClassFoundFlag) {
                    alert("Please send an e-mail to IBM clarifying this variation.");
                }
            }
        });
    },
    checkOpenDevGradeUpdation: function () {
        $('.open_dev_grade').focus(function () {
            this.old_grade_id = $(this).attr('id');
            this.old_grade_value = $(this).val();
        });
        $('.open_dev_grade').focusout(function () {
            this.new_grade_id = $(this).attr('id');
            this.new_grade_value = $(this).val();

            if (this.old_grade_value != this.new_grade_value) {
                alert("Please send an e-mail to IBM clarifying this variation.");
            }
        });
    },
    checkOpenCastGradeUpdation: function () {
        $('.open_cast_grade').focus(function () {
            this.old_grade_id = $(this).attr('id');
            this.old_grade_value = $(this).val();
        });
        $('.open_cast_grade').focusout(function () {
            this.new_grade_id = $(this).attr('id');
            this.new_grade_value = $(this).val();

            if (this.old_grade_value != this.new_grade_value) {
                alert("Please send an e-mail to IBM clarifying this variation.");
            }
        });
    },
    checkGradeRequiredStar: function () {

        var _this = this;
        $(".one_grade_more").blur(function () {
            var element_id = $(this).attr('id');
            _this.stock_type = _this.getStockType(element_id);
            _this.work_type = _this.getWorkType(element_id);

            var element_no1 = (element_id).split('_');
            var element_no = "_" + element_no1[3];
            var req_field_chk = $("#" + _this.stock_type + "_" + _this.work_type + "_grade" + element_no).val();

            if (req_field_chk > 0) {
                $("#" + _this.stock_type + "_" + _this.work_type + "_required").empty();

                var qty_val = $("#F_" + _this.stock_type.toUpperCase() + "_" + _this.work_type.toUpperCase() + "_QTY");
                /*if(qty_val.val() < 1){
                 alert("Please enter the quantity");
                 $(qty_val).val('');
                 }*/
            }
        });

    },
    checkMetalRequiredStar: function () {
        var _this = this;
        $(".metal-box").blur(function () {
            var element_id = $(this).attr('id');
            _this.stock_type = _this.getStockType(element_id);
            _this.work_type = _this.getWorkType(element_id);

            var element_no = (element_id).substr(-2, 2);

            var req_field_chk = $("#" + _this.stock_type + "_" + _this.work_type + "_metal" + element_no).val();

            if (req_field_chk == "") {
                $("#" + _this.stock_type + "_" + _this.work_type + "_required").empty();
                $("#" + _this.stock_type + "_" + _this.work_type + "_required").css("color", "red");
                $("#" + _this.stock_type + "_" + _this.work_type + "_required").append('*');
            }
            else {
                $("#" + _this.stock_type + "_" + _this.work_type + "_required").empty();
            }
        });

    },
    f5PostValidation: function () {
        var _this = this;

        // $('#frmRomF5').submit(function (event) {
        $('#frmRomStocksOre').submit(function (event) {
            var check_select = _this.checkEmptyDD();
            if (check_select == false) {
                event.preventDefault();
            }

            // getting custom defined array of table from above
            var romTables = _this.romTables;
            for (var i = 0; i < romTables.length; i++) {
                var quantity_value = $("." + romTables[i] + "_qty").val();
                var metal_value = $("." + romTables[i] + "_metal").val();
                var grade_value = $("." + romTables[i] + "_grade").val();

                //        if(quantity_value == 0 ){
                //          var error_flag_1 = "1";
                //        }
                if (quantity_value != 0) {
                    if (grade_value == 0 || metal_value == "" || grade_value == 0.00) {
                        // $("#" + romTables[i] + "_required").empty();
                        // $("#" + romTables[i] + "_required").css("color", "red");
                        // $("#" + romTables[i] + "_required").append('*');

                        var error_flag_2 = "1";
                    }
                }
            }
            var error_check = $('#error-check').val();

            //      if(error_check == '1' || error_flag_1 == "1" || error_flag_2 == "1"){
            if (error_check == '1' || error_flag_2 == "1") {
                alert('Form contain errors. Please enter correct details');
                event.preventDefault();
            }
        });
    },
    checkEmptyDD: function () {
        var select_boxs = new Array();
        select_boxs = document.getElementsByTagName("select");

        var select_error_flag = 0;
        for (var i = 0; i < select_boxs.length; i++) {
            var quantity_value = $(select_boxs[i]).parent().parent().parent().parent().prev().children(':first-child').val();
            if (quantity_value != 0) {
                if (select_boxs[i]['value'] == "") {
                    select_error_flag = select_error_flag + 1;
                }
            }
        }

        if (select_error_flag > 0) {
            alert('Select Options in all Select Boxes. If No metal Content/Grade then Select NIL');
            return false
        }
        else
            return true;
    },
    estProdF5Validation: function () {
        var cum_prod = document.getElementById('cum_prod').value;
        var estimated_prod = document.getElementById('estimated_prod').value;

        var prod_value = document.getElementById('f_prod_tot_qty').value;
        var form_entry_total = parseFloat(prod_value);

        var total_prod = parseFloat(cum_prod) + form_entry_total;

        if (total_prod > estimated_prod)
            alert('Cumulative production of ROM exceeded the approved production for the financial year');
    },
    quantityRoundToZero: function () {
        $('.tot-qty').focusout(function () {
            this.quantityValue = $(this).val();
            var roundedQuantity = Utilities.roundOff0(this.quantityValue);
            this.quantityValue = $(this).val(roundedQuantity);
        });
    },
    formExMineF5Validation: function () {
        $(document).ready(function () {
            
            jQuery.validator.addMethod("roundOff2", function (value, element) {
                var temp = new Number(value);
                element.value = (temp).toFixed(2);
                return true;
            }, "");

            $("#frmExMineF5").validate({
                rules: {
                    "f_pmv": {
                        required: true,
                        number: true,
                        min: 0,
                        max: 99999999.99,
                        roundOff2: true
                    }
                },
                errorElement: "div",
                onkeyup: false,
                messages: {
                    "f_pmv": {
                        required: "Please enter ex-mine price",
                        number: "Ex-mine price is not a valid number"
                    }
                }
            });
        });

        // $("#frmExMineF5").submit(function () {
        //     var totalRomProd = $("#totalRomProd").val();
        //     var pmv = $("#f_pmv").val();

        //     if (pmv == 0) {
        //         if (totalRomProd > 0) {
        //             alert("Please enter the ex-mine price > 0");
        //             return false;
        //         }
        //     }
        // });
    },
    checkReason: function () {
        var prevProd = parseInt(document.getElementById('prev_month_prod').value);

        // $("#frmRomF5").submit(function () {
        /* commented below code as "reason" field is not coming in "Production / Stocks (ROM)"
         * PHASE II modification
        $("#frmRomStocksOre").submit(function () {
            var curProd = $("#f_prod_tot_qty").val();
            var temp = ((prevProd * 20) / 100);
            var reason = document.getElementById("F_INC_REASON").value;
            if ((curProd > (temp + prevProd) || curProd < (prevProd - temp)) && (reason == "")) {
                alert("Since the production varies more than 20% than previous month's production, please enter the reason");
                return false;
            }
        });
        */
    },
    checkClosingStock: function () {
        $('#F_CLOSE_DEV_QTY').blur(function () {
            var close_val = parseInt($(this).val());
            var open_val = parseInt($('#F_OPEN_DEV_QTY').val());
            var prod_val = parseInt($('#F_PROD_DEV_QTY').val());

            if (close_val > (open_val + prod_val)) {
                alert("Closing stock should be less than the sum of production and opening stock");
                $(this).val('')
            }

        });

        $('#F_CLOSE_STOP_QTY').blur(function () {
            var close_val = parseInt($(this).val());
            var open_val = parseInt($('#F_OPEN_STOP_QTY').val());
            var prod_val = parseInt($('#F_PROD_STOP_QTY').val());

            if (close_val > (open_val + prod_val)) {
                alert("Closing stock should be less than the sum of production and opening stock");
                $(this).val('')
            }

        });

        $('#F_CLOSE_CAST_QTY').blur(function () {
            var close_val = parseInt($(this).val());
            var open_val = parseInt($('#F_OPEN_CAST_QTY').val());
            var prod_val = parseInt($('#F_PROD_CAST_QTY').val());

            if (close_val > (open_val + prod_val)) {
                alert("Closing stock should be less than the sum of production and opening stock");
                $(this).val('')
            }

        });
    },
    autoFillForZeroProduction: function () {
        $(".metal-box").unbind("change");
        $(".metal-box").change(function () {
            var metalBoxId = $(this).attr('id');
            var metalBoxVal = $(this).val();

            var splitMetalBoxId = metalBoxId.split("_");
            var quantityFieldId = "F_" + splitMetalBoxId[0].toUpperCase() + "_" + splitMetalBoxId[1].toUpperCase() + "_QTY";
            var gradeFieldId = metalBoxId.replace("metal", "grade");
            if (metalBoxVal == 'NIL') {
                var buttonClicked = window.confirm("Selecting NIL in the Metal Content/grade will automatically put 0 in corresponding Quantity and Grade. \nAre you sure want to continue?");
                if (buttonClicked == true) {
                    $("#" + quantityFieldId).val(0);
                    $("#" + gradeFieldId).val("0.00");
                }
                else {
                    $(this).val("");
                }
            }
            //      else{
            //        $("#" + quantityFieldId).val("");
            //        $("#" + gradeFieldId).val("");
            //
            //      }

        });
    }
}

var f5Con = {
    init: function (metal_url, data_url) {
        Utilities.ajaxBlockUI();
        this.metalUrl = metal_url;
        this.dataUrl = data_url;

        Utilities.roundOff();
        this.conTables = new Array('open_ore', 'rec_ore', 'treat_ore', 'con_obt', 'tail_ore', 'close_con');
        this.conRenderTables();
        this.addBtn();

    },
    conRenderTables: function () {
        var _this = this;

        $.ajax({
            url: _this.metalUrl,
            type: 'POST',
			async: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (response) {
                _this.metals = json_parse(response);
            }
        });
		
		$.ajax({
			url: _this.dataUrl,
			type: 'POST',
			async: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
			success: function (response) {
				_this.data = json_parse(response);
				_this.rom_data = _this.data.rom;
				_this.con_data = _this.data.con;
				
				if (_this.rom_data == "" && _this.con_data == "") {
					_this.createConSubTables();
				} else {
					_this.renderEditForm();
				}

				//            _this.dropDownValidation();
				//            _this.RomQuantityCustomValidation();
				_this.ConQuantityDDValidation();
				_this.ConQuantityCustomValidation();
				_this.MetaldropDownValidation();
				_this.formConRecoF5Validation();
				_this.GradeDDValidation();
				_this.romMetalGradeTotal();
				_this.conF5PostValidation();
				_this.romCheckGradeRequiredStar();
				_this.romCheckMetalRequiredStar();
				_this.oreTreatedQuantityValidation();
				_this.conTextFieldValidation();
				_this.autoFillForZeroProduction();
			}
		});
    },
    createConSubTables: function () {

        for (var i = 0; i < this.conTables.length; i++) {
            var sub_table = document.getElementById(this.conTables[i] + "_table");

            var tr = $(document.createElement('tr'));
            $('#' + this.conTables[i] + "_table").append(tr);

            var metal_td = $(document.createElement('td'));
            tr.append(metal_td);

            var select_box = $(document.createElement('select'));
            select_box.attr('id', this.conTables[i] + "_metal_1");
            select_box.attr('name', this.conTables[i] + "_metal_1");
            select_box.addClass(this.conTables[i] + "_metal metal-box");
            metal_td.append(select_box);

            var dummy_option = $(document.createElement('option'));
            dummy_option.html("- Select -");
            dummy_option.val("");
            select_box.append(dummy_option);

            for (var j = 0; j < Object.keys(this.metals).length - 1; j++) {
                var options = $(document.createElement('option'));
                options.html(this.metals[j]);
                options.val(this.metals[j]);
                select_box.append(options);
            }

            if (this.conTables[i] == "con_obt") {
                this.renderQuantityField(tr, i, 1);
                this.renderConFields(1);
            } else if (this.conTables[i] == "close_con") {
                this.renderQuantityField(tr, i, 1);
                this.renderClosingStockGrade(1);
            } else {
                var grade_td = $(document.createElement('td'));
                tr.append(grade_td);

                var grade = $(document.createElement('input'));
                grade.attr('id', this.conTables[i] + "_grade_1");
                grade.attr('name', this.conTables[i] + "_grade_1");
                grade.addClass(this.conTables[i] + "_grade grade-txtbox");
                grade.attr('maxLength', "5");
                grade_td.append(grade);

                var required_td = $(document.createElement('td'));
                required_td.attr('id', this.conTables[i] + "_required");
                tr.append(required_td);


            }
            //since this is a new record, initialize the count to 1 for all.
            var metal_count = document.getElementById(this.conTables[i] + "_metal_count");
            metal_count.value = 1;
        }

    },
    renderEditForm: function () {

        //for edit form initialize the metal count to 0 for all.
        for (var i = 0; i < this.conTables.length; i++) {
            var mc = document.getElementById(this.conTables[i] + "_metal_count");
            mc.value = 0;
        }

        this.renderRomDataTable();
        this.renderConDataTable();
        this.conTextFieldValidation();

    },
    renderQuantityField: function (tr, i, element_no) {
        var quantity_td = $(document.createElement('td'));
        tr.append(quantity_td);

        var quantity = $(document.createElement('input'));
        quantity.attr('id', this.conTables[i] + "_quantity_" + element_no);
        quantity.attr('name', this.conTables[i] + "_quantity_" + element_no);
        quantity.addClass(this.conTables[i] + "_quantity quantity-txtbox");
        quantity.attr('maxLength', "16");
        quantity_td.append(quantity);
    },
    renderConFields: function (element_no, id) {
        var _this = this;
        var metal_value_table = document.getElementById('con_obt_metal_value_table');

        var metal_value_tr = $(document.createElement('tr'));
        $('#con_obt_metal_value_table').append(metal_value_tr);

        var metal_value_td = $(document.createElement('td'));
        metal_value_tr.append(metal_value_td);

        var metal_value = $(document.createElement('input'));
        metal_value.attr('id', "con_obt_metal_value_" + element_no);
        metal_value.attr('name', "con_obt_metal_value_" + element_no);
        metal_value.addClass("metal-value-txtbox");
        metal_value.attr('maxLength', "16");
        metal_value_td.append(metal_value);

        var grade_table = document.getElementById('con_obt_grade_table');

        var grade_tr = $(document.createElement('tr'));
        $('#con_obt_grade_table').append(grade_tr);

        var grade_td = $(document.createElement('td'));
        grade_tr.append(grade_td);

        var grade = $(document.createElement('input'));
        grade.attr('id', "con_obt_grade_" + element_no);
        grade.attr('name', "con_obt_grade_" + element_no);
        grade.addClass("con-obt-grade grade-txtbox");
        grade.attr('maxLength', "5");
        grade_td.append(grade);

        //close button
        if (element_no != 1) {
            var close_td = $(document.createElement('td'));
            close_td.addClass("close-symbol");
            // console.log("clicked")
            // console.log("uday")
            close_td.bind('click', function () {
                $(this).parent().remove();
                var metal_value = document.getElementById("con_obt_metal_value_" + element_no);
                $(metal_value).parent().remove();
                var qty_tr = document.getElementById("con_obt_quantity_" + element_no);
                $(qty_tr).parent().parent().remove();

                //rename the id and name for the other text and select boxes
                _this.renameBoxes(id);

                //hidden metal count
                var metal_count = document.getElementById(id + "_metal_count");
                var prev_metal_count = metal_count.value;
                var dec_metal_count = parseInt(prev_metal_count) - 1;
                metal_count.value = dec_metal_count;
            });
            grade_tr.append(close_td);
        }
    },
    renderClosingStockGrade: function (element_no, grade_value) {
        var _this = this;
        var grade_table = $(document.getElementById('close_con_grade_table'));

        var grade_tr = $(document.createElement('tr'));
        grade_table.append(grade_tr);

        var grade_td = $(document.createElement('td'));
        grade_tr.append(grade_td);

        var grade = $(document.createElement('input'));
        grade.attr('id', "close_con_grade_" + element_no);
        grade.attr('name', "close_con_grade_" + element_no);
        grade.addClass("close-con-grade grade-txtbox");
        grade.attr('maxLength', "5");
        if (grade_value)
            grade.val(grade_value);
        grade_td.append(grade);

        //close button
        if (element_no != 1) {
            var close_td = $(document.createElement('td'));
            close_td.addClass("close-symbol");
            // console.log("clicked1")
            close_td.bind('click', function () {
                $(this).parent().remove();
                var close_con_qty = document.getElementById("close_con_quantity_" + element_no);
                $(close_con_qty).parent().parent().remove();

                //rename the id and name for the other text and select boxes
                _this.renameBoxes('close_con', 1);

                //hidden metal count
                var metal_count = document.getElementById("close_con_metal_count");
                var prev_metal_count = metal_count.value;
                var dec_metal_count = parseInt(prev_metal_count) - 1;
                metal_count.value = dec_metal_count;
            });
            grade_tr.append(close_td);
        }

    },
    addBtn: function () {
        var _this = this;
        for (var i = 0; i < this.conTables.length; i++) {
            var tbl = document.getElementById(this.conTables[i] + "_table");
            var btn = document.getElementById(this.conTables[i] + "_add_btn");

            btn.onclick = function (id) {
                return function (evt) {
                    var tbl = document.getElementById(id + "_table");
                    var new_row = $(document.createElement('tr'));
                    $('#' + id + "_table").append(new_row);

                    var metal_td = $(document.createElement('td'));
                    new_row.append(metal_td);

                    //hidden metal count
                    var metal_count = document.getElementById(id + "_metal_count");
                    var prev_metal_count = metal_count.value;
                    if (prev_metal_count == _this.metals.length) {
                        alert("Sorry! You can't add more than " + _this.metals.length + " records");
                        return;
                    }
                    var inc_metal_count = parseInt(prev_metal_count) + 1;
                    metal_count.value = inc_metal_count;

                    //metal select box
                    var select_box = $(document.createElement('select'));
                    select_box.attr('id', id + "_metal_" + inc_metal_count);
                    select_box.attr('name', id + "_metal_" + inc_metal_count);
                    select_box.addClass(id + "_metal metal-box")
                    metal_td.append(select_box);

                    var dummy_option = $(document.createElement('option'));
                    dummy_option.html("- Select -");
                    dummy_option.val("");
                    select_box.append(dummy_option);

                    for (var j = 0; j < Object.keys(_this.metals).length - 1; j++) {
                        var options = $(document.createElement('option'));
                        options.html(_this.metals[j]);
                        options.val(_this.metals[j]);
                        select_box.append(options);
                    }

                    if (id == "con_obt") {
                        _this.renderQuantityField(new_row, 3, inc_metal_count);
                        _this.renderConFields(inc_metal_count, id);
                    } else if (id == "close_con") {
                        _this.renderQuantityField(new_row, 5, inc_metal_count);
                        _this.renderClosingStockGrade(inc_metal_count);
                    } else {
                        //grade box
                        var grade_td = $(document.createElement('td'));
                        new_row.append(grade_td);

                        var grade = $(document.createElement('input'));
                        grade.attr('id', id + "_grade_" + inc_metal_count);
                        grade.attr('name', id + "_grade_" + inc_metal_count);
                        grade.addClass(id + "_grade grade-txtbox");
                        grade_td.append(grade);
                    }

                    //close button
                    if (id == "con_obt" || id == "close_con") {
                        // console.log("inhere")
                        //do nothing
                    } else {
                        var close_td = $(document.createElement('td'));
                        close_td.addClass("close-symbol");
                        // console.log("clicked2")
                        close_td.unbind('click');
                        close_td.bind('click', function () {
                            // console.log("singh is king")
                            $(this).parent().remove();

                            //rename the id and name for the other text and select boxes
                            _this.renameBoxes(id);

                            //hidden metal count
                            var metal_count = document.getElementById(id + "_metal_count");
                            var prev_metal_count = metal_count.value;
                            var dec_metal_count = parseInt(prev_metal_count) - 1;
                            metal_count.value = dec_metal_count;
                        });
                        new_row.append(close_td);
                    }
                    //call the validation for the newly generated elements
                    //          _this.dropDownValidation();
                    _this.GradeDDValidation();
                    _this.MetaldropDownValidation();
                    _this.ConQuantityDDValidation();
                    _this.romMetalGradeTotal();
                    _this.conTextFieldValidation();
                }
            }(this.conTables[i]);
        }
    },
    renderRomDataTable: function () {
        var _this = this;
        for (var i = 0; i < this.rom_data.length; i++) {
            var sub_table = document.getElementById(this.rom_data[i]['table'] + "_table");

            var tr = $(document.createElement('tr'));
            $('#' + this.rom_data[i]['table'] + "_table").append(tr);

            var metal_td = $(document.createElement('td'));
            tr.append(metal_td);

            //hidden metal count
            var metal_count = document.getElementById(this.rom_data[i]['table'] + "_metal_count");
            var prev_metal_count = metal_count.value;
            var inc_metal_count = parseInt(prev_metal_count) + 1;
            metal_count.value = inc_metal_count;

            //metal select box
            var select_box = $(document.createElement('select'));
            select_box.attr('id', this.rom_data[i]['table'] + "_metal_" + inc_metal_count);
            select_box.attr('name', this.rom_data[i]['table'] + "_metal_" + inc_metal_count);
            select_box.addClass(this.rom_data[i]['table'] + "_metal metal-box");
            metal_td.append(select_box);

            var dummy_option = $(document.createElement('option'));
            dummy_option.html("- Select -");
            dummy_option.val("");
            select_box.append(dummy_option);

            for (var j = 0; j < Object.keys(this.metals).length - 1; j++) {
                var options = $(document.createElement('option'));
                options.html(this.metals[j]);
                options.val(this.metals[j]);
                select_box.append(options);
            }

            select_box.val(this.rom_data[i]['metal']);

            //grade text box
            var grade_td = $(document.createElement('td'));
            tr.append(grade_td);

            var grade = $(document.createElement('input'));
            grade.attr('id', this.rom_data[i]['table'] + "_grade_" + inc_metal_count);
            grade.attr('name', this.rom_data[i]['table'] + "_grade_" + inc_metal_count);
            grade.addClass(this.rom_data[i]['table'] + "_grade grade-txtbox");
            grade.val(this.rom_data[i]['grade']);
            grade_td.append(grade);
            var required_td = $(document.createElement('td'));
            required_td.attr('id', this.rom_data[i]['table'] + "_required")
            tr.append(required_td);


            var tmp_qty_id = this.rom_data[i]['table'].toUpperCase() + "_QTY";
            var quantity = document.getElementById(tmp_qty_id);
            quantity.value = this.rom_data[i]['tot_qty'];

            if (prev_metal_count > 0) {
                //close button
                var close_td = $(document.createElement('td'));
                close_td.addClass("close-symbol");
                // console.log("clicked4")            


                close_td.bind('click', function (id) {

                    /**
                     * REMOVED THIS RETURN FUNCTION AS THIS IS USED TO GET THE ID OF THE ELEMENT ON CLICK EVENT 
                     * BUT THE REMOVE BUTTON HAS ONLY CLASS AND THUS THIS IS CREATING PROBLEM WHILE DELETEING THE RECROR
                     * 
                     * ALSO ADDED THE BELOW 3 LINES FOR GETTING THE ID OF THE ELEMENT ON CLICK OF THE REMOVE
                     * 
                     * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
                     * @version 20th Jan 2014
                     **/
                    //          return function() { 
                    //rename the id and name for the other text and select boxes
                    var rowElementId = $(this).closest('tr').find('td:first select').attr('id');
                    var rowElementIdTemp = rowElementId.split("_");
                    var id = rowElementIdTemp[0] + "_" + rowElementIdTemp[1];

                    _this.renameBoxes(id);

                    $(this).parent().remove();

                        // console.log("udrockxxxx")
                        // return function() {
                        //     console.log("tummile")
                    $(this).parent().remove();

                    //rename the id and name for the other text and select boxes
                    _this.renameBoxes(id);

                    //hidden metal count
                    var metal_count = document.getElementById(id + "_metal_count");
                    var prev_metal_count = metal_count.value;
                    var dec_metal_count = parseInt(prev_metal_count) - 1;
                    metal_count.value = dec_metal_count;
                    // }
                });
                // (this.rom_data[i]['table']);
                tr.append(close_td);
            }
        }
    },
    renderConDataTable: function () {
        var _this = this;
        var con_obt_table = document.getElementById('con_obt_table');
        var metal_value_table = document.getElementById('con_obt_metal_value_table');
        var grade_table = document.getElementById('con_obt_grade_table');

        var close_con_table = document.getElementById('close_con_table');

        for (var i = 0; i < this.con_data.length; i++) {

            if (this.con_data[i].table == 'con_obt') {
                //hidden metal count
                var metal_count = document.getElementById("con_obt_metal_count");
                var prev_metal_count = metal_count.value;
                var inc_metal_count = parseInt(prev_metal_count) + 1;
                metal_count.value = inc_metal_count;

                var quantity_tr = $(document.createElement('tr'));
                $('#con_obt_table').append(quantity_tr);

                //metal
                var metal_td = $(document.createElement('td'));
                quantity_tr.append(metal_td);

                var select_box = $(document.createElement('select'));
                select_box.attr('id', "con_obt_metal_" + inc_metal_count);
                select_box.attr('name', "con_obt_metal_" + inc_metal_count);
                select_box.addClass("con_obt_metal metal-box");
                metal_td.append(select_box);

                var dummy_option = $(document.createElement('option'));
                dummy_option.html("- Select -");
                dummy_option.val("");
                select_box.append(dummy_option);

                for (var j = 0; j < Object.keys(this.metals).length - 1; j++) {
                    var options = $(document.createElement('option'));
                    options.html(this.metals[j]);
                    options.val(this.metals[j]);
                    select_box.append(options);
                }

                select_box.val(this.con_data[i].metal);

                //quantity
                var quantity_td = $(document.createElement('td'));
                quantity_tr.append(quantity_td);

                var quantity = $(document.createElement('input'));
                quantity.attr('id', "con_obt_quantity_" + inc_metal_count);
                quantity.attr('name', "con_obt_quantity_" + inc_metal_count);
                quantity.addClass("con_obt_quantity quantity-txtbox right");
                quantity.attr('maxLength', "16");
                quantity.val(this.con_data[i].tot_qty);
                quantity_td.append(quantity);

                //metal value
                var metal_value_tr = $(document.createElement('tr'));
                $('#con_obt_metal_value_table').append(metal_value_tr);

                var metal_value_td = $(document.createElement('td'));
                metal_value_tr.append(metal_value_td);

                var metal_value = $(document.createElement('input'));
                metal_value.attr('id', "con_obt_metal_value_" + inc_metal_count);
                metal_value.attr('name', "con_obt_metal_value_" + inc_metal_count);
                metal_value.addClass("metal-value-txtbox");
                metal_value.val(this.con_data[i].con_value);
                metal_value_td.append(metal_value);

                //grade
                var grade_tr = $(document.createElement('tr'));
                $('#con_obt_grade_table').append(grade_tr);

                var grade_td = $(document.createElement('td'));
                grade_tr.append(grade_td);

                var grade = $(document.createElement('input'));
                grade.attr('id', "con_obt_grade_" + inc_metal_count);
                grade.attr('name', "con_obt_grade_" + inc_metal_count);
                grade.addClass("con-obt-grade grade-txtbox");
                grade.attr('maxLength', "5");
                grade.val(this.con_data[i].grade);
                grade_td.append(grade);

                //close button
                if (inc_metal_count != 1) {
                    var close_td = $(document.createElement('td'));
                    close_td.addClass("close-symbol");
                    // console.log("clicked5")
                    close_td.bind('click', function () {
                        $(this).parent().remove();
                        var metal_value = document.getElementById("con_obt_metal_value_" + inc_metal_count);
                        $(metal_value).parent().remove();
                        var qty_tr = document.getElementById("con_obt_quantity_" + inc_metal_count);
                        $(qty_tr).parent().parent().remove();

                        //rename the id and name for the other text and select boxes
                        _this.renameBoxes('con_obt', 1);

                        //hidden metal count
                        var metal_count = document.getElementById("con_obt_metal_count");
                        var prev_metal_count = metal_count.value;
                        var dec_metal_count = parseInt(prev_metal_count) - 1;
                        metal_count.value = dec_metal_count;
                    });
                    grade_tr.append(close_td);
                }
            } else {
                //hidden metal count
                var mc = document.getElementById("close_con_metal_count");
                var prev_mc = mc.value;
                var inc_mc = parseInt(prev_mc) + 1;
                mc.value = inc_mc;

                var quantity_tr = $(document.createElement('tr'));
                $('#close_con_table').append(quantity_tr);

                //metal
                var metal_td = $(document.createElement('td'));
                quantity_tr.append(metal_td);

                var select_box = $(document.createElement('select'));
                select_box.attr('id', "close_con_metal_" + inc_mc);
                select_box.attr('name', "close_con_metal_" + inc_mc);
                select_box.addClass("close_con_metal metal-box");
                metal_td.append(select_box);

                var dummy_option = $(document.createElement('option'));
                dummy_option.html("- Select -");
                dummy_option.val("");
                select_box.append(dummy_option);

                for (var j = 0; j < Object.keys(this.metals).length - 1; j++) {
                    var options = $(document.createElement('option'));
                    options.html(this.metals[j]);
                    options.val(this.metals[j]);
                    select_box.append(options);
                }

                select_box.val(this.con_data[i].metal);

                //quantity
                var quantity_td = $(document.createElement('td'));
                quantity_tr.append(quantity_td);

                var quantity = $(document.createElement('input'));
                quantity.attr('id', "close_con_quantity_" + inc_mc);
                quantity.attr('name', "close_con_quantity_" + inc_mc);
                quantity.addClass("close_con_quantity quantity-txtbox right");
                quantity.attr('maxLength', "15");
                quantity.val(this.con_data[i].tot_qty);
                quantity_td.append(quantity);

                this.renderClosingStockGrade(inc_mc, this.con_data[i].grade);
            }
        }
    },
    renameBoxes: function (id, is_con) {
        // console.log(id)
        var existing_select_boxes = $("." + id + "_metal")
        var existing_text_boxes = $("." + id + "_grade")
        for (var k = 0; k <= existing_select_boxes.length; k++) {
            var count = k + 1;

            $(existing_select_boxes[k]).attr('name', id + '_metal_' + count);
            $(existing_select_boxes[k]).attr('id', id + '_metal_' + count);

            $(existing_text_boxes[k]).attr('name', id + '_grade_' + count);
            $(existing_text_boxes[k]).attr('id', id + '_grade_' + count);

            if (is_con == true) {
                $(existing_text_boxes[k]).attr('name', id + '_quantity_' + count);
                $(existing_text_boxes[k]).attr('id', id + '_quanitity_' + count);
            }
        }
    },
    dropDownValidation: function () {

        $(".open_ore_metal").change(function () {
            var element_id = $(this).attr('id');
            var value = $(this).attr('value');
            var dropDownId = element_id.substr(15, 1);
            var dropDownElement = element_id.substr(0, 15);
            var dropDownIdInt = parseInt(dropDownId);
            var iCount;

            var sub_table = document.getElementById('open_ore_table').childNodes.length;

            for (iCount = 1; iCount <= sub_table; iCount++)
            {
                if (document.getElementById(dropDownElement + dropDownIdInt).value != "")
                {
                    if (value == document.getElementById(dropDownElement + iCount).value && iCount != dropDownIdInt)
                    {
                        alert('Sorry, you can not select one metal content more than once.');
                        document.getElementById(dropDownElement + dropDownIdInt).value = "";
                    }
                }
            }
        });

        $(".rec_ore_metal").change(function () {
            var element_id = $(this).attr('id');
            var value = $(this).attr('value');
            var dropDownId = element_id.substr(14, 1);
            var dropDownElement = element_id.substr(0, 14);
            var dropDownIdInt = parseInt(dropDownId);
            var iCount;

            var sub_table = document.getElementById('rec_ore_table').childNodes.length;

            for (iCount = 1; iCount <= sub_table; iCount++)
            {
                if (document.getElementById(dropDownElement + dropDownIdInt).value != "")
                {
                    if (value == document.getElementById(dropDownElement + iCount).value && iCount != dropDownIdInt)
                    {
                        alert('Sorry, you can not select one metal content more than once.');
                        document.getElementById(dropDownElement + dropDownIdInt).value = "";
                    }
                }
            }
        });

        $(".treat_ore_metal").change(function () {
            var element_id = $(this).attr('id');
            var value = $(this).attr('value');
            var dropDownId = element_id.substr(16, 1);
            var dropDownElement = element_id.substr(0, 16);
            var dropDownIdInt = parseInt(dropDownId);
            var iCount;

            var sub_table = document.getElementById('treat_ore_table').childNodes.length;

            for (iCount = 1; iCount <= sub_table; iCount++)
            {
                if (document.getElementById(dropDownElement + dropDownIdInt).value != "")
                {
                    if (value == document.getElementById(dropDownElement + iCount).value && iCount != dropDownIdInt)
                    {
                        alert('Sorry, you can not select one metal content more than once.');
                        document.getElementById(dropDownElement + dropDownIdInt).value = "";
                    }
                }
            }
        });

        $(".con_obt_metal").change(function () {
            var element_id = $(this).attr('id');
            var value = $(this).attr('value');
            var dropDownId = element_id.substr(14, 1);
            var dropDownElement = element_id.substr(0, 14);
            var dropDownIdInt = parseInt(dropDownId);
            var iCount;

            var sub_table = document.getElementById('con_obt_table').childNodes.length;

            for (iCount = 1; iCount <= sub_table; iCount++)
            {
                if (document.getElementById(dropDownElement + dropDownIdInt).value != "")
                {
                    if (value == document.getElementById(dropDownElement + iCount).value && iCount != dropDownIdInt)
                    {
                        alert('Sorry, you can not select one metal content more than once.');
                        document.getElementById(dropDownElement + dropDownIdInt).value = "";
                    }
                }
            }
        });

        $(".tail_ore_metal").change(function () {
            var element_id = $(this).attr('id');
            var value = $(this).attr('value');
            var dropDownId = element_id.substr(15, 1);
            var dropDownElement = element_id.substr(0, 15);
            var dropDownIdInt = parseInt(dropDownId);
            var iCount;

            var sub_table = document.getElementById('tail_ore_table').childNodes.length;

            for (iCount = 1; iCount <= sub_table; iCount++)
            {
                if (document.getElementById(dropDownElement + dropDownIdInt).value != "")
                {
                    if (value == document.getElementById(dropDownElement + iCount).value && iCount != dropDownIdInt)
                    {
                        alert('Sorry, you can not select one metal content more than once.');
                        document.getElementById(dropDownElement + dropDownIdInt).value = "";
                    }
                }
            }
        });

        $(".close_con_metal").change(function () {
            var element_id = $(this).attr('id');
            var value = $(this).attr('value');
            var dropDownId = element_id.substr(16, 1);
            var dropDownElement = element_id.substr(0, 16);
            var dropDownIdInt = parseInt(dropDownId);
            var iCount;

            var sub_table = document.getElementById('close_con_table').childNodes.length;

            for (iCount = 1; iCount <= sub_table; iCount++)
            {
                if (document.getElementById(dropDownElement + dropDownIdInt).value != "")
                {
                    if (value == document.getElementById(dropDownElement + iCount).value && iCount != dropDownIdInt)
                    {
                        alert('Sorry, you can not select one metal content more than once.');
                        document.getElementById(dropDownElement + dropDownIdInt).value = "";
                    }
                }
            }
        });

        $(".grade-txtbox").blur(function () {
            var flag = true;
            var elementId = $(this).attr('id');
            var elementVal = document.getElementById(elementId).value;
            if (elementVal == "")
            {
                var errorElement = document.createElement('div');
                errorElement.id = elementId + "err";
                errorElement.className = "err";
                elementId.appendChild(errorElement);
                document.getElementById(elementId + "err").innerHTML = "Please enter grade";
            }
            else if (elementVal < 0)
            {
                alert('Grade should be greater than zero');
            }
            else if (!isNaN(elementVal))
            {
                var temp = new Number(elementVal);
                elementVal = (temp).toFixed(2);
                document.getElementById(elementId).value = elementVal;
            }
            else
            {
                alert('Please enter a valid number');
            }
        });
    },
    formConRecoF5Validation: function () {

        $(document).ready(function () {

               $.validator.addMethod("cRequired", $.validator.methods.required,
                 $.validator.format("Please enter quantity"));
               $.validator.addMethod("cNumber", $.validator.methods.number,
                 $.validator.format("Quantity should be a number"));
               $.validator.addMethod("cMin", $.validator.methods.min,
                 $.validator.format("Quantity should not be zero or negative"));
               $.validator.addMethod("cMax", $.validator.methods.max, 
                 $.validator.format("Quantity should not exceed 12,3 digits"));
            //      
            //    //=================ADDING RULES FOR VALIDATION OF DYNAMIC FORM==============
            //    $.validator.addClassRules("con_obt_quantity", {
            //      cRquired: true,
            //      cNumber:true,
            //      cMin:0,
            ////      cRoundOff3:true,
            //      cMax: 999999999999.999
            //    });

            $("#frmConReco").validate({
                rules: {
                    "open_ore_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        roundOff3: true,
                        max: 999999999999.999
                                //            maxlength:12
                    },
                    "rec_ore_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        roundOff3: true,
                        max: 999999999999.999
                                //            maxlength:16
                    },
                    "treat_ore_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        roundOff3: true,
                        max: 999999999999.999
                                //            maxlength:16
                    },
                    "tail_ore_qty": {
                        required: true,
                        number: true,
                        min: 0,
                        roundOff3: true,
                        max: 999999999999.999
                                //            maxlength:16
                    }
                },
                errorElement: "div",
                onkeyup: false,
                messages: {
                    "open_ore_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        //            maxlength:"Quantity should not exceed 12,3 digits",
                        max: "Quantity should not exceed 12,3 digits",
                        min: "Quantity should not be zero or negative"
                    },
                    "rec_ore_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        max: "Quantity should not exceed 12,3 digits",
                        //            maxlength:"Quantity should not exceed 12,3 digits",
                        min: "Quantity should not be zero or negative"
                    },
                    "treat_ore_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        max: "Quantity should not exceed 12,3 digits",
                        //            maxlength:"Quantity should not exceed 15 digits",
                        min: "Quantity should not be zero or negative"
                    },
                    "tail_ore_qty": {
                        required: "Please enter quantity",
                        number: "Quantity should be a number",
                        max: "Quantity should not exceed 12,3 digits",
                        //            maxlength:"Quantity should not exceed 15 digits",
                        min: "Quantity should not be zero or negative"
                    }
                }
            })
        });

    },
    GradeDDValidation: function () {
        $("#frmConReco").on('focus', '.grade-txtbox', function () {
            var element_id = $(this).attr('id');

            var temp_stock_no1 = (element_id).split('_');
            var temp_stock_no = "_" + temp_stock_no1[3];
            var temp_metal = element_id.split('_');
            var first_value = temp_metal[0];
            var second_value = temp_metal[1];

            var select_box_id = document.getElementById(first_value + "_" + second_value + "_" + "metal" + temp_stock_no);
            var value = select_box_id.value;
            if (value == "") {
                /*var dataToAppend ="Please select the metal first";
                $('#'+element_id).parent().next('.err_cv').html(dataToAppend);*/
                
                alert('Please select the metal first');
                select_box_id.focus();
                $('.error-check').val('1');
            }
            else {
                $('.error-check').val('0');
            }
        });
    },
    QuantityDDValidation: function () {
        $('#quantity-txtbox').blur(function () {

        });
    },
    RomQuantityCustomValidation: function () {
        $('.rom-quantity-txtbox').blur(function () {
            var element_id = $(this).attr('id');
            var temp_metal = element_id.split('_');
            var first_value = temp_metal[0].toUpperCase();
            var second_value = temp_metal[1].toUpperCase();

            var quantity_id = document.getElementById(first_value + "_" + second_value + "_QTY");
            var value = quantity_id.value;
            if (value == "") {
                alert("Please enter quantity");
            }
            return;
        });
    },
    ConQuantityDDValidation: function () {
        $('#frmConReco').on('focus', '.quantity-txtbox', function () {
            var element_id = $(this).attr('id');
            var temp_stock_no1 = (element_id).split("_");
            var temp_stock_no = "_" + temp_stock_no1[3];
            var temp_metal = element_id.split('_');
            var first_value = temp_metal[0];
            var second_value = temp_metal[1];

            var quantity_id = document.getElementById(first_value + "_" + second_value + "_metal" + temp_stock_no);
            var value = quantity_id.value;
            if (value == "") {
                /*var dataToAppend ="Please select the metal first";
                $('#'+element_id).parent().next('.err_cv').html(dataToAppend);*/
                alert("Please select the metal first");
            }
            return;
        });
    },
    ConQuantityCustomValidation: function () {
        $('.quantity-txtbox').blur(function () {
            var element_id = $(this).attr('id');
            var temp_element_no1 = (element_id).split("_");
            var temp_element_no = "_" + temp_element_no1[3];
            var temp_metal = element_id.split('_');
            var first_value = temp_metal[0];
            var second_value = temp_metal[1];
            var table_name = document.getElementById(first_value + "_" + second_value + "_table");

            var quantity_id = document.getElementById(first_value + "_" + second_value + "_quantity" + temp_element_no);
            var value = quantity_id.value;
            if (value == "") {
                var error_div = document.getElementById(first_value + "_" + second_value + "_quantity" + "_error");
                if (!error_div) {
                    error_div = $(document.createElement('div'));
                    error_div.html("Please enter valid quantity");
                    error_div.attr('id', first_value + "_" + second_value + "_quantity" + "_error");
                    error_div.addClass("error-msg-div");
                    $('#' + first_value + "_" + second_value + "_quantity" + "_error").appendTo($(table_name).parent());
                }
                return false;
            } else {
                $("#" + first_value + "_" + second_value + "_quantity" + "_error").remove();
                return true;
            }
        });
    },
    MetaldropDownValidation: function () {
        $(".metal-box").change(function () {
            var value = $(this).val();

            var element_id = $(this).attr('id');
            var element_no1 = (element_id).split('_');
            var element_no = element_no1[3];
            var temp_metal = element_id.split('_');
            var first_value = temp_metal[0];
            var second_value = temp_metal[1];
            var tableName = document.getElementById(first_value + "_" + second_value + "_table");

            var dropdown_length = tableName.childNodes.length;

            for (var i = 1; i <= dropdown_length; i++) {
                if (element_no != i) {
                    var selected_element_id = document.getElementById(first_value + "_" + second_value + "_metal_" + i);
                    var selected_element_value = selected_element_id.value;

                    if (selected_element_value == value) {
                        alert('Sorry, you can not select one metal more than once');
                        $(this).val("");
                    }
                }
            }
        });
    },
    romMetalGradeTotal: function () {
        var _this = this;

        $(".grade-txtbox").unbind("blur");
        $(".grade-txtbox").blur(function () {

            var element_id = $(this).attr('id');
            var element_no1 = element_id.split('_');
            var element_no = "_" + element_no1[3];
            var temp_metal = element_id.split('_');
            var first_value = temp_metal[0];
            var second_value = temp_metal[1];
            var select_box_name = document.getElementById(first_value + "_" + second_value + "_metal" + element_no);
            var select_box_value = select_box_name.value;
            _this.romValidateGradeTotal(first_value, second_value, select_box_value);
        });
    },
    romValidateGradeTotal: function (first_value, second_value, select_box_value) {
        this.gradeTable = document.getElementById(first_value + "_" + second_value + "_table");
        var gradeTableLength = $('#' + first_value + "_" + second_value + "_table tbody tr").length;

        var grp_element_value = 0;
        // for (var i = 1; i <= this.gradeTable.childNodes.length; i++) {
        for (var i = 1; i <= gradeTableLength; i++) {
            var grade_grp_element_id = first_value + "_" + second_value + "_grade_" + i;

            var grade_grp_element = document.getElementById(grade_grp_element_id);
            grade_grp_element.value = Utilities.roundOff2(grade_grp_element.value);

            var grade_value = $.trim(grade_grp_element.value);

            // validating the grade for min and max values
            this.romCustomGradeValidation(grade_value, select_box_value, grade_grp_element_id);

            grp_element_value += parseFloat(grade_value);
        }
    },
    romCustomGradeValidation: function (grade_value, select_box_value, grade_id) {

        if (select_box_value != "" && select_box_value != 'NIL') {
            if (grade_value >= 100) {
                alert("Maximum grade value allowed is 99.99");
                var element_name = document.getElementById(grade_id);
                element_name.value = "";
                $('#error-check').val('1');
            }
            else if (grade_value <= 0) {
                alert("Please enter grade value greater than 0");
                var element_name = document.getElementById(grade_id);
                element_name.value = "";
                $('#error-check').val('1');
            }
            else {
                $('#error-check').val('0');
            }
        }
    },
    romCheckGradeRequiredStar: function () {
        _this = this;
        $("#frmConReco .grade-txtbox").unbind("blur");
        $("#frmConReco .grade-txtbox").blur(function () {
            var element_id = $(this).attr('id');
            var element_no1 = element_id.split('_');
            var element_no = "_" + element_no1[3];
            var temp_metal = element_id.split('_');
            var first_value = temp_metal[0];
            var second_value = temp_metal[1];
            var select_box_name = document.getElementById(first_value + "_" + second_value + "_grade" + element_no);
            var select_box_value = select_box_name.value;

            if (select_box_value > 0) {
                $("#" + first_value + "_" + first_value + "_required").empty();
            }
        });
    },
    romCheckMetalRequiredStar: function () {
        var _this = this;
        $("#frmConReco .metal-box").unbind("blur");
        $("#frmConReco .metal-box").blur(function () {
            var element_id = $(this).attr('id');
            var element_no1 = element_id.split("_");
            var element_no = "_" + element_no1[3];
            var temp_metal = element_id.split('_');
            var first_value = temp_metal[0];
            var second_value = temp_metal[1];
            var metal_box_name = document.getElementById(first_value + "_" + second_value + "_metal" + element_no);
            var metal_box_value = metal_box_name.value;

            if (metal_box_value == "") {
                $("#" + first_value + "_" + second_value + "_required").empty();
                $("#" + first_value + "_" + second_value + "_required").css("color", "red");
                $("#" + first_value + "_" + second_value + "_required").append('*');
            }
            else {
                $("#" + first_value + "_" + second_value + "_required").empty();
            }
        });
    },
    oreTreatedQuantityValidation: function () {
        $('#treat_ore_qty').blur(function () {
            var ore_treat_val = $(this).val();

            var open_ore_id = document.getElementById("open_ore_qty");
            var open_ore_value = open_ore_id.value;
            var ore_rec_id = document.getElementById("rec_ore_qty");
            var ore_rec_value = ore_rec_id.value;

            if (parseFloat(ore_treat_val) > (parseFloat(open_ore_value) + parseFloat(ore_rec_value))) {
                alert("Ore treated is more than opening stock plus ore received");
            }

            if (open_ore_value == "" || ore_rec_value == "") {
                alert("Please enter Opening stock and Ore received first")
            }

        });
    },
    conF5PostValidation: function () {
        var _this = this;
        //    var romArray = new Array('OPEN_ORE', 'REC_ORE', 'TREAT_ORE', 'TAIL_ORE');
        var romArray = new Array('open_ore', 'rec_ore', 'treat_ore', 'tail_ore');

        $('#frmConReco').unbind("submit");
        $('#frmConReco').submit(function (event) {
            var select_check = _this.checkAnySelectEmptyValidation();
            if (select_check == false) {
                event.preventDefault();
            }

            var treat_ore_id = document.getElementById("treat_ore_qty");
            var ore_treat_val = treat_ore_id.value;
            var open_ore_id = document.getElementById("open_ore_qty");
            var open_ore_value = open_ore_id.value;
            var ore_rec_id = document.getElementById("rec_ore_qty");
            var ore_rec_value = ore_rec_id.value;

            if (parseFloat(ore_treat_val) > (parseFloat(open_ore_value) + parseFloat(ore_rec_value))) {
                alert("Ore treated is more than opening stock plus ore received");
                event.preventDefault();
            }

            if (open_ore_value == "" || ore_rec_value == "") {
                alert("Please enter Opening stock and Ore received first");
                event.preventDefault();
            }

            // getting custom defined array of table from above
            for (var i = 0; i < romArray.length; i++) {
                var quantity_value = $("#" + romArray[i].toUpperCase() + "_QTY").val();
                var metal_value = $("." + romArray[i] + "_metal").val();
                var grade_value = $("." + romArray[i] + "_grade").val();
                var error_flag_1 = 0
                /*if(quantity_value == 0 ){
                 var error_flag_1 = "1";
                 }*/

                if (metal_value != 'NIL') {
                    if (grade_value == 0 && metal_value != "") {
                        $("#" + romArray[i] + "_required").empty();
                        $("#" + romArray[i] + "_required").css("color", "red");
                        $("#" + romArray[i] + "_required").append('*');
                        var error_flag_2 = "1";
                    }
                }
            }
            var error_check = $('#error-check').val();
            if (error_check == '1' || error_flag_1 == "1" || error_flag_2 == "1") {
                alert('Form contain errors. Please enter correct details');
                event.preventDefault();
            }

            //      this.oreTreatedQuantityValidation();

        });
    },
    checkAnySelectEmptyValidation: function () {
        var select_boxes = new Array();
        select_boxes = document.getElementsByTagName("select");

        var select_error_flag = 0;
        for (var i = 0; i < select_boxes.length; i++) {
            if (select_boxes[i]['value'] == "") {
                select_error_flag = select_error_flag + 1;
            }
        }

        if (select_error_flag > 0) {
            alert('Select Options in all Select Boxes. If No metal Content/Grade then Select NIL');
            return false
        }
        else
            return true;
    },
    conTextFieldValidation: function () {
        $("#frmConReco .con_obt_quantity").blur(function () {
            var quantity_id = $(this).attr('id');
            var quantity_value = $(this).val();

            var qty_parsed_value = Utilities.roundOff3(quantity_value);

            if (qty_parsed_value.length > 16) {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 12,3");
                $(this).val("");
            }
        });

        $("#frmConReco .close_con_quantity").blur(function () {
            var quantity_id = $(this).attr('id');
            var quantity_value = $(this).val();

            var qty_parsed_value = Utilities.roundOff3(quantity_value);

            if (qty_parsed_value.length > 15) {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 11,3");
                $(this).val("");
            }
        });

        $("#frmConReco .metal-value-txtbox").blur(function () {
            var value_field_id = $(this).attr('id');
            var value_field_value = $(this).val();

            var qty_parsed_value = Utilities.roundOff3(value_field_value);

            if (qty_parsed_value.length > 16) {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 12,3");
                $(this).val("");
            }
        });
    },
    autoFillForZeroProduction: function () {
        $("#frmConReco .metal-box").unbind("change");
        $("#frmConReco .metal-box").change(function () {
            var metalBoxId = $(this).attr('id');
            var metalBoxVal = $(this).val();

            var splitMetalBoxId = metalBoxId.split("_");
            var quantityFieldId = splitMetalBoxId[0].toUpperCase() + "_" + splitMetalBoxId[1].toUpperCase() + "_QTY";
            var otherQuantityFieldId = splitMetalBoxId[0] + "_" + splitMetalBoxId[1] + "_quantity_1";
            var gradeFieldId = metalBoxId.replace("metal", "grade");
            var valueFieldId = metalBoxId.replace("metal", "metal_value")

            if (metalBoxVal == 'NIL') {
                var buttonClicked = window.confirm("Selecting NIL in the Metal Content/grade will automatically put 0 in corresponding all fields. \nAre you sure want to continue?");
                if (buttonClicked == true) {
                    $("#" + quantityFieldId).val(0);
                    $("#" + otherQuantityFieldId).val(0);
                    $("#" + gradeFieldId).val("0.00");
                    $("#" + valueFieldId).val(0);
                }
                else {
                    $(this).val("");
                }
            }
            //      else{
            //        $("#" + quantityFieldId).val("");
            //        $("#" + gradeFieldId).val("");
            //
            //      }

        });
    }

}

var f5Sales = {
    init: function (product_url, data_url, prev_data_url, unit_url) {
        Utilities.ajaxBlockUI();
        this.byProductUrl = product_url;
        this.saleDataUrl = data_url;
        this.prevDataUrl = prev_data_url;
        this.unitUrl = unit_url;

        this.saleTables = new Array('open_stock', 'sale_place', 'prod_sold', 'clos_stock');
        this.saleRenderTables();
        this.addBtn();
    },
    saleRenderTables: function () {
        var _this = this;
		var sales_data_result = 'false';
        $.ajax({
            url: _this.byProductUrl,
            type: 'POST',
			async: false,
            success: function (response) {
                _this.metals = json_parse(response);
            }
        });
		
		$.ajax({
			url: _this.saleDataUrl,
			type: 'POST',
			async: false,
			success: function (response) {
				_this.sales_data = json_parse(response);
				sales_data_result = 'true';
			}
		});
		
		if(sales_data_result == 'true'){
			if (Object.keys(_this.sales_data).length == 1) {
				$.ajax({
					url: _this.prevDataUrl,
					type: 'POST',
					async: false,
					success: function (response) {
						_this.prev_month_data = json_parse(response);
						
						if (Object.keys(_this.prev_month_data).length > 1 ) {
							_this.createSalesTableWithPrevData(_this.prev_month_data);
						}
						else {
							_this.createSalesSubTables(1, false, '');

						}
						_this.autoFillForZeroProduction();
						_this.formValidation();
					}
				})
			} else {
				_this.editTables(_this.sales_data);
				_this.checkOpenQuantityUpdation('open_stock');
				_this.checkOpenQuantityUpdation('prod_sold');
				_this.DDfocusValue();
				//              _this.createSalesSubTables(1, _this.sales_data);
			}
			//            _this.formValidation();
			//            _this.salePostValidation();
			//            _this.dropDownValidation();
			//            _this.validateNewFrom();
			_this.salePostValidation();
			_this.formValidation();
			_this.autoFillForZeroProduction();
		}
    },
    createSalesSubTables: function (element_no, edit_data, prev_data) {
        var _this = this;
        var sub_table = document.getElementById("sales_data_table");
        var tr = $(document.createElement('tr'));
        $('#sales_data_table').append(tr);
        var metal_td = $(document.createElement('td'));
        tr.append(metal_td);

        var select_box = $(document.createElement('select'));
        select_box.attr('id', "open_stock_metal_" + element_no);
        select_box.attr('name', "open_stock_metal_" + element_no);
        select_box.addClass("open_stock_metal_box");
        metal_td.append(select_box);

        var dummy_option = $(document.createElement('option'));
        dummy_option.html("- Select -");
        dummy_option.val("");
        select_box.append(dummy_option);

        for (var j = 0; j < Object.keys(this.metals).length - 1; j++) {
            var options = $(document.createElement('option'));
            options.html(this.metals[j]);
            options.val(this.metals[j]);
            select_box.append(options);
        }
        /*
         if(edit_data != ""){
         select_box.val(edit_data[columnVal].open_metal);
         }
         */

        var quantity_td = $(document.createElement('td'));
        tr.append(quantity_td);

        var open_quantity_input_td = $(document.createElement('td'));
        quantity_td.append(open_quantity_input_td);

        var quantity = $(document.createElement('input'));
        quantity.attr('id', "open_stock_qty_" + element_no);
        quantity.attr('name', "open_stock_qty_" + element_no);
        quantity.attr('maxLength', "16");
        quantity.addClass("open_stock_qty sales-quantity-txtbox makeNil");
        open_quantity_input_td.append(quantity);


        var unit_td = $(document.createElement('td'));
        unit_td.attr('id', "open_stock_unit_" + element_no);
        tr.append(unit_td);
        if (edit_data != "") {
            unit_td.html(edit_data[0].unit);
        }

        var grade_td = $(document.createElement('td'));
        tr.append(grade_td);
        var grade = $(document.createElement('input'));
        grade.attr('id', "open_stock_grade_" + element_no);
        grade.attr('name', "open_stock_grade_" + element_no);
        grade.addClass("open_stock_grade sales-grade-txtbox makeNil");
        grade_td.append(grade);
        /*
         if(edit_data != ""){
         grade.val(edit_data[columnVal].open_grade);
         }
         */
        var sale_place_td = $(document.createElement('td'));
        tr.append(sale_place_td);
        var sale_place = $(document.createElement('input'));
        sale_place.attr('id', "sale_place_value_" + element_no);
        sale_place.attr('name', "sale_place_value_" + element_no);
        sale_place.addClass("sale_place_value sales-value-txtbox makeNil");
        sale_place_td.append(sale_place);
        /*
         if(edit_data != ""){
         
         sale_place1.val(edit_data[columnVal].sale_place);
         }
         */
        var sold_quantity_td = $(document.createElement('td'));
        tr.append(sold_quantity_td);

        var sold_quantity_input_td = $(document.createElement('td'));
        sold_quantity_td.append(sold_quantity_input_td);

        var sold_quantity = $(document.createElement('input'));
        sold_quantity.attr('id', "prod_sold_qty_" + element_no);
        sold_quantity.attr('name', "prod_sold_qty_" + element_no);
        sold_quantity.attr('maxLength', "16");
        sold_quantity.addClass("prod_sold_qty sales-quantity-txtbox makeNil");
        sold_quantity_input_td.append(sold_quantity);
        /*
         if(edit_data != ""){
         sold_quantity.val(edit_data[columnVal].prod_tot_qty);
         }
         */

        var sold_unit_td = $(document.createElement('td'));
        sold_unit_td.attr('id', "prod_sold_unit_" + element_no);
        tr.append(sold_unit_td);
        if (edit_data != "") {
            sold_unit_td.html(edit_data[0].unit);
        }

        var sold_grade_td = $(document.createElement('td'));
        tr.append(sold_grade_td);
        var sold_grade = $(document.createElement('input'));
        sold_grade.attr('id', "prod_sold_grade_" + element_no);
        sold_grade.attr('name', "prod_sold_grade_" + element_no);
        sold_grade.addClass("prod_sold_grade sales-grade-txtbox makeNil");
        sold_grade_td.append(sold_grade);
        /*
         if(edit_data != ""){
         sold_grade.val(edit_data[columnVal].prod_grade);
         }
         */
        var sold_value_td = $(document.createElement('td'));
        tr.append(sold_value_td);
        var sold_value = $(document.createElement('input'));
        sold_value.attr('id', "prod_sold_value_" + element_no);
        sold_value.attr('name', "prod_sold_value_" + element_no);
        sold_value.addClass("prod_sold_value sales-value-txtbox makeNil");
        sold_value_td.append(sold_value);
        /*
         if(edit_data != ""){
         sold_value.val(edit_data[columnVal].prod_product_value);
         }
         */
        var close_stock_qty_td = $(document.createElement('td'));
        tr.append(close_stock_qty_td);

        var close_stock_input_td = $(document.createElement('td'));
        close_stock_qty_td.append(close_stock_input_td);

        var close_qty = $(document.createElement('input'));
        close_qty.attr('id', "close_stock_qty_" + element_no);
        close_qty.attr('name', "close_stock_qty_" + element_no);
        close_qty.attr('maxLength', "16");
        close_qty.addClass("close_stock_qty sales-quantity-txtbox makeNil");
        close_stock_input_td.append(close_qty);
        /*
         if(edit_data != ""){
         close_qty.val(edit_data[columnVal].close_tot_qty);
         }
         */
        var close_unit_td = $(document.createElement('td'));
        close_unit_td.attr('id', "close_stock_unit_" + element_no);
        tr.append(close_unit_td);
        if (edit_data != "") {
            close_unit_td.html(edit_data[0].unit);
        }
        var close_stock_value_td = $(document.createElement('td'));
        tr.append(close_stock_value_td);
        var close_stock_value = $(document.createElement('input'));
        close_stock_value.attr('id', "close_stock_grade_" + element_no);
        close_stock_value.attr('name', "close_stock_grade_" + element_no);
        close_stock_value.addClass("close_stock_grade sales-grade-txtbox makeNil");
        close_stock_value_td.append(close_stock_value);
        /*
         if(edit_data != ""){
         close_stock_value.val(edit_data[columnVal].close_product_value);
         }
         */
        var metal_count = document.getElementById("month_sale_count");
        metal_count.value = element_no;

        if (metal_count.value > 1) {
            //close button
            var close_td = $(document.createElement('td'));
            close_td.addClass("sale-close-symbol");
            close_td.bind('click', function () {
                //rename the id and name for the other text and select boxes
                $(this).parent().empty();
                _this.renameFields();

                //hidden metal count
                var data_row_count = document.getElementById("month_sale_count");
                var prev_data_row_count = data_row_count.value;
                var inc_data_row_count = parseInt(prev_data_row_count) - 1;
                data_row_count.value = inc_data_row_count;
            });
            tr.append(close_td);
        }

        if (edit_data != "") {
            var i;
            for (i = 0; i < edit_data.length; i++) {
                if (i == 0) {
                    select_box.val(edit_data[i]['open_metal']);
                    var open_metal_qty = Utilities.roundOff3(edit_data[i]['open_tot_qty']);
                    quantity.val(open_metal_qty);
                    grade.val(edit_data[i]['open_grade']);
                }
                if (i == 1) {
                    sale_place.val(edit_data[i]['sale_place']);
                }
                if (i == 2) {
                    var sold_qty = Utilities.roundOff3(edit_data[i]['prod_tot_qty']);
                    sold_quantity.val(sold_qty);
                    sold_grade.val(edit_data[i]['prod_grade']);
                    sold_value.val(edit_data[i]['prod_product_value']);
                }
                if (i == 3) {
                    var close_quantity = Utilities.roundOff3(edit_data[i]['close_tot_qty']);
                    close_qty.val(close_quantity);
                    close_stock_value.val(edit_data[i]['close_product_value']);
                }
            }
        }
        else if (prev_data != "") {
            select_box.value = prev_data['metal_content'];
            var open_metal_qty = Utilities.roundOff3(prev_data['prev_qty']);
            quantity.value = open_metal_qty;
        }

        //onchange of the product, replace all the quantity's unit
        select_box.onchange = function () {
            Utilities.ajaxBlockUI();
            var sel_value = "sel_value=" + select_box.value;
            $.ajax({
                url: _this.unitUrl,
                data: sel_value,
                type: 'POST',
                success: function (response) {
                    unit_td.innerHTML = response;
                    sold_unit_td.innerHTML = response;
                    close_unit_td.innerHTML = response;
                }
            });
        }

    },
    addBtn: function () {
        var _this = this;
        $('#addButton').click(function () {
            var metal_count = document.getElementById("month_sale_count");
            var prev_metal_count = metal_count.value;
            var inc_metal_count = parseInt(prev_metal_count) + 1;
            metal_count.value = inc_metal_count;

            // Restricting user to not enter more than 6 rows of data
            if (prev_metal_count == 6) {
                alert("Sorry! you can't enter more than 6 records");
            } else {
                _this.createSalesSubTables(inc_metal_count, false, '');
            }
            _this.dropDownValidation();
            _this.formValidation();
            //      _this.closeBtn(metal_count);
        });
    },
    editTables: function (edit_data) {
        var _this = this;
        var data = edit_data;

        var row_no = Object.keys(data).length / 4;

        if (row_no > 1) {
            for (var i = 1; i <= row_no; i++) {
                var data_upper_limit = i * 4;
                var data_lower_limit = data_upper_limit - 4;
                var partial_data = new Array();
                var k = 0;
                for (var j = data_lower_limit; j < data_upper_limit; j++) {
                    partial_data[k] = data[j];
                    k++;
                }
                _this.createSalesSubTables(i, partial_data, '');
                _this.dropDownValidation();
            }
        }
        else {
            _this.createSalesSubTables(1, edit_data, '');
            _this.dropDownValidation();
        }
    },
    renameFields: function () {
        var existing_metal_boxes = $(".open_stock_metal_box");
        for (var j = 0; j < existing_metal_boxes.length; j++) {
            var count = j + 1;
            $(existing_metal_boxes[j]).attr('name', 'open_stock_metal_' + count);
            $(existing_metal_boxes[j]).attr('id', 'open_stock_metal_' + count);
        }

        var open_qty = $(".open_stock_qty");
        for (var k = 0; k < open_qty.length; k++) {
            var qty_count = k + 1;
            $(open_qty[k]).attr('name', 'open_stock_qty_' + qty_count);
            $(open_qty[k]).attr('id', 'open_stock_qty_' + qty_count);
        }

        var open_grade = $(".open_stock_grade");
        for (var l = 0; l < open_grade.length; l++) {
            var open_grade_count = l + 1;
            $(open_grade[l]).attr('name', 'open_stock_grade_' + open_grade_count);
            $(open_grade[l]).attr('id', 'open_stock_grade_' + open_grade_count);
        }

        var place_sold = $(".sale_place_value");
        for (var m = 0; m < place_sold.length; m++) {
            var sale_place_count = m + 1;
            $(place_sold[m]).attr('name', 'sale_place_value_' + sale_place_count);
            $(place_sold[m]).attr('id', 'sale_place_value_' + sale_place_count);
        }

        var prod_sold_qty = $(".prod_sold_qty");
        for (var n = 0; n < prod_sold_qty.length; n++) {
            var prod_sold_qty_count = n + 1;
            $(prod_sold_qty[n]).attr('name', 'prod_sold_qty_' + prod_sold_qty_count);
            $(prod_sold_qty[n]).attr('id', 'prod_sold_qty_' + prod_sold_qty_count);
        }

        var prod_sold_grade = $(".prod_sold_grade");
        for (var p = 0; p < prod_sold_grade.length; p++) {
            var prod_sold_grade_count = p + 1;
            $(prod_sold_grade[p]).attr('name', 'prod_sold_grade_' + prod_sold_grade_count);
            $(prod_sold_grade[p]).attr('id', 'prod_sold_grade_' + prod_sold_grade_count);
        }

        var prod_sold_value = $(".prod_sold_value");
        for (var r = 0; r < prod_sold_value.length; r++) {
            var prod_sold_value_count = r + 1;
            $(prod_sold_value[r]).attr('name', 'prod_sold_value_' + prod_sold_value_count);
            $(prod_sold_value[r]).attr('id', 'prod_sold_value_' + prod_sold_value_count);
        }

        var close_stock_qty = $(".close_stock_qty");
        for (var s = 0; s < close_stock_qty.length; s++) {
            var close_stock_qty_count = s + 1;
            $(close_stock_qty[s]).attr('name', 'close_stock_qty_' + close_stock_qty_count);
            $(close_stock_qty[s]).attr('id', 'close_stock_qty_' + close_stock_qty_count);
        }

        var close_stock_value = $(".close_stock_value");
        for (var t = 0; t < close_stock_value.length; t++) {
            var close_stock_value_count = t + 1;
            $(close_stock_value[t]).attr('name', 'close_stock_value_' + close_stock_value_count);
            $(close_stock_value[t]).attr('id', 'close_stock_value_' + close_stock_value_count);
        }
    },
    formValidation: function () {
        $('#frmSalesF5').on('blur', '.open_stock_metal_box', function () {
            var element_id = $(this).attr('id');
            var open_stock_metal = $(this).val();

            if (open_stock_metal == "") {
                var error_field = document.getElementById(element_id + "_req");
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please select metal");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove();
            }
        });

        $('#frmSalesF5').on('change', '.open_stock_metal_box', function () {
            var element_id = $(this).attr('id');
            var open_stock_metal = $(this).val();

            if (open_stock_metal == "") {
                var error_field = document.getElementById(element_id + "_req");
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please select metal");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove();
            }
        });

        $('#frmSalesF5').on('blur', '.open_stock_qty', function () {
            var element_id = $(this).attr('id');
            var open_stock_qty = $(this).val();

            if (open_stock_qty == "") {
                var error_field = document.getElementById(element_id + "_req");
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter quantity");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove();
            }
        });

        $('#frmSalesF5').on('focusout', '.open_stock_qty', function () {
            var open_stock_qty = $(this).val();

            var rounded_value = Utilities.roundOff3(open_stock_qty);

            if (rounded_value.length > 16) {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 12,3")
            }
        });

        $('#frmSalesF5').on('blur', '.open_stock_grade', function () {
            var element_id = $(this).attr('id');
            var open_stock_grade = $(this).val();

            var error_field = document.getElementById(element_id + "_req");
            if (open_stock_grade == "") {
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter grade");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove()
            }
        });

        $('#frmSalesF5').on('blur', '.sale_place_value', function () {
            var element_id = $(this).attr('id');
            var sale_place_value = $(this).val();

            var error_field = document.getElementById(element_id + "_req");
            if (sale_place_value == "") {
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter sale place");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove()
            }
        });

        $('#frmSalesF5').on('blur', '.prod_sold_qty', function () {
            var element_id = $(this).attr('id');
            var prod_sold_qty = $(this).val();

            var error_field = document.getElementById(element_id + "_req");
            if (prod_sold_qty == "") {
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter quantity");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove()
            }
        });

        $('#frmSalesF5').on('focusout', '.prod_sold_qty', function () {
            var open_stock_qty = $(this).val();

            var rounded_value = Utilities.roundOff3(open_stock_qty);

            if (rounded_value.length > 16) {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 12,3")
            }
        });


        $('#frmSalesF5').on('blur', '.prod_sold_qty', function () {
            var element_id = $(this).attr('id');
            var prod_sold_grade = $(this).val();

            var error_field = document.getElementById(element_id + "_req");
            if (prod_sold_grade == "") {
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter grade");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove()
            }
        });

        $('#frmSalesF5').on('blur', '.prod_sold_value', function () {
            var element_id = $(this).attr('id');
            var prod_sold_value = $(this).val();

            var error_field = document.getElementById(element_id + "_req");
            if (prod_sold_value == "") {
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter value");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove()
            }
        });

        $('#frmSalesF5').on('blur', '.prod_sold_grade', function () {
            var element_id = $(this).attr('id');
            var prod_sold_grade = $(this).val();

            var error_field = document.getElementById(element_id + "_req");
            if (prod_sold_grade == "") {
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter grade");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove()
            }
        });

        $('#frmSalesF5').on('blur', '.close_stock_qty', function () {
            var element_id = $(this).attr('id');
            var close_stock_qty = $(this).val();

            var error_field = document.getElementById(element_id + "_req");
            if (close_stock_qty == "") {
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter quantity");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove()
            }
        });

        $('#frmSalesF5').on('focusout', '.close_stock_qty', function () {
            var open_stock_qty = $(this).val();

            var rounded_value = Utilities.roundOff3(open_stock_qty);

            if (rounded_value.length > 16) {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 12,3")
            }
        });

        $('#frmSalesF5').on('blur', '.close_stock_value', function () {
            var element_id = $(this).attr('id');
            var close_stock_value = $(this).val();

            var error_field = document.getElementById(element_id + "_req");
            if (close_stock_value == "") {
                if (!error_field) {
                    var required_field = $(document.createElement('div'))
                    required_field.attr('id', element_id + "_req");
                    required_field.html("Please enter value");
                    required_field.addClass("sales-required-flag");
                    $(this).closest('td').append(required_field);
                }
            }
            else {
                $("#" + element_id + "_req").remove()
            }
        });


    },
    salePostValidation: function () {
        var _this = this;
        $("#frmSalesF5").submit(function (event) {
            var empty_field_count = _this.salePartialPostValidation();

            if (empty_field_count > 0) {
                alert("All fields required. If No data is there, select Nil in the Metal/Product Drop box");
                event.preventDefault();
            }
        });
    },
    salePartialPostValidation: function () {
        var row_id = $(".open_stock_qty");
        var row_count = row_id.length;
        var empty_count = 0;

        for (var i = 1; i <= row_count; i++) {

            var open_stock_metal = $("#open_stock_metal_" + i).val();
            var open_stock_qty = $("#open_stock_qty_" + i).val();
            var open_stock_grade = $("#open_stock_grade_" + i).val();
            var sale_place_value = $("#sale_place_value_" + i).val();
            var prod_sold_qty = $("#prod_sold_qty_" + i).val();
            var prod_sold_grade = $("#prod_sold_grade_" + i).val();
            var prod_sold_value = $("#prod_sold_value_" + i).val();
            var close_stock_qty = $("#close_stock_qty_" + i).val();
            var close_stock_value = $("#close_stock_value_" + i).val();
            if (open_stock_metal == "" || open_stock_qty == "" || open_stock_grade == "" || sale_place_value == "" || prod_sold_qty == "" || prod_sold_grade == "" || prod_sold_value == "" || close_stock_qty == "" || close_stock_value == "") {
                empty_count = empty_count + 1;
            }
            else {
                empty_count = 0;
            }
        }
        return empty_count;
    },
    dropDownValidation: function () {
        $("#frmSalesF5").on('focus', '.open_stock_metal_box', function () {
            this.intial_metal_value = $(this).val();
        });

        $("#frmSalesF5").on('change', '.open_stock_metal_box', function () {
            var value = $(this).val();

            var element_id = $(this).attr('id');
            var element_no1 = (element_id).split('_');
            var element_no = element_no1[3];
            var row_id = $(".open_stock_qty");
            var dropdown_length = row_id.length;

            for (var i = 1; i <= dropdown_length; i++) {
                if (element_no != i) {
                    var selected_element_id = document.getElementById("open_stock_metal_" + i);
                    var selected_element_value = selected_element_id.value;

                    if (selected_element_value == value) {
                        alert('Sorry, you can not select one metal more than once');
                        $(this).val("");
                    }
                }
            }
        });

    },
    DDfocusValue: function () {
        var _this = this;

        $("#frmSalesF5").on('focus', '.open_stock_metal_box', function () {
            _this.prev_value = $(this).val();
        });

        $("#frmSalesF5").on('focusout', '.open_stock_metal_box', function () {
            _this.new_value = $(this).val();
            if (_this.prev_value != "" && _this.prev_value != _this.new_value) {
                alert("Please send an e-mail to IBM clarifying this variation.");
            }

        });
    },
    checkOpenQuantityUpdation: function (table_name) {
        $('.' + table_name + '_qty').focus(function () {
            this.old_open_quantity_id = $(this).attr('id');
            this.old_open_quantity_value = $(this).val();
        });
        $('.' + table_name + '_qty').focusout(function () {
            this.new_quantity_id = $(this).attr('id');
            this.new_open_quantity_value = $(this).val();

            if (this.old_open_quantity_value != this.new_open_quantity_value) {
                alert("Please send an e-mail to IBM clarifying this variation.");
            }
        });
    },
    createSalesTableWithPrevData: function (data) {
        var _this = this;
        var prev_month_row_count = Object.keys(data).length-1;

        for (var i = 0; i < prev_month_row_count; i++) {
            var element_no = i + 1;
            _this.createSalesSubTables(element_no, '', data[i]);
        }
        _this.dropDownValidation();
        _this.formValidation();

    },
    autoFillForZeroProduction: function () {
        $("#frmSalesF5 .open_stock_metal_box").unbind("change");
        $("#frmSalesF5").on('change', '.open_stock_metal_box', function () {
            var metalBoxId = $(this).attr('id');
            var metalBoxVal = $(this).val();

            // console.log(metalBoxId)
            var splitMetalBoxId = metalBoxId.split("_");
            var quantityFieldId = splitMetalBoxId[0].toUpperCase() + "_" + splitMetalBoxId[1].toUpperCase() + "_QTY";
            var otherQuantityFieldId = splitMetalBoxId[0] + "_" + splitMetalBoxId[1] + "_quantity_1";
            var gradeFieldId = metalBoxId.replace("metal", "grade");
            var valueFieldId = metalBoxId.replace("metal", "metal_value")

            if (metalBoxVal == 'NIL') {
                var buttonClicked = window.confirm("Selecting NIL in the Metal Content/grade will automatically put 0 in corresponding all fields. \nAre you sure want to continue?");
                if (buttonClicked == true) {
                    $(".makeNil").val(0);
                }
                else {
                    $(".makeNil").val("");
                }
            }
            // else{
            //     $("#" + quantityFieldId).val("");
            //     $("#" + gradeFieldId).val("");
            // }

        });
    }

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

var f5Smelter = {
    init: function (metal_url, product_url, data_url, unit_url) {
        Utilities.ajaxBlockUI();
        this.metalUrl = metal_url;
        this.byProductUrl = product_url;
        this.smelterDataUrl = data_url;
        this.unitUrl = unit_url;

        this.recoveryTypes = new Array('open', 'con_rc', 'con_rs', 'con_so', 'con_tr', 'close');
        this.recoveryRenderTables();
    },
    recoveryRenderTables: function () {
        var _this = this;

        $.ajax({
            url: _this.metalUrl,
            type: 'POST',
			async: false,
            success: function (response) {
                _this.metals = json_parse(response);                
            }
        });
		
		$.ajax({
			url: _this.byProductUrl,
			type: 'POST',
			async: false,
			success: function (rp) {
				_this.byProducts = json_parse(rp);
			}
		});
		
		$.ajax({
			url: _this.smelterDataUrl,
			type: 'POST',
			async: false,
			success: function (response) {
				_this.data = json_parse(response);

				if (_this.data.recovery == "" && _this.data.con_metal == "" && _this.data.by_product == "" && _this.data.prev_month_data == "") {
					_this.createRecoveryTable(1, '', '');
					_this.createConMetalTable(1, '');
					_this.createByProductTable(1, '');
				}
				else if (_this.data.recovery == "" && _this.data.con_metal == "" && _this.data.by_product == "" && _this.data.prev_month_data != "") {
					_this.createRecoveryWithPrevData(_this.data.prev_month_data);
					_this.createConMetalTable(1, '');
					_this.createByProductTable(1, '');

				}

				else {
					_this.renderEditForm();
				}

				_this.recoveryAddBtn();
				_this.conMetalAddBtn();
				_this.byProductAddBtn();
				_this.recoveryQtyValidation();
				_this.recoveryGradevalidation();
				_this.recoverySourceValidation();
				_this.recoveryConcenTreatValidation();
				_this.recoveryCloseStockValidataion();
				_this.conMetalQtyValidation('rc-qty');
				_this.conMetalQtyValidation('rc-byproduct-qty');
				_this.conMetalValueValidation('rc-byproduct-value');
				_this.conMetalValueValidation('rc-value');
				_this.conMetalGradeValidation();
				_this.postValidation();
				_this.openDropDownValidation();
				_this.recoveredDropDownValidation();
				_this.byProductDropDownValidation();
				_this.closingStockValidation();
				_this.autoFillForZeroProduction();

			}
		});
    },
    createRecoveryTable: function (element_no, data, prev_data) {
        var _this = this;
        var array_no = element_no - 1;
        var recovery_table = document.getElementById('recovery-table');

        var recovery_tr = $(document.createElement('tr'));
        $('#recovery-table').append(recovery_tr);

        var open_td = $(document.createElement('td'));
        recovery_tr.append(open_td);
        this.createOpenTable(open_td, element_no, data, prev_data);

        var open_grade_td = $(document.createElement('td'));
        open_grade_td.attr('align', 'center');
        recovery_tr.append(open_grade_td);
        var open_grade = $(document.createElement('input'));
        open_grade.attr('id', "open_grade_" + element_no);
        open_grade.attr('name', "open_grade_" + element_no);
        open_grade.addClass("open_grade grade-txtbox makeNil");
        open_grade.attr('maxLength', "5");
        if (data != "")
            open_grade.val(data[array_no].open_grade);
        open_grade_td.append(open_grade);


        //CON - RC
        var con_rc_qty_td = $(document.createElement('td'));
        con_rc_qty_td.attr('align', 'center');
        recovery_tr.append(con_rc_qty_td);
        var con_rc_qty = $(document.createElement('input'));
        con_rc_qty.attr('id', "con_rc_qty_" + element_no);
        con_rc_qty.attr('name', "con_rc_qty_" + element_no);
        con_rc_qty.addClass("con_rc_qty quantity-txtbox makeNil");
        con_rc_qty.attr('maxLength', "16");
        if (data != "")
            con_rc_qty.val(data[array_no].con_rc_qty);
        con_rc_qty_td.append(con_rc_qty);

        var con_rc_grade_td = $(document.createElement('td'));
        con_rc_grade_td.attr('align', 'center');
        recovery_tr.append(con_rc_grade_td);
        var con_rc_grade = $(document.createElement('input'));
        con_rc_grade.attr('id', "con_rc_grade_" + element_no);
        con_rc_grade.attr('name', "con_rc_grade_" + element_no);
        con_rc_grade.addClass("con_rc_grade grade-txtbox makeNil");
        con_rc_grade.attr('maxLength', "5");
        if (data != "")
            con_rc_grade.val(data[array_no].con_rc_grade);
        con_rc_grade_td.append(con_rc_grade);

        //CON - RS
        var con_rs_source_td = $(document.createElement('td'));
        con_rs_source_td.attr('align', 'center');
        recovery_tr.append(con_rs_source_td);
        var con_rs_source = $(document.createElement('input'));
        con_rs_source.attr('id', "con_rs_source_" + element_no);
        con_rs_source.attr('name', "con_rs_source_" + element_no);
        con_rs_source.addClass("con-rs-source makeNil");
        con_rs_source.attr('maxLength', "50");
        if (data != "")
            con_rs_source.val(data[array_no].con_rs_source);
        con_rs_source_td.append(con_rs_source);

        var con_rs_qty_td = $(document.createElement('td'));
        con_rs_qty_td.attr('align', 'center');
        recovery_tr.append(con_rs_qty_td);
        var con_rs_qty = $(document.createElement('input'));
        con_rs_qty.attr('id', "con_rs_qty_" + element_no);
        con_rs_qty.attr('name', "con_rs_qty_" + element_no);
        con_rs_qty.addClass("con_rs_qty quantity-txtbox makeNil");
        con_rs_qty.attr('maxLength', "16");
        if (data != "")
            con_rs_qty.val(data[array_no].con_rs_qty);
        con_rs_qty_td.append(con_rs_qty);

        var con_rs_grade_td = $(document.createElement('td'));
        con_rs_grade_td.attr('align', 'center');
        recovery_tr.append(con_rs_grade_td);
        var con_rs_grade = $(document.createElement('input'));
        con_rs_grade.attr('id', "con_rs_grade_" + element_no);
        con_rs_grade.attr('name', "con_rs_grade_" + element_no);
        con_rs_grade.addClass("con_rs_grade grade-txtbox makeNil");
        con_rs_grade.attr('maxLength', "5");
        if (data != "")
            con_rs_grade.val(data[array_no].con_rs_grade);
        con_rs_grade_td.append(con_rs_grade);

        //CON - SOLD
        var con_so_qty_td = $(document.createElement('td'));
        con_so_qty_td.attr('align', 'center');
        recovery_tr.append(con_so_qty_td);
        var con_so_qty = $(document.createElement('input'));
        con_so_qty.attr('id', "con_so_qty_" + element_no);
        con_so_qty.attr('name', "con_so_qty_" + element_no);
        con_so_qty.addClass("con_so_qty quantity-txtbox makeNil");
        con_so_qty.attr('maxLength', "16");
        if (data != "")
            con_so_qty.val(data[array_no].con_so_qty);
        con_so_qty_td.append(con_so_qty);

        var con_so_grade_td = $(document.createElement('td'));
        con_so_grade_td.attr('align', 'center');
        recovery_tr.append(con_so_grade_td);
        var con_so_grade = $(document.createElement('input'));
        con_so_grade.attr('id', "con_so_grade_" + element_no);
        con_so_grade.attr('name', "con_so_grade_" + element_no);
        con_so_grade.addClass("con_so_grade grade-txtbox makeNil");
        con_so_grade.attr('maxLength', "5");
        if (data != "")
            con_so_grade.val(data[array_no].con_so_grade);
        con_so_grade_td.append(con_so_grade);

        //CON - TREATED
        var con_tr_qty_td = $(document.createElement('td'));
        con_tr_qty_td.attr('align', 'center');
        recovery_tr.append(con_tr_qty_td);
        var con_tr_qty = $(document.createElement('input'));
        con_tr_qty.attr('id', "con_tr_qty_" + element_no);
        con_tr_qty.attr('name', "con_tr_qty_" + element_no);
        con_tr_qty.addClass("con_tr_qty quantity-txtbox makeNil");
        con_tr_qty.attr('maxLength', "16");
        if (data != "")
            con_tr_qty.val(data[array_no].con_tr_qty);
        con_tr_qty_td.append(con_tr_qty);

        var con_tr_grade_td = $(document.createElement('td'));
        con_tr_grade_td.attr('align', 'center');
        recovery_tr.append(con_tr_grade_td);
        var con_tr_grade = $(document.createElement('input'));
        con_tr_grade.attr('id', "con_tr_grade_" + element_no);
        con_tr_grade.attr('name', "con_tr_grade_" + element_no);
        con_tr_grade.addClass("con_tr_grade grade-txtbox makeNil");
        con_tr_grade.attr('maxLength', "5");
        if (data != "")
            con_tr_grade.val(data[array_no].con_tr_grade);
        con_tr_grade_td.append(con_tr_grade);

        //CLOSE
        var close_qty_td = $(document.createElement('td'));
        close_qty_td.attr('align', 'center');
        recovery_tr.append(close_qty_td);
        var close_qty = $(document.createElement('input'));
        close_qty.attr('id', "close_qty_" + element_no);
        close_qty.attr('name', "close_qty_" + element_no);
        close_qty.addClass("close_qty quantity-txtbox makeNil");
        close_qty.attr('maxLength', "16");
        if (data != "")
            close_qty.val(data[array_no].close_qty);
        close_qty_td.append(close_qty);
        close_qty.bind('blur', function () {
            var open_qty = document.getElementById("open_qty_" + element_no);
            var temp = (parseInt(open_qty.value) + parseInt(con_rc_qty.value) + parseInt(con_rs_qty.value)
                    - parseInt(con_so_qty.value) - parseInt(con_tr_qty.value));
            var close_qty_value = parseInt(close_qty.value);

            if (close_qty_value > temp) {
                alert("Closing quantity is not valid");
                $(close_qty).val('');
            }
        });

        var close_value_td = $(document.createElement('td'));
        close_value_td.attr('align', 'center');
        recovery_tr.append(close_value_td);
        var close_value = $(document.createElement('input'));
        close_value.attr('id', "close_value_" + element_no);
        close_value.attr('name', "close_value_" + element_no);
        close_value.addClass("close-value makeNil");
        if (data != "")
            close_value.val(data[array_no].close_value);
        close_value_td.append(close_value);

        if (element_no > 1) {
            //close button
            var close_td = $(document.createElement('td'));
            close_td.addClass("recovery-close-symbol");
            close_td.bind('click', function () {
                //rename the id and name for the other text and select boxes
                //            _this.renameBoxes(id);

                $(this).parent().remove();

                _this.renameRecoveryBoxes();


                //hidden metal count
                var recovery_count = document.getElementById("recovery_count");
                var prev_metal_count = recovery_count.value;
                var dec_metal_count = parseInt(prev_metal_count) - 1;
                recovery_count.value = dec_metal_count;
            });
            recovery_tr.append(close_td);
        }

        //initialize the recovery count
        var recovery_count = document.getElementById("recovery_count");
        recovery_count.value = element_no;

    },
    createOpenTable: function (parent, element_no, data, prev_data) {
        var array_no = element_no - 1;

        var open_table = $(document.createElement('table'));
        open_table.addClass('smelter-open-table');
        parent.append(open_table);

        var metal_tr = $(document.createElement('tr'));
        open_table.append(metal_tr);

        var metal_td = $(document.createElement('td'));
        metal_tr.append(metal_td);

        var select_box = $(document.createElement('select'));
        select_box.attr('id', "open_metal_" + element_no);
        select_box.attr('name', "open_metal_" + element_no);
        select_box.addClass("metal-box");
        metal_td.append(select_box);

        var dummy_option = $(document.createElement('option'));
        dummy_option.html("- Select -");
        dummy_option.val("");
        select_box.append(dummy_option);

        for (var j = 0; j < Object.keys(this.metals).length - 1; j++) {
            var options = $(document.createElement('option'));
            options.html(this.metals[j]);
            options.val(this.metals[j]);
            select_box.append(options);
        }

        if (data != "") {
            select_box.val(data[array_no].open_metal);
        }
        else if (prev_data != "") {
            select_box.val(prev_data[array_no].open_metal);
        }

        var qty_td = $(document.createElement('td'));
        metal_tr.append(qty_td);

        var open_qty = $(document.createElement('input'));
        open_qty.attr('id', "open_qty_" + element_no);
        open_qty.attr('name', "open_qty_" + element_no);
        open_qty.addClass("open_qty quantity-txtbox makeNil");
        open_qty.attr('maxLength', "16");
        qty_td.append(open_qty);

        if (data != "") {
            open_qty.val(data[array_no].open_qty);
        }
        else if (prev_data != "") {
            open_qty.val(prev_data[array_no].open_qty);
        }
    },
    recoveryAddBtn: function () {
        var _this = this;
        var btn = document.getElementById("recovery_add_btn");

        btn.onclick = function () {
            //hidden metal count
            var metal_count = document.getElementById("recovery_count");
            var prev_metal_count = metal_count.value;
            if (prev_metal_count == _this.metals.length) {
                alert("Sorry! You can't add more than " + _this.metals.length + " records");
                return;
            }
            var inc_metal_count = parseInt(prev_metal_count) + 1;
            metal_count.value = inc_metal_count;

            _this.createRecoveryTable(inc_metal_count, '', '');
            _this.recoveryQtyValidation();
            _this.recoveryGradevalidation();
            _this.recoverySourceValidation();
            _this.recoveryConcenTreatValidation();
            _this.recoveryCloseStockValidataion();
            _this.openDropDownValidation();



        }
    },
    createConMetalTable: function (element_no, data) {
        var _this = this;
        var array_no = element_no - 1;

        var metal_table = document.getElementById('con_metal_table')
        var metal_tr = $(document.createElement('tr'))
        $('#con_metal_table').append(metal_tr);

        var metal_td = $(document.createElement('td'))
        metal_tr.append(metal_td);

        var select_box = $(document.createElement('select'));
        select_box.attr('id', "rc_metal_" + element_no);
        select_box.attr('name', "rc_metal_" + element_no);
        select_box.addClass("rc-metal");
        metal_td.append(select_box);

        var dummy_option = $(document.createElement('option'));
        dummy_option.html("- Select -");
        dummy_option.val("");
        select_box.append(dummy_option);

        for (var j = 0; j < Object.keys(this.byProducts).length - 1; j++) {
            var options = $(document.createElement('option'));
            options.html(this.byProducts[j]);
            options.val(this.byProducts[j]);
            select_box.append(options);
        }

        if (data != "")
            select_box.val(data[array_no].rc_metal);

        var qty_td = $(document.createElement('td'));
        metal_tr.append(qty_td);
        var rc_qty = $(document.createElement('input'));
        rc_qty.attr('id', "rc_qty_" + element_no);
        rc_qty.attr('name', "rc_qty_" + element_no);
        rc_qty.addClass("rc-qty");
        rc_qty.attr('maxLength', "16");
        qty_td.append(rc_qty);
        if (data != "")
            rc_qty.val(data[array_no].rc_qty);

        var unit_td = $(document.createElement('td'));
        unit_td.attr('id', "rc_unit_" + element_no);
        metal_tr.append(unit_td);
        if (data != "")
            unit_td.html(data[array_no].unit);

        select_box.bind('change', function () {
            Utilities.ajaxBlockUI();
            //      var sel_value = "sel_value=" + select_box.value; COMMENTED BY UDAY AS THIS CODE WAS NOT WORKING AND ADDED THE BELOW LINE
            var sel_value = "sel_value=" + $(this).val();
            // console.log("uday")
            $.ajax({
                url: _this.unitUrl,
                data: sel_value,
                type: 'POST',
                success: function (response) {
                    unit_td.innerHTML = response;
                }
            });
        });

        var metal_value_table = document.getElementById('con_metal_value_table');
        var metal_value_tr = $(document.createElement('tr'));
        $('#con_metal_value_table').append(metal_value_tr);
        var metal_value_td = $(document.createElement('td'));
        metal_value_tr.append(metal_value_td);
        var metal_value = $(document.createElement('input'));
        metal_value.attr('id', "rc_value_" + element_no);
        metal_value.attr('name', "rc_value_" + element_no);
        metal_value.addClass("rc-value");
        metal_value.attr('maxLength', "15");
        metal_value_td.append(metal_value);
        if (data != "")
            metal_value.val(data[array_no].rc_value);

        var grade_table = document.getElementById('con_grade_table');
        var grade_tr = $(document.createElement('tr'));
        $('#con_grade_table').append(grade_tr);
        var grade_td = $(document.createElement('td'));
        grade_tr.append(grade_td);
        var grade = $(document.createElement('input'));
        grade.attr('id', "rc_grade_" + element_no);
        grade.attr('name', "rc_grade_" + element_no);
        grade.addClass("rc-grade");
        grade.attr('maxLength', "5");
        grade_td.append(grade);
        if (data != "")
            grade.val(data[array_no].rc_grade);

        if (element_no > 1) {
            //close button
            var close_td = $(document.createElement('td'));
            close_td.addClass("recovery-close-symbol");
            close_td.bind('click', function () {
                //rename the id and name for the other text and select boxes
                $(this).parent().remove();
                var temp = $(this).parent().children(':first').children(':first').attr('id');

                var element_id1 = temp.split('_');
                var element_id = element_id1[2];

                var metal_value = document.getElementById("rc_value_" + element_id);
                $(metal_value).parent().remove();
                var qty_tr = document.getElementById("rc_qty_" + element_id);
                $(qty_tr).parent().parent().remove();

                _this.renameConMetalBoxes();

                //hidden metal count
                var con_metal_count = document.getElementById("con_metal_count");
                var prev_metal_count = con_metal_count.value;
                var dec_metal_count = parseInt(prev_metal_count) - 1;
                con_metal_count.value = dec_metal_count;
            });
            grade_tr.append(close_td);
        }

        //initialize the con metal count
        var con_metal_count = document.getElementById("con_metal_count");
        con_metal_count.value = element_no;
    },
    conMetalAddBtn: function () {
        var _this = this;
        var btn = document.getElementById("con_metal_add_btn");

        btn.onclick = function () {
            //hidden metal count
            var con_metal_count = document.getElementById("con_metal_count");
            var prev_con_metal_count = con_metal_count.value;
            if (prev_con_metal_count == _this.byProducts.length) {
                alert("Sorry! You can't add more than " + _this.byProducts.length + " records");
                return;
            }
            var inc_con_metal_count = parseInt(prev_con_metal_count) + 1;
            con_metal_count.value = inc_con_metal_count;

            _this.createConMetalTable(inc_con_metal_count, '');
            _this.conMetalQtyValidation('rc-qty');
            _this.recoveredDropDownValidation();
            _this.closingStockValidation();

        }
    },
    createByProductTable: function (element_no, data) {
        var _this = this;
        var array_no = element_no - 1;

        var byproduct_table = document.getElementById('byproduct_table')
        var byproduct_tr = $(document.createElement('tr'));
        $('#byproduct_table').append(byproduct_tr);

        var byproduct_td = $(document.createElement('td'))
        byproduct_tr.append(byproduct_td);

        var select_box = $(document.createElement('select'));
        select_box.attr('id', "rc_byproduct_prod_" + element_no);
        select_box.attr('name', "rc_byproduct_prod_" + element_no);
        select_box.addClass("rc-byproduct-prod");
        byproduct_td.append(select_box);

        var dummy_option = $(document.createElement('option'));
        dummy_option.html("- Select -");
        dummy_option.val("");
        select_box.append(dummy_option);

        for (var j = 0; j < Object.keys(this.byProducts).length - 1; j++) {
            var options = $(document.createElement('option'));
            options.html(this.byProducts[j]);
            options.val(this.byProducts[j]);
            select_box.append(options);
        }

        if (data != "")
            select_box.val(data[array_no].bp_metal);

        var qty_td = $(document.createElement('td'));
        byproduct_tr.append(qty_td);
        var rc_byproduct_qty = $(document.createElement('input'));
        rc_byproduct_qty.attr('id', "rc_byproduct_qty_" + element_no);
        rc_byproduct_qty.attr('name', "rc_byproduct_qty_" + element_no);
        rc_byproduct_qty.addClass("rc-byproduct-qty");
        rc_byproduct_qty.attr('maxLength', "16");
        qty_td.append(rc_byproduct_qty);
        if (data != "")
            rc_byproduct_qty.val(data[array_no].bp_qty);

        var unit_td = $(document.createElement('td'));
        unit_td.attr('id', "rc_byproduct_unit_" + element_no);
        byproduct_tr.append(unit_td);
        if (data != "")
            unit_td.html(data[array_no].unit);

        select_box.bind('change', function () {
            Utilities.ajaxBlockUI();
            var sel_value = "sel_value=" + select_box.value;
            $.ajax({
                url: _this.unitUrl,
                data: sel_value,
                type: 'POST',
                success: function (response) {
                    unit_td.innerHTML = response;
                }
            });
        });

        var byproduct_value_table = document.getElementById('byproduct_value_table');
        var byproduct_value_tr = $(document.createElement('tr'));
        $('#byproduct_value_table').append(byproduct_value_tr);
        var byproduct_value_td = $(document.createElement('td'));
        byproduct_value_tr.append(byproduct_value_td);
        var byproduct_value = $(document.createElement('input'));
        byproduct_value.attr('id', "rc_byproduct_value_" + element_no);
        byproduct_value.attr('name', "rc_byproduct_value_" + element_no);
        byproduct_value.attr('class', "rc-byproduct-value");
        byproduct_value.attr('maxLength', "16");
        byproduct_value_td.append(byproduct_value);
        if (data != "")
            byproduct_value.val(data[array_no].bp_value);

        var grade_table = document.getElementById('byproduct_grade_table');
        var grade_tr = $(document.createElement('tr'));
        $('#byproduct_grade_table').append(grade_tr);
        var grade_td = $(document.createElement('td'));
        grade_tr.append(grade_td);
        var grade = $(document.createElement('input'));
        grade.attr('id', "rc_byproduct_grade_" + element_no);
        grade.attr('name', "rc_byproduct_grade_" + element_no);
        grade.addClass("rc-byproduct-grade");
        grade.attr('maxLength', "5")
        grade_td.append(grade);
        if (data != "")
            grade.val(data[array_no].bp_grade);

        if (element_no > 1) {
            //close button
            var close_td = $(document.createElement('td'));
            close_td.addClass("recovery-close-symbol");
            close_td.bind('click', function () {
                //rename the id and name for the other text and select boxes
                $(this).parent().remove();
                var temp = $(this).parent().children(':first').children(':first').attr('id');
                var element_id1 = temp.split('_');
                var element_id = element_id1[3]
                var metal_value = document.getElementById("rc_byproduct_value_" + element_id);
                $(metal_value).parent().remove();
                var qty_tr = document.getElementById("rc_byproduct_qty_" + element_id);
                $(qty_tr).parent().parent().remove();

                _this.renameByProductBoxes();

                //hidden metal count
                var byproduct_count = document.getElementById("byproduct_count");
                var prev_metal_count = byproduct_count.value;
                var dec_metal_count = parseInt(prev_metal_count) - 1;
                byproduct_count.value = dec_metal_count;
            });
            grade_tr.append(close_td);
        }

        //initialize the con metal count
        var byproduct_count = document.getElementById("byproduct_count");
        byproduct_count.value = element_no;
    },
    byProductAddBtn: function () {
        var _this = this;
        var btn = document.getElementById("byproduct_add_btn");

        btn.onclick = function () {
            //hidden metal count
            var byproduct_count = document.getElementById("byproduct_count");
            var prev_byproduct_count = byproduct_count.value;
            if (prev_byproduct_count == _this.byProducts.length) {
                alert("Sorry! You can't add more than " + _this.byProducts.length + " records");
                return;
            }
            var inc_byproduct_count = parseInt(prev_byproduct_count) + 1;
            byproduct_count.value = inc_byproduct_count;

            _this.createByProductTable(inc_byproduct_count, '');
            _this.conMetalQtyValidation('rc-byproduct-qty');
            _this.conMetalValueValidation('rc-byproduct-value');
            _this.conMetalValueValidation('rc-value');
            _this.conMetalGradeValidation();
            _this.byProductDropDownValidation();

        }
    },
    renderEditForm: function () {
        //recovery
        this.recovery_data = this.data.recovery;
        for (var i = 0; i < this.recovery_data.length; i++) {
            var element_no = i + 1;
            this.createRecoveryTable(element_no, this.recovery_data, '');
        }

        //con metal
        this.con_metal_data = this.data.con_metal;
        for (var i = 0; i < this.con_metal_data.length; i++) {
            var con_element_no = i + 1;
            this.createConMetalTable(con_element_no, this.con_metal_data);
        }

        //byproduct
        this.byproduct_data = this.data.by_product;
        for (var i = 0; i < this.byproduct_data.length; i++) {
            var bp_element_no = i + 1;
            this.createByProductTable(bp_element_no, this.byproduct_data);
        }
    },
    renameRecoveryBoxes: function () {

        for (var i = 0; i < this.recoveryTypes.length; i++) {
            var id = this.recoveryTypes[i];

            var existing_qty_boxes = $("." + id + "_qty")
            for (var j = 0; j < existing_qty_boxes.length; j++) {
                var count = j + 1;
                $(existing_qty_boxes[j]).attr('name', id + '_qty_' + count);
                $(existing_qty_boxes[j]).attr('id', id + '_qty_' + count);
            }

            var existing_grade_boxes = $("." + id + "_grade")
            for (var k = 0; k < existing_grade_boxes.length; k++) {
                var gcount = k + 1;
                $(existing_grade_boxes[k]).attr('name', id + '_grade_' + gcount);
                $(existing_grade_boxes[k]).attr('id', id + '_grade_' + gcount);
            }

            var existing_metal_boxes = $(".metal-box")
            for (var m = 0; m < existing_metal_boxes.length; m++) {
                var mcount = m + 1;
                $(existing_metal_boxes[m]).attr('name', 'open_metal_' + mcount);
                $(existing_metal_boxes[m]).attr('id', 'open_metal_' + mcount);
            }

            var existing_source_boxes = $(".con-rs-source")
            for (var s = 0; s < existing_source_boxes.length; s++) {
                var scount = s + 1;
                $(existing_source_boxes[s]).attr('name', 'con_rs_soruce_' + scount);
                $(existing_source_boxes[s]).attr('id', 'con_rs_soruce_' + scount);
            }

            var existing_value_boxes = $(".close-value")
            for (var v = 0; v < existing_value_boxes.length; v++) {
                var vcount = v + 1;
                $(existing_value_boxes[v]).attr('name', 'close_value_' + vcount);
                $(existing_value_boxes[v]).attr('id', 'close_value_' + vcount);
            }
        }
    },
    renameConMetalBoxes: function () {

        var existing_qty_boxes = $(".rc-qty")
        for (var j = 0; j < existing_qty_boxes.length; j++) {
            var count = j + 1;
            $(existing_qty_boxes[j]).attr('name', 'rc_qty_' + count);
            $(existing_qty_boxes[j]).attr('id', 'rc_qty_' + count);
        }

        var existing_grade_boxes = $(".rc-grade")
        for (var k = 0; k < existing_grade_boxes.length; k++) {
            var gcount = k + 1;
            $(existing_grade_boxes[k]).attr('name', 'rc_grade_' + gcount);
            $(existing_grade_boxes[k]).attr('id', 'rc_grade_' + gcount);
        }

        var existing_metal_boxes = $(".rc-metal")
        for (var m = 0; m < existing_metal_boxes.length; m++) {
            var mcount = m + 1;

            $(existing_metal_boxes[m]).attr('name', 'rc_metal_' + mcount);
            $(existing_metal_boxes[m]).attr('id', 'rc_metal_' + mcount);
        }

        var existing_value_boxes = $(".rc-value")
        for (var v = 0; v < existing_value_boxes.length; v++) {
            var vcount = v + 1;
            $(existing_value_boxes[v]).attr('name', 'rc_value_' + vcount);
            $(existing_value_boxes[v]).attr('id', 'rc_value_' + vcount);
        }
    },
    renameByProductBoxes: function () {

        var existing_qty_boxes = $(".rc-byproduct-qty")
        for (var j = 0; j < existing_qty_boxes.length; j++) {
            var count = j + 1;
            $(existing_qty_boxes[j]).attr('name', 'rc_byproduct_qty_' + count);
            $(existing_qty_boxes[j]).attr('id', 'rc_byproduct_qty_' + count);
        }

        var existing_grade_boxes = $(".rc-byproduct-grade")
        for (var k = 0; k < existing_grade_boxes.length; k++) {
            var gcount = k + 1;
            $(existing_grade_boxes[k]).attr('name', 'rc_byproduct_grade_' + gcount);
            $(existing_grade_boxes[k]).attr('id', 'rc_byproduct_grade_' + gcount);
        }

        var existing_metal_boxes = $(".rc-byproduct-prod")
        for (var m = 0; m < existing_metal_boxes.length; m++) {
            var mcount = m + 1;
            $(existing_metal_boxes[m]).attr('name', 'rc_byproduct_prod_' + mcount);
            $(existing_metal_boxes[m]).attr('id', 'rc_byproduct_prod_' + mcount);
        }

        var existing_value_boxes = $(".rc-byproduct-value")
        for (var v = 0; v < existing_value_boxes.length; v++) {
            var vcount = v + 1;
            $(existing_value_boxes[v]).attr('name', 'rc_byproduct_value_' + vcount);
            $(existing_value_boxes[v]).attr('id', 'rc_byproduct_value_' + vcount);
        }
    },
    recoveryQtyValidation: function () {
        var rec_table_length = this.recoveryTypes.length;
        for (var i = 0; i < rec_table_length; i++) {
            var table_name = this.recoveryTypes[i];

            $("." + table_name + "_qty").blur(function () {
                var quantity_id = $(this).attr('id');
                var quantity_value = $(this).val();

                var qty_parsed_value = Utilities.roundOff3(quantity_value);

                if (qty_parsed_value.length > 16) {
                    alert("Maximum quantity limit exceeded. Maximum value allowed is 12,3");

                    var old_smelter_value = $("#smelter_error_check").val();

                    if (old_smelter_value == 0) {
                        var new_smelter_value = parseInt(old_smelter_value) + 1;
                        $("#smelter_error_check").val(new_smelter_value);
                    }
                }
                /* else if(qty_parsed_value == 0.000){
                 alert("Please enter valid quantity");
                 $(this).val('');
                 
                 var old_smel_value = $("#smelter_error_check").val();
                 if(old_smel_value == 0){
                 var new_smel_value = parseInt(old_smel_value) + 1;
                 $("#smelter_error_check").val(new_smel_value);
                 }
                 }*/
                else if (quantity_value == "") {
                    alert("Please enter quantity");

                    var old_smel_empty_value = $("#smelter_error_check").val();
                    if (old_smel_empty_value) {
                        var new_smel_empty_value = parseInt(old_smel_empty_value) + 1;
                        $("#smelter_error_check").val(new_smel_empty_value);
                    }
                }
                else {
                    $(this).val(qty_parsed_value);
                    var old_smelter_flag = $("#smelter_error_check").val();

                    if (old_smelter_flag > 0) {
                        var new_smelter_flag = parseInt(old_smelter_flag) - 1;

                        $("#smelter_error_check").val(new_smelter_flag);
                    }
                }
            });
        }
    },
    recoveryGradevalidation: function () {
        var rec_table_length = this.recoveryTypes.length;
        for (var i = 0; i < rec_table_length; i++) {
            var table_name = this.recoveryTypes[i];

            $("." + table_name + "_grade").unbind("blur");
            $("." + table_name + "_grade").blur(function () {
                var grade_id = $(this).attr('id');
                var grade_value = $(this).val();

                var grade_parsed_value = Utilities.roundOff22(grade_value);

                if (grade_parsed_value.length > 5) {
                    alert("Maximum grade limit exceeded. Maximum value allowed is 99.99");

                    var old_smelter_value = $("#smelter_error_check").val();
                    if (old_smelter_value == 0) {
                        var new_smelter_value = parseInt(old_smelter_value) + 1;
                        $("#smelter_error_check").val(new_smelter_value);
                    }
                }
                else if (grade_parsed_value == 0.000) {
                    var metalDDTemp1 = grade_id.split("_");
                    var metalLastElem = $(metalDDTemp1).last();

                    if (metalLastElem[0] == 1) {
                        var metalDropDownVal = $("#open_metal_1").val();
                        if (metalDropDownVal != 'NIL') {
                            alert("Please enter valid grade");
                            var old_smel_value = $("#smelter_error_check").val();
                            if (old_smel_value == 0) {
                                var new_smel_value = parseInt(old_smel_value) + 1;
                                $("#smelter_error_check").val(new_smel_value);
                            }
                        }
                    }
                    else {
                        alert("Please enter valid grade");
                        var old_smel_value = $("#smelter_error_check").val();
                        if (old_smel_value == 0) {
                            var new_smel_value = parseInt(old_smel_value) + 1;
                            $("#smelter_error_check").val(new_smel_value);
                        }
                    }

                }
                else if (grade_value == "") {
                    alert("Please enter grade");

                    var old_smel_empty_value = $("#smelter_error_check").val();
                    if (old_smel_empty_value) {
                        var new_smel_empty_value = parseInt(old_smel_empty_value) + 1;
                        $("#smelter_error_check").val(new_smel_empty_value);
                    }
                }
                else {
                    $(this).val(grade_parsed_value);
                    var old_smelter_flag = $("#smelter_error_check").val();

                    if (old_smelter_flag > 0) {
                        var new_smelter_flag = parseInt(old_smelter_flag) - 1;

                        $("#smelter_error_check").val(new_smelter_flag);
                    }
                }
            });
        }
    },
    recoverySourceValidation: function () {
        $("#frmSmeltReco").on('blur', '.con_src_qty', function () {
            var source_value = $(this).val();
            var source_length = source_value.length;

            if (source_length > 50) {
                alert("Maximum number of characters is 50");
            }
        });
    },
    recoveryConcenTreatValidation: function () {
        $("#frmSmeltReco").on('blur', '.con_tr_qty', function () {

            var concen_treat_id = $(this).attr('id');
            var concen_treat_val = $(this).val();

            var element_no = concen_treat_id.substr(-2, 2);

            var open_concen_value = $("#open_qty" + element_no).val();
            var con_rec_val = $("#con_rc_qty" + element_no).val();
            var con_rs_val = $("#con_rs_qty" + element_no).val();
            var con_so_val = $("#con_so_qty" + element_no).val();

            //It should be <= opening stock of concentrate + concentrate received from concentrator + concentrate received from other sources ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“ concentrate sold
            var math_equation = ((parseInt(open_concen_value) + parseInt(con_rec_val) + parseInt(con_rs_val)) - parseInt(con_so_val));

            if (concen_treat_val > math_equation) {
                alert("Concentrates treated should be less than or equal to opening stock of concentrate + concentrate received from concentrator + concentrate received from other sources - concentrate sold");

                var old_smel_value = $("#smelter_error_check").val();
                if (old_smel_value == 0) {
                    var new_smel_value = parseInt(old_smel_value) + 1;
                    $("#smelter_error_check").val(new_smel_value);
                }
            }
            else {
                var old_smelter_value = $("#smelter_error_check").val();
                if (old_smelter_value == 0) {
                    var new_smelter_value = parseInt(old_smelter_value) - 1;
                    $("#smelter_error_check").val(new_smelter_value);
                }
            }

        });
    },
    recoveryCloseStockValidataion: function () {
        $("#frmSmeltReco").on('blur', '.close_qty', function () {

            var close_qty_id = $(this).attr('id');
            var close_qty_val = $(this).val();

            var element_no = close_qty_id.substr(-2, 2);

            var open_qty_value = $("#open_qty" + element_no).val();
            var con_rec_val = $("#con_rc_qty" + element_no).val();
            var con_rs_val = $("#con_rs_qty" + element_no).val();
            var con_so_val = $("#con_so_qty" + element_no).val();
            var con_treat_val = $("#con_tr_qty" + element_no).val();

            //It should be <= opening stock of concentrate + concentrate received from concentrator + concentrate received from other sources ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“ concentrate sold
            var math_equation = (((parseInt(open_qty_value) + parseInt(con_rec_val) + parseInt(con_rs_val)) - parseInt(con_so_val)) - parseInt(con_treat_val));

            //It should be <= opening stock of concentrate + concentrate received from concentrator + concentrate received from other sources - concentrate sold - concentrate treated 
            if (close_qty_val > math_equation) {
                alert("Closing stocks of concentrate should be less than or equal to opening stock of concentrate + concentrate received from concentrator + concentrate received from other sources - concentrate sold - concentrate treated");

                var old_smel_value = $("#smelter_error_check").val();
                if (old_smel_value == 0) {
                    var new_smel_value = parseInt(old_smel_value) + 1;
                    $("#smelter_error_check").val(new_smel_value);
                }
            }
            else {
                var old_smelter_value = $("#smelter_error_check").val();
                if (old_smelter_value == 0) {
                    var new_smelter_value = parseInt(old_smelter_value) - 1;
                    $("#smelter_error_check").val(new_smelter_value);
                }
            }
        });
    },
    conMetalQtyValidation: function (table_name) {

        $("#frmSmeltReco").on("blur", "." + table_name, function () {
            var quantity_id = $(this).attr('id');
            var quantity_value = $(this).val();

            var qty_parsed_value = Utilities.roundOff3(quantity_value);

            if (qty_parsed_value.length > 16) {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 12,3");

                var old_smelter_value = $("#smelter_error_check").val();

                /*if(old_smelter_value == 0){
                 var new_smelter_value = parseInt(old_smelter_value) + 1;
                 $("#smelter_error_check").val(new_smelter_value);
                 } */
            } /*
             else if(qty_parsed_value == 0.000){
             alert("Please enter valid quantity");
             $(this).val('');
             
             var old_smel_value = $("#smelter_error_check").val();
             if(old_smel_value == 0){
             var new_smel_value = parseInt(old_smel_value) + 1;
             $("#smelter_error_check").val(new_smel_value);
             }
             }*/
            else if (quantity_value == "") {
                alert("Please enter quantity");

                var old_smel_empty_value = $("#smelter_error_check").val();
                if (old_smel_empty_value) {
                    var new_smel_empty_value = parseInt(old_smel_empty_value) + 1;
                    $("#smelter_error_check").val(new_smel_empty_value);
                }
            }
            else {
                $(this).val(qty_parsed_value);
                var old_smelter_flag = $("#smelter_error_check").val();

                if (old_smelter_flag > 0) {
                    var new_smelter_flag = parseInt(old_smelter_flag) - 1;

                    $("#smelter_error_check").val(new_smelter_flag);
                }
            }
        });
    },
    conMetalValueValidation: function (table_name) {

        $("#frmSmeltReco").on("blur", "." + table_name, function () {
            var quantity_id = $(this).attr('id');
            var quantity_value = $(this).val();

            var qty_parsed_value = Utilities.roundOff22(quantity_value);

            if (table_name == "rc-byproduct-value") {
                if (qty_parsed_value.length > 16) {
                    var qty_parsed_flag_1 = "1";
                }
            }
            else if (table_name == "rc-value") {
                if (qty_parsed_value.length > 15) {
                    var qty_parsed_flag_2 = "1"
                }
            }
            if (qty_parsed_flag_1 == "1") {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 12,3");

                var old_smelter_value = $("#smelter_error_check").val();

                if (old_smelter_value == 0) {
                    var new_smelter_value = parseInt(old_smelter_value) + 1;
                    $("#smelter_error_check").val(new_smelter_value);
                }

            }
            else if (qty_parsed_flag_2 == "1") {
                alert("Maximum quantity limit exceeded. Maximum value allowed is 12,2");

                var old_sme_value = $("#smelter_error_check").val();
                /*
                 if(old_sme_value == 0){
                 var new_sme_value = parseInt(old_sme_value) + 1;
                 $("#smelter_error_check").val(new_sme_value);
                 }*/
            } /*
             else if(qty_parsed_value == 0.00){
             alert("Please enter valid value");
             
             var old_smel_value = $("#smelter_error_check").val();
             if(old_smel_value == 0){
             var new_smel_value = parseInt(old_smel_value) + 1;
             $("#smelter_error_check").val(new_smel_value);
             }
             }*/
            else if (quantity_value == "") {
                alert("Please enter value");

                var old_smel_empty_value = $("#smelter_error_check").val();
                if (old_smel_empty_value) {
                    var new_smel_empty_value = parseInt(old_smel_empty_value) + 1;
                    $("#smelter_error_check").val(new_smel_empty_value);
                }
            }
            else {
                $(this).val(qty_parsed_value);
                var old_smelter_flag = $("#smelter_error_check").val();

                if (old_smelter_flag > 0) {
                    var new_smelter_flag = parseInt(old_smelter_flag) - 1;

                    $("#smelter_error_check").val(new_smelter_flag);
                }
            }
        });
    },
    postValidation: function () {
        $("#frmSmeltReco").validate({
            onSubmit: true,
            onkeyup: false
        });
        // $.validator.addMethod("cRequired", $.validator.methods.required,
        //         $.validator.format("required"));

        //=================ADDING RULES FOR VALIDATION OF DYNAMIC FORM==============
        //    $.validator.addClassRules("rc-metal rc-qty rc-value rc-grade rc-byproduct-prod rc-byproduct-qty rc-byproduct-value rc-byproduct-grade", {
        // $.validator.addClassRules("metal-box", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("makeNil", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("rc-metal", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("rc-qty", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("rc-value", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("rc-grade", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("rc-byproduct-prod", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("rc-byproduct-qty", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("rc-byproduct-value", {
        //     cRequired: true
        // });
        // $.validator.addClassRules("rc-byproduct-grade", {
        //     cRequired: true
        // });

        $("#frmSmeltReco").submit(function (event) {
            var all_select_fields = new Array();
            all_select_fields = document.getElementsByTagName("select");

            var select_error_flag = 0;
            for (var i = 0; i < all_select_fields.length; i++) {
                if (all_select_fields[i]['value'] == "") {
                    select_error_flag = select_error_flag + 1;
                }
            }

            var all_input_fields = Array();
            all_input_fields = document.getElementsByTagName("input");
            var input_error_flag = 0;
            for (var j = 0; j < all_input_fields.length; j++) {
                if (all_input_fields[j].type == "text") {
                    if (all_input_fields[j].value == "") {
                        input_error_flag = input_error_flag + 1;
                    }
                }
            }

            if (select_error_flag > 0 || input_error_flag > 0) {
                alert("All Fields are required.");
                event.preventDefault();
            }

        });
    },
    openDropDownValidation: function () {
        $("#frmSmeltReco").on("change", ".open_metal", function () {
            var value = $(this).val();

            var element_id = $(this).attr('id');
            var element_no1 = (element_id).split('_');
            var element_no = element_no1[2];
            var row_id = $(".open_metal");
            var dropdown_length = row_id.length;

            for (var i = 1; i <= dropdown_length; i++) {
                if (element_no != i) {
                    var selected_element_id = document.getElementById("open_metal_" + i);
                    var selected_element_value = selected_element_id.value;

                    if (selected_element_value == value) {
                        alert('Sorry, you can not select one metal more than once');
                        $(this).val("");
                    }
                }
            }
        });
    },
    recoveredDropDownValidation: function () {
        $("#frmSmeltReco").on("change", ".rc-metal", function () {
            var value = $(this).val();

            var element_id = $(this).attr('id');
            var element_no1 = (element_id).split('_');
            var element_no = element_no1[2];
            var row_id = $(".rc-metal");
            var dropdown_length = row_id.length;

            for (var i = 1; i <= dropdown_length; i++) {
                if (element_no != i) {
                    var selected_element_id = document.getElementById("rc_metal_" + i);
                    var selected_element_value = selected_element_id.value;

                    if (selected_element_value == value) {
                        alert('Sorry, you can not select one metal more than once');
                        $(this).val("");
                    }
                }
            }
        });
    },
    byProductDropDownValidation: function () {
        $("#frmSmeltReco").on("change", ".rc-byproduct-prod", function () {
            var value = $(this).val();

            var element_id = $(this).attr('id');
            var element_no1 = (element_id).split('_');
            var element_no = element_no1[3];
            var row_id = $(".rc-byproduct-prod");
            var dropdown_length = row_id.length;

            for (var i = 1; i <= dropdown_length; i++) {
                if (element_no != i) {
                    var selected_element_id = document.getElementById("rc_byproduct_prod_" + i);
                    var selected_element_value = selected_element_id.value;

                    if (selected_element_value == value) {
                        alert('Sorry, you can not select one metal more than once');
                        $(this).val("");
                    }
                }
            }
        });
    },
    createRecoveryWithPrevData: function (data) {
        var _this = this;

        var prev_data_row_count = data.length;
        for (var i = 0; i < prev_data_row_count; i++) {
            var element_no = i + 1;
            _this.createRecoveryTable(element_no, '', data);
        }
    },
    conMetalGradeValidation: function () {
        $("#frmSmeltReco").on('blur', '.rc-byproduct-grade', function () {
            var grade_value = $(this).val();

            if (parseFloat(grade_value) > 100) {
                alert("Maximum grade limit exceeded. Maximum value allowed is 99.99")
            }
            else if (parseFloat(grade_value) <= 0) {
                var grade_id = $(this).attr("id");
                var metalDDId = grade_id.replace("grade", "prod");
                var metalDDValue = $("#" + metalDDId).val();
                if (metalDDValue != 'NIL')
                    alert("Please enter valid grade")
            }
        });

        $("#frmSmeltReco").on('blur', '.rc-grade', function () {
            var grade_value = $(this).val();

            if (parseFloat(grade_value) > 100) {
                alert("Maximum grade limit exceeded. Maximum value allowed is 99.99")
            }
            else if (parseFloat(grade_value) <= 0) {
                var grade_id = $(this).attr("id");
                var metalDDId = grade_id.replace("grade", "metal");
                var metalDDValue = $("#" + metalDDId).val();
                if (metalDDValue != 'NIL')
                    alert("Please enter valid grade")
            }
        });
    },
    closingStockValidation: function () {

    },
    autoFillForZeroProduction: function () {
        $("#frmSmeltReco .open_metal").unbind("change");
        $("#frmSmeltReco").on('change', '.open_metal', function () {
            //      var metalBoxId = $(this).attr('id');
            var metalBoxVal = $(this).val();

            //      var splitMetalBoxId = metalBoxId.split("_");
            //      var quantityFieldId = splitMetalBoxId[0].toUpperCase() + "_" + splitMetalBoxId[1].toUpperCase() + "_QTY";
            //      var otherQuantityFieldId = splitMetalBoxId[0] + "_" + splitMetalBoxId[1] + "_quantity_1";
            //      var gradeFieldId = metalBoxId.replace("metal", "grade");
            //      var valueFieldId = metalBoxId.replace("metal", "metal_value")

            if (metalBoxVal == 'NIL') {
                var buttonClicked = window.confirm("Selecting NIL in the Metal Content/grade will automatically put 0 in corresponding all fields. \nAre you sure want to continue?");
                if (buttonClicked == true) {
                    $(".makeNil").val(0);
                }
                else {
                    $(".makeNil").val("");
                }
            }
            //      else{
            //        $("#" + quantityFieldId).val("");
            //        $("#" + gradeFieldId).val("");
            //
            //      }

        });
        $("#frmSmeltReco").on('change', '.rc-metal', function () {
            var metalBoxId = $(this).attr('id');
            var metalBoxVal = $(this).val();

            //      var splitMetalBoxId = metalBoxId.split("_");
            //      var quantityFieldId = splitMetalBoxId[0].toUpperCase() + "_" + splitMetalBoxId[1].toUpperCase() + "_QTY";
            //      var otherQuantityFieldId = splitMetalBoxId[0] + "_" + splitMetalBoxId[1] + "_quantity_1";
            var quantityFieldId = metalBoxId.replace("metal", "qty");
            var valueFieldId = metalBoxId.replace("metal", "value");
            var gradeFieldId = metalBoxId.replace("metal", "grade")

            if (metalBoxVal == 'NIL') {
                var buttonClicked = window.confirm("Selecting NIL in the Metal Content/grade will automatically put 0 in corresponding all fields. \nAre you sure want to continue?");
                if (buttonClicked == true) {
                    $("#" + quantityFieldId).val(0);
                    $("#" + valueFieldId).val(0);
                    $("#" + gradeFieldId).val(0);
                }
                else {
                    $("#" + quantityFieldId).val("");
                    $("#" + valueFieldId).val("");
                    $("#" + gradeFieldId).val("");
                }
            }
            //      else{
            //        $("#" + quantityFieldId).val("");
            //        $("#" + gradeFieldId).val("");
            //
            //      }

        });
        $("#frmSmeltReco").on('change', '.rc-byproduct-prod', function () {
            var metalBoxId = $(this).attr('id');
            var metalBoxVal = $(this).val();

            var quantityFieldId = metalBoxId.replace("_prod_", "_qty_");
            var valueFieldId = metalBoxId.replace("_prod_", "_value_");
            var gradeFieldId = metalBoxId.replace("_prod_", "_grade_")

            if (metalBoxVal == 'NIL') {
                var buttonClicked = window.confirm("Selecting NIL in the Metal Content/grade will automatically put 0 in corresponding all fields. \nAre you sure want to continue?");
                if (buttonClicked == true) {
                    $("#" + quantityFieldId).val(0);
                    $("#" + valueFieldId).val(0);
                    $("#" + gradeFieldId).val(0);
                }
                else {
                    $("#" + quantityFieldId).val("");
                    $("#" + valueFieldId).val("");
                    $("#" + gradeFieldId).val("");
                }
            }
            //      else{
            //        $("#" + quantityFieldId).val("");
            //        $("#" + gradeFieldId).val("");
            //
            //      }

        });
    }

}
/**
 * Takes care of all the JS functionalities of MMS module
 */
var mms = {
    disableUser: function (user_id) {
        var _this = this;
        var is_confirm = confirm("Are you sure to disable this user?");
        if (is_confirm) {
            $.ajax({
                url: "disableUser",
                type: 'POST',
                data: "id=" + user_id,
                success: function (response) {
                    var data = json_parse(response);
                    if (data.status == 'success') {

                        $('#status_' + user_id).children().remove();
                        var link = document.createElement('a');
                        link.innerHTML = "Enable";
                        link.href = "javascript:void(0)";
                        link.onclick = function () {
                            _this.enableUser(user_id);
                        }
                        $('#status_' + user_id).append(link);

                        var success = document.getElementById('disable-success');
                        $(success).show();
                        $(success).fadeOut(6000);
                    }
                }
            });
        }
    },
    enableUser: function (user_id) {
        var _this = this;
        var is_confirm = confirm("Are you sure to enable this user?");
        if (is_confirm) {
            $.ajax({
                url: "enableUser",
                type: 'POST',
                data: "id=" + user_id,
                success: function (response) {
                    var data = json_parse(response);
                    if (data.status == 'success') {
                        $('#status_' + user_id).children().remove();

                        var link = document.createElement('a');
                        link.innerHTML = "Disable";
                        link.href = "javascript:void(0)";
                        link.onclick = function () {
                            _this.disableUser(user_id);
                        }
                        $('#status_' + user_id).append(link);

                        var success = document.getElementById('enable-success');
                        $(success).show();
                        $(success).fadeOut(6000);
                    }
                }
            });
        }
    },
    selectReturns: function () {
        var assigned_returns = new Array();
        var assigned_to = $("#selected_returns");

        //wholesome selection/deselction
        $("#assign_all").change(function () {
            if ($(".assign_chkbox").is(':checked') == false) {
                $(".assign_chkbox").attr('checked', true);

                $('input:checkbox.assign_chkbox').each(function () {
                    var chkbox_id = $(this).attr('id');
                    var returns_id = chkbox_id.slice(14);
                    assigned_returns.push(returns_id);

                    assigned_to.val(assigned_returns);
                });

            }
            else {
                $(".assign_chkbox").attr('checked', false);
                assigned_returns = [];
                assigned_to.val('');
            }
        });

        //individual selection
        $(".assign_chkbox").change(function () {
            $("#assign_all").attr('checked', false);

            var chkbox_id = $(this).attr('id');
            var returns_id = chkbox_id.slice(14);

            if (assigned_returns.in_array(returns_id) == false)
                assigned_returns.push(returns_id);

            if ($(this).is(':checked') == false)
                assigned_returns.removeByValue(returns_id)

            assigned_to.val(assigned_returns);
        });
    },
    selectMiners: function () {
        var assigned_miners = new Array();
        var assigned_to = $("#selected_miners");

        //wholesome selection/deselction
        $("#assign_all").change(function () {
            if ($(".assign_chkbox").is(':checked') == false) {
                $(".assign_chkbox").attr('checked', true);

                $('input:checkbox.assign_chkbox').each(function () {
                    var miner = $(this).val();
                    assigned_miners.push(miner);
                    assigned_to.val(assigned_miners);
                });

            }
            else {
                $(".assign_chkbox").attr('checked', false);
                assigned_miners = [];
                assigned_to.val('');
            }
        });

        //individual selection
        $(".assign_chkbox").change(function () {
            $("#assign_all").attr('checked', false);

            var miner = $(this).val();

            if (assigned_miners.in_array(miner) == false)
                assigned_miners.push(miner);

            if ($(this).is(':checked') == false)
                assigned_miners.removeByValue(miner)

            assigned_to.val(assigned_miners);
        });
    },
    profileFormValidation: function () {
        // CHANGED THE  mie_name, last_name, phone, fax FROM REQUIRED TO NOT REQURIED
        //  UDAY SHANKAR SINGH 10TH JUNE 2014 
        $("#frmUserProfile").validate({
            rules: {
                "F[first_name]": {
                    required: true,
                    maxlength: 50
                },
                "F[mid_name]": {
                    required: false,
                    maxlength: 50
                },
                "F[last_name]": {
                    required: false,
                    maxlength: 50
                },
                "F[email]": {
                    required: true,
                    email: true
                },
                "F[mobile]": {
                    required: true,
                    number: true,
                    maxlength: 15
                },
                "F[phone]": {
                    number: false,
                    maxlength: 15
                },
                "F[fax]": {
                    number: false,
                    maxlength: 20
                }
            },
            errorElement: "div",
            messages: {
                "F[first_name]": {
                    required: "Please enter your First Name.",
                    maxlength: "First Name should be less than 50 charaters."
                },
                "F[mid_name]": {
                    required: "Please enter your Middle Name.",
                    maxlength: "Middle Name should be less than 50 charaters."
                },
                "F[last_name]": {
                    required: "Please enter your Last Name.",
                    maxlength: "Last Name should be less than 50 charaters."
                },
                "F[email]": {
                    required: "Please enter your email address.",
                    email: "Email address is invalid."
                },
                "F[mobile]": {
                    required: "Please enter your mobile number.",
                    number: "Mobile number is not valid."
                },
                "F[phone]": {
                    required: "Please enter your phone number.",
                    number: "Phone number is not valid."
                },
                "F[fax]": {
                    required: "Please enter your fax number.",
                    number: "Fax number is not valid."
                }
            }
        });
    },
    profileDistricts: function () {
        $('#F_state_code').change(function () {
            var state = $.trim($("#F_state_code option:selected").val());

            $('.ajaxloader').fadeIn();

            $.ajax({
                url: 'getDistricts',
                data: 'state=' + state,
                type: 'POST',
                //        dataType: 'xml',
                success: function (response) {
                    var data = json_parse(response);
                    var district = document.getElementById('F_district_id');

                    for (var i = 0; i < data.length; i++) {
                        var option = document.createElement('option');
                        option.innerHTML = data[i]['district'];
                        option.value = data[i]['id'];
                        district.appendChild(option);
                    }

                    $('.ajaxloader').hide();
                }
            });
        });

    },
    selectState: function (state_code, dist_id) {
        var state = $("#F_state_code").val(state_code);

        $('.ajaxloader').fadeIn();

        $.ajax({
            url: 'getDistricts',
            data: 'state=' + state_code,
            type: 'POST',
            success: function (response) {
                var data = json_parse(response);
                var district = document.getElementById('F_district_id');

                for (var i = 0; i < data.length; i++) {
                    var option = document.createElement('option');
                    option.innerHTML = data[i]['district'];
                    option.value = data[i]['id'];
                    district.appendChild(option);
                }

                $('#F_district_id').val(dist_id);
                $('.ajaxloader').hide();
            }
        });
    },
    selectUsers: function () {
        var assigned_users = new Array();
        var assigned_to = $("#selected_users");

        //wholesome selection/deselction
        $("#assign_all").change(function () {
            if ($(".assign_chkbox").is(':checked') == false) {
                $(".assign_chkbox").attr('checked', true);

                $('input:checkbox.assign_chkbox').each(function () {
                    var user = $(this).val();
                    assigned_users.push(user);
                    assigned_to.val(assigned_users);
                });

            }
            else {
                $(".assign_chkbox").attr('checked', false);
                assigned_users = [];
                assigned_to.val('');
            }
        });

        //individual selection
        $(".assign_chkbox").change(function () {
            $("#assign_all").attr('checked', false);

            var user = $(this).val();

            if (assigned_users.in_array(user) == false)
                assigned_users.push(user);

            if ($(this).is(':checked') == false)
                assigned_users.removeByValue(user)

            assigned_to.val(assigned_users);
        });
    },
    getJurisdictionRegions: function () {
        var _this = this;
        $("#jurisdiction").change(function () {
            var zone = $(this).val();
            _this.getRegions(zone);
        });
    },
    getRegions: function (zone) {
        $.ajax({
            url: 'getRegions',
            type: 'POST',
            data: "zone=" + zone,
            success: function (response) {
                var data = json_parse(response);
                var region = document.getElementById('area');
                $(region).empty();

                var i = 0;
                $.each(data, function (index, item) {
                    var option = document.createElement('option');
                    if (i == 0)
                        option.value = "";
                    else
                        option.value = item;
                    option.innerHTML = item;
                    region.appendChild(option);
                    i++;
                });
            }
        });
    },
    getDistricts: function (area) {

        $.ajax({
            url: 'getDistrictsByRegion',
            type: 'POST',
            data: "area=" + area,
            success: function (response) {
                var data = json_parse(response);
                var district = document.getElementById('district');
                $(district).empty();

                $.each(data, function (key, item) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.innerHTML = item;
                    district.appendChild(option);
                });
            }
        });
    },
    getAreaState: function ()
    {
        var _this = this;
        $("#area").change(function () {
            var area = $(this).val();
            _this.getStatefn(area);
        });
    },
    getStatefn: function (reg) {
        $.ajax({
            url: 'getStateByRegion',
            type: 'POST',
            data: "regarea=" + reg,
            success: function (response) {
                var data = json_parse(response);
                var state = document.getElementById('state');
                $(state).empty();
                var dummy_option = document.createElement('option');
                dummy_option.value = "";
                dummy_option.innerHTML = "Select";
                state.appendChild(dummy_option);
                $.each(data, function (key, item) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.innerHTML = item;
                    state.appendChild(option);
                });
            }
        });
    },
    getAreaDistricts: function () {
        var _this = this;
        $("#area").change(function () {
            var area = $(this).val();
            _this.getDistricts(area);
        });
    },
    getAreaDistrictsNew: function () {
        var _this = this;
        $("#state").change(function () {
            var state = $(this).val();
            _this.getDistrictsByState(state);
        });
    },
    getDistrictsByState: function (area) {
		
		/*
			* Check areaCode for J&K and D&D. If areaCode is related to J&K then change areaCode from 'J&K' to 'JNK'.
			* If areaCode is related to D&D then change areaCode from 'D&D' to 'DND'.
		    * Change Done By Pravin Bhakare on Date 21-01-2019 
		    * This was done to address the issue of Jammu & Kashmir state which not fetch district list under Jammu & kashimer and 
			* issue of Daman & DIU state which not fetch district list under Daman & DIU.
		*/
		if(area == 'J&K'){ area = 'JNK'; }
		if(area == 'D&D'){ area = 'DND'; }
		
		
		/*********************************/
        $.ajax({
            url: 'getDistrictsByState',
            type: 'POST',
            data: "state=" + area,
            success: function (response) {
                var data = json_parse(response);
                var district = document.getElementById('district');
                $(district).empty();

                var dummy_option = document.createElement('option');
                dummy_option.value = "";
                dummy_option.innerHTML = "Select";
                district.appendChild(dummy_option);

                $.each(data, function (key, item) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.innerHTML = item;
                    district.appendChild(option);
                });
            }
        });
    },
    autoCompleteDistricts: function (url) {
        Utilities.autoCompleteWidget();

        $("#district").catcomplete({
            source: url,
            select: function (event, ui) {
                var dist_id = ui.item.dist_id;
                $('#district_id').val(dist_id);
            }
        });
    },
    checkDate: function () {
        var temp_from_date = document.getElementById('from_date').value;
        if (temp_from_date == "") {
            alert('Please enter the From Date');
            return false;
        }
        var temp_2 = temp_from_date.split('-');
        var from_date = temp_2[2] + "-" + temp_2[1] + "-" + temp_2[0];

        var temp_to_date = document.getElementById('to_date').value;
        if (temp_to_date == "") {
            alert('Please enter the To Date');
            return false;
        }

        var temp = temp_to_date.split('-');
        var to_date = temp[2] + "-" + temp[1] + "-" + temp[0];

        if (to_date != "") {
            if ((new Date(to_date).getTime() < new Date(from_date).getTime())) {
                alert("From Date should be less than To Date.");
                return false;
            } else {
                return true;
            }
        }
    },
    checkreportDate: function () {
        var return_type = document.getElementById('return_type').value;
        // FOR MONTHLY RETURNS REPORT
        if (return_type == 'MONTHLY')
        {
            var msg = 'Date';
            var f_month = document.getElementById('start_month').value;
            //            console.log(f_month)
            if (f_month == "")
            {
                alert('Please enter the From Month');
                return false;
            }
            var f_year = document.getElementById('start_year').value;
            if (f_year == "")
            {
                alert('Please enter the From Year');
                return false;
            }

            var checkMonthElement = $("#to_month");
            if (checkMonthElement)
                var t_month = $("#to_month").val();

            if (t_month == "")
            {
                alert('Please enter the To Month');
                return false;
            }

            var checkYearElement = $("#to_year");
            if (checkYearElement)
                var t_year = $('#to_year').val();
            if (t_year == "")
            {
                alert('Please enter the To Month');
                return false;
            }
            var temp_from_date = f_month + "-" + f_year;
            document.getElementById('from_date').value = temp_from_date;

            if (t_month && t_year) {
                var temp_to_date = t_month + "-" + t_year;
                document.getElementById('to_date').value = temp_to_date;
            }
            /* Below added code added by ganesh satav because of add the validation for regitration no
             * vertion 1/7/2014
             *
             */
            var checkForRegNoField = document.getElementById('Registration_no');
            if (checkForRegNoField) {
                var f_reg = document.getElementById('Registration_no').value;
                if (f_reg == "-Please Select Id -")
                {
                    alert('Please select Registration No');
                    return false;
                }
            }
        } else
        {
            var msg = 'Year';
        }
        var temp_from_date = document.getElementById('from_date').value;
        if (temp_from_date == "") {
            alert('Please enter the From ' + msg + '.');
            return false;
        }
        var temp_2 = temp_from_date.split('-');
        var from_date = temp_2[2] + "-" + temp_2[1] + "-" + temp_2[0];

        var toDateCheck = $("#to_date").val();
        if (toDateCheck) {
            var temp_to_date = document.getElementById('to_date').value;
            if (temp_to_date == "") {
                alert('Please enter the To ' + msg + '.');
                return false;
            }

            var temp = temp_to_date.split('-');
            var to_date = temp[2] + "-" + temp[1] + "-" + temp[0];
            if (to_date != "") {
                if ((new Date(to_date).getTime() < new Date(from_date).getTime())) {
                    alert("From " + msg + " should be less than To " + msg + '.');
                    return false;
                }
            }
        }
        var fromDate = new Date(from_date);
        var toDate = new Date(to_date).getTime();
        if (return_type == 'MONTHLY')
        {
            if (new Date(fromDate).setMonth(fromDate.getMonth() + 11) < new Date(toDate).getTime()) {
                alert("Selected date range should be 1 to 12 month");
                return false;
            } else
                return true;
        } else
        {
            if (new Date(fromDate).setYear(fromDate.getFullYear() + 5) < new Date(toDate).getTime()) {
                alert("Selected year range should be 1 to 5 year");
                return false;
            } else
                return true;
        }
        return false;
    },
    checkCombination: function () {
        var txtCombination = parseInt($("#txtCombination").val());
        var txtPeriod = parseInt($("#txtPeriod").val());

        var combinationValidityTest = txtCombination * txtPeriod;
        if (combinationValidityTest != 12) {
            alert("Product of Period and Combination Must be 12");
            return false;
        }
        else
            return true;

    },
    selectreportState: function (state_code) {
		
		/*
			* Check areaCode for J&K and D&D. If areaCode is related to J&K then change areaCode from 'J&K' to 'JNK'.
			* If areaCode is related to D&D then change areaCode from 'D&D' to 'DND'.
		    * Change Done By Pravin Bhakare on Date 21-01-2019 
		    * This was done to address the issue of Jammu & Kashmir state which not fetch district list under Jammu & kashimer and 
			* issue of Daman & DIU state which not fetch district list under Daman & DIU.
		*/
		
		if(state_code == 'J&K'){ state_code = 'JNK'; }
		if(state_code == 'D&D'){ state_code = 'DND'; }
		
		/***********************************/
        Utilities.ajaxBlockUI();
        $.ajax({
            url: 'getDistricts',
            data: 'state=' + state_code,
            type: 'POST',
            success: function (response) {
                var data = json_parse(response);
                $('#district_code').find('option').remove();
                var district = $('#district_code');
                var option = $(document.createElement('option'));
                option.html('-Please Select District-');
                option.val('');
                district.append(option);
                for (var i = 0; i < data.length; i++) {
                    var option = $(document.createElement('option'));
                    option.html(data[i]['district']);
                    option.val(data[i]['id']);
                    district.append(option);
                }
                $('#district_code').val(0);
            }
        });
    },
    reportDatePicker: function () {
        $("#from_date,#to_date").datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: new Date(2011, 1 - 1, 1)
        });
    }
}


/**
 * JS Engine
 * Returns true if a value exists in the given array
 */
Array.prototype.in_array = function (p_val) {
    for (var i = 0, l = this.length; i < l; i++) {
        if (this[i] == p_val) {
            return true;
        }
    }
    return false;
}

/**
 * JS Engine
 * Removes the array element by key value
 */
Array.prototype.removeByValue = function (val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) {
            this.splice(i, 1);
            break;
        }
    }
}