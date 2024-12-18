<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
class HomeworkModel extends Model
{
    use HasFactory;

    protected $table = 'homework';

    static public function getRecordStudent($class_id, $student_id)
    {
        $return = HomeworkModel::select('homework.*', 'class.name as class_name', 'subject.name as subject_name', 'users.name as created_by_name')
                ->join('users', 'users.id', '=', 'homework.created_by')
                ->join('class', 'class.id', '=', 'homework.class_id')
                ->join('subject', 'subject.id', '=', 'homework.subject_id')
                ->where('homework.class_id', '=' , $class_id)
                ->where('homework.is_delete', '=', 0)
                ->whereNotIn('homework.id',function($query) use ($student_id) {
                   $query->select('homework_submit.homework_id')
                            ->from('homework_submit')
                            ->where('homework_submit.student_id', '=', $student_id);
                });

                if(!empty(Request::get('subject_name')))
                {
                    $return = $return->where('subject.name', 'like', '%'.Request::get('subject_name').'%');
                }

                if(!empty(Request::get('from_homework_date')))
                {
                    $return = $return->where('homework.homework_date', '>=', Request::get('from_homework_date'));
                }

                if(!empty(Request::get('to_homework_date')))
                {
                    $return = $return->where('homework.homework_date', '<=', Request::get('to_homework_date'));
                }


                if(!empty(Request::get('from_submission_date')))
                {
                    $return = $return->where('homework.submission_date', '>=', Request::get('from_submission_date'));
                }

                if(!empty(Request::get('to_submission_date')))
                {
                    $return = $return->where('homework.submission_date', '<=', Request::get('to_submission_date'));
                }

                if(!empty(Request::get('from_created_date')))
                {
                    $return = $return->whereDate('homework.created_at', '>=', Request::get('from_created_date'));
                }

                if(!empty(Request::get('to_created_date')))
                {
                    $return = $return->whereDate('homework.created_at', '<=', Request::get('to_created_date'));
                }

                
                $return = $return->orderBy('homework.id', 'desc')
                ->paginate(20);

        return $return;
    }
}
