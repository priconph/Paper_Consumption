function AddMonthlyTargetDraft()
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
        url: "add_monthly_target_draft",
        method: "post",
        data: $('#addMonthlyTargetForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddMonthlyTargetIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyTarget").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                if (response['error']['paper_id'] === undefined) {
                    $("#selPaperId").removeClass('is-invalid');
                    $("#selPaperId").attr('title', '');
                }
                else {
                    $("#selPaperId").addClass('is-invalid');
                    $("#selPaperId").attr('title', response['error']['paper_id']);
                }
                if (response['error']['monthly_target'] === undefined) {
                    $("#idtarget").removeClass('is-invalid');
                    $("#idtarget").attr('title', '');
                }
                else {
                    $("#idtarget").addClass('is-invalid');
                    $("#idtarget").attr('title', response['error']['monthly_target']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalMonthlyTarget").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#idtarget").val("");
                $(".selectPaper").val(0).trigger("change");

                toastr.success('Save Success!');
                dataTableDrafts.draw();
                // dataTablePapers.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                // toastr.warning('Monthly Target already set!');
            }

            $("#btnAddMonthlyTargetIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyTarget").removeAttr('disabled');
            $("#btnAddMonthlyTargetIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddMonthlyTargetIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddMonthlyTarget").removeAttr('disabled');
            $("#btnAddMonthlyTargetIcon").addClass('fa fa-check');
        }
    });
}

function GetMonthlyTargetDraftByIdToEdit(draftId)
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
        url: "get_id_edit_monthly_target_draft",
        method: "get",
        data: {
            draft_id: draftId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let draft = response['drafts'];

          
            if (draft.length > 0) {
                $("#monthMonthlyTargetId").val(draft[0].month);
                $("#selPaperEditId").val(draft[0].paper_id).change();
                $("#monthlyTargetId").val(draft[0].paper_quantity);
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

function EditMonthlyTargetPaperDraft()
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
        url: "edit_monthly_target_draft",
        method: "post",
        data: $('#editMonthlyTargetDraftForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnEditMonthlyTargetDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditMonthlyTargetDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                // console.log('qweqweqw');
                // console.log($('#idreason'));
                toastr.error('Saving Monthly used paper failed!');
                if (response['error']['paper_id_edit'] === undefined) {
                    $("#selPaperEditId").removeClass('is-invalid');
                    $("#selPaperEditId").attr('title', '');
                }
                else {
                    $("#selPaperEditId").addClass('is-invalid');
                    $("#selPaperEditId").attr('title', response['error']['paper_id_edit']);
                }
                if (response['error']['monthly_target_edit'] === undefined) {
                    $("#monthlyTargetId").removeClass('is-invalid');
                    $("#monthlyTargetId").attr('title', '');
                }
                else {
                    $("#monthlyTargetId").addClass('is-invalid');
                    $("#monthlyTargetId").attr('title', response['error']['monthly_target_edit']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalMonthlyTargetDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#monthlyTargetId").val("");
                $(".selectPaper").val(0).trigger("change");
                toastr.success('Success!');

                dataTableDrafts.draw();
            }

            $("#btnEditMonthlyTargetDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditMonthlyTargetDraft").removeAttr('disabled');
            $("#btnEditMonthlyTargetDraftIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            // toastr.error('Please set monthly target for the selected paper first!');
            $("#btnEditMonthlyTargetDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditMonthlyTargetDraft").removeAttr('disabled');
            $("#btnEditMonthlyTargetDraftIcon").addClass('fa fa-check');
        }
    });
}

function SubmitMonthlyTargetPaperDraft()
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
        url: "submit_monthly_target_draft",
        method: "post",
        data: $('#editMonthlyTargetDraftForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnSubmitMonthlyTargetDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitMonthlyTargetDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                if (response['error']['paper_id_edit'] === undefined) {
                    $("#selPaperEditId").removeClass('is-invalid');
                    $("#selPaperEditId").attr('title', '');
                }
                else {
                    $("#selPaperEditId").addClass('is-invalid');
                    $("#selPaperEditId").attr('title', response['error']['paper_id_edit']);
                }
                if (response['error']['monthly_target_edit'] === undefined) {
                    $("#monthlyTargetId").removeClass('is-invalid');
                    $("#monthlyTargetId").attr('title', '');
                }
                else {
                    $("#monthlyTargetId").addClass('is-invalid');
                    $("#monthlyTargetId").attr('title', response['error']['monthly_target_edit']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalMonthlyTargetDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#monthlyTargetId").val("");
                $(".selectPaper").val(0).trigger("change");

                toastr.success('Save Success!');
                dataTableDrafts.draw();
                dataTableMonthlyTarget.draw();
                // dataTablePapers.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                $('#selPaperEditId').prop('disabled', true);
                toastr.warning('Monthly Target already set!');
            }

            $("#btnSubmitMonthlyTargetDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitMonthlyTargetDraft").removeAttr('disabled');
            $("#btnSubmitMonthlyTargetDraftIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnSubmitMonthlyTargetDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitMonthlyTargetDraft").removeAttr('disabled');
            $("#btnSubmitMonthlyTargetDraftIcon").addClass('fa fa-check');
        }
    });
}

