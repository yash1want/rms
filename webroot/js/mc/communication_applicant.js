
$(document).ready(function(){

	$('.cmnt-edit').on('click',function(){
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];

		$('#cmnt_btn-'+curId).hide();
		$('#cmnt_del-'+curId).hide();
		$('#cmnt_del_conf-'+curId).hide();
		$('#cmnt_save-'+curId).show();
		$('#cmnt_cancel-'+curId).show();

		var oldCmntRsn = $('#old_cmnt_rsn-'+curId).val();
		var oldCmntRsnDt = $('#old_cmnt_rsn_dt-'+curId).val();
		var rsnContainer = '<span class="badge badge-reason"><i class="pe-7s-date"></i> '+oldCmntRsnDt+'</span><br><br><textarea name="cmnt_reason_'+curId+'" class="reason-box form-control" id="cmnt_reason_'+curId+'" rows="5">'+oldCmntRsn+'</textarea>';
		$('#cmnt_rsn-'+curId).html(rsnContainer);
		$('#cmnt_reason_'+curId).focus();
	});

	$('.cmnt-del').on('click',function(){
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];

		$('#cmnt_del-'+curId).hide();
		$('#cmnt_del_conf-'+curId).show();

	});

	$('.cmnt-del-conf').on('click',function(){
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];

		var returnId = $('#reason_id-'+curId).val();
		var mineCode = $('#mine_code').val();
		var returnDate = $('#return_date').val();
		var returnType = $('#return_type').val();
		var mmsUserId = $('#mms_user_id').val();
		var part_no = $('#part_no').val();
		var sectionId = $('#section_id').val();
		var mineral = $('#mineral').val();
		var sub_min = $('#sub_min').val();
		var viewUserType = $('#view_user_type').val();
		var remove_comment_url = $('#remove_comment_url').val();

		if(viewUserType == 'authuser'){
			var dataPost = {submit:'remove_comment', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:returnId, section_id:sectionId, mineral:mineral, sub_min:sub_min, part_no:part_no};
		} else {
			var dataPost = {submit:'remove_comment',  mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:returnId, section_id:sectionId, part_no:part_no};
		}
		$.ajax({
			type: 'POST',
			url: remove_comment_url,
			data: dataPost,
			beforeSend: function (xhr){
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				$('#cmnt_btn-'+curId).hide();
				$('#cmnt_del_conf-'+curId).hide();
				$('#ajax_loader').show();
			},
			success: function(response){
				location.reload();
			}
		});

	});

	$('.cmnt-cancel').on('click',function(){
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];

		$('#cmnt_save-'+curId).hide();
		$('#cmnt_cancel-'+curId).hide();
		$('#cmnt_btn-'+curId).show();
		$('#cmnt_del-'+curId).show();

		var oldCmntRsn = $('#old_cmnt_rsn-'+curId).val();
		var oldCmntRsnDt = $('#old_cmnt_rsn_dt-'+curId).val();
		$('#cmnt_rsn-'+curId).html('<span class="badge badge-reason"><i class="pe-7s-date"></i> '+oldCmntRsnDt+'</span><br><br>'+oldCmntRsn);
	});

	$('.cmnt-save').on('click',function(){
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];

		// $('#cmnt_save-'+curId).hide();
		// $('#cmnt_cancel-'+curId).hide();
		// $('#cmnt_btn-'+curId).show();
		// $('#cmnt_del-'+curId).show();

		// var oldCmntRsn = $('#old_cmnt_rsn-'+curId).val();
		// $('#cmnt_rsn-'+curId).html(oldCmntRsn);

		var returnId = $('#reason_id-'+curId).val();
		var reason = $('#cmnt_reason_'+curId).val();
		var mineCode = $('#mine_code').val();
		var returnDate = $('#return_date').val();
		var returnType = $('#return_type').val();
		var mmsUserId = $('#mms_user_id').val();
		var sectionId = $('#section_id').val();
		var mineral = $('#mineral').val();
		var sub_min = $('#sub_min').val();
		var viewUserType = $('#view_user_type').val();
		var update_comment_url = $('#update_comment_url').val();
		var part_no = $('#part_no').val();

		if(viewUserType == 'authuser'){
			var dataPost = {reason:reason, submit:'save_comment', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, returnId:returnId, section_id:sectionId, mineral:mineral, sub_min:sub_min, part_no:part_no};
		} else {
			
			var dataPost = {reason:reason, submit:'save_comment', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:returnId, section_id:sectionId, part_no:part_no};
		}

		$.ajax({
			type: 'POST',
			url: update_comment_url,
			data: dataPost,
			beforeSend: function (xhr){
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				$('#cmnt_save-'+curId).hide();
				$('#cmnt_cancel-'+curId).hide();
				$('#ajax_loader').show();
			},
			success: function(response){
				$('#ajax_loader').hide();
				$('#cmnt_msg-'+curId).html('<i class="fa fa-check"></i> Updated!').fadeIn();
				$('#cmnt_msg-'+curId).delay(2000).fadeOut();
				$('#cmnt_btn-'+curId).show();
				$('#cmnt_del-'+curId).show();

				var currentDateTime = getCurrentDateTime();
				var oldCmntRsn = $('#old_cmnt_rsn-'+curId).val(reason);
				var oldCmntRsnDt = $('#old_cmnt_rsn_dt-'+curId).val(currentDateTime);
				$('#cmnt_rsn-'+curId).html('<span class="badge badge-reason"><i class="pe-7s-date"></i> '+currentDateTime+'</span><br><br>'+reason);
			}
		});
	});

    $('#final_submit_ref').on('click', function(){
        finalSubmitRef();
    });

});

function getCurrentDateTime(){
	var d = new Date();
	// var datestring = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
	var ampm = (d.getHours() >= 12) ? "PM" : "AM";
	var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + " " + ampm;
	return datestring;
}
