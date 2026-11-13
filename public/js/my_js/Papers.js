function AddPapers() {
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
        url: "add_papers",
        method: "post",
        data: $('#addPaperForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddPaperIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddPaper").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving paper failed!');
                if (response['error']['paper_name'] === undefined) {
                    $("#idpapername").removeClass('is-invalid');
                    $("#idpapername").attr('title', '');
                }
                else {
                    $("#idpapername").addClass('is-invalid');
                    $("#idpapername").attr('title', response['error']['paper_name']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalAddItem").modal('hide');
                $("#addPaperForm")[0].reset();
                toastr.success('Paper added!');
                dataTablePapers.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                toastr.warning('Paper already exists!');
            }

            $("#btnAddPaperIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddPaper").removeAttr('disabled');
            $("#btnAddPaperIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddPaperIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddPaper").removeAttr('disabled');
            $("#btnAddPaperIcon").addClass('fa fa-check');
        }
    });
}

function DeactivatePapers() {
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
        url: "deactivate_papers",
        method: "post",
        data: $('#deactivatePaperForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#deactivateIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeactivatePaper").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTablePapers.draw();
                $("#modalDeactivatePaper").modal('hide');
                $("#deactivatePaperForm")[0].reset();
                toastr.success('Paper successfully deactivated!');
            }
            else {
                toastr.warning('Paper already deactivated!');
            }

            $("#deactivateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivatePaper").removeAttr('disabled');
            $("#deactivateIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#deactivateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivatePaper").removeAttr('disabled');
            $("#deactivateIcon").addClass('fa fa-check');
        }
    });
}

function ActivatePapers() {
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
        url: "activate_papers",
        method: "post",
        data: $('#activatePaperForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#activateIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnActivatePaper").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTablePapers.draw();
                $("#modalActivatePaper").modal('hide');
                $("#activatePaperForm")[0].reset();
                toastr.success('Paper successfully activated!');
            }
            else {
                toastr.warning('Paper already deactivated!');
            }

            $("#activateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivatePaper").removeAttr('disabled');
            $("#activateIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#activateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivatePaper").removeAttr('disabled');
            $("#activateIcon").addClass('fa fa-check');
        }
    });
}

function GetPaperByIdToEdit(paperId) {
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
        url: "get_id_edit",
        method: "get",
        data: {
            paper_id: paperId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let paper = response['paper_name'];
            if (paper.length > 0) {
                $("#idEditpapername").val(paper[0].name);
            }
            else {
                toastr.warning('No Record Found!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function EditPaper() {
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
        url: "edit_paper",
        method: "post",
        data: $('#editPaperForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnEditPaperIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditPaper").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Updating Paper Failed!');

                if (response['error']['paper_name'] === undefined) {
                    $("#idEditpapername").removeClass('is-invalid');
                    $("#idEditpapername").attr('title', '');
                }
                else {
                    $("#idEditpapername").addClass('is-invalid');
                    $("#idEditpapername").attr('title', response['error']['paper_name']);
                }
            }
            else {
                if (response['result'] == 1) {
                    $("#modalEditItem").modal('hide');
                    $("#editPaperForm")[0].reset();
                    dataTablePapers.draw();
                    toastr.success('Paper succesfully updated!');
                }
                else {
                    toastr.warning('Paper already exists!');
                }
            }
            $("#btnEditPaperIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditPaper").removeAttr('disabled');
            $("#btnEditPaperIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnEditPaperIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditPaper").removeAttr('disabled');
            $("#btnEditPaperIcon").addClass('fa fa-check');
        }
    });
}

function GetPaper(cboElement) {
    let result = '<option value="0" selected disabled> -- Select Paper -- </option>';
    $.ajax({
        url: 'get_papers',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function (response) {
            result = '';
            if (response['paper'].length > 0) { // true
                result = '<option value="0" selected disabled> Select Paper </option>';
                for (let index = 0; index < response['paper'].length; index++) {
                    result += '<option value="' + response['paper'][index].id + '">' + response['paper'][index].name + '</option>';
                }
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function GetPapersForFilter(cboElement) {
    let result = '<option value="0" selected disabled> -- Select Paper -- </option>';

    $.ajax({
        url: 'get_papers_for_filter',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function (response) {
            result = '';
            if (response['paper'].length > 0) { // true
                result += '<option value="0" selected disabled> Select Paper </option>';
                result += '<option value=""> All </option>';
                for (let index = 0; index < response['paper'].length; index++) {
                    result += '<option value="' + response['paper'][index].name + '">' + response['paper'][index].name + '</option>';
                }
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

