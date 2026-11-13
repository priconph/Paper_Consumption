<?php

namespace App\Http\Controllers;

use App\MonthEndBal;
use DataTables;

class MonthEndingBalanceController extends Controller
{
    public function display_month_end_balance()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $month_end_balance = MonthEndBal::with(['paper'])
            ->with(['fiscal_year'])
            ->where('department_id', $_SESSION['user_department'])
            ->get();

        return DataTables::of($month_end_balance)
            ->addColumn('month', function ($month_end_balance) {
                $result = "";
                if ($month_end_balance->month == "January") {
                    $result .= '<tr value="10">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                } elseif ($month_end_balance->month == "February") {
                    $result .= '<tr value="11">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                } elseif ($month_end_balance->month == "March") {
                    $result .= '<tr value="12">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                } elseif ($month_end_balance->month == "April") {
                    $result .= '<tr value="1">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                } elseif ($month_end_balance->month == "May") {
                    $result .= '<tr value="2">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                } elseif ($month_end_balance->month == "June") {
                    $result .= '<tr value="3">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                } elseif ($month_end_balance->month == "July") {
                    $result .= '<tr value="4">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                } elseif ($month_end_balance->month == "August") {
                    $result .= '<tr value="5">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                } elseif ($month_end_balance->month == "September") {
                    $result .= '<tr value="6">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                } elseif ($month_end_balance->month == "October") {
                    $result .= '<tr value="7">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                } elseif ($month_end_balance->month == "November") {
                    $result .= '<tr value="8">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                } elseif ($month_end_balance->month == "December") {
                    $result .= '<tr value="9">' . $month_end_balance->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                }
                return $result;
            })
            ->rawColumns(['month'])
            ->make(true);
    }
}
