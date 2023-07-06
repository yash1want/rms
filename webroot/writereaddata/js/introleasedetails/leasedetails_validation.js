$(document).ready(function () {

 // make associate mineral as multiselect, Pravin Bhakare 06-07-2022
	$('#associate_miniral').multiselect({
		placeholder: 'Associate Minerals',
		includeSelectAllOption: true,
		buttonWidth: '100%',
		maxHeight: 200,
	});

	// Pravin Bhakare 06-07-2022
	$('.ms-options input[type=checkbox]').on('click',function(){
		return false;
	});
	
	var lease_type = $('#lease_type').val();
	if (lease_type == 1) {
		$('#fy_block_from').closest('div .col-md-3').hide();
		$('#fy_block_to').closest('div .col-md-3').hide();
		$('#fy_block_from').removeClass('cvReq');
		$('#fy_block_to').removeClass('cvReq');

	} else {
		$('#fy_block_from').closest('div .col-md-3').show();
		$('#fy_block_to').closest('div .col-md-3').show();
		$('#fy_block_from').addClass('cvReq');
		$('#fy_block_to').addClass('cvReq');
	}

	$('#lease_type').on('change', function () {

		var lease_type = $(this).val();

		if (lease_type == 1) {
			$('#fy_block_from').closest('div .col-md-3').hide();
			$('#fy_block_to').closest('div .col-md-3').hide();
			$('#fy_block_from').removeClass('cvReq');
			$('#fy_block_to').removeClass('cvReq');
			$('#fy_block_from').parent().parent().find('.err_cv:first').text('');
			$('#fy_block_to').parent().parent().find('.err_cv:first').text('');

		} else {
			$('#fy_block_from').closest('div .col-md-3').show();
			$('#fy_block_to').closest('div .col-md-3').show();
			$('#fy_block_from').addClass('cvReq');
			$('#fy_block_to').addClass('cvReq');
		}


	});

	//$('form').on('submit', function () {
		$('#btnSubmit').on('click', function () {
		var lease_type = $('#lease_type').val();

		if (lease_type == 2) {

			var fy_block_from = $('#fy_block_from').val();
			var fy_block_to = $('#fy_block_to').val();

			inputval = new Date(fy_block_from);
			var year = inputval.getFullYear();
			var month = inputval.getMonth() + 1;
			var day = inputval.getDate();


			var year = year + 5;
			month = month < 10 ? '0' + month : month;
			day = day < 10 ? '0' + day : day;

			var input2value = year + '-' + month + '-' + day;

			if (input2value != fy_block_to) {
				//$('#fy_block_to').parent().parent().find('.err_cv:first').text('There should be 5 year of span between "From" and "To" dates!');
				// return false;
			}
		}
		
		$("#bs-alert").modal();
		
		/*if (confirm('Ensured that all details were correct before submitting the form?')) {
			//do nothing 
		} else {
			return false;
		}*/

	});
	
	$("#btn_ok_1").on("click", function (e) {	
		$('#btnFSubmit').click();
	});


	// Added by Shweta Apale on 24-05-2022
	$('#form_id').on('change', '.fy_block_from', function () {
		var id = $(this).attr('id');
		generateToDate(id);
	});


	// To generate To Date from next 5 year depending on From Date on 24-05-2022 by Shweta Apale
	function generateToDate(elementId) {

		var fromDate = $('#fy_block_from').val();

		var fromNextFiveYr = Number(fromDate) + Number(5);

		$('#fy_block_to').empty(); //add this line to empty select before appending value

		for (var i = fromDate; (i < fromNextFiveYr); i++) {
			var j = Number(i) + Number(1);
			var subStr = j.toString().substr(2);

			var toDate = i + '-' + subStr;
			j = j - 1;
			$('#fy_block_to').append(`<option value="${j}">${toDate}</option>`);
		}
	}

	// Added by Shweta Apale on 24-05-2022 On page load fetching value of To Date
	// window.onload = function displayToDate() {
		
	// 	var lease_type = $('#lease_type').val();

	// 	if (lease_type == 2) {
			
	// 		var toDates = $('#fy_block_to_date').val();
	// 		//console.log(toDates);
	// 		if (toDates == '1970') {
	// 			$('#fy_block_to').empty();
	// 		}
	// 		else {
	// 			var fromDate = $('#fy_block_from').val();

	// 			var fromNextFiveYr = Number(fromDate) + Number(5);

	// 			for (var i = fromDate; (i < fromNextFiveYr); i++) {
	// 				var j = Number(i) + Number(1);
	// 				var subStr = j.toString().substr(2);

	// 				var toDate = i + '-' + subStr;

	// 				$('#fy_block_to').append(`<option value="${j}" selected>${toDate}</option>`);
	// 			}
	// 		}
	// 	}else{
			
	// 		$("#fy_block_from").addClass("d_none");
	// 		$("#fy_block_to").addClass("d_none");
	// 	}	
	// }
	
	
	$("#forest").on("focusout",function(e){
		
		var leasearea = parseFloat($("#leasearea").val());
		var forest = parseFloat($("#forest").val());
		
		if(forest > leasearea){
			$("#forest").val('');
			$(".forest_err_cv").text('Forest area will be less or requal from lease area');			
		}		
	});
	
	$("#forest").on("focusin",function(e){
		
		$(".forest_err_cv").text('');		
	});
	
	$("#lease_type").on("change",function(){
		
		var lease_type = $('#lease_type').val();
		
		if (lease_type == 2) {
			$("#fy_block_from").show();
			$("#fy_block_to").show();
		}else{
			$("#fy_block_from").hide();
			$("#fy_block_to").hide();
		}
	})
	
	
});