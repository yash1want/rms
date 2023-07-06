
/**
 * DYNAMIC FORM CREATION BY USING ARRAYS
 * @version : 22th JUL 2021
 * @contributors >----------
 * @author	: Aniket Ganvir
 * @author	: Pravin Bhakare
 * @author	: Amol Chodhari
 */

/*$(document).ready(function(){
	$('.count-text').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 2000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});
});
*/

$(document).ready(function(){

	// var tableFormData = $('#formdata').val();
	// alert(tableFormData);
	setTimeout(function(){
		addClassInput();
	},100);
	var tableFormD = document.getElementById('formdata').value;
	// console.log(tableFormD);
    var tableFormData = (tableFormD != '') ? JSON.parse(tableFormD) : Array();

	$(document).on('click', '#table_1 #add_more', function() {
		var tblId = $(this).closest('table').attr('id');
		var tblIdArr = tblId.split('_');
		var tblIdNum = tblIdArr[1];
		addMoreRow(tblIdNum);
	});

	$(document).on('click', '#table_1 .remove_btn_btn', function() {
		var tblId = $(this).closest('table').attr('id');
		var tblIdArr = tblId.split('_');
		var tblIdNum = tblIdArr[1];
		var trId = $(this).closest('tr').attr('id');
		remRow(trId, tblIdNum);
	});

	createFormStruct(tableFormData);
	
});