function DeleteMonthlyTargetDraft()
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
        url: "delete_monthly_target_draft",
        method: "post",
        data: $('#deleteMonthlyTargetDraftForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnDeleteDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeleteDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableDrafts.draw();
                $("#modalDeleteMonthlyTargetDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#deleteMonthlyTargetDraftForm")[0].reset();
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

function AddPaperPurchasesDraft()
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
        url: "add_paper_purchases_draft",
        method: "post",
        data: $('#addPaperPurchasesForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddPaperPurchasesIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddPaperPurchases").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                if (response['error']['paper_id'] === undefined) {
                    $("#selPaperPurchasesId").removeClass('is-invalid');
                    $("#selPaperPurchasesId").attr('title', '');
                }
                else {
                    $("#selPaperPurchasesId").addClass('is-invalid');
                    $("#selPaperPurchasesId").attr('title', response['error']['paper_id']);
                }
                if (response['error']['paper_purchase_quantity'] === undefined) {
                    $("#quantityPaperPurchasesId").removeClass('is-invalid');
                    $("#quantityPaperPurchasesId").attr('title', '');
                }
                else {
                    $("#quantityPaperPurchasesId").addClass('is-invalid');
                    $("#quantityPaperPurchasesId").attr('title', response['error']['paper_purchase_quantity']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalPaperPurchases").modal('hide');
                $("#modalViewDrafts").modal('show');

                $("#quantityPaperPurchasesId").val("");
                $(".selectPaper").val(0).trigger("change");

                toastr.success('Success!');

                dataTableDrafts.draw();


            }
            else if (response['result'] == 0) {
                toastr.warning('Duplicate record');
            }

            $("#btnAddPaperPurchasesIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddPaperPurchases").removeAttr('disabled');
            $("#btnAddPaperPurchasesIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddPaperPurchasesIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddPaperPurchases").removeAttr('disabled');
            $("#btnAddPaperPurchasesIcon").addClass('fa fa-check');
        }
    });
}

