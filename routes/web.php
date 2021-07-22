<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Clear Cache facade value:
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
});

Route::get('/', 'HomeController@index');
Route::get('/faq', 'HomeController@faq');
Route::get('/contact', 'HomeController@contact');
Route::post('/contact', 'HomeController@postcontact');
Route::post('/success', 'HomeController@success');
//=========================================================
// edit images from admin
Route::get('edit_imagerrrrrrr98888880/{id}','HomeController@edit_image');
Route::post('edit_imagerrrrrrr98888880','HomeController@post_edit_image');
//=========================recovery pin=================
//Route::get('recovery_pin','HomeController@recovery_pin');
//Route::post('recovery_pin','HomeController@post_recovery_pin');
//==========================================================
Route::get('/profile', 'UndergraduateController@index');
Route::get('/register_course', 'UndergraduateController@register_course');
Route::post('/preview_course', 'UndergraduateController@preview_course');
Route::get('/preview_course', 'UndergraduateController@register_course');
Route::post('/register_course', 'UndergraduateController@post_register_course');
Route::get('/print_course', 'UndergraduateController@print_course');
Route::get('/view_register_course', 'UndergraduateController@view_register_course');
Route::post('/view_register_course', 'UndergraduateController@post_view_register_course');
Route::get('/getdepartment/{id}', 'Auth\RegisterController@getdepartment');
Route::get('/getdept/{id}', 'UndergraduateController@getdept');
Route::get('/gfos/{id}/{p_id}', 'UndergraduateController@gfos');
Route::get('/getlga/{id}', 'Auth\RegisterController@getlga');
Route::get('/getfos/{id}/{p_id}', 'Auth\RegisterController@getfos');
Route::get('/view_result', 'UndergraduateController@view_result');
Route::post('/view_result', 'UndergraduateController@post_view_result');
//Route::get('/edit_fos', 'UndergraduateController@edit_fos');
//Route::post('/edit_fos', 'UndergraduateController@post_edit_fos');
//Route::get('/edit_fac', 'UndergraduateController@edit_fac');
//Route::post('/edit_fac', 'UndergraduateController@post_edit_fac');
Route::get('/addCourses', 'UndergraduateController@addCourses');
Route::post('/addCourses', 'UndergraduateController@post_addCourses');
Route::post('/preview_addcourse', 'UndergraduateController@preview_addcourse');
Route::get('/preview_addcourse', 'UndergraduateController@preview_addcourse');
Route::get('/deleteCourses', 'UndergraduateController@deleteCourses');
Route::post('/deleteCourses', 'UndergraduateController@post_deleteCourses');
Route::get('/preview_deletecourse', 'UndergraduateController@preview_deletecourse');
Route::post('/preview_deletecourse', 'UndergraduateController@preview_deletecourse');
Route::post('/removecourse', 'UndergraduateController@removecourse');
Route::post('/register_addcourse', 'UndergraduateController@post_register_addcourse');
//Route::get('/edit_matric_number', 'UndergraduateController@edit_matric_number');
//Route::post('/edit_matric_number', 'UndergraduateController@post_edit_matric_number');
//Route::get('/edit_names', 'UndergraduateController@edit_names');
//Route::post('/edit_names', 'UndergraduateController@post_edit_names');

//Route::get('/edit_email', 'UndergraduateController@edit_email');
//Route::post('/edit_email', 'UndergraduateController@post_edit_email');
//Route::get('/edit_phone_number', 'UndergraduateController@edit_phone_number');
//Route::post('/edit_phone_number', 'UndergraduateController@post_edit_phone_number');

// ==================== returning students ===============================================
//Route::get('returning_register_course','UndergraduateController@returning_register_course');
//-------------------------- medicine --------------------------------
Route::get('returningStudentMedicine','UndergraduateController@returningStudentMedicine');

Route::get('regMore','UndergraduateController@returning_register_course');
Route::post('returningRegisterCourse','UndergraduateController@returningRegisterCourse');
Route::get('returningRegisterCourse','UndergraduateController@returningRegisterCourse');
Route::get('returning_register_semester_courses','UndergraduateController@returning_register_semester_courses');
Route::get('returning_preview_course','UndergraduateController@returning_preview_course');
Route::post('returning_post_register_course','UndergraduateController@returning_post_register_course');
Route::get('returning_medicine_preview_course','UndergraduateController@returning_medicine_preview_course');
Route::post('returning_post_medicine_register_course','UndergraduateController@returning_post_medicine_register_course');

Route::get('probation_semester_courses','UndergraduateController@probation_semester_courses');

Route::post('probation_post_register_course', 'UndergraduateController@probation_post_register_course');
//--------------- summer registration-------------------------
Route::get('register_summer_course','UndergraduateController@registerSummerCourse');
Route::post('register_summer_course','UndergraduateController@register_summer_course');
Route::get('previewSummerCourse','UndergraduateController@previewSummerCourse');
Route::post('postSummerCourse','UndergraduateController@postSummerCourse');
Route::get('register_delayed_course','UndergraduateController@register_delayed_course');
//========================== register long vacation===================================
Route::get('register_long_vacation/{level?}/{duration?}/{session?}','UndergraduateController@register_long_vacation');
Route::get('previewVacationCourse','UndergraduateController@previewVacationCourse');
Route::post('postVacationCourse','UndergraduateController@postVacationCourse');
//============================ old student returning =======================================
Route::get('oldreturnstudent', ['uses' =>'OldstudentController@index','middleware' => 'usersession']);
Route::get('std_logout','Auth\LoginController@std_logout');
Route::post('std_login','Auth\LoginController@std_login');
Route::get('std_login','Auth\LoginController@s_login');
Route::get('std_logout','Auth\LoginController@std_logout');
Route::get('oldresult','OldstudentController@index'); 
Route::get('check_result/{sessional}/{period}','OldstudentController@check_result');


// stop registration
Route::get('/enter_pin1', 'Auth\LoginController@enter_pin1');
Route::post('/enter_pin1', 'Auth\LoginController@post_enter_pin1');
// active registration link
Route::get('/jesusChrist', 'Auth\LoginController@enter_pin');
Route::post('/enter_pin', 'Auth\LoginController@post_enter_pin');
//==============================predegreee student===================================================
Route::get('pdg_register',['uses' =>'Auth\RegisterController@pdg_register','middleware' => 'checkreg']);
Route::get('udg_register',['uses' =>'Auth\RegisterController@showRegistrationForm','middleware' => 'checkudg']);
Route::post('udg_register',['uses' =>'Auth\RegisterController@register','middleware' => 'checkudg']);
Route::post('pdg_register','Auth\RegisterController@post_pdg_register');
Route::get('pds','PdsController@index');
Route::get('home', ['uses' =>'HomeController@index','middleware' => 'auth:pdg']);
Route::get('/pds_view_result', 'PdsController@pds_view_result');
Route::get('/pds_enter_pin', 'Auth\LoginController@pds_enter_pin');
Route::post('/pds_enter_pin', 'Auth\LoginController@pds_post_enter_pin');

//=============================== diploma students ===========================
Route::get('register_resit_course','UndergraduateController@register_resit_course');
Route::post('register_resit_course','UndergraduateController@post_register_resit_course');
Route::post('register_resit_course1','UndergraduateController@post_register_resit_course1');
Auth::routes();
Route::get('logout','Auth\LoginController@logout');


