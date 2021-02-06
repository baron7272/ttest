<?php

namespace App\Http\Controllers\Users\Auth;

use App\Bank;
use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use App\Libraries\MailHandler;
use App\NextOfKin;
use App\Referral;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
   
        $countries = Country::all();
        $banks = Bank::all();
        $nextOfKin = NextOfKin::all();
        $agents = DB::table('users')->where('isAgent', 'True')->get();
        return view('auth.register', [
            'title' => 'Investor Registration',
            'registerRoute' => 'public.register', 'countries' => $countries, 'banks' => $banks, 'nextOfKin' => $nextOfKin, 'agents' => $agents,
        ]);
    }

    public function register(Request $request)
    { 
        try {
	        
	        $input = $request->all();
	
	        $this->validator($request);
	        
	        $option = [
	            'secret' => '6LcdFcMUAAAAAMD3YugPZdJD9bNmgYfo45s7Lpkj',
		    'response' => $input['g-recaptcha-response']
		];
		
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $option);
		
		$response = curl_exec($ch);
	    	$err = curl_error($ch);
	     	curl_close ($ch);
		
		$rs = json_decode($response, true);
		
		if($rs['success'] === false){
			return redirect()
		            ->route('public.register')
		            ->with('error', 'Invalid captcha or captcha has expired');
		}
	
		
		if($request->toogle){
		$u = $request->referred_by_code;
		$dude = DB::table('users')->where('referral_code',$request->referred_by_code)->first();
		}else{
		$u = $request->referred_by;
		 $dude = DB::table('users')->where('id', $request->referred_by)->first();
		 
		}
		
	
      
        if(!$dude ){
        
         return redirect()
	      ->route('public.register')
		->with('error', 'Invalid referral Code!');
        }
	$u=422;
	$referral_code = 'ref'.random_strings(9);
	
	$drop = DB::table('users')->where('referral_code', $referral_code)->first();
	if($drop !=NULL){
	return redirect()
	      ->route('public.register')
		->with('error', 'Login failed try again!');

                }
	        $name = $request->firstname . ' ' . $request->surname;
			$dob = $request->day.'-'.$request->month.'-'.$request->year;
						
			$ext= Country::where('name',$request->country)->first();

			$piks= User::where('account_number',$request->account_number)->orwhere('email',$request->email)->first();
			if($piks){
				return redirect()
				->route('public.register')
			  ->with('error', 'Registration failed, Details already exist!');
			}
	        $user = new User($request->merge(['reff'=>$u, 'referral_code'=>$referral_code,'name' => $name,'dob' => $dob,'password' => Hash::make($request->get('password')),'ext'=> $ext->extension])->all());
	        $user->save();
	
	        try {
	            $mail = (object) null;
	            $mail->template = 'email.verify';
	            $mail->from_email = env('SENDER_EMAIL');
	            $mail->from_name = env('APP_NAME');
	           $mail->to_email = $user->email;
	            $mail->to_name = $user->name;
	            $mail->subject = 'Verify Email Address';
	
	            $token = Hash::make($user->email);
	            $token = str_replace('/', '', str_replace('$', '', $token));
	
	            $user->email_verified_token = $token;
	            $user->save();
	
	            $mail->verify_url = env('WEB_URL') . '/email/verify/' . $user->id . '?token=' . $token;
	
	            $send = (new MailHandler())->sendMail($mail);
	
	           Log::debug('sent: ' . json_encode($send));
	        } catch (\Exception $e) {
	            Log::debug($e->getMessage());
	      }
	
	        return redirect()
	            ->route('public.login')
	            ->withInput()
	            ->with('status', 'Registration Successfull, A verification link has been sent to your email, please use it to verify your account');
        }
        catch(\Exception $e){
            Log::error('registration error: '.$e->getMessage());
          return redirect()
	      ->route('public.register')
		->with('error', 'Registration failed, try again!');
        }
    }

    private function validator(Request $request)
    {
        //validation rules
        $rules = [
            'firstname' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:users|min:11|max:90',
            'phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'bank_name' => 'required|string',
            'account_number' => 'required',
            'password' => 'required|string|min:4|max:255',
            'g-recaptcha-response' => 'required'
        ];

        $messages = [
            'email.unique' => 'Email already exist',
            'g-recaptcha-response.required' => 'you have to verify you are not a robot',
        ];

        //validate the request
        $request->validate($rules, $messages);
    }

    public function generate_referral_code($email)
    {
        $code = substr(str_shuffle(base64_encode($email)), 0, 5);
        $time = substr(md5(time()), 0, 2);
        return 'ref' . $code . $time;
    }
}


if (!function_exists('random_strings')) {
    /**
     * @param string $validator_errors
     *
     * @return string
     */
    function random_strings($length_of_string) 
{ 
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

    return substr(str_shuffle($str_result), 0, $length_of_string); 
}
  
}