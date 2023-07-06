jQuery(document).ready(function () {

    $('#frmMineDetails').on('submit', function(){

        var mineCode = $('#mine_code').val();

        var newFaxNo = $("#f_fax_no").val().trim();
        var newFaxNoEl = $('#f_fax_no');
        if ((isNummm(newFaxNo) == 'no') || newFaxNo.length > 15 || newFaxNo.length < 6) {
            var replyMsg = "Fax number is not valid.";
            newFaxNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var newPhoneNo = $("#f_phone_no").val();
        var newPhoneNoEl = $('#f_phone_no');
        if ((isNummm(newPhoneNo) == 'no') || newPhoneNo.length > 15 || newPhoneNo.length < 6) {
            var replyMsg = "Phone number is not valid.";
            newPhoneNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var newMobileNo = $("#f_mobile_no").val();
        var newMobileNoEl = $('#f_mobile_no');
        if ((isNummm(newMobileNo) == 'no') || newMobileNo.length != 10) {
            var replyMsg = "Mobile number is not valid.";
            newMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
		var validfirstno = ['6','7','8','9'];
		var f_m_no = newMobileNo.charAt(0);
		if($.inArray(f_m_no,validfirstno) != -1){
			
		}else{
            var replyMsg = "Mobile number is not valid.";
            newMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
		}
        
        var newEMail = $("#f_email").val();
        var newEMailEl = $('#f_email');
        if (isEmail(newEMail) == false) {
            var replyMsg = "E-mail is not valid.";
            newEMailEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }

    });

    $('#f_mobile_no').on('focusout', function() {

        var umobile = $("#f_mobile_no").val();
        var newMobileNoEl = $('#f_mobile_no');
		var validfirstno = ['6','7','8','9'];
		
		var f_m_no = umobile.charAt(0);
		if($.inArray(f_m_no,validfirstno) != -1){
			
		}else{
            var replyMsg = "Mobile number is not valid.";
            newMobileNoEl.parent().next('.err_cv').text(replyMsg);
		}

    });
	
    jQuery('.fax_no_update').click(function () {
        
        var newFaxNo = $("#f_fax_no").val().trim();
        var newFaxNoEl = $('#f_fax_no');
        if ((isNummm(newFaxNo) == 'no') || newFaxNo.length > 15 || newFaxNo.length < 6) {
            var replyMsg = "Fax number is not valid.";
            newFaxNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }

        var value = jQuery.trim($("#f_fax_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.fax_ajaxloader').fadeIn();
        jQuery('.fax_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/F/' + value, function () {
            jQuery('.fax_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.phone_no_update').click(function () {
        
        var newPhoneNo = $("#f_phone_no").val();
        var newPhoneNoEl = $('#f_phone_no');
        if ((isNummm(newPhoneNo) == 'no') || newPhoneNo.length > 15 || newPhoneNo.length < 6) {
            var replyMsg = "Phone number is not valid.";
            newPhoneNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }

        var value = jQuery.trim($(" #f_phone_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.phone_ajaxloader').fadeIn();
        jQuery('.phone_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/P/' + value, function () {
            jQuery('.phone_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.mobile_no_update').click(function () {
        
        var newMobileNo = $("#f_mobile_no").val();
        var newMobileNoEl = $('#f_mobile_no');
        if ((isNummm(newMobileNo) == 'no') || newMobileNo.length != 10) {
            var replyMsg = "Mobile number is not valid.";
            newMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
		var validfirstno = ['6','7','8','9'];
		var f_m_no = newMobileNo.charAt(0);
		if($.inArray(f_m_no,validfirstno) != -1){
			
		}else{
            var replyMsg = "Mobile number is not valid.";
            newMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
		}

        var value = jQuery.trim($("#f_mobile_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.mobile_ajaxloader').fadeIn();
        jQuery('.mobile_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/M/' + value, function () {
            jQuery('.mobile_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.email_update').click(function () {
        
        var newEMail = $("#f_email").val();
        var newEMailEl = $('#f_email');
        if (isEmail(newEMail) == false) {
            var replyMsg = "E-mail is not valid.";
            newEMailEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var value = jQuery.trim($("#f_email").val());
        var mineCode = $('#mine_code').val();
        jQuery('.email_ajaxloader').fadeIn();
        jQuery('.email_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/E/' + value, function () {
            jQuery('.email_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.a_fax_no_update').click(function () {
        var value = jQuery.trim($("#f_a_fax_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.a_fax_ajaxloader').fadeIn();
        jQuery('.a_fax_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/FA/' + value, function () {
            jQuery('.a_fax_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.a_phone_no_update').click(function () {
        var value = jQuery.trim($("#f_a_phone_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.a_phone_ajaxloader').fadeIn();
        jQuery('.a_phone_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/PA/' + value, function () {
            jQuery('.a_phone_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.a_mobile_no_update').click(function () {
        var value = jQuery.trim($("#f_a_mobile_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.a_mobile_ajaxloader').fadeIn();
        jQuery('.a_mobile_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/MA/' + value, function () {
            jQuery('.a_mobile_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.a_email_update').click(function () {
        var value = jQuery.trim($("#f_a_email").val());
        var mineCode = $('#mine_code').val();
        jQuery('.a_email_ajaxloader').fadeIn();
        jQuery('.a_email_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/EA/' + value, function () {
            jQuery('.a_email_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });


});


function checkInt(num) {

    if(typeof num === 'number'){
        if(num % 1 === 0){
            return 'yes';
        } else{
            return 'no';
        }
    } else{
        return 'no';
    }

}

function isInt(n){

    return Number(n) === n && n % 1 === 0;

}


function isEmail(email) {

    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);

  }

  function isNumm(input){

    var result = 'yes';
    
    if($.isNumeric(input)){
      result = 'yes';
    } else if(input.charAt(0)=='.') 
    {
        result = 'no';
    }
    else {
        result = 'no';
    }

    return result;

  }

function isNummm(input) {

    if (input.includes(".")) {
        return 'no';
    } else {
        return 'yes';
    }

}