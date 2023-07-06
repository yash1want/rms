$(document).ready(function(){  
   $('#taken_btn').click(function(){     
  var ticket_record_id = $('#ticket_record_id').val();
 
  var token_number = $('#token_number').val();
  
  var support_team_id = $('#support_team_id').val();
  
  var username = $('#username').val();

  var edit ="edit";
 
        $.ajax({
             url:"../support-mod/save-taken-status",
             method:"GET",
             data:{ticket_record_id:ticket_record_id,token_number:token_number,support_team_id:support_team_id,username:username,edit:edit}, 
              success: function(data)
              {

               /* alert('Record Updated Successfully');
                //window.location = "../support-mod/ticket-list";
                window.location = "../support-mod/support_app/inprocess";*/

               /* $('#alert_success_msg').removeClass("d-none_msg");
                $("#alert_success_msg").fadeIn();*/
                window.location='../support-mod/support_app/inprocess';

                /*setTimeout(function(){$("#alert_success_msg").fadeOut('slow');})*/
                /*setTimeout(function(){ window.location='../support-mod/support_app/inprocess'; }, 100000);*/
                //alert(data);return false;
                //$('#success_dist').click();
              },
              error: function(data)
              {
                alert('Something Went Wrong');
              },
       });
     

   });
});

//======================= Press enter button Cursor will be next line in textarea 27-06 Ankush===========<====================================

$(document).ready(function() {
  $('textarea').on('keydown', function(event) {
    
    if (event.keyCode === 13 && !event.shiftKey) {
      var cursorPosition = this.selectionStart;
      var textareaValue = $(this).val();
      var updatedValue = textareaValue.substring(0, cursorPosition) + '\n' + textareaValue.substring(cursorPosition);
      $(this).val(updatedValue);
      this.selectionStart = this.selectionEnd = cursorPosition + 1;
      event.preventDefault();
    }
  });
});

//======================= FOR RESOLVED Status===========<====================================

  $(document).ready(function(){  
     $('#resolve_btn').click(function(){     
    var ticket_record_id = $('#ticket_record_id').val();

    var token_number = $('#token_number').val();
    //alert(token_number);
    var support_team_id = $('#support_team_id').val();
    //alert(support_team_id);
    var username = $('#username').val();
   

    var checkedTicketType = $('input[type=radio][name=resolve_btn]:checked').val();
    //alert(checkedTicketType);return false;
          if (checkedTicketType == 'Resolved') {
            $('#show_resolve_form').removeClass("d-none");
            //$('#show_resolve_form').addClass("d-none");
          }

     });
  });


/*$(document).ready(function(){  
   $('#finalResolve_btn').click(function()
  { */
   //var add_more_attachment =$('input[type=file][name=add_more_attachment]').val();
   //var arr = [];
  /* var arr = [];
    ///var add_more_attachment = document.getElementById("add_more_attachment[0]").value;
    var add_more_attachment   = $(this).find('input[type=file]').val();
    arr.push({
      add_more_attachment: add_more_attachment,
      
   });
    alert(add_more_attachment);return false;*/

    //alert(add_more_attachment);return false;

   /*let arrayItem = [];
   var sArrayItem = "";

    $.each($(".items_table .item-row"),function(index,value){
      let desc = $(this).find(".row-desc").val()
      let attach = $(this).find(".row-attach").val()
      let item = {
              ItemDesc: desc,
              ItemAttach: attach,
            }
      arrayItem.push(item)
   });
   console.log(arrayItem);
    sArrayItem = JSON.stringify(arrayItem);
   alert(sArrayItem);return false;*/





/*
    var add_more_description =$('#add_more_description').val();
    var inpro_issue_type = $('#inpro_issue_type').val();
    var description = $('#description').val();
    var ticket_record_id = $('#ticket_record_id').val();

   //alert(ticket_record_id);return false;
    var token_number = $('#token_number').val();
    //alert(token_number);
    var support_team_id = $('#support_team_id').val();
    //alert(support_team_id);
    var username = $('#username').val();

      if(inpro_issue_type=="")
      {
        $("#inpro_issue_type").css("border", "1px solid red");
        return false;
      }
      else
      {
        $("#inpro_issue_type").css("border", "3px solid #e6e6e6");
      }
      if(description=='')
      {
        $("#description").css("border", "1px solid red");
        return false;
      }
      else
      {
          $.ajax({
             url:"../support-mod/save-resolve-status",
             method:"GET",
             data:{ticket_record_id:ticket_record_id,token_number:token_number,support_team_id:support_team_id,username:username,description:description,inpro_issue_type:inpro_issue_type}, 
              success: function(data)
              {
                alert('Record Updated Successfully');
                //window.location = "../support-mod/ticket-list";
                window.location = "../support-mod/support_app/resolve";
                //alert(data);return false;
                //$('#success_dist').click();
              },
              error: function(data)
              {
                alert('Something Went Wrong');
              },
       });
      }
    

     });
  });
*/

