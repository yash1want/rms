
$(document).ready(function(){

	// input maxlength
	$('#trad_ac_tbl').ready(function(){
		$('#trad_ac_tbl .supplier_registration').prop('maxlength', '20');
		$('#trad_ac_tbl .buyer_registration').prop('maxlength', '20');
	});

	// hide autocomplete div on click
	$('body').on('click', function(){
		$('.sugg-box').hide();
	});

	var firstMineral = $('#first_mineral').val();
	if(firstMineral == 'NIL'){
		$('.h-add-more-btn').hide();
		$('input,select').not('.mineral').not(':hidden').attr('readonly','readonly');
		$('.grade option[value=""]').remove();
	}

    $('#frmActivityDetails').ready(function(){
        tradAcNil();
    });

	tradAcCounts();

	$('#frmActivityDetails').on('change', '#trad_ac_tbl .mineral',function(){

		var tRw = $(this).closest('tr').attr('id');
		var tRwArr = tRw.split('_');
		var mId = tRwArr[2];
		var gradeDetailUrl = $('#get_grade_detail_url').val();
		var rawMaterialMetalUrl = $('#raw_material_metal_url').val();
		var mineral = $(this).val();
		var returnDate = $('#return_date').val();
		var rwSpan = $('#trad_ac_tbl #'+tRw+' td:first').attr('rowspan');
		var secNo = $('#frmActivityDetails #section_no').val();
		var uType = $('#uType').val();
		var buyerRegNoNilVal = (uType == 'E') ? 'NIL' : '0';
		rwSpan = parseInt(rwSpan);

		if(mineral != ''){

            if(mineral != 'NIL'){
                
                $.ajax({
                    type: 'POST',
                    url: gradeDetailUrl,
                    data: {'mineral': mineral, 'returnDate': returnDate},
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    success: function(data){
                        for(var nrw=1; nrw < rwSpan; nrw++){
                            $('#trad_ac_tbl .c_row_'+mId+'_'+nrw+' .grade').html(data);
                        }
                    }
                });
                
                $.ajax({
                    type: 'POST',
                    url: rawMaterialMetalUrl,
                    data: {	'mineral': mineral},
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    success: function(data){
                        $('#trad_ac_tbl #'+tRw+' td:first .unitSpan_mineral').text(data);
                    }
                });

                $('#grade_1_1').removeAttr('readonly');
                $('#opening_stock_quantity_1_1').removeAttr('readonly');
                $('#reg_no_1_1_1').removeAttr('readonly');
                $('#supplier_quantity_1_1_1').removeAttr('readonly');
                $('#supplier_value_1_1_1').removeAttr('readonly');
                $('#import_country_1_1_1').removeAttr('readonly');
                $('#import_quantity_1_1_1').removeAttr('readonly');
                $('#import_value_1_1_1').removeAttr('readonly');
                $('#buyer_regNo_1_1_1').removeAttr('readonly');
                $('#buyer_quantity_1_1_1').removeAttr('readonly');
                $('#buyer_value_1_1_1').removeAttr('readonly');
                $('#closing_stock_1_1').removeAttr('readonly');
				if(secNo == '3'){
					$('#consumeQuantity_1_1').removeAttr('readonly');
					$('#consumeValue_1_1').removeAttr('readonly');
				}
                $('.h-add-more-btn').show();

            } else {

                var tdRowSpan = $(this).parent().parent().attr('rowspan');
                if(tdRowSpan > 2){
                    $('#c_row_1 td').eq(0).attr('rowspan', 2);

                    for(var i=2; i<tdRowSpan; i++){
                        $('.c_row_1_'+i).remove();
                    }
                }

				$('#grade_cnt_1').val('1');
				$('#c_row_count').val('1');
				$('#mineral_cnt').val('1');

                $('#supplier_table_1_1_1 tbody tr').not(':first').remove();
                $('#supplier_table_1_1_1 tbody tr td').eq(3).html('');
				$('#purchase_cnt_1_1').val('1');
				
                $('#import_table_1_1_1 tbody tr').not(':first').remove();
                $('#import_table_1_1_1 tbody tr td').eq(3).html('');
				$('#import_cnt_1_1').val('1');
				
                $('#buyer_table_1_1_1 tbody tr').not(':first').remove();
                $('#buyer_table_1_1_1 tbody tr td').eq(3).html('');
				$('#despatch_cnt_1_1').val('1');

                $('#grade_1_1').html('<option value="0">NIL</option>').attr('readonly','readonly');
                $('#opening_stock_quantity_1_1').val('0').attr('readonly','readonly');
                $('#reg_no_1_1_1').val('0').attr('readonly','readonly');
                $('#supplier_quantity_1_1_1').val('0').attr('readonly','readonly');
                $('#supplier_value_1_1_1').val('0').attr('readonly','readonly');
                $('#import_country_1_1_1').val('NIL').attr('readonly','readonly');
                $('#import_quantity_1_1_1').val('0').attr('readonly','readonly');
                $('#import_value_1_1_1').val('0').attr('readonly','readonly');
                $('#buyer_regNo_1_1_1').val(buyerRegNoNilVal).attr('readonly','readonly');
                $('#buyer_quantity_1_1_1').val('0').attr('readonly','readonly');
                $('#buyer_value_1_1_1').val('0').attr('readonly','readonly');
                $('#closing_stock_1_1').val('0').attr('readonly','readonly');
				if(secNo == '3'){
					$('#consumeQuantity_1_1').val('0').attr('readonly','readonly');
					$('#consumeValue_1_1').val('0').attr('readonly','readonly');
				}
                $('.h-add-more-btn').hide();
                $('.unitSpan_mineral').html('');

            }

		}

	});

	$('#frmActivityDetails').on('click', '#trad_ac_tbl .supplier_add_more',function(){

		var elId = $(this).closest('.trad_ac_grade_tbl').attr('id');
		var elArr = elId.split('_');
		var msId = elArr[2]+'_'+elArr[3];

		var rowC = $('#'+elId+' tbody tr').length;
		rowC = rowC+1;
		
		var rowCon = "<tr>";
		rowCon += "<td class='v_a_base'>";
		rowCon += '<div><input type="text" name="reg_no_rowcc_sbcc" id="reg_no_rowcc_sbcc" class="form-control form-control-sm text-fields supplier_registration supplier_reg_noClass_rowcc ui-autocomplete-input cvOn cvReq" maxlength="20"></div>';
		rowCon += '<div class="err_cv"></div><div class="sugg-box autocomp"></div>';
		rowCon += "</td>";
		rowCon += "<td class='v_a_base'>";
		rowCon += '<div><input type="text" name="supplier_quantity_rowcc_sbcc" id="supplier_quantity_rowcc_sbcc" class="form-control form-control-sm text-fields supplier_quantity supplier_quantityClass_rowcc cvOn cvReq cvNum"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "<td class='v_a_base'>";
		rowCon += '<div><input type="text" name="supplier_value_rowcc_sbcc" id="supplier_value_rowcc_sbcc" class="form-control form-control-sm text-fields supplier_value supplier_valueClass_rowcc cvOn cvReq cvNum"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "<td class='v_a_base mw_19'><i class='fa fa-times btn-rem btn_rem_supplier'></i></td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g,msId);
		rowCon = rowCon.replace(/sbcc/g,rowC);
		tradAcDelRw('#'+elId, 'btn_rem_supplier');
		$('#'+elId+' tbody').append(rowCon);
		tradAcCounts();

	});
	
	$('#frmActivityDetails').on('click', '#trad_ac_tbl .import_add_more',function(){

		var elId = $(this).closest('.trad_ac_import_tbl').attr('id');
		var elArr = elId.split('_');
		var msId = elArr[2]+'_'+elArr[3];
		var mId = elArr[2];

		var rowC = $('#'+elId+' tbody tr').length;
		rowC = rowC+1;
		
		var countryEl = $('#trad_ac_tbl tbody #c_row_'+mId+' td #import_country_'+mId+'_1_1').parent().html();
		countryEl = countryEl.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+msId+'_'+rowC+'\"');
		countryEl = countryEl.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+msId+'_'+rowC+'\"');
		countryEl = countryEl.replace('selected="selected"', '');

		var rowCon = "<tr>";
		rowCon += "<td class='v_a_base'>";
		rowCon += '<div>';
		rowCon += countryEl;
		rowCon += '</div>';
		rowCon += '<div class="sugg-box autocomp"></div>';
		rowCon += "</td>";
		rowCon += "<td class='v_a_base'>";
		rowCon += '<div><input type="text" name="import_quantity_rowcc_sbcc" id="import_quantity_rowcc_sbcc" class="form-control form-control-sm text-fields import_quantity import_quantityClass_rowcc cvOn cvReq cvNum"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "<td class='v_a_base'>";
		rowCon += '<div><input type="text" name="import_value_rowcc_sbcc" id="import_value_rowcc_sbcc" class="form-control form-control-sm text-fields import_value import_value_rowcc cvOn cvNum cvNotReq"></div>';
		rowCon += "</td>";
		rowCon += "<td class='v_a_base mw_19'><i class='fa fa-times btn-rem btn_rem_import'></i></td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g,msId);
		rowCon = rowCon.replace(/sbcc/g,rowC);
		tradAcDelRw('#'+elId, 'btn_rem_import');
		$('#'+elId+' tbody').append(rowCon);
		tradAcCounts();

	});
	
	$('#frmActivityDetails').on('click', '#trad_ac_tbl .add_more_buyer_btn',function(){

		var elId = $(this).closest('.trad_ac_buyer_tbl').attr('id');
		var elArr = elId.split('_');
		var msId = elArr[2]+'_'+elArr[3];
		var mId = elArr[2];

		var secNo = $('#section_no').val();

		var cRw = $('#trad_ac_tbl #c_row_'+mId+' td').eq(0).attr('rowspan');
		var incRow = cRw;

		var rowC = $('#'+elId+' tbody tr').length;
		rowC = rowC+1;

		var rowCon = "<tr>";
		rowCon += "<td class='v_a_base'>";
		if (secNo == '2') {
			var importCnt = $('#trad_ac_tbl tbody #buyer_regNo_'+msId+'_1').parent().html();
			importCnt = importCnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+msId+'\_'+rowC+'\"');
			importCnt = importCnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+msId+'\_'+rowC+'\"');
			importCnt = importCnt.replace(/buyer_regNoClass_(.*?)\_(.*?) /g, 'buyer_regNoClass_$1\_'+incRow+' ');
			importCnt = importCnt.replace('selected="selected"', '');
			rowCon += importCnt;
		} else {
			rowCon += '<div><input type="text" name="buyer_regNo_rowcc_sbcc" id="buyer_regNo_rowcc_sbcc" class="form-control form-control-sm text-fields buyer_registration buyer_regNoClass_rowcc ui-autocomplete-input cvOn cvReq" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" maxlength="20"></div>';
			rowCon += '<div class="err_cv"></div>';
			rowCon += '<div class="sugg-box autocomp"></div>';
		}
		rowCon += "</td>";
		rowCon += "<td class='v_a_base'>";
		rowCon += '<div><input type="text" name="buyer_quantity_rowcc_sbcc" id="buyer_quantity_rowcc_sbcc" class="form-control form-control-sm text-fields buyer_quantity buyer_quantityClass_rowcc cvOn cvReq cvNum"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "<td class='v_a_base'>";
		rowCon += '<div><input type="text" name="buyer_value_rowcc_sbcc" id="buyer_value_rowcc_sbcc" class="form-control form-control-sm text-fields buyer_value buyer_valueClass_rowcc cvOn cvReq cvNum"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += "</td>";
		rowCon += "<td class='v_a_base mw_19'><i class='fa fa-times btn-rem btn_rem_buyer'></i></td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g,msId);
		rowCon = rowCon.replace(/sbcc/g,rowC);
		tradAcDelRw('#'+elId, 'btn_rem_buyer');
		$('#'+elId+' tbody').append(rowCon);
		tradAcCounts();

	});
	
	$('#frmActivityDetails').on('click', '#trad_ac_tbl .grade_add_more',function(){

		var elId = $(this).attr('id');
		var elArr = elId.split('_');
		var mId = elArr[2];

		var cRw = $('#trad_ac_tbl #c_row_'+mId+' td').eq(0).attr('rowspan');
		var nCRw = parseInt(cRw)+1;
		var incRow = cRw;
		var pRow = incRow-1;

		var gradeEl = $('#trad_ac_tbl tbody #c_row_'+mId+' td').eq(1).html();
		gradeEl = gradeEl.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+incRow+'\"');
		gradeEl = gradeEl.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+incRow+'\"');
		gradeEl = gradeEl.replace('selected="selected"', '');

		var opnStockEl = $('#trad_ac_tbl tbody #c_row_'+mId+' td').eq(2).html();
		opnStockEl = opnStockEl.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_$4\_'+incRow+'\"');
		opnStockEl = opnStockEl.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_$4\_'+incRow+'\"');
		opnStockEl = opnStockEl.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		//supplier
		var regNo = $('#trad_ac_tbl tbody #c_row_'+mId+' #reg_no_'+mId+'_1_1').parent().html();
		regNo = regNo.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		regNo = regNo.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		regNo = regNo.replace(/supplier_reg_noClass_(.*?)\_(.*?) /g, 'supplier_reg_noClass_$1\_'+incRow+' ');
		regNo = regNo.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var supQnt = $('#trad_ac_tbl tbody #c_row_'+mId+' #supplier_quantity_'+mId+'_1_1').parent().html();
		supQnt = supQnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		supQnt = supQnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		supQnt = supQnt.replace(/supplier_quantityClass_(.*?)\_(.*?) /g, 'supplier_quantityClass_$1\_'+incRow+' ');
		supQnt = supQnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var supVal = $('#trad_ac_tbl tbody #c_row_'+mId+' #supplier_value_'+mId+'_1_1').parent().html();
		supVal = supVal.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		supVal = supVal.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		supVal = supVal.replace(/supplier_valueClass_(.*?)\_(.*?) /g, 'supplier_valueClass_$1\_'+incRow+' ');
		supVal = supVal.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var addMoreSup = $('#trad_ac_tbl tbody #c_row_'+mId+' #add_more_supplier_'+mId+'_1_1').parent().html();
		addMoreSup = addMoreSup.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_$4\_'+incRow+'\_$6\"');
		
		//import
		var importCnt = $('#trad_ac_tbl tbody #c_row_'+mId+' #import_country_'+mId+'_1_1').parent().html();
		importCnt = importCnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		importCnt = importCnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		importCnt = importCnt.replace(/import_countryClass_(.*?)\_(.*?) /g, 'import_countryClass_$1\_'+incRow+' ');
		// importCnt = importCnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
		importCnt = importCnt.replace('selected="selected"', '');

		var importQnt = $('#trad_ac_tbl tbody #c_row_'+mId+' #import_quantity_'+mId+'_1_1').parent().html();
		importQnt = importQnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		importQnt = importQnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		importQnt = importQnt.replace(/import_quantityClass_(.*?)\_(.*?) /g, 'import_quantityClass_$1\_'+incRow+' ');
		importQnt = importQnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var importVal = $('#trad_ac_tbl tbody #c_row_'+mId+' #import_value_'+mId+'_1_1').parent().html();
		importVal = importVal.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		importVal = importVal.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		importVal = importVal.replace(/import_value import_value_(.*?)\_(.*?) /g, 'import_value import_value_$1\_'+incRow+' ');
		importVal = importVal.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var addMoreImport = $('#trad_ac_tbl tbody #c_row_'+mId+' #add_more_import_'+mId+'_1_1').parent().html();
		addMoreImport = addMoreImport.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_$4\_'+incRow+'\_$6\"');

		//ore consumed
		var secNo = $('#frmActivityDetails #section_no').val();
		if(secNo == 3){

			var consQnt = $('#trad_ac_tbl tbody #c_row_'+mId+' .consume_quantity').parent().html();
			consQnt = consQnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+incRow+'\"');
			consQnt = consQnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+incRow+'\"');
			consQnt = consQnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
			
			var consVal = $('#trad_ac_tbl tbody #c_row_'+mId+' .consume_value').parent().html();
			consVal = consVal.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+incRow+'\"');
			consVal = consVal.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+incRow+'\"');
			consVal = consVal.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
			
		}
		
		//buyer
		if (secNo == 2) {
			var buyerRegno = $('#trad_ac_tbl tbody #c_row_'+mId+' #buyer_regNo_'+mId+'_1_1').parent().html();
			buyerRegno = buyerRegno.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
			buyerRegno = buyerRegno.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
			buyerRegno = buyerRegno.replace(/buyer_regNoClass_(.*?)\_(.*?) /g, 'buyer_regNoClass_$1\_'+incRow+' ');
			buyerRegno = buyerRegno.replace('selected="selected"', '');
		} else {
			var buyerRegno = $('#trad_ac_tbl tbody #c_row_'+mId+' #buyer_regNo_'+mId+'_1_1').parent().html();
			buyerRegno = buyerRegno.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
			buyerRegno = buyerRegno.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
			buyerRegno = buyerRegno.replace(/buyer_regNoClass_(.*?)\_(.*?) /g, 'buyer_regNoClass_$1\_'+incRow+' ');
			buyerRegno = buyerRegno.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
		}

		var buyerQnt = $('#trad_ac_tbl tbody #c_row_'+mId+' #buyer_quantity_'+mId+'_1_1').parent().html();
		buyerQnt = buyerQnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		buyerQnt = buyerQnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		buyerQnt = buyerQnt.replace(/buyer_quantityClass_(.*?)\_(.*?) /g, 'buyer_quantityClass_$1\_'+incRow+' ');
		buyerQnt = buyerQnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var buyerVal = $('#trad_ac_tbl tbody #c_row_'+mId+' #buyer_value_'+mId+'_1_1').parent().html();
		buyerVal = buyerVal.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		buyerVal = buyerVal.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\_$5\"');
		buyerVal = buyerVal.replace(/buyer_valueClass_(.*?)\_(.*?) /g, 'buyer_valueClass_$1\_'+incRow+' ');
		buyerVal = buyerVal.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var addMoreBuyer = $('#trad_ac_tbl tbody #c_row_'+mId+' #add_more_buyer_'+mId+'_1_1').parent().html();
		addMoreBuyer = addMoreBuyer.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_$4\_'+incRow+'\_$6\"');

		//closing stock quantity
		var closStock = $('#trad_ac_tbl tbody #c_row_'+mId+' #closing_stock_'+mId+'_1').parent().parent().html();
		closStock = closStock.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+incRow+'\"');
		closStock = closStock.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+incRow+'\"');
		closStock = closStock.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
		
		//remark
		// var remark = $('#trad_ac_tbl tbody #c_row_'+mId+' #remark_'+mId+'_1').parent().html();
		// remark = remark.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+incRow+'\"');
		// remark = remark.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+incRow+'\"');
		// remark = remark.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		//grade
		var addMoreGrade = $('#trad_ac_tbl #add_grade_'+mId).parent().html();
		
		var rowCon = "<tr class='c_row_"+mId+"_"+incRow+" main_tr'>";
		rowCon += "<td class='v_a_base'>";
		rowCon += gradeEl;
		rowCon += "<div class='unitSpan_mineral'></div>";
		rowCon += "</td>";
		rowCon += "<td class='v_a_base'>";
		rowCon += opnStockEl;
		rowCon += "</td>";

		rowCon += "<td colspan='3' class='v_a_base'>";
		rowCon += "<table id='supplier_table_"+mId+"_"+incRow+"_1' class='trad_ac_grade_tbl table table-borderless'>";
		rowCon += "<thead></thead>";
		rowCon += "<tbody>";
		rowCon += "<tr>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+regNo+"</div><div class='err_cv'></div><div class='sugg-box autocomp'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+supQnt+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+supVal+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base mw_19'></td>";
		rowCon += "</tr>";
		rowCon += "</tbody>";
		rowCon += "<thead>";
		rowCon += "<tr>";
		rowCon += "<th colspan='4'>"+addMoreSup+"</th>";
		rowCon += "</tr>";
		rowCon += "</thead>";
		rowCon += "</table>";
		rowCon += "<input type='hidden' name='purchase_cnt_"+mId+"_"+incRow+"' id='purchase_cnt_"+mId+"_"+incRow+"' value='1'>";
		rowCon += "</td>";
		
		rowCon += "<td colspan='3' class='v_a_base'>";
		rowCon += "<table id='import_table_"+mId+"_"+incRow+"_1' class='trad_ac_import_tbl table table-borderless'>";
		rowCon += "<thead></thead>";
		rowCon += "<tbody>";
		rowCon += "<tr>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+importCnt+"</div><div class='sugg-box autocomp'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+importQnt+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+importVal+"</div></td>";
		rowCon += "<td class='v_a_base mw_19'></td>";
		rowCon += "</tr>";
		rowCon += "</tbody>";
		rowCon += "<thead>";
		rowCon += "<tr>";
		rowCon += "<th colspan='4'>"+addMoreImport+"</th>";
		rowCon += "</tr>";
		rowCon += "</thead>";
		rowCon += "</table>";
		rowCon += "<input type='hidden' name='import_cnt_"+mId+"_"+incRow+"' id='import_cnt_"+mId+"_"+incRow+"' value='1'>";
		rowCon += "</td>";

		if(secNo == 3){

			rowCon += "<td class='v_a_base'>";
			rowCon += consQnt;
			rowCon += "</td>";
			rowCon += "<td class='v_a_base'>";
			rowCon += consVal;
			rowCon += "</td>";

		}
		
		rowCon += "<td colspan='3' class='v_a_base'>";
		rowCon += "<table id='buyer_table_"+mId+"_"+incRow+"_1' class='trad_ac_buyer_tbl table table-borderless'>";
		rowCon += "<thead></thead>";
		rowCon += "<tbody>";
		rowCon += "<tr>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+buyerRegno+"</div><div class='err_cv'></div><div class='sugg-box autocomp'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+buyerQnt+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+buyerVal+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base mw_19'></td>";
		rowCon += "</tr>";
		rowCon += "</tbody>";
		rowCon += "<thead>";
		rowCon += "<tr>";
		rowCon += "<th colspan='4'>"+addMoreBuyer+"</th>";
		rowCon += "</tr>";
		rowCon += "</thead>";
		rowCon += "</table>";
		rowCon += "<input type='hidden' name='despatch_cnt_"+mId+"_"+incRow+"' id='despatch_cnt_"+mId+"_"+incRow+"' value='1'>";
		rowCon += "</td>";

		rowCon += "<td class='v_a_base'>"+closStock+"</td>";
		// rowCon += "<td class='v_a_base'>"+remark+"</td>";

		rowCon += "<td class='v_a_base'><i class='fa fa-times btn-rem btn_rem_grade'></i></td>";
		rowCon += "</tr>";
		rowCon += "<tr class='main_tr'>";
		rowCon += "<td colspan='12' class='v_a_base'>"+addMoreGrade+"</td>";
		rowCon += "</tr>";
		
		$('#trad_ac_tbl #c_row_'+mId).find('td:first').attr('rowspan',nCRw);
		$('#trad_ac_tbl tbody .c_row_'+mId+'_'+pRow).after(rowCon);
		$(this).closest('tr').remove();
		tradAcCounts();

	});

	
	$(document).on('click','#frmActivityDetails #trad_ac_tbl #add_more_mineral',function(){

		var cRw = $('#c_row_count').val();
		var nRw = parseInt(cRw) + 1;
		var secNo = $('#frmActivityDetails #section_no').val();
		
		//mineral
		var mineralEl = $('#trad_ac_tbl #mineral_1').parent().parent().html();
		mineralEl = mineralEl.replace(/name\=\"(.*?)\_(.*?)\"/g, 'name\=\"$1\_'+nRw+'\"');
		mineralEl = mineralEl.replace(/id\=\"(.*?)\_(.*?)\"/g, 'id\=\"$1\_'+nRw+'\"');
		mineralEl = mineralEl.replace('selected="selected"', '');

		//grade
		var gradeEl = $('#trad_ac_tbl #grade_1_1').parent().parent().html();
		gradeEl = gradeEl.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_'+nRw+'\_$3\"');
		gradeEl = gradeEl.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_'+nRw+'\_$3\"');
		gradeEl = gradeEl.replace(/trad_ac_grade_select_(.*?) /g, 'trad_ac_grade_select_'+nRw+' ');
		gradeEl = gradeEl.replace('selected="selected"', '');
		
		//opening stock
		var openStock = $('#trad_ac_tbl #opening_stock_quantity_1_1').parent().parent().html();
		openStock = openStock.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_$3\_'+nRw+'\_$5\"');
		openStock = openStock.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+nRw+'\_$5\"');
		openStock = openStock.replace(/opening_stock_quantity opening_stock_quantity_(.*?) /g, 'opening_stock_quantity opening_stock_quantity_'+nRw+' ');
		openStock = openStock.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		//supplier
		var regNo = $('#trad_ac_tbl tbody tr:nth-child(1) #reg_no_1_1_1').parent().html();
		regNo = regNo.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		regNo = regNo.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		regNo = regNo.replace(/supplier_reg_noClass_(.*?)\_(.*?) /g, 'supplier_reg_noClass_'+nRw+'\_$1 ');
		regNo = regNo.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var supQnt = $('#trad_ac_tbl tbody tr:nth-child(1) #supplier_quantity_1_1_1').parent().html();
		supQnt = supQnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		supQnt = supQnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		supQnt = supQnt.replace(/supplier_quantityClass_(.*?)\_(.*?) /g, 'supplier_quantityClass_'+nRw+'\_$1 ');
		supQnt = supQnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var supVal = $('#trad_ac_tbl tbody tr:nth-child(1) #supplier_value_1_1_1').parent().html();
		supVal = supVal.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		supVal = supVal.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		supVal = supVal.replace(/supplier_valueClass_(.*?)\_(.*?) /g, 'supplier_valueClass_'+nRw+'\_$1 ');
		supVal = supVal.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var addMoreSup = $('#trad_ac_tbl tbody tr:nth-child(1) #add_more_supplier_1_1_1').parent().html();
		addMoreSup = addMoreSup.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+nRw+'\_$5\_$6\"');

		//import
		var importCnt = $('#trad_ac_tbl tbody tr:nth-child(1) #import_country_1_1_1').parent().html();
		importCnt = importCnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		importCnt = importCnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		importCnt = importCnt.replace(/import_countryClass_(.*?)\_(.*?) /g, 'import_countryClass_'+nRw+'\_$1 ');
		// importCnt = importCnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
		importCnt = importCnt.replace('selected="selected"', '');

		var importQnt = $('#trad_ac_tbl tbody tr:nth-child(1) #import_quantity_1_1_1').parent().html();
		importQnt = importQnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		importQnt = importQnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		importQnt = importQnt.replace(/import_quantityClass_(.*?)\_(.*?) /g, 'import_quantityClass_'+nRw+'\_$1 ');
		importQnt = importQnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var importVal = $('#trad_ac_tbl tbody tr:nth-child(1) #import_value_1_1_1').parent().html();
		importVal = importVal.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		importVal = importVal.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		importVal = importVal.replace(/import_value import_value_(.*?)\_(.*?) /g, 'import_value import_value_'+nRw+'\_$1 ');
		importVal = importVal.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var addMoreImport = $('#trad_ac_tbl tbody tr:nth-child(1) #add_more_import_1_1_1').parent().html();
		addMoreImport = addMoreImport.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+nRw+'\_$5\_$6\"');

		//ore consumed
		if(secNo == 3){
			
			var consQnt = $('#trad_ac_tbl #consumeQuantity_1_1').parent().html();
			consQnt = consQnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_'+nRw+'\_$3\"');
			consQnt = consQnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_'+nRw+'\_$3\"');
			consQnt = consQnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
			
			var consVal = $('#trad_ac_tbl #consumeValue_1_1').parent().html();
			consVal = consVal.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_'+nRw+'\_$3\"');
			consVal = consVal.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_'+nRw+'\_$3\"');
			consVal = consVal.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		}

		//buyer
		if (secNo == 2) {
			var buyerRegno = $('#trad_ac_tbl tbody tr:nth-child(1) #buyer_regNo_1_1_1').parent().html();
			buyerRegno = buyerRegno.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
			buyerRegno = buyerRegno.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
			buyerRegno = buyerRegno.replace(/buyer_regNoClass_(.*?)\_(.*?) /g, 'buyer_regNoClass_'+nRw+'\_$1 ');
			buyerRegno = buyerRegno.replace('selected="selected"', '');
		} else {
			var buyerRegno = $('#trad_ac_tbl tbody tr:nth-child(1) #buyer_regNo_1_1_1').parent().html();
			buyerRegno = buyerRegno.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
			buyerRegno = buyerRegno.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
			buyerRegno = buyerRegno.replace(/buyer_regNoClass_(.*?)\_(.*?) /g, 'buyer_regNoClass_'+nRw+'\_$1 ');
			buyerRegno = buyerRegno.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
		}

		var buyerQnt = $('#trad_ac_tbl tbody tr:nth-child(1) #buyer_quantity_1_1_1').parent().html();
		buyerQnt = buyerQnt.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		buyerQnt = buyerQnt.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		buyerQnt = buyerQnt.replace(/buyer_quantityClass_(.*?)\_(.*?) /g, 'buyer_quantityClass_'+nRw+'\_$1 ');
		buyerQnt = buyerQnt.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var buyerVal = $('#trad_ac_tbl tbody tr:nth-child(1) #buyer_value_1_1_1').parent().html();
		buyerVal = buyerVal.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		buyerVal = buyerVal.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\_$5\"');
		buyerVal = buyerVal.replace(/buyer_valueClass_(.*?)\_(.*?) /g, 'buyer_valueClass_'+nRw+'\_$1 ');
		buyerVal = buyerVal.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');

		var addMoreBuyer = $('#trad_ac_tbl tbody tr:nth-child(1) #add_more_buyer_1_1_1').parent().html();
		addMoreBuyer = addMoreBuyer.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_$3\_'+nRw+'\_$5\_$6\"');

		//closing stock quantity
		var closStock = $('#trad_ac_tbl tbody tr:nth-child(1) #closing_stock_1_1').parent().parent().html();
		closStock = closStock.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\_$4\"');
		closStock = closStock.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\_$4\"');
		closStock = closStock.replace(/closing_stock closing_stock_(.*?) /g, 'closing_stock closing_stock_'+nRw+' ');
		closStock = closStock.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
		
		//remark
		// var remark = $('#trad_ac_tbl tbody tr:nth-child(1) #remark_1_1').parent().html();
		// remark = remark.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_'+nRw+'\_$3\"');
		// remark = remark.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_'+nRw+'\_$3\"');
		// remark = remark.replace(/remark remark_(.*?) /g, 'remark remark_'+nRw+' ');
		// remark = remark.replace(/value\=\"(.*?)\"/g, 'value\=\"\"');
		
		// //grade
		var addMoreGrade = $('#trad_ac_tbl #add_grade_1').parent().html();
		addMoreGrade = addMoreGrade.replace(/id\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'id\=\"$1\_$2\_'+nRw+'\"');
		addMoreGrade = addMoreGrade.replace(/name\=\"(.*?)\_(.*?)\_(.*?)\"/g, 'name\=\"$1\_$2\_'+nRw+'\"');

		var rowCon = "<tr id='c_row_"+nRw+"' class='c_row_"+nRw+"_1 main_tr c_row'>";
		rowCon += "<td rowspan='2' class='v_a_base'>"+mineralEl+"</td>";
		// rowCon += "<td>"+gradeEl+"<input type='hidden' name='grade_cnt_"+nRw+"' id='grade_cnt_"+nRw+"' value='1'></td>";
		rowCon += "<td class='v_a_base'>"+gradeEl+"</td>";
		rowCon += "<td class='v_a_base'>"+openStock+"</td>";

		rowCon += "<td colspan='3' class='v_a_base'>";
		rowCon += "<table id='supplier_table_"+nRw+"_1_1' class='trad_ac_grade_tbl table table-borderless'>";
		rowCon += "<thead></thead>";
		rowCon += "<tbody>";
		rowCon += "<tr>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+regNo+"</div><div class='err_cv'></div><div class='sugg-box autocomp'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+supQnt+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+supVal+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base mw_19'></td>";
		rowCon += "</tr>";
		rowCon += "</tbody>";
		rowCon += "<thead>";
		rowCon += "<tr>";
		rowCon += "<th colspan='4'>"+addMoreSup+"</th>";
		rowCon += "</tr>";
		rowCon += "</thead>";
		rowCon += "</table>";
		rowCon += "<input type='hidden' name='purchase_cnt_"+nRw+"_1' id='purchase_cnt_"+nRw+"_1' value='1'>";
		rowCon += "</td>";

		rowCon += "<td colspan='3' class='v_a_base'>";
		rowCon += "<table id='import_table_"+nRw+"_1_1' class='trad_ac_import_tbl table table-borderless'>";
		rowCon += "<thead></thead>";
		rowCon += "<tbody>";
		rowCon += "<tr>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+importCnt+"</div><div class='sugg-box autocomp'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+importQnt+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+importVal+"</div></td>";
		rowCon += "<td class='v_a_base mw_19'></td>";
		rowCon += "</tr>";
		rowCon += "</tbody>";
		rowCon += "<thead>";
		rowCon += "<tr>";
		rowCon += "<th colspan='4'>"+addMoreImport+"</th>";
		rowCon += "</tr>";
		rowCon += "</thead>";
		rowCon += "</table>";
		rowCon += "<input type='hidden' name='import_cnt_"+nRw+"_1' id='import_cnt_"+nRw+"_1' value='1'>";
		rowCon += "</td>";

		if(secNo == 3){
			rowCon += "<td class='v_a_base'>"+consQnt+"</td>";
			rowCon += "<td class='v_a_base'>"+consVal+"</td>";
		}

		rowCon += "<td colspan='3' class='v_a_base'>";
		rowCon += "<table id='buyer_table_"+nRw+"_1_1' class='trad_ac_buyer_tbl table table-borderless'>";
		rowCon += "<thead></thead>";
		rowCon += "<tbody>";
		rowCon += "<tr>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+buyerRegno+"</div><div class='err_cv'></div><div class='sugg-box autocomp'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+buyerQnt+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base'><div class='input text'>"+buyerVal+"</div><div class='err_cv'></div></td>";
		rowCon += "<td class='v_a_base mw_19'></td>";
		rowCon += "</tr>";
		rowCon += "</tbody>";
		rowCon += "<thead>";
		rowCon += "<tr>";
		rowCon += "<th colspan='4'>"+addMoreBuyer+"</th>";
		rowCon += "</tr>";
		rowCon += "</thead>";
		rowCon += "</table>";
		rowCon += "<input type='hidden' name='despatch_cnt_"+nRw+"_1' id='despatch_cnt_"+nRw+"_1' value='1'>";
		rowCon += "</td>";

		rowCon += "<td class='v_a_base'>"+closStock+"</td>";
		// rowCon += "<td class='v_a_base'>"+remark+"</td>";

		rowCon += "<td class='v_a_base'><i class='fa fa-times btn-rem btn_rem_mineral'></i></td>";
		rowCon += "</tr>";
		rowCon += "<tr class='main_tr'>";
		rowCon += "<td colspan='12'>"+addMoreGrade+"</td>";
		rowCon += "</tr>";

		$('#trad_ac_tbl .main_tbody').append(rowCon);

		var c_row_total = $('#trad_ac_tbl .main_tbody .c_row').length;
		$('#c_row_count').val(c_row_total);
		tradAcCounts();
        tradAcNil();

	});

	$(document).on('click','#frmActivityDetails #trad_ac_tbl .trad_ac_grade_tbl .btn_rem_supplier',function(){

		var tId = $(this).closest('table').attr('id');
		var tIdArr = tId.split('_');
		var mId = tIdArr[2]+"_"+tIdArr[3];
		
		$(this).closest('tr').remove();
		tradAcRqvRw('#'+tId, '.supplier_registration', 'reg_no_'+mId, '.supplier_quantity', 'supplier_quantity_'+mId, '.supplier_value', 'supplier_value_'+mId);
		tradAcDelRwSyn('#'+tId);
		tradAcCounts();

	});
	
	$(document).on('click','#frmActivityDetails #trad_ac_tbl .trad_ac_import_tbl .btn_rem_import',function(){

		var tId = $(this).closest('table').attr('id');
		var tIdArr = tId.split('_');
		var mId = tIdArr[2]+"_"+tIdArr[3];

		$(this).closest('tr').remove();
		tradAcRqvRw('#'+tId, '.import_country', 'import_country_'+mId, '.import_quantity', 'import_quantity_'+mId, '.import_value', 'import_value_'+mId);
		tradAcDelRwSyn('#'+tId);
		tradAcCounts();

	});
	
	$(document).on('click','#frmActivityDetails #trad_ac_tbl .trad_ac_buyer_tbl .btn_rem_buyer',function(){

		var tId = $(this).closest('table').attr('id');
		var tIdArr = tId.split('_');
		var mId = tIdArr[2]+"_"+tIdArr[3];

		var secNo = $('#section_no').val();
		var buyerClass = (secNo == 2) ? '.buyer_country' : '.buyer_registration';

		$(this).closest('tr').remove();
		tradAcRqvRw('#'+tId, buyerClass, 'buyer_regNo_'+mId, '.buyer_quantity', 'buyer_quantity_'+mId, '.buyer_value', 'buyer_value_'+mId);
		tradAcDelRwSyn('#'+tId);
		tradAcCounts();

	});
	
	$(document).on('click','#frmActivityDetails #trad_ac_tbl .btn_rem_grade',function(){

		// var closStckId = $(this).closest('tr').find('td:last').prev().prev().find('.closing_stock').attr('id');
		var closStckId = $(this).closest('tr').find('td:last').prev().find('.closing_stock').attr('id');
		var closStckIdArr = closStckId.split('_');
		var mId = closStckIdArr[2];
		var rwId = closStckIdArr[3];
		var secNo = $('#frmActivityDetails #section_no').val();

		var rwCl = $(this).closest('tr').attr('class');
		var tRwSpan = $('#trad_ac_tbl #c_row_'+mId).find('td:first').attr('rowspan');
		tRwSpan = parseInt(tRwSpan);
		var nTRwSpan = parseInt(tRwSpan) - 1;

		var nRw = 2;
		for(var cnRw=1; cnRw < tRwSpan; cnRw++){

			if(cnRw != rwId && cnRw != '1'){
				
				var msId = mId+'_'+cnRw;
				var nmsId = mId+'_'+nRw;
				var gradeEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(1) .grade');
				gradeEl.attr('name','grade_'+nmsId);
				gradeEl.attr('id','grade_'+nmsId);
				
				var opnstkEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(2) .opening_stock_quantity');
				opnstkEl.attr('name','opening_stock_quantity_'+nmsId);
				opnstkEl.attr('id','opening_stock_quantity_'+nmsId);

				//supplier
				tradAcRqvRw('#supplier_table_'+msId+'_1', '.supplier_registration', 'reg_no_'+nmsId, '.supplier_quantity', 'supplier_quantity_'+nmsId, '.supplier_value', 'supplier_value_'+nmsId);
				$('#supplier_table_'+msId+'_1 thead .supplier_add_more').attr('id','add_more_supplier_'+nmsId+'_1');
				$('#supplier_table_'+msId+'_1').attr('id','supplier_table_'+nmsId+'_1');
				
				//import
				tradAcRqvRw('#import_table_'+msId+'_1', '.import_country', 'import_country_'+nmsId, '.import_quantity', 'import_quantity_'+nmsId, '.import_value', 'import_value_'+nmsId);
				$('#import_table_'+msId+'_1 thead .import_add_more').attr('id','add_more_import_'+nmsId+'_1');
				$('#import_table_'+msId+'_1').attr('id','import_table_'+nmsId+'_1');

				//ore consumed
				if(secNo == 3){
					var consQnt = $('#trad_ac_tbl .c_row_'+msId+' .consume_quantity');
					consQnt.attr('name','consumeQuantity_'+nmsId);
					consQnt.attr('id','consumeQuantity_'+nmsId);
					
					var consVal = $('#trad_ac_tbl .c_row_'+msId+' .consume_value');
					consVal.attr('name','consumeValue_'+nmsId);
					consVal.attr('id','consumeValue_'+nmsId);
				}
				
				//buyer
				tradAcRqvRw('#buyer_table_'+msId+'_1', '.buyer_registration', 'buyer_regNo_'+nmsId, '.buyer_quantity', 'buyer_quantity_'+nmsId, '.buyer_value', 'buyer_value_'+nmsId);
				$('#buyer_table_'+msId+'_1 thead .add_more_buyer_btn').attr('id','add_more_buyer_'+nmsId+'_1');
				$('#buyer_table_'+msId+'_1').attr('id','buyer_table_'+nmsId+'_1');
				
				// var clostkEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(6) .closing_stock');
				var clostkEl = $('#trad_ac_tbl .c_row_'+msId+' .closing_stock');
				clostkEl.attr('name','closing_stock_'+nmsId);
				clostkEl.attr('id','closing_stock_'+nmsId);

				$('#trad_ac_tbl .c_row_'+msId).attr('class','c_row_'+nmsId+' main_tr');
				
				nRw++;
			}

		}

		$('#trad_ac_tbl #c_row_'+mId).find('td:first').attr('rowspan',nTRwSpan);
		$(this).closest('tr').remove();
		tradAcCounts();

	});

	
	$(document).on('click','#frmActivityDetails #trad_ac_tbl .btn_rem_mineral',function(){

		var mIdRw = $(this).closest('tr').attr('id');
		var mIdRwArr = mIdRw.split('_');
		var mId = mIdRwArr[2];
		var secNo = $('#frmActivityDetails #section_no').val();
		
		var tRwSpan = $('#trad_ac_tbl #'+mIdRw).find('td:first').attr('rowspan');
		tRwSpan = parseInt(tRwSpan);
		var nTRwSpan = parseInt(tRwSpan) - 1;

		var cRw = $('#trad_ac_tbl .main_tbody .c_row').length;
		
		$('#trad_ac_tbl .c_row_'+mId+'_'+nTRwSpan).next().remove();
		for(var cnt=1; cnt < tRwSpan; cnt++){

			$('#trad_ac_tbl .c_row_'+mId+'_'+cnt).remove();

		}

		var nRw = 2;
		for(var rwc=1; rwc <= cRw; rwc++){

			if(rwc != mId && rwc != '1'){

				var rwSpan = $('#trad_ac_tbl #c_row_'+rwc).find('td:first').attr('rowspan');
				rwSpan = parseInt(rwSpan);

				for(var cr=1; cr <= rwSpan; cr++){

					var msId = rwc+'_'+cr;
					var nmsId = nRw+'_'+cr;

					if(cr == 1){

						var mineralEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(1) .mineral');
						mineralEl.attr('name','mineral_'+nRw);
						mineralEl.attr('id','mineral_'+nRw);

						var gradeEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(2) .grade');
						gradeEl.attr('name','grade_'+nmsId);
						gradeEl.attr('id','grade_'+nmsId);

						var opnstkEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(3) .opening_stock_quantity');
						opnstkEl.attr('name','opening_stock_quantity_'+nmsId);
						opnstkEl.attr('id','opening_stock_quantity_'+nmsId);

						//supplier
						tradAcRqvRw('#supplier_table_'+msId+'_1', '.supplier_registration', 'reg_no_'+nmsId, '.supplier_quantity', 'supplier_quantity_'+nmsId, '.supplier_value', 'supplier_value_'+nmsId);
						$('#supplier_table_'+msId+'_1 thead .supplier_add_more').attr('id','add_more_supplier_'+nmsId+'_1');
						$('#supplier_table_'+msId+'_1').attr('id','supplier_table_'+nmsId+'_1');

						//import
						tradAcRqvRw('#import_table_'+msId+'_1', '.import_country', 'import_country_'+nmsId, '.import_quantity', 'import_quantity_'+nmsId, '.import_value', 'import_value_'+nmsId);
						$('#import_table_'+msId+'_1 thead .import_add_more').attr('id','add_more_import_'+nmsId+'_1');
						$('#import_table_'+msId+'_1').attr('id','import_table_'+nmsId+'_1');
						
						//ore consumed
						if(secNo == 3){
							var consQnt = $('#trad_ac_tbl .c_row_'+msId+' .consume_quantity');
							consQnt.attr('name','consumeQuantity_'+nmsId);
							consQnt.attr('id','consumeQuantity_'+nmsId);
							
							var consVal = $('#trad_ac_tbl .c_row_'+msId+' .consume_value');
							consVal.attr('name','consumeValue_'+nmsId);
							consVal.attr('id','consumeValue_'+nmsId);
						}
						
						//buyer
						tradAcRqvRw('#buyer_table_'+msId+'_1', '.buyer_registration', 'buyer_regNo_'+nmsId, '.buyer_quantity', 'buyer_quantity_'+nmsId, '.buyer_value', 'buyer_value_'+nmsId);
						$('#buyer_table_'+msId+'_1 thead .add_more_buyer_btn').attr('id','add_more_buyer_'+nmsId+'_1');
						$('#buyer_table_'+msId+'_1').attr('id','buyer_table_'+nmsId+'_1');
						
						// var clostkEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(7) .closing_stock');
						var clostkEl = $('#trad_ac_tbl .c_row_'+msId+' .closing_stock');
						clostkEl.attr('name','closing_stock_'+nmsId);
						clostkEl.attr('id','closing_stock_'+nmsId);
						
						var mainRw = $('#trad_ac_tbl .c_row_'+msId);
						mainRw.attr('id','c_row_'+nRw);
						mainRw.attr('class','c_row_'+nRw+'_1 main_tr c_row');

					} else if(cr != rwSpan){
						
						var gradeEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(1) .grade');
						gradeEl.attr('name','grade_'+nmsId);
						gradeEl.attr('id','grade_'+nmsId);

						var opnstkEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(2) .opening_stock_quantity');
						opnstkEl.attr('name','opening_stock_quantity_'+nmsId);
						opnstkEl.attr('id','opening_stock_quantity_'+nmsId);

						//supplier
						tradAcRqvRw('#supplier_table_'+msId+'_1', '.supplier_registration', 'reg_no_'+nmsId, '.supplier_quantity', 'supplier_quantity_'+nmsId, '.supplier_value', 'supplier_value_'+nmsId);
						$('#supplier_table_'+msId+'_1 thead .supplier_add_more').attr('id','add_more_supplier_'+nmsId+'_1');
						$('#supplier_table_'+msId+'_1').attr('id','supplier_table_'+nmsId+'_1');

						//import
						tradAcRqvRw('#import_table_'+msId+'_1', '.import_country', 'import_country_'+nmsId, '.import_quantity', 'import_quantity_'+nmsId, '.import_value', 'import_value_'+nmsId);
						$('#import_table_'+msId+'_1 thead .import_add_more').attr('id','add_more_import_'+nmsId+'_1');
						$('#import_table_'+msId+'_1').attr('id','import_table_'+nmsId+'_1');
						
						//ore consumed
						if(secNo == 3){
							var consQnt = $('#trad_ac_tbl .c_row_'+msId+' .consume_quantity');
							consQnt.attr('name','consumeQuantity_'+nmsId);
							consQnt.attr('id','consumeQuantity_'+nmsId);
							
							var consVal = $('#trad_ac_tbl .c_row_'+msId+' .consume_value');
							consVal.attr('name','consumeValue_'+nmsId);
							consVal.attr('id','consumeValue_'+nmsId);
						}
						
						//buyer
						tradAcRqvRw('#buyer_table_'+msId+'_1', '.buyer_registration', 'buyer_regNo_'+nmsId, '.buyer_quantity', 'buyer_quantity_'+nmsId, '.buyer_value', 'buyer_value_'+nmsId);
						$('#buyer_table_'+msId+'_1 thead .add_more_buyer_btn').attr('id','add_more_buyer_'+nmsId+'_1');
						$('#buyer_table_'+msId+'_1').attr('id','buyer_table_'+nmsId+'_1');
						
						// var clostkEl = $('#trad_ac_tbl .c_row_'+msId+' td:nth-child(6) .closing_stock');
						var clostkEl = $('#trad_ac_tbl .c_row_'+msId+' .closing_stock');
						clostkEl.attr('name','closing_stock_'+nmsId);
						clostkEl.attr('id','closing_stock_'+nmsId);

						var mainRw = $('#trad_ac_tbl .c_row_'+msId);
						mainRw.attr('class','c_row_'+nmsId+' main_tr');

					} else {

						var addMoreGrade = $('#trad_ac_tbl #add_grade_'+rwc);
						addMoreGrade.attr('id','add_grade_'+nRw);

					}

				}

				nRw++;

			}

		}
		
		var c_row_total = $('#trad_ac_tbl .main_tbody .c_row').length;
		$('#c_row_count').val(c_row_total);
		tradAcCounts();
        tradAcNil();

	});

	// SHOW HIDE READ MORE TEXT

	$('#frmActivityDetails').on('click', '#read_more_link_1', function() {

		$('#frmActivityDetails #read_more_text_1').show();
		$('#frmActivityDetails #read_more_link_1').hide();
		$('#frmActivityDetails #hide_text_link_1').show();

	});
	
	$('#frmActivityDetails').on('click', '#hide_text_link_1', function() {

		$('#frmActivityDetails #read_more_text_1').hide();
		$('#frmActivityDetails #hide_text_link_1').hide();
		$('#frmActivityDetails #read_more_link_1').show();

	});
	
	$('#frmActivityDetails').on('click', '#read_more_link_2', function() {

		$('#frmActivityDetails #read_more_text_2').show();
		$('#frmActivityDetails #read_more_link_2').hide();
		$('#frmActivityDetails #hide_text_link_2').show();

	});
	
	$('#frmActivityDetails').on('click', '#hide_text_link_2', function() {

		$('#frmActivityDetails #read_more_text_2').hide();
		$('#frmActivityDetails #hide_text_link_2').hide();
		$('#frmActivityDetails #read_more_link_2').show();

	});


});

