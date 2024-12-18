<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekModel extends Model
{
    use HasFactory;

    protected $table = 'week';

    static public function getRecord()
    {
        return WeekModel::get();
    }

    static public function getWeekUsingName($weekname)
    {
        return WeekModel::where('name','=',$weekname)->first();
    }

}