//======================= FOR Released Status===========<====================================


$(document).ready(function(){  
     $('#release_btn').click(function(){     

    var ticket_record_id = $('#ticket_record_id').val();
    //alert(ticket_record_id);
    var token_number = $('#token_number').val();
    //alert(token_number);
    var support_team_id = $('#support_team_id').val();
    //alert(support_team_id);
    var username = $('#username').val();
    //alert(username);return false; 
      
          $.ajax({
             url:"../support-mod/save-release-status",
             method:"GET",
             data:{ticket_record_id:ticket_record_id,token_number:token_number,support_team_id:support_team_id,username:username,}, 
              success: function(data)
              {
                //alert('Record Released Successfully');
                //window.location = "../support-mod/ticket-list";
                window.location = "../support-mod/support_app/pending";
                //alert(data);return false;
                //$('#success_dist').click();
              },
              error: function(data)
              {
                alert('Something Went Wrong');
              },
       });
     });
  });
     
//=============================Add Row Js============================================= 

$(document).ready(function() {

    // upRemBtn();
    // upRemBtnAll();
    // calcInstitutionCount();

    // CapStruc.fieldValidation();

    $('#ticketTable').on('click', '#add_more_btn', function() {
        addMoreRw();
    });
    
    $('#ticketTable').on('click', '.rem_btn', function(){
        var rwId = $(this).closest('tr').attr('id');
        
        remRw(rwId);
        updateSerialNo();
    });

});

function addMoreRw() {
     
    var cRw = $('#ticketTable tbody tr:last').attr('id');
    var cRwArr = cRw.split('-');
    var nRw = parseInt(cRwArr[1]) + parseInt(1);
    
    var rwCon = '<tr id="rw-'+nRw+'"><td class="text-center srno">'+nRw+'</td>';
    rwCon += '<td><div class="input text"><input type="file" name="add_more_attachment[]"  class="row-attach form-control" id="add_more_attachment[]" value="" autocomplete="off"></div><div class="err_cv"></div></td>';
    rwCon += '<td><div class="input textarea"><textarea name="add_more_description[]" class="row-desc form-control" id="add_more_description[]" placeholder="Enter Description" value="" autocomplete="off"></textarea></div><div class="err_cv"></div></td>';
    rwCon += '<td><button type="button" class="btn btn-sm rem_btn"><i class="fa fa-times"></i></button></td></tr>';

    $('#ticketTable tbody').append(rwCon);
        

    $('#ticketTable tbody tr').each(function(i) {
        $(this).find('.srno').text(i + 1);
        $(this).attr('id', 'rw-' + (i + 1));
    });
    upRemBtn();
    calcInstitutionCount();

}

function upRemBtn(){

    var tRw = $('#ticketTable tbody tr').length;
    if(tRw == 2){
        $('#ticketTable tbody tr:first .rem_btn').removeAttr('disabled');
    } else if(tRw == 1) {
        $('#ticketTable tbody tr:first .rem_btn').attr('disabled','true');
    }

}

function remRw(rwId){

    $('#' + rwId).remove();
    upRemBtn();
    upRw();
    calcInstitutionCount();

}

function upRw() {

    var rws = $('#ticketTable tbody tr').length;
    var rwId = 1;
    for (var i=0; i < rws; i++) {

        var rw = $('#ticketTable tbody tr').eq(i);
        rw.find('.institution').attr({name: 'institute_name_'+rwId, id: 'institute_name_'+rwId});
        rw.find('.loan').attr({name: 'loan_amount_'+rwId, id: 'loan_amount_'+rwId});
        rw.find('.interest').attr({name: 'interest_rate_'+rwId, id: 'interest_rate_'+rwId});
        rw.attr('id', 'rw-'+rwId);

        rwId++;

    }
    updateSerialNo();

}
function updateSerialNo() {
   $('#ticketTable tbody tr').each(function(i) {
        $(this).find('.srno').text(i + 1);
        $(this).attr('id', 'rw-' + (i + 1));
    });
  }


