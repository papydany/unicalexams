<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('getFaculty','Api\StudentController@faculty');
Route::get('getDepartment/{faculyId}','Api\StudentController@department');
Route::get('getFos/{departmentId}','Api\StudentController@fos');
Route::Post('getRegisteredCourse','Api\StudentController@getRegisteredCourse');
Route::Post('getFosWithMatricNo','Api\StudentController@getFosWithMatricNo');
Route::Post('updateStudentFos','Api\StudentController@updateStudentFos');
Route::post('postRegisteredCourse','Api\StudentController@postRegisteredCourse');
Route::get('viewRegisteredCourse/{matric_number}/{levelId}/{session}/{semesterId}','Api\StudentController@viewRegisteredCourse');
Route::get('viewResult/{matric_number}/{levelId}/{session}/{semesterId}','Api\StudentController@viewResult');
Route::get('julius','Api\StudentController@julius');