function createFormStruct(tableFormArr){

	var tableRw = JSON.parse(JSON.stringify(tableFormArr));
	//console.log(tableRw);
	var tRw = 0;
	$.each(tableRw, function(index, value){

		var tabRw = tRw + parseInt(1);
		var tableForm = $('#table_container_'+tabRw);
		
		var tableContainer = "";
		// var mainRowContainer = "";
		tableContainer += '<input type="hidden" name="row_count_'+tabRw+'" id="row-count-'+tabRw+'" value="1">';
		tableContainer += "<table id='table_"+tabRw+"' class='table table-bordered table_form'>";
		tableContainer += "<thead class='table-light table_head'>";
		
		var tableFormHead = $('.table_form .table_head');
		var tableArr = JSON.parse(JSON.stringify(tableFormArr[tRw]));
		
		$.each(tableArr.label, function(index, value){
			
			tableContainer += "<tr>";
			
			$.each(this, function(index, value){
				tableContainer += "<th";
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
		tableContainer += "<tbody class='table_body'>";
		
		var rowsC = 1;
		
		$.each(tableArr.input, function(index, value){
		
			tableContainer += "<tr id='row_container-"+rowsC+"'>";
			
			var tableFormBody = $('.table_form .table_body');
			var mainRowContainer = "";
			
			$.each(this, function(index, value){
				
				var inputName = this.name + "[]";
				var inputId = "ta-" + this.name + "-"+rowsC;
				var inputType = this.type;
				var inputValid = this.valid;
				var inputLength = this.length;
				var inputOptions = this.option;
				var inputOptActive = this.selected;
				var compval = (this.compval == null) ? '' : 'compval="'+this.compval+'" ';
				var compwith = (this.compwith == null) ? '' : 'compwith="ta-'+this.compwith+'-'+rowsC+'" ';
				var msgname = (this.msgname == null) ? '' : 'msgname="'+this.msgname+'" ';
				// var inputMaxLenTxt = (this.maxlength == null) ? '' : '"maxlength"=>"';
				// var inputMaxLenVal = (this.maxlength == null) ? '' : this.maxlength + '",';
				var inputMaxLenVal = (this.maxlength == null) ? '' : this.maxlength;
				var inputOnchange = (this.onchange == null) ? '' : 'onchange=\''+this.onchange+'\'';
				var inputClass = (this.class == null) ? "" : this.class;
				var inputPlaceholder = (this.placeholder == null) ? "" :  'placeholder="'+this.placeholder+'" ';
				var inputClassArr = inputClass.split(" ");
				var inputAutocomplete = "";
				var mainInputAutocomplete = "";
				if($.inArray("nameOne", inputClassArr) !== -1){
					inputAutocomplete += "<div id='ta-suggestion_box-"+rowsC+"' class='sugg-box autocomp'></div>";
					mainInputAutocomplete += "<div id='ta-suggestion_box-"+rowsC+"' class='sugg-box autocomp'></div>";
				}

				var inputValue = (this.value == null) ? "" : this.value;
				var inputMax = (this.max == null) ? "" : this.max;
				var inputReadonly = (this.readonly == null) ? '' : ' readonly="'+this.readonly+'"';
				
				var cvfloat = (this.cvfloat == null) ? "" : 'cvfloat="'+this.cvfloat+'" '; // added on 05-08-2022 by Aniket
				
				tableContainer += (inputType == 'hidden') ? "" : "<td>";
				mainRowContainer += (inputType == 'hidden') ? "" : "<td>";
				
				var selectContainer = '<select name="'+inputName+'" id="'+inputId+'" class="form-control input-field '+inputClass+'" '+inputOnchange+''+inputReadonly+'>';
				var mainSelectContainer = '<select name="'+inputName+'" id="'+inputId+'" class="form-control input-field '+inputClass+'" '+inputOnchange+''+inputReadonly+'>';
				selectContainer += "<option value=''>--select--</option>";
				mainSelectContainer += "<option value=''>--select--</option>";
				$.each(inputOptions, function(){
					
					var optionValue = this.vall;
					var optionLabel = this.label;
					var optActive = (inputOptActive == optionValue) ? "selected" : "";
					selectContainer += "<option value='"+optionValue+"' "+optActive+" >"+optionLabel+"</option>";
					mainSelectContainer += "<option value='"+optionValue+"' >"+optionLabel+"</option>";
					
				});
				
				selectContainer += "</select>";
				mainSelectContainer += "</select>";

				//input type file
				var webroot_url = $('#webroot_url').val(); 
				
				//To get file name on preview on 21-10-2022
				/* var sp = inputValue.split("/");
				 var str = String(sp[1]);
				 var previewDoc = str.substr(23);*/
				
				var previewFile = (inputType == 'file' && inputValue != '') ? '<div><a href="'+webroot_url+decodeURIComponent(inputValue)+'" target="_blank">Preview File</a></div>' : '';
				tableContainer += '<div>';
				tableContainer += 	(this.name == null) ? '<span class="serial_no">'+rowsC+'</span>' : 
									(inputType == 'textarea') ? '<textarea name="' + inputName + '" id="'+inputId+'" value="'+inputValue+'" class=>"form-control input-field '+inputClass+'"'+inputReadonly+'>' :
									(inputType == 'hidden') ? '<input name="' + inputName + '" '+msgname+' type="'+inputType+'" id="'+inputId+'" value="'+inputValue+'" class="form-control input-field"'+inputReadonly+'>' :
									(inputType == 'select') ? selectContainer : 
									(inputType == 'file') ? '<input name="' + inputName +'" type="'+inputType+'" id="'+inputId+'" class="form-control input-field '+inputClass+'" value="'+decodeURIComponent(inputValue)+'"><input name="hidden'+inputName+'" type="hidden" value="'+decodeURIComponent(inputValue)+'" class="hidden_doc">'+previewFile :
									'<input name="' + inputName + '" type="'+inputType+'" id="'+inputId+'" value="'+inputValue+'" class="form-control input-field '+inputClass+'" maxlength="'+inputMaxLenVal+'" max="'+inputMax+'"'+compval+'  '+compwith+'   ' +msgname+ '  '+inputPlaceholder+''+inputReadonly+' '+cvfloat+'>';
				tableContainer += '</div><div class="err_cv"></div>'+inputAutocomplete;

				mainRowContainer += '<div>';
				mainRowContainer += (this.name == null) ? '<span class="serial_no">'+rowsC+'</span>' : 
									(inputType == 'textarea') ? '<textarea name="' + inputName + '" id="'+inputId+'" class="form-control input-field '+inputClass+'"'+inputReadonly+'>' :
									(inputType == 'hidden') ? '<input name="' + inputName + '" '+msgname+' type="'+inputType+'" id="'+inputId+'" class="form-control input-field"'+inputReadonly+'>' :
									(inputType == 'select') ? mainSelectContainer : 
									(inputType == 'file') ? '<input name="' + inputName +'" type="'+inputType+'" id="'+inputId+'" class="form-control input-field '+inputClass+'"><input name="hidden'+inputName+'" type="hidden" class="hidden_doc">' :
									'<input name="' + inputName + '" type="'+inputType+'" id="'+inputId+'" class="form-control input-field '+inputClass+'" maxlength="'+inputMaxLenVal+'" max="'+inputMax+'" '+compval+'  '+compwith+'     ' +msgname+ '  '+inputPlaceholder+''+inputReadonly+' '+cvfloat+'>';
				mainRowContainer += '</div><div class="err_cv"></div>'+mainInputAutocomplete;
									
				tableContainer	+= (inputType == 'hidden') ? "" :  "</td>";
				mainRowContainer	+= (inputType == 'hidden') ? "" :  "</td>";
			});
			
			var rowId = "row_container-1";
			tableContainer += "<td class='remove_btn'>";
			tableContainer += "<button type='button' class='btn btn-sm btn-danger remove_btn_btn' ><i class='fa fa-times'></i></button>";
			tableContainer += "</td>";
			mainRowContainer += "<td class='remove_btn'>";
			mainRowContainer += "</td>";
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
		tableContainer += "<tbody id='addMoreRow'>";
		tableContainer += "<tr id='addmorebtn'>";
		tableContainer += "<td colspan='"+colsCount+"'>";
		tableContainer += "<div class='form-buttons text-right'><button type='button' id='add_more' class='btn btn-info btn-sm'><i class='fa fa-plus'></i> Add more</button></div>";
		tableContainer += "</td>";
		tableContainer += "</tr>";
		tableContainer += "</tbody>";
		tableContainer += "</table>";
		
		tableForm.append(tableContainer);

		checkDirectorDetRem(tabRw);

		tRw++;

	});
		
}

function addMoreRow(tabRw){

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
	rowContainer = rowContainer.replace(/compwith\=\"(.*?)\-(.*?)\-(.*?)\"/g, 'compwith\=\"$1\-$2\-'+incRow+'\"');
	rowContainer = rowContainer.replace(/class\=\'remove_btn\'\>(.*?)\</g, 'class\=\"remove_btn\"\>\<button type\=\"button\" class\=\"btn btn\-sm btn\-danger remove\_btn\_btn\" \><i class\=\"fa fa\-times\"\>\<\/\i\>\<\/button\>\<');
	rowContainer += "</tr>";
	
	//console.log(rowContainer);

	$('#table_'+tabRw).append(rowContainer);
	updateSerialNo(tabRw);
	checkDirectorDetRem(tabRw);

	$("input").attr("autocomplete","off");

	// $.getScript('../../js/sale-despatch.js');
	
}

function checkDirectorDetRem(tabRw){

	var totalRows = $('#table_'+tabRw+' .table_body tr').length;
	if(totalRows == 2){
		$('#table_'+tabRw+' .table_body tr:first button').removeAttr('disabled');
	} else if(totalRows == 1) {
		$('#table_'+tabRw+' .table_body tr:first button').attr('disabled','true');
	}

}

function remRow(parentId, tId){
	
	$('#table_'+tId+' #' + parentId).remove();
	updateSerialNo(tId);
	checkDirectorDetRem(tId);
	
}

function updateSerialNo(tId){
	
	var rowsCount = $('#table_'+tId+' .table_body tr').length;
	var i;
	for(i = 0; i < rowsCount; i++){
		var incI = i + parseInt(1);
		var thisAtt = $('#table_'+tId+' .table_body tr td .serial_no').eq(i).text(incI);
	}
	$('#row-count-'+tId).val(rowsCount);
	
}
// append class to all input fields to ajust width added by Shalini D Date : 07/03/2022
function addClassInput()
{
	//var Tcols = document.getElementById('table_1').rows[0].cells.length;
	var Tcols = $('#row_container-1 td').length;
	if(Tcols > 8)
	{
		$('#table_1 td :input').addClass('form_input_width');
	}
}

