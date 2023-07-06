 $(document).ready(function(){
 	$('.file_upload').on('change', function(){

 		var selected_file = $(this).val();
 		var field_id = $(this).attr('id');
		
		// To get allowed format for particular field start
		// Added by Shweta Apale on 24-01-2023
		var single_id = field_id.split('t');
		var field_val = $('#' + single_id[1]).val();
		var fileFormat = $('#format' + single_id[1]).val();
		// end
 		
		var ext_type_array = ["pdf","kmz"];
		var get_file_size = $('#'.concat(field_id))[0].files[0].size;
		var get_file_ext = selected_file.split(".");
		var validExt = get_file_ext.length-1;
		var value_return = 'true';
		
		var checkFormat = get_file_ext[1].toLowerCase(); // Added by Shweta Apale on 24-01-2023

		get_file_ext = get_file_ext[get_file_ext.length-1].toLowerCase();

		//Converted Mb to bytes on 20-09-2022 Shweta Apale
		if(get_file_size > 10485760){  // 5097152 5 Mb changed to 10 Mb 10485760 for 20971520 20 Mb
		//if(get_file_size > 5097152){ 
			$("#error_size_".concat(field_id)).show().text("Please select file below 10mb");
			$("#".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){ $("#error_size_".concat(field_id)).show().text(''); $("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}

		/* Commented by Shweta Apale on 24-01-2023
		if(ext_type_array.lastIndexOf(get_file_ext) == -1){

			$("#error_size_".concat(field_id)).show().text("Please select file pdf, kmz type only");
			$("#".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){$("#error_size_".concat(field_id)).show().text(''); $("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}*/
		
		// Added by Shweta Apale on 24-01-2023 
		// To check file format and restrict it
		if(fileFormat == 'pdf' && checkFormat != fileFormat){			
			$("#error_size_".concat(field_id)).show().text("Please select file pdf only");
			$("#".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){$("#error_size_".concat(field_id)).show().text(''); $("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}
				
		if(fileFormat == 'kmz' && checkFormat != fileFormat){
				$("#error_size_".concat(field_id)).show().text("Please select file kMZ only");
				$("#".concat(field_id)).addClass("is-invalid");
				$("#".concat(field_id)).click(function(){$("#error_size_".concat(field_id)).show().text(''); $("#".concat(field_id)).removeClass("is-invalid");});
				$('#'.concat(field_id)).val('');
				value_return = 'false';
			}
			
		if(fileFormat == 'both' && $.inArray(checkFormat,ext_type_array) === -1 || get_file_ext[1] == 'docx'){
		
			$("#error_size_".concat(field_id)).show().text("Please select PDF or KMZ file only");
			$("#".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){$("#error_size_".concat(field_id)).show().text(''); $("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		} 
		// End

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
			// exit();
			return true;
		}

 	});

 });
 
// Added by Shweta Apale on 02-09-2022
// $(document).ready(function () {
	// $('#btnSubmit').on('click', function () {
		//console.log('hi');
		// $('#ajax_loader').show();

	// });
// });

// Added by Shweta Apale on 30-01-2023
$(document).ready(function () {
	$('#btnSubmit').on('click', function () {		
		var rowLength = $("#plateTable >tbody >tr").length;		
		var valuerReturn = 'true';
		var count = 0;
		var ext_type_array = ["pdf","kmz"];
		
		for(var i = 1; i <= rowLength; i++){
			
			var uploadfile = $("#plateTable tbody tr:nth-child("+i+") td:nth-child(4)").find('input[type=file]').val(); // Selected filename for upload
								
			if(uploadfile != ''){
				
				var uploadFileExe = uploadfile.substr((uploadfile.lastIndexOf(".")+1)).toLowerCase();
				var uploadfileid = $("#plateTable tbody tr:nth-child("+i+") td:nth-child(4)").find('input[type=file]').attr('id');
				var hrefindex = uploadfileid.split('document')[1];
				var uploadedFileFormat = $("#format"+ hrefindex).val();			
				
			}else{
				
				var previewfile = $("#plateTable tbody tr:nth-child("+i+") td:nth-child(4)").find('a').attr('href'); // DB saved filename
				
				if(typeof previewfile !== 'undefined'){									
					var uploadFileExe = previewfile.substr((previewfile.lastIndexOf(".")+1)).toLowerCase();
					var hrefid = $("#plateTable tbody tr:nth-child("+i+") td:nth-child(4)").find('a').attr('id');
					var hrefindex = hrefid.split('preview')[1];
					var uploadedFileFormat = $("#format"+ hrefindex).val(); // DB saved file format					
				}
			
			}
			
			if(uploadedFileFormat == 'both' && $.inArray(uploadFileExe,ext_type_array) === -1){
							
				$("#error_size_".concat("document"+ hrefindex)).show().text("Please select correct file format");
				$("#".concat("document"+ hrefindex)).addClass("is-invalid");
				$("#".concat("document"+ hrefindex)).click(function(){$("#error_size_".concat("document"+ hrefindex)).show().text('');$("#".concat("document"+ hrefindex)).removeClass("is-invalid");});
				$('#'.concat("document"+ hrefindex)).val('');							
				valuerReturn = 'false';	
				
			}else  if(uploadFileExe != uploadedFileFormat && uploadedFileFormat != 'both'){
				$("#error_size_".concat("document"+ hrefindex)).show().text("Please select correct file format");
				$("#".concat("document"+ hrefindex)).addClass("is-invalid");
				$("#".concat("document"+ hrefindex)).click(function(){$("#error_size_".concat("document"+ hrefindex)).show().text('');$("#".concat("document"+ hrefindex)).removeClass("is-invalid");});
				$('#'.concat("document"+ hrefindex)).val('');							
				valuerReturn = 'false';				
			}				
		} 		
		
		if(valuerReturn == 'false'){
			return false;
		}else{
			$('#ajax_loader').show();
			return true;
		}		
	});
});


// Added by Shweta Apale on 30-01-2023
$(window).on("load", function(){
	var loginusertype = $('#loginusertype').val();
	var rowLength = $("#plateTable >tbody >tr").length;
	var count = 0;
	var ext_type_array = ["pdf","kmz"];
	
	//mmsuser-R/O mmsuser-Inspection Officer
	if(loginusertype == 'mmsuser-R/O' || loginusertype == 'mmsuser-Inspection Officer'){
		for(var i = 1; i <= rowLength; i++){			
			
			var previewfile = $("#plateTable tbody tr:nth-child("+i+") td:nth-child(4)").find('a').attr('href');
				
			if(typeof previewfile !== 'undefined'){				
				
				var uploadFileExe = previewfile.substr((previewfile.lastIndexOf(".")+1)).toLowerCase();
				var hrefid = $("#plateTable tbody tr:nth-child("+i+") td:nth-child(4)").find('a').attr('id');
				var hrefindex = hrefid.split('preview')[1];
				var uploadedFileFormat = $("#format"+ hrefindex).val(); // DB saved file format					
			}
			
			if(uploadedFileFormat == 'both' && $.inArray(uploadFileExe,ext_type_array) === -1){
				
				$("#error_size_".concat("document"+ hrefindex)).show().text("Please select correct file format");
				$("#".concat("document"+ hrefindex)).addClass("is-invalid");
				$("#".concat("document"+ hrefindex)).click(function(){$("#error_size_".concat("document"+ hrefindex)).show().text('');$("#".concat("document"+ hrefindex)).removeClass("is-invalid");});
				$('#'.concat("document"+ hrefindex)).val('');							
				valuerReturn = 'false';	
				
			}else if(uploadFileExe != uploadedFileFormat){
				$("#".concat("document"+ hrefindex)).addClass("is-invalid-ext");
				$("#".concat("document"+ hrefindex)).click(function(){$("#error_size_".concat("document"+ hrefindex)).show().text('');$("#".concat("document"+ hrefindex)).removeClass("is-invalid-ext");});
				$('#'.concat("document"+ hrefindex)).val('');							
				valuerReturn = 'false';				
			}	
		} 
		
		if(valuerReturn  == 'false'){
			alert('Note : Some uploaded file formats are not as per requirement, those file are marked in "Red" color');
		}		
	}		
});