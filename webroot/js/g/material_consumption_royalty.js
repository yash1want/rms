
$(document).ready(function(){

    //=========================FORM VALIDATION==================================
    Royality.fieldValidation();
    var royalityMonthlyTotal = $('#monthly_royalty_total').val();
    Royality.monthlyAnnualAlert(royalityMonthlyTotal);
    Royality.postValidation(royalityMonthlyTotal);

});