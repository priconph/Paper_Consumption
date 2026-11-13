function AddMonthlyTarget() {
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
        url: "add_monthly_target",
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
                $("#idtarget").val("");
                $(".selectPaper").val(0).trigger("change");

                toastr.success('Monthly Target added!');
                dataTableMonthlyTarget.draw();
                // dataTablePapers.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                toastr.warning('Monthly Target already set!');
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

function GetMonthlyTarget(year) {
    $.ajax({
        url: "display_monthly_target",
        method: "get",
        data: {
            year_value: year,
            // month_value : month
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                $('#monthlyTargetTable').hide();
            }
            else {
                toastr.error('Error');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}


function GetMonthlyTargetMonth(month) {
    $.ajax({
        url: "display_monthly_target",
        method: "get",
        data: {
            // year_value : year,
            month_value: month
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let result = response['result'];

            console.log(result);
            if (result == 1) {

                dataTableMonthlyTarget.draw();
                dataTableTotalUsedPaper.draw();
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

// function GetYears(cboElement){
//     let result = '<option value="0" selected disabled> -- Select Fiscal Year -- </option>';
//     $.ajax({
//         url: 'get_year',
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

// function GetMonth(cboElement) {
//     $.ajax({
//         url: 'get_months',
//         method: 'get',
//         dataType: 'json',
//         beforeSend: function () {
//         },
//         success: function (response) {
//             let month = response['month'];
//             let d = new Date();
//             let monthName = month[d.getMonth() - 1];

//             $(cboElement).val(monthName);
//         }
//     });
// }

// function GetMonths(cboElement){
//     let result = '<option value="0" selected disabled> -- Select Month -- </option>';
//     $.ajax({
//         url: 'get_month',
//         method: 'get',
//         dataType: 'json',
//         beforeSend: function(){
//             result = '<option value="0" selected disabled> -- Loading -- </option>';
//             cboElement.html(result);
//         },
//         success: function(response){
//             result = '';
//             if(response['month'].length > 0){ // true
//                 result = '<option value="0" selected disabled> Select Month </option>';
//                 result += '<option value=""> All </option>';

//                 for(let index = 0; index < response['month'].length; index++){
//                     result += '<option value="'+response['month'][index].month+'">'+ response['month'][index].month +'</option>';
//                 }
//             }
//             else{
//                 result = '<option value="0" selected disabled> No record found </option>';
//             }
//             cboElement.html(result);
//         }
//     });
// }

function FilterFiscalYear(year) {
    $.ajax({
        url: "filter_fiscal_by_year",
        method: "get",
        data: {
            // year_value : year,
            year_value: year
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let result = response['fiscalYear'];
            console.log(result);

            // if(result == 1)
            // {

            //    dataTableMonthlyTarget.draw();

            // }

        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}