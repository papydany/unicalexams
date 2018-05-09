<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Contact;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\User;

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
     if(count($users) > 0)
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
}
