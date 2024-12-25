<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SettingModel;
use Illuminate\Support\Facades\Auth;
use Hash;
use Str;

class UserController extends Controller
{

    public function Setting()
    {
        $data['getRecord'] = SettingModel::getSingle();
        $data['header_title'] = "Setting";
        return view('admin.setting', $data);    
    }

    public function UpdateSetting(Request $request)
    {
        $setting = SettingModel::getSingle();
        $setting->paypal_email = trim($request->paypal_email);
        $setting->stripe_key = trim($request->stripe_key);
        $setting->stripe_secret = trim($request->stripe_secret);

        $setting->school_name = trim($request->school_name);
        $setting->exam_description = trim($request->exam_description);

        if(!empty($request->file('logo')))
        {
            $ext = $request->file('logo')->getClientOriginalExtension();
            $file = $request->file('logo');   
            $randomStr = date('Ymdhis').Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/setting/', $filename);
            
            $setting->logo = $filename;            
        }


        if(!empty($request->file('fevicon_icon')))
        {
            $ext = $request->file('fevicon_icon')->getClientOriginalExtension();
            $file = $request->file('fevicon_icon');   
            $randomStr = date('Ymdhis').Str::random(10);
            $fevicon_icon = strtolower($randomStr).'.'.$ext;
            $file->move('upload/setting/', $fevicon_icon);
           
            $setting->fevicon_icon = $fevicon_icon;            
        }



        $setting->save();

        return redirect()->back()->with('success', "Setting Successfully Updated");
    }

    public function MyAccount()
    {
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = "My Account";
        if(Auth::user()->user_type == 1)
        {
            return view('admin.my_account', $data);    
        }
        else if(Auth::user()->user_type == 2)
        {
            return view('teacher.my_account', $data);    
        }
        else if(Auth::user()->user_type == 3)
        {
            return view('student.my_account', $data);    
        }
        else if(Auth::user()->user_type == 4)
        {
            return view('parent.my_account', $data);    
        }
        
    }

    public function UpdateMyAccountAdmin(Request $request)
    {
        $id = Auth::user()->id;        
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id           
        ]);

        $admin = User::getSingle($id);
        $admin->name = trim($request->name);
        $admin->email = trim($request->email);
        $admin->save();
        
        return redirect()->back()->with('success', "Account Successfully Updated");
    }

    public function UpdateMyAccount(Request $request)
    {
        $id = Auth::user()->id;
        
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile_number' => 'max:15|min:8',       
            'marital_status' => 'max:50',                                       
        ]);


        $teacher = User::getSingle($id);
        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);

        if(!empty($request->date_of_birth))
        {
            $teacher->date_of_birth = trim($request->date_of_birth);    
        }

        if(!empty($request->file('profile_pic')))
        {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');   
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            
            $teacher->profile_pic = $filename;            
        }

        $teacher->marital_status = trim($request->marital_status);
        $teacher->address = trim($request->address);
        $teacher->mobile_number = trim($request->mobile_number);
        $teacher->permanent_address = trim($request->permanent_address);
        $teacher->qualification = trim($request->qualification);
        $teacher->work_experience = trim($request->work_experience);
        $teacher->email = trim($request->email);
        $teacher->save();

        return redirect()->back()->with('success', "Account Successfully Updated");
    }

    public function UpdateMyAccountStudent(Request $request)
    {
        $id = Auth::user()->id;
        
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'weight' => 'max:10',
            'mobile_number' => 'max:15|min:8',            
            'religion' => 'max:50',
            'height' => 'max:10'            
        ]);

    

        $student = User::getSingle($id);;
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->gender = trim($request->gender);

        if(!empty($request->date_of_birth))
        {
            $student->date_of_birth = trim($request->date_of_birth);    
        }

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
            $file->move('upload/profile/', $filename);
            $student->profile_pic = $filename;            
        }

        $student->religion = trim($request->religion);
        $student->mobile_number = trim($request->mobile_number);
        $student->height = trim($request->height);
        $student->weight = trim($request->weight);
        $student->email = trim($request->email);
        $student->save();

        return redirect()->back()->with('success', "Account Successfully Updated");
    }

    public function UpdateMyAccountParent(Request $request)
    {
        $id = Auth::user()->id;
        
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile_number' => 'max:15|min:8',            
            'address' => 'max:255',
            'occupation' => 'max:255'         
        ]);


        $parent = User::getSingle($id);;

        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);
        $parent->occupation = trim($request->occupation);
        $parent->address = trim($request->address);

        if(!empty($request->file('profile_pic')))
        {
            if(!empty($parent->getProfile()))
            {
                unlink('upload/profile/'.$parent->profile_pic);
            }

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');   
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            
            $parent->profile_pic = $filename;            
        }

        $parent->mobile_number = trim($request->mobile_number);
        $parent->email = trim($request->email);
        $parent->save();

        return redirect()->back()->with('success', "Account Successfully Updated");
    }


    public function change_password()
    {
        $data['header_title'] = "Change Password";
        return view('profile.change_password', $data);
    }


    public function update_change_password(Request $request)
    {
        $user = User::getSingle(Auth::user()->id);
        if(Hash::check($request->old_password, $user->password))
        {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', "Password successfully updated");
        }
        else
        {
            return redirect()->back()->with('error', "Old Password is not Currect");
        }
    }
}
