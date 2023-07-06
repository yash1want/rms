$(document).ready(function(){

    $('#from_date_log').on('change',function(){
        var fdate = $('#from_date_log').val();
        $('#to_date_log').prop('min',fdate);
    });
    
    $('#to_date_log').on('change',function(){
        var fdate = $('#to_date_log').val();
        $('#from_date_log').prop('max',fdate);
    });

});