$(document).ready(function(){
		
		$('#menus_list_table').DataTable();
		
	});

$('.delete_menu').click(function (e) { 

    if (confirm('Are You Sure Delete This Page record ')) {
        ////
    } else {
        return false;
        exit;
    }
    
});