$(document).ready(function(){
        
    //$(".welcome-user-name").first("a").remove(); // REMOVING THE HOME BUTTON
    // $(".welcome-user-name").find("a").remove(); // REMOVING THE HOME AND LOGOUT BUTTON

    $("#resetPassword").submit(function(event){
    
    
   var np = $("#new_pass").val()
    
   var Stringlen = np.length;
   var ValidateDigits = /[^0-9]/g;
   var ValidateSpChar = /[a-zA-Z0-9]/g;
   var ValidateCharCaps = /[^A-Z]/g;
   var ValidateCharSmall = /[^a-z]/g;

   var digitString = np.replace(ValidateDigits , "");
   var specialString = np.replace(ValidateSpChar, "");
   var charStringCaps = np.replace(ValidateCharCaps, "");
   var charStringSmall = np.replace(ValidateCharSmall, "");
   var resetPassCaptcha = $('#captcha').val();

       if(/^[a-zA-Z0-9 ]*$/.test(resetPassCaptcha) == false || resetPassCaptcha == "" || resetPassCaptcha.length != '6') {
        $("#error_captchacode").show().text("Invalid captcha");		
        $("#captcha").click(function(){$("#error_captchacode").hide().text;});
        clearResetFields();
        return false;
    }
   
    if(Stringlen < 8)
       {
        $("#error_new_pass").show().text("Passwords must be at least 8 characters");		
        $("#new_pass").click(function(){$("#error_new_pass").hide().text;});
        clearResetFields();	
        return false;
       }
    if(specialString < 1)
       {
        $("#error_new_pass").show().text("Passwords must include at least 1 special (#,@,&,$ etc) characters");		
        $("#new_pass").click(function(){$("#error_new_pass").hide().text;});
        clearResetFields();	
        return false;
       }
    if(digitString < 1)
       {
        $("#error_new_pass").show().text("Passwords must include at least 1 numeric characters");		
        $("#new_pass").click(function(){$("#error_new_pass").hide().text;});
        clearResetFields();	
        return false;
       }
    if(charStringCaps < 1)
       {
        $("#error_new_pass").show().text("Passwords must include at least 1 capital case alphabet");		
        $("#new_pass").click(function(){$("#error_new_pass").hide().text;});
        clearResetFields();	
        return false;
       }
       
    if(charStringSmall < 1)
       {
        $("#error_new_pass").show().text("Passwords must include at least 1 small case alphabet");		
        $("#new_pass").click(function(){$("#error_new_pass").hide().text;});
        clearResetFields();	
        return false;
       }   
       
    if(np != $("#new_pass_conf").val())
       {
        $("#error_new_pass").show().text("New Password and Confirm Password must be same");		
        $("#new_pass").click(function(){$("#error_new_pass").hide().text;});
        clearResetFields();	
        return false;
       }  
    
    
      var us = sha512($("#new_pass").val());
      var usco = sha512($("#new_pass_conf").val());
      
      var tkn = $("#tkn").val();
      var tkn1 = $("#tkn1").val();
      var tkn2 = $("#tkn2").val();
         
      var usalted = tkn + us + tkn2;
      var ucsalted = tkn + usco + tkn1;
      tkn1 = " ";
      $("#tkn").val(tkn1);
      $("#tkn1").val(tkn1);
      $("#tkn2").val(tkn1);
        
        $("#new_pass").val(usalted);
        $("#new_pass_conf").val(ucsalted);
    });
    
    $("#closeTab").click(function(){
        close();
       window.close(); 
    });
    
});


// clear input fields
function clearResetFields() {
$('#new_pass').val('');
$('#new_pass_conf').val('');
$('#captcha').val('');
}