<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function password_reset()
    {
        return view('auth.passwords.email');
    }

    public function post_password_reset(Request $request)
    {
    $this->validate($request, ['matric_number' => 'required',]);
    $u = User::where('matric_number',$request->input('matric_number'))->first();

    if ($u != null)
    {
        $check =DB::table('password_resets')->where('email',$request->matric_number)->first();
        
        if($check != null)
        {
    DB::table('password_resets')->where('email',$request->matric_number)->delete();

        }
        $token = str_random(64);
         $email =strtolower($u->email);
        if($email != null){
            $new =DB::table('password_resets')->insert(['email' => $request->matric_number, 'token' => $token]);

         $data = array('email' => $email,'token' => $token);

  Mail::send(array('html'=>'emails.recovery_pin'), $data, function($message) use ($data)  {
                
                $message->to($data['email'],$data['token']);
                $message->subject("Reset Your Password");

            });
}else
{
    Session::flash('warning',"your have no email on your account. contact system admistrator");
    return back(); 
}
Session::flash('success',"Check your email .For reset link.");
      return view('auth.passwords.email');

    }else
    {
       Session::flash('warning',"please check your Matric Number.");
            return back(); 
    }


}
public function password_reset_token(Request $request, $token)
{
    if(isset($token))
    {
$check = DB::table('password_resets')->where('token',$token)->first();
if($check != null)
{
   return view('auth.passwords.reset')->withU($check); 
}else
{
    Session::flash('warning',"Please the link has expired. please enter your Matric Number to reset again ");
      return view('auth.passwords.reset');
}

}
}

public function post_password_reset_token(Request $request)
{
    $this->validate($request, ['password' => 'required|string|min:6|confirmed',]);
  $user = User::where('matric_number',$request->matric_number)->first();
  $user->password =bcrypt($request->password);
  $user->save();
   DB::table('password_resets')->where('email',$request->matric_number)->delete();
    Session::flash('success',"password change successfully.");

   return redirect('/'); 
}
}
