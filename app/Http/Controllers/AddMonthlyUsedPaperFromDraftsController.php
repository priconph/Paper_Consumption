<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MonthlyUsedPaper;
use App\TotalUsedPaper;
use App\FiscalYear;
use App\MonthEndBal;
use App\BeginningBalance;
use App\MonthlyTarget;
use App\TotalUsedPerPaper;
use App\MonthlyUsedPaperDraft;
use DataTables;

class AddMonthlyUsedPaperFromDraftsController extends Controller
{
    public function add_monthly_used_from_drafts(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;
        $fy = $result[0]->year + 1;

        $GetActiveMonth = DB::connection('mysql')->select("SELECT `active_month` FROM `month_config` WHERE `status` = '0'");
        $date_now = Carbon::now()->format('d');

        if($date_now == 01 || $date_now == 02 || $date_now == 03 || $date_now == 04 || $date_now == 05){
            if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                $monthNow = Carbon::now()->subMonth()->format('F');
                $nextMonth = Carbon::now()->format('F');
            }else{//Previous Month
                $monthNow = Carbon::now()->subMonths(2)->format('F');
                $nextMonth = Carbon::now()->format('F');
            }
        }else{
            if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                $monthNow = Carbon::now()->format('F');
                $nextMonth = Carbon::now()->addMonth()->format('F');
            }else{//Previous Month
                $monthNow = Carbon::now()->subMonth()->format('F');
                $nextMonth = Carbon::now()->format('F');
            }

