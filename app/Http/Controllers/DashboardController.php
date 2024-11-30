<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Models\StudentAddFeesModel;
use App\Models\ClassSubjectModel;
use App\Models\HomeworkModel;



class DashboardController extends Controller
{
    public function dashboard()
    {
        #title:
            $data['header_title'] = 'Dashboard';
            if(Auth::user()-> user_type == 1)
            {
                return view('admin.dashboard',data: $data);
            }
            else if(Auth::user()-> user_type== 2)
            {
                return view('teacher.dashboard',data: $data);
            }
            else if(Auth::user()-> user_type== 3)
            {
            $data['TotalPaidAmount'] = StudentAddFeesModel::TotalPaidAmountStudent(Auth::user()->id);
            $data['TotalSubject'] = ClassSubjectModel::MySubjectTotal(Auth::user()->class_id);       
            // $data['TotalNoticeBoard'] = NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            // $data['TotalHomework'] = HomeworkModel::getRecordStudentCount(Auth::user()->class_id, Auth::user()->id);

            // $data['TotalSubmittedHomework'] = HomeworkSubmitModel::getRecordStudentCount(Auth::user()->id);
            
            // $data['TotalAttendance'] = StudentAttendanceModel::getRecordStudentCount(Auth::user()->id);
                return view('student.dashboard',data: $data);
            }
            else if(Auth::user()-> user_type== 4)
            {
            //$student_ids = User::getMyStudentIds(Auth::user()->id);
            //$class_ids = User::getMyStudentClassIds(Auth::user()->id);

            // if(!empty($student_ids))
            // {
            //     $data['TotalPaidAmount'] = StudentAddFeesModel::TotalPaidAmountStudentParent($student_ids);
            //     $data['TotalAttendance'] = StudentAttendanceModel::getRecordStudentParentCount($student_ids);

            //     $data['TotalSubmittedHomework'] = HomeworkSubmitModel::getRecordStudentParentCount($student_ids);
            // }
            // else
            // {
            //     $data['TotalPaidAmount'] = 0;
            //     $data['TotalAttendance'] = 0;
            //     $data['TotalSubmittedHomework'] = 0;
            // }
            

            //$data['getTotalFees'] = StudentAddFeesModel::getTotalFees();
            $data['TotalStudent'] = User::getMyStudentCount(Auth::user()->id);
            //$data['TotalNoticeBoard'] = NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            return view('parent.dashboard', $data);
            }
    }
}
