
$(document).ready(function(){

    // var data_url = "<?php echo url_for('h1/getMatConsTaxDetails'); ?>";
    // H1MaterialConsumption.fillConTaxData(data_url);

    //============================FORM VALIDATION===============================
    OtherExpenses.fieldValidation();
    OtherExpenses.taxPostValidation();

});

 // below comment button by ganesh satav as per the discuss with ibm person 
//                           added by ganesh satav dated 3 Sep 2014  
//  function printForm()
//  {
//    var container = document.getElementById("part3_taxes");
//    myWindow=window.open('','_blank','location=no, scrollbars=yes');
//    var css_file_path = document.getElementById("css_file_path").value;
//    var image_file_path = document.getElementById("image_file_path").value;
//    var print_data = "<link rel='stylesheet' href=" + css_file_path +"style.css type='text/css'>";
//    print_data += "<img src=" + image_file_path + "mail-header.jpg" + " alt='Header Image' border='0' title='Header Image'>";
//    print_data += container.innerHTML;
//    myWindow.document.write(print_data);
//
//    var text_inp = new Array();
//    var inp = myWindow.document.getElementsByTagName('input');
//
//    for(var i=0; i<inp.length; i++){
//      if(inp[i].type == 'text')
//        text_inp.push(inp[i].id);
//    }
//
//    for(var i=0; i<text_inp.length; i++){
//      var text_box = myWindow.document.getElementById(text_inp[i]);
//      var tb_value = text_box.value;
//                        
//      text_box.parentNode.innerHTML = tb_value;
//    }	
//    myWindow.focus();
//    myWindow.print();
//    myWindow.document.close();
//    return true;
//  }
