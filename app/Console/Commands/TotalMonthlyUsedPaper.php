<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Department;
use App\MonthlyUsedPaper;
use App\TotalUsedPaper;
use App\FiscalYear;
use App\Paper;
use App\PaperPurchases;


class TotalMonthlyUsedPaper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'total:used';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Total monthly used paper';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

            $result = FiscalYear::where('status', 0)
            ->get();
            $year = collect($result)->pluck('year')->flatten(1);
            $year_id = collect($result)->pluck('id')->flatten(1);

            $fy = $result[0]->year;
            $fy_id = $result[0]->id;

            $fullMonth = Carbon::now()->format('F'); // Month now
            $lastMonth = Carbon::now()->subMonth()->format('F'); // Last month

            // $fullMonth = "November";
            // $lastMonth = "October";

            $first_department_id = Department::where('id', 1)->get();
            $first_department = $first_department_id[0]->id;

            $second_department_id = Department::where('id', 2)->get();
                $second_department = $second_department_id[0]->id;

            $third_department_id = Department::where('id', 3)->get();
                $third_department = $third_department_id[0]->id;
            
            $fourth_department_id = Department::where('id', 4)->get();
                $fourth_department = $fourth_department_id[0]->id;
            
            $fifth_department_id = Department::where('id', 5)->get();
                $fifth_department = $fifth_department_id[0]->id;

            $sixth_department_id = Department::where('id', 6)->get();
                $sixth_department = $sixth_department_id[0]->id;

            $seventh_department_id = Department::where('id', 7)->get(); 
                $seventh_department = $seventh_department_id[0]->id;

            $eighth_department_id = Department::where('id', 8)->get();
                $eighth_department = $eighth_department_id[0]->id;

            $ninth_department_id = Department::where('id', 9)->get();
                $ninth_department = $ninth_department_id[0]->id;
            
            $tenth_department_id = Department::where('id', 10)->get();
                $tenth_department = $tenth_department_id[0]->id;

            $eleventh_department_id = Department::where('id', 11)->get();
                $eleventh_department = $eleventh_department_id[0]->id;

            $twelfth_department_id = Department::where('id', 12)->get();
                $twelfth_department = $twelfth_department_id[0]->id;

            $thirteenth_department_id = Department::where('id', 13)->get();
                $thirteenth_department = $thirteenth_department_id[0]->id;

            $fourteenth_department_id = Department::where('id', 14)->get();
                $fourteenth_department = $fourteenth_department_id[0]->id;

            if($first_department == 1)
            {
                $total = MonthlyUsedPaper::where('department_id', 1)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 1
                    ]);
                }
            }

            if($second_department == 2)
            {
                $total = MonthlyUsedPaper::where('department_id', 2)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 2
                    ]);
                }
            }

            if($third_department == 3)
            {
                $total = MonthlyUsedPaper::where('department_id', 3)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 3
                    ]);
                }
            }

            if($fourth_department == 4)
            {
                $total = MonthlyUsedPaper::where('department_id', 4)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 4
                    ]);
                }
            }

            if($fifth_department == 5)
            {
                $total = MonthlyUsedPaper::where('department_id', 5)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 5
                    ]);
                }
            }

            if($sixth_department == 6)
            {
                $total = MonthlyUsedPaper::where('department_id', 6)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 6
                    ]);
                }
            }

            if($seventh_department == 7)
            {
                $total = MonthlyUsedPaper::where('department_id', 7)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 7
                    ]);
                }
            }

            if($eighth_department == 8)
            {
                $total = MonthlyUsedPaper::where('department_id', 8)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 8
                    ]);
                }
            }

            if($ninth_department == 9)
            {
                $total = MonthlyUsedPaper::where('department_id', 9)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 9
                    ]);
                }
            }

            if($tenth_department == 10)
            {
                $total = MonthlyUsedPaper::where('department_id', 10)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 10
                    ]);
                }
            }

            if($eleventh_department == 11)
            {
                $total = MonthlyUsedPaper::where('department_id', 11)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 11
                    ]);
                }
            }

            if($twelfth_department == 12)
            {
                $total = MonthlyUsedPaper::where('department_id', 12)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 12
                    ]);
                }
            }

            if($thirteenth_department == 13)
            {
                $total = MonthlyUsedPaper::where('department_id', 13)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 13
                    ]);
                }
            }

            if($fourteenth_department == 14)
            {
                $total = MonthlyUsedPaper::where('department_id', 14)
                ->where('month', $lastMonth)
                ->where('fiscal_year_id', $year_id)
                ->sum('data_monthly_used_paper');

                if($fullMonth != $lastMonth)
                {
                    TotalUsedPaper::insert([
                        'quantity' => $total,
                        'month' => $lastMonth,
                        'year' => $fy,
                        'fiscal_year_id' => $fy_id,
                        'department_id' => 14
                    ]);
                }
            }
        
        $this->info('Total of used paper for the month computed!');
    }
}
