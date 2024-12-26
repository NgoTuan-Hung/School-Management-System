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
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\AssignClassTeacher;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\ExaminationsController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\CrouseDetail;
use App\Http\Controllers\RegisterController;














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

Route::get('/', [HomePageController::class, 'ShowHome']);

Route::prefix('school')->controller(HomePageController::class)->group(function () {
    Route::get('/', [HomePageController::class, 'ShowHome']);
    Route::get('home', [HomePageController::class, 'ShowHome']);
    Route::get('trainers', [HomePageController::class, 'ShowTrainer']);
    Route::get('crouses', [HomePageController::class, 'ShowCrouse']);
    Route::get('details/{id}', [CrouseDetail::class, 'ShowCrouseDetails']);
    Route::post('details/{id}', [CrouseDetail::class, 'RegisterStudent']);


});


// Route Login, Logout
Route::get('login',[AuthController::class,'login']);
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

    Route::get('admin/register/list', [RegisterController::class, 'list']);
    Route::get('admin/register/delete/{id}', [RegisterController::class, 'delete']);
    Route::get('admin/register/approve/{id}', [RegisterController::class, 'approve']);


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
    Route::get('admin/assign_class_teacher/list',[AssignClassTeacherController::class,'list']);
    Route::get('admin/assign_class_teacher/add',[AssignClassTeacherController::class,'add']);
    Route::post('admin/assign_class_teacher/add',[AssignClassTeacherController::class,'insert']);
    Route::get('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class, 'edit']);
    Route::post('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class, 'update']);
    Route::get('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class, 'edit_single']);
    Route::post('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class, 'update_single']);
    Route::get('admin/assign_class_teacher/delete/{id}', [AssignClassTeacherController::class, 'delete']);


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


    Route::get('admin/communicate/notice_board', [CommunicateController::class, 'NoticeBoard']);
    Route::get('admin/communicate/notice_board/add', [CommunicateController::class, 'AddNoticeBoard']);
    Route::post('admin/communicate/notice_board/add', [CommunicateController::class, 'InsertNoticeBoard']);
    
    Route::get('admin/communicate/notice_board/edit/{id}', [CommunicateController::class, 'EditNoticeBoard']);

    Route::post('admin/communicate/notice_board/edit/{id}', [CommunicateController::class, 'UpdateNoticeBoard']);

    Route::get('admin/communicate/notice_board/delete/{id}', [CommunicateController::class, 'DeleteNoticeBoard']);
    



    //change password url:
    Route::get('admin/change_password',[UserController::class,'change_password']);
    Route::post('admin/change_password',[UserController::class,'update_change_password']);

});

Route::group(['middleware' => 'teacher'], function () {

    Route::get('teacher/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('teacher/change_password', [UserController::class, 'change_password']);
    Route::post('teacher/change_password', [UserController::class, 'update_change_password']);

    Route::get('teacher/account', [UserController::class, 'MyAccount']);
    Route::post('teacher/account', [UserController::class, 'UpdateMyAccount']);



    Route::get('teacher/my_student', [StudentController::class, 'MyStudent']);


    


    Route::get('teacher/my_class_subject', [AssignClassTeacherController::class, 'MyClassSubject']);
    Route::get('teacher/my_class_subject/class_timetable/{class_id}/{subject_id}', [ClassTimetableController::class, 'MyTimetableTeacher']);
    

    
    Route::get('teacher/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetableTeacher']);
    Route::get('teacher/my_exam_result/print', [ExaminationsController::class, 'myExamResultPrint']);

    Route::get('teacher/my_calendar', [CalendarController::class, 'MyCalendarTeacher']);


    Route::get('teacher/marks_register', [ExaminationsController::class, 'marks_register_teacher']); 
    Route::post('teacher/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']); 
    Route::post('teacher/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']); 


    Route::get('teacher/my_notice_board', [CommunicateController::class, 'MyNoticeBoardTeacher']);

    // Home Work:
    Route::get('teacher/homework/homework', [HomeworkController::class, 'HomeworkTeacher']);
    Route::get('teacher/homework/homework/add', [HomeworkController::class, 'addTeacher']);
    Route::post('teacher/ajax_get_subject', [HomeworkController::class, 'ajax_get_subject']);
    Route::post('teacher/homework/homework/add', [HomeworkController::class, 'insertTeacher']);
    Route::get('teacher/homework/homework/edit/{id}', [HomeworkController::class, 'editTeacher']);
    Route::post('teacher/homework/homework/edit/{id}', [HomeworkController::class, 'updateTeacher']);

    Route::get('teacher/homework/homework/delete/{id}', [HomeworkController::class, 'delete']); 
    
    Route::get('teacher/homework/homework/submitted/{id}', [HomeworkController::class, 'submittedTeacher']);
});


