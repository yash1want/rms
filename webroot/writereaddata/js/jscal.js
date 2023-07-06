$(document).ready(function(){

$('#form_id').on('change', '.cvFile', function(){
    var selected_file = $(this).val();
    var field_id = $(this).attr('id');
    
    var ext_type_array = ["pdf"];
    var get_file_size = $('#'.concat(field_id))[0].files[0].size;
    var get_file_ext = selected_file.split(".");
    var validExt = get_file_ext.length-1;
    var value_return = 'true';

    get_file_ext = get_file_ext[get_file_ext.length-1].toLowerCase();

    if(get_file_size > 5097152){

      $("#".concat(field_id)).parent().append('<span class="err">Please select file below 5mb </span>').css('color','red');
      $("#".concat(field_id)).addClass("is-invalid");
      $("#".concat(field_id)).click(function(){ $("#".concat(field_id)).parent().find('.err').remove(); $("#".concat(field_id)).removeClass("is-invalid");});
      $('#'.concat(field_id)).val('');
      value_return = 'false';
    }

    if(ext_type_array.lastIndexOf(get_file_ext) == -1){

      $("#".concat(field_id)).parent().append('<span class="err">Please select file type pdf only</span>').css('color','red');
      $("#".concat(field_id)).addClass("is-invalid");
      $("#".concat(field_id)).click(function(){ $("#".concat(field_id)).parent().find('.err').remove();  $("#".concat(field_id)).removeClass("is-invalid");});
      $('#'.concat(field_id)).val('');
      value_return = 'false';
    }

    if (validExt != 1){

      $("#".concat(field_id)).parent().append('<span class="err">Invalid file uploaded</span>').css('color','red');
      
      $("#".concat(field_id)).addClass("is-invalid");
      $("#".concat(field_id)).click(function(){ $("#".concat(field_id)).parent().find('.err').remove(); $("#".concat(field_id)).removeClass("is-invalid");});
      $('#'.concat(field_id)).val('');
      value_return = 'false';
    }

    if(value_return == 'false'){
      return false;
    }else{
      exit();
    }
  });


      
});
  /* validation related alert messages */
  function showAlrt(msg){

    remAlrt();
    var alrtCon = '<div class="toast alrt-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="6000">';
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


