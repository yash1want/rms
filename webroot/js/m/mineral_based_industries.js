
$(document).ready(function() {

    MineralBasedIndustries.init();

    // $("#plant1").attr('readonly', true);
    $("#plant1").css('background-color', '#D1D0CE');
    // $("#state").attr('readonly', true);
    $("#state").css('background-color', '#D1D0CE');
    // $("#district").attr('readonly', true);
    $("#district").css('background-color', '#D1D0CE');
    // $("#location").attr('readonly', true);
    $("#location").css('background-color', '#D1D0CE');

    $('#industry_name').on('change', function() {
        var indName = $(this).val();
        MineralBasedIndustries.selectindustry(indName);
    });

	var statedata = $('#stateData').val();
	console.log(statedata);
	if(statedata == '0'){
		$('#submit').css('display','none');
	}
});

// function printForm()
// {
//     var container = document.getElementById("mineral_base_ind");
//     myWindow = window.open('', '_blank', 'location=no, scrollbars=yes');
//     var css_file_path = document.getElementById("css_file_path").value;
//     var image_file_path = document.getElementById("image_file_path").value;
//     var print_data = "<link rel='stylesheet' href=" + css_file_path + "style.css type='text/css'>";
//     print_data += "<img src=" + image_file_path + "mail-header.jpg" + " alt='Header Image' border='0' title='Header Image'>";
//     print_data += container.innerHTML;
//     myWindow.document.write(print_data);

//     var text_inp = new Array();
//     var inp = myWindow.document.getElementsByTagName('input');

//     for (var i = 0; i < inp.length; i++) {
//         if (inp[i].type == 'text')
//             text_inp.push(inp[i].id);
//     }

//     for (var i = 0; i < text_inp.length; i++) {

//         var text_box = myWindow.document.getElementById(text_inp[i]);
//         var tb_value = text_box.value;
//         text_box.parentNode.innerHTML = $('#' + text_inp[i]).val();
//     }


//     var select_inp = new Array();
//     var sel = myWindow.document.getElementsByTagName('select');
//     for (var i = 0; i < sel.length; i++) {

//         select_inp.push(sel[i].id);
//     }
//     for (var i = 0; i < select_inp.length; i++) {

//         var select_box = myWindow.document.getElementById(select_inp[i]);

//         var sel_option = $('#' + select_inp[i] + " option:selected").text()
//         if ((sel_option == '-Please Select State-') || (sel_option == '-Plase Select District-'))
//             select_box.parentNode.innerHTML = " ";
//         else
//             select_box.parentNode.innerHTML = sel_option;
//     }

//     myWindow.document.close();
//     myWindow.focus();
//     myWindow.print();

//     return true;
// }
