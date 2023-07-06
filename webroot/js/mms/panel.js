
var tableFormD = document.getElementById('table_form_data').value;
var tableFormData = (tableFormD != '') ? JSON.parse(tableFormD) : Array();

// custom_validations.init();

$(document).ready(function(){
	
	/**
	 * Show loader on AJAX execution
	 * @version 18th Nov 2021
	 * @author Aniket Ganvir
	 */
	$(document).ajaxStart(function() {
		$('.form_spinner').show('slow');
	});

	$(document).ajaxStop(function() {
		$('.form_spinner').hide('slow');
	});

	// Bootstrap tooltip initialization
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    /* OPEN RETURNS IN VIEW MODE AS PER "section_mode" STATUS */

	var sectionMode = $('#section_mode').val();
	
	if(sectionMode == 'view'){
		$('.monthly-return-form input').attr('disabled','disabled');
		$('.monthly-return-form select').attr('disabled','disabled');
		$('.monthly-return-form textarea').attr('disabled','disabled');
		$('.monthly-return-form #next1').hide();
		$('.monthly-return-form button').hide();
		$('.monthly-return-form .btn-rem').hide();
		$('.monthly-return-form .tbl_rem_btn').hide();
		$('.monthly-return-form #add_more_btn_particular').hide();
		$('.table').not('.table-bordered').addClass('table-bordered');

		$('#table_container').ready(function(){
			$('.monthly-return-form input').attr('disabled','disabled');
			$('.monthly-return-form select').attr('disabled','disabled');
			$('.monthly-return-form textarea').attr('disabled','disabled');
		});
	}

});
