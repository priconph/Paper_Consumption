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
use DataTables;

class ConsumptionSummaryController extends Controller
{
    public function get_current_fy(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        $get_current_fy = $current_fy[0]->year;

        return response()->json(['result' => $get_current_fy]);
    }

    public function get_bod_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 1)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_ias_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 2)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_fin_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 3)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_hrd_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 4)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_ess_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 5)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_log_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 6)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_fac_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 7)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_iss_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 8)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_qad_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 9)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_ems_consumption(){
        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;


        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', 10)
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_dept_consumption(){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;



        $total_used = MonthlyUsedPaper::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', $_SESSION['user_department'])
            ->sum('data_monthly_used_paper');

        return response()->json(['result' => $total_used]);
    }

    public function get_dept_target(){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $current_fy = FiscalYear::where('status', 0)
            ->get();

        // $get_current_fy = $current_fy[0]->year;
        $get_current_fy_id = $current_fy[0]->id;



        $total_target = MonthlyTarget::where('fiscal_year_id', $get_current_fy_id)
            ->where('department_id', $_SESSION['user_department'])
            ->sum('data_monthly_target');

        return response()->json(['result' => $total_target]);
    }
}
