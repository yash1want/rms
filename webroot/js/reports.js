$(document).ready(function () {
    $("#state").change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-districts-arr',
            type: "POST",
            data: ({
                state: changedValue
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                $('#district')
                    .find('option')
                    .remove();
                var mySelect = $('#district');
                mySelect.append(resp);
            }
        });
    });

    $("#district").change(function () {
        var changedValue = $(this).val();
        var changedValueState = $('#state').val();
        $.ajax({
            url: '../ajax/get-ibm-by-state-district-array',
            type: "POST",
            data: ({
                district: changedValue,
                state: changedValueState
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                $('#ibm')
                    .find('option')
                    .remove();
                var mySelect = $('#ibm');
                mySelect.append(resp);
            }
        });
    });

    $("#ibm").change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-mine-name-by-ibm-array',
            type: "POST",
            data: ({
                ibm: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                $('#minename')
                    .find('option')
                    .remove();
                var mySelect = $('#minename');
                mySelect.append(resp);
            }
        });
    });

    $("#ibm").change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-lessee-owner-by-ibm-array',
            type: "POST",
            data: ({
                ibm: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                $('#owner')
                    .find('option')
                    .remove();
                var mySelect = $('#owner');
                mySelect.append(resp);
            }
        });
    });

    //Commented because Lessee Area is not mention in any table it will uncomment in future
    $("#ibm").change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-lessee-area-by-ibm-array',
            type: "POST",
            data: ({
                ibm: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                $('#area')
                    .find('option')
                    .remove();
                var mySelect = $('#area');
                mySelect.append(resp);
            }
        });
    });

    $("#ibm").change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: '../ajax/get-mine-code-by-ibm-array',
            type: "POST",
            data: ({
                ibm: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                $('#minecode')
                    .find('option')
                    .remove();
                var mySelect = $('#minecode');
                mySelect.append(resp);
            }
        });
    });

});

$(function () {
    $(".monthDate").datepicker({
        dateFormat: 'MM yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '2011:' + (new Date).getFullYear(),
        showButtonPanel: true,

        onClose: function (dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        },
    });
});


// Changed class name by Shweta Apale on 09-03-2023
$(function () {
    $(".supportReportDates").datepicker({
        dateFormat: 'MM yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '2022:' + (new Date).getFullYear(),
        showButtonPanel: true,
        onClose: function (dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        },
    });
});


// Checking Date range on submitting the form
$(document).ready(function () {
    $("#formFilter").click(function () {
        var tdate = $('#t_date').val();
        var fdate = $('#f_date').val();

        var todate = tdate.split(' ');
        var fromdate = fdate.split(' ');

        var year1 = fromdate[1];
        var year2 = todate[1];
        var year = year2 - year1;

        if (year2 < year1) {
            alert("To Date should be greater than From Date.");
            return false;
        }

        if (year > 1) {
            alert("Selected range should be less than 1 Year");
            return false;
        }
        else {
            return true;
        }
    });
});

// For Group in DataTable Id = tableReportGroup
$(document).ready(function () {
    //Table indexing start from 0, groupColumn = 2 means 3rd column & groupColumn = 1 means 2nd column
    var showDate = 1;

	var head1 = $('#heading1').text();
    var head2 = $('#heading2').text();
    var heading = head1 + '    ' + head2;
	
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
    var exportFilename = last + '-' + formatDate;

    var table = $('#tableReportGroup').DataTable({
        dom: 'Bfrtip',
        buttons: [
		/*{
            extend: 'csvHtml5',
            text: 'Export CSV',
            filename: exportFilename,
            footer: true
        },*/
        {
            extend: 'excelHtml5',
            // messageBottom: 'he', 
            text: 'Export Excel',
            filename: exportFilename,
             title: heading,
            footer: true,
        },
           
		{
			extend: 'print',
			title: heading,
		},
        ],
        "pageLength": 25,
        "columnDefs": [
            {
                "visible": true, "targets": [showDate],

            } 
        ],
        "order": [[2, 'asc'], [3, 'asc'], [4, 'asc']],
        "rowGroup": {
            dataSrc: [showDate]
        },
    	

        "drawCallback": function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;

            api.column(showDate, { page: 'current' }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td class="groupWeight" colspan="37">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });

        }
    });
    // For Order By & Serial Number
    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

});





// For No Group in DataTable ID = tableReport
$(document).ready(function () {
    var head1 = $('#heading1').text();
    var head2 = $('#heading2').text();
    var heading = head1 + '    ' + head2;

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
    var exportFilename = last + '-' + formatDate;

    var table = $('#tableReport').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                filename: exportFilename,
                title: heading,
                footer: true,
            }
            /*{
                extend: 'print',
                title: heading,
            },*/
        ],

        "pageLength": 25,

        "order": [[2, 'asc'], [3, 'asc'], [4, 'asc']],

    });

    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

});


// For No Group in DataTable ID = tableReportm03
$(document).ready(function () {
    var head1 = $('#heading1').text();
    var head2 = $('#heading2').text();
    var heading = head1 + '    ' + head2;

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
    var exportFilename = last + '-' + formatDate;

    var table = $('#tableReportm03').DataTable({
       /* dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                filename: exportFilename,
                title: heading,
                footer: true,
            },
            {
                extend: 'print',
                title: heading,
            },
        ],*/

        "pageLength": 25,

        "order": [[2, 'asc'], [3, 'asc'], [4, 'asc']],

    });

    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

});

	// To download excel 
	// Added by Shweta Apale on 27-07-2022 start
	$(document).ready(function () {
		$("#downloadExcel").on('click', function () {
			var head1 = $('#heading1').text();
			var head2 = $('#heading2').text();
			var heading = head1 + '    ' + head2;

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
			var exportFilename = last + '-' + formatDate;
			tableToExcel('noDatatable', exportFilename);
		});
	});

	var tableToExcel = (function () {
		var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
			, base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }

		return function (table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
			// window.location.href = uri + base64(format(template, ctx))

			// To give custom file name
			var a = document.createElement('a');
			a.href = uri + base64(format(template, ctx))
			a.download = name + '.xls';
			//triggering the function
			a.click();
		}
	})()
	// End

	// Added by Shweta Apale on 27-07-2022 to print table start
	$(document).ready(function () {
		$('#printTable').on('click', function () {
			printData();
		})
	})

	function printData() {
		var divToPrint = document.getElementById("noDatatable");
		newWin = window.open("");
		newWin.document.write(divToPrint.outerHTML);
		newWin.print();
		newWin.close();
	}
	// End
