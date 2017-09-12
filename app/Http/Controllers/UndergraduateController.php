<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Programme;
use App\Faculty;
use App\Department;
use App\Fos;
use App\StudentReg;
use App\RegisterCourse;
use App\Semester;
use App\Level;
use App\CourseReg;
use App\StudentResult;
use App\User;
use App\CourseUnit;
use Auth;
use DB;
use Illuminate\Support\Facades\Session;
class UndergraduateController extends Controller
{
    //
Const FIRST_SEMESTER =1;
Const SECOND_SEMESTER =2;

    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {
    
    // get programme
$p=Auth::user()->programme_id;
$programme =Programme::find($p);

// get faculty
$f=Auth::user()->faculty_id;
$faculty=Faculty::find($f);

// get department
$d=Auth::user()->department_id;
$department =Department::find($d);

// get fos
$fs=Auth::user()->fos_id;
$fss =Fos::find($fs);	
          return view('undergraduate.index')->withP($programme)->withF($faculty)->withD($department)->withFs($fss);
    }
//========================================================register course for new student ======================
    public function register_course()
    {
        // check student_reg table if it has register before
        // thses conditon will work only for year one student
        $user_id =Auth::user()->id;
        $p_id =Auth::user()->programme_id;
        $f_id =Auth::user()->faculty_id;
        $d_id =Auth::user()->department_id;
        $fos_id =Auth::user()->fos_id;
        $l= 1;
         $session=  session()->get('session_year');
        $check_student_reg =StudentReg::where([['user_id',$user_id],['semester',self::FIRST_SEMESTER],['session',$session]])->first();
        if(count($check_student_reg) == 0)
        {
          // register for year first semester 
         /* get courses for regiteration*/
         $register_course=RegisterCourse::where([['programme_id',$p_id],['faculty_id',$f_id],['department_id',$d_id],['fos_id',$fos_id],['semester_id',self::FIRST_SEMESTER],['session',$session],['level_id',$l],])->orderBy('reg_course_status','ASC')->get();
         $semester =self::FIRST_SEMESTER;


        }
        elseif(count($check_student_reg) == 1){
           $check_student_reg_2 =StudentReg::where([['user_id',$user_id],['semester',self::SECOND_SEMESTER],['session',$session]])->first(); 
if(count($check_student_reg_2) == 0)
        {
 // register for year first semester 
  $register_course=RegisterCourse::where([['programme_id',$p_id],['faculty_id',$f_id],['department_id',$d_id],['fos_id',$fos_id],['semester_id',self::SECOND_SEMESTER],['session',$session],['level_id',$l],])->orderBy('reg_course_status','ASC')->get();
   $semester =self::SECOND_SEMESTER;

        }else{
             Session::flash('warning','You have register for both semester in these session');
              return back();
        }

        }
       
return view('undergraduate.register_course')->withReg($register_course)->withS($semester)->withL($l)->withSs($session);
    }
//--------------------------------------------------------preview course method-------------------------------------
    public function preview_course(Request $request)
    {
     $session=  session()->get('session_year');
     $l =$request->level;
     $s=$request->semester;  
     $variable = $request->input('id');
    
     if($variable ==  null)
     {
        Session::flash('danger',"Please Select a course.");
      return back();
     }
     $course_unit =CourseUnit::where([['session',$session],['level',$l],['fos',Auth::user()->fos_id]])->first();
     if(count($course_unit) == 0)
     {
      $course_unit =CourseUnit::where([['session',$session],['level',0],['fos',0]])->first();
     }
     $data =RegisterCourse::whereIn('id',$variable)->orderBy('reg_course_status','ASC')->orderBy('reg_course_code','ASC')->get();
    

  
     return view('undergraduate.preview_course')->withPre($data)->withS($s)->withL($l)->withSs($session)->withCu($course_unit);
    }
    //-------------------------------------------------- register course that been preview method-----------------------

