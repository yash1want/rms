$(document).ready(function(){

	$('#form_id').on('blur', '.factor', function(){
 		var id = $(this).attr('id');
	    // bucketFillValidation(id); // commented this call as change requested for removing 0 to 1 value validation by IBM division with doc reference "Validation changes for Swell Factor Box" - Aniket G [30-01-2023]
 	});
 	
	/*$('#form_id').on('blur', '.tph', function(){
 		
     var tph = $(this).attr('id');
     var tphArr = tph.split('-');
     var tphId = tphArr[2];

     var bucCap = $('#ta-bucket_capacity-'+tphId).val();
     var bucFill = $('#ta-bucket_fill_factor-'+tphId).val();
     var sweFact = $('#ta-swell_factor-'+tphId).val();
     var tonnFact = $('#ta-tonnage_factor-'+tphId).val();
     //var machiFact = $('#ta-machine_uti_factor-'+tphId).val();
	 // The above commented line has been restored as machifact is required in the calculation below
	 //Naveen Jha -- 13/09/2022 -- The TPH calculation is incorrect. 
	 var machiFact = $('#ta-machine_uti_factor-'+tphId).val();
	 
     var taEffi = $('#ta-efficiency-'+tphId).val();
     var cycleTime = $('#ta-cycle_time-'+tphId).val();
     
     //var tph = ( (3600 * (bucCap * bucFill * sweFact * tonnFact * machiFact * taEffi))/cycleTime)/1000;
     //var tph = ( (3600 * (bucCap * bucFill * sweFact * tonnFact * taEffi))/cycleTime);
	 // The above formula has bee changed to include machifact 
	 //Naveen Jha -- 13/09/2022 -- The TPH calculation is incorrect. 
	 var tphCalculated = ( (3600 * (bucCap * bucFill * sweFact * tonnFact * taEffi * machiFact))/cycleTime);
	 //Added below tph validation by rounded and truncated value upto 2 decimal places, on 16-09-2022 by Aniket G.
	 var tphArr = tphCalculated.toString().split('.');
	 var tphTruncated = (tphArr.length == 2) ? tphArr[0] + '.' + tphArr[1].toString().substr(0,2) : tphCalculated;
	 var tphRounded = tphCalculated.toFixed(2);
	 
     showAlrt(totalCal);
	 if(!isNaN(tphCalculated)){
	     if($(this).val() != Number(tphTruncated) && $(this).val() != Number(tphRounded))
	     {
	     	showAlrt('(G) TPH =TPH is not validating. Kindly correct before proceeding');
			$('#'+tph).addClass('is-invalid');
			$(this).val(tphTruncated);
	     } else {
			$('#'+tph).removeClass('is-invalid');
		 }
     } 
    
 	}); */
	
	// Added  by Shweta Apale on 30-09-2022 start
	// $('#form_id').on('blur', '.cycleTime', function () {
	$('#form_id').on('blur input', '.calAutoTph', function () { // calling tph auto calculation on calAutTph class fields - Aniket G [18-10-2022]
		var id = $(this).attr('id');
		var single_id = id.split('-');
		var elementVal = (single_id[0] + '-tph-' + single_id[2]);

		doCalculationTph(elementVal);
	});

	// Calling Total Hours auto calculation on Effshift id field (New UAT Issue List #26) - Aniket G [31-10-2022][c]
	$('#form_id').on('blur change input', '#Effshift', function () {
		doTotalHoursAutoCal();
	});

	$('#form_id').on('click blur focusout', '.calAutoTph, .tph, .total_hour, .yearly_hand_by_exc, .max_hand_mat_block_period, .exc_machine_req, .form_input_width', function(){
		doTotalHoursAutoCal();
	});

	// Reflect "Total Hours" value on newest added rows - Aniket G [31-10-2022][c]
	$('#form_id').on('click', '#add_more', function(){
		$('#table_1').ready(function(){
			var tblRws = $('#table_1 .table_body tr').length;
			var nRw = parseInt(tblRws) - 1;
			var totHours = $('#table_1 input[name="total_hour[]"]').eq(0).val();
			if(totHours != ''){
				$('#table_1 input[name="total_hour[]"]').eq(nRw).val(totHours);
			}
		});
	});

	// Do "Number of excavator machines required (K)" auto calculation for freeze field (New UAT Issue List #26) - Aniket G [31-10-2022][c]
	$('#form_id').on('blur', '.max_hand_mat_block_period', function(){
		var id = $(this).attr('id');
		doNumOfExcAutoCal(id);
	});
	
	function doCalculationTph(elementId) {
		var single_id = elementId.split('-');
		var field_val = $('#' + elementId).val();

		var bucCap = $('#' + single_id[0] + '-bucket_capacity-' + single_id[2]).val();
		var bucFill = $('#' + single_id[0] + '-bucket_fill_factor-' + single_id[2]).val();
		var sweFact = $('#' + single_id[0] + '-swell_factor-' + single_id[2]).val();
		var tonnFact = $('#' + single_id[0] + '-tonnage_factor-' + single_id[2]).val();
		var machiFact = $('#' + single_id[0] + '-machine_uti_factor-' + single_id[2]).val();
		var taEffi = $('#' + single_id[0] + '-efficiency-' + single_id[2]).val();
		var cycleTime = $('#' + single_id[0] + '-cycle_time-' + single_id[2]).val();

		//var tph = ( (3600 * (bucCap * bucFill * sweFact * tonnFact * machiFact * taEffi))/cycleTime)/1000;
		// var tph = ((3600 * (bucCap * bucFill * sweFact * tonnFact * taEffi)) / cycleTime);
		var tph = ((3600 * (bucCap * bucFill * sweFact * tonnFact * taEffi * machiFact)) / cycleTime);
		tph = tph.toFixed(2);
		if(!isNaN(tph) && tph != 'Infinity'){
			$('#' + elementId).val(tph);
		}
		
		// Do "Yearly handling by one Excavator (t)"" auto calculation (New UAT Issue List #26) - Aniket G [31-10-2022][c]
		doYearlyHandlingAutoCal(single_id[2]);
	}
	// End

	
 	$('#form_id').on('blur', '.total_hour', function(){
 	
      var total_hour = $(this).attr('id');
      var workingdays = parseInt(document.getElementById("Workingdays").value);
      var num1 = parseInt(document.getElementById("Num1").value);
      var effshift = parseInt(document.getElementById("Effshift").value);
      var total_hour = workingdays * num1  * effshift;
      var a = total_hour.toFixed(2);
      if(!isNaN(total_hour)){
      	if($(this).val() != Number(a))
	     {
	     	showAlrt('Total Hours (H) is not validating. Kindly correct before proceeding');
			$('#'+total_hour).addClass('is-invalid');
	     }
      	$(this).val(a);
      }
     
  	});
 	$('#form_id').on('blur', '.yearly_hand_by_exc', function(){
     	var yearly_hand_by_exc = $(this).attr('id');
     	var yearly_hand_by_excArr = yearly_hand_by_exc.split('-');
     	var yearly_hand_by_excId = yearly_hand_by_excArr[2];
     	var taTph = $('#ta-tph-'+yearly_hand_by_excId).val();
     	var totalHour = $('#ta-total_hour-'+yearly_hand_by_excId).val(); 
      	var yearly_hand_by_exc = taTph * totalHour;
      	var b = yearly_hand_by_exc.toFixed(2);

      	if(!isNaN(yearly_hand_by_exc)){
      	if($(this).val() != Number(yearly_hand_by_exc))
	     {
	     	showAlrt('Yearly handling by one LHD/Loader (t) is not validating. Kindly correct before proceeding');
			$('#'+yearly_hand_by_exc).addClass('is-invalid');
	     }
      	$(this).val(b);
      }
      	
     
  	});
	// commented below function as this calculation handled by auto calculation function - Aniket G [31-10-2022][u]
//   	$('#form_id').on('blur', '.exc_machine_req', function(){
//      	var exc_machine_req = $(this).attr('id');
//      	var exc_machine_reqArr = exc_machine_req.split('-');
//      	var exc_machine_reqId = exc_machine_reqArr[2];
//      	var yearlyHand = $('#ta-yearly_hand_by_exc-'+exc_machine_reqId).val();
//      	var maxHand = $('#ta-max_hand_mat_block_period-'+exc_machine_reqId).val(); 
//       	var exc_machine_req = maxHand / yearlyHand;
//       	var n = exc_machine_req.toFixed(2);
//       	$(this).val(n);
     
//   });

 	function  bucketFillValidation(elementId) 
 	{
 		var elementValue = $('#'+elementId).val();
 		if(Number(elementValue) > 0 && Number(elementValue) <= 1 )
 		{
 			$('#'+elementId).removeClass('is-invalid');
			return true;
 		}else{
 			showAlrt('Value should not be less then 0 and greater than or equal to 1');
			$('#'+elementId).val('');
			$('#'+elementId).addClass('is-invalid');
 		}
 	}
 	
 	

});

