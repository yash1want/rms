$("#esign_submit_btn").prop("disabled", true);
$("#plz_wait").hide();

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];


    $("#declaration_check_box").change(function() {

        if($(this).prop('checked') == true) {

            $("#plz_wait").show();

            var pdf_generation_url = $('#pdf_generation_url').val();
            var esign_xml_url = $('#esign_xml_url').val();
       
            //updated on 28-05-2021 for Form Based Esign method
            //now direct called xml creation function from esigncontroller hereby
            //removed the call to cw-dialog.js function, no need now
            //applied multiple inner ajax calls

            $.ajax({
                type:'POST',
                async: true,
                cache: false,
                url: pdf_generation_url,
                data: {'action':'esign'},
                beforeSend: function (xhr) { // for csrf token
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    $('.form_spinner').hide('slow');
                },
                success: function(){

                    $("#plz_wait").hide();
                    $("#esign_submit_btn").prop("disabled", false);//enable esign button

                }

            });

        }

        if($(this).prop('checked') == false){

            $("#esign_submit_btn").prop("disabled", true);
        }
    });


    $(".close").click(function() {
        $('.modal-backdrop').addClass('d-none');
        $("#declarationModal").modal('hide');
        // $(".modal").hide();
        return false;
    });


//till here on 28-05-2021 for Form based method, and renoved unwanted scripts


//for final submit without esign, added on 04-05-2018 by Amol
$("#declaration_check_box_wo_esign").change(function() {

$("#okBtn_wo_esign").prop("disabled", false);

if($(this).prop('checked') == false){

    $("#okBtn_wo_esign").prop("disabled", true);
}

});
