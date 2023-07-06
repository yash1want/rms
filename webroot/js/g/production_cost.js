
$(document).ready(function() {

    $('#frmProductionCost').addClass('mx-auto w-75');
    var overhead = $('#over_head').val();

    ProductionCost.fieldRequiredCheck();
    ProductionCost.checkAllFormFieldsForTotalRequired();
    ProductionCost.fieldValidation(overhead);
    ProductionCost.valueCheck();
    ProductionCost.postValidation();

});
