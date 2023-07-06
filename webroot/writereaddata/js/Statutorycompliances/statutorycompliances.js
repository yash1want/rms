$(window).on('load',function(){
	toggleInputsEC();
	toggleInputsFC();
	$(document).on('change','#applicable',function(){
		toggleInputsEC();
	});
	$(document).on('change','#applicableFC',function(){
		toggleInputsFC();
	});

});

function toggleInputsEC() {
		var applicable = $('#applicable').val();
		var disable = true;
		if(applicable==='yes'){
			 disable = false;
		}
			$('#letterno').prop('disabled',disable).not('.cvReq');
			$('#envdate').prop('disabled',disable).not('.cvReq');
			$('#validity').prop('disabled',disable).not('.cvReq');
			$('#rommaterial').prop('disabled',disable).not('.cvReq');
			$('#rom_mineral_unit').prop('disabled',disable).not('.cvReq');
			$('#letterno1').prop('disabled',disable).not('.cvReq');
			$('#aprrovalof').prop('disabled',disable).not('.cvReq');
			$('#dateSPCB').prop('disabled',disable).not('.cvReq');
			$('#validitySPCB').prop('disabled',disable).not('.cvReq');
			$('#spcb-rom-material').prop('disabled',disable).not('.cvReq');
			$('#spcb_rom_material_unit').prop('disabled',disable).not('.cvReq');
			//$('#rommaterial').prop('disabled',disable);
}
function toggleInputsFC() {
		var applicable = $('#applicableFC').val();
		var disable = true;
		if(applicable==='yes'){
			 disable = false;
		}
			$('#letternoFC').prop('disabled',disable).not('.cvReq');
			$('#envdateFC').prop('disabled',disable).not('.cvReq');
			$('#validityFC').prop('disabled',disable).not('.cvReq');
			$('#rommaterialFC').prop('disabled',disable).not('.cvReq');
			
}

$(document).ready(function () {

	$('#form_id').on('change', '.total_area_acqu', function () {
		var id = $(this).attr('id');
		checkTotalAreaAcqu(id);
	});
});

function checkTotalAreaAcqu(elementId) {
	var tot = parseFloat($('#total_area_acqu').val());
	var leaseArea = parseFloat($('#leaseArea').val());

	if (tot > leaseArea) {
		// $("#total_area_acqu").parent().next().text('" Total area aquired in hectares " should not be greater than the "Lease Area (Ha):" from section the "1.Lease Details"');
		showAlrt(' Total area aquired in hectares " should not be greater than the "Lease Area (Ha):" from section the "1.Lease Details');				
		$('#total_area_acqu').val('');
		
	}
}