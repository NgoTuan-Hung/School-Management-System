<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;


class AdminController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Admin List';
        return view('admin.admin.list',$data);
    }

    public function add()
    {
        $data['header_title'] = 'Add New admin';
        return view('admin.admin.add',$data);
    }
    public function insert( Request $request)
    {
        //  Checking email is empty or not, check email in correct form 
        // Checking email is exist in database -> result error
        request()->validate([
            'email' => 'required|email|unique:users'
        ]);
        
        $user = new User();
        $user -> name = trim($request-> name);
        $user -> email = trim($request-> email);
        $user -> password = Hash::make($request-> password);
        $user -> user_type = 1;
        $user -> save();

        return redirect('admin/admin/list')-> with('success','Admin successfully created');

    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);

        if(!empty($data['getRecord']))
        {
            $data['header_title'] = 'Edit Admin'; 
            return view('admin.admin.edit',$data);   
        }
        else
        {
            return abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        //  Checking email is empty or not, check email in correct form 
        // Checking email is exist in database 
        // with exception with $id that update
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        $user = User::getSingle($id);
        $user -> name = trim($request-> name);
        $user -> email = trim($request-> email);
        if(!empty($request -> password))
        {
            $user -> password = Hash::make($request-> password);
        }
        $user -> save();
        return redirect('admin/admin/list')-> with('success','Admin successfully updated');
    }

    public function delete($id)
    {
        //Find the user with id and delete from database
        // $user = User::findOrFail($id);
        // $user -> delete();
        $user = User::getSingle($id);
        $user -> is_delete = 1;
        $user -> save();
        return redirect('admin/admin/list')-> with('success','Admin successfully deleted');
    }
}
