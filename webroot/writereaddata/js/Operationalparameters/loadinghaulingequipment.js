 $(document).ready(function(){
 	$('#form_id').ready(function() {
 		//appendInput(1);
 		showSelectedValue();
    });
 	
 	$('#form_id').on('click', '#add_more', function(){
 		var currentRow = $('#table_1 .table_body tr:last').attr('id');
		var tblIdArr = currentRow.split('-');
		var tblIdNum =  parseInt(tblIdArr[1]) + parseInt(1);
		setTimeout(function() {
			appendInput(tblIdNum);
		}, 100);
 	});

 	function appendInput(id) 
 	{
 		var field_id = $('.hau_type').attr('id');
 		var _field_id = field_id.split('-');
 		$('#'+_field_id[0]+'-'+_field_id[1]+'-'+id).parent().append('<input type="text" name="other_reason[]" id="other_reason-'+id+'" class="form-control input-field cvOn cvAlphaNum cvNotReq d-none" placeholder="Please enter other type"/>');
 	}

 	$('#form_id').on('change', '.hau_type', function(){
 		var id = $(this).attr('id');
	    showInput(id);
 	});
 	function showInput(typeid)
	{
		var fieldVal = $('#'+typeid).val();
		var field_id = typeid.split('-');

		if(fieldVal == 100)
		{
			$('#other_reason-'+field_id[2]).removeClass('d-none');
		}else{
			$('#other_reason-'+field_id[2]).parent().parent().find('.err_cv').text('');
			$('#other_reason-'+field_id[2]).addClass('d-none');
		}
	}
	function showSelectedValue()
	{
		var  huatype = document.getElementsByName("hua_other_type[]");
		for (var i = 0; i < huatype.length; i++) {
			var field_id = parseInt(i)+parseInt(1);
			appendInput(field_id);
			var type = $('#other_reason-'+field_id).parent().find('select').val();
			if(huatype[i].value != '' || type == 100)
			{
				$('#other_reason-'+field_id).removeClass('d-none');
				$('#other_reason-'+field_id).val(huatype[i].value);
			}
		}
	}
});