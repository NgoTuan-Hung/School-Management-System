<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';


    static public function getRecord()
    {
        $return = self::select('class.*','users.name as created_by_name') 
                                -> join('users','users.id','class.created_by')
                                ->orderBy('class.id','asc');
                            if(!empty(request()->get('name')))
                            {
                                $return = $return->where('class.name','like','%'.request()->get('name').'%');

                            }
                            if (!empty(request()->get('date'))) {
                                $return = $return->whereDate('class.created_at' ,'=' ,request()->get('date'));
                            }             
                            $return = $return   ->where('class.is_delete','=',0) 
                                                -> orderBy('id','asc')
                                                -> paginate(5);
            return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getClass()
    {
        $return = self::select('class.*')
                        -> join('users','users.id','class.created_by')
                        -> where('class.is_delete','=',0)
                        -> where('class.status','=',0)
                        -> orderBy('class.name','asc')
                        -> get();
        return $return;
    }
}
