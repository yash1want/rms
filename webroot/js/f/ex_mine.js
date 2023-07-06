
$(document).ready(function(){

    f5Rom.formExMineF5Validation();
    
    $('#btnExMine').parent().closest('form').attr('id','frmExMineF5');
    
    $("#frmExMineF5").on('submit', function() {
        
        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmExMineF5');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
        
        var totalRomProd = $("#totalRomProd").val();
        var pmv = $("#f_pmv").val();

        if (pmv == 0) {
            if (totalRomProd > 0) {
                alert("Please enter the ex-mine price > 0");
                returnFormStatus = false;
            }
        }

        return returnFormStatus;
        
    });

});