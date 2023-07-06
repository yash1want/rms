
// To Hide Update Button for 9.3.5 Noise

$(window).on("load", function () {
	var curr_id = $('#hideUpdate').val();
	if (curr_id != undefined) {
		var is_update = $('#btnSubmit').val();

		if (is_update.toLowerCase() === 'update') {
			$("#btnSubmit").hide();
		}

	}
});

$(document).ready(function () {
	$('#save_comment').on('click', function () {
		// e.preventDefault();
		$('textarea[name="reason"]').removeClass('is-invalid');
		$('textarea[name="reason"]').parent().parent().find('.err_cv').text('');
		var reason = $('textarea[name="reason"]').val();
		if (reason == '') {
			$('textarea[name="reason"]').addClass('is-invalid');
			$('textarea[name="reason"]').parent().parent().find('.err_cv').text('Field required!');
			return false;
		} else {
			// $('.form_spinner').show('slow');
			return true;
		}
	});
	$('#btnSubmit').on('click', function () {
		// e.preventDefault();
		var last_cmt_id = $('#last_cmt_id').val();
		if (last_cmt_id != '') {
			$('textarea[name="reason"]').removeClass('is-invalid');
			$('textarea[name="reason"]').parent().parent().find('.err_cv').text('');
			var reason = $('textarea[name="reason"]').val();
			if (reason == '') {
				$('textarea[name="reason"]').addClass('is-invalid');
				$('textarea[name="reason"]').parent().parent().find('.err_cv').text('Field required!');
				return false;
			} else {
				// $('.form_spinner').show('slow');
				return true;
			}
		}
	});


	//average_grade-1

	$('.cmnt-edit').on('click', function () {
		
		var userRole = $("#user_role").val();
		var btnId = $(this).attr('id');		
		var curId = btnId.split('-');		
		curId = curId[1];
		console.log(userRole);
		$('#cmnt_btn-' + curId).hide();
		$('#cmnt_del-' + curId).hide();
		$('#cmnt_del_conf-' + curId).hide();
		$('#cmnt_save-' + curId).show();
		$('#cmnt_cancel-' + curId).show();
		// updated by pravin bhakare 17-06-2022
		var editcolumnid = '';
		if(userRole == 6){
			
			var rotoapplicant = $('#cmnt_rsn-' + curId + '-6A').text().trim();
			var rotoio = $('#cmnt_rsn-' + curId + '-6I').text();
			
			if(rotoapplicant !=''){
				editcolumnid = '6A';
			}else if(rotoio !=''){
				editcolumnid = '6I';
			}			
		}else{
			editcolumnid = userRole;
		}

		var oldCmntRsn = $('#old_cmnt_rsn-' + curId + '-' + editcolumnid).val();
		var oldCmntRsnDt = $('#old_cmnt_rsn_dt-' + curId + '-' + editcolumnid).val();
		var rsnContainer = '<span class="badge badge-reason"><i class="pe-7s-date"></i> ' + oldCmntRsnDt + '</span><br><br><textarea name="cmnt_reason_' + curId + '" class="reason-box form-control" id="cmnt_reason_' + curId + '" rows="5">' + oldCmntRsn + '</textarea>';
		$('#cmnt_rsn-' + curId + '-' +editcolumnid).html(rsnContainer);
		$('#cmnt_reason_' + curId).focus();
		$('#rocommwith').val(editcolumnid);
	
	});

	
// Added click on  copy Button, copy IO comment append io comment in textarea  by Ankush T 17-05-2023
	
	
	
	$('.cmnt-del').on('click', function () {
		var userRole = $("#user_role").val();
		
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];
		
		// updated by pravin bhakare 17-06-2022
		var editcolumnid = '';
		if(userRole == 6){
			
			var rotoapplicant = $('#cmnt_rsn-' + curId + '-6A').text().trim();
			var rotoio = $('#cmnt_rsn-' + curId + '-6I').text();
			
			if(rotoapplicant !=''){
				editcolumnid = '6A';
			}else if(rotoio !=''){
				editcolumnid = '6I';
			}			
		}else{
			editcolumnid = userRole;
		}
		
		$('#rocommwith').val(editcolumnid);	
		$('#cmnt_del-' + curId).hide();
		$('#cmnt_del_conf-' + curId).show();

	});

	$('.cmnt-del-conf').on('click', function () {
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];

		var returnId = $('#reason_id-' + curId).val();
		var remove_comment_url = $('#remove_comment_url').val();
		var final_submit = $('#hidden_final_sub').val();

		// updated by pravin bhakare 17-06-2022
		var rocommwith = $('#rocommwith').val();
		// updated by pravin bhakare 17-06-2022	
		var dataPost = { submit: 'remove_comment', return_id: returnId,final_submit:final_submit, rocommwith:rocommwith };

		$.ajax({
			type: 'POST',
			url: remove_comment_url,
			data: dataPost,
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				$('#cmnt_btn-' + curId).hide();
				$('#cmnt_del_conf-' + curId).hide();
				$('#ajax_loader').show();
			},
			success: function (response) {
				location.reload();
			}
		});

	});

	$('.cmnt-cancel').on('click', function () {
		
		var userRole = $("#user_role").val();
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];

		$('#cmnt_save-' + curId).hide();
		$('#cmnt_cancel-' + curId).hide();
		$('#cmnt_btn-' + curId).show();
		$('#cmnt_del-' + curId).show();
 
		
		// updated by pravin bhakare 17-06-2022
		var editcolumnid = '';
		if(userRole == 6){
			
			var rotoapplicant = $('#cmnt_rsn-' + curId + '-6A').text().trim();
			var rotoio = $('#cmnt_rsn-' + curId + '-6I').text();
			
			if(rotoapplicant !=''){
				editcolumnid = '6A';
			}else if(rotoio !=''){
				editcolumnid = '6I';
			}			
		}else{
			editcolumnid = userRole;
		}

		var oldCmntRsn = $('#old_cmnt_rsn-' + curId + '-' +editcolumnid).val();
		var oldCmntRsnDt = $('#old_cmnt_rsn_dt-' + curId + '-' +editcolumnid).val();
		$('#cmnt_rsn-' + curId + '-' +editcolumnid).html('<span class="badge badge-reason"><i class="pe-7s-date"></i> ' + oldCmntRsnDt + '</span><br>' + oldCmntRsn);
	});

	$('.cmnt-save').on('click', function () {
		
		var userRole = $("#user_role").val();
		var btnId = $(this).attr('id');
		var curId = btnId.split('-');
		curId = curId[1];

		var returnId = $('#reason_id-' + curId).val();
		var reason = $('#cmnt_reason_' + curId).val();
  
		// updated by pravin bhakare 17-06-2022
		var rocommwith = $('#rocommwith').val();
		
		var update_comment_url = $('#update_comment_url').val();
		// updated by pravin bhakare 17-06-2022
		var dataPost = { reason: reason, submit: 'save_comment', return_id: returnId, rocommwith: rocommwith };


		if(reason != ''){
			$.ajax({
				type: 'POST',
				url: update_comment_url,
				data: dataPost,
				beforeSend: function (xhr) {
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					$('#cmnt_save-' + curId).hide();
					$('#cmnt_cancel-' + curId).hide();
					$('#ajax_loader').show();
				},
				success: function (response) {
					$('#ajax_loader').hide();
					$('#cmnt_msg-' + curId).html('<i class="fa fa-check"></i> Updated!').fadeIn();
					$('#cmnt_msg-' + curId).delay(2000).fadeOut();
					$('#cmnt_btn-' + curId).show();
					$('#cmnt_del-' + curId).show();

					var editcolumnid = '';
					if(userRole == 6){
						
						var rotoapplicant = $('#cmnt_rsn-' + curId + '-6A').text().trim();
						var rotoio = $('#cmnt_rsn-' + curId + '-6I').text();
						
						if(rotoapplicant !=''){
							editcolumnid = '6A';
						}else if(rotoio !=''){
							editcolumnid = '6I';
						}			
					}else{
						editcolumnid = userRole;
					}
			
					var currentDateTime = getCurrentDateTime();
					var oldCmntRsn = $('#old_cmnt_rsn-' + curId + '-' + editcolumnid).val(reason);
					var oldCmntRsnDt = $('#old_cmnt_rsn_dt-' + curId + '-' + editcolumnid).val(currentDateTime);
					$('#cmnt_rsn-' + curId + '-' + editcolumnid).html('<span class="badge badge-reason"><i class="pe-7s-date"></i> ' + currentDateTime + '</span><br>' + reason);
				}
			});
		} else {
			$('#cmnt_reason_' + curId).addClass('is-invalid').prop('placeholder', 'Field is required');
		}
	});

	/* referred back button */
	$('#referred_back').on('click', function () {
		referredBack();
	});

	/* aprove button */
	$('#approve').on('click', function () {
		approveReturn();
	});



	/*    var objDiv = document.getElementById("referred_cmt");
	objDiv.scrollTop = objDiv.scrollHeight;
	*/
});

