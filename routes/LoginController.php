<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Pin;
use App\PdgUser;
use DB;
use App\Http\Traits\MyTrait;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    use MyTrait;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)

    {

        $this->validate($request, [
            'matric_number' => 'required',
             'pin' => 'required',
            'serial_number' => 'required',
            'type' => 'required',
          'status' => 'required',
            ]);
        $matric_number =$request->input('matric_number');
        $pin =$request->input('pin');
        $serial_number =$request->input('serial_number');
        $status =$request->input('status');
        $s_type = explode('~',$request->input('type'));

        $type =$s_type[0]; // for students type eg pds, undergraduate

        $type_2 =$s_type[1]; // for student type for undergraduate details eg. direct entry and normal students.


        if($type == 1)
        {
       
      
       if (auth::guard('pdg')->attempt(array('matric_number' => $request->input('matric_number'), 'password' => $request->input('matric_number'))))

        {   
$user_id =auth::guard('pdg')->user()->id;

$user_matric_number=auth::guard('pdg')->user()->matric_number;

//====================== autheticate pin ========================

  $pin =Pin::where([['pin',$pin],['id',$serial_number]])->first();
 
  if(count($pin) >0)
  {
    session()->put('login_user',$pin->id);
    session()->put('login_pin',$pin->pin);
    session()->put('session_year',$pin->session);

    if($pin->status == 0)
    {
       
        $pin->student_id =$user_id;
        $pin->matric_number =$user_matric_number;
        $pin->status =1;
        $pin->student_type=$type;
        $pin->save();
       
    return redirect()->intended('/pds'); 

    }elseif($pin->status == 1)
    {
      if($pin->matric_number == $matric_number && $pin->student_id == $user_id)
      {
      
     
       return redirect()->intended('/pds'); 
      }else{
        
   
         Auth::logout();
         return redirect('login')->with('status', 'pin Already used by another matric number.');
      } 
    }
  }else{
 

Auth::logout();
      return redirect('login')->with('status', 'Incorrect Pin or Serial Number.');
  }
}

        }elseif($type == 2)
        {
          
      
       if (auth()->attempt(array('matric_number' => $request->input('matric_number'), 'password' => $request->input('matric_number'))))

        {   
$user_id =auth()->user()->id;
$user_matric_number=auth()->user()->matric_number;


        //====================== autheticate pin ========================

  $pin =Pin::where([['pin',$pin],['id',$serial_number]])->first();
 
  if($pin != null)
  {
    session()->put('login_user',$pin->id);
     session()->put('login_pin',$pin->pin);
    session()->put('session_year',$pin->session);
    session()->put('student_type',$type_2);
   session()->put('student_status',$status);
    if($pin->status == 0)
    {
     
        $pin->student_id =$user_id;
        $pin->matric_number =$user_matric_number;
        $pin->student_type=$type;
        $pin->status =1;
        $pin->save();
      
       
    return redirect()->intended('/profile'); 

    }elseif($pin->status == 1)
    {
      if($pin->matric_number == $matric_number && $pin->student_id == $user_id)
      {
      return redirect()->intended('/profile'); 
      }else{
        Auth::logout();
        return redirect('login')->with('status', 'pin Already used by another matric number.');
      } 
    }
  }else{
 Auth::logout();
  return redirect('login')->with('status', 'Incorrect Pin or Serial Number.');
  }
}
}
Session::flash('warning',"please check your Matric Number.");
 return back();
}
// ==============================login form======================
    public function enter_pin1()
    {
   return view('auth.enter_pin1');
    }

      public function enter_pin()
    {
   return view('auth.enter_pin');
    }
// ==============================login form======================
     public function post_enter_pin1(Request $request)
    {
      Session::flash('danger',"whoops!!! Some thing went wrong.Contant your Exams Officer");
      return back();
    }

    public function post_enter_pin(Request $request)
    {
  

$this->validate($request, ['pin' => 'required','serial_no' => 'required',]);
$pin =$request->input('pin');
$serial_no =$request->input('serial_no');
$MatricNumber =$request->input('matricno');
$session_year =$request->input('session');
$sec = explode('~', $session_year);
$entry_year =$sec[1];
$Session =$sec[0];
$student_type =$request->input('student_type');
$pin =$request->input('pin');
$serial_no =$request->input('serial_no');
       if( $student_type == 1)
       {
   $Level=100;
       }elseif($student_type == 2)
       {
   $Level=200;
       }
       if($student_type != 3)
       {
//$response =$this->get_school_status($MatricNumber,$Session,$Level);
$response ="OK Proceed";
       }else{
    $response ="OK Proceed";
       }
  
 
             
if($response =="OK Proceed")
        {
   $check =User::where([['jamb_reg',$MatricNumber],['entry_year',$entry_year]])->first();
   if($check != null)
   {
    Session::flash('danger',"your jamb reg number / Matric Number is registered Already.");
 
     return back();
   } 
  $pin =Pin::where([['pin',$pin],['id', $serial_no]])->first();
  if($pin != null)
  {
    if($pin->status == 0)
    {
      session()->forget('u_login_user');
      session()->forget('jreg');
      session()->forget('session');
       session()->put('u_login_user',$pin->id);
       session()->put('jreg',$MatricNumber);
       session()->put('session',$pin->session);
      
      return redirect()->intended('/udg_register'); 

    }elseif($pin->status == 1)
    {
     Session::flash('danger',"Pin Already Used.");
    return back(); 
    }
  }else{
Session::flash('danger',"Incorrect Pin or Serial Number.");
            
  }

   
   }elseif($response =="Not Paid")
   {
Session::flash('danger',"you have not pay school fees.");
   }
   else{
    Session::flash('danger',"School fess authetication failed. contact your system admin.");
    }
     return back();
   
    }
// ==============================login form======================
    public function pds_enter_pin()
    {
      return view('auth.pds_enter_pin');
    }
// ==============================login form======================
    public function pds_post_enter_pin(Request $request)
    {
       $this->validate($request, [
           'pin' => 'required',
            'serial_no' => 'required',
           
            ]);
        $pin =$request->input('pin');
        $serial_no =$request->input('serial_no');
        $MatricNumber =$request->input('matricno');
       $session_year =$request->input('session');
  $sec = explode('~', $session_year);
     
     $entry_year =$sec[1];
      $Session =$sec[0];
      $Level =100;
      
//$response =$this->get_school_status($MatricNumber,$Session,$Level);
$response ='OK Proceed';
        if($response =="OK Proceed")
        {
          $check =PdgUser::where([['jamb_reg',$MatricNumber],['entry_year',$entry_year]])->first();
   if($check != null)
   {
    Session::flash('danger',"your jamb reg number is registered Already.");
 
     return back();
   }  
       $pin =Pin::where([['pin',$pin],['id', $serial_no]])->first();
  if($pin != null)
  {
    if($pin->status == 0)
    {
      session()->forget('pds_login_user');
       session()->forget('jreg');
    session()->flush();

       session()->put('pds_login_user',$pin->id);
        session()->put('jreg',$MatricNumber);
      return redirect()->intended('/pdg_register'); 

    }elseif($pin->status == 1)
    {
     Session::flash('danger',"Pin Already Used.");
    return redirect()->intended('/pds_enter_pin'); 
    }
  }else{
Session::flash('danger',"Incorrect Pin or Serial Number.");
            
  }
  }elseif($response =="Not Paid")
   {
Session::flash('danger',"your have not pay school fess.");
   }

     return back();
    }


// ==============================login form======================
    public function s_login()
    {
    return view('auth.std_login');
    }
// ==============================login======================
         public function std_login(Request $request)

    {

        $this->validate($request, [
            'matric_no' => 'required',
             'pin' => 'required',
            'serial_no' => 'required',
            'student_type'=>'required'
            ]);

        $matric_no =$request->input('matric_no');
        $pin =$request->input('pin');
        $serial_no =$request->input('serial_no');
        $student_type= $request->input('student_type');
 $users = DB::connection('mysql1')->table('students_profile')->where('matric_no', $matric_no)->first();
//====================== autheticate pin ========================
if($users != null)
{
  $pin =Pin::where([['pin',$pin],['id', $serial_no]])->first();

  if($pin != null)
  {
    if($pin->status == 0)
    {
       
        $pin->student_id =$users->std_id;
        $pin->student_type =$student_type;
        $pin->matric_number=$users->matric_no;
        $pin->status =1;
        $pin->save();
       session()->put('login_user',$pin->id);
       session()->put('session_year',$pin->session);
       session()->put('student_type',$pin->student_type);
       session()->put('std_id',$users->std_id);
       session()->put('matric_no',$users->matric_no);
       $name =$users->surname.' '.$users->firstname.' '.$users->othernames;
       session()->put('name', $name);
       session()->put('fos',$users->stdcourse);
        session()->put('faculty_id',$users->stdfaculty_id);
       session()->put('depart_id',$users->stddepartment_id);
       session()->put('programme_id',$users->stdprogramme_id);
    return redirect()->intended('/oldresult'); 

    }elseif($pin->status == 1)
    {
      if($pin->student_type == $student_type && $pin->student_id == $users->std_id && $pin->matric_number == $matric_no)
      {
       session()->put('login_user',$pin->id);
       session()->put('session_year',$pin->session);
       session()->put('student_type',$pin->student_type);
       session()->put('std_id',$users->std_id);
       session()->put('matric_no',$users->matric_no);
       $name =$users->surname.' '.$users->firstname.' '.$users->othernames;
       session()->put('name', $name);
       session()->put('fos',$users->stdcourse);
        session()->put('faculty_id',$users->stdfaculty_id);
       session()->put('depart_id',$users->stddepartment_id);
       session()->put('programme_id',$users->stdprogramme_id);
       return redirect()->intended('/oldresult'); 
      }else{
        Session::flash('warning',"pin Already used by another matric number.");
            return back();
      } 
    }
  }else{
Session::flash('danger',"Incorrect Pin or Serial Number.");
            return back();
  }
}else{
 Session::flash('warning',"please check your Matric Number.");
            return back();
}


   
}

public function std_logout()
{
   session()->forget('login_user');

session()->flush();

   return redirect()->intended('/'); 
}

 public function logout(Request $request)
{
Auth::logout();
return redirect('/');
}
}
