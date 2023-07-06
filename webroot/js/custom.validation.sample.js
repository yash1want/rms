
  $(document).ready(function(){
    $('form').keypress(function (event) {
        if (event.keyCode === 10 || event.keyCode === 13) {
            event.preventDefault();
        }
    });
  });
  
  
  /* custom validations functions */
  
  $(document).ready(function(){
  
    $(document).on('keyup keypress blur change','.cvOn',function(){
  
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
  
      var classArr = $(this).attr('class');
      var classArr = classArr.split(" ");
  
      var funcs = {
        'cvReq': cvReq,
        'cvNum': cvNum,
        'cvMin': cvMin,
        'cvMaxLen': cvMaxLen,
        'cvEmail': cvEmail,
        /*...*/
      };
  
      var cvClassArr = ['cvReq','cvNum','cvMin','cvMaxLen','cvEmail'];
  
      $.each(classArr, function(item, index){
        if(jQuery.inArray(index, cvClassArr) !== -1){
          var errorText = getErrorText(index, inputMinMax);
          var funcStatus = funcs[index](formId, input, inputId);
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
  
  
    });
  
    function getErrorText(className, inputMinMax){
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
        case 'cvEmail':
          txt = "Invalid email address";
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
      } else {
        $('#'+inputId).val($('#'+inputId).val().replace(/[^0-9]/g, ''));
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
  
    function cvEmail(formId, input){
  
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  
      var result = '0';
      if(!regex.test(input)){
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
  
      if(errCount == 0){
        $('#'+formId+' :submit').removeAttr('disabled');
      }
  
    }
  
  });
  
// on submit validations

$(document).ready(function(){

    $('.form_name').on('submit', function(){
        var returnFormStatus = true;
        var returnEmptyStatus = formEmptyStatus('.form_name');
        returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus; 

        //select field validations
        var selRw = $('.form_name').find('select').not(':hidden').not('select[disabled]').length;
        for(var i=0;i<selRw;i++){
            var selField = $('.form_name').find('select').not(':hidden').not('select[disabled]').eq(i).val();
            if(selField == ''){
                showElAlrt('.form_name', 'select', i);
                formSelStatus = 'invalid';
            }
        }

        if(formSelStatus == 'invalid'){
            showAlrt('Select value from dropdown!');
            returnFormStatus = false;
        }

        return returnFormStatus;
    });

});

/* common empty field validations */
function formEmptyStatus(formId, ){
    
    var formStatus = 'valid';
    $(formId).find('input').not(':hidden,:button').not('input[disabled]').removeClass('is-invalid');
    var inRw = $(formId).find('input').not(':hidden,:button').not('input[disabled]').length;
    for(var i=0;i<inRw;i++){
        var inField = $(formId).find('input').not(':hidden,:button').not('input[disabled]').not('.cvNotReq').eq(i).val();
        if(inField == ''){
            showFieldAlrt(formId, i);
            formStatus = 'invalid';
        }
    }

    if(formStatus == 'invalid'){
        showAlrt('Invalid data !');
    }

    return formStatus;

}


function showFieldAlrt(formId, eqId){

    $(formId).find('input').not(':hidden,:button').not('input[disabled]').eq(eqId).addClass('is-invalid');

}

/* validation related alert messages */
function showAlrt(msg){

	remAlrt();
	var alrtCon = '<div class="toast alrt-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">';
	alrtCon += '<div class="alrt-body">';
	alrtCon += '<i class="fa fa-exclamation-triangle"></i>';
	alrtCon += '<span> '+msg+'</span>';
	alrtCon += '</div>';
	alrtCon += '</div>';
	$('.alrt-div').append(alrtCon);
    $('.toast').toast('show');

}

function remAlrt(){
	$('.alrt-div .hide').remove();
}

function showElAlrt(formId, elNm, eqId){

    $(formId).find(elNm).not(':hidden,:button').not('input[disabled]').eq(eqId).addClass('is-invalid');

}