$(document).ready(function() {
    
    $(document).on("click", ".state_comment_btn", function() {

        var appid = $(this).attr('appid');
        var lid = $(this).attr('lid');
        var appv = $(this).attr('appv');
        var commentmode = $(this).attr('mode');
        getStateComment(appid, lid, appv, commentmode);

    });
    
    $('#sortlisttable .state_comment_btn').on('click', function() {

        var appid = $(this).attr('appid');
        var lid = $(this).attr('lid');
        var appv = $(this).attr('appv');
        var commentmode = $(this).attr('mode');
        getStateComment(appid, lid, appv, commentmode);

    });
    
    $(document).on("click", ".odo_comment_btn", function() {

        var appid = $(this).attr('appid');
        var lid = $(this).attr('lid');
        var appv = $(this).attr('appv');
        var commentmode = $(this).attr('mode');
        getOdoComment(appid, lid, appv, commentmode);

    });
    
    $('#sortlisttable .odo_comment_btn').on('click', function() {

        var appid = $(this).attr('appid');
        var lid = $(this).attr('lid');
        var appv = $(this).attr('appv');
        var commentmode = $(this).attr('mode');
        getOdoComment(appid, lid, appv, commentmode);

    });

    // COM comment modal, added on 13-09-2022 by Aniket
    $(document).on("click", ".com_comment_btn", function() {

        var appid = $(this).attr('appid');
        var lid = $(this).attr('lid');
        var appv = $(this).attr('appv');
        var commentmode = $(this).attr('mode');
        getComComment(appid, lid, appv, commentmode);

    });
    
    // COM comment modal, added on 13-09-2022 by Aniket
    $('#sortlisttable .com_comment_btn').on('click', function() {

        var appid = $(this).attr('appid');
        var lid = $(this).attr('lid');
        var appv = $(this).attr('appv');
        var commentmode = $(this).attr('mode');
        getComComment(appid, lid, appv, commentmode);

    });

});

