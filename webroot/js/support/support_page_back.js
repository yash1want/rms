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
                alert('Record Updated Successfully');
                //window.location = "../support-mod/ticket-list";
                window.location = "../support-mod/support_app/inprocess";
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

//=======================FOR RESOLVED ===========<====================================

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

$(document).ready(function(){  
     $('#finalResolve_btn').click(function(){     
    var description = $('#description').val();
    var ticket_record_id = $('#ticket_record_id').val();

   //alert(ticket_record_id);return false;
    var token_number = $('#token_number').val();
    //alert(token_number);
    var support_team_id = $('#support_team_id').val();
    //alert(support_team_id);
    var username = $('#username').val();
   
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
             data:{ticket_record_id:ticket_record_id,token_number:token_number,support_team_id:support_team_id,username:username,description:description}, 
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


    
  
    
    
