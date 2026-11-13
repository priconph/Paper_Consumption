<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MonthlyTarget;
use App\FiscalYear;
use App\TotalUsedPaper;
use DataTables;

class MonthlyTargetController extends Controller
{
    public function add_monthly_target(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;

        $validator = Validator::make($data, [
            'paper_id' => 'required',
            'monthly_target' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', $request->month)
                ->where('department_id', $request->department_id)
                ->where('paper_id', $request->paper_id)->exists()
            ) {
                return response()->json(['result' => 0]);
            } else {

                // $user_dept = User::select('department_id')->where('name',  $_SESSION["user_name"])->get();
                MonthlyTarget::insert([
                    'paper_id' => $request->paper_id,
                    'data_monthly_target' => $request->monthly_target,
                    'month' => $request->month,
                    'department_id' => $request->department_id,
                    'fiscal_year_id' => $fy_id
                ]);

                $check_total_used_paper_monthly_target = TotalUsedPaper::where('month', $request->month)
                    ->where('fiscal_year_id', $fy_id)
                    ->where('department_id', $request->department_id)
                    ->get();

                if (count($check_total_used_paper_monthly_target) != 0) {
                    $get_monthly_target_in_total_used_paper = $check_total_used_paper_monthly_target[0]->monthly_target_id;
                    $get_quantity_in_total_used_paper = $check_total_used_paper_monthly_target[0]->quantity;

                    $updated_total_monthly_target = $get_monthly_target_in_total_used_paper + $request->monthly_target;

                    if ($updated_total_monthly_target > $get_quantity_in_total_used_paper) {
                        $status = "Under";
                    } elseif ($updated_total_monthly_target < $get_quantity_in_total_used_paper) {
                        $status = "Over";
                    } else if ($updated_total_monthly_target == $get_quantity_in_total_used_paper) {
                        $status = "On Target";
                    }

                    TotalUsedPaper::where('month', $request->month)
                        ->where('fiscal_year_id', $fy_id)
                        ->where('department_id', $request->department_id)
                        ->update([
                            'monthly_target_id' => $updated_total_monthly_target,
                            'status' => $status
                        ]);
                }

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
    }

    public function display_monthly_target(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $monthly_targets = MonthlyTarget::with(['paper'])
            ->with(['fiscal_year'])
            ->where('department_id', $_SESSION['user_department'])
            ->get();

        return DataTables::of($monthly_targets)
            ->addColumn('month', function ($monthly_targets) {
                $result = "";
                // if ($monthly_targets->month == "January") {
                //     $result .= '<tr value="1">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                // } elseif ($monthly_targets->month == "February") {
                //     $result .= '<tr value="2">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                // } elseif ($monthly_targets->month == "March") {
                //     $result .= '<tr value="3">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                // } elseif ($monthly_targets->month == "April") {
                //     $result .= '<tr value="4">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                // } elseif ($monthly_targets->month == "May") {
                //     $result .= '<tr value="5">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                // } elseif ($monthly_targets->month == "June") {
                //     $result .= '<tr value="6">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                // } elseif ($monthly_targets->month == "July") {
                //     $result .= '<tr value="7">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                // } elseif ($monthly_targets->month == "August") {
                //     $result .= '<tr value="8">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                // } elseif ($monthly_targets->month == "September") {
                //     $result .= '<tr value="9">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                // } elseif ($monthly_targets->month == "October") {
                //     $result .= '<tr value="10">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                // } elseif ($monthly_targets->month == "November") {
                //     $result .= '<tr value="11">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                // } elseif ($monthly_targets->month == "December") {
                //     $result .= '<tr value="12">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                // }
                if ($monthly_targets->month == "January") {
                    $result .= '<tr value="10">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="10"> </tr>';
                } elseif ($monthly_targets->month == "February") {
                    $result .= '<tr value="11">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="11"> </tr>';
                } elseif ($monthly_targets->month == "March") {
                    $result .= '<tr value="12">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="12"> </tr>';
                } elseif ($monthly_targets->month == "April") {
                    $result .= '<tr value="1">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="1"> </tr>';
                } elseif ($monthly_targets->month == "May") {
                    $result .= '<tr value="2">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="2"> </tr>';
                } elseif ($monthly_targets->month == "June") {
                    $result .= '<tr value="3">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="3"> </tr>';
                } elseif ($monthly_targets->month == "July") {
                    $result .= '<tr value="4">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="4"> </tr>';
                } elseif ($monthly_targets->month == "August") {
                    $result .= '<tr value="5">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="5"> </tr>';
                } elseif ($monthly_targets->month == "September") {
                    $result .= '<tr value="6">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="6"> </tr>';
                } elseif ($monthly_targets->month == "October") {
                    $result .= '<tr value="7">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="7"> </tr>';
                } elseif ($monthly_targets->month == "November") {
                    $result .= '<tr value="8">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="8"> </tr>';
                } elseif ($monthly_targets->month == "December") {
                    $result .= '<tr value="9">' . $monthly_targets->month . '<input class="month_name" type="hidden" value="9"> </tr>';
                }
                return $result;
            })
            ->rawColumns(['month'])
            ->make(true);
    }

    public function get_year()
    {
        $years = MonthlyTarget::select('year')
            ->distinct()
            ->get();

        $test = "";
        for ($i = 0; $i < count($years); $i++) {
            $date = Carbon::parse($years[$i]['year'])->format('Y-m-d');
            $test1 = $date;

            $year1 =  Carbon::parse($years[$i]['year'])->year;
            $test .= "<option value=" . $test1 . ">" . $year1 . "</option>";
        }
        return response()->json(['years' => $test]);
    }
}
