
$(document).ready(function()
{

	$('#modal_ok').on('click', function(){

		var BtnType = $('#btn_type').val();

		if(BtnType=='refer_back'){ referredBack(); }
		else if(BtnType=='dis_approve'){ disApprove(); }
		else if(BtnType=='approve'){  /*$('#approve').removeClass('confirm_btn');*/ /*$('#approve').click();*/ approveReturn(); }
        $('#confirmModal').hide();
        return true;
	});
	$('#modal_cancel').on('click', function(){
		$('#confirm-modal-btn').click();
	});
	
	$('#save_comment').on('click', function() {
		// e.preventDefault();
		$('textarea[name="reason"]').removeClass('is-invalid');
		$('textarea[name="reason"]').parent().parent().find('.err_cv').text('');
		var reason = $('textarea[name="reason"]').val();
		if (reason == '') {
			$('textarea[name="reason"]').addClass('is-invalid');
			$('textarea[name="reason"]').parent().parent().find('.err_cv').text('Field required!');
			return false;
		} else {
			$('.form_spinner').show('slow');
			return true;
		}
	});

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
		var sectionId = $('#section_id').val();
		var part_no = $('#part_no').val();
		var mineral = $('#mineral').val();
		var sub_min = $('#sub_min').val();
		var viewUserType = $('#view_user_type').val();
		var remove_comment_url = $('#remove_comment_url').val();

		if(viewUserType == 'authuser'){
			var dataPost = {submit:'remove_comment', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:returnId, section_id:sectionId, mineral:mineral, sub_min:sub_min, part_no:part_no};
		} else {
			var dataPost = {submit:'remove_comment', return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:returnId, section_id:sectionId, part_no:part_no};
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
				if (response.trim() == 1) {
					location.reload();
				} else if (response.trim() == 2) {
					$('#ajax_loader').hide();
					$('.referred-back-history').append('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> You cannot delete the comment in this section because it\'s dependent on the section <b>4. Recovery at the Smelter-Mill-Plant</b> which is currently referred back.</div>');
				} else {
					$('#ajax_loader').hide();
					$('.referred-back-history').append('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Problem in deletion of comment. Try again later.</div>');
				}
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
		var part_no = $('#part_no').val();
		var mineral = $('#mineral').val();
		var sub_min = $('#sub_min').val();
		var viewUserType = $('#view_user_type').val();
		var update_comment_url = $('#update_comment_url').val();

		if(viewUserType == 'authuser'){
			var dataPost = {reason:reason, submit:'save_comment', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, returnId:returnId, section_id:sectionId, mineral:mineral, sub_min:sub_min, part_no:part_no};
		} else {
			var dataPost = {reason:reason, submit:'save_comment', return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:returnId, section_id:sectionId, part_no:part_no};
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

    /* referred back button */
    $('#referred_back').on('click', function(){
        $('#confirm-modal-btn').click();
		$('#modal-confirm-txt').text('Are you sure you want to proceed?');
		$('#btn_type').val('refer_back');
    }); 
    /* Dis-approve button */
    $('#disapprove').on('click', function(){
        $('#confirm-modal-btn').click();
		$('#modal-confirm-txt').text('Are you sure you want to proceed?');
		$('#btn_type').val('dis_approve');
    });
    /* Final Approve button */
    $('#approve').on('click', function(){
    	if($(this).hasClass('confirm_btn'))
		{

			var isLastUnapprovedUrl = $('#is_last_unapproved_url').val();
			var mineCode = $('#mine_code').val();
			var returnDate = $('#return_date').val();
			var returnType = $('#return_type').val();
			var mineral = $('#mineral').val();
			var partNo = $('#part_no').val();
			var secId = $('#section_id').val();
			var subMin = $('#sub_min').val();
			var mainSec = $('#main_sec_parse').val();
			var mmsCntrlNm = $('#mms_cntrl_nm').val();
			var isLastUnapprovedFlag = 0;

			$.ajax({
				type: 'POST',
				url: isLastUnapprovedUrl,
				async: false,
				data: {mine_code: mineCode, return_date: returnDate, return_type: returnType, mineral: mineral, part_no: partNo, section: secId, sub_mineral: subMin, main_sec: mainSec, mms_cntrl_nm: mmsCntrlNm},
				beforeSend: function (xhr){
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				},
				success: function(response){
					if (response.trim() == 1) {
						$('#confirm-modal-btn').click();
						$('#modal-confirm-txt').html('This action can&#39;t be undone! On Approving, no further modification will be made on section and application will get Final Approval ');
						$('#btn_type').val('approve');
						isLastUnapprovedFlag = 1;
					} else {
						$('.form_spinner').show();
						isLastUnapprovedFlag = 0;
					}
				}
			});

			if (isLastUnapprovedFlag == 1) {
				return false;
			} else {
				return true;
			}

	    	// var LastPart = $('#LastPart').val();
			// var LastSection = $('#LastSection').val();
			// var section_id = $('#section_id').val();
			// var part_no = $('#part_no').val();
			// var mineral = $('#mineral').val();
			// if((part_no == LastPart || mineral == LastPart) && (section_id == LastSection))
			// {
		    //     $('#confirm-modal-btn').click();
			// 	$('#modal-confirm-txt').html('This action can&#39;t be undone! On Approving, no further modification will be made on section and application will get Final Approval ');
			// 	$('#btn_type').val('approve');
			// 	return false;
			// }

    	}else
    	{
    		return true;
    	}

    });

    /* aprove button */
    // $('#approve').on('click', function(){
    //     approveReturn();
    // });

});

function getCurrentDateTime(){
	var d = new Date();
	// var datestring = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
	var ampm = (d.getHours() >= 12) ? "PM" : "AM";
	var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + " " + ampm;
	return datestring;
}


function referredBack(){

	var mineCode = $('#mine_code').val();
	var returnDate = $('#return_date').val();
	var returnType = $('#return_type').val();
	var mmsUserId = $('#mms_user_id').val();
	var viewUserType = $('#view_user_type').val();
	var return_id = $('#return_id').val();
	var section_id = $('#section_id').val();
	var refer_back_comment_url = $('#refer_back_comment_url').val();
	var dashboardUrl = $('#dashboard_url').val();
	var ajaxLoaderHtml = $('#ajax_loader_html').val();
	var userRole = $('#mms_user_role').val();
	if(userRole == '3' || userRole == '9')
	{
		var RefUser = 'Supervisor';
	}else
	{
		var RefUser = 'Applicant';
	}
	var succ_msg = "Successfully referred back to the "+RefUser+"!";
	var err_msg = "Problem in referred back to the "+RefUser+"!";

	if(viewUserType == 'authuser'){
		var dataPost = {reason:'', submit:'referred_back', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, returnId:'', section_id:'', mineral:'', sub_min:''};
	} else {
		var part_no = $('#part_no').val();
		var dataPost = {reason:'', submit:'referred_back', return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:return_id, section_id:section_id, part_no:part_no};
	}


	
	$.ajax({
		type: 'POST',
		url: refer_back_comment_url,
		data: dataPost,
		beforeSend: function (xhr){
			xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			var loaderImg = ajaxLoaderHtml;
			$('.cmnt-main').addClass('cmnt-main-ajax');
			$('.cmnt-main').html(loaderImg);
		},
		success: function(response)
		{
			if(response == 2){
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text(succ_msg);
				$('#modal_box').removeClass('login-modal-content');
				$('#modal_box .login-modal-header').addClass('bg-success');
				$('#modal_box .login-modal-header i').attr('class', 'fa fa-check-circle login-info-icon text-white');
				$('#modal-cont-btn').on('click',function(){
					location.href = dashboardUrl;
				});
			} else {
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text(err_msg);
				$('#modal-cont-btn').on('click',function(){
					location.href = dashboardUrl;
				});
			}

			
		}
	});

}

function disApprove()
{
	
	var mineCode = $('#mine_code').val();
	var returnDate = $('#return_date').val();
	var returnType = $('#return_type').val();
	var mmsUserId = $('#mms_user_id').val();
	var viewUserType = $('#view_user_type').val();
	var return_id = $('#return_id').val();
	var section_id = $('#section_id').val();
	var disapprove_return_url = $('#disapprove_return_url').val();
	var dashboardUrl = $('#dashboard_url').val();
	var ajaxLoaderHtml = $('#ajax_loader_html').val();
	var userRole = $('#mms_user_role').val();
	var mainSecParse = $('#main_sec_parse').val();
	var mineral = $('#mineral').val();
	var sub_min = $('#sub_min').val();
	var part_no = $('#part_no').val();
	
	var succ_msg = "Successfully disapprove the section !";
	var err_msg = "Problem in disapprove the section !";

	if(viewUserType == 'authuser'){
		var dataPost = {reason:'', submit:'disapprove', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, returnId:return_id, section_id:section_id, part_no:part_no, mineral:mineral, sub_min:sub_min, main_sec_parse:mainSecParse};
	} else {
		
		var dataPost = {reason:'', submit:'disapprove', return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:return_id, section_id:section_id, part_no:part_no, main_sec_parse:mainSecParse};
	}


	
	$.ajax({
		type: 'POST',
		url: disapprove_return_url,
		data: dataPost,
		beforeSend: function (xhr){
			xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			var loaderImg = ajaxLoaderHtml;
			$('.cmnt-main').addClass('cmnt-main-ajax');
			$('.cmnt-main').html(loaderImg);
		},
		success: function(response)
		{
			if(response == 3){
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text(succ_msg);
				$('#modal_box').removeClass('login-modal-content');
				$('#modal_box .login-modal-header').addClass('bg-success');
				$('#modal_box .login-modal-header i').attr('class', 'fa fa-check-circle login-info-icon text-white');
				$('#modal-cont-btn').on('click',function(){
					location.reload();
				});
			} else {
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text(err_msg);
				$('#modal-cont-btn').on('click',function(){
					location.reload();
				});
			}

			
		}
	});

}

// Approve return
function approveReturn() {

	$('#confirm-modal-btn').click();
	$("#declarationModal").modal('show');

}

// function approveReturn(){

// 	var mineCode = $('#mine_code').val();
// 	var returnDate = $('#return_date').val();
// 	var returnType = $('#return_type').val();
// 	var mmsUserId = $('#mms_user_id').val();
// 	var sectionId = $('#section_id').val();
// 	var returnId = $('#return_id').val();
// 	var viewUserType = $('#view_user_type').val();
// 	var approve_return_url = $('#approve_return_url').val();
// 	var dashboardUrl = $('#dashboard_url').val();
// 	var mainSecParse = $('#main_sec_parse').val();

// 	if(viewUserType == 'authuser'){
// 		var mineral = $('#mineral').val();
// 		var subMin = $('#sub_min').val();
// 		var dataPost = {reason:'', submit:'approve_return', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:returnId, section_id:sectionId, mineral:mineral, sub_min:subMin, main_sec:mainSecParse};
// 	} else {
// 		var partNo = $('#part_no').val();
// 		var dataPost = {reason:'', submit:'approve_return', mine_code:mineCode, return_date:returnDate, return_type:returnType, mms_user_id:mmsUserId, return_id:returnId, section_id:sectionId, part_no:partNo, main_sec:mainSecParse};
// 	}
// 	$.ajax({
// 		type: 'POST',
// 		url: approve_return_url,
// 		data: dataPost,
// 		beforeSend: function (xhr){
// 			xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
// 		},
// 		success: function(response){

// 			if(response == 1){ // SECTION APPROVED

// 				var msg = '<div class="alert alert-success mt-2"><i class="fa fa-check-circle"></i> Section succesfully approved!</div>';
// 				$('#save_comment').hide();
// 				$('#approve').hide();
// 				$('#referred_back').hide();
// 				$('#cmnt_sec_msg').html(msg);
// 				$('.cmnt_input').remove();
// 				$('#cmnt-table thead tr th').eq(3).remove();
// 				$('#cmnt-table tbody tr td').eq(3).remove();

// 			} else if(response == 2) { // RETURN APPROVED
				
// 				$('#referred-modal-btn').click();
// 				$('#Refmodal-alert-txt').text('Successfully Approved return!');
// 				$('#refer_modal_box').removeClass('login-modal-content');
// 				$('#refer_modal_box .login-modal-header').addClass('bg-success');
// 				$('#refer_modal_box .login-modal-header i').attr('class', 'fa fa-check-circle login-info-icon text-white');
// 				$('#modal-cont-btn').on('click',function(){
// 					location.href = dashboardUrl;
// 				});

// 			} else {
// 				$('#referred-modal-btn').click();
// 				$('#Refmodal-alert-txt').text('Problem in Approving return! Try again later.');
// 				$('#modal-cont-btn').on('click',function(){
// 					location.href = dashboardUrl;
// 				});
// 			}

// 		}
// 	});

// }