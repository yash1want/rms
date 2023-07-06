
$(document).ready(function () {

	Particular.fieldValidation();
	Particular.renewalDateAlert();

	chkAddMoreLeasBtn();
	chkRemTblBtn();
	updateTblCnt();

	$('#frmParticulars').on('click', '#add_more_btn_particular', function () {

		var tblCnt = $('#frmParticulars .particular_tbl').length;
		var tblId = parseInt(tblCnt) + 1;
		var tblCon = $('#frmParticulars #particular_tbl_1').html();
		tblCon = tblCon.replace(/_1/g, '_' + tblId);
		tblCon = tblCon.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
		tblConFinal = '<div class="rounded border mt-3 particular_tbl_div" id="tbl_con_' + tblId + '"><table class="table table-bordered particular_tbl mb-0" id="particular_tbl_' + tblId + '">';
		tblConFinal += tblCon;
		tblConFinal += '</table></div>';

		$('#particular_con').append(tblConFinal);

		chkAddMoreLeasBtn();
		chkRemTblBtn();
		updateTblCnt();

	});

	$('#frmParticulars').on('click', '.tbl_rem_btn', function () {

		var btnId = $(this).attr('id');
		btnIdArr = btnId.split('_');
		var btnIdCnt = btnIdArr[3];
		$('#frmParticulars #tbl_con_' + btnIdCnt).remove();

		chkRemTblBtn();
		chkAddMoreLeasBtn();
		updateSrlNo();
		updateTblCnt();

	});

	// $('#add_info_lease').multiSelect;
	// placeholder: 'Select options'

	$('#add_info_lease').multiselect({
		// placeholder: 'Select options'
	});

});

function chkAddMoreLeasBtn() {

	var tblCnt = $('#frmParticulars .particular_tbl').length;
	if (tblCnt >= 5) {
		$('#frmParticulars #add_more_btn_particular').hide();
	} else {
		$('#frmParticulars #add_more_btn_particular').show();
	}

}

function chkRemTblBtn() {

	var tblCnt = $('#frmParticulars .particular_tbl').length;
	if (tblCnt == 1) {
		$('#frmParticulars .tbl_rem_btn').hide();
	} else {
		$('#frmParticulars .tbl_rem_btn').show();
	}

}

function updateSerialNoMultiple(tId) {

	var rowsCount = $('#table_' + tId + ' .table_body tr').length;
	var i;
	for (i = 0; i < rowsCount; i++) {
		var incI = i + parseInt(1);
		var thisAtt = $('#table_' + tId + ' .table_body tr td .serial_no').eq(i).text(incI);
	}
	$('#row-count-' + tId).val(rowsCount);

}

function updateSrlNo() {

	var tblCnt = $('#frmParticulars .particular_tbl').length;
	for (var i = 1; i <= tblCnt; i++) {

		var tblId = $('#frmParticulars #particular_con .particular_tbl_div:nth-child(' + i + ')').attr('id');
		var tblIdArr = tblId.split('_');
		var tblIdNum = tblIdArr[2];
		var tbl = $('#frmParticulars #tbl_con_' + tblIdNum);

		$('#frmParticulars #tbl_con_' + tblIdNum).find('[id*="_' + tblIdNum + '"]').each(function () {
			$(this).attr('id', $(this).attr('id').replace('_' + tblIdNum, '_' + i));
		});
		$('#frmParticulars #tbl_con_' + tblIdNum).find('[name*="_' + tblIdNum + '"]').each(function () {
			$(this).attr('name', $(this).attr('name').replace('_' + tblIdNum, '_' + i));
		});

		tbl.attr('id', 'tbl_con_' + i);

	}

}

function updateTblCnt() {

	var tblCnt = $('#frmParticulars .particular_tbl').length;
	$('#frmParticulars #table_count').val(tblCnt);

}

