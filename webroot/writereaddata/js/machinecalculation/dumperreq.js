$(document).ready(function(){

 	
 	$('#form_id').on('blur', '.total_hour', function(){
 	
      var total_hour = $(this).attr('id');
      var workingdays = parseInt(document.getElementById("Workingdays").value);
      var num1 = parseInt(document.getElementById("Num1").value);
      var effshift = parseInt(document.getElementById("Effshift").value);
      var total_hour = workingdays * num1  * effshift;
      var a = total_hour.toFixed(2);
      if(!isNaN(total_hour)){
      	if($(this).val() != Number(total_hour))
	      {
  	     	showAlrt('Total Hours (H) is not validating. Kindly correct before proceeding');
  			  $('#'+total_hour).addClass('is-invalid');
	      } 
      	$(this).val(a);
      }
     
  	});
    $('#form_id').on('blur', '.dist_cover_minutes', function(){
    
      var dist_cover_minutes = $(this).attr('id');
     
      var dist_cover_minutesArr = dist_cover_minutes.split('-');
      var dist_cover_minutesId = dist_cover_minutesArr[2];
      var dumperSpeed = $('#ta-dumper_speed-'+dist_cover_minutesId).val();
      var leadDistance = $('#ta-lead_distance-'+dist_cover_minutesId).val(); 
      var dist_cover_minutes = (leadDistance /dumperSpeed)*60 ;
      var n = dist_cover_minutes.toFixed(2);
      if(!isNaN(dist_cover_minutes)){
        if($(this).val() != Number(dist_cover_minutes))
        {
          showAlrt('Time taken to cover distance in minutes(iii) is not validating. Kindly correct before proceeding');
          $('#'+dist_cover_minutes).addClass('is-invalid');
        } 
        $(this).val(n);
      }
      
       
    });

    $('#form_id').on('blur', '.one_trip_time', function(){
    
      var one_trip_time = $(this).attr('id');
      var one_trip_timeArr = one_trip_time.split('-');
      var one_trip_timeId = one_trip_timeArr[2];
      var distCover = $('#ta-dist_cover_minutes-'+one_trip_timeId).val();
      var shoverLoad = $('#ta-shover_loading_time-'+one_trip_timeId).val();
      var unloadingTime = $('#ta-unloading_time-'+one_trip_timeId).val(); 
      var one_trip_time = parseFloat(distCover) + parseFloat(shoverLoad) + parseFloat(unloadingTime);
      var n = one_trip_time.toFixed(2);
      if(!isNaN(one_trip_time)){
        if($(this).val() != Number(one_trip_time))
        {
          showAlrt('Total Time to complete one trip(vi) is not validating. Kindly correct before proceeding');
          $('#'+one_trip_time).addClass('is-invalid');
        } 
        $(this).val(n);
      }
     
  });
  $('#form_id').on('blur', '.no_of_trips', function(){
     var no_of_trips = $(this).attr('id');
   
     var no_of_tripsArr = no_of_trips.split('-');
     var no_of_tripsId = no_of_tripsArr[2];
     var oneTrip = $('#ta-one_trip_time-'+no_of_tripsId).val();
     
      // var no_of_trips = oneTrip/60;
      var no_of_trips = 60/oneTrip; // change the formula on request by IBM, added on 03-08-2022 by Aniket
      var n = no_of_trips.toFixed(2);
      if(!isNaN(no_of_trips)){
        if($(this).val() != Number(no_of_trips))
        {
          showAlrt('No. of Trips / hr is not validating. Kindly correct before proceeding');
          $('#'+no_of_trips).addClass('is-invalid');
        } 
        $(this).val(n);
      }
      
     
  });
  $('#form_id').on('blur', '.total_transp_hour', function(){
  
     var total_transp_hour = $(this).attr('id');
   
     var total_transp_hourArr = total_transp_hour.split('-');
     var total_transp_hourId = total_transp_hourArr[2];
     var noTrip = $('#ta-no_of_trips-'+total_transp_hourId).val();
      var dumperCapacity = $('#ta-dumper_capacity-'+total_transp_hourId).val();
      var total_transp_hour = dumperCapacity * noTrip;
      var n = total_transp_hour.toFixed(2);
      if(!isNaN(total_transp_hour)){
        if($(this).val() != Number(total_transp_hour))
        {
          showAlrt('Total transportation per hour is not validating. Kindly correct before proceeding');
          $('#'+total_transp_hour).addClass('is-invalid');
        } 
        $(this).val(n);
      }
      
     
  });
  $('#form_id').on('blur', '.dumper_yearly_handling', function(){
  
     var dumper_yearly_handling = $(this).attr('id');
   
     var dumper_yearly_handlingArr = dumper_yearly_handling.split('-');
     var dumper_yearly_handlingId = dumper_yearly_handlingArr[2];
     var totalTran = $('#ta-total_transp_hour-'+dumper_yearly_handlingId).val();
      var totalHour = $('#ta-total_hour-'+dumper_yearly_handlingId).val();
      var dumper_yearly_handling = totalHour * totalTran;
      var n = dumper_yearly_handling.toFixed(2);
      var nStrArr = dumper_yearly_handling.toString().split('.');
      var nTruncated = (nStrArr.length == 2) ? nStrArr[0] + '.' + nStrArr[1].toString().substr(0, 4) : n;
      if(!isNaN(dumper_yearly_handling)){
        if($(this).val() == Number(n) || $(this).val() == Number(dumper_yearly_handling) || $(this).val() == Number(nTruncated)){
          $('#'+dumper_yearly_handling).removeClass('is-invalid');
        }else{
          showAlrt('Yearly handling by one dumper is not validating. Kindly correct before proceeding');
          $('#'+dumper_yearly_handling).addClass('is-invalid');
          $(this).val(n);
        }
      }
     
  });
  $('#form_id').on('blur', '.no_of_dumpers', function(){
    var no_of_dumpers = $(this).attr('id');
   
    var no_of_dumpersArr = no_of_dumpers.split('-');
    var no_of_dumpersId = no_of_dumpersArr[2];
    var dumperYearly = $('#ta-dumper_yearly_handling-'+no_of_dumpersId).val();
    var maxHand = $('#ta-max_hand_mat_block_period-'+no_of_dumpersId).val();
    var no_of_dumpers = maxHand / dumperYearly;
    var n = no_of_dumpers.toFixed(2);	

      if(!isNaN(no_of_dumpers)){
        if( Number($(this).val()).toFixed(2) != Number(n))
        {
          showAlrt('Number of dumpers will be (xi) is not validating. Kindly correct before proceeding');
          $('#'+no_of_dumpers).addClass('is-invalid');
        }		       
      }
     
  });
 	
 	

});