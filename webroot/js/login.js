
function myFunction(){						
					
	var username = $("#username").val();
	var pass = $("#password").val();
	var captchacode = $("#captcha").val();
	var saltvalue = $("#salt_value").val();
	var return_value = 'true';
	
	if(username == ""){				
		$("#error_username").show().text("Please enter your username.");
		$("#error_username").css({"color":"red","font-size":"14px"});			
		$("#username").click(function(){$("#error_username").hide().text;});
		return_value = 'false';
	}
		
	if(pass == ""){
			
		$("#error_password").show().text("Please enter your password.");
		$("#error_password").css({"color":"red","font-size":"14px"});			
		$("#password").click(function(){$("#error_password").hide().text;});
		return_value = 'false';
	}
		
	if(captchacode == ""){				
		$("#error_captchacode").show().text("Please enter captcha code.");
		$("#error_captchacode").css({"color":"red","font-size":"14px"});			
		$("#captcha").click(function(){$("#error_captchacode").hide().text;});
		return_value = 'false';
	}
	
	if(return_value == 'true'){
		
		var EncryptPass = sha512(pass);
		var SaltedPass = EncryptPass.concat(saltvalue);		
		var Saltedmd5pass = sha512(SaltedPass);	
		$("#username").val($.base64.encode(username));		
		$("#password").val(Saltedmd5pass);
		$("#salt_value").val('');	

		$('#login_form').submit();
		
	}else{
		return false;
	}	
}


function get_new_captcha(){
	var captchaUrl = ($('#captchRefreshUrl').length) ? $('#captchRefreshUrl').val() : "../users/refresh_captcha_code";
	$.ajax({
			type: "POST",
			async:true,
			url:captchaUrl,
			// url:"../users/refresh_captcha_code",
			//url:"../users/create-captcha",					
			beforeSend: function (xhr) { // Add this line
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			}, 
			success: function (data) {
					$("#captcha_img").html(data);
					//$("#login_captcha_img").attr('src','../users/refresh-captcha');
			}
	});
}

function get_new_captcha_reset(){				
	$.ajax({
			type: "POST",
			async:true,
			// url:"refresh_captcha_code",					
			url:"../users/create-captcha",					
			beforeSend: function (xhr) { // Add this line
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			}, 
			success: function (data) {
					// $("#captcha_img").html(data);
					$("#login_captcha_img").attr('src','../../../users/refresh-captcha');
			}
	});
}

$(document).ready(function(){

	

	$('#multiple_browser_login_btn').on('click', function(){
		submitLoginForm();
	});

	$('#Login').click(function() {		 
		myFunction();
	});	

});


/**
 * CREATED SEPARATE FUNCTION FOR PASSWORD ENCRYPTION
 * TO PROCESS ENCRYPT PASSWORD TO THE SERVER SIDE
 * @addedon: 05th MAR 2021 (by Aniket Ganvir)
 */
function encryptPass() {
	
	var pa = SHA512($("#password").val()); 
    var us = $("#username").val().split('').reverse().join('');
  
	var tkn = $("#tkn").val();
	var tkn1 = $("#tkn1").val();
	var tkn2 = $("#tkn2").val();
	
	var u =tkn.replace(" ", us);
    u = $.base64.encode(u);
    
	/* Hashed password with SHA512 encryption
	 * Previously SHA256 was used to hashed
	 * Modified on 09-10-2020 by Aniket Ganvir
	 */
    var psalted = SHA512(pa + tkn1);
	tkn1 = " ";
	$("#tkn").val(tkn1);
	$("#tkn1").val(tkn1);
	$("#tkn2").val(tkn1);
    
    $("#password").val(psalted);
    $("#username").val(u);
	
}


function submitLoginForm() {
	encryptPass();
	$('#multilogin').val('update');
	$('#login_form').submit();
}

// clear login input fields
// @addedon: 05th MAR 2021 (by Aniket Ganvir)
function clearFields(){

	// $("#username").val('');
	$("#password").val('');
	$("#captcha").val('');

}

