<?php
namespace App\Http\Traits;
use App\CourseReg;
use App\StudentReg;
use App\StudentResult;
use App\Fos;
use App\RegisterCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

trait MyTrait {


 


 public function get_school_status($MatricNumber,$Session,$Level)
 {
  $response = file_get_contents('https://myunical.edu.ng/verifyfee/GetFeeStatus.ashx?matricno='.$MatricNumber.'&session='.$Session);

  return $response;

}

public function getBioDataFromJulius(){
  $client = new \GuzzleHttp\Client();
/*  $response = $client->request('POST','https://portalapi.unical.edu.ng/prod/unicore/v1/api/ExternalQuery/Authenticate', ['json' =>[
    'username' => 'myexbackend@portal.com',
    'password' => 'dWq6R2#:Cp/X'
]]);
if($response){*/
$data ='';//json_decode($response->getBody());
$key ='';//$data->cipherKey;
$token ='';//$data->token;
$request = ["reg_no" =>"20028686GA",
"dept_id" =>0,
"fac_id" =>0];
$signature =$this->signature($request,$key);
dd($signature);
$headers = [
  'Authorization' => 'Bearer '.$token,        
  'Accept'        => 'application/json',
  "Content-Type"  => "application/json",
  "X-TIM-Signature"=>$signature
];



$response2 = $client->request('POST','https://portalapi.unical.edu.ng/prod/unicore/v1/api/ExternalQuery/GetBioData',['header'=>$headers] ,['json' =>
  $request]);
  var_dump($response2->getBody());
  die();
//}
}

public function signature($request, $key)
{
$key ='41762201743b43468d721187cdf2646a';
 $requestJson = json_encode($request);
$requestBytes = utf8_encode($requestJson);
$cipherBytes = utf8_encode('41762201743b43468d721187cdf2646a');
$hmac = hash_hmac('sha256',$requestBytes, $cipherBytes);
$signature = $hmac;
return $signature;
}

// course without grade
public function courseWithOutGrade($courseTable,$session,$level,$id,$period)
{
  $course_id_with_no_result =array();
  $studentresult=StudentResult::where([['session',$session],['level_id',$level],['user_id',$id]])
  ->select('coursereg_id')
->get();
$p =array();
if($period == 'NORMAL')
{
  $p =['NORMAL'];
}elseif($period == 'VACATION'){
  $p =['NORMAL','VACATION'];
}else{
  $p =[$period];
}
  $courseReg=DB::connection('mysql2')->table($courseTable)
->where([['period',$p],['session',$session],['level_id',$level],['user_id',$id]])
->whereNotIn('id',$studentresult)
->get();
foreach ($courseReg as $key => $value) {
  $course_id_with_no_result [] =$value->id;
}
return $course_id_with_no_result;
}

// ----------------- drop course unit----------------------------
public function dropCourseUnit($id,$l,$s,$period)
{
  $sql1 = CourseReg::where([['user_id',$id],['level_id',$l],['session',$s],['period',$period]])
  ->whereIn('course_status',['C','E'])
  ->select('course_id')
 ->get();
  $sql2 = DB::table('register_courses')
         ->where([['reg_course_status','C'],['level_id',$l],['session',$s],['fos_id',Auth::user()->fos_id]])
         ->whereNotIn('course_id',$sql1)
        ->get();
        $c =$sql2->sum('reg_course_unit');

 
return $c;
}
/**--------------- failed course unit-------------------------------------------- */
public function failCourseUnit($l,$id,$s,$season)
{
  $courseId =array();
  $courseArray=['GSS','GST'];
$sql2 =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','F'],['season',$season]])
->select('course_id')->get();
foreach($sql2 as $v)
{
$sql1 =DB::connection('mysql2')->table('student_results')
->where([['course_id',$v->course_id],['session','<=',$s],['user_id',$id],['grade','F']])
->get()->count();
$reg =CourseReg::where([['course_id',$v->course_id],['session',$s],['user_id',$id]])->first();
if($reg != null){
if( in_array(substr($reg->course_code,0,3), $courseArray))

{
$courseId []=$v->course_id;
}else{

if($sql1 < 3)
{
  $courseId []=$v->course_id;
}
}
}
}

$sql =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','F'],['season',$season]])
->whereIn('course_id',$courseId )
->get(); 
$tc =$sql->sum('cu');
return $tc;
}


public function passedCourseUnit($l,$id,$s,$season)
{
  $courseId =array();
  $courseArray=['GSS','GST'];
/*$sql2 =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','!=','F'],['season',$season]])
->select('course_id')->get();
foreach($sql2 as $v)
{
$sql1 =DB::connection('mysql2')->table('student_results')
->where([['course_id',$v->course_id],['session','<=',$s],['user_id',$id],['grade','F']])
->get()->count();
$reg =CourseReg::where([['course_id',$v->course_id],['session',$s],['user_id',$id]])->first();

if( in_array(substr($reg->course_code,0,3), $courseArray))

{
$courseId []=$v->course_id;
}else{

if($sql1 < 3)
{
  $courseId []=$v->course_id;
}
}
}*/

$sql =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','!=','F'],['season',$season]])
->get(); 
$tc =$sql->sum('cu');
return $tc;
}

// ----------------- drop course ----------------------------
public function dropCourse($id,$l,$s,$period)
{
  $sql1 = CourseReg::where([['user_id',$id],['level_id',$l],['session',$s],['period',$period]])
  ->whereIn('course_status',['C','E'])
  ->select('course_id')
 ->get();
  $sql2 = DB::table('register_courses')
         ->where([['reg_course_status','C'],['level_id',$l],['session',$s],['fos_id',Auth::user()->fos_id]])
         ->whereNotIn('course_id',$sql1)->orderBy('semester_id','asc')
        ->get();
return $sql2;
}
/**--------------- failed course -------------------------------------------- */
public function failCourse($l,$id,$s,$season)
{
  $courseId =array();
  $courseArray=['GSS','GST'];
$sql =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','F'],['season',$season]])
->select('course_id')->get();
foreach($sql as $v)
{

  $sql1 =DB::connection('mysql2')->table('student_results')
  ->where([['course_id',$v->course_id],['session','<=',$s],['user_id',$id],['grade','F']])
->get()->count();
$cosreg =CourseReg::where([['course_id',$v->course_id],['session',$s],['user_id',$id]])->first();
//var_dump(substr($cosreg->course_code,0,3));
if($cosreg != null){
if(in_array(substr($cosreg->course_code,0,3), $courseArray))

{
$courseId []=$v->course_id;
}else{

if($sql1 < 3)
{
  $courseId []=$v->course_id;
}
}
}
}//dd();
$reg =DB::table('register_courses')->whereIn('course_id',$courseId)
->where([['fos_id',Auth::user()->fos_id],['session',$s],['level_id',$l]])
->orderBy('semester_id','asc')->get();
return $reg;
}

//------------------------- registered students------------------------
public function getStudentRegistered()
{
  $s = DB::connection('mysql2')->table('student_regs')->where([['user_id',Auth::user()->id],['semester',1]])
 ->select('session','level_id')->distinct('session')->orderBy('session','ASC')->get();
 
   return $s;
 


}

public function getAllStudentRegistered()
{
 $s = DB::connection('mysql2')->table('student_regs')->where('user_id',Auth::user()->id)
->select('*')->orderBy('session','ASC')->orderBy('season','ASC')->orderBy('semester','ASC')->get();
return $s;
}

public function updatePinLog1($pinId,$session)
{
  $affected = DB::table('pins')
  ->where('id', $pinId)
  ->update(['log1' => 1,'log_session'=>$session]);
}
public function updatePinLog2($pinId)
{
  $affected = DB::table('pins')
  ->where('id', $pinId)
  ->update(['log2' => 1]);
 }

