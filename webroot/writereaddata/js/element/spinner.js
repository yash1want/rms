$(window).on('load', function () {
	$('.form_spinner').hide('slow');
});

$(document).ready(function(){

	// Show loader on AJAX execution
	$(document).ajaxStart(function() {
		$('.form_spinner').show('slow');
	});

	$(document).ajaxStop(function() {
		$('.form_spinner').hide('slow');
	});
    
	// Sidebar menu link redirection
	$('.leveltwo ul li a').on('click', function () {
		$('.form_spinner').show('slow');
	});

	// For 'Previous', 'Home' and 'Next' action button
	$(document).on('click', '.spinner_btn_nxt', function () {
		$('.form_spinner').show('slow');
	});

});