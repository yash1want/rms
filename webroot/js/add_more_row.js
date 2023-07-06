
/**
 * DYNAMIC FORM CREATION BY USING ARRAYS
 * @addedon: 03rd MAR 2021 (by Aniket Ganvir)
 */
$(document).ready(function(){
	
	// $('#table_container').ready(function(){

	// 	var projectPath = $('#project_path').val();
	// 	$.getScript(projectPath+'js/mc.custom.validation.js');

	// });

	$(document).on('click', '#add_more', function() {
		var tblId = $(this).closest('table').attr('id');
		var tblIdArr = tblId.split('_');
		var tblIdNum = tblIdArr[1];
		addMoreRowMultiple(tblIdNum);
	});

	$(document).on('click', '.remove_btn_btn', function() {
		var tblId = $(this).closest('table').attr('id');
		var tblIdArr = tblId.split('_');
		var tblIdNum = tblIdArr[1];
		var trId = $(this).closest('tr').attr('id');
		remRowMultiple(trId, tblIdNum);
	});

	createFormStructMultiple(tableFormData);
	
});

function createFormStructMultiple(tableFormArr){

	var tableRw = JSON.parse(JSON.stringify(tableFormArr));
	var tRw = 0;
	$.each(tableRw, function(index, value){

		var tabRw = tRw + parseInt(1);
		var tableForm = $('#table_container_'+tabRw);
		
		var tableContainer = "";
		// var mainRowContainer = "";
		tableContainer += '<input type="hidden" name="row_count_'+tabRw+'" id="row-count-'+tabRw+'" value="1">';
		tableContainer += "<table id='table_"+tabRw+"' class='table table-bordered table-sm table_form'>";
		
		var tableFormHead = $('.table_form .table_head');
		var tableArr = JSON.parse(JSON.stringify(tableFormArr[tRw]));

		if (tableArr['label'][0][0]['col'] != null) {

			tableContainer += "<thead class='bg-secondary text-white table_head'>";
			
			$.each(tableArr.label, function(index, value){
				
				tableContainer += "<tr>";
				
				$.each(this, function(index, value){
					tableContainer += "<th class='align-middle text-center' ";
					tableContainer += (this.colspan > 1) ? " colspan='" + this.colspan + "'" : "";
					tableContainer += (this.rowspan > 1) ? " rowspan='" + this.rowspan + "'>" : ">";
					tableContainer += this.col;
					tableContainer += "</th>";
				});
				
				tableContainer += "<th>";
				tableContainer += "</th>";
				tableContainer += "</tr>";
			});
			
			tableContainer += "</thead>";
		}

		tableContainer += "<tbody class='table_body'>";
		
		var rowsC = 1;
		
		$.each(tableArr.input, function(index, value){
		
			tableContainer += "<tr id='row_container-"+rowsC+"'>";
			
			var tableFormBody = $('.table_form .table_body');
			var mainRowContainer = '';
			
			$.each(this, function(index, value)
			{
				
				var inputName = this.name + "[]";
				var inputId = "ta-" + this.name + "-"+rowsC;
				var inputType = this.type;
				// var inputValid = this.valid;
				// var inputLength = this.length;
				var inputOptions = this.option;
				var inputOptActive = this.selected;
				var inputMaxLenVal = (this.maxlength == null) ? '' : ' maxlength="'+this.maxlength+'"';
				var inputOnchange = (this.onchange == null) ? '' : 'onchange=\''+this.onchange+'\'';
				var inputClass = (this.class == null) ? "" : this.class;
				inputClass += (this.diff != null && this.diff != '') ? this.diff : "";
				var inputReadonly = (this.readonly == null) ? '' : ((this.readonly == true) ? 'readonly' : '');
				var inputDisabled = (this.disabled == null) ? '' : ((this.disabled == true) ? ' disabled' : '');
				var inputClassArr = inputClass.split(" ");
				var inputAutocomplete = "";
				var mainInputAutocomplete = "";
				if($.inArray("nameOne", inputClassArr) !== -1){
					inputAutocomplete += '<div id="ta-suggestion_box-'+rowsC+'" class="sugg-box autocomp"></div>';
					mainInputAutocomplete += '<div id="ta-suggestion_box-'+rowsC+'" class="sugg-box autocomp"></div>';
				}

				var inputValue = (this.value == null) ? "" : this.value;
				var inputMax = (this.max == null) ? "" : ' max="'+this.max+'"';
				var inputMin = (this.min == null) ? "" : ' min="'+this.min+'"';
				var inputTitle = (this.title != null && this.title != '') ? ' title="'+this.title+'"' : "";
				
				tableContainer += (inputType == 'hidden') ? "" : "<td>";
				mainRowContainer += (inputType == 'hidden') ? '' : '<td>';
				
				var selectContainer = "<div><select name='"+inputName+"' id='"+inputId+"' class='form-control form-control-sm input-field "+inputClass+"' "+inputOnchange+" "+inputTitle+">";
				var mainSelectContainer = '<div><select name="'+inputName+'" id="'+inputId+'" class="form-control form-control-sm input-field '+inputClass+'" '+inputOnchange+'>';
				if(inputOptions){

					$.each(inputOptions, function(){
						
						var optionValue = this.vall;
						var optionLabel = this.label;
						var optionCat = (this.mcat == null) ? '' : this.mcat;
						if (optionCat != '') {

							if (this.mcatsrno == 1) {
								selectContainer += '<optgroup label="'+optionCat+'">';
								mainSelectContainer += '<optgroup label="'+optionCat+'">';
							}

						}

						var optActive = (inputOptActive == optionValue) ? "selected" : "";
						selectContainer += "<option value='"+optionValue+"' "+optActive+" >"+optionLabel+"</option>";
						mainSelectContainer += "<option value='"+optionValue+"' >"+optionLabel+"</option>";

						if (optionCat != '') {

							if (this.mcatsrno == this.mcatrow) {
								selectContainer += '</optgroup>';
								mainSelectContainer += '</optgroup>';
							}

						}
						
					});

				}
				selectContainer += "</select></div>";
				mainSelectContainer += '</select></div>';
				
				tableContainer += 	(this.name == null) ? '<span class="serial_no">'+rowsC+'</span>' : 
									(inputType == 'textarea') ? '<div><textarea name="' + inputName + '" id="'+inputId+'" value="'+inputValue+'" class="form-control form-control-sm input-field '+inputClass+'" '+inputTitle+inputReadonly+inputDisabled+'></div>' :
									(inputType == 'hidden') ? '<input name="' + inputName + '" type="'+inputType+'" id="'+inputId+'" value="'+inputValue+'" class="form-control form-control-sm input-field">' :
									(inputType == 'select') ? selectContainer : 
									'<div><input name="' + inputName + '" type="'+inputType+'" id="'+inputId+'" value="'+inputValue+'" class="form-control form-control-sm input-field '+inputClass+'" '+inputMaxLenVal+' '+inputMax+' '+inputMin+' '+inputTitle+inputReadonly+inputDisabled+'></div>';
				tableContainer += '<div class="err_cv"></div>'+inputAutocomplete;


				mainRowContainer += (this.name == null) ? '<span class="serial_no">'+rowsC+'</span>' : 
									(inputType == 'textarea') ? '<div><textarea name="' + inputName + '" id="'+inputId+'" class="form-control form-control-sm input-field '+inputClass+' '+inputDisabled+'"></div>' :
									(inputType == 'hidden') ? '<input name="' + inputName + '" type="'+inputType+'" id="'+inputId+'" class="form-control form-control-sm input-field">' :
									(inputType == 'select') ? mainSelectContainer : 
									'<div><input name="' + inputName + '" type="'+inputType+'" id="'+inputId+'" class="form-control form-control-sm input-field '+inputClass+'" '+inputMaxLenVal+' '+inputMax+' '+inputMin+' '+inputDisabled+'></div>';
				mainRowContainer += '<div class="err_cv"></div>'+mainInputAutocomplete;
									
				tableContainer	+= (inputType == 'hidden') ? "" :  "</td>";
				mainRowContainer	+= (inputType == 'hidden') ? '' :  '</td>';
			});
		
			
			var rowId = "row_container-1";
			tableContainer += "<td class='remove_btn m_w_37'>";
			tableContainer += "<button type='button' class='btn btn-sm btn-danger remove_btn_btn'><i class='fa fa-times'></i></button>";
			tableContainer += "</td>";
			mainRowContainer += '<td class="remove_btn m_w_37">';
			mainRowContainer += '</td>';
			tableContainer += "</tr>";
			$('#main_row').val(mainRowContainer);

			tableForm.after('<input type="hidden" id="main_row_'+tabRw+'">');
			$('#main_row_'+tabRw).val(mainRowContainer);
			
			rowsC++;
		
		});

			
		var colsCount = 0;
		$.each(tableArr.label[0], function(){
			colsCount += parseInt(this.colspan);
		});
		colsCount ++;
		
		tableContainer += "</tbody>";
		tableContainer += "<tbody>";
		tableContainer += "<tr id='addmorebtn'>";
		tableContainer += "<td colspan='"+colsCount+"'>";
		tableContainer += "<div class='form-buttons text-right'><button type='button' id='add_more' class='btn btn-info btn-sm'><i class='fa fa-plus'></i> Add more</button></div>";
		tableContainer += "</td>";
		tableContainer += "</tr>";
		tableContainer += "</tbody>";
		tableContainer += "</table>";
		
		tableForm.append(tableContainer);

		checkDirectorDetRemMultiple(tabRw);

		tRw++;

	});
		
}

