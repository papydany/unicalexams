<?php

namespace App\Http\Controllers;
use App\StudentReg;
use App\StudentResult;
use App\CourseReg;
use App\Semester;
use App\RegisterCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Traits\MyTrait;


class MoppedUpController extends Controller
{
    use MyTrait;
Const Diploma = 2;
    public function index ()
    {
        $id = Auth::user()->id;
        $student_reg =StudentReg::where('user_id',$id)->whereIn('semester',[1,2])
        ->orderBy('level_id','desc')->orderBy('session','desc')->first();
    
        $s =$student_reg->session + 1;
        $s_next =$s+1;
    
        $student_type= session()->get('student_type'); // eg direct entry and normal students
        $all_semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
        if($student_reg != null)
        {
 
      
        $cgpa =$this->get_cgpa($s,$id,'NORMAL');
          // diploma  student 
if(Auth::user()->programme_id == self::Diploma)
{
$r = $this->result_remark_diploma($id,$student_reg->session,$student_reg->level_id,$cgpa);
}else{
// for normal students... diploma own is
$r = $this->Probtion($student_reg->level_id,$id,$student_reg->session,$cgpa,'NORMAL');//$this->result_remark($id,$student_reg->session,$student_reg->level_id,$cgpa,'NORMAL');
}

}else
{
  Session::flash('warning','You Have not register for last session. or contact system admin for further explanation'); 
  return back();
}
// check if all register courses has result
$course_id_with_no_result =array(); 
// modified to allow hnd 400 students to register first semester only cousrs of outstanding result in year 3 11/1/2022
// adding check for only first semester
if(Auth::user()->fos_id ==125 && $student_reg->level_id == 3 || Auth::user()->fos_id ==126 && $student_reg->level_id == 2)
{
$courseReg=CourseReg::where([['session',$student_reg->session],['level_id',$student_reg->level_id],['user_id',$id],['semester_id',1]])->get();
}else{
$courseReg=CourseReg::where([['session',$student_reg->session],['level_id',$student_reg->level_id],['user_id',$id]])->get();
}


foreach ($courseReg as $key => $value) {
$student_result=StudentResult::where([['session',$student_reg->session],['level_id',$student_reg->level_id],['user_id',$id],['coursereg_id',$value->id]])->first();
if($student_result == null)
{
 // introduce to check for GSS with no result for 2019 session
$ch =CourseReg::where([['id',$value->id],['session','2019']])->where('course_code','Like','GSS%')->first();
if($ch == null)
$course_id_with_no_result [] =$value->id;
}
}

if(count($course_id_with_no_result) == 0 )
{
if(Auth::user()->entry_year < 2019 ){
  if($s > 2019){
    Session::flash('warning',' mop up exams is for on 2014 to 2018 session only'); 
    return back();
  }
if($r== "WITHDRAW" || $r== "WITHDRAW OR CHANGE PROGRAMME" || $r== "CHANGE PROGRAMME" || $r=="PROBATION")
{
    return view('moppedUp.index')->withR($r)->withCwnr($course_id_with_no_result)->withS($s)->withSemester($all_semester)->withL($student_reg->level_id)->withNext($s_next);

}
}else{
    Session::flash('warning','your entry year is not qualify to write mopped exams'); 
    return back(); 
}
}else{
    Session::flash('warning','Outstanding result'); 
    return back();
}

}
public function moppedUp_semester_courses(Request $request)
{
  
  $session =$request->session;
  $level =$request->level;
  $id = Auth::user()->id;
  $previous_level =$level;
 $drop_register_course ="";
 $failed_register_course ="";

  // check if you have register for
 $check_student_reg=$this->CheckRegisterStudent(Auth::user()->id,$session,$level,'NORMAL');


if($check_student_reg == 0)
{
  $student_reg =StudentReg::where([['user_id',$id,],['level_id',$previous_level]])->orderBy('session','desc')->orderBy('level_id','desc')->first();
  // get failed courses
  $failed_courses_course_id =array();
  $unregister_course_id =array();
  $combine_course_id ='';
  $previous_session = $student_reg->session;

$failed_courses =$this->getCurrentFailedCourses($id,$level,$previous_session);

// check if the courses has been failed upto three times
if(count($failed_courses) > 0)
{
  foreach ($failed_courses as $key => $value) {
  $check_failed_courses =$this->NumberPreviousFailedCoursePerCourseId($id,$value->semester,$previous_session,$value->course_id);
 if($check_failed_courses < 3)
   {
$failed_courses_course_id [] =$value->course_id;
}
   }
  }

  // get carry over courses. ie compulsory course the students failed to do in the previous session
  $d_register_course =$this->GetRegisteredCompulsaryCoursesSession($previous_session,$previous_level);
 
if(count($d_register_course) > 0)
{
  foreach ($d_register_course as $key => $value) {
   $courseReg=$this->GetCourseRegSingle($previous_session,$previous_level,$id,$value->id,$value->course_id,$value->semester_id,'NORMAL');  
   
   if($courseReg == null)
   {
    $unregister_course_id [] =$value->course_id;
   }
  }
}


// combine the failed and unregister courses_id;
  if(!empty($failed_courses_course_id) && !empty($unregister_course_id))
  {
$combine_course_id =array_merge($failed_courses_course_id,$unregister_course_id);

  }elseif(!empty($failed_courses_course_id))
  {
$combine_course_id =$failed_courses_course_id;

  }
  elseif(!empty($unregister_course_id))
  {
    
$combine_course_id =$unregister_course_id;
  }

  if(!empty($combine_course_id))
  {
    foreach ($combine_course_id as $key => $value) {
      // get courses first
   $r_c =DB::connection('mysql')->table('register_courses')->where([['course_id',$value],['fos_id',Auth::user()->fos_id],['session',$previous_session]])->first();
   if($r_c != null){

     // check if failed or unregister courses id exist in register courses

      $check_register_course =DB::connection('mysql')->table('register_courses')->where([['course_id',$value],['fos_id',Auth::user()->fos_id],['session',$session],['level_id',$level],['reg_course_status',"G"]])->first();
      // failed or unregister courses id does not exist in register courses

      if($check_register_course == null)
      {
   $insert_data[] =['course_id'=>$value,'programme_id'=>Auth::user()->programme_id,'department_id'=>Auth::user()->department_id,'faculty_id'=>Auth::user()->faculty_id,'fos_id'=>Auth::user()->fos_id,'level_id'=>$level,'semester_id'=>$r_c->semester_id,'reg_course_title'=>$r_c->reg_course_title,'reg_course_code'=>$r_c->reg_course_code,'reg_course_unit'=>$r_c->reg_course_unit,'reg_course_status'=>"G",'session'=>$session];
      }
    }
    }
    

    if(!empty($insert_data)) 
    {
    DB::connection('mysql')->table('register_courses')->insert($insert_data);
  }

  // select course from register course
  // for failed course
  if(!empty($failed_courses_course_id))
  {
  $failed_register_course =$this->GetRegisteredCoursesWithArrayCourseIdNoSemester($session,$level,"G",$failed_courses_course_id);
}

// for drop courses
  if(!empty($unregister_course_id))
  {
 $drop_register_course =$this->GetRegisteredCoursesWithArrayCourseIdNoSemester($session,$level,"G",$unregister_course_id);
  
}

}
    
}else
{

 Session::flash('danger',"you have register for these semester. Thank you");
 return back();
}
$next =$session + 1;
return view('moppedUp.courses')->withDrc($drop_register_course)->withFrc($failed_register_course)->withL($level)->withS($session)->withNext($next);
}


 //------------------------- register course mopped up----------------------

    public function post_moppedUp_semester_courses(Request $request)
    {
    
       $idf = $request->input('idf');
       $idd = $request->input('idd');
       $session=$request->session;
      $level =$request->level;
       $check_student_reg =$this->CheckRegisterStudent(Auth::user()->id,$session,$level,'NORMAL');

    if($check_student_reg == 0)
    {
$student_reg = new StudentReg;
$student_reg->user_id =Auth::user()->id;
$student_reg->session = $session;
$student_reg->semester =1;
$student_reg->programme_id =Auth::user()->programme_id;
$student_reg->faculty_id =Auth::user()->faculty_id;
$student_reg->department_id =Auth::user()->department_id;
$student_reg->level_id =$level;
$student_reg->moppedUp =1;
$student_reg->season ="NORMAL";
$student_reg->save();

$student_reg2 = new StudentReg;
$student_reg2->user_id =Auth::user()->id;
$student_reg2->session = $session;
$student_reg2->semester =2;
$student_reg2->programme_id =Auth::user()->programme_id;
$student_reg2->faculty_id =Auth::user()->faculty_id;
$student_reg2->department_id =Auth::user()->department_id;
$student_reg2->level_id =$level;
$student_reg2->moppedUp =1;
$student_reg2->season ="NORMAL";
$student_reg2->save();

       
if($student_reg->id){
  // register failed courses
  if($idf != null)
  {
      $data_f =RegisterCourse::whereIn('id',$idf)->get();

        foreach ($data_f as $key => $vf) {
         $insert_data_f[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$vf->id,'user_id'=>Auth::user()->id,'level_id'=>$vf->level_id,'semester_id'=>$vf->semester_id,'course_id'=>$vf->course_id,'course_title'=>$vf->reg_course_title,'course_code'=>$vf->reg_course_code,'course_unit'=>$vf->reg_course_unit,'course_status'=>"R",'session'=>$vf->session,'period'=>"NORMAL"];
        }  

        DB::connection('mysql2')->table('course_regs')->insert($insert_data_f);
  }
    
  // register drop courses
  if($idd != null)
  {
          $data_d =RegisterCourse::whereIn('id',$idd)->get();

        foreach ($data_d as $key => $vd) {
         $insert_data_d[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$vd->id,'user_id'=>Auth::user()->id,'level_id'=>$vd->level_id,'semester_id'=>$vd->semester_id,'course_id'=>$vd->course_id,'course_title'=>$vd->reg_course_title,'course_code'=>$vd->reg_course_code,'course_unit'=>$vd->reg_course_unit,'course_status'=>"D",'session'=>$vd->session,'period'=>"NORMAL"];
        }  

        DB::connection('mysql2')->table('course_regs')->insert($insert_data_d);
    }
         Session::flash('success',"Courses for mopped exams successfully registered .");
       }
    }else{
 Session::flash('warning',"you have register for these session already.");
    }

  
return redirect()->action('UndergraduateController@index');
} 


}

