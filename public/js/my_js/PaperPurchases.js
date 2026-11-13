function AddPaperPurchases() {
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
        url: "add_paper_purchases",
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
                $("#quantityPaperPurchasesId").val("");
                $(".selectPaper").val(0).trigger("change");

                toastr.success('Success!');
                dataTableBeginningBalance.draw();
                dataTablePurchasedPaper.draw();
                dataTableMonthEndBalance.draw();

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

function GetMonthForPaperPurchases() {
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
        url: 'get_ending_bal',
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
        }
    });
}

function GetPaperName(cboElement) {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },
        url: 'get_ending_bal',
        method: 'post',
        dataType: 'json',
        beforeSend: function () {
            // console.log($("#idpaper_name"));
        },
        success: function (response) {
            console.log(response['result']);
        }
    });
}

// function GetYears(cboElement){
//     let result = '<option value="0" selected disabled> -- Select Fiscal Year -- </option>';
//     $.ajax({
//         url: 'get_years',
//         method: 'get',
//         dataType: 'json',
//         beforeSend: function(){
//             result = '<option value="0" selected disabled> -- Loading -- </option>';
//             cboElement.html(result);
//         },
//         success: function(response){
//             // console.log(response['year_only']);

//             result = '';
//             if(response['years'].length > 0){ // true
//                 result = '<option value="0" selected disabled> Select Fiscal Year </option>';
//                 result += '<option value=""> All</option>';
//                 result += response['years'];

//             }
//             else{
//                 result = '<option value="0" selected disabled> No record found </option>';
//             }
//             cboElement.html(result);
//         }
//     });
// }

function GetFiscal() {
    $.ajax({
        url: 'get_fy_for_paper_purchases',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            // console.log(response['result']);

            $("#fiscalYearId").val(response['result']);
        }
    });
}

// function GetPaperPurchasedQuantity() {
//     $.ajax({
//         url: 'get_paper_purchased_quantity',
//         method: 'get',
//         dataType: 'json',
//         data: { paper_purchased_id: $('#paperPurchasedId').val() },
//         beforeSend: function () {

//         },
//         success: function (response) {
//             // paperPurchasedQuantityId
//             console.log(response['result']);
//             // $("#paperPurchasedQuantityId").val(response['result']);
//             // console.log(response['paperId']);
//         }
//     });
// }