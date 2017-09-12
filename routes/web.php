<?php

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
Route::post('/demo', ['as' => 'demo', 'uses' => 'SoapController@demo']);
Route::get('/demo', ['as' => 'demo', 'uses' => 'SoapController@demo']);
Route::get('/', 'HomeController@index');
Route::get('/faq', 'HomeController@faq');
Route::get('/contact', 'HomeController@contact');
Route::post('/contact', 'HomeController@postcontact');
Route::post('/success', 'HomeController@success');
Route::get('/profile', 'UndergraduateController@index');
Route::get('/register_course', 'UndergraduateController@register_course');
Route::post('/preview_course', 'UndergraduateController@preview_course');
Route::get('/preview_course', 'UndergraduateController@register_course');
Route::post('/register_course', 'UndergraduateController@post_register_course');
Route::get('/print_course', 'UndergraduateController@print_course');
Route::get('/view_register_course', 'UndergraduateController@view_register_course');
Route::post('/view_register_course', 'UndergraduateController@post_view_register_course');
Route::get('/getdepartment/{id}', 'Auth\RegisterController@getdepartment');
Route::get('/getlga/{id}', 'Auth\RegisterController@getlga');
Route::get('/getfos/{id}/{p_id}', 'Auth\RegisterController@getfos');
Route::get('/view_result', 'UndergraduateController@view_result');
Route::post('/view_result', 'UndergraduateController@post_view_result');

//============================ old student returning =======================================
Route::get('oldreturnstudent', ['uses' =>'OldstudentController@index','middleware' => 'usersession']);
Route::get('std_logout','Auth\LoginController@std_logout');
Route::post('std_login','Auth\LoginController@std_login');
Route::get('std_login','Auth\LoginController@s_login');
Route::get('std_logout','Auth\LoginController@std_logout');
Route::get('oldresult','OldstudentController@index'); 
Route::get('check_result/{sessional}','OldstudentController@check_result');
Route::get('/enter_pin', 'Auth\LoginController@enter_pin');
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

Auth::routes();


