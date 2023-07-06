
$("#from_date").prop("disabled", true);
$("#to_date").prop("disabled", true);

$('input[type=radio][name=rb_period]').change(function() {
    if (this.value == 'period') {
        $("#from_date").prop("disabled", true);
        $("#to_date").prop("disabled", true);
        $("#r_period").prop("disabled", false);
            $("#r_period option[value='']").remove();
    }
    else if (this.value == 'range') {
        $("#r_period").prop("disabled", true);	
        $("#r_period").append("<option value=''>Select</option>");	
        $("#r_period").val('');
        $("#from_date").prop("disabled", false);
        $("#to_date").prop("disabled", false);
    }
});

$("#from_date").datepicker({
    minViewMode: "months",
    startView: "months",
    autoclose: true,
    format: 'mm/yyyy'
});

$("#to_date").datepicker({
    minViewMode: "months",
    startView: "months",
    autoclose: true,
    format: 'mm/yyyy'

});

/*$("#to_date").datepicker({ 
            format: 'dd/mm/yyyy',
            autoclose: true, 
            todayHighlight: true
      });

  $("#from_date").datepicker({ 
        format: 'dd/mm/yyyy',
        autoclose: true, 
        todayHighlight: true
  })
*/


      


ajaxfunction.getMonthArr();
ajaxfunction.getRegionArr();
ajaxfunction.getStatesArr();
ajaxfunction.getDistrictsArr();