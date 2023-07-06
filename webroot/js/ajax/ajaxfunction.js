
var ajaxfunction = {
	
	getMonthArr: function () {
		
		$('#f_year').change(function(){
			
			var year = $(this).val();
			
			$.ajax({				
					type:"POST",
					url:"../ajax/get-month-arr",
					data:{year:year},
					cache:false,
					
					beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
					success : function(response)
					{	
						$("#f_month").find('option').remove();
						$("#f_month").append(response);						
					}
			});			
		});	
	},
	
	getRegionArr: function () {
		
		$('#f_zone').change(function(){
			
			var zone = $(this).val();
			
			$.ajax({				
					type:"POST",
					url:"../ajax/get-regions-arr",
					data:{zone:zone},
					cache:false,
					
					beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
					success : function(response)
					{	
						$("#f_region").find('option').remove();
						$("#f_state").find('option').remove();
						$("#f_district").find('option').remove();
						$("#f_state").append("<option value=''>Select</option>");
						$("#f_district").append("<option value=''>Select</option>");
						$("#f_region").append(response);						
					}
			});			
		});	
	},
	
	getStatesArr: function () {
		
		$('#f_region').change(function(){
			
			var region = $(this).val();
			
			$.ajax({				
					type:"POST",
					url:"../ajax/get-states-arr",
					data:{region:region},
					cache:false,
					
					beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
					success : function(response)
					{	
						$("#f_state").find('option').remove();
						$("#f_district").find('option').remove();
						$("#f_district").append("<option value=''>Select</option>");
						$("#f_state").append(response);						
					}
			});			
		});	
	},
	
	
	getDistrictsArr: function () {
		
		$('#f_state').change(function(){
			
			var state = $(this).val();
			
			$.ajax({				
					type:"POST",
					url:"../ajax/get-districts-arr",
					data:{state:state},
					cache:false,
					
					beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
					success : function(response)
					{	
						$("#f_district").find('option').remove();
						$("#f_district").append(response);						
					}
			});			
		});	
	},


	getParentUsersArr: function () {
		
		var useraction = $('#useraction').val();
		var current_role_id  = $('#role_id').val();
		var usrid  = $('#usrid').val();
		
		
		$('#role_id').change(function(){
			
			var no_pending_work = 1;			
			var role_id = $(this).val();
			
			if(useraction == 'edit'){
				
				var p_roles = ['2','3','8','9','20'];
				$('.form_spinner').show('slow');


				// if($.inArray(current_role_id, p_roles) !== -1 ){

					$.ajax({				
						type:"POST",
						url:"../ajax/get-pending-work-status",
						data:{roleid:current_role_id,usrid:usrid},
						cache:false,
						
						beforeSend: function (xhr) { // Add this line
							xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
						},
						success : function(response)
						{	
							if(response.trim() == 'work_allocate'){
								
								// specify the allocated work roles, added on 06-10-2022 by Aniket 
								$.ajax({				
									type:"POST",
									url:"../ajax/get-pending-work-list",
									data:{roleid:current_role_id,usrid:usrid},
									cache:false,
									beforeSend: function (xhr) {
										xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
									},
									success: function(resp){
										$('.form_spinner').hide('slow');
										alert("Can't change the current role from user, Because following work are allocated: "+resp.trim()+" Please Reallocate the work to another user and then update the role.");
										$('#role_id').val(current_role_id);
										role_id = current_role_id;
										get_parent_array(role_id);
										
									}
			
								});
							}else{
								$('.form_spinner').hide('slow');
								no_pending_work = 0;
								$('#no_pending_work').val(no_pending_work);
								get_parent_array(role_id);

							}
							
						}
					});
				// }else{
				// 	no_pending_work = 0;
				// }

			}else if(useraction == 'add'){
				no_pending_work = 0;
			}

			//var no_pending_work = $('#no_pending_work').val();
			if(no_pending_work == 0){
				
				get_parent_array(role_id);
			}

		});	

	},

	getZoneRegionArr: function(){
		
		var roles = ['5','6'];	

		$('#parentinput').change(function(){

			var role_id = $('#role_id').val();

			var parentinput = $(this).val();

			if( $.inArray(role_id, roles) !== -1 ){	

				$.ajax({				
					type:"POST",
					url:"../ajax/get-zone-region-arr",
					data:{roleid:role_id,parentid:parentinput},
					cache:false,
					
					beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
					success : function(response)
					{	
						$("#zoneregionlabel").empty();
						if(role_id==5){
							$("#zoneregionlabel").append('Zone Name <span class="text-danger">*</span>');
						}else{
							$("#zoneregionlabel").append('Region Name <span class="text-danger">*</span>');
						}

						$("#zoneregionbox").show();	
						$("#zoneregionid").find('option').remove();
						$("#zoneregionid").append(response);						
					}
				});
			}	

		});
		
	},


	genLevel2UsrPass: function()
	{
		
		$('#level2user').on('click','tbody tr .genbtn', function(){
			
			var btntext = $(this).text().toLowerCase();
			var useremail = $(this).closest("tr").find('input[name="email"]').val();
			var userid = $(this).closest("tr").find('input[name="userid"]').val();
			var level2usrid = $(this).closest("tr").find('input[name="level2usrid"]').val();
			var level2type = $(this).closest("tr").find('input[name="level2type"]').val();

			$.ajax({
				type:"POST",
				url : "../ajax/gen-level3-user-pass",
				data : {	level2usrid:level2usrid,
					  		userid:userid,
							useremail:useremail,
							level2type:level2type},
				cache:false,

				beforeSend: function (xhr) { // Add this line
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				},

				success : function(response)
				{
					if(response == 1){
						alert('Password successfully '+btntext+'. Kindly check your email '+useremail+' for reset the password.');
						location.reload();	
						
					}else{
						
						alert(response.trim());
						location.reload();
					}
				}
			});
						
		});

	}

}


function get_parent_array(role_id){
	
	$("#zoneregionbox").hide();	
	var current_parent_id = $("#current_parent_id").val();
	
	var roles = ['2','3','5','6','8','9','10','20','21','22','25'];	

	if( $.inArray(role_id, roles) !== -1 ){

		$.ajax({				
			type:"POST",
			url:"../ajax/get-parentuser-arr",
			data:{roleid:role_id},
			cache:false,
			
			beforeSend: function (xhr) { // Add this line
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
			success : function(response)
			{	
				$("#parentbox").show();	
				$("#parentinput").find('option').remove();
				$("#parentinput").append(response);						
				if(role_id == 10){
					$("#parentlabel").html('State <span class="text-danger">*</span>');		
				}else{
					$("#parentlabel").html('Parent User <span class="text-danger">*</span>');
				}
				
				$("#parentinput").val(current_parent_id);
			}
		});

	}else{
		
		$("#parentinput").find('option').remove();
		$("#parentbox").hide();
	}
	
}