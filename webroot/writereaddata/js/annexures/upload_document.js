 $(document).ready(function(){

 	$('.file_upload').on('change', function(){

 		var selected_file = $(this).val();
 		var field_id = $(this).attr('id');
 		
		var ext_type_array = ["pdf"];
		var get_file_size = $('#'.concat(field_id))[0].files[0].size;
		var get_file_ext = selected_file.split(".");
		var validExt = get_file_ext.length-1;
		var value_return = 'true';

		get_file_ext = get_file_ext[get_file_ext.length-1].toLowerCase();

		//if(get_file_size > 5097152){
		if(get_file_size > 10485760){  // 5097152 5 Mb changed to 10 Mb 10485760 for 20971520 20 Mb
			$("#error_size_".concat(field_id)).show().text("Please select file below 10mb");
			$("#".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){ $("#error_size_".concat(field_id)).show().text(''); $("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}

		if(ext_type_array.lastIndexOf(get_file_ext) == -1){

			$("#error_size_".concat(field_id)).show().text("Please select file pdf type only");
			$("#".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){$("#error_size_".concat(field_id)).show().text(''); $("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}

		if (validExt != 1){

			$("#error_size_".concat(field_id)).show().text("Invalid file uploaded");
			$("#".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){$("#error_size_".concat(field_id)).show().text('');$("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}

		if(value_return == 'false'){
			return false;
		}else{
			exit();
		}

 	});

 });
 
  // Added by Shweta Apale on 01-09-2022
$(document).ready(function () {
	$('#btnSubmit').on('click', function () {
		//console.log('hi');
		$('#ajax_loader').show();

	});
});