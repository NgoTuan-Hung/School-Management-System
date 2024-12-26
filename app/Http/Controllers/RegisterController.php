<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;




class RegisterController extends Controller
{
    public function list(){

        $data['getRecord'] = User::getRegister();
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = "Admin List";
        return view('admin.register.list',$data);

    }

    public function delete($id)
    {
        $user = User::getSingle($id);
        $user->is_delete = 1;
        $user->save();

        return redirect('admin/register/list')->with('success', "Register successfully deleted");
    }

    public function approve($id){
        $user = User::getSingle($id);
        $user->is_student = 0;
        $user->save();
        return redirect('admin/register/list')->with('success', "Approve successfully ");


    }



    
}