function addMoreRow(){

	var currentRow = $('.table_form .table_body tr:last').attr('id');
	var extractId = currentRow.split('-');
	var incRow = parseInt(extractId[1]) + parseInt(1);
	var valueBlank = "";
	
	var rowContainer = "<tr id='row_container-"+incRow+"'>";
	// rowContainer +=$('#row_container-1').html();
	rowContainer +=$('#main_row').val();
	rowContainer = rowContainer.replace(/name\=\"(.*?)\-(.*?)\-(.*?)\"/g, 'name\=\"$1\-$2\-'+incRow+'\"');
	rowContainer = rowContainer.replace(/id\=\'(.*?)\-(.*?)\-(.*?)\'/g, "id\=\'$1\-$2\-"+incRow+"\'");
	rowContainer = rowContainer.replace(/id\=\"(.*?)\-(.*?)\-(.*?)\"/g, 'id\=\"$1\-$2\-'+incRow+'\"');
	rowContainer = rowContainer.replace(/value\=\"(.*?)\"/g, 'value\=\"'+valueBlank+'\"');
	rowContainer = rowContainer.replace(/class\=\"serial_no\"\>(.*?)\</g, 'class\=\"serial_no\"\>'+incRow+'\<');
	rowContainer = rowContainer.replace(/class\=\'remove_btn m_w_37\'\>(.*?)\</g, 'class\=\"remove_btn m_w_37\"\>\<button type\=\"button\" class\=\"btn btn\-sm btn\-danger remove\_btn\_btn\" onclick\=\"remRow\(\'row_container\-'+incRow+'\'\)\"\><i class\=\"fa fa\-times\"\>\<\/\i\>\<\/button\>\<');
	rowContainer += "</tr>";
	
	$('.table_body').append(rowContainer);
	updateSerialNo();
	checkDirectorDetRem();

	$("input").attr("autocomplete","off");

	// $.getScript('../../js/sale-despatch.js');
	
}

function addMoreRowMultiple(tabRw){

	var currentRow = $('#table_'+tabRw+' .table_body tr:last').attr('id');
	var extractId = currentRow.split('-');
	var incRow = parseInt(extractId[1]) + parseInt(1);
	var valueBlank = "";
	
	var rowContainer = "<tr id='row_container-"+incRow+"'>";
	// rowContainer +=$('#row_container-1').html();
	rowContainer +=$('#main_row_'+tabRw).val();
	
	rowContainer = rowContainer.replace(/name\=\"(.*?)\-(.*?)\-(.*?)\"/g, 'name\=\"$1\-$2\-'+incRow+'\"');
	// rowContainer = rowContainer.replace(/id\=\'(.*?)\-(.*?)\-(.*?)\'/g, "id\=\'$1\-$2\-"+incRow+"\'");
	rowContainer = rowContainer.replace(/id\=\"(.*?)\-(.*?)\-(.*?)\"/g, 'id\=\"$1\-$2\-'+incRow+'\"');
	rowContainer = rowContainer.replace(/value\=\"(.*?)\"/g, 'value\=\"'+valueBlank+'\"');
	rowContainer = rowContainer.replace(/class\=\"serial_no\"\>(.*?)\</g, 'class\=\"serial_no\"\>'+incRow+'\<');
	rowContainer = rowContainer.replace(/class\=\"remove_btn m_w_37\"\>(.*?)\</g, 'class\=\"remove_btn m_w_37\"\>\<button type\=\"button\" class\=\"btn btn\-sm btn\-danger remove\_btn\_btn\" \><i class\=\"fa fa\-times\"\>\<\/\i\>\<\/button\>\<');
	rowContainer += "</tr>";
	
	$('#table_'+tabRw).append(rowContainer);
	updateSerialNoMultiple(tabRw);
	checkDirectorDetRemMultiple(tabRw);

	$("input").attr("autocomplete","off");

	var projectPath = $('#project_path').val();
	// $.getScript(projectPath+'js/sale-despatch.js');
	// $.getScript(projectPath+'js/mc.custom.validation.js');
	
}

function checkDirectorDetRem(){

	var totalRows = $('#directors_details_table .table_body tr').length;
	if(totalRows == 2){
		$('#directors_details_table .table_body tr:first button').removeAttr('disabled');
	} else if(totalRows == 1) {
		$('#directors_details_table .table_body tr:first button').attr('disabled','true');
	}

}

function checkDirectorDetRemMultiple(tabRw){

	var totalRows = $('#table_'+tabRw+' .table_body tr').length;
	if(totalRows == 2){
		$('#table_'+tabRw+' .table_body tr:first button').removeAttr('disabled');
	} else if(totalRows == 1) {
		$('#table_'+tabRw+' .table_body tr:first button').attr('disabled','true');
	}

}
	
function remRow(parentId){
	
	$('#' + parentId).remove();
	updateSerialNo();
	checkDirectorDetRem();
	
}

function remRowMultiple(parentId, tId){
	
	$('#table_'+tId+' #' + parentId).remove();
	updateSerialNoMultiple(tId);
	checkDirectorDetRemMultiple(tId);
	
}

function updateSerialNo(){
	
	var rowsCount = $('.table_body tr').length;
	var i;
	for(i = 0; i < rowsCount; i++){
		var incI = i + parseInt(1);
		var thisAtt = $('.table_body tr td .serial_no').eq(i).text(incI);
	}
	$('#row-count').val(rowsCount);
	
}

function updateSerialNoMultiple(tId){
	
	var rowsCount = $('#table_'+tId+' .table_body tr').length;
	var i;
	for(i = 0; i < rowsCount; i++){
		var incI = i + parseInt(1);
		var thisAtt = $('#table_'+tId+' .table_body tr td .serial_no').eq(i).text(incI);
	}
	$('#row-count-'+tId).val(rowsCount);
	
}

	