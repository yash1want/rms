$(document).ready(function() {

    checkSavingBtn();

    $('.payment_radio_btn').on('click', function() {

        var paymentStatus = $('.payment_radio_btn[name="bharatkosh_payment_done"]:checked').val();
        
        if (paymentStatus == 'yes') {
            $('.payment_field').show();
            $('#btnSubmit').show();
        } else {
            $('.payment_field').hide();
            $('#btnSubmit').hide();
        }

    });

    $('#payment_receipt_document').on('change',function(){
        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['pdf','jpg','jpeg']) == -1) {
            var el = $('#payment_receipt_document');
            el.addClass('is-invalid');
            el.wrap('<form>').closest('form').get(0).reset();
            el.unwrap();
            $('#error_payment_receipt_document').text("Invalid file type!");
        }

        if(window.FileReader && window.File && window.FileList && window.Blob){
            var fSize = $('#payment_receipt_document')[0].files[0].size;
            if(fSize > 2097152){
                var el = $('#payment_receipt_document');
                el.addClass('is-invalid');
                el.wrap('<form>').closest('form').get(0).reset();
                el.unwrap();
                $('#error_payment_receipt_document').text("File too large. File must be less than 2 megabytes.");
            }
        }
    });
    
    $('#payment_receipt_document').on('click',function(){
        var el = $('#payment_receipt_document');
        el.removeClass('is-invalid');
        $('#error_payment_receipt_document').text("");
    });

});

function checkSavingBtn() {
    
    var paymentStatus = $('.payment_radio_btn[name="bharatkosh_payment_done"]:checked').val();
    if (paymentStatus == 'yes') {
        $('#btnSubmit').show();
    } else {
        $('#btnSubmit').hide();
    }
    
}