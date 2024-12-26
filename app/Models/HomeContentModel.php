<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContentModel extends Model
{
    use HasFactory;

    protected $table = 'home_content';


    static public function getSingle($id)
    {
        return self::find($id);
    }



    static public function getContent(){
        return self::select('home_content.*')->get();
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
    return asset('public/assets/img/hero-bg.jpg');
}

public function getAboutUsPic()
{
    // Assume about_us_pic is the attribute for the about us image
    $filePath = public_path('upload/about_us_pic/' . $this->about_us_pic);
    if (!empty($this->about_us_pic) && file_exists($filePath)) {
        return asset('upload/about_us_pic/' . $this->about_us_pic);
    }
    return asset('public/about_us_pic/img/default-about-us-pic.jpg');
}

public function getProfileDirect(){
    if(!empty($this->profile_pic) && file_exists('upload/class/'.$this->profile_pic))
    {
        return url('upload/class/'.$this->profile_pic);
    }
    else
    {
        return url('public/assets/img/hero-bg.jpg');
    }
}

public function getProfileDirectUs(){
    if(!empty($this->about_us_pic) && file_exists('upload/about_us_pic/'.$this->about_us_pic))
    {
        return url('upload/about_us_pic/'.$this->about_us_pic);
    }
    else
    {
        return url('public/about_us_pic/img/hero-bg.jpg');
    }
}

}
