
$(document).ready(function() {
        
    /* deactivate user */
    $(document).on('click', '.deact_usr', function(){
        var usrId = $(this).attr('id');
        var usrIdArr = usrId.split('-');
        var usrIdNo = usrIdArr[1];
        var usrRoleId = $('#usr_role-'+usrIdNo).val();
        checkUserPendingWork(usrRoleId, usrIdNo);
    });
    
    /* activate user */
    $(document).on('click', '.act_usr', function(){
        var usrId = $(this).attr('id');
        var usrIdArr = usrId.split('-');
        var usrIdNo = usrIdArr[1];
        $('#confirm-modal-btn').click();
        $('#modal-confirm-txt').text('Are you sure you want to activate the user?');
        $('#modal_ok').attr('id', 'act_usr_modal_btn');
        $('#usr_id_hidden').val(usrIdNo);
    });
    
	$('#modal_cancel').on('click', function(){
		$('#confirmModal').trigger('click');
	});

	$('.confirm-modal-btn').on('click', function(){
		$('#confirmModal').trigger('click');
	});

	$(document).on('click', '#deact_usr_modal_btn', function(){

        var userId = $('#usr_id_hidden').val();

        if (userId != '') {
            $.ajax({
                type: 'POST',
                url: 'user_deactivate',
                data: {'action':'deactivate', 'user_id':userId},
                beforeSend: function (xhr){
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    $('.form_spinner').show('slow');
                },
                success: function(resp){
                    if (resp.trim() == 1) {
                        window.location.reload();
                    } else {
		                $('.form_spinner').hide('slow');
                        alert('Problem in user deactivation, try again later!');
                    }
                }
            });
        }

	});
    
	$(document).on('click', '#act_usr_modal_btn', function(){

        var userId = $('#usr_id_hidden').val();

        if (userId != '') {
            $.ajax({
                type: 'POST',
                url: 'user_activate',
                data: {'action':'activate', 'user_id':userId},
                beforeSend: function (xhr){
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    $('.form_spinner').show('slow');
                },
                success: function(resp){
                    if (resp.trim() == 1) {
                        window.location.reload();
                    } else {
		                $('.form_spinner').hide('slow');
                        alert('Problem in user activation, try again later!');
                    }
                }
            });
        }

	});
    
});

function checkUserPendingWork(userRoleId, userId) {
    
    if (userId != '') {
        $.ajax({				
            type:"POST",
            url:"../ajax/get-pending-work-status",
            data:{roleid:userRoleId,usrid:userId},
            cache:false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
		        $('.form_spinner').show('slow');
            },
            success : function(response)
            {	
                if(response.trim() == 'work_allocate'){

                    // $('.form_spinner').hide('slow');
                    
                    $.ajax({				
                        type:"POST",
                        url:"../ajax/get-pending-work-list",
                        data:{roleid:userRoleId,usrid:userId},
                        cache:false,
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                            $('.form_spinner').show('slow');
                        },
                        success: function(resp){

                            $('.form_spinner').hide('slow');
                            alert("Can't deactivate the user, Because following work are allocated: "+resp.trim()+" Please Reallocate the work to another user and then deactivate the user.");
                            
                        }

                    });
                    
                    // alert("Can't deactivate the user, Because some work are allocated. Please Reallocate the work to another user and then update the role.");
                    
                } else {
                            
                    $('.form_spinner').hide('slow');
                    $('#confirm-modal-btn').click();
                    $('#modal-confirm-txt').text('Are you sure you want to deactivate the user?');
                    $('#modal_ok').attr('id', 'deact_usr_modal_btn');
                    $('#usr_id_hidden').val(userId);
                    $('#usr_role_id_hidden').val(userRoleId);

                }
                
            }

        });
    }

}

