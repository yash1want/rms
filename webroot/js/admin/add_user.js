
$(document).ready(function(){
	
	var zoneregioncount = $('#zoneregioncount').val();
	var parentUserListCount = $('#parentUserListCount').val();
	var zoneRegionCount = $('#zoneRegionCount').val();
	var useraction = $('#useraction').val();
	var current_role_id  = $('#role_id').val();
	var usrid  = $('#usrid').val();

	if(zoneregioncount == 0){

		$("#zoneregionbox").hide();

	}	
	if(parentUserListCount == 0){
		$("#parentbox").hide();
	}	
	if(zoneRegionCount == 0){
		$("#zoneregionbox").hide();
	}	


	ajaxfunction.getDistrictsArr();
    ajaxfunction.getParentUsersArr();
    ajaxfunction.getZoneRegionArr();

    /*$('#role_id').change(function(){ 
		ajaxfunction.getParentUsersArr();

    });*/

	
    $('#email').on('focusout',function(){

    	let uemail = $("#email").val();
		var userEmailOld = $('#userEmailOld').val();

		if(uemail != userEmailOld) {
			
			$.ajax({				
				type:"POST",
				url:"../ajax/get-dup-email",
				data:{uemail:uemail},
				cache:false,
				
				beforeSend: function (xhr) { // Add this line
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				},
				success : function(response)
				{	
					if(response == 1){

						$("#email_error").show().text('already exists, try with unique email id');
						$("#email").addClass("is-invalid");
						$("#email").val('');
						$("#email").click(function(){$("#email_error").hide().text; $("#email").removeClass("is-invalid");});
					
					}if(response == 2)
					{

						$("#email_error").show().text('Invalid email id');
						$("#email").addClass("is-invalid");
						$("#email").val('');
						$("#email").click(function(){$("#email_error").hide().text; $("#email").removeClass("is-invalid");});
					}					
				}
			});

		}    	

    });


    $('#mobile').on('focusout',function(){

    	let umobile = $("#mobile").val();
    	let value_return = 'true';

    	if(!(umobile.match(/^(?=.*[0-9])[0-9]{10}$/g)))//also allow if 6 X $ 4 nos found //added on 12-10-2017 by Amol   
		{ 						
			$("#mobile_error").show().text('Invalid mobile number');
    		$("#mobile").addClass("is-invalid");
    		$("#mobile").val('');
			$("#mobile").click(function(){$("#mobile_error").hide().text; $("#mobile").removeClass("is-invalid");});
			value_return = 'false';						
		}
		
		
		var validfirstno = ['6','7','8','9'];
		
		var f_m_no = umobile.charAt(0);
		if($.inArray(f_m_no,validfirstno) != -1){
			
		}else{
			$("#mobile_error").show().text('Invalid mobile number');
    		$("#mobile").addClass("is-invalid");
    		$("#mobile").val('');
			$("#mobile").click(function(){$("#mobile_error").hide().text; $("#mobile").removeClass("is-invalid");});				 
			value_return='false';
		}

		if(value_return == 'true'){

			$.ajax({				
				type:"POST",
				url:"../ajax/get-dup-mms-mobile",
				data:{umobile:umobile},
				cache:false,
				
				beforeSend: function (xhr) { // Add this line
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				},
				success : function(response)
				{	
					if(response == 1){

						$("#mobile_error").show().text('already exists, try with unique mobile number');
	    				$("#mobile").addClass("is-invalid");
	    				$("#mobile").val('');
						$("#mobile").click(function(){$("#mobile_error").hide().text; $("#mobile").removeClass("is-invalid");});
					
					}if(response == 2)
					{

						$("#mobile_error").show().text('Invalid mobile number');
    					$("#mobile").addClass("is-invalid");
    					$("#mobile").val('');
						$("#mobile").click(function(){$("#mobile_error").hide().text; $("#mobile").removeClass("is-invalid");});				
					}					
				}
			}); 
		}

    });
	

	$('#mobile').on('input',function(){ 
		if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); 
	});
	$('#phone').on('input',function(){ 
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


	$('#btnsave').on('click',function(){
		
		var first_name = $('#first_name').val();		
		var last_name = $('#last_name').val();
		var email = $('#email').val();
		var mobile = $('#mobile').val();
		var role_id = $('#role_id').val();

		if($("#parentinput").length ){
			var parentinput = $('#parentinput').val();
			
			if(parentinput == ''){
				$("#parent_error").show().text('Please select the value');
				$("#parentinput").addClass("is-invalid");
	    		$("#parentinput").val('');
				$("#parentinput").click(function(){$("#parent_error").hide().text; $("#parentinput").removeClass("is-invalid");});
					
			}

		}
		if($("#zoneregionid").length ){
			var zoneregionid = $('#zoneregionid').val();

			if(first_name == ''){
				$("#zone_error").show().text('Please select the value');
				$("#zoneregionid").addClass("is-invalid");
	    		$("#zoneregionid").val('');
				$("#zoneregionid").click(function(){$("#zone_error").hide().text; $("#zoneregionid").removeClass("is-invalid");});
				
			}

		}

		if(first_name == ''){
			$("#f_error").show().text('Please enter a first name');
			$("#first_name").addClass("is-invalid");
	    	$("#first_name").val('');
			$("#first_name").click(function(){$("#f_error").hide().text; $("#first_name").removeClass("is-invalid");});
				
		}

		if(last_name == ''){
			$("#l_error").show().text('Please enter a last name');
			$("#last_name").addClass("is-invalid");
	    	$("#last_name").val('');
			$("#last_name").click(function(){$("#l_error").hide().text; $("#last_name").removeClass("is-invalid");});
				
		}

		if(email == ''){
			$("#email_error").show().text('Please enter an email');
			$("#email").addClass("is-invalid");
	    	$("#email").val('');
			$("#email").click(function(){$("#email_error").hide().text; $("#email").removeClass("is-invalid");});
				
		}

		if(mobile == ''){
			$("#mobile_error").show().text('Please enter a mobile number');
			$("#mobile").addClass("is-invalid");
	    	$("#mobile").val('');
			$("#mobile").click(function(){$("#mobile_error").hide().text; $("#mobile").removeClass("is-invalid");});
				
		}

		if(role_id == ''){
			$("#role_error").show().text('Please select the role');
			$("#role_id").addClass("is-invalid");
	    	$("#role_id").val('');
			$("#role_id").click(function(){$("#role_error").hide().text; $("#role_id").removeClass("is-invalid");});
				
		}
	});




})

