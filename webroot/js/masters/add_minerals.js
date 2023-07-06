
$(document).ready(function() {

});
$("#tableReportModal").on('click','.addmineral',function() {
	
	var form_type = $(this).parent().parent().find("select.form_type").val();
	var input_unit = $(this).parent().parent().find("select.input_unit").val();
	var output_unit = $(this).parent().parent().find("select.output_unit").val();
	var mineral_code = $(this).attr('id');
	var result = 'true';
	var recordstatus = 1;
	
	if(typeof form_type !== "undefined"){
		if(form_type == ''){
			$(this).parent().parent().find("select.form_type").addClass('is-invalid');
			result = 'false';
		}
		recordstatus = 0;
	}else{
		form_type = '';
	}
	
	if(typeof input_unit !== "undefined"){
		if(input_unit == ''){
			$(this).parent().parent().find("select.input_unit").addClass('is-invalid');
			result = 'false';
		}
		recordstatus = 0;
	}else{
		input_unit = '';
	}
	
	if(typeof output_unit !== "undefined"){
		if(input_unit == ''){
			$(this).parent().parent().find("select.output_unit").addClass('is-invalid');
			result = 'false';
		}
		recordstatus = 0;
	}else{
		output_unit = '';
	}
	
	if(result == 'false'){
		return false;
	}else{
		
		$.ajax({
			url: 'addmineralfromreg',
			type: "POST",
			data: ({form_type:form_type,input_unit:input_unit,output_unit:output_unit,mineral_code:mineral_code,recordstatus:recordstatus}),
			beforeSend: function(xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
			success: function(resp) {
				if(resp == 1){
					alert('Mineral successfully added');
					window.location.reload();
				}else{
					alert('Something went wrong');
				}
			}
		});
	}
	
    
});