 $(document).ready(function(){

 	
 	setTimeout(function() {
	    $('.hau_type').on('change', function() {
	        var id = $(this).attr('id');
	    	showInput(id);
	    });
 	}, 100);

});
function showInput(typeid)
{
	var fieldVal = $('#'+typeid).val();
	var field_id = typeid.split('-');
	if(fieldVal == 12)
	{
		$('#'+typeid).parent().append('<input type="text" name="other_reason[]" id="other_reason-'+field_id[2]+'" class="form-control input-field cvOn cvAlphaNum cvNotReq " placeholder=""/>');
	}else{
		$('#other_reason-'+field_id[2]).parent().parent().find('.err_cv').text('');
		$('#other_reason-'+field_id[2]).remove();
	}
}