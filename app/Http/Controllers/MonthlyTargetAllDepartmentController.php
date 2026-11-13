<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FiscalYear;
use App\Department;
use App\MonthlyTarget;


class MonthlyTargetAllDepartmentController extends Controller
{
    public function get_monthly_target_all_dept(Request $request)
    {
        if ($request->fiscal_year != null) {
            $fy = FiscalYear::where('year', $request->fiscal_year)
                ->get();
            $fy_id = $fy[0]->id;

            $get_departments = Department::where('name', '!=', 'TS')
                ->where('name', '!=', 'CN')
                ->where('name', '!=', 'YF')
                ->where('name', '!=', 'PPS')
                ->get();

                // return $get_departments;
            $result = '';
            $counter = 0;
            for ($i = 0; $i < count($get_departments); $i++) {
                $get_department_id = $get_departments[$i]->id;
                $counter = $counter + 1;

                $result .=
                    '<tr style=" border-top: 2px solid black; border-right: 2px solid black; ">
                        <th width="7%" style="background-color: white; vertical-align : middle;text-align:center; border-right: 2px solid black; border-left: 2px solid black;" rowspan = "2"><span>' . $get_departments[$i]->name . '</span></th>
                        <td width="10%" style="border-right: 2px solid black; border-left: 2px solid black; ">PCS</td> ';

                //===== GET PAPER TARGET PER MONTH =====//
                $monthly_target_per_month_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_total = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');
                //===== GET PAPER TARGET PER MONTH END =====//

                $monthly_target_per_month_april_ream = $monthly_target_per_month_april / 500;
                $monthly_target_per_month_may_ream = $monthly_target_per_month_may / 500;
                $monthly_target_per_month_june_ream = $monthly_target_per_month_june / 500;
                $monthly_target_per_month_july_ream = $monthly_target_per_month_july / 500;
                $monthly_target_per_month_august_ream = $monthly_target_per_month_august / 500;
                $monthly_target_per_month_september_ream = $monthly_target_per_month_september / 500;
                $monthly_target_per_month_october_ream = $monthly_target_per_month_october / 500;
                $monthly_target_per_month_november_ream = $monthly_target_per_month_november / 500;
                $monthly_target_per_month_december_ream = $monthly_target_per_month_december / 500;
                $monthly_target_per_month_january_ream = $monthly_target_per_month_january / 500;
                $monthly_target_per_month_february_ream = $monthly_target_per_month_february / 500;
                $monthly_target_per_month_march_ream = $monthly_target_per_month_march / 500;

                $total_ream = $monthly_target_per_month_april_ream + $monthly_target_per_month_may_ream + $monthly_target_per_month_june_ream + $monthly_target_per_month_july_ream + $monthly_target_per_month_august_ream + $monthly_target_per_month_september_ream + $monthly_target_per_month_october_ream + $monthly_target_per_month_november_ream + $monthly_target_per_month_december_ream + $monthly_target_per_month_january_ream + $monthly_target_per_month_february_ream + $monthly_target_per_month_march_ream;

                //===== DISPLAY MONTHLY TARGET =====//
                if ($get_department_id == $counter) {

                    if ($monthly_target_per_month_april == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_april . '</td>';
                    }

                    if ($monthly_target_per_month_may == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_may . '</td>';
                    }

                    if ($monthly_target_per_month_june == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_june . '</td>';
                    }

                    if ($monthly_target_per_month_july == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_july . '</td>';
                    }

                    if ($monthly_target_per_month_august == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_august . '</td>';
                    }

                    if ($monthly_target_per_month_september  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_september  . '</td>';
                    }

                    if ($monthly_target_per_month_october  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_october  . '</td>';
                    }

                    if ($monthly_target_per_month_november  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_november  . '</td>';
                    }

                    if ($monthly_target_per_month_december  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_december  . '</td>';
                    }

                    if ($monthly_target_per_month_january  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_january  . '</td>';
                    }

                    if ($monthly_target_per_month_february == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_february  . '</td>';
                    }

                    if ($monthly_target_per_month_march  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_march  . '</td>';
                    }

                    $result .= '<td width="7%">' . $monthly_target_total . '</td></tr>';

                    $result .= ' <tr>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">REAM</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_april_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_may_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_june_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_july_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_august_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_september_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_october_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_november_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_december_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_january_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_february_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_march_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$total_ream, 2, '.', '') . '</td>
                    </tr>';
                }
                //  <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$total_ream, 2, '.', '') . '</td>
                //===== DISPLAY MONTHLY TARGET END =====//
            }

            $total_monthly_target_per_month_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'April')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'May')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'June')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'July')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'August')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'September')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'October')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'November')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'December')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'January')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'February')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'March')
                ->sum('data_monthly_target');


            $total_monthly_target_per_month =  $total_monthly_target_per_month_april + $total_monthly_target_per_month_may + $total_monthly_target_per_month_june + $total_monthly_target_per_month_july + $total_monthly_target_per_month_august + $total_monthly_target_per_month_september + $total_monthly_target_per_month_october + $total_monthly_target_per_month_november + $total_monthly_target_per_month_december + $total_monthly_target_per_month_january + $total_monthly_target_per_month_february + $total_monthly_target_per_month_march;


            $total_ream_april = $total_monthly_target_per_month_april / 500;
            $total_ream_may = $total_monthly_target_per_month_may / 500;
            $total_ream_june = $total_monthly_target_per_month_june / 500;
            $total_ream_july = $total_monthly_target_per_month_july / 500;
            $total_ream_august = $total_monthly_target_per_month_august / 500;
            $total_ream_september = $total_monthly_target_per_month_september / 500;
            $total_ream_october = $total_monthly_target_per_month_october / 500;
            $total_ream_november = $total_monthly_target_per_month_november / 500;
            $total_ream_december = $total_monthly_target_per_month_december / 500;
            $total_ream_january = $total_monthly_target_per_month_january / 500;
            $total_ream_february = $total_monthly_target_per_month_february / 500;
            $total_ream_march = $total_monthly_target_per_month_march / 500;

            $total_ream_overall = $total_ream_april + $total_ream_may + $total_ream_june + $total_ream_july + $total_ream_august + $total_ream_september + $total_ream_october + $total_ream_november + $total_ream_december + $total_ream_january + $total_ream_february + $total_ream_march;

            $total_ream_overall =   number_format((float)$total_ream_april, 2, '.', '') +
            number_format((float)$total_ream_may, 2, '.', '') + 
            number_format((float)$total_ream_june, 2, '.', '') + 
            number_format((float)$total_ream_july, 2, '.', '') + 
            number_format((float)$total_ream_august, 2, '.', '') + 
            number_format((float)$total_ream_september, 2, '.', '') + 
            number_format((float)$total_ream_october, 2, '.', '') + 
            number_format((float)$total_ream_november, 2, '.', '') + 
            number_format((float)$total_ream_december, 2, '.', '') + 
            number_format((float)$total_ream_january, 2, '.', '') +
            number_format((float)$total_ream_february, 2, '.', '') +
            number_format((float)$total_ream_march, 2, '.', '');

            $result .= '<tr style=" border-left: 2px solid black; border-top: 2px solid black; border-right: 2px solid black;">
                            <td style="border-left: 2px solid black;"></td>
                            <td style="border-right: 2px solid black;">TOTAL PCS</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_april . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_may . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_june . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_july . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_august . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_september . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_october . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_november . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_december . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_january . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_february . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_march . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month . '</td>
                    </tr>
                    <tr style="background-color: #fff9c4; border-bottom: 2px solid black; border-right: 2px solid black;">
                        <td style="border-left: 2px solid black;"></td>
                        <td style="border-right: 2px solid black;">TOTAL REAM</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_april, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_may, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_june, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_july, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_august, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_september, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_october, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_november, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_december, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_january, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_february, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_march, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_overall, 2, '.', '') . '</td>
                    </tr>';

            return response()->json(['result' => $result]);
        } else {
            $fy = FiscalYear::where('status', 0)
                ->get();

            $fy_id = $fy[0]->id;

            $get_departments = Department::where('name', '!=', 'TS')
                ->where('name', '!=', 'CN')
                ->where('name', '!=', 'YF')
                ->where('name', '!=', 'PPS')
                ->get();

            $result = '';
            $counter = 0;
            for ($i = 0; $i < count($get_departments); $i++) {
                $get_department_id = $get_departments[$i]->id;
                $counter = $counter + 1;

                $result .=
                    '<tr style=" border-top: 2px solid black; border-right: 2px solid black; ">
                        <th width="7%" style="background-color: white; vertical-align : middle;text-align:center; border-right: 2px solid black; border-left: 2px solid black;" rowspan = "2"><span>' . $get_departments[$i]->name . '</span></th>
                        <td width="10%" style="border-right: 2px solid black; border-left: 2px solid black; ">PCS</td> ';

                //===== GET PAPER TARGET PER MONTH =====//
                $monthly_target_per_month_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_per_month_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_total = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');
                //===== GET PAPER TARGET PER MONTH END =====//

                $monthly_target_per_month_april_ream = $monthly_target_per_month_april / 500;
                $monthly_target_per_month_may_ream = $monthly_target_per_month_may / 500;
                $monthly_target_per_month_june_ream = $monthly_target_per_month_june / 500;
                $monthly_target_per_month_july_ream = $monthly_target_per_month_july / 500;
                $monthly_target_per_month_august_ream = $monthly_target_per_month_august / 500;
                $monthly_target_per_month_september_ream = $monthly_target_per_month_september / 500;
                $monthly_target_per_month_october_ream = $monthly_target_per_month_october / 500;
                $monthly_target_per_month_november_ream = $monthly_target_per_month_november / 500;
                $monthly_target_per_month_december_ream = $monthly_target_per_month_december / 500;
                $monthly_target_per_month_january_ream = $monthly_target_per_month_january / 500;
                $monthly_target_per_month_february_ream = $monthly_target_per_month_february / 500;
                $monthly_target_per_month_march_ream = $monthly_target_per_month_march / 500;

                $total_ream = $monthly_target_per_month_april_ream + $monthly_target_per_month_may_ream + $monthly_target_per_month_june_ream + $monthly_target_per_month_july_ream + $monthly_target_per_month_august_ream + $monthly_target_per_month_september_ream + $monthly_target_per_month_october_ream + $monthly_target_per_month_november_ream + $monthly_target_per_month_december_ream + $monthly_target_per_month_january_ream + $monthly_target_per_month_february_ream + $monthly_target_per_month_march_ream;

                //===== DISPLAY MONTHLY TARGET =====//
                if ($get_department_id == $counter) {

                    if ($monthly_target_per_month_april == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_april . '</td>';
                    }

                    if ($monthly_target_per_month_may == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_may . '</td>';
                    }

                    if ($monthly_target_per_month_june == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_june . '</td>';
                    }

                    if ($monthly_target_per_month_july == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_july . '</td>';
                    }

                    if ($monthly_target_per_month_august == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_august . '</td>';
                    }

                    if ($monthly_target_per_month_september  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_september  . '</td>';
                    }

                    if ($monthly_target_per_month_october  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_october  . '</td>';
                    }

                    if ($monthly_target_per_month_november  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_november  . '</td>';
                    }

                    if ($monthly_target_per_month_december  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_december  . '</td>';
                    }

                    if ($monthly_target_per_month_january  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_january  . '</td>';
                    }

                    if ($monthly_target_per_month_february == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_february  . '</td>';
                    }

                    if ($monthly_target_per_month_march  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $monthly_target_per_month_march  . '</td>';
                    }

                    $result .= '<td width="7%">' . $monthly_target_total . '</td></tr>';

                    $result .= ' <tr>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">REAM</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_april_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_may_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_june_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_july_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_august_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_september_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_october_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_november_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_december_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_january_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_february_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$monthly_target_per_month_march_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$total_ream, 2, '.', '') . '</td>
                    </tr>';
                }
                //  <td style="background-color: #fff9c4; border-right: 2px solid black; border-left: 2px solid black;">' . number_format((float)$total_ream, 2, '.', '') . '</td>
                //===== DISPLAY MONTHLY TARGET END =====//
            }

            $total_monthly_target_per_month_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'April')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'May')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'June')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'July')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'August')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'September')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'October')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'November')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'December')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'January')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'February')
                ->sum('data_monthly_target');

            $total_monthly_target_per_month_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'March')
                ->sum('data_monthly_target');


            $total_monthly_target_per_month =  $total_monthly_target_per_month_april + $total_monthly_target_per_month_may + $total_monthly_target_per_month_june + $total_monthly_target_per_month_july + $total_monthly_target_per_month_august + $total_monthly_target_per_month_september + $total_monthly_target_per_month_october + $total_monthly_target_per_month_november + $total_monthly_target_per_month_december + $total_monthly_target_per_month_january + $total_monthly_target_per_month_february + $total_monthly_target_per_month_march;


            $total_ream_april = $total_monthly_target_per_month_april / 500;
            $total_ream_may = $total_monthly_target_per_month_may / 500;
            $total_ream_june = $total_monthly_target_per_month_june / 500;
            $total_ream_july = $total_monthly_target_per_month_july / 500;
            $total_ream_august = $total_monthly_target_per_month_august / 500;
            $total_ream_september = $total_monthly_target_per_month_september / 500;
            $total_ream_october = $total_monthly_target_per_month_october / 500;
            $total_ream_november = $total_monthly_target_per_month_november / 500;
            $total_ream_december = $total_monthly_target_per_month_december / 500;
            $total_ream_january = $total_monthly_target_per_month_january / 500;
            $total_ream_february = $total_monthly_target_per_month_february / 500;
            $total_ream_march = $total_monthly_target_per_month_march / 500;

            $total_ream_overall = $total_ream_april + $total_ream_may + $total_ream_june + $total_ream_july + $total_ream_august + $total_ream_september + $total_ream_october + $total_ream_november + $total_ream_december + $total_ream_january + $total_ream_february + $total_ream_march;

         $total_ream_overall =   number_format((float)$total_ream_april, 2, '.', '') +
            number_format((float)$total_ream_may, 2, '.', '') + 
            number_format((float)$total_ream_june, 2, '.', '') + 
            number_format((float)$total_ream_july, 2, '.', '') + 
            number_format((float)$total_ream_august, 2, '.', '') + 
            number_format((float)$total_ream_september, 2, '.', '') + 
            number_format((float)$total_ream_october, 2, '.', '') + 
            number_format((float)$total_ream_november, 2, '.', '') + 
            number_format((float)$total_ream_december, 2, '.', '') + 
            number_format((float)$total_ream_january, 2, '.', '') +
            number_format((float)$total_ream_february, 2, '.', '') +
            number_format((float)$total_ream_march, 2, '.', '');


            $result .= '<tr style=" border-left: 2px solid black; border-top: 2px solid black; border-right: 2px solid black;">
                            <td style="border-left: 2px solid black;"></td>
                            <td style="border-right: 2px solid black;">TOTAL PCS</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_april . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_may . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_june . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_july . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_august . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_september . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_october . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_november . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_december . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_january . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_february . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month_march . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month . '</td>
                    </tr>
                    <tr style="background-color: #fff9c4; border-bottom: 2px solid black; border-right: 2px solid black;">
                        <td style="border-left: 2px solid black;"></td>
                        <td style="border-right: 2px solid black;">TOTAL REAM</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_april, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_may, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_june, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_july, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_august, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_september, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_october, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_november, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_december, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_january, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_february, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_march, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_overall, 2, '.', '') . '</td>
                    </tr>';
                    // <td style="border-right: 2px solid black;">' . number_format((float)$total_ream_overall, 2, '.', '') . '</td>
                    // 
            return response()->json(['result' => $result]);
        }
    }
}
