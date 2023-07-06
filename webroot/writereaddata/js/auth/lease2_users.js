  /*  $('#lease2user').DataTable();*/
    //ajaxfunction.genLevel2UsrPass();



$( document ).ready(function() {
    $('#lease2user').DataTable();
   //ajaxfunction.genLevel2UsrPass();
});
 

//$('#lease2user').DataTable(); 

 $( document ).ready(function() {
  $('#lease2user').on('click','.genbtn',function(){
      var btn_name = $(this).text().toLowerCase();
      var row = $(this).closest("tr");

      var user_first_name = row.find('input[name="first_name"]').val();
      var user_last_name = row.find('input[name="last_name"]').val();
      var user_mobile = row.find('input[name="mobile"]').val();
      var useremail = row.find('input[name="email"]').val();
      var userid = row.find('input[name="userid"]').val();
      var level2usrid = row.find('input[name="level2usrid"]').val();
      var lease_code = row.find('input[name="lease_code"]').val();
      var lease_id = row.find('input[name="lease_id"]').val();
      var uid = row.find('input[name="uid"]').val();

      if (user_first_name === '') {
        row.find('input[name="first_name"]').focus().val('');
        return false; 
      }

      if (user_last_name === '') {
        row.find('input[name="last_name"]').focus().val('');
        return false; 
      }

      if (user_mobile === '') {
        row.find('input[name="mobile"]').focus().val('');
        return false; 
      }

      if (useremail === '') {
        row.find('input[name="email"]').focus().val('');
        return false; 
      }
    


         $.ajax({
                type:"POST",
                url : "../auth/gen-lease2-user-pass",
                data : {    level2usrid:level2usrid,
                            userid:userid,
                            first_name:user_first_name,
                            last_name:user_last_name,
                            mobile:user_mobile,
                            email:useremail,
                            btn_name:btn_name,
                            lease_code:lease_code,
                            uid:uid,
                            lease_id:lease_id,
                        },
                cache:false,

                beforeSend: function (xhr) { 
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },

                success : function(response)
                {  
                    if(response.trim() == 1)
                    {
                       
                      alert('Link Send successfully. Kindly check your email '+useremail+' for reset the password.');
                      location.reload();
                    }
                    else
                    {
                       
                      alert('Try Again.');
                      location.reload();
                    }
                }
            });
                        
        });

    
});
/*-----------------------------------------------------------------------------------------------------------------*/
 /*Custom Validation*/
 /*$(document).ready(function(){
  $('form').keypress(function (event) {
    if (event.keyCode === 10 || event.keyCode === 13) {
        event.preventDefault();
    }
  });
});*/

/* custom validations functions */

