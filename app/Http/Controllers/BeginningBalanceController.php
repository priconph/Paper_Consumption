<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\FiscalYear;
use App\MonthEndBal;
use App\BeginningBalance;

use DataTables;

class BeginningBalanceController extends Controller
{
    public function display_beginning_bal()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $beginning_balance = BeginningBalance::with(['paper'])
            ->with(['fiscal_year'])
            ->where('department_id', $_SESSION['user_department'])
            ->get();

        return DataTables::of($beginning_balance)
            ->addColumn('month', function ($beginning_balance) {
                $result = "";
                // if ($beginning_balance->month == "January") {
                //     $result .= '<tr value="1">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                // } elseif ($beginning_balance->month == "February") {
                //     $result .= '<tr value="2">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                // } elseif ($beginning_balance->month == "March") {
                //     $result .= '<tr value="3">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                // } elseif ($beginning_balance->month == "April") {
                //     $result .= '<tr value="4">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                // } elseif ($beginning_balance->month == "May") {
                //     $result .= '<tr value="5">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                // } elseif ($beginning_balance->month == "June") {
                //     $result .= '<tr value="6">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                // } elseif ($beginning_balance->month == "July") {
                //     $result .= '<tr value="7">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                // } elseif ($beginning_balance->month == "August") {
                //     $result .= '<tr value="8">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                // } elseif ($beginning_balance->month == "September") {
                //     $result .= '<tr value="9">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                // } elseif ($beginning_balance->month == "October") {
                //     $result .= '<tr value="10">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                // } elseif ($beginning_balance->month == "November") {
                //     $result .= '<tr value="11">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                // } elseif ($beginning_balance->month == "December") {
                //     $result .= '<tr value="12">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                // }
                if ($beginning_balance->month == "January") {
                    $result .= '<tr value="10">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                } elseif ($beginning_balance->month == "February") {
                    $result .= '<tr value="11">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                } elseif ($beginning_balance->month == "March") {
                    $result .= '<tr value="12">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                } elseif ($beginning_balance->month == "April") {
                    $result .= '<tr value="1">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                } elseif ($beginning_balance->month == "May") {
                    $result .= '<tr value="2">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                } elseif ($beginning_balance->month == "June") {
                    $result .= '<tr value="3">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                } elseif ($beginning_balance->month == "July") {
                    $result .= '<tr value="4">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                } elseif ($beginning_balance->month == "August") {
                    $result .= '<tr value="5">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                } elseif ($beginning_balance->month == "September") {
                    $result .= '<tr value="6">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                } elseif ($beginning_balance->month == "October") {
                    $result .= '<tr value="7">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                } elseif ($beginning_balance->month == "November") {
                    $result .= '<tr value="8">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                } elseif ($beginning_balance->month == "December") {
                    $result .= '<tr value="9">' . $beginning_balance->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                }
                return $result;
            })
            ->rawColumns(['month']) // to format the added columns(status & action) as html format
            ->make(true);
    }

    public function get_beginning_balance_quantity(Request $request)
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

            // $monthNow = Carbon::now()->format('F');                 // Month now //uncomment to activate real month
            // $nextMonth = Carbon::now()->addMonth()->format('F');    // Month now //uncomment to activate real month
            // $monthNow = Carbon::now()->subMonth()->format('F');  //uncomment to activate previous month
            // $nextMonth = Carbon::now()->format('F');             //uncomment to activate previous month
        }

        $check_month_end_balance = MonthEndBal::with(['paper'])
            ->with(['fiscal_year'])
            ->where('paper_id', $paper_id)
            ->where('fiscal_year_id', $fy_id)
            ->where('month', $monthNow)
            ->where('department_id', $_SESSION['user_department'])
            ->get();

        $month_end_balance_for_the_month = count($check_month_end_balance);

        if ($month_end_balance_for_the_month == 0) {
            $beginning_balance_quantity = BeginningBalance::with(['paper'])
                ->where('month', $monthNow)
                ->where('fiscal_year_id', $fy_id)
                ->where('department_id', $_SESSION['user_department'])
                ->where('paper_id', $paper_id)
                ->get();


            // return $beginning_balance_quantity;

            $get_quantity_per_paper = collect($beginning_balance_quantity)->pluck('quantity')->flatten(1);


            // $get_quantity_per_paper = $beginning_balance_quantity[0]->quantity;
            return response()->json(['result' => $get_quantity_per_paper]);
        } else {
            $month_end_balance_quantity = MonthEndBal::with(['paper'])
                ->where('month', $monthNow)
                ->where('fiscal_year_id', $fy_id)
                ->where('department_id', $_SESSION['user_department'])
                ->where('paper_id', $paper_id)
                ->get();


            $get_quantity_per_paper = $month_end_balance_quantity[0]->quantity;


            return response()->json(['result' => $get_quantity_per_paper]);
        }
    }

    public function add_beginning_balance_quantity(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

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

            // $monthNow = Carbon::now()->format('F');                // Month now //uncomment to activate real month
            // $nextMonth = Carbon::now()->addMonth()->format('F');   // Month now //uncomment to activate real month
            // $monthNow = Carbon::now()->subMonth()->format('F');    //uncomment to activate previous month
            // $nextMonth = Carbon::now()->format('F');               //uncomment to activate previous month
        }

        $validator = Validator::make($data, [
            'paper_id' => 'required',
            'beginning_balance' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {

            //===== CHECK BEGINNING BALANCE BASED ON PAPER USED =====//
            $check_beginning_balance = BeginningBalance::with(['paper'])
                ->with(['fiscal_year'])
                ->where('paper_id', $request->paper_id)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $monthNow)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== CHECK BEGINNING BALANCE BASED ON PAPER USED END =====//

            //===== CHECK MONTH ENDING BALANCE BASED ON PAPER USED =====//
            $check_month_end_balance = MonthEndBal::with('paper')
                ->with('fiscal_year')
                ->where('paper_id', $request->paper_id)
                ->where('month', $monthNow)
                ->where('fiscal_year_id', $fy_id)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== CHECK MONTH ENDING BALANCE BASED ON PAPER USED END =====//

            //===== CHECK BEGINNING BALANCE NEXT MONTH =====//
            $check_beginning_balance_next_month = BeginningBalance::with(['paper'])
                ->where('month', $nextMonth)
                ->where('fiscal_year_id', $fy_id)
                ->where('paper_id', $request->paper_id)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== CHECK BEGINNING BALANCE NEXT MONTH END =====//

            if (count($check_beginning_balance) == 0) {
                BeginningBalance::insert([
                    'quantity' => $request->beginning_balance,
                    'month' => $request->month,
                    'paper_id' => $request->paper_id,
                    'department_id' => $_SESSION['user_department'],
                    'fiscal_year_id' => $fy_id
                ]);
            } else {
                $get_existing_balance = $check_beginning_balance[0]->quantity;
                $new_beginning_balance = $get_existing_balance + $request->beginning_balance;

                BeginningBalance::where('department_id', $_SESSION['user_department'])
                    ->where('month', $request->month)
                    ->where('paper_id', $request->paper_id)
                    ->where('fiscal_year_id', $fy_id)
                    ->update([
                        'quantity' => $new_beginning_balance,
                        'month' => $request->month,
                        'paper_id' => $request->paper_id,
                        'department_id' => $_SESSION['user_department'],
                        'fiscal_year_id' => $fy_id
                    ]);

                if (count($check_month_end_balance) != 0) {
                    $get_existing_balance = $check_month_end_balance[0]->quantity;
                    $new_month_end_balance = $get_existing_balance + $request->beginning_balance;

                    MonthEndBal::where('department_id', $_SESSION['user_department'])
                        ->where('month', $request->month)
                        ->where('paper_id', $request->paper_id)
                        ->where('fiscal_year_id', $fy_id)
                        ->update([
                            'quantity' => $new_month_end_balance,
                        ]);

                    if (count($check_beginning_balance_next_month) != 0) {
                        $get_existing_balance = $check_beginning_balance_next_month[0]->quantity;
                        $new_beginning_balance_next_month = $get_existing_balance + $request->beginning_balance;

                        BeginningBalance::where('department_id', $_SESSION['user_department'])
                            ->where('month', $nextMonth)
                            ->where('paper_id', $request->paper_id)
                            ->where('fiscal_year_id', $fy_id)
                            ->update([
                                'quantity' => $new_beginning_balance_next_month,
                            ]);
                    } else {
                        // $get_existing_balance = $check_beginning_balance_next_month[0]->quantity;
                        // $new_beginning_balance_next_month = $get_existing_balance + $request->beginning_balance;
                        $get_existing_balance = $check_month_end_balance[0]->quantity;
                        $new_beginning_balance_next_month = $get_existing_balance + $request->beginning_balance;

                        BeginningBalance::insert([
                            'quantity' => $new_beginning_balance_next_month,
                            'month' => $nextMonth,
                            'paper_id' => $request->paper_id,
                            'department_id' => $_SESSION['user_department'],
                            'fiscal_year_id' => $fy_id
                        ]);
                    }
                } else {
                    MonthEndBal::insert([
                        'quantity' => $request->beginning_balance,
                        'month' => $request->month,
                        'paper_id' => $request->paper_id,
                        'department_id' => $_SESSION['user_department'],
                        'fiscal_year_id' => $fy_id
                    ]);
                }
            }

            DB::commit();
            return response()->json(['result' => 1]);
        }
    }
}