// Student api"
Route::group(['middleware' => 'student'], function(){
    Route::get('student/dashboard',[DashboardController::class,'dashboard']);

    Route::get('student/account', [UserController::class, 'MyAccount']);
    Route::post('student/account', [UserController::class, 'UpdateMyAccountStudent']);

    Route::get('student/my_notice_board', [CommunicateController::class, 'MyNoticeBoardStudent']); 

    // Time table:
    Route::get('student/my_subject', [SubjectController::class, 'MySubject']);
    Route::get('student/my_timetable', [ClassTimetableController::class, 'MyTimetable']);

    Route::get('student/my_calendar', [CalendarController::class, 'MyCalendar']);
    Route::get('student/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetable']);

    // Student homework api stuff:
    Route::get('student/my_homework', [HomeworkController::class, 'HomeworkStudent']);
    Route::get('student/my_homework/submit_homework/{id}', [HomeworkController::class, 'SubmitHomework']);
    Route::post('student/my_homework/submit_homework/{id}', [HomeworkController::class, 'SubmitHomeworkInsert']);

    
    Route::get('student/my_submitted_homework', [HomeworkController::class, 'HomeworkSubmittedStudent']);



    Route::get('student/change_password',[UserController::class,'change_password']);
    Route::post('student/change_password',[UserController::class,'update_change_password']);

    //student exam api
    Route::get('student/my_exam_result', [ExaminationsController::class, 'myExamResult']); 
    Route::get('student/my_exam_result/print', [ExaminationsController::class, 'myExamResultPrint']);
    
});

// Parent api:
Route::group(['middleware' => 'parent'], function(){
    Route::get('parent/my_student/subject/class_timetable/{class_id}/{subject_id}/{student_id}', [ClassTimetableController::class, 'MyTimetableParent']);

    //pảrent message board api
    Route::get('parent/my_student_notice_board', [CommunicateController::class, 'MyStudentNoticeBoardParent']); 
    Route::get('parent/dashboard',[DashboardController::class,'dashboard']);

    Route::get('parent/change_password',[UserController::class,'change_password']);
    Route::post('parent/change_password',[UserController::class,'update_change_password']);

    // parent api my student
    Route::get('parent/my_student/subject/{student_id}', [SubjectController::class, 'ParentStudentSubject']);
    Route::get('parent/my_student/exam_timetable/{student_id}', [ExaminationsController::class, 'ParentMyExamTimetable']);
    Route::get('parent/my_student/exam_result/{student_id}', [ExaminationsController::class, 'ParentMyExamResult']);
 
    // parent api check student exam
    Route::get('parent/my_exam_result/print', [ExaminationsController::class, 'myExamResultPrint']);
    Route::get('parent/my_student/calendar/{student_id}', [CalendarController::class, 'MyCalendarParent']);

    // parent check student homework:
    Route::get('parent/my_student/homewrok/{id}', [HomeworkController::class, 'HomeworkStudentParent']);
    Route::get('parent/my_student/submitted_homewrok/{id}', [HomeworkController::class, 'SubmittedHomeworkStudentParent']);



    Route::get('parent/my_notice_board', [CommunicateController::class, 'MyNoticeBoardParent']);
    Route::get('parent/my_student', [ParentController::class, 'myStudentParent']);

});