function upRemBtnAll(){

    var tRw = $('#ticketTable tbody tr').length;
    if (tRw > 1) {
        $('#ticketTable tbody tr .rem_btn').removeAttr('disabled');
    } else {
        $('#ticketTable tbody tr:first .rem_btn').attr('disabled','true');
    }

}

function calcInstitutionCount() {

    var tRw = $('#ticketTable tbody tr').length;
    $('#institutionCount').val(tRw);

}

//================
/*jQuery(document).ready(function () {
    
    $('#save_resolve_status').on('submit', function(){

        //alert("hiii");return false;
         var inpro_issue_type = $('#inpro_issue_type').val();
         var description = $('#description').val();


         if(inpro_issue_type=="")
          {
            $("#inpro_issue_type").css("border", "1px solid red");
            return false;
          }
          else
          {
            $("#inpro_issue_type").css("border", "3px solid #e6e6e6");
          }
          if(description=='')
          {
            $("#description").css("border", "1px solid red");
            return false;
          }
           else
          {
            $("#description").css("border", "3px solid #e6e6e6");
          }*/


        /*var mineCode = $('#mine_code').val();

        var newAFaxNo = $("#f_a_fax_no").val().trim();
        var newAFaxNoEl = $('#f_a_fax_no');
        if ((isNummm(newAFaxNo) == 'no') || newAFaxNo.length > 15 || newAFaxNo.length < 6) {
            var replyMsg = "Fax number is not valid.";
            newAFaxNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var newAPhoneNo = $("#f_a_phone_no").val();
        var newAPhoneNoEl = $('#f_a_phone_no');
        if ((isNummm(newAPhoneNo) == 'no') || newAPhoneNo.length > 15 || newAPhoneNo.length < 6) {
            var replyMsg = "Phone number is not valid.";
            newAPhoneNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var newAMobileNo = $("#f_a_mobile_no").val();
        var newAMobileNoEl = $('#f_a_mobile_no');
        if ((isNummm(newAMobileNo) == 'no') || newAMobileNo.length != 10) {
            var replyMsg = "Mobile number is not valid.";
            newAMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var validfirstno = ['6','7','8','9'];
        var f_m_no = newAMobileNo.charAt(0);
        if($.inArray(f_m_no,validfirstno) != -1){
            
        }else{
            var replyMsg = "Mobile number is not valid.";
            newAMobileNoEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }
        
        var newAEMail = $("#f_a_email").val();
        var newAEMailEl = $('#f_a_email');
        if (isEmail(newAEMail) == false) {
            var replyMsg = "E-mail is not valid.";
            newAEMailEl.parent().next('.err_cv').text(replyMsg);
            return false;
        }*/

    /*});*/



$(document).ready(function(){  
   $('#finalResolve_btn').click(function()
  { 
    var inpro_issue_type = $('#inpro_issue_type').val();
    var description = $('#description').val();
    

      if(inpro_issue_type=="")
      {
        $("#inpro_issue_type").css("border", "1px solid red");
        return false;
      }
      else
      {
        $("#inpro_issue_type").css("border", "3px solid #e6e6e6");
      }
      if(description=='')
      {
        $("#description").css("border", "1px solid red");
        return false;
      }
      else
      {
        $("#inpro_issue_type").css("border", "3px solid #e6e6e6");
      }
      
    

     });
  });
   


//===================================================================================================

/*$('input[type=radio][name=rb_period]').change(function() {
    alert(this.value);return false;
    if (this.value == 'period') 
    {
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
*/



/*$(document).ready(function() {
    var typingTimer;
    var doneTypingInterval = 500; // milliseconds

    $('#search-form input').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    function doneTyping() {
        $('#search-form').submit();
    }
});

$(document).on('submit', '#search-form', function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    //alert(formData);return false;
    $.ajax({
        type: 'GET',
        url: $(this).attr('action'),
        data: formData,
        success: function(data) {
            alert(data);
            //$('#list').html(data);
            //$('#list').draw(data);
            //$('#list').DataTable().clear().rows.add(data).draw();
        }
    });
});
*/


    $(document).ready(function() {
        var table = $('#list').DataTable();

        $('#search-form input').keyup(function() {
            table.search($(this).val()).draw();
        });
    });

