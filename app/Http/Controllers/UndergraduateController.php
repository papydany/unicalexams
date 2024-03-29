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
use App\Pin;
use App\RegisterSpecialization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\Http\Traits\MyTrait;

class UndergraduateController extends Controller
{
 use MyTrait;
Const FIRST_SEMESTER =1;
Const SECOND_SEMESTER =2;
Const Diploma = 2;
Const FacultyofBiological = 4;
Const MEDICINE = 14;
Const DENTISTRY = 10;
Const IPPA =17;
Const IOC =16;
Const IOE=15;
Const BASSEY=23;

Const DepartmentOfPlant = 21;
Const FosHnd=0;
Const FosHndDe =0;
const FacultOfAgric =18;
const DepartmentFoodTech =13;


    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {
    
    // get programme
$p=Auth::user()->programme_id;

$all_Student_reg = $this->getAllStudentRegistered();
$programme =DB::table('programmes')->find($p);

// get faculty
$f=Auth::user()->faculty_id;
$faculty=DB::table('faculties')->find($f);

// get department
$d=Auth::user()->department_id;
$department =DB::table('departments')->find($d);

// get fos
$fs=Auth::user()->fos_id;
$fss =DB::table('fos')->find($fs);
// specialization
if(Auth::user()->specialization_id != 0 || Auth::user()->specialization_id != null)
{
$spec =DB::table('specializations')->find(Auth::user()->specialization_id);
}else{
  $spec='';
}

//$student_reg =StudentReg::where('user_id',Auth::user()->id)->get();	
//$session=session()->get('session_year');
return view('undergraduate.index')->withP($programme)->withF($faculty)->withD($department)->withFs($fss)->withSpec($spec)->withAllstudentreg($all_Student_reg);
 }

//===================  edit fos ================================
public function edit_fos()
{
   $d=Auth::user()->department_id;
   $p=Auth::user()->programme_id;
   $get_fos = Fos::where([['department_id',$d],['programme_id',$p]])->get();
   return view('undergraduate.edit_fos')->withFs($get_fos );
}  

public function post_edit_fos(Request $request)
{
    $fos = $request->input('fos');   
$update =User::find(Auth::user()->id);
$update->fos_id = $fos;
$update->save();
   Session::flash('success',"SUCCESSFUL.");
   return redirect()->action('UndergraduateController@index');
} 

//===================  edit faculty ================================
public function edit_fac()
{
   
   $get_fac = Faculty::orderBy('faculty_name','ASC')->get();
   return view('undergraduate.edit_fac')->withFs($get_fac );
}  

public function post_edit_fac(Request $request)
{
    $fac = $request->input('faculty'); 
    $dept = $request->input('department');
    $fos = $request->input('fos'); 
  
$update =User::find(Auth::user()->id);
$update->faculty_id = $fac;
$update->department_id = $dept;
$update->fos_id = $fos;
$update->save();
   Session::flash('success',"SUCCESSFUL.");
   return redirect()->action('UndergraduateController@index');
} 
//===================  edit matic number ================================
public function edit_matric_number()
{
   return view('undergraduate.edit_matric_number');
}  

public function post_edit_matric_number(Request $request)
{
  $this->validate($request,array('matric_number' => 'bail|required|unique:mysql2.users',));

$new_matric_number = $request->input('matric_number');

$user =User::find(Auth::user()->id);
$old_matric_number  = $user->matric_number;
$user->matric_number = $new_matric_number;
$user->password = bcrypt($new_matric_number);
$user->save();

// ==== updated result table
StudentResult::where('user_id',Auth::user()->id)
->update(['matric_number' => $new_matric_number]);

// ==== pin
Pin::where([['student_id',Auth::user()->id],['matric_number',$old_matric_number]])
->update(['matric_number' => $new_matric_number]);



   Session::flash('success',"SUCCESSFUL");
   return redirect()->action('UndergraduateController@index');
} 
//======================= update passport================
public function edit_image()
{
  $users = User::find(Auth::user()->id);
  return view('home.edit_image')->withU($users);
}
public function post_edit_image(Request $request)
{
   $users = User::find(Auth::user()->id);
 if($users != null)
 {
  if($request->hasFile('image_url')) {
        $image = $request->file('image_url');
        $filename = time() . '.' . $image->getClientOriginalExtension();
       $destinationPath = public_path('img/student');
        $img = Image::make($image->getRealPath());
        $img->resize(150, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $filename);
    $users->image_url = $filename;
    $users->save();
    Session::flash('success',"successful.");
     
      }
      return   $this->success();
 }
return   $this->index();
} 

//======================== update password ======================

public function updatePassword(Request $request)
{
$checkReg =StudentReg::where('user_id',Auth::user()->id)->orderBy('session','desc')->first();


$user =User::find(Auth::user()->id);
$user->password = bcrypt($request->password);
$user->save();
Session::flash('success',"SUCCESSFUL");

return redirect()->action('UndergraduateController@index');
} 

//===================  edit email ================================
public function edit_email()
{
   return view('undergraduate.edit_email');
}  

public function post_edit_email(Request $request)
{
  $this->validate($request,array('email' => 'required|unique:mysql2.users',));
$email = strtolower($request->input('email'));
$user =User::find(Auth::user()->id);
$user->email = $email;
$user->save();
Session::flash('success',"SUCCESSFUL");
return redirect()->action('UndergraduateController@index');
} 

//===================  edit phone number ================================
public function edit_phone_number()
{
   return view('undergraduate.edit_phone_number');
}  

public function post_edit_phone_number(Request $request)
{
  $this->validate($request,array('phone' => 'required',));

$phone = $request->input('phone');
$user =User::find(Auth::user()->id);
$user->phone =$phone;
$user->save();
Session::flash('success',"SUCCESSFUL");
return redirect()->action('UndergraduateController@index');
} 


//===================  edit fos ================================
public function edit_names()
{
 return view('undergraduate.edit_names');
}  

public function post_edit_names(Request $request)
{
    $first_name = $request->input('firstname');
    $surname = $request->input('surname');
    $other_name = $request->input('othername');     
$update =User::find(Auth::user()->id);
$update->surname =$surname;
$update->firstname  =$first_name; 
$update->othername= $other_name;
$update->save();
   Session::flash('success',"SUCCESSFUL.");
   return redirect()->action('UndergraduateController@index');
}  
//===================register course for new student ======================
    public function register_course()
    {
        // check student_reg table if it has register before
        // these condition will work only for year one student
        // entry year serve as session here
        $session=  session()->get('session_year');
      /* if(Auth::user()->faculty_id == self::DENTISTRY ||  Auth::user()->faculty_id == self::MEDICINE 
        || Auth::user()->faculty_id == self::IOC || Auth::user()->faculty_id == self::BASSEY || Auth::user()->faculty_id == self::BASSEY ||  Auth::user()->faculty_id == self::IOE ||  Auth::user()->faculty_id == self::IPPA || auth::user()->fos_id == 226 )
        {}elseif*/
        if($session < '2020'){
        Session::flash('danger',"Registration is closed for all session below 2020");
            return back();
        }
        
        $user_id =Auth::user()->id;
        $p_id =Auth::user()->programme_id;
        $f_id =Auth::user()->faculty_id;
        $d_id =Auth::user()->department_id;
        $fos_id =Auth::user()->fos_id;
        $l= 1;
        $log1=  session()->get('log1');
      
        
         
         $check_s =StudentReg::where([['user_id',$user_id],['level_id',$l],['session','<',$session]])->first();
         
         if($check_s != null)
         {
          Session::flash('warning',"you have registered for year one. login as returning students to continue other levels registration. for further information contact the system administrator");
          return back();
         }

        $check_student_reg =StudentReg::where([['user_id',$user_id],['semester',self::FIRST_SEMESTER],['session',$session]])->first();
        if($check_student_reg == null)
        {
          // check if the pin can be used for first semester registration
          //$log1=  session()->get('log1');
          if($log1 == 1)
          {
            Session::flash('warning',"The Pin used to login has been used for registration already");
          return back();
          }

          // register for year first semester 
         /* get courses for registration*/
         $register_course=RegisterCourse::where([['programme_id',$p_id],['faculty_id',$f_id],['department_id',$d_id],['fos_id',$fos_id],['semester_id',self::FIRST_SEMESTER],['session',$session],['level_id',$l]])->whereIn('reg_course_status',["C","E"])->orderBy('reg_course_status','ASC')->get();
         $semester =self::FIRST_SEMESTER;


        }
        elseif($check_student_reg != null){
           $check_student_reg_2 =StudentReg::where([['user_id',$user_id],['semester',self::SECOND_SEMESTER],['session',$session]])->first(); 
if($check_student_reg_2 == null)
        {
        
 // register for year first semester 
  $register_course=RegisterCourse::where([['programme_id',$p_id],['faculty_id',$f_id],['department_id',$d_id],['fos_id',$fos_id],['semester_id',self::SECOND_SEMESTER],['session',$session],['level_id',$l],])->whereIn('reg_course_status',["C","E"])->orderBy('reg_course_status','ASC')->get();

   $semester =self::SECOND_SEMESTER;

        }else{
             Session::flash('warning','You have register for both semester in these session');
              return back();
        }

        }
       
return view('undergraduate.register_course')->withReg($register_course)->withS($semester)->withL($l)->withSs($session);
    }
//--------------------------------------preview course method-------------------------------------
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
     if($course_unit == null)
     {
      $course_unit =CourseUnit::where([['session',$session],['level',0],['fos',0]])->first();
     }
     $data =RegisterCourse::whereIn('id',$variable)->orderBy('reg_course_status','ASC')->orderBy('reg_course_code','ASC')->get();
    

  
     return view('undergraduate.preview_course')->withPre($data)->withS($s)->withL($l)->withSs($session)->withCu($course_unit);
    }
    //------------------------- register course that been preview method-----------------------

    public function post_register_course(Request $request)
    {
    // $db = DB::transaction(function () {   
        $id = $request->input('id');
        $session=session()->get('session_year');
       $l =$request->level;
       $s=$request->semester; 
        $insert_data =array();
    $check_student_reg=StudentReg::where([['user_id',Auth::user()->id],['semester',$s],['session',$session],['level_id',$l]])->first();
    if($check_student_reg == null)
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
        if(session()->get('currentSession') != null)
        {   }else{
  $pinId=  session()->get('login_user');
       // first semester log
if($s==1){
  $affected = DB::table('pins')
  ->where('id', $pinId)
  ->update(['log1' => 1,'log_session'=>$session]);
}else{
  $affected = DB::table('pins')
  ->where('id', $pinId)
  ->update(['log2' => 1,'log_session'=>$session]);
}
        }
         
    }
         Session::flash('success',"SUCCESSFUL.");
    }else{
 Session::flash('warning',"you have register for these semester already.");
    }

  
return redirect()->action('UndergraduateController@index');
}

