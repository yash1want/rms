$(document).ready(function() {
	$('#plz_wait_reset').hide();
	$('#reset_ok').hide();
	$('#reset_done').hide();
	
    $('.leaselist').on('click','.reset_btn',  function(){
		
        $('#reset_alert').show();
        $('#confirm_reset').show();
        
        var lnm = $(this).attr('lnm');
        var mlpbcode = $(this).attr('mlpbcode');
        var mlpbtype = $(this).attr('mlpbtype');
        var lid = $(this).attr('lid');
        var appid = $(this).attr('appid');
				
        $('#lease_name_reset').text(lnm);
        $('#ml_pb_code_reset').text(mlpbcode);
        $('#ml_pb_type_reset').text(mlpbtype);
        $('#lease_id_reset').val(lid);
        $('#lease_name_reset').val(lnm);
        $('#ml_pb_code_reset').val(mlpbcode);
        $('#ml_pb_type_reset').val(mlpbtype);
        $('#applicant_id_reset').val(appid);
    });

    $('#confirm_reset').on('click',function(){

		if(confirm('Are you sure to reset the application? On reset, The all saved sections data will be erased completely. Reset action can not be undone.')){
			
			 $('#cancel_reset_modal').hide();
			 $('#confirm_reset').hide();	
            $('#reset_box_error').removeClass('alert alert-danger');
            $('#reset_box_error').text('');
		
			var leaseId = $('#lease_id_reset').val();
			var ml_pb_code = $('#ml_pb_code_reset').val();
			var ml_pb_type = $('#ml_pb_type_reset').val();
			 var applicant_id = $('#applicant_id_reset').val();
			 
			 $('#plz_wait_reset').show();
			 
			 $.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: '../ajax/reset-application',
                data: {'leaseid':leaseId,'ml_pb_code':ml_pb_code,'ml_pb_type':ml_pb_type,'applicant_id':applicant_id},
                beforeSend: function (xhr) { // for csrf token
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    $('.form_spinner').hide('slow');
                },
                success: function(resp){
                    
                    if($.trim(resp) == 1){
                        $('#plz_wait_reset').hide();
                        $('#leasedetails').hide();
                        $('#reset_alert').hide();
                        $('#reset_ok').show();
                        $('#reset_done').show();	
                    }else{
                        $('#reset_box_error').addClass('alert alert-danger');
                        $('#reset_box_error').text('Problem in resetting the application! Please, try again later.');
                    }		
                }

            });			
		}
        
    });
	
	$('#reset_ok').on('click',function(){
		location.reload();		
	});

});