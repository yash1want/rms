
$(document).ready(function() {
    
    $('#table_container_1').ready(function() {

        $('#GeologyPart3').on('submit', function(){
            var returnFormStatus = true;
            var returnEmptyStatus = formEmptyStatus('GeologyPart3');
            returnFormStatus = (returnEmptyStatus == 'invalid') ? false : returnFormStatus;
            var returnSelEmptyStatus = formSelEmptyStatus('GeologyPart3');
            returnFormStatus = (returnSelEmptyStatus == 'invalid') ? false : returnFormStatus;
            return returnFormStatus;
        });

        SecGreatThenFour.fieldVaidation();
        renderCapacityUnit();
        upNilEntry();
        nilEffect();

        // $('#GeologyPart3').on('click', '#add_more', function() {
        //     renderCapacityUnit();
        // });
        
        $('#GeologyPart3').on('change', '.machine_select', function() {
            renderCapacityUnit();
            var mSel = $(this).val();
            if (mSel == 'NIL') {
                nilEffect();
            } else {
                var trRw = $(this).closest('tr').attr('id');
                clearMachinFields(trRw);
            }
        });
        
        $('#GeologyPart3').on('click', '#add_more', function() {
            $('#GeologyPart3').ready(function() {
                upNilEntry();
            });
        });
        
        $('#GeologyPart3').on('click', '.remove_btn_btn', function() {
            $('#GeologyPart3').ready(function() {
                upNilEntry();
            });
        });

    });

});

function renderCapacityUnit() {

    var rw = '#GeologyPart3 #table_1 .table_body tr';
    var rws = $(rw).length;
    for (var i=0; i < rws; i++) {

        var mType = $(rw).eq(i).find('.machine_select').val();
        var mTypeId = $(rw).eq(i).find('.machine_select').attr('id');
        if (mType != '' && mType != 'NIL') {
            var mTypeArr = mType.split('-');
            var mTypeVal = mTypeArr[1];
            var mTypeIdArr = mTypeId.split('-');
            var rwId = mTypeIdArr[2];
            var capUnitLen = $(rw).eq(i).find('.cap_unit').length;
            // if (capUnitLen == 0) {
            //     $(rw).eq(i).find('.capacity_box').parent().parent().append('<div class="cap_unit">'+mTypeVal+'</div>');
            // } else {
            //     $(rw).eq(i).find('.cap_unit').text(mTypeVal);
            // }
            $('#ta-unit_boxx-'+rwId).val(mTypeVal);
        } else {
            var capUnitLen = $(rw).eq(i).find('.cap_unit').length;
            if (capUnitLen > 0) {
                // $(rw).eq(i).find('.cap_unit').text('');
                $('#ta-unit_boxx-'+rwId).val(mTypeVal);
            }
        }

    }

}

function clearMachinFields(rw) {

    var tblB = '#GeologyPart3 #table_1 .table_body';
    var tblRw = tblB+' #'+rw;

    if ($(tblRw).find(".electrical_select option[value='0']").length != 0) {
        $(tblRw).find(".electrical_select option[value='0']").remove();
    }
    
    if ($(tblRw).find(".opencast_select option[value='0']").length != 0) {
        $(tblRw).find(".opencast_select option[value='0']").remove();
    }

    $(tblRw).find('.capacity_box').prop('disabled', false);
    $(tblRw).find('.unit_box').prop('disabled', false);
    $(tblRw).find('.machinery_no').prop('disabled', false);
    $(tblRw).find('.electrical_select').prop('disabled', false);
    $(tblRw).find('.opencast_select').prop('disabled', false);
    
    $(tblRw).find('.capacity_box').val('');
    $(tblRw).find('.unit_box').val('');
    $(tblRw).find('.machinery_no').val('');
    $(tblRw).find('.electrical_select').val('');
    $(tblRw).find('.opencast_select').val('');

	$('#add_more').show();

}

function upNilEntry() {

    var rw = '#GeologyPart3 #table_1 .table_body tr';
    var rws = $(rw).length;
    if (rws == 1) {
        
        if ($(rw).eq(0).find(".machine_select option[value='NIL']").length == 0) {
            $(rw).eq(0).find('.machine_select').append($('<option></option>').attr('value','NIL').text('NIL'));
        }

    } else {
        
        $(rw).find(".machine_select option[value='NIL']").remove();

    }

}

function nilEffect() {

    var rw = '#GeologyPart3 #table_1 .table_body tr';
    var mSelect = $(rw).eq(0).find('.machine_select').val();
    if (mSelect == 'NIL') {

        $(rw).eq(0).find('.capacity_box').val('0.000').prop('disabled', true);
        $(rw).eq(0).find('.unit_box').val('0').prop('disabled', true);
        $(rw).eq(0).find('.machinery_no').val('0').prop('disabled', true);

        if ($(rw).eq(0).find(".electrical_select option[value='0']").length == 0) {
            $(rw).eq(0).find('.electrical_select').append($('<option></option>').attr('value', '0').text('NIL'));
        }
        $(rw).eq(0).find('.electrical_select').val('0').prop('disabled', true);
        
        if ($(rw).eq(0).find(".opencast_select option[value='0']").length == 0) {
            $(rw).eq(0).find('.opencast_select').append($('<option></option>').attr('value', '0').text('NIL'));
        }
        $(rw).eq(0).find('.opencast_select').val('0').prop('disabled', true);

        remNilEffectRw();

    }

}

function remNilEffectRw() {

    var rw = '#GeologyPart3 #table_1 .table_body tr';
	$(rw + ':not(:first-child)').remove();
	$('#add_more').hide();
	$(rw + ':first-child .remove_btn .remove_btn_btn').attr('disabled', true);

}
