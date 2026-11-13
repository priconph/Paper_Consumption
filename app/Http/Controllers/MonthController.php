<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BeginningBalance;
use App\MonthEndBal;
use App\MonthlyTarget;
use App\MonthlyUsedPaper;
use App\PaperPurchases;
use App\TotalUsedPaper;
use App\TotalUsedPerPaper;

class MonthController extends Controller
{
    public function get_months(Request $request)
    {

        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        return response()->json(['month' => $months]);
    }

    public function get_month()
    {
        $months = MonthlyTarget::select('month')
            ->distinct()
            ->get();

        return response()->json(['month' => $months]);
    }

    public function get_months_from_beginning_balance_table()
    {
        //===== GET ALL MONTHS FROM BEGINNING BALANCE TABLE FOR FILTERING PURPOSE =====//
        $result = BeginningBalance::distinct()->get('month');

        $all_months = '<option value="0" selected disabled>  Select Month  </option>';
        $all_months .= '<option value="">  All  </option>';
        for ($i = 0; $i < count($result); $i++) {
            $months = $result[$i]->month;

            $all_months .= "<option value=" . $months . ">" . $months . "</option>";
        }
        return response()->json(['month' => $all_months]);
        //===== GET ALL MONTHS FROM BEGINNING BALANCE TABLE FOR FILTERING PURPOSE END =====//
    }

    public function get_months_from_monthly_target_table()
    {
        //===== GET ALL MONTHS FROM MONTHLY TARGET TABLE FOR FILTERING PURPOSE =====//
        $result = MonthlyTarget::distinct()->get('month');

        $all_months = '<option value="0" selected disabled>  Select Month  </option>';
        $all_months .= '<option value="">  All  </option>';
        for ($i = 0; $i < count($result); $i++) {
            $months = $result[$i]->month;

            $all_months .= "<option value=" . $months . ">" . $months . "</option>";
        }
        return response()->json(['month' => $all_months]);
        //===== GET ALL MONTHS FROM MONTHLY TARGET TABLE FOR FILTERING PURPOSE END =====//
    }

    public function get_months_from_total_purchases_table()
    {
        //===== GET ALL MONTHS FROM TOTAL PURCHASES TABLE FOR FILTERING PURPOSE =====//
        $result = PaperPurchases::distinct()->get('month');

        $all_months = '<option value="0" selected disabled>  Select Month  </option>';
        $all_months .= '<option value="">  All  </option>';
        for ($i = 0; $i < count($result); $i++) {
            $months = $result[$i]->month;

            $all_months .= "<option value=" . $months . ">" . $months . "</option>";
        }
        return response()->json(['month' => $all_months]);
        //===== GET ALL MONTHS FROM TOTAL PURCHASES TABLE FOR FILTERING PURPOSE END =====//
    }

    public function get_months_from_total_used_paper_table()
    {
        //===== GET ALL MONTHS FROM TOTAL USED PAPER TABLE FOR FILTERING PURPOSE =====//
        $result = TotalUsedPaper::distinct()->get('month');

        $all_months = '<option value="0" selected disabled>  Select Month  </option>';
        $all_months .= '<option value="">  All  </option>';
        for ($i = 0; $i < count($result); $i++) {
            $months = $result[$i]->month;

            $all_months .= "<option value=" . $months . ">" . $months . "</option>";
        }
        return response()->json(['month' => $all_months]);
        //===== GET ALL MONTHS FROM TOTAL USED PAPER TABLE FOR FILTERING PURPOSE END =====//
    }

    public function get_months_from_month_end_balance_table()
    {
        //===== GET ALL MONTHS FROM MONTH END BALANCE TABLE FOR FILTERING PURPOSE =====//
        $result = MonthEndBal::distinct()->get('month');

        $all_months = '<option value="0" selected disabled>  Select Month  </option>';
        $all_months .= '<option value="">  All  </option>';
        for ($i = 0; $i < count($result); $i++) {
            $months = $result[$i]->month;

            $all_months .= "<option value=" . $months . ">" . $months . "</option>";
        }
        return response()->json(['month' => $all_months]);
        //===== GET ALL MONTHS FROM MONTH END BALANCE TABLE FOR FILTERING PURPOSE END =====//
    }


    public function get_months_from_total_used_per_paper_table()
    {
        //===== GET ALL MONTHS FROM MONTH END BALANCE TABLE FOR FILTERING PURPOSE =====//
        $result = TotalUsedPerPaper::distinct()->get('month');

        $all_months = '<option value="0" selected disabled>  Select Month  </option>';
        $all_months .= '<option value="">  All  </option>';
        for ($i = 0; $i < count($result); $i++) {
            $months = $result[$i]->month;

            $all_months .= "<option value=" . $months . ">" . $months . "</option>";
        }
        return response()->json(['month' => $all_months]);
        //===== GET ALL MONTHS FROM MONTH END BALANCE TABLE FOR FILTERING PURPOSE END =====//
    }

    public function get_months_from_monthly_used_paper_table()
    {
        //===== GET ALL MONTHS FROM MONTH END BALANCE TABLE FOR FILTERING PURPOSE =====//
        $result = MonthlyUsedPaper::distinct()->get('month');

        $all_months = '<option value="0" selected disabled>  Select Month  </option>';
        $all_months .= '<option value="">  All  </option>';
        for ($i = 0; $i < count($result); $i++) {
            $months = $result[$i]->month;

            $all_months .= "<option value=" . $months . ">" . $months . "</option>";
        }
        return response()->json(['month' => $all_months]);
        //===== GET ALL MONTHS FROM MONTH END BALANCE TABLE FOR FILTERING PURPOSE END =====//


    }
}
