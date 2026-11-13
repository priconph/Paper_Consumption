function SetFiscalYear() {
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
        url: "set_fiscal_year",
        method: "post",
        data: $('#setFiscalYearForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnSetFiscalYearIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSetFiscalYear").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving Fiscal Year failed!');
                if (response['error']['fiscal_year'] === undefined) {
                    $("#fiscalYearId").removeClass('is-invalid');
                    $("#fiscalYearId").attr('title', '');
                }
                else {
                    $("#fiscalYearId").addClass('is-invalid');
                    $("#fiscalYearId").attr('title', response['error']['fiscal_year']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalFiscalYear").modal('hide');
                $("#setFiscalYearForm")[0].reset();


                toastr.success('Fiscal Year Set!');
                // dataTablePapers.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                toastr.warning('Fiscal Year already set!');
            }

            $("#btnSetFiscalYearIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSetFiscalYear").removeAttr('disabled');
            $("#btnSetFiscalYearIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnSetFiscalYearIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSetFiscalYear").removeAttr('disabled');
            $("#btnSetFiscalYearIcon").addClass('fa fa-check');
        }
    });
}

function GetFiscalYear() {
    $.ajax({
        url: 'get_fiscal_year',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
        },
        success: function (response) {
            // console.log(response['result']);

            let result = response['result'];
            let addYear = 1;
            // console.log(result[0] + addYear);
            $("#fiscalYearId").val(result);
            $(".nextYear").html(result[0] + addYear);
            $("#nextYearId").val(result[0] + addYear);

            // $("#fiscalYearId").value(result);
        }
    });
}

function UpdateFiscalYear() {
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
        url: "update_fiscal_year",
        method: "post",
        data: $('#updateFiscalYearForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnUpdateFiscalYearIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnUpdateFiscalYear").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving Fiscal Year failed!');
                if (response['error']['next_fiscal_year'] === undefined) {
                    $("#nextYearId").removeClass('is-invalid');
                    $("#nextYearId").attr('title', '');
                }
                else {
                    $("#nextYearId").addClass('is-invalid');
                    $("#nextYearId").attr('title', response['error']['next_fiscal_year']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalUpdateFiscal").modal('hide');
                $("#updateFiscalYearForm")[0].reset();
                $('.modal-backdrop').remove();

                toastr.success('Fiscal Year Set!');
                // dataTablePapers.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                toastr.warning('Fiscal Year already set!');
            }

            $("#btnUpdateFiscalYearIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnUpdateFiscalYear").removeAttr('disabled');
            $("#btnUpdateFiscalYearIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnUpdateFiscalYearIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnUpdateFiscalYear").removeAttr('disabled');
            $("#btnUpdateFiscalYearIcon").addClass('fa fa-check');
        }
    });
}

function GetFiscalYears(cboElement) {
    $.ajax({
        url: 'get_all_fy',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['fy'].length > 0) { // true
                result += response['fy'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }

            $(cboElement).html(result);
        }
    });
}

function GetFiscalYearTarget(cboElement) {
    $.ajax({
        url: 'get_fy_for_overall_target',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['fiscal'].length > 0) { // true
                result += response['fiscal'];
            } else {
                result = '<option value="0" selected disabled> No record found </option>';
            }
            // console.log(result);
            $(cboElement).html(result);
        }
    });
}

