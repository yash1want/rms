
$(document).ready(function(){

	jQuery.validator.addMethod("roundOff1", function( value, element ) {
		var temp = new Number (value);
		element.value = (temp).toFixed(1);
		
		return true;
	}, "");

	jQuery.validator.addMethod("roundOff2", function( value, element ) {
		var temp = new Number (value);
		element.value = (temp).toFixed(2);
		
		return true;
	}, "");

	jQuery.validator.addMethod("roundOff3", function( value, element ) {
		alert('roundOff');
		var temp = new Number (value);
		element.value = (temp).toFixed(3);
		return true;
	}, "");
		
	// var metal_url = $('#get_metals_url').val();
	// var data_url = $('#get_con_data_url').val();
	// f5Con.init(metal_url, data_url);

	f5Con.ConQuantityDDValidation();
	f5Con.ConQuantityCustomValidation();
	// f5Con.MetaldropDownValidation();
	// f5Con.formConRecoF5Validation();
	f5Con.GradeDDValidation();
	// f5Con.romMetalGradeTotal();
	f5Con.conF5PostValidation();
	f5Con.romCheckGradeRequiredStar();
	f5Con.romCheckMetalRequiredStar();
	f5Con.oreTreatedQuantityValidation();
	f5Con.conTextFieldValidation();
	f5Con.autoFillForZeroProduction();

});

