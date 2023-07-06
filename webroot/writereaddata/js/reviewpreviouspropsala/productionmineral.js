$(document).ready(function(){
    $('.deviation').on('blur', function() {
        var id = $(this).attr('id');
    	getTotal(id);
    });

    function getTotal(deviation)
    {
    	var sep_id = deviation.split('_');
        var deviationVal  = $('#'+deviation).val();
		var proposal  = $('#'+sep_id[0]+'_proposal').val();
		var achievement  = $('#'+sep_id[0]+'_achievement').val();
		
		var total = parseFloat(achievement) - parseFloat(proposal); //changed to 'parseFloat' from 'parseInt' on 03-08-2022 by Aniket				
		
		if(!isNaN(total)){
    		if(deviationVal == total)
    		{
    			$('#'+deviation).removeClass('is-invalid');
    			return true;
    		}else{
    				
    			showAlrt('For Deviation (Achievement - Proposals) is not validating. Kindly correct before proceeding');
    			 $('#'+deviation).val('');
    			 $('#'+deviation).addClass('is-invalid');
    			 
    		}
        }
    }
    $(".tot").on('blur', function() {
    	var elementId = $(this).attr('id');
    	var elementName = $(this).attr('name');
    	updateSubTotal(elementName,elementId);
    });

    function updateSubTotal(fieldName,fieldId) {
    	var sum_prop = 0;
    	$("input[name='"+fieldName+"']").each(function () {
    		var _elementId = $(this).attr('id');
    		var nameFirst = _elementId.split('_');

            var _elementName = $(this).attr('id');
            var eleName = _elementName.split('_');
			
    		if(nameFirst[0]!=='tot' && eleName[0] !=='open')
    		{
    			//sum_prop += parseInt($(this).val()); Commented on 21-09-2022 by Shweta Apale
				
				sum_prop += parseFloat($(this).val());	

				sum_prop1 = Number(sum_prop).toFixed(4);
    		}					
		});			
		
		
		
		var getTotal = $('#'+fieldId).val();
		getTotal = Number(getTotal).toFixed(4);
		
    	if(getTotal==sum_prop1)
    	{
    		$('#'+fieldId).removeClass('is-invalid');
    		return true;
    	}else{
    		showAlrt('Total is not validating. Kindly correct before proceeding');
			$('#'+fieldId).val('');
			$('#'+fieldId).addClass('is-invalid');
    	}
	}
  });