function GetPaperPurchasesDraftByIdToEdit(draftId)
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
        url: "get_id_edit_paper_purchased_draft",
        method: "get",
        data: {
            draft_id: draftId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let draft = response['drafts'];

            if (draft.length > 0) {
                $("#monthId").val(draft[0].month);
                $("#selPaperPurchasesEditId").val(draft[0].paper_id).change();
                $("#quantityPaperPurchasesEditId").val(draft[0].paper_quantity);
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


function EditPaperPurchasesDraft()
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
        url: "edit_paper_purchases_draft",
        method: "post",
        data: $('#editPaperPurchasesDraftForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnEditPaperPurchasesDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditPaperPurchasesDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                // console.log('qweqweqw');
                // console.log($('#idreason'));
                toastr.error('Saving failed!');
                if (response['error']['paper_id_edit'] === undefined) {
                    $("#selPaperEditId").removeClass('is-invalid');
                    $("#selPaperEditId").attr('title', '');
                }
                else {
                    $("#selPaperEditId").addClass('is-invalid');
                    $("#selPaperEditId").attr('title', response['error']['paper_id_edit']);
                }
                if (response['error']['monthly_target_edit'] === undefined) {
                    $("#monthlyTargetId").removeClass('is-invalid');
                    $("#monthlyTargetId").attr('title', '');
                }
                else {
                    $("#monthlyTargetId").addClass('is-invalid');
                    $("#monthlyTargetId").attr('title', response['error']['monthly_target_edit']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalPaperPurchasesDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#quantityPaperPurchasesEditId").val("");
                $(".selectPaper").val(0).trigger("change");
                toastr.success('Success!');

                dataTableDrafts.draw();
            }

            $("#btnEditPaperPurchasesDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditPaperPurchasesDraft").removeAttr('disabled');
            $("#btnEditPaperPurchasesDraftIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            // toastr.error('Please set monthly target for the selected paper first!');
            $("#btnEditPaperPurchasesDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditPaperPurchasesDraft").removeAttr('disabled');
            $("#btnEditPaperPurchasesDraftIcon").addClass('fa fa-check');
        }
    });
}

function SubmitPaperPurchasesDraft()
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
        url: "submit_paper_purchases_draft",
        method: "post",
        data: $('#editPaperPurchasesDraftForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnSubmitPaperPurchasesIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitPaperPurchases").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                // console.log('qweqweqw');
                // console.log($('#idreason'));
                toastr.error('Saving failed!');
                if (response['error']['paper_id_edit'] === undefined) {
                    $("#selPaperEditId").removeClass('is-invalid');
                    $("#selPaperEditId").attr('title', '');
                }
                else {
                    $("#selPaperEditId").addClass('is-invalid');
                    $("#selPaperEditId").attr('title', response['error']['paper_id_edit']);
                }
                if (response['error']['monthly_target_edit'] === undefined) {
                    $("#monthlyTargetId").removeClass('is-invalid');
                    $("#monthlyTargetId").attr('title', '');
                }
                else {
                    $("#monthlyTargetId").addClass('is-invalid');
                    $("#monthlyTargetId").attr('title', response['error']['monthly_target_edit']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalPaperPurchasesDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#quantityPaperPurchasesEditId").val("");
                $(".selectPaper").val(0).trigger("change");
                toastr.success('Success!');

                dataTableDrafts.draw();
                dataTablePurchasedPaper.draw();
                dataTableMonthEndBalance.draw();
                dataTableBeginningBalance.draw();

            }

            $("#btnSubmitPaperPurchasesIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitPaperPurchases").removeAttr('disabled');
            $("#btnSubmitPaperPurchasesIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            // toastr.error('Please set monthly target for the selected paper first!');
            $("#btnSubmitPaperPurchasesIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitPaperPurchases").removeAttr('disabled');
            $("#btnSubmitPaperPurchasesIcon").addClass('fa fa-check');
        }
    });
}

function DeletePaperPurchasesDraft()
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
        url: "delete_paper_purchases_draft",
        method: "post",
        data: $('#deletePaperPurchasesDraftForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnDeleteDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeleteDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableDrafts.draw();
                $("#modalDeletePaperPurchasesDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#deletePaperPurchasesDraftForm")[0].reset();
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

function AddBeginningBalanceDraft()
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
        url: "add_beginning_balance_draft",
        method: "post",
        data: $('#addBeginningBalanceForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddBeginningBalanceIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddBeginningBalanceDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving failed!');
                if (response['error']['paper_id'] === undefined) {
                    $("#selPaperBeginningBalanceId").removeClass('is-invalid');
                    $("#selPaperBeginningBalanceId").attr('title', '');
                }
                else {
                    $("#selPaperBeginningBalanceId").addClass('is-invalid');
                    $("#selPaperBeginningBalanceId").attr('title', response['error']['paper_id']);
                }
                if (response['error']['beginning_balance'] === undefined) {
                    $("#beginningBalanceQuantityId").removeClass('is-invalid');
                    $("#beginningBalanceQuantityId").attr('title', '');
                }
                else {
                    $("#beginningBalanceQuantityId").addClass('is-invalid');
                    $("#beginningBalanceQuantityId").attr('title', response['error']['beginning_balance']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalBeginningBalance").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#beginningBalanceQuantityId").val("");
                $(".selectPaper").val(0).trigger("change");

                toastr.success('Save Success!');
                dataTableDrafts.draw();
                // dataTablePapers.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                // toastr.warning('Monthly Target already set!');
            }

            $("#btnAddBeginningBalanceIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddBeginningBalanceDraft").removeAttr('disabled');
            $("#btnAddBeginningBalanceIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddBeginningBalanceIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddBeginningBalanceDraft").removeAttr('disabled');
            $("#btnAddBeginningBalanceIcon").addClass('fa fa-check');
        }
    });
}

