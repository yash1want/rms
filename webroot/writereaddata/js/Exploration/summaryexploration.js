$(document).ready(function () {

    $('#form_id').on('change', '.covered_area', function () {
        var id = $(this).attr('id');
        checkTotalArea(id);
    });
});

function checkTotalArea(elementId) {
    console.log(elementId);

    var single_id = elementId.split('-');
    var field_val  = $('#'+elementId).val();

    console.log(field_val);

    	// var tot = parseFloat($('#total_area_acqu').val());
    	var leaseArea = parseFloat($('#leaseArea').val());

        // var leaseArea = $('#lease_area').val();
        console.log(leaseArea);


    // 	if (tot > leaseArea) {
    // 		// $("#total_area_acqu").parent().next().text('" Total area aquired in hectares " should not be greater than the "Lease Area (Ha):" from section the "1.Lease Details"');
    // 		showAlrt(' Total area aquired in hectares " should not be greater than the "Lease Area (Ha):" from section the "1.Lease Details');				
    // 		$('#total_area_acqu').val('');

    // 	}
}