function tradAcRqvRw(tId, regCl, regIn, qntCl, qntIn, valCl, valIn){

	var rowCn = $(tId+' tbody tr').length;

	for(var cnRw=1;cnRw <= rowCn; cnRw++){

		var reg_num = $(tId+' tbody tr:nth-child('+cnRw+') td:nth-child(1) '+regCl);
		reg_num.attr('name',regIn+'_'+cnRw);
		reg_num.attr('id',regIn+'_'+cnRw);
		
		var qnt = $(tId+' tbody tr:nth-child('+cnRw+') td:nth-child(2) '+qntCl);
		qnt.attr('name',qntIn+'_'+cnRw);
		qnt.attr('id',qntIn+'_'+cnRw);
		
		var amnt = $(tId+' tbody tr:nth-child('+cnRw+') td:nth-child(3) '+valCl);
		amnt.attr('name',valIn+'_'+cnRw);
		amnt.attr('id',valIn+'_'+cnRw);

	}

}

function tradAcDelRw(tId, btnCl){

	$(tId+' tbody tr td:nth-child(4)').html("<i class='fa fa-times btn-rem "+btnCl+"'></i>");
}

function tradAcDelRwSyn(tId){

	var rowCn = $(tId+' tbody tr').length;
	if(rowCn == 1){
		$(tId+' tbody tr:first td:nth-child(4)').html("");
	}

}

