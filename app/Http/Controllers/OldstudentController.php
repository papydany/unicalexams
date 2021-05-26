<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Pin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
class OldstudentController extends Controller
{
  
       public function __construct()
    {
       $this->middleware('usersession');
 }
    
    public function index()
    {
  
   $std_id = session()->get('std_id');
    $name =  session()->get('name');
    $matric_no =  session()->get('matric_no');
    $year =  session()->get('session_year');
    $yearplus = $year + 1;
$get_session = DB::connection('mysql1')->table('students_results')->select('std_mark_custom2','period')->distinct()->where([['std_mark_custom2','!=',""],['std_mark_custom2','<=', $year],['std_id',$std_id],['matric_no',$matric_no]])->get();

return view('result.index')->withName($name)->withMatric_no($matric_no)->withYear($year)->withYearplus($yearplus)->withGetsession($get_session);
    }
//====================================check result ==============================
   function check_result($sessional,$period)
  {
   if($sessional && $period)
   {
 $name =  session()->get('name');
 $matric_no =  session()->get('matric_no');
 $std_id = session()->get('std_id');
 $matric_no =  session()->get('matric_no');
 $yearplus = $sessional + 1;
 $c_gpa ='';
 $gpa = $this->get_gpa($sessional, $std_id,$period);
 if($period =="NORMAL")
 {
	$c_gpa =$this->get_cgpa($sessional, $std_id);
 }elseif($period =="VACATION")
 {
	$c_gpa =$this->get_cgpa_vacation($sessional, $std_id);
 }
 
 
 $level = $this->get_level($std_id,$sessional);

 if(empty($level))
 {
 	Session::flash('warning',"opps error occurs");
 	return redirect('oldresult');
 }
 $fac = $this->get_faculty();
 $dep = $this->get_department();
 $c_sty =$this->get_course_study();

 $r = $this->result_remark($std_id,$sessional,$c_gpa);

 $rc_id =$this->get_result_course_id($sessional,$std_id);

 
/* --------------get first semeter course reg --------------------------- */
 
$course_first = $this->getcourse_grade($sessional,$std_id,'First Semester',$level,$rc_id,$period);
$course_second = $this->getcourse_grade($sessional,$std_id,'Second Semester',$level,$rc_id,$period);

$course_1 = $this->getcourse_without_grade($sessional,$std_id,'First Semester',$level,$rc_id,$period);
$course_2 = $this->getcourse_without_grade($sessional,$std_id,'Second Semester',$level,$rc_id,$period);


return view('result.check_result')->withCourse_first($course_first)->withCourse_second($course_second)
->withY($sessional)->withYplus($yearplus)->withName($name)->withMatric_no($matric_no)->withGpa($gpa)
->withCgpa($c_gpa)->withLevel($level)->withR($r)->withFac($fac)->withDep($dep)->withCsty($c_sty)
->withCourse_1($course_1)->withCourse_2($course_2);

 }
   return back();
}

//============================= get result course id=========================
function get_result_course_id($session,$std_id){
	$cc =array();
$c =DB::connection('mysql1')->table('students_results')->distinct()
 ->where([['std_mark_custom2',$session],['std_id',$std_id]])
 ->select('stdcourse_id')->get();
 foreach($c as $v)
 {
	 $cc [] =$v->stdcourse_id;
 }
 return $cc;
}

// ============================ get student grade=======================
function getcourse_grade($sessional,$std_id,$semester,$level,$rc_id,$period)
{

$grade =DB::connection('mysql1')->table('course_reg')
 ->join('students_results', 'course_reg.thecourse_id', '=', 'students_results.stdcourse_id')
 ->where([['students_results.std_mark_custom2',$sessional],['students_results.std_id',$std_id]])
->where([['course_reg.cyearsession',$sessional],['course_reg.std_id',$std_id],['course_reg.csemester',$semester],['course_reg.clevel_id',$level],['course_reg.course_season',$period]])
->where('students_results.period',$period)
->whereIn('course_reg.thecourse_id',$rc_id)->orderBy('stdcourse_custom2','ASC')->get();
return $grade;
}

function getcourse_without_grade($sessional,$std_id,$semester,$level,$rc_id,$period)
{
	$grade =DB::connection('mysql1')->table('course_reg')
->where([['course_reg.cyearsession',$sessional],['course_reg.std_id',$std_id],['course_reg.csemester',$semester],['course_reg.clevel_id',$level],['course_reg.course_season',$period]])
->whereNOTIn('course_reg.thecourse_id',$rc_id)->orderBy('stdcourse_custom2','ASC')->get();
return $grade;
}

//====================================cgpa ==============================

function get_cgpa($s, $s_id){

	$tcu = 0; $tgp = 0;
	$row = DB::connection('mysql1')->table('students_results')->distinct()
	->join('course_reg', 'course_reg.thecourse_id', '=', 'students_results.stdcourse_id')
	->where([['students_results.std_mark_custom2','<=',$s],['students_results.std_id',$s_id],['std_cstatus',"yes"],['students_results.std_grade','!=',"N"],['students_results.period','NORMAL']])
	->where([['course_reg.cyearsession','<=',$s],['course_reg.std_id',$s_id],['course_reg.course_season','NORMAL']])
	->select('students_results.stdcourse_id', 'students_results.std_mark_custom2','students_results.std_grade','course_reg.c_unit')
	->get();
	
	if(count($row) > 0)
	{
	foreach ($row as $key => $value)
	{
	  // $cu = $this->get_crunit($value->stdcourse_id, $value->std_mark_custom2, $s_id);
	
	$cu = $value->c_unit;
	
	
	   $gp = $this->get_gradepoint ($value->std_grade, $cu);
	   $tcu += $cu;
	   $tgp += $gp;
	}
	
		@$gpa = $tgp / $tcu ;
		$gpa = number_format ($gpa,2); 
		return $gpa;
	}
	return 0;
	}

function get_cgpa_vacation($s, $s_id){

$tcu = 0; $tgp = 0;
$row = DB::connection('mysql1')->table('students_results')->distinct()
->join('course_reg', 'course_reg.thecourse_id', '=', 'students_results.stdcourse_id')
->where([['students_results.std_mark_custom2','<=',$s],['students_results.std_id',$s_id],['std_cstatus',"yes"],['students_results.std_grade','!=',"N"]])
->where([['course_reg.cyearsession','<=',$s],['course_reg.std_id',$s_id]])
->select('students_results.stdcourse_id', 'students_results.std_mark_custom2','students_results.std_grade','course_reg.c_unit')
->get();

if(count($row) > 0)
{
foreach ($row as $key => $value)
{
  // $cu = $this->get_crunit($value->stdcourse_id, $value->std_mark_custom2, $s_id);

$cu = $value->c_unit;


   $gp = $this->get_gradepoint ($value->std_grade, $cu);
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
function get_gpa($s,$s_id,$period)
{

$tcu = 0; $tgp = 0;
$row = DB::connection('mysql1')->table('students_results')
->join('course_reg', 'course_reg.thecourse_id', '=', 'students_results.stdcourse_id')
->where([['students_results.std_mark_custom2',$s],['students_results.std_id',$s_id],['std_cstatus',"yes"],['students_results.std_grade','!=',"N"],['students_results.period',$period]])
->where([['course_reg.cyearsession',$s],['course_reg.std_id',$s_id],['course_reg.course_season',$period]])
->select('students_results.stdcourse_id', 'students_results.std_id','students_results.std_grade','course_reg.c_unit')
->get();

if(count($row) > 0)
{
foreach ($row as $key => $value)
{
 // $cu = $this->get_crunit($value->stdcourse_id, $s, $s_id);
$cu =$value->c_unit;
  $gp = $this->get_gradepoint ($value->std_grade, $cu);
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
function get_crunit ($stdcourseid,$s,$stdid )
{
$cu = DB::connection('mysql1')->table('course_reg')->where([['thecourse_id',$stdcourseid],['cyearsession',$s],['std_id',$stdid]])->first();
if($cu != null)
{
return $cu->c_unit;
}
return '';
}
//===================================get grade point ==============================
function get_gradepoint ( $grade, $cu ){
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
	else if ($grade == 'N' )
		return 0.0 * $cu;
	
}
//====================================get level ==============================
function get_level($s_id,$s)
{
$g_level= DB::connection('mysql1')->table('registered_semester')->where([['std_id',$s_id],['ysession',$s]])->first();

if($g_level!=null)
{return $g_level->rslevelid;
}
return '';
}
//====================================result_remark==============================
function result_remark($std_id,$s,$cgpa)
{	
$fail=''; $pass=''; $c=0; $carryf='';$rept='';
$course_array =array(); $course_id_array =array(); $pass_course_id=array();$unpass_course_id='';
$l =$this->get_level($std_id,$s);
//$cgpa =$this->get_cgpa($s, $std_id);
$ss =$s-1;

// check for probation students
$probation_student=$this->student_probationa($l,$std_id,$s);


if($probation_student != 0)
{
$probation_condtion =$this->new_Probtion_4_probation_result($std_id,$cgpa,$l,$s);

if($probation_condtion == true)
{
	return $probation_condtion;
}
}

$new_prob=$this->new_Probtion($l,$std_id, $s,$cgpa);
if($new_prob==true)
{
return $new_prob;
}
//$sql_num = DB::connection('mysql1')->table('students_results')->where([['std_id',$std_id],['std_mark_custom2','=',$s],['std_grade',"F"],['level_id','=',$l]])->groupBy('stdcourse_id','stdresult_id')->select('stdcourse_id')->COUNT('stdcourse_id');

$sql = DB::connection('mysql1')->table('students_results')->where([['std_id',$std_id],['std_mark_custom2','=',$s],['std_grade',"F"],['level_id','=',$l]])->select('stdcourse_id','cu')->get();
if (count($sql)!=0){ // found failed courses in the level
	foreach($sql as $key => $value){
	$course_id_array []=$value->stdcourse_id;
		//$course_array []=['course_id'=>$key,'number'=>$value->count()];
	}
	

$sql1 = DB::connection('mysql1')->table('students_results')->whereIn('stdcourse_id',$course_id_array)->where([['std_id',$std_id],['std_mark_custom2','<=',$s],['std_grade','!=',"F"],['level_id','<=',$l]])->get();

 if(count($sql1) != 0  ){ //found that failed course passed in the level
	foreach ($sql1 as $k => $v)
	{
	$pass_course_id[]= $v->stdcourse_id;
	
	}
}
// the remain course_id that is not yet passed
$unpass_course_id=array_diff($course_id_array,$pass_course_id);

$sql3 = DB::connection('mysql1')->table('students_results')->where([['std_id',$std_id],['std_mark_custom2','<=',$s],['std_grade',"F"],['level_id','<=',$l]])
->whereIn('stdcourse_id',$unpass_course_id)->select('stdcourse_id')->get()->groupBy('stdcourse_id');
	 

	 foreach($sql3 as $k => $v) {
	$n = $v->count();
	
  if (in_array($k, $unpass_course_id))
  {
		$rowc = DB::connection('mysql1')->table('course_reg')->where([['thecourse_id',$k],['std_id',$std_id],['clevel_id','=',$l],['cyearsession','=',$s]])->first();
       if($rowc != null){
		$code = substr($rowc->stdcourse_custom2,0,3).' '.substr($rowc->stdcourse_custom2,3,4);
			
		$type = substr($rowc->stdcourse_custom2,0,3); // GSSS

		if ($n >= 3)
{
	if ($type != 'GSS' )
	{ 
		
if($this->ignore_carryF ($std_id, $k, $s ) == '')
	{
		$carryf .= ', '.$code;
	}
	} else {
		     $rept .= ', '.$code;
			}
} elseif($n < 3) 
{
	$rept .= ', '.$code;
}
	}
}
}

}

$take =$this->take_courses_sessional($std_id, $l, $s);


$carryf = $carryf != '' ? '<b>CARRY F </b>'.substr($carryf,2)."<br/>" : '';
$rept = $rept != '' ? '<b>RPT</b> '. substr($rept,2) : '';
$rept = $take != '' ? '<b>TAKE</b> '. $take .'<br/>'.$rept : $rept;
	//$dur = G_duration($std_id);
	
	//if (($l >= $dur) && ($rept == '')) {
	if ($rept == '') {	
		$fail = "<b>PASS</b>"."<br/>".$carryf;
	} else if (($carryf != '') && ($rept != '')) {
		$fail = $carryf . $rept;
	} else if (($carryf != '') && ($rept == '')) {
		$fail = "<b>PASS</b>"."<br/>".$carryf;
	} else if (($carryf != '') || ($rept != '')) {
		$fail = $carryf . $rept;
	} else { $fail = '<b>PASS</b>' ;}
	
	return $fail;
}
	// function for ignore carry F ========================
function ignore_carryF ($std_id, $thecourse_id, $s )
{
$sql1 = DB::connection('mysql1')->table('course_reg')->where([['std_id',$std_id],['cyearsession',$s],['thecourse_id',$thecourse_id]])->first();
if ($sql1 == null)
{ 
return 'true';
} else
{ 
return '';
}
	
}

function take_courses_sessional($stdid, $l, $s) 
{
	$fos = session()->get('fos'); 
	$take = '';
	$course_id = array();
	$course_array =array();
	
	$result = DB::connection('mysql1')->table('students_results')->where([['std_id',$stdid],['level_id',$l],['std_mark_custom2',$s]])->get();

	foreach ($result  as $key => $value) {
	$course_id[] = $value->stdcourse_id;
	}

	$sql1 = DB::connection('mysql1')->table('all_courses')->where([['course_custom2',$fos],['level_id',$l],['course_custom5',$s],['course_status',"C"]])
	 ->whereNotIn('thecourse_id',$course_id)
	->get();

	foreach ($sql1 as $k => $v) {
	 	$take.= ', '.substr($v->course_code,0,3).' '.substr($v->course_code,3,4);

			}

	$course_reg_elective = DB::connection('mysql1')->table('course_reg')->where([['std_id',$stdid],['clevel_id',$l],['cyearsession',$s],['stdcourse_custom3',"E"]])->get();	

	if(count($course_reg_elective) > 0)
{

foreach ($course_reg_elective  as $key => $value) {
	$course_array[] = $value->thecourse_id;
	}

		$sql2 = DB::connection('mysql1')->table('all_courses')->where([['course_custom2',$fos],['level_id',$l],['course_custom5',$s],['course_status',"E"]])
	 ->whereIn('thecourse_id',$course_array)
	  ->whereNotIn('thecourse_id',$course_id)
	->get();

	foreach ($sql2 as $k => $v) {
	 	$take.= ', '.substr($v->course_code,0,3).' '.substr($v->course_code,3,4);

			}	
		}
	
	
	
	return $take != '' ? substr($take,2) : '';
	}
//=========================get faculty ==========================
function get_faculty()
{
$id =  session()->get('faculty_id');
$sql = DB::connection('mysql1')->table('faculties')->where([['faculties_id',$id]])->first();
return $sql->faculties_name;
}

//=========================get Department ==========================
function get_department()
{
$fac_id =  session()->get('faculty_id');
$depart_id =  session()->get('depart_id');
$sql = DB::connection('mysql1')->table('departments')->where([['fac_id',$fac_id],['departments_id',$depart_id]])->first();
return $sql->departments_name;	
	}
//=========================get fcourse study ==========================
function get_course_study()
	{
	$id =  session()->get('fos');
$sql = DB::connection('mysql1')->table('dept_options')->where([['do_id',$id]])->first();

return $sql->programme_option;
	}
// ==========================get entry session ========================================
function get_entry_sesssion($std)
{
	$sql = DB::connection('mysql1')->table('students_profile')->where('std_id',$std)->first();	
	return $sql;
}
//  =========================== get fail course units ==============================================
function get_fail_crunit($l,$s_id,$s)
{
$sql = DB::connection('mysql1')->table('students_results')->where([['level_id',$l],['std_mark_custom2',$s],['std_id',$s_id],['std_grade','F']])->get();	
$cu=array();
foreach ($sql as $key => $value)
{
$cu [] = $value->cu;
}
 
$tcu=array_sum($cu);
return $tcu;
}	
//======================================= probation =========================================
function new_Probtion($l,$s_id,$s,$cgpa)
{
$return ='';
$fail_cu=$this->get_fail_crunit($l,$s_id,$s);
$entry_year =$this->get_entry_sesssion($s_id);
$prog = session()->get('programme_id');
if($prog == 7)
{
	if($entry_year->std_custome6 == "April")
	{
		$apend ="-AP";
		$new_prob ="2012".$apend;
	}elseif($entry_year->std_custome6 =="August") {
		 $apend ="-AG";
		  $new_prob ="2012".$apend;
	}
	
               
}else{
	$new_prob =2012;
	// $new_prob_2 =2014;
}

$y =$entry_year->std_custome2;
	if( $y< $new_prob)
	{
	
		
	if( $cgpa < 0.75 ){
		$return =  'WITHDRAW';
	}elseif(( $cgpa >= 0.75) && ($cgpa <= 0.99) ){
	$return =	 'PROBATION';
	}
	}else{


        if($fail_cu > 15 || $cgpa >=0.00 && $cgpa <=0.99 ){
			
		$return = 'WITHDRAW';
		}
		elseif($cgpa >=1.00 && $cgpa <=1.49 || $fail_cu ==15){

			$return = 'PROBATION';

		}elseif( $cgpa > 1.49 && $cgpa <=1.5 && $fail_cu ==15 ){
		$return = 'WITHDRAW OR CHANGE PROGRAMME';
		} 
		}

		return $return;
}

function new_Probtion_4_probation_result($s_id,$cgpa,$l,$s){
	$entry_year =$this->get_entry_sesssion($s_id);
	$failed = $this->get_fail_crunit($l,$s_id,$s);
	$return ='';
if($entry_year->std_custome2 >= 2012){
if( $cgpa < 1.5  || $failed >= 15 )
$return = 'WITHDRAW';
}else{
	
	if($cgpa < 0.75)
	$return = 'WITHDRAW';
	if( $cgpa <=1.00 && $cgpa > 0.74 )
		$return = 'WITHDRAW OR CHANGE PROGRAMME';
}
return $return;
}

function student_probationa($l,$std,$s){
	$ss = $s-1;
	
$sql = DB::connection('mysql1')->table('students_reg')->where([['std_id',$std],['yearsession',$ss],['level_id',$l]])->count();	
return $sql;
	
}


}
