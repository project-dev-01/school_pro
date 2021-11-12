<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

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

    public function forgotpassword() {
        return view('auth.passwords.email');
    }

    public function resetpassword(Request $request){

        // dd($request);
        $request->validate(['email' => 'required|email'],[
            'email' => 'Email ID requied to reset your password'
        ]);
       
        $user = User::where('email', '=', $request->email)->first();
        // dd($user);
        if($user === null){
            return redirect()->back()->with('error','Email id does not exist');
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return redirect()->back()->with('success','A reset link has been sent to your email address.');
            // echo $link;
            
        } else {
            return redirect()->back()->with('error','A Network Error occurred. Please try again.');
        }
        
    }

    private function sendResetEmail($email, $token){
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('name','email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = url('password/reset').'/'.$token;
        // return true;
        // dd($link);
        if($email){
         $data = array('link'=>$link,'name'=> $user->name,); 
         
         Mail::send('auth.mail', $data, function($message) use($email) {
         $message->to($email, 'members')->subject
             ('Password Reset');
         $message->from('rajesh@aibots.my',' School');
         });  
         return true;
        }else{
            return false;
        }
    }
}