/*$(document).ready(function(){

  $(document).on('keyup keypress blur change focusout','.cvOn',function(){

    var formId = $(this).closest('form').attr('id');
    //alert(formId);return false;
    var input = $(this).val();
    var inputId = $(this).attr('id');

    var inputMin = $(this).attr('min');
    var inputMaxlength = $(this).attr('maxlength');
    var inputFloat = $(this).attr('cvfloat');

    var inputMinMax = "";

    if (typeof inputMin !== 'undefined' && inputMin !== false) {
      inputMinMax = inputMin;
    }

    if (typeof inputMaxlength !== 'undefined' && inputMaxlength !== false) {
      inputMinMax = inputMaxlength;
    }

    var inputFloatVal = "";
    var inFloatLen = 0;
    var inFloatWhole = 0;
    if (typeof inputFloat !== 'undefined' && inputFloat !== false) {
      inputFloatVal = inputFloat;
      inFloatArr = inputFloat.split('.');
      inFloatLen = inFloatArr[1].length;
      inFloatWhole = inFloatArr[0];
    }



    var classArr = $(this).attr('class');
    var classArr = classArr.split(" ");

    var funcs = {
      'cvReq': cvReq,
      'cvNum': cvNum,
      'cvMin': cvMin,
      'cvMaxLen': cvMaxLen,
      'cvFirstName': cvFirstName,
      'cvLastName': cvLastName,
      'cvMobile': cvMobile,
      'cvEmail': cvEmail,
      'cvFloat': cvFloat,
      'cvFloatRestrict': cvFloatRestrict,
      'cvDate': cvDate,
      'cvAlpha': cvAlpha,
      'cvAlphaNum': cvAlphaNum,
      
    };

    var cvClassArr = ['cvReq','cvNum','cvMin','cvMaxLen','cvFirstName','cvLastName','cvMobile','cvEmail','cvFloat','cvFloatRestrict','cvDate','cvAlpha','cvAlphaNum'];

    $.each(classArr, function(item, index){
      if(jQuery.inArray(index, cvClassArr) !== -1){
        var errorText = getErrorText(index, inputMinMax, inputFloatVal, inFloatLen, inFloatWhole);
        var funcStatus = funcs[index](formId, input, inputId);
        //console.log(funcStatus); 
        if(funcStatus == '1'){
          $('#'+inputId).parent().parent().find('.err_cv:first').text(errorText);
          disSubmitBtn(formId);
          return false;
        } else {
          $('#'+inputId).parent().parent().find('.err_cv:first').text('');
          enableSubmitBtn(formId);
        }
      }
    });


  });*/


  /*$(document).on('focusout','.cvEmail',function(){

    var formId = $(this).closest('form').attr('id');
    var input = $(this).val();
    var inputId = $(this).attr('id');

    var funcStatus = cvEmail(formId, input)
    if(funcStatus == '1'){     
      $('#'+inputId).parent().parent().find('.err_cv:first').text('Invalid email address');
      $(this).val('');
      disSubmitBtn(formId);
      return false;
    }
   
  });*/