function tradAcCounts(){

	upCntRec();
	var mineralCnt = $('#trad_ac_tbl .main_tbody .c_row').length;
	$('#c_row_count').val(mineralCnt);
	$('#mineral_cnt').val(mineralCnt);

	for(var nrw=1; nrw<=mineralCnt; nrw++){

		var mineralRw = $('#trad_ac_tbl #c_row_'+nrw+' td:first').attr('rowspan');
		var gradeCnt = parseInt(mineralRw)-1;
		$('#trad_ac_tbl #grade_cnt_'+nrw).val(gradeCnt);

	}

	var minRw = $('#frmActivityDetails #mineral_cnt').val();
	for(var nrw=1; nrw<=minRw; nrw++){

		var gradeCnt = $('#trad_ac_tbl #grade_cnt_'+nrw).val();
		for(var rw=1; rw<=gradeCnt; rw++){

			//supplier
			var mrw = nrw+'_'+rw;
			var supCnt = $('#trad_ac_tbl #supplier_table_'+mrw+'_1 tbody tr').length;
			$('#trad_ac_tbl #purchase_cnt_'+mrw).val(supCnt);
			
			//import
			var impCnt = $('#trad_ac_tbl #import_table_'+mrw+'_1 tbody tr').length;
			$('#trad_ac_tbl #import_cnt_'+mrw).val(impCnt);
			
			//buyer
			var buyerCnt = $('#trad_ac_tbl #buyer_table_'+mrw+'_1 tbody tr').length;
			$('#trad_ac_tbl #despatch_cnt_'+mrw).val(buyerCnt);

		}

	}
	
}

