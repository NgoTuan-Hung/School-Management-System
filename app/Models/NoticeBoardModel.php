<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
class NoticeBoardModel extends Model
{
    use HasFactory;

    protected $table = 'notice_board';


    static public function getSingle($id){
        return self::find($id);
    }
    static public function getRecord()
    {
        $return = self::select('notice_board.*', 'users.name as created_by_name')
                ->join('users', 'users.id', '=', 'notice_board.created_by');

                if(!empty(Request::get('title')))
                {
                    $return = $return->where('notice_board.title','like', '%'.trim(Request::get('title')).'%');
                }


                if(!empty(Request::get('notice_date_from')))
                {
                    $return = $return->where('notice_board.notice_date','>=', Request::get('notice_date_from'));
                }

                if(!empty(Request::get('notice_date_to')))
                {
                    $return = $return->where('notice_board.notice_date','<=', Request::get('notice_date_to'));
                }


                if(!empty(Request::get('publish_date_from')))
                {
                    $return = $return->where('notice_board.publish_date','>=', Request::get('publish_date_from'));
                }

                if(!empty(Request::get('publish_date_to')))
                {
                     $return = $return->where('notice_board.publish_date','<=', Request::get('publish_date_to'));
                }


                if(!empty(Request::get('message_to')))
                {
                    $return = $return->join('notice_board_message', 'notice_board_message.notice_board_id', '=', 'notice_board.id');

                    $return = $return->where('notice_board_message.message_to','=', Request::get('message_to'));
                }


        $return = $return->orderBy('notice_board.id', 'desc')
                ->paginate(20);

        return $return;
    }


    static public function getRecordUser($message_to)
    {
        $return = NoticeBoardModel::select('notice_board.*', 'users.name as created_by_name')
                ->join('users', 'users.id', '=', 'notice_board.created_by');
        $return = $return->join('notice_board_message', 'notice_board_message.notice_board_id', '=', 'notice_board.id');

        if(!empty(Request::get('title')))
        {
            $return = $return->where('notice_board.title','like', '%'.trim(Request::get('title')).'%');
        }

        if(!empty(Request::get('notice_date_from')))
        {
            $return = $return->where('notice_board.notice_date','>=', Request::get('notice_date_from'));
        }

        if(!empty(Request::get('notice_date_to')))
        {
            $return = $return->where('notice_board.notice_date','<=', Request::get('notice_date_to'));
        }

        $return = $return->where('notice_board_message.message_to','=', $message_to);
        $return = $return->where('notice_board.publish_date', '<=', date('Y-m-d'));
        $return = $return->orderBy('notice_board.id', 'desc')
                ->paginate(20);

        return $return;
    }

    static public function getRecordUserCount($message_to)
    {
        $return = NoticeBoardModel::select('notice_board.id')
                ->join('users', 'users.id', '=', 'notice_board.created_by');
        $return = $return->join('notice_board_message', 'notice_board_message.notice_board_id', '=', 'notice_board.id');
        $return = $return->where('notice_board_message.message_to','=', $message_to);
        $return = $return->where('notice_board.publish_date', '<=', date('Y-m-d'))        
                ->count();

        return $return;
    }


    public function getMessage()
    {
        return $this->hasMany(NoticeBoardMessageModel::class, "notice_board_id");
    }

    public function getMessageToSingle($notice_board_id, $message_to)
    {
        return NoticeBoardMessageModel::where('notice_board_id', '=', $notice_board_id)->where('message_to', '=', $message_to)->first();
    }
}
