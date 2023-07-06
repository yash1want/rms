
$(document).ready(function(){

	$('#table_container').ready(function(){

		var tblRw = $('#table_1 .table_body tr').length;
		for(var i=1;i<=tblRw;i++){

			var grade = $('#table_1 .table_body tr:nth-child('+i+') td').eq(0).find('select').val();
			if(grade != 'NIL'){
				var natDespatch = $('#table_1 .table_body tr:nth-child('+i+') td').eq(1).find('select').val();
				if(natDespatch == 'EXPORT'){
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(2).find('input').val('').attr('disabled','true');
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(3).find('input').val('').attr('disabled','true');
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(4).find('input').val('').attr('disabled','true');
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(5).find('input').val('').attr('disabled','true');
				} else if(natDespatch != ''){
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(6).find('select').val('').attr('disabled','true');
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(7).find('input').val('').attr('disabled','true');
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(8).find('input').val('').attr('disabled','true');
				}
			} else {
				remOtherRw();
			}

			if(i!=1){
				
				if($('#table_1 .table_body tr:nth-child('+i+') td').eq(0).find("select option[value='NIL']").length != 0){
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(0).find("select option[value='NIL']").remove();
				}
				
				if($('#table_1 .table_body tr:nth-child('+i+') td').eq(1).find("select option[value='NIL']").length != 0){
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(1).find("select option[value='NIL']").remove();
				}
				if($('#table_1 .table_body tr:nth-child('+i+') td').eq(6).find("select option[value='NIL']").length != 0){
					$('#table_1 .table_body tr:nth-child('+i+') td').eq(6).find("select option[value='NIL']").remove();
				}

			}

		}
		
	});
});

