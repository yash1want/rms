$(document).ready(function(){

    $("#btnsave").on('click',function(){

        let selected_user =  $("#selected_user").val();
        let checkboxval = $("input[type='checkbox']").is(':checked');

        let return_value = 'true';
        
        if(selected_user == ''){
            $("#f_error").text('Select the user');
            $("#selected_user").addClass('is-invalid');
            return_value = 'false';             
        }

        if(checkboxval == false){
            $("#chk_error").text('Select the atleast one role');
            $(".checkboxx").addClass('checkInvalid'); 
            return_value = 'false';         
        }

        if(return_value == 'true'){
            $("#set_roles").submit();
        }else{
            return false;
        }
    });

    $("#btnupdate").on('click',function(){

        let selected_user =  $("#selected_user").val();
        let return_value = 'true';

        if(selected_user == ''){
            $("#f_error").text('Select the user');
            $("#selected_user").addClass('is-invalid');
            return_value = 'false';             
        }

        if(return_value == 'true'){
            $("#set_roles").submit();
        }else{
            return false;
        }

    });

    $(".forminput").on('click',function(){
        $("#selected_user").removeClass('is-invalid'); 
        $(".checkboxx").removeClass('checkInvalid');            
        $("#f_error").text('');
        $("#chk_error").text('');
    })


    $(".edit_selected_user").on('change',function(){

        let selected_user =  $("#selected_user").val();

        if(selected_user == ''){            
            $(".rolebox").css('display','none');
        }else{
            $(".rolebox").css('display','block');
            $.ajax({
                type:"POST",
                url:'get-user-roles',
                data:{user_id:selected_user},
                cache:false,                
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success : function(response)
                {
                    var obj = JSON.parse(response);

                    if(obj[0] == 'yes'){

                    }else{

                        let userroles = obj[1].split(',');                        
                        $.each(userroles,function (key, val){
                            $("input[name='"+val+"']").prop('checked', true);
                        })
                    }                    
                }
            })
        }
    });



})