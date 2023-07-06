
$(document).ready(function(){

    $('#frmRomStocksF7').on('submit', function(){

        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmRomStocksF7');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
        return returnFormStatus;

    });

});