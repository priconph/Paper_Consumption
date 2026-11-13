<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('index');
})->name('login');

// Admin Views
Route::get('/summary', function () {
    return view('summary');
})->name('summary');

Route::get('/management', function () {
    return view('management');
})->name('management');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/user_dashboard', function () {
    return view('user_dashboard');
})->name('user_dashboard');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


Route::get('/monthly_target', function () {
    return view('monthly_target');
})->name('monthly_target');

Route::get('/total_paper_purchases', function () {
    return view('total_paper_purchases');
})->name('total_paper_purchases');
// Admin Views End

// User Views
Route::get('/paper_consumption_report', function () {
    return view('paper_consumption_report');
})->name('paper_consumption_report');

Route::get('/paper_consumption_report_monthly', function () {
    return view('paper_consumption_report_monthly');
})->name('paper_consumption_report_monthly');
// User Views End

// Automated computation
Route::get('/auto_mailer', function () {
    return view('auto_mailer');
})->name('auto_mailer');

//  Paper Controller
Route::get('get_id_edit', 'PaperController@get_id_edit');
Route::get('/view_papers', 'PaperController@view_papers');
Route::get('/get_papers', 'PaperController@get_papers');
Route::get('/get_papers_for_filter', 'PaperController@get_papers_for_filter');
Route::post('/add_papers', 'PaperController@add_papers');
Route::post('/deactivate_papers', 'PaperController@deactivate_papers');
Route::post('/activate_papers', 'PaperController@activate_papers');
Route::post('/edit_paper', 'PaperController@edit_paper');

// Department Controller
Route::get('/get_department', 'DepartmentController@get_department');
Route::get('/get_id_edit_department', 'DepartmentController@get_id_edit_department');
Route::get('/view_departments', 'DepartmentController@view_departments');
Route::post('/add_department', 'DepartmentController@add_department');
Route::post('/deactivate_department', 'DepartmentController@deactivate_department');
Route::post('/activate_department', 'DepartmentController@activate_department');
Route::post('/edit_department', 'DepartmentController@edit_department');

// User Controller
Route::post('/add_user', 'UserController@add_user');
Route::post('/deactivate_user', 'UserController@deactivate_user');
Route::post('/activate_user', 'UserController@activate_user');
Route::post('edit_user', 'UserController@edit_user');
Route::get('get_user_levels', 'UserController@get_user_levels');
Route::get('/view_users', 'UserController@view_users');
Route::get('/get_id_edit_user', 'UserController@get_id_edit_user');
Route::get('/get_active_month', 'UserController@get_active_month');
Route::post('change_active_month', 'UserController@change_active_month');

// Deduction Controller
Route::get('/view_deductions', 'DeductionController@view_deductions');
Route::get('/get_id_deduction', 'DeductionController@get_id_deduction');
Route::post('/add_deduction', 'DeductionController@add_deduction');
Route::post('/edit_deduction', 'DeductionController@edit_deduction');
Route::get('/deduction_summary', 'DeductionController@deduction_summary');


// Monthly Target Controller
Route::post('/add_monthly_target', 'MonthlyTargetController@add_monthly_target');
Route::get('/filter_fiscal_by_year', 'MonthlyTargetController@filter_fiscal_by_year');
Route::get('/display_monthly_target', 'MonthlyTargetController@display_monthly_target');
Route::get('/get_year', 'MonthlyTargetController@get_year');

// Month Controller
Route::get('/get_month', 'MonthController@get_month');
Route::get('/get_months', 'MonthController@get_months');
Route::get('/get_months_from_beginning_balance_table', 'MonthController@get_months_from_beginning_balance_table');
Route::get('/get_months_from_monthly_target_table', 'MonthController@get_months_from_monthly_target_table');
Route::get('/get_months_from_total_purchases_table', 'MonthController@get_months_from_total_purchases_table');
Route::get('/get_months_from_total_used_paper_table', 'MonthController@get_months_from_total_used_paper_table');
Route::get('/get_months_from_month_end_balance_table', 'MonthController@get_months_from_month_end_balance_table');
Route::get('/get_months_from_total_used_per_paper_table', 'MonthController@get_months_from_total_used_per_paper_table');
Route::get('/get_months_from_monthly_used_paper_table', 'MonthController@get_months_from_monthly_used_paper_table');

