
var tableFormD = document.getElementById('table_form_data').value;
var tableFormData = (tableFormD != '') ? JSON.parse(tableFormD) : Array();

$(document).ready(function(){

	/**
	 * Show loader on AJAX execution
	 * @version 18th Nov 2021
	 * @author Aniket Ganvir
	 */
	$(document).ajaxStart(function() {
		$('.form_spinner').show('slow');
	});

	$(document).ajaxStop(function() {
		$('.form_spinner').hide('slow');
	});
	
    // custom_validations.init();
    
    /* OPEN RETURNS IN EDIT OR VIEW MODE AS PER "section_mode" STATUS */

	var sectionMode = $('#section_mode').val();

	if(sectionMode == 'read'){
		$('.monthly-return-form input').not(':hidden').attr('disabled','disabled');
		$('.monthly-return-form select').attr('disabled','disabled');
		$('.monthly-return-form textarea').attr('disabled','disabled');
		$('.monthly-return-form #next1').hide();
		$('.monthly-return-form button').hide();
		$('.monthly-return-form .btn-rem').hide();

		$('#table_container').ready(function(){
			$('.monthly-return-form input').not(':hidden').attr('disabled','disabled');
			$('.monthly-return-form select').attr('disabled','disabled');
			$('.monthly-return-form textarea').attr('disabled','disabled');
		});
	}

	if(sectionMode == 'edit'){
		$('.form_btn_prev').hide();
		$('.form_btn_next').hide();
		$('.monthly-return-form #next1').hide();
		$('.monthly-return-form button').not('.btn-add-more').hide();
		// $('#submit').text('Update').show();
		$('#save_comment').show();
		$('#final_submit_ref').show();
		$('.referred-back-history .cmnt-edit').show();
		$('.referred-back-history .cmnt-del').show();
		$('.cmnt-action-btn .update-form').show();

		$('.form_btn_edit').show(); // add more
		$('.remove_btn_btn').show(); // add more
		$('.table_form #add_more').show(); // add more
		$('#ss_add_more_btn').show(); // source of supply
		$('.ss_remove_btn_btn').show(); // source of supply
	}

	$('#btn_final_submit').on('click', function(){
		var finalSubmitUrl = $('#final_submit_url').val();
		var returnUrl = $('#dashboard_url').val();
		finalSubmit(finalSubmitUrl, returnUrl);
	});
	
});

function finalSubmit(final_submit_url, redirect_url) {

    /***** Added magnetite,hematite arguments by saranya raj 18th April 2016 *******************/
    //disable

   	// Utilities.ajaxBlockUI();
    $.ajax({
        url: final_submit_url,
        success: function (resp) {

            var response = $.trim(resp);
			var returnType = $('#return_type').val();
            //if there are no errors
            if (response == "" || response == null) {

				$("#declarationModal").modal('show');
				
				/*var dashboardUrl = $('#dashboard_url').val();
				$('#login-modal-btn').click();
				$('#modal-alert-txt').text(returnType+' Return successfully submitted !');
				$('#modal_box').removeClass('login-modal-content');
				$('#modal_box .login-modal-header').addClass('bg-success');
				$('#modal_box .login-modal-header i').attr('class', 'fa fa-check-circle login-info-icon text-white');
				$('#modal-cont-btn').on('click',function(){
					location.href = dashboardUrl;
				});*/
				// $('#loginModal').on('click',function(){
				// 	location.href='auth/home';
				// });
				return false;

                // window.location = redirect_url;
                // return;

				/* Now at the time of submitting the final return, if the form is completed correctly,
				the esign message box will open for the purpose of esign to the filled form.
				Done by Pravin Bhakare. 27-07-2020 */	
				//modal.style.display = "block";					
                //window.location = redirect_url;
                //return false;
            }

            //if not list out the errors
            var data = response.split('|');
            /*
             var table = document.getElementById('final-submit-error');
             $(table).empty();
             var empty_tr = document.createElement('tr');
             empty_tr.innerHTML = "&nbsp;";
             table.appendChild(empty_tr);
             var empty_tr = document.createElement('tr');
             empty_tr.innerHTML = "&nbsp;";
             table.appendChild(empty_tr);*/

            var finalSubmitArray = new Array();
            for (var i = 0; i < data.length; i++) {
                finalSubmitArray += "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" + data[i] + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
            $("#final-submit-error").html(finalSubmitArray);
        }
    });

}


function finalSubmitRef(){

	$("#declarationModal").modal('show');
	return false;

	// var mine_code = $('#mine_code').val();
	// var return_date = $('#return_date').val();
	// var return_type = $('#return_type').val();
	// var mms_user_id = $('#mms_user_id').val();
	// var final_submit_ref_url = $('#final_submit_ref_url').val();
	// var home_link = $('#home_link').val();
	// var viewUserType = $('#view_user_type').val();
	// var returnType = $('#return_type').val();

	// if(viewUserType == 'authuser'){
	// var dataPost = {'submit':'final_submit_ref', 'mine_code':mine_code, 'return_date':return_date, 'return_type':return_type, 'mms_user_id':mms_user_id};
	// } else {
	// var dataPost = {'submit':'final_submit_ref', 'mine_code':mine_code, 'return_date':return_date, 'return_type':return_type, 'mms_user_id':mms_user_id};
	// }

	// $.ajax({
	// 	type: 'POST',
	// 	url: final_submit_ref_url,
	// 	data: dataPost,
	// 	beforeSend: function (xhr){
	// 		xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
	// 	},
	// 	success: function(response){

	// 		response = response.trim();

	// 		if(response == '1'){
	// 			$('#login-modal-btn').click();
	// 			$('#modal-alert-txt').text(returnType+' Return successfully submitted !');
	// 			$('#modal_box').removeClass('login-modal-content');
	// 			$('#modal_box .login-modal-header').addClass('bg-success');
	// 			$('#modal_box .login-modal-header i').attr('class', 'fa fa-check-circle login-info-icon text-white');
	// 			$('#modal-cont-btn').on('click',function(){
	// 				location.href=home_link;
	// 			});
	// 		} else {
	// 			$("#final-submit-error").html('<span class="alert alert-danger">Problem in submitting '+returnType+' return! Try again later.</span>');
	// 		}
	// 	}
	// });

}