function getStateComment(appid, lid, appv, commentmode){
    
    $('#applicant_id').val(appid);
    $('#lease_id').val(lid);
    $('#commenting_user').val('stateuser');
    var getStateCommentUrl = $('#get_state_comment_url').val();

    if(commentmode == 'Edit'){
        $('#state_comment').removeAttr('disabled');
        $('#save_state_comment_btn').show();
    }else{
        $('#state_comment').attr('disabled',true);
        $('#save_state_comment_btn').hide();
    }

    $.ajax({
        type: 'POST',
        url: getStateCommentUrl,
        data: {action:'get_comment', lease_id:lid, applicant_id:appid, app_version:appv},
        beforeSend: function (xhr){
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function(resp){
            resp = JSON.parse(resp);
            if(resp['active']['data'] == true){
                $('#active_comment_div').show();
                $('#state_comment').val(resp['active']['comment']);
                $('#state_comment_dt').html(resp['active']['comment_date']);
                $('#state_comment_dt').addClass('badge-secondary');
            }else{
                $('#state_comment').val('');
                $('#state_comment_dt').html('');
                $('#state_comment_dt').removeClass('badge-secondary');

                if(commentmode != 'Edit'){
                    $('#active_comment_div').hide();
                }
            }

            var historyCon = '';
            if(resp['all'][0]['data'] == true){
                historyCon += '<label for="exampleText" class="font-weight-bold d-block mt-1">Comment history</label>';
                historyCon += '<table class="table font-weight-normal font_12 comment_history_modal">';
                historyCon += '<tbody class="d-table w-100">';
                $.each(resp['all'], function(key,val){
                    historyCon += '<tr>';
                    historyCon += '<td class="border-dark">';
                    historyCon += '<span>'+val['comment']+'</span>';
                    historyCon += '<span class="d-inline-block badge badge-info float-right">'+val['comment_date']+'</span>';
                    historyCon += '</tr>';

                });
                historyCon += '</tbody>';
                historyCon += '</table>';
            }

            $('#comment_history_div').html(historyCon);

        }

    });
}

function getOdoComment(appid, lid, appv, commentmode){
    
    $('#applicant_id').val(appid);
    $('#lease_id').val(lid);
    $('#commenting_user').val('odouser');
    var getOdoCommentUrl = $('#get_odo_comment_url').val();

    if(commentmode == 'Edit'){
        $('#state_comment').removeAttr('disabled');
        $('#save_state_comment_btn').show();
    }else{
        $('#state_comment').attr('disabled',true);
        $('#save_state_comment_btn').hide();
    }

    $.ajax({
        type: 'POST',
        url: getOdoCommentUrl,
        data: {action:'get_comment', lease_id:lid, applicant_id:appid, app_version:appv},
        beforeSend: function (xhr){
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function(resp){
            resp = JSON.parse(resp);
            if(resp['active']['data'] == true){
                $('#active_comment_div').show();
                $('#state_comment').val(resp['active']['comment']);
                $('#state_comment_dt').html(resp['active']['comment_date']);
                $('#state_comment_dt').addClass('badge-secondary');
            }else{
                $('#state_comment').val('');
                $('#state_comment_dt').html('');
                $('#state_comment_dt').removeClass('badge-secondary');
                
                if(commentmode != 'Edit'){
                    $('#active_comment_div').hide();
                }
            }
            
            var historyCon = '';
            if(resp['all'][0]['data'] == true){
                historyCon += '<label for="exampleText" class="font-weight-bold d-block mt-1">Comment history</label>';
                historyCon += '<table class="table font-weight-normal font_12 comment_history_modal">';
                historyCon += '<tbody class="d-table w-100">';
                $.each(resp['all'], function(key,val){
                    historyCon += '<tr>';
                    historyCon += '<td class="border-dark">';
                    historyCon += '<span>'+val['comment']+'</span>';
                    historyCon += '<span class="d-inline-block badge badge-info float-right">'+val['comment_date']+'</span>';
                    historyCon += '</tr>';

                });
                historyCon += '</tbody>';
                historyCon += '</table>';
            }

            $('#comment_history_div').html(historyCon);

        }

    });
}

function getComComment(appid, lid, appv, commentmode){
    
    $('#applicant_id').val(appid);
    $('#lease_id').val(lid);
    $('#commenting_user').val('comuser');
    var getComCommentUrl = $('#get_com_comment_url').val();

    if(commentmode == 'Edit'){
        $('#state_comment').removeAttr('disabled');
        $('#save_state_comment_btn').show();
    }else{
        $('#state_comment').attr('disabled',true);
        $('#save_state_comment_btn').hide();
    }

    $.ajax({
        type: 'POST',
        url: getComCommentUrl,
        data: {action:'get_comment', lease_id:lid, applicant_id:appid, app_version:appv},
        beforeSend: function (xhr){
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function(resp){
            resp = JSON.parse(resp);
            if(resp['active']['data'] == true){
                $('#active_comment_div').show();
                $('#state_comment').val(resp['active']['comment']);
                $('#state_comment_dt').html(resp['active']['comment_date']);
                $('#state_comment_dt').addClass('badge-secondary');
            }else{
                $('#state_comment').val('');
                $('#state_comment_dt').html('');
                $('#state_comment_dt').removeClass('badge-secondary');
                
                if(commentmode != 'Edit'){
                    $('#active_comment_div').hide();
                }
            }
            
            var historyCon = '';
            if(resp['all'][0]['data'] == true){
                historyCon += '<label for="exampleText" class="font-weight-bold d-block mt-1">Comment history</label>';
                historyCon += '<table class="table font-weight-normal font_12 comment_history_modal">';
                historyCon += '<tbody class="d-table w-100">';
                $.each(resp['all'], function(key,val){
                    historyCon += '<tr>';
                    historyCon += '<td class="border-dark">';
                    historyCon += '<span>'+val['comment']+'</span>';
                    historyCon += '<span class="d-inline-block badge badge-info float-right">'+val['comment_date']+'</span>';
                    historyCon += '</tr>';

                });
                historyCon += '</tbody>';
                historyCon += '</table>';
            }

            $('#comment_history_div').html(historyCon);

        }

    });
}