
/**
 * SECURITY RELATED JS
 */

 $(document).ready(function(){

	$("input").attr("autocomplete","off");
	$('input').not("input[type='hidden']").prop('maxlength', '128');
	$('#captcha').not("input[type='hidden']").prop('maxlength', '6');
	$('#forgotpass_captcha').not("input[type='hidden']").prop('maxlength', '6');
	$('textarea').not("[maxlength]").prop('maxlength', '500');

});