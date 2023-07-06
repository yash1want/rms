/* Hide error msg after 5s*/
$(function() {
    setTimeout(function() { $(".errormsg").fadeOut(1500); }, 5000)    
})

/* change language dropdown */
$('#language-dd').on('click', function(){

	var changeLangUrl = $('#change_lang_url').val();

	$.ajax({
	    url: changeLangUrl,
		beforeSend: function (xhr){
			xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
		},
	    success: function (resp) {
	    	location.reload();
	    }
	});

});

$(document).ready(function(){

	/* javascript disable msg box */
	$('.reload_page_btn').on('click', function(){
		location.reload();
	});

	//tinyeditor 
	$arrayIDs = ['editor'];

	for (var i = 0; i < $arrayIDs.length; i++) {
		$txteditor =  $('#'+$arrayIDs[i]).length;
		if ($txteditor>0) {
			tinymce.init({
			  selector: 'textarea#'+$arrayIDs[i],
			  height: 350,
			  menubar: false,
			  quickbars_insert_toolbar: 'image table',
			  plugins: 'advlist lists fullscreen table paste wordcount image link autolink visualblocks quickbars media',
			  toolbar_mode: 'wrap',
			  image_advtab: true,
			   quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quicktable imageoptions',
			  toolbar: 'undo redo | fontselect | fontsizeselect | formatselect | ' +' | bullist numlist | outdent indent |  bold italic underline strikethrough forecolor backcolor '+
			  ' | alignleft aligncenter alignright alignjustify | ' +
			  'removeformat | '+' image media | table fullscreen  preview |',
			  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
			 	});
		}
	}

});