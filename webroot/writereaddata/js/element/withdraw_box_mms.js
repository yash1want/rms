let appEditor;

// ClassicEditor
// .create( document.querySelector( '#letter_content' ) )
// .then( editor => {
//     appEditor = editor;
// } )
// .catch( error => {
//     console.error( error );
// } );

tinymce.init({
    selector: 'textarea#letter_content',
    height: 350,
    menubar: false,
    quickbars_insert_toolbar: 'image table',
    plugins: 'advlist lists fullscreen table paste wordcount image link autolink visualblocks quickbars media',
    toolbar_mode: 'wrap',
    image_advtab: true,
     quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quicktable imageoptions',
    toolbar: 'undo redo | fontselect | fontsizeselect | formatselect | ' +' | bullist numlist | outdent indent |  bold italic underline strikethrough forecolor backcolor '+
    ' | alignleft aligncenter alignright alignjustify | ' +
    'removeformat | '+' image media | table fullscreen  preview |',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
       });

$(document).ready(function() {

    $('.withdraw_btn').on('click', function(){
        
        $('#plz_wait_withdraw').show();
        $('#plz_wait_letter_modal').hide();
        $('#withdraw_reason_div').show();

        $('#withdraw_alert').show();
        $('#confirm_withdraw').show();
        $('#letter_continue').hide();
        $('#withdraw_app_btn').hide();
        $('#esign_div').hide();
        $('#letter_modal_div').hide();
        $('#cancel_withdraw_modal').show();
        
        $('#withdraw_reason').val('');
        $('#declaration_check_box').prop('checked',false);

        $('#submit_without_esign_btn').hide(); //testing purpose only
        $('#esign_submit_btn').hide();

        var lnm = $(this).attr('lnm');
        var mlpbcode = $(this).attr('mlpbcode');
        var mlpbtype = $(this).attr('mlpbtype');
        var lid = $(this).attr('lid');
        var appid = $(this).attr('appid');
        $('#tbl_lease_name').text(lnm);
        $('#tbl_ml_pb_code').text(mlpbcode);
        $('#tbl_ml_pb_type').text(mlpbtype);
        $('#lease_id').val(lid);
        $('#lease_name').val(lnm);
        $('#ml_pb_code').val(mlpbcode);
        $('#ml_pb_type').val(mlpbtype);
        $('#applicant_id').val(appid);
        
        var getWithdrawReasonUrl = $('#get_withdraw_reason_url').val();

        $.ajax({
            type:'POST',
            async: true,
            cache: false,
            url: getWithdrawReasonUrl,
            data: {'action':'get_reason','lease_id':lid,'applicant_id':appid},
            beforeSend: function (xhr) { // for csrf token
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                $('.form_spinner').hide('slow');
            },
            success: function(resp){
                resp = JSON.parse(resp);
                $('#withdraw_reason').val(resp['reason']);
                $('#plz_wait_withdraw').hide();
            }

        });

    });

    $('#confirm_withdraw').on('click',function(){

        $("#plz_wait_letter_modal").show();

        $('#withdraw_reason_div').hide();
        $('#letter_modal_div').show();

        $('#confirm_withdraw').hide();
        $('#letter_continue').show();


        var getLetterModalContentUrl = $('#get_letter_modal_content_url').val();
        var applicant_id = $('#applicant_id').val();
        var lease_id = $('#lease_id').val();
        var applicant_id = $('#applicant_id').val();
        var ml_pb_code = $('#ml_pb_code').val();
        var ml_pb_type = $('#ml_pb_type').val();
        $.ajax({
            type:'POST',
            async: true,
            cache: false,
            url: getLetterModalContentUrl,
            data: {'action':'get_letter_content','letter_type':'withdraw','lease_id':lease_id,'applicant_id':applicant_id,'ml_pb_code':ml_pb_code,'ml_pb_type':ml_pb_type},
            beforeSend: function (xhr) { // for csrf token
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                $('.form_spinner').hide('slow');
            },
            success: function(resp){
                resp = JSON.parse(resp);

                $('#letter_to').html(resp['letter_to']);
                $('#letter_region_name').html(resp['region_name']);
                $('#letter_sub').html(resp['letter_sub']);
                // appEditor.setData(resp['letter_content']);
                tinyMCE.get('letter_content').setContent(resp['letter_content']);
                
                $("#plz_wait_letter_modal").hide();
            }

        });


    });

    // $('#confirm_withdraw').on('click',function(){

    //     $('#confirm_withdraw').hide();
    //     $('#withdraw_reason_div').show();
    //     $('#withdraw_app_btn').show();
    //     var leaseId = $('#lease_id').val();
    //     var previewPdfUrl = $('#withdraw_preview_url').val();
    //     var previewPdfFullUrl = previewPdfUrl+'/'+leaseId;
    //     $('#preview_pdf_lnk').attr('href',previewPdfFullUrl);
    //     $('#pdf_generation_url').val(previewPdfFullUrl);

    // });

    $('#letter_continue').on('click',function(){

        //check form validation here
        if(checkLetterModalValidation() == true){
            
            $("#plz_wait_letter_modal").show();

            var setLetterContentUrl = $('#set_letter_content_url').val();
            var letter_no = $('#letter_no').val();
            var letter_dt = $('#letter_dt').val();
            var letter_to = $('#letter_to').val();
            var letter_sub = $('#letter_sub').val();
            // var letter_content = appEditor.getData();
            var letter_content = tinyMCE.get('letter_content').getContent();
            var lease_id = $('#lease_id').val();
            var lease_name = $('#lease_name').val();
            var applicant_id = $('#applicant_id').val();
            var app_esign_action = $('#app_esign_action').val();
            var ml_pb_code = $('#ml_pb_code').val();
            var ml_pb_type = $('#ml_pb_type').val();

            $.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: setLetterContentUrl,
                data: {'action':'set_letter_content','app_esign_action':app_esign_action,'lease_id':lease_id,'applicant_id':applicant_id,'lease_name':lease_name,'ml_pb_code':ml_pb_code,'ml_pb_type':ml_pb_type,'letter_no':letter_no,'letter_dt':letter_dt,'letter_to':letter_to,'letter_sub':letter_sub,'letter_content':letter_content},
                beforeSend: function (xhr) { // for csrf token
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    $('.form_spinner').hide('slow');
                },
                success: function(resp){
                    if(resp.trim() == 1){

                        $('#letterModal .close').trigger('click');

                        $('#esign_div').show();
                        $('#withdraw_alert').hide();
                        $('#withdraw_reason_div').hide();
                        $('#cancel_withdraw_modal').hide();
                        $('#withdraw_app_btn').hide();
                        $('#confirm_withdraw').hide();
                        $('#letter_modal_div').hide();
                        $('#letter_continue').hide();

                        //testing purpose only
                        $('#esign_submit_btn').show(); //testing purpose only
                        $('#submit_without_esign_btn').show(); //testing purpose only

                    }else{
                        $('#letter_modal_error').html('<div class="alert alert-danger">Something went wrong! Try again later.</span>');
                    }
                    $("#plz_wait_letter_modal").hide();
                }

            });

        }

    });

    $('#letter_modal_div input').on('input',function(){
        $(this).removeClass('is-invalid');
        $('#letter_modal_error').html('');
    });

});

function checkLetterModalValidation(){

    var valid_in = true;
    var letter_no = $('#letter_no').val();
    var letter_dt = $('#letter_dt').val();
    var letter_to = $('#letter_to').val();
    var letter_sub = $('#letter_sub').val();
    // var letter_content = $('#letter_content').val();
    if(letter_no == ''){
        $('#letter_no').addClass('is-invalid');
        $('#letter_no').focus();
        valid_in = false;
    }
    if(letter_dt == ''){
        $('#letter_dt').addClass('is-invalid');
        $('#letter_dt').focus();
        valid_in = false;
    }
    if(letter_to == ''){
        $('#letter_to').addClass('is-invalid');
        $('#letter_to').focus();
        valid_in = false;
    }
    if(letter_sub == ''){
        $('#letter_sub').addClass('is-invalid');
        $('#letter_sub').focus();
        valid_in = false;
    }
    // if(letter_content == ''){
    //     $('#letter_content').addClass('is-invalid');
    //     $('#letter_content').focus();
    //     valid_in = false;
    // }
    if(valid_in == false){
        $('#letter_modal_error').html('<div class="alert alert-danger">Invalid data!</div>');
    }

    return valid_in;

}