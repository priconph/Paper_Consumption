<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TotalUsedPaper;
use App\FiscalYear;
use App\Department;
use App\MonthlyTarget;

class ActualConsumptionController extends Controller
{
    public function get_actual_consumption(Request $request)
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

            $result = '';
            $counter = 0;
            for ($i = 0; $i < count($get_departments); $i++) {
                $get_department_id = $get_departments[$i]->id;
                $counter = $counter + 1;

                $result .=
                    '<tr style="border-top: 2px solid black; border-left: 2px solid black; border-right: 2px solid black;">
                        <th width="7%" style="background-color: white; vertical-align : middle; text-align:center; border-left: 2px solid black; border-right: 2px solid black;" rowspan = "2"><span>' . $get_departments[$i]->name . '</span></th>
                        <td width="10%" style="border-right: 2px solid black;">PCS</td> ';

                //===== GET PAPER CONSUMPTION PER MONTH =====//
                $actual_consumption_per_month_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_total = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');
                //===== GET PAPER CONSUMPTION PER MONTH END =====//

                //===== GET TOTAL TARGET PER DEPARTMENT =====//
                $monthly_target_total = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');
                //===== GET TOTAL TARGET PER DEPARTMENT END =====//

                $monthly_target_ream = $monthly_target_total / 500;
                $difference_target_subtract_actual_total = $monthly_target_total - $actual_consumption_total;
                $difference_target_subtract_actual_total_ream = $difference_target_subtract_actual_total / 500;

                //===== GET REAM PER DEPARTMENT =====//
                $actual_consumption_per_month_april_ream = $actual_consumption_per_month_april / 500;
                $actual_consumption_per_month_may_ream = $actual_consumption_per_month_may / 500;
                $actual_consumption_per_month_june_ream = $actual_consumption_per_month_june / 500;
                $actual_consumption_per_month_july_ream = $actual_consumption_per_month_july / 500;
                $actual_consumption_per_month_august_ream = $actual_consumption_per_month_august / 500;
                $actual_consumption_per_month_september_ream = $actual_consumption_per_month_september / 500;
                $actual_consumption_per_month_october_ream = $actual_consumption_per_month_october / 500;
                $actual_consumption_per_month_november_ream = $actual_consumption_per_month_november / 500;
                $actual_consumption_per_month_december_ream = $actual_consumption_per_month_december / 500;
                $actual_consumption_per_month_january_ream = $actual_consumption_per_month_january / 500;
                $actual_consumption_per_month_february_ream = $actual_consumption_per_month_february / 500;
                $actual_consumption_per_month_march_ream = $actual_consumption_per_month_march / 500;

                $total_ream = $actual_consumption_per_month_april_ream + $actual_consumption_per_month_may_ream + $actual_consumption_per_month_june_ream + $actual_consumption_per_month_july_ream + $actual_consumption_per_month_august_ream + $actual_consumption_per_month_september_ream + $actual_consumption_per_month_october_ream + $actual_consumption_per_month_november_ream + $actual_consumption_per_month_december_ream + $actual_consumption_per_month_january_ream + $actual_consumption_per_month_february_ream + $actual_consumption_per_month_march_ream;
                //===== GET REAM PER DEPARTMENT END =====//

                //===== DISPLAY ACTUAL CONSUMPTION =====//
                if ($get_department_id == $counter) {

                    if ($actual_consumption_per_month_april == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_april . '</td>';
                    }

                    if ($actual_consumption_per_month_may == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_may . '</td>';
                    }

                    if ($actual_consumption_per_month_june == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_june . '</td>';
                    }

                    if ($actual_consumption_per_month_july == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_july . '</td>';
                    }

                    if ($actual_consumption_per_month_august == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_august . '</td>';
                    }

                    if ($actual_consumption_per_month_september  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_september  . '</td>';
                    }

                    if ($actual_consumption_per_month_october  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_october  . '</td>';
                    }

                    if ($actual_consumption_per_month_november  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_november  . '</td>';
                    }

                    if ($actual_consumption_per_month_december  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_december  . '</td>';
                    }

                    if ($actual_consumption_per_month_january  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_january  . '</td>';
                    }

                    if ($actual_consumption_per_month_february == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_february  . '</td>';
                    }

                    if ($actual_consumption_per_month_march  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_march  . '</td>';
                    }

                    $result .= '<td width="7%" style="border-right: 2px solid black;">' . $actual_consumption_total . '</td>';
                    $result .= '<td width="7%" style="border-right: 2px solid black;">' . $monthly_target_total . '</td>';
                    if ($difference_target_subtract_actual_total < 0) {
                        $result .= '<td width="7%" style="font-weight: bold; color: red; border-right: 2px solid black;">' . $difference_target_subtract_actual_total . '</td></tr>';
                    } else {
                        $result .= '<td width="7%" style="font-weight: bold; color: green; border-right: 2px solid black;">' . $difference_target_subtract_actual_total . '</td></tr>';
                    }

                    $result .= ' <tr>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">REAM</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_april_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_may_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_june_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_july_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_august_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_september_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_october_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_november_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_december_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_january_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_february_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_march_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$monthly_target_ream, 2, '.', '') . '</td>';
                    if ($difference_target_subtract_actual_total_ream < 0) {
                        $result .= '
                         <td style="background-color: #fff9c4; font-weight: bold; color: red; border-right: 2px solid black;">' . number_format((float)$difference_target_subtract_actual_total_ream, 2, '.', '') . '</td>

                    </tr>';
                    } else {
                        $result .= '
                         <td style="background-color: #fff9c4; font-weight: bold; color: green; border-right: 2px solid black;">' . number_format((float)$difference_target_subtract_actual_total_ream, 2, '.', '') . '</td>

                    </tr>';
                    }
                }
                //===== DISPLAY ACTUAL CONSUMPTION END =====//
            }

