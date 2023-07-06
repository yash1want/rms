
// For No Group in DataTable ID = tableReport
$(document).ready(function () {
    var head1 = $('#heading1').text();
    var head2 = $('#heading2').text();
    var head3 = $('#heading3').text();
    var reportExcelName = $('#reportExcelName').val();
    var reportRegionName = $('#reportRegionName').val();
    var heading = head1;

    // To get Current date
    var nowDate = new Date();
    var nowDay = ((nowDate.getDate().toString().length) == 1) ? '0' + (nowDate.getDate()) : (nowDate.getDate());
    var nowMonth = ((nowDate.getMonth().toString().length) == 1) ? '0' + (nowDate.getMonth() + 1) : (nowDate.getMonth() + 1);
    var nowYear = nowDate.getFullYear();
    var formatDate = nowDay + "." + nowMonth + "." + nowYear;

    // To get Url Last segment
    var url = $(location).attr("href");
    var segments = new URL(url).pathname.split('/');
    var last = segments.pop() || segments.pop();

    // Combined last segment with date to get csv, xsl filename as per report and date
    // var exportFilename = last + '-' + formatDate;
    var exportFilename = reportExcelName.replace('%%region_name%%',reportRegionName);
    var reportGeneratedTime = $('#reportGeneratedTime').val();
    $('#tableReport').append('<caption style="caption-side: bottom">Report generated on '+reportGeneratedTime+'</caption>');

    var table = $('#tableReport').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                filename: exportFilename,
                title: heading,
                footer: true,
                messageTop: head2 + '    ' + head3,
            },
            {
                extend: 'print',
                title: heading,
            },
        ],

        "pageLength": 25,

        // "order": [[2, 'asc'], [3, 'asc'], [4, 'asc']],

    });

    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

});


