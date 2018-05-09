<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Pin;
use Illuminate\Support\Facades\Session;
use DB;
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


    $get_session = DB::connection('mysql1')->table('students_results')->select('std_mark_custom2')->distinct()->where([['std_mark_custom2','<=', $year],['std_id',$std_id],['matric_no',$matric_no]])->get();
   

    return view('result.index')->withName($name)->withMatric_no($matric_no)->withYear($year)->withYearplus($yearplus)->withGetsession($get_session);
    }
//====================================check result ==============================
   function check_result($sessional)
  {
   if($sessional)
   {
 $name =  session()->get('name');
 $matric_no =  session()->get('matric_no');
 $std_id = session()->get('std_id');
 $matric_no =  session()->get('matric_no');
 $yearplus = $sessional + 1;

 $gpa = $this->get_gpa($sessional, $std_id);

 $c_gpa =$this->get_cgpa($sessional, $std_id);

 $level = $this->get_level($std_id,$sessional);

 if(empty($level))
 {
 	Session::flash('warning',"opps error occurs");
 	return redirect('oldresult');
 }
 $fac = $this->get_faculty();
 $dep = $this->get_department();
 $c_sty =$this->get_course_study();
 $r = $this->result_remark($std_id, $sessional);


 /*------------get first result -------------------------------------*/
 $result_first = DB::connection('mysql1')->table('students_results')
 ->join('course_reg', 'course_reg.thecourse_id', '=', 'students_results.stdcourse_id')
 ->where([['students_results.matric_no',$matric_no],['students_results.std_mark_custom2',$sessional],['students_results.std_id',$std_id]])
 ->where([['course_reg.cyearsession',$sessional],['course_reg.std_id',$std_id],['course_reg.csemester','First Semester']])
 ->select('course_reg.*', 'students_results.std_grade','students_results.cp')
 ->get();
/*------------get second result -------------------------------------*/
 $result_second = DB::connection('mysql1')->table('students_results')
 ->join('course_reg', 'course_reg.thecourse_id', '=', 'students_results.stdcourse_id')
 ->where([['students_results.matric_no',$matric_no],['students_results.std_mark_custom2',$sessional],['students_results.std_id',$std_id]])
 ->where([['course_reg.cyearsession',$sessional],['course_reg.std_id',$std_id],['course_reg.csemester','Second Semester']])
 ->select('course_reg.*', 'students_results.std_grade','students_results.cp')
 ->get();

 /*--------------------get all result------------------------------------------*/
 $result =DB::connection('mysql1')->table('students_results')->where([['matric_no',$matric_no],['std_mark_custom2',$sessional],['std_id',$std_id]])->get();
 if(count($result) > 0)
 {
 foreach ($result as $key => $value) {
 $result_id [] = $value->stdcourse_id;
 }

/* --------------get first semeter course reg --------------------------- */
 $course_first =DB::connection('mysql1')->table('course_reg')
 ->where([['cyearsession',$sessional],['std_id',$std_id],['csemester','First Semester'],['clevel_id',$level]])
 ->whereNotIn('thecourse_id',$result_id)->get();
 
 $course_second =DB::connection('mysql1')->table('course_reg')
 ->where([['cyearsession',$sessional],['std_id',$std_id],['csemester','Second Semester'],['clevel_id',$level]])
 ->whereNotIn('thecourse_id',$result_id)->get();

}

 return view('result.check_result')->withResult_first($result_first)->withResult_second($result_second)->withCourse_first($course_first)->withCourse_second($course_second)->withY($sessional)->withYplus($yearplus)->withName($name)->withMatric_no($matric_no)->withGpa($gpa)->withCgpa($c_gpa)->withLevel($level)->withR($r)->withFac($fac)->withDep($dep)->withCsty($c_sty);

 }
   return back();
}

