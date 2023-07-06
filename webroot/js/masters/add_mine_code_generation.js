
$(document).ready(function() {

});
$("#stateSelect").change(function() {
    var changedValue = $(this).val();
    var dataUrl = $('#get_district_url').val();
    $.ajax({
        url: dataUrl,
        type: "POST",
        data: ({
            state: changedValue
        }),
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function(resp) {
            $('#districtSelect')
                .find('option')
                .remove();
            var mySelect = $('#districtSelect');
            mySelect.append(resp);
        }
    });
});