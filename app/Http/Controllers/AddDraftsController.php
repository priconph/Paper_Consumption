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
use App\PaperPurchases;
use App\MonthlyUsedPaperDraft;
use App\Draft;
use DataTables;


class AddDraftsController extends Controller
{
    public function display_drafts()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $drafts =  Draft::with(['fiscal_year'])
            ->with(['paper'])
            ->where('department_id', $_SESSION['user_department'])
            ->where('status', 1)
            ->get();

        return DataTables::of($drafts)
            ->addColumn('month', function ($draft) {
                $result = "";
                if ($draft->month == "January") {
                    $result .= '<tr value="10">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="January"> </tr>';
                } elseif ($draft->month == "February") {
                    $result .= '<tr value="11">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="February"> </tr>';
                } elseif ($draft->month == "March") {
                    $result .= '<tr value="12">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="March"> </tr>';
                } elseif ($draft->month == "April") {
                    $result .= '<tr value="1">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="April"> </tr>';
                } elseif ($draft->month == "May") {
                    $result .= '<tr value="2">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="May"> </tr>';
                } elseif ($draft->month == "June") {
                    $result .= '<tr value="3">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="June"> </tr>';
                } elseif ($draft->month == "July") {
                    $result .= '<tr value="4">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="July"> </tr>';
                } elseif ($draft->month == "August") {
                    $result .= '<tr value="5">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="August"> </tr>';
                } elseif ($draft->month == "September") {
                    $result .= '<tr value="6">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="September"> </tr>';
                } elseif ($draft->month == "October") {
                    $result .= '<tr value="7">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="October"> </tr>';
                } elseif ($draft->month == "November") {
                    $result .= '<tr value="8">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="November"> </tr>';
                } elseif ($draft->month == "December") {
                    $result .= '<tr value="9">' . $draft->month . '<input id="month_name" type="hidden" style="width:50%;" value="December"> </tr>';
                }
                return $result;
            })
            ->addColumn('action', function ($draft) {
                $result = FiscalYear::where('status', 0)
                    ->get();
                $fy_id = $result[0]->id;

                $result = "";

                $get_month = $draft->month;
                $get_fy_id = $draft->fiscal_year_id;
                $get_category = $draft->category;

                $GetActiveMonth = DB::connection('mysql')->select("SELECT `active_month` FROM `month_config` WHERE `status` = '0'");
                $date_now = Carbon::now()->format('d');

                if($date_now == 01 || $date_now == 02 || $date_now == 03 || $date_now == 04 || $date_now == 05){
                    if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                        $month_now = Carbon::now()->subMonth()->format('F');
                        $nextMonth = Carbon::now()->format('F');
                    }else{//Previous Month
                        $month_now = Carbon::now()->subMonths(2)->format('F');
                        $nextMonth = Carbon::now()->format('F');
                    }
                }else{
                    if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                        $month_now = Carbon::now()->format('F');
                        $nextMonth = Carbon::now()->addMonth()->format('F');
                    }else{//Previous Month
                        $month_now = Carbon::now()->subMonth()->format('F');
                        $nextMonth = Carbon::now()->format('F');
                    }

                    // $month_now = Carbon::now()->format('F');                 //uncomment to activate real month
                    // $nextMonth = Carbon::now()->addMonth()->format('F');     //uncomment to activate real month
                    // $month_now = Carbon::now()->subMonth()->format('F');        //uncomment to activate previous month
                    // $nextMonth = Carbon::now()->format('F');                    //uncomment to activate previous month
                }

