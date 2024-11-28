<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getStudent();
        $data['header_title'] = 'Student List';
        return view('admin.student.list',$data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = 'Add New Student';
        return view('admin.student.add',$data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'weight' => 'max:10',
            'blood_group' => 'max:10',
            'mobile_number' => 'max:15|min:8',
            'admission_number' => 'max:50',
            'roll_number' => 'max:50',
            'caste' => 'max:50',
            'religion' => 'max:50',
            'height' => 'max:10',
        ], [
            // Custom error messages for 'email'
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
        
            // Custom error messages for 'weight'
            'weight.max' => 'Weight must not exceed 10 characters.',
        
            // Custom error messages for 'blood_group'
            'blood_group.max' => 'Blood group must not exceed 10 characters.',
        
            // Custom error messages for 'mobile_number'
            'mobile_number.max' => 'Mobile number must not exceed 15 characters.',
            'mobile_number.min' => 'Mobile number must be at least 8 characters.',
        
            // Custom error messages for 'admission_number'
            'admission_number.max' => 'Admission number must not exceed 50 characters.',
        
            // Custom error messages for 'roll_number'
            'roll_number.max' => 'Roll number must not exceed 50 characters.',
        
            // Custom error messages for 'caste'
            'caste.max' => 'Caste must not exceed 50 characters.',
        
            // Custom error messages for 'religion'
            'religion.max' => 'Religion must not exceed 50 characters.',
        
            // Custom error messages for 'height'
            'height.max' => 'Height must not exceed 10 characters.',
        ]);
        



        $student = new User;
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->admission_number = trim($request->admission_number);
        $student->roll_number = trim($request->roll_number);
        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);
        if(!empty($request->date_of_birth))
        {
            $student->date_of_birth = trim($request->date_of_birth);    
        }

        //Save image file on upload folder
        if(!empty($request->file('profile_pic')))
        {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');   
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(base_path('upload/profile/'), $filename);

            $student->profile_pic = $filename;            
        }

        $student->caste = trim($request->caste);
        $student->religion = trim($request->religion);
        $student->mobile_number = trim($request->mobile_number);

        if(!empty($request->admission_date))
        {
            $student->admission_date = trim($request->admission_date);    
        }

        $student->blood_group = trim($request->blood_group);
        $student->height = trim($request->height);
        $student->weight = trim($request->weight);
        $student->status = trim($request->status);
        $student->email = trim($request->email);
        $student->password = Hash::make($request->password);
        $student->user_type = 3;
        $student->save();

        return redirect('admin/student/list')->with('success', "Student Successfully Created");
    
    }

    
    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = "Edit Student";
            return view('admin.student.edit',$data);    
        }
        else
        {
            abort(404);
        }
        
    }

    public function update($id, Request $request)
    {
        //vaildation:
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'weight' => 'max:10',
            'blood_group' => 'max:10',
            'mobile_number' => 'max:15|min:8',            
            'admission_number' => 'max:50',
            'roll_number' => 'max:50',
            'caste' => 'max:50',
            'religion' => 'max:50',
            'height' => 'max:10'            
        ], [
            // Custom error messages
            'email.required' => 'Email address is required. Please provide one.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken. Please choose another one.',
            
            'weight.max' => 'Weight cannot be more than 10 characters.',
            'blood_group.max' => 'Blood group name cannot be more than 10 characters.',
            'mobile_number.min' => 'Mobile number must be at least 8 digits.',
            'mobile_number.max' => 'Mobile number cannot exceed 15 digits.',
            
            'admission_number.max' => 'Admission number can only have a maximum of 50 characters.',
            'roll_number.max' => 'Roll number can only have a maximum of 50 characters.',
            'caste.max' => 'Caste field can only have a maximum of 50 characters.',
            'religion.max' => 'Religion field can only have a maximum of 50 characters.',
            
            'height.max' => 'Height can only have a maximum of 10 characters.'
        ]);
        
        $student = User::getSingle($id);;
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->admission_number = trim($request->admission_number);
        $student->roll_number = trim($request->roll_number);
        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);

        if(!empty($request ->date_of_birth))
        {
            $student-> date_of_birth =trim($request->date_of_birth);
        }

        //unlink the image:
        if(!empty($request->file('profile_pic')))
        {
            if(!empty($student->getProfile()))
            {
                unlink('upload/profile/'.$student->profile_pic);
            }

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');   
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(base_path('upload/profile/'), $filename);

            $student->profile_pic = $filename; 
        }


        $student->caste = trim($request->caste);
        $student->religion = trim($request->religion);
        $student->mobile_number = trim($request->mobile_number);

        if(!empty($request->admission_date))
        {
            $student->admission_date = trim($request->admission_date);    
        }
        
        $student->blood_group = trim($request->blood_group);
        $student->height = trim($request->height);
        $student->weight = trim($request->weight);
        $student->status = trim($request->status);
        $student->email = trim($request->email);

        if(!empty($request->password))
        {
            $student->password = Hash::make($request->password);    
        }
        
        $student->save();

        return redirect('admin/student/list')->with('success', "Student Successfully Updated");
    }

    public function delete($id)
    {
        $getRecord = User::getSingle($id);
        if(!empty($getRecord))
        {
            $getRecord->is_delete = 1;
            $getRecord->save();

            return redirect()->back()->with('success', "Student Successfully Deleted");
        }
        else
        {
            abort(404);
        }
    }
    
}
