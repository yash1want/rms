
$(document).ready(function() {

    $('#mobile').on('focusout', function() {
        checkMobile();
    });

	$('#mobile').on('input',function(){
		if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); 
	});

	$('#user_image').on('change',function(){

		$(this).removeClass('is-invalid');
        $('#photo_error').text("");
        var fileExtension = ['jpg', 'jpeg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $(this).addClass('is-invalid');
            $(this).val('');
            $('#photo_error').text("Only jpg,jpeg format allowed!");
        }
        if ( window.FileReader && window.File && window.FileList && window.Blob ) {
            if (this.files[0].size > 2000000) { // 2 MB validation
                $(this).addClass('is-invalid');
                $(this).val('');
                $('#photo_error').text("Max allowed upload size is 2 MB");
            }
        }

	});

    $('#add_user').on('submit', function(event) {
        var errStatus = checkMobile();
        if (errStatus == 'yes') {
            alert('Mobile number is not valid.');
            event.preventDefault();
        }
    });

});

function checkMobile() {
    
    var umobile = $("#mobile").val();
    var validfirstno = ['6','7','8','9'];
    var errStatus = 'no';
    
    var f_m_no = umobile.charAt(0);
    if($.inArray(f_m_no,validfirstno) != -1){
        $('#mobile_error').text("");
    }else{
        $('#mobile_error').text("Mobile number is not valid.");
        var errStatus = 'yes';
    }

    return errStatus;

}