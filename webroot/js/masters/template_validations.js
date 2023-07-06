	
	$('.template_validations').click(function (e) { 

		if (sms_message_parameter_validation() == false) {
			e.preventDefault();
		} else { 
			edit_template.submit();
		}
	});
	
	// Validate parameters that are used in sms message, if it is in pre-defined parameter list. (Done By Pravin 09-03-2018)
	function sms_message_parameter_validation(){

		var sms_parameter_list = ['ack_number','registration_no','application_no','mine_code','month','year','app_id','ddo_user','sodo_user','state_user','io_user','ro_user','com_user']
		
		var sms_message = $('#sms_message').val();
		var total_occurrences = substr_count(sms_message,'%%');
		var parameter_not_inarray = '';

		while (total_occurrences > 0) {

			var matches = sms_message.split("%%");

			if(matches[1]){

				var result = inArray(matches[1], sms_parameter_list);

				if(result == false){
					var parameter_not_inarray = parameter_not_inarray + '%%'+matches[1]+'%%' +', ';
				}
				var replace_value = '%%'+matches[1]+'%%';
				var sms_message = sms_message.replace(replace_value, matches[1]);
				var total_occurrences = substr_count(sms_message,'%%');

			}
		}

		if(parameter_not_inarray){

			$("#error_sms_message").show().text("The parameter "+parameter_not_inarray+" is/are not defined. You can only use the pre-defined parameters.");
			$("#sms_message").addClass("is-invalid");
			$("#sms_message").click(function(){$("#error_sms_message").hide().text;$("#sms_message").removeClass("is-invalid");});
			return false;

		} else { 
			exit(); 
		}

	}



	//SubString Count Method
	function substr_count(string,substring,start,length){

		var c = 0;
		if(start) {
			string = string.substr(start);
		}

		if(length) {
			string = string.substr(0,length);
		}

		for(var i=0;i<string.length;i++){

			if(substring == string.substr(i,substring.length))
			c++;
		}

		return c;
	}


	function inArray(str_value, str_array) {

		var length = str_array.length;

		for(var i = 0; i < length; i++) {

			if(str_array[i] == str_value) return true;
		}

		return false;
	}