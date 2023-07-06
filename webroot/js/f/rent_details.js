
$(document).ready(function() {

    $('#f_past_royalty').on('focusout', function() {
        checkDmfNmetRoyalty('toast');
    });

    $('#f_past_pay_dmf').on('focusout', function() {
        checkDmfNmetRoyalty('toast');
    });
    
    $('#f_past_pay_nmet').on('focusout', function() {
        checkDmfNmetRoyalty('toast');
    });

    $('#frmRentDetails').on('submit', function() {
        checkDmfNmetRoyalty('alert');
    });

});

function checkDmfNmetRoyalty(warningMethod) {

    var royaltyPaid = $('#f_past_royalty').val();
    var dmfPaid = $('#f_past_pay_dmf').val();
    var nmetPaid = $('#f_past_pay_nmet').val();
    if (royaltyPaid.length > 0 && dmfPaid.length > 0 && nmetPaid.length > 0) {
        
        var royaltyPaidVal = parseInt($('#f_past_royalty').val());
        var dmfPaidVal = parseInt($('#f_past_pay_dmf').val());
        var nmetPaidVal = parseInt($('#f_past_pay_nmet').val());
        if (royaltyPaidVal > 0) {
            
            if (dmfPaidVal == 0) {
                var warningMsg = 'Kindly check "Payment made to the DMF" because "Royalty paid" is positive';
                if (warningMethod == 'toast') {
                    showAlrt(warningMsg);
                } else {
                    alert(warningMsg);
                }
            }
            
            if (nmetPaidVal == 0) {
                var warningMsg = 'Kindly check "Payment made to the NMET" because "Royalty paid" is positive';
                if (warningMethod == 'toast') {
                    showAlrt(warningMsg);
                } else {
                    alert(warningMsg);
                }
            }
            
        }

    }

}

