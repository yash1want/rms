
$(document).ready(function() {
    // ProductManufactureDetails.addMore();
    // var data_url = "<?php echo url_for('oSeries/getProductManufDetails'); ?>";
    // ProductManufactureDetails.initMBI(data_url);
    
    ProductManufactureDetails.ProductManufactureDetailsvalidation();
});

// below comment button by ganesh satav as per the discuss with ibm person 
// added by ganesh satav dated 3 Sep 2014
// function printForm()
// {
//     var container = document.getElementById("prod_man_det");
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

//     var textarea_inp = new Array();
//     var ta_inp = myWindow.document.getElementsByTagName('textarea');
//     for (var i = 0; i < ta_inp.length; i++) {
//         textarea_inp.push(ta_inp[i].id);
//     }
//     for (var i = 0; i < textarea_inp.length; i++) {
//         var textarea = myWindow.document.getElementById(textarea_inp[i]);
//         var ta_value = textarea.value;
//         textarea.parentNode.innerHTML = $('#' + textarea_inp[i]).val();
//     }
//     $(myWindow.document).find('.h-add-more-btn').html("");
//     $(myWindow.document).find('.h-close-icon').removeClass('h-close-icon');


//     myWindow.document.close();
//     myWindow.focus();
//     myWindow.print();

//     return true;
// }