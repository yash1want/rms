$(document).ready(function(){

/* message modal box */

	$('.msg_box_modal').ready(function(){
		
		$('#form-modal-btn-msg-box').click();
		$('.form-modal-btn').on('click',function(){
			var alrtRedirectUrl = $('#alrt_redirect_url').val();
			location.href = alrtRedirectUrl;
		});
	});
});