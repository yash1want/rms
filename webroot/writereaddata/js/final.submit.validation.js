var final_submt_btn = $("#hidden_final_sub").val();
var sub_btn = $("#hidden_final_sub_btn").val();
var payment_module_status = $('#payment_module_status').val();
var loginusertype = $("#loginusertype").val();
var formview = $("#formview").val();
var commentsectionview = $("#commentsectionview").val();
var hidecommentbox = $("#hidecommentbox").val();	
var curAction = $('#current_action').val();
var ioFinalSubmitBtnStatus = $('#io_final_submit_btn_status').val();
// added by Pravin Bhakare 17-010-2022
var displaymode = $('#displaymode').val();

if(payment_module_status == 'view-all'){
  final_submt_btn = 'view_all';
  commentsectionview = 'view_all';       
}else if(payment_module_status == 'edit'){
  final_submt_btn = 'view_all';
  if(curAction !="paymentDetail"){ 
	   commentsectionview = 'view_all';    
  }
}

 $(document).ready(function()
 {
    $('#main_outer_form').ready(function(){
        input();
    });
	
	// Added by Pravin Bhakare 17-010-2022
	$('#btnDisapproved').on('click', function(){
		$("#ro-comm-with-applicant").prop("checked", true);
	});
	/*$('.bottombutton').on('click', '#final_submt_btn', function(){
		var finalSubmitUrl = $('#final_submit_url').val();
		finalSubmit(finalSubmitUrl);
	});*/
	
	$('#referred_back_final_submit').on('click',function(e){
		if(confirm('Are your sure to Referred Back this application?')){
			return true;
		} else {
			e.preventDefault();
			return false;
		}
	});

});
 
function input()
{
		if(final_submt_btn == 'view_all'){

		  $("#main_outer_form :input").prop("disabled", true);
		  $("#main_outer_form :input[type='radio']").prop("disabled", true);
		  $("#main_outer_form :input[type='select']").prop("disabled", true);
		  $("#main_outer_form :input[type='submit']").css('display','none');
		  $("#main_outer_form :input[type='reset']").css('display','none');
		  $("#main_outer_form :input[type='button']").prop("disabled", true);
		  $("#main_outer_form :input[type='hidden']").prop("disabled", false);
		  $("#add_more").remove();
		  if(sub_btn == 'yes' && payment_module_status == 'edit'){
			$(".remove_btn_btn").show();
		  }else{
			$(".remove_btn_btn").remove();
		  }

		}
		
		if(formview == 'view_all'){

		  $("#main_outer_form :input").prop("disabled", true);
		  $("#main_outer_form :input[type='radio']").prop("disabled", true);
		  $("#main_outer_form :input[type='select']").prop("disabled", true);
		  $("#main_outer_form :input[type='submit']").css('display','none');
		  $("#main_outer_form :input[type='reset']").css('display','none');
		  $("#main_outer_form :input[type='button']").prop("disabled", true);
		  $("#main_outer_form :input[type='hidden']").prop("disabled", false);
		  $("#add_more").remove();
		  $(".remove_btn_btn").remove();
		  //$(".commentboxf").css('display','none');	
		  $("#showuploadmodelhref").css('display','none');
		}
		
		// Add displaymode condition by Pravin Bhakare 17-010-2022
		if(displaymode == 'view'){
			
			$(".cmnt-edit").css('display','none');
			$(".cmnt-del").css('display','none');
			$("#btnSubmit").css('display','none');
			$("#btnApproved[type='submit']").css('display','none');
			$("#btnApproved[type='button']").css('display','none');
			$("#btnDisapproved[type='submit']").css('display','none');
			$("#save_comment").css('display','none');
			$("#referred_back_final_submit").css('display','none');
			$("#final_submt_btn").css('display','none');
			$("#btnReject").css('display','none');
			$(".commentboxf").css('display','none');
			
		}else if(commentsectionview == 'view_all'){
			
			$(".cmnt-edit").css('display','none');
			$(".cmnt-del").css('display','none');
			$("#btnSubmit").css('display','none');
			$("#btnApproved[type='submit']").css('display','none');
			// $("#btnApproved[type='button']").css('display','none');
			$("#save_comment").css('display','none');
			$("#referred_back_final_submit").css('display','none');
			$("#final_submt_btn").css('display','none');
			$("#btnReject").css('display','none');
			$(".commentboxf").css('display','none');
			
		}else if(hidecommentbox == "true"){
			
			$(".commentboxf").css('display','none');
			$("#save_comment").css('display','none');
			
		}else{
			$(".cmnt-edit").css('display','none');
			$(".cmnt-del").css('display','none');
		}

		if(payment_module_status == 'edit-all'){
			$("#main_outer_form #payment_transaction_id").prop("disabled", false);
			$("#main_outer_form #payment_trasaction_date").prop("disabled", false);
			$("#main_outer_form #payment_receipt_document").prop("disabled", false);
		}else if(payment_module_status == 'view-all'){
			$("#main_outer_form #payment_transaction_id").prop("disabled", true);
			$("#main_outer_form #payment_trasaction_date").prop("disabled", true);
			$("#main_outer_form #payment_receipt_document").prop("disabled", true);
		}else if(payment_module_status == 'edit'){
			var curCntrl = $('#current_controller').val();
			var curAction = $('#current_action').val();
			$("#main_outer_form input[name='bharatkosh_payment_done']").prop("disabled", false);
			$("#main_outer_form #payment_transaction_id").prop("disabled", false);
			$("#main_outer_form #payment_trasaction_date").prop("disabled", false);
			$("#main_outer_form #payment_receipt_document").prop("disabled", false);
			$("#main_outer_form #payment_amount").prop("disabled", false);
			$("#main_outer_form #applicant_comment").prop("disabled", false);
			
			if(curCntrl == 'Payment' && curAction == 'paymentDetail'){
				$("#main_outer_form #btnSubmit").prop("disabled", false);
				$("#main_outer_form #btnSubmit").show();
			}
			if(sub_btn == 'yes'){
				$("#main_outer_form #final_submt_btn").prop("disabled", false);
			}
	  }

	// Button disabled exception added for "1.1 Lease Details > Name of associated minerals:", added on 2022-07-11 by Aniket
	$('.ms-options-wrap button').prop('disabled',false);
	// allow rejection action at all stages of process (i.e. submit, at scrutiny, referred back) but not on disposed (i.e. Approved, Rejected, Withdrawn) - Aniket G [09-01-2023][C]
	var rejectionBtn = $('#rejection_btn').val();
	if(rejectionBtn == true){
		$("#btnReject").css('display','inline-block'); // overwrite previous reject button `display` properties
	}

	// Show 'Scrutinize and Send to RO' button to IO 
	// if there is no section available for scrutiny by default (condition when applicant remove sections like Financial Year 4, Year 5)
	// this will overwrite existing button show logic
	if(ioFinalSubmitBtnStatus == true){
		$("#referred_back_final_submit").css('display','block');
	}

}

function finalSubmit(final_submit_url) {

    $.ajax({
        url: final_submit_url,
        success: function (resp) {

            var response = $.trim(resp);
            //if there are no errors
            if (response == "yes") {

				$("#declarationModal").modal('show');
				return false;

            }else{

				var data = [];
				data[0] = "Invalid request!";
	
				var finalSubmitArray = new Array();
				for (var i = 0; i < data.length; i++) {
					finalSubmitArray += "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" + data[i] + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
				}

				$("#final_submit_error_msg").html(finalSubmitArray);

			}

        }
    });

}


