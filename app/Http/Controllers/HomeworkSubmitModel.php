<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class HomeworkSubmitModel extends Model
{
    use HasFactory;

    protected $table = 'homework_submit';

    static public function getRecordStudent($student_id)
    {
        $return = HomeworkSubmitModel::select('homework_submit.*', 'class.name as class_name', 'subject.name as subject_name')
                        ->join('homework','homework.id', '=', 'homework_submit.homework_id')
                        ->join('class', 'class.id', '=', 'homework.class_id')
                        ->join('subject', 'subject.id', '=', 'homework.subject_id')
                        ->where('homework_submit.student_id', '=', $student_id);

                if(!empty(Request::get('class_name')))
                {
                    $return = $return->where('class.name', 'like', '%'.Request::get('class_name').'%');
                }

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
                    $return = $return->whereDate('homework_submit.created_at', '>=', Request::get('from_created_date'));
                }

                if(!empty(Request::get('to_created_date')))
                {
                    $return = $return->whereDate('homework_submit.created_at', '<=', Request::get('to_created_date'));
                }


        $return = $return->orderBy('homework_submit.id', 'desc')
                        ->paginate(20);

        return $return;
    }
}
