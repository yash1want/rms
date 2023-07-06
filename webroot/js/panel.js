
$(document).ready(function () {
	
	// Added on 20-10-2022 start
	var tableThLength = $(".return_list_table thead tr th").length

	if (tableThLength == 6) { //aoColumns indexing starts from 0
		$(".return_list_table").DataTable({ "aoColumns": [null, null, null, null, null, { "sType": "date-uk" }], "pageLength": 10 });
	} else if (tableThLength == 8) {
		$(".return_list_table").DataTable({ "aoColumns": [null, null, null, null, null, { "sType": "date-uk" }, null, { "sType": "date-uk" }], "pageLength": 10 });
	} else if (tableThLength == 9) {
		$(".return_list_table").DataTable({ "aoColumns": [null, null, null, null, null, null, { "sType": "date-uk" }, null, { "sType": "date-uk" }], "pageLength": 10 });
	}
	// End

	$('#list').DataTable();
	$('#frmDeductionsDetails').addClass('w-75 m-auto');

	/**
	 * HIGHLIGHT FORM LEFT SIDEBAR MAIN MENU SECTION IF ALL SUBMENUS ARE FILLED
	 * @version 01-04-2021
	 * @author Aniket Ganvir
	 */

	for (var i = 1; i <= 15; i++) {

		if ($('.menu_sec_' + i).length > 0) {

			var secCount = $('.menu_sec_' + i).parent().find('ul li').length;
			var classCount = $('.menu_sec_' + i).parent().find('ul li .u_menu_success').length;
			var pendingCount = $('.menu_sec_' + i).parent().find('ul li .u_menu_pending').length;
			if (secCount == classCount) {
				$('.menu_sec_' + i).addClass('main_menu_success');
				$('.pb_menu_sec_' + i).addClass('u_pb_success');
			} else if (pendingCount > 0) {
				$('.menu_sec_' + i).addClass('main_menu_pending');
				$('.pb_menu_sec_' + i).addClass('u_pb_pending');
			} else {
				$('.menu_sec_' + i).addClass('main_menu_error');
				$('.pb_menu_sec_' + i).addClass('u_pb_error');
			}

		}

	}

	/* printall button */
	$('#print_all_btn').on('click', function () {
		var l_val = $(this).val();
		window.open(l_val, '_blank');
	});

	/* statistics count swing effect */
	$('.count-text').each(function () {
		$(this).prop('Counter', 0).animate({
			Counter: $(this).text()
		}, {
			duration: 2000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});

	/* progress bar highlight */

	var pbCount = $('.u_pb_menu li').length;
	var i;
	var avgLen = 100 / pbCount;
	var activeMenuLen = avgLen + (pbCount - 1);
	var normalMenuLen = avgLen - 1;
	for (i = 1; i <= pbCount; i++) {

		if ($('.u_pb_menu li:nth-child(' + i + ') a').hasClass('u_progress_bar_active')) {
			$('.u_pb_menu li:nth-child(' + i + ')').css('width', activeMenuLen + '%');
		} else {
			$('.u_pb_menu li:nth-child(' + i + ')').css('width', normalMenuLen + '%');
		}

	}

	$('.u_progress_bar').hover(function () {
		$(this).parent().css('width', activeMenuLen + '%');
		$('.u_progress_bar_active').parent().css('width', normalMenuLen + '%');
		//$('.u_pg_bar_active').addClass('u_progress_bar_menu');
	}, function () {
		$(this).parent().css('width', normalMenuLen + '%');
		$('.u_progress_bar_active').parent().css('width', activeMenuLen + '%');
	});


});

// Added on 20-10-2022 start
jQuery.extend(jQuery.fn.dataTableExt.oSort, {
	"date-uk-pre": function (a) {
		var ukDatea = a.split('/');
		return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
	},

	"date-uk-asc": function (a, b) {
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	},

	"date-uk-desc": function (a, b) {
		return ((a < b) ? 1 : ((a > b) ? -1 : 0));
	}
});
// End

// element > return_list
if ($('.return_list_table').length) {
	$('.return_list_table').DataTable();
}

// monthly > rejected_returns
$(document).ready(function () {
	if ($('.rejected-return-table').length) {
		$('#rejected-return-table').DataTable();
	}
});

/**
 * Spinner hide/show on form redirection and on load
 * @version 17th Nov 2021
 * @author Aniket Ganvir
 */
$(window).on('load', function () {

	$('.form_spinner').hide('slow');

});

$(document).ready(function () {

	// Sidebar menu link redirection
	$('.mm-collapse li:not(:has(a[href="#"]))').on('click', function () {
		$('.form_spinner').show('slow');
	});

	// For 'Previous', 'Home' and 'Next' action button
	$(document).on('click', '.spinner_btn_nxt', function () {
		$('.form_spinner').show('slow');
	});

	// Modal continue button
	$('#modal-cont-btn').on('click', function () {
		$('.form_spinner').show('slow');
	});

	// Dashboard panel return alert / messages modal
	$('#msg_box_only_btn').trigger('click');

	// Dashboard panel return alert / messages modal
	$('#login-modal-btn-msg-box').trigger('click');

	/* message modal box */
	$('.msg_box_modal').ready(function () {
		$('#login-modal-btn-msg-box').click();
		$('.login-modal-btn').on('click', function () {
			var alrtRedirectUrl = $('#alrt_redirect_url').val();
			location.href = alrtRedirectUrl;
		});
	});

	// $('.spinner_btn').on('click', function() {
	// 	$('.form_spinner').show('slow');
	// });

	// $("body").on('DOMSubtreeModified', "#alrt-div", function() {
	// 	console.log('changed');
	// });

	// $('#alrt-div').on('documentchanged', function() {
	// 	// 	console.log('changed');
	// });

});



// Added by Shweta Apale on 01-02-2022 To select all checkbox
// $(document).ready(function () {
// 	var $selectAll = $('#violationSelectAll'); // main checkbox inside table thead
// 	var $table = $('.tableViolation'); // table selector 
// 	var $tdCheckbox = $table.find('tbody input:checkbox'); // checboxes inside table body
// 	var tdCheckboxChecked = 0; // checked checboxes

// 	// Select or deselect all checkboxes depending on main checkbox change
// 	$selectAll.on('click', function () {
// 		$tdCheckbox.prop('checked', this.checked);
// 	});

// 	// Toggle main checkbox state to checked when all checkboxes inside tbody tag is checked
// 	$tdCheckbox.on('change', function (e) {
// 		tdCheckboxChecked = $table.find('tbody input:checkbox:checked').length; // Get count of checkboxes that is checked
// 		// if all checkboxes are checked, then set property of main checkbox to "true", else set to "false"
// 		$selectAll.prop('checked', (tdCheckboxChecked === $tdCheckbox.length));
// 	})
// });

/**
 * Added by Shweta Apale on 03-02-2022
 * To validate checkbox to be checked atleast once 
 * Confirmation to send notice
 * */
$(document).ready(function () {
	$('#sendNotice').click(function () {
		checked = $("input[type=checkbox]:checked").length;
		if (!checked) {
			alert("At least check one checkbox.");
			return false;
		}
	});

	$('#sendNotice').click(function () {
		checked = $("input[type=checkbox]:checked").length;
		if (checked) {
			if (confirm('Are you sure want to  send notice !')) {
				////
			} else {
				return false;
				exit;
			}
		}
	});
});

// To select all checkbox of all pages
$(document).ready(function () {
	var oTable = $('#violationList').dataTable({
		"paging": false,
	});

	var allPages = oTable.fnGetNodes();

	$('body').on('click', '#violationSelectAll', function () {
		if ($(this).hasClass('allChecked')) {
			$('input[type="checkbox"]', allPages).prop('checked', false);
		} else {
			$('input[type="checkbox"]', allPages).prop('checked', true);
		}
		$(this).toggleClass('allChecked');
	})
});

$(document).ready(function () { 
	$('#violationListServe').dataTable();
});

$(function () {
	$(".monthDate").datepicker({
		dateFormat: 'MM yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '2011:' + (new Date).getFullYear(),
		showButtonPanel: true,

		onClose: function (dateText, inst) {
			$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
		},
	});
});
