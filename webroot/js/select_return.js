
$(document).ready(function(){
    
	/**
	 * Show loader on AJAX execution
	 * @version 17th Jan 2022
	 * @author Aniket Ganvir
	 */
	$(document).ajaxStart(function() {
		$('.form_spinner').show('slow');
	});

	$(document).ajaxStop(function() {
		$('.form_spinner').hide('slow');
	});

    /* message modal box */
    $('.msg_box_modal').ready(function(){
        $('#login-modal-btn-msg-box').click();
        $('.login-modal-btn').on('click',function(){
            var alrtRedirectUrl = $('#alrt_redirect_url').val();
            location.href = alrtRedirectUrl;
        });
    });

    /* monthly select return form validations */
    $('#frmSelectReturns').ready(function(){

        $("#month").change(function(){
            var year = $("#year option:selected").val();
            var month = parseInt($("#month option:selected").val());
                    
            if(year!=null){
                var currentMonth = $('#current_month').val();
                var currentYear = $('#current_year').val();
                            
                if(year == currentYear){
                    if(month >= currentMonth){
                        alert("You cannot select this month of current year");
                        $("#month").val('');
                    }   
                }
            }
        });
      
      
        $("#year").change(function(){

            var year = $("#year option:selected").val();
            var month = $("#month option:selected").val();
            var userType = $('#controller_type').val();
                
            // if(year!=null){
            //     var currentMonth = $('#current_month').val();
            //     var currentYear = $('#current_year').val();
                            
            //     if(year == currentYear){
            //         if(month >= currentMonth){
            //             alert("You cannot select this month of current year");
            //             $("#month").val('');
            //         }
            //     }
            // }

            if (userType == 'miner') {
                var mineCode = $('#mine_code').val();
                var ajaxUrl = "../ajax/getMinerFileReturnMonth";
                var dataPost = {'return_year': year, 'mine_code': mineCode};
            } else {
                var appId = $('#applicant_id').val();
                var ajaxUrl = "../ajax/getEnduserFileReturnMonth";
                var dataPost = {'return_year': year, 'applicant_id': appId};
            }
        
            if(year!=null){

                $.ajax({
                    type: 'POST',
                    url: ajaxUrl,
                    data: dataPost,
                    beforeSend: function (xhr){
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    success: function(response){
                        $('#month').html(response);
                    }
                });

            }

        });
      
        $('#frmSelectReturns').on('submit', function(){
            var month = $("#month option:selected").val();
            var year = $("#year option:selected").val();
            var result = true;
    
            if(month == ''){
    
                $('.err_month').text("Please select valid month");
                $('#month').addClass('form_red');
                result = false;
    
            } else if(year == ''){
    
                $('.err_year').text("Please select valid year");
                $('#year').addClass('form_red');
                result = false;
    
            }
    
            return result;
        });
    
        $('#month').on('click',function(){
            $(this).removeClass('form_red');
            $('.err_month').text("");
        });
    
        $('#year').on('click',function(){
            $(this).removeClass('form_red');
            $('.err_year').text("");
        });

    });

    /* annual select return form validations */
    $('#frmAnnualReturns').ready(function(){
        
        $('#frmAnnualReturns').on('submit', function(){
            var year = $("#year option:selected").val();
            var result = true;

            if(year == ''){
                $('.err_annual_year').text("Please select valid year");
                $('#year').addClass('is-invalid');
                result = false;
            }
    
            return result;
        });
    
        $('#year').on('click',function(){
            $(this).removeClass('is-invalid');
            $('.err_annual_year').text("");
        });

    });

      
});