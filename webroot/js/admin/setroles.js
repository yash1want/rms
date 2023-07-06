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
            $(".checkboxx").attr('work_alloc_st', 0);
            $(".checkboxx").attr('work_alloc_txt', 0);
            $(".checkboxx").prop('checked', false);
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
                            val = (val == 'inspection_officer') ? 'io' : val; //added condition to mark checked for IO role checkbox, added on 22-09-2022 by Aniket.
                            $("input[name='"+val+"']").prop('checked', true);
                            $("input[name='"+val+"']").attr('work_alloc_st', obj[2][val]);
                            $("input[name='"+val+"']").attr('work_alloc_txt', obj[3][val]);
                        })
                    }                    
                }
            })
        }
    });

    // Restrict work allocated user role form being unchecked, added on 22-09-2022 by Aniket.
    $('.checkboxx').on('click',function(){
        var work_alloc_st = $(this).attr('work_alloc_st');
        var work_alloc_txt = $(this).attr('work_alloc_txt');
        if(work_alloc_st == 1){
            this.checked = true;
            alert("Can't remove this user role, Because following work are allocated: "+work_alloc_txt+" Please Reallocate the work to another user and then update the role.");
        }
    });


})