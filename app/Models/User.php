<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    static public function getTotalUser($type){
        return self::select('users.*')
                            ->where('users.user_type','=',$type)
                            ->count();
    }

    static public function getTotalStudent(){
        return self::select('users.*')
                            ->where('users.user_type','=',3)
                            ->where('users.is_student','=',0)
                            ->count();
    }

    
    static public function getAdmin($remove_pagination = 0)
    {
        $return = self::select('users.*')
                                -> where('user_type','=',1) 
                                -> where('is_delete','=',0);
        if (!empty(request()->get('email'))) {
            $return = $return->where('email', 'like', '%' . request()->get('email') . '%');
        }
        if (!empty(request()->get('name'))) {
            $name = request()->get('name');
            
            // Loại bỏ khoảng trắng 
            $nameWithoutSpaces = str_replace(' ', '', $name);
            
            $return = $return->where(function ($query) use ($nameWithoutSpaces) {
                $query->whereRaw("REPLACE(users.name, ' ', '') LIKE ?", ['%' . $nameWithoutSpaces . '%']);
            });
        }
        

        if (!empty(request()->get('date'))) {
            $return = $return->whereDate('created_at' ,'=' ,request()->get('date'));
        } if(!empty(request()->get('email')))
                        {
                            $return = $return->where('users.email','like','%'.request()->get('email'));
                        }
                                
        $return = $return -> orderBy('id','asc')
                        -> paginate(10);
        return $return;
    }

    static public function getTeacher()
    {   
        $return = self::select('users.*')
                        ->where('users.user_type','=',2)
                        ->where('users.is_delete','=',0);
                        if(!empty(request()->get('name')))
                        {
                            $name = request()->get('name');
                            // Kiểm tra tên bắt đầu với ký tự nhập vào
                            $return = $return->where('users.name', 'like', $name.'%');
                        }


                        if(!empty(request()->get('last_name')))
                        {
                            $return = $return->where('users.last_name','like', '%'.request()->get('last_name').'%');
                        }

                        if(!empty(request()->get('email')))
                        {
                            $return = $return->where('users.email','like', '%'.request()->get('email').'%');
                        }

                        if(!empty(request()->get('gender')))
                        {
                            $return = $return->where('users.gender','=', request()->get('gender'));
                        }

                        if(!empty(request()->get('mobile_number')))
                        {
                            $return = $return->where('users.mobile_number','like', '%'.request()->get('mobile_number').'%');
                        }

                        if(!empty(request()->get('marital_status')))
                        {
                            $return = $return->where('users.marital_status','like', '%'.request()->get('marital_status').'%');
                        }

                        if(!empty(request()->get('address')))
                        {
                            $return = $return->where('users.address','like', '%'.request()->get('address').'%');
                        }

                        

                        if(!empty(request()->get('admission_date')))
                        {
                            $return = $return->whereDate('users.admission_date','=', request()->get('admission_date'));
                        }

                        if(!empty(request()->get('date')))
                        {
                            $return = $return->whereDate('users.created_at','=', request()->get('date'));
                        }

                        if(!empty(request()->get('status')))
                        {
                            $status = (request()->get('status') == 100) ? 0 : 1;
                            $return = $return->where('users.status','=', $status);
                        }


                       
        $return = $return -> orderBy('id','desc')
        -> paginate(10);
        return $return;
    }

    static public function getTeacherStudentCount($teacher_id)
    {
        $return = self::select('users.id')
                        ->join('class', 'class.id', '=', 'users.class_id')
                        ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
                        ->where('assign_class_teacher.teacher_id', '=', $teacher_id)   
                        ->where('assign_class_teacher.status','=',0)                     
                        ->where('assign_class_teacher.is_delete','=',0)                     
                        ->where('users.user_type','=',3)
                        ->where('users.is_delete','=',0)
                        ->orderBy('users.id', 'desc')
                        ->groupBy('users.id')
                        ->count();

        return $return;
    }
    

    static public function getTeacherClass()
    {   
        $return = self::select('users.*')
                        ->where('users.user_type','=',2)
                        ->where('users.is_delete','=',0);
            
        $return = $return -> orderBy('users.id','desc')
        -> get();
        return $return;
    }

    static public function getStudent($remove_pagination = 0)
    {
        $return = self::select('users.*','class.name as class_name','parent.name as parent_name')
                        ->join('users as parent','parent.id','=','users.parent_id','left')
                        ->join('class','class.id','=','users.class_id','left')
                        -> where('users.user_type','=',3)
                        -> where('users.is_student','!=',1)
                        -> where('users.is_delete','=',0);
                        if(!empty(request()->get('name')))
                        {
                            $name = request()->get('name');
                            // Kiểm tra tên bắt đầu với ký tự nhập vào
                            $return = $return->where('users.name', 'like', $name.'%');
                        }
                        if(!empty(request()->get('last_name')))
                        {
                            $return = $return->where('users.last_name','like', '%'.request()->get('last_name').'%');
                        }

                        if(!empty(request()->get('email')))
                        {
                            $return = $return->where('users.email','like', '%'.request()->get('email').'%');
                        }

                        if(!empty(request()->get('admission_number')))
                        {
                            $return = $return->where('users.admission_number','like', '%'.request()->get('admission_number').'%');
                        }

                        if(!empty(request()->get('roll_number')))
                        {
                            $return = $return->where('users.roll_number','like', '%'.request()->get('roll_number').'%');
                        }

                        if(!empty(request()->get('class')))
                        {
                            $return = $return->where('class.name','like', '%'.request()->get('class').'%');
                        }

                        if(!empty(request()-> get('gender')))
                        {
                            $return = $return->where('users.gender','=', request()->get('gender'));
                        }

                        if(!empty(request()->get('religion')))
                        {
                            $return = $return->where('users.religion','like', '%'.request()->get('religion').'%');
                        }

                        if(!empty(request()->get('mobile_number')))
                        {
                            $return = $return->where('users.mobile_number','like', '%'.request()->get('mobile_number').'%');
                        }
                        
                        if(!empty(request()->get('admission_date')))
                        {
                            $return = $return->whereDate('users.admission_date','=', request()->get('admission_date'));
                        }

                        if(!empty(request()->get('date')))
                        {
                            $return = $return->whereDate('users.created_at','=', request()->get('date'));
                        }

                        if(!empty(request()->get('status')))
                        {
                            $status = (request()->get('status') == 100) ? 0 : 1;
                            $return = $return->where('users.status','=', $status);
                        }


        $return = $return->orderBy('users.id', 'desc');

            if(!empty($remove_pagination))
            {
                $return = $return->get();
            }
            else
            {
                $return = $return->paginate(40);
            }
                        

        return $return;
    }


    // parent side work
    static public function getMyStudent($parent_id)
    {
        $return = self::select('users.*', 'class.name as class_name','parent.name as parent_name')
                        ->join('users as parent','parent.id', '=', 'users.parent_id')
                        ->join('class', 'class.id', '=', 'users.class_id', 'left')
                        ->where('users.user_type','=',3)
                        ->where('users.parent_id','=',$parent_id)
                        ->where('users.is_delete','=',0)
                        ->orderBy('users.id', 'desc')
                        ->get();

        return $return;
    }

    static public function getMyStudentCount($parent_id)
    {
        $return = self::select('users.id')
                        ->join('users as parent','parent.id', '=', 'users.parent_id')
                        ->join('class', 'class.id', '=', 'users.class_id', 'left')
                        ->where('users.user_type','=',3)
                        ->where('users.parent_id','=',$parent_id)
                        ->where('users.is_delete','=',0)
                        ->count();
        return $return;
    }


    
    static public function getTeacherStudent($teacher_id)
{
    $return = self::select('users.*', 'class.name as class_name')
                    ->join('class', 'class.id', '=', 'users.class_id')
                    ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
                    ->where('assign_class_teacher.teacher_id', '=', $teacher_id)   
                    ->where('assign_class_teacher.status', '=', 0)                     
                    ->where('assign_class_teacher.is_delete', '=', 0)                     
                    ->where('users.user_type', '=', 3)
                    ->where('users.is_delete', '=', 0)
                    ->orderBy('users.id', 'desc');
    $return = $return->paginate(20);

    return $return;
}


    static public function getSingleClass($id)
    {
        return self::select('users.*','class.amount', 'class.name as class_name')
                    ->join('class','class.id','users.class_id')
                    ->where('users.id','=',$id)
                    ->first();
    }

    
    static public function getParent($remove_pagination=0)
    {
        $return = self::select('users.*')
                        ->where('user_type','=',4)
                        ->where('is_delete','=',0);

                        if(!empty(request()->get('name')))
                        {
                            $return = $return->where('users.name','like', '%'.request()->get('name').'%');
                        }
                        if(!empty(request()->get('last_name')))
                        {
                            $return = $return->where('users.last_name','like', '%'.request()->get('last_name').'%');
                        }

                        if(!empty(request()->get('email')))
                        {
                            $return = $return->where('users.email','like', '%'.request()->get('email').'%');
                        }

                        if(!empty(request()->get('gender')))
                        {
                            $return = $return->where('users.gender','=', request()->get('gender'));
                        }

                        if(!empty(request()->get('mobile_number')))
                        {
                            $return = $return->where('users.mobile_number','like', '%'.request()->get('mobile_number').'%');
                        }

                        if(!empty(request()->get('address')))
                        {
                            $return = $return->where('users.address','like', '%'.request()->get('address').'%');
                        }

                        if(!empty(request()->get('occupation')))
                        {
                            $return = $return->where('users.occupation','like', '%'.request()->get('occupation').'%');
                        }


                        if(!empty(request()->get('date')))
                        {
                            $return = $return->whereDate('users.created_at','=', request()->get('date'));
                        }

                        if(!empty(request()->get('status')))
                        {
                            $status = (request()->get('status') == 100) ? 0 : 1;
                            $return = $return->whereDate('users.status','=', $status);
                        }


                    $return = $return->orderBy('id', 'desc');

                    if(!empty($remove_pagination))
                    {
                        $return = $return->get();
                    }
                    else
                    {
                        $return = $return->paginate(40);
                    }
                        

        return $return;
    }


    static public function getSearchStudent()
    {
        if(!empty(request()->get('id')) || !empty(request()->get('name')) || !empty(request()->get('last_name')) || !empty(request()->get('email')))
        {
                $return = self::select('users.*', 'class.name as class_name','parent.name as parent_name')
                            ->join('users as parent','parent.id', '=', 'users.parent_id', 'left')
                            ->join('class', 'class.id', '=', 'users.class_id', 'left')
                            ->where('users.user_type','=',3)
                            ->where('users.is_delete','=',0);

                            if(!empty(request()->get('id')))
                            {
                                $return = $return->where('users.id','=', request()->get('id'));
                            }

                            if(!empty(request()->get('name')))
                            {
                                $return = $return->where('users.name','like', '%'.request()->get('name').'%');
                            }
                            if(!empty(request()->get('last_name')))
                            {
                                $return = $return->where('users.last_name','like', '%'.request()->get('last_name').'%');
                            }

                            if(!empty(request()->get('email')))
                            {
                                $return = $return->where('users.email','like', '%'.request()->get('email').'%');
                            }



            $return = $return->orderBy('users.id', 'desc')
                            ->limit(50)
                            ->get();

            return $return;
        }
    }

    static public function getMyStudentIds($parent_id)
    {
        $return = self::select('users.id')
                        ->join('users as parent','parent.id', '=', 'users.parent_id')
                        ->join('class', 'class.id', '=', 'users.class_id', 'left')
                        ->where('users.user_type','=',3)
                        ->where('users.parent_id','=',$parent_id)
                        ->where('users.is_delete','=',0)
                        ->orderBy('users.id', 'desc')
                        ->get();

        $student_ids = array();
        foreach($return as $value)
        {
            $student_ids[] = $value->id;
        }

        return $student_ids;
    }

    static public function getMyStudentClassIds($parent_id)
    {
        $return = self::select('users.class_id')
                        ->join('users as parent','parent.id', '=', 'users.parent_id')
                        ->join('class', 'class.id', '=', 'users.class_id')
                        ->where('users.user_type','=',3)
                        ->where('users.parent_id','=',$parent_id)
                        ->where('users.is_delete','=',0)
                        ->orderBy('users.id', 'desc')
                        ->get();

        $class_ids = array();
        foreach($return as $value)
        {
            $class_ids[] = $value->class_id;
        }

        return $class_ids;
    }

    static public function getEmailSingle($email)
    {
        return self::where('email','=', $email) -> first();
    }
    static public function getTokenSingle($remember_token)
    {
        return self::where('remember_token','=', $remember_token) -> first();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function getProfile()
{
    // Check if profile_pic is not empty and the file exists in the specified directory.
    if (!empty($this->profile_pic) && file_exists('upload/profile/' . $this->profile_pic)) {
        // If the file exists, return the full URL to the profile picture.
        return url('upload/profile/' . $this->profile_pic);
    } else {
        // If no profile picture is set or the file doesn't exist, return an empty string.
        return '';
    }
}

    public function getProfileDirect()
    {
        if(!empty($this->profile_pic) && file_exists('upload/profile/'.$this->profile_pic))
        {
            return url('upload/profile/'.$this->profile_pic);
        }
        else
        {
            return url('upload/profile/user.jpg');
        }
    }


    static public function getStudentClass($class_id)
    {
        return self::select('users.id', 'users.name', 'users.last_name')
                        ->where('users.user_type','=',3)
                        ->where('users.is_delete','=',0)
                        ->where('users.class_id','=',$class_id)
                        ->orderBy('users.id', 'desc')
                        ->get();        
    }

    static public function getRegister($remove_pagination = 0)
    {
        $return = self::select('users.*','class.name as class_name')
                        ->join('class', 'class.id', '=', 'users.class_id')
                        ->where('user_type','=',3)
                        ->where('is_student','=',1)
                        ->where('users.is_delete','=',0);
                        if(!empty(request()->get('class_id'))){
                            $return = $return->where('users.class_id', '=', request()->get('class_id'));
                        }
                        if(!empty(request()->get('name')))
                        {
                            $return = $return->where('users.name', 'like', '%'.request()->get('name').'%');
                        }
                        if(!empty(request()->get('email')))
        {
            $return = $return->where('users.email', 'like', '%'.request()->get('email').'%');
        }

        $return = $return->orderBy('users.id', 'desc')
                        ->paginate(20);

        return $return;
    }


    static public function getTotalRegister(){
        return self::select('users.*')
                            ->where('users.is_student','=',1)
                            ->count();
    }

    

}
