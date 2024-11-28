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
}