function upCntRec(){

	var gradeArrMoreCnt = $('.grade_add_more').length;
	for(var gamr=1; gamr<=gradeArrMoreCnt; gamr++){

		var nxtGraadeCnt = $('#trad_ac_tbl #add_grade_'+gamr).next();
		nxtGraadeCnt.prop('name','grade_cnt_'+gamr);
		nxtGraadeCnt.prop('id','grade_cnt_'+gamr);

	}
	
	var tradAcGradeTbl = $('.trad_ac_grade_tbl').length;
	for(var supCntRw=0; supCntRw<tradAcGradeTbl; supCntRw++){

		var tradAcGradeTblId = $('#trad_ac_tbl .trad_ac_grade_tbl').eq(supCntRw).attr('id');
		var tradAcGradeTblCntRw = tradAcGradeTblId.split('_');
		var tradAcGradeTblCnt = $('#trad_ac_tbl .trad_ac_grade_tbl').eq(supCntRw).next();
		tradAcGradeTblCnt.prop('name','purchase_cnt_'+tradAcGradeTblCntRw[2]+'_'+tradAcGradeTblCntRw[3]);
		tradAcGradeTblCnt.prop('id','purchase_cnt_'+tradAcGradeTblCntRw[2]+'_'+tradAcGradeTblCntRw[3]);

	}
	
	var tradAcImportTbl = $('.trad_ac_import_tbl').length;
	for(var impCntRw=0; impCntRw<tradAcImportTbl; impCntRw++){

		var tradAcImportTblId = $('#trad_ac_tbl .trad_ac_import_tbl').eq(impCntRw).attr('id');
		var tradAcImportTblCntRw = tradAcImportTblId.split('_');
		var tradAcImportTblCnt = $('#trad_ac_tbl .trad_ac_import_tbl').eq(impCntRw).next();
		tradAcImportTblCnt.prop('name','import_cnt_'+tradAcImportTblCntRw[2]+'_'+tradAcImportTblCntRw[3]);
		tradAcImportTblCnt.prop('id','import_cnt_'+tradAcImportTblCntRw[2]+'_'+tradAcImportTblCntRw[3]);

	}
	
	var tradAcBuyerTbl = $('.trad_ac_buyer_tbl').length;
	for(var buyerCntRw=0; buyerCntRw<tradAcBuyerTbl; buyerCntRw++){

		var tradAcBuyerTblId = $('#trad_ac_tbl .trad_ac_buyer_tbl').eq(buyerCntRw).attr('id');
		var tradAcBuyerTblCntRw = tradAcBuyerTblId.split('_');
		var tradAcBuyerTblCnt = $('#trad_ac_tbl .trad_ac_buyer_tbl').eq(buyerCntRw).next();
		tradAcBuyerTblCnt.prop('name','despatch_cnt_'+tradAcBuyerTblCntRw[2]+'_'+tradAcBuyerTblCntRw[3]);
		tradAcBuyerTblCnt.prop('id','despatch_cnt_'+tradAcBuyerTblCntRw[2]+'_'+tradAcBuyerTblCntRw[3]);

	}

}

