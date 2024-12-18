<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\FeesCollectionController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\AssignClassTeacher;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\ExaminationsController;









/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


//Testing api:

// Route::get('admin/assign_class_teacher/list',[AssignClassTeacher::class,'list']);
// Route::get('admin/assign_class_teacher/add',[AssignClassTeacher::class,'add']);


// Route Login, Logout
Route::get('/',[AuthController::class,'login']);
Route::post('login',[AuthController::class,'AuthLogin']);
Route::get('logout',[AuthController::class,'logout']);
//Route forgot password
Route::get('forgot-password',[AuthController::class,'forgotpassword']);
Route::post('forgot-password',[AuthController::class,'PostForgotPassword']);

//Route reset password
Route::get('reset/{token}',[AuthController::class,'reset']);
Route::post('reset/{token}',[AuthController::class,'PostReset']);


//Authentication user blocking different user enter
Route::group(['middleware' => 'admin'], function(){
    Route::get('admin/dashboard',[DashboardController::class,'dashboard']);
    Route::get('admin/admin/list',[AdminController::class,'list']);
    Route::get('admin/admin/add',[AdminController::class,'add']);
    Route::post('admin/admin/add',[AdminController::class,'insert']);
    // Admin url edit, delete:
    Route::get('admin/admin/edit/{id}',[AdminController::class,'edit']);
    Route::post('admin/admin/edit/{id}',[AdminController::class,'update']);
    Route::get('admin/admin/delete/{id}',[AdminController::class,'delete']);
    
    //admin my account
    Route::get('admin/account', [UserController::class, 'MyAccount']);
    Route::post('admin/account', [UserController::class, 'UpdateMyAccountAdmin']);


    // student 
    Route::get('admin/student/list', [StudentController::class, 'list']);
    Route::get('admin/student/add', [StudentController::class, 'add']);
    Route::post('admin/student/add', [StudentController::class, 'insert']);
    // Student url edit, delete:
    Route::get('admin/student/edit/{id}',[StudentController::class,'edit']);
    Route::post('admin/student/edit/{id}',[StudentController::class,'update']);
    Route::get('admin/student/delete/{id}',[StudentController::class,'delete']);

    //Teacher:
    Route::get('admin/teacher/list', [TeacherController::class, 'list']);
    Route::get('admin/teacher/add', [TeacherController::class, 'add']);
    Route::post('admin/teacher/add', [TeacherController::class, 'insert']);
    
    Route::get('admin/teacher/edit/{id}',[TeacherController::class,'edit']);
    Route::post('admin/teacher/edit/{id}',[TeacherController::class,'update']);
    Route::get('admin/teacher/delete/{id}',[TeacherController::class,'delete']);

    

    //Parent:
    Route::get('admin/parent/list', [ParentController::class, 'list']);
    Route::get('admin/parent/add', [ParentController::class, 'add']);
    Route::post('admin/parent/add', [ParentController::class, 'insert']);
    //Parent edit, delete:
    Route::get('admin/parent/edit/{id}',[ParentController::class,'edit']);
    Route::post('admin/parent/edit/{id}',[ParentController::class,'update']);
    Route::get('admin/parent/delete/{id}',[ParentController::class,'delete']);
    Route::get('admin/parent/my-student/{id}', [ParentController::class, 'myStudent']);
    Route::get('admin/parent/assign_student_parent/{student_id}/{parent_id}', [ParentController::class, 'AssignStudentParent']);
    Route::get('admin/parent/assign_student_parent_delete/{id}', [ParentController::class, 'AssignStudentParentDelete']);


    
    //Class url:
    Route::get('admin/class/list',[ClassController::class,'list']);
    Route::get('admin/class/add',[ClassController::class,'add']);
    Route::post('admin/class/add',[ClassController::class,'insert']);
    //Class url edit,delete:
    Route::get('admin/class/edit/{id}',[ClassController::class,'edit']);
    Route::post('admin/class/edit/{id}',[ClassController::class,'update']);
    Route::get('admin/class/delete/{id}',[ClassController::class,'delete']);

    // Subject URL:
    Route::get('admin/subject/list',[SubjectController::class,'list']);
    Route::get('admin/subject/add',[SubjectController::class,'add']);
    Route::post('admin/subject/add',[SubjectController::class,'insert']);
    Route::get('admin/subject/edit/{id}',[SubjectController::class,'edit']);
    Route::post('admin/subject/edit/{id}',[SubjectController::class,'update']);
    Route::get('admin/subject/delete/{id}',[SubjectController::class,'delete']);

    //assign_subject
    Route::get('admin/assign_subject/list',[ClassSubjectController::class,'list']);
    Route::get('admin/assign_subject/add',[ClassSubjectController::class,'add']);
    Route::post('admin/assign_subject/add',[ClassSubjectController::class,'insert']);
    Route::get('admin/assign_subject/edit/{id}',[ClassSubjectController::class,'edit']);
    Route::post('admin/assign_subject/edit/{id}',[ClassSubjectController::class,'update']);
    Route::get('admin/assign_subject/delete/{id}',[ClassSubjectController::class,'delete']);
    Route::get('admin/assign_subject/edit_single/{id}',[ClassSubjectController::class,'edit_single']);
    Route::post('admin/assign_subject/edit_single/{id}',[ClassSubjectController::class,'update_single']);
    
    //assgin_class_teacher:
    Route::get('admin/assign_class_teacher/list',[AssignClassTeacher::class,'list']);
    Route::get('admin/assign_class_teacher/add',[AssignClassTeacher::class,'add']);
    Route::post('admin/assign_class_teacher/add',[AssignClassTeacher::class,'insert']);
    Route::get('admin/assign_class_teacher/edit/{id}', [AssignClassTeacher::class, 'edit']);
    Route::post('admin/assign_class_teacher/edit/{id}', [AssignClassTeacher::class, 'update']);
    Route::get('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacher::class, 'edit_single']);
    Route::post('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacher::class, 'update_single']);
    Route::get('admin/assign_class_teacher/delete/{id}', [AssignClassTeacher::class, 'delete']);


    Route::get('admin/examinations/exam/list', [ExaminationsController::class, 'exam_list']);  
    Route::get('admin/examinations/exam/add', [ExaminationsController::class, 'exam_add']);  
    Route::post('admin/examinations/exam/add', [ExaminationsController::class, 'exam_insert']);  



    Route::get('admin/class_timetable/list', [ClassTimetableController::class, 'list']);
    Route::post('admin/class_timetable/get_subject', [ClassTimetableController::class, 'get_subject']);
    Route::post('admin/class_timetable/add', [ClassTimetableController::class, 'insert_update']);

    Route::get('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_edit']);  
    Route::post('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_update']);
    Route::get('admin/examinations/exam/delete/{id}', [ExaminationsController::class, 'exam_delete']); 

    // Scheduling
    Route::get('admin/examinations/exam_schedule', [ExaminationsController::class, 'exam_schedule']); 
    Route::post('admin/examinations/exam_schedule_insert', [ExaminationsController::class, 'exam_schedule_insert']); 


    Route::get('admin/examinations/marks_register', [ExaminationsController::class, 'marks_register']); 
    Route::post('admin/examinations/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']); 
    Route::post('admin/examinations/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']); 

    Route::get('admin/examinations/marks_grade', [ExaminationsController::class, 'marks_grade']);
    Route::get('admin/examinations/marks_grade/add', [ExaminationsController::class, 'marks_grade_add']);
    Route::post('admin/examinations/marks_grade/add', [ExaminationsController::class, 'marks_grade_insert']);
    Route::get('admin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'marks_grade_edit']);
    Route::post('admin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'marks_grade_update']);
    Route::get('admin/examinations/marks_grade/delete/{id}', [ExaminationsController::class, 'marks_grade_delete']);
    



    //change password url:
    Route::get('admin/change_password',[UserController::class,'change_password']);
    Route::post('admin/change_password',[UserController::class,'update_change_password']);

});

