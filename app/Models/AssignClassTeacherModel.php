<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class AssignClassTeacherModel extends Model
{
    use HasFactory;
    protected $table = 'assign_class_teacher';

    static public function getAlreadyFirst($class_id, $teacher_id)
    {
        return self::where('class_id','=',$class_id)->where('teacher_id','=',$teacher_id)
        ->first();
    }
    static public function getRecord()
     {
        $return = self::select('assign_class_teacher.*', 'class.name as class_name', 'teacher.name as teacher_name', 'teacher.last_name as teacher_last_name', 'users.name as created_by_name')
                    ->join('users as teacher', 'teacher.id', '=', 'assign_class_teacher.teacher_id')
                    ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
                    ->join('users', 'users.id', '=', 'assign_class_teacher.created_by')
                    ->where('assign_class_teacher.is_delete', '=', 0);

                    if(!empty(request()->get('class_name')))
                    {
                        $return = $return->where('class.name', 'like', '%'.request()->get('class_name').'%');
                    }

                    if (!empty(request()->get('teacher_name'))) {
                        $name = request()->get('teacher_name');
                    
                        // Tách từ nhập vào thành mảng các từ
                        $keywords = explode(' ', $name);
                    
                        // Tìm kiếm tất cả các từ trong first_name và last_name
                        $return = $return->where(function ($query) use ($keywords) {
                            foreach ($keywords as $keyword) {
                                $query->orWhere(function($q) use ($keyword) {
                                    $q->where('teacher.name', 'like', '%'. $keyword .'%')
                                    ->orWhere('teacher.last_name', 'like', '%'. $keyword .'%');
                                });
                            }
                        });
                    }
                    

                    if(!empty(request()->get('status')))
                    {
                        $status = (request()->get('status') == 100) ? 0 : 1;
                        $return = $return->where('assign_class_teacher.status', '=', $status);
                    }

                    if(!empty(request()->get('date')))
                    {
                        $return = $return->whereDate('assign_class_teacher.created_at', '=', request()->get('date'));
                    }
        $return = $return->orderBy('assign_class_teacher.id', 'desc')
                    ->paginate(20);

        return $return;
                    
    }

    static public function getSingle($id){
        return self::find($id);
    }


    static public function getAssignTeacherID($class_id)
    {
        return self::where('assign_class_teacher.class_id', '=', $class_id)->where('is_delete', '=', 0)->get();

    }
}