            //===== TOTAL ACTUAL CONSUMPTION =====//
            $total_actual_consumption_per_month_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'April')
                ->sum('quantity');

            $total_actual_consumption_per_month_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'May')
                ->sum('quantity');

            $total_actual_consumption_per_month_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'June')
                ->sum('quantity');

            $total_actual_consumption_per_month_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'July')
                ->sum('quantity');

            $total_actual_consumption_per_month_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'August')
                ->sum('quantity');

            $total_actual_consumption_per_month_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'September')
                ->sum('quantity');

            $total_actual_consumption_per_month_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'October')
                ->sum('quantity');

            $total_actual_consumption_per_month_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'November')
                ->sum('quantity');

            $total_actual_consumption_per_month_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'December')
                ->sum('quantity');

            $total_actual_consumption_per_month_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'January')
                ->sum('quantity');

            $total_actual_consumption_per_month_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'February')
                ->sum('quantity');

            $total_actual_consumption_per_month_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'March')
                ->sum('quantity');
            //===== TOTAL ACTUAL CONSUMPTION END =====//

            //===== TOTAL MONTHLY TARGET =====//
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
            //===== TOTAL MONTHLY TARGET END =====//

            //===== COMPUTE TOTAL MONTHLY TARGET =====//
            $total_monthly_target_per_month =  $total_monthly_target_per_month_april + $total_monthly_target_per_month_may + $total_monthly_target_per_month_june + $total_monthly_target_per_month_july + $total_monthly_target_per_month_august + $total_monthly_target_per_month_september + $total_monthly_target_per_month_october + $total_monthly_target_per_month_november + $total_monthly_target_per_month_december + $total_monthly_target_per_month_january + $total_monthly_target_per_month_february + $total_monthly_target_per_month_march;

            $total_monthly_target_ream = $total_monthly_target_per_month / 500;
            //===== COMPUTE TOTAL MONTHLY TARGET END =====//

            //===== COMPUTE TOTAL ACTUAL CONSUMPTION =====//
            $total_actual_consumption_per_month =  $total_actual_consumption_per_month_april + $total_actual_consumption_per_month_may + $total_actual_consumption_per_month_june + $total_actual_consumption_per_month_july + $total_actual_consumption_per_month_august + $total_actual_consumption_per_month_september + $total_actual_consumption_per_month_october + $total_actual_consumption_per_month_november + $total_actual_consumption_per_month_december + $total_actual_consumption_per_month_january + $total_actual_consumption_per_month_february + $total_actual_consumption_per_month_march;
            //===== COMPUTE TOTAL ACTUAL CONSUMPTION END =====//
            $difference_target_to_actual = $total_monthly_target_per_month - $total_actual_consumption_per_month;
            $difference_target_to_actual_ream = $difference_target_to_actual / 500;

            //===== GET TOTAL REAM FROM ACTUAL CONSUMPTION =====//
            $total_ream_april = $total_actual_consumption_per_month_april / 500;
            $total_ream_may = $total_actual_consumption_per_month_may / 500;
            $total_ream_june = $total_actual_consumption_per_month_june / 500;
            $total_ream_july = $total_actual_consumption_per_month_july / 500;
            $total_ream_august = $total_actual_consumption_per_month_august / 500;
            $total_ream_september = $total_actual_consumption_per_month_september / 500;
            $total_ream_october = $total_actual_consumption_per_month_october / 500;
            $total_ream_november = $total_actual_consumption_per_month_november / 500;
            $total_ream_december = $total_actual_consumption_per_month_december / 500;
            $total_ream_january = $total_actual_consumption_per_month_january / 500;
            $total_ream_february = $total_actual_consumption_per_month_february / 500;
            $total_ream_march = $total_actual_consumption_per_month_march / 500;

            $total_ream_overall = $total_ream_april + $total_ream_may + $total_ream_june + $total_ream_july + $total_ream_august + $total_ream_september + $total_ream_october + $total_ream_november + $total_ream_december + $total_ream_january + $total_ream_february + $total_ream_march;
            //===== GET TOTAL REAM FROM ACTUAL CONSUMPTION END =====//

            $result .= '<tr style=" border-top: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                            <td style="border-left: 2px solid black;"></td>
                            <td style="border-right: 2px solid black;">TOTAL PCS</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_april . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_may . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_june . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_july . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_august . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_september . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_october . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_november . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_december . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_january . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_february . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_march . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month . '</td>';
            if ($difference_target_to_actual <  0) {
                $result .= '<td style="color: red; font-weight:bold;">' . $difference_target_to_actual . '</td>';
            } else {
                $result .= '<td style="color: green; font-weight:bold;">' . $difference_target_to_actual . '</td>';
            }

            $result .= '
                    </tr>
                    <tr style="background-color: #fff9c4; border-bottom: 2px solid black;">
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
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_monthly_target_ream, 2, '.', '') . '</td>';
            if ($difference_target_to_actual_ream < 0) {
                $result .= '<td style="color: red; font-weight:bold; border-right: 2px solid black;">' . number_format((float)$difference_target_to_actual_ream, 2, '.', '') . '</td>
                    </tr>';
            } else {
                $result .= '<td style="color: green; font-weight:bold; border-right: 2px solid black;">' . number_format((float)$difference_target_to_actual_ream, 2, '.', '') . '</td>
                    </tr>';
            }
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
                    '<tr style="border-top: 2px solid black; border-left: 2px solid black; border-right: 2px solid black;">
                        <th width="7%" style="background-color: white; vertical-align : middle; text-align:center; border-left: 2px solid black; border-right: 2px solid black;" rowspan = "2"><span>' . $get_departments[$i]->name . '</span></th>
                        <td width="10%" style="border-right: 2px solid black;">PCS</td> ';

                //===== GET PAPER CONSUMPTION PER MONTH =====//
                $actual_consumption_per_month_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_per_month_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $actual_consumption_total = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');
                //===== GET PAPER CONSUMPTION PER MONTH END =====//

                //===== GET TOTAL TARGET PER DEPARTMENT =====//
                $monthly_target_total = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');
                //===== GET TOTAL TARGET PER DEPARTMENT END =====//

                $monthly_target_ream = $monthly_target_total / 500;
                $difference_target_subtract_actual_total = $monthly_target_total - $actual_consumption_total;
                $difference_target_subtract_actual_total_ream = $difference_target_subtract_actual_total / 500;

                //===== GET REAM PER DEPARTMENT =====//
                $actual_consumption_per_month_april_ream = $actual_consumption_per_month_april / 500;
                $actual_consumption_per_month_may_ream = $actual_consumption_per_month_may / 500;
                $actual_consumption_per_month_june_ream = $actual_consumption_per_month_june / 500;
                $actual_consumption_per_month_july_ream = $actual_consumption_per_month_july / 500;
                $actual_consumption_per_month_august_ream = $actual_consumption_per_month_august / 500;
                $actual_consumption_per_month_september_ream = $actual_consumption_per_month_september / 500;
                $actual_consumption_per_month_october_ream = $actual_consumption_per_month_october / 500;
                $actual_consumption_per_month_november_ream = $actual_consumption_per_month_november / 500;
                $actual_consumption_per_month_december_ream = $actual_consumption_per_month_december / 500;
                $actual_consumption_per_month_january_ream = $actual_consumption_per_month_january / 500;
                $actual_consumption_per_month_february_ream = $actual_consumption_per_month_february / 500;
                $actual_consumption_per_month_march_ream = $actual_consumption_per_month_march / 500;

                $total_ream = $actual_consumption_per_month_april_ream + $actual_consumption_per_month_may_ream + $actual_consumption_per_month_june_ream + $actual_consumption_per_month_july_ream + $actual_consumption_per_month_august_ream + $actual_consumption_per_month_september_ream + $actual_consumption_per_month_october_ream + $actual_consumption_per_month_november_ream + $actual_consumption_per_month_december_ream + $actual_consumption_per_month_january_ream + $actual_consumption_per_month_february_ream + $actual_consumption_per_month_march_ream;
                //===== GET REAM PER DEPARTMENT END =====//

                //===== DISPLAY ACTUAL CONSUMPTION =====//
                if ($get_department_id == $counter) {

                    if ($actual_consumption_per_month_april == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_april . '</td>';
                    }

                    if ($actual_consumption_per_month_may == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_may . '</td>';
                    }

                    if ($actual_consumption_per_month_june == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_june . '</td>';
                    }

                    if ($actual_consumption_per_month_july == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_july . '</td>';
                    }

                    if ($actual_consumption_per_month_august == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_august . '</td>';
                    }

                    if ($actual_consumption_per_month_september  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_september  . '</td>';
                    }

                    if ($actual_consumption_per_month_october  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_october  . '</td>';
                    }

                    if ($actual_consumption_per_month_november  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_november  . '</td>';
                    }

                    if ($actual_consumption_per_month_december  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_december  . '</td>';
                    }

                    if ($actual_consumption_per_month_january  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_january  . '</td>';
                    }

                    if ($actual_consumption_per_month_february == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_february  . '</td>';
                    }

                    if ($actual_consumption_per_month_march  == null) {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">0</td>';
                    } else {
                        $result .= '<td width="5%" style="border-right: 2px solid black;">' . $actual_consumption_per_month_march  . '</td>';
                    }

                    $result .= '<td width="7%" style="border-right: 2px solid black;">' . $actual_consumption_total . '</td>';
                    $result .= '<td width="7%" style="border-right: 2px solid black;">' . $monthly_target_total . '</td>';
                    if ($difference_target_subtract_actual_total < 0) {
                        $result .= '<td width="7%" style="font-weight: bold; color: red; border-right: 2px solid black;">' . $difference_target_subtract_actual_total . '</td></tr>';
                    } else {
                        $result .= '<td width="7%" style="font-weight: bold; color: green; border-right: 2px solid black;">' . $difference_target_subtract_actual_total . '</td></tr>';
                    }

                    $result .= ' <tr>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">REAM</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_april_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_may_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_june_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_july_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_august_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_september_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_october_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_november_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_december_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_january_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_february_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$actual_consumption_per_month_march_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$total_ream, 2, '.', '') . '</td>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$monthly_target_ream, 2, '.', '') . '</td>';
                    if ($difference_target_subtract_actual_total_ream < 0) {
                        $result .= '
                         <td style="background-color: #fff9c4; font-weight: bold; color: red; border-right: 2px solid black;">' . number_format((float)$difference_target_subtract_actual_total_ream, 2, '.', '') . '</td>

                    </tr>';
                    } else {
                        $result .= '
                         <td style="background-color: #fff9c4; font-weight: bold; color: green; border-right: 2px solid black;">' . number_format((float)$difference_target_subtract_actual_total_ream, 2, '.', '') . '</td>

                    </tr>';
                    }
                }
                //===== DISPLAY ACTUAL CONSUMPTION END =====//
            }

            //===== TOTAL ACTUAL CONSUMPTION =====//
            $total_actual_consumption_per_month_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'April')
                ->sum('quantity');

            $total_actual_consumption_per_month_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'May')
                ->sum('quantity');

            $total_actual_consumption_per_month_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'June')
                ->sum('quantity');

            $total_actual_consumption_per_month_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'July')
                ->sum('quantity');

            $total_actual_consumption_per_month_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'August')
                ->sum('quantity');

            $total_actual_consumption_per_month_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'September')
                ->sum('quantity');

            $total_actual_consumption_per_month_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'October')
                ->sum('quantity');

            $total_actual_consumption_per_month_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'November')
                ->sum('quantity');

            $total_actual_consumption_per_month_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'December')
                ->sum('quantity');

            $total_actual_consumption_per_month_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'January')
                ->sum('quantity');

            $total_actual_consumption_per_month_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'February')
                ->sum('quantity');

            $total_actual_consumption_per_month_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'March')
                ->sum('quantity');
            //===== TOTAL ACTUAL CONSUMPTION END =====//

            //===== TOTAL MONTHLY TARGET =====//
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
            //===== TOTAL MONTHLY TARGET END =====//

            //===== COMPUTE TOTAL MONTHLY TARGET =====//
            $total_monthly_target_per_month =  $total_monthly_target_per_month_april + $total_monthly_target_per_month_may + $total_monthly_target_per_month_june + $total_monthly_target_per_month_july + $total_monthly_target_per_month_august + $total_monthly_target_per_month_september + $total_monthly_target_per_month_october + $total_monthly_target_per_month_november + $total_monthly_target_per_month_december + $total_monthly_target_per_month_january + $total_monthly_target_per_month_february + $total_monthly_target_per_month_march;

            $total_monthly_target_ream = $total_monthly_target_per_month / 500;
            //===== COMPUTE TOTAL MONTHLY TARGET END =====//

            //===== COMPUTE TOTAL ACTUAL CONSUMPTION =====//
            $total_actual_consumption_per_month =  $total_actual_consumption_per_month_april + $total_actual_consumption_per_month_may + $total_actual_consumption_per_month_june + $total_actual_consumption_per_month_july + $total_actual_consumption_per_month_august + $total_actual_consumption_per_month_september + $total_actual_consumption_per_month_october + $total_actual_consumption_per_month_november + $total_actual_consumption_per_month_december + $total_actual_consumption_per_month_january + $total_actual_consumption_per_month_february + $total_actual_consumption_per_month_march;
            //===== COMPUTE TOTAL ACTUAL CONSUMPTION END =====//
            $difference_target_to_actual = $total_monthly_target_per_month - $total_actual_consumption_per_month;
            $difference_target_to_actual_ream = $difference_target_to_actual / 500;

            //===== GET TOTAL REAM FROM ACTUAL CONSUMPTION =====//
            $total_ream_april = $total_actual_consumption_per_month_april / 500;
            $total_ream_may = $total_actual_consumption_per_month_may / 500;
            $total_ream_june = $total_actual_consumption_per_month_june / 500;
            $total_ream_july = $total_actual_consumption_per_month_july / 500;
            $total_ream_august = $total_actual_consumption_per_month_august / 500;
            $total_ream_september = $total_actual_consumption_per_month_september / 500;
            $total_ream_october = $total_actual_consumption_per_month_october / 500;
            $total_ream_november = $total_actual_consumption_per_month_november / 500;
            $total_ream_december = $total_actual_consumption_per_month_december / 500;
            $total_ream_january = $total_actual_consumption_per_month_january / 500;
            $total_ream_february = $total_actual_consumption_per_month_february / 500;
            $total_ream_march = $total_actual_consumption_per_month_march / 500;

            $total_ream_overall = $total_ream_april + $total_ream_may + $total_ream_june + $total_ream_july + $total_ream_august + $total_ream_september + $total_ream_october + $total_ream_november + $total_ream_december + $total_ream_january + $total_ream_february + $total_ream_march;
            //===== GET TOTAL REAM FROM ACTUAL CONSUMPTION END =====//

            $result .= '<tr style=" border-top: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                            <td style="border-left: 2px solid black;"></td>
                            <td style="border-right: 2px solid black;">TOTAL PCS</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_april . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_may . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_june . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_july . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_august . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_september . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_october . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_november . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_december . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_january . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_february . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month_march . '</td>
                            <td style="border-right: 2px solid black;">' . $total_actual_consumption_per_month . '</td>
                            <td style="border-right: 2px solid black;">' . $total_monthly_target_per_month . '</td>';
            if ($difference_target_to_actual <  0) {
                $result .= '<td style="color: red; font-weight:bold;">' . $difference_target_to_actual . '</td>';
            } else {
                $result .= '<td style="color: green; font-weight:bold;">' . $difference_target_to_actual . '</td>';
            }

            $result .= '
                    </tr>
                    <tr style="background-color: #fff9c4; border-bottom: 2px solid black;">
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
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_monthly_target_ream, 2, '.', '') . '</td>';
            if ($difference_target_to_actual_ream < 0) {
                $result .= '<td style="color: red; font-weight:bold; border-right: 2px solid black;">' . number_format((float)$difference_target_to_actual_ream, 2, '.', '') . '</td>
                    </tr>';
            } else {
                $result .= '<td style="color: green; font-weight:bold; border-right: 2px solid black;">' . number_format((float)$difference_target_to_actual_ream, 2, '.', '') . '</td>
                    </tr>';
            }
            return response()->json(['result' => $result]);
        }
    }

    public function subtract_actual_consumption(Request $request)
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

            $result = '';
            $counter = 0;
            for ($i = 0; $i < count($get_departments); $i++) {
                $get_department_id = $get_departments[$i]->id;
                $counter = $counter + 1;

                //===== GET PAPER CONSUMPTION PER MONTH =====//
                $monthly_consumption_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_total = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');
                //===== GET PAPER CONSUMPTION PER MONTH END =====//

                //===== GET PAPER TARGET PER MONTH =====//
                $monthly_target_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_total = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');
                //===== GET PAPER TARGET PER MONTH END =====//

                //====== SUBTRACT ACTUAL CONSUMPTION FROM MONTHLY TARGET =====//
                $difference_april = $monthly_target_april - $monthly_consumption_april;
                $difference_may = $monthly_target_may - $monthly_consumption_may;
                $difference_june = $monthly_target_june - $monthly_consumption_june;
                $difference_july = $monthly_target_july - $monthly_consumption_july;
                $difference_august = $monthly_target_august - $monthly_consumption_august;
                $difference_september = $monthly_target_september - $monthly_consumption_september;
                $difference_october = $monthly_target_october - $monthly_consumption_october;
                $difference_november = $monthly_target_november - $monthly_consumption_november;
                $difference_december = $monthly_target_december - $monthly_consumption_december;
                $difference_january = $monthly_target_january - $monthly_consumption_january;
                $difference_february = $monthly_target_february - $monthly_consumption_february;
                $difference_march = $monthly_target_march - $monthly_consumption_march;

                $total_difference = $difference_april + $difference_may + $difference_june + $difference_july + $difference_august + $difference_september + $difference_october + $difference_november + $difference_december + $difference_january + $difference_february + $difference_march;

                //====== SUBTRACT ACTUAL CONSUMPTION FROM MONTHLY TARGET =====//
                $result .=
                    '<tr style="border-top: 2px solid black; border-left: 2px solid black; border-right: 2px solid black;">
                        <th width="7%" style="background-color: white; vertical-align : middle;text-align:center; border-left: 2px solid black; border-right: 2px solid black;" rowspan = "2"><span>' . $get_departments[$i]->name . '</span></th>
                        <td width="10%" style="border-right: 2px solid black;">PCS</td> ';

                if ($get_department_id == $counter) {

                    if ($difference_april >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_april . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_april . '</td>';
                    }

                    if ($difference_may >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_may . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_may . '</td>';
                    }

                    if ($difference_june >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_june . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_june . '</td>';
                    }

                    if ($difference_july >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_july . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_july . '</td>';
                    }

                    if ($difference_august >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_august . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_august . '</td>';
                    }

                    if ($difference_september  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_september . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_september  . '</td>';
                    }

                    if ($difference_october  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_october . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_october  . '</td>';
                    }

                    if ($difference_november  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_november . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_november  . '</td>';
                    }

                    if ($difference_december  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_december . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_december  . '</td>';
                    }

                    if ($difference_january  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_january . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_january  . '</td>';
                    }

                    if ($difference_february >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_february . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_february  . '</td>';
                    }

                    if ($difference_march  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_march . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_march  . '</td>';
                    }

                    $result .= '<td width="7%" style="border-right: 2px solid black;">' . $total_difference . '</td></tr>';

                    $difference_april_ream = $difference_april / 500;
                    $difference_may_ream = $difference_may / 500;
                    $difference_june_ream = $difference_june / 500;
                    $difference_july_ream = $difference_july / 500;
                    $difference_august_ream = $difference_august / 500;
                    $difference_september_ream = $difference_september / 500;
                    $difference_october_ream = $difference_october / 500;
                    $difference_november_ream = $difference_november / 500;
                    $difference_december_ream = $difference_december / 500;
                    $difference_january_ream = $difference_january / 500;
                    $difference_february_ream = $difference_february / 500;
                    $difference_march_ream = $difference_march / 500;

                    $total_difference_ream = $total_difference / 500;

                    $result .= ' <tr>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">REAM</td>';

                    if ($difference_april_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_april_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_april_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_may_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_may_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_may_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_june_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_june_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_june_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_july_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_july_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_july_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_august_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_august_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_august_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_september_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_september_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_september_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_october_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_october_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_october_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_november_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_november_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_november_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_december_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_december_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_december_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_january_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_january_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_january_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_february_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_february_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_february_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_march_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_march_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_march_ream, 2, '.', '') . '</td> ';
                    }


                    $result .= '<td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$total_difference_ream, 2, '.', '') . '</td></tr>';
                }
            }

            //===== GET PAPER CONSUMPTION PER MONTH =====//
            $consumption_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'April')
                ->sum('quantity');

            $consumption_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'May')
                ->sum('quantity');

            $consumption_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'June')
                ->sum('quantity');

            $consumption_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'July')
                ->sum('quantity');

            $consumption_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'August')
                ->sum('quantity');

            $consumption_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'September')
                ->sum('quantity');

            $consumption_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'October')
                ->sum('quantity');

            $consumption_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'November')
                ->sum('quantity');

            $consumption_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'December')
                ->sum('quantity');

            $consumption_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'January')
                ->sum('quantity');

            $consumption_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'February')
                ->sum('quantity');

            $consumption_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'March')
                ->sum('quantity');

            $monthly_consumption_total = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->sum('quantity');
            //===== GET PAPER CONSUMPTION PER MONTH END =====//

            //===== GET PAPER TARGET PER MONTH =====//
            $target_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'April')
                ->sum('data_monthly_target');

            $target_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'May')
                ->sum('data_monthly_target');

            $target_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'June')
                ->sum('data_monthly_target');

            $target_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'July')
                ->sum('data_monthly_target');

            $target_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'August')
                ->sum('data_monthly_target');

            $target_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'September')
                ->sum('data_monthly_target');

            $target_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'October')
                ->sum('data_monthly_target');

            $target_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'November')
                ->sum('data_monthly_target');

            $target_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'December')
                ->sum('data_monthly_target');

            $target_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'January')
                ->sum('data_monthly_target');

            $target_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'February')
                ->sum('data_monthly_target');

            $target_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'March')
                ->sum('data_monthly_target');

            $total_april = $target_april - $consumption_april;
            $total_may = $target_may - $consumption_may;
            $total_june = $target_june - $consumption_june;
            $total_july = $target_july - $consumption_july;
            $total_august = $target_august - $consumption_august;
            $total_september = $target_september - $consumption_september;
            $total_october = $target_october - $consumption_october;
            $total_november = $target_november - $consumption_november;
            $total_december = $target_december - $consumption_december;
            $total_january = $target_january - $consumption_january;
            $total_february = $target_february - $consumption_february;
            $total_march = $target_march - $consumption_march;

            $total_consumption_pcs = $total_april + $total_may + $total_june + $total_july + $total_august + $total_september + $total_october + $total_november + $total_december + $total_january + $total_february + $total_march;


            $result .= '<tr style=" border-top: 2px solid black; border-left: 2px solid black; ">
                            <td></td>
                            <td style="border-right: 2px solid black;">TOTAL PCS</td>';

            if ($total_april >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_april . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_april . '</td>';
            }

            if ($total_may >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_may . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_may . '</td>';
            }

            if ($total_june >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_june . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_june . '</td>';
            }

            if ($total_july >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_july . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_july . '</td>';
            }

            if ($total_august >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_august . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_august . '</td>';
            }

            if ($total_september >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_september . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_september . '</td>';
            }

            if ($total_october >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_october . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_october . '</td>';
            }

            if ($total_november >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_november . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_november . '</td>';
            }

            if ($total_december >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_december . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_december . '</td>';
            }

            if ($total_january >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_january . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_january . '</td>';
            }

            if ($total_february >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_february . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_february . '</td>';
            }

            if ($total_march >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_march . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_march . '</td>';
            }

            if ($total_consumption_pcs >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_consumption_pcs . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_consumption_pcs . '</td>';
            }

            $total_consumption_ream_april = $total_april / 500;
            $total_consumption_ream_may = $total_may / 500;
            $total_consumption_ream_june = $total_june / 500;
            $total_consumption_ream_july = $total_july / 500;
            $total_consumption_ream_august = $total_august / 500;
            $total_consumption_ream_september = $total_september / 500;
            $total_consumption_ream_october = $total_october / 500;
            $total_consumption_ream_november = $total_november / 500;
            $total_consumption_ream_december = $total_december / 500;
            $total_consumption_ream_january = $total_january / 500;
            $total_consumption_ream_february = $total_february / 500;
            $total_consumption_ream_march = $total_march / 500;

            $total_consumption_ream = $total_consumption_ream_april + $total_consumption_ream_may + $total_consumption_ream_june + $total_consumption_ream_july + $total_consumption_ream_august + $total_consumption_ream_september + $total_consumption_ream_october + $total_consumption_ream_november + $total_consumption_ream_december + $total_consumption_ream_january + $total_consumption_ream_february + $total_consumption_ream_march;

            $result .= '
                    </tr>
                    <tr style="background-color: #fff9c4; border-right: 2px solid black; border-bottom: 2px solid black; border-left: 2px solid black;">
                        <td></td>
                        <td style="border-right: 2px solid black;">TOTAL REAM</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_april, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_may, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_june, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_july, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_august, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_september, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_october, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_november, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_december, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_january, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_february, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_march, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream, 2, '.', '') . '</td>
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

                //===== GET PAPER CONSUMPTION PER MONTH =====//
                $monthly_consumption_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $monthly_consumption_total = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');
                //===== GET PAPER CONSUMPTION PER MONTH END =====//

                //===== GET PAPER TARGET PER MONTH =====//
                $monthly_target_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $monthly_target_total = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');
                //===== GET PAPER TARGET PER MONTH END =====//

                //====== SUBTRACT ACTUAL CONSUMPTION FROM MONTHLY TARGET =====//
                $difference_april = $monthly_target_april - $monthly_consumption_april;
                $difference_may = $monthly_target_may - $monthly_consumption_may;
                $difference_june = $monthly_target_june - $monthly_consumption_june;
                $difference_july = $monthly_target_july - $monthly_consumption_july;
                $difference_august = $monthly_target_august - $monthly_consumption_august;
                $difference_september = $monthly_target_september - $monthly_consumption_september;
                $difference_october = $monthly_target_october - $monthly_consumption_october;
                $difference_november = $monthly_target_november - $monthly_consumption_november;
                $difference_december = $monthly_target_december - $monthly_consumption_december;
                $difference_january = $monthly_target_january - $monthly_consumption_january;
                $difference_february = $monthly_target_february - $monthly_consumption_february;
                $difference_march = $monthly_target_march - $monthly_consumption_march;

                $total_difference = $difference_april + $difference_may + $difference_june + $difference_july + $difference_august + $difference_september + $difference_october + $difference_november + $difference_december + $difference_january + $difference_february + $difference_march;

                //====== SUBTRACT ACTUAL CONSUMPTION FROM MONTHLY TARGET =====//
                $result .=
                    '<tr style="border-top: 2px solid black; border-left: 2px solid black; border-right: 2px solid black;">
                        <th width="7%" style="background-color: white; vertical-align : middle;text-align:center; border-left: 2px solid black; border-right: 2px solid black;" rowspan = "2"><span>' . $get_departments[$i]->name . '</span></th>
                        <td width="10%" style="border-right: 2px solid black;">PCS</td> ';

                if ($get_department_id == $counter) {

                    if ($difference_april >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_april . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_april . '</td>';
                    }

                    if ($difference_may >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_may . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_may . '</td>';
                    }

                    if ($difference_june >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_june . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_june . '</td>';
                    }

                    if ($difference_july >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_july . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_july . '</td>';
                    }

                    if ($difference_august >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_august . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_august . '</td>';
                    }

                    if ($difference_september  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_september . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_september  . '</td>';
                    }

                    if ($difference_october  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_october . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_october  . '</td>';
                    }

                    if ($difference_november  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_november . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_november  . '</td>';
                    }

                    if ($difference_december  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_december . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_december  . '</td>';
                    }

                    if ($difference_january  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_january . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_january  . '</td>';
                    }

                    if ($difference_february >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_february . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_february  . '</td>';
                    }

                    if ($difference_march  >= 0) {
                        $result .= '<td width="5%" style="color: green; border-right: 2px solid black;">' . $difference_march . '</td>';
                    } else {
                        $result .= '<td width="5%" style="color: red ; border-right: 2px solid black; font-weight:bold;">' . $difference_march  . '</td>';
                    }

                    $result .= '<td width="7%" style="border-right: 2px solid black;">' . $total_difference . '</td></tr>';

                    $difference_april_ream = $difference_april / 500;
                    $difference_may_ream = $difference_may / 500;
                    $difference_june_ream = $difference_june / 500;
                    $difference_july_ream = $difference_july / 500;
                    $difference_august_ream = $difference_august / 500;
                    $difference_september_ream = $difference_september / 500;
                    $difference_october_ream = $difference_october / 500;
                    $difference_november_ream = $difference_november / 500;
                    $difference_december_ream = $difference_december / 500;
                    $difference_january_ream = $difference_january / 500;
                    $difference_february_ream = $difference_february / 500;
                    $difference_march_ream = $difference_march / 500;

                    $total_difference_ream = $total_difference / 500;

                    $result .= ' <tr>
                        <td style="background-color: #fff9c4; border-right: 2px solid black;">REAM</td>';

                    if ($difference_april_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_april_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_april_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_may_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_may_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_may_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_june_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_june_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_june_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_july_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_july_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_july_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_august_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_august_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_august_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_september_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_september_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_september_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_october_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_october_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_october_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_november_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_november_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_november_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_december_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_december_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_december_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_january_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_january_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_january_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_february_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_february_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_february_ream, 2, '.', '') . '</td>';
                    }

                    if ($difference_march_ream >= 0) {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: green;">' . number_format((float)$difference_march_ream, 2, '.', '') . '</td>';
                    } else {
                        $result .= '
                        <td style="background-color: #fff9c4; border-right: 2px solid black; color: red;">' . number_format((float)$difference_march_ream, 2, '.', '') . '</td> ';
                    }


                    $result .= '<td style="background-color: #fff9c4; border-right: 2px solid black;">' . number_format((float)$total_difference_ream, 2, '.', '') . '</td></tr>';
                }
            }

            //===== GET PAPER CONSUMPTION PER MONTH =====//
            $consumption_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'April')
                ->sum('quantity');

            $consumption_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'May')
                ->sum('quantity');

            $consumption_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'June')
                ->sum('quantity');

            $consumption_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'July')
                ->sum('quantity');

            $consumption_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'August')
                ->sum('quantity');

            $consumption_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'September')
                ->sum('quantity');

            $consumption_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'October')
                ->sum('quantity');

            $consumption_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'November')
                ->sum('quantity');

            $consumption_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'December')
                ->sum('quantity');

            $consumption_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'January')
                ->sum('quantity');

            $consumption_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'February')
                ->sum('quantity');

            $consumption_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->where('month', 'March')
                ->sum('quantity');

            $monthly_consumption_total = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                ->sum('quantity');
            //===== GET PAPER CONSUMPTION PER MONTH END =====//

            //===== GET PAPER TARGET PER MONTH =====//
            $target_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'April')
                ->sum('data_monthly_target');

            $target_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'May')
                ->sum('data_monthly_target');

            $target_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'June')
                ->sum('data_monthly_target');

            $target_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'July')
                ->sum('data_monthly_target');

            $target_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'August')
                ->sum('data_monthly_target');

            $target_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'September')
                ->sum('data_monthly_target');

            $target_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'October')
                ->sum('data_monthly_target');

            $target_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'November')
                ->sum('data_monthly_target');

            $target_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'December')
                ->sum('data_monthly_target');

            $target_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'January')
                ->sum('data_monthly_target');

            $target_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'February')
                ->sum('data_monthly_target');

            $target_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', 'March')
                ->sum('data_monthly_target');

            $total_april = $target_april - $consumption_april;
            $total_may = $target_may - $consumption_may;
            $total_june = $target_june - $consumption_june;
            $total_july = $target_july - $consumption_july;
            $total_august = $target_august - $consumption_august;
            $total_september = $target_september - $consumption_september;
            $total_october = $target_october - $consumption_october;
            $total_november = $target_november - $consumption_november;
            $total_december = $target_december - $consumption_december;
            $total_january = $target_january - $consumption_january;
            $total_february = $target_february - $consumption_february;
            $total_march = $target_march - $consumption_march;

            $total_consumption_pcs = $total_april + $total_may + $total_june + $total_july + $total_august + $total_september + $total_october + $total_november + $total_december + $total_january + $total_february + $total_march;


            $result .= '<tr style=" border-top: 2px solid black; border-left: 2px solid black; ">
                            <td></td>
                            <td style="border-right: 2px solid black;">TOTAL PCS</td>';

            if ($total_april >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_april . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_april . '</td>';
            }

            if ($total_may >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_may . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_may . '</td>';
            }

            if ($total_june >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_june . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_june . '</td>';
            }

            if ($total_july >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_july . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_july . '</td>';
            }

            if ($total_august >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_august . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_august . '</td>';
            }

            if ($total_september >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_september . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_september . '</td>';
            }

            if ($total_october >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_october . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_october . '</td>';
            }

            if ($total_november >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_november . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_november . '</td>';
            }

            if ($total_december >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_december . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_december . '</td>';
            }

            if ($total_january >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_january . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_january . '</td>';
            }

            if ($total_february >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_february . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_february . '</td>';
            }

            if ($total_march >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_march . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_march . '</td>';
            }

            if ($total_consumption_pcs >= 0) {
                $result .= '<td style="color:green; border-right: 2px solid black;">' . $total_consumption_pcs . '</td>';
            } else {
                $result .= '<td style="color:red; border-right: 2px solid black; font-weight: bold;">' . $total_consumption_pcs . '</td>';
            }

            $total_consumption_ream_april = $total_april / 500;
            $total_consumption_ream_may = $total_may / 500;
            $total_consumption_ream_june = $total_june / 500;
            $total_consumption_ream_july = $total_july / 500;
            $total_consumption_ream_august = $total_august / 500;
            $total_consumption_ream_september = $total_september / 500;
            $total_consumption_ream_october = $total_october / 500;
            $total_consumption_ream_november = $total_november / 500;
            $total_consumption_ream_december = $total_december / 500;
            $total_consumption_ream_january = $total_january / 500;
            $total_consumption_ream_february = $total_february / 500;
            $total_consumption_ream_march = $total_march / 500;

            $total_consumption_ream = $total_consumption_ream_april + $total_consumption_ream_may + $total_consumption_ream_june + $total_consumption_ream_july + $total_consumption_ream_august + $total_consumption_ream_september + $total_consumption_ream_october + $total_consumption_ream_november + $total_consumption_ream_december + $total_consumption_ream_january + $total_consumption_ream_february + $total_consumption_ream_march;

            $result .= '
                    </tr>
                    <tr style="background-color: #fff9c4; border-right: 2px solid black; border-bottom: 2px solid black; border-left: 2px solid black;">
                        <td></td>
                        <td style="border-right: 2px solid black;">TOTAL REAM</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_april, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_may, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_june, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_july, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_august, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_september, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_october, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_november, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_december, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_january, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_february, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream_march, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$total_consumption_ream, 2, '.', '') . '</td>
                    </tr>';

            return response()->json(['result' => $result]);
        }
    }
}
