
$(document).ready(function(){

	f5Sales.formValidation();
	f5Sales.salePostValidation();
	f5Sales.dropDownValidation();
	f5Sales.DDfocusValue();
	f5Sales.autoFillForZeroProduction();

	$('#frmSalesF5').on('change', '.open_stock_metal_box', function() {

		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var id = elIdArr[3];
		checkOpenRecovSoldClosing(id);

	});
	
	$('#frmSalesF5').on('focusout', '.open_stock_qty, .prod_sold_qty, .close_stock_qty', function() {

		var elId = $(this).attr('id');
		var elIdArr = elId.split('_');
		var id = elIdArr[3];
		checkOpenRecovSoldClosing(id);

	});
	
	$("#frmSalesF5").on('submit',function(){
		checkOpenRecovSoldClosing('all');
		var i = 1;
		var error = false;
		var table_length = parseInt($('#sales_data_table tbody tr').length) + 1;
		
		for(i=1; i < table_length; i++){
			
			var open_stock_qty = parseFloat($("#open_stock_qty_"+i).val()).toFixed(3);
			var prod_sold_qty = parseFloat($("#prod_sold_qty_"+i).val()).toFixed(3);
			var close_stock_qty = parseFloat($("#close_stock_qty_"+i).val()).toFixed(3);
			
			var soldquanClosequan = (parseFloat(prod_sold_qty) +  parseFloat(close_stock_qty)).toFixed(3);
			
			if(open_stock_qty != soldquanClosequan){				
				// $("#open_stock_qty_"+i).val('').addClass('is-invalid');
				// $("#prod_sold_qty_"+i).val('').addClass('is-invalid');
				// $("#close_stock_qty_"+i).val('').addClass('is-invalid');

				// error = true;
			}
			
		}
		if(error == true){
			//showAlrt("Opening stock is less than sold quantity + closing stock");
			//return false;	
		}else{
			return true;	
		}
		
	});

    $('#frmSalesF5').ready(function(){
        salesMetalProductNil();
    });
	
    $('#frmSalesF5').on('change', '.open_stock_metal_box', function(){
        var open_stock_metal = $(this).val();

        if (open_stock_metal == "") {
            showAlrt('Please select metal');
        }
    });

	$('#frmSalesF5').on('focusout', '.open_stock_qty', function(){
		var open_stock_qty = $(this).val();
		$(this).removeClass('is-invalid');
		
		var temp = parseFloat(open_stock_qty);
		var rounded_value = (temp).toFixed(3);

		if (rounded_value.length > 16) {
			showAlrt("Maximum quantity limit exceeded. Maximum value allowed is 12,3");
			$(this).val('');
		}else{
			var prodsoldqty  = parseFloat($(this).closest('tr').find('.prod_sold_qty').val()).toFixed(3);
			var closestockqty  = parseFloat($(this).closest('tr').find('.close_stock_qty').val()).toFixed(3);
				
			var soldquanClosequan = (parseFloat(prodsoldqty) + parseFloat(closestockqty)).toFixed(3);
			
			if(rounded_value != soldquanClosequan){
				
				// showAlrt("Opening stock is less than sold quantity + closing stock");
				// $(this).val('').addClass('is-invalid');
				// $(this).closest('tr').find('.prod_sold_qty').val('').addClass('is-invalid');
				// $(this).closest('tr').find('.close_stock_qty').val('').addClass('is-invalid');
			}
			
		}
	});
	
	$('#frmSalesF5').on('focusout', '.prod_sold_qty', function(){
		var prod_sold_qty = $(this).val();
		$(this).removeClass('is-invalid');
		
		var temp = parseFloat(prod_sold_qty);
		var rounded_value = (temp).toFixed(3);

		if (rounded_value.length > 16) {
			showAlrt("Maximum quantity limit exceeded. Maximum value allowed is 12,3");
			$(this).val('');
		}else{
			
			var openstockqty  = parseFloat($(this).closest('tr').find('.open_stock_qty').val()).toFixed(3);
			var closestockqty  = parseFloat($(this).closest('tr').find('.close_stock_qty').val()).toFixed(3);
				
			var soldquanClosequan = (parseFloat(rounded_value) + parseFloat(closestockqty)).toFixed(3);
			
			if(openstockqty != soldquanClosequan){
				
				// showAlrt("Opening stock is less than sold quantity + closing stock");
				// $(this).val('').addClass('is-invalid');
				// $(this).closest('tr').find('.open_stock_qty').val('').addClass('is-invalid');
				// $(this).closest('tr').find('.close_stock_qty').val('').addClass('is-invalid');
			}
			
		}
	});
	
	$('#frmSalesF5').on('focusout', '.close_stock_qty', function(){
		var close_stock_qty = $(this).val();
		$(this).removeClass('is-invalid');
		
		var temp = parseFloat(close_stock_qty);
		var rounded_value = (temp).toFixed(3);

		if (rounded_value.length > 16) {
			showAlrt("Maximum quantity limit exceeded. Maximum value allowed is 12,3");
			$(this).val('');
		}else{
			
			var openstockqty  = parseFloat($(this).closest('tr').find('.open_stock_qty').val()).toFixed(3);
			var prodsoldqty  = parseFloat($(this).closest('tr').find('.prod_sold_qty').val()).toFixed(3);
				
			var soldquanClosequan = (parseFloat(prodsoldqty) + parseFloat(rounded_value)).toFixed(3);;
			
			if(openstockqty != soldquanClosequan){
				
				// showAlrt("Opening stock is less than sold quantity + closing stock");
				// $(this).val('').addClass('is-invalid');
				// $(this).closest('tr').find('.open_stock_qty').val('').addClass('is-invalid');
				// $(this).closest('tr').find('.prod_sold_qty').val('').addClass('is-invalid');
			}
		}
	});
	
	// $('#frmSalesF5').on('focusout', '.open_stock_metal_box', function(){
	// 	var elementId = $(this).attr('id');
	// 	if($('#prev_'+elementId).length){
	// 		var prevVal = $('#prev_'+elementId).val();
	// 		var newVal = $(this).val();
	// 		if (prevVal != '' && prevVal != newVal) {
	// 			alert("Please send an e-mail to IBM clarifying this variation.");
	// 		}

	// 	}
	// });
	
	$('#frmSalesF5').on('change', '.open_stock_metal_box', function(){
		var monthSaleCount = $('#month_sale_count').val();
		if(monthSaleCount != 1){
			var selEl = $(this);
			var selMetal = $(this).val();
			var elId = $(this).attr('id');
			var elIdArr = elId.split('_');
			var elIdRw = elIdArr[2];

			$('.open_stock_metal_box').each(function(){
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
		
		var metalBox = $(this).val();
		if(metalBox == 'NIL'){
			var nilStatus = confirm("Selecting NIL in the Metal Content/grade will automatically put 0 in corresponding all fields. \nAre you sure want to continue? ");
			if(nilStatus == true){
				$('.makeNil').val('0');
				$('#sales_metal_product_add_btn').hide();
				$('#sales_data_table tbody tr').not(':first').remove();
                $('#month_sale_count').val(1);
			} else {
				$(this).val('');
			}
		} else {
			$('#sales_metal_product_add_btn').show();
		}
		
		var elementId = $(this).attr('id');
		if($('#prev_'+elementId).length){
			var prevVal = $('#prev_'+elementId).val();
			var newVal = $(this).val();
			if (prevVal != '' && prevVal != newVal) {
				alert("Please send an e-mail to IBM clarifying this variation.");
			}

		}

	});
	
    $('#frmSalesF5').on('submit', function(){

        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('frmSalesF5');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
        
        var returnSelEmptyStatus = formSelEmptyStatus('frmSalesF5');
        returnFormStatus = (returnSelEmptyStatus == 'invalid') ? false : returnFormStatus;

        if(returnFormStatus == false){
            showAlrt('All fields required. If No data is there, select Nil in the Metal/Product Drop box');
        }
        
        return returnFormStatus;

    });
	
	salesMetalProductRowCount();
	salesMetalProductRemAddAllMain();

	$('#frmSalesF5').on('click', '#sales_metal_product_add_btn', function(){

		var rowC = $('#sales_data_table tbody tr').length;
		rowC++;
		
		var rowCon = '<tr>';
		rowCon += '<td>';
		rowCon += '<div>';
		rowCon += $('#open_stock_metal_row').val();
		rowCon += '</div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div class="input text"><input type="text" name="open_stock_qty_rowcc" id="open_stock_qty_rowcc" class="form-control open_stock_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvMaxLen cvFloat" maxLength="16" cvfloat="999999999999.999"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div class="input text"><input type="text" name="open_stock_grade_rowcc" id="open_stock_grade_rowcc" class="form-control open_stock_grade sales-grade-txtbox makeNil cvOn cvReq cvNum"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div class="input text"><input type="text" name="sale_place_value_rowcc" id="sale_place_value_rowcc" class="form-control sale_place_value sales-value-txtbox makeNil cvOn cvReq"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div class="input text"><input type="text" name="prod_sold_qty_rowcc" id="prod_sold_qty_rowcc" class="form-control prod_sold_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvFloat" cvfloat="999999999999.999"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div class="input text"><input type="text" name="prod_sold_grade_rowcc" id="prod_sold_grade_rowcc" class="form-control prod_sold_grade sales-grade-txtbox makeNil cvOn cvReq cvNum"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div class="input text"><input type="text" name="prod_sold_value_rowcc" id="prod_sold_value_rowcc" class="form-control prod_sold_value sales-value-txtbox makeNil cvOn cvReq cvNum"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div class="input text"><input type="text" name="close_stock_qty_rowcc" id="close_stock_qty_rowcc" class="form-control close_stock_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvMaxLen cvFloat" maxLength="16" cvfloat="999999999999.999"></div>';
		rowCon += '<div class="err_cv"></div>';
		rowCon += '</td>';
		rowCon += '<td>';
		rowCon += '<div class="input text"><input type="text" name="close_stock_grade_rowcc" id="close_stock_grade_rowcc" class="form-control close_stock_grade sales-grade-txtbox makeNil cvOn cvNum cvNotReq"></div>';
		rowCon += '</td>';
		rowCon += "<td><i class='fa fa-times btn-rem'></i></td>";
		rowCon += '</tr>';
		rowCon = rowCon.replace(/rowcc/g,rowC);
		salesMetalProductRemMainAdd();
		$('#sales_data_table tbody').append(rowCon);
		salesMetalProductRowCount();
		salesMetalProductNil();

	});

	$('#sales_data_table').on('click','.btn-rem', function(){

		$(this).closest('tr').remove();
		salesMetalProductRowMainVal();
		salesMetalProductMainSymRw();
		salesMetalProductRowCount();

	});

});

// CHECKING "Opening stk. of metal/ product plus metal recovered less metal/ product sold should be equal to closing stk. of metal/ product"
// Effective from Phase-II
// Added on 21-03-2022 by Aniket G.
function checkOpenRecovSoldClosing(rw) {

	var metalsRecovered = $('#metals_recovered').val();
	var metalsRecov = JSON.parse(metalsRecovered);
	
	if (rw == 'all') {

		var rwCount = $('#frmSalesF5 #sales_data_table .t-body tr').length;
		var warningFound = false;
		for (var n=0; n < rwCount; n++) {

			var rwId = n + parseInt(1);
			var openStkMetal = $('#frmSalesF5 #open_stock_metal_'+rwId).val();
			if (openStkMetal != '') {
	
				var indexFound = false;
				var indRw;
				$.each(metalsRecov, function(index, value){
					if (openStkMetal == value['rc_metal']) {
						indexFound = true;
						indRw = index;
					}
				});
	
				if (indexFound == true) {
	
					var qtyRecov = parseFloat(metalsRecov[indRw]['rc_qty']);
					var qtyOpen = parseFloat($('#frmSalesF5 #open_stock_qty_'+rwId).val());
					var qtySold = parseFloat($('#frmSalesF5 #prod_sold_qty_'+rwId).val());
					var qtyClose = parseFloat($('#frmSalesF5 #close_stock_qty_'+rwId).val());
					var qtyCalculated = (qtyOpen + qtyRecov - qtySold).toFixed(3);
					if (qtyClose != qtyCalculated) {
						warningFound = true;
					}
	
				}
	
			}

		}
		
		if (warningFound == true) {
			// alert("Opening stk. of metal/ product plus metal recovered less metal/ product sold should be equal to closing stk. of metal/ product");
			alert("Closing stocks of metals/ Products should be equal to Opening stocks of metals/ Products + Metals recovered - Metals/Products sold");
		}
		

	} else {

		var openStkMetal = $('#frmSalesF5 #open_stock_metal_'+rw).val();
		if (openStkMetal != '') {

			var indexFound = false;
			var indRw;
			$.each(metalsRecov, function(index, value){
				if (openStkMetal == value['rc_metal']) {
					indexFound = true;
					indRw = index;
				}
			});

			if (indexFound == true) {

				var qtyRecov = metalsRecov[indRw]['rc_qty'];
				var qtyOpen = $('#frmSalesF5 #open_stock_qty_'+rw).val();
				var qtySold = $('#frmSalesF5 #prod_sold_qty_'+rw).val();
				var qtyClose = $('#frmSalesF5 #close_stock_qty_'+rw).val();

				if (qtyOpen.length > 0 && qtyRecov.length > 0 && qtySold.length > 0 && qtyClose.length > 0) {

					var qtyRecov = parseFloat(qtyRecov);
					var qtyOpen = parseFloat(qtyOpen);
					var qtySold = parseFloat(qtySold);
					var qtyClose = parseFloat(qtyClose);
					var qtyCalculated = (qtyOpen + qtyRecov - qtySold).toFixed(3);
					if (qtyClose != qtyCalculated) {
						// alert("Opening stk. of metal/ product plus metal recovered less metal/ product sold should be equal to closing stk. of metal/ product");
						alert("Closing stocks of metals/ Products should be equal to Opening stocks of metals/ Products + Metals recovered - Metals/Products sold");
					}

				}

			}

		}

	}

}
function salesMetalProductNil(){

	var monthSaleCount = $('#month_sale_count').val();
	if(monthSaleCount > 1){
		$('.open_stock_metal_box option[value="NIL"]').not(':first').remove();
	}

    var firstNil = $('#open_stock_metal_1').val();
    if(firstNil == 'NIL'){
        $('#sales_metal_product_add_btn').hide();
    }

}

function salesMetalProductRemMainAdd(){

	$('#sales_data_table tbody tr td:nth-child(10)').html("<i class='fa fa-times btn-rem'></i>");
}

function salesMetalProductRemAddAllMain(){

	if($('#sales_data_table tbody tr').length > 1){
		$('#sales_data_table tbody tr td:nth-child(10)').html("<i class='fa fa-times btn-rem'></i>");
	}
}

function salesMetalProductRowMainVal(){

	var rowCn = $('#sales_data_table tbody tr').length;
	if(rowCn == 1){
		$('#sales_data_table tbody tr:first td:nth-child(10)').html("");
	}

}

function salesMetalProductMainSymRw(){

	salesMetalProductRw('.open_stock_metal_box','open_stock_metal_','open_stock_metal_',1);
	salesMetalProductRw('.open_stock_qty','open_stock_qty_','open_stock_qty_',2);
	salesMetalProductRw('.open_stock_grade','open_stock_grade_','open_stock_grade_',3);
	salesMetalProductRw('.sale_place_value','sale_place_value_','sale_place_value_',4);
	salesMetalProductRw('.prod_sold_qty','prod_sold_qty_','prod_sold_qty_',5);
	salesMetalProductRw('.prod_sold_grade','prod_sold_grade_','prod_sold_grade_',6);
	salesMetalProductRw('.prod_sold_value','prod_sold_value_','prod_sold_value_',7);
	salesMetalProductRw('.close_stock_qty','close_stock_qty_','close_stock_qty_',8);
	salesMetalProductRw('.close_stock_grade','close_stock_grade_','close_stock_grade_',9);

}

function salesMetalProductRw(clBox, inName, inId, tdPos){

	var rowCn = $('#sales_data_table tbody tr').length;

	for(var cnRw=1;cnRw <= rowCn; cnRw++){

		var metal = $('#sales_data_table tbody tr:nth-child('+cnRw+') td:nth-child('+tdPos+') '+clBox);
		metal.attr('name',inName+cnRw);
		metal.attr('id',inId+cnRw);

	}

}

function salesMetalProductRowCount(){

	$('#month_sale_count').val($('#sales_data_table tbody tr').length);

}

/**
 * Made by Shweta Apale 24-01-2022
 * To get input values of Metal, Quantity, Value
 */
$(document).ready(function () {
	var prod_sold_qty_gold, prod_sold_value_gold, rc_divide;
	$('input[id^="prod_sold_value_"], input[id^="prod_sold_qty_"], [id^="open_stock_metal_"]').focusout(function () {
		var metal_selected = $('[id^="open_stock_metal_"]').val();
		if (metal_selected === 'Gold') {
			prod_sold_value_gold = $('input[id^="prod_sold_value_"]').val();
			prod_sold_qty_gold = $('input[id^="prod_sold_qty_"]').val();

			if (prod_sold_value_gold != '' && prod_sold_qty_gold != '') {
				rc_divide = parseFloat(prod_sold_value_gold) / parseFloat(prod_sold_qty_gold);
				// rc_divide.toFixed(3);
				$.ajax({
					type: "POST",
					url: "../check_gold_value",
					data: { rc_divide_sale: rc_divide },
					cache: false,

					beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
					success : function(response)
					{
						// console.log(response);
						// console.log(response == 1);
						if(response == 1){
						alert('Only 2% error is allowed');
						}
					}
				});
			}
		}

	});
});
