// Added by Ankush T on 19/04/2023  
$(document).ready(function() {
  var checkedTicketType = $('input[type=radio][name=ticket_type]:checked').val();
  var checkedFormSubmission = $('input[type=radio][name=form_submission]:checked').val();
  var selectedIssuedType = $('#issued_type').val();

    
    
    if (checkedTicketType == 'RMS') {
      $('#issued-raise-at').removeClass('d-none');
    }
    else if (checkedTicketType == 'MPAS') {
      $('#issued-raise-at').removeClass('d-none');
      $('#form-submission').addClass("d-none");
    }
     if (selectedIssuedType == "Form Related" || selectedIssuedType == "Flow Related") {
      // alert("hii");

      $("#form-submission").removeClass("d-none");
      $("#show-form-submission").removeClass("d-none");
      $("#ticket-table").removeClass("d-none");
      $("#show-form-others").addClass("d-none");

    } else if (selectedIssuedType == "Others" || selectedIssuedType == "Change Request") {

      // alert("HELLO");
      $("#show-form-others").removeClass("d-none");
      $("#ticket-table").removeClass("d-none");
      $("#show-form-submission").addClass("d-none");
      $("#form-submission").addClass("d-none");
      $("#form-type-monthly").addClass("d-none");
      $("#form-type-annual").addClass("d-none");

    } else {
      // alert("baher");
      $("#form-submission").addClass("d-none");
      $("#show-form-submission").addClass("d-none");
      $("#show-form-others").addClass("d-none");
    }

    if (checkedFormSubmission === 'Form F' || checkedFormSubmission === 'Form L') {
      $('#form-type-monthly').removeClass('d-none');
      $("#form-type-annual").addClass("d-none");
    }
    else if (checkedFormSubmission == 'Form G' || checkedFormSubmission == 'Form N') {
      $('#form-type-annual').removeClass('d-none');
      $("#form-type-monthly").addClass("d-none");
    }

    


});
$(document).ready(function() {
  $('input[type=radio][name=ticket_type]').change(function() {

    // alert("hello")
    if (this.value == 'RMS') {
      $('#issued-raise-at').removeClass('d-none');
    }
    else if (this.value == 'MPAS') {
      $('#issued-raise-at').removeClass('d-none');
      $('#form-submission').addClass("d-none");
    }
  });
});


$(document).ready(function() {
  $("#issued_type").on("change", function() {
    var issuedType = $(this).val();
    
    if (issuedType === "Form Related" || issuedType === "Flow Related") {
      
      $("#show-form-submission").removeClass("d-none");
      $("#ticket-table").removeClass("d-none");
      $("#show-form-others").addClass("d-none");
    
    } else if (issuedType === "Others" || issuedType === "Change Request") {
      $("#show-form-others").removeClass("d-none");
      $("#ticket-table").removeClass("d-none");
      $("#show-form-submission").addClass("d-none");
      $("#form-submission").addClass("d-none");
      $("#form-type-monthly").addClass("d-none");
      $("#form-type-annual").addClass("d-none");
    
    } else {
      $("#form-submission").addClass("d-none");
      $("#show-form-submission").addClass("d-none");
      $("#show-form-others").addClass("d-none");
      $("#ticket-table").addClass("d-none");
    }
  });
});

$(document).ready(function() {
  $('input[type=radio][name=form_submission]').change(function() {
    if (this.value == 'Form F' || this.value == 'Form L') {
      $('#form-type-monthly').removeClass('d-none');
      $("#form-type-annual").addClass("d-none");
    }
    else if (this.value == 'Form G' || this.value == 'Form N') {
      $('#form-type-annual').removeClass('d-none');
      $("#form-type-monthly").addClass("d-none");
    }
  });
});
    
    //hide msg box
$(document).ready(function() {
  setTimeout(function() {
  $("#msg-box").addClass("d-none");
}, 5000);
});



// Add a click event listener to all radio buttons
$('.radio-button input[type="radio"]').click(function() {
  // Remove the active class from all radio buttons
  $('.radio-button').removeClass('active');
  
  // Add the active class to the clicked radio button
  $(this).parent().addClass('active');
});