function getCurrentDateTime() {
	var d = new Date();
	// var datestring = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
	var ampm = (d.getHours() >= 12) ? "PM" : "AM";
	var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + " " + ampm;
	return datestring;
}


function referredBack() {

	var returnId = $('#reason_id-' + curId).val();
	var referred_back_url = $('#referred_back_url').val();
	var dashboardUrl = $('#dashboard_url').val();
	var ajaxLoaderHtml = $('#ajax_loader_html').val();

	var dataPost = { reason: '', submit: 'referred_back', returnId: returnId };


	$.ajax({
		type: 'POST',
		url: referred_back_url,
		data: dataPost,
		beforeSend: function (xhr) {
			xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			var loaderImg = ajaxLoaderHtml;
			$('.cmnt-main').addClass('cmnt-main-ajax');
			$('.cmnt-main').html(loaderImg);
		},
		success: function (response) {

			if (response == 2) {
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text('Successfully referred back to the user!');
				$('#modal_box').removeClass('login-modal-content');
				$('#modal_box .login-modal-header').addClass('bg-success');
				$('#modal_box .login-modal-header i').attr('class', 'fa fa-check-circle login-info-icon text-white');
				$('#modal-cont-btn').on('click', function () {
					location.href = dashboardUrl;
				});
			} else {
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text('Problem in referred back to the user!');
				$('#modal-cont-btn').on('click', function () {
					location.href = dashboardUrl;
				});
			}
		}
	});

}


