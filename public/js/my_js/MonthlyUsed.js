function AddMonthlyUsedPaper() {
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
        url: "add_monthly_used_paper",
        method: "post",
        data: $('#addMonthlyUsedPaperForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddMonthlyUsedIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyUsed").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving Monthly used paper failed!');
                if (response['error']['paper_id'] === undefined) {
                    $("#selPaperId").removeClass('is-invalid');
                    $("#selPaperId").attr('title', '');
                }
                else {
                    $("#selPaperId").addClass('is-invalid');
                    $("#selPaperId").attr('title', response['error']['paper_id']);
                }
                if (response['error']['quantity'] === undefined) {
                    $("#idquantity").removeClass('is-invalid');
                    $("#idquantity").attr('title', '');
                }
                else {
                    $("#idquantity").addClass('is-invalid');
                    $("#idquantity").attr('title', response['error']['quantity']);
                }
                if (response['error']['reason'] === undefined) {
                    $("#idreason").removeClass('is-invalid');
                    $("#idreason").attr('title', '');
                }
                else {
                    $("#idreason").addClass('is-invalid');
                    $("#idreason").attr('title', response['error']['reason']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalMonthlyUsedPaper").modal('hide');
                $("#idquantity").val("");
                $("#idreason").val("");
                $("#paperPurchasedQuantityId").val("");
                $(".selectPaper").val(0).trigger("change");
                $('.checkedNoConsumption').prop('checked', false);
                $('#idquantity').attr('readonly', false);
                $('#idreason').attr('readonly', false);
                toastr.success('Monthly used paper added!');

                dataTableMonthlyUsedPaper.draw();
            }
            else if (response['result'] == 0) {
                toastr.warning('No consumption for the selected paper is already set!');
            }

            $("#btnAddMonthlyUsedIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyUsed").removeAttr('disabled');
            $("#btnAddMonthlyUsedIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('Please set monthly target for the selected paper first!');
            $("#btnAddMonthlyUsedIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyUsed").removeAttr('disabled');
            $("#btnAddMonthlyUsedIcon").addClass('fa fa-check');
        }
    });
}

function GetMonthForTotalUsed() {
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
        url: 'get_total_used_paper',
        method: 'post',
        data: $('#getMonthForm').serialize(),
        dataType: 'json',
        beforeSend: function () {
            $("#btnSyncIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSync").prop('disabled', 'disabled');
        },
        success: function (response) {

            if (response['validation'] == 'hasError') {
                toastr.error('Sync Failed');
            }
            else if (response['result'] == 1) {
                console.log(response['total']);
                toastr.success('Sync Success');
                dataTableTotalUsedPaper.draw();
            }
            else if (response['result'] == 0) {
                toastr.warning('Already synced!');
            }
            $("#btnSyncIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSync").removeAttr('disabled');
            $("#btnSyncIcon").addClass('fa fa-check');
        },
    });
}

