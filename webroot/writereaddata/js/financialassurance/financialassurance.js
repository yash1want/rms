$(document).ready(function () {
	
	// $('#form_id').on('blur', '.bank_amt', function(){
 	// 	var id = $(this).attr('id');
	//     doCalculation(id);
 	// });
	
	var bankAmtA = parseFloat($('#total_prop_area').val());
	var mineCategory = $('#mine_category').val();
	
	// if(mineCategory == 'A'){
	// 	var calAmtA = bankAmtA * 3;
	// 	var amtA = 10;
	// 	if(calAmtA < amtA){
	// 		$('#bank_guarantee_amnt').val(amtA);
	// 		showAlrt('Minimum value is '+amt+' lac for Amount of Bank Gurantee');
	// 	} else {
	// 		$('#bank_guarantee_amnt').val(calAmtA);					
	// 	}			
		
	// }
	
	// To alert if prefetched value is changed by user
	$('#bank_guarantee_amnt').on('blur', function(){
		var inputBankGuaAmt = $('#bank_guarantee_amnt').val();
		var mineCategory = $('#mine_category').val();
		
		if(mineCategory == 'A'){
			var calAmtA = parseFloat(bankAmtA) * parseFloat(5);
			calAmtARounded = calAmtA.toFixed(2);
			var calAmtAArr = calAmtA.toString().split('.');
			var calAmtATruncated = (calAmtAArr.length == 2) ? calAmtAArr[0] + '.' + calAmtAArr[1].toString().substr(0, 2) : calAmtA;
			var amtA = 10;
			if(calAmtA < amtA){
				if(inputBankGuaAmt < amtA){
					showAlrt('Minimum value is '+amtA+' lac for Amount of Bank Gurantee');
				} else if(inputBankGuaAmt > amtA){
					showAlrt('As per calculation ie., Amount of Bank Gurantee (Lac INR) = (Area furnished in first column * Rs 5 Lac) value is not validating!');
				}
			} else {
				if (Number(inputBankGuaAmt) == Number(calAmtARounded) || Number(inputBankGuaAmt) == Number(calAmtATruncated)) {
					//
				} else {
					showAlrt('As per calculation ie., Amount of Bank Gurantee (Lac INR) = (Area furnished in first column * Rs 5 Lac) value is not validating');
				}
			}
		} else {
			var calAmtA = parseFloat(bankAmtA) * parseFloat(3);
			calAmtARounded = calAmtA.toFixed(2);
			var calAmtAArr = calAmtA.toString().split('.');
			var calAmtATruncated = (calAmtAArr.length == 2) ? calAmtAArr[0] + '.' + calAmtAArr[1].toString().substr(0, 2) : calAmtA;
			var amtA = 5;
			if(calAmtA < amtA){
				if(inputBankGuaAmt < amtA){
					showAlrt('Minimum value is '+amtA+' lac for Amount of Bank Gurantee');
				} else if(inputBankGuaAmt > amtA){
					showAlrt('As per calculation ie., Amount of Bank Gurantee (Lac INR) = (Area furnished in first column * Rs 3 Lac) value is not validating!');
				}
			} else {
				if (Number(inputBankGuaAmt) == Number(calAmtARounded) || Number(inputBankGuaAmt) == Number(calAmtATruncated)) {
					//
				} else {
					showAlrt('As per calculation ie., Amount of Bank Gurantee (Lac INR) = (Area furnished in first column * Rs 3 Lac) value is not validating');
				}
			}
		}
		
	});
	
    $('#financialassuran').on('focusout', '.bank_amt', function() {

        var bankAmt = parseFloat($(this).val());
        var mineCategory = $('#mine_category').val();
				
        if(mineCategory == 'B'){
            var amt = 5;
			var calAmt = bankAmt * 3;
        }else{
			var calAmt = bankAmt * 5;
            var amt = 10;
        }
			
        if(calAmt < amt){
            $(this).val(amt);
            showAlrt('Minimum value is '+amt+' lac for Amount of Bank Gurantee');
        } else {
			$(this).val(calAmt);			
		}				
    });

});




function doCalculation(elementId)
{
    var sep_id = elementId.split('-');
    var elementVal = $('#'+elementId).val();
    var fieldVal = $('#'+sep_id[0]+'-total_prop_area-'+sep_id[2]).val();
    var multi_val = $('#multi_val').val();

    var total = parseFloat(fieldVal) * parseFloat(multi_val);

    if(Number(total) == Number(elementVal))
    {
    	$('#'+elementId).removeClass('is-invalid');
    	return true;

    }else{
    	showAlrt('Amount of Bank Gurantee is not validating. Kindly correct before proceeding');
        $('#'+elementId).addClass('is-invalid');
        $('#'+elementId).val('');
    }
    
}