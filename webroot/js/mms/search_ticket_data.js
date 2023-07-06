 
 $(document).ready(function() {
        var table = $('#list').DataTable();

        $('#search-input').keyup(function() {
            table.search($(this).val()).draw();
        });
    });

