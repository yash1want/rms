$(document).ready(function(){

    $('#reset_year_btn').hide();
    $("#approved_result").empty();

    $('#date_execution').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "1970:2050",
        
    });
    $('#date_approval').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1970:2050",
        dateFormat: 'dd/mm/yy'
    });
    $('#date_conmmencement').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1970:2050",
        dateFormat: 'dd/mm/yy'
    });

   
    var current_year = (new Date).getFullYear();
    var currentYear = parseInt(current_year) - 5;

    get_five_year_dropdown(currentYear);

    get_five_year_block(currentYear);

    // On Financial Year Change
    $("#start_year").on('change',function(){
        var selectyear = $(this).val();
        var selectedyearvalue = selectyear.split('-');
        var startyear = selectedyearvalue[0];
        get_five_year_block(startyear);
    });

    $("#reset_year_btn").on('click',function(){
        var resetYear = $('#reset_start_year').val();
        clear_year_on_reset(resetYear);
    });

    
    // Get Approved Mineral Production Details
    $("#mineral_name").on('change',function(){
        $('#reset_year_btn').hide();			

        var mineral_name = $(this).val();
        var plan_id = $('#plan_id').val();
        //alert(mineral_name);return false;
        $.ajax({
            type:'POST',
            url:'get-mineral-details',
            data:{mineral_name:mineral_name,plan_id:plan_id},
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success : function(response){
                
                $("#document_type").empty();

                if(response == 0){

                    var options = '<option value="">Select</option><option value="1">Mining Plan</option><option value="2">Modification of Mining Plan</option><option value="3">Schemes of Mining</option><option value="4">Modification of Scheme of Mining</option>';
                    $("#document_type").append(options);
                    clear_form_data(currentYear);
                    $("#approved_result").empty();
                    $("#final_submit").css('display','none');
                }else{
                    var obj = JSON.parse(response);

                    if(obj[1]['reset_year_btn'] == true){
                        $('#reset_year_btn').show();
                        $('#reset_start_year').val(obj[1]['reset_start_year']);
                    }
                    
                    if(obj[0] == 'saved'){

                        show_form_data(obj[1]);
                        $("#approved_result").empty();
                        $("#final_submit").css('display','block');
                    }

                    if(obj[0] == 'final_submitted'){

                        alert("You already filled the Mining Plan for this mineral and your Mining Plan is under scrutinization. Please wait till it gets scrutinized.");
                        $('#btnsave').css('display','none');
                        $('#final_submit').css('display','none');
                        $("#approved_result").empty();
                        $("#mineral_name").val('');
                    }

                    if(obj[0] == 'accepted'){

                        var ro_dashboard = $("#ro_dashboard").val();

                        if(ro_dashboard=='yes')
                        {
                            show_form_data(obj[1]);
                            $('select').attr('disabled',true);
                            $('input').attr('disabled',true);
                            $('textarea').attr('disabled',true);
                            $('#accepted').css('display','none');

                        }else
                        {
                            $("#approved_list").css('display','block');
                            show_approved_data(obj[1]);
                            var options = '<option value="">Select</option><option value="2">Modification of Mining Plan</option><option value="3">Schemes of Mining</option><option value="4">Modification of Scheme of Mining</option>';
                            $("#document_type").append(options);
                        }

                    }
                    if(obj[0] == 'pending'){

                        show_form_data(obj[1]);

                    }

                    
                }
            }

        })
    });

    $("#date_execution").on('change',function(){

        var date_execution_date =compareDateFormat( $("#date_execution").val());
        var date_approval = compareDateFormat($("#date_approval").val());
        var date_conmmencement = compareDateFormat($("#date_conmmencement").val());

        
        if(date_approval !='' && date_conmmencement !=''){

            if(!((new Date(date_execution_date) < new Date(date_approval)) 
            && (new Date(date_execution_date) < new Date(date_conmmencement))) )
            {  
               // alert('Date of execution of mining lease should be less than Approval Date and Commencement Date');
               // $("#date_execution").val('');
            }  
        } 

    });

    $("#date_approval").on('change',function(){

        var date_execution_date = compareDateFormat($("#date_execution").val());
        var date_approval = compareDateFormat($("#date_approval").val());
        var date_conmmencement = compareDateFormat($("#date_conmmencement").val());

        if(date_execution_date != ''){

            if(!((new Date(date_execution_date) < new Date(date_approval)) 
            && (new Date(date_execution_date) < new Date(date_conmmencement))) )
            {  
               // alert('Date of execution of mining lease should be less than Approval Date and Commencement Date');
                //$("#date_execution").val('');
            }  
        }
              
    });

    $("#date_conmmencement").on('change',function(){
        
        var date_execution_date = compareDateFormat($("#date_execution").val());
        var date_approval = compareDateFormat($("#date_approval").val());
        var date_conmmencement = compareDateFormat($("#date_conmmencement").val());

        if(date_execution_date != ''){

            if(!((new Date(date_execution_date) < new Date(date_approval)) 
            && (new Date(date_execution_date) < new Date(date_conmmencement))) )
            {  
               // alert('Date of execution of mining lease should be less than Approval Date and Commencement Date');
               // $("#date_execution").val('');
            }  
        }

    });



    $("#btnsave").on('click',function(){

       var year_1 = $("#year_1").val();
       var year_2 = $("#year_2").val();
       var year_3 = $("#year_3").val();
       var year_4 = $("#year_4").val();
       var year_5 = $("#year_5").val();

       var mineral_name = $("#mineral_name").val();
       var date_execution = $("#date_execution").val();
       var date_approval = $("#date_approval").val();
       var date_conmmencement = $("#date_conmmencement").val();
       var document_type = $("#document_type").val();

       var return_value = 'true';

       if(year_1 == ''){
         $("#error_year_1").text("enter the value"); 
         $("#year_1").addClass('is-invalid');
         return_value = 'false';
       }

       if(year_2 == ''){
        $("#error_year_2").text("enter the value"); 
        $("#year_2").addClass('is-invalid');   
         return_value = 'false';
       }

       if(year_3 == ''){
        $("#error_year_3").text("enter the value"); 
        $("#year_3").addClass('is-invalid');   
        return_value = 'false';
       }

       if(year_4 == ''){
        $("#error_year_4").text("enter the value"); 
        $("#year_4").addClass('is-invalid');   
        return_value = 'false';
       }

       if(year_5 == ''){
        $("#error_year_5").text("enter the value"); 
        $("#year_5").addClass('is-invalid');   
        return_value = 'false';
       }

       if(mineral_name == ''){
        $("#error_mineral_name").text("Select the mineral name"); 
        $("#mineral_name").addClass('is-invalid');  
        return_value = 'false';
       }

        if(date_execution == ''){
            $("#error_date_execution").text("Select the execution date"); 
            $("#date_execution").addClass('is-invalid');  
            return_value = 'false';
        }

        if(date_approval == ''){
            $("#error_date_approval").text("Select the approval date"); 
            $("#date_approval").addClass('is-invalid'); 
            return_value = 'false';
        }

        if(date_conmmencement == ''){
            $("#error_date_conmmencement").text("Select the conmmencement date"); 
            $("#date_conmmencement").addClass('is-invalid'); 
            return_value = 'false';
        }

        if(document_type == ''){
            $("#error_document_type").text("Select the document"); 
            $("#document_type").addClass('is-invalid'); 
            return_value = 'false';
        }

        if(return_value == 'false'){
            return false;
        }
    });

    var ro_dashboard = $("#ro_dashboard").val();
    var ro_selected_mineral = $("#ro_selected_mineral").val();

    if(ro_dashboard == 'yes' && ro_selected_mineral != ''){
        $(".reset").css('display','none');
        $("#final_submit").css('display','none');
        $("#btnsave").css('display','none');
        $("#approved_list").css('display','none');
        $("#mineral_name").val(ro_selected_mineral);        
        $("#mineral_name").change();
        $('#mineral_name option')
        .filter(function() {
            return !this.value || $.trim(this.value).length == 0;
        }).remove(); 

    }else{
        $("#accepted").css('display','none');
        $("#reason_text").css('display','none');
        $(".reason_box").css('display','none');
        $("#approved_list").css('display','none');
        $("#final_submit").css('display','none');
    }

});

