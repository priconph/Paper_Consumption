function GetActiveMonth(request = null, callback = null){
    $.ajax({
        url: "get_active_month",
        method: "get",
        dataType: "json",
        success: function (response){
            let month = response['month'][0];
            if(request == 'with_callback'){
                callback(month);
            }else{
                let date = new Date();
                let options = { month: 'long' };
                let active_month;

                if(month.active_month == 1){
                    active_month = 'Real-Time Month';
                }else{
                    date.setMonth(date.getMonth() - 1); //Subtract 1 from the current month
                    active_month = 'Previous Month';
                }

                let currentMonth = new Intl.DateTimeFormat('en-US', options).format(date);
                $('#ActiveMonth').html(active_month +' ('+ currentMonth +')');
                $('#setActiveMonthBtn').attr('active_month', month.active_month);
            }
        }
    });
}

function GetMonthsFromBeginningBalance(cboElement) {
    $.ajax({
        url: 'get_months_from_beginning_balance_table',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['month'].length > 0) { // true
                result += response['month'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }

            $(cboElement).html(result);
        }
    });
}

function GetMonthsFromMonthlyTarget(cboElement) {
    $.ajax({
        url: 'get_months_from_monthly_target_table',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['month'].length > 0) { // true
                result += response['month'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }

            $(cboElement).html(result);
        }
    });
}

function GetMonthsFromTotalPurchases(cboElement) {
    $.ajax({
        url: 'get_months_from_total_purchases_table',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['month'].length > 0) { // true
                result += response['month'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }

            $(cboElement).html(result);
        }
    });
}

function GetMonthsFromTotalUsedPaper(cboElement) {
    $.ajax({
        url: 'get_months_from_total_used_paper_table',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['month'].length > 0) { // true
                result += response['month'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }

            $(cboElement).html(result);
        }
    });
}

function GetMonthsFromMonthEndBalance(cboElement) {
    $.ajax({
        url: 'get_months_from_month_end_balance_table',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['month'].length > 0) { // true
                result += response['month'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }

            $(cboElement).html(result);
        }
    });
}

function GetMonthsFromTotalUsedPaperPerPaper(cboElement) {
    $.ajax({
        url: 'get_months_from_total_used_per_paper_table',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['month'].length > 0) { // true
                result += response['month'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }

            $(cboElement).html(result);
        }
    });
}

function GetMonthsFromMonthlyUsedPapers(cboElement) {
    $.ajax({
        url: 'get_months_from_monthly_used_paper_table',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            result = '';
            if (response['month'].length > 0) { // true
                result += response['month'];
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }

            $(cboElement).html(result);
        }
    });
}



