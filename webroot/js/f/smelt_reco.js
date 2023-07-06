
$(document).ready(function () {

	f5Smelter.recoverySourceValidation();
	f5Smelter.recoveryConcenTreatValidation();
	f5Smelter.recoveryCloseStockValidataion();
	f5Smelter.conMetalQtyValidation();
	f5Smelter.conMetalValueValidation();
	f5Smelter.postValidation();
	f5Smelter.openDropDownValidation();
	f5Smelter.recoveredDropDownValidation();
	f5Smelter.byProductDropDownValidation();
	f5Smelter.conMetalGradeValidation();
	f5Smelter.autoFillForZeroProduction();

	$('#frmSmeltReco').on('change', '.open_metal', function () {
		var openMetalCount = $('#recovery_count').val();
		if (openMetalCount != 1) {
			var selEl = $(this);
			var selMetal = $(this).val();
			var elId = $(this).attr('id');
			var elIdArr = elId.split('_');
			var elIdRw = elIdArr[2];

			$('.open_metal').each(function () {
				var otherElId = $(this).attr('id');
				if (elId != otherElId) {
					var otherMetal = $(this).val();
					if (selMetal == otherMetal) {
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
	});

	$('#frmSmeltReco').on('change', '.rc-metal', function () {
		var conMetalCount = $('#con_metal_count').val();
		if (conMetalCount != 1) {
			var selEl = $(this);
			var selMetal = $(this).val();
			var elId = $(this).attr('id');
			var elIdArr = elId.split('_');
			var elIdRw = elIdArr[2];

			$('.rc-metal').each(function () {
				var otherElId = $(this).attr('id');
				if (elId != otherElId) {
					var otherMetal = $(this).val();
					if (selMetal == otherMetal) {
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
	});

	$('#frmSmeltReco').on('change', '.rc-byproduct-prod', function () {
		var conMetalCount = $('#byproduct_count').val();
		if (conMetalCount != 1) {
			var selEl = $(this);
			var selMetal = $(this).val();
			var elId = $(this).attr('id');
			var elIdArr = elId.split('_');
			var elIdRw = elIdArr[2];

			$('.rc-byproduct-prod').each(function () {
				var otherElId = $(this).attr('id');
				if (elId != otherElId) {
					var otherMetal = $(this).val();
					if (selMetal == otherMetal) {
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
	});

	smeltRecoRowCount();
	smeltRecoRemAddAllMain();
	smeltRecoRemAddAll('con_metal_value_table', 2);
	smeltRecoRemAddAll('byproduct_value_table', 2);

	$('#frmSmeltReco').on('click', '#recovery_add_btn', function () {

		var rowC = $('#recovery-table .recovery-table-body .recovery-table-rw').length;
		rowC++;

		var rowCon = '<tr class="recovery-table-rw">';
		rowCon += '<td>';
		rowCon += '<table class="smelter-open-table table table-borderless">';
		rowCon += '<tbody>';
		rowCon += '<tr>';
		rowCon += '<td>';
		rowCon += $('#open_metal_row').val();
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="open_qty_rowcc" id="open_qty_rowcc" class="form-control open_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen min_width" maxLength="16"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td></td>';
		rowCon += '</tr>';
		rowCon += '</tbody>';
		rowCon += '</table>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="open_grade_rowcc" id="open_grade_rowcc" class="form-control open_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="5"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="con_rc_qty_rowcc" id="con_rc_qty_rowcc" class="form-control con_rc_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="16"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="con_rc_grade_rowcc" id="con_rc_grade_rowcc" class="form-control con_rc_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="5"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="con_rs_qty_rowcc" id="con_rs_qty_rowcc" class="form-control con_rs_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="16"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="con_rs_grade_rowcc" id="con_rs_grade_rowcc" class="form-control con_rs_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="5"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="con_so_qty_rowcc" id="con_so_qty_rowcc" class="form-control con_so_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="16"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="con_so_grade_rowcc" id="con_so_grade_rowcc" class="form-control con_so_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="5"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="con_tr_qty_rowcc" id="con_tr_qty_rowcc" class="form-control con_tr_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="16"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="con_tr_grade_rowcc" id="con_tr_grade_rowcc" class="form-control con_tr_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="5"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="close_qty_rowcc" id="close_qty_rowcc" class="form-control close_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen" maxLength="16"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div><input type="text" name="close_value_rowcc" id="close_value_rowcc" class="form-control close-value makeNil cvOn cvNum cvReq"></div><div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowCon += '</tr>';
		rowCon = rowCon.replace(/rowcc/g, rowC);
		smeltRecoRemMainAdd();
		$('#recovery-table .recovery-table-body').append(rowCon);
		smeltRecoRowCount();

	});

	$('#frmSmeltReco').on('click', '#recovery-table .btn-rem', function () {

		$(this).closest('tr').remove();
		smeltRecoRowMainVal('#open_ore_table');
		smeltRecoMainSymRw();
		smeltRecoRowCount();

	});

	$('#frmSmeltReco').on('click', '#con_metal_add_btn', function () {

		var rowC = $('#con_metal_table tbody tr').length;
		rowC++;

		var rowCon = "<tr>";
		rowCon += "<td>";
		rowCon += $('#rc_metal_row').val();
		rowCon += '<div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "<td>";
		rowCon += '<div><input type="text" name="rc_qty_rowcc" id="rc_qty_rowcc" class="form-control rc-qty cvOn cvNum cvReq cvMaxLen" maxLength="16"></div><div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g, rowC);
		$('#con_metal_table tbody').append(rowCon);

		var rowGrade = "<tr>";
		rowGrade += "<td>";
		rowGrade += '<div><input type="text" name="rc_grade_rowcc" id="rc_grade_rowcc" class="form-control rc-grade cvOn cvNum cvReq cvMaxLen" maxLength="5"></div><div class="err_cv"></div>';
		rowGrade += "</td>";
		rowGrade += "</tr>";
		rowGrade = rowGrade.replace(/rowcc/g, rowC);
		$('#con_grade_table tbody').append(rowGrade);

		var rowValue = "<tr>";
		rowValue += "<td>";
		rowValue += '<div><input type="text" name="rc_value_rowcc" id="rc_value_rowcc" class="form-control rc-value cvOn cvNum cvReq cvMaxLen" maxLength="15"></div><div class="err_cv"></div>';
		rowValue += "</td>";
		rowValue += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowValue += "</tr>";
		rowValue = rowValue.replace(/rowcc/g, rowC);
		smeltRecoRemAdd('#con_metal_value_table');
		$('#con_metal_value_table tbody').append(rowValue);
		smeltRecoRowCount();

	});

	$('#frmSmeltReco').on('click', '#con_metal_value_table .btn-rem', function () {

		var rwTr = $(this).closest('tr').find('.rc-value').attr('id');
		var rwId = rwTr.split("_");
		var rId = rwId[rwId.length - 1];
		$('#con_metal_table tbody tr:nth-child(' + rId + ')').remove();
		$('#con_grade_table tbody tr:nth-child(' + rId + ')').remove();
		$(this).closest('tr').remove();
		smeltRecoRowVal('#con_metal_value_table');
		smeltRecoSymRwOne('#con_metal_table', '.rc-metal', 'rc_metal_', '.rc-qty', 'rc_qty_');
		smeltRecoSymRwTwo('#con_grade_table', '.rc-grade', 'rc_grade_');
		smeltRecoSymRwTwo('#con_metal_value_table', '.rc-value', 'rc_value_');
		smeltRecoRowCount();

	});

	$('#frmSmeltReco').on('click', '#byproduct_add_btn', function () {

		var rowC = $('#byproduct_table tbody tr').length;
		rowC++;

		var rowCon = "<tr>";
		rowCon += "<td>";
		rowCon += $('#rc_byproduct_prod_row').val();
		rowCon += '<div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "<td>";
		rowCon += '<div><input type="text" name="rc_byproduct_qty_rowcc" id="rc_byproduct_qty_rowcc" class="form-control rc-byproduct-qty cvOn cvNum cvReq cvMaxLen" maxLength="16"></div><div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g, rowC);
		$('#byproduct_table tbody').append(rowCon);

		var rowGrade = "<tr>";
		rowGrade += "<td>";
		rowGrade += '<div><input type="text" name="rc_byproduct_grade_rowcc" id="rc_byproduct_grade_rowcc" class="form-control rc-byproduct-grade cvOn cvNum cvReq cvMaxLen" maxLength="5"></div><div class="err_cv"></div>';
		rowGrade += "</td>";
		rowGrade += "</tr>";
		rowGrade = rowGrade.replace(/rowcc/g, rowC);
		$('#byproduct_grade_table tbody').append(rowGrade);

		var rowValue = "<tr>";
		rowValue += "<td>";
		rowValue += '<div><input type="text" name="rc_byproduct_value_rowcc" id="rc_byproduct_value_rowcc" class="form-control rc-byproduct-value cvOn cvNum cvReq cvMaxLen" maxLength="16"></div><div class="err_cv"></div>';
		rowValue += "</td>";
		rowValue += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowValue += "</tr>";
		rowValue = rowValue.replace(/rowcc/g, rowC);
		smeltRecoRemAdd('#byproduct_value_table');
		$('#byproduct_value_table tbody').append(rowValue);
		smeltRecoRowCount();

	});

	$('#frmSmeltReco').on('click', '#byproduct_value_table .btn-rem', function () {

		var rwTr = $(this).closest('tr').find('.rc-byproduct-value').attr('id');
		var rwId = rwTr.split("_");
		var rId = rwId[rwId.length - 1];
		$('#byproduct_table tbody tr:nth-child(' + rId + ')').remove();
		$('#byproduct_grade_table tbody tr:nth-child(' + rId + ')').remove();
		$(this).closest('tr').remove();
		smeltRecoRowVal('#byproduct_value_table');
		smeltRecoSymRwOne('#byproduct_table', '.rc-byproduct-prod', 'rc_byproduct_prod_', '.rc-byproduct-qty', 'rc_byproduct_qty_');
		smeltRecoSymRwTwo('#byproduct_grade_table', '.rc-byproduct-grade', 'rc_byproduct_grade_');
		smeltRecoSymRwTwo('#byproduct_value_table', '.rc-byproduct-value', 'rc_byproduct_value_');
		smeltRecoRowCount();

	});

	$(document).on('change', '#frmSmeltReco .metal-box', function () {

		var metalBox = $(this).val();
		if (metalBox == 'NIL') {
			var nilStatus = confirm("Selecting NIL in the Metal Content/Grade will automatically put 0 in corresponding Quantity and Grade.\nAre you sure want to continue?");
			if (nilStatus == true) {
				var elId = $(this).attr('id');
				var elArr = elId.split('_');
				var elArrRw = elArr.length;
				if (elArrRw == 3) {
					var elRw = elArr[2];
					var metalEl = elArr[0];
					if (metalEl == 'open') {
						$('#frmSmeltReco #' + elArr[0] + '_qty_' + elRw).val('0');
						$('#frmSmeltReco #' + elArr[0] + '_grade_' + elRw).val('0');
						$('#frmSmeltReco #con_rc_qty_' + elRw).val('0');
						$('#frmSmeltReco #con_rc_grade_' + elRw).val('0');
						$('#frmSmeltReco #con_rs_qty_' + elRw).val('0');
						$('#frmSmeltReco #con_rs_grade_' + elRw).val('0');
						$('#frmSmeltReco #con_so_qty_' + elRw).val('0');
						$('#frmSmeltReco #con_so_grade_' + elRw).val('0');
						$('#frmSmeltReco #con_tr_qty_' + elRw).val('0');
						$('#frmSmeltReco #con_tr_grade_' + elRw).val('0');
						$('#frmSmeltReco #close_qty_' + elRw).val('0');
						$('#frmSmeltReco #close_value_' + elRw).val('0');
					} else if (metalEl == 'rc') {
						$('#frmSmeltReco #' + elArr[0] + '_qty_' + elRw).val('0');
						$('#frmSmeltReco #' + elArr[0] + '_grade_' + elRw).val('0');
						$('#frmSmeltReco #' + elArr[0] + '_value_' + elRw).val('0');
					}
				} else {
					var elRw = elArr[3];
					$('#frmSmeltReco #' + elArr[0] + '_' + elArr[1] + '_qty_' + elRw).val('0');
					$('#frmSmeltReco #' + elArr[0] + '_' + elArr[1] + '_grade_' + elRw).val('0');
					$('#frmSmeltReco #' + elArr[0] + '_' + elArr[1] + '_value_' + elRw).val('0');
				}
			} else {
				$(this).val('');
			}
		}

	});

	$(document).on('submit', '#frmSmeltReco', function () {

		if (!confirm('On saving this section, The section "5. Sales during the month" will reset. Kindly note that, Whenever changes made on the section "4. Recovery at the Smelter-Mill-Plant" by applicant then data in the section "5. Sales during the month" will be reset. Please confirm before saving.')) {
			return false;
		}

		$('#frmSmeltReco').find('select').not(':hidden').not('select[disabled]').removeClass('is-invalid');
		$('#frmSmeltReco').find('input').not(':hidden').not('select[disabled]').removeClass('is-invalid');
		var returnFormStatus = true;
		var formSelStatus = 'valid';

		var emptyStatus = formEmptyStatus('frmSmeltReco');

		var selRw = $('#frmSmeltReco').find('select').not(':hidden').not('select[disabled]').length;
		for (var i = 0; i < selRw; i++) {
			var selField = $('#frmSmeltReco').find('select').not(':hidden').not('select[disabled]').eq(i).val();
			if (selField == '') {
				showElAlrt('frmSmeltReco', 'select', i);
				formSelStatus = 'invalid';
			}
		}

		if (formSelStatus == 'invalid') {
			showAlrt('Select Options in all Select Boxes. <br>If No <b>Metal Content/Grade</b> then Select <b>NIL</b>');
			returnFormStatus = false;
		}

		if (emptyStatus == 'invalid') { returnFormStatus = false; }

		return returnFormStatus;

	});

});

function smeltRecoRemMainAdd() {

	$('.recovery-table-body .recovery-table-rw td:nth-child(14)').html("<i class='fa fa-times btn-rem'></i>");
}

function smeltRecoRemAdd(tId) {

	$(tId + ' tbody tr td:nth-child(2)').html("<i class='fa fa-times btn-rem'></i>");
}


function smeltRecoRemAddAllMain() {

	if ($('#recovery-table .recovery-table-body .recovery-table-rw').length > 1) {
		$('#recovery-table .recovery-table-body .recovery-table-rw td:nth-child(14)').html("<i class='fa fa-times btn-rem'></i>");
	}
}

function smeltRecoRemAddAll(tId, nRw) {

	if ($('#' + tId + ' tbody tr').length > 1) {
		$('#' + tId + ' tbody tr td:nth-child(' + nRw + ')').html("<i class='fa fa-times btn-rem'></i>");
	}
}

function smeltRecoRowMainVal() {

	var rowCn = $('#recovery-table .recovery-table-body .recovery-table-rw').length;
	if (rowCn == 1) {
		$('#recovery-table .recovery-table-body tr:first td:nth-child(14)').html("");
	}

}

function smeltRecoRowVal(tId) {

	var rowCn = $(tId + ' tbody tr').length;
	if (rowCn == 1) {
		$(tId + ' tbody tr:first td:nth-child(2)').html("");
	}

}

function smeltRecoMainSymRw() {

	smeltRecoMainRw('.metal-box', 'open_metal_', 'open_metal_', 1);
	smeltRecoMainRw('.open_qty', 'open_qty_', 'open_qty_', 1);
	smeltRecoMainRw('.open_grade', 'open_grade_', 'open_grade_', 2);
	smeltRecoMainRw('.con_rc_qty', 'con_rc_qty_', 'con_rc_qty_', 3);
	smeltRecoMainRw('.con_rc_grade', 'con_rc_grade_', 'con_rc_grade_', 4);
	smeltRecoMainRw('.con_rs_qty', 'con_rs_qty_', 'con_rs_qty_', 6);
	smeltRecoMainRw('.con_rs_grade', 'con_rs_grade_', 'con_rs_grade_', 7);
	smeltRecoMainRw('.con_so_qty', 'con_so_qty_', 'con_so_qty_', 8);
	smeltRecoMainRw('.con_so_grade', 'con_so_grade_', 'con_so_grade_', 9);
	smeltRecoMainRw('.con_tr_qty', 'con_tr_qty_', 'con_tr_qty_', 10);
	smeltRecoMainRw('.con_tr_grade', 'con_tr_grade_', 'con_tr_grade_', 11);
	smeltRecoMainRw('.close_qty', 'close_qty_', 'close_qty_', 12);
	smeltRecoMainRw('.close-value', 'close_value_', 'close_value_', 13);

}

function smeltRecoMainRw(clBox, inName, inId, tdPos) {

	var rowCn = $('#recovery-table .recovery-table-body .recovery-table-rw').length;
	var tabBody = "#recovery-table .recovery-table-body";

	for (var cnRw = 1; cnRw <= rowCn; cnRw++) {

		var metal = $(tabBody + ' .recovery-table-rw:nth-child(' + cnRw + ') td:nth-child(' + tdPos + ') ' + clBox);
		metal.attr('name', inName + cnRw);
		metal.attr('id', inId + cnRw);

	}
}

function smeltRecoSymRwOne(tId, metalCl, metalIn, qtyCl, qtyIn) {

	var rowCn = $(tId + ' tbody tr').length;

	for (var cnRw = 1; cnRw <= rowCn; cnRw++) {

		var metal = $(tId + ' tbody tr:nth-child(' + cnRw + ') td:nth-child(1) ' + metalCl);
		metal.attr('name', metalIn + cnRw);
		metal.attr('id', metalIn + cnRw);

		var qty = $(tId + ' tbody tr:nth-child(' + cnRw + ') td:nth-child(2) ' + qtyCl);
		qty.attr('name', qtyIn + cnRw);
		qty.attr('id', qtyIn + cnRw);

	}

}

function smeltRecoSymRwTwo(tId, clName, inName) {

	var rowCn = $(tId + ' tbody tr').length;

	for (var cnRw = 1; cnRw <= rowCn; cnRw++) {

		var inRw = $(tId + ' tbody tr:nth-child(' + cnRw + ') td:nth-child(1) ' + clName);
		inRw.attr('name', inName + cnRw);
		inRw.attr('id', inName + cnRw);

	}

}

function smeltRecoRowCount() {

	$('#recovery_count').val($('#recovery-table .recovery-table-body .recovery-table-rw').length);
	$('#con_metal_count').val($('#con_metal_table tbody tr').length);
	$('#byproduct_count').val($('#byproduct_table tbody tr').length);

}

/**
 * Made by Shweta Apale 24-01-2022
 * To get input values of Metal, Quantity, Value
 */
$(document).ready(function () {
	var rc_qty_gold, rc_value_gold, rc_divide;
	$('input[id^="rc_value_"], input[id^="rc_qty_"], [id^="rc_metal_"]').focusout(function () {
		var metal_selected = $('[id^="rc_metal_"]').val();
		if (metal_selected === 'Gold') {
			rc_value_gold = $('input[id^="rc_value_"]').val();
			rc_qty_gold = $('input[id^="rc_qty_"]').val();

			if (rc_value_gold != '' && rc_qty_gold != '') {
				rc_divide = parseFloat(rc_value_gold) / parseFloat(rc_qty_gold);
				// rc_divide.toFixed(3);
				$.ajax({
					type: "POST",
					url: "../check_gold_value",
					data: { rc_divide_smelter: rc_divide },
					cache: false,

					beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
					success: function (response) {
						// console.log(response);
						// console.log(response == 1);
						if (response == 1) {
							alert('Only 2% error is allowed');
						}
					}
				});
			}
		}

	});
});