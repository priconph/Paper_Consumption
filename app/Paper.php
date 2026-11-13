<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MonthlyTarget;

class Paper extends Model
{
    protected $table = 'papers';
    protected $connection = 'mysql';
}
