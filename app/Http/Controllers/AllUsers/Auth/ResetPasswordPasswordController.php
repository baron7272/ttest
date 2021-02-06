<?php

namespace App\Http\Controllers\Users\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Hash;
use Log;
use App\Libraries\MailHandler;

class ResetPasswordPasswordController extends Controller
{
    
    
    //

    public function showforgetpass()
    {
        return view('auth.resetpassword', [
            'title' => 'Investor resetpassword',
            'resetpasswordRoute' => 'public.resetpassword',
        ]);;
    }

   

    public function resetpassword(Request $request)
    {
        if($check = User::where('email' ,$request->email)->first()){

        
	        try {
	            $mail = (object) null;
	            $mail->template = 'email.password';
	            $mail->from_email = env('SENDER_EMAIL');
	            $mail->from_name = env('APP_NAME');
	            $mail->to_email = $check->email;
	            $mail->to_name = $check->name;
	            $mail->subject = 'Reset Password';
	
	            $token = Hash::make($check->email);
	            $token = str_replace('/', '', str_replace('$', '', $token));
	
	          
                
                    $check->password_reset = $token;
                    $check->save();
                
	
                $mail->verify_url = env('WEB_URL') . '/resset/pin/' . $check->id . '?token=' . $token;
                
	     
	
	            $send = (new MailHandler())->sendMail($mail);
	
	            Log::debug('sent: ' . json_encode($send));
	        } catch (\Exception $e) {
	            Log::debug($e->getMessage());
            }
            
	
	        return redirect()
	            ->route('public.resetpassword')
	            ->withInput()
                ->with('status', 'A password reset link has been sent to your email');
          } else
          {
                return redirect()
	            ->route('public.resetpassword')
	            ->withInput()
	            ->with('error', 'Email does not exist');
            }
        }
      

        public function verify(Request $request)
        {
            
            $investor = User::where('id', $request->route('id'))->first();
            if ($request->input('token') == $investor->password_reset) {

                return view('auth.setpassword', [
                    'confirmpasswordRoute' => 'public.confirmpassword',
                    'id'=> $request->id,
                ])->with('status', 'Enter your new password!');
            }
            return redirect()
	            ->route('public.resetpassword')
	            ->withInput()
	            ->with('error', 'Enter email to reset password');
        }


        public function confirmpassword(Request $request)
        {
        
            User::where('id', $request->id)
          ->update(['password' => Hash::make($request->get('password')),'password_reset'=> 'Null']);

          return redirect()
          ->route('public.login')
          ->withInput()
          ->with('status', 'password reset successful, please login');

          
        }





}