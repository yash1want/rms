
$(document).ready(function(){

	var userRoleStatus = $('#user_role_status').val();
	var allowUserRoleOne = ['2','3'];
	var allowUserRoleTwo = ['8','9'];

	if($.inArray(userRoleStatus, allowUserRoleOne) !== -1){
		$("#authusermonstatics").removeClass("col-md-3");
		$("#authuserannstatics").removeClass("col-md-3");
		$("#enduserstatics ").removeClass("col-md-6");
		//$("#endusermonthlystatics ").removeClass("col-md-6");
		$("#authusermonstatics").addClass("col-md-4");
		$("#authuserannstatics").addClass("col-md-4");
		$("#enduserstatics ").addClass("col-md-4");	
		//$("#endusermonthlystatics ").addClass("col-md-12");
	}
	
	if($.inArray(userRoleStatus, allowUserRoleTwo) !== -1){
		$("#authusermonstatics").removeClass("col-md-3");
		$("#authuserannstatics").removeClass("col-md-3");
		$(".CommentboxDive ").removeClass("col-md-12");
		$("#enduserstatics").removeClass("col-md-6");
		$("#endusermonthlystatics ").removeClass("col-md-6");
		$("#enduserAnnualtatics").removeClass("col-md-6");

		$("#authusermonstatics").addClass("col-md-4");
		$("#authuserannstatics").addClass("col-md-4");
		$(".CommentboxDive").addClass("col-md-4");
		$("#enduserstatics").addClass("col-md-12");	
		$("#enduserAnnualtatics ").addClass("col-md-4");
		$("#endusermonthlystatics ").addClass("col-md-4");
	}

});