 //================== get specialization id to use ===========================

 public function getSpecializationIdWithLevel($specializationId,$level)
 {
   if($specializationId == 0)
   {
     return 0;
   }else{
    // $s =Specialization::find($specializationId);
     $s = DB::table('specializations')->find($specializationId);

     if($level < $s->level)
     {
       return 0;
     }
     return $specializationId;
   }
 }

//================================medicine function code ==========================
public function failMedicineCourse($l,$id,$s)
{
  $courseId =array();
 
$sql =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','F']])
->select('course_id')->get();
foreach($sql as $v)
{
  $courseId [] =$v->course_id;
}
$reg =DB::table('register_courses')->whereIn('course_id',$courseId)
->where([['fos_id',Auth::user()->fos_id],['session',$s],['level_id',$l]])
->get();

return $reg;
}

//check if the have register for second year
public function checkRegisterForYearTwo($id)
{
  $fos =Fos::find(auth::user()->fos_id);
  if($fos->duration == 5)
  {
    return true;
  }
  $c =StudentReg::where([['user_id',$id],['level_id',2],['semester',1]])->first();
  if($c == null){
return false;
  }else{
    $cc =StudentReg::where([['user_id',$id],['level_id',2],['semester',2]])->first();
    if($cc == null)
    return false;
}

return true;

}

//==============================end of medicine of function code=================

//  ======================== check is student did probation======

public function student_probation($l,$id,$s){
	$ss = $s-1;
	
$sql = DB::connection('mysql2')->table('student_regs')->where([['user_id',$id],['session',$ss],['level_id',$l]])->count();	
return $sql;
	
}

//====================================cgpa ==============================
function get_cgpa($s,$user_id,$season){
  if($season == 'VACATION')
  {
    $takeType =['NORMAL','VACATION'];
  }else if($season == 'RESIT'){
    $takeType =['NORMAL','RESIT'];
  }else{
    $takeType =['NORMAL'];
  }
$tcu = 0; $tgp = 0;
$row = DB::connection('mysql2')->table('student_results')->distinct()
->join('course_regs', 'course_regs.id', '=', 'student_results.coursereg_id')
->where([['student_results.session','<=',$s],['student_results.user_id',$user_id],])
->where([['course_regs.session','<=',$s],['course_regs.user_id',$user_id]])
->whereIn('student_results.season',$takeType)
->get();
if(count($row) > 0)
{
foreach ($row as $key => $value)
{
  // $cu = $this->get_crunit($value->coursereg_id, $value->session, $user_id);
   $cu =$value->course_unit;
   $gp = $this->get_gradepoint($value->grade, $cu);
   $tcu += $cu;
   $tgp += $gp;
}

    @$gpa = $tgp / $tcu ;
    $gpa = number_format ($gpa,2); 
    return $gpa;
  }
  return 0;
}

//====================================gpa ==============================
public function get_gpa($s,$user_id,$season)
{

$tcu = 0; $tgp = 0;
$row = DB::connection('mysql2')->table('student_results')->distinct()
->join('course_regs', 'course_regs.id', '=', 'student_results.coursereg_id')
->where([['student_results.session',$s],['student_results.user_id',$user_id],['season',$season]])
->where([['course_regs.session',$s],['course_regs.user_id',$user_id]])
->get();

if(count($row) > 0)
{
foreach ($row as $key => $value)
{
 // $cu = $this->get_crunit($value->coursereg_id, $s, $user_id);
  $cu =$value->course_unit;
  $gp = $this->get_gradepoint ($value->grade, $cu);
  $tcu = $tcu + $cu;
  $tgp = $tgp + $gp;
}
 @$gpa = $tgp / $tcu ;
 $gpa = number_format ($gpa,2);
return $gpa;
}
return 0;
    
}
//====================================get credit unit ==============================
protected function get_crunit($id )
{
$cu = CourseReg::find($id);
return $cu->course_unit;
}
//===================================get grade point ==============================
public  function get_gradepoint($grade,$cu){

    if ($grade == 'A' )
        return 5.0 * $cu;
    else if ($grade == 'B' )
        return 4.0 * $cu;
    else if ($grade == 'C' )
        return 3.0 * $cu;
    else if ($grade == 'D' )
        return 2.0 * $cu;
    else if ($grade == 'E' )
        return 1.0 * $cu;
    else if ($grade == 'F' )
        return 0.0 * $cu ;
    
   }

