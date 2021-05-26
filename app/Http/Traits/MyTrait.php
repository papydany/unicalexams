<?php
namespace App\Http\Traits;
use App\Programme;
use App\Faculty;
use App\CourseReg;
use App\StudentResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
trait MyTrait {


 


 public function get_school_status($MatricNumber,$Session,$Level)
 {
  $response = file_get_contents('https://myunical.edu.ng/verifyfee/GetFeeStatus.ashx?matricno='.$MatricNumber.'&session='.$Session.'&level='.$Level);

  return $response;

}
// course without grade
public function courseWithOutGrade($courseTable,$session,$level,$id,$period)
{
  $course_id_with_no_result =array();
  $studentresult=StudentResult::where([['session',$session],['level_id',$level],['user_id',$id]])
  ->select('coursereg_id')
->get();

  $courseReg=DB::connection('mysql2')->table($courseTable)
->where([['period',$period],['session',$session],['level_id',$level],['user_id',$id]])
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

$sql =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','F'],['season',$season]])
->whereIn('course_id',$courseId )
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

if(in_array(substr($cosreg->course_code,0,3), $courseArray))

{
$courseId []=$v->course_id;
}else{

if($sql1 < 3)
{
  $courseId []=$v->course_id;
}
}
}//dd();
$reg =DB::table('register_courses')->whereIn('course_id',$courseId)
->where([['fos_id',Auth::user()->fos_id],['session',$s],['level_id',$l]])
->orderBy('semester_id','asc')->get();
return $reg;
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

//==============================end of medicine of function code=================
}
