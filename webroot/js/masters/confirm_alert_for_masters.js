//for Commodity
$('.delete_commodity').click(function (e) { 

	if (confirm('Are You Sure Delete This Commodity !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Concentrate
$('.delete_concentrate').click(function (e) { 

	if (confirm('Are You Sure Delete This Concentrate !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Country
$('.delete_country').click(function (e) { 

	if (confirm('Are You Sure Delete This Country !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for District
$('.delete_district').click(function (e) { 

	if (confirm('Are You Sure Delete This District !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Zone
$('.delete_zone').click(function (e) { 

	if (confirm('Are You Sure Delete This Zone !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Explosive
$('.delete_explosive').click(function (e) { 

	if (confirm('Are You Sure Delete This Explosive !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Unit
$('.delete_unit').click(function (e) { 

	if (confirm('Are You Sure Delete This Unit !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Extra Mineral
$('.delete_extra_mineral').click(function (e) { 

	if (confirm('Are You Sure Delete This Extra Mineral !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Stone Type
$('.delete_stone_type').click(function (e) { 

	if (confirm('Are You Sure Delete This Stone Type !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Mine Code Generation
$('.delete_mine_code_generation').click(function (e) { 

	if (confirm('Are You Sure Delete This Mine Code !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Work Stoppage
$('.delete_work_stoppage').click(function (e) { 

	if (confirm('Are You Sure Delete This Work Stoppage !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Machinery
$('.delete_machinery').click(function (e) { 

	if (confirm('Are You Sure Delete This Machinery !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//Material
$('.delete_material').click(function (e) { 

	if (confirm('Are You Sure Delete This Material !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//MCP Deposit
$('.delete_mcp_deposit').click(function (e) { 

	if (confirm('Are You Sure Delete This MCP Deposit !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Metal
$('.delete_metal').click(function (e) { 

	if (confirm('Are You Sure Delete This Metal !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Mica Type
$('.delete_mica_type').click(function (e) { 

	if (confirm('Are You Sure Delete This  Mica Type !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Mine Catgory
$('.delete_mine_category').click(function (e) { 

	if (confirm('Are You Sure Delete This Mine Catgory !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Mine Grade
$('.delete_mineral_grade').click(function (e) { 

	if (confirm('Are You Sure Delete This Mine Grade !')) {
		////
	} else {
		return false;
		exit;
	}
	
});

//for Mineral Work
$('.delete_mineral_work').click(function (e) { 

	if (confirm('Are You Sure Delete This Mineral Work !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Mine type
$('.delete_mine_type').click(function (e) { 

	if (confirm('Are You Sure Delete This Mine type !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for product
$('.delete_product').click(function (e) { 

	if (confirm('Are You Sure Delete This Product !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for region
$('.delete_region').click(function (e) { 

	if (confirm('Are You Sure Delete This Region !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Rock
$('.delete_rock').click(function (e) { 

	if (confirm('Are You Sure Delete This Rock !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Rom 5 step
$('.delete_rom_step').click(function (e) { 

	if (confirm('Are You Sure Delete This Rom 5 step !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Smelter Step
$('.delete_smelter_step').click(function (e) { 

	if (confirm('Are You Sure Delete This Smelter Step !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for State
$('.delete_state').click(function (e) { 

	if (confirm('Are You Sure Delete This State !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Size Range
$('.delete_size_range').click(function (e) { 

	if (confirm('Are You Sure Delete This Size Range !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Grid
$('.delete_grid').click(function (e) { 

	if (confirm('Are You Sure Delete This Grid !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Finished Products
$('.delete_finished_product').click(function (e) { 

	if (confirm('Are You Sure Delete This Finished Products !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Sms email tempaltes - activate
$('.activate_template').click(function (e) { 

	if (confirm('Are You Sure Activate This Template !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


//for Sms email tempaltes - deactivate
$('.deactivate_template').click(function (e) { 

	if (confirm('Are You Sure Deactivate This Template !')) {
		////
	} else {
		return false;
		exit;
	}
	
});


$('#commoditytable').on('click','.edit_mine_code_details',function(e){
		
		e.preventDefault();	
		
	    var mine_code =  $(this).closest('tr').find('td:first').text();
		var url = $(this).attr('href');
		
		$.ajax({
			url: 'check-inprocess-mine-details',
			type: "POST",
			data: ({mine_code:mine_code}),
			beforeSend: function(xhr) {
				xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
			},
			success: function(resp) {
				if(resp == 1){					
					window.location.href = url;
				}else{
					alert('Can not modifed the mine code generation details, Because miningplan approval request against the mine code '+ mine_code +' is inprocess');
					return false;					
				}
			}
		});

		
})

$(window).on('load', function() {
	$('#report_model_id').trigger('click');
});