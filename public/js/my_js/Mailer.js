function SendMail() {
    $.ajax({
        url: 'send_mail',
        method: 'get',
        dataType: 'json',
        success: function (response) {

        },
    });
}