// Get Five years Block
function get_five_year_block(currentYear){

    var K = 2;
    for(var n = 1; n < 5; n++){
        
        var year_start = parseInt(currentYear) + n;
        var year_end = parseInt(year_start) + 1;
        
        var options = $(document.createElement('option'));
        $('#year_'+K+'_label').text(year_start + "-" + year_end);        
        K++;
    }
}

// show form data
function show_form_data(data){

    $("#start_year").empty();

    if(data['approved_record'] == 'no'){
        var options = '<option value="">Select</option><option value="1">Mining Plan</option><option value="2">Modification of Mining Plan</option><option value="3">Schemes of Mining</option><option value="4">Modification of Scheme of Mining</option>';
    }else{
        var options = '<option value="">Select</option><option value="2">Modification of Mining Plan</option><option value="3">Schemes of Mining</option><option value="4">Modification of Scheme of Mining</option>';
    }
    $("#document_type").append(options);

	if(data['CREATED_AT'] == null){
		
		var start_year = (parseInt(data['FIRST_SUBMIT_DATE'])-1)+'-'+data['FIRST_SUBMIT_DATE'];
		get_five_year_block((parseInt(data['FIRST_SUBMIT_DATE'])-1));
		get_five_year_dropdown((parseInt(data['FIRST_SUBMIT_DATE'])-1));
	}else{
		
		// var createddate = data['CREATED_AT'].split('T')[0];
		var createddate = data['UPDATED_AT'].split('T')[0];
		
		if(createddate > '2022-04-01'){
			var start_year = (parseInt(data['FIRST_SUBMIT_DATE'])-1)+'-'+data['FIRST_SUBMIT_DATE'];
			get_five_year_block((parseInt(data['FIRST_SUBMIT_DATE'])-1));
			get_five_year_dropdown((parseInt(data['FIRST_SUBMIT_DATE'])-1));
			
		}else{
			
			var start_year = data['FIRST_SUBMIT_DATE']+'-'+(parseInt(data['FIRST_SUBMIT_DATE'])+1);
			get_five_year_block((parseInt(data['FIRST_SUBMIT_DATE'])));
			get_five_year_dropdown((parseInt(data['FIRST_SUBMIT_DATE'])));
		}
	}
	
    // var start_year = (parseInt(data['FIRST_SUBMIT_DATE'])-1)+'-'+data['FIRST_SUBMIT_DATE'];

    // get_five_year_block((parseInt(data['FIRST_SUBMIT_DATE'])-1));
    // get_five_year_dropdown((parseInt(data['FIRST_SUBMIT_DATE'])-1));

    $("#document_type").val(data['DOCUMENT_TYPE']);
	if(data['APPR_DATE'] == '' || data['APPR_DATE'] == null){ /** do nothing */ } else { $("#date_approval").val(dateFormat(data['APPR_DATE'])); }
	if(data['COMMENCEMENT_DATE'] == '' || data['COMMENCEMENT_DATE'] == null){ /** do nothing */ } else { $("#date_conmmencement").val(dateFormat(data['COMMENCEMENT_DATE'])); }
	if(data['EFF_APPR_DATE'] == '' || data['EFF_APPR_DATE'] == null){ /** do nothing */ } else { $("#date_execution").val(dateFormat(data['EFF_APPR_DATE'])); }
    $("#start_year").val(start_year);
    $("#year_1").val(data['YEAR_1']);
    $("#year_2").val(data['YEAR_2']);
    $("#year_3").val(data['YEAR_3']);
    $("#year_4").val(data['YEAR_4']);
    $("#year_5").val(data['YEAR_5']);

    
}

