<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TotalUsedPaper;
use App\FiscalYear;
use App\Department;

use App\MonthlyTarget;


class QuarterlyConsumptionController extends Controller
{

    public function get_quarterly_consumption(Request $request)
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
                    '<tr style="border-right: 2px solid black;"> 
                        <th rowspan="3" width="7%" style="background-color: white; vertical-align : middle;text-align:center;border: 2px solid black;"><span>' . $get_departments[$i]->name . '</span></th>';

                //===== GET TARGET PER DEPARTMENT REAMS FOR 1ST QUARTER =====//
                $first_quarter_targets_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $first_quarter_targets_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $first_quarter_targets_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $first_quarter_targets = $first_quarter_targets_april + $first_quarter_targets_may + $first_quarter_targets_june;
                $first_quarter_targets_ream = $first_quarter_targets / 500;
                //===== GET TARGET PER DEPARTMENT REAMS FOR 1ST QUARTER END =====//

                //===== GET TARGET PER DEPARTMENT REAMS FOR 2ND QUARTER =====//
                $second_quarter_targets_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $second_quarter_targets_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $second_quarter_targets_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $second_quarter_targets = $second_quarter_targets_july + $second_quarter_targets_august + $second_quarter_targets_september;

                $second_quarter_targets_ream = $second_quarter_targets / 500;
                //===== GET TARGET PER DEPARTMENT REAMS FOR 2ND QUARTER END =====//

                //===== GET TARGET PER DEPARTMENT REAMS FOR 3RD QUARTER =====//
                $third_quarter_targets_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $third_quarter_targets_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $third_quarter_targets_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $third_quarter_targets = $third_quarter_targets_october + $third_quarter_targets_november + $third_quarter_targets_december;

                $third_quarter_targets_ream = $third_quarter_targets / 500;
                //===== GET TARGET PER DEPARTMENT REAMS FOR 3RD QUARTER END =====//

                //===== GET TARGET PER DEPARTMENT REAMS FOR 4TH QUARTER =====//
                $fourth_quarter_targets_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $fourth_quarter_targets_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $fourth_quarter_targets_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $fourth_quarter_targets = $fourth_quarter_targets_january + $fourth_quarter_targets_february + $fourth_quarter_targets_march;

                $fourth_quarter_targets_ream = $fourth_quarter_targets / 500;
                //===== GET TARGET PER DEPARTMENT REAMS FOR 4TH QUARTER END =====//

                $whole_fy_ream = $first_quarter_targets_ream + $second_quarter_targets_ream + $third_quarter_targets_ream + $fourth_quarter_targets_ream;

                $result .= '<td style="border-right: 2px solid black;">TARGET</td> 
                        <td style="border-right: 2px solid black;">' . number_format((float)$first_quarter_targets_ream, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$second_quarter_targets_ream, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$third_quarter_targets_ream, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$fourth_quarter_targets_ream, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$whole_fy_ream, 2, '.', '') . '</td>
                </tr>';

                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 1ST QUARTER =====//
                $first_quarter_consumption_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $first_quarter_consumption_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $first_quarter_consumption_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $first_quarter_consumptions = $first_quarter_consumption_april + $first_quarter_consumption_may + $first_quarter_consumption_june;

                $first_quarter_consumption_reams = $first_quarter_consumptions / 500;
                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 1ST QUARTER END =====//

                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 2ND QUARTER =====//
                $second_quarter_consumption_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $second_quarter_consumption_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $second_quarter_consumption_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $second_quarter_consumptions = $second_quarter_consumption_july + $second_quarter_consumption_august + $second_quarter_consumption_september;

                $second_quarter_consumption_reams = $second_quarter_consumptions / 500;
                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 2ND QUARTER END =====//

                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 3RD QUARTER =====//
                $third_quarter_consumption_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $third_quarter_consumption_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $third_quarter_consumption_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $third_quarter_consumptions = $third_quarter_consumption_october + $third_quarter_consumption_november + $third_quarter_consumption_december;

                $third_quarter_consumption_reams = $third_quarter_consumptions / 500;
                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 3RD QUARTER END =====//

                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 3RD QUARTER =====//
                $fourth_quarter_consumption_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $fourth_quarter_consumption_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $fourth_quarter_consumption_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $fourth_quarter_consumptions = $fourth_quarter_consumption_january + $fourth_quarter_consumption_february + $fourth_quarter_consumption_march;

