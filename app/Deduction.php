<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FiscalYear;
use App\Department;

class Deduction extends Model
{
    public function fiscal_year()
    {
        return $this->hasOne(FiscalYear::class, 'id', 'fiscal_year_id');
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}
