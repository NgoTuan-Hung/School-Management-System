<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MarksRegisterModel;




class ExamScheduleModel extends Model
{
    use HasFactory;

    protected $table = 'exam_schedule';

     static public function getSingle($id)
    {
        return self::find($id);
    }


    static public function getRecordSingle($exam_id, $class_id, $subject_id)
    {
        return ExamScheduleModel::where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->first();
    }

    static public function deleteRecord($exam_id, $class_id)
    {
        ExamScheduleModel::where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->delete();
    }


    static public function getExam($class_id)
{
    return self::select('exam_schedule.exam_id', 'exam.name as exam_name')
               ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
               ->where('exam_schedule.class_id', '=', $class_id)
               ->groupBy('exam_schedule.exam_id', 'exam.name') // Bao gồm các cột cần thiết trong GROUP BY
               ->orderBy('exam_schedule.exam_id', 'desc') // Sắp xếp theo exam_id
               ->get();
}


static public function getExamTeacher($teacher_id)
{
    return ExamScheduleModel::select('exam_schedule.exam_id', 'exam.name as exam_name')
            ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'exam_schedule.class_id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->groupBy('exam_schedule.exam_id', 'exam.name')
            ->orderBy('exam_schedule.exam_id', 'desc')
            ->get();
}


    static public function getExamTimetable($exam_id, $class_id)
    {
        return ExamScheduleModel::select('exam_schedule.*', 'subject.name as subject_name', 'subject.type as subject_type')
                ->join('subject', 'subject.id', '=', 'exam_schedule.subject_id')
                ->where('exam_schedule.exam_id','=',$exam_id)
                ->where('exam_schedule.class_id','=',$class_id)
                ->get();
    }


    static public function getSubject($exam_id, $class_id)
    {
        return ExamScheduleModel::select('exam_schedule.*', 'subject.name as subject_name', 'subject.type as subject_type')
                ->join('subject', 'subject.id', '=', 'exam_schedule.subject_id')
                ->where('exam_schedule.exam_id','=',$exam_id)
                ->where('exam_schedule.class_id','=',$class_id)
                ->get();
    }

    

    static public function getExamTimetableTeacher($teacher_id)
    {
        return ExamScheduleModel::select('exam_schedule.*', 'class.name as class_name','subject.name as subject_name','exam.name as exam_name')
                ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'exam_schedule.class_id')
                ->join('class', 'class.id', '=', 'exam_schedule.class_id')
                ->join('subject', 'subject.id', '=', 'exam_schedule.subject_id')
                ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                ->get();
    }

    static public function getMark($student_id, $exam_id, $class_id, $subject_id)
    {
        return MarksRegisterModel::CheckAlreadyMark($student_id, $exam_id, $class_id, $subject_id);
    }
}
