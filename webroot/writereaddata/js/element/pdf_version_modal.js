$(document).ready(function(){

    $('body').on('click','.view_all_pdf_version_btn',function(){

        $('#pdf_version_spinner').show();
        $('#pdf_version_tbl thead').empty();
        $('#pdf_version_tbl tbody').empty();
        $('#pdf_version_tbl_two thead').empty();
        $('#pdf_version_tbl_two tbody').empty();
        $('#pdf_approved_version_msg').empty();
        var getPdfVersionUrl = $('#get_pdf_version_url').val();
        var lid = $(this).attr('lid');
        var formLabel = 'F';
        var appid = '30APR02003';
        var rmnyr = 'November / 2022';
        $('#pdf_version_appid').text(appid+' • Form '+formLabel);
        
        var pdfApprovedTitle = 'MMS Approved Version';
        $('#pdf_mms_version_title').text(pdfApprovedTitle);
        
        var appidCol = 'Mine Code';
        var rmonthyearLabel = 'Return Month/Year';
        var theadTrOne = '<tr class="bg-light"><th>'+appidCol+'</th><th>Application Pdf</th><th>'+rmonthyearLabel+'</th><th>eSigned Date</th><th>Version</th></tr>';
        var theadTrTwo = '<tr class="bg-light"><th>'+appidCol+'</th><th>Application Pdf</th><th>'+rmonthyearLabel+'</th><th>Approved Date</th></tr>';
        $('#pdf_version_tbl thead').append(theadTrOne);

        $.ajax({
            type:'POST',
            async: true,
            cache: false,
            url: getPdfVersionUrl,
            data: {'action':'get_version_list','lid':lid},
            beforeSend: function (xhr) { // for csrf token
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp){
                $('#pdf_version_spinner').hide();
                var isApproved = false;
                var data = JSON.parse(resp);

                // info
                $('#info_appid').text(data.info.app_id);
                $('#info_lcode').text(data.info.lease_code+" ("+data.info.lease_flag.toUpperCase()+")");
                $('#info_lnm').text(data.info.lease_nm);
                $('#info_rgn').text(data.info.region);
                $('#info_rcom').text(data.info.ro_nm);
                $('#info_ddo').text(data.info.ddo_nm);
                $('#info_io').text(data.info.io_nm);
                $('#info_com').text(data.info.com_nm);
                $('#pdf_version_modal #pdf_version_content').html(data.template);

                $.each(data.row,function(key, val)
                {
                    if(val.status != 'APPROVED') 
                    {
                        var link = val.pdf_path;
                        var tbodyTr = '<tr><td class="font-weight-bold">'+appid+'</td><td><a href="'+link+'" target="_blank">'+val.pdf_name+'</a></td><td>'+rmnyr+'</td><td>'+val.esigned_date+'</td><td>'+val.version+'</td><tr>';
                        $('#pdf_version_tbl tbody').append(tbodyTr);
                    } else {
                        isApproved = true;
                        $('#pdf_version_tbl_two thead').append(theadTrTwo);
                        var link = val.pdf_path;
                        var tbodyTr = '<tr><td class="font-weight-bold">'+appid+'</td><td><a href="'+link+'" target="_blank">'+val.pdf_name+'</a></td><td>'+rmnyr+'</td><td>'+val.esigned_date+'</td><tr>';
                        $('#pdf_version_tbl_two tbody').append(tbodyTr);
                    }
                });

                if(isApproved == false){
                    var noApprovedText = '<div class="alert alert-info"><i class="fa fa-info-circle"></i> No approved version</div>';
                    $('#pdf_approved_version_msg').html(noApprovedText);
                }
            }

        });

    });

});