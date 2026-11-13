<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mail;
use App\User;
use App\MonthlyUsedPaper;
use App\FiscalYear;
use App\Department;
use App\TotalUsedPaper;
use Carbon\Carbon;

class MailController extends Controller
{
    public function send_mail()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        // $monthNow = Carbon::now()->format('F');

        $get_current_fiscal_year = FiscalYear::where('status', 0)
            ->get();

        $current_fy_id = $get_current_fiscal_year[0]->id;

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
            // $monthNow = Carbon::now()->subMonth()->format('F'); //uncomment to activate previous month
            // $nextMonth = Carbon::now()->format('F');            //uncomment to activate previous month
        }

        $count_monthly_used_data_for_the_month = TotalUsedPaper::where('month', $monthNow)
            ->where('fiscal_year_id', $current_fy_id)
            ->orderBy('department_id')
            ->get()
            ->unique('department_id');

        // return $count_monthly_used_data_for_the_month;

        $departments_id = array();
        for ($i = 0; $i < count($count_monthly_used_data_for_the_month); $i++) {
            $departments_id[] = $count_monthly_used_data_for_the_month[$i]->department_id;
        }


        $recipients = User::whereNotIn('department_id', $departments_id)
            ->where('status', 0)
            ->get()->pluck('email')->toArray();

        // dump($recipients);
        // return $recipients;
        // return $monthNow;

        // $recipients = User::where('status', 0)
        //     ->get()->pluck('email')->toArray();

        $data = array('' => "");

        Mail::send('email_content', $data, function ($message) use ($recipients) {
            $message->to($recipients)
                ->subject('EMAIL REMINDER FOR UPDATING Paper Consumption')
                ->from('issinfoservice@pricon.ph', 'Paper Consumption Monitoring Reminder')
                ->bcc('cdcasuyon@pricon.ph');
        });
    }
}
