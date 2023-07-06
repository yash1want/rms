
    $("#submit_btn").click(function(event){

    	if(change_password_validations() == false){
    		event.preventDefault();
    	}else{
    		$("#change_password").submit();
    	}

    });

    $('#change_password').on('focusout', '#Newpassword, #confpass', function() {
    
        var pswd = $(this).val();
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$#!%^*?&])[A-Za-z\d@$#!%^*?&]{8,}$/;

        if (!regex.test(pswd)){
            $(this).parent().parent().find('.error').text("Invalid password format.");
            $(this).addClass("is-invalid");
        } else {
            $(this).parent().parent().find('.error').text("");
            $(this).removeClass("is-invalid");
        }

    });

    //Validation to check the existing password by AKASH on 31-12-2021
    $('#Oldpassword').focusout(function (e) { 
      
        var Oldpassword = $("#Oldpassword").val();

        if (Oldpassword != '') {

            $.ajax({
                
                type : 'POST',
                url : '../ajax/check_old_password',
                async : true,
                data : {Oldpassword:Oldpassword},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success : function(response){

                    if($.trim(response)=='yes'){

                        alert('The Old Password is Not Correct ! Please Try Again.');
                        $("#Oldpassword").val('');
                    }
                }
            });
        }
        
    }); 


    //FOR CHECKING THE Password & CONFIRM Passwordd ARE SAME OR NOT ON 31-12-2021 BY AKASH
    $('#confpass').focusout(function(){

        var NewPassword = $("#Newpassword").val();
        var ConfirmedPassword = $('#confpass').val();
        if (NewPassword != '') {
            
            if (NewPassword != ConfirmedPassword) {
                alert('Confirm Password not matched!!');
                $('#confpass').val('');
            }
        }

    });


    //This function is used for change password input validations.
    function change_password_validations(){

        // Empty Field validation

        var oldpass=$("#Oldpassword").val();
        var newpass=$("#Newpassword").val();
        var confpass=$("#confpass").val();

        var value_return = 'true';

        if(oldpass==""){

            $("#error_oldpass").show().text("Please enter your old password.");
            $("#Oldpassword").addClass("is-invalid");
            $("#Oldpassword").click(function(){$("#error_oldpass").hide().text;$("#Oldpassword").removeClass("is-invalid");});
            value_return = 'false';
        }

        if(newpass==""){

            $("#error_newpass").show().text("Please enter your new password.");
            $("#Newpassword").addClass("is-invalid");
            $("#Newpassword").click(function(){$("#error_newpass").hide().text;$("#Newpassword").removeClass("is-invalid");});
            value_return = 'false';
        } else {
            if (isStdPasswordFormat(newpass) == 0) {
                $("#error_newpass").show().text("Invalid password format");
                $("#Newpassword").addClass("is-invalid");
                $("#Newpassword").click(function(){$("#error_newpass").hide().text;$("#Newpassword").removeClass("is-invalid");});
                value_return = 'false';
            }
        }

        if(confpass==""){

            $("#error_confpass").show().text("Please confirm your new password.");
            $("#confpass").addClass("is-invalid");
            $("#confpass").click(function(){$("#error_confpass").hide().text;$("#confpass").removeClass("is-invalid");});
            value_return = 'false';
        } else {
            if (isStdPasswordFormat(confpass) == 0) {
                $("#error_confpass").show().text("Please confirm your new password.");
                $("#confpass").addClass("is-invalid");
                $("#confpass").click(function(){$("#error_confpass").hide().text;$("#confpass").removeClass("is-invalid");});
                value_return = 'false';
            }
        }

        //added this condition on 10-02-2021 by Amol
        var user_id = $("#user_id").val();
        if(newpass==user_id){

            alert('Please Note: You can not use your User Id as your password');
            $("#Newpassword").val('');//clear field
            $("#confpass").val('');
            value_return = 'false';
        }


        if(value_return == 'false'){

            alert("Invalid input. Kindly check");
            $("#Newpassword").val('');//clear field
            $("#confpass").val('');
            return false;

        }else{
            
            //old password encription
            var OldpasswordValue = document.getElementById('Oldpassword').value; 
            var SaltValue = document.getElementById('hiddenSaltvalue').value;

            var OldpassEncryptpass = sha512(OldpasswordValue);   

            var OldpassSaltedpass = SaltValue.concat(OldpassEncryptpass);

            var OldpassSaltedsha512pass = sha512(OldpassSaltedpass);

            document.getElementById('Oldpassword').value = OldpassSaltedsha512pass;

            //new password encription
            var NewpasswordValue = document.getElementById('Newpassword').value;

           /* if(NewpasswordValue.match(/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%^&*]{7,15}$/g)){

            }else{
                showAlrt('Password length should be min. 8 char, min. 1 number, min. 1 Special char. and min. 1 Capital Letter');
                return false;
            }
        */

            var NewpassEncryptpass = sha512(NewpasswordValue); 
            var NewpassSaltedpass = SaltValue.concat(NewpassEncryptpass);
            document.getElementById('Newpassword').value = NewpassSaltedpass;

            //Confirm password encription
            var ConfpassValue = document.getElementById('confpass').value;
            var ConfpassEncrypt = sha512(ConfpassValue);
            var ConfpassSalted = SaltValue.concat(ConfpassEncrypt);
            document.getElementById('confpass').value = ConfpassSalted;
            document.getElementById('hiddenSaltvalue').value = '';
            exit();


        }


    }

function isStdPasswordFormat(input) {
    
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$#!%^*?&])[A-Za-z\d@$#!%^*?&]{8,}$/;

    if (!regex.test(input)) {
        return 0;
    } else {
        return 1;
    }

}

