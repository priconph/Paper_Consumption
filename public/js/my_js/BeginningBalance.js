function AddBeginningBalance() {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "add_beginning_balance_quantity",
        method: "post",
        data: $('#addBeginningBalanceForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddBeginningBalanceIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddBeginningBalance").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                if (response['error']['beginning_balance'] === undefined) {
                    $("#beginningBalanceQuantityId").removeClass('is-invalid');
                    $("#beginningBalanceQuantityId").attr('title', '');
                }
                else {
                    $("#beginningBalanceQuantityId").addClass('is-invalid');
                    $("#beginningBalanceQuantityId").attr('title', response['error']['beginning_balance']);
                }
                if (response['error']['paper_id'] === undefined) {
                    $("#selPaperBeginningBalanceId").removeClass('is-invalid');
                    $("#selPaperBeginningBalanceId").attr('title', '');
                }
                else {
                    $("#selPaperBeginningBalanceId").addClass('is-invalid');
                    $("#selPaperBeginningBalanceId").attr('title', response['error']['paper_id']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalBeginningBalance").modal('hide');
                $("#beginningBalanceQuantityId").val("");
                $(".selectPaper").val(0).trigger("change");

                toastr.success('Beginning Balance added!');
                dataTableBeginningBalance.draw(); // reload the tables after insertion
                dataTableMonthEndBalance.draw()
            }
            else if (response['result'] == 0) {
                toastr.warning('');
            }

            $("#btnAddBeginningBalanceIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddBeginningBalance").removeAttr('disabled');
            $("#btnAddBeginningBalanceIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddBeginningBalanceIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddBeginningBalance").removeAttr('disabled');
            $("#btnAddBeginningBalanceIcon").addClass('fa fa-check');
        }
    });
}