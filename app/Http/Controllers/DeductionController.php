<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Deduction;
use App\Department;
use App\FiscalYear;
use App\TotalUsedPaper;
use DataTables;

class DeductionController extends Controller
{
    public function view_deductions()
    {
        $deductions = Deduction::with(['department'])->get();

        // return $deductions;
        return DataTables::of($deductions)
            ->addColumn('action', function ($deduction) {
                $result = "";
                $result .= '<button class="btn btn-primary text-center actionEditDeduction " deduction-id="' . $deduction->id . '" data-toggle="modal" data-target="#modalEditDeduction" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                return $result;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function add_deduction(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'deduction' => 'required|numeric',
            'fiscal_year' => 'required',
        ]);

        $fy = FiscalYear::where('year', $request->fiscal_year)
            ->get();
        $fy_id = $fy[0]->id;

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (Deduction::where('fiscal_year_id', $fy_id)->where('department_id', $request->department)->exists()) {
                return response()->json(['result' => 0]);
            } else {
                Deduction::insert([
                    'year' => $request->fiscal_year,
                    'deduction' => $request->deduction,
                    'fiscal_year_id' => $fy_id,
                    'department_id' => $request->department
                ]);

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
    }

    public function get_id_deduction(Request $request)
    {
        $deductions = Deduction::where('id', $request->deduction_id)->get();

        return response()->json(['d_value' => $deductions]);
    }

    public function edit_deduction(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'deduction' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            Deduction::where('id', $request->deduction_id)
                ->update([
                    'deduction' => $request->deduction,
                ]);

            return response()->json(['result' => 1]);
        }
    }

