<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class StudentAttendanceModel extends Model
{
    use HasFactory;

    protected $table = 'student_attendance';


    static public function getClassStudent($student_id)
    {
        return StudentAttendanceModel::select('student_attendance.*', 'class.name as class_name')
                    ->join('class', 'class.id', '=', 'student_attendance.class_id')
                    ->where('student_attendance.student_id', '=', $student_id)
                    ->groupBy('student_attendance.class_id')
                    ->get();
    }

    static public function getRecordStudent($student_id)
    {
        $return =  StudentAttendanceModel::select('student_attendance.*', 'class.name as class_name')
                    ->join('class', 'class.id', '=', 'student_attendance.class_id')
                    ->where('student_attendance.student_id', '=', $student_id);

                    if(!empty(Request::get('class_id')))
                    {
                        $return = $return->where('student_attendance.class_id', '=', Request::get('class_id'));
                    }

                    if(!empty(Request::get('attendance_type')))
                    {
                        $return = $return->where('student_attendance.attendance_type', '=', Request::get('attendance_type'));
                    }

                    if(!empty(Request::get('start_attendance_date')))
                    {
                        $return = $return->where('student_attendance.attendance_date', '>=', Request::get('start_attendance_date'));
                    }

                    if(!empty(Request::get('end_attendance_date')))
                    {
                        $return = $return->where('student_attendance.attendance_date', '<=', Request::get('end_attendance_date'));
                    }

        $return = $return->orderBy('student_attendance.id', 'desc')
                        ->paginate(50);
        return $return;
    }
}
