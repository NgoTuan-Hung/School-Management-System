<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NoticeBoardModel;
use App\Models\NoticeBoardMessageModel;
use App\Mail\SendEmailUserMail;
use Auth;
use Mail;
class CommunicateController extends Controller
{
    public function MyNoticeBoardParent()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['header_title'] = 'My Notice Board';
        return view('parent.my_notice_board', $data);
    } 
    
    public function MyStudentNoticeBoardParent()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(3);
        $data['header_title'] = 'My Notice Board';
        return view('parent.my_student_notice_board', $data);
    }
}

