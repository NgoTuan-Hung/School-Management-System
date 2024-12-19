<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NoticeBoardModel;
use App\Models\NoticeBoardMessageModel;
use App\Mail\SendEmailUserMail;
use Illuminate\Support\Facades\Auth;
use Mail;
class CommunicateController extends Controller
{

    // admin side
    public function NoticeBoard()
    {
        $data['getRecord'] = NoticeBoardModel::getRecord();
        $data['header_title'] = 'Notice Board';
        return view('admin.communicate.noticeboard.list', $data);
    }

    public function AddNoticeBoard()
    {
        $data['header_title'] = 'Add New Notice Board';
        return view('admin.communicate.noticeboard.add', $data);
    }

    public function InsertNoticeBoard(Request $request)
    {
        $save = new NoticeBoardModel;
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->created_by = Auth::user()->id;
        $save->save();
        
        if(!empty($request->message_to))
        {
            foreach ($request->message_to as $message_to) 
            {
                $message = new NoticeBoardMessageModel;
                $message->notice_board_id = $save->id;
                $message->message_to  = $message_to;
                $message->save();
            }    
        }
        

        return redirect('admin/communicate/notice_board')->with('success', "Notice Board successfully created");
    }

    public function EditNoticeBoard($id)
    {
        $data['getRecord'] = NoticeBoardModel::getSingle($id);
        $data['header_title'] = 'Edit Notice Board';
        return view('admin.communicate.noticeboard.edit', $data);
    }

    public function UpdateNoticeBoard($id, Request $request)
    {
        $save = NoticeBoardModel::getSingle($id);
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->save();
        
        NoticeBoardMessageModel::DeleteRecord($id);

        if(!empty($request->message_to))
        {
            foreach ($request->message_to as $message_to) 
            {
                $message = new NoticeBoardMessageModel;
                $message->notice_board_id = $save->id;
                $message->message_to  = $message_to;
                $message->save();
            }    
        }
        

        return redirect('admin/communicate/notice_board')->with('success', "Notice Board successfully updated");
    }

    public function DeleteNoticeBoard($id)
    {
        $save = NoticeBoardModel::getSingle($id);
        $save->delete();

        NoticeBoardMessageModel::DeleteRecord($id);

        return redirect()->back()->with('success', "Notice Board successfully delted");
    }


    //Student side work
    public function MyNoticeBoardStudent()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['header_title'] = 'My Notice Board';
        return view('student.my_notice_board', $data);
    }

    // teacher side work   
    public function MyNoticeBoardTeacher()
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['header_title'] = 'My Notice Board';
        return view('teacher.my_notice_board', $data);
    }

    // parent side work 
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

