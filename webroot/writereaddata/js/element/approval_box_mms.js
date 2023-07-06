
// commented ckeditor initialization coz having issue in csp
// let appEditor;
// instead using richtexteditor
// on 28-06-2022 by Aniket
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

    $('#letter_last_saved').hide();
    $('#letter_save_draft').hide();

    // final submission by applicant
    $('#final_submt_btn').on('click',function(){

        $('#letter_last_saved').hide();
        $('#letter_save_draft').hide();

        $('#letter_modal_div').hide();
        $('#plz_wait_letter_modal').hide();

        var btnStatus = $(this).attr('st');
        if(btnStatus == 'payment' || btnStatus == 'submit'){

            $('#approvalBoxLabel').html('<i class="fa fa-check-circle header-icon"></i> Final Submission');
            $('#app_esign_action').val(btnStatus);
            $('#esign_pdf_preview_link').text('Final Submission PDF: ');

            $("#plz_wait_withdraw").show();
            $('#esign_div').show();
            $('#esign_btn_div').hide();
            $('#confirm_withdraw').hide();
            $('#letter_modal_common_error').html('');
            $('#letter_continue').hide();
            $('#esign_submit_btn').hide();
            $('#submit_without_esign_btn').hide(); // testing purpose only

            var checkFinalSubmitBtnUrl = $('#check_final_submit_btn_url').val();
            $.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: checkFinalSubmitBtnUrl,
                data: {'action':'check_final_submit','app_esign_action':btnStatus},
                beforeSend: function (xhr) { // for csrf token
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    $('.form_spinner').hide('slow');
                },
                success: function(resp){
                    resp = JSON.parse(resp);

                    if(resp['status'] == true){
                        $('#esign_div').show();
                        $('#esign_btn_div').show();
                        $('#withdraw_alert').hide();
                        $('#withdraw_reason_div').hide();
                        // $('#cancel_letter_modal').hide();
                        $('#withdraw_app_btn').hide();
                        $('#confirm_withdraw').hide();
                        $('#letter_modal_div').hide();
                        $('#letter_continue').hide();
                        $('#letter_modal_common_error').html('<div class="alert alert-info"><i class="fa fa-info-circle"></i> This action can&#39;t be <u>undone</u>! On <b>final submission</b>, no further modification will be done on section.</div>')

                        //testing purpose only
                        $('#esign_submit_btn').show(); //testing purpose only
                        $('#submit_without_esign_btn').show(); //testing purpose only
                    }else{
                        $('#letter_modal_error').html('<div class="alert alert-danger">Something went wrong! Try again later.</span>');
                    }
                    
                    $("#plz_wait_withdraw").hide();

                }

            });

        }

    });

    // approval
    $('#btnApproved').on('click',function(){

        $('#letter_last_saved').hide();
        $('#letter_save_draft').hide();
        
        var btnStatus = $(this).attr('st');
        if(btnStatus == 'final'){

            $('#approvalBoxLabel').html('<i class="fa fa-check-circle header-icon"></i> Final Approve Application');
            $('#app_esign_action').val('approve');
            $('#esign_pdf_preview_link').text('Approval PDF: ');
            $('#letter_no').val('');

            $("#plz_wait_letter_modal").show();
            $('#letter_modal_div').show();
            $('#esign_div').hide();
            $('#esign_btn_div').hide();
            $('#confirm_withdraw').hide();
            $('#letter_continue').show();
            $('#letter_modal_common_error').html('');
            $('#letter_continue').hide();
            $('#esign_submit_btn').hide();
            $('#submit_without_esign_btn').hide(); // testing purpose only

            var getLetterModalContentUrl = $('#get_letter_modal_content_url').val();
            // var applicant_id = $('#applicant_id').val();
            // var lease_id = $('#lease_id').val();
            // var applicant_id = $('#applicant_id').val();
            // var ml_pb_code = $('#ml_pb_code').val();
            // var ml_pb_type = $('#ml_pb_type').val();
            $.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: getLetterModalContentUrl,
                data: {'action':'get_letter_content','letter_type':'approve'},
                beforeSend: function (xhr) { // for csrf token
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    $('.form_spinner').hide('slow');
                },
                success: function(resp){
                    resp = JSON.parse(resp);

                    if(resp['status'] == true){
                        $('#letter_to').html(resp['letter_to']);
                        $('#letter_region_name').html(resp['region_name']);
                        $('#letter_sub').html(resp['letter_sub']);
                        $('#letter_continue').show();
                        tinyMCE.get('letter_content').setContent(resp['letter_content']);

                        // save as draft & retrieve last saved functionality added - Aniket G [27-01-2023]
                        $('#letter_save_draft').show();
                        if(resp['retrieve'] == true){
                            $('#letter_last_saved').show();
                        }
                    }else{
                        $('#letter_modal_div').hide();
                        $('#letter_modal_common_error').html('<div class="alert alert-danger">'+resp['error_txt']+'</div>');
                    }
                    
                    $("#plz_wait_letter_modal").hide();
                }

            });

        }

    });

    // rejection
    $('#btnReject').on('click',function(){

        $('#letter_last_saved').hide();
        $('#letter_save_draft').hide();

        $('#approvalBoxLabel').html('<i class="fa fa-times-circle header-icon"></i> Reject Application');
        $('#app_esign_action').val('reject');
        $('#esign_pdf_preview_link').text('Reject application PDF: ');
        $('#letter_no').val('');

        $("#plz_wait_letter_modal").show();
        $('#letter_modal_div').show();
        $('#esign_div').hide();
        $('#esign_btn_div').hide();
        $('#confirm_withdraw').hide();
        $('#letter_continue').show();
        $('#letter_modal_common_error').html('');
        $('#letter_continue').hide();
        $('#esign_submit_btn').hide();
        $('#submit_without_esign_btn').hide(); // testing purpose only

        var getLetterModalContentUrl = $('#get_letter_modal_content_url').val();
        // var applicant_id = $('#applicant_id').val();
        // var lease_id = $('#lease_id').val();
        // var applicant_id = $('#applicant_id').val();
        // var ml_pb_code = $('#ml_pb_code').val();
        // var ml_pb_type = $('#ml_pb_type').val();
        $.ajax({
            type:'POST',
            async: true,
            cache: false,
            url: getLetterModalContentUrl,
            data: {'action':'get_letter_content','letter_type':'reject'},
            beforeSend: function (xhr) { // for csrf token
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                $('.form_spinner').hide('slow');
            },
            success: function(resp){
                resp = JSON.parse(resp);

                if(resp['status'] == true){
                    $('#letter_to').html(resp['letter_to']);
                    $('#letter_region_name').html(resp['region_name']);
                    $('#letter_sub').html(resp['letter_sub']);
                    $('#letter_continue').show();
                    tinyMCE.get('letter_content').setContent(resp['letter_content']);
                }else{
                    $('#letter_modal_div').hide();
                    $('#letter_modal_common_error').html('<div class="alert alert-danger">'+resp['error_txt']+'</div>');
                }
                
                $("#plz_wait_letter_modal").hide();
            }

        });

    });

    // save & continue letter modal
    $('#letter_continue').on('click',function(){

        if(checkLetterModalValidation() == true){
            
            $('#letter_last_saved').hide();
            $('#letter_save_draft').hide();
            
            $("#plz_wait_letter_modal").show();

            var setLetterContentUrl = $('#set_letter_content_url').val();
            var letter_no = $('#letter_no').val();
            var letter_dt = $('#letter_dt').val();
            var letter_to = $('#letter_to').val();
            var letter_sub = $('#letter_sub').val();
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
                        $('#esign_btn_div').show();
                        $('#withdraw_alert').hide();
                        $('#withdraw_reason_div').hide();
                        // $('#cancel_letter_modal').hide();
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

    // letter save draft - Aniket G [25-01-2023]
    $('#letter_save_draft').on('click',function(){
            
        $("#plz_wait_letter_modal").show();

        var saveLetterContentDraft = $('#save_letter_content_draft_url').val();
        var letter_content = tinyMCE.get('letter_content').getContent();

        $.ajax({
            type:'POST',
            async: true,
            cache: false,
            url: saveLetterContentDraft,
            data: {'action':'save_letter_content','letter_content':letter_content},
            beforeSend: function (xhr) { // for csrf token
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                $('.form_spinner').hide('slow');
            },
            success: function(resp){
                resp = JSON.parse(resp);
                
                $("#plz_wait_letter_modal").hide();
                
                if(resp['status'] == true){
                    $('#draft_msg').hide().html('<i class="fa fa-check-circle"></i> Letter Content saved as draft!').fadeIn('slow').delay(5000).hide(1);
                }else{
                    showAlrt("Problem in saving letter content! Try again later.");
                }
                
            }

        });

    });

    // retrieve last saved draft - Aniket G [27-01-2023]
    $('#letter_last_saved').on('click',function(){

        $("#plz_wait_letter_modal").show();

        var getLetterContentDraftUrl = $('#get_letter_content_draft_url').val();
        $.ajax({
            type:'POST',
            async: true,
            cache: false,
            url: getLetterContentDraftUrl,
            data: {'action':'get_letter_content_draft'},
            beforeSend: function (xhr) { // for csrf token
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                $('.form_spinner').hide('slow');
            },
            success: function(resp){
                resp = JSON.parse(resp);

                $("#plz_wait_letter_modal").hide();

                if(resp['status'] == true){
                    tinyMCE.get('letter_content').setContent(resp['letter_content']);
                    $('#draft_msg').hide().html('<i class="fa fa-check-circle"></i> Letter Content retrieved from last saved!').fadeIn('slow').delay(5000).hide(1);
                }else{
                    showAlrt("Problem in retrieving last saved letter content! Try again later.");
                }
                
            }

        });

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


