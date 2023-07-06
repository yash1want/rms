$(document).ready(function(){	
	$('#region_selection_in').hide();
	$('#myModal').ready(function(){
        $('#btn-msg-box').click();
    });
	
	$(".app-main").css("z-index","-1");
	$(".modal-dialog").css("box-shadow","none");

	$('#selected_user').on('change',function(){
		var selectedUser = $(this).val();
		if(selectedUser == '25'){
			var region_selection = $('#region_selection').val();
			if(region_selection == 1){
				$('#region_selection_in').show();
			}
		}else{
			$('#region_selection_in').hide();
		}
	});
});