    public function post_register_course(Request $request)
    {
    // $db = DB::transaction(function () {   
        $id = $request->input('id');
        $session=session()->get('session_year');
       $l =$request->level;
       $s=$request->semester; 

    
    $check_student_reg=StudentReg::where([['user_id',Auth::user()->id],['semester',$s],['session',$session],['level_id',$l]])->first();
    if(count($check_student_reg) == 0)
    {

    $student_reg = new StudentReg;
        $student_reg->user_id =Auth::user()->id;
        $student_reg->session = $session;
        $student_reg->semester =$s;
        $student_reg->programme_id =Auth::user()->programme_id;
        $student_reg->faculty_id =Auth::user()->faculty_id;
        $student_reg->department_id =Auth::user()->department_id;
        $student_reg->level_id =$l;
        $student_reg->season ="NORMAL";
        $student_reg->save();
       
if($student_reg->id){
          $data =RegisterCourse::whereIn('id',$id)->get();

        foreach ($data as $key => $value) {
         $insert_data[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$value->id,'user_id'=>Auth::user()->id,'level_id'=>$value->level_id,'semester_id'=>$value->semester_id,'course_id'=>$value->course_id,'course_title'=>$value->reg_course_title,'course_code'=>$value->reg_course_code,'course_unit'=>$value->reg_course_unit,'course_status'=>$value->reg_course_status,'session'=>$value->session,'period'=>"NORMAL"];
        }  

        DB::connection('mysql2')->table('course_regs')->insert($insert_data);
    }
         Session::flash('success',"SUCCESSFULL.");
    }else{
 Session::flash('warning',"you have register for these semester already.");
    }

  
return redirect()->action('UndergraduateController@index');
}

public function print_course()
{
    $s =Semester::where('programme_id',Auth::user()->programme_id)->get();
    $l = Level::where('programme_id',Auth::user()->programme_id)->get();
    $session=session()->get('session_year');
    return view('undergraduate.print_course')->withS($s)->withL($l)->withSs($session);

}
public function view_register_course($l,$s)
{
    $session=session()->get('session_year');
    $course =CourseReg::wherewhere([['user_id',Auth::user()->id],['semester',$s],['session',$session],['level_id',$l],['period',"NORMAL"]])->get();
    return view('undergraduate.view_register_course')->withC($course)->withS($s)->withL($l)->withSs($session);

}

public function post_view_register_course(Request $request)
{
    $this->validate($request,array('level'=>'required','semester'=>'required',));
    // get programme

$programme =$this->getProgramme();

// get faculty

$faculty=$this->getfaculty();

// get department

$department =$this->getDepartment();

// get fos

$fss =$this->getFos();   
    
    $session=session()->get('session_year');
     $l =$request->level;
    $s=$request->semester; 
    $course =CourseReg::where([['user_id',Auth::user()->id],['semester_id',$s],['session',$session],['level_id',$l],['period',"NORMAL"]])
        ->orderBy('course_status','ASC')->orderBy('course_code','ASC')->get();
    return view('undergraduate.view_register_course')->withC($course)->withS($s)->withL($l)->withSs($session)->withP($programme)->withF($faculty)->withD($department)->withFs($fss);

}

public function view_result()
{

    $l = Level::where('programme_id',Auth::user()->programme_id)->get();
    $session=session()->get('session_year');
    
    return view('undergraduate.view_result')->withL($l)->withSs($session);
}
//----------------------------------------------------------------------------------------------------------------
 public function post_view_result(Request $request)
 {
 $this->validate($request,array('level'=>'required',));
  $session=session()->get('session_year');
  $l=$request->input('level');
  $id = Auth::user()->id;
  $p =Auth::user()->programme_id;
  $d =Auth::user()->department_id;
$f =Auth::user()->faculty_id;
    // get programme

$fss =$this->getFos();

// get faculty

$faculty=$this->getfaculty();

// get department

$department =$this->getDepartment();

 $f_semester =1;
   $s_semester =2;
if($p == 4)
{
    if($l == 2)
    {
   $f_semester =3;
   $s_semester =4;
    }elseif ($l==3) {
   $f_semester =5;
   $s_semester =6;
    }
    elseif ($l==4) {
    $f_semester =7;
   $s_semester =8;
    }
    elseif ($l==5) {
    $f_semester =9;
   $s_semester =10;
}
    elseif ($l==6) {
    $f_semester =11;
   $s_semester =12;
    }
}
$first_result ='';
$second_result = '';
$course_first ='';
$course_second ='';
$student_reg =StudentReg::where([['user_id',$id],['faculty_id',$f],['session',$session],['level_id',$l],['department_id',$d],['programme_id',$p]])->get();
if(count($student_reg) > 0)
{

foreach ($student_reg as $key => $value) {
 $std_reg[] =$value->id;
}

$first_result = DB::connection('mysql2')->table('course_regs')
            ->join('student_results', 'student_results.coursereg_id', '=', 'course_regs.id')
            ->where([['course_regs.user_id',$id],['course_regs.level_id',$l],['course_regs.session',$session],['semester_id',$f_semester]])
             ->wherein('studentreg_id',$std_reg)
            ->get();
 if(count($first_result) >0)
 {

$second_result = DB::connection('mysql2')->table('course_regs')
            ->join('student_results', 'student_results.coursereg_id', '=', 'course_regs.id')
            ->where([['course_regs.user_id',$id],['course_regs.level_id',$l],['course_regs.session',$session],['semester_id',$s_semester]])
             ->wherein('studentreg_id',$std_reg)
            ->get();

 /*--------------------get all result------------------------------------------*/
 $result =DB::connection('mysql2')->table('student_results')->where([['user_id',$id],['session',$session],['level_id',$l]])->get();
 if(count($result) > 0)
 {
 foreach ($result as $key => $value) {
 $result_id [] = $value->coursereg_id;
 }

/* --------------get first semeter course reg --------------------------- */
 $course_first =DB::connection('mysql2')->table('course_regs')
  ->where([['user_id',$id],['level_id',$l],['session',$session],['semester_id',$f_semester]])
 ->whereNotIn('id',$result_id)->get();
 
 $course_second =DB::connection('mysql2')->table('course_regs')
   ->where([['user_id',$id],['level_id',$l],['session',$session],['semester_id',$s_semester]])
 ->whereNotIn('id',$result_id)->get();
}
$cgp =$this->get_cgpa($session, $id);
$gp =$this->get_gpa($session, $id);
$r = $this->result_remark($id, $session,$l);
     return view('undergraduate.post_view_result')->withFirst_result($first_result)->withSecond_result($second_result)->withCourse_first($course_first)->withCourse_second($course_second)->withL($l)->withFss($fss)->withF($faculty)->withD($department)->withY($session)->withCgpa($cgp)->withGpa($gp)->withR($r); 
 }
else{
       //return view('undergraduate.noresult')->withL($l);
    Session::flash('warning','Your Result is not ready. Please Contact Your Examination Officer.');
       return back();
     }  


     }else{
      // return view('undergraduate.unregistered')->withL($l);
       Session::flash('warning','You Have not register  for thses session'); 
       return back();
     }   


 }

//====================================result_remark==============================
function result_remark($id, $s,$l)
{   
$fail=''; $pass=''; $c=0; $carryf='';$rept='';

$cgpa =$this->get_cgpa($s, $id);
$prob=$this->Probtion($l,$id,$s,$cgpa);
if($prob==true)
{
return $prob;
}
$sql_num = StudentResult::where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l]])->groupBy('course_id','id')->select('course_id','cu')->COUNT('course_id');
$sql =StudentResult::where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l]])->groupBy('course_id','id')->select('course_id','cu')->get();
        