                $fourth_quarter_consumption_reams = $fourth_quarter_consumptions / 500;
                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 3RD QUARTER END =====//

                $whole_fy_consumption = $first_quarter_consumption_reams + $second_quarter_consumption_reams + $third_quarter_consumption_reams + $fourth_quarter_consumption_reams;

                $result .= '<tr style="border-right: 2px solid black;">
                            <td style="border-right: 2px solid black;">ACTUAL</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$first_quarter_consumption_reams, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$second_quarter_consumption_reams, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$third_quarter_consumption_reams, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$fourth_quarter_consumption_reams, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$whole_fy_consumption, 2, '.', '') . '</td>
                        </tr>';

                //===== GET DIFFERENCE BETWEEN TARGET AND ACTUAL CONSUMPTION  =====//
                $first_quarter_difference = $first_quarter_targets_ream - $first_quarter_consumption_reams;
                $second_quarter_difference = $second_quarter_targets_ream - $second_quarter_consumption_reams;
                $third_quarter_difference = $third_quarter_targets_ream - $third_quarter_consumption_reams;
                $fourth_quarter_difference = $fourth_quarter_targets_ream - $fourth_quarter_consumption_reams;

                $total_difference = $first_quarter_difference + $second_quarter_difference +  $third_quarter_difference + $fourth_quarter_difference;
                //===== GET DIFFERENCE BETWEEN TARGET AND ACTUAL CONSUMPTION END  =====//

                $result .= '<tr style="border-bottom: 2px solid black; border-right: 2px solid black; background-color: #fff9c4;">
                            <td style="border-right: 2px solid black;">DIFFERENCE</td>
                            <td style="border-right: 2px solid black;"> ' . number_format((float)$first_quarter_difference, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$second_quarter_difference, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$third_quarter_difference, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$fourth_quarter_difference, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$total_difference, 2, '.', '') . '</td>
                            
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
                    '<tr style="border-right: 2px solid black;"> 
                        <th rowspan="3" width="7%" style="background-color: white; vertical-align : middle;text-align:center;border: 2px solid black;"><span>' . $get_departments[$i]->name . '</span></th>';

                //===== GET TARGET PER DEPARTMENT REAMS FOR 1ST QUARTER =====//
                $first_quarter_targets_april = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $first_quarter_targets_may = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $first_quarter_targets_june = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $first_quarter_targets = $first_quarter_targets_april + $first_quarter_targets_may + $first_quarter_targets_june;
                $first_quarter_targets_ream = $first_quarter_targets / 500;
                //===== GET TARGET PER DEPARTMENT REAMS FOR 1ST QUARTER END =====//

                //===== GET TARGET PER DEPARTMENT REAMS FOR 2ND QUARTER =====//
                $second_quarter_targets_july = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $second_quarter_targets_august = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $second_quarter_targets_september = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $second_quarter_targets = $second_quarter_targets_july + $second_quarter_targets_august + $second_quarter_targets_september;

                $second_quarter_targets_ream = $second_quarter_targets / 500;
                //===== GET TARGET PER DEPARTMENT REAMS FOR 2ND QUARTER END =====//

                //===== GET TARGET PER DEPARTMENT REAMS FOR 3RD QUARTER =====//
                $third_quarter_targets_october = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $third_quarter_targets_november = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $third_quarter_targets_december = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $third_quarter_targets = $third_quarter_targets_october + $third_quarter_targets_november + $third_quarter_targets_december;

                $third_quarter_targets_ream = $third_quarter_targets / 500;
                //===== GET TARGET PER DEPARTMENT REAMS FOR 3RD QUARTER END =====//

                //===== GET TARGET PER DEPARTMENT REAMS FOR 4TH QUARTER =====//
                $fourth_quarter_targets_january = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $fourth_quarter_targets_february = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $fourth_quarter_targets_march = MonthlyTarget::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('data_monthly_target');

                $fourth_quarter_targets = $fourth_quarter_targets_january + $fourth_quarter_targets_february + $fourth_quarter_targets_march;

                $fourth_quarter_targets_ream = $fourth_quarter_targets / 500;
                //===== GET TARGET PER DEPARTMENT REAMS FOR 4TH QUARTER END =====//

                $whole_fy_ream = $first_quarter_targets_ream + $second_quarter_targets_ream + $third_quarter_targets_ream + $fourth_quarter_targets_ream;

                $result .= '<td style="border-right: 2px solid black;">TARGET</td> 
                        <td style="border-right: 2px solid black;">' . number_format((float)$first_quarter_targets_ream, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$second_quarter_targets_ream, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$third_quarter_targets_ream, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$fourth_quarter_targets_ream, 2, '.', '') . '</td>
                        <td style="border-right: 2px solid black;">' . number_format((float)$whole_fy_ream, 2, '.', '') . '</td>
                </tr>';

                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 1ST QUARTER =====//
                $first_quarter_consumption_april = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'April')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $first_quarter_consumption_may = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'May')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $first_quarter_consumption_june = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'June')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $first_quarter_consumptions = $first_quarter_consumption_april + $first_quarter_consumption_may + $first_quarter_consumption_june;

                $first_quarter_consumption_reams = $first_quarter_consumptions / 500;
                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 1ST QUARTER END =====//

                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 2ND QUARTER =====//
                $second_quarter_consumption_july = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'July')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $second_quarter_consumption_august = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'August')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $second_quarter_consumption_september = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'September')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $second_quarter_consumptions = $second_quarter_consumption_july + $second_quarter_consumption_august + $second_quarter_consumption_september;

                $second_quarter_consumption_reams = $second_quarter_consumptions / 500;
                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 2ND QUARTER END =====//

                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 3RD QUARTER =====//
                $third_quarter_consumption_october = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'October')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $third_quarter_consumption_november = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'November')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $third_quarter_consumption_december = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'December')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $third_quarter_consumptions = $third_quarter_consumption_october + $third_quarter_consumption_november + $third_quarter_consumption_december;

                $third_quarter_consumption_reams = $third_quarter_consumptions / 500;
                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 3RD QUARTER END =====//

                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 3RD QUARTER =====//
                $fourth_quarter_consumption_january = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'January')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $fourth_quarter_consumption_february = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'February')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $fourth_quarter_consumption_march = TotalUsedPaper::where('fiscal_year_id', $fy_id)
                    ->where('month', 'March')
                    ->where('department_id', $get_department_id)
                    ->sum('quantity');

                $fourth_quarter_consumptions = $fourth_quarter_consumption_january + $fourth_quarter_consumption_february + $fourth_quarter_consumption_march;

                $fourth_quarter_consumption_reams = $fourth_quarter_consumptions / 500;
                //===== GET ACTUAL CONSUMPTION PER DEPARTMENT FOR 3RD QUARTER END =====//

                $whole_fy_consumption = $first_quarter_consumption_reams + $second_quarter_consumption_reams + $third_quarter_consumption_reams + $fourth_quarter_consumption_reams;

                $result .= '<tr style="border-right: 2px solid black;">
                            <td style="border-right: 2px solid black;">ACTUAL</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$first_quarter_consumption_reams, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$second_quarter_consumption_reams, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$third_quarter_consumption_reams, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$fourth_quarter_consumption_reams, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$whole_fy_consumption, 2, '.', '') . '</td>
                        </tr>';

                //===== GET DIFFERENCE BETWEEN TARGET AND ACTUAL CONSUMPTION  =====//
                $first_quarter_difference = $first_quarter_targets_ream - $first_quarter_consumption_reams;
                $second_quarter_difference = $second_quarter_targets_ream - $second_quarter_consumption_reams;
                $third_quarter_difference = $third_quarter_targets_ream - $third_quarter_consumption_reams;
                $fourth_quarter_difference = $fourth_quarter_targets_ream - $fourth_quarter_consumption_reams;

                $total_difference = $first_quarter_difference + $second_quarter_difference +  $third_quarter_difference + $fourth_quarter_difference;
                //===== GET DIFFERENCE BETWEEN TARGET AND ACTUAL CONSUMPTION END  =====//

                $result .= '<tr style="border-bottom: 2px solid black; border-right: 2px solid black; background-color: #fff9c4;">
                            <td style="border-right: 2px solid black;">DIFFERENCE</td>
                            <td style="border-right: 2px solid black;"> ' . number_format((float)$first_quarter_difference, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$second_quarter_difference, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$third_quarter_difference, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$fourth_quarter_difference, 2, '.', '') . '</td>
                            <td style="border-right: 2px solid black;">' . number_format((float)$total_difference, 2, '.', '') . '</td>
                            
                        </tr>';
            }
            return response()->json(['result' => $result]);
        }
    }
}
