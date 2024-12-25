<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use Hash;




class CrouseDetail extends Controller
{
    public function ShowCrouseDetails($id)
    {
        $data['getRecord'] = ClassModel::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = "Class Detail";
            return view('school.details',$data);    
        }
        else
        {
            abort(404);
        }
        
    }


    public function RegisterStudent(Request $request, $id)
    {
        // dd([
        //     'request_data' => $request->all(), // Lấy tất cả dữ liệu từ request
        //     'id' => $id, // Lấy giá trị của $id
        // ]);
    
        // request()->validate([
        //     'email' => 'required|email|unique:users'
        // ]);
    
        $register_student =  new User();
        $register_student->name = trim($request->name);
        $register_student->email = trim($request->email);
        $register_student->password = Hash::make($request->password);
        $register_student->user_type = 3;
        $register_student-> is_student = 1;
        $register_student-> class_id = $id;
    
        $register_student->save();
        return redirect()->back()->with('success', "Successfully created");
    
    }
}
