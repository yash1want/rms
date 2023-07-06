$(document).ready(function() {

	/*$('#table_id').DataTable();*/
	$('a[id^="delete_action_confirm_"]').on("click",function(){
		if(confirm("Are you sure you want to delete?"))
		{
			return true;
		}else{
			return false;
		}
	
  	});
});

// created by shankhpal shende 02/05/2022 for dropdown year of cxecution date

var mySelect = $('#fromyears');
var currentYear = new Date().getFullYear(); //2022
var startYear = 2009;
for (var i = 0; i <= 10; i++) {
  startYear = startYear + 1;
  currentYear = startYear + 1;
  mySelect.append(
    $('<option></option>').val(startYear + "-" + currentYear).html(startYear + "-" + currentYear)
  );
}
// created by shankhpal shende 02/05/2022 for dropdown year of cxecution date
var mySelect = $('#toyears');
var currentYear = new Date().getFullYear(); //2022
var startYear = 2009;
for (var i = 0; i <= 20; i++) {
  startYear = startYear + 1;
  currentYear = startYear + 1;
  mySelect.append(
    $('<option></option>').val(startYear + "-" + currentYear).html(startYear + "-" + currentYear)
  );
}

function fnById() {
    alert(document.getElementById("myHiddenInputId").value);
}