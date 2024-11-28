<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function list()
    {
        $data['getRecord'] = ClassModel::getRecord();
        $data['header_title']= "Class List"; 
        return view('admin.class.list',$data);
    }
    public function add()
    {
        $data['header_title'] = 'Add New class';
        return view('admin.class.add',$data);
    }

    public function insert(Request $request)
    {
        $save = new ClassModel();
        $save -> name = trim($request-> name);
        $save -> status = $request-> status;
        $save -> created_by = Auth::user()-> id;
        $save -> save();

        return redirect('admin/class/list')-> with('success','New Class successfully created');
    }

    public function edit($id)
    {
        $data['getRecord'] = ClassModel::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title'] = 'Edit Class'; 
            return view('admin.class.edit',$data);   
        }
        else
        {
            return abort(404);
        }
    }

    public function update($id, Request $request)
    {
        $save = ClassModel::getSingle($id);
        $save->name = $request->name;
        $save->status=$request->status;
        $save -> save();
        return redirect('admin/class/list')-> with('success','Class successfully updated');
    }

    public function delete($id)
    {
        //Find the user with id and delete from database
        // $user = Class::findOrFail($id);
        // $user -> delete();

        $save = ClassModel::getSingle($id);
        $save->is_delete = 1;
        $save -> save();

        return redirect()->back()-> with('success','Class successfully deleted');

    }
}