   protected function Probtion($l,$id,$s,$cgpa,$season)
{
$return ='';
$fail_cu=$this->get_fail_crunit($l,$id,$s,$season);
//$entry_year =$this->get_entry_sesssion($id);
/*$p=Auth::user()->programme_id;
$f=Auth::user()->faculty_id;*/



$fos =$this->getFos();


if( $l >= $fos->duration)
{
  return $return;
}
$s_on_probation =$this->getprobationStudents($id,$l,$s);


if($s_on_probation == 'true')
{

if($cgpa >=0.00 && $cgpa <=0.99){
            
        $return = 'WITHDRAW';
        }
        elseif($cgpa >=1.00 && $cgpa <=1.49){

        $return = 'WITHDRAW OR CHANGE PROGRAMME';

        }
      
    
        return $return;
}else{

  
   if($fail_cu > 15 && $cgpa < 1.5 || $cgpa >=0.00 && $cgpa <=0.99){
            
        $return = 'WITHDRAW';
        }
        elseif($cgpa >=1.00 && $cgpa <=1.49 || $fail_cu ==15){

            $return = 'PROBATION';

        }elseif($cgpa >=1.5 && $fail_cu >15){
        $return = 'CHANGE PROGRAMME';
        } 
      //new condion for probation for medlap in 300l for DE and 400l for UME
//if they did not write second semester course the professonal exams, they have to repeat d class

        if($fos->id == 143 && $l == 4)
        {
          $sql2 = DB::table('register_courses')
          ->where([['reg_course_status','C'],['level_id',$l],['session',$s],['fos_id',$fos->id],['semester_id',2]])->first();
          $row = DB::connection('mysql2')->table('course_regs')
        ->where([['session',$s],['user_id',$id],['level_id',$l]])
        ->whereIn('course_id',[$sql2->course_id])
        ->get();
        if(count($row) == 0)
        {
          $return = 'PROBATION';
        }
        
        }elseif($fos->id == 144 && $l == 3){
          $sql2 = DB::table('register_courses')
          ->where([['reg_course_status','C'],['level_id',$l],['session',$s],['fos_id',$fos->id],['semester_id',2]])->first();
          
          $row = DB::connection('mysql2')->table('course_regs')
        ->where([['session',$s],['user_id',$id],['level_id',$l]])
        ->whereIn('course_id',[$sql2->course_id])
        ->get();
        
        if(count($row) == 0)
        {
          
          $return = 'PROBATION';
        }
        }

        return $return;
      }

}

//  =========================== get fail course units ==============================================
protected function get_fail_crunit($l,$id,$s,$season)
{
$sql =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','F'],['season',$season]])
->get(); 
$tcu=$sql->sum('cu');
return $tcu;
}

//---------------------------- get probation students -----------------------------------
public function getprobationStudents($id,$l,$s)
{
   // get student that did probation
 $s1 = $s-1;
 
 
//$prob_Student_reg = StudentReg::where([['user_id',$id],['session',$s],['level_id',$l]])->first();

$u = DB::connection('mysql2')->table('student_regs')
->where([['user_id',$id],['session',$s1],['level_id',$l]])->count();
if($u != 0){
return true;
}
return '';
}
//====================== get fos ======================================================
public function getFos()
{
   $fs=Auth::user()->fos_id;
$fss =Fos::find($fs);  
return $fss;
}
//============ get register students for a session=======================================
public function CheckRegisterStudent($id,$session,$level,$season)
{
$student_reg=StudentReg::where([['user_id',$id],['session',$session],['level_id',$level],['season',$season]])->get()->count();
return $student_reg;
}
/*----------------------- current failed courses --------------------------*/
public function getCurrentFailedCourses($id,$level,$session)
{
  $failed_courses =StudentResult::where([['user_id',$id,],['level_id',$level],['session',$session],['grade','F']])->get();
  return $failed_courses;
}

/*------------------------------- number of previous failed courses per course id --------------------*/
public function NumberPreviousFailedCoursePerCourseId($id,$semester,$previous_session,$course_id)
{

 $no_failed_courses =StudentResult::where([['user_id',$id,],['semester',$semester],['session','<=',$previous_session],['grade','F'],['course_id',$course_id]])->get()->count();
 return  $no_failed_courses;
}

/*------------------ get compulsary register courses in the session --------*/
public function GetRegisteredCompulsaryCoursesSession($session,$level)
{
  $specializationId =$this->getSpecializationIdWithLevel(Auth::user()->specialization_id,$level);
  if($specializationId > 0)
  {
  $regcourse= DB::table('register_courses')
    ->join('register_specializations', 'register_courses.id', '=', 'register_specializations.registercourse_id')
    ->where([['session',$session],['programme_id',Auth::user()->programme_id],['faculty_id',Auth::user()->faculty_id],['department_id',Auth::user()->department_id],['register_courses.fos_id',Auth::user()->fos_id],['level_id',$level],['reg_course_status','C']])
    ->where('register_specializations.specialization_id',$specializationId)
    ->select('register_courses.*')
    ->get();

  }else{
  $regcourse=RegisterCourse::where([['session',$session],['programme_id',Auth::user()->programme_id],['faculty_id',Auth::user()->faculty_id],['department_id',Auth::user()->department_id],['fos_id',Auth::user()->fos_id],['level_id',$level],['reg_course_status','C']])
  ->whereIn('specialization_id',[0,$specializationId])
  ->get();
  }

  return $regcourse;
}


/*-------------------------getsingele course reg at a time --------------------------------------*/
public function GetCourseRegSingle($session,$level,$id,$regcourse_id,$course_id,$semester,$period)
{
   $courseReg=CourseReg::where([['session',$session],['level_id',$level],['user_id',$id],['registercourse_id',$regcourse_id],['course_id',$course_id],['semester_id',$semester],['period',$period]])->first();
   return $courseReg; 
}

public function GetRegisteredCoursesWithArrayCourseIdNoSemester($session,$level,$status,$array_course_id)
{
   $regcourse =RegisterCourse::where([['fos_id',Auth::user()->fos_id],['session',$session],['level_id',$level],['reg_course_status',$status]])->whereIn('course_id',$array_course_id)->get();

   return $regcourse;
}
}