function GetPapers(cboElement) {
    // let result = '<option value="0" selected disabled> -- Select Paper -- </option>';
    $.ajax({
        url: 'get_papers_per_dept',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function (response) {
            result = '';
            if (response['paper_names'].length > 0) { // true
                result += response['paper_names'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function AddMonthlyUsedPaperDraft()
{
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
        url: "add_monthly_used_paper_draft",
        method: "post",
        data: $('#addMonthlyUsedPaperForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddMonthlyUsedIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyUsed").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                // console.log('qweqweqw');
                // console.log($('#idreason'));
                toastr.error('Saving Monthly used paper failed!');
                if (response['error']['paper_id'] === undefined) {
                    $("#selPaperId").removeClass('is-invalid');
                    $("#selPaperId").attr('title', '');
                }
                else {
                    $("#selPaperId").addClass('is-invalid');
                    $("#selPaperId").attr('title', response['error']['paper_id']);
                }
                if (response['error']['quantity'] === undefined) {
                    $("#idquantity").removeClass('is-invalid');
                    $("#idquantity").attr('title', '');
                }
                else {
                    $("#idquantity").addClass('is-invalid');
                    $("#idquantity").attr('title', response['error']['quantity']);
                }
                if (response['error']['reason'] === undefined) {
                    $("#idreason").removeClass('is-invalid');
                    $("#idreason").attr('title', '');
                }
                else {
                    $("#idreason").addClass('is-invalid');
                    $("#idreason").attr('title', response['error']['reason']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalMonthlyUsedPaper").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#idquantity").val("");
                $("#idreason").val("");
                $("#paperPurchasedQuantityId").val("");
                $(".selectPaper").val(0).trigger("change");
                $('.checkedNoConsumption').prop('checked', false);
                $('#idquantity').attr('readonly', false);
                $('#idreason').attr('readonly', false);
                toastr.success('Save Success!');

                dataTableMonthlyUsedPaperDraft.draw();
            }

            $("#btnAddMonthlyUsedIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyUsed").removeAttr('disabled');
            $("#btnAddMonthlyUsedIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('Please set monthly target for the selected paper first!');
            $("#btnAddMonthlyUsedIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyUsed").removeAttr('disabled');
            $("#btnAddMonthlyUsedIcon").addClass('fa fa-check');
        }
    });
}

function GetMonthlyUsedDraftByIdToEdit(draftId)
{
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
        url: "get_id_edit_monthly_used_draft",
        method: "get",
        data: {
            draft_id: draftId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let draft = response['drafts'];

            // $('#getMonthId').val(response['month']);
            // console.log(draft[0].month);
            if (draft.length > 0) {
                $("#monthId").val(draft[0].month);
                $("#getMonthId").val(draft[0].month);
                $("#selPaperIdEdit").val(draft[0].paper_id).change();
                $("#quantityId").val(draft[0].paper_quantity);
                $("#reasonId").val(draft[0].reason);

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

function EditMonthlyUsedPaperDraft()
{
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
        url: "edit_monthly_used_paper_draft",
        method: "post",
        data: $('#editMonthlyUsedPaperForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnEditMonthlyUsedDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditMonthlyUsedDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                // console.log('qweqweqw');
                // console.log($('#idreason'));
                toastr.error('Saving Monthly used paper failed!');
                if (response['error']['paper_id_edit'] === undefined) {
                    $("#selPaperIdEdit").removeClass('is-invalid');
                    $("#selPaperIdEdit").attr('title', '');
                }
                else {
                    $("#selPaperIdEdit").addClass('is-invalid');
                    $("#selPaperIdEdit").attr('title', response['error']['paper_id_edit']);
                }
                if (response['error']['quantity_edit'] === undefined) {
                    $("#quantityId").removeClass('is-invalid');
                    $("#quantityId").attr('title', '');
                }
                else {
                    $("#quantityId").addClass('is-invalid');
                    $("#quantityId").attr('title', response['error']['quantity_edit']);
                }
                if (response['error']['reason_edit'] === undefined) {
                    $("#reasonId").removeClass('is-invalid');
                    $("#reasonId").attr('title', '');
                }
                else {
                    $("#reasonId").addClass('is-invalid');
                    $("#reasonId").attr('title', response['error']['reason_edit']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalMonthlyUsedPaperDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#quantityId").val("");
                $("#reasonId").val("");
                $("#paperPurchasedQuantityId").val("");
                $(".selectPaper").val(0).trigger("change");
                $('.checkedNoConsumption').prop('checked', false);
                $('#quantityId').attr('readonly', false);
                $('#reasonId').attr('readonly', false);
                toastr.success('Success!');

                dataTableMonthlyUsedPaperDraft.draw();
            }

            $("#btnEditMonthlyUsedDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditMonthlyUsedDraft").removeAttr('disabled');
            $("#btnEditMonthlyUsedDraftIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            // toastr.error('Please set monthly target for the selected paper first!');
            $("#btnEditMonthlyUsedDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditMonthlyUsedDraft").removeAttr('disabled');
            $("#btnEditMonthlyUsedDraftIcon").addClass('fa fa-check');
        }
    });
}

function DeleteDraft()
{
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
        url: "delete_draft",
        method: "post",
        data: $('#deleteDraftForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnDeleteDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeleteDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableMonthlyUsedPaperDraft.draw();
                $("#modalDeleteDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#deleteDraftForm")[0].reset();
                toastr.success('Draft deleted!');
            }
            $("#btnDeleteDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeleteDraft").removeAttr('disabled');
            $("#btnDeleteDraftIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnDeleteDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeleteDraft").removeAttr('disabled');
            $("#btnDeleteDraftIcon").addClass('fa fa-check');
        }
    });
}