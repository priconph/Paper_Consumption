function AddMonthlyUsedPaperFromDraft() {
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
        url: "add_monthly_used_from_drafts",
        method: "post",
        data: $('#editMonthlyUsedPaperForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnSubmitDraftIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmitDraft").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving failed!');
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
                $("#modalMonthlyUsedPaper").modal('hide');
                $("#modalMonthlyUsedPaperDraft").modal('hide');
                $("#quantityId").val("");
                $("#reasonId").val("");
                $("#paperPurchasedQuantityId").val("");
                $(".selectPaper").val(0).trigger("change");
                $('.checkedNoConsumption').prop('checked', false);
                $('#idquantity').attr('readonly', false);
                $('#reasonId').attr('readonly', false);
                toastr.success('Monthly used paper added!');

                dataTableMonthlyUsedPaperDraft.draw();
                dataTableMonthlyUsedPaper.draw();
            }
            else if (response['result'] == 0) {
                toastr.warning('No consumption for the selected paper is already set!');
            }

            $("#btnSubmitDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitDraft").removeAttr('disabled');
            $("#btnSubmitDraftIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('Please set monthly target for the selected paper first!');
            $("#btnSubmitDraftIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmitDraft").removeAttr('disabled');
            $("#btnSubmitDraftIcon").addClass('fa fa-check');
        }
    });
}