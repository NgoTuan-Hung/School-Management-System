<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;
use Illuminate\Support\Str;

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
        $save -> amount = $request-> amount;
        $save -> status = $request-> status;
        $save -> created_by = Auth::user()-> id;

        if ($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/class/', $filename);
            $save->profile_pic = $filename;
        $save -> save();
        }

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
    // Lấy bản ghi lớp cần cập nhật
    $save = ClassModel::getSingle($id);

    // Cập nhật các trường thông tin
    $save->name = $request->name;
    $save->amount = $request->amount;
    $save->status = $request->status;

    // Kiểm tra và xử lý tệp hình ảnh
    if(!empty($request->file('profile_pic')))
        {
            if (!empty($save->profile_pic) && file_exists(public_path('upload/class/' . $save->profile_pic))) {
                unlink(public_path('upload/class/' . $save->profile_pic));
            }

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');   
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(base_path('upload/class/'), $filename);

            $save->profile_pic = $filename;            
        }

    // Lưu thông tin cập nhật
    $save->save();

    // Quay lại trang danh sách lớp với thông báo thành công
    return redirect('admin/class/list')->with('success', 'Class successfully updated');
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