$(document).ready(function(){

    $("#years").change(function () {
        $('#months').empty();
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-report-filter-months',
            type: "POST",
            data: ({
                year: changedValue
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                var obj = JSON.parse(resp);
                var monthOption = '<option value="">--Select--</option>';

                if(obj['status'] == true){
                    $.each(obj['months'],function (key, val){
                        key = key.replace('uuu','');
                        monthOption += '<option value="'+key+'">'+val+'</option>';
                    })
                }
                $('#months').append(monthOption);
            }
        });
    });
	
	
	$("#tableReport").on('click','.reptdet',function(){
		
		let regid = $(this).parent('tr').attr('regid');
		let reportNo = $(this).attr('rept');
		let previousMonthDate = $('#previousMonthDate').val();
		let fromMonthDate = $('#fromMonthDate').val();
		let toMonthDate = $('#toMonthDate').val();
		let currval = $(this).text();
        let regName = $(this).parent('tr').find('td').eq(1).text();
        $('#reportModalHeading3').text('Region: '+regName);
		
		if(currval != 0){

            var theadTitle = 'MPAS Analytical Report (Month Wise - Region Wise)';
			var dateHead = 'Date';
            switch(reportNo){
                case '1': 
					theadTitle = 'No. of applications pending';					
					break;
                case '2': 
					theadTitle = 'No. of application submitted during the month'; // Remove brackets on 05-05-2023 by Shweta Apale
					break;
                case '3': 
					theadTitle = 'No. of application approved during the month'; // Remove brackets on 05-05-2023 by Shweta Apale
					dateHead = 'Date Of Approval';
					break;
                case '4': 
					theadTitle = 'No. of application dis-approved during the month'; // Remove brackets on 05-05-2023 by Shweta Apale
					dateHead = 'Date of Dis-approval';
					break;
                case '5': 
					theadTitle = 'No. of applications withdrawn during the month'; // Remove brackets on 05-05-2023 by Shweta Apale
					dateHead = 'Date of Withdrawn';
					break;
                case '6': 
					theadTitle = 'Disposed in &lt; 45 days'; 
					dateHead = 'Date of Disposed';
					break;
                case '7': 
					theadTitle = 'Disposed between 45-60 days';
					dateHead = 'Date of Disposed';
					break;
                case '8': 
					theadTitle = 'Disposed between 60-90 days'; 
					dateHead = 'Date of Disposed';
					break;
                case '9': 
					theadTitle = 'Disposed in &gt;90 days'; 
					dateHead = 'Date of Disposed';
					break;
            }

            $('#reportModalLabel').html(theadTitle);
			
			$.ajax({
				url: '../ajax/get-reportone-statistics-details',
				type: "POST",
				data: {
						regid: regid,
						reportNo : reportNo,
						previousMonthDate : previousMonthDate,
						fromMonthDate : fromMonthDate,
						toMonthDate : toMonthDate
					},
				beforeSend: function (xhr) {
                    $("#tableReportModal").DataTable().destroy();
					xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				},
				success: function (resp) { 
                    $('#tableReportModal .tableBodyModal').empty();
					$('#tableReportModal .tableHeadModal').empty();
                    var resp = JSON.parse(resp);
                    var rows = resp.length;
                    var srno = 1;
					
					var conHead = '';
						conHead +='<tr>';
						conHead +='<th>#</th>';
						conHead +='<th>Applicant ID</th>';
						conHead +='<th>Lease Name</th>';
						conHead +='<th>Lease Code</th>';
						conHead += '<th>Date of First Submission</th>';						
						conHead += '<th>DDO Approval Date</th>'; // added new column - Aniket G [2023-05-12]
						if($.inArray(reportNo,['3','4','5','6','7','8','9']) !== -1){
							conHead += '<th>'+dateHead+'</th>';
						}
						if($.inArray(reportNo,['6','7','8','9']) !== -1){
							conHead += '<th>Disposed Status</th>';
							conHead += '<th>Disposed Days</th>';
						}
						conHead +='<th>Version</th>';
						conHead +='<th>PDF</th>';
					conHead += '</tr>';
					
                    var con = '';
                    if(rows != 0){ 
                        $.each(resp,function (key, val){  console.log(resp);
                            con += '<tr>';
                            con += '<td>'+srno+'</td>';
                            con += '<td>'+val['applicant_id']+'</td>';
                            con += '<td>'+val['lease_name']+'</td>';
                            con += '<td>'+val['lease_code']+'</td>';
							// con += '<td>'+val['created_at']+'</td>'; // dateOfFirstSubmission changed to created_at by Shweta Apale 05-05-2023
							con += '<td>'+val['dateOfFirstSubmission']+'</td>'; // dateOfFirstSubmission changed to created_at by Shweta Apale 05-05-2023
							con += '<td>'+val['ddo_approval_dt']+'</td>'; // show 'DDO approval date' column - Aniket G [2023-05-12]
							if($.inArray(reportNo,['3','4','5','6','7','8','9']) !== -1){
								con += '<td>'+val['created_at']+'</td>';
							}
							if($.inArray(reportNo,['6','7','8','9']) !== -1){
								con += '<td class="text-capitalize">'+val['status']+'</td>';
								con += '<td>'+val['diffdays']+'</td>';
							}
                            con += '<td>'+val['version']+'</td>';
                            // con += '<td><a class="btn btn-info btn-sm m_w_max" href="../'+val['pdf_path']+'" target="_blank"><i class="fa fa-pdf"></i> View Details</a></td>'; // Changed PDF to Details on 04-05-2023 by Shweta Apale
                            con += '<td><a href="#" class="btn btn-info btn-sm m_w_max view_all_pdf_version_btn" title="View all PDF version" lid="'+val['lease_id']+'" data-toggle="modal" data-target="#pdf_version_modal"><i class="fa fa-pdf"></i> View Details</a></td>'; // Changed PDF to Details on 04-05-2023 by Shweta Apale
                            con += '</tr>';
                            srno++;
                        });
                    } else {
                        con += '<tr>';
                        con += '<td colspan="7">No records found!</td>';
                        con += '</tr>';
                    }
					$('#tableReportModal .tableHeadModal').append(conHead);
                    $('#tableReportModal .tableBodyModal').append(con);
                    tableReportModalIni();
				}
			});
		} 
		
	})
	
	

});

