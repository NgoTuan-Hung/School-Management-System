<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;

class UserController extends Controller
{
    public function change_password()
    {
        $data['header_title'] = "Change Password";
        return view('profile.change_password',$data);
    }

    public function update_change_password(Request $request)
    {
        // dd($request -> all());
        $user = User::getSingle(Auth::user()-> id);
        if(Hash::check($request ->old_password,$user-> password))
        {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success',"Password successfully update");
        }
        else
        {
            return redirect() -> back()->with('error',"Old Password is not correct");
        }
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

        $admin=User::getSingle($id);
        $admin->name = trim($request->name);
        $admin->email = trim($request->email);
        $admin->save();
        
        return redirect()->back()->with('success', "Account Successfully Updated");


    }
}
