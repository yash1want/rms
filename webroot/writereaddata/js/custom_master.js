$(document).ready(function () {
    $('#commoditytable').DataTable();
});


$(document).ready(function () {
    $('#stoppage_sn').change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: 'check-stoppage-sn',
            type: "POST",
            data: ({
                stoppage_sn: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                console.log(resp);
                if (resp == 1) {
                    alert('Stoppage Sn already present.');
                    $('#stoppage_sn').focus();
                    return false;
                }
                else {
                    return true;
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#machinery_code').change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: 'check-machinery-code',
            type: "POST",
            data: ({
                machinery_code: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                console.log(resp);
                if (resp == 1) {
                    alert('Machinery code already present.');
                    $('#machinery_code').focus();
                    return false;
                }
                else {
                    return true;
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#type_concentrate').change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: 'check-type-concentrate',
            type: "POST",
            data: ({
                type_concentrate: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                console.log(resp);
                if (resp == 1) {
                    alert('Concentrate type already present.');
                    $('#type_concentrate').focus();
                    return false;
                }
                else {
                    return true;
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#mineral_name').change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: 'check-extra-mineral',
            type: "POST",
            data: ({
                mineral_name: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                console.log(resp);
                if (resp == 1) {
                    alert('Mineral Name already present.');
                    $('#mineral_name').focus();
                    return false;
                }
                else {
                    return true;
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#metal_name').change(function () {
        var changedValue = $(this).val();
        $.ajax({
            url: 'check-metal',
            type: "POST",
            data: ({
                metal_name: changedValue,
            }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (resp) {
                console.log(resp);
                if (resp == 1) {
                    alert('Metal Name already present.');
                    $('#metal_name').focus();
                    return false;
                }
                else {
                    return true;
                }
            }
        });
    });
});