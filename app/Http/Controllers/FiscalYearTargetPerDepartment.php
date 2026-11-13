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
use App\Paper;
use App\TotalUsedPerPaper;
use DataTables;

class FiscalYearTargetPerDepartment extends Controller
{
    public function get_all_target_papers(Request $request)
    {
        if ($request->fiscal_year != null) {
            $fy = FiscalYear::where('year', $request->fiscal_year)
                ->get();
            $fy_id = $fy[0]->id;

            $get_papers = Paper::all();

            $result = '';
            $counter = 0;
            for ($i = 0; $i < count($get_papers); $i++) {

                $counter = $counter + 1;
                $get_papers_id = $get_papers[$i]->id;
                $monthly_target_per_paper_bod = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 1)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_ias = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 2)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_fin = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 3)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_hrd = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 4)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_ess = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 5)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_log = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 6)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_fac = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 7)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_iss = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 8)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_qad = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 9)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_ems = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 10)
                    ->sum('data_monthly_target');

                $total_target = $monthly_target_per_paper_bod + $monthly_target_per_paper_ias + $monthly_target_per_paper_fin +
                    $monthly_target_per_paper_hrd + $monthly_target_per_paper_ess + $monthly_target_per_paper_log + $monthly_target_per_paper_fac + $monthly_target_per_paper_iss + $monthly_target_per_paper_qad + $monthly_target_per_paper_ems;

                $result .=
                    '<tr style=" border-top: 2px solid black; style="border-left: 2px solid black;">
                        <th style="background-color: white; border-right: 2px solid black; vertical-align : middle;text-align:center; border-left: 2px solid black;" rowspan = "2"><span>' . $get_papers[$i]->name . '</span></th>
                        <td style="border-left: 2px solid black; border-right: 2px solid black;">PCS</td> ';

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_bod . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_ias . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_fin . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_hrd . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_ess . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_log . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_fac . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_iss . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_qad . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_ems . '</td>';
                }

                $bod_total_ream = $monthly_target_per_paper_bod / 500;
                $ias_total_ream = $monthly_target_per_paper_ias / 500;
                $fin_total_ream = $monthly_target_per_paper_fin / 500;
                $hrd_total_ream = $monthly_target_per_paper_hrd / 500;
                $ess_total_ream = $monthly_target_per_paper_ess / 500;
                $log_total_ream = $monthly_target_per_paper_log / 500;
                $fac_total_ream = $monthly_target_per_paper_fac / 500;
                $iss_total_ream = $monthly_target_per_paper_iss / 500;
                $qad_total_ream = $monthly_target_per_paper_qad / 500;
                $ems_total_ream = $monthly_target_per_paper_ems / 500;

                $total_ream = $bod_total_ream + $ias_total_ream + $fin_total_ream + $hrd_total_ream + $ess_total_ream + $log_total_ream + $fac_total_ream + $iss_total_ream + $qad_total_ream + $ems_total_ream;

                $result .= '<td style="border-right: 2px solid black; border-left: 2px solid black;">' . $total_target . '</td></tr>
                    <tr style="border-left: 2px solid black; border-right: 2px solid black;";>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">REAM</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$bod_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$ias_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$fin_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$hrd_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$ess_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$log_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$fac_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$iss_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$qad_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$ems_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' .  number_format((float)$total_ream, 2, '.', '') . '</td>
                    </tr>';
            }

            $monthly_target_paper_bod = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 1)
                ->sum('data_monthly_target');
            $bod_ream = $monthly_target_paper_bod / 500;

            $monthly_target_paper_ias = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 2)
                ->sum('data_monthly_target');
            $ias_ream = $monthly_target_paper_ias / 500;

            $monthly_target_paper_fin = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 3)
                ->sum('data_monthly_target');
            $fin_ream = $monthly_target_paper_fin / 500;

            $monthly_target_paper_hrd = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 4)
                ->sum('data_monthly_target');
            $hrd_ream = $monthly_target_paper_hrd / 500;

            $monthly_target_paper_ess = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 5)
                ->sum('data_monthly_target');
            $ess_ream = $monthly_target_paper_ess / 500;

            $monthly_target_paper_log = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 6)
                ->sum('data_monthly_target');
            $log_ream = $monthly_target_paper_log / 500;

            $monthly_target_paper_fac = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 7)
                ->sum('data_monthly_target');
            $fac_ream = $monthly_target_paper_fac / 500;

            $monthly_target_paper_iss = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 8)
                ->sum('data_monthly_target');
            $iss_ream = $monthly_target_paper_iss / 500;

            $monthly_target_paper_qad = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 9)
                ->sum('data_monthly_target');
            $qad_ream = $monthly_target_paper_qad / 500;

            $monthly_target_paper_ems = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 10)
                ->sum('data_monthly_target');
            $ems_ream = $monthly_target_paper_ems / 500;

            $total_pcs = $monthly_target_paper_bod + $monthly_target_paper_ias + $monthly_target_paper_fin + $monthly_target_paper_hrd + $monthly_target_paper_ess + $monthly_target_paper_log + $monthly_target_paper_fac + $monthly_target_paper_iss + $monthly_target_paper_qad + $monthly_target_paper_ems;

            $total_ream = $bod_ream + $ias_ream + $fin_ream + $hrd_ream + $ess_ream + $log_ream + $fac_ream + $iss_ream + $qad_ream + $ems_ream;

            $result .= '<tr style=" border-top: 2px solid black; border-left: 2px solid black;">
                            <td style=" border-left: 2px solid black;"></td>
                            <td style=" border-right: 2px solid black;">TOTAL PCS</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_bod . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_ias . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_fin . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_hrd . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_ess . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_log . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_fac . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_iss . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_qad . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_ems . '</td>
                            <td style=" border-right: 2px solid black;">' . $total_pcs . '</td>
                    </tr>
                    <tr style="background-color: #fff9c4;  border-left: 2px solid black; border-bottom: 2px solid black;">
                        <td style="background-color: #fff9c4;"></td>
                        <td style=" border-right: 2px solid black; ">TOTAL REAM</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$bod_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$ias_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$fin_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$hrd_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$ess_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$log_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$fac_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$iss_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$qad_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$ems_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$total_ream, 2, '.', '') . '</td>
                    </tr>';

            return response()->json(['result' => $result]);
        } else {
            $fy = FiscalYear::where('status', 0)
                ->get();
            $fy_id = $fy[0]->id;

            $get_papers = Paper::all();

            $result = '';
            $counter = 0;
            for ($i = 0; $i < count($get_papers); $i++) {

                $counter = $counter + 1;
                $get_papers_id = $get_papers[$i]->id;
                $monthly_target_per_paper_bod = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 1)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_ias = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 2)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_fin = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 3)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_hrd = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 4)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_ess = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 5)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_log = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 6)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_fac = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 7)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_iss = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 8)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_qad = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 9)
                    ->sum('data_monthly_target');

                $monthly_target_per_paper_ems = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('paper_id', $get_papers_id)
                    ->where('department_id', 10)
                    ->sum('data_monthly_target');

                $total_target = $monthly_target_per_paper_bod + $monthly_target_per_paper_ias + $monthly_target_per_paper_fin +
                    $monthly_target_per_paper_hrd + $monthly_target_per_paper_ess + $monthly_target_per_paper_log + $monthly_target_per_paper_fac + $monthly_target_per_paper_iss + $monthly_target_per_paper_qad + $monthly_target_per_paper_ems;

                $result .=
                    '<tr style=" border-top: 2px solid black; style="border-left: 2px solid black;">
                        <th style="background-color: white; border-right: 2px solid black; vertical-align : middle;text-align:center; border-left: 2px solid black;" rowspan = "2"><span>' . $get_papers[$i]->name . '</span></th>
                        <td style="border-left: 2px solid black; border-right: 2px solid black;">PCS</td> ';

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_bod . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_ias . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_fin . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_hrd . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_ess . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_log . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_fac . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_iss . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_qad . '</td>';
                }

                if ($get_papers_id == $counter) {
                    $result .= '<td style="border-left: 2px solid black; border-right: 2px solid black;"> ' . $monthly_target_per_paper_ems . '</td>';
                }

                $bod_total_ream = $monthly_target_per_paper_bod / 500;
                $ias_total_ream = $monthly_target_per_paper_ias / 500;
                $fin_total_ream = $monthly_target_per_paper_fin / 500;
                $hrd_total_ream = $monthly_target_per_paper_hrd / 500;
                $ess_total_ream = $monthly_target_per_paper_ess / 500;
                $log_total_ream = $monthly_target_per_paper_log / 500;
                $fac_total_ream = $monthly_target_per_paper_fac / 500;
                $iss_total_ream = $monthly_target_per_paper_iss / 500;
                $qad_total_ream = $monthly_target_per_paper_qad / 500;
                $ems_total_ream = $monthly_target_per_paper_ems / 500;

                $total_ream = $bod_total_ream + $ias_total_ream + $fin_total_ream + $hrd_total_ream + $ess_total_ream + $log_total_ream + $fac_total_ream + $iss_total_ream + $qad_total_ream + $ems_total_ream;

                $result .= '<td style="border-right: 2px solid black; border-left: 2px solid black;">' . $total_target . '</td></tr>
                    <tr style="border-left: 2px solid black; border-right: 2px solid black;";>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">REAM</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$bod_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$ias_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$fin_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$hrd_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$ess_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$log_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$fac_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$iss_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$qad_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' . number_format((float)$ems_total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-left: 2px solid black; border-right: 2px solid black;">' .  number_format((float)$total_ream, 2, '.', '') . '</td>
                    </tr>';
            }

            $monthly_target_paper_bod = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 1)
                ->sum('data_monthly_target');
            $bod_ream = $monthly_target_paper_bod / 500;

            $monthly_target_paper_ias = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 2)
                ->sum('data_monthly_target');
            $ias_ream = $monthly_target_paper_ias / 500;

            $monthly_target_paper_fin = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 3)
                ->sum('data_monthly_target');
            $fin_ream = $monthly_target_paper_fin / 500;

            $monthly_target_paper_hrd = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 4)
                ->sum('data_monthly_target');
            $hrd_ream = $monthly_target_paper_hrd / 500;

            $monthly_target_paper_ess = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 5)
                ->sum('data_monthly_target');
            $ess_ream = $monthly_target_paper_ess / 500;

            $monthly_target_paper_log = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 6)
                ->sum('data_monthly_target');
            $log_ream = $monthly_target_paper_log / 500;

            $monthly_target_paper_fac = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 7)
                ->sum('data_monthly_target');
            $fac_ream = $monthly_target_paper_fac / 500;

            $monthly_target_paper_iss = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 8)
                ->sum('data_monthly_target');
            $iss_ream = $monthly_target_paper_iss / 500;

            $monthly_target_paper_qad = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 9)
                ->sum('data_monthly_target');
            $qad_ream = $monthly_target_paper_qad / 500;

            $monthly_target_paper_ems = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('department_id', 10)
                ->sum('data_monthly_target');
            $ems_ream = $monthly_target_paper_ems / 500;

            $total_pcs = $monthly_target_paper_bod + $monthly_target_paper_ias + $monthly_target_paper_fin + $monthly_target_paper_hrd + $monthly_target_paper_ess + $monthly_target_paper_log + $monthly_target_paper_fac + $monthly_target_paper_iss + $monthly_target_paper_qad + $monthly_target_paper_ems;

            $total_ream = $bod_ream + $ias_ream + $fin_ream + $hrd_ream + $ess_ream + $log_ream + $fac_ream + $iss_ream + $qad_ream + $ems_ream;

            $result .= '<tr style=" border-top: 2px solid black; border-left: 2px solid black;">
                            <td style=" border-left: 2px solid black;"></td>
                            <td style=" border-right: 2px solid black;">TOTAL PCS</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_bod . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_ias . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_fin . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_hrd . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_ess . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_log . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_fac . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_iss . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_qad . '</td>
                            <td style=" border-right: 2px solid black;">' . $monthly_target_paper_ems . '</td>
                            <td style=" border-right: 2px solid black;">' . $total_pcs . '</td>
                    </tr>
                    <tr style="background-color: #fff9c4;  border-left: 2px solid black; border-bottom: 2px solid black;">
                        <td style="background-color: #fff9c4;"></td>
                        <td style=" border-right: 2px solid black; ">TOTAL REAM</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$bod_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$ias_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$fin_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$hrd_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$ess_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$log_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$fac_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$iss_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$qad_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$ems_ream, 2, '.', '') . '</td>
                        <td style=" border-right: 2px solid black; ">' . number_format((float)$total_ream, 2, '.', '') . '</td>
                    </tr>';

            return response()->json(['result' => $result]);
        }
    }

    public function get_fy_for_overall_target()
    {
        //===== GET ALL FISCAL YEAR FROM FISCAL YEARS TABLE FOR FILTERING PURPOSE =====//
        $result = FiscalYear::where('year', '!=', '2020')
            ->where('status', '!=', '0')
            ->get();

        $active_fy = FiscalYear::where('status', 0)->get();
        $fy_active = $active_fy[0]->year;

        $all_fy = '';
        $all_fy .= "<option value=" . $fy_active . ">" . $fy_active . "</option>";

        for ($i = 0; $i < count($result); $i++) {
            $fy = $result[$i]->year;

            $all_fy .= "<option value=" . $fy . ">" . $fy . "</option>";
        }

        return response()->json(['fiscal' => $all_fy]);
        //===== GET ALL FISCAL YEAR FROM FISCAL YEARS TABLE FOR FILTERING PURPOSE END =====//
    }
}