/*
  function getErrorText(className, inputMinMax, inputFloatVal, inFloatLen, inFloatWhole){
    var txt;
    switch(className){
      case 'cvReq':
        txt = "Field is required";
        break;
      case 'cvNum':
        txt = "Must be numeric";
        break;
      case 'cvMin':
        txt = "Minimum value should be " + inputMinMax;
        break;
      case 'cvMaxLen':
        txt = "Maximum value should be " + inputMinMax;
        break;
      case 'cvFirstName':
        txt = "Invalid first name input";
        break;
     case 'cvLastName':
        txt = "Invalid last name input";
        break;
     case 'cvMobile':
        txt = "Invalid mobile input";
        break;
      case 'cvEmail':
        txt = "Invalid email address";
        break;
      case 'cvFloat':
        txt = "Please enter a value less than or equal to " + inputFloatVal;
        break;
      case 'cvFloatRestrict':
        txt = "Value must not exceeds the "+inFloatWhole+" & upto "+inFloatLen+" decimal places allowed";
        break;
      case 'cvDate':
          txt = "Please enter date in DD/MM/YYYY format";
          break;
      case 'cvAlpha':
          txt = "Please enter alphabet characters only";
          break;
        case 'cvAlphaNum':
          txt = "Please enter alphabet and numbers characters only";
          break;
      default:
        txt = "Invalid";

    }

    return txt;

  }


  function cvReq(formId, input){

    var result = '0';
    if(input == ''){
      result = '1';
    }

    return result;

  }

  function cvNum(formId, input, inputId){

    var result = '0';
    
    if($.isNumeric(input)){
      result = '0';
    } else if(input.charAt(0)=='.') 
    {
        $('#'+formId+' #'+inputId).val($('#'+inputId).val().replace(/^\./, '0.'));
        result = '0';
    }
    else {
      $('#'+formId+' #'+inputId).val($('#'+inputId).val().replace(/[^0-9]/g, ''));
      result = '1';
    }

    return result;

  }

  function cvMin(formId, input, event){

    var min = $('#'+formId+' [name="'+event+'"]').attr('min');

    var result = '0';
    if(input < min){
      result = '1';
    }

    return result;

  }

  function cvMaxLen(formId, input, event){

    var maxLen = $('#'+formId+' [name="'+event+'"]').attr('maxlength');

    var result = '0';
    if(input.length > maxLen){
      result = '1';
    }

    return result;

  }

  function cvFirstName(formId, input, inputId){
    
    var regex = new RegExp("^[a-zA-Z ]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#'+formId+' #'+inputId).val($('#'+inputId).val().replace(/[^a-zA-Z]/g, ''));
      result = '1';
    }
    
    return result;
  
  }

  function cvLastName(formId, input, inputId){
    
    var regex = new RegExp("^[a-zA-Z ]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#'+formId+' #'+inputId).val($('#'+inputId).val().replace(/[^a-zA-Z]/g, ''));
      result = '1';
    }
    
    return result;
  
  }

  function cvMobile(formId, input, inputId){
    
    var regex = new RegExp("^[0-9 ]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#'+formId+' #'+inputId).val($('#'+inputId).val().replace(/[^0-9]/g, ''));
      result = '1';
    }
    
    return result;
  
  }

  function cvEmail(formId, input){

    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    var result = '0';
    if(!regex.test(input)){
      result = '1';
    }

    return result;

  }
  
  function cvFloat(formId, input, inputId){

    var result = '0';

    var floatVal = $('#'+formId+' #'+inputId).attr('cvfloat');

    var floatValArr = floatVal.split('.');
    var valDec = floatValArr[1].length;
    var valNum = floatValArr[0];

    var inputArr = input.split('.');
    if(inputArr.length == 2){
      if(inputArr[1].length > valDec){
        $('#'+formId+' #'+inputId).val(parseFloat(input).toFixed(valDec));
      }
    }

    if(parseInt(inputArr[0]) > parseInt(valNum)){
      result = '1';
    }

    return result;

  }
  
  function cvFloatRestrict(formId, input, inputId) {

    var result = '0';

    var floatVal = $('#' + formId + ' #' + inputId).attr('cvfloat');

    var floatValArr = floatVal.split('.');
    var valDec = floatValArr[1].length;
    var valNum = floatValArr[0];

    var inputArr = input.toString().split('.');
    if (inputArr.length == 2) {
      if (inputArr[1].length > valDec) {
        inputValid = inputArr[0]+'.'+inputArr[1].toString().substr(0, valDec);
        $('#' + formId + ' #' + inputId).val(inputValid);
      }
    }

    if (parseInt(inputArr[0]) > parseInt(valNum)) {
      result = '1';
    }

    return result;

  }
  
  function cvDate(formId, input, inputId){

    var result = '0';
    var date = input.split("/");
    
    if(date.length == 3){
      
      var day = date[0];
      var month = date[1];        
      var regex = /^(0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])[\/\-]\d{4}$/;
      if (regex.test(input) || input.length == 0) {
        result = '1';
      }
      if (day > 31) {
        result = '1';
      }
      else {
        if (month > 12) {
            result = '1';
        }
      }
      
    } else {
      result = '1';
    }
    
    return result;

  }

  function cvAlpha(formId, input, inputId){
    
    var regex = new RegExp("^[a-zA-Z ]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#'+formId+' #'+inputId).val($('#'+inputId).val().replace(/[^a-zA-Z]/g, ''));
      result = '1';
    }
    
    return result;
  
  }

  function cvAlphaNum(formId, input, inputId){
    
    var regex = new RegExp("^[a-zA-Z0-9 ]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#'+formId+' #'+inputId).val($('#'+inputId).val().replace(/[^a-zA-Z0-9]/g, ''));
      result = '1';
    }
    
    return result;
  
  }

  function checkAllError(){

    var errCount = '0';
    var element = document.getElementsByClassName('err_cv');
    for(var i=0;i<element.length;i++){
      if(element[i].innerHTML){
        errCount = '1';
      }
    }

    return errCount;

  }


  function disSubmitBtn(formId){

    $('#'+formId+' :submit').attr('disabled','true');

  }

  function enableSubmitBtn(formId){

    var errCount = checkAllError();
        console.log(errCount);
    if(errCount == 0){
      $('#'+formId+' :submit').removeAttr('disabled');
    }

  }

});
*/