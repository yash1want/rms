$(document).ready(function() {
    
	$('#show_rej_reason_con').hide();
	
    $(document).on('click', '.reversal_comment_btn', function() {

        var appid = $(this).attr('appid');
        var mlpbcode = $(this).attr('mlpbcode');
        var mlpbtype = $(this).attr('mlpbtype');
        var mlpb = mlpbcode + ' (' + mlpbtype + ')';
        var lnm = $(this).attr('lnm');
        var lid = $(this).attr('lid');
        var mncode = $(this).attr('mncode');
        var state = $(this).attr('state');
        var fsdate = $(this).attr('fsdate');
        var commentmode = $(this).attr('mode');
        $('#rev_lease_id').val(lid);
        $('#rev_applicant_id').val(appid);
        $('#rev_box_appid').text(appid);
        $('#rev_box_mlpbcode').text(mlpb);
        $('#rev_box_lnm').text(lnm);
        $('#rev_box_mncode').text(mncode);
        $('#rev_box_state').text(state);
        $('#rev_box_fsdate').text(fsdate);

        $('#rev_box_alert').html('');
        $('#rev_reason_con').hide();
        $('#rev_reason').val('');
        $('#rev_comment_dt').html('');
        $('#rev_comment_dt').removeClass('badge-secondary');
		$('#rej_comment_dt').removeClass('badge-secondary');
        $('#rev_comment_history #rev_comment_tbl').html('');
        $('#rev_comment_history').hide();

        if(commentmode == 'edit'){
            $('#rev_apply_btn').show();
            $('#rev_reason').prop('disabled',false);
        }else{
            $('#rev_apply_btn').hide();
            $('#rev_reason').prop('disabled',true);
        }
        
        var getReversalHistoryUrl = $('#get_reversal_history_url').val();
        $.ajax({
            type: 'POST',
            url: getReversalHistoryUrl,
            data: {action:'get_rev_history', lease_id:lid, app_id:appid},
            beforeSend: function (xhr){
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp){
                resp = JSON.parse(resp);

                if(resp[0]['active'] == 1){
                    $('#rev_comment_history').show();

                    var comment = '';
                    $.each(resp, function(ky, vl){
                        var action_badge = (resp[ky]['status'] == 'approved') ? 'check-circle text-success' : 'times-circle text-danger'; 
                        comment += '<tr>';
                        comment += '<td>';
                        comment += '<div class="badge badge-secondary">'+resp[ky]['apply_reason_dt']+'</div>';
                        comment += '<div>'+resp[ky]['apply_reason']+'</div>';
                        comment += '</td>';
                        comment += '<td>';
                        comment += (resp[ky]['rej_reason'] != null) ? '<div class="badge badge-secondary">'+resp[ky]['rej_reason_dt']+'</div> <i class="fa fa-'+action_badge+'" title="'+resp[ky]['status']+'"></i>' : '';
                        comment += (resp[ky]['rej_reason'] != null) ? '<div>'+resp[ky]['rej_reason']+'</div>' : '';
                        comment += '</td>';
                        comment += '</tr>';
                    });
    
                    $('#rev_comment_history #rev_comment_tbl').append(comment);
                }

            }

        });

        if(commentmode == 'edit'){
            var getComForLeaseUrl = $('#get_com_for_lease_url').val();
            $.ajax({
                type: 'POST',
                url: getComForLeaseUrl,
                data: {action:'get_com', lease_id:lid},
                beforeSend: function (xhr){
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(resp){
                    resp = JSON.parse(resp);
                    if(resp['com_allocate'] == true){
                        $('#rev_reason_con').show();
                        $('#rev_apply_btn').show();
                        $('#rev_com_id').val(resp['com_id']);
                    }else{
                        $('#rev_box_alert').html('<div class="alert alert-danger"><i class="fa fa-info-circle"></i> <b>This Lease doesn\'t have COM!</b> Kindly allocate COM first.</div>');
                        $('#rev_reason_con').hide();
                        $('#rev_apply_btn').hide();
                    }
    
                }
    
            });
        }

    });

    
    $(document).on('click', '.reversal_action_btn', function() {

        var rid = $(this).attr('rid');
        var appid = $(this).attr('appid');
        var mlpbcode = $(this).attr('mlpbcode');
        var mlpbtype = $(this).attr('mlpbtype');
        var mlpb = mlpbcode + ' (' + mlpbtype + ')';
        var lnm = $(this).attr('lnm');
        var lid = $(this).attr('lid');
        var mncode = $(this).attr('mncode');
        var state = $(this).attr('state');
        var fsdate = $(this).attr('fsdate');
        var commentmode = $(this).attr('mode');
        $('#rev_record_id').val(rid);
        $('#rev_lease_id').val(lid);
        $('#rev_applicant_id').val(appid);
        $('#rev_box_appid').text(appid);
        $('#rev_box_mlpbcode').text(mlpb);
        $('#rev_box_lnm').text(lnm);
        $('#rev_box_mncode').text(mncode);
        $('#rev_box_state').text(state);
        $('#rev_box_fsdate').text(fsdate);

        $('#rev_box_alert').html('');
        $('#rev_reason_con').hide();
        $('#rev_reason').val('');
        $('#rev_comment_dt').html('');
        $('#rev_comment_dt').removeClass('badge-secondary');
        $('#rev_comment_history #rev_comment_tbl').html('');
        $('#rev_comment_history').hide();

        $('#rev_apply_btn').hide();
        $('#rev_approve_btn').hide();
        $('#rev_reject_btn').hide();
        $('#rev_reason').prop('disabled',false);

        var getReversalHistoryUrl = $('#get_reversal_history_url').val();
        $.ajax({
            type: 'POST',
            url: getReversalHistoryUrl,
            data: {action:'get_rev_history', lease_id:lid, app_id:appid},
            beforeSend: function (xhr){
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp){
                resp = JSON.parse(resp);

                if(resp[0]['active'] == 1){
                    $('#rev_comment_history').show();
                    
                    var comment = '';
                    $.each(resp, function(ky, vl){
                        var action_badge = (resp[ky]['status'] == 'approved') ? 'check-circle text-success' : 'times-circle text-danger'; 
                        comment += '<tr>';
                        comment += '<td>';
                        comment += '<div class="badge badge-secondary">'+resp[ky]['apply_reason_dt']+'</div>';
                        comment += '<div>'+resp[ky]['apply_reason']+'</div>';
                        comment += '</td>';
                        comment += '<td>';
                        comment += (resp[ky]['rej_reason'] != null) ? '<div class="badge badge-secondary">'+resp[ky]['rej_reason_dt']+'</div> <i class="fa fa-'+action_badge+'" title="'+resp[ky]['status']+'"></i>' : '';
                        comment += (resp[ky]['rej_reason'] != null) ? '<div>'+resp[ky]['rej_reason']+'</div>' : '';
                        comment += '</td>';
                        comment += '</tr>';
                    });
    
                    $('#rev_comment_history #rev_comment_tbl').append(comment);
                }

            }

        });
        
        if(commentmode == 'edit'){
            $('#rev_approve_btn').show();
            $('#rev_reject_btn').show();
        }

        var getReversalReasonForComUrl = $('#get_reversal_reason_for_com_url').val();
        $.ajax({
            type: 'POST',
            url: getReversalReasonForComUrl,
            data: {action:'get_reason', lease_id:lid, record_id:rid},
            beforeSend: function (xhr){
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp){
                resp = JSON.parse(resp);
                if(resp['status'] == true){
                    $('#rev_box_ro').html(resp['ro_name']);
                    $('#rev_box_cdt').html(resp['reason_dt']);
                }

            }

        });

    });

    $(document).on('click','#rev_reject_btn',function(event){
		$("#rej_reject_btn").prop("name",'rev_reject');
        $('#rej_reason').prop("placeholder","Enter reason for rejection here...");
        if(!confirm('Are you sure you want to reject this application!')){
            event.preventDefault();
        }

    });
    
    $(document).on('click','#rev_approve_btn',function(event){
		$("#rej_reject_btn").prop("name",'rev_approve');
        $('#rej_reason').prop("placeholder","Enter reason for approval here...");
        if(!confirm('Are you sure you want to approve this application!')){
            event.preventDefault();
        }

    });

});