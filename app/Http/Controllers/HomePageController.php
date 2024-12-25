<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\User;
use App\Models\ClassModel;



class HomePageController extends Controller
{
    public function ShowHome()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getTotalStudent'] = User::getTotalStudent();
        $data['getTotalTeacher'] = User::getTotalUser(2);
        $data['getTotalCrouse'] = ClassSubjectModel::getTotalCrouse();
        $data['header_title'] = 'Home Page';
        $data['teachers'] = User::getTeacher();
        return view('school.home',$data);
    }

    public function ShowTrainer()
    {
        $data['header_title'] = 'Trainers Page';
        $data['getRecord'] = User::getTeacher();
        return view('school.trainers',$data);
    }

    public function ShowCrouse()
    {
        $data['header_title'] = 'Crouses Page';
        $data['getClass'] = ClassModel::getClass(); 
        return view('school.crouses',$data);
    }

}