                //===== FOR MONTHLY TARGET DRAFT =====//
                if ($get_category == 'Monthly Target') {
                    if ($get_month == $month_now && $get_fy_id == $fy_id) {
                        $result .= '<button data-dismiss="modal" class="btn btn-primary text-center actionEditMonthlyTargetDraft" id="btnEditDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalMonthlyTargetDraft" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-success actionSubmitMonthlyTargetDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalMonthlyTargetDraft" data-keyboard="false"><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-danger actionDeleteMonthlyTargetDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalDeleteMonthlyTargetDraft" data-keyboard="false"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
                    } else {
                        // $result .= '<button data-dismiss="modal" class="btn btn-primary text-center actionEditDraft" id="btnEditDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false" disabled><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-success actionSubmitMonthlyTargetDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false" disabled><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-danger actionDeleteMonthlyTargetDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalDeleteMonthlyTargetDraft" data-keyboard="false"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
                    }
                }
                //===== FOR MONTHLY TARGET DRAFT END =====//
                //===== FOR PAPER PURCHASES DRAFT =====//
                elseif ($get_category == 'Paper Purchases') {
                    if ($get_month == $month_now && $get_fy_id == $fy_id) {
                        $result .= '<button data-dismiss="modal" class="btn btn-primary text-center actionEditPaperPurchasesDraft" id="btnEditDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalPaperPurchasesDraft" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-success actionSubmitPaperPurchasesDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalPaperPurchasesDraft" data-keyboard="false"><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-danger actionDeletePaperPurchasesDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalDeletePaperPurchasesDraft" data-keyboard="false"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
                    } else {
                        // $result .= '<button data-dismiss="modal" class="btn btn-primary text-center actionEditDraft" id="btnEditDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false" disabled><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-success actionSubmitPaperPurchasesDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false" disabled><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-danger actionDeletePaperPurchasesDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalDeletePaperPurchasesDraft" data-keyboard="false"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
                    }
                }
                //===== FOR PAPER PURCHASES DRAFT END =====//
                //===== FOR BEGINNING BALANCE DRAFT =====//
                elseif ($get_category == 'Beginning Balance') {
                    if ($get_month == $month_now && $get_fy_id == $fy_id) {
                        $result .= '<button data-dismiss="modal" class="btn btn-primary text-center actionEditBeginningBalanceDraft" id="btnEditDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalBeginningBalanceDraft" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-success actionSubmitBeginningBalanceDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalBeginningBalanceDraft" data-keyboard="false"><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-danger actionDeleteBeginningBalanceDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalDeleteBeginningBalanceDraft" data-keyboard="false"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
                    } else {
                        // $result .= '<button data-dismiss="modal" class="btn btn-primary text-center actionEditDraft" id="btnEditDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false" disabled><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-success actionSubmitBeginningBalanceDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalMonthlyUsedPaperDraft" data-keyboard="false" disabled><i class="fa fa-upload" aria-hidden="true"></i> Submit</button>&nbsp;';

                        $result .= '<button data-dismiss="modal" class="btn btn-danger actionDeleteBeginningBalanceDraft" draft-id="' . $draft->id . ' " data-toggle="modal" data-target="#modalDeleteBeginningBalanceDraft" data-keyboard="false"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
                    }
                }
                //===== FOR BEGINNING BALANCE DRAFT END =====//
                return $result;
            })
            ->rawColumns(['month', 'action'])
            ->make(true);
    }

    public function add_monthly_target_draft(Request $request)
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

            Draft::insert([
                'paper_id' => $request->paper_id,
                'paper_quantity' => $request->monthly_target,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $fy_id,
                'category' => 'Monthly Target',
                'status' => 1
            ]);

            DB::commit();
            return response()->json(['result' => 1]);
        }
    }

    public function get_id_edit_monthly_target_draft(Request $request)
    {
        $monthly_target_drafts = Draft::with(['paper'])->where('id', $request->draft_id)->get();

        $monthly_used_drafts_month = Draft::with(['paper'])->where('id', $request->draft_id)->get();
        // $month = $monthly_used_drafts_month[0]->month;

        return response()->json(['drafts' => $monthly_target_drafts]);
    }

    public function edit_monthly_target_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        Draft::where('id', $request->draft_id)
            ->update([
                'paper_id' => $request->paper_id_edit,
                'paper_quantity' => $request->monthly_target_edit
            ]);

        return response()->json(['result' => 1]);
    }

    public function submit_monthly_target_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;

        $validator = Validator::make($data, [
            'paper_id_edit' => 'required',
            'monthly_target_edit' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (MonthlyTarget::where('fiscal_year_id', $fy_id)
                ->where('month', $request->month)
                ->where('department_id', $_SESSION["user_department"])
                ->where('paper_id', $request->paper_id_edit)->exists()
            ) {
                return response()->json(['result' => 0]);
            } else {

                // $user_dept = User::select('department_id')->where('name',  $_SESSION["user_name"])->get();
                MonthlyTarget::insert([
                    'paper_id' => $request->paper_id_edit,
                    'data_monthly_target' => $request->monthly_target_edit,
                    'month' => $request->month,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $fy_id
                ]);

                $check_total_used_paper_monthly_target = TotalUsedPaper::where('month', $request->month)
                    ->where('fiscal_year_id', $fy_id)
                    ->where('department_id', $_SESSION["user_department"])
                    ->get();

                if (count($check_total_used_paper_monthly_target) != 0) {
                    $get_monthly_target_in_total_used_paper = $check_total_used_paper_monthly_target[0]->monthly_target_id;
                    $get_quantity_in_total_used_paper = $check_total_used_paper_monthly_target[0]->quantity;

                    $updated_total_monthly_target = $get_monthly_target_in_total_used_paper + $request->monthly_target_edit;

                    if ($updated_total_monthly_target > $get_quantity_in_total_used_paper) {
                        $status = "Under";
                    } elseif ($updated_total_monthly_target < $get_quantity_in_total_used_paper) {
                        $status = "Over";
                    } else if ($updated_total_monthly_target == $get_quantity_in_total_used_paper) {
                        $status = "On Target";
                    }

                    TotalUsedPaper::where('month', $request->month)
                        ->where('fiscal_year_id', $fy_id)
                        ->where('department_id', $_SESSION["user_department"])
                        ->update([
                            'monthly_target_id' => $updated_total_monthly_target,
                            'status' => $status
                        ]);
                }

                Draft::where('id', $request->draft_id)
                    ->update([
                        'status' => 0
                    ]);

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
    }

    public function delete_monthly_target_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        Draft::where('id', $request->draft_id)
            ->update([
                'status' => 2
            ]);

        return response()->json(['result' => "1"]);
    }

    public function add_paper_purchases_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;

        $validator = Validator::make($data, [
            'paper_id' => 'required',
            'paper_purchase_quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {

            Draft::insert([
                'paper_id' => $request->paper_id,
                'paper_quantity' => $request->paper_purchase_quantity,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $fy_id,
                'category' => 'Paper Purchases',
                'status' => 1
            ]);

            DB::commit();
            return response()->json(['result' => 1]);
        }
    }

    public function get_id_edit_paper_purchased_draft(Request $request)
    {
        $paper_purchased_drafts = Draft::with(['paper'])->where('id', $request->draft_id)->get();

        // $monthly_used_drafts_month = Draft::with(['paper'])->where('id', $request->draft_id)->get();
        // $month = $monthly_used_drafts_month[0]->month;

        return response()->json(['drafts' => $paper_purchased_drafts]);
    }

    public function edit_paper_purchases_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        Draft::where('id', $request->draft_id)
            ->update([
                'paper_id' => $request->paper_id_edit,
                'paper_quantity' => $request->paper_purchase_quantity_edit
            ]);

        return response()->json(['result' => 1]);
    }

    public function submit_paper_purchases_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'paper_id_edit' => 'required',
            'paper_purchase_quantity_edit' => 'required|numeric',
        ]);

        //===== GET CURRENT FISCAL YEAR =====//
        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;
        //===== GET CURRENT FISCAL YEAR END =====//

        //===== MONTH NOW =====//
        $GetActiveMonth = DB::connection('mysql')->select("SELECT `active_month` FROM `month_config` WHERE `status` = '0'");
        $date_now = Carbon::now()->format('d');

        if($date_now == 01 || $date_now == 02 || $date_now == 03 || $date_now == 04 || $date_now == 05){
            if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                $monthNow = Carbon::now()->subMonth()->format('F');
                $nextMonth = Carbon::now()->format('F');
            }else{//Previous Month
                $monthNow = Carbon::now()->subMonths(2)->format('F');
                $nextMonth = Carbon::now()->format('F');
            }
        }else{
            if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                $monthNow = Carbon::now()->format('F');
                $nextMonth = Carbon::now()->addMonth()->format('F');
            }else{//Previous Month
                $monthNow = Carbon::now()->subMonth()->format('F');
                $nextMonth = Carbon::now()->format('F');
            }
            // $monthNow = Carbon::now()->format('F');                //uncomment to activate real month
            // $nextMonth = Carbon::now()->addMonth()->format('F');   //uncomment to activate real month
            // $monthNow = Carbon::now()->subMonth()->format('F');       //uncomment to activate previous month
            // $nextMonth = Carbon::now()->format('F');                  //uncomment to activate previous month
        }
        //===== MONTH NOW END =====//

        //===== CHECK BEGINNING BALANCE THIS MONTH =====//
        $check_beginning_balance = BeginningBalance::with(['paper'])
            ->where('month', $monthNow)
            ->where('fiscal_year_id', $fy_id)
            ->where('paper_id', $request->paper_id_edit)
            ->where('department_id', $_SESSION['user_department'])
            ->get();

        $check_beginning_balance_based_on_paperId = count($check_beginning_balance);
        //===== CHECK BEGINNING BALANCE THIS MONTH END =====//

        //===== CHECK BEGINNING BALANCE NEXT MONTH =====//
        $check_beginning_balance_next_month = BeginningBalance::with(['paper'])
            ->where('month', $nextMonth)
            ->where('fiscal_year_id', $fy_id)
            ->where('paper_id', $request->paper_id_edit)
            ->where('department_id', $_SESSION['user_department'])
            ->get();
        //===== CHECK BEGINNING BALANCE NEXT MONTH END =====//

        //===== CHECK ENDING BALANCE THIS MONTH =====//
        $check_month_end_balance = MonthEndBal::with(['paper'])
            ->where('month', $monthNow)
            ->where('fiscal_year_id', $fy_id)
            ->where('paper_id', $request->paper_id_edit)
            ->where('department_id', $_SESSION['user_department'])
            ->get();
        //===== CHECK ENDING BALANCE THIS MONTH END =====//

        //===== IF VALIDATION FAILS =====//
        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        //===== IF VALIDATION FAILS END =====//

        //===== IF BEGINNING BALANCE DOES NOT EXIST INSERT NEW DATA =====//
        elseif ($check_beginning_balance_based_on_paperId == 0) {
            //===== INSERT PAPER PURCHASED DATA =====//
            PaperPurchases::insert([
                'paper_id' => $request->paper_id_edit,
                'quantity' => $request->paper_purchase_quantity_edit,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $fy_id
            ]);
            //===== INSERT PAPER PURCHASED DATA END =====//

            //===== INSERT NEW BEGINNING BALANCE DATA =====//
            BeginningBalance::insert([
                'paper_id' => $request->paper_id_edit,
                'quantity' => $request->paper_purchase_quantity_edit,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $fy_id
            ]);
            //===== INSERT NEW BEGINNING BALANCE DATA END =====//

            //===== INSERT TO MONTH END BAL =====//
            MonthEndBal::insert([
                'paper_id' => $request->paper_id_edit,
                'quantity' => $request->paper_purchase_quantity_edit,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $fy_id
            ]);
            //===== INSERT TO MONTH END BAL END =====//

            Draft::where('id', $request->draft_id)
                ->update([
                    'status' => 0
                ]);

            DB::commit();
            return response()->json(['result' => 1]);
        }
        //===== IF BEGINNING BALANCE DOES NOT EXIST INSERT NEW DATA =====//

        //===== ON PAPER PURCHASE CHECK IF BEGINNING BALANCE ALREADY EXISTS THEN UPDATE BEGINNING BALANCE AND MONTH ENDING BALANCE =====//   //===== THEN INSERT THE PAPER PURCHASED  =====//
        elseif ($check_beginning_balance_based_on_paperId != 0) {
            if (count($check_beginning_balance_next_month) != 0) {
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//
                $quantity_based_on_paperId =  $check_beginning_balance[0]->quantity;
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//

                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//
                $quantity_based_on_paperId_next_month =  $check_beginning_balance_next_month[0]->quantity;
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//

                //===== GET MONTH ENDING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//
                $quantity_based_on_paperId_month_end =  $check_month_end_balance[0]->quantity;
                //===== GET MONTH ENDING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//

                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE =====//
                $new_beginning_balance = $quantity_based_on_paperId + $request->paper_purchase_quantity_edit;
                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE END =====//

                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE NEXT MONTH =====//
                $new_beginning_balance_next_month = $quantity_based_on_paperId_next_month + $request->paper_purchase_quantity_edit;
                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE NEXT MONTH END =====//

                //===== ADD NEWLY PURCHASED PAPER TO MONTH ENDING BALANCE IF THERE IS ALREADY A MONTH BALANCE =====//
                $new_month_end_balance = $quantity_based_on_paperId_month_end + $request->paper_purchase_quantity_edit;
                //===== ADD NEWLY PURCHASED PAPER TO MONTH ENDING BALANCE IF THERE IS ALREADY A MONTH BALANCE END =====//

                //===== UPDATE EXISTING BEGINNING BALANCE =====//
                BeginningBalance::where('paper_id', $request->paper_id_edit)
                    ->where('month', $request->month)
                    ->where('fiscal_year_id', $fy_id)
                    ->where('department_id', $_SESSION["user_department"])
                    ->update([
                        'quantity' => $new_beginning_balance
                    ]);
                //===== UPDATE EXISTING BEGINNING BALANCE END =====//

                //===== UPDATE EXISTING BEGINNING BALANCE FOR NEXT MONTH =====//
                BeginningBalance::where('paper_id', $request->paper_id_edit)
                    ->where('month', $nextMonth)
                    ->where('fiscal_year_id', $fy_id)
                    ->where('department_id', $_SESSION["user_department"])
                    ->update([
                        'quantity' => $new_beginning_balance_next_month
                    ]);
                //===== UPDATE EXISTING BEGINNING BALANCE END FOR NEXT MONTH =====//

                //===== UPDATE EXISTING MONTH ENDING BALANCE =====//
                MonthEndBal::where('paper_id', $request->paper_id_edit)
                    ->where('month', $request->month)
                    ->where('fiscal_year_id', $fy_id)
                    ->where('department_id', $_SESSION["user_department"])
                    ->update([
                        'quantity' => $new_month_end_balance
                    ]);
                //===== UPDATE EXISTING MONTH ENDING BALANCE END =====//

                //===== INSERT PAPER PURCHASED DATA =====//
                PaperPurchases::insert([
                    'paper_id' => $request->paper_id_edit,
                    'quantity' => $request->paper_purchase_quantity_edit,
                    'month' => $request->month,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $fy_id
                ]);
                //===== INSERT PAPER PURCHASED DATA END =====//

                Draft::where('id', $request->draft_id)
                    ->update([
                        'status' => 0
                    ]);

                DB::commit();
                return response()->json(['result' => 1]);
            } else {
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//
                $quantity_based_on_paperId =  $check_beginning_balance[0]->quantity;
                //===== GET BEGINNING BALANCE QUANTITY BASED ON PAPER ID FOR UPDATING REFERENCE =====//

                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE =====//
                $new_beginning_balance = $quantity_based_on_paperId + $request->paper_purchase_quantity_edit;
                //===== ADD NEWLY PURCHASED PAPER TO BEGINNING BALANCE IF THERE IS ALREADY A BEGINNING BALANCE END =====//

                //===== UPDATE EXISTING BEGINNING BALANCE =====//
                BeginningBalance::where('paper_id', $request->paper_id_edit)
                    ->where('month', $request->month)
                    ->where('fiscal_year_id', $fy_id)
                    ->where('department_id', $_SESSION["user_department"])
                    ->update([
                        'quantity' => $new_beginning_balance
                    ]);
                //===== UPDATE EXISTING BEGINNING BALANCE END =====//

                //===== INSERT PAPER PURCHASED DATA =====//
                PaperPurchases::insert([
                    'paper_id' => $request->paper_id_edit,
                    'quantity' => $request->paper_purchase_quantity_edit,
                    'month' => $request->month,
                    'department_id' => $_SESSION["user_department"],
                    'fiscal_year_id' => $fy_id
                ]);
                //===== INSERT PAPER PURCHASED DATA END =====//

                Draft::where('id', $request->draft_id)
                    ->update([
                        'status' => 0
                    ]);

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
        //===== ON PAPER PURCHASE CHECK IF BEGINNING BALANCE ALREADY EXISTS THEN UPDATE BEGINNING BALANCE AND MONTH ENDING BALANCE =====//   //===== THEN INSERT THE PAPER PURCHASED END =====//
    }

    public function delete_paper_purchases_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        Draft::where('id', $request->draft_id)
            ->update([
                'status' => 2
            ]);

        return response()->json(['result' => "1"]);
    }

    public function add_beginning_balance_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;

        $validator = Validator::make($data, [
            'paper_id' => 'required',
            'beginning_balance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {

            Draft::insert([
                'paper_id' => $request->paper_id,
                'paper_quantity' => $request->beginning_balance,
                'month' => $request->month,
                'department_id' => $_SESSION["user_department"],
                'fiscal_year_id' => $fy_id,
                'category' => 'Beginning Balance',
                'status' => 1
            ]);

            DB::commit();
            return response()->json(['result' => 1]);
        }
    }

    public function get_id_edit_beginning_balance_draft(Request $request)
    {
        $beginning_balance_drafts = Draft::with(['paper'])->where('id', $request->draft_id)->get();

        return response()->json(['drafts' => $beginning_balance_drafts]);
    }

    public function edit_beginning_balance_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        Draft::where('id', $request->draft_id)
            ->update([
                'paper_id' => $request->paper_id_edit,
                'paper_quantity' => $request->beginning_balance_edit
            ]);

        return response()->json(['result' => 1]);
    }

    public function submit_beginning_balance_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $result = FiscalYear::where('status', 0)
            ->get();
        $fy_id = $result[0]->id;

        $GetActiveMonth = DB::connection('mysql')->select("SELECT `active_month` FROM `month_config` WHERE `status` = '0'");
        $date_now = Carbon::now()->format('d');

        if($date_now == 01 || $date_now == 02 || $date_now == 03 || $date_now == 04 || $date_now == 05){
            if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                $monthNow = Carbon::now()->subMonth()->format('F');
                $nextMonth = Carbon::now()->format('F');
            }else{//Previous Month
                $monthNow = Carbon::now()->subMonths(2)->format('F');
                $nextMonth = Carbon::now()->format('F');
            }
        }else{
            if($GetActiveMonth[0]->active_month == 1){//Real-Time Month
                $monthNow = Carbon::now()->format('F');
                $nextMonth = Carbon::now()->addMonth()->format('F');
            }else{//Previous Month
                $monthNow = Carbon::now()->subMonth()->format('F');
                $nextMonth = Carbon::now()->format('F');
            }

            // $monthNow = Carbon::now()->format('F');                //uncomment to activate real month
            // $nextMonth = Carbon::now()->addMonth()->format('F');   //uncomment to activate real month
            // $monthNow = Carbon::now()->subMonth()->format('F');       //uncomment to activate previous month
            // $nextMonth = Carbon::now()->format('F');                  //uncomment to activate previous month
        }

        $validator = Validator::make($data, [
            'paper_id_edit' => 'required',
            'beginning_balance_edit' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            //===== CHECK BEGINNING BALANCE BASED ON PAPER USED =====//
            $check_beginning_balance = BeginningBalance::with(['paper'])
                ->with(['fiscal_year'])
                ->where('paper_id', $request->paper_id_edit)
                ->where('fiscal_year_id', $fy_id)
                ->where('month', $monthNow)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== CHECK BEGINNING BALANCE BASED ON PAPER USED END =====//

            //===== CHECK MONTH ENDING BALANCE BASED ON PAPER USED =====//
            $check_month_end_balance = MonthEndBal::with('paper')
                ->with('fiscal_year')
                ->where('paper_id', $request->paper_id_edit)
                ->where('month', $monthNow)
                ->where('fiscal_year_id', $fy_id)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== CHECK MONTH ENDING BALANCE BASED ON PAPER USED END =====//

            //===== CHECK BEGINNING BALANCE NEXT MONTH =====//
            $check_beginning_balance_next_month = BeginningBalance::with(['paper'])
                ->where('month', $nextMonth)
                ->where('fiscal_year_id', $fy_id)
                ->where('paper_id', $request->paper_id_edit)
                ->where('department_id', $_SESSION['user_department'])
                ->get();
            //===== CHECK BEGINNING BALANCE NEXT MONTH END =====//

            if (count($check_beginning_balance) == 0) {
                BeginningBalance::insert([
                    'quantity' => $request->beginning_balance_edit,
                    'month' => $request->month,
                    'paper_id' => $request->paper_id_edit,
                    'department_id' => $_SESSION['user_department'],
                    'fiscal_year_id' => $fy_id
                ]);
            } else {
                $get_existing_balance = $check_beginning_balance[0]->quantity;
                $new_beginning_balance = $get_existing_balance + $request->beginning_balance_edit;

                BeginningBalance::where('department_id', $_SESSION['user_department'])
                    ->where('month', $request->month)
                    ->where('paper_id', $request->paper_id_edit)
                    ->where('fiscal_year_id', $fy_id)
                    ->update([
                        'quantity' => $new_beginning_balance,
                        'month' => $request->month,
                        'paper_id' => $request->paper_id_edit,
                        'department_id' => $_SESSION['user_department'],
                        'fiscal_year_id' => $fy_id
                    ]);

                if (count($check_month_end_balance) != 0) {
                    $get_existing_balance = $check_month_end_balance[0]->quantity;
                    $new_month_end_balance = $get_existing_balance + $request->beginning_balance_edit;

                    MonthEndBal::where('department_id', $_SESSION['user_department'])
                        ->where('month', $request->month)
                        ->where('paper_id', $request->paper_id_edit)
                        ->where('fiscal_year_id', $fy_id)
                        ->update([
                            'quantity' => $new_month_end_balance,
                        ]);

                    if (count($check_beginning_balance_next_month) != 0) {
                        $get_existing_balance = $check_beginning_balance_next_month[0]->quantity;
                        $new_beginning_balance_next_month = $get_existing_balance + $request->beginning_balance_edit;

                        BeginningBalance::where('department_id', $_SESSION['user_department'])
                            ->where('month', $nextMonth)
                            ->where('paper_id', $request->paper_id_edit)
                            ->where('fiscal_year_id', $fy_id)
                            ->update([
                                'quantity' => $new_beginning_balance_next_month,
                            ]);
                    } else {
                        // $get_existing_balance = $check_beginning_balance_next_month[0]->quantity;
                        // $new_beginning_balance_next_month = $get_existing_balance + $request->beginning_balance;
                        $get_existing_balance = $check_month_end_balance[0]->quantity;
                        $new_beginning_balance_next_month = $get_existing_balance + $request->beginning_balance_edit;

                        BeginningBalance::insert([
                            'quantity' => $new_beginning_balance_next_month,
                            'month' => $nextMonth,
                            'paper_id' => $request->paper_id_edit,
                            'department_id' => $_SESSION['user_department'],
                            'fiscal_year_id' => $fy_id
                        ]);
                    }
                } else {
                    MonthEndBal::insert([
                        'quantity' => $request->beginning_balance_edit,
                        'month' => $request->month,
                        'paper_id' => $request->paper_id_edit,
                        'department_id' => $_SESSION['user_department'],
                        'fiscal_year_id' => $fy_id
                    ]);
                }
            }

            Draft::where('id', $request->draft_id)
                ->update([
                    'status' => 0
                ]);

            DB::commit();
            return response()->json(['result' => 1]);
        }
    }

    public function delete_beginning_balance_draft(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        Draft::where('id', $request->draft_id)
            ->update([
                'status' => 2
            ]);

        return response()->json(['result' => "1"]);
    }
}
