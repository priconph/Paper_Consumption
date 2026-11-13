<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Paper;
use App\Department;
use App\FiscalYear;

class MonthlyTarget extends Model
{
    protected $table = 'monthly_targets';
    protected $connection = 'mysql';

    public function paper()
    {
        return $this->hasOne(Paper::class, 'id', 'paper_id');
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function fiscal_year()
    {
        return $this->hasOne(FiscalYear::class, 'id', 'fiscal_year_id');
    }
}
