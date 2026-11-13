<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MonthlyUsedPaper;
use App\TotalUsedPaper;
use App\FiscalYear;
use App\Department;
use App\BeginningBalance;
use App\MonthlyTarget;
use App\TotalUsedPerPaper;
use DataTables;

class PaperConsumptionReasonsController extends Controller
{
    public function get_paper_consumption_reasons()
    {
        $paper_consumption_reasons = MonthlyUsedPaper::with(['department'])
            ->with(['fiscal_year'])
            ->get();

        return DataTables::of($paper_consumption_reasons)
            ->make(true);
    }

    public function get_department(Request $request)
    {
        $departments = Department::where('name', '!=', 'CN')
            ->where('name', '!=', 'TS')
            ->where('name', '!=', 'YF')
            ->where('name', '!=', 'PPS')
            ->get();

        return response()->json(['department' => $departments]);
    }
}
