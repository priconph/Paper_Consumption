<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PaperPurchases;
use App\FiscalYear;
use App\BeginningBalance;
use App\MonthEndBal;
use DataTables;

class PaperPurchasesController extends Controller
{
    public function add_paper_purchases(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'paper_id' => 'required',
            'paper_purchase_quantity' => 'required|numeric',
        ]);

        //===== GET CURRENT FISCAL YEAR =====//
        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;
        //===== GET CURRENT FISCAL YEAR END =====//

        //===== MONTH NOW =====//
        $GetActiveMonth = DB::connection('mysql')->select("SELECT `active_month` FROM `month_config` WHERE `status` = '0'");
        $date_now = Carbon::now()->format('d');
        if ($date_now == 01 || $date_now == 02 || $date_now == 03 || $date_now == 04 || $date_now == 05){
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
        //===== MONTH NOW END =====//

        //===== CHECK BEGINNING BALANCE THIS MONTH =====//
        $check_beginning_balance = BeginningBalance::with(['paper'])
            ->where('month', $monthNow)
            ->where('fiscal_year_id', $fy_id)
            ->where('paper_id', $request->paper_id)
            ->where('department_id', $_SESSION['user_department'])
            ->get();

        $check_beginning_balance_based_on_paperId = count($check_beginning_balance);
        //===== CHECK BEGINNING BALANCE THIS MONTH END =====//

        //===== CHECK BEGINNING BALANCE NEXT MONTH =====//
        // $check_beginning_balance_next_month = BeginningBalance::with(['paper'])
        //     ->where('month', $nextMonth)
        //     ->where('fiscal_year_id', $fy_id)
        //     ->where('paper_id', $request->paper_id)
        //     ->where('department_id', $_SESSION['user_department'])
        //     ->get();
        //===== CHECK BEGINNING BALANCE NEXT MONTH END =====//


        if ($nextMonth == 'April') {
            $check_beginning_balance_next_month = BeginningBalance::with(['paper'])
            ->where('month', $nextMonth)
            ->where('fiscal_year_id', $fy_id + 1)
            ->where('paper_id', $request->paper_id)
            ->where('department_id', $_SESSION['user_department'])
            ->get();
        } else {
            $check_beginning_balance_next_month = BeginningBalance::with(['paper'])
            ->where('month', $nextMonth)
            ->where('fiscal_year_id', $fy_id)
            ->where('paper_id', $request->paper_id)
            ->where('department_id', $_SESSION['user_department'])
            ->get();
        }

        // return count($check_beginning_balance_next_month);

        // return $check_beginning_balance_next_month;

        //===== CHECK ENDING BALANCE THIS MONTH =====//
        $check_month_end_balance = MonthEndBal::with(['paper'])
            ->where('month', $monthNow)
            ->where('fiscal_year_id', $fy_id)
            ->where('paper_id', $request->paper_id)
            ->where('department_id', $_SESSION['user_department'])
            ->get();
        //===== CHECK ENDING BALANCE THIS MONTH END =====//

        //===== IF VALIDATION FAILS =====//
        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        //===== IF VALIDATION FAILS END =====//

        //===== IF BEGINNING BALANCE DOES NOT EXIST INSERT NEW DATA =====//
        elseif ($check_beginning_balance_based_on_paperId == 0) {
            //===== INSERT PAPER PURCHASED DATA =====//
            PaperPurchases::insert([
                'paper_id' => $request->paper_id,
                'quantity' => $request->paper_purchase_quantity,
                'year' => $request->year,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $request->fiscal_year
            ]);
            //===== INSERT PAPER PURCHASED DATA END =====//

            //===== INSERT NEW BEGINNING BALANCE DATA =====//
            BeginningBalance::insert([
                'paper_id' => $request->paper_id,
                'quantity' => $request->paper_purchase_quantity,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $request->fiscal_year
            ]);
            //===== INSERT NEW BEGINNING BALANCE DATA END =====//

            //===== INSERT TO MONTH END BAL =====//
            MonthEndBal::insert([
                'paper_id' => $request->paper_id,
                'quantity' => $request->paper_purchase_quantity,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $request->fiscal_year
            ]);
            //===== INSERT TO MONTH END BAL END =====//

            DB::commit();
            return response()->json(['result' => 1]);
        }
        //===== IF BEGINNING BALANCE DOES NOT EXIST INSERT NEW DATA =====//

        //===== ON PAPER PURCHASE CHECK IF BEGINNING BALANCE ALREADY EXISTS THEN UPDATE BEGINNING BALANCE AND MONTH ENDING BALANCE =====//   //===== THEN INSERT THE PAPER PURCHASED  =====//
        elseif ($check_beginning_balance_based_on_paperId != 0) {
            if (count($check_beginning_balance_next_month) != 0) {
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//
                $quantity_based_on_paperId =  $check_beginning_balance[0]->quantity;
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//

                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//
                $quantity_based_on_paperId_next_month =  $check_beginning_balance_next_month[0]->quantity;
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//

                //===== GET MONTH ENDING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//
                $quantity_based_on_paperId_month_end =  $check_month_end_balance[0]->quantity;
                //===== GET MONTH ENDING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//

                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE =====//
                $new_beginning_balance = $quantity_based_on_paperId + $request->paper_purchase_quantity;
                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE END =====//

                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE NEXT MONTH =====//
                $new_beginning_balance_next_month = $quantity_based_on_paperId_next_month + $request->paper_purchase_quantity;
                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE NEXT MONTH END =====//

                //===== ADD NEWLY PURCHASED PAPER TO MONTH ENDING BALANCE IF THERE IS ALREADY A MONTH BALANCE =====//
                $new_month_end_balance = $quantity_based_on_paperId_month_end + $request->paper_purchase_quantity;
                //===== ADD NEWLY PURCHASED PAPER TO MONTH ENDING BALANCE IF THERE IS ALREADY A MONTH BALANCE END =====//

                //===== UPDATE EXISTING BEGINNING BALANCE =====//
                BeginningBalance::where('paper_id', $request->paper_id)
                    ->where('month', $request->month)
                    ->where('fiscal_year_id', $request->fiscal_year)
                    ->where('department_id', $_SESSION["user_department"])
                    ->update([
                        'quantity' => $new_beginning_balance
                    ]);
                //===== UPDATE EXISTING BEGINNING BALANCE END =====//

                if($nextMonth == 'April') {
                     //===== UPDATE EXISTING BEGINNING BALANCE FOR NEXT MONTH =====//
                     BeginningBalance::where('paper_id', $request->paper_id)
                     ->where('month', $nextMonth)
                     ->where('fiscal_year_id', $fy_id + 1)
                     ->where('department_id', $_SESSION["user_department"])
                     ->update([
                         'quantity' => $new_beginning_balance_next_month
                     ]);
                     //===== UPDATE EXISTING BEGINNING BALANCE END FOR NEXT MONTH =====//
                }
                else {
                    //===== UPDATE EXISTING BEGINNING BALANCE FOR NEXT MONTH =====//
                    BeginningBalance::where('paper_id', $request->paper_id)
                    ->where('month', $nextMonth)
                    ->where('fiscal_year_id', $request->fiscal_year)
                    ->where('department_id', $_SESSION["user_department"])
                    ->update([
                        'quantity' => $new_beginning_balance_next_month
                    ]);
                    //===== UPDATE EXISTING BEGINNING BALANCE END FOR NEXT MONTH =====//
                }

                //===== UPDATE EXISTING MONTH ENDING BALANCE =====//
                MonthEndBal::where('paper_id', $request->paper_id)
                    ->where('month', $request->month)
                    ->where('fiscal_year_id', $request->fiscal_year)
                    ->where('department_id', $_SESSION["user_department"])
                    ->update([
                        'quantity' => $new_month_end_balance
                    ]);
                //===== UPDATE EXISTING MONTH ENDING BALANCE END =====//

                //===== INSERT PAPER PURCHASED DATA =====//
                PaperPurchases::insert([
                    'paper_id' => $request->paper_id,
                    'quantity' => $request->paper_purchase_quantity,
                    'year' => $request->year,
                    'month' => $request->month,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $request->fiscal_year
                ]);
                //===== INSERT PAPER PURCHASED DATA END =====//

                DB::commit();
                return response()->json(['result' => 1]);
            } else {
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//
                $quantity_based_on_paperId =  $check_beginning_balance[0]->quantity;
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//

                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE =====//
                $new_beginning_balance = $quantity_based_on_paperId + $request->paper_purchase_quantity;
                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE END =====//

                //===== UPDATE EXISTING BEGINNING BALANCE =====//
                BeginningBalance::where('paper_id', $request->paper_id)
                    ->where('month', $request->month)
                    ->where('fiscal_year_id', $request->fiscal_year)
                    ->where('department_id', $_SESSION["user_department"])
                    ->update([
                        'quantity' => $new_beginning_balance
                    ]);
                //===== UPDATE EXISTING BEGINNING BALANCE END =====//


                //===== INSERT PAPER PURCHASED DATA =====//
                PaperPurchases::insert([
                    'paper_id' => $request->paper_id,
                    'quantity' => $request->paper_purchase_quantity,
                    'year' => $request->year,
                    'month' => $request->month,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $request->fiscal_year
                ]);
                //===== INSERT PAPER PURCHASED DATA END =====//

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
        //===== ON PAPER PURCHASE CHECK IF BEGINNING BALANCE ALREADY EXISTS THEN UPDATE BEGINNING BALANCE AND MONTH ENDING BALANCE =====//   //===== THEN INSERT THE PAPER PURCHASED END =====//
    }

    public function display_paper_purchases()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        //===== DISPLAY ALL PAPER PURCHASES PER DEPARTMENT =====//
        $paper_purchases = PaperPurchases::with('paper')
            ->with('fiscal_year')
            ->where('department_id', $_SESSION["user_department"])
            ->get();

        return DataTables::of($paper_purchases)
            ->addColumn('month', function ($paper_purchases) {
                $result = "";
                if ($paper_purchases->month == "January") {
                    $result .= '<tr value="10">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="10"> </tr>';
                } elseif ($paper_purchases->month == "February") {
                    $result .= '<tr value="11">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="11"> </tr>';
                } elseif ($paper_purchases->month == "March") {
                    $result .= '<tr value="12">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="12"> </tr>';
                } elseif ($paper_purchases->month == "April") {
                    $result .= '<tr value="1">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="1"> </tr>';
                } elseif ($paper_purchases->month == "May") {
                    $result .= '<tr value="2">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="2"> </tr>';
                } elseif ($paper_purchases->month == "June") {
                    $result .= '<tr value="3">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="3"> </tr>';
                } elseif ($paper_purchases->month == "July") {
                    $result .= '<tr value="4">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="4"> </tr>';
                } elseif ($paper_purchases->month == "August") {
                    $result .= '<tr value="5">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="5"> </tr>';
                } elseif ($paper_purchases->month == "September") {
                    $result .= '<tr value="6">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="6"> </tr>';
                } elseif ($paper_purchases->month == "October") {
                    $result .= '<tr value="7">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="7"> </tr>';
                } elseif ($paper_purchases->month == "November") {
                    $result .= '<tr value="8">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="8"> </tr>';
                } elseif ($paper_purchases->month == "December") {
                    $result .= '<tr value="9">' . $paper_purchases->month . '<input class="month_name" type="hidden" style="width:0%;" value="9"> </tr>';
                }
                return $result;
            })
            ->rawColumns(['month'])
            ->make(true);
        //===== DISPLAY ALL PAPER PURCHASES PER DEPARTMENT END =====//
    }

    public function get_ending_bal(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        return response()->json(['result' => $data]);
    }

    public function get_fy_for_paper_purchases()
    {
        $result = FiscalYear::where('status', 0)
            ->get();
        $year = collect($result)->pluck('id')->flatten(1)->toArray();
        // $nextYear = $year + 1;

        return response()->json(['result' => $year]);
    }

    public function get_paper_purchased_quantity(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $request->all();
        $paper_id = $request->paper_purchased_id;

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;

        $GetActiveMonth = DB::connection('mysql')->select("SELECT `active_month` FROM `month_config` WHERE `status` = '0'");
        $date_now = Carbon::now()->format('d');

        if ($date_now == 01 || $date_now == 02 || $date_now == 03 || $date_now == 04 || $date_now == 05) {
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

        $getBeginningBalanceofPaperBasedOnDept = BeginningBalance::with(['paper'])
            ->where('month', $monthNow)
            ->where('fiscal_year_id', $fy_id)
            ->where('department_id', $_SESSION['user_department'])
            ->where('paper_id', $request->paper_purchased_id)
            ->get('paper_id');

        $checkBeginningBalance = count($getBeginningBalanceofPaperBasedOnDept);

        if ($checkBeginningBalance != 0) {
            $result = BeginningBalance::with(['paper'])
                ->where('month', $monthNow)
                ->where('fiscal_year_id', $fy_id)
                ->where('department_id', $_SESSION['user_department'])
                ->where('paper_id', $paper_id)
                ->get();

            $get_quantity_per_paper = $result[0]->quantity;
            return response()->json(['result' => $get_quantity_per_paper]);
        }
    }
}
