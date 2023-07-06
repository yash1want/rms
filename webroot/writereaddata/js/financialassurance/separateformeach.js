$(document).ready(function () {
    
    /*$('#total1').on('focusout',  function () {

        var areaStart = $('#start_year_area1').val();
        var addReq = $('#add_reqs1').val();
        
        var t = parseFloat(areaStart)+parseFloat(addReq);
        var total = $(this).val();
        console.log(total);
        total = parseFloat(total);
        console.log(total);

        if(t != total){
            alert('Incorrect Calculation');
            return false;
        }

        // alert(total);

        // document.getElementById('total1').value = parseFloat(areaStart)+parseFloat(addReq);
    
    })
*/


	$('.valuea').on('change', function () {

        start_year_area_total_cal();

        var inId = $(this).attr('id');
        var inIdArr = inId.split('-');
        var rowId = inIdArr[1];

        var value1 = ($("#start_year_area-" + rowId).val() == '') ? 0 : $("#start_year_area-" + rowId).val();
        var value2 = ($("#add_reqs-" + rowId).val() == '') ? 0 : $("#add_reqs-" + rowId).val();

        var total = 0;

        total = parseFloat(value1) + parseFloat(value2);
        if(total < 0){
            $("#start_year_area-" + rowId).val('');
            $("#total-" + rowId).val('');
            showAlrt('The absolute value of <b>Additional Requirement (ha) (B)*</b> shouldn\'t be more than <b>Area put to use at Start of Year (ha) (A)</b>!');
        }else{
            $("#total-" + rowId).val(total.toFixed(2));
        }
        total_total_cal();

    });

    $('.valueb').on('change', function () {

        add_reqs_total_cal();

        var inId = $(this).attr('id');
        var inIdArr = inId.split('-');
        var rowId = inIdArr[1];

        var value1 = ($("#start_year_area-" + rowId).val() == '') ? 0 : $("#start_year_area-" + rowId).val();
        var value2 = ($("#add_reqs-" + rowId).val() == '') ? 0 : $("#add_reqs-" + rowId).val();

        var total = 0;

        total = parseFloat(value1) + parseFloat(value2);
        if(total < 0){
            $("#add_reqs-" + rowId).val('');
            $("#total-" + rowId).val('');
            showAlrt('The absolute value of <b>Additional Requirement (ha) (B)*</b> shouldn\'t be more than <b>Area put to use at Start of Year (ha) (A)</b>!');
        }else{
            $("#total-" + rowId).val(total.toFixed(2));
        }
        total_total_cal();

    });
	
	
	$('.totalv').on('change', function () {
        total_total_cal();
    });



    $('.totalv').on('focusout', function () {

        var inId = $(this).attr('id');
        var inIdArr = inId.split('-');
        var rowId = inIdArr[1];

        var valueA = parseFloat($("#start_year_area-" + rowId).val());
        var valueB = parseFloat($("#add_reqs-" + rowId).val());
        var gettotal = $(this).val();
        var total = parseFloat(valueA) + parseFloat(valueB);

        if (gettotal != total) {
            $('#total-' + rowId).parent().next('.err_cv').text('Total Calculation is not Matched!');
            $('#total-' + rowId).addClass("is-invalid");
            $("#total-" + rowId).click(function () { $("#total-" + rowId).parent().next('.err_cv').hide().text; $("#total-" + rowId).removeClass("is-invalid"); $('#total-' + rowId).val('');});
            showAlrt('Total Calculation is not Matched!');
        } else {
            $('#total-' + rowId).removeClass("is-invalid");
            return true;
            
        }


    });

    $(".tot").on('blur', function () {
        var elementId = $(this).attr('id');
        var _id = elementId.split('-');
        var elementName = _id[1];
        updateSubTotal(elementName, elementId);
    });


});

function updateSubTotal(fieldName,fieldId) {
    var total = 0;

    $("input[name='"+fieldName+"[]']").each(function () {
        var tot = ($(this).val()== '') ? 0 : $(this).val();
        total += parseFloat(tot);
	});
    
	var getTotal = parseFloat($('#' + fieldId).val()); // added parseFloat on 08-08-2022 by Aniket
    getTotal = getTotal.toFixed(2); //added toFixed on 08-08-2022 by Aniket
    total = total.toFixed(2); //added toFixed on 08-08-2022 by Aniket
    // alert(getTotal);
    if (getTotal == total) {
        $('#' + fieldId).removeClass('is-invalid');
        return true;
    } else {
        showAlrt('Total is not validating. Kindly correct before proceeding');
        $('#' + fieldId).val('0');
        $('#' + fieldId).addClass('is-invalid');
    }
}


function total_total_cal() {

    var total = 0;

    $("input[name='total[]']").each(function () {
        var tot = ($(this).val() == '') ? 0 : $(this).val();
        total += parseFloat(tot);
    });

    $('#tot-total-13').val(total.toFixed(2));
}

// Added by Shweta Apale on 06-10-2022 start
 $('#form_id').on('submit', function (e) {
    //To get Url Last segment
    var url = $(location).attr("href");
    var segments = new URL(url).pathname.split('/');
    var last = segments.pop() || segments.pop();

    var applicantuser = $('#applicant').val();
    var savebutton = $('#btnSubmit').val();
	var financial = $('#financial').val();
	
	console.log('hi');
    if (last != 'financialfive' && applicantuser == 'primaryuser' && savebutton != 'Save' && savebutton != 'Save & Next') {
        if (financial == 1) {
			if (confirm('In Financial Assurance chapter, from YEAR 1 to YEAR 5 and Financial Assurance Part 2 are interlinked sections. If any section is updated then next remaining sections i.e YEAR 1 to YEAR 5 and Financial Assurance Part 2 data will automatically get cleared(removed)')) {
			   return true;
			} else {
				return false;
			}
		} else {
			if (confirm('In Financial Assurance chapter, from YEAR 1 to YEAR 5 are interlinked sections. If any section is updated then next remaining sections i.e YEAR 1 to YEAR 5 data will automatically get cleared(removed)')) {
			   return true;
			} else {
				return false;
			}
		}
     }
   
 });
// end

function start_year_area_total_cal() {

    var total = 0;

    $("input[name='start_year_area[]']").each(function () {
        var tot = ($(this).val() == '') ? 0 : $(this).val();
        total += parseFloat(tot);
    });

    $('#tot-start_year_area-13').val(total.toFixed(2));
}

function add_reqs_total_cal() {

    var total = 0;

    $("input[name='add_reqs[]']").each(function () {
        var tot = ($(this).val() == '') ? 0 : $(this).val();
        total += parseFloat(tot);
    });

    $('#tot-add_reqs-13').val(total.toFixed(2));
}