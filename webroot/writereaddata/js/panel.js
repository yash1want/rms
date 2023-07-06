
$(document).ready(function() {

	// right click disabled - Aniket G [24-11-2022][c]
	$(document).bind("contextmenu", function(e) {
        e.preventDefault();
    });
    
    var tableThLength = $(".leaselist thead tr th").length;
	
	if(tableThLength == 3){
		$(".leaselist").DataTable({"aoColumns": [null,{ "sType": "date-uk" },null],"pageLength": 5});
	}else if(tableThLength == 4){
		$(".leaselist").DataTable({"aoColumns": [null,null,{ "sType": "date-uk" },null],"pageLength": 5});
	}else if(tableThLength == 5){
		$(".leaselist").DataTable({"aoColumns": [null,null,null,{ "sType": "date-uk" },null],"pageLength": 5});
    }else if(tableThLength == 6){
		$(".leaselist").DataTable({"aoColumns": [null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 5});
	}else if(tableThLength == 7){
		$(".leaselist").DataTable({"aoColumns": [null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 5});
	}else if(tableThLength == 8){
		$(".leaselist").DataTable({"aoColumns": [null,null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 5});
	}else if(tableThLength == 9){
		$(".leaselist").DataTable({"aoColumns": [null,null,null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 5});
	}else if(tableThLength == 10){
		$(".leaselist").DataTable({"aoColumns": [null,null,null,null,null,null,null,{ "sType": "date-uk" },{ "sType": "date-uk" },null],"pageLength": 5});
	}else if(tableThLength == 11){
		$(".leaselist").DataTable({"aoColumns": [null,null,null,null,null,null,null,null,{ "sType": "date-uk" },{ "sType": "date-uk" },null],"pageLength": 5});
	} else if(tableThLength == 12){
		$(".leaselist").DataTable({"aoColumns": [null,null,null,null,null,null,null,null,null,null,{ "sType": "date-uk" },{ "sType": "date-uk" },null],"pageLength": 5});
	}
	
	
    var paylistThLen = $("#paylist thead tr th").length;
	if(paylistThLen == 7){
		$('#paylist').DataTable({"aoColumns": [null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 5});
	}else if(paylistThLen == 8){
		$('#paylist').DataTable({"aoColumns": [null,null,null,null,null,{ "sType": "date-uk" },null,null],"pageLength": 5});

	}
	$('#inlist').DataTable({"aoColumns": [null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 10});
	
	//$('#list').DataTable({}); Commented by Shweta Apale on 02-02-2023
	checkModal();
	
	// Added by Shweta Apale on 02-02-2023 start
	var tableThLengthList = $("#list thead tr th").length
	
	if(tableThLengthList == 3){
		$("#list").DataTable({"aoColumns": [null,{ "sType": "date-uk" },null],"pageLength": 10});
	}else if(tableThLengthList == 4){
		$("#list").DataTable({"aoColumns": [null,null,{ "sType": "date-uk" },null],"pageLength": 10});
	}else if(tableThLengthList == 5){
		$("#list").DataTable({"aoColumns": [null,null,null,{ "sType": "date-uk" },null],"pageLength": 10});
    }else if(tableThLengthList == 6){
		$("#list").DataTable({"aoColumns": [null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 10});
	}/*else if(tableThLengthList == 6){
		$("#list").DataTable({"aoColumns": [null,null,{ "sType": "date-uk" },{ "sType": "date-uk" },null,null],"pageLength": 10});
	}*/else if(tableThLengthList == 7){
		$("#list").DataTable({"aoColumns": [null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 10});
	}else if(tableThLengthList == 8){
		$(".#list").DataTable({"aoColumns": [null,null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 10});
	}else if(tableThLengthList == 9){
		$("#list").DataTable({"aoColumns": [null,null,null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 10});
	}else if(tableThLengthList == 10){
		$("#list").DataTable({"aoColumns": [null,null,null,null,null,null,null,null,{ "sType": "date-uk" },null],"pageLength": 10});
	}else if(tableThLengthList == 11){
		$("#list").DataTable({"aoColumns": [null,null,null,null,null,null,null,null,{ "sType": "date-uk" },{ "sType": "date-uk" },null],"pageLength": 10});
	} else if(tableThLengthList == 12){
		$("#list").DataTable({"aoColumns": [null,null,null,null,null,null,null,null,null,{ "sType": "date-uk" },{ "sType": "date-uk" },null],"pageLength": 10});
	}
	// End

	var pbCount = $('.u_pb_menu li').length;
	var i;
	var avgLen = 100 / pbCount;
	// var activeMenuLen = avgLen + (pbCount - 1);
	var activeMenuLen = avgLen + pbCount;
	// var normalMenuLen = avgLen - 1;
	var normalMenuLen = avgLen;

	for(i = 1; i <= pbCount; i++){
	
        $('.u_pb_menu li:nth-child('+i+')').css('width', normalMenuLen+'%');
		
	}

	// $('.u_progress_bar').hover(function(){
	// 	$(this).parent().css('width', activeMenuLen+'%');
	// }, function(){
	// 	$(this).parent().css('width', normalMenuLen+'%');
	// });

    //$('[data-toggle="tooltip"]').tooltip();
  
    $('input[id^="input_no_"]').on("click",function(){
		var id= $(this).attr('data-value');
		$('#document'+id).hide();
		$('#showText'+id).hide();
		$('#preview'+id).hide();
	});
	$('input[id^="input_yes_"]').on("click",function(){
		var id= $(this).attr('data-value');
		$('#document'+id).show();
		$('#showText'+id).show();
		$('#showText'+id).removeClass('d-none');
		$('#preview'+id).show();
	});
	
	
	
	// update user role in multiple role module, pravin bhakare 07-06-2022
	$('.dashboard_select').on("click",function(){
		
		var user_role = $(this).attr('id');
		
		$.ajax({				
				type:"POST",
				url:"../ajax/change-dashboard",
				data:{user_role:user_role},
				cache:false,
				
				beforeSend: function (xhr) { // Add this line
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				},
				success : function(response)
				{	
					window.location.href = "../mms/home";		
				}
		});	
		
	});
	

});

function checkModal() {

	if ($('#msg_box_only_btn').length > 0) {
		$('#msg_box_only_btn').trigger('click');
	}

}


jQuery.extend( jQuery.fn.dataTableExt.oSort, {
"date-uk-pre": function ( a ) {
    var ukDatea = a.split('/');
    return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
},

"date-uk-asc": function ( a, b ) {
    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
},

"date-uk-desc": function ( a, b ) {
    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
}
} );


// Added by Shweta Apale on 14-10-2022
$(document).ready(function () {
    $('#referred_back_final_submit').on('click', function (event) {
		//event.preventDefault();

		var userRole = $('#user_role').val();
		if(userRole == 6){
			var rv = 'true'; 
			var webroot_url = $('#webroot_url').val()+'ajax/get-finanical-section-array';
			
			$.ajax({
				url: webroot_url,
				async: false,
				beforeSend: function (xhr) {
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				},
				success: function (resp) {
					var result = JSON.parse(resp);
					if ((result[0] == 0 || result[0] == result[4]) && result[3] == 0) {                    
					rv = 'true';
					} else if ((result[0] == 0 || result[0] == result[4]) && result[3] == 1) {                    
						rv = 'true';
					} else {
						var msg = 'The referred back sections of "Financial Assurance Chapter" ' + result[1].slice(0, -2) + ' are interlinked with ' + result[2].slice(0, -2) + ' sections. So please refer back the sections ' + result[2].slice(0, -2) + '.';
						alert(msg);
						
						rv = 'false';
					}
				}
			});
			
			if(rv == 'false'){
				return false;
			}else{
				return true;
			}        
		}        
    });
});