public function print_course()
{
    $s =Semester::where('programme_id',Auth::user()->programme_id)->get();
   // $session=session()->get('session_year');
    $reg =StudentReg::where([['user_id',Auth::user()->id],['semester',1]])
    ->select('session','level_id')->distinct('session')->get();
    if($reg == null)
    {
      Session::flash('warning',"you have not register courses for these session");
      return back();
    }
    return view('undergraduate.print.index')->withS($s)->withReg($reg);

}
public function view_register_course($l,$s)
{
    $session=session()->get('session');
    $course =CourseReg::where([['user_id',Auth::user()->id],['semester',$s],['session',$session],['level_id',$l],['period',"NORMAL"]])->get();
    return view('undergraduate.view_register_course')->withC($course)->withS($s)->withL($l)->withSs($session);

}

//========================  add course =============================
public function addCourses()
{
       $s =Semester::where('programme_id',Auth::user()->programme_id)->get();
   // $l = Level::where('programme_id',Auth::user()->programme_id)->get();
    //$session=session()->get('session_year');
    //$reg =StudentReg::where([['session',$session],['user_id',Auth::user()->id]])->first();
    $studentreg =StudentReg::where([['user_id',Auth::user()->id]])
 ->select('session','level_id')->distinct('session')->orderBy('level_id','desc')->first();
      if($studentreg == null)
    {
      Session::flash('warning',"you have not register courses for these session");
      return back();
    }
   return view('undergraduate.addCourses')->withS($s)->withStudentreg($studentreg);
 
}

public function post_addCourses(request $request)
{
      $session=$request->session;
       $l =$request->level;
       $s=$request->semester;
       $id=Auth::user()->id;
      $fos_id=Auth::user()->fos_id;
      $Regcourse_id = array();
      $Reg_course =array();

       $check = StudentReg::where([['session',$session],['level_id',$l],['semester',$s],['user_id',$id]])->first();
    
       if($check == null)
       {
         Session::flash('warning',"you have not register for these semester.please use the Register Courses Link.");
         return back();
       }
       // probation students check and resit

        $probation_resit_check = StudentReg::where([['level_id',$l],['semester',$s],['user_id',$id]])->count();

        if($probation_resit_check >= 2)
        {
          Session::flash('warning',"probation or Resit Students can not used the add courses link.Contact System adminstartor for further assistance.");
         return back();
        }


       
       $courseReg =CourseReg::where([['session',$session],['level_id',$l],['semester_id',$s],['user_id',$id],['studentreg_id',$check->id]])->get();
       // total course of unit register
       /*
will be need to check the course of unit u have before you can add more

       */
       $course_reg_unit =$courseReg->sum('course_unit');
   
       if(count($courseReg) > 0)
       {
        foreach ($courseReg as $key => $value) {
           $Reg_course_id [] =$value->register_course_id;
        }
      }
       
        $Reg_course =RegisterCourse::where([['session',$session],['level_id',$l],['semester_id',$s],['fos_id',$fos_id]])->WhereIn('reg_course_status',['C','E'])->whereNotIn('id',$Reg_course_id)->get();
       

       return view('undergraduate.post_addCourses')->withS($s)->withL($l)->withSs($session)->withReg($Reg_course)->withCrunit($course_reg_unit);
}

   public function preview_addcourse(Request $request)
    {
      $session=$request->session;
     $l =$request->level;
     $s=$request->semester;  
     $variable = $request->input('id');
    $crunit=$request->crunit; 

     if($variable ==  null)
     {
        Session::flash('danger',"Please Select a course.");
      return back();
     }
     $course_unit =CourseUnit::where([['session',$session],['level',$l],['fos',Auth::user()->fos_id]])->first();
     if($course_unit == null)
     {
      $course_unit =CourseUnit::where([['session',$session],['level',0],['fos',0]])->first();
     }


     $data =RegisterCourse::whereIn('id',$variable)->orderBy('reg_course_status','ASC')->orderBy('reg_course_code','ASC')->get();
    // unit already register with the selected once
    $total_unit = $data->sum('reg_course_unit') + $crunit;
  
     return view('undergraduate.preview_addcourse')->withPre($data)->withS($s)->withL($l)->withSs($session)->withCu($course_unit)->withTu($total_unit);
    }

    public function post_register_addcourse(Request $request)
    {
    // $db = DB::transaction(function () {   
        $id = $request->input('id');
        $session=$request->session;
       $l =$request->level;
       $s=$request->semester; 

    
    $check_student_reg=StudentReg::where([['user_id',Auth::user()->id],['semester',$s],['session',$session],['level_id',$l]])->first();

    if($check_student_reg != null)
    {

          $data =RegisterCourse::whereIn('id',$id)->get();

        foreach ($data as $key => $value) {
         $insert_data[] =['studentreg_id'=>$check_student_reg->id,'registercourse_id'=>$value->id,'user_id'=>Auth::user()->id,'level_id'=>$value->level_id,'semester_id'=>$value->semester_id,'course_id'=>$value->course_id,'course_title'=>$value->reg_course_title,'course_code'=>$value->reg_course_code,'course_unit'=>$value->reg_course_unit,'course_status'=>$value->reg_course_status,'session'=>$value->session,'period'=>"NORMAL"];
        }  

        DB::connection('mysql2')->table('course_regs')->insert($insert_data);
    
         Session::flash('success',"SUCCESSFUL.");
    }

  
return redirect()->action('UndergraduateController@index');
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
    
    $session=$request->session;
     $l =$request->level;
     $season=$request->season;
    $s=$request->semester;
     
    $semester =Semester::where([['programme_id',Auth::user()->programme_id],['semester_id',$s]])->first(); 
    $course =CourseReg::where([['user_id',Auth::user()->id],['semester_id',$s],['session',$session],['level_id',$l],['period',$season]])
        ->orderBy('course_status','ASC')->orderBy('course_code','ASC')->get();
    return view('undergraduate.view_register_course')->withC($course)->withS($semester)->withL($l)->withSs($session)->withP($programme)->withF($faculty)->withD($department)->withFs($fss);

}

//========================  delete course =============================
public function deleteCourses()
{
      $s =Semester::where('programme_id',Auth::user()->programme_id)->get();
    //$l = Level::where('programme_id',Auth::user()->programme_id)->get();
    //$session=session()->get('session_year');

    //$reg =StudentReg::where([['session',$session],['user_id',Auth::user()->id]])->first();
    $studentreg =StudentReg::where([['user_id',Auth::user()->id]])
 ->select('session','level_id')->distinct('session')->orderBy('level_id','desc')->first();

      if($studentreg == null)
    {
      Session::flash('warning',"you have not register courses for these session");
      return back();
    }
    
   return view('undergraduate.deleteCourses.index')->withS($s)->withStudentreg($studentreg);
 
}
// ================== post delete courses===========
public function post_deleteCourses(request $request)
{
$session=$request->session;
$l =$request->level;
$s=$request->semester;
$id=Auth::user()->id;
$check = StudentReg::where([['session',$session],['level_id',$l],['semester',$s],['user_id',$id]])->first();
if($check == null)
{
  Session::flash('warning',"you have not register for these semester.please use the Register Courses Link.");
  return back();
}
$courseReg =CourseReg::where([['session',$session],['level_id',$l],['semester_id',$s],['user_id',$id],['studentreg_id',$check->id]])->whereIn('course_status',["E","C"])->get();
$courseregunit =$courseReg->sum('course_unit');
return view('undergraduate.deleteCourses.view')->withS($s)->withL($l)->withSs($session)->withCrunit($courseregunit)->withCreg($courseReg );
}
// =============== preview delete courses ===========
 public function preview_deletecourse(Request $request)
{
  $session= $request->session;
  $l =$request->level;
  $s=$request->semester;  
  $variable = $request->input('id');
  $crunit=$request->crunit; 
  if($variable ==  null)
  {
    Session::flash('danger',"Please Select a course.");
    return back();
  }
  $data =CourseReg::whereIn('id',$variable)->orderBy('course_status','ASC')->orderBy('course_code','ASC')->get();
  return view('undergraduate.deleteCourses.preview')->withPre($data)->withS($s)->withL($l)->withSs($session);
}
// =========== remove courses =============
public function removecourse(Request $request)
{
 $variable = $request->input('id');
 foreach ($variable as $key => $value)
 {
   $check =StudentResult::where([['user_id',Auth::user()->id],['coursereg_id',$value]])->first();
   if($check == null)
   {
    CourseReg::destroy($value);
    Session::flash('success',"SUCCESSFUL.");
   }else{
    Session::flash('warning',"can not delete courses with result.");
    }
  }
 return redirect()->action('UndergraduateController@deleteCourses');
}

//==============================result =================================