$(document).ready(function(){

	$('#table_container').ready(function(){

		var tblRw = $('#table_1 .table_body tr').length;
		$('.sale_despatch_grade').on('change',function(){

			var curEl = $(this).attr('id');
			var curElArr = curEl.split('-');
			var curElRw = curElArr.length;
			var tblRw = curElArr[curElRw - 1];
			var grade = $(this).val();
			
			if(grade == 'NIL'){
				
				if($('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(1).find("select option[value='NIL']").length == 0){
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(1).find('select').append($('<option></option>').attr('value','NIL').text('NIL'));
				}

				$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(1).find('select').val('NIL').prop('disabled', true);
				$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(2).find('.auto-comp').val('0').prop('disabled', true);
				$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(3).find('input').val('NIL').prop('disabled', true);
				$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(4).find('input').val('0.000').prop('disabled', true);
				$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(5).find('input').val('0.00').prop('disabled', true);
				
				if($('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(6).find("select option[value='NIL']").length == 0){
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(6).find('select').append($('<option></option>').attr('value','NIL').text('NIL'));
				}

				$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(6).find('select').val('NIL').prop('disabled', true);
				$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(7).find('input').val('0.000').prop('disabled', true);
				$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(8).find('input').val('0.00').prop('disabled', true);

				remOtherRw();

			} else {

				upOtherRw();
				
				if($('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(1).find("select option[value='NIL']").length != 0){
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(1).find("select option[value='NIL']").remove();
					
					if($('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(6).find("select option[value='NIL']").length != 0){
						$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(6).find("select option[value='NIL']").remove();
					}
					
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(1).find('select').prop('disabled', false);
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(2).find('.auto-comp').prop('disabled', false);
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(3).find('input').prop('disabled', false);
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(4).find('input').prop('disabled', false);
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(5).find('input').prop('disabled', false);

					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(6).find('select').val('');
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(7).find('input').val('');
					$('#frmSalesDespatches #table_1 .table_body #row_container-'+tblRw+' td').eq(8).find('input').val('');

				}

			}

		});
		
	});
});

function remOtherRw(){

	$('#frmSalesDespatches #table_1 .table_body tr:not(:first-child)').remove();
	$('#add_more').hide();
	$('#frmSalesDespatches #table_1 .table_body tr:first-child .remove_btn .remove_btn_btn').attr('disabled',true);

}

function upOtherRw(){

	$('#add_more').show();
}

$(document).ready(function(){

	$('#table_container_1').ready(function(){

		$('#frmSalesDespatches').on('submit',function(){
			
			var validStatus = true;
			$('.s_des_input').removeClass('is-invalid');
			$('.s_des_input').next('.err_cv').text('');

			var tblRw = $('#frmSalesDespatches table .table_body tr').length;
			
			for(var i=1;i<=tblRw;i++){

				var grade = $('#frmSalesDespatches table .table_body tr:nth-child('+i+') td').eq(0).find('select').val();
				var curEl = $('#frmSalesDespatches table .table_body tr:nth-child('+i+') td').eq(0).find('select').attr('id');
				var curElArr = curEl.split('-');
				var curElRw = curElArr.length;
				var tRw = curElArr[curElRw - 1];

				if(grade == 'NIL'){
					//
				} else if(grade != ''){

					validStatusResult = chkSDespatchRw(tRw);
					if(validStatusResult == false){
						validStatus = false;
					}

				} else {

					showInputAlrt(tblRw);
					validStatus = false;

				}

			}
			
			if(validStatus == false){
				showAlrt('Invalid input !');
				$('.toast').toast('show');
			}

			return validStatus;

		});
	});
});

function showAlrt(msg){

	remAlrt();
	var alrtCon = '<div class="toast alrt-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">';
	alrtCon += '<div class="alrt-body">';
	alrtCon += '<i class="fa fa-exclamation-triangle"></i>';
	alrtCon += '<span> '+msg+'</span>';
	alrtCon += '</div>';
	alrtCon += '</div>';
	$('.alrt-div').append(alrtCon);

}

function remAlrt(){
	$('.alrt-div').html('');
}

function chkSDespatchRw(tRw){
	
	var validStatus = true;
	var natDespatch = $('#frmSalesDespatches #table_1 .table_body #row_container-'+tRw+' td').eq(1).find('select').val();

	if(natDespatch == 'EXPORT'){

		for(var i=6;i<=8;i++){

			var inField = $('#frmSalesDespatches #table_1 .table_body #row_container-'+tRw+' td').eq(i).find('.s_des_input').val();
			if(inField == ''){ showFieldAlrt(tRw, i); validStatus = false;  }

		}

	} else if(natDespatch != ''){
		
		for(var i=2;i<=5;i++){

			var inField = $('#frmSalesDespatches #table_1 .table_body #row_container-'+tRw+' td').eq(i).find('.s_des_input').val();
			if(inField == ''){ showFieldAlrt(tRw, i); validStatus = false; }

		}

	} else {
		
		var inField = $('#frmSalesDespatches #table_1 .table_body #row_container-'+tRw+' td').eq(1).find('.s_des_input').val();
		if(inField == ''){ showFieldAlrt(tRw, 1); validStatus = false; }

	}

	return validStatus;

}


function showInputAlrt(tRw){

	$('#frmSalesDespatches #table_1 .table_body #row_container-'+tRw+' td').eq(0).find('select').addClass('is-invalid');
	$('#frmSalesDespatches #table_1 .table_body #row_container-'+tRw+' td').eq(0).find('select').next('.err_cv').text('Invalid !');

}

function showFieldAlrt(tRw, eqId){

	$('#frmSalesDespatches #table_1 .table_body #row_container-'+tRw+' td').eq(eqId).find('.s_des_input').addClass('is-invalid');
	$('#frmSalesDespatches #table_1 .table_body #row_container-'+tRw+' td').eq(eqId).find('.s_des_input').next('.err_cv').text('Invalid !');

}


$(document).ready(function(){

	$('#table_container').ready(function(){
		$('.auto-comp').on('change',function(){

		  	var curEl = $(this).attr('id');
		  	var curElArr = curEl.split('-');
		  	var numRw = curElArr[2];
			var consigneeUrl = $('#consignee_url').val();

			setTimeout(function(){
				var reg_no = $('#ta-client_reg_no-'+numRw).val();
				$.ajax({
					type: 'POST',
					url: consigneeUrl,
					data: {	'reg_no': reg_no,},
					beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
					success: function(data){
						$('#ta-client_name-'+numRw).val(data);
					}
				});
			}, 500);

		});
	});
});


$(document).ready(function(){

	$('#table_container').ready(function(){

	  $(".auto-comp").on("keyup", function(){
	  	var curEl = $(this).attr('id');
	  	var curElArr = curEl.split('-');
	  	var numRw = curElArr[2];
	    var app_id = $(this).val();
		var appUrl = $('#app_id_url').val();
	    if (app_id !=="") {
	      $.ajax({
	        url:appUrl,
	        type:"POST",
	        cache:false,
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
	        data:{'app_id':app_id},
	        success:function(data){
	          $("#ta-suggestion_box-"+numRw).html(data);
	          $("#ta-suggestion_box-"+numRw).fadeIn();
	        }  
	      });
	    }else{
	      $("#ta-suggestion_box-"+numRw).html("");  
	      $("#ta-suggestion_box-"+numRw).fadeOut();
	    }

		  // click one particular city name it's fill in textbox
		  // $(document).on("click","li", function(){
		  //   $('#ta-client_reg_no-'+numRw).val($(this).text());
		  //   $('#ta-suggestion_box-'+numRw).fadeOut("fast");
		  // });

		  $(document).on("click",".sugg-box ul li", function(){
		  	var sugBoxId = $(this).closest('.sugg-box').attr('id');
		  	var curBx = sugBoxId.split('-');
		  	var boxRw = curBx[2];
		    $('#ta-client_reg_no-'+boxRw).val($(this).text());
		    $('#ta-suggestion_box-'+boxRw).fadeOut("fast");
		  });

	  });

  });

});
