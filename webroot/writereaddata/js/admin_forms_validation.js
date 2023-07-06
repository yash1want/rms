
	//This function is used for add_user, edit_user & user_profile form validations(admin users)
	function add_user_validations(){

		var f_name=$("#f_name").val();
		var l_name=$("#l_name").val();
		var email=$("#email").val();
		var phone=$("#phone").val();
		var landline_phone=$("#landline_phone").val();
		var profile_pic=$("#profile_pic").val();//added on 06-05-2021 for profile pic
		var value_return = 'true';

		//split path to find controller and action
		var path = window.location.pathname;
		var paths = path.split("/");
		var controller = paths[2];
		var action = paths[3];

		if(f_name==""){

			$("#error_f_name").show().text("Please Enter First Name");
			$("#f_name").addClass("is-invalid");
			$("#f_name").click(function(){$("#error_f_name").hide().text;$("#f_name").removeClass("is-invalid");});
			value_return = 'false';

		}

		if(l_name==""){

			$("#error_l_name").show().text("Please Enter Last Name");
			$("#l_name").addClass("is-invalid");
			$("#l_name").click(function(){$("#error_l_name").hide().text;$("#l_name").removeClass("is-invalid");});
			value_return = 'false';

		}


		if(email==""){

			$("#error_email").show().text("Please Enter Email Address");
			$("#email").addClass("is-invalid");
			$("#email").click(function(){$("#error_email").hide().text;$("#email").removeClass("is-invalid");});
			value_return = 'false';

		}else{

			if(email.match(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/)){}else{

				$("#error_email").show().text("Please Enter Valid Email Address");
				$("#email").addClass("is-invalid");
				$("#email").click(function(){$("#error_email").hide().text;$("#email").removeClass("is-invalid");});
				value_return = 'false';
			}

		}

		/*if(once_card_no==""){

				$("#error_aadhar_card_no").show().text("Should not be blank, Only numbers allowed, max & min length is 12");
				$("#error_aadhar_card_no").css({"color":"red","font-size":"11px","font-weight":"500","text-align":"right"});
				$("#once_card_no").click(function(){$("#error_aadhar_card_no").hide().text;});

				value_return = 'false';

			}else{

				if(once_card_no.match(/^(?=.*[0-9])[0-9]{12}$/g) || once_card_no.match(/^[X-X]{8}[0-9]{4}$/i)){}else{//also allow if 8 X $ 4 nos found //added on 12-10-2017 by Amol

					$("#error_aadhar_card_no").show().text("Should not be blank, Only numbers allowed, max & min length is 12");
					$("#error_aadhar_card_no").css({"color":"red","font-size":"11px","font-weight":"500","text-align":"right"});
					$("#once_card_no").click(function(){$("#error_aadhar_card_no").hide().text;});

					value_return = 'false';
				}

			}
			*/

		if(phone==""){

			$("#error_phone").show().text("Should not be blank, Only numbers allowed, max & min length is 10");
			$("#phone").addClass("is-invalid");
			$("#phone").click(function(){$("#error_phone").hide().text;	$("#phone").removeClass("is-invalid");});

			value_return = 'false';

		}else{

			if(action == 'add_user'){

				if(phone.match(/^(?=.*[0-9])[0-9]{10}$/g)){}else{//also allow if 6 X $ 4 nos found //added on 12-10-2017 by Amol

					$("#error_phone").show().text("Should not be blank, Only numbers allowed, max & min length is 10");
					$("#phone").addClass("is-invalid");
					$("#phone").click(function(){$("#error_phone").hide().text;	$("#phone").removeClass("is-invalid");});
					value_return = 'false';
				}

				//first valid no. for mob.no, applid on 16-02-2021 by Amol
				var validfirstno = ['7','8','9'];
				//get first character of mobile no.
				var f_m_no = phone.charAt(0);
				if($.inArray(f_m_no,validfirstno) != -1){
					//valid
				}else{
					$("#error_phone").show().text("Invalid mobile number");
					$("#phone").addClass("is-invalid");
					$("#phone").click(function(){$("#error_phone").hide().text;	$("#phone").removeClass("is-invalid");});
					value_return='false';
				}
			}else{

				if(phone.match(/^(?=.*[0-9])[0-9]{10}$/g) || phone.match(/^[X-X]{6}[0-9]{4}$/i)){}else{//also allow if 6 X $ 4 nos found //added on 12-10-2017 by Amol

					$("#error_phone").show().text("Should not be blank, Only numbers allowed, max & min length is 10");
					$("#phone").addClass("is-invalid");
					$("#phone").click(function(){$("#error_phone").hide().text;	$("#phone").removeClass("is-invalid");});
					value_return = 'false';
				}

			}

		}


		if(landline_phone==""){

			// Comment on 21/11/2017 by pravin to avoid blank landline no restriction

			/*$("#error_landline_phone").show().text("Should not be blank, Only numbers allowed, max length is 12");
			$("#error_landline_phone").css({"color":"red","font-size":"11px","font-weight":"500","text-align":"right"});
			$("#landline_phone").click(function(){$("#error_landline_phone").hide().text;});

			value_return = 'false';*/

		}else{

			if(landline_phone.match(/^(?=.*[0-9])[0-9]{6,12}$/g)){}else{

				$("#error_landline_phone").show().text("Should not be blank, Only numbers allowed, max length is 12");
				$("#landline_phone").addClass("is-invalid");
				$("#landline_phone").click(function(){$("#error_landline_phone").hide().text;	$("#landline_phone").removeClass("is-invalid");});
				value_return = 'false';
			}
			//validate landline no, pattern, not to contain string '00000', on 18-02-2021 by Amol
			if(landline_phone.indexOf('00000') > -1){

				$("#error_landline_phone").show().text("Given phone no. is not valid");
				$("#landline_phone").addClass("is-invalid");
				$("#landline_phone").click(function(){$("#error_landline_phone").hide().text;	$("#landline_phone").removeClass("is-invalid");});
				value_return = 'false';
			}
		}

		//to validate lims role in LIMS selected
		if($('#division-lmis').is(":checked")){

			if($('#lmis_role').val()==''){

				$("#error_lmis_role").show().text("Mandatory to Select role if user belongs to LIMS");
				$("#lmis_role").addClass("is-invalid");
				$("#lmis_role").click(function(){$("#error_lmis_role").hide().text;	$("#lmis_role").removeClass("is-invalid");});
				value_return = 'false';
			}

		}
		//added on 10-08-2018 to validate lims role in BOTH with LIMS selected
		if($('#division-both').is(":checked") && $('#user_belongs_to-lmis').is(":checked")){

			if($('#lmis_role').val()==''){

				$("#error_lmis_role").show().text("Mandatory to Select role if user belongs to LIMS");
				$("#lmis_role").addClass("is-invalid");
				$("#lmis_role").click(function(){$("#error_lmis_role").hide().text;	$("#lmis_role").removeClass("is-invalid");});
				value_return = 'false';
			}

		}


		//this check is only first time add user
		if(action == 'add_user'){

			//commented on 11-04-2018 by Amol
			/*if($('#aadhar_auth_check').prop("checked") == false){

				$("#error_aadhar_auth_check").show().text("Please check to confirm Aadhar authentication");
				$("#aadhar_auth_check").addClass("is-invalid");
				$("#aadhar_auth_check").click(function(){$("#error_aadhar_auth_check").hide().text;	$("#aadhar_auth_check").removeClass("is-invalid");});
				value_return = 'false';
			}
			*/
		}

		//added on 06-05-2021 for profile pic
		//commented as it is not mandatory every time
		/*if(profile_pic==""){

			$("#error_profile_pic").show().text("Please select profile picture.");
			$("#profile_pic").addClass("is-invalid")
			$("#profile_pic").click(function(){$("#error_profile_pic").hide().text;	$("#profile_pic").removeClass("is-invalid");});
			value_return = 'false';
		}*/


		if(value_return == 'false'){
			var msg = "Please check some fields are missing or not proper.";
			renderToast('error', msg);
			return false;
		}else{
			exit();
		}

	}






	//File validation common function
	//This function is called on file upload browse button to validate selected file
	function file_browse_onclick(field_id){

		var selected_file = $('#'.concat(field_id)).val();
		var ext_type_array = ["jpg" , "pdf"];
		var get_file_size = $('#'.concat(field_id))[0].files[0].size;
		var get_file_ext = selected_file.split(".");
		var validExt = get_file_ext.length-1;
		var value_return = 'true';

		get_file_ext = get_file_ext[get_file_ext.length-1].toLowerCase();

		if(get_file_size > 2097152){

			$("#error_size_".concat(field_id)).show().text("Please select file below 2mb");
			$("#error_size_".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){$("#".concat(field_id)).hide().text;$("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}

		if(ext_type_array.lastIndexOf(get_file_ext) == -1){

			$("#error_type_".concat(field_id)).show().text("Please select file of jpg, pdf type only");
			$("#error_type_".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){$("#".concat(field_id)).hide().text;$("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}

		if (validExt != 1){

			$("#error_type_".concat(field_id)).show().text("Invalid file uploaded");
			$("#error_type_".concat(field_id)).addClass("is-invalid");
			$("#".concat(field_id)).click(function(){$("#".concat(field_id)).hide().text;$("#".concat(field_id)).removeClass("is-invalid");});
			$('#'.concat(field_id)).val('');
			value_return = 'false';
		}

		if(value_return == 'false'){
			return false;
		}else{
			exit();
		}

	}


	//this function is used for add page, edit page validations
	function add_edit_pages_validation(){

		var title = $('#title').val();
		var publish_date = $('#publish_date').val();
		var archive_date = $('#archive_date').val();
		var meta_keyword = $('#meta_keyword').val();
		var meta_description = $('#meta_description').val();
		
		//var english_content =tinyMCE.get('english_content').getContent().replace(/<[^>]*>/gi, '').length;
		
		var value_return = 'true';

		if(title == ''){

			$("#error_title").show().text("Please enter page title");
			$("#title").addClass("is-invalid");
			$("#title").click(function(){$("#error_title").hide().text;$("#title").removeClass("is-invalid");});
			value_return = 'false';
	 	}

	 	
		//this code applied by Pravin on 02-08-2017 before date comparision
		var from = $("#publish_date").val().split("/");
		var publish_date_match = new Date(from[2], from[1] - 1, from[0]);

		var from = $("#archive_date").val().split("/");
		var archive_date_match = new Date(from[2], from[1] - 1, from[0]);

		if(publish_date_match > archive_date_match){

			$("#error_archive_date").show().text("Archive date can not be less than Publish date");
			$("#archive_date").addClass("is-invalid");
			$("#archive_date").click(function(){$("#error_archive_date").hide().text;$("#archive_date").removeClass("is-invalid");});
			value_return = 'false';
		}

		if(publish_date == ''){

			$("#error_publish_date").show().text("Publish date can not be empty");
			$("#publish_date").addClass("is-invalid");
			$("#publish_date").click(function(){$("#error_publish_date").hide().text;$("#publish_date").removeClass("is-invalid");});
			value_return = 'false';

		}

		if(archive_date == ''){

			$("#error_archive_date").show().text("Archive date can not be empty");
			$("#archive_date").addClass("is-invalid");
			$("#archive_date").click(function(){$("#error_archive_date").hide().text;$("#archive_date").removeClass("is-invalid");});
			value_return = 'false';
		}

		if(meta_keyword == ''){

			$("#error_meta_keyword").show().text("Please enter page meta keyword");
			$("#meta_keyword").addClass("is-invalid");
			$("#meta_keyword").click(function(){$("#error_meta_keyword").hide().text;$("#meta_keyword").removeClass("is-invalid");});
			value_return = 'false';
		}

		if(meta_description == ''){

			$("#error_meta_description").show().text("Please enter page meta description");
			$("#meta_description").addClass("is-invalid");
			$("#meta_description").click(function(){$("#error_meta_description").hide().text;$("#meta_description").removeClass("is-invalid");});
			value_return = 'false';
		}

		if(value_return == 'false'){

			var msg = "Please Check Some Fields are Missing or not Proper.";
			renderToast('error', msg);
			return false;
		
		}else{

			//	exit();
		}

	}



	//this function is used for add menu, edit menu validations
	function add_edit_menus_validation(){

		var title = $('#title').val();
		var link_type = $('#link_type').val();
		var external_link = $('#external_link').val();
		var link_id = $('#link_id').val();
		var position = $('#position').val();
		var order_id = $('#order_id').val();

		var value_return = 'true';


		if(title == ''){

			$("#error_title").show().text("Please enter Menu name");
			$("#title").addClass("is-invalid");
			$("#title").click(function(){$("#error_title").hide().text;$("#title").removeClass("is-invalid");});
			value_return = 'false';
		}

		if(order_id == ''){

			$("#error_order").show().text("Please enter menu order no");
			$("#order_id").addClass("is-invalid");
			$("#order_id").click(function(){$("#error_order").hide().text;$("#order_id").removeClass("is-invalid");});
			value_return = 'false';
		}

		if(!$('#link_type-page').is(":checked") && !$('#link_type-external').is(":checked")){

			$("#error_link_type").show().text("Please check Menu type");
			$("#link_type-page").addClass("is-invalid");
			$("#link_type-page").click(function(){$("#error_link_type").hide().text;$("#link_type-page").removeClass("is-invalid");});
			value_return = 'false';

		}else{

			if($('#link_type-external').is(":checked")){

				if(external_link == ''){

					$("#error_external_link").show().text("Please enter external link");
                    $("#external_link").addClass("is-invalid");
                    $("#external_link").click(function(){$("#error_external_link").hide().text;$("#external_link").removeClass("is-invalid");});
					value_return = 'false';

				}
			}

			if($('#link_type-page').is(":checked")){

				if(link_id == ''){

					$("#error_link_id").show().text("Please select page from list");
                    $("#link_id").addClass("is-invalid");
                    $("#link_id").click(function(){$("#error_link_id").hide().text;$("#link_id").removeClass("is-invalid");});
					value_return = 'false';

				}
			}

		}

		if(!$('#position-top').is(":checked") && !$('#position-bottom').is(":checked")){

			$("#error_position").show().text("Please check menu position");
            $("#position-top").addClass("is-invalid");
            $("#position-top").click(function(){$("#error_position").hide().text;$("#position-top").removeClass("is-invalid");});
			value_return = 'false';
		}

		if(value_return == 'false'){
			var msg = "Please Check Some Fields are Missing or not Proper.";
			renderToast('error', msg);
			return false;
		}else{
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


	// DISPLAY FORM RELATED ALERTS/MESSAGES IN NEW TEMPLATE
	// By Aniket Ganvir dated 10th DEC 2020
	function renderToast(theme, msgTxt) {

		$('#toast-msg-'+theme).html(msgTxt);
		$('#toast-msg-box-'+theme).fadeIn('slow');
		$('#toast-msg-box-'+theme).delay(3000).fadeOut('slow');

	}


	$(document).ready(function() {

			$('.mod').fadeIn('slow');

			//$("#msgboxidcon").click(function(){
            $(document).on('click','#msgboxidcon',function (){

                console.log('hello');
					$('.mod').fadeOut('slow');
					var redirectto = $("#msgboxredi").val();

					setTimeout(function(){
						window.location = redirectto;
					}, 0000);

			});
	})
