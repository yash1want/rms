
$(document).ready(function(){

	$('#frmDailyAverage').ready(function(){

		var returnMonthTotalDays = $('#return_month_total_days').val();
		// custom_validations.openWageCalculation(returnMonthTotalDays);
		// custom_validations.belowWageCalculation(returnMonthTotalDays);
		// custom_validations.aboveWageCalculation(returnMonthTotalDays);
		// custom_validations.totalSalary(returnMonthTotalDays);
		// custom_validations.dailyEmploymentValidations();
		
		custom_validations.openWageCalculation(returnMonthTotalDays);
		custom_validations.belowWageCalculation(returnMonthTotalDays);
		custom_validations.aboveWageCalculation(returnMonthTotalDays);
		custom_validations.totalSalary(returnMonthTotalDays);
		custom_validations.dailyEmploymentValidations();
		custom_validations.dailyEmploymentPostValidation();
		
	});

});


//BELOW VALIDATION'S ARE ADDED FOR THE TOTAL WAGES CALCULATIONS OF DIRECT AND CONTRACTUAL TOTAL 
//THAT IF THE NO. OF MALE AND NO. OF FEMALE FIELD IS ENTERED SOME VALUES THEN THE DIRECT AND CONRTACTUAL FIELD
//SHOULD NOT BE ZERO, THERE SHOULD BE CALUCLATED VALUE
//ADDED ON JAN-08 2022 BY AKASH 
jQuery(document).ready(function () {

	//Below Direct Total 
	$('#F_Below_WAGE_DIRECT').focusout(function (e) { 
		e.preventDefault();
		
		var belowMaleDirectValue = jQuery.trim($("#F_Below_MALE_AVG_DIRECT").val());
		var belowFemaleDirectValue = jQuery.trim($("#F_Below_FEMALE_AVG_DIRECT").val());
		var belowTotalDirect = jQuery.trim($("#F_Below_WAGE_DIRECT").val());

		if (parseInt(belowMaleDirectValue) || parseInt(belowFemaleDirectValue) > 0) {
			if (parseInt(belowTotalDirect) == 0) {
				showAlrt("Average Daily Wages should not be zero");
				$('#F_Below_WAGE_DIRECT').val(''); 
			}
		}
	});

	//Open Direct Total
	$('#F_Open_WAGE_DIRECT').focusout(function (e) { 
		e.preventDefault();
		
		var openMaleDirectValue = jQuery.trim($("#F_Open_MALE_AVG_DIRECT").val());
		var openFemaleDirectValue = jQuery.trim($("#F_Open_FEMALE_AVG_DIRECT").val());
		var openTotalDirect = jQuery.trim($("#F_Open_WAGE_DIRECT").val());

		if (parseInt(openMaleDirectValue) || parseInt(openFemaleDirectValue) > 0) {
			if (parseInt(openTotalDirect) == 0) {
				showAlrt("Average Daily Wages should not be zero");
				$('#F_Open_WAGE_DIRECT').val(''); 

			}
		}
	});

	//Above Direct Total
	$('#F_Above_WAGE_DIRECT').focusout(function (e) { 
		e.preventDefault();
		
		var aboveMaleDirect = jQuery.trim($("#F_Above_MALE_AVG_DIRECT").val());
		var aboveFemaleDirect = jQuery.trim($("#F_Above_FEMALE_AVG_DIRECT").val());
		var aboveTotalDirect = jQuery.trim($("#F_Above_WAGE_DIRECT").val());

		if (parseInt(aboveMaleDirect) || parseInt(aboveFemaleDirect) > 0) {
			if (parseInt(aboveTotalDirect) == 0) {
				showAlrt("Average Daily Wages should not be zero");
				$('#F_Above_WAGE_DIRECT').val(''); 
			}
		}
	});


	//Below Contract Total
	$('#F_Below_WAGE_CONTRACT').focusout(function (e) { 
		e.preventDefault();
		
		var belowGroundMaleContract = jQuery.trim($("#F_Below_MALE_AVG_CONTRACT").val());
		var belowFemaleContract = jQuery.trim($("#F_Below_FEMALE_AVG_CONTRACT").val());
		var belowTotalContract = jQuery.trim($("#F_Below_WAGE_CONTRACT").val());

		if (parseInt(belowGroundMaleContract) || parseInt(belowFemaleContract) > 0) {
			if (parseInt(belowTotalContract) == 0) {
				showAlrt("Average Daily Wages should not be zero");
				$('#F_Below_WAGE_CONTRACT').val(''); 
			}
		}
	});


	//Open Contract Total
	$('#F_Open_WAGE_CONTRACT').focusout(function (e) { 
		e.preventDefault();
		
		var openCastMaleContract = jQuery.trim($("#F_Open_MALE_AVG_CONTRACT").val());
		var openFemaleContract = jQuery.trim($("#F_Open_FEMALE_AVG_CONTRACT").val());
		var openTotalContract = jQuery.trim($("#F_Open_WAGE_CONTRACT").val());

		if (parseInt(openCastMaleContract) || parseInt(openFemaleContract) > 0) {
			if (parseInt(openTotalContract) == 0) {
				showAlrt("Average Daily Wages should not be zero");
				$('#F_Open_WAGE_CONTRACT').val(''); 

			}
		}
	});

	//Above Contract Total
	$('#F_Above_WAGE_CONTRACT').focusout(function (e) { 
		e.preventDefault();
		
		var aboveGroudbMaleContract = jQuery.trim($("#F_Above_MALE_AVG_CONTRACT").val());
		var aboveFemaleContract = jQuery.trim($("#F_Above_FEMALE_AVG_CONTRACT").val());
		var aboveTotalContract = jQuery.trim($("#F_Above_WAGE_CONTRACT").val());

		if (parseInt(aboveGroudbMaleContract) || parseInt(aboveFemaleContract) > 0) {
			if (parseInt(aboveTotalContract) == 0) {
				showAlrt("Average Daily Wages should not be zero");
				$('#F_Above_WAGE_CONTRACT').val(''); 
			}
		}
	});

	
	

});


//The Validations for the daily wages of DIRECT and CONTRACTUAL labour wages Alert if total is correct or not 
//added these on show alert on the Jan 10 - 2022 By AKASH
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