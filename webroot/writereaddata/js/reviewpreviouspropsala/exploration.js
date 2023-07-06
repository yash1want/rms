$(document).ready(function(){
    $('.deviation').on('blur', function() {
        var id = $(this).attr('id');
    	getTotal(id);
    });
	
	// Added by Shweta Apale on 16-06-2022
	$('.deviation1').on('blur', function () {
		var id = $(this).attr('id');
		getTotalBorejolePitTrench(id);
	});

    function getTotal(deviation)
    {	var sep_id = deviation.split('_');
        var deviationVal  = $('#'+deviation).val();
		var proposal  = $('#'+sep_id[0]+'_proposals').val();
		var achievement  = $('#'+sep_id[0]+'_achieve').val();
		
		var total = parseFloat(achievement) - parseFloat(proposal); //changed to 'parseFloat' from 'parseInt' on 03-08-2022 by Aniket
		
		total = total.toFixed(2); //Added by Shweta Apale on 30-09-2022
		deviationVal = Number(deviationVal).toFixed(2);
		
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
	
	// Added by Shweta Apale on 16-06-2022
	function getTotalBorejolePitTrench(deviation) {
		var sep_id = deviation.split('_');

		var deviationVal = $('#' + deviation).val();

		var proposal = $('#' + sep_id[0] + '_proposals_' + sep_id[2]).val();
		var achievement = $('#' + sep_id[0] + '_achieve_' + sep_id[2]).val();

		var total = parseInt(achievement) - parseInt(proposal);

		if (!isNaN(total)) {
			if (deviationVal == total) {
				$('#' + deviation).removeClass('is-invalid');
				return true;
			} else {
				showAlrt('For Deviation (Achievement - Proposals) is not validating. Kindly correct before proceeding');
				$('#' + deviation).val('');
				$('#' + deviation).addClass('is-invalid');
			}
		}
	}
});