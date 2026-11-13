function GetUserLevel(cboElement) {
    let result = '<option value="0" selected disabled> -- Select User Level -- </option>';
    $.ajax({
        url: 'get_user_levels',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function (response) {
            result = '';
            if (response['user_level'].length > 0) { // true
                result = '<option value="0" selected disabled> Select User Level </option>';
                for (let index = 0; index < response['user_level'].length; index++) {
                    result += '<option value="' + response['user_level'][index].id + '">' + response['user_level'][index].user_level + '</option>';
                }
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}