$(document).ready(function(){

    $('#list').on('click','.view_all_pdf_version_btn',function(){

        $('#pdf_version_spinner').show();
        $('#pdf_version_tbl thead').empty();
        $('#pdf_version_tbl tbody').empty();
        $('#pdf_version_tbl_two thead').empty();
        $('#pdf_version_tbl_two tbody').empty();
        $('#pdf_approved_version_msg').empty();
        var getPdfVersionUrl = $('#get_pdf_version_url').val();
        var appid = $(this).attr('appid');
        var rtype = $(this).attr('rtype');
        var rdate = $(this).attr('rdate');
        var rmnyr = $(this).attr('rmnyr');
        var rform = $(this).attr('rform');
        var formLabel = (rform == 'authuser') ? ((rtype == 'MONTHLY') ? 'F' : 'G') : ((rtype == 'MONTHLY') ? 'L' : 'M');
        var monthyearLabel = rtype[0].toUpperCase() + rtype.slice(1).toLowerCase();
        $('#pdf_version_appid').text(appid+' • Form '+formLabel);
        $('#pdf_version_rdate').text(rmnyr+' • '+monthyearLabel);
        
        var pdfApprovedTitle = (rform == 'authuser') ? 'MMS Approved Version' : 'ME Approved Version';
        $('#pdf_mms_version_title').text(pdfApprovedTitle);
        
        var appidCol = (rform == 'authuser') ? 'Mine Code' : 'Applicant ID';
        var rmonthyearLabel = (rtype == 'MONTHLY') ? 'Return Month/Year' : 'Return Year';
        var theadTrOne = '<tr class="bg-light"><th>'+appidCol+'</th><th>Application Pdf</th><th>'+rmonthyearLabel+'</th><th>eSigned Date</th><th>Version</th></tr>';
        var theadTrTwo = '<tr class="bg-light"><th>'+appidCol+'</th><th>Application Pdf</th><th>'+rmonthyearLabel+'</th><th>Approved Date</th></tr>';
        $('#pdf_version_tbl thead').append(theadTrOne);

        $.ajax({
            type:'POST',
            async: true,
            cache: false,
            url: getPdfVersionUrl,
            data: {'action':'get_version_list','appid':appid,'rtype':rtype,'rdate':rdate,'rform':rform},
            beforeSend: function (xhr) { // for csrf token
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(resp){
                $('#pdf_version_spinner').hide();
                var isApproved = false;
                var data = JSON.parse(resp);
                $.each(data,function(key, val){
                    if(val.status != 'APPROVED') {
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