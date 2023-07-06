$(document).ready(function(){
    $('.deviation').on('blur', function() {
        var id = $(this).attr('id');
    	getTotal(id);
    });

    function getTotal(deviation)
    {	
    	var yearcount = deviation.split('-');
        var deviationVal  = $('#'+deviation).val();
		var generated  = $('#tailing_yearly_gen-'+yearcount[1]).val();
		var utilized  = $('#tailing_yearly_util-'+yearcount[1]).val();
		
		var total = parseInt(generated) - parseInt(utilized);
		if(!isNaN(total)){
			if(deviationVal == total)
			{
				$('#'+deviation).removeClass('is-invalid');
				return true;
			}else{
				showAlrt('For Disposal of Tailing to Tailing Pond (m³) (A-B) (Yearly generation of Tailing (m³) (A) - Yearly Utilization of Tailing (m³) (B)) is not validating. Kindly correct before proceeding');
				$('#'+deviation).val('');
				$('#'+deviation).addClass('is-invalid');
			}
		}
    }
});