$(document).ready(function() {
  $('input[type=radio][name=ticket_type], select[name=issued_type]').change(function() {
    if ($('input[name=ticket_type]:checked').val() === 'MPAS' && ($('select[name=issued_type]').val() === 'Flow Related' || $('select[name=issued_type]').val() === 'Form Related')) {
     $("#form-submission").addClass("d-none");
    } 
    if ($('input[name=ticket_type]:checked').val() === 'RMS' && ($('select[name=issued_type]').val() === 'Flow Related' || $('select[name=issued_type]').val() === 'Form Related')) {
     $("#form-submission").removeClass("d-none");
    } 
  });
});

$(document).ready(function(){
$('#btnsave').on('click',function(){
   
   var issued_raise_at = $('#issued_raise_at').val();
   var issued_type = $('#issued_type').val();
   var mine_code = $('#mine_code').val();
   var description = $('#description').val();
   var other_issue_type = $('#other_issue_type').val();
   var other_description = $('#other_description').val();
    
   

    if(issued_raise_at == null){
      $("#issued_raise_at_error").show().text('Please select issue raise at');
      $("#issued_raise_at").addClass("is-invalid");
      $("#issued_raise_at").focus();
      $("#issued_raise_at").val('');
      $("#issued_raise_at").click(function(){$("#issued_raise_at_error").hide().text; $("#issued_raise_at").removeClass("is-invalid");});
      
      return false;
        
    }
    if(issued_type == null){
      $("#issued_type_error").show().text('Please select issued_type');
      $("#issued_type").addClass("is-invalid");
      $("#issued_type").focus();
      $("#issued_type").val('');
      $("#issued_type").click(function(){$("#issued_type_error").hide().text; $("#issued_type").removeClass("is-invalid");});
      
      return false;
        
    }
    // if(issued_type == 'Form Related' || issued_type == 'Flow Related'){

    // // alert('hiii');return false;
    // if(mine_code == ''){
    //   $("#mine_code_error").show().text('Please enter mine code');
    //   $("#mine_code").addClass("is-invalid");
    //   $("#mine_code").focus();
    //   $("#mine_code").val('');
    //   $("#mine_code").click(function(){$("#mine_code_error").hide().text; $("#mine_code").removeClass("is-invalid");});
      
    //   return false;
        
    // }

  //   if(description == ''){
  //     $("#description").focus();
  //     $("#description_error").show().text('Please enter description');
  //     $("#description").addClass("is-invalid");
  //     $("#description").val('');
  //     $("#description").click(function(){$("#description_error").hide().text; $("#description").removeClass("is-invalid");});
      
  //     return false;
        
  //   }

  // }else{

  //   // alert('hello');return false;

  //   if(other_issue_type == ''){
  //     $("#other_issue_type_error").show().text('Please enter issue');
  //     $("#other_issue_type").addClass("is-invalid");
  //     $("#other_issue_type").focus();
  //     $("#other_issue_type").val('');
  //     $("#other_issue_type").click(function(){$("#other_issue_type_error").hide().text; $("#other_issue_type").removeClass("is-invalid");});
      
  //     return false;
        
  //   }

  //   if(other_description == ''){
  //     $("#other_description_error").show().text('Please enter other_description');
  //     $("#other_description").addClass("is-invalid");
  //     $("#other_description").focus();
  //     $("#other_description").val('');
  //     $("#other_description").click(function(){$("#other_description_error").hide().text; $("#other_description").removeClass("is-invalid");});
      
  //     return false;
        
  //   }
  //   }
    
  });

 });


$(document).ready(function() {
  $("#myButton").on("mouseenter", function() {
    $(this).css("transform", "translateX(10px)");
  });

  $("#myButton").on("mouseleave", function() {
    $(this).css("transform", "translateX(0)");
  });
});

$(document).ready(function() {
  $('.tooltip-button').tooltip({
    container: 'body',
    trigger: 'hover'
  });
});


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


 
  
  