public function view_result()
{
 $l = Level::where('programme_id',Auth::user()->programme_id)->get();
 $studentreg =$this->getStudentRegistered();
 $session=session()->get('session_year');
 
  return view('undergraduate.view_result')->withL($l)->withSs($session)->withStudentreg($studentreg);
}
//----------------------------------------------------------------------------------------------------------------
public function post_view_result(Request $request)
{
 $this->validate($request,array('level'=>'required',));
  //$session=session()->get('session_year');
  $session=$request->input('session');
  $l=$request->input('level');
  $season=$request->input('season');
  $id = Auth::user()->id;
  $p =Auth::user()->programme_id;
  $d =Auth::user()->department_id;
  $f =Auth::user()->faculty_id;
  $fss =$this->getFos();
  $faculty=$this->getfaculty();
  $department =$this->getDepartment();
  $f_semester =1;
  $s_semester =2;
 if($p == 4)
 {
  if($l == 2)
  {
   $f_semester =3;
   $s_semester =4;
   }elseif ($l==3)
   {
   $f_semester =5;
   $s_semester =6;
    }
    elseif ($l==4)
    {
    $f_semester =7;
    $s_semester =8;
    }
    elseif ($l==5)
    {
    $f_semester =9;
    $s_semester =10;
    }
    elseif ($l==6)
    {
    $f_semester =11;
    $s_semester =12;
    }
  }
$first_result ='';
$second_result = '';
$course_first ='';
$course_second ='';
$student_reg =DB::connection('mysql2')->table('student_regs')->where([['season',$season],['user_id',$id],['faculty_id',$f],['session',$session],['level_id',$l],['department_id',$d],['programme_id',$p]])->get();
if(count($student_reg) > 0)
{
 foreach ($student_reg as $key => $value)
 {
   $std_reg[] =$value->id;
}

 
 $first_result = DB::connection('mysql2')->table('course_regs')
 ->join('student_results', 'student_results.coursereg_id', '=', 'course_regs.id')
 ->where([['course_regs.user_id',$id],['course_regs.level_id',$l],['course_regs.session',$session],['course_regs.period',$season],['semester_id',$f_semester]])
 ->wherein('studentreg_id',$std_reg)->get();
 if($season =='VACATION')
 {
$ccc = 1;
 }else{
$ccc = count($first_result);
 }

 if($ccc == 0)
 {$ccc =1;

 }

if( $ccc > 0)
 {
  if(Auth::user()->faculty_id == self::MEDICINE && $l > 2 || Auth::user()->faculty_id == self::DENTISTRY && $l > 2)
  {
    /*--------------------get all result------------------------------------------*/
 $result =DB::connection('mysql2')->table('student_results')->where([['user_id',$id],['session',$session],['level_id',$l],['season',$season]])->get();
 if(count($result) > 0)
 {
 foreach ($result as $key => $value)
 {
 $result_id [] = $value->coursereg_id;
 }
 }else{
  Session::flash('warning','Your Result is not ready. Please Contact Your Examination Officer.');
  return back();
 }
/* --------------get first semeter course reg --------------------------- */
 $course_first =DB::connection('mysql2')->table('course_regs')
  ->where([['user_id',$id],['level_id',$l],['session',$session],['semester_id',$f_semester],['period',$season]])
 ->whereNotIn('id',$result_id)->get();
    return view('undergraduate.medicine.view_result')->withFirstresult($first_result)->withCoursefirst($course_first)->withL($l)->withFss($fss)->withF($faculty)->withD($department)->withY($session)->withSeason($season); 
  }

   $second_result = DB::connection('mysql2')->table('course_regs')
   ->join('student_results', 'student_results.coursereg_id', '=', 'course_regs.id')
   ->where([['course_regs.user_id',$id],['course_regs.level_id',$l],['course_regs.session',$session],['course_regs.period',$season],['semester_id',$s_semester]])
   ->wherein('studentreg_id',$std_reg)->get();

 /*--------------------get all result------------------------------------------*/
 $result =DB::connection('mysql2')->table('student_results')->where([['user_id',$id],['session',$session],['level_id',$l],['season',$season]])->get();
 if(count($result) > 0)
 {
 foreach ($result as $key => $value)
 {
 $result_id [] = $value->coursereg_id;
 }

/* --------------get first semeter course reg --------------------------- */
 $course_first =DB::connection('mysql2')->table('course_regs')
  ->where([['user_id',$id],['level_id',$l],['session',$session],['semester_id',$f_semester],['period',$season]])
 ->whereNotIn('id',$result_id)->get();
 
 $course_second =DB::connection('mysql2')->table('course_regs')
  ->where([['user_id',$id],['level_id',$l],['session',$session],['semester_id',$s_semester],['period',$season]])
 ->whereNotIn('id',$result_id)->get();
}
else{
  Session::flash('warning','Your Result is not ready. Please Contact Your Examination Officer.');
  return back();
 }
$cgp =$this->get_cgpa($session, $id,$season);
$gp =$this->get_gpa($session, $id,$season);
if(Auth::user()->programme_id == 2)
{
$r = $this->result_remark_diploma($id,$session,$l,$cgp);
}else
{
$r = $this->result_remark($id,$session,$l,$cgp,$season);
}


     return view('undergraduate.post_view_result')->withFirstresult($first_result)->withSecondresult($second_result)->withCoursefirst($course_first)->withCoursesecond($course_second)->withL($l)->withFss($fss)->withF($faculty)->withD($department)->withY($session)->withSeason($season)->withCgpa($cgp)->withGpa($gp)->withR($r); 
 }
else{
       //return view('undergraduate.noresult')->withL($l);
    Session::flash('warning','Your Result is not ready. Please Contact Your Examination Officer.');
       return back();
     }  


     }else{
      // return view('undergraduate.unregistered')->withL($l);
       Session::flash('warning','You Have not register  for these session'); 
       return back();
     }   


 }

