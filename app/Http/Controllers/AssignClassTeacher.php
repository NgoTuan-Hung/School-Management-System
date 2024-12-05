<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AssignClassTeacherModel;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class AssignClassTeacher extends Controller
{
    public function list(Request $request)
{
    $getRecord = AssignClassTeacherModel::getRecord();

    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'data' => $getRecord,
            'message' => 'Assign class teacher list retrieved successfully.'
        ], 200);
    }
    // Nếu không phải API, trả về view như cũ
    $data['getRecord'] = $getRecord;
    $data['header_title'] = "Assign Class Teacher";
    return view('admin.assign_class_teacher.list', $data);
}


    public function add(Request $request){
        $getClass = ClassModel::getClass();
        $getTeacher =  User::getTeacherClass();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'class' => $getClass,
                'teacher'=> $getTeacher,
                'message' => 'Assign class teacher list retrieved successfully.'
            ], 200);
        }

        $data['header_title'] = "Add Assign Class Teacher";
        $data['getClass'] = $getClass;
        $data['getTeacher'] = $getTeacher;
        return view('admin.assign_class_teacher.add', $data);
    }

    public function insert(Request $request){
        if(!empty($request->teacher_id)){
            foreach($request->teacher_id as $teacher_id)
            {
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if(!empty($getAlreadyFirst))
                {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
                else{
                    $save = new AssignClassTeacherModel();
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_class_teacher/list')->with('success', "Assign Class to Teacher Successfully");

        }
        else{
            return redirect()->back()->with('error', 'Due to some error pls try again');

        }

    }


    public function edit($id)
    {
        $getRecord = AssignClassTeacherModel::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getAssignTeacherID'] = AssignClassTeacherModel::getAssignTeacherID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = "Edit Assign Class Teacher";
            return view('admin.assign_class_teacher.edit', $data);    
        }
        else
        {
            abort(404);
        }
        
    }


}