Route::group(['middleware' => 'teacher'], function(){
    Route::get('teacher/dashboard',[DashboardController::class,'dashboard']);

    Route::get('teacher/change_password',[UserController::class,'change_password']);
    Route::post('teacher/change_password',[UserController::class,'update_change_password']);
});

Route::group(['middleware' => 'student'], function(){
    Route::get('student/dashboard',[DashboardController::class,'dashboard']);
    //FeesCollectionController
    Route::get('student/fees_collection', [FeesCollectionController::class, 'CollectFeesStudent']);
    Route::post('student/fees_collection', [FeesCollectionController::class, 'CollectFeesStudentPayment']);
    //
    Route::get('student/change_password',[UserController::class,'change_password']);
    Route::post('student/change_password',[UserController::class,'update_change_password']);
    
});

Route::group(['middleware' => 'parent'], function(){
    Route::get('parent/my_student_notice_board', [CommunicateController::class, 'MyStudentNoticeBoardParent']); 
    Route::get('parent/dashboard',[DashboardController::class,'dashboard']);

    Route::get('parent/change_password',[UserController::class,'change_password']);
    Route::post('parent/change_password',[UserController::class,'update_change_password']);

    Route::get('parent/my_notice_board', [CommunicateController::class, 'MyNoticeBoardParent']);
    Route::get('parent/my_student', [ParentController::class, 'myStudentParent']);

    Route::get('parent/my_student/attendance/{student_id}', [AttendanceController::class, 'MyAttendanceParent']);
});