            // $monthNow = Carbon::now()->format('F');                //uncomment to activate real month
            // $nextMonth = Carbon::now()->addMonth()->format('F');   //uncomment to activate real month
            // $monthNow = Carbon::now()->subMonth()->format('F'); //uncomment to activate previous month
            // $nextMonth = Carbon::now()->format('F');            //uncomment to activate previous month
        }

        $validator = Validator::make($data, [
            'paper_id_edit' => 'required',
            'quantity_edit' => 'required',
            'reason_edit' => 'required'
        ]);

        //===== CHECK MONTH ENDING BALANCE BASED ON PAPER USED =====//
        $check_month_end_balance = MonthEndBal::with('paper')
            ->with('fiscal_year')
            ->where('paper_id', $request->paper_id_edit)
            ->where('month', $monthNow)
            ->where('fiscal_year_id', $fy_id)
            ->where('department_id', $_SESSION['user_department'])
            ->count();
        //===== CHECK MONTH ENDING BALANCE BASED ON PAPER USED END =====//

        //====== CHECK IF TOTAL USED PAPER IS ALREADY SET =====//
        $check_total_used_paper = TotalUsedPaper::with(['paper'])
            ->with(['fiscal_year'])
            ->where('fiscal_year_id', $fy_id)
            ->where('month', $monthNow)
            ->where('department_id', $_SESSION['user_department'])
            ->get();

            // return $check_total_used_paper;
        //====== CHECK IF TOTAL USED PAPER IS ALREADY SET END =====//

        //====== CHECK MONTHLY TARGET FOR INSERT AND UPDATE =====//
        $check_monthly_target = MonthlyTarget::where('month', $monthNow)
            ->where('department_id', $_SESSION['user_department'])
            ->where('fiscal_year_id', $fy_id)
            ->get();

        $sum_monthly_target = MonthlyTarget::where('month', $monthNow)
            ->where('department_id', $_SESSION['user_department'])
            ->where('fiscal_year_id', $fy_id)
            ->sum('data_monthly_target');

        $monthly_target_quantity = $sum_monthly_target;
        $monthly_target = $check_monthly_target[0]->id;
        //====== CHECK MONTHLY TARGET FOR INSERT AND UPDATE END =====//

        //===== CHECK MONTHLY TARGET PER PAPER =====//
        $check_monthly_target_per_paper = MonthlyTarget::where('month', $monthNow)
            ->where('department_id', $_SESSION['user_department'])
            ->where('fiscal_year_id', $fy_id)
            ->where('paper_id', $request->paper_id_edit)
            ->get();

        $monthly_target_per_paper = $check_monthly_target_per_paper[0]->data_monthly_target;
        // $monthly_target_per_paper = collect($check_monthly_target_per_paper)->pluck('data_monthly_target')->flatten(1)->toArray();
        //===== CHECK MONTHLY TARGET PER PAPER END =====//

        $check_if_no_consumption_is_set = MonthlyUsedPaper::where('reason', 'No Consumption')
            ->where('month', $monthNow)
            ->where('fiscal_year_id', $fy_id)
            ->where('department_id', $_SESSION['user_department'])
            ->count();

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        //===== IF MONTH ENDING BALANCE OF USED PAPER IS NOT YET SET (INSERT NEW DATA) =====//
        elseif ($check_month_end_balance == 0) {
            if ($check_if_no_consumption_is_set == 0) {
                //===== INSERT MONTHLY USED PAPER BASED ON PAPER USED =====//
                MonthlyUsedPaper::insert([
                    'paper_id' => $request->paper_id_edit,
                    'data_monthly_used_paper' => $request->quantity_edit,
                    'reason' => $request->reason_edit,
                    'month' => $request->month,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $fy_id
                ]);
                //===== INSERT MONTHLY USED PAPER BASED ON PAPER USED END =====//
            } else {
                return response()->json(['result' => 0]);
            }

            //===== CHECK BEGINNING BALANCE BASED ON PAPER USED =====//
            $check_beginning_balance = BeginningBalance::with(['paper'])
                ->with(['fiscal_year'])
                ->where('paper_id', $request->paper_id_edit)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $monthNow)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== CHECK BEGINNING BALANCE BASED ON PAPER USED END =====//

            //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER USED =====//
            $quantity_from_beginning_balance = $check_beginning_balance[0]->quantity;
            //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER USED END =====//

            //===== SUBTRACT PAPER USED TO THE BEGINNING BALANCE BASED ON PAPER FOR MONTH ENDING BALANCE =====//
            $month_end_balance = $quantity_from_beginning_balance - $request->quantity_edit;
            //===== SUBTRACT PAPER USED TO THE BEGINNING BALANCE BASED ON PAPER FOR MONTH ENDING BALANCE END =====//

            //===== INSERT NEW MONTH ENDING BALANCE BASED ON PAPER =====//
            MonthEndBal::insert([
                'quantity' => $month_end_balance,
                'month' => $request->month,
                'paper_id' => $request->paper_id_edit,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $fy_id
            ]);
            //===== INSERT NEW MONTH ENDING BALANCE BASED ON PAPER =====//

            if ($nextMonth == 'April') {
                if (FiscalYear::where('year', $fy)->exists()) {
                    FiscalYear::where('year', $fy)
                        ->update([
                            'year' => $fy
                        ]);
                } else {
                    FiscalYear::insert([
                        'year' => $fy,
                        'status' => 1
                    ]);
                }

                //===== INSERT BEGINNING BALANCE NEXT MONTH BASED ON PAPER FOR NEXT FY =====//
                BeginningBalance::insert([
                    'quantity' => $month_end_balance,
                    'month' => $nextMonth,
                    'paper_id' => $request->paper_id_edit,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $fy_id + 1
                ]);
                //===== INSERT BEGINNING BALANCE NEXT MONTH BASED ON PAPER FOR NEXT FY END =====//

            } else {
                //===== INSERT BEGINNING BALANCE NEXT MONTH BASED ON PAPER =====//
                BeginningBalance::insert([
                    'quantity' => $month_end_balance,
                    'month' => $nextMonth,
                    'paper_id' => $request->paper_id_edit,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $fy_id
                ]);
                //===== INSERT BEGINNING BALANCE NEXT MONTH BASED ON PAPER END =====//
            }

            //===== IF TOTAL USED PAPER IS NOT YET SET =====//
            if (count($check_total_used_paper) == 0) {
                $total_of_paper_used_this_month = MonthlyUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $total_of_paper_used_per_paper_this_month = MonthlyUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $check_total_used_per_paper = TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->get();

                if (count($check_total_used_per_paper) == 0) {
                    if ($monthly_target_per_paper > $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Under";
                    } elseif ($monthly_target_per_paper < $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Over";
                    } else if ($monthly_target_per_paper == $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "On Target";
                    }
                    TotalUsedPerPaper::insert([
                        'department_id' => $_SESSION['user_department'],
                        'paper_id' => $request->paper_id_edit,
                        'month' => $monthNow,
                        'fiscal_year_id' => $fy_id,
                        'quantity' => $total_of_paper_used_per_paper_this_month,
                        'monthly_target_quantity' => $monthly_target_per_paper,
                        'status' => $status_1
                    ]);
                } else {
                    if ($monthly_target_per_paper > $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Under";
                    } elseif ($monthly_target_per_paper < $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Over";
                    } else if ($monthly_target_per_paper == $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "On Target";
                    }
                    TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                        ->where('paper_id', $request->paper_id)
                        ->where('month', $monthNow)
                        ->where('fiscal_year_id', $fy_id)
                        ->update([
                            'quantity' => $total_of_paper_used_per_paper_this_month,
                            'status' => $status_1
                        ]);
                }

                if ($monthly_target_quantity > $total_of_paper_used_this_month) {
                    $status = "Under";
                } elseif ($monthly_target_quantity < $total_of_paper_used_this_month) {
                    $status = "Over";
                } else if ($monthly_target_quantity == $total_of_paper_used_this_month) {
                    $status = "On Target";
                }
                TotalUsedPaper::insert([
                    'department_id' => $_SESSION['user_department'],
                    'month' => $monthNow,
                    'fiscal_year_id' => $fy_id,
                    'quantity' => $total_of_paper_used_this_month,
                    'monthly_target_id' => $sum_monthly_target,
                    'status' => $status
                ]);
            }
            //===== IF TOTAL USED PAPER IS NOT YET SET END =====//
            //===== IF TOTAL USED PAPER IS ALREADY SET =====//
            else {
                $total_of_paper_used_this_month = MonthlyUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $total_of_paper_used_per_paper_this_month = MonthlyUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $check_total_used_per_paper = TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->get();

                if (count($check_total_used_per_paper) == 0) {
                    if ($monthly_target_per_paper > $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Under";
                    } elseif ($monthly_target_per_paper < $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Over";
                    } else if ($monthly_target_per_paper == $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "On Target";
                    }
                    TotalUsedPerPaper::insert([
                        'department_id' => $_SESSION['user_department'],
                        'paper_id' => $request->paper_id_edit,
                        'month' => $monthNow,
                        'fiscal_year_id' => $fy_id,
                        'quantity' => $total_of_paper_used_per_paper_this_month,
                        'monthly_target_quantity' => $monthly_target_per_paper,
                        'status' => $status_1
                    ]);
                } else {
                    if ($monthly_target_per_paper > $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Under";
                    } elseif ($monthly_target_per_paper < $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Over";
                    } else if ($monthly_target_per_paper == $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "On Target";
                    }
                    TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                        ->where('paper_id', $request->paper_id_edit)
                        ->where('month', $monthNow)
                        ->where('fiscal_year_id', $fy_id)
                        ->update([
                            'quantity' => $total_of_paper_used_per_paper_this_month,
                            'status' => $status_1
                        ]);
                }

                if ($monthly_target_quantity > $total_of_paper_used_this_month) {
                    $status = "Under";
                } elseif ($monthly_target_quantity < $total_of_paper_used_this_month) {
                    $status = "Over";
                } else if ($monthly_target_quantity == $total_of_paper_used_this_month) {
                    $status = "On Target";
                }
                TotalUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('fiscal_year_id', $fy_id)
                    ->update([
                        'quantity' => $total_of_paper_used_this_month,
                        'status' => $status
                    ]);
            }
            //===== IF TOTAL USED PAPER IS ALREADY SET END =====//

            MonthlyUsedPaperDraft::where('id', $request->draft_id)
                ->update([
                    'status' => 0
                ]);

            DB::commit();
            return response()->json(['result' => 1, 'stat' => $status, 'total_used' => $total_of_paper_used_this_month, 'monthly_target' => $monthly_target_quantity]);
        }
        //===== IF MONTH ENDING BALANCE OF USED PAPER IS NOT YET SET =====//

        //===== IF MONTH ENDING BALANCE OF USED PAPER IS ALREADY SET (UPDATE DATA IF USER ADD MONTHLY USED PAPER) =====//
        elseif ($check_month_end_balance != 0) {
            if ($check_if_no_consumption_is_set == 0) {
                //===== INSERT MONTHLY USED PAPER BASED ON PAPER USED =====//
                MonthlyUsedPaper::insert([
                    'paper_id' => $request->paper_id_edit,
                    'data_monthly_used_paper' => $request->quantity_edit,
                    'reason' => $request->reason_edit,
                    'month' => $request->month,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $fy_id
                ]);
                //===== INSERT MONTHLY USED PAPER BASED ON PAPER USED END =====//
            } else {
                return response()->json(['result' => 0]);
            }

            //===== GET DATA FROM MONTH ENDING BALANCE BASED ON PAPER USED =====//
            $check_month_end_balance = MonthEndBal::with(['paper'])
                ->with(['fiscal_year'])
                ->where('paper_id', $request->paper_id_edit)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $monthNow)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== GET DATA FROM MONTH ENDING BALANCE BASED ON PAPER USED END =====//

            //===== GET MONTH END BALANCE QUANTITY =====//
            $quantity_from_month_end_balance = $check_month_end_balance[0]->quantity;
            //===== GET MONTH END BALANCE QUANTITY END =====//

            //===== SUBTRACT PAPER USED QUANTITY TO MONTH ENDING BALANCE =====//
            $month_end_balance = $quantity_from_month_end_balance - $request->quantity_edit;
            //===== SUBTRACT PAPER USED QUANTITY TO MONTH ENDING BALANCE END =====//

            //===== UPDATE MONTH ENDING BALANCE =====//
            MonthEndBal::where('paper_id', $request->paper_id_edit)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $monthNow)
                ->where('department_id', $_SESSION['user_department'])
                ->update([
                    'quantity' => $month_end_balance,
                ]);
            //===== UPDATE MONTH ENDING BALANCE =====//

            if ($nextMonth == 'April') {
                if (FiscalYear::where('year', $fy)->exists()) {
                    FiscalYear::where('year', $fy)
                        ->update([
                            'year' => $fy
                        ]);
                } else {
                    FiscalYear::insert([
                        'year' => $fy,
                        'status' => 1
                    ]);
                }

                //===== UPDATE BEGINNING BALANCE NEXT MONTH =====//
                BeginningBalance::where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id + 1)
                    ->where('month', $nextMonth)
                    ->where('department_id', $_SESSION['user_department'])
                    ->update([
                        'quantity' => $month_end_balance,
                    ]);
                //===== UPDATE BEGINNING BALANCE NEXT MONTH END =====//

            } else {
                //===== UPDATE BEGINNING BALANCE NEXT MONTH =====//
                BeginningBalance::where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->where('month', $nextMonth)
                    ->where('department_id', $_SESSION['user_department'])
                    ->update([
                        'quantity' => $month_end_balance,
                    ]);
                //===== UPDATE BEGINNING BALANCE NEXT MONTH END =====//
            }

            //===== IF TOTAL USED PAPER IS NOT YET SET =====//
            if (count($check_total_used_paper) == 0) {
                $total_of_paper_used_this_month = MonthlyUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $total_of_paper_used_per_paper_this_month = MonthlyUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $check_total_used_per_paper = TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->get();

                if (count($check_total_used_per_paper) == 0) {
                    if ($monthly_target_per_paper > $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Under";
                    } elseif ($monthly_target_per_paper < $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Over";
                    } else if ($monthly_target_per_paper == $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "On Target";
                    }

                    TotalUsedPerPaper::insert([
                        'department_id' => $_SESSION['user_department'],
                        'paper_id' => $request->paper_id_edit,
                        'month' => $monthNow,
                        'fiscal_year_id' => $fy_id,
                        'quantity' => $total_of_paper_used_per_paper_this_month,
                        'monthly_target_quantity' => $monthly_target_per_paper,
                        'status' => $status_1
                    ]);
                } else {
                    if ($monthly_target_per_paper > $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Under";
                    } elseif ($monthly_target_per_paper < $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Over";
                    } else if ($monthly_target_per_paper == $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "On Target";
                    }
                    TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                        ->where('paper_id', $request->paper_id_edit)
                        ->where('month', $monthNow)
                        ->where('fiscal_year_id', $fy_id)
                        ->update([
                            'quantity' => $total_of_paper_used_per_paper_this_month,
                            'status' => $status_1
                        ]);
                }

                if ($monthly_target_quantity > $total_of_paper_used_this_month) {
                    $status = "Under";
                } elseif ($monthly_target_quantity < $total_of_paper_used_this_month) {
                    $status = "Over";
                } else if ($monthly_target_quantity == $total_of_paper_used_this_month) {
                    $status = "On Target";
                }

                TotalUsedPaper::insert([
                    'department_id' => $_SESSION['user_department'],
                    'month' => $monthNow,
                    'fiscal_year_id' => $fy_id,
                    'quantity' => $total_of_paper_used_this_month,
                    'monthly_target_id' => $sum_monthly_target,
                    'status' => $status
                ]);
            }
            //===== IF TOTAL USED PAPER IS NOT YET SET END =====//
            //===== IF TOTAL USED PAPER IS ALREADY SET =====//
            else {
                $total_of_paper_used_this_month = MonthlyUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $total_of_paper_used_per_paper_this_month = MonthlyUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $check_total_used_per_paper = TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->get();

                if (count($check_total_used_per_paper) == 0) {
                    if ($monthly_target_per_paper > $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Under";
                    } elseif ($monthly_target_per_paper < $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Over";
                    } else if ($monthly_target_per_paper == $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "On Target";
                    }

                    TotalUsedPerPaper::insert([
                        'department_id' => $_SESSION['user_department'],
                        'paper_id' => $request->paper_id_edit,
                        'month' => $monthNow,
                        'fiscal_year_id' => $fy_id,
                        'quantity' => $total_of_paper_used_per_paper_this_month,
                        'monthly_target_quantity' => $monthly_target_per_paper,
                        'status' => $status_1
                    ]);
                } else {
                    if ($monthly_target_per_paper > $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Under";
                    } elseif ($monthly_target_per_paper < $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "Over";
                    } else if ($monthly_target_per_paper == $total_of_paper_used_per_paper_this_month) {
                        $status_1 = "On Target";
                    }
                    TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                        ->where('paper_id', $request->paper_id_edit)
                        ->where('month', $monthNow)
                        ->where('fiscal_year_id', $fy_id)
                        ->update([
                            'quantity' => $total_of_paper_used_per_paper_this_month,
                            'status' => $status_1
                        ]);
                }

                if ($monthly_target_quantity > $total_of_paper_used_this_month) {
                    $status = "Under";
                } elseif ($monthly_target_quantity < $total_of_paper_used_this_month) {
                    $status = "Over";
                } else if ($monthly_target_quantity == $total_of_paper_used_this_month) {
                    $status = "On Target";
                }

                TotalUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('fiscal_year_id', $fy_id)
                    ->where('month', $monthNow)
                    ->update([
                        'quantity' => $total_of_paper_used_this_month,
                        'status' => $status
                    ]);
            }
            //===== IF TOTAL USED PAPER IS ALREADY SET END =====//

            MonthlyUsedPaperDraft::where('id', $request->draft_id)
                ->update([
                    'status' => 0
                ]);

            DB::commit();
            return response()->json(['result' => 1, 'stat' => $status, 'total_used' => $total_of_paper_used_this_month, 'monthly_target' => $monthly_target_quantity]);
        }
    }
}