// Monthly Used Paper Controller
Route::post('/add_monthly_used_paper', 'MonthlyUsedPaperController@add_monthly_used_paper');
Route::post('/add_monthly_used_paper_draft', 'MonthlyUsedPaperController@add_monthly_used_paper_draft');
Route::post('edit_monthly_used_paper_draft', 'MonthlyUsedPaperController@edit_monthly_used_paper_draft');
Route::get('/display_monthly_used_paper', 'MonthlyUsedPaperController@display_monthly_used_paper');
Route::get('/display_total_used_paper', 'MonthlyUsedPaperController@display_total_used_paper');
Route::get('/get_papers_per_dept', 'MonthlyUsedPaperController@get_papers_per_dept');
Route::get('/get_total_used_paper', 'MonthlyUsedPaperController@get_total_used_paper');
Route::get('/display_paper_consumption_reasons', 'MonthlyUsedPaperController@display_paper_consumption_reasons');
Route::get('/display_total_used_per_paper', 'MonthlyUsedPaperController@display_total_used_per_paper');
Route::get('/display_monthly_used_paper_draft', 'MonthlyUsedPaperController@display_monthly_used_paper_draft');
Route::get('/get_id_edit_monthly_used_draft', 'MonthlyUsedPaperController@get_id_edit_monthly_used_draft');
Route::post('/delete_draft', 'MonthlyUsedPaperController@delete_draft');

// Paper Purchases Controller
Route::post('/add_paper_purchases', 'PaperPurchasesController@add_paper_purchases');
Route::get('/display_paper_purchases', 'PaperPurchasesController@display_paper_purchases');
Route::get('/get_year1', 'PaperPurchasesController@get_year1');
Route::get('/get_fy_for_paper_purchases', 'PaperPurchasesController@get_fy_for_paper_purchases');
Route::get('/get_paper_purchased_quantity', 'PaperPurchasesController@get_paper_purchased_quantity');

// Total Consumption Controller
Route::get('/display_total_consumption', 'TotalConsumptionController@display_total_consumption');
Route::get('/generate_total_consumption', 'TotalConsumptionController@generate_total_consumption');

// Total Used Papers Controller
Route::get('/compute_total_used_paper', 'TotalUsedPaperController@compute_total_used_paper');

// Month Ending Balance Controller
Route::get('/get_ending_bal', 'MonthEndingBalanceController@get_ending_bal');
Route::get('/display_month_end_balance', 'MonthEndingBalanceController@display_month_end_balance');

// Beginning Balance controller
Route::get('/compute_beginning_bal_with_paper_purchases', 'BeginningBalanceController@compute_beginning_bal_with_paper_purchases');
Route::get('/display_beginning_bal', 'BeginningBalanceController@display_beginning_bal');
Route::get('/get_beginning_balance_quantity', 'BeginningBalanceController@get_beginning_balance_quantity');
Route::post('/add_beginning_balance_quantity', 'BeginningBalanceController@add_beginning_balance_quantity');

// Fiscal Year Controller
Route::post('/set_fiscal_year', 'FiscalYearController@set_fiscal_year');
Route::post('/update_fiscal_year', 'FiscalYearController@update_fiscal_year');
Route::get('/get_fiscal_year', 'FiscalYearController@get_fiscal_year');
Route::get('/get_all_fy', 'FiscalYearController@get_all_fy');

// CONSUMPTION SUMMARY CONTROLLER
Route::get('/get_total_consumption_per_dept', 'ConsumptionSummaryController@get_total_consumption_per_dept');
Route::get('/get_current_fy', 'ConsumptionSummaryController@get_current_fy');
Route::get('/get_bod_consumption', 'ConsumptionSummaryController@get_bod_consumption');
Route::get('/get_ias_consumption', 'ConsumptionSummaryController@get_ias_consumption');
Route::get('/get_fin_consumption', 'ConsumptionSummaryController@get_fin_consumption');
Route::get('/get_hrd_consumption', 'ConsumptionSummaryController@get_hrd_consumption');
Route::get('/get_ess_consumption', 'ConsumptionSummaryController@get_ess_consumption');
Route::get('/get_log_consumption', 'ConsumptionSummaryController@get_log_consumption');
Route::get('/get_fac_consumption', 'ConsumptionSummaryController@get_fac_consumption');
Route::get('/get_iss_consumption', 'ConsumptionSummaryController@get_iss_consumption');
Route::get('/get_qad_consumption', 'ConsumptionSummaryController@get_qad_consumption');
Route::get('/get_ems_consumption', 'ConsumptionSummaryController@get_ems_consumption');
Route::get('/get_dept_consumption', 'ConsumptionSummaryController@get_dept_consumption');
Route::get('/get_dept_target', 'ConsumptionSummaryController@get_dept_target');

