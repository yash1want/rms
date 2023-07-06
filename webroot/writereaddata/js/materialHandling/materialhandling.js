$(document).ready(function(){
	
	$("select").each(function() {
		var S_elementId = $(this).attr('name');
		  if($(this).val() == 2)
		  {
		  	$('#'+S_elementId+'-file').hide();
		  }
	});

	$('#form_id').on('change', '.fileShow', function(){
 		var id = $(this).attr('name');
 		var elementValue = $(this).val();
	    ShowhideUploaodField(id,elementValue);
 	});

 	function ShowhideUploaodField(elementId,elementValue)
 	{
 		if(elementValue=='1'){
 			$('#'+elementId+'-file').show();
 		}
 		else if(elementValue=='2')
 		{ 
 			$('#'+elementId+'-file').hide(); 
 		}
 	}

});