<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

use App\Faculty;
use App\Programme;
use App\Department;
use App\State;
use App\Lga;
use App\Fos;
use App\Pin;
class NewRegisterController extends Controller
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
   // $this->middleware('guest');
    $this->middleware('checkNewRegLogin', ['only' => ['showRegistrationForm']]);
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
        if(session()->get('currentSession') != null)
        {
            $password = $data['password'];
        }else{
            $password = $data['matric_number'];
        }
 
        
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
            'password' => bcrypt($password),
            'nationality' => $data['nationality'],
            'address' => $data['address'],
            'image_url' => $img,
        ]);
    }
public function showRegistrationForm($id)
{
   $f = $this->get_faculty();
    $p = $this->get_programme();
    $u =User::find($id);
    return view('auth.newregister')->withF($f)->withP($p)->withu($u);

}
    public function register(Request $request)

    { 
    
          
    session()->put('student_type',2);
   session()->put('student_status',1);
          $input = $request->all();
          $entryYear =$request->entry_year;
        $validator = $this->validator($input);
 if ($validator->passes()) {

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
         $request->image_url = $filename;
          }
 if(session()->get('currentSession') != null)
 {
$reg = $this->create($input, $request->image_url)->toArray();
$password = $input['password'];  
 }
session()->put('session_year',$entryYear);
if (auth()->attempt(array('matric_number' => $reg['matric_number'], 'password' =>$password)))
   return redirect()->intended('/profile'); 
}

 return back()->with('errors',$validator->errors());
    }


 
    //   ==================================== custom function ============================================
private function get_faculty()
{
  
$sql =Faculty::orderBy('faculty_name','ASC')->get();
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
$sql =State::orderBy('state_name','ASC')->get();
return $sql;
}
//---------------------------------------------------------------------------------------------------------
public function getdepartment($id)
{
$sql =Department::where('faculty_id',$id)->orderBy('department_name','ASC')->get();
return $sql;
}
//-------------------------------------------------------------------------------------------------------
public function getlga($id)
{
$sql =Lga::where('state_id',$id)->orderBy('lga_name','ASC')->get();
return $sql;
}
//-------------------------------------------------------------------------------------------------------
public function getfos($id,$p_id)
{
$sql =Fos::where([['department_id',$id],['programme_id',$p_id]])->orderBy('fos_name','ASC')->get();
return $sql;
}
}
