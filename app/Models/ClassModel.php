<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Request;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = ClassModel::select('class.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', 'class.created_by');

                    if(!empty(Request::get('name')))
                    {
                        $return = $return->where('class.name', 'like', '%'.Request::get('name').'%');
                    }

                    if(!empty(Request::get('date')))
                    {
                        $return = $return->whereDate('class.created_at','=', Request::get('date'));
                    }

                    $return = $return->where('class.is_delete', '=', 0)
                    ->orderBy('class.id', 'desc')
                    ->paginate(20);

        return $return;
    }

    static public function getClass()
    {
        $return = ClassModel::select(
                'class.*', 
                'teachers.name as teacher_name', 
                'teachers.profile_pic as teacher_avatar'
            )
            ->join('users as creators', 'creators.id', '=', 'class.created_by')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
            ->join('users as teachers', 'teachers.id', '=', 'assign_class_teacher.teacher_id')
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0)
            ->orderBy('class.name', 'asc')
            ->get();
    
        return $return;
    }
    


    static public function getTotalClass()
    {
        $return = ClassModel::select('class.id')
                    ->join('users', 'users.id', 'class.created_by')
                    ->where('class.is_delete', '=', 0)
                    ->where('class.status', '=', 0)
                    ->count();

        return $return;
    }
    
    public function getProfile()
{
    // Đường dẫn đầy đủ tới thư mục upload/class
    $filePath = public_path('upload/class/' . $this->profile_pic);

    // Kiểm tra nếu profile_pic không rỗng và file tồn tại
    if (!empty($this->profile_pic) && file_exists($filePath)) {
        // Trả về URL đầy đủ của ảnh
        return asset('upload/class/' . $this->profile_pic);
    }

    // Trả về ảnh mặc định nếu không có ảnh
    return asset('images/default-profile.png');
}


    public function getClassProfileDirect(){
        if(!empty($this->profile_pic) && file_exists('upload/class/'.$this->profile_pic))
        {
            return url('upload/class/'.$this->profile_pic);
        }
        else
        {
            return url('upload/class/user.jpg');
        }
    }


    public function getTeacherProfileDirect()
{
    if (!empty($this->teacher_avatar) && file_exists('upload/profile/' . $this->teacher_avatar)) {
        return url('upload/profile/' . $this->teacher_avatar);
    } else {
        // Ảnh mặc định nếu giáo viên không có ảnh
        return url('upload/profile/user.jpg');
    }
}



}
