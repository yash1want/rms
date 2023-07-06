$(document).ready(function () {
	var doc_type = $('#doc_type').val();
	
	// if(doc_type=='2' || doc_type =='3')
	// // if( doc_type =='3')
	// {
	// 	$('#periodmofification').closest('div #periodDiv').show();
	// 	$('#mpdate').closest('div #dateDiv').show();
	// 	$('#periodmofification').addClass('cvReq');
	// 	$('#mpdate').addClass('cvReq');
	// }
	// else if(doc_type=='2') 
	// {
	// 	$('#loinumber').closest('div #loiDiv').show();
	// 	$('#loinumber').addClass('cvReq');
	// }
	// else if(doc_type == '1'){ //Added by Shweta Apale on 13-05-2022
	// 	$('#periodmofification').closest('div #periodDiv').hide();
	// 	$('#mpdate').closest('div #dateDiv').show();
	// 	$('#mpdate').addClass('cvReq');
	// }
	// // else if(doc_type == '2' || doc_type == '6' || doc_type == '3'){ //Added by Shweta Apale on 13-05-2022
	// // 	$('#periodmofification').closest('div #periodDiv').show();
	// // 	// $('#mpdate').closest('div #dateDiv').hide();
	// // 	// $('#mpdate').addClass('cvReq');
	// // 	// $('#loinumber').closest('div #loiDiv').hide();
	// // 	// $('#loinumber').addClass('cvReq');
	// // }
	// else
	// {
	// 	$('#periodmofification').closest('div #periodDiv').hide();
	// 	$('#mpdate').closest('div #dateDiv').hide();
	// 	$('#periodmofification').addClass('cvNotReq');
	// 	$('#mpdate').addClass('cvNotReq');
	// 	$('#loinumber').closest('div #loiDiv').show();
	// 	$('#loinumber').addClass('cvNotReq');
	// }

	// if (doc_type == '2') {
	// 	$('#mpdate').closest('div #dateDiv').hide();
	// 	$('#mpdate').addClass('cvNotReq');
	// 	$('#loinumber').closest('div #loiDiv').hide();
	// 	$('#loinumber').addClass('cvNotReq');
	// }
	// else if (doc_type == '6') {
	// 	$('#mpdate').closest('div #dateDiv').hide();
	// 	$('#mpdate').addClass('cvNotReq');
	// 	$('#loinumber').closest('div #loiDiv').hide();
	// 	$('#loinumber').addClass('cvNotReq');
	// }
	// else if (doc_type == '3') {
	// 	$('#mpdate').closest('div #dateDiv').hide();
	// 	$('#mpdate').addClass('cvNotReq');
	// 	$('#loinumber').closest('div #loiDiv').hide();
	// 	$('#loinumber').addClass('cvNotReq');
	// }
	// else if (doc_type == '1') {
	// 	$('#loinumber').closest('div #loiDiv').show();
	// 	$('#mpdate').closest('div #dateDiv').show();
	// 	$('#periodmofification').closest('div #periodDiv').hide();
	// }

	// else {
	// 	$('#periodmofification').closest('div #periodDiv').hide();
	// 	$('#mpdate').closest('div #dateDiv').hide();
	// 	$('#periodmofification').addClass('cvNotReq');
	// 	$('#mpdate').addClass('cvNotReq');
	// 	$('#loinumber').closest('div #loiDiv').show();
	// 	$('#loinumber').addClass('cvNotReq');
	// }

	if (doc_type == '2' || doc_type == '3' || doc_type == '6') {
		$('#mpdate').closest('div #dateDiv').hide();
		$('#mpdate').addClass('cvNotReq');
		$('#loinumber').closest('div #loiDiv').hide();
		$('#loinumber').addClass('cvNotReq');
	}
	else {
		$('#loinumber').closest('div #loiDiv').show();
		$('#mpdate').closest('div #dateDiv').show();
		$('#periodmofification').closest('div #periodDiv').hide();
	}

	/*$('#periodmofification').hide();
	$('#mpdate').hide();*/

	$('#form_id').on('change', '.doc_type', function () {
		var id = $(this).attr('id');
		hideShowFields(id);
	});
	
	/*window.onload = function displayLeaseType() {
		var leasetype = $('#leasetype').val();
		var id = '';
		hideShowFields(id,leasetype);
	}*/
});

