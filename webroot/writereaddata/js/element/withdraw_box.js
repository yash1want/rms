$(document).ready(function() {

    $('.withdraw_btn').on('click', function(){
        $('#withdraw_alert').show();
        $('#confirm_withdraw').show();
        $('#withdraw_reason_div').hide();
        $('#withdraw_app_btn').hide();
        $('#esign_div').hide();
        
        $('#withdraw_reason').val('');
        $('#declaration_check_box').prop('checked',false);

        $('#submit_without_esign_btn').hide(); //testing purpose only
        $('#esign_submit_btn').hide();

        var lnm = $(this).attr('lnm');
        var mlpbcode = $(this).attr('mlpbcode');
        var mlpbtype = $(this).attr('mlpbtype');
        var lid = $(this).attr('lid');
        var appid = $(this).attr('appid');
        $('#lease_name').text(lnm);
        $('#ml_pb_code').text(mlpbcode);
        $('#ml_pb_type').text(mlpbtype);
        $('#lease_id').val(lid);
        $('#lease_name').val(lnm);
        $('#ml_pb_code').val(mlpbcode);
        $('#ml_pb_type').val(mlpbtype);
        $('#applicant_id').val(appid);
    });

    $('#confirm_withdraw').on('click',function(){

        $('#confirm_withdraw').hide();
        $('#withdraw_reason_div').show();
        $('#withdraw_app_btn').show();
        var leaseId = $('#lease_id').val();
        var previewPdfUrl = $('#withdraw_preview_url').val();
        var previewPdfFullUrl = previewPdfUrl+'/'+leaseId;
        $('#preview_pdf_lnk').attr('href',previewPdfFullUrl);
        $('#pdf_generation_url').val(previewPdfFullUrl);

    });

    $('#withdraw_app_btn').on('click',function(){

        var withdrawReason = $('#withdraw_reason').val();
        if(withdrawReason != ''){

            $("#plz_wait_withdraw").show();
            var setWithdrawReasonUrl = $('#set_withdraw_reason_url').val();
            var leaseId = $('#lease_id').val();
            var lease_name = $('#lease_name').val();
            var ml_pb_code = $('#ml_pb_code').val();
            var ml_pb_type = $('#ml_pb_type').val();
            var applicant_id = $('#applicant_id').val();

            $.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: setWithdrawReasonUrl,
                data: {'action':'reason','reason':withdrawReason,'leaseid':leaseId,'lease_name':lease_name,'ml_pb_code':ml_pb_code,'ml_pb_type':ml_pb_type,'applicant_id':applicant_id},
                beforeSend: function (xhr) { // for csrf token
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    $('.form_spinner').hide('slow');
                },
                success: function(resp){
                    if(resp.trim() == 1){
                        $('#esign_div').show();
                        $('#withdraw_alert').hide();
                        $('#withdraw_reason_div').hide();
                        $('#cancel_withdraw_modal').hide();
                        $('#withdraw_app_btn').hide();

                        //testing purpose only
                        $('#esign_submit_btn').show(); //testing purpose only
                        $('#submit_without_esign_btn').show(); //testing purpose only

                    }else{
                        $('#withdraw_reason_error').text('Something went wrong! Try again later.');
                    }
                    $("#plz_wait_withdraw").hide();
                }

            });

        }else{
            $('#withdraw_reason').addClass('is-invalid');
            $('#withdraw_reason_error').text('Required field');
        }

    });

    $('#withdraw_reason').on('click',function(){
        $('#withdraw_reason').removeClass('is-invalid');
        $('#withdraw_reason_error').text('');
    });

});