function approveReturn() {

	var mineCode = $('#mine_code').val();
	var returnDate = $('#return_date').val();
	var returnType = $('#return_type').val();
	var mmsUserId = $('#mms_user_id').val();
	var section_id = $('#section_id').val();
	var return_id = $('#return_id').val();
	var viewUserType = $('#view_user_type').val();
	var approve_return_url = $('#approve_return_url').val();
	var dashboardUrl = $('#dashboard_url').val();
	var ajaxLoaderHtml = $('#ajax_loader_html').val();

	if (viewUserType == 'authuser') {
		var dataPost = { reason: '', submit: 'approve_return', mine_code: mineCode, return_date: returnDate, return_type: returnType, mms_user_id: mmsUserId, returnId: '', section_id: '', mineral: '', sub_min: '' };
	} else {
		var part_no = $('#part_no').val();
		var dataPost = { reason: '', submit: 'approve_return', mine_code: mineCode, return_date: returnDate, return_type: returnType, mms_user_id: mmsUserId, return_id: return_id, section_id: section_id, part_no: part_no };
	}
	$.ajax({
		type: 'POST',
		url: approve_return_url,
		data: dataPost,
		beforeSend: function (xhr) {
			xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			var loaderImg = ajaxLoaderHtml;
			$('.cmnt-main').addClass('cmnt-main-ajax');
			$('.cmnt-main').html(loaderImg);
		},
		success: function (response) {

			if (response == 1) {
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text('Successfully Approved return!');
				$('#modal_box').removeClass('login-modal-content');
				$('#modal_box .login-modal-header').addClass('bg-success');
				$('#modal_box .login-modal-header i').attr('class', 'fa fa-check-circle login-info-icon text-white');
				$('#modal-cont-btn').on('click', function () {
					location.href = dashboardUrl;
				});
			} else {
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text('Problem in Approving return! Try again later.');
				$('#modal-cont-btn').on('click', function () {
					location.href = dashboardUrl;
				});
			}
		}
	});
}

// Added click on  copy Button, copy IO comment append io comment in textarea  by Ankush T 17-05-2023
	
	$(document).ready(function() {
        $('.copy_cmnt_btn').click(function() {

        $('.copy_cmt').each(function() {
			var value = $(this).last().text();
		
         $('#average_grade-1').val(value);
		});
         
        });
    });




