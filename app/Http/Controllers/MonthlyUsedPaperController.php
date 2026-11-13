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

class MonthlyUsedPaperController extends Controller
{
    public function add_monthly_used_paper(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        // return $data;
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
            'paper_id' => 'required',
            'quantity' => 'required',
            'reason' => 'required'
        ]);

        //===== CHECK MONTH ENDING BALANCE BASED ON PAPER USED =====//
        $check_month_end_balance = MonthEndBal::with('paper')
            ->with('fiscal_year')
            ->where('paper_id', $request->paper_id)
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
            ->where('paper_id', $request->paper_id)
            ->get();

        $monthly_target_per_paper = $check_monthly_target_per_paper[0]->data_monthly_target;
        // $monthly_target_per_paper = collect($check_monthly_target_per_paper)->pluck('data_monthly_target')->flatten(1)->toArray();
        //===== CHECK MONTHLY TARGET PER PAPER END =====//

        $check_if_no_consumption_is_set = MonthlyUsedPaper::where('data_monthly_used_paper', 0)
            ->where('month', $monthNow)
            ->where('fiscal_year_id', $fy_id)
            ->where('department_id', $_SESSION['user_department'])
            ->where('paper_id', $request->paper_id)
            ->count();

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        //===== IF MONTH ENDING BALANCE OF USED PAPER IS NOT YET SET (INSERT NEW DATA) =====//
        elseif ($check_month_end_balance == 0) {
            if ($check_if_no_consumption_is_set == 0) {
                //===== INSERT MONTHLY USED PAPER BASED ON PAPER USED =====//
                MonthlyUsedPaper::insert([
                    'paper_id' => $request->paper_id,
                    'data_monthly_used_paper' => $request->quantity,
                    'reason' => $request->reason,
                    'year' => $request->year,
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
                ->where('paper_id', $request->paper_id)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $monthNow)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== CHECK BEGINNING BALANCE BASED ON PAPER USED END =====//

            //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER USED =====//
            $quantity_from_beginning_balance = $check_beginning_balance[0]->quantity;
            //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER USED END =====//

            //===== SUBTRACT PAPER USED TO THE BEGINNING BALANCE BASED ON PAPER FOR MONTH ENDING BALANCE =====//
            $month_end_balance = $quantity_from_beginning_balance - $request->quantity;
            //===== SUBTRACT PAPER USED TO THE BEGINNING BALANCE BASED ON PAPER FOR MONTH ENDING BALANCE END =====//

            //===== INSERT NEW MONTH ENDING BALANCE BASED ON PAPER =====//
            MonthEndBal::insert([
                'quantity' => $month_end_balance,
                'month' => $request->month,
                'paper_id' => $request->paper_id,
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
                    'paper_id' => $request->paper_id,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $fy_id + 1
                ]);
                //===== INSERT BEGINNING BALANCE NEXT MONTH BASED ON PAPER FOR NEXT FY END =====//

            } else {
                //===== INSERT BEGINNING BALANCE NEXT MONTH BASED ON PAPER =====//
                BeginningBalance::insert([
                    'quantity' => $month_end_balance,
                    'month' => $nextMonth,
                    'paper_id' => $request->paper_id,
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
                    ->where('paper_id', $request->paper_id)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $check_total_used_per_paper = TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id)
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
                        'paper_id' => $request->paper_id,
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
                    ->where('paper_id', $request->paper_id)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $check_total_used_per_paper = TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id)
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
                        'paper_id' => $request->paper_id,
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
                TotalUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('fiscal_year_id', $fy_id)
                    ->update([
                        'quantity' => $total_of_paper_used_this_month,
                        'status' => $status
                    ]);
            }
            //===== IF TOTAL USED PAPER IS ALREADY SET END =====//

            DB::commit();
            return response()->json(['result' => 1, 'stat' => $status, 'total_used' => $total_of_paper_used_this_month, 'monthly_target' => $monthly_target_quantity]);
        }
        //===== IF MONTH ENDING BALANCE OF USED PAPER IS NOT YET SET =====//

        //===== IF MONTH ENDING BALANCE OF USED PAPER IS ALREADY SET (UPDATE DATA IF USER ADD MONTHLY USED PAPER) =====//
        elseif ($check_month_end_balance != 0) {
            if ($check_if_no_consumption_is_set == 0) {
                //===== INSERT MONTHLY USED PAPER BASED ON PAPER USED =====//
                MonthlyUsedPaper::insert([
                    'paper_id' => $request->paper_id,
                    'data_monthly_used_paper' => $request->quantity,
                    'reason' => $request->reason,
                    'year' => $request->year,
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
                ->where('paper_id', $request->paper_id)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $monthNow)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== GET DATA FROM MONTH ENDING BALANCE BASED ON PAPER USED END =====//

            //===== GET MONTH END BALANCE QUANTITY =====//
            $quantity_from_month_end_balance = $check_month_end_balance[0]->quantity;
            //===== GET MONTH END BALANCE QUANTITY END =====//

            //===== SUBTRACT PAPER USED QUANTITY TO MONTH ENDING BALANCE =====//
            $month_end_balance = $quantity_from_month_end_balance - $request->quantity;
            //===== SUBTRACT PAPER USED QUANTITY TO MONTH ENDING BALANCE END =====//

            //===== UPDATE MONTH ENDING BALANCE =====//
            MonthEndBal::where('paper_id', $request->paper_id)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $monthNow)
                ->where('department_id', $_SESSION['user_department'])
                ->update([
                    'quantity' => $month_end_balance,
                ]);
            //===== UPDATE MONTH ENDING BALANCE =====//

            //===== CHECK BEGINNING BALANCE NEXT MONTH =====//
            $check_beginning_balance_next_month = BeginningBalance::where('paper_id', $request->paper_id)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $nextMonth)
                ->where('department_id', $_SESSION['user_department'])
                ->count();
            //===== CHECK BEGINNING BALANCE NEXT MONTH END =====//

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
                BeginningBalance::where('paper_id', $request->paper_id)
                    ->where('fiscal_year_id', $fy_id + 1)
                    ->where('month', $nextMonth)
                    ->where('department_id', $_SESSION['user_department'])
                    ->update([
                        'quantity' => $month_end_balance,
                    ]);
                //===== UPDATE BEGINNING BALANCE NEXT MONTH END =====//

            } elseif ($check_beginning_balance_next_month != 0) {
                //===== UPDATE BEGINNING BALANCE NEXT MONTH =====//
                BeginningBalance::where('paper_id', $request->paper_id)
                    ->where('fiscal_year_id', $fy_id)
                    ->where('month', $nextMonth)
                    ->where('department_id', $_SESSION['user_department'])
                    ->update([
                        'quantity' => $month_end_balance,
                    ]);
                //===== UPDATE BEGINNING BALANCE NEXT MONTH END =====//
            } elseif ($check_beginning_balance_next_month == 0) {
                //===== INSERT BEGINNING BALANCE NEXT MONTH BASED ON PAPER =====//
                BeginningBalance::insert([
                    'quantity' => $month_end_balance,
                    'month' => $nextMonth,
                    'paper_id' => $request->paper_id,
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
                    ->where('paper_id', $request->paper_id)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $check_total_used_per_paper = TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id)
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
                        'paper_id' => $request->paper_id,
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
                    ->where('paper_id', $request->paper_id)
                    ->where('fiscal_year_id', $fy_id)
                    ->sum('data_monthly_used_paper');

                $check_total_used_per_paper = TotalUsedPerPaper::where('department_id', $_SESSION['user_department'])
                    ->where('month', $monthNow)
                    ->where('paper_id', $request->paper_id)
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
                        'paper_id' => $request->paper_id,
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

                TotalUsedPaper::where('department_id', $_SESSION['user_department'])
                    ->where('fiscal_year_id', $fy_id)
                    ->where('month', $monthNow)
                    ->update([
                        'quantity' => $total_of_paper_used_this_month,
                        'status' => $status
                    ]);
            }
            //===== IF TOTAL USED PAPER IS ALREADY SET END =====//

            DB::commit();
            return response()->json(['result' => 1, 'stat' => $status, 'total_used' => $total_of_paper_used_this_month, 'monthly_target' => $monthly_target_quantity]);
        }
    }

    public function display_monthly_used_paper(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $monthly_used_papers = MonthlyUsedPaper::with('paper')
            ->with('fiscal_year')
            ->where('department_id', $_SESSION["user_department"])
            ->get();


        return DataTables::of($monthly_used_papers)
            ->addColumn('month', function ($monthly_used_papers) {
                $result = "";
                if ($monthly_used_papers->month == "January") {
                    $result .= '<tr value="10">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                } elseif ($monthly_used_papers->month == "February") {
                    $result .= '<tr value="11">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                } elseif ($monthly_used_papers->month == "March") {
                    $result .= '<tr value="12">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                } elseif ($monthly_used_papers->month == "April") {
                    $result .= '<tr value="1">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                } elseif ($monthly_used_papers->month == "May") {
                    $result .= '<tr value="2">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                } elseif ($monthly_used_papers->month == "June") {
                    $result .= '<tr value="3">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                } elseif ($monthly_used_papers->month == "July") {
                    $result .= '<tr value="4">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                } elseif ($monthly_used_papers->month == "August") {
                    $result .= '<tr value="5">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                } elseif ($monthly_used_papers->month == "September") {
                    $result .= '<tr value="6">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                } elseif ($monthly_used_papers->month == "October") {
                    $result .= '<tr value="7">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                } elseif ($monthly_used_papers->month == "November") {
                    $result .= '<tr value="8">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                } elseif ($monthly_used_papers->month == "December") {
                    $result .= '<tr value="9">' . $monthly_used_papers->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                }
                return $result;
            })
            ->rawColumns(['month'])
            ->make(true);
    }

    public function display_total_used_paper()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        //===== GET TOTAL USED PAPER FOR THE DEPARTMENT  =====//
        $total_used_papers = TotalUsedPaper::with(['department'])
            ->with(['monthly_target'])
            ->with(['fiscal_year'])
            ->where('department_id', $_SESSION["user_department"])
            ->where('fiscal_year_id', '!=', '1')
            ->get();
        //===== GET TOTAL USED PAPER FOR THE DEPARTMENT END  =====//

        $count_total_used_paper = count($total_used_papers);

        //===== DISPLAY DATA IN TOTAL USED PAPER DATATABLES  =====//
        return DataTables::of($total_used_papers)
            ->addColumn('total_reams', function ($total_used_paper) use ($count_total_used_paper) {
                for ($i = 0; $i < $count_total_used_paper; $i++) {
                    $get_total_quantity = $total_used_paper->quantity;
                    // dump($get_total_quantity);
                    $get_total_reams = $get_total_quantity / 500;
                    $total_reams = number_format((float)$get_total_reams, 2, '.', '');
                }
                return $total_reams;
            })
            ->addColumn('status', function ($total_used_paper) {
                $result = "";

                if ($total_used_paper->status == "Over") {
                    $result .= '<center><span class="badge badge-pill badge-danger">Over</span></center>';
                } elseif ($total_used_paper->status == "Under") {
                    $result .= '<center><span class="badge badge-pill badge-success">Under</span></center>';
                } elseif ($total_used_paper->status == "On Target") {
                    $result .= '<center><span class="badge badge-pill badge-primary">On Target</span></center>';
                }
                return $result;
            })
            ->addColumn('month', function ($total_used_paper) {
                $result = "";
                if ($total_used_paper->month == "January") {
                    $result .= '<tr value="10">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                } elseif ($total_used_paper->month == "February") {
                    $result .= '<tr value="11">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                } elseif ($total_used_paper->month == "March") {
                    $result .= '<tr value="12">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                } elseif ($total_used_paper->month == "April") {
                    $result .= '<tr value="1">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                } elseif ($total_used_paper->month == "May") {
                    $result .= '<tr value="2">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                } elseif ($total_used_paper->month == "June") {
                    $result .= '<tr value="3">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                } elseif ($total_used_paper->month == "July") {
                    $result .= '<tr value="4">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                } elseif ($total_used_paper->month == "August") {
                    $result .= '<tr value="5">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                } elseif ($total_used_paper->month == "September") {
                    $result .= '<tr value="6">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                } elseif ($total_used_paper->month == "October") {
                    $result .= '<tr value="7">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                } elseif ($total_used_paper->month == "November") {
                    $result .= '<tr value="8">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                } elseif ($total_used_paper->month == "December") {
                    $result .= '<tr value="9">' . $total_used_paper->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                }
                return $result;
            })
            ->rawColumns(['total_reams', 'status', 'month']) // to format the added columns(total reams) as html format
            ->make(true);
        //===== DISPLAY DATA IN TOTAL USED PAPER DATATABLES END  =====//
    }

    public function display_total_used_per_paper()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $total_used_papers = TotalUsedPerPaper::with(['paper'])
            ->with('fiscal_year')
            ->where('department_id', $_SESSION['user_department'])
            ->get();

        return DataTables::of($total_used_papers)
            ->addColumn('month', function ($total_used_papers) {
                $result = "";
                if ($total_used_papers->month == "January") {
                    $result .= '<tr value="10">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                } elseif ($total_used_papers->month == "February") {
                    $result .= '<tr value="11">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                } elseif ($total_used_papers->month == "March") {
                    $result .= '<tr value="12">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                } elseif ($total_used_papers->month == "April") {
                    $result .= '<tr value="1">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                } elseif ($total_used_papers->month == "May") {
                    $result .= '<tr value="2">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                } elseif ($total_used_papers->month == "June") {
                    $result .= '<tr value="3">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                } elseif ($total_used_papers->month == "July") {
                    $result .= '<tr value="4">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                } elseif ($total_used_papers->month == "August") {
                    $result .= '<tr value="5">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                } elseif ($total_used_papers->month == "September") {
                    $result .= '<tr value="6">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                } elseif ($total_used_papers->month == "October") {
                    $result .= '<tr value="7">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                } elseif ($total_used_papers->month == "November") {
                    $result .= '<tr value="8">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                } elseif ($total_used_papers->month == "December") {
                    $result .= '<tr value="9">' . $total_used_papers->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                }
                return $result;
            })
            ->addColumn('status', function ($total_used_paper) {
                $result = "";
                if ($total_used_paper->status == "Over") {
                    $result .= '<center><span class="badge badge-pill badge-danger">Over</span></center>';
                } elseif ($total_used_paper->status == "Under") {
                    $result .= '<center><span class="badge badge-pill badge-success">Under</span></center>';
                } elseif ($total_used_paper->status == "On Target") {
                    $result .= '<center><span class="badge badge-pill badge-primary">On Target</span></center>';
                }
                return $result;
            })
            ->rawColumns(['status', 'month']) // to format the added columns(total reams) as html format
            ->make(true);;
    }

    public function get_papers_per_dept()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;

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

        $check_beginning_balance = BeginningBalance::with(['paper'])
            ->with(['fiscal_year'])
            ->where('fiscal_year_id', $fy_id)
            ->where('month', $monthNow)
            ->where('department_id', $_SESSION['user_department'])
            ->get();

        $paper_name = '<option value="0" selected disabled>  Select Paper  </option>';
        for ($j = 0; $j < count($check_beginning_balance); $j++) {
            // FROM BEGINNING BALANCE
            $paper_id_from_beginning_balance = $check_beginning_balance[$j]->paper_id;
            $paper_name_from_beginning_balance = $check_beginning_balance[$j]->paper->name;
            // FROM BEGINNING BALANCE END

            $paper_name .=  "<option value=" . $paper_id_from_beginning_balance . ">" . $paper_name_from_beginning_balance . "</option>";
        }
        return response()->json(['paper_names' => $paper_name]);
    }

    public function display_paper_consumption_reasons()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $get_paper_consumption_reasons = MonthlyUsedPaper::with(['fiscal_year'])
            ->where('department_id', $_SESSION["user_department"])
            ->get();

        return DataTables::of($get_paper_consumption_reasons)
            ->addColumn('month', function ($get_paper_consumption_reasons) {
                $result = "";
                if ($get_paper_consumption_reasons->month == "January") {
                    $result .= '<tr value="10">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "February") {
                    $result .= '<tr value="11">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "March") {
                    $result .= '<tr value="12">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "April") {
                    $result .= '<tr value="1">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "May") {
                    $result .= '<tr value="2">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "June") {
                    $result .= '<tr value="3">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "July") {
                    $result .= '<tr value="4">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "August") {
                    $result .= '<tr value="5">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "September") {
                    $result .= '<tr value="6">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "October") {
                    $result .= '<tr value="7">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "November") {
                    $result .= '<tr value="8">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                } elseif ($get_paper_consumption_reasons->month == "December") {
                    $result .= '<tr value="9">' . $get_paper_consumption_reasons->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                }
                return $result;
            })
            ->rawColumns(['month'])
            ->make(true);
    }

    public function add_monthly_used_paper_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;

        $validator = Validator::make($data, [
            'paper_id' => 'required',
            'quantity' => 'required',
            'reason' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            MonthlyUsedPaperDraft::insert([
                'paper_id' => $request->paper_id,
                'paper_quantity' => $request->quantity,
                'reason' => $request->reason,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $fy_id,
                'status' => 1
            ]);

            DB::commit();
            return response()->json(['result' => 1]);
        }
    }

    public function display_monthly_used_paper_draft()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        //===== DISPLAY MONTHLY USED PAPER DRAFTS =====//
        $monthly_used_draft = MonthlyUsedPaperDraft::with(['paper'])
            ->with(['fiscal_year'])
            ->where('department_id', $_SESSION["user_department"])
            ->where('status', 1)
            ->get();

        return DataTables::of($monthly_used_draft)
            ->addColumn('month', function ($monthly_used_draft) {
                $result = "";
                if ($monthly_used_draft->month == "January") {
                    $result .= '<tr value="10">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="January"> </tr>';
                } elseif ($monthly_used_draft->month == "February") {
                    $result .= '<tr value="11">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="February"> </tr>';
                } elseif ($monthly_used_draft->month == "March") {
                    $result .= '<tr value="12">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="March"> </tr>';
                } elseif ($monthly_used_draft->month == "April") {
                    $result .= '<tr value="1">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="April"> </tr>';
                } elseif ($monthly_used_draft->month == "May") {
                    $result .= '<tr value="2">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="May"> </tr>';
                } elseif ($monthly_used_draft->month == "June") {
                    $result .= '<tr value="3">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="June"> </tr>';
                } elseif ($monthly_used_draft->month == "July") {
                    $result .= '<tr value="4">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="July"> </tr>';
                } elseif ($monthly_used_draft->month == "August") {
                    $result .= '<tr value="5">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="August"> </tr>';
                } elseif ($monthly_used_draft->month == "September") {
                    $result .= '<tr value="6">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="September"> </tr>';
                } elseif ($monthly_used_draft->month == "October") {
                    $result .= '<tr value="7">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="October"> </tr>';
                } elseif ($monthly_used_draft->month == "November") {
                    $result .= '<tr value="8">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="November"> </tr>';
                } elseif ($monthly_used_draft->month == "December") {
                    $result .= '<tr value="9">' . $monthly_used_draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="December"> </tr>';
                }
                return $result;
            })
            ->addColumn('action', function ($monthly_used_draft) {
                $result = FiscalYear::where('status', 0)
                    ->get();
                $fy_id = $result[0]->id;

                $result = "";

                $get_month = $monthly_used_draft->month;
                $get_fy_id = $monthly_used_draft->fiscal_year_id;

                $GetActiveMonth = DB::connection('mysql')->select("SELECT `active_month` FROM `month_config` WHERE `status` = '0'");
                $date_now = Carbon::now()->format('d');
                if($date_now == 01 || $date_now == 02 || $date_now == 03 || $date_now == 04 || $date_now == 05){
                    if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                        $month_now = Carbon::now()->subMonth()->format('F');
                        $nextMonth = Carbon::now()->format('F');
                    }else{//Previous Month
                        $month_now = Carbon::now()->subMonths(2)->format('F');
                        $nextMonth = Carbon::now()->format('F');
                    }
                }else{
                    if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                        $month_now = Carbon::now()->format('F');
                        $nextMonth = Carbon::now()->addMonth()->format('F');
                    }else{//Previous Month
                        $month_now = Carbon::now()->subMonth()->format('F');
                        $nextMonth = Carbon::now()->format('F');
                    }

                    // $month_now = Carbon::now()->format('F');                //uncomment to activate real month
                    // $nextMonth = Carbon::now()->addMonth()->format('F');    //uncomment to activate real month
                    // $month_now = Carbon::now()->subMonth()->format('F');    //uncomment to activate previous month
                    // $nextMonth = Carbon::now()->format('F');                //uncomment to activate previous month
                }

                if ($get_month == $month_now && $get_fy_id == $fy_id) {
                    $result .= '<button data-dismiss="modal" class="btn btn-primary text-center actionEditDraft" id="btnEditDraft" draft-id="' . $monthly_used_draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                    $result .= '<button data-dismiss="modal" class="btn btn-success actionSubmitDraft" draft-id="' . $monthly_used_draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false"><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>&nbsp;';

                    $result .= '<button data-dismiss="modal" class="btn btn-danger actionDeleteDraft" draft-id="' . $monthly_used_draft->id . ' " data-toggle="modal" data-target="#modalDeleteDraft" data-keyboard="false"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
                } else {
                    // $result .= '<button data-dismiss="modal" class="btn btn-primary text-center actionEditDraft" id="btnEditDraft" draft-id="' . $monthly_used_draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false" disabled><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                    $result .= '<button data-dismiss="modal" class="btn btn-success actionSubmitDraft" draft-id="' . $monthly_used_draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false" disabled><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>&nbsp;';

                    $result .= '<button data-dismiss="modal" class="btn btn-danger actionDeleteDraft" draft-id="' . $monthly_used_draft->id . ' " data-toggle="modal" data-target="#modalDeleteDraft" data-keyboard="false"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
                }
                return $result;
            })
            ->rawColumns(['month', 'action'])
            ->make(true);
        //===== DISPLAY MONTHLY USED PAPER DRAFTS END =====//
    }

    public function get_id_edit_monthly_used_draft(Request $request)
    {
        $monthly_used_drafts = MonthlyUsedPaperDraft::with(['paper'])->where('id', $request->draft_id)->get();

        $monthly_used_drafts_month = MonthlyUsedPaperDraft::with(['paper'])->where('id', $request->draft_id)->get();
        $month = $monthly_used_drafts_month[0]->month;

        $result = '<input type="text" value="' . $month . '" readonly>';

        return response()->json(['drafts' => $monthly_used_drafts, 'month' => $result]);
    }

    public function edit_monthly_used_paper_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        MonthlyUsedPaperDraft::where('id', $request->draft_id)
            ->update([
                'paper_id' => $request->paper_id_edit,
                'paper_quantity' => $request->quantity_edit,
                'reason' => $request->reason_edit,
            ]);

        return response()->json(['result' => 1]);
        // }
    }

    public function delete_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        MonthlyUsedPaperDraft::where('id', $request->draft_id)
            ->update([
                'status' => 2
            ]);

        return response()->json(['result' => "1"]);
    }
}