// Do total hours auto calculation for freeze field (New UAT Issue List #26) - Aniket G [31-10-2022][c]
function doTotalHoursAutoCal(){
	var workingdays = parseInt(document.getElementById("Workingdays").value);
	var num1 = parseInt(document.getElementById("Num1").value);
	var effshift = parseInt(document.getElementById("Effshift").value);
	var total_hour = workingdays * num1  * effshift;
	var a = parseInt(total_hour);
	if(!isNaN(total_hour)){
		$('#form_id .total_hour').val(a);

		// Do "Yearly handling by one Excavator (t)"" auto calculation (New UAT Issue List #26) - Aniket G [31-10-2022][c]
		doYearlyHandlingAutoCal('all');
	}
}

// Do "Yearly handling by one Excavator (t)" auto calculation for freeze field (New UAT Issue List #26) - Aniket G [31-10-2022][c]
function doYearlyHandlingAutoCal(elId){
	if(elId == 'all'){
		var tphRws = $('#form_id input[name="tph[]"]').length;

		for(var i=0; i < tphRws; i++){
			var tph = $('#form_id input[name="tph[]"]').eq(i).val();
			var totHours = $('#form_id input[name="total_hour[]"]').eq(i).val();
			var yearlyHandling = parseFloat(tph) * parseInt(totHours);
			yearlyHandling = yearlyHandling.toFixed(2);
			if(!isNaN(yearlyHandling)){
				$('#form_id input[name="yearly_hand_by_exc[]"]').eq(i).val(yearlyHandling);

				// Do "Number of excavator machines required (K)" auto calculation for freeze field (New UAT Issue List #26) - Aniket G [31-10-2022][c]
				doNumOfExcAutoCal($('#form_id input[name="tph[]"]').eq(i).attr('id'));
			}
		}

	}else{
		var tph = $('#form_id #ta-tph-'+elId).val();
		var totHours = $('#form_id #ta-total_hour-'+elId).val();
		var yearlyHandling = parseFloat(tph) * parseInt(totHours);
		yearlyHandling = yearlyHandling.toFixed(2);
		if(!isNaN(yearlyHandling)){
			$('#form_id #ta-yearly_hand_by_exc-'+elId).val(yearlyHandling);

			// Do "Number of excavator machines required (K)" auto calculation for freeze field (New UAT Issue List #26) - Aniket G [31-10-2022][c]
			doNumOfExcAutoCal('ta-max_hand_mat_block_period-'+elId);
		}
	}
}

// Do "Number of excavator machines required (K)" auto calculation for freeze field (New UAT Issue List #26) - Aniket G [31-10-2022][c]
function doNumOfExcAutoCal(elId){
	var elIdArr = elId.split('-');
	var maxHandle = $('#'+elIdArr[0]+'-max_hand_mat_block_period-'+elIdArr[2]).val();
	var yearlyHandle = $('#'+elIdArr[0]+'-yearly_hand_by_exc-'+elIdArr[2]).val();
	var excNumMachines = maxHandle / yearlyHandle;
	excNumMachines = excNumMachines.toFixed(2);
	if(!isNaN(excNumMachines)){
		$('#'+elIdArr[0]+'-exc_machine_req-'+elIdArr[2]).val(excNumMachines);
	}
}