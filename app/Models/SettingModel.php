<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    use HasFactory;

    protected $table = 'setting';

    static public function getSingle()
    {
        return self::find(1);
    }

    public function getLogo()
    {
        if(!empty($this->logo) && file_exists('upload/setting/'.$this->logo))
        {
            return url('upload/setting/'.$this->logo);
        }
        else
        {
            return '';
        }
    }
}