// show login input field error messages
// @addedon: 05th MAR 2021 (by Aniket Ganvir)
function showLoginError(errorEle,msg,inputELe){

	$(errorEle).show().text(msg);
	$(inputELe).click(function(){$(errorEle).hide().text;});
	clearFields(); // clear input fields

}

//-------------------------- FORGOT PASSWORD ---------------------------
/**
 * CLEAR INPUT FIELDS ON PAGE LOAD FOR FIXING SECURITY AUDIT ISSUE
 * By Aniket Ganvir dated 10th NOV 2020
 */
$('#forgotpass_username').val('');
$('#forgotpass_email').val('');
$('#forgotpass_captcha').val('');

jQuery().ready(function() { 
    // validate signup form on keyup and submit3
    // $("#frmforgotPassword").validate({ 
    //     rules: {
    //         "username": {
    //             required: true,
    //             maxlength: 50
    //         },
    //         "email": {
    //             required: true,
    //             // email: true
    //         },
    //         "captcha": {
    //             required: true
    //         }
    //     },
    //     errorElement: "div"
    // });
});

$(document).ready(function(){

	/* message modal box */
	$('.msg_box_modal').ready(function(){
		$('#login-modal-btn-msg-box').click();
		$('.login-modal-btn').on('click',function(){
			var alrtRedirectUrl = $('#alrt_redirect_url').val();
			location.href = alrtRedirectUrl;
		});
	});
	
	// prevent form submit through 'Enter' key
	$('form input').keydown(function (e) {
		if (e.keyCode ==  13) {
			e.preventDefault();
			return false;
		}
	});

	$('#new_captcha').on('click', function(){
		get_new_captcha();
	});
	
	// validate form input fields, added on 06th JAN 2021 by Aniket Ganvir
	$('#frmforgotPassword').on('submit', function() {

		var forgotPassEmail = $('#forgotpass_email').val();
		var forgotPassUsername = $('#forgotpass_username').val();
		var forgotPassCaptcha = $('#forgotpass_captcha').val();
		
		if(forgotPassUsername=='' || forgotPassEmail=='' || forgotPassCaptcha==''){
			$("#error_username").show().text("Please fill out all the fields!");		
			$("#forgotpass_username").click(function(){$("#error_username").hide().text;});
			// clearForgotFields();	
			return false;
		}else if(/^[a-zA-Z0-9-&_.@\/ ]*$/.test(forgotPassUsername) == false) {
			$("#error_username").show().text("Invalid username entered");		
			$("#forgotpass_username").click(function(){$("#error_username").hide().text;});
			clearForgotFields();	
			return false;
		}else if(!isValidEmailAddress(forgotPassEmail)) {
			$("#error_email").show().text("Invalid email address");		
			$("#forgotpass_email").click(function(){$("#error_email").hide().text;});
			clearForgotFields();
			return false;
		} else if(/^[a-zA-Z0-9 ]*$/.test(forgotPassCaptcha) == false || forgotPassCaptcha == "" || forgotPassCaptcha.length != '6') {
			$("#error_captchacode").show().text("Invalid captcha");		
			$("#forgotpass_captcha").click(function(){$("#error_captchacode").hide().text;});
			clearForgotFields();
			return false;
		} else {
			var encodedForgotPassEmail = $.base64.encode(forgotPassEmail);
			$('#forgotpass_email').val(encodedForgotPassEmail);
			return true;
		}
		
	});


});

// clear input fields
function clearForgotFields() {
	$('#forgotpass_username').val('');
	$('#forgotpass_email').val('');
	$('#forgotpass_captcha').val('');
}

function isValidEmailAddress(emailAddress) {
	var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
	return pattern.test(emailAddress);
}

$(document).ready(function() {

	$('.external_site_url').on('click',function() {
		confirm('You are being redirected to a external site.');
	});

});