$(document).ready(function(){
		$('#uploadexcel').removeClass('cvOn');
		$('#showuploadmodelhref,#excelmodelclose').on('click',function(){
		$('table').toggle('slow');
		$('input').each(
			function () {
				if ($(this).hasClass('cvOn')) {
				$(this).removeClass('cvOn');
				}else{
				$(this).addClass('cvOn');
				}
				$(this).parent().parent().find('.err_cv:first').text('');
			});
	});	


});