    public function deduction_summary(Request $request)
    {
        if ($request->fiscal_year != null) {
            $fy = FiscalYear::where('year', $request->fiscal_year)
                ->get();
            $fy_id = $fy[0]->id;
            $fy_year = $fy[0]->year;


            $current_fiscal_year = FiscalYear::where('year', $fy_year)
                ->get();
            $current_fy = $current_fiscal_year[0]->year;
            $current_fy_id = $current_fiscal_year[0]->id;

            $past_fy = FiscalYear::where('year', $fy_year - 1)
                ->get();
            $past_fy_id = $past_fy[0]->id;
            $past_fy_year = $past_fy[0]->year;


            if ($past_fy_year == null) {
                return response()->json(['result' => '<td colspan="7"  style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">No Data</td>']);
            } else {
                $get_departments = Department::where('name', '!=', 'TS')
                    ->where('name', '!=', 'CN')
                    ->where('name', '!=', 'YF')
                    ->where('name', '!=', 'PPS')
                    ->get();

                $counter = 0;
                $result = '';
                $array_current_fy_target = array();
                $array_current_fy_target_pcs = array();
                $array_deduction_quantity_to_ream_to_float = array();
                $array_deduction_quantity = array();
                $array_get_total_used_paper_last_fy_ream = array();
                
                for ($i = 0; $i < count($get_departments); $i++) {
                    $department = $get_departments[$i]->id;
                    $department_name = $get_departments[$i]->name;

                    $counter = $counter + 1;

                    $get_total_used_paper_last_fy = TotalUsedPaper::where('department_id', $department)
                        ->where('fiscal_year_id', $past_fy_id)
                        ->sum('quantity');

                    $get_deduction = Deduction::where('fiscal_year_id', $fy_id)
                        ->where('department_id', $department)
                        ->get();

                    $deduction = 0;
                    if(count($get_deduction) != 0) {
                        $deduction = $get_deduction[0]->deduction;
                    }

                    $deduction_percentage =  $deduction / 100;
                    $deduction_percentage_to_float = number_format((float)$deduction_percentage, 2, '.', '');

                    $deduction_quantity = $get_total_used_paper_last_fy * $deduction_percentage_to_float;
                    $array_deduction_quantity[] = $deduction_quantity;

                    $deduction_quantity_to_float = number_format((float)$deduction_quantity, 2, '.', '');
                    $deduction_quantity_to_ream = $deduction_quantity / 500;

                    $deduction_quantity_to_ream_to_float = number_format((float)$deduction_quantity_to_ream, 2, '.', '');
                    $array_deduction_quantity_to_ream_to_float[] = $deduction_quantity_to_ream_to_float;

                    $get_total_used_paper_last_fy_ream =  $get_total_used_paper_last_fy / 500;
                    $get_total_used_paper_last_fy_ream_to_float = number_format((float)$get_total_used_paper_last_fy_ream, 2, '.', '');
                    $array_get_total_used_paper_last_fy_ream[] = $get_total_used_paper_last_fy_ream;

                    $current_fy_target = $get_total_used_paper_last_fy - $deduction_quantity;
                    $current_fy_target_to_float = number_format((float)$current_fy_target, 2, '.', '');
                    $array_current_fy_target_pcs[] = $current_fy_target;

                    $current_fy_target_ream = $current_fy_target / 500;
                    $current_fy_target_ream_to_float = number_format((float)$current_fy_target_ream, 1, '.', '');
                    $array_current_fy_target[] = $current_fy_target_ream_to_float;
                    // dump($current_fy_target_ream_to_float);

                    $result .= '<tr>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . $department_name . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' .  $get_total_used_paper_last_fy . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)$get_total_used_paper_last_fy_ream, 2, '.', '') . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . $deduction_quantity . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)$deduction_quantity_to_ream_to_float, 2, '.', '')  . '</td>
                                <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . $current_fy_target  . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . $current_fy_target_ream_to_float . '</td>
                            </tr>
                            ';
                }

                // return $array_current_fy_target_pcs;

            //  return ;

                $get_total_used_paper_last_fy = TotalUsedPaper::where('fiscal_year_id', $past_fy_id)
                    ->sum('quantity');

                // return $get_total_used_paper_last_fy;

                $get_total_used_paper_last_fy_to_ream = $get_total_used_paper_last_fy / 500;


                $get_deduction = Deduction::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $department)
                    ->get();

                $deduction = 0;
                if(count($get_deduction) != 0) {
                    $deduction = $get_deduction[0]->deduction;   
                }

                $deduction_percentage =  $deduction / 100;
                $deduction_percentage_to_float = number_format((float)$deduction_percentage, 2, '.', '');

                $deduction_quantity = $get_total_used_paper_last_fy * $deduction_percentage_to_float;

                $deduction_quantity_to_ream = $deduction_quantity / 500;

                $current_fy_target = $get_total_used_paper_last_fy - $deduction_quantity;
                $current_fy_target_ream = $current_fy_target / 500;

                $result .= '<tr>
                        <td style="font-weight: bold; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">TOTAL</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)$get_total_used_paper_last_fy, 1, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)array_sum($array_get_total_used_paper_last_fy_ream), 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)array_sum($array_deduction_quantity), 1, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)array_sum($array_deduction_quantity_to_ream_to_float), 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black; background-color: #fff9c4;">' . number_format((float)array_sum($array_current_fy_target_pcs), 1, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . array_sum($array_current_fy_target) . '</td>
                        </tr>';
                return response()->json(['result' => $result]);
            }
        } else {
            $fy = FiscalYear::where('status', 0)
                ->get();
            $fy_id = $fy[0]->id;

            $current_fiscal_year = FiscalYear::where('status', 0)
                ->get();
            $current_fy = $current_fiscal_year[0]->year;
            $current_fy_id = $current_fiscal_year[0]->id;

            $past_fy = FiscalYear::where('year', $current_fy - 1)
                ->get();
            $past_fy_id = $past_fy[0]->id;
            $past_fy_year = $past_fy[0]->year;


            if ($past_fy_year == null) {
                return response()->json(['result' => '<td colspan="7"  style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">No Data</td>']);
            } else {
                $get_departments = Department::where('name', '!=', 'TS')
                    ->where('name', '!=', 'CN')
                    ->where('name', '!=', 'YF')
                    ->where('name', '!=', 'PPS')
                    ->get();

                $counter = 0;
                $result = '';
                $array_current_fy_target = array();
                $array_current_fy_target_pcs = array();
                $array_deduction_quantity_to_ream_to_float = array();
                $array_deduction_quantity = array();
                $array_get_total_used_paper_last_fy_ream = array();
                
                for ($i = 0; $i < count($get_departments); $i++) {
                    $department = $get_departments[$i]->id;
                    $department_name = $get_departments[$i]->name;

                    $counter = $counter + 1;

                    $get_total_used_paper_last_fy = TotalUsedPaper::where('department_id', $department)
                        ->where('fiscal_year_id', $past_fy_id)
                        ->sum('quantity');

                    $get_deduction = Deduction::where('fiscal_year_id', $fy_id)
                        ->where('department_id', $department)
                        ->get();

                    $deduction = 0;
                    if(count($get_deduction) != 0) {
                        $deduction = $get_deduction[0]->deduction;
                    }

                    $deduction_percentage =  $deduction / 100;
                    $deduction_percentage_to_float = number_format((float)$deduction_percentage, 2, '.', '');

                    $deduction_quantity = $get_total_used_paper_last_fy * $deduction_percentage_to_float;
                    $array_deduction_quantity[] = $deduction_quantity;

                    $deduction_quantity_to_float = number_format((float)$deduction_quantity, 2, '.', '');
                    $deduction_quantity_to_ream = $deduction_quantity / 500;

                    $deduction_quantity_to_ream_to_float = number_format((float)$deduction_quantity_to_ream, 2, '.', '');
                    $array_deduction_quantity_to_ream_to_float[] = $deduction_quantity_to_ream_to_float;

                    $get_total_used_paper_last_fy_ream =  $get_total_used_paper_last_fy / 500;
                    $get_total_used_paper_last_fy_ream_to_float = number_format((float)$get_total_used_paper_last_fy_ream, 2, '.', '');
                    $array_get_total_used_paper_last_fy_ream[] = $get_total_used_paper_last_fy_ream;

                    $current_fy_target = $get_total_used_paper_last_fy - $deduction_quantity;
                    $current_fy_target_to_float = number_format((float)$current_fy_target, 2, '.', '');
                    $array_current_fy_target_pcs[] = $current_fy_target;

                    $current_fy_target_ream = $current_fy_target / 500;
                    $current_fy_target_ream_to_float = number_format((float)$current_fy_target_ream, 1, '.', '');
                    $array_current_fy_target[] = $current_fy_target_ream_to_float;
                    // dump($current_fy_target_ream_to_float);

                    $result .= '<tr>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . $department_name . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' .  $get_total_used_paper_last_fy . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)$get_total_used_paper_last_fy_ream, 2, '.', '') . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . $deduction_quantity . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)$deduction_quantity_to_ream_to_float, 2, '.', '')  . '</td>
                                <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . $current_fy_target  . '</td>
                                <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . $current_fy_target_ream_to_float . '</td>
                            </tr>
                            ';
                }

                // return $array_current_fy_target_pcs;

            //  return ;

                $get_total_used_paper_last_fy = TotalUsedPaper::where('fiscal_year_id', $past_fy_id)
                    ->sum('quantity');

                // return $get_total_used_paper_last_fy;

                $get_total_used_paper_last_fy_to_ream = $get_total_used_paper_last_fy / 500;


                $get_deduction = Deduction::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $department)
                    ->get();

                $deduction = 0;
                if(count($get_deduction) != 0) {
                    $deduction = $get_deduction[0]->deduction;   
                }

                $deduction_percentage =  $deduction / 100;
                $deduction_percentage_to_float = number_format((float)$deduction_percentage, 2, '.', '');

                $deduction_quantity = $get_total_used_paper_last_fy * $deduction_percentage_to_float;

                $deduction_quantity_to_ream = $deduction_quantity / 500;

                $current_fy_target = $get_total_used_paper_last_fy - $deduction_quantity;
                $current_fy_target_ream = $current_fy_target / 500;

                $result .= '<tr>
                        <td style="font-weight: bold; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">TOTAL</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)$get_total_used_paper_last_fy, 1, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)array_sum($array_get_total_used_paper_last_fy_ream), 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)array_sum($array_deduction_quantity), 1, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . number_format((float)array_sum($array_deduction_quantity_to_ream_to_float), 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black; background-color: #fff9c4;">' . number_format((float)array_sum($array_current_fy_target_pcs), 1, '.', '') . '</td>
                        <td style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">' . array_sum($array_current_fy_target) . '</td>
                        </tr>';
                return response()->json(['result' => $result]);
            }
        }
    }
}
