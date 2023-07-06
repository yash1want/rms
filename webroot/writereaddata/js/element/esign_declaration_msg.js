$("#esign_submit_btn").prop("disabled", true);
$("#submit_without_esign_btn").prop("disabled", true); //testing purpose only
$("#plz_wait").hide();
$("#plz_wait_withdraw").hide();

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];


    $("#declaration_check_box").change(function() {

        if($(this).prop('checked') == true) {

            $("#plz_wait").show();
            $("#plz_wait_withdraw").show();

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

                    $.ajax({
                        type:'POST',
                        async: true,
                        cache: false,
                        url: esign_xml_url,
                        beforeSend: function (xhr) { // for csrf token
                            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                        },
                        success: function(xmlresult){

                            xmlresult = JSON.parse(xmlresult);

                            $("#eSignRequest").val('');
                            $("#aspTxnID").val('');

                            $("#eSignRequest").val(xmlresult.xml);
                            $("#aspTxnID").val(xmlresult.txnid);

                            $("#plz_wait").hide();
                            $("#plz_wait_withdraw").hide();
                            $("#esign_submit_btn").prop("disabled", false);//enable esign button
                            $("#submit_without_esign_btn").prop("disabled", false); //testing purpose only

                        }
                    });

                }

            });

        }

        if($(this).prop('checked') == false){

            $("#esign_submit_btn").prop("disabled", true);
            $("#submit_without_esign_btn").prop("disabled", true); //testing purpose only
        }
    });


    $("#esign_submit_btn").click(function(){

        if(confirm("You are now Redirecting to CDAC Server for Esign Authentication")){

            return true;
        }else{
            return false;
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

