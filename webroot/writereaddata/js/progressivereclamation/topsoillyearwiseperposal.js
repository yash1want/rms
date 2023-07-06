$(document).ready(function(){
    $('.deviation').on('blur', function() {
        var id = $(this).attr('id');
    	getTotal(id);
    });

    function getTotal(deviation)
    {	var sep_id = deviation.split('_');
    	var yearcount = deviation.split('-');
        var deviationVal  = $('#'+deviation).val();
		var generated  = $('#'+sep_id[0]+'_soil_generated-'+yearcount[1]).val();
		var utilized  = $('#'+sep_id[0]+'_soil_utilized-'+yearcount[1]).val();
		
		var total = parseInt(generated) - parseInt(utilized);
		if(!isNaN(total)){
			if(deviationVal == total)
			{
				$('#'+deviation).removeClass('is-invalid');
				return true;
			}else{
				showAlrt('For Topsoil Stored (m³) (A-B) (Topsoil Generated (m³) (A) - Topsoil Utilized (m³) (B)) is not validating. Kindly correct before proceeding');
				 $('#'+deviation).val('');
				 $('#'+deviation).addClass('is-invalid');
			}
		}
    }
});