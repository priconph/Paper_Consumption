<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Department;
use App\Paper;
use App\MonthlyUsedPaper;
use App\MonthlyTarget;
use App\FiscalYear;

class TotalUsedPaper extends Model
{
    protected $table = 'total_used_papers';
    protected $connection = 'mysql';

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function monthly_used_paper()
    {
        return $this->hasOne(MonthlyUsedPaper::class, 'id', 'monthly_used_paper_id');
    }

    public function fiscal_year()
    {
        return $this->hasOne(FiscalYear::class, 'id', 'fiscal_year_id');
    }

    public function paper()
    {
        return $this->hasOne(Paper::class, 'id', 'paper_id');
    }

    public function monthly_target()
    {
        return $this->hasOne(MonthlyTarget::class, 'id', 'monthly_target_id');
    }
}