function hideShowFields(elementId) {
	//console.log(leasetype);
	var elementVal = $('#' + elementId).val();
	
	//console.log(elementVal);

	// Added by Shweta Apale on 04-06-2022
	if (elementVal == '2' || elementVal == '3' || elementVal == '6') {
		//console.log('hi');
		$('#periodmofification').closest('div #periodDiv').show();
		$('#periodmofification').addClass('cvReq');

		$('#reasonmodification').closest('div #reasonDiv').show();
		$('#reasonmodification').addClass('cvNotReq');

		$('#mpdate').closest('div #dateDiv').hide();
		$('#mpdate').addClass('cvNotReq');

		$('#loinumber').closest('div #loiDiv').hide();
		$('#loinumber').addClass('cvNotReq');
	}

	if (elementVal == '1') {
		
		//console.log('MP select');
		$('#mpdate').closest('div #dateDiv').show();
		$('#mpdate').addClass('cvReq');

		$('#loinumber').closest('div #loiDiv').show();
		$('#loinumber').addClass('cvReq');

		$('#reasonmodification').closest('div #reasonDiv').hide();
		$('#reasonmodification').addClass('cvNotReq');

		$('#periodmofification').closest('div #periodDiv').hide();
		$('#periodmofification').addClass('cvNotReq');

	}

}

// Added on 04-06-2022 by Shweta Apale on loading fetching val of doc type
window.onload = function displayDocType() {
	var elementVal = $('#doc_type').val();
	
	if (elementVal == '2' || elementVal == '3' || elementVal == '6') {
		//console.log(elementVal);
		$('#periodmofification').closest('div #periodDiv').show();
		$('#periodmofification').addClass('cvReq');

		$('#reasonmodification').closest('div #reasonDiv').show();
		$('#reasonmodification').addClass('cvNotReq');

		$('#mpdate').closest('div #dateDiv').hide();
		$('#mpdate').addClass('cvNotReq');

		$('#loinumber').closest('div #loiDiv').hide();
		$('#loinumber').addClass('cvNotReq');
	}

	if (elementVal == '1') {
		
		$('#mpdate').closest('div #dateDiv').show();
		$('#mpdate').addClass('cvReq');

		$('#loinumber').closest('div #loiDiv').show();
		$('#loinumber').addClass('cvReq');

		$('#reasonmodification').closest('div #reasonDiv').hide();
		$('#reasonmodification').addClass('cvNotReq');

		$('#periodmofification').closest('div #periodDiv').hide();
		$('#periodmofification').addClass('cvNotReq');
		
	}
}

// Added  by Shweta Apale on 27-09-2022 
$('#reasonmodification').keyup(function () {
	var characterCount = $(this).val().length,
		current = $('#current'),
		maximum = $('#maximum'),
		theCount = $('#the-count');

	current.text(characterCount);

	if (characterCount < 1500) {
		current.css('color', '#666');
	}
	if (characterCount > 1500 && characterCount < 1600) {
		current.css('color', '#6d5555');
	}
	if (characterCount > 1600 && characterCount < 1700) {
		current.css('color', '#793535');
	}
	if (characterCount > 1700 && characterCount < 1800) {
		current.css('color', '#841c1c');
	}
	if (characterCount > 1800 && characterCount < 1899) {
		current.css('color', '#8f0001');
	}
	if (characterCount >= 1900) {
		maximum.css('color', '#8f0001');
		current.css('color', '#8f0001');
		theCount.css('font-weight', 'bold');
	} else {
		maximum.css('color', '#666');
		theCount.css('font-weight', 'normal');
	}
});