//====================================cgpa ==============================
function get_cgpa($s, $s_id){

$tcu = 0; $tgp = 0;
$row = DB::connection('mysql1')->table('students_results')->distinct()
->join('course_reg', 'course_reg.thecourse_id', '=', 'students_results.stdcourse_id')
->where([['students_results.std_mark_custom2','<=',$s],['students_results.std_id',$s_id],['std_cstatus',"yes"],['students_results.std_grade','!=',"N"]])
->where([['course_reg.cyearsession','<=',$s],['course_reg.std_id',$s_id]])
->select('students_results.stdcourse_id', 'students_results.std_mark_custom2','students_results.std_grade')
->get();
if(count($row) > 0)
{
foreach ($row as $key => $value)
{
   $cu = $this->get_crunit($value->stdcourse_id, $value->std_mark_custom2, $s_id);


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
function get_gpa($s, $s_id)
{

$tcu = 0; $tgp = 0;
$row = DB::connection('mysql1')->table('students_results')->distinct()
->join('course_reg', 'course_reg.thecourse_id', '=', 'students_results.stdcourse_id')
->where([['students_results.std_mark_custom2',$s],['students_results.std_id',$s_id],['std_cstatus',"yes"],['students_results.std_grade','!=',"N"]])
->where([['course_reg.cyearsession',$s],['course_reg.std_id',$s_id]])
->select('students_results.stdcourse_id', 'students_results.std_id','students_results.std_grade')
->get();
if(count($row) > 0)
{
foreach ($row as $key => $value)
{
  $cu = $this->get_crunit($value->stdcourse_id, $s, $s_id);

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
if(count($cu ) > 0)
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

if(count($g_level) > 0 )
{return $g_level->rslevelid;
}
return '';
}
//====================================result_remark==============================
function result_remark($std_id,$s)
{	
$fail=''; $pass=''; $c=0; $carryf='';$rept='';
$l =$this->get_level($std_id,$s);
$cgpa =$this->get_cgpa($s, $std_id);
$new_prob=$this->new_Probtion($l,$std_id, $s,$cgpa);
if($new_prob==true)
{
return $new_prob;
}
$sql_num = DB::connection('mysql1')->table('students_results')->where([['std_id',$std_id],['std_mark_custom2','=',$s],['std_grade',"F"],['level_id','=',$l]])->groupBy('stdcourse_id','stdresult_id')->select('stdcourse_id','cu')->COUNT('stdcourse_id');
$sql = DB::connection('mysql1')->table('students_results')->where([['std_id',$std_id],['std_mark_custom2','=',$s],['std_grade',"F"],['level_id','=',$l]])->groupBy('stdcourse_id','stdresult_id')->select('stdcourse_id','cu')->get();
		
if (count($sql)!=0){ // found failed courses in the level

foreach($sql as $key => $value)
{
$sql1 = DB::connection('mysql1')->table('students_results')->where([['std_id',$std_id],['std_mark_custom2','<=',$s],['std_grade','!=',"F"],['level_id','<=',$l],['stdcourse_id',$value->stdcourse_id]])->get();
	
if (count($sql1)!=0){ //found that failed course passed in the level
foreach ($sql1 as $k => $v)
{
$pass .= ','.$v->stdcourse_id;
}
}else{
$rowc = DB::connection('mysql1')->table('course_reg')->where([['std_id',$std_id],['thecourse_id',$value->stdcourse_id],['clevel_id','<=',$l],['cyearsession','<=',$s]])->first();
	
$code = substr($rowc->stdcourse_custom2,0,3).' '.substr($rowc->stdcourse_custom2,3,4);
			
$type = substr($rowc->stdcourse_custom2,0,3); // GSSS
$n = count($sql_num);
			
if ($n >= 3)
{
	if ($type != 'GSS')
	{ 
		
		if($this->ignore_carryF ($std_id, $value->stdcourse_id, $s ) == '')
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
if ( 0 == count($sql1) )
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
	$course_id = '';
	$course_array ='';
	
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


}
