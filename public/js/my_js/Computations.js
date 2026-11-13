function GetTotalUsedPerMonth() {
    $.ajax({
        url: 'compute_total_used_paper',
        method: 'get',
        dataType: 'json',
        success: function (response) {

        },
    });
}

function AddPaperPurchasedAndBeginningBal() {
    $.ajax({
        url: 'compute_beginning_bal_with_paper_purchases',
        method: 'get',
        dataType: 'json',
        success: function (response) {

        },
    });
}