<?php

namespace App\Http\Controllers\Api;

use App\CourseReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FacultyResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\FosResource;
use App\Http\Resources\RegisterCourseResource;
use App\Http\Resources\CourseRegResource;
use App\Http\Resources\ResultResource;
use App\Faculty;
use App\Department;
use App\RegisterCourse;
use App\Fos;
use App\StudentReg;

use Illuminate\Support\Facades\DB;
use App\Http\Traits\MyTrait;

class StudentController extends Controller
{
  use MyTrait;
    public function faculty()
    {
       $f= Faculty::get();
   
       return FacultyResource::collection($f); 
    }

    public function Department($id)
    {
       $d= Department::where('faculty_id',$id)->get();
       return DepartmentResource::collection($d); 
    }

    public function fos($id)
    {
       $fos= fos::where('department_id',$id)->get();
       return FosResource::collection($fos); 
    }

    public function getRegisteredCourse(Request $request)
    {
     
      $request->validate([
         'matric_number' => ['required'],
         'merchantID' => ['required'],
        'semesterId'=>['required'],
     ]);
     $matric_number = $request['matric_number'];
    $merchantID = $request['merchantID'];
    $levelId = 1;
    $session = 2020;
    $semesterId = $request['semesterId'];
    if($merchantID == '3AQ')
{
      $checkProfile =DB::connection('mysql2')->table('users')->where('matric_number',$matric_number)->first();
    if($checkProfile == null){
       // profile dont exist.
      return response()->json('100');
    }
    $fosId = $checkProfile->fos_id;
    if($fosId != 0){
        $rc =RegisterCourse::where([['fos_id',$fosId],['level_id',$levelId],['session',$session],['semester_id',$semesterId]])
        ->where('reg_course_status',['C','E'])
        ->get();
        return RegisterCourseResource::collection($rc);
    }else{
       // no fos id
      return response()->json('102');
    }
   }else{
   // merchant id does not exist
 return response()->json('000');
}
    }

    public function getFosWithMatricNo(Request $request)
    {
      $request->validate([
         'matric_number' => ['required'],
         'merchantID' => ['required'],
      ]); 
      $matric_number = $request['matric_number'];
      $merchantID = $request['merchantID'];
      if($merchantID == '3AQ')
      {
         $checkProfile =DB::connection('mysql2')->table('users')->where('matric_number',$matric_number)->first();
         

         if($checkProfile == null){
            // profile dont exist.
           return response()->json('100');
         }
         $department = $checkProfile->department_id;
         $fos= fos::where('department_id',$department)->get();
       return FosResource::collection($fos); 
      }else{
         // merchant id does not exist
       return response()->json('000');
      }
    }

    public function updateStudentFos(Request $request)
    {
      $request->validate([
         'matric_number' => ['required'],
         'merchantID' => ['required'],
        'fosId'=>['required'],
     ]);

     $matric_number = $request['matric_number'];
     $merchantID = $request['merchantID'];
     $fosId = $request['fosId'];
     if($merchantID == '3AQ')
 {
  $u = DB::connection('mysql2')->table('users')->where('matric_number',$matric_number)->update(['fos_id',$fosId]);
  if($u == 1){
   return response()->json('200');
  }else{
   return response()->json('00');
  }
}else{
   // merchant id does not exist
 return response()->json('000');
}
    }

    public function postRegisteredCourse(Request $request)
    {
        $request->validate([
            'matric_number' => ['required'],
            'merchantID' => ['required'],
           'semesterId'=>['required'],
        ]);
        //merchant code is 1470
        $merchantID =$request->merchantID;
if($merchantID == '3AQ')
{
    $matric_number = $request['matric_number'];
    $merchantID = $request['merchantID'];
    $levelId = 1;
    $session = 2020;
    $semesterId = $request['semesterId'];
    $id = $request->input('id');
   
  $checkProfile =DB::connection('mysql2')->table('users')->where('matric_number',$matric_number)->first();
    if($checkProfile == null){
       // profile dont exist.
      return response()->json('100');
    }

   $checkStudentReg =StudentReg::where([['user_id',$checkProfile->id],['session',$session],['level_id',$levelId],['semester',$semesterId]])->first();
   if($checkStudentReg != null){
      // you have register for these semester
return response()->json('101');
   }
   $student_reg = new StudentReg;
   $student_reg->user_id =$checkProfile->id;
   $student_reg->session = $session;
   $student_reg->semester =$semesterId;
   $student_reg->programme_id =$checkProfile->programme_id;
   $student_reg->faculty_id =$checkProfile->faculty_id;
   $student_reg->department_id =$checkProfile->department_id;
   $student_reg->level_id =$levelId;
   $student_reg->season ="NORMAL";
   $student_reg->merchantID=$merchantID;
   $student_reg->save();

   $reg =RegisterCourse::whereIn('id',$id)->get();
   foreach($reg as $value){
   $data[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$value->id,'user_id'=>$checkProfile->id,'level_id'=>$levelId,'semester_id'=>$semesterId,'course_id'=>$value->course_id,'course_title'=>$value->reg_course_title,'course_code'=>$value->reg_course_code,'course_unit'=>$value->reg_course_unit,'course_status'=>$value->reg_course_status,'session'=>$session,'period'=>"NORMAL"];
   } 
 DB::connection('mysql2')->table('course_regs')->insert($data);
 //success full
return response()->json('200');

  }else{
     // merchant id does not exist
   return response()->json('000');
}
        
    
}

public function viewRegisteredCourse($matric_number,$levelId,$session,$semesterId)
    {
      $m =str_replace('_','/',$matric_number);
       
       $user=DB::connection('mysql2')->table('users')->where('matric_number',$m)->first();
     
       if($user == null)
       {
         return response()->json('000');
       }
     
        $rc =CourseReg::where([['user_id',$user->id],['level_id',$levelId],['session',$session],['semester_id',$semesterId]])
        ->get();
        //dd($rc);
        return CourseRegResource::collection($rc);
    }

    public function viewResult($matric_number,$levelId,$session,$semesterId)
    {
      $m =str_replace('_','/',$matric_number);
       $user=DB::connection('mysql2')->table('users')->where('matric_number',$m)->first();

       if($user == null)
       {
         return response()->json('000');
       }
     
        $rc =DB::connection('mysql2')->table('course_regs')
        ->join('student_results','course_regs.id', '=', 'student_results.coursereg_id')
        ->where([['course_regs.user_id',$user->id],['course_regs.level_id',$levelId],['course_regs.session',$session],['course_regs.semester_id',$semesterId]])
        ->Select('course_code','student_results.*')
        ->get();
        return ResultResource::collection($rc);
    }

    public function julius()
    {
    $this->getBioDataFromJulius();
    }
    

}