if (count($sql)!=0){ // found failed courses in the level

foreach($sql as $key => $value)
{
$sql1 = StudentResult::where([['user_id',$id],['session','<=',$s],['grade','!=',"F"],['level_id','<=',$l],['course_id',$value->course_id]])->get();
    
if (count($sql1)!=0){ //found that failed course passed in the level
foreach ($sql1 as $k => $v)
{
$pass .= ','.$v->course_id;
}
}else{
$rowc = CourseReg::where([['user_id',$id],['course_id',$value->course_id],['level_id','<=',$l],['session','<=',$s]])->first();
    
$code = substr($rowc->course_code,0,3).' '.substr($rowc->course_code,3,4);
            
$type = substr($rowc->course_code,0,3); // GSSS
$n = count($sql_num);
            
if ($n >= 3)
{
    if ($type != 'GSS')
    { 
        
        if($this->ignore_carryF ($id, $value->course_id, $s ) == '')
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

$take =$this->take_courses_sessional($id, $l, $s);
$carryf = $carryf != '' ? '<b>CARRY F </b>'.substr($carryf,2)."<br/>" : '';
$rept = $rept != '' ? '<b>RPT</b> '. substr($rept,2) : '';
$rept = $take != '' ? '<b>TAKE</b> '. $take .'<br/>'.$rept : $rept; 
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
//============================================= course sessional ==============================
function take_courses_sessional($user_id, $l, $s) 
{

    $take = '';
    $course_id = '';
    $course_array ='';
    $result = StudentResult::where([['user_id',$user_id],['level_id',$l],['session',$s]])->get();
    foreach ($result  as $key => $value) {
    $course_id[] = $value->course_id;
    }

    $sql1 = CourseReg::where([['user_id',$user_id],['level_id',$l],['session',$s]])
     ->whereNotIn('course_id',$course_id)
    ->get();

    foreach ($sql1 as $k => $v) {
        $take.= ', '.substr($v->course_code,0,3).' '.substr($v->course_code,3,4);

            }
 
    return $take != '' ? substr($take,2) : '';
    }

// ================================function for ignore carry F ========================
protected function ignore_carryF ($id)
{
$sql1 = CourseReg::find($id);
if ( 0 == count($sql1) )
{ 
return 'true';
} else
{ 
return '';
}
    
}    
//====================================cgpa ==============================
function get_cgpa($s, $user_id){

$tcu = 0; $tgp = 0;
$row = DB::connection('mysql2')->table('student_results')->distinct()
->join('course_regs', 'course_regs.id', '=', 'student_results.coursereg_id')
->where([['student_results.session','<=',$s],['student_results.user_id',$user_id]])
->where([['course_regs.session','<=',$s],['course_regs.user_id',$user_id]])
->get();
foreach ($row as $key => $value)
{
   $cu = $this->get_crunit($value->coursereg_id, $value->session, $user_id);
   $gp = $this->get_gradepoint ($value->grade, $cu);
   $tcu += $cu;
   $tgp += $gp;
}

    @$gpa = $tgp / $tcu ;
    $gpa = number_format ($gpa,2); 
    return $gpa;
}

//====================================gpa ==============================
public function get_gpa($s,$user_id)
{

$tcu = 0; $tgp = 0;
$row = DB::connection('mysql2')->table('student_results')->distinct()
->join('course_regs', 'course_regs.id', '=', 'student_results.coursereg_id')
->where([['student_results.session',$s],['student_results.user_id',$user_id]])
->where([['course_regs.session',$s],['course_regs.user_id',$user_id]])
->get();
foreach ($row as $key => $value)
{
  $cu = $this->get_crunit($value->coursereg_id, $s, $user_id);
  $gp = $this->get_gradepoint ($value->grade, $cu);
  $tcu = $tcu + $cu;
  $tgp = $tgp + $gp;
}
 @$gpa = $tgp / $tcu ;
 $gpa = number_format ($gpa,2);
return $gpa;
    
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
   //======================================= probation =========================================
protected function Probtion($l,$id,$s,$cgpa)
{
$return ='';
$fail_cu=$this->get_fail_crunit($l,$id,$s);
$entry_year =$this->get_entry_sesssion($id);

$y =$entry_year->std_custome2;
   
   if($fail_cu > 15|| $cgpa >=0.00 && $cgpa <=0.99 ){
            
        $return = 'WITHDRAW';
        }
        elseif($cgpa >=1.00 && $cgpa <=1.49 || $fail_cu ==15){

            $return = 'PROBATION';

        }elseif( $cgpa > 1.49 && $cgpa <=1.5 && $fail_cu ==15 ){
        $return = 'WITHDRAW OR CHANGE PROGRAMME';
        } 
    
        return $return;
}
//  =========================== get fail course units ==============================================
protected function get_fail_crunit($l,$id,$s)
{
$sql =StudentResult::where([['level_id',$l],['session',$s],['user_id',$id],['grade','F']])->get(); 
$cu=array();
foreach ($sql as $key => $value)
{
$cu [] = $value->cu;
}
 
$tcu=array_sum($cu);
return $tcu;
}
// ==========================get entry session ========================================
protected function get_entry_sesssion($id)
{
    $sql = User::find($id);  
    return $sql;
}
 //================================== get programme =======================================

 public function getProgramme()
 {
    $p=Auth::user()->programme_id;
$programme =Programme::find($p);
return $programme;
 }

 public function getfaculty()
 {
   $f=Auth::user()->faculty_id;
$faculty=Faculty::find($f);
return $faculty; 
 }

 public function getDepartment()
 {
    $d=Auth::user()->department_id;
$department =Department::find($d);
return $department;
 }

 public function getFos()
 {
    $fs=Auth::user()->fos_id;
$fss =Fos::find($fs);  
return $fss;
 }

}

