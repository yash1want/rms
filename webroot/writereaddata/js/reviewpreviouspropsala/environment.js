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
		
		deviationVal = Number(deviationVal).toFixed(2);
		
		var total = parseFloat(achievement) - parseFloat(proposal); //changed to 'parseFloat' from 'parseInt' on 03-08-2022 by Aniket
		total = total.toFixed(2);
		
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
});