<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Teacher List';
        return view('admin.teacher.list',$data);
    }
}
