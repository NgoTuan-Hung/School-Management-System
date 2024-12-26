<?php

namespace App\Http\Controllers;

use App\Models\HomeContentModel;
use Illuminate\Http\Request;
use Str;

class ContentController extends Controller
{
    //
    public function list(){
        $data['header_title'] = "Content";
        $data['getContent'] = HomeContentModel::getContent();
        return view('admin.cms.list',$data);
    }
    public function edit($id)
    {
        $data['getRecord'] = HomeContentModel::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title'] = 'Edit Class'; 
            return view('admin.cms.edit',$data);   
        }
        else
        {
            return abort(404);
        }
    }



    public function update($id, Request $request)
{
    // Lấy bản ghi lớp cần cập nhật
    $save = HomeContentModel::getSingle($id);

    // Cập nhật các trường thông tin
    $save->title = $request->title;
    $save->small_title = $request->small_title;

    // Kiểm tra và xử lý tệp hình ảnh profile_pic
    if(!empty($request->file('profile_pic')))
    {
        if (!empty($save->profile_pic) && file_exists(public_path('upload/class/' . $save->profile_pic))) {
            unlink(public_path('upload/class/' . $save->profile_pic)); // Xóa hình cũ nếu có
        }

        $ext = $request->file('profile_pic')->getClientOriginalExtension();
        $file = $request->file('profile_pic');   
        $randomStr = date('Ymdhis').Str::random(20);
        $filename = strtolower($randomStr).'.'.$ext;
        $file->move(base_path('upload/class/'), $filename);
        $save->profile_pic = $filename; // Lưu tên tệp hình ảnh
    }



    // Kiểm tra và xử lý tệp hình ảnh about_us_pic
    if(!empty($request->file('about_us_pic')))
    {
        if (!empty($save->about_us_pic) && file_exists(public_path('upload/about_us_pic/' . $save->about_us_pic))) {
            unlink(public_path('upload/about_us_pic/' . $save->about_us_pic)); // Xóa hình cũ nếu có
        }

        $ext = $request->file('about_us_pic')->getClientOriginalExtension();
        $file = $request->file('about_us_pic');   
        $randomStr = date('Ymdhis').Str::random(20);
        $filename = strtolower($randomStr).'.'.$ext;
        $file->move(base_path('upload/about_us_pic/'), $filename);
        $save->about_us_pic = $filename; // Lưu tên tệp hình ảnh
    }

    // Cập nhật nội dung khác
    $save->about_us = $request->about_us;

    // Lưu thông tin cập nhật
    $save->save();

    // Quay lại trang danh sách lớp với thông báo thành công
    return redirect('admin/cms/list')->with('success', 'Content successfully updated');
}


}
