$(document).ready(function(){

	$('body').on('click','.fetch_detail_btn',function(e){
		
		$('#lease_activity_proceed').prop('href','#');
		$('#lease_activity_proceed').removeClass('withdraw_btn_link');
		$('#lease_activity_proceed').removeClass('reset_btn_link');
		$('#lease_activity_modal_error').addClass('d-none');
		$('#lease_activity_modal_error').text('');
		var checkLeaseSessionUrl = $('#multi_lease_session_check_url').val();
		var lid = $(this).attr('lid');
		var fid = $(this).attr('fid');
		var lcode = $(this).attr('lcode');
		var appid = $(this).attr('appid');
		$.ajax({
			type:"POST",
			url: checkLeaseSessionUrl,
			async: false,
			data:{action:'check',lid:lid},
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
			success: function (resp) {
				if(resp == 1){
					var sessionLeaseUsername = $('#session_lease_user_name').val();
					var otherUser = (sessionLeaseUsername == 'notfound') ? appid+'/'+lcode : appid;
					$('#lease_active_user').text(otherUser);
					$('#lease_activity_modal_btn').click();
					e.preventDefault();
					var proceedUrl = checkLeaseSessionUrl.replace('ajax/check-multi-lease-session','auth/fetch-details/'+fid);
					$('#lease_activity_proceed').prop('href',proceedUrl);
				}else{
					return true;
				}
			}
		});
		
	});

	$('body').on('click','.withdraw_request_btn',function(){
		
		$('#lease_activity_proceed').prop('href','#');
		$('#lease_activity_proceed').removeClass('withdraw_btn_link');
		$('#lease_activity_proceed').removeClass('reset_btn_link');
		$('#lease_activity_modal_error').addClass('d-none');
		$('#lease_activity_modal_error').text('');
		var checkLeaseSessionUrl = $('#multi_lease_session_check_url').val();
		var lid = $(this).attr('lid');
		var lcode = $(this).attr('lcode');
		var appid = $(this).attr('appid');
		$.ajax({
			type:"POST",
			url: checkLeaseSessionUrl,
			async: false,
			data:{action:'check',lid:lid},
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
			success: function (resp) {
				if(resp == 1){
					var sessionLeaseUsername = $('#session_lease_user_name').val();
					var otherUser = (sessionLeaseUsername == 'notfound') ? appid+'/'+lcode : appid;
					$('#lease_active_user').text(otherUser);
					$('#lease_activity_modal_btn').click();
					$('#lease_activity_proceed').addClass('withdraw_btn_link');
					$('#lease_activity_proceed').attr('lid',lid);
				}else{

                    var setMultiLeaseSessionUrl = $('#set_multi_lease_session_url').val();
                    $.ajax({
                        type:"POST",
                        url: setMultiLeaseSessionUrl,
                        async: false,
                        data:{action:'set',lid:lid},
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                        },
                        success: function (resp) {
                            if(resp == 1){
                                $('#withdraw_btn-'+lid).click();
                            }else{
                                alert('Something went wrong! Try again later.');
                            }
                        }
                    });

				}
			}
		});
		
	});

	$('body').on('click','.withdraw_btn_link',function(){

		$('#lease_activity_modal_error').addClass('d-none');
		$('#lease_activity_modal_error').text('');
		var setMultiLeaseSessionUrl = $('#set_multi_lease_session_url').val();
		var lid = $(this).attr('lid');
		$.ajax({
			type:"POST",
			url: setMultiLeaseSessionUrl,
			async: false,
			data:{action:'set',lid:lid},
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
			success: function (resp) {
				if(resp == 1){
					$('#lease_activity_modal_cancel').click();
					$('#withdraw_btn-'+lid).click();
				}else{
					$('#lease_activity_modal_error').removeClass('d-none');
					$('#lease_activity_modal_error').text('Something went wrong! Try again later.');
				}
			}
		});

	});

	
	$('body').on('click','.reset_request_btn',function(){
		
		$('#lease_activity_proceed').prop('href','#');
		$('#lease_activity_proceed').removeClass('withdraw_btn_link');
		$('#lease_activity_proceed').removeClass('reset_btn_link');
		$('#lease_activity_modal_error').addClass('d-none');
		$('#lease_activity_modal_error').text('');
		var checkLeaseSessionUrl = $('#multi_lease_session_check_url').val();
		var lid = $(this).attr('lid');
		var lcode = $(this).attr('lcode');
		var appid = $(this).attr('appid');
		$.ajax({
			type:"POST",
			url: checkLeaseSessionUrl,
			async: false,
			data:{action:'check',lid:lid},
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
			success: function (resp) {
				if(resp == 1){
					var sessionLeaseUsername = $('#session_lease_user_name').val();
					var otherUser = (sessionLeaseUsername == 'notfound') ? appid+'/'+lcode : appid;
					$('#lease_active_user').text(otherUser);
					$('#lease_activity_modal_btn').click();
					$('#lease_activity_proceed').addClass('reset_btn_link');
					$('#lease_activity_proceed').attr('lid',lid);
				}else{

                    var setMultiLeaseSessionUrl = $('#set_multi_lease_session_url').val();
                    $.ajax({
                        type:"POST",
                        url: setMultiLeaseSessionUrl,
                        async: false,
                        data:{action:'set',lid:lid},
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                        },
                        success: function (resp) {
                            if(resp == 1){
                                $('#reset_btn-'+lid).click();
                            }else{
                                alert('Something went wrong! Try again later.');
                            }
                        }
                    });

				}
			}
		});
		
	});
	
	$('body').on('click','.reset_btn_link',function(){

		$('#lease_activity_modal_error').addClass('d-none');
		$('#lease_activity_modal_error').text('');
		var setMultiLeaseSessionUrl = $('#set_multi_lease_session_url').val();
		var lid = $(this).attr('lid');
		$.ajax({
			type:"POST",
			url: setMultiLeaseSessionUrl,
			async: false,
			data:{action:'set',lid:lid},
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
			success: function (resp) {
				if(resp == 1){
					$('#lease_activity_modal_cancel').click();
					$('#reset_btn-'+lid).click();
				}else{
					$('#lease_activity_modal_error').removeClass('d-none');
					$('#lease_activity_modal_error').text('Something went wrong! Try again later.');
				}
			}
		});

	});

});