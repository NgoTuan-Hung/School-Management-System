<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\StudentAttendanceModel;
use App\Models\AssignClassTeacherModel;
use App\Exports\ExportAttendance;
use Auth;
use Excel;


class AttendanceController extends Controller
{
    public function MyAttendanceParent($student_id)
    {
        $data['getStudent'] = User::getSingle($student_id);
        $data['getClass'] = StudentAttendanceModel::getClassStudent($student_id);
        $data['getRecord'] = StudentAttendanceModel::getRecordStudent($student_id);
        $data['header_title'] = "Student Attendance";
        return view('parent.my_attendance', $data);
    }
}
