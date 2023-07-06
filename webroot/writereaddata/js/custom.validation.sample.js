
$(document).ready(function () {
  $('form').keypress(function (event) {
    if (event.keyCode === 10 || event.keyCode === 13) {
      event.preventDefault();
    }
  });
});


/* custom validations functions */

$(document).ready(function () {
  /*setTimeout(function() {
      $("select").prepend("<option value=''> -- Select --</option>");
  }, 100);*/


$(document).on('focusout', '.cvOn', function () {
	
	var formId = $(this).closest('form').attr('id');
	var input = $(this).val();
	var inputId = $(this).attr('id');
	
	
	var inputMin = $(this).attr('min');
    var inputMaxlength = $(this).attr('maxlength');

    var inputMinMax = "";

    if (typeof inputMin !== 'undefined' && inputMin !== false) {
      inputMinMax = inputMin;
    }

    if (typeof inputMaxlength !== 'undefined' && inputMaxlength !== false) {
      inputMinMax = inputMaxlength;
    }
    
    var inputFloatVal = "";

    if (typeof inputFloat !== 'undefined' && inputFloat !== false) {
      inputFloatVal = inputFloat;
    }
	
	var classArr = $(this).attr('class');
    var classArr = classArr.split(" ");
	
	var funcs = {
		'cvMobile': cvMobile,
        'cvEmail': cvEmail,
		'cvLatLong' : cvLatLong //Added by Shweta Apale
	};
	
	var cvClassArr = ['cvMobile','cvEmail','cvLatLong'];
	
	
	$.each(classArr, function (item, index) {
      if (jQuery.inArray(index, cvClassArr) !== -1) {
        //extra parameter "inputId" passed by Amey S. on 05/01/2022
        var errorText = getErrorText(index, inputMinMax, inputId);
		
        var funcStatus = funcs[index](formId, input, inputId);
		
        if (funcStatus == '1') {
          $('#' + inputId).parent().parent().find('.err_cv:first').text(errorText);
          $('#' + formId + ' #' + inputId).val('');		  
          return false;
        } else {
          $('#' + inputId).parent().parent().find('.err_cv:first').text('');
          //enableSubmitBtn(formId);
        }
      }
    });	
	 
});

  $(document).on('keyup keypress blur change', '.cvOn', function () {

    var formId = $(this).closest('form').attr('id');
    var input = $(this).val();
    var inputId = $(this).attr('id');

    var inputMin = $(this).attr('min');
    var inputMaxlength = $(this).attr('maxlength');

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
    var inputFloat = $(this).attr('cvfloat');
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
      'cvNumSlash': cvNumSlash,
      'cvNumAlphaSlash': cvNumAlphaSlash,
      'cvMin': cvMin,
      'cvMaxLen': cvMaxLen,
      'cvEmail':cvEmail,
      'cvFloat': cvFloat,
      'cvFloatRestrict': cvFloatRestrict, //added on 16-09-2022 by Aniket G.
      'cvDate': cvDate,
      'cvAlpha': cvAlpha,
      'cvAlphaNum': cvAlphaNum,
      'cvAlphaNumSpecial': cvAlphaNumSpecial,
      'cvDegree': cvDegree,
      'cvCompair': cvCompair,           //added by Amey S.       
      'cvHide': cvHide,                 //added by Amey S. 
      'cvShow': cvShow,                 //added by Amey S. 
      'cvShowHide': cvShowHide,         //added by Amey S.         
      'cvYearDiff': cvYearDiff,         //added by Amey S.      
      'cvFinaYearDiff': cvFinaYearDiff, //added by Shankhpal Shende on 06/05/2022   
      'cvFileExcel': cvFileExcel,         //added by Amey S.   
      'cvFileSizeExcel': cvFileSizeExcel, // Added By Shweta Apale
      'cvFilePdfExcel': cvFilePdfExcel,         // added by Aniket
      'cvFileSizePdfExcel': cvFileSizePdfExcel, // added by Aniket
      'cvNegative': cvNegative,         //added by Shalini D.  
      'cvNotFloat': cvNotFloat, // Added By Shweta Apale
      'cvNotZero': cvNotZero,           // Added By Shalini D. 
      //'cvLatLong': cvLatLong,           // Added By Shalini D.
      'cvNotZeroButZeroPoint': cvNotZeroButZeroPoint, // Added by Shweta Apale 
      'cvNumSpecial' : cvNumSpecial,
	  cvFileCommon: cvFileCommon, //Added by Shweta Apale on 21-06-2022
      /*...*/
    };

    var cvClassArr = ['cvReq', 'cvNum', 'cvNumSlash', 'cvNumAlphaSlash', 'cvFloat', 'cvFloatRestrict', 'cvMin', 'cvMaxLen', 'cvEmail','cvCompair', 'cvHide', 'cvShow', 'cvShowHide', 'cvYearDiff', 'cvFinaYearDiff', 'cvFileExcel', 'cvFileSizeExcel', 'cvFilePdfExcel', 'cvFileSizePdfExcel', 'cvAlpha', 'cvAlphaNum', 'cvAlphaNumSpecial', 'cvNegative', 'cvNotFloat', 'cvNotZero', 'cvDegree', 'cvNotZeroButZeroPoint', 'cvNumSpecial','cvFileCommon'];

    $.each(classArr, function (item, index) {
      if (jQuery.inArray(index, cvClassArr) !== -1) {
        //extra parameter "inputId" passed by Amey S. on 05/01/2022
        var errorText = getErrorText(index, inputMinMax, inputId, inputFloatVal, inFloatLen, inFloatWhole);
        var funcStatus = funcs[index](formId, input, inputId);
        if (funcStatus == '1') {
          $('#' + inputId).parent().parent().find('.err_cv:first').text(errorText);
          //disSubmitBtn(formId);
          return false;
        } else {
          $('#' + inputId).parent().parent().find('.err_cv:first').text('');
          //enableSubmitBtn(formId);
        }
      }
    });


  });

  function getErrorText(className, inputMinMax, inputId, inputFloatVal, inFloatLen, inFloatWhole) {
    var txt;
    switch (className) {
      case 'cvReq':
        txt = "Field is required";
        break;
      case 'cvNum':
        txt = "Must be numeric";
        break;
      case 'cvNumSlash':
        txt = "Invalid username";
        break;
      case 'cvNumAlphaSlash':
        txt = "Invalid username";
        break;
      case 'cvMin':
        txt = "Minimum value should be " + inputMinMax;
        break;
      case 'cvMaxLen':
        txt = "Maximum value should be " + inputMinMax;
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
      case 'cvAlphaNumSpecial':
        txt = "Please enter alphabet,numbers and special characters only";
        break;
      case 'cvCompair':
        txt = getMessageforcompair(inputId);
        break;
      case 'cvYearDiff':
        txt = 'There should be 5 year of span between "From" and "To" date!';
        break;
      case 'cvFinaYearDiff':
        txt = 'There should be 5 year of span between "From" and "To" date!';
        break;
      case 'cvFileExcel':
        /*txt = 'Invalid file format!';*/
        txt = 'Please select file type Excel only';
        break;
      case 'cvFileSizeExcel':
        txt = 'File size exceeds';
        break;
      case 'cvFilePdfExcel':
        /*txt = 'Invalid file format!';*/
        txt = 'Please select file type PDF/Excel only';
        break;
      case 'cvFileSizePdfExcel':
        txt = 'File size exceeds';
        break;
      case 'cvNegative':
        txt = 'Must be numeric';
        break;
      case 'cvNotFloat':
        txt = 'Must be numeric';
        break;
      case 'cvNotZero':
        txt = 'Invalid Input';
        break;
      case 'cvNotZeroButZeroPoint':
        txt = 'Invalid Input';
        break;
      case 'cvLatLong':
        txt = 'Invalid Input Format';
        break;
      case 'cvDegree':
        txt = "0 to 90 degree only";
        break;
      case 'cvNumSpecial':
        txt = "Only number & special characters( : , . , - ) are allowed";
        break;
	 case 'cvMobile':
        txt = "Invalid mobile input";
        break;	 	
	// Adde by Shweta Apale on 21-06-2022 Start
     case "cvFileCommon":
        txt = "Only Excel & PDF are allowed";
        break;	
      default:
        txt = "Invalid";

    }

    return txt;

  }



  function cvReq(formId, input) {

    var result = '0';
    if (input == '') {
      result = '1';
    }

    return result;
  }

  //modified by shalini
  function cvNum(formId, input, inputId) {
    var result = '0';
    if ($.isNumeric(input)) {
      result = '0';
    } else if (input.charAt(0) == '.') {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/^\./, '0.'));
      result = '0';
    }
    else {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^0-9]/g, ''));
      result = '1';
    }
    return result;
  }
  
  function cvNumSlash(formId, input, inputId) {
    var result = '0'
    var regex = new RegExp("^[0-9/]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^0-9/]/g, ''));
      result = '1';
    }

    return result;
  }
  
  /**
   * Added for Secondary Lease user username
   * @author Aniket G
   * @version 22-06-2023
   */
  function cvNumAlphaSlash(formId, input, inputId) {
    var result = '0'
    var regex = new RegExp("^[A-Z0-9/]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^0-9/]/g, ''));
      result = '1';
    }

    return result;
  }

  // Added By Shweta Apale
  function cvNotFloat(formId, input, inputId) {
    var regex = /^[0-9]*$/;

    var result = '0';
    if (!regex.test(input)) {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^0-9]/g, ''));
      result = '1';
    }

    return result;
  }
  // Added By Shalini D
  function cvNotZero(formId, input, inputId) {
    var regex = /^[1-9]*$/;

    var result = '0';
    if (input <= 0) {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^1-9]/g, ''));
      result = '1';
    }

    return result;
  }

  // Added by Shweta Apale
  function cvNotZeroButZeroPoint(formId, input, inputId) {
    var regex = /^(?!0(\.0*)?$)\d+(\.?\d{0,2})?$/;

    var result = '0';
    if (input <= 0) {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/^(?!0(\.0*)?$)\d+(\.?\d{0,2})?$/g, ''));
      result = '1';
    }

    return result;
  }

  //added by shalini d
  function cvNegative(formId, input, inputId) {
    var result = '0';
    if (Number(input) < 0) {
      result = '0';
    } else if ($.isNumeric(input)) {
      result = '0';
    }
    else {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^0-9-]/g, ''));
      result = '1';
    }

    return result;

  }
  /*function cvNum(formId, input, inputId){
    var result = '0';
    if($.isNumeric(input)){
      result = '0';
    } else {
      $('#'+inputId).val($('#'+inputId).val().replace(/[^0-9]/g, ''));
      result = '1';
    }
 
    return result;
 
  }*/
  //end 

  function cvMin(formId, input, event) {

    var min = $('#' + formId + ' [name="' + event + '"]').attr('min');

    var result = '0';
    if (input < min) {
      result = '1';
    }

    return result;

  }

  function cvMaxLen(formId, input, event) {

    var maxLen = $('#' + formId + ' [name="' + event + '"]').attr('maxlength');

    var result = '0';
    if (input.length > maxLen) {
      result = '1';
    }

    return result;

  }

  function cvEmail(formId, input) {

    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    var result = '0';
    if (!regex.test(input)) {
      result = '1';
    }

    return result;

  }
  
  function cvMobile(formId, input, inputId) {
	
    var regex = /^\d{10}$/;

    var result = '0';
    if (!regex.test(input)) {		
      result = '1';
    }
	
    return result;

  }


  function cvFloat(formId, input, inputId) {

    var result = '0';

    var floatVal = $('#' + formId + ' #' + inputId).attr('cvfloat');
    var floatValArr = floatVal.split('.');
    var valDec = floatValArr[1].length;
    var valNum = floatValArr[0];	

    var inputArr = input.split('.');
		
    if (inputArr.length == 2) {
      if (inputArr[1].length > valDec) {
		  
        $('#' + formId + ' #' + inputId).val(parseFloat(input).toFixed(valDec));		
      }
    }

    if (parseInt(inputArr[0]) > parseInt(valNum)) {
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

  function cvDate(formId, input, inputId) {

    var result = '0';
    var date = input.split("/");

    if (date.length == 3) {

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

  function cvAlpha(formId, input, inputId) {

    var regex = new RegExp("^[a-zA-Z ]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^a-zA-Z ]/g, ''));
      result = '1';
    }

    return result;

  }
  //added by pradip
  function cvAlphaNumSpecial(formId, input, inputId) {

    // var regex = new RegExp("^[a-zA-Z0-9\-\n:/!@$%&*.',\";? <>()+]+$"); //Change in validation by Shweta Apale on 24-06-2022
	var regex = new RegExp("^[a-zA-Z0-9\-\n:/!@$%&*.,\`;? <>()+]+$"); //Change in validation by Shweta Apale on 30-08-2022
	 
    if (regex.test(input)) {
      var result = '0';
    } else {
      /*$('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^a-zA-Z0-9\-\n:/!@$%&*.',\";? <>()+]/g, "")) //Change in validation by Shweta Apale on 24-06-2022 */
	  
	  $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^a-zA-Z0-9\-\n:/!@$%&*.,\`;? <>()+]/g, "")) //Change in validation by Shweta Apale on 30-08-2022
	  
      result = '1';
    }

    return result;

  }

 /* function cvNumSpecial(formId, input, inputId) {

    var regex = new RegExp("^[0-9:/!@$%&*.', <>()-]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[0-9:/!@$%&*.', <>()-]/g, ''));
      result = '1';
    }

    return result;

  }*/
  
  function cvNumSpecial(formId, input, inputId) {
        
        result = '0'
     var regex = new RegExp("^[0-9:.-]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^0-9:. -]/g, ''));
      result = '1';
    }

    return result;
  }


  function cvAlphaNum(formId, input, inputId) {

    var regex = new RegExp("^[a-zA-Z0-9\n ]+$");
    if (regex.test(input)) {
      var result = '0';
    } else {
      $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^a-zA-Z0-9\n ]/g, ''));
      result = '1';
    }

    return result;

  }



  function cvDegree(formId, input, inputId) {
    //alert(input);
    // var regex = new RegExp("^[0-9]|[1-9][0]|90+$");
    // if (regex.test(input > 90)) {
    //   var result = '0';
    // } else {
    //   $('#' + formId + ' #' + inputId).val($('#' + inputId).val().replace(/[^[0-9]|[1-9][0]|90]/g, ''));
    //   result = '1';
    // }

    // return result;
    
    //alert(input);
    var result = '0';
    if(parseFloat(input) > 90){
      $('#' + formId + ' #' + inputId).val('');
      result = '1';
    }else if(parseFloat(input) < 0){
      $('#' + formId + ' #' + inputId).val('');
      result = '1';
    } else {
      result = '0';
    }

    return result;

  }




  function checkAllError() {

    var errCount = '0';
    var element = document.getElementsByClassName('err_cv');
    for (var i = 0; i < element.length; i++) {
      if (element[i].innerHTML) {
        errCount = '1';
      }
    }

    return errCount;

  }

  function disSubmitBtn(formId) {

    $('#' + formId + ' :submit').attr('disabled', 'true');

  }

  function enableSubmitBtn(formId) {

    var errCount = checkAllError();

    if (errCount == 0) {
      $('#' + formId + ' :submit').removeAttr('disabled');
    }

  }

});

// on submit validations


$(document).ready(function () {

  $('.form_name').on('submit', function () {

    var returnFormStatus = true;
    var formSelStatus = 'valid';

    var returnEmptyStatus = formEmptyStatus('.form_name');
    returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
    //select field validations
    var selRw = $('.form_name').find('select').not(':hidden,.cvNotReq').not('select[disabled]').length;
    for (var i = 0; i < selRw; i++) {
      var selField = $('.form_name').find('select').not(':hidden,.cvNotReq').not('select[disabled]').eq(i).val();
      if (selField == '') {
        showElAlrt('.form_name', 'select', i);
        formSelStatus = 'invalid';
      }
    }
    //  alert(formSelStatus);
    if (formSelStatus == 'invalid') {

      showAlrt('Select value from dropdown!');
      returnFormStatus = false;
    }
    // alert(returnFormStatus);

    return returnFormStatus;
  });

});

/* common empty field validations */
function formEmptyStatus(formId) {
  var formStatus = 'valid';
  $(formId).find('input').not(':hidden,:button').not('input[disabled]').removeClass('is-invalid');
  var inRw = $(formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').length;
  for (var i = 0; i < inRw; i++) {
    var inField = $(formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').eq(i).val();
    var inType = $(formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').eq(i).attr('type');
    if (inType == 'file') {
      var prevField = $(formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').eq(i).next('.hidden_doc').val();
      if (prevField == '' & inField == '') {
        showFieldAlrt(formId, i);
        formStatus = 'invalid';
      }
    } else if (inType == 'checkbox') {
      //
    } else if (inField == '') {
      showFieldAlrt(formId, i);
      formStatus = 'invalid';
    }
  }

  if (formStatus == 'invalid') {
    // showAlrt('Invalid data !');
    showAlrt('Please check all fields!');


  }

  return formStatus;

}


function showFieldAlrt(formId, eqId) {

  $(formId).find('input').not(':hidden,:button,.cvNotReq').not('input[disabled]').eq(eqId).addClass('is-invalid');

}

/* validation related alert messages */
function showAlrt(msg) {

  remAlrt();
  var alrtCon = '<div class="alrt-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">';
  alrtCon += '<div class="alrt-body">';
  alrtCon += '<i class="fa fa-exclamation-triangle"></i>';
  alrtCon += '<span> ' + msg + '</span>';
  alrtCon += '</div>';
  alrtCon += '</div>';
  $('.alrt-div').append(alrtCon);
  $('.alrt-danger').show();

}

function remAlrt() {
  $('.alrt-div .hide').remove();
}

function showElAlrt(formId, elNm, eqId) {

  $(formId).find(elNm).not(':hidden,:button').not('input[disabled]').eq(eqId).addClass('is-invalid');

}


/*Addded By Amey S. on 05/01/2022*/

/*start*/
function cvCompair(formId, input, inputId) {
  var inputval = $('#' + formId + ' #' + inputId).val();
  var inputcompval = $('#' + formId + ' #' + inputId).attr('compval');
  var inputvaltype = $('#' + formId + ' #' + inputId).attr('valuetype');
  var inputtype = $('#' + formId + ' #' + inputId).attr('type');

  inputvaltype = inputvaltype != undefined ? inputvaltype : inputtype;
  var input2val_id = $('#' + formId + ' #' + inputId).attr('compwith');

  var input2value = $('#' + input2val_id).val();
  var input2valtype = $('#' + input2val_id).attr('valuetype');
  var input2type = $('#' + input2val_id).attr('type');
  // console.log(input2type);
  input2valtype = input2valtype != undefined ? input2valtype : input2type;
 

  if (inputvaltype == 'date' && input2valtype == 'date') {
    inputval = new Date(inputval);
    input2value = new Date(input2value);


  }
  else {
    inputval = (inputval != '' || inputval == undefined) ? parseFloat(inputval) : 0;
    input2value = (input2value != '' || input2value == undefined) ? parseFloat(input2value) : 0;
  }

  var result = '0';

  if (input2value == '' || inputval == '') {
    result = '1';
  }
  else if (inputcompval == 'small' && (input2value < inputval)) {
    result = '1';
    $('#' + inputId).val(''); // added by shankhpal shende on 6/5/2022
  }
  else if (inputcompval == 'big' && (input2value > inputval)) {
    result = '1';
    $('#' + inputId).val(''); // added by shankhpal shende 6/5/2022 Commented By Shweta Apale on 16-05-2022 because not able to put value 
  }

  return result;

}

function getMessageforcompair(inputId) {
  
  var label1 = $('#' + inputId).parent().parent().children('label').text().replace(/:/g, '');
 
  var input2val_id = $('#' + inputId).attr('compwith');

  var input2compval = $('#' + inputId).attr('compval');
  // console.log(input2compval);

  var label2 = $('#' + input2val_id).parent().parent().children('label').text().replace(/:/g, '');
  if (input2compval == 'small') {

    if (label1 == '') {
      label1 = $('#' + inputId).attr('msgname');
     
      label2 = $('#' + input2val_id).attr('msgname');
      if (label1 == '' || label1 == undefined) {
        label1 = 'From date';
        label2 = 'To date';
      }

    } else {

      label2 = $('#' + input2val_id).attr('msgname');
   

    }
  }
  else {

    if (label2 == '') {      
      label2 = $('#' + input2val_id).attr('msgname');
      label1 = $('#' + inputId).attr('msgname');
      // console.log(label1);

      if (label2 == '' || label2 == undefined) {
        label1 = 'To date';
        label2 = 'From date';
      }
    } else {      
      label1 = $('#' + inputId).attr('msgname');
      // console.log(label1);
    }
  }

  var msg = label1 + ' should be greater than ' + label2;
  if (input2compval == 'small') {
    msg = label1 + ' should be smaller than ' + label2;
  }
  return msg;
}


//added on 06/01/2022 By Amey S. for hideing element
function cvHide(formId, input, inputId) {

  var hideid = $('#' + formId + ' #' + inputId).attr('hideid');
  var selecthideids = $('select[id^="' + hideid + '"]');
  if (selecthideids.length <= 0) {

    selecthideids = $('input[id^="' + hideid + '"]');
  }
  $('#' + hideid + 'More').hide();

  $.each(selecthideids, function (item, index) {
    var id = $(this).attr('id');
    $('#' + id).removeClass('cvReq');
    $(this).parent().parent().find('.err_cv:first').text('');
  });

}

//added on 06/01/2022 By Amey S. for showing element
function cvShow(formId, input, inputId) {

  $('#' + inputId + 'More').show();
  var selecthideids = $('select[id^="' + inputId + '"]');

  if (selecthideids.length <= 0) {

    selecthideids = $('input[id^="' + inputId + '"]');
  }

  $.each(selecthideids, function (item, index) {
    var id = $(this).attr('id');
    $('#' + id).addClass('cvReq');
  });
}


//added on 06/01/2022 By Amey S. for hideing element
function cvShowHide(formId, input, inputId) {

  var hideid = $('#' + formId + ' #' + inputId).attr('hideid');
  var ischecked = $('#' + inputId + ':checked');

  if (ischecked.length > 0) {
    $('#' + inputId + 'More').show();
    $('#' + hideid).addClass('cvReq');
  } else {
    $('#' + inputId + 'More').hide();
    $('#' + hideid).removeClass('cvReq');
  }

}

//added on 07/01/2022 By Amey S. for checking 5 years difference
function cvYearDiff(formId, input, inputId) {


  var result = '0';
  var inputval = $('#' + formId + ' #' + inputId).val();


  var inputcompval = $('#' + formId + ' #' + inputId).attr('compval');
  var input2val_id = $('#' + formId + ' #' + inputId).attr('compwith'); //compair
  var input2value = $('#' + input2val_id).val();

  inputval = new Date(inputval);

  var year = inputval.getFullYear();
  var month = inputval.getMonth() + 1;
  var day = inputval.getDate();

  input2val = new Date(input2value);
  var year2 = input2val.getFullYear();

  if (inputcompval == 'big') {
    year = year - 5;
  }
  else {
    year = year + 5;
  }

  month = month < 10 ? '0' + month : month;
  day = day < 10 ? '0' + day : day;

  //var inputval1 = year + '-' + month + '-' + day;
  var inputval1 = year;
  var inputval2 = year2;

  if (inputval1 != inputval2) {
    //var inputval = $('#' + formId + ' #' + inputId).val('');
    result = '1';
  }

  return result;

}


//added on 06/05/2022 By Shankhpal Shende. for checking 5 years difference
function cvFinaYearDiff(formId, input, inputId) {


  var result = '0';
  var inputval = $('#' + formId + ' #' + inputId).val();

  var inputcompval = $('#' + formId + ' #' + inputId).attr('compval');
  var input2val_id = $('#' + formId + ' #' + inputId).attr('compwith'); //compair
  var input2value = $('#' + input2val_id).val();

  var date1 = input2value;
  var date2 = inputval;

  var year1 = date1.split('-');
  var year2 = date2.split('-');

  var newdt1 = year1[0]
  var newdt1 = year1[1]

  var newdt2 = year2[0]
  var newdt2 = year2[1]


  var diff_year = year(newdt2, newdt1)

  function year(newdt2, newdt1) {

    var dt2 = new Date(newdt2);
    var dt1 = new Date(newdt1);

    var diff = (dt2.getTime() - dt1.getTime()) / 1000;
    diff /= (60 * 60 * 24);

    return Math.abs(Math.round(diff / 365.25));
  }

  if (diff_year <= 5) {
    var result = '0';

  }
  else {
    var result = '1'
    $('#' + inputId).val('');
  }
  return result;

}








//File validation common function
function cvFileExcel(formId, input, inputId) {

  var selected_file = $('#'.concat(inputId)).val();
  var ext_type_array = ["xlsx", "xls"];

  var get_file_ext = selected_file.substr((selected_file.lastIndexOf('.') + 1));

  var value_return = 'true';

  get_file_ext = get_file_ext.toLowerCase();

  if (ext_type_array.lastIndexOf(get_file_ext) == -1) {
    var inputval = $('#' + formId + ' #' + inputId).val('');
    value_return = 'false';
  }

  if (value_return == 'false') {
    var inputval = $('#' + formId + ' #' + inputId).val('');
    return '1';
  }
  else {
    return '0';
  }

}

// Excel file size validation
function cvFileSizeExcel(formId, input, inputId) {

  var selected_file = $('#'.concat(inputId)).val();
  var ext_type_array = ["xlsx", "xls"];

  var get_file_size = $('#'.concat(inputId))[0].files[0].size;

  var value_return = 'true';

  if (get_file_size > 5097152) {
    value_return = 'false';

  }

  if (value_return == 'false') {
    var inputval = $('#' + formId + ' #' + inputId).val('');
    return '1';
  }
  else {
    return '0';
  }

}

//File validation common function
function cvFilePdfExcel(formId, input, inputId) {

  var selected_file = $('#'.concat(inputId)).val();
  var ext_type_array = ["pdf", "xlsx", "xls"];

  var get_file_ext = selected_file.substr((selected_file.lastIndexOf('.') + 1));

  var value_return = 'true';

  get_file_ext = get_file_ext.toLowerCase();

  if (ext_type_array.lastIndexOf(get_file_ext) == -1) {
    var inputval = $('#' + formId + ' #' + inputId).val('');
    value_return = 'false';
  }

  if (value_return == 'false') {
    var inputval = $('#' + formId + ' #' + inputId).val('');
    return '1';
  }
  else {
    return '0';
  }

}

// Excel file size validation
function cvFileSizePdfExcel(formId, input, inputId) {

  var selected_file = $('#'.concat(inputId)).val();
  var ext_type_array = ["pdf", "xlsx", "xls"];

  var get_file_size = $('#'.concat(inputId))[0].files[0].size;

  var value_return = 'true';

  if (get_file_size > 5097152) {
    value_return = 'false';

  }

  if (value_return == 'false') {
    var inputval = $('#' + formId + ' #' + inputId).val('');
    return '1';
  }
  else {
    return '0';
  }

}

//Lat Long common function added by shalini d date : 21/03/2022
function cvLatLong(formId, input, inputId) {
  var result = '0';
  var inputval = $('#' + formId + ' #' + inputId).val();
  //var regex = /^([0-9][0-9]:[0-9][0-9]:[0-9][0-9].[0-9][0-9]+$)/;
  // for last only dot accept done by laxmi B. on 04-11-2022
  var regex = /^([0-9][0-9]:[0-9][0-9]:[0-9][0-9][.][0-9][0-9]+$)/;

  if (!regex.test(inputval)) {
    result = '1';
  }
  
  return result;
}

/*End*/


//File validation common function to upload PDF & Excel Made by Shweta Apale on 21-06-2022 Start
function cvFileCommon(formId, input, inputId) {
  var selected_file = $("#".concat(inputId)).val();
  var ext_type_array = ["xlsx", "xls", "pdf"];

  var get_file_ext = selected_file.substr(selected_file.lastIndexOf(".") + 1);

  var value_return = "true";

  get_file_ext = get_file_ext.toLowerCase();

  if (ext_type_array.lastIndexOf(get_file_ext) == -1) {
    var inputval = $("#" + formId + " #" + inputId).val("");
    value_return = "false";
  }

  if (value_return == "false") {
    var inputval = $("#" + formId + " #" + inputId).val("");
    return "1";
  } else {
    return "0";
  }
}
// End

// Added by Shweta Apale on 24-06-2022 to get enter key work for textarea start
$(document).ready(function () {
  $("textarea").on("keypress", function (e) {
    var key = e.keyCode;
	var id = $(this).attr('id');
	
    // If the user has pressed enter
    if (key == 13) {
	  document.getElementById(id).value = document.getElementById(id).value + "\n";	 
      return false;
    }
    else {
      return true;
    }
  });
});
// End



$(document).ready(function () {

	// Added  by Pravin Bhakare on 10-10-2022 
	$('.charCount').keyup(function () {
		var characterCount = $(this).val().length,
			current = $('#current'),
			maximum = $('#maximum'),
			theCount = $('#the-count');

		current.text(characterCount);

		if (characterCount < 1500) {
			current.css('color', '#666');
		}
		if (characterCount > 1500 && characterCount < 1600) {
			current.css('color', '#6d5555');
		}
		if (characterCount > 1600 && characterCount < 1700) {
			current.css('color', '#793535');
		}
		if (characterCount > 1700 && characterCount < 1800) {
			current.css('color', '#841c1c');
		}
		if (characterCount > 1800 && characterCount < 1899) {
			current.css('color', '#8f0001');
		}
		if (characterCount >= 1900) {
			maximum.css('color', '#8f0001');
			current.css('color', '#8f0001');
			theCount.css('font-weight', 'bold');
		} else {
			maximum.css('color', '#666');
			theCount.css('font-weight', 'normal');
		}
	});

});