function tableReportModalIni(){
    var reportModalHead1 = $('#reportModalLabel').text();
    var head1 = $('#heading1').text();
    var head2 = $('#heading2').text();
    var head3 = $('#reportModalHeading3').text();
    var reportExcelName = $('#reportExcelName').val();
    var reportRegionName = $('#reportModalHeading3').text();
    var reportMonthFrom = $('#reportMonthFrom').val();
    var reportMonthTo = $('#reportMonthTo').val();
    // var heading = reportModalHead1+' - '+head1;
    var heading = head1;

    // To get Current date
    var nowDate = new Date();
    var nowDay = ((nowDate.getDate().toString().length) == 1) ? '0' + (nowDate.getDate()) : (nowDate.getDate());
    var nowMonth = ((nowDate.getMonth().toString().length) == 1) ? '0' + (nowDate.getMonth() + 1) : (nowDate.getMonth() + 1);
    var nowYear = nowDate.getFullYear();
    var formatDate = nowDay + "." + nowMonth + "." + nowYear;

    // To get Url Last segment
    var url = $(location).attr("href");
    var segments = new URL(url).pathname.split('/');
    var last = segments.pop() || segments.pop();

    // Combined last segment with date to get csv, xsl filename as per report and date
    // var exportFilename = last + '-' + formatDate;
    // var exportFilename = reportExcelName;
    var exportFilename = reportModalHead1.replaceAll('.','');
    exportFilename = exportFilename.replaceAll(' ','_');
    reportRegionName = reportRegionName.replace('Region: ','');
    reportExcelName = reportExcelName.replace('%%region_name%%',reportRegionName);
    exportFilename = exportFilename+'_'+reportExcelName;
    var reportGeneratedTime = $('#reportGeneratedTime').val();
    $('#tableReportModal caption').remove();
    $('#tableReportModal').append('<caption style="caption-side: bottom">Report generated on '+reportGeneratedTime+'</caption>');

    var reportModalLabel = $('#reportModalLabel').html();
    console.log(reportModalLabel);
    var reportSubheading;
    switch(reportModalLabel){
        case 'No. of applications pending (as on 21st of the previous month)': 
            reportSubheading = 'No. of applications pending (as on '+reportMonthFrom+' 21st)    '+head3;
            break;
        case 'No. of application submitted during the month (21st to 20th)': 
            reportSubheading = 'No. of application submitted during the month ('+reportMonthFrom+' 21st to '+reportMonthTo+' 20th)    '+head3; 
            break;
        case 'No. of application approved during the month (21st to 20th)': 
            reportSubheading = 'No. of application approved during the month ('+reportMonthFrom+' 21st to '+reportMonthTo+' 20th)    '+head3;
            break;
        case 'No. of application dis-approved during the month (21st to 20th)': 
            reportSubheading = 'No. of application dis-approved during the month ('+reportMonthFrom+' 21st to '+reportMonthTo+' 20th)    '+head3; 
            break;
        case 'No. of applications withdrawn during the month (21st to 20th)': 
            reportSubheading = 'No. of applications withdrawn during the month ('+reportMonthFrom+' 21st to '+reportMonthTo+' 20th)    '+head3; 
            break;
        case 'Disposed in &lt; 45 days': 
            reportSubheading = head2+'    '+head3;
            break;
        case 'Disposed between 45-60 days': 
            reportSubheading = head2+'    '+head3;
            break;
        case 'Disposed between 60-90 days': 
            reportSubheading = head2+'    '+head3;
            break;
        case 'Disposed in &gt;90 days': 
            reportSubheading = head2+'    '+head3;
            break;
    }

    var table = $('#tableReportModal').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                filename: exportFilename,
                title: heading,
                footer: true,
                messageTop: reportSubheading,
                exportOptions: {
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'print',
                title: heading,
            },
        ],

        "pageLength": 25,

        // "order": [[2, 'asc'], [3, 'asc'], [4, 'asc']],

    });

    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}