//====================================result_remark==============================
function result_remark($id,$s,$l,$cgpa,$season)
{   
$fail=''; $pass=''; $c=0; $carryf='';$rept='';
$course_array =array(); $course_id_array =array(); $pass_course_id=array();$unpass_course_id='';
$row_data =array();
//$cgpa =$this->get_cgpa($s, $id);
$prob=$this->Probtion($l,$id,$s,$cgpa,$season);

if($prob==true)
{
return $prob;
}
if($season == 'VACATION')
  {
    $takeType =['NORMAL','VACATION'];
  }else if($season == 'RESIT'){
    $takeType =['NORMAL','RESIT'];
  }else{
    $takeType =['NORMAL'];
  }
$sql =DB::connection('mysql2')->table('student_results')->where([['user_id',$id],['session','<=',$s],['grade',"F"],['level_id','<=',$l]])
->whereIn('season',$takeType)
->select('course_id','cu')->get()->groupBy('course_id','id');


if (count($sql)!=0){ // found failed courses in the level
  foreach($sql as $key => $value)
  {
    $course_array []=['course_id'=>$key,'number'=>$value->count()];
    $course_id_array []=$key;
  }

//dd($course_id_array);
  $sql1 = DB::connection('mysql2')->table('student_results')->where([['user_id',$id],['session','<=',$s],['grade','!=',"F"],['level_id','<=',$l]])
  ->whereIn('season',$takeType)
  ->whereIn('course_id',$course_id_array)->get();
  if (count($sql1)!=0){
    foreach ($sql1 as $k => $v)
{
$pass_course_id[]= $v->course_id;
}
   }
   // the remain course_id that is not yet passed
$unpass_course_id=array_diff($course_id_array,$pass_course_id);

$rowc = DB::connection('mysql2')->table('course_regs')
->whereIn('course_id',$unpass_course_id)
->where([['user_id',$id],['level_id','<=',$l],['session','<=',$s]])
->whereIn('period',$takeType)->get();

if(count($rowc) != 0)
{
foreach($rowc as $row)
{
  $row_data[$row->course_id] =['type'=>substr($row->course_code,0,3),'type1'=>substr($row->course_code,3,4)];
}
}


  foreach($course_array as $k => $v) {
    $course_id_v =$course_array[$k]['course_id'];
    $n = $course_array[$k]['number'];
  if (in_array($course_id_v, $unpass_course_id))
  {
  /*  $rowc = DB::connection('mysql2')->table('course_regs')
    ->where([['user_id',$id],['course_id',$course_id_v],['level_id','<=',$l],['session','<=',$s]])
    ->whereIn('period',$takeType)->first();
    
if($rowc != null){
    
  $code = substr($rowc->course_code,0,3).' '.substr($rowc->course_code,3,4);
              
  $type = substr($rowc->course_code,0,3);
  }
   
*/
$type = $row_data[$course_id_v]['type'];
$code = $type.' '.$row_data[$course_id_v]['type1'];
   if ($n >= 3)
{
    if (!in_array($type ,[ 'GSS','GST']))
    { 
        
      /*  if($this->ignore_carryF ($id, $course_id_v, $s ) == '')
        {*/
            $carryf .= ', '.$code;
       // }
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
$probation_student =$this->getprobationStudents($id,$l,$s);

if($probation_student =='true'){
  $take =''; 
}else{
$take =$this->take_courses_sessional($id, $l, $s);
//dd($take);
}
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

// diploma remarks
function result_remark_diploma($id, $s,$l,$cgpa)
{   
$fail=''; $pass=''; $c=0; $carryf='';$rept='';

//$cgpa =$this->get_cgpa($s, $id);

$sql_num = StudentResult::where([['user_id',$id],['session',$s],['grade',"F"],['level_id',$l]])->groupBy('course_id','id')->select('course_id','cu')->COUNT('course_id');
$sql =StudentResult::where([['user_id',$id],['session',$s],['grade',"F"],['level_id',$l],['flag','Sessional']])->groupBy('course_id','id')->select('course_id','cu')->get();
        
if (count($sql)!=0){ // found failed courses in the level

foreach($sql as $key => $value)
{

$rowc = CourseReg::where([['user_id',$id],['course_id',$value->course_id],['level_id',$l],['session',$s]])->first();
    
$code = substr($rowc->course_code,0,3).' '.substr($rowc->course_code,3,4);
     
$rept .= ', '.$code;

}
}


$take =$this->take_courses_sessional($id, $l, $s);


$rept = $rept != '' ? '<b>RESIT</b> '. substr($rept,2) : '';
$rept = $take != '' ? '<b>TAKE</b> '. $take .'<br/>'.$rept : $rept; 
    if ($rept == '') {  
        $fail = "<b>PASS</b>";
    } else if($rept != '') {
        $fail =  $rept;
    } 
    else { $fail = '<b>PASS</b>' ;}
    
    return $fail;
}
//============================================= course sessional ==============================
function take_courses_sessional($user_id, $l, $s) 
{

    $take = '';
    $course_id =array();
    $course_array =array();
    

    $result = DB::connection('mysql2')->table('student_results')->where([['user_id',$user_id],['level_id',$l],['session',$s]])->get();
    foreach ($result  as $key => $value) {
    $course_id[] = $value->course_id;
    }
//dd($course_id);
    $sql1 = DB::connection('mysql2')->table('course_regs')->where([['user_id',$user_id],['level_id',$l],['session',$s]])
     ->whereIn('course_status',['C','E'])
    ->get();
   

    foreach ($sql1 as $k => $v) {
      if(!in_array($v->course_id,$course_id)){
        $take.= ', '.substr($v->course_code,0,3).' '.substr($v->course_code,3,4);
      }
        $course_array[] = $v->course_id;
            }
      $specializationId =$this->getSpecializationIdWithLevel(Auth::user()->specialization_id,$l);
      
            if($specializationId > 0)
            {
            
        $sql2= DB::table('register_courses')
              ->join('register_specializations', 'register_courses.id', '=', 'register_specializations.registercourse_id')
              ->where([['session',$s],['programme_id',Auth::user()->programme_id],['faculty_id',Auth::user()->faculty_id],['department_id',Auth::user()->department_id],['register_courses.fos_id',Auth::user()->fos_id],['level_id',$l],['reg_course_status','C']])
              ->where('register_specializations.specialization_id',$specializationId)
              ->whereNotIn('course_id',$course_array)
              ->select('register_courses.*')
              ->get();
          
            }else{   
      $sql2 = DB::table('register_courses')
            ->where([['reg_course_status','C'],['level_id',$l],['session',$s],['fos_id',Auth::user()->fos_id]])
            ->whereNotIn('course_id',$course_array)
           ->get();
            }
           foreach ($sql2 as $k => $v) {
            $take.= ', '.substr($v->reg_course_code,0,3).' '.substr($v->reg_course_code,3,4);
            
                }       
 
    return $take != '' ? substr($take,2) : '';
    }

// ================================function for ignore carry F ========================
protected function ignore_carryF ($id)
{
$sql1 = CourseReg::find($id);
if ($sql1 == null)
{ 
return 'true';
} else
{ 
return '';
}
    
} 

   //======================================= probation =========================================




// ==========================get entry session ========================================
protected function get_entry_sesssion($id)
{
    $sql = User::find($id);  
    return $sql->entry_year;
}
 //================================== get programme =======================================

 public function getProgramme()
 {
    $p=Auth::user()->programme_id;
$programme =Programme::find($p);
return $programme;
 }
//====================================== get faculty ================================
 public function getfaculty()
 {
   $f=Auth::user()->faculty_id;
$faculty=Faculty::find($f);
return $faculty; 
 }
//===================================== get department ==================================
 public function getDepartment()
 {
    $d=Auth::user()->department_id;
$department =Department::find($d);
return $department;
 }

//======================= get department by faculty ==================================================
 public function getdept($id)
{
$sql =Department::where('faculty_id',$id)->orderBy('department_name','ASC')->get();
return $sql;
}
// ============================== get fos by department and programme ===========================
public function gfos($id,$p_id)
{
$sql =Fos::where([['department_id',$id],['programme_id',$p_id]])->orderBy('fos_name','ASC')->get();
return $sql;
}
//====================== get register students per semester ========================
public function CheckRegisterStudentPerSemester($id,$semester,$session,$level,$normal)
{
$student_reg =StudentReg::where([['user_id',$id],['semester',$semester],['session',$session],['level_id',$level],['season',$normal]])->first();
return $student_reg;
}

//============================= get semester by programme ================================
public function getSemester($semester)
{
  $semester_name =Semester::where([['programme_id',Auth::user()->programme_id],['semester_id',$semester]])->first();
  return $semester_name;
}
/*----------------------- previously failed courses --------------------------*/
public function getPreviouFailedCourses($id,$semester,$previous_session,$season =null)
{
  if($season != null)
  {
  $failed_courses =StudentResult::where([['user_id',$id,],['semester',$semester],['session',$previous_session],['grade','F'],['season',$season]])->get();
 
  }else{
  $failed_courses =StudentResult::where([['user_id',$id,],['semester',$semester],['session',$previous_session],['grade','F']])->get();
  }return $failed_courses;
}

public function getCourseCodeType($courseReg_id)
{
  $c =CourseReg::find($courseReg_id);
  return $c;
}

/*----------------------- previously failed courses no semester --------------------------*/
public function getPreviouFailedCoursesWithNoSemester($id,$previous_session)
{
  
  $failed_courses =StudentResult::where([['user_id',$id,],['session',$previous_session],['grade','F']])->get();
 return $failed_courses;
}




/*------------------ get compulsary register courses in the session --------*/
public function GetRegisteredCompulsaryCourses($semester,$session,$level)
{
  $specializationId =$this->getSpecializationIdWithLevel(Auth::user()->specialization_id,$level);
  if($specializationId > 0)
  {
  
    $regcourse= DB::table('register_courses')
    ->join('register_specializations', 'register_courses.id', '=', 'register_specializations.registercourse_id')
    ->where([['semester_id',$semester],['session',$session],['programme_id',Auth::user()->programme_id],['faculty_id',Auth::user()->faculty_id],['department_id',Auth::user()->department_id],['register_courses.fos_id',Auth::user()->fos_id],['level_id',$level],['reg_course_status','C']])
    ->where('register_specializations.specialization_id',$specializationId)
    ->select('register_courses.*')
    ->get();

  }else{
  $regcourse=RegisterCourse::where([['semester_id',$semester],['session',$session],['programme_id',Auth::user()->programme_id],['faculty_id',Auth::user()->faculty_id],['department_id',Auth::user()->department_id],['fos_id',Auth::user()->fos_id],['level_id',$level],['reg_course_status','C']])
  ->whereIn('specialization_id',[0,$specializationId])
  ->get();
  }
  return $regcourse;
}






public function GetCourseRegSingleForStudentThatDidProbation($session1,$session2,$level,$id,$course_id,$semester,$period)
{
   //$courseReg=CourseReg::where([['level_id',$level],['user_id',$id],['registercourse_id',$regcourse_id],['course_id',$course_id],['semester_id',$semester],['period',$period]])
   $courseReg=CourseReg::where([['level_id',$level],['user_id',$id],['course_id',$course_id],['semester_id',$semester],['period',$period]])
  ->WhereIn('session',[$session1,$session2])->first();
  
   return $courseReg; 
}

public function GetRegisteredCoursesWithArrayCourseId($semester,$session,$level,$status,$array_course_id)
{
   $regcourse =RegisterCourse::where([['semester_id',$semester],['fos_id',Auth::user()->fos_id],['session',$session],['level_id',$level],['reg_course_status',$status]])->whereIn('course_id',$array_course_id)->get();

   return $regcourse;
}



//=========================
public function course_with_no_result($session,$level,$id)
{
  $r =0;$course_id=array();
 $courseReg=CourseReg::where([['session',$session],['level_id',$level],['user_id',$id]])->get();
foreach ($courseReg as $key => $value) {
 $studentresult=StudentResult::where([['session',$session],['level_id',$level],['user_id',$id],['coursereg_id',$value->id]])->first();
 if($studentresult == null)
 {
$course_id [] =$value->id;
}}
 

 if(count($course_id) > 0)
 {
  $r =1;
 }

return $r;
}

// ==========================returning students courses registration process ==================================

public function returning_register_course()
{
  session()->forget('session');
  $allStudentreg = $this->getAllStudentRegistered();
   $studentreg = $this->getStudentRegistered();

     if($studentreg == null)
   {
     Session::flash('warning',"you have not register for year one. login as new student to register");
     return back();
   }
  
    return view('undergraduate.rs_register_course.index')->withAllstudentreg($allStudentreg);
  

}

public function returningRegisterCourse(Request $request)
{
 $id = Auth::user()->id;
 
 //session()->forget('session');
 
 if ($request->isMethod('post')) {
  session()->forget('session');  
 session()->put('session',$request->session);
}
 //dd(session()->get('session_year'));
 $s =session()->get('session');

 $s_next =$s+1;
  $pinId =session()->get('login_user');
  $pn =Pin::find($pinId);
  if($pn->log1 == 1 && $pn->log2 ==1)
 {
   Session::flash('warning',"Pin already used for registration");
 return back();
 }
 $log1=  session()->get('log1');
 $log2=  session()->get('log2');
 if($log1 == 1 && $log2 ==1)
 {
  Session::flash('warning',"Pin already used for registration");
 return back();
 }

 if(Auth::user()->faculty_id == self::MEDICINE || Auth::user()->faculty_id == self::DENTISTRY )
  {
    $chechYearTwo =$this->checkRegisterForYearTwo($id);
    if($chechYearTwo == true){
    return view('undergraduate.medicine.index')->withs($s)->withNext($s_next);
    }
  
  }
 
$student_reg =StudentReg::where([['user_id',$id],['session','<',$s]])
->whereIn('semester',[1,2])->orderBy('level_id','desc')->orderBy('session','desc')->first();

  $all_level ='';
  $MatricNumber = Auth::user()->matric_number;
  $jamb_reg = Auth::user()->jamb_reg;
  
  $Session =$s.'/'.$s_next;
  //$Session ="2017/2018";

 
 
  $student_type= session()->get('student_type'); // eg direct entry and normal students
  $all_semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
  if($student_reg != null)
  {
    if($student_type == 1)
  {
    // direct entry students
$probation_level = $student_reg->level_id+1; 
$probation_level =$probation_level."00";  
$Level =$student_reg->level_id+2;
$Level =$Level."00";
  }elseif($student_type == 2)
  {
  // normal students

$probation_level = $student_reg->level_id."00";  
$Level =$student_reg->level_id+1;
$Level =$Level."00";
 }

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
    Session::flash('warning','You Have not register for last session.login as new  students to continue your registration or contact system admin for further explanation'); 
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
 $studentresult=StudentResult::where([['session',$student_reg->session],['level_id',$student_reg->level_id],['user_id',$id],['coursereg_id',$value->id]])->first();
 if($studentresult == null)
 {
   // introducce to check for GSS with no result for 2019 session
$ch =CourseReg::where([['id',$value->id],['session','2019']])->where('course_code','Like','GSS%')->first();
if($ch == null)
$course_id_with_no_result [] =$value->id;
 }
}

if(count($course_id_with_no_result) == 0)
{
  if($r== "WITHDRAW" || $r== "WITHDRAW OR CHANGE PROGRAMME" || $r== "CHANGE PROGRAMME")
  {

  }
  elseif($r=="PROBATION")
 {
  $all_level =$student_reg->level_id; 
  // probation level
  /* $response = Curl::to('https://myunical.edu.ng/verifyfee/GetFeeStatus.ashx')->withData(['matricno'=>$MatricNumber, 'session'=> $Session, 'level'=>$probation_level])->get();*/
 // if(session()->get('currentSession') != null) {
 //  if($s >'2019'){
  $response =$this->get_school_status($MatricNumber,$Session,$probation_level);
/* }else{
$response ="OK Proceed";
  }*/
    if($response =="OK Proceed")
      {
session()->put('paidschoolfess',$id);
      }
    elseif($response =="Not Paid")
    {
      // check again if fess has been paid with asumed level the students fee
/*$response = Curl::to('https://myunical.edu.ng/verifyfee/GetFeeStatus.ashx')->withData(['matricno'=>$MatricNumber, 'session'=> $Session, 'level'=>$Level])->get();*/
//if(session()->get('currentSession') != null) {
 // if($s >'2019'){
$response =$this->get_school_status($MatricNumber,$Session,$Level);
/*}else{
  $response ="OK Proceed";
}*/
if($response =="OK Proceed")
      {
session()->put('paidschoolfess',$id);
      }
      elseif($response =="Not Paid")
    {
// check again if fess has been paid with asumed level the students fee and jamb reg number
/*$response = Curl::to('https://myunical.edu.ng/verifyfee/GetFeeStatus.ashx')->withData(['matricno'=>$jamb_reg, 'session'=> $Session, 'level'=>$Level])->get();*/
 $response =$this->get_school_status($jamb_reg,$Session,$Level);
if($response =="OK Proceed")
      {
session()->put('paidschoolfess',$id);
      }
      elseif($response =="Not Paid")
    {

 
 $response =$this->get_school_status($jamb_reg,$Session,$probation_level);

if($response =="OK Proceed")
      {
session()->put('paidschoolfess',$id);
      }
      elseif($response =="Not Paid")
    
    {  
      Session::flash('danger',"you have not pay school fees.");
      return back();
    }

    }
  }
}
  }else
  {
$all_level =$student_reg->level_id+1; 
//if(session()->get('currentSession') != null) {
  //if($s >'2019'){
  $response =$this->get_school_status($MatricNumber,$Session,$Level);
/*}else{
$response ="OK Proceed";
}*/
    if($response =="OK Proceed")
      {
     session()->put('paidschoolfess',$id);
      }
    elseif($response =="Not Paid")
    {
      // check with jamb reg because student have not updated their matric number

       $response =$this->get_school_status($jamb_reg,$Session,$Level);
       
       if($response =="OK Proceed")
      {
session()->put('paidschoolfess',$id);
      }
      elseif($response =="Not Paid")
    {
      Session::flash('danger',"you have not pay school fees.");
      return back();
    }
    }
  }
}else{
  Session::flash('danger',"your have out standing courses that grade have not be inputed.Contact your examination officer to input the grades before you can continues the registration.");
      return back();
}
//dd($r);
return view('undergraduate.rs_register_course.index1')->withR($r)->withCwnr($course_id_with_no_result)->withS($s)->withSemester($all_semester)->withL($all_level)->withNext($s_next);


}

/*========================= medicine code ===================================*/
public function returningStudentMedicine(Request $request)
{
  $session =$request->session;
  $level =$request->level;
  $id = Auth::user()->id;
  $period =$request->period;
 

 $check_student_reg =$this->CheckRegisterStudentPerSemester($id,1,$session,$level,$period);

if($check_student_reg == null)
{
  // period is vacation
  if($period =='VACATION')
  {
  // get fail courses
  $failcourse =$this->failMedicineCourse($level,$id,$session);
  return view('undergraduate.medicine.PartCourses')->withFc($failcourse)->withL($level)->withP($period)->withS($session);

  }
  $student_reg =StudentReg::where([['user_id',$id],['session','<',$session]])
  ->whereIn('semester',[1,2])->orderBy('level_id','desc')->orderBy('session','desc')->first();
  $course_id_with_no_result =array(); 
 
    $courseReg=CourseReg::where([['session',$student_reg->session],['level_id',$student_reg->level_id],['user_id',$id]])->get();
  
  foreach ($courseReg as $key => $value) {
   $studentresult=StudentResult::where([['session',$student_reg->session],['level_id',$student_reg->level_id],['user_id',$id],['coursereg_id',$value->id]])->first();
   if($studentresult == null)
   {
     // introducce to check for GSS with no result for 2019 session
  /*$ch =CourseReg::where([['id',$value->id],['session','2019']])->where('course_code','Like','GSS%')->first();
  if($ch == null)*/
  $course_id_with_no_result [] =$value->id;
   //}
  }
}
if(count($course_id_with_no_result) != 0)
{
  Session::flash('danger',"Outstanding grade");
  return back();
}
 $register_course=RegisterCourse::where([['programme_id',Auth::user()->programme_id],['faculty_id',Auth::user()->faculty_id],['department_id',Auth::user()->department_id],['fos_id',Auth::user()->fos_id],['session',$session],['level_id',$level]])->orderBy('reg_course_status','ASC')->get();
}else
{

 Session::flash('danger',"you have register for these session. Thank you");
 return back();
}

return view('undergraduate.medicine.PartCourses')->withRc($register_course)->withL($level)->withP($period)->withS($session);


 //Session::flash('danger',"you must been autheticated for school fees to continue with your registration.Click on returning students Link on the menu");
  //  return redirect()->intended('/profile'); 


}


public function returning_medicine_preview_course(Request $request)
    {
     $session= $request->input('session');
     $level =$request->level;
     $period =$request->period;
     $semester=$request->semester;  
     $variable = $request->input('id');
    $failed_variable = $request->input('idf');
    $drop_variable = $request->input('idd');
    $data ='';  $failed_data =''; $drop_data=''; $course_unit ='';
    $data_sum =0;  $failed_data_sum =0; $drop_data_sum=0; 
    $semester_name =Semester::where([['programme_id',Auth::user()->programme_id],['semester_id',$semester]])->first();
     if($variable != null)
     {
      $data =RegisterCourse::whereIn('id',$variable)->orderBy('reg_course_status','ASC')->orderBy('reg_course_code','ASC')->get();
       $data_sum = $data->sum('reg_course_unit');
     }
     
       if($failed_variable != null)
     {
      $failed_data =RegisterCourse::whereIn('id',$failed_variable)->orderBy('reg_course_code','ASC')->get();
      $failed_data_sum = $failed_data->sum('reg_course_unit');

     }
       if($drop_variable != null)
     {
      $drop_data =RegisterCourse::whereIn('id',$drop_variable)->orderBy('reg_course_code','ASC')->get();
      $drop_data_sum = $drop_data->sum('reg_course_unit');
      
     }
    
     $total_unit =$data_sum + $failed_data_sum + $drop_data_sum;
     //for medicine domi total course unit
    

    return view('undergraduate.medicine.partCoursePreview')->withPre($data)->withPref($failed_data)->withPred($drop_data)->withL($level)
    ->withP($period)->withTu($total_unit)->withSn($semester_name)->withS($session);
    }


    public function returning_post_medicine_register_course(Request $request)
    {
    // $db = DB::transaction(function () {   
       $id = $request->input('id');
       $idf = $request->input('idf');
       $idd = $request->input('idd');
       $session=$request->input('session');
       $level =$request->level;
       $semester=$request->semester; 
       $period =$request->period;

    
    $check_student_reg=StudentReg::where([['user_id',Auth::user()->id],['semester',$semester],['session',$session],['level_id',$level],['season',$period]])->first();
    if($check_student_reg == null)
    {
$student_reg = new StudentReg;
$student_reg->user_id =Auth::user()->id;
$student_reg->session = $session;
$student_reg->semester =$semester;
$student_reg->programme_id =Auth::user()->programme_id;
$student_reg->faculty_id =Auth::user()->faculty_id;
$student_reg->department_id =Auth::user()->department_id;
$student_reg->level_id =$level;
$student_reg->season =$period;
$student_reg->save();
       
if($student_reg->id){
  // register failed courses
  if($idf != null)
  {
      $data_f =RegisterCourse::whereIn('id',$idf)->get();

        foreach ($data_f as $key => $vf) {
         $insert_data_f[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$vf->id,'user_id'=>Auth::user()->id,'level_id'=>$vf->level_id,'semester_id'=>$vf->semester_id,'course_id'=>$vf->course_id,'course_title'=>$vf->reg_course_title,'course_code'=>$vf->reg_course_code,'course_unit'=>$vf->reg_course_unit,'course_status'=>"R",'session'=>$vf->session,'period'=>$period];
        }  

        DB::connection('mysql2')->table('course_regs')->insert($insert_data_f);
  }
    
  // register drop courses
  if($idd != null)
  {
          $data_d =RegisterCourse::whereIn('id',$idd)->get();

        foreach ($data_d as $key => $vd) {
         $insert_data_d[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$vd->id,'user_id'=>Auth::user()->id,'level_id'=>$vd->level_id,'semester_id'=>$vd->semester_id,'course_id'=>$vd->course_id,'course_title'=>$vd->reg_course_title,'course_code'=>$vd->reg_course_code,'course_unit'=>$vd->reg_course_unit,'course_status'=>"D",'session'=>$vd->session,'period'=>$period];
        }  

        DB::connection('mysql2')->table('course_regs')->insert($insert_data_d);
    }
if($id != null)
{
          $data =RegisterCourse::whereIn('id',$id)->get();

        foreach ($data as $key => $value) {
         $insert_data[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$value->id,'user_id'=>Auth::user()->id,'level_id'=>$value->level_id,'semester_id'=>$value->semester_id,'course_id'=>$value->course_id,'course_title'=>$value->reg_course_title,'course_code'=>$value->reg_course_code,'course_unit'=>$value->reg_course_unit,'course_status'=>$value->reg_course_status,'session'=>$value->session,'period'=>$period];
        }  

        DB::connection('mysql2')->table('course_regs')->insert($insert_data);
    }
  //  if(session()->get('currentSession') != null) {}else{
      $pinId=  session()->get('login_user');
     $this->updatePinLog1($pinId,$session);
     $this->updatePinLog2($pinId);
   // }
 
         Session::flash('success',"SUCCESSFULL.");
       }


       return redirect()->action('UndergraduateController@returningRegisterCourse');
    }else{
 Session::flash('warning',"you have register for these semester already.");
 return redirect()->action('UndergraduateController@returningRegisterCourse');
    }
} 
/*========================= end medicine code ===================================*/

public function returning_register_semester_courses(Request $request)
{
  $semester =$request->semester;
  $session =$request->session;
  $level =$request->level;
  $id = Auth::user()->id;
  $previous_level =$level-1;
 $drop_register_course ="";
 $failed_register_course ="";
 $register_course ='';
 $d='';$f='';$p='';

 $semester_name =$this->getSemester($semester);


  // check first if the student has been autheticated for school fess
  if(session()->get('paidschoolfess') == Auth::user()->id)
{
  // check if you have register for the semester
 $check_student_reg =$this->CheckRegisterStudentPerSemester($id,$semester,$session,$level,'NORMAL');

if($check_student_reg == null)
{
  $dropCourseAgric =array();

  $failedCoursesAgric =array();

  $failedCoursesAgricVacation=array();

  $student_reg =StudentReg::where([['user_id',$id,],['semester',$semester],['level_id',$previous_level]])->orderBy('session','desc')->orderBy('level_id','desc')->first();
  // get failed courses
  $failed_courses_course_id =array();

  $unregister_course_id =array();

  $combine_course_id ='';

  $previous_session = $student_reg->session;

  if(Auth::user()->programme_id != self::Diploma)
    {
      
  if(Auth::user()->department_id == self::DepartmentOfPlant && Auth::user()->entry_year == '2016' && $semester == 2 
  || Auth::user()->fos_id == self::FosHnd && $semester == 2 || Auth::user()->fos_id == self::FosHndDe && $semester == 2
  )
  {
    $fos = $this->getFos();
    
    if($fos->duration == 3){
      //direct entry
      $ITlevel = 2;
      }else{
      $ITlevel =3;
      }
      if($level == $ITlevel)
      { 
        
    $failed_courses = array();
      }else{
        $failed_courses =$this->getPreviouFailedCourses($id,$semester,$previous_session,'NORMAL');
      }
    }elseif(Auth::user()->faculty_id == self::FacultOfAgric){
      // faculty of agric condition for year 4
      $fos = $this->getFos();
      if($fos->duration == 4){
        //direct entry
        $ITlevel = 3;
        }else{
        $ITlevel =4;
        }
        if($level == $ITlevel)
        {
  $lastlevel =$level -1;
  $dropUnit = $this->dropCourseUnit($id,$lastlevel,$previous_session,'NORMAL');
 $failUnit =$this->failCourseUnit($lastlevel,$id,$previous_session,'NORMAL');
 $failUnit_vacation =$this->passedCourseUnit($lastlevel,$id,$previous_session,'VACATION');
 $totalCourseUnit = $dropUnit + $failUnit - $failUnit_vacation;
 if(Auth::user()->department_id == self::DepartmentFoodTech)
 {}else{
 // if($totalCourseUnit > 8){ i have to by for the students. delay student can register please treat 23/12/22
 if($totalCourseUnit > 8 && $id != 3116){
  Session::flash('danger',"You can not proceed with year four  registration.");
   return back();
 }
}
      
          if(Auth::user()->department_id == self::DepartmentFoodTech && $semester == 1)
          {
          $failed_courses =$this->getPreviouFailedCourses($id,$semester,$previous_session,'NORMAL');
          }else{
      $failed_courses = array();
          }
        }else{
          $failed_courses =$this->getPreviouFailedCourses($id,$semester,$previous_session,'NORMAL');
        }
  }else{

$failed_courses =$this->getPreviouFailedCourses($id,$semester,$previous_session,'NORMAL');
  }
  
 
// check if the courses has been failed upto three times
if(count($failed_courses) > 0)
{
  foreach ($failed_courses as $key => $value) {
  
  $check_failed_courses =$this->NumberPreviousFailedCoursePerCourseId($id,$semester,$previous_session,$value->course_id);
  $course_code =$this->getCourseCodeType($value->coursereg_id);
  $type = substr($course_code->course_code,0,3);
  // modified 08/07/2021
  if(in_array($type ,[ 'GSS','GST']) || $check_failed_courses < 3)
   {
$failed_courses_course_id [] =$value->course_id;
}
    
   }
  
  }
  
     // for students taht observer probation. to help dem fetct their real compulsary courses
    
     $probation_student =$this->getprobationStudents($id,$previous_level,$previous_session);

     if($probation_student =='true')
     {
       $previous_session = $previous_session -1;
       $session1 =$session -1;
       $sessionArray =[$previous_session,$session1];
     }
    

if(Auth::user()->department_id == self::DepartmentOfPlant && Auth::user()->entry_year == '2016' && $semester == 2 
|| Auth::user()->fos_id == self::FosHnd && $semester == 2  || Auth::user()->fos_id == self::FosHndDe && $semester == 2 )
{
  $fos = $this->getFos();
  if($fos->duration == 3){
    //direct entry
    $ITlevel = 2;
    }else{
    $ITlevel =3;
    }
    if($level == $ITlevel)
    {
      $d_register_course = array();
    }else{
      $d_register_course =$this->GetRegisteredCompulsaryCourses($semester,$previous_session,$previous_level);
    }
  }elseif(Auth::user()->faculty_id == self::FacultOfAgric){
    // faculty of agric condition for year 4
    $fos = $this->getFos();
    if($fos->duration == 4){
      //direct entry
      $ITlevel = 3;
      }else{
      $ITlevel =4;
      }
      if($level == $ITlevel)
      {
        $dropCourseAgric = $this->GetRegisteredCompulsaryCourses($semester,$previous_session,$previous_level);
        if(Auth::user()->department_id == self::DepartmentFoodTech && $semester == 1)
        {
          $d_register_course =$this->GetRegisteredCompulsaryCourses($semester,$previous_session,$previous_level);
        }else{
          $d_register_course = array();
         
        }
      }else{
        $d_register_course =$this->GetRegisteredCompulsaryCourses($semester,$previous_session,$previous_level);
      }   
}else{

  // get carry over courses. ie compulsary course the students failed to do in the previous session
  $d_register_course =$this->GetRegisteredCompulsaryCourses($semester,$previous_session,$previous_level);
}

//dd($d_register_course);
// will continue these conditon to reduce so delay student will not register for year 4 in agric
/*if($level == $ITlevel && Auth::user()->faculty_id == self::FacultOfAgric)
{
  //condition for delay
  $a =count($dropCourseAgric);
  $b =count($failedCoursesAgricVacation);
  $c =count($failedCoursesAgric);
  $d =$a+$b+$c;
  
  if($d > 10){
    
    return back();
  }

}
*/

if(count($d_register_course) > 0)
{
  foreach ($d_register_course as $key => $value) {
    
   if($probation_student =='true')
   {
     // for student that did probation
     
   $courseReg=$this->GetCourseRegSingleForStudentThatDidProbation($previous_session,$session1,$previous_level,$id,$value->course_id,$semester,'NORMAL');
   }else{
    $courseReg=$this->GetCourseRegSingle($previous_session,$previous_level,$id,$value->id,$value->course_id,$semester,'NORMAL'); 
   }
   if($courseReg== null)
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
    $insert_data =array();
    foreach ($combine_course_id as $key => $value) {
      // get courses first
   $r_c =RegisterCourse::where([['course_id',$value],['semester_id',$semester],['fos_id',Auth::user()->fos_id],['session',$previous_session]])->first();
   if($r_c != null){

     // check if failed or unregister courses id exist in registercourses
     
      $check_register_course =RegisterCourse::where([['course_id',$value],['semester_id',$semester],['fos_id',Auth::user()->fos_id],['session',$session],['level_id',$level],['reg_course_status',"G"]])->first();
      // failed or unregister courses id does not exist in registercourses
      
      if($check_register_course == null)
      {
    // $specializationId =$this->getSpecializationIdWithLevel(Auth::user()->specialization_id,$previous_level);
   $insert_data[] =['course_id'=>$value,'programme_id'=>Auth::user()->programme_id,'department_id'=>Auth::user()->department_id,'faculty_id'=>Auth::user()->faculty_id,'fos_id'=>Auth::user()->fos_id,'specialization_id'=>0,'level_id'=>$level,'semester_id'=>$semester,'reg_course_title'=>$r_c->reg_course_title,'reg_course_code'=>$r_c->reg_course_code,'reg_course_unit'=>$r_c->reg_course_unit,'reg_course_status'=>"G",'session'=>$session];
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
  $failed_register_course =$this->GetRegisteredCoursesWithArrayCourseId($semester,$session,$level,"G",$failed_courses_course_id);
}


// for drop courses
  if(!empty($unregister_course_id))
  {
 $drop_register_course =$this->GetRegisteredCoursesWithArrayCourseId($semester,$session,$level,"G",$unregister_course_id);
  
}

}
    }

  $presentSpecializationId =$this->getSpecializationIdWithLevel(Auth::user()->specialization_id,$level);
  if($presentSpecializationId == 0){
  $register_course=RegisterCourse::where([['programme_id',Auth::user()->programme_id],['faculty_id',Auth::user()->faculty_id],['department_id',Auth::user()->department_id],['fos_id',Auth::user()->fos_id],['semester_id',$semester],['session',$session],['level_id',$level]])
  ->whereIn('reg_course_status',["C","E"])
  ->orderBy('reg_course_status','ASC')->get();
  }else{
    $register_course=DB::table('register_courses')
    ->join('register_specializations','register_courses.id','=','register_specializations.registercourse_id')
    ->where([['programme_id',Auth::user()->programme_id],['faculty_id',Auth::user()->faculty_id],['department_id',Auth::user()->department_id],['register_courses.fos_id',Auth::user()->fos_id],['semester_id',$semester],['session',$session],['level_id',$level]])
  ->where('register_specializations.specialization_id',Auth::user()->specialization_id)
    ->whereIn('reg_course_status',["C","E"])
    ->select('register_courses.*')
  ->orderBy('reg_course_status','ASC')->get();
  }

  
      
}else
{

 Session::flash('danger',"you have register for these semester. Thank you");
 return back();
}

return view('undergraduate.rs_register_course.semester_courses')->withDrc($drop_register_course)->withFrc($failed_register_course)->withRc($register_course)->withSn($semester_name)->withL($level)->withS($session);
}

 Session::flash('danger',"you must been autheticated for school fees to continue with your registration.Click on returning students Link on the menu");
    return redirect()->intended('/profile'); 

}

public function returning_preview_course(Request $request)
    {
     $session= $request->session;
     $level =$request->level;
     $semester=$request->semester;  
     $variable = $request->input('id');
    $failed_variable = $request->input('idf');
    $drop_variable = $request->input('idd');
    $data ='';  $failed_data =''; $drop_data=''; $course_unit ='';
    $data_sum =0;  $failed_data_sum =0; $drop_data_sum=0; 
    $semester_name =Semester::where([['programme_id',Auth::user()->programme_id],['semester_id',$semester]])->first();
     if($variable != null)
     {
      $data =RegisterCourse::whereIn('id',$variable)->orderBy('reg_course_status','ASC')->orderBy('reg_course_code','ASC')->get();
       $data_sum = $data->sum('reg_course_unit');
     }
     
       if($failed_variable != null)
     {
      $failed_data =RegisterCourse::whereIn('id',$failed_variable)->orderBy('reg_course_code','ASC')->get();
      $failed_data_sum = $failed_data->sum('reg_course_unit');

     }
       if($drop_variable != null)
     {
      $drop_data =RegisterCourse::whereIn('id',$drop_variable)->orderBy('reg_course_code','ASC')->get();
      $drop_data_sum = $drop_data->sum('reg_course_unit');
      
     }
     $course_unit =CourseUnit::where([['session',$session],['level',$level],['fos',Auth::user()->fos_id]])->first();
     if($course_unit == null)
     {
      $course_unit =CourseUnit::where([['session',$session],['level',0],['fos',0]])->first();
     }
     $total_unit =$data_sum + $failed_data_sum + $drop_data_sum;
    

    return view('undergraduate.rs_register_course.preview_courses')->withPre($data)->withPref($failed_data)->withPred($drop_data)->withL($level)->withCu($course_unit)->withTu($total_unit)->withSn($semester_name)->withS($session);
    }

 //------------------------- register course that been preview method-----------------------

    public function returning_post_register_course(Request $request)
    {
    // $db = DB::transaction(function () {   
       $id = $request->input('id');
       $idf = $request->input('idf');
       $idd = $request->input('idd');
       $session= $request->session;
       $level =$request->level;
       $semester=$request->semester; 


    
    $check_student_reg=StudentReg::where([['user_id',Auth::user()->id],['semester',$semester],['session',$session],['level_id',$level]])->first();
    if($check_student_reg == null)
    {
$student_reg = new StudentReg;
$student_reg->user_id =Auth::user()->id;
$student_reg->session = $session;
$student_reg->semester =$semester;
$student_reg->programme_id =Auth::user()->programme_id;
$student_reg->faculty_id =Auth::user()->faculty_id;
$student_reg->department_id =Auth::user()->department_id;
$student_reg->level_id =$level;
$student_reg->season ="NORMAL";
$student_reg->save();
       
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
if($id != null)
{
          $data =RegisterCourse::whereIn('id',$id)->get();

        foreach ($data as $key => $value) {
         $insert_data[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$value->id,'user_id'=>Auth::user()->id,'level_id'=>$value->level_id,'semester_id'=>$value->semester_id,'course_id'=>$value->course_id,'course_title'=>$value->reg_course_title,'course_code'=>$value->reg_course_code,'course_unit'=>$value->reg_course_unit,'course_status'=>$value->reg_course_status,'session'=>$value->session,'period'=>"NORMAL"];
        }  

        DB::connection('mysql2')->table('course_regs')->insert($insert_data);
    }
    //if(session()->get('currentSession') != null) {}else{
    $pinId=  session()->get('login_user');

    // first semester log
    if($semester == 1)
    {
     $this->updatePinLog1($pinId,$session);
    
    }else{
      $this->updatePinLog2($pinId);
 
      }
    //}
         Session::flash('success',"SUCCESSFULL.");
       }
       return redirect()->action('UndergraduateController@returningRegisterCourse');
    }else{
 Session::flash('warning',"you have register for these semester already.");
 return redirect()->action('UndergraduateController@returningRegisterCourse');
    }
} 

//============================= summer registration for agric students================

public function registerSummerCourse()
{
  $allStudentreg = $this->getAllStudentRegistered();
  $studentreg = $this->getStudentRegistered();
  /*$studentreg =StudentReg::where([['user_id',Auth::user()->id],['semester',1]])
  ->select('session','level_id')->distinct('session')->get();*/
 return view('undergraduate.register_summer_course.index1')->withStudentreg($studentreg)->withAllstudentreg($allStudentreg);
}
public function register_summer_course(Request $request)
{
  $all_semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
 $id = Auth::user()->id;
 $s=  $request->session;
 $fos = $this->getFos();
 if($fos->duration == 4){
  //direct entry
  $level = 2;
  }else{
  $level =3;
  }
$student_reg =DB::connection('mysql2')->table('student_regs')
->where([['user_id',$id],['session',$s],['level_id',$level]])->first();
$next =$s+1;
 if($student_reg != null)
  {
  $cgpa =$this->get_cgpa($s,$id,'NORMAL');
  $prob=$this->Probtion($level,$id,$s,$cgpa,'NORMAL');
  if($prob != '')
  {
    return view('undergraduate.register_summer_course.index')->withR($prob)->withSs($s)->withNext($next)->withL($level);

  }

  }
  // check if all register courses has result  for the session
  
  $course_id_with_no_result = $this->courseWithOutGrade('course_regs',$student_reg->session,$student_reg->level_id,$id,'VACATION');

if(count($course_id_with_no_result) == 0)
{
 $dropUnit = $this->dropCourseUnit($id,$level,$s,'NORMAL');
 $failUnit =$this->failCourseUnit($level,$id,$s,'NORMAL');
 $totalCourseUnit = $dropUnit + $failUnit;

if($totalCourseUnit > 0 &&  $totalCourseUnit <=16)
{
  $failCourse =$this->failCourse($level,$id,$s,'NORMAL');
  $dropCourse =$this->dropCourse($id,$level,$s,'NORMAL');
  $course =$failCourse->merge($dropCourse);
  

  return view('undergraduate.register_summer_course.index')->withR($prob)->withSs($s)->withNext($next)->withL($level)->withRc($course);

}else{
  Session::flash('danger',"you are not qualify for summer.Contact your examination officer  for more information.");
  return back();
}
 

}else{
  Session::flash('danger',"your have out standing courses that grade have not be inputed.Contact your examination officer to input the grades before you can continues the registration.");
      return back();
}



}
//===================== preview summer courses ===========================

public function previewSummerCourse(Request $request)
    {
     
     $level =$request->level;
     $s =$request->session;
     $variable = $request->input('id');
   
    $data ='';   $course_unit ='';
    $data_sum =0;  
     if($variable != null)
     {
      $data =RegisterCourse::whereIn('id',$variable)->orderBy('reg_course_status','ASC')->orderBy('reg_course_code','ASC')->get();
       $data_sum = $data->sum('reg_course_unit');
     }
      
  $total_unit =$data_sum;
  $tcu =8;
  $next =$s+1;
    return view('undergraduate.register_summer_course.preview')->withTcu($tcu)->withPre($data)->withL($level)->withS($s)->withNext($next)->withCu($course_unit)->withTu($total_unit);
    }

//=========================post summer course ====================================
public function postSummerCourse(Request $request)
{
// $db = DB::transaction(function () {   
   $id = $request->input('id');
   $session = $request->session;;
   $level =$request->level;
$check_student_reg=DB::connection('mysql2')->table('student_regs')->where([['user_id',Auth::user()->id],['session',$session],['level_id',$level],['season','VACATION']])->get();
 //dd($check_student_reg);
if(count($check_student_reg) == 0)
{
 // $data[] =

 // dd($data);
  $studentReg =  DB::connection('mysql2')->table('student_regs')->insert([
    ['user_id'=>Auth::user()->id,'session'=>$session,'level_id'=>$level,'semester'=>1,'season'=>'VACATION',
    'department_id'=>Auth::user()->department_id,'faculty_id'=>Auth::user()->faculty_id,'programme_id'=>Auth::user()->programme_id],
    ['user_id'=>Auth::user()->id,'session'=>$session,'level_id'=>$level,'semester'=>2,'season'=>'VACATION',
    'department_id'=>Auth::user()->department_id,'faculty_id'=>Auth::user()->faculty_id,'programme_id'=>Auth::user()->programme_id],
  ]);
if($studentReg){

if($id != null)
{
      $data =RegisterCourse::whereIn('id',$id)->get();
     
    foreach ($data as $key => $value) {
      $student_reg=DB::connection('mysql2')->table('student_regs')->where([['user_id',Auth::user()->id],['session',$session],['level_id',$level],['season','VACATION'],['semester',$value->semester_id]])->first();
      if($value->reg_course_status =='G')
      {
        $status ='R';
      }else{
        $status =$value->reg_course_status;
      }
     $insert_data[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$value->id,'user_id'=>Auth::user()->id,'level_id'=>$value->level_id,'semester_id'=>$value->semester_id,'course_id'=>$value->course_id,'course_title'=>$value->reg_course_title,'course_code'=>$value->reg_course_code,'course_unit'=>$value->reg_course_unit,'course_status'=>$status,'session'=>$value->session,'period'=>"VACATION"];
    }  

    DB::connection('mysql2')->table('course_regs')->insert($insert_data);
}

     Session::flash('success',"SUCCESSFULL.");
   }
   return redirect()->action('UndergraduateController@registerSummerCourse');
}else{
Session::flash('warning',"you have register for  summer these semester already.");
return redirect()->action('UndergraduateController@registerSummerCourse');
}
} 
//=====================delay registration for agric students========================

public function register_delayed_course(Request $request)
{
  $allStudentreg = $this->getAllStudentRegistered();
 

 return view('undergraduate.register_delayed_course.index')->withAllstudentreg($allStudentreg);

}

public function post_register_delayed_course(Request $request)
{
  $all_semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
 $id = Auth::user()->id;
 $s=  $request->session;
 $fos = $this->getFos();
 if($fos->duration == 4){
  //direct entry
  $level = 2;
  }else{
  $level =3;
  }
$student_reg =DB::connection('mysql2')->table('student_regs')
->where([['user_id',$id],['session',$s],['level_id',$level]])->first();
$next =$s+1;
$lastSession =$s-1;
 if($student_reg == null)
  {
  $cgpa =$this->get_cgpa($lastSession,$id,'NORMAL');
  $prob=$this->Probtion($level,$id,$lastSession,$cgpa,'NORMAL');
  
  if($prob != '')
  {
    return view('undergraduate.register_delayed_course.index2')->withR($prob)->withSs($s)->withNext($next)->withL($level);

  }

  // check if all register courses has result  for the session
  
  $course_id_with_no_result = $this->courseWithOutGrade('course_regs',$lastSession,$level,$id,'VACATION');

if(count($course_id_with_no_result) == 0)
{
 $dropUnit = $this->dropCourseUnit($id,$level,$lastSession,'NORMAL');
 $failUnit =$this->failCourseUnit($level,$id,$lastSession,'NORMAL');
 $failUnit_vacation =$this->failCourseUnit($level,$id,$lastSession,'VACATION');
 $totalCourseUnit = $dropUnit + $failUnit - $failUnit_vacation;

if($totalCourseUnit > 8 )
{
  $failCourse =$this->failCourse($level,$id,$lastSession,'NORMAL');
  $dropCourse =$this->dropCourse($id,$level,$lastSession,'NORMAL');
  $course =$failCourse->merge($dropCourse);
  
  

  return view('undergraduate.register_delayed_course.index2')->withR($prob)->withSs($s)->withNext($next)->withL($level)->withRc($course);

}else{
  Session::flash('danger',"your are not qualify for delay.Contact your examination officer to input the grades before you can continues the registration.");
  return back();
}
 

}else{
  Session::flash('danger',"your have out standing courses that grade have not be inputed.Contact your examination officer to input the grades before you can continues the registration.");
      return back();
}

}
}

//===================== preview Delayed courses ===========================

public function previewDelayedCourse(Request $request)
    {
     
     $level =$request->level;
     $s =$request->session;
     $variable = $request->input('id');
   
    $data ='';   $course_unit ='';
    $data_sum =0;  
     if($variable != null)
     {
      $data =RegisterCourse::whereIn('id',$variable)->orderBy('reg_course_status','ASC')->orderBy('reg_course_code','ASC')->get();
       $data_sum = $data->sum('reg_course_unit');
     }
      
  $total_unit =$data_sum;
  $tcu =24;
  $next =$s+1;
    return view('undergraduate.register_delayed_course.preview')->withTcu($tcu)->withPre($data)->withL($level)->withS($s)->withNext($next)->withCu($course_unit)->withTu($total_unit);
    }

//=========================post delayed course ====================================
public function postDelayedCourse(Request $request)
{
// $db = DB::transaction(function () {   
   $id = $request->input('id');
   $session = $request->session;;
   $level =$request->level;
$check_student_reg=DB::connection('mysql2')->table('student_regs')->where([['user_id',Auth::user()->id],['session',$session],['level_id',$level],['season','VACATION']])->get();
 //dd($check_student_reg);
if(count($check_student_reg) == 0)
{
 
  $studentReg =  DB::connection('mysql2')->table('student_regs')->insert([
    ['user_id'=>Auth::user()->id,'session'=>$session,'level_id'=>$level,'semester'=>1,'season'=>'NORMAL',
    'department_id'=>Auth::user()->department_id,'faculty_id'=>Auth::user()->faculty_id,'programme_id'=>Auth::user()->programme_id],
    ['user_id'=>Auth::user()->id,'session'=>$session,'level_id'=>$level,'semester'=>2,'season'=>'NORMAL',
    'department_id'=>Auth::user()->department_id,'faculty_id'=>Auth::user()->faculty_id,'programme_id'=>Auth::user()->programme_id],
  ]);
if($studentReg){

if($id != null)
{
      $data =RegisterCourse::whereIn('id',$id)->get();
     
    foreach ($data as $key => $value) {
      $student_reg=DB::connection('mysql2')->table('student_regs')->where([['user_id',Auth::user()->id],['session',$session],['level_id',$level],['season','NORMAL'],['semester',$value->semester_id]])->first();
      if($value->reg_course_status =='G')
      {
        $status ='R';
      }else{
        $status =$value->reg_course_status;
      }
     $insert_data[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$value->id,'user_id'=>Auth::user()->id,'level_id'=>$value->level_id,'semester_id'=>$value->semester_id,'course_id'=>$value->course_id,'course_title'=>$value->reg_course_title,'course_code'=>$value->reg_course_code,'course_unit'=>$value->reg_course_unit,'course_status'=>$status,'session'=>$session,'period'=>"NORMAL"];
    }  

    DB::connection('mysql2')->table('course_regs')->insert($insert_data);
}

     Session::flash('success',"SUCCESSFULL.");
   }
   return redirect()->action('UndergraduateController@register_delayed_course');
}else{
Session::flash('warning',"you have register for  summer these semester already.");
return redirect()->action('UndergraduateController@register_delayed_course');
}
} 
//======================= register long vacation courses =======================

//============================= summer registration for agric students================
public function register_long_vacation(Request $request)
{
  $level =$request->level;
  $duration =$request->duration;
  $s =(int)$request->session;

 $all_semester =Semester::where('programme_id',Auth::user()->programme_id)->get();
 $id = Auth::user()->id;
 $student_reg =DB::connection('mysql2')->table('student_regs')
->where([['user_id',$id],['session',$s],['level_id',$level]])->first();
$next =$s+1;
 
  // check if all register courses has result  for the session
$course_id_with_no_result = $this->courseWithOutGrade('course_regs',$s,$level,$id,'NORMAL');

if(count($course_id_with_no_result) == 0)
{
 //$dropUnit = $this->dropCourseUnit($id,$level,$s,'NORMAL');
 $failUnit =$this->failCourseUnit($level,$id,$s,'NORMAL');

 //$totalCourseUnit = $dropUnit + $failUnit;
 $totalCourseUnit = $failUnit;

if($totalCourseUnit > 0 &&  $totalCourseUnit <=8)
{
  $failCourse =$this->failCourse($level,$id,$s,'NORMAL');
  //$dropCourse =$this->dropCourse($id,$level,$s,'NORMAL');
  //$course =$failCourse->merge($dropCourse);
  $course =$failCourse;
  

  return view('undergraduate.register_long_vacation.index')->withSs($s)->withNext($next)->withL($level)->withRc($course);

}else{
  Session::flash('danger',"Your failed  course is more than 6 unit.");
      return back();

}
 

}else{
  Session::flash('danger',"your have out standing courses that grade have not be inputed.Contact your examination officer to input the grades before you can continues the registration.");
      return back();
}
}

public function previewVacationCourse(Request $request)
    {
     $level =$request->level;
     $s =$request->session;
     $next =$s+1;
    $variable = $request->input('id');
   $data ='';   $course_unit ='';
    $data_sum =0;  
     if($variable != null)
     {
      $data =RegisterCourse::whereIn('id',$variable)->orderBy('reg_course_status','ASC')->orderBy('reg_course_code','ASC')->get();
       $data_sum = $data->sum('reg_course_unit');
     }
      
  $total_unit =$data_sum;
  $tcu =24;
    return view('undergraduate.register_long_vacation.preview')->withSs($s)->withNext($next)->withTcu($tcu)->withPre($data)->withL($level)->withCu($course_unit)->withTu($total_unit);
    }

//=========================post vacation course ====================================
public function postVacationCourse(Request $request)
{
// $db = DB::transaction(function () {   
   $id = $request->input('id');
   $session=$request->session;
   $level =$request->level;
$check_student_reg=DB::connection('mysql2')->table('student_regs')->where([['user_id',Auth::user()->id],['session',$session],['level_id',$level],['season','VACATION']])->get();
 //dd($check_student_reg);
if(count($check_student_reg) == 0)
{
  $studentReg =  DB::connection('mysql2')->table('student_regs')->insert([
    ['user_id'=>Auth::user()->id,'session'=>$session,'level_id'=>$level,'semester'=>1,'season'=>'VACATION',
    'department_id'=>Auth::user()->department_id,'faculty_id'=>Auth::user()->faculty_id,'programme_id'=>Auth::user()->programme_id],
    ['user_id'=>Auth::user()->id,'session'=>$session,'level_id'=>$level,'semester'=>2,'season'=>'VACATION',
    'department_id'=>Auth::user()->department_id,'faculty_id'=>Auth::user()->faculty_id,'programme_id'=>Auth::user()->programme_id],
  ]);
if($studentReg){

if($id != null)
{
      $data =RegisterCourse::whereIn('id',$id)->get();
     
    foreach ($data as $key => $value) {
      $student_reg=DB::connection('mysql2')->table('student_regs')->where([['user_id',Auth::user()->id],['session',$session],['level_id',$level],['season','VACATION'],['semester',$value->semester_id]])->first();
if($value->reg_course_status =='G')
{
  $status ='R';
}else{
  $status =$value->reg_course_status;
}
     $insert_data[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$value->id,'user_id'=>Auth::user()->id,'level_id'=>$value->level_id,'semester_id'=>$value->semester_id,'course_id'=>$value->course_id,'course_title'=>$value->reg_course_title,'course_code'=>$value->reg_course_code,'course_unit'=>$value->reg_course_unit,'course_status'=>$status,'session'=>$value->session,'period'=>"VACATION"];
    }  

    DB::connection('mysql2')->table('course_regs')->insert($insert_data);
}

     Session::flash('success',"SUCCESSFULL.");
   }
   return redirect()->action('UndergraduateController@index');
}else{
Session::flash('warning',"you have registered for long vacation in these session already.");
return redirect()->action('UndergraduateController@index');
}
} 
/*--------------                      PROBATION  -----------------------------------*/
// ================================ probation course registration ====================================================
public function probation_semester_courses(Request $request)
{
  
  $session =$request->session;
  $level =$request->level;
  $id = Auth::user()->id;
  $previous_level =$level;
 $drop_register_course ="";
 $failed_register_course ="";
// check first if the student has been autheticated for school fess
 //dd(session()->get('paidschoolfess'));
  if(session()->get('paidschoolfess') == Auth::user()->id)
{
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

  // get carry over courses. ie compulsary course the students failed to do in the previous session
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

     // check if failed or unregister courses id exist in registercourses

      $check_register_course =DB::connection('mysql')->table('register_courses')->where([['course_id',$value],['fos_id',Auth::user()->fos_id],['session',$session],['level_id',$level],['reg_course_status',"G"]])->first();
      // failed or unregister courses id does not exist in registercourses

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
return view('undergraduate.rs_register_course.probation')->withDrc($drop_register_course)->withFrc($failed_register_course)->withL($level)->withS($session)->withNext($next);
}

 Session::flash('danger',"you must been autheticated for school fees to continue with your registration.Click on returning students Link on the menu");
    return redirect()->intended('/profile'); 

}


 //------------------------- register course probation----------------------

    public function probation_post_register_course(Request $request)
    {
    // $db = DB::transaction(function () {   
       
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
    // update pin
    $pinId=  session()->get('login_user');
     $this->updatePinLog1($pinId,$session);
     $this->updatePinLog2($pinId);
 
      

         Session::flash('success',"SUCCESSFULL.");
       }
    }else{
 Session::flash('warning',"you have register for these semester already.");
    }

  
return redirect()->action('UndergraduateController@returningRegisterCourse');
}   
/*------------------------------- DIPLOMA ------------------------------------------*/
//======================= diploma students =======================================
public function register_resit_course()
{
  
 $id = Auth::user()->id;
 $studentreg =StudentReg::where([['user_id',Auth::user()->id],['semester',1]])
 ->select('session','level_id')->distinct('session')->get();
 // $student_reg =StudentReg::where([['user_id',$id],['session','=',$s]])->orderBy('level_id','desc')->first();

  return view('undergraduate.diploma.resit.index')->withStudentreg($studentreg);
}

public function post_register_resit_course(Request $request)
{

  $session =$request->session;
  $level =$request->level;
  $id = Auth::user()->id;
 $failed_courses ="";
 $course_id=array();

$check =$this->course_with_no_result($session,$level,$id);

if($check != 0)
{  Session::flash('warning',"you can not register for resit courses untill all result are entered.so contact your examination officer");
  return back();
}
$check_student_reg =StudentReg::where([['user_id',$id,],['level_id',$level],['season','RESIT']])->first();
if($check_student_reg == null)
{
 
  $student_reg =StudentReg::where([['user_id',$id,],['level_id',$level],['season','NORMAL']])->get()->count();

  if($student_reg == 0)
  {
    Session::flash('warning',"you have not register for these session.");
    return back();
  }
  // get failed courses
  $failed_courses =array();
 $failed_courses =$this->getCurrentFailedCourses($id,$level,$session);

 if(!empty($failed_courses))
 {
  foreach ($failed_courses as $key => $value) {
    $course_id []=$value->course_id;
  }

  $reg =RegisterCourse::whereIn('course_id',$course_id)->where([['fos_id',Auth::user()->fos_id],['session',$session],['level_id',$level],['reg_course_status','C']])->get();
  
   }
$next =$session + 1;
 return view('undergraduate.diploma.resit.preview')->withRg($reg)->withL($level)->withS($session)->withNext($next);

}else
{
  Session::flash('warning',"you have register for resit course already.");
  return back();
}
}
// register resit courses.
public function post_register_resit_course1(Request $request)
{
$d = $request->input('idd');
$session =$request->session;
$level =$request->level;
//dd($session);
$reg =RegisterCourse::whereIn('id',$d)->get();
//dd($reg);
 
 $check_student_reg=$this->CheckRegisterStudent(Auth::user()->id,$session,$level,'RESIT');
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
$student_reg->season ="RESIT";
$student_reg->save();

$student_reg2 = new StudentReg;
$student_reg2->user_id =Auth::user()->id;
$student_reg2->session = $session;
$student_reg2->semester =2;
$student_reg2->programme_id =Auth::user()->programme_id;
$student_reg2->faculty_id =Auth::user()->faculty_id;
$student_reg2->department_id =Auth::user()->department_id;
$student_reg2->level_id =$level;
$student_reg2->season ="RESIT";
$student_reg2->save();
       
if($student_reg->id){
  // register failed courses
  if(count($reg) > 0)
  {

foreach ($reg as $key => $vf) {
  if($vf->semester_id == 1){
         $data[] =['studentreg_id'=>$student_reg->id,'registercourse_id'=>$vf->id,'user_id'=>Auth::user()->id,'level_id'=>$vf->level_id,'semester_id'=>$vf->semester_id,'course_id'=>$vf->course_id,'course_title'=>$vf->reg_course_title,'course_code'=>$vf->reg_course_code,'course_unit'=>$vf->reg_course_unit,'course_status'=>"R",'session'=>$vf->session,'period'=>"RESIT"];
       }
if($vf->semester_id == 2){
         $data2[] =['studentreg_id'=>$student_reg2->id,'registercourse_id'=>$vf->id,'user_id'=>Auth::user()->id,'level_id'=>$vf->level_id,'semester_id'=>$vf->semester_id,'course_id'=>$vf->course_id,'course_title'=>$vf->reg_course_title,'course_code'=>$vf->reg_course_code,'course_unit'=>$vf->reg_course_unit,'course_status'=>"R",'session'=>$vf->session,'period'=>"RESIT"];
       }

        }
        if(!empty($data)){ DB::connection('mysql2')->table('course_regs')->insert($data); }
       
       if(!empty($data2)){ DB::connection('mysql2')->table('course_regs')->insert($data2); }
        Session::flash('success',"SUCCESSFULL");
      }
    }
  }else{
    Session::flash('warning',"you have register for a resit courses already");
    return back();
  }
  return redirect()->action('UndergraduateController@index');
}




 public function getDuplicate()
{$a =array();
  $s=DB::connection('mysql2')->table('users')
  ->whereBetween('id',[1,500])->get();
  foreach($s as $v){
    set_time_limit(8000000);
    $t=DB::connection('mysql2')->table('course_regs')
    ->where('user_id',$v->id)
    ->where('period','NORMAL')
    ->select('*', (DB::raw('COUNT(registercourse_id)')))
    ->groupBy('registercourse_id')
    ->havingRaw('COUNT(registercourse_id) > 1')
    ->get();
    if(count($t) != 0)
    {
      $a[]=$t;
    }
   
    }
    dd($a);
}

}

