 $(document).ready(function(){
    $('.deviation').on('blur', function() {
        var id = $(this).attr('id');
    	getTotal(id);
    });

    function getTotal(deviation)
    {
        var deviationVal  = $('#'+deviation).val();
		var expend_proposal  = $('#total_expend_proposal').val();
		var achievement  = $('#achievement').val();
		
		var total = parseFloat(achievement) - parseFloat(expend_proposal); //changed to 'parseFloat' from 'parseInt' on 03-08-2022 by Aniket
		
		if(deviationVal == total)
		{
			$('#'+deviation).removeClass('is-invalid');
			return true;
		}else{
				
			showAlrt('For Deviation (Achievement - Total Expenditure for SDF implementation (b)) is not validating. Kindly correct before proceeding');
			 $('#'+deviation).val('');
			 $('#'+deviation).addClass('is-invalid');
			 
		}

    }


  });