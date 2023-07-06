
$(document).ready(function(){

    $('#frmRomStocks').ready(function(){

        /* opening stock modification alert */

        $("#f_open_oc_rom").blur(function () {
            var ow_old = $('#f_open_oc_rom_old').val();
            if ($("#f_open_oc_rom").val() != ow_old) {
                if (ow_old != ''){
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });
        
        $("#f_open_dw_rom").blur(function () {
            var dw_old = $('#f_open_dw_rom_old').val();
            if ($("#f_open_dw_rom").val() != dw_old) {
                if (dw_old != ''){
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });

        $("#f_open_ug_rom").blur(function () {
            var fu_old = $('#f_open_ug_rom_old').val();
            if ($("#f_open_ug_rom").val() != fu_old) {
                if (fu_old != ''){
                    alert("Please send an e-mail to IBM clarifying this variation");
                }
            }
        });


        $('#frmRomStocks').on('submit', function(){

            //call the estimated production validation on onsubmit action
            estProdF1Validation();

            var openingOpen = document.getElementById('f_open_oc_rom').value;
            var productionOpen = document.getElementById('f_prod_oc_rom').value;
            var closingOpen = parseFloat(document.getElementById('f_clos_oc_rom').value);

            var openingDump = document.getElementById('f_open_dw_rom').value;
            var productionDump = document.getElementById('f_prod_dw_rom').value;
            var closingDump = parseFloat(document.getElementById('f_clos_dw_rom').value);

            var actCloseOpen = roundOff3(parseFloat(openingOpen) + parseFloat(productionOpen));
            var actCloseDump = roundOff3(parseFloat(openingDump) + parseFloat(productionDump));

            if (closingOpen > actCloseOpen) {
                showAlrt("Closing stock should be less than or equal to Opening + Production.");
                document.getElementById('f_clos_oc_rom').classList.add('is-invalid');
                document.getElementById('f_clos_oc_rom').focus();
                return false;
            } else if (closingDump > actCloseDump) {
                showAlrt("Closing stock should be less than or equal to Opening + Production.");
                document.getElementById('f_clos_dw_rom').classList.add('is-invalid');
                document.getElementById('f_clos_dw_rom').focus();
                return false;
            } else {
                return true;
            }

        });
        
        var prevMonth = $('#prev_month').val();
        var mineCode = $('#mine_code').val();
        var returnType = $('#return_type').val();
        var mineralName = $('#mineral_name').val();
        var ironSubMin = $('#iron_sub_min').val();
        var post_data = {prev_month: prevMonth, mine_code: mineCode, return_type: returnType, mineral: mineralName, iron_sub_min: ironSubMin};
        var romPrevClosStockUrl = $('#rom_prev_clos_stock_url').val();

        $.ajax({
            url: romPrevClosStockUrl,
            type: 'POST',
            data: post_data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (response) {
                var data = json_parse(response);
                if ($("#f_open_oc_rom").val() == '')
                    $("#f_open_oc_rom").val(data['oc']);
                if ($("#f_open_ug_rom").val() == '')
                    $("#f_open_ug_rom").val(data['ug']);
                if ($("#f_open_dw_rom").val() == '')
                    $("#f_open_dw_rom").val(data['dw']);
            }
        });

        var returnType = $('#return_type').val();
        if (returnType == "ANNUAL") {
            // var explosiveData = "<?php // echo $explosiveTotalRomOre; ?>";
            custom_validations.fRomProductionPreValueAlert();
            // custom_validations.fRomProductionVsExplCons(explosiveData);
            custom_validations.closeIconClick();
        }

    });

});

function estProdF1Validation(){

    var cum_prod = document.getElementById('cum_prod').value;
    var estimated_prod = document.getElementById('estimated_prod').value;
    
    var prod_oc = document.getElementById('f_open_oc_rom').value;
    var prod_dw = document.getElementById('f_prod_dw_rom').value;
    
    var form_entry_total = parseFloat(prod_oc) + parseFloat(prod_dw);
    
    var total_prod = parseFloat(cum_prod) + form_entry_total;
    
    if (total_prod > estimated_prod){
        alert('Cumulative production of ROM exceeded the approved production for the financial year');
    }

}

function roundOff3(value) {

    var temp_value = parseFloat(value);
    var round_off_value = temp_value.toFixed(3);

    return round_off_value;

}