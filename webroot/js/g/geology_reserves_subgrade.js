
$(document).ready(function() {

    SecFour.fieldValidation();
    
    mReservTot('begin');
    rResourceTot('begin');
    resResourceTot('begin');
    mReservTot('during');
    rResourceTot('during');
    resResourceTot('during');
    mReservTot('depletion');
    rResourceTot('depletion');
    resResourceTot('depletion');
    mReservTot('balance');
    rResourceTot('balance');
    resResourceTot('balance');

    $('.rs_balance').on('change', function() {

        var rw = $(this).closest('tr');
        var rsBegin = rw.find('.rs_begin').val();
        var rsDuring = rw.find('.rs_during').val();
        var rsDepletion = rw.find('.rs_depletion').val();
        var rsBalanceCal = parseInt(rsBegin) + parseInt(rsDuring) - parseInt(rsDepletion);
        var rsBalance = parseInt($(this).val());

        if (rsBalance != rsBalanceCal) {
            showAlrt('Balance resources should be equal to <br><b>(6) = (3+4-5) </b>');
            $(this).val('');
        }

    });

    $('.rs_begin').on('change', function() {
        mReservTot('begin');
        rResourceTot('begin');
        resResourceTot('begin');
    });
    $('.rs_during').on('change', function() {
        mReservTot('during');
        rResourceTot('during');
        resResourceTot('during');
    });
    $('.rs_depletion').on('change', function() {
        mReservTot('depletion');
        rResourceTot('depletion');
        resResourceTot('depletion');
    });
    $('.rs_balance').on('change', function() {
        mReservTot('balance');
        rResourceTot('balance');
        resResourceTot('balance');
    });

});

function mReservTot(mRes) {
    
    var mReserv = 0;
    for(var i=1; i <= 3; i++) {
        var rs =  $('#row-'+i).find('.rs_'+mRes).val();
        mReserv += (rs != '') ? parseFloat(rs) : 0;
    }
    
    $('#mReserv'+mRes+'Tot').text(mReserv.toFixed(2));

}

function rResourceTot(rRes) {
    
    var rResource = 0;
    for(var i=4; i <= 10; i++) {
        var rs =  $('#row-'+i).find('.rs_'+rRes).val();
        rResource += (rs != '') ? parseFloat(rs) : 0;
    }
    
    $('#rResource'+rRes+'Tot').text(rResource.toFixed(2));

}

function resResourceTot(res) {

    var mRes = $('#mReserv'+res+'Tot').text();
    var rRes = $('#rResource'+res+'Tot').text();
    $('#'+res+'Tot').text((parseInt(mRes) + parseInt(rRes)).toFixed(2));

}