// FISCAL YEAR TARGET PER DEPARTMENT CONTROLLER
Route::get('/get_all_target_papers', 'FiscalYearTargetPerDepartment@get_all_target_papers');
Route::get('/get_fy_for_overall_target', 'FiscalYearTargetPerDepartment@get_fy_for_overall_target');

// MONTHLY TARGET OF ALL DEPARTMENT CONTROLLER (FOR ADMIN VIEW)
Route::get('/get_monthly_target_all_dept', 'MonthlyTargetAllDepartmentController@get_monthly_target_all_dept');

// ACTUAL CONSUMPTION CONTROLLER
Route::get('/get_actual_consumption', 'ActualConsumptionController@get_actual_consumption');
Route::get('/subtract_actual_consumption', 'ActualConsumptionController@subtract_actual_consumption');

// QUARTERLY CONSUMPTION CONTROLLER
Route::get('/get_quarterly_consumption', 'QuarterlyConsumptionController@get_quarterly_consumption');

// MAIL CONTROLLER
Route::get('/send_mail', 'MailController@send_mail');

// PAPER CONSUMPTION REASONS CONTROLLER
Route::get('/get_paper_consumption_reasons', 'PaperConsumptionReasonsController@get_paper_consumption_reasons');

// ADD MONTHLY USED PAPER FROM DRAFTS CONTROLLER
Route::post('/add_monthly_used_from_drafts', 'AddMonthlyUsedPaperFromDraftsController@add_monthly_used_from_drafts');

// ADD DRAFTS FOR MONTHLY TARGET, BEGINNING BALANCE, PAPER PURCHASES CONTROLLER
Route::get('/display_drafts', 'AddDraftsController@display_drafts');
// MONTHLY TARGET DRAFTS //
Route::get('/get_id_edit_monthly_target_draft', 'AddDraftsController@get_id_edit_monthly_target_draft');
Route::post('/add_monthly_target_draft', 'AddDraftsController@add_monthly_target_draft');
Route::post('/edit_monthly_target_draft', 'AddDraftsController@edit_monthly_target_draft');
Route::post('/submit_monthly_target_draft', 'AddDraftsController@submit_monthly_target_draft');
Route::post('/delete_monthly_target_draft', 'AddDraftsController@delete_monthly_target_draft');
// PAPER PURCHASES DRAFTS //
Route::get('/get_id_edit_paper_purchased_draft', 'AddDraftsController@get_id_edit_paper_purchased_draft');
Route::post('/add_paper_purchases_draft', 'AddDraftsController@add_paper_purchases_draft');
Route::post('/edit_paper_purchases_draft', 'AddDraftsController@edit_paper_purchases_draft');
Route::post('/submit_paper_purchases_draft', 'AddDraftsController@submit_paper_purchases_draft');
Route::post('/delete_paper_purchases_draft', 'AddDraftsController@delete_paper_purchases_draft');
// BEGINNING BALANCE DRAFTS //
Route::post('/add_beginning_balance_draft', 'AddDraftsController@add_beginning_balance_draft');
Route::get('/get_id_edit_beginning_balance_draft', 'AddDraftsController@get_id_edit_beginning_balance_draft');
Route::post('/edit_beginning_balance_draft', 'AddDraftsController@edit_beginning_balance_draft');
Route::post('/submit_beginning_balance_draft', 'AddDraftsController@submit_beginning_balance_draft');
Route::post('/delete_beginning_balance_draft', 'AddDraftsController@delete_beginning_balance_draft');

// Sign in and Sign out
Route::post('/sign_in', 'UserController@sign_in')->name('sign_in');
Route::post('/sign_out', 'UserController@sign_out')->name('sign_out');

// Prevent back after logout and login
Route::group(['middleware' => 'prevent-back-history'], function () {
    Auth::routes();

    // Admin Views
    Route::get('/data_settings', function () {
        return view('data_settings');
    })->name('data_settings');
    // Admin Views End

    Route::get('/management', function () {
        return view('management');
    })->name('management');
    // Admin Views End

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Views
    Route::get('/paper_consumption_report', function () {
        return view('paper_consumption_report');
    })->name('paper_consumption_report');

    Route::get('/paper_consumption_report_monthly', function () {
        return view('paper_consumption_report_monthly');
    })->name('paper_consumption_report_monthly');
    // User Views End

    Route::get('/', function () {
        return view('index');
    })->name('login');

    Route::get('/summary', function () {
        return view('summary');
    })->name('summary');

    Route::get('/monthly_target', function () {
        return view('monthly_target');
    })->name('monthly_target');

    Route::get('/total_paper_purchases', function () {
        return view('total_paper_purchases');
    })->name('total_paper_purchases');
});