function tradAcNil(){

    var cRowCount = $('#c_row_count').val();
    if(cRowCount > 1){
        $('.mineral option[value="NIL"]').remove();
    } else {
        if($('.mineral option[value="NIL"]').length == 0){
            $('.mineral').append('<option value="NIL">NIL</option>');
        }
    }

}

// Remove select and input element from fields for MMS view
// This is done for text-wrapping input values
$(document).ready(function() {

	if ($('#main_sec_parse').length > 0) {

		$('#trad_ac_tbl select').each(function(i, el) {

			var selInDiv = $(el).parent();
			var selText = selInDiv.find(':selected').text();

			var selTit = $(el).attr('title');
			if (typeof selTit !== 'undefined' && selTit !== false) {
				selInDiv.attr('title', selTit);
			}

			if ($(el).hasClass("in_old")) {
				selInDiv.addClass('in_old p-1 rounded');
			}
			
			if ($(el).hasClass("in_new")) {
				selInDiv.addClass('in_new p-1 rounded');
			}
			
			if ($(el).hasClass("in_modified")) {
				selInDiv.addClass('in_modified p-1 rounded');
			}

			selInDiv.html(selText);

		});
		
		$('#trad_ac_tbl input:not(:hidden)').each(function(i, el) {

			var inDiv = $(el).parent();
			var inText = $(el).val();

			var inTit = $(el).attr('title');
			if (typeof inTit !== 'undefined' && inTit !== false) {
				inDiv.attr('title', inTit);
			}

			if ($(el).hasClass("in_old")) {
				inDiv.addClass('in_old p-1 rounded');
			}
			
			if ($(el).hasClass("in_new")) {
				inDiv.addClass('in_new p-1 rounded');
			}
			
			if ($(el).hasClass("in_modified")) {
				inDiv.addClass('in_modified p-1 rounded');
			}
				
			inDiv.text(inText);

		});

		$('.trad_ac_grade_tbl tbody tr td:nth-child(1)').addClass('w_32_p');
		$('.trad_ac_grade_tbl tbody tr td:nth-child(2)').addClass('text-center');
		$('.trad_ac_grade_tbl tbody tr td:nth-child(3)').addClass('text-center');
		$('.trad_ac_import_tbl tbody tr td:nth-child(1)').addClass('w_32_p');
		$('.trad_ac_import_tbl tbody tr td:nth-child(2)').addClass('text-center');
		$('.trad_ac_import_tbl tbody tr td:nth-child(3)').addClass('text-center');
		$('.trad_ac_buyer_tbl tbody tr td:nth-child(1)').addClass('w_32_p');
		$('.trad_ac_buyer_tbl tbody tr td:nth-child(2)').addClass('text-center');
		$('.trad_ac_buyer_tbl tbody tr td:nth-child(3)').addClass('text-center');
	}

});