function GetBeginningBalanceDraftByIdToEdit(draftId)
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
        url: "get_id_edit_beginning_balance_draft",
        method: "get",
        data: {
            draft_id: draftId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let draft = response['drafts'];

            if (draft.length > 0) {
                $("#monthBeginningBalanceId").val(draft[0].month);
                $("#selPaperBeginningBalanceEditId").val(draft[0].paper_id).change();
                $("#beginningBalanceQuantityEditId").val(draft[0].paper_quantity);
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

function EditBeginningBalanceDraft()
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
        url: "edit_beginning_balance_draft",
        method: "post",
        data: $('#editBeginningBalanceForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnEditBeginningBalanceIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditBeginningBalanceDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                // console.log('qweqweqw');
                // console.log($('#idreason'));
                toastr.error('Saving failed!');
                if (response['error']['paper_id_edit'] === undefined) {
                    $("#selPaperBeginningBalanceEditId").removeClass('is-invalid');
                    $("#selPaperBeginningBalanceEditId").attr('title', '');
                }
                else {
                    $("#selPaperBeginningBalanceEditId").addClass('is-invalid');
                    $("#selPaperBeginningBalanceEditId").attr('title', response['error']['paper_id_edit']);
                }
                if (response['error']['beginning_balance_edit'] === undefined) {
                    $("#beginningBalanceQuantityEditId").removeClass('is-invalid');
                    $("#beginningBalanceQuantityEditId").attr('title', '');
                }
                else {
                    $("#beginningBalanceQuantityEditId").addClass('is-invalid');
                    $("#beginningBalanceQuantityEditId").attr('title', response['error']['beginning_balance_edit']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalBeginningBalanceDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#quantityPaperPurchasesEditId").val("");
                $(".selectPaper").val(0).trigger("change");
                toastr.success('Success!');

                dataTableDrafts.draw();
            }

            $("#btnEditBeginningBalanceIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditBeginningBalanceDraft").removeAttr('disabled');
            $("#btnEditBeginningBalanceIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            // toastr.error('Please set monthly target for the selected paper first!');
            $("#btnEditBeginningBalanceIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditBeginningBalanceDraft").removeAttr('disabled');
            $("#btnEditBeginningBalanceIcon").addClass('fa fa-check');
        }
    });
}

function SubmitBeginningBalanceDraft()
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
        url: "submit_beginning_balance_draft",
        method: "post",
        data: $('#editBeginningBalanceForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnEditBeginningBalanceIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditBeginningBalanceDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                // console.log('qweqweqw');
                // console.log($('#idreason'));
                toastr.error('Saving failed!');
                if (response['error']['paper_id_edit'] === undefined) {
                    $("#selPaperBeginningBalanceEditId").removeClass('is-invalid');
                    $("#selPaperBeginningBalanceEditId").attr('title', '');
                }
                else {
                    $("#selPaperBeginningBalanceEditId").addClass('is-invalid');
                    $("#selPaperBeginningBalanceEditId").attr('title', response['error']['paper_id_edit']);
                }
                if (response['error']['beginning_balance_edit'] === undefined) {
                    $("#beginningBalanceQuantityEditId").removeClass('is-invalid');
                    $("#beginningBalanceQuantityEditId").attr('title', '');
                }
                else {
                    $("#beginningBalanceQuantityEditId").addClass('is-invalid');
                    $("#beginningBalanceQuantityEditId").attr('title', response['error']['beginning_balance_edit']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalBeginningBalanceDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#quantityPaperPurchasesEditId").val("");
                $(".selectPaper").val(0).trigger("change");
                toastr.success('Success!');

                dataTableDrafts.draw();
            }

            $("#btnEditBeginningBalanceIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditBeginningBalanceDraft").removeAttr('disabled');
            $("#btnEditBeginningBalanceIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            // toastr.error('Please set monthly target for the selected paper first!');
            $("#btnEditBeginningBalanceIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditBeginningBalanceDraft").removeAttr('disabled');
            $("#btnEditBeginningBalanceIcon").addClass('fa fa-check');
        }
    });
}

function DeleteBeginningBalanceDraft()
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
        url: "delete_beginning_balance_draft",
        method: "post",
        data: $('#deleteBeginningBalanceDraftForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnDeleteDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeleteDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableDrafts.draw();
                dataTableBeginningBalance.draw();

                $("#modalDeleteBeginningBalanceDraft").modal('hide');
                $("#modalViewDrafts").modal('show');
                $("#deleteBeginningBalanceDraftForm")[0].reset();
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