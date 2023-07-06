jQuery(document).ready(function () {
	
    $('#frmNameAddress').on('submit', function(e){

        var returnType = $('#return_type').val();
        if(returnType == 'ANNUAL'){
            var prevOwner = $('#f_previous_lessee_name').val();
            var dtTransfer = $('#f_date_of_entry').val();
            if(prevOwner!='' && dtTransfer == ''){
                e.preventDefault();
                showAlrt('<b>Date of Transfer</b> shouldn\'t be empty if <b>10.(i) Transferer (previous owner)</b> is filled.<br>If not required, keep it blank.<br><br>Note: To reset the <b>(ii) Date of transfer</b>, click on <kbd>Delete</kbd> OR <kbd>Backspace</kbd>.');
            }
            
            if(prevOwner=='' && dtTransfer != ''){
                e.preventDefault();
                showAlrt('<b>10.(i) Transferer (previous owner)</b> shouldn\'t be empty if <b>Date of Transfer</b> is filled.<br>If not required, keep it blank.<br><br>Note: To reset the <b>(ii) Date of transfer</b>, click on <kbd>Delete</kbd> OR <kbd>Backspace</kbd>.');
            }
        }

        var mineCode = $('#mine_code').val();

        var newAFaxNo = $("#f_a_fax_no").val().trim();
        var newAFaxNoEl = $('#f_a_fax_no');
        // if ((isNummm(newAFaxNo) == 'no') || newAFaxNo.length > 15 || newAFaxNo.length < 6) {
        if ((isNummm(newAFaxNo) == 'no') || newAFaxNo.length > 15) {
            var replyMsg = "Fax number is not valid.";
            newAFaxNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var newAPhoneNo = $("#f_a_phone_no").val();
        var newAPhoneNoEl = $('#f_a_phone_no');
        if ((isNummm(newAPhoneNo) == 'no') || newAPhoneNo.length > 15 || newAPhoneNo.length < 6) {
            var replyMsg = "Phone number is not valid.";
            newAPhoneNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var newAMobileNo = $("#f_a_mobile_no").val();
        var newAMobileNoEl = $('#f_a_mobile_no');
        if ((isNummm(newAMobileNo) == 'no') || newAMobileNo.length != 10) {
            var replyMsg = "Mobile number is not valid.";
            newAMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
		var validfirstno = ['6','7','8','9'];
		var f_m_no = newAMobileNo.charAt(0);
		if($.inArray(f_m_no,validfirstno) != -1){
			
		}else{
            var replyMsg = "Mobile number is not valid.";
            newAMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
		}
        
        var newAEMail = $("#f_a_email").val();
        var newAEMailEl = $('#f_a_email');
        if (isEmail(newAEMail) == false) {
            var replyMsg = "E-mail is not valid.";
            newAEMailEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }

    });

    
    $('#f_a_mobile_no').on('focusout', function() {

        var umobile = $("#f_a_mobile_no").val();
        var newMobileNoEl = $('#f_a_mobile_no');
		var validfirstno = ['6','7','8','9'];
		
		var f_m_no = umobile.charAt(0);
		if($.inArray(f_m_no,validfirstno) != -1){
			
		}else{
            var replyMsg = "Mobile number is not valid.";
            newMobileNoEl.parent().next('.err_cv').text(replyMsg);
		}

    });

    var returnType = $('#return_type').val();
    if(returnType == 'ANNUAL') {
        NameAndAddress.fieldValidation();
    }

    jQuery('.a_fax_no_update').click(function () {
        
        var newAFaxNo = $("#f_a_fax_no").val().trim();
        var newAFaxNoEl = $('#f_a_fax_no');
        // if ((isNummm(newAFaxNo) == 'no') || newAFaxNo.length > 15 || newAFaxNo.length < 6) {
        if (newAFaxNo.length > 15 && ( (newAFaxNo.length > 0) && (isNummm(newAFaxNo) == 'no') ) ) {
            var replyMsg = "Fax number is not valid.";
            newAFaxNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }

        var value = jQuery.trim($("#f_a_fax_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.a_fax_ajaxloader').fadeIn();
        jQuery('.a_fax_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/FA/' + value, function () {
            jQuery('.a_fax_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.a_phone_no_update').click(function () {
        
        var newAPhoneNo = $("#f_a_phone_no").val();
        var newAPhoneNoEl = $('#f_a_phone_no');
        if ((isNummm(newAPhoneNo) == 'no') || newAPhoneNo.length > 15 || newAPhoneNo.length < 6) {
            var replyMsg = "Phone number is not valid.";
            newAPhoneNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }

        var value = jQuery.trim($("#f_a_phone_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.a_phone_ajaxloader').fadeIn();
        jQuery('.a_phone_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/PA/' + value, function () {
            jQuery('.a_phone_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.a_mobile_no_update').click(function () {
        
        var newAMobileNo = $("#f_a_mobile_no").val();
        var newAMobileNoEl = $('#f_a_mobile_no');
        if ((isNummm(newAMobileNo) == 'no') || newAMobileNo.length != 10) {
            var replyMsg = "Mobile number is not valid.";
            newAMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
		var validfirstno = ['6','7','8','9'];
		var f_m_no = newAMobileNo.charAt(0);
		if($.inArray(f_m_no,validfirstno) != -1){
			
		}else{
            var replyMsg = "Mobile number is not valid.";
            newAMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
		}

        var value = jQuery.trim($("#f_a_mobile_no").val());
        var mineCode = $('#mine_code').val();
        jQuery('.a_mobile_ajaxloader').fadeIn();
        jQuery('.a_mobile_no_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/MA/' + value, function () {
            jQuery('.a_mobile_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    jQuery('.a_email_update').click(function () {
        
        var newAEMail = $("#f_a_email").val();
        var newAEMailEl = $('#f_a_email');
        if (isEmail(newAEMail) == false) {
            var replyMsg = "E-mail is not valid.";
            newAEMailEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var value = jQuery.trim($("#f_a_email").val());
        var mineCode = $('#mine_code').val();
        jQuery('.a_email_ajaxloader').fadeIn();
        jQuery('.a_email_loder').hide().load('../monthly/mineUpdates/MC/'+mineCode+'/EA/' + value, function () {
            jQuery('.a_email_ajaxloader').hide();
            jQuery(this).fadeIn();
        });
    });

    $("#profile_pdf").change(function () {
        $(this).removeClass('is-invalid');
        $('#profile_pdf_error').text("");
        var fileExtension = ['xls', 'xlsx'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $(this).addClass('is-invalid');
            $(this).val('');
            $('#profile_pdf_error').text("Only excel format allowed!");
        }
        if ( window.FileReader && window.File && window.FileList && window.Blob ) {
            if (this.files[0].size > 2000000) { // 2 MB validation
                $(this).addClass('is-invalid');
                $(this).val('');
                $('#profile_pdf_error').text("Max allowed upload size is 2 MB");
            }
        }
    });
    
    $("#profile_kml").change(function () {
        $(this).removeClass('is-invalid');
        $('#profile_kml_error').text("");
        var fileExtension = ['kml', 'kmz'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $(this).addClass('is-invalid');
            $(this).val('');
            $('#profile_kml_error').text("Only KML,KMZ format allowed!");
        }
        if ( window.FileReader && window.File && window.FileList && window.Blob ) {
            if (this.files[0].size > 2000000) { // 2 MB validation
                $(this).addClass('is-invalid');
                $(this).val('');
                $('#profile_kml_error').text("Max allowed upload size is 2 MB");
            }
        }
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