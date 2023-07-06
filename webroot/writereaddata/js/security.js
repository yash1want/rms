
$(document).ready(function(){

	// $("input").attr("autocomplete","off");
	$('input').not("input[type='hidden']").not("[maxlength]").prop('maxlength', '150');
	// $('#username').not("input[type='hidden']").not("[maxlength]").prop('maxlength', '100');
	// $('#password').not("input[type='hidden']").not("[maxlength]").prop('maxlength', '150');
	$('#captcha').not("input[type='hidden']").not("[maxlength]").prop('maxlength', '6');
	$('textarea').not("[maxlength]").prop('maxlength', '500');

    $(document).bind("contextmenu", function(e) {
        e.preventDefault();
    });

});