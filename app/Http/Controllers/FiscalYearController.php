<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\FiscalYear;

class FiscalYearController extends Controller
{
    public function set_fiscal_year(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'fiscal_year' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (FiscalYear::where('year', $request->fiscal_year)->exists()) {
                return response()->json(['result' => 0]);
            } else {
                FiscalYear::insert([
                    'year' => $request->fiscal_year,
                    'status' => 0,
                ]);

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
    }

    public function get_fiscal_year()
    {
        $result = FiscalYear::where('status', 0)
            ->get();
        $year = collect($result)->pluck('year')->flatten(1)->toArray();

        return response()->json(['result' => $year]);
    }

    public function update_fiscal_year(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $get_past_fy =  $request->next_fiscal_year - 1;
        $get_current_fy = $request->next_fiscal_year;

        FiscalYear::where('year', $get_past_fy)
            ->update([
                'status' => 1
            ]);

        FiscalYear::where('year', $get_current_fy)
            ->update([
                'status' => 0
            ]);
        return response()->json(['result' => 1]);
    }

    public function get_all_fy()
    {
        //===== GET ALL FISCAL YEAR FROM FISCAL YEARS TABLE FOR FILTERING PURPOSE =====//
        $result = FiscalYear::where('year', '!=', '2020')->get();

        $all_fy = '<option value="0" selected disabled>  Select Fiscal Year  </option>';
        $all_fy .= '<option value="" >  All  </option>';
        for ($i = 0; $i < count($result); $i++) {
            $fy = $result[$i]->year;

            $all_fy .= "<option value=" . $fy . ">" . $fy . "</option>";
        }
        return response()->json(['fy' => $all_fy]);
        //===== GET ALL FISCAL YEAR FROM FISCAL YEARS TABLE FOR FILTERING PURPOSE END =====//
    }
}
