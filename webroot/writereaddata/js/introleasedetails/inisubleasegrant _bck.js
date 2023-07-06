$(document).ready(function(){
	let getalldata = [];
	$(document).on('change blur keyup keypress','table',function(){
		var rowlength = $("table > tbody > tr").length;
		rowlength = rowlength-1;
		$("table > tbody > tr").each(function () {
	    	var element = $(this).find('td').children('.cvOn');	    	
			let getsinglerowdata = [];
			if (element.length>0) {
	    	for (var i = 0; i < element.length; i++) {
	    			//console.log(element[i]);
	    				var id = $(element[i]).attr('id');
						var arrayIndex = id.split('-')[2];
						var index = parseInt(rowlength-1) + parseInt(i);
	    			
			    		if (element[i].nodeName==='SELECT') {
			    					var select = $(element[i]).children('option');
			    					var selectid = $(element[i]).attr('id');
			    					var userselected = $('#'+selectid).val();
									var valueaccordingtoselect = $(select[arrayIndex-1]).val();
									if (userselected!=undefined && userselected!='') {

									if (valueaccordingtoselect!=userselected) {
										if(event.type==='change'){
											alert('You are not allowed to change selected value in grant column!');
										}
									}
									}
									$('#'+selectid).val(valueaccordingtoselect);
							}
									
			    		if ( element[i].nodeName === 'INPUT' ) {
			    				var previousfrom = parseInt(arrayIndex)-parseInt(1);

			    				var fromasperuserview = parseInt(arrayIndex)-parseInt(1);
			    				var toasperuserview = parseInt(fromasperuserview)-parseInt(1);
			    					
			    				var grant_from  =  $("#ta-grant_from-"+arrayIndex).val();
			    				var grant_from_label  =  $("#ta-lease_grant_number-"+arrayIndex+' option:selected').text();
			    				var grant_to  =  $("#ta-grant_to-"+previousfrom).val();
			    				var grant_to_label  =  $("#ta-lease_grant_number-"+previousfrom+' option:selected').text();

			    			
			    				if (new Date(grant_from) <= new Date(grant_to)) {
			    					var errorText = grant_from_label+' "From date" should be greater than '+grant_to_label+' "To date".';
			    				$("#ta-grant_from-"+arrayIndex).parent().parent().find('.err_cv:first').text(errorText);
			    				}
			    		}

	    				var selected = $(element[i]).val();

		    			if(getalldata[rowlength-1]===undefined){ 
		    				getsinglerowdata.push(selected);
		    			}else{
		    				getalldata[rowlength-1][i] = selected;
		    			}
				
	    		}

	    		if(getalldata[rowlength-1]===undefined){
	    		 getalldata.push(getsinglerowdata);
	    		}
	    	}
			});		    					
	    		 console.log(getalldata);
		});

	
	
	});

