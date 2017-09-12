<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\PdgUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Faculty;
use App\Programme;
use App\Department;
use App\State;
use App\Lga;
use App\Fos;
use App\Pin;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
   // protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    Const Undergraduate =2;
    Const PDS =1;
    public function __construct()
    {
        $this->middleware('guest');
    $this->middleware('checkudg', ['only' => ['showRegistrationForm']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'surname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'othername' => 'required|string|max:255',
             'matric_number' => 'required|unique:mysql2.users',
            'phone' => 'required|string|max:255',
            'programme_id' => 'required',
             'department_id' => 'required',
            'faculty_id' => 'required',
            'fos_id' => 'required',
             'state_id' => 'required',
            'lga_id' => 'required',
            'entry_year' => 'required',
             'gender' => 'required',
            'marital_status' => 'required',
            'address' => 'required',
            'email' => 'required|string|email|max:100|unique:mysql2.users',
           
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data,$img)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'othername' => $data['othername'],
            'matric_number' => $data['matric_number'],
            'jamb_reg' => $data['jamb_reg'],
            'phone' => $data['phone'],
            'programme_id' => $data['programme_id'],
            'department_id' => $data['department_id'],
            'faculty_id' => $data['faculty_id'],
            'fos_id' => $data['fos_id'],
            'entry_year' => $data['entry_year'],
            'entry_month' => $data['entry_month'],
             'state_id' => $data['state_id'],
            'lga_id' => $data['lga_id'],
            'gender' => $data['gender'],
            'marital_status' => $data['marital_status'],
            'email' => $data['email'],
            'password' => bcrypt($data['matric_number']),
            'nationality' => $data['nationality'],
            'address' => $data['address'],
            'image_url' => $img,
        ]);
    }
public function showRegistrationForm()
{
   
    $f = $this->get_faculty();
    $p = $this->get_programme();
    $s = $this->get_state();
    
     
    return view('auth.register')->withF($f)->withP($p)->withS($s);

}
    public function register(Request $request)

    { 
        $login_user= session()->get('u_login_user');
          $input = $request->all();
          //dd($input);
        $validator = $this->validator($input);
 if ($validator->passes()) {

        if($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $filename = time() . '.' . $image->getClientOriginalExtension();
           $destinationPath = public_path('img/student');
            $img = Image::make($image->getRealPath());
            $img->resize(150, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
         $request->image_url = $filename;
          }
$pin = Pin::find($login_user);

 if($pin->status == 0)
 {
 
$reg = $this->create($input, $request->image_url)->toArray();
if($reg['id'] > 0)
{
 
 $pin->status = 1;
 $pin->student_id = $reg['id'];
 $pin->matric_number = $reg['matric_number'];
 $pin->student_type = self::Undergraduate;

 $pin->save();
 session()->forget('u_login_user');
 session()->flush();
   Session::flash('status','Registration successfull. Login and Registered  Your Courses'); 
    return redirect('login');
   }   

        }
    else
    {
         Session::flash('danger','Pin Allready Used');  
    }
}




        return back()->with('errors',$validator->errors());
    }



    //====================================predegre registration ========================================

    public function pdg_register()
    {
    $p = $this->get_pdg_programme();
    $s = $this->get_state();
    return view('auth.pdg_register')->withP($p)->withS($s); 
    }
//----------------------------------- post predree registeration --------------------------------------------------------
  public function post_pdg_register(Request $request)

    {
       
 $this->validate($request,array( 
    'surname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'othername' => 'required|string|max:255',
             'matric_number' => 'required|unique:mysql2.pdg_users',
            'phone' => 'required|string|max:255',
            'student_type' => 'required',
             'state_id' => 'required',
            'lga_id' => 'required',
            'entry_year' => 'required',
             'gender' => 'required',
            'marital_status' => 'required',
            'address' => 'required',
            'email' => 'required|string|email|max:100|unique:mysql2.pdg_users',));

  if($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $filename = time() . '.' . $image->getClientOriginalExtension();
           $destinationPath = public_path('img/pdg_student');
            $img = Image::make($image->getRealPath());
            $img->resize(150, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
         $request->image_url = $filename;
          }
$login_user= session()->get('pds_login_user');          
$pin = Pin::find($login_user);

 if($pin->status == 0)
 {
 

 $pdg = new PdgUser;
       $pdg->firstname = $request->input('firstname');
       $pdg->surname = $request->input('surname');
       $pdg->othername = $request->input('othername');
       $pdg->matric_number = $request->input('matric_number');
       $pdg->jamb_reg = $request->input('jamb_reg');
       $pdg->phone = $request->input('phone');
       $pdg->student_type = $request->input('student_type');
       $pdg->programme_id = 1;
       $pdg->entry_year = $request->input('entry_year');
       $pdg->state_id = $request->input('state_id');
       $pdg->lga_id = $request->input('lga_id');
       $pdg->gender = $request->input('gender');
       $pdg->marital_status = $request->input('marital_status');
       $pdg->email =  $request->input('email');
       $pdg->password = bcrypt($request->input('matric_number'));
       $pdg->nationality = $request->input('nationality');
       $pdg->address =  $request->input('address');
       $pdg->image_url = $request->image_url;
       $pdg->save();
   
if($pdg->id > 0)
{
 
 $pin->status = 1;
 $pin->student_id = $pdg->id;
 $pin->matric_number = $pdg->matric_number;
 $pin->student_type = self::PDS;

 $pin->save();

   Session::flash('success','successfull'); 
   session()->forget('pds_login_user');
    session()->flush();
    Session::flash('status','Registration successfull. Login and Registered  Your Courses'); 
    return redirect('login');
   }   

}else{
         Session::flash('danger','Pin Allready Used');  
    }     
return back();
    }  
    //   ==================================== custom function ============================================
private function get_faculty()
{
  
$sql =Faculty::get();
return $sql;
}
//----------------------------------------------------------------------------------------------------------
private function get_programme()
{
 // hide PDS 
$sql =Programme::where('id','!=',1)->get();
return $sql;
}

//----------------------------------------------------------------------------------------------------------
private function get_pdg_programme()
{
 // show PDS 
$sql =Programme::where('id',1)->get();
return $sql;
}
//------------------------------------------------------------------------------------------------------------
public function get_state()
{
$sql =State::get();
return $sql;
}
//---------------------------------------------------------------------------------------------------------
public function getdepartment($id)
{
$sql =Department::where('faculty_id',$id)->get();
return $sql;
}
//-------------------------------------------------------------------------------------------------------
public function getlga($id)
{
$sql =Lga::where('state_id',$id)->get();
return $sql;
}
//-------------------------------------------------------------------------------------------------------
public function getfos($id,$p_id)
{
$sql =Fos::where([['department_id',$id],['programme_id',$p_id]])->get();
return $sql;
}
}