// show approved data
function show_approved_data(data){

    var fin_year_1  = (parseInt(data['FIRST_SUBMIT_DATE'])-1)+'-'+data['FIRST_SUBMIT_DATE'];
    var fin_year_2  = data['FIRST_SUBMIT_DATE']+'-'+(parseInt(data['FIRST_SUBMIT_DATE'])+1); 
    var fin_year_3  = (parseInt(data['FIRST_SUBMIT_DATE'])+1)+'-'+(parseInt(data['FIRST_SUBMIT_DATE'])+2);
    var fin_year_4  = (parseInt(data['FIRST_SUBMIT_DATE'])+2)+'-'+(parseInt(data['FIRST_SUBMIT_DATE'])+3);
    var fin_year_5  = (parseInt(data['FIRST_SUBMIT_DATE'])+3)+'-'+(parseInt(data['FIRST_SUBMIT_DATE'])+4);
    var approvedRecord = "<tr><td><label>Sr.No</label></td><td><label>Financial Year:</label></td><td><label>Unit of Measurement: Tonne</label></td></tr>";
    approvedRecord += "<tr>"+"<td><label>1</label></td><td><label>"+fin_year_1+"</label></td>"+"<td><label>"+data['YEAR_1']+"</label></td></tr>";
    approvedRecord += "<tr>"+"<td><label>2</label></td><td><label>"+fin_year_2+"</label></td>"+"<td><label>"+data['YEAR_2']+"</label></td></tr>";
    approvedRecord += "<tr>"+"<td><label>3</label></td><td><label>"+fin_year_3+"</label></td>"+"<td><label>"+data['YEAR_3']+"</label></td></tr>";
    approvedRecord += "<tr>"+"<td><label>4</label></td><td><label>"+fin_year_4+"</label></td>"+"<td><label>"+data['YEAR_4']+"</label></td></tr>";
    approvedRecord += "<tr>"+"<td><label>5</label></td><td><label>"+fin_year_5+"</label></td>"+"<td><label>"+data['YEAR_5']+"</label></td></tr>";

    $("#approved_result").empty();
    $("#approved_result").append(approvedRecord);
}

