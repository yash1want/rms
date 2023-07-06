// file added by laxmi
$(document).ready(function(){
//for at time one radio selected added by laxmi B. 2022-09-28
    $('#applicable').click( function(){
        $('#applicable').prop('checked', true);
         $('#notApplicable').prop('checked', false);
         $('#form_outer_main').css('display', 'block');
    });
    $('#notApplicable').click( function(){
        $('#notApplicable').prop('checked', true);
        $('#applicable').prop('checked', false);
         $('#form_outer_main').css('display', 'none');
    });
//end radio selected code
// code for selected applicable then table show otherwise table is hidden 
$('.container .panel input[type="radio"]:checked').each(function() {
    var demovalue = $(this).val();
    if(demovalue == 'Applicable'){
       $("#form_outer_main").show();
    } else if(demovalue == 'Not Applicable'){
          $("#form_outer_main").hide();
    } else {
        $("#form_outer_main").hide();
    }
   
});
}); 
// close of ready()

//End here Laxmi B.
