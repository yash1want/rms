$(document).ready(function() {

    $("#zoneSelect").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-zone-regions-array',
            type: "POST",
            data: ({
                zone: changedValue
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#regionSelect').find('option').remove();
				$('#stateSelects').find('option').remove();	
				$('#districtSelects').find('option').remove();
				
                var mySelect = $('#regionSelect');
                mySelect.append(resp);
				mySelect.append("<option value=''>Select All</option>");
            }
        });
    });

    $("#regionSelect").change(function() {
        var changedValue = $(this).val();
		var zoneValue = $("#zoneSelect").val(); 
        $.ajax({
            url: '../ajax/get-districts-region-array',
            type: "POST",
            data: ({
                region_name: changedValue,
				zone: zoneValue
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#stateSelects').find('option').remove();
				$('#districtSelects').find('option').remove();
				
                var mySelect = $('#stateSelects');
                mySelect.append(resp);
				mySelect.append("<option value=''>Select All</option>");
            }
        });
    });

    $("#districtSelect").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-states-by-district-array',
            type: "POST",
            data: ({
                district_code: changedValue
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#stateSelects')
                    .find('option')
                    .remove();
                var mySelect = $('#stateSelects');
                mySelect.append(resp);
            }
        });
    });

    $("#stateSelects").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-districts-array',
            type: "POST",
            data: ({
                state: changedValue
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#districtSelects')
                    .find('option')
                    .remove();
                var mySelect = $('#districtSelects');
                mySelect.append(resp);
				mySelect.append("<option value=''>Select All</option>");
            }
        });
    });

    $("#stateSelectsMultiple").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-single-districts-array',
            type: "POST",
            data: ({
                state: changedValue
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#districtSingleSelects')
                    .find('option')
                    .remove();
                var mySelect = $('#districtSingleSelects');
                mySelect.append(resp);
            }
        });
    });

    $("#districtSingleSelects").change(function() {
        var changedValue = $(this).val();
        var changedValueState = $('#stateSelectsMultiple').val();
        $.ajax({
            url: '../ajax/get-ibm-by-state-district-array',
            type: "POST",
            data: ({
                district: changedValue,
                state: changedValueState
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#ibmSelect')
                    .find('option')
                    .remove();
                var mySelect = $('#ibmSelect');
                mySelect.append(resp);
				
				get_registration_no_a14();
            }
        });
    });

    //$("#ibmSelect").change(function() {
	function get_registration_no_a14(){	
        //var changedValue = $(this).val();
        var changedValueState = $('#stateSelectsMultiple').val();
        var changedValueDistrict = $('#districtSingleSelects').val();
        $.ajax({
            url: '../ajax/get-company-by-state-district-ibm-array',
            type: "POST",
            data: ({
                //ibm: changedValue,
                state: changedValueState,
                district: changedValueDistrict
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#companySelect')
                    .find('option')
                    .remove();
                var mySelect = $('#companySelect');
                mySelect.append(resp);
				
				get_companyname_a14();
            }
        });
	}	
    //});

    //$("#companySelect").change(function() {
	function get_companyname_a14(){ 	
	
       // var changedValue = $(this).val();
        var changedValueState = $('#stateSelectsMultiple').val();
        var changedValueDistrict = $('#districtSingleSelects').val();
       // var changedValueIbm = $('#ibmSelect').val();
        $.ajax({
            url: '../ajax/get-plant-by-state-district-ibm-company-array',
            type: "POST",
            data: ({
               // company: changedValue,
                state: changedValueState,
                district: changedValueDistrict,
               // ibm: changedValueIbm
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('.plantSelect')
                    .find('option')
                    .remove();
                var mySelect = $('.plantSelect');
                mySelect.append(resp);
            }
        });
	}	
   // });

    $("#stateSelectPlant").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-plant-by-state-array',
            type: "POST",
            data: ({
                state: changedValue
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#plantSelect')
                    .find('option')
                    .remove();
                var mySelect = $('#plantSelect');
                mySelect.append(resp);
            }
        });
    });

    $("#industriesSelect").change(function() {
        var changedValue = $(this).val();
        var changedValueState = $('#stateSelectPlant').val();
        $.ajax({
            url: '../ajax/get-plant-by-state-industry-array',
            type: "POST",
            data: ({
                industryy: changedValue,
                state: changedValueState,
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('.plantIndustrySelect')
                    .find('option')
                    .remove();
                var mySelect = $('.plantIndustrySelect');
                mySelect.append(resp);
            }
        });
    });

    $("#annualFilter").click(function(event) {
		
        
        var returnType = document.getElementById('returnType').value;
		var reportno = document.getElementById('reportno').value;
        
		
        if (returnType == 'ANNUAL') {
				
			if(reportno == 'A15'){
							
				var fd2 = document.getElementById("from_year_15").value;
				var td2 = document.getElementById("to_year_15").value;
				
		        if(fd2 != '' && td2 != ''){
					
					var year = td2 - fd2; //Difference between years
					
					if( year < 0 ){
						
						alert("Form date not greather than To date");
						document.getElementById("from_year_15").value = '';
						document.getElementById("to_year_15").value = '';
						
					}else if (year > 9) {
						
						alert("Selected date range should be less than 10 Year");
						document.getElementById("from_year_15").value = '';
						document.getElementById("to_year_15").value = '';
					}
				}
				
			}else{	
			
				var fd2 = document.getElementById("from_year").value;
				var td2 = document.getElementById("to_year").value;
				
				
				if(fd2 != '' && td2 != ''){
					
					var year = td2 - fd2; //Difference between years
					
					if( year < 0 ){
						
						alert("Form date not greather than To date");
						document.getElementById("from_year_15").value = '';
						document.getElementById("to_year_15").value = '';
						
					}else if (year > 1) {
						alert("Selected date range should be less than 1 Year");
						document.getElementById("from_year_15").value = '';
						document.getElementById("to_year_15").value = '';
					}
				}
			}
		}
    });

    $("#regionIbmSelect").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-ibm-reg-region-array',
            type: "POST",
            data: ({
                region_name: changedValue
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#ibmSelect')
                    .find('option')
                    .remove();
                var mySelect = $('#ibmSelect');
                mySelect.append(resp);
            }
        });
    });

    $("#industrySelect").change(function() {
        var changedValue = $(this).val();
        var changedValueRegion = $('#regionIbmSelect').val();
        $.ajax({
            url: '../ajax/get-ibm-reg-industry-array',
            type: "POST",
            data: ({
                industry: changedValue,
                region_name: changedValueRegion,
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('.ibmSelectIndustry')
                    .find('option')
                    .remove();
                var mySelect = $('.ibmSelectIndustry');
                mySelect.append(resp);
            }
        });
    });

    $("#stateIbmSelect").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-ibm-reg-state-array',
            type: "POST",
            data: ({
                state_name: changedValue
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#ibmSelect')
                    .find('option')
                    .remove();
                var mySelect = $('#ibmSelect');
                mySelect.append(resp);
            }
        });
    });

    $("#industrySelectState").change(function() {
        var changedValue = $(this).val();
        var changedValueRegion = $('#stateIbmSelect').val();
        $.ajax({
            url: '../ajax/get-ibm-reg-industry-state-array',
            type: "POST",
            data: ({
                industry: changedValue,
                state_name: changedValueRegion,
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('.ibmSelectIndustry')
                    .find('option')
                    .remove();
                var mySelect = $('.ibmSelectIndustry');
                mySelect.append(resp);
            }
        });
    });



    $("#ibmSelectIndustry").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-industry-by-ibm-array',
            type: "POST",
            data: ({
                ibm: changedValue,
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#industriesSelectedIbm')
                    .find('option')
                    .remove();
                var mySelect = $('#industriesSelectedIbm');
                mySelect.append(resp);
            }
        });
    });

    $("#industriesSelectedIbm").change(function() {
        var changedValue = $(this).val();
        var changedValueIbm = $('#ibmSelectIndustry').val();

        $.ajax({
            url: '../ajax/get-plant-by-industry-ibm-array',
            type: "POST",
            data: ({
                indust: changedValue,
                ibm: changedValueIbm,
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#plantIndustryIbmSelect')
                    .find('option')
                    .remove();
                var mySelect = $('#plantIndustryIbmSelect');
                mySelect.append(resp);
            }
        });
    });


    $("#plantSelect").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-supplier-by-plant-array',
            type: "POST",
            data: ({
                plant: changedValue,
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#supplierSelect')
                    .find('option')
                    .remove();
                var mySelect = $('#supplierSelect');
                mySelect.append(resp);
            }
        });
    });

    $(".fromMonth").change(function() {
        var changedValue = $(this).val();
        var changedYear = $('.year').val();

        $.ajax({
            url: '../ajax/get-to-month-by-from-month-array',
            type: "POST",
            data: ({
                from_month: changedValue,
                from_year: changedYear,
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('.toMonth')
                    .find('option')
                    .remove();
                var mySelect = $('.toMonth');
                mySelect.append(resp);
            }
        });
    });

    $("#industrySelectedIbm").change(function() {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-ibm-by-industry-array',
            type: "POST",
            data: ({
                industry: changedValue,
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#getIndustryIbm')
                    .find('option')
                    .remove();
                var mySelect = $('#getIndustryIbm');
                mySelect.append(resp);
            }
        });
    });

    $("#getIndustryIbm").change(function() {
        var changedValue = $(this).val();
        var changedValueIndustry = $('#industrySelectedIbm').val();
        $.ajax({
            url: '../ajax/get-plant-by-industry-ibms-array',
            type: "POST",
            data: ({
                ibm: changedValue,
                industry: changedValueIndustry
            }),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp) {
                $('#plantIndustryIbmSelect')
                    .find('option')
                    .remove();
                var mySelect = $('#plantIndustryIbmSelect');
                mySelect.append(resp);
            }
        });
    });
});