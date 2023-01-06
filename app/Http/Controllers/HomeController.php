<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Contact;
use Intervention\Image\Facades\Image;
use App\User;
use App\Faculty;
use Illuminate\Support\Facades\DB;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }

*/ 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }

    public function homepage()
    {
    	
        return view('home.homepage');
    }

 public function faq()
    {
       
        return view('home.faq');
    }
  public function contact()
    {
       
        return view('home.contact');
    } 
public function postcontact(Request $request)
    {
      $this->validate($request,array
     (
    'email'=>'required',
    'matric_number'=>'required',
    'message'=>'required',
    )); 
    $user =User::where('matric_number',$request->matric_number)->first();
    $user1 =DB::connection('mysql1')->table('students_profile')->where('matric_no',$request->matric_number)->first();
    if($user == null && $user1 ==null )
    {
        Session::flash('warning','check your matric number. Only registered Students that can send message');   
        return view('home.contact');  
    }
      $cont=New Contact;
$cont->email =$request->email;
$cont->phone =$request->phone;
$cont->status =0;
$cont->matric_number =$request->matric_number;
$cont->message =$request->message;
$cont->save();
    Session::flash('success','successfull');   
return view('home.contact');
    }  
//====================  edit images==============================================
    public function edit_image($id)
    {
      $users = User::find($id);
     return view('home.edit_image')->withU($users);
    }

      public function post_edit_image(Request $request)
    {
       $users = User::find($request->id);
     if($users != null)
     {
      if($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $filename = time() . '.' . $image->getClientOriginalExtension();
           $destinationPath = public_path('img/student');
            $img = Image::make($image->getRealPath());
            $size =$img->filesize();
           
            if($size > 30720){
                Session::flash('danger','Image Size is bigger than 30kb'); 
                return back(); 
            }
            $img->resize(150, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
        $users->image_url = $filename;
        $users->save();
        Session::flash('success',"successfull.");
         
          }
          return   $this->success();
     }
  return   $this->index();
    } 
    public function success()
    {
        return view('home.success');
    }   
    //=========================get faculty ==========================
function get_faculty()
{
$sql =Faculty::$connection2->get();
return $sql;
}

//=========================get Department ==========================
function get_department()
{
$fac_id =  session()->get('faculty_id');
$depart_id =  session()->get('depart_id');
$sql = DB::connection('mysql1')->table('departments')->where([['fac_id',$fac_id],['departments_id',$depart_id]])->first();
return $sql->departments_name;	
    }
    //============================recovery pin===================
    public function recovery_pin()
    {
        return view('home.recovery_pin.index'); 
    }

    public function post_recovery_pin(Request $request)
    {
        $matric_number =$request->matric_number;
       // $email =$request->email;
        $sql = DB::table('users')->where('matric_number',$matric_number)->first();
        if($sql == null)
        {
    Session::flash('warning',"Please check your matric number if you  are registered.");
      return back();
        }else{
       
$data = array('email' => $sql->email,'matric_number'=>$sql->matric_number);

  Mail::send(array('html'=>'emails.recovery_pin'), $data, function($message) use ($data)  {
                
                $message->to($data['email'],$data['matric_number']);
                $message->subject("Unical database : Reset Of Password");

            });
        }
        Session::flash('success',"Email sent. check your sparm mail if not found in the inbox.");
        return back();
//return $sql->departments_name;	

    }
    
}