function clear_form_data(currentYear){

    $("#start_year").empty();
    get_five_year_dropdown(currentYear);

    $("#document_type").val('');
    $("#date_approval").val('');
    $("#date_conmmencement").val('');
    $("#date_execution").val('');
    $("#start_year").val(currentYear+'-'+(parseInt(currentYear)+1));
    $("#year_1").val('');
    $("#year_2").val('');
    $("#year_3").val('');
    $("#year_4").val('');
    $("#year_5").val('');
}

function clear_year_on_reset(currentYear){
    $("#start_year").empty();
    get_five_year_dropdown(currentYear);
    $("#start_year").val(currentYear+'-'+(parseInt(currentYear)+1));
    get_five_year_block(currentYear);
}

function get_five_year_dropdown(currentYear){
    
    var mpCurrentYear = $('#mp_current_year').val();
    var mpCurrentMonth = $('#mp_current_month').val();
    var yearDiff = parseInt(mpCurrentYear) - currentYear;
    yearDiff = (mpCurrentMonth >= 4) ? yearDiff + 1 : yearDiff;
    // for(var m = 0; m < 6; m++){
    for(var m = 0; m < yearDiff; m++){

        var year_start = parseInt(currentYear) + m;
        var year_end = parseInt(year_start) + 1;
        
        var options = $(document.createElement('option'));
        options.html(year_start + "-" + year_end);
        options.attr("value",year_start + "-" + year_end);
        $("#start_year").append(options);
    }
}

function dateFormat(date){
    var splitDate = date.split('-');
    //return splitDate[1]+'/'+splitDate[2]+'/'+splitDate[0];
    return splitDate[2]+'/'+splitDate[1]+'/'+splitDate[0];
}
function compareDateFormat(date){
    var splitDate = date.split('/');
    return splitDate[1]+'/'+splitDate[0]+'/'+splitDate[2];
}  