$(document).ready(function(){

	$('#frmConReco').on('change', '.open_ore_grade', function(){
		var grade_value = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		var select_box_value = $('#open_ore_metal_'+elIdRw).val();
		if (select_box_value != "" && select_box_value != 'NIL') {
			if (grade_value >= 100) {
				alert("Maximum grade value allowed is 99.99");
				$(this).val('');
				$('#error-check').val('1');
			}
			else if (grade_value <= 0) {
				alert("Please enter grade value greater than 0");
				$(this).val('');
				$('#error-check').val('1');
			}
			else {
				$('#error-check').val('0');
			}
		}
	});
	
	$('#frmConReco').on('change', '.rec_ore_grade', function(){
		var grade_value = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		var select_box_value = $('#rec_ore_metal_'+elIdRw).val();
		if (select_box_value != "" && select_box_value != 'NIL') {
			if (grade_value >= 100) {
				alert("Maximum grade value allowed is 99.99");
				$(this).val('');
				$('#error-check').val('1');
			}
			else if (grade_value <= 0) {
				alert("Please enter grade value greater than 0");
				$(this).val('');
				$('#error-check').val('1');
			}
			else {
				$('#error-check').val('0');
			}
		}
	});
	
	$('#frmConReco').on('change', '.treat_ore_grade', function(){
		var grade_value = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		var select_box_value = $('#treat_ore_metal_'+elIdRw).val();
		if (select_box_value != "" && select_box_value != 'NIL') {
			if (grade_value >= 100) {
				alert("Maximum grade value allowed is 99.99");
				$(this).val('');
				$('#error-check').val('1');
			}
			else if (grade_value <= 0) {
				alert("Please enter grade value greater than 0");
				$(this).val('');
				$('#error-check').val('1');
			}
			else {
				$('#error-check').val('0');
			}
		}
	});
	
	$('#frmConReco').on('change', '.con-obt-grade', function(){
		var grade_value = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		var select_box_value = $('#con_obt_metal_'+elIdRw).val();
		if (select_box_value != "" && select_box_value != 'NIL') {
			if (grade_value >= 100) {
				alert("Maximum grade value allowed is 99.99");
				$(this).val('');
				$('#error-check').val('1');
			}
			else if (grade_value <= 0) {
				alert("Please enter grade value greater than 0");
				$(this).val('');
				$('#error-check').val('1');
			}
			else {
				$('#error-check').val('0');
			}
		}
	});
	
	$('#frmConReco').on('change', '.tail_ore_grade', function(){
		var grade_value = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		var select_box_value = $('#tail_ore_metal_'+elIdRw).val();
		if (select_box_value != "" && select_box_value != 'NIL') {
			if (grade_value >= 100) {
				alert("Maximum grade value allowed is 99.99");
				$(this).val('');
				$('#error-check').val('1');
			}
			else if (grade_value <= 0) {
				alert("Please enter grade value greater than 0");
				$(this).val('');
				$('#error-check').val('1');
			}
			else {
				$('#error-check').val('0');
			}
		}
	});
	
	$('#frmConReco').on('change', '.close-con-grade', function(){
		var grade_value = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		var select_box_value = $('#close_con_metal_'+elIdRw).val();
		if (select_box_value != "" && select_box_value != 'NIL') {
			if (grade_value >= 100) {
				alert("Maximum grade value allowed is 99.99");
				$(this).val('');
				$('#error-check').val('1');
			}
			else if (grade_value <= 0) {
				alert("Please enter grade value greater than 0");
				$(this).val('');
				$('#error-check').val('1');
			}
			else {
				$('#error-check').val('0');
			}
		}
	});
	
	$('#frmConReco').on('change', '.open_ore_metal', function(){
		var openOreMetalCount = $('#open_ore_metal_count').val();
		var selEl = $(this);
		var selMetal = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		if(openOreMetalCount != 1){

			$('.open_ore_metal').each(function(){
				var otherElId = $(this).attr('id');
				if(elId != otherElId){
					var otherMetal = $(this).val();
					if(selMetal == otherMetal){
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
		var quantityFieldId = elIdArr[0] + "_" + elIdArr[1] + "_qty";
		var qty = ($('#'+quantityFieldId).val()=='')? 0 : $('#'+quantityFieldId).val();
		var metal = (selMetal=='NIL')? '' : selMetal;
		if(qty == 0 && metal!= '')
		{
			var buttonClicked = window.confirm("Please enter quantity first");
			$('#'+quantityFieldId).focus();
			selEl.val('');
		}
	});
	
	$('#frmConReco').on('change', '.rec_ore_metal', function(){
		var openOreMetalCount = $('#rec_ore_metal_count').val();
		var selEl = $(this);
		var selMetal = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		if(openOreMetalCount != 1){
			
			$('.rec_ore_metal').each(function(){
				var otherElId = $(this).attr('id');
				if(elId != otherElId){
					var otherMetal = $(this).val();
					if(selMetal == otherMetal){
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
		var quantityFieldId = elIdArr[0] + "_" + elIdArr[1] + "_qty";
		var qty = ($('#'+quantityFieldId).val()=='')? 0 : $('#'+quantityFieldId).val();
		var metal = (selMetal=='NIL')? '' : selMetal;
		if(qty == 0 && metal!= '')
		{
			var buttonClicked = window.confirm("Please enter quantity first");
			$('#'+quantityFieldId).focus();
			selEl.val('');
		}
	});
	
	$('#frmConReco').on('change', '.treat_ore_metal', function(){
		var openOreMetalCount = $('#treat_ore_metal_count').val();
		var selEl = $(this);
		var selMetal = $(this).val();
		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var elIdRw = elIdArr[3];
		if(openOreMetalCount != 1){
			
			$('.treat_ore_metal').each(function(){
				var otherElId = $(this).attr('id');
				if(elId != otherElId){
					var otherMetal = $(this).val();
					if(selMetal == otherMetal){
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
		var quantityFieldId = elIdArr[0] + "_" + elIdArr[1] + "_qty";
		var qty = ($('#'+quantityFieldId).val()=='')? 0 : $('#'+quantityFieldId).val();
		var metal = (selMetal=='NIL')? '' : selMetal;
		if(qty == 0 && metal!= '')
		{
			var buttonClicked = window.confirm("Please enter quantity first");
			$('#'+quantityFieldId).focus();
			selEl.val('');
		}
	});
	
	$('#frmConReco').on('change', '.con_obt_metal', function(){
		var openOreMetalCount = $('#con_obt_metal_count').val();
		if(openOreMetalCount != 1){
			var selEl = $(this);
			var selMetal = $(this).val();
			var elId = $(this).attr('id');
			var elIdArr = elId.split('_');
			var elIdRw = elIdArr[3];
			
			$('.con_obt_metal').each(function(){
				var otherElId = $(this).attr('id');
				if(elId != otherElId){
					var otherMetal = $(this).val();
					if(selMetal == otherMetal){
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
	});
	
	$('#frmConReco').on('change', '.tail_ore_metal', function(){
		var openOreMetalCount = $('#tail_ore_metal_count').val();
		if(openOreMetalCount != 1){
			var selEl = $(this);
			var selMetal = $(this).val();
			var elId = $(this).attr('id');
			var elIdArr = elId.split('_');
			var elIdRw = elIdArr[3];
			
			$('.tail_ore_metal').each(function(){
				var otherElId = $(this).attr('id');
				if(elId != otherElId){
					var otherMetal = $(this).val();
					if(selMetal == otherMetal){
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
	});
	
	$('#frmConReco').on('change', '.close_con_metal', function(){
		var openOreMetalCount = $('#close_con_metal_count').val();
		if(openOreMetalCount != 1){
			var selEl = $(this);
			var selMetal = $(this).val();
			var elId = $(this).attr('id');
			var elIdArr = elId.split('_');
			var elIdRw = elIdArr[3];
			
			$('.close_con_metal').each(function(){
				var otherElId = $(this).attr('id');
				if(elId != otherElId){
					var otherMetal = $(this).val();
					if(selMetal == otherMetal){
						selEl.val('');
						showAlrt('Sorry, you can not select one metal more than once !');
					}
				}
			});
		}
	});


	conRecoRowCount();
	conRecoRemAddAll('open_ore_table','3');
	conRecoRemAddAll('rec_ore_table','3');
	conRecoRemAddAll('treat_ore_table','3');
	conRecoRemAddAll('tail_ore_table','3');
	conRecoRemAddAll('con_obt_metal_value_table','2');
	conRecoRemAddAll('close_con_grade_table','2');

	$('#frmConReco').on('click', '#btn-add-1', function(){

		var rowC = $('#open_ore_table tbody tr').length;
		rowC++;

		var rowCon = "<tr>";
		rowCon += "<td>";
		rowCon += $('#open_ore_metal_row').val();
		rowCon += "<div class='err_cv'></div>";
		rowCon += "</td>";
		rowCon += "<td>";
		rowCon += "<div><input type='text' name='open_ore_grade_rowcc' id='open_ore_grade_rowcc' class='form-control form-control-sm open_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen' maxLength='5'></div><div class='err_cv'></div>";
		rowCon += "</td>";
		rowCon += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g,rowC);
		conRecoRemAdd('#open_ore_table');
		$('#open_ore_table tbody').append(rowCon);
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#open_ore_table .btn-rem', function(){

		$(this).closest('tr').remove();
		conRecoRowVal('#open_ore_table');
		conRecoSymRw('#open_ore_table','.open_ore_metal','open_ore_metal_','.open_ore_grade','open_ore_grade_');
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#btn-add-2', function(){

		var rowC = $('#rec_ore_table tbody tr').length;
		rowC++;
		
		var rowCon = "<tr>";
		rowCon += "<td>";
		rowCon += $('#rec_ore_metal_row').val();
		rowCon += "<div class='err_cv'></div>";
		rowCon += "</td>";
		rowCon += "<td>";
		rowCon += "<div><input type='text' name='rec_ore_grade_rowcc' id='rec_ore_grade_rowcc' class='form-control form-control-sm rec_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen' maxLength='5'></div><div class='err_cv'></div>";
		rowCon += "</td>";
		rowCon += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g,rowC);
		conRecoRemAdd('#rec_ore_table');
		$('#rec_ore_table tbody').append(rowCon);
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#rec_ore_table .btn-rem', function(){

		$(this).closest('tr').remove();
		conRecoRowVal('#rec_ore_table');
		conRecoSymRw('#rec_ore_table','.rec_ore_metal','rec_ore_metal_','.rec_ore_grade','rec_ore_grade_');
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#btn-add-3', function(){

		var rowC = $('#treat_ore_table tbody tr').length;
		rowC++;
		
		var rowCon = "<tr>";
		rowCon += "<td>";
		rowCon += $('#treat_ore_metal_row').val();
		rowCon += "<div class='err_cv'></div>";
		rowCon += "</td>";
		rowCon += "<td>";
		rowCon += "<div><input type='text' name='treat_ore_grade_rowcc' id='treat_ore_grade_rowcc' class='form-control form-control-sm treat_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen' maxLength='5'></div><div class='err_cv'></div>";
		rowCon += "</td>";
		rowCon += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g,rowC);
		conRecoRemAdd('#treat_ore_table');
		$('#treat_ore_table tbody').append(rowCon);
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#treat_ore_table .btn-rem', function(){

		$(this).closest('tr').remove();
		conRecoRowVal('#treat_ore_table');
		conRecoSymRw('#treat_ore_table','.treat_ore_metal','treat_ore_metal_','.treat_ore_grade','treat_ore_grade_');
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#btn-add-4', function(){

		var rowC = $('#con_obt_table tbody tr').length;
		rowC++;
		
		var rowConOne = "<tr>";
		rowConOne += "<td>";
		rowConOne += $('#con_obt_metal_row').val();
		rowConOne += "<div class='err_cv'></div>";
		rowConOne += "</td>";
		rowConOne += "<td>";
		rowConOne += "<div><input type='text' name='con_obt_quantity_rowcc' id='con_obt_quantity_rowcc' class='form-control form-control-sm con_obt_quantity quantity-txtbox cvOn cvNum cvReq cvMaxLen' maxLength='16'></div><div class='err_cv'></div>";
		rowConOne += "</td>";
		rowConOne += "</tr>";
		rowConOne = rowConOne.replace(/rowcc/g,rowC);
		$('#con_obt_table tbody').append(rowConOne);

		var rowConTwo = "<tr>";
		rowConTwo += "<td>";
		rowConTwo += "<div><input type='text' name='con_obt_grade_rowcc' id='con_obt_grade_rowcc' class='form-control form-control-sm con-obt-grade grade-txtbox cvOn cvReq cvMaxLen' maxLength='5'></div><div class='err_cv'></div>";
		rowConTwo += "</td>";
		rowConTwo += "</tr>";
		rowConTwo = rowConTwo.replace(/rowcc/g,rowC);
		$('#con_obt_grade_table tbody').append(rowConTwo);

		var rowConThree = "<tr>";
		rowConThree += "<td>";
		rowConThree += "<div><input type='text' name='con_obt_metal_value_rowcc' id='con_obt_metal_value_rowcc' class='form-control form-control-sm metal-value-txtbox cvOn cvReq cvMaxLen' maxLength='16'></div><div class='err_cv'></div>";
		rowConThree += "</td>";
		rowConThree += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowConThree += "</tr>";
		rowConThree = rowConThree.replace(/rowcc/g,rowC);
		conRecoRemAddTwo('#con_obt_metal_value_table');
		$('#con_obt_metal_value_table tbody').append(rowConThree);

		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#con_obt_metal_value_table .btn-rem', function(){

		var rwTr = $(this).closest('tr').find('.metal-value-txtbox').attr('id');
		var rwId = rwTr.split("_");
		var rId = rwId[rwId.length-1];
		$('#con_obt_table tbody tr:nth-child('+rId+')').remove();
		$('#con_obt_grade_table tbody tr:nth-child('+rId+')').remove();
		$(this).closest('tr').remove();
		conRecoRowValTwo('#con_obt_metal_value_table');
		conRecoSymRw('#con_obt_table','.con_obt_metal','con_obt_metal_','.con_obt_quantity','con_obt_quantity_');
		conRecoSymRwTwo('#con_obt_grade_table','.con-obt-grade','con_obt_grade_');
		conRecoSymRwTwo('#con_obt_metal_value_table','.metal-value-txtbox','con_obt_metal_value_');
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#btn-add-5', function(){

		var rowC = $('#tail_ore_table tbody tr').length;
		rowC++;
		
		var rowCon = "<tr>";
		rowCon += "<td>";
		rowCon += $('#tail_ore_metal_row').val();
		rowCon += "<div class='err_cv'></div>";
		rowCon += "</td>";
		rowCon += "<td>";
		rowCon += "<div><input type='text' name='tail_ore_grade_rowcc' id='tail_ore_grade_rowcc' class='form-control form-control-sm tail_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen' maxLength='5'></div><div class='err_cv'></div>";
		rowCon += "</td>";
		rowCon += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowCon += "</tr>";
		rowCon = rowCon.replace(/rowcc/g,rowC);
		conRecoRemAdd('#tail_ore_table');
		$('#tail_ore_table tbody').append(rowCon);
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#tail_ore_table .btn-rem', function(){

		$(this).closest('tr').remove();
		conRecoRowVal('#tail_ore_table');
		conRecoSymRw('#tail_ore_table','.tail_ore_metal','tail_ore_metal_','.tail_ore_grade','tail_ore_grade_');
		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#btn-add-6', function(){

		var rowC = $('#close_con_table tbody tr').length;
		rowC++;
		
		var rowConOne = "<tr>";
		rowConOne += "<td>";
		rowConOne += $('#close_con_metal_row').val();
		rowConOne += "<div class='err_cv'></div>";
		rowConOne += "</td>";
		rowConOne += "<td>";
		rowConOne += "<div><input type='text' name='close_con_quantity_rowcc' id='close_con_quantity_rowcc' class='form-control form-control-sm close_con_quantity quantity-txtbox cvOn cvNum cvReq cvMaxLen' maxLength='16'></div><div class='err_cv'></div>";
		rowConOne += "</td>";
		rowConOne += "</tr>";
		rowConOne = rowConOne.replace(/rowcc/g,rowC);
		$('#close_con_table tbody').append(rowConOne);

		var rowConTwo = "<tr>";
		rowConTwo += "<td>";
		rowConTwo += "<div><input type='text' name='close_con_grade_rowcc' id='close_con_grade_rowcc' class='form-control form-control-sm close-con-grade grade-txtbox cvOn cvNum cvReq cvMaxLen' maxLength='16'></div><div class='err_cv'></div>";
		rowConTwo += "</td>";
		rowConTwo += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowConTwo += "</tr>";
		rowConTwo = rowConTwo.replace(/rowcc/g,rowC);
		conRecoRemAddTwo('#close_con_grade_table');
		$('#close_con_grade_table tbody').append(rowConTwo);

		conRecoRowCount();

	});

	$('#frmConReco').on('click', '#close_con_grade_table .btn-rem', function(){

		var rwTr = $(this).closest('tr').find('.close-con-grade').attr('id');
		var rwId = rwTr.split("_");
		var rId = rwId[rwId.length-1];
		$('#close_con_table tbody tr:nth-child('+rId+')').remove();
		$(this).closest('tr').remove();
		conRecoRowValTwo('#close_con_grade_table');
		conRecoSymRw('#close_con_table','.close_con_metal','close_con_metal_','.close_con_quantity','close_con_quantity_');
		conRecoSymRwTwo('#close_con_grade_table','.close-con-grade','close_con_grade_');
		conRecoRowCount();

	});

});

function conRecoRemAdd(tId){

	$(tId+' tbody tr td:nth-child(3)').html("<i class='fa fa-times btn-rem'></i>");
}

function conRecoRemAddTwo(tId){

	$(tId+' tbody tr td:nth-child(2)').html("<i class='fa fa-times btn-rem'></i>");
}

function conRecoRemAddAll(tId, nRw){

	if($('#'+tId+' tbody tr').length > 1){
		$('#'+tId+' tbody tr td:nth-child('+nRw+')').html("<i class='fa fa-times btn-rem'></i>");
	}
}

function conRecoRowVal(tId){

	var rowCn = $(tId+' tbody tr').length;
	if(rowCn == 1){
		$(tId+' tbody tr:first td:nth-child(3)').html("");
	}

}

function conRecoRowValTwo(tId){

	var rowCn = $(tId+' tbody tr').length;
	if(rowCn == 1){
		$(tId+' tbody tr:first td:nth-child(2)').html("");
	}

}

function conRecoSymRw(tId, metalCl, metalIn, gradeCl, gradeIn){

	var rowCn = $(tId+' tbody tr').length;

	for(var cnRw=1;cnRw <= rowCn; cnRw++){

		var metal = $(tId+' tbody tr:nth-child('+cnRw+') td:nth-child(1) '+metalCl);
		metal.attr('name',metalIn+cnRw);
		metal.attr('id',metalIn+cnRw);

		var grade = $(tId+' tbody tr:nth-child('+cnRw+') td:nth-child(2) '+gradeCl);
		grade.attr('name',gradeIn+cnRw);
		grade.attr('id',gradeIn+cnRw);

	}

}

function conRecoSymRwTwo(tId, clName, inName){

	var rowCn = $(tId+' tbody tr').length;

	for(var cnRw=1;cnRw <= rowCn; cnRw++){

		var inRw = $(tId+' tbody tr:nth-child('+cnRw+') td:nth-child(1) '+clName);
		inRw.attr('name',inName+cnRw);
		inRw.attr('id',inName+cnRw);

	}

}

function conRecoRowCount(){

	$('#open_ore_metal_count').val($('#open_ore_table tbody tr').length);
	$('#rec_ore_metal_count').val($('#rec_ore_table tbody tr').length);
	$('#treat_ore_metal_count').val($('#treat_ore_table tbody tr').length);

	$('#con_obt_metal_count').val($('#con_obt_table tbody tr').length);
	$('#tail_ore_metal_count').val($('#tail_ore_table tbody tr').length);
	$('#close_con_metal_count').val($('#close_con_table tbody tr').length);

}
