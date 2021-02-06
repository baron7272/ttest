<?php

namespace App\Http\Controllers\AllUsers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Log;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public function __construct()
    {
        $this->middleware('guest:public')->except('logout');
    }

    public function username()
    {
        return 'email';
    }

    //Max login attempt allowed
    public $maxAttempts = 5;

    //Number of minutes to lock the login
    public $decayMinutes = 3;

    public function showLoginForm()
    {
        /// not coming to this spot
        // return 'Investor login ';
        return view('allUser.auth.login', [
            'title' => 'User Login',
            'loginRoute' => 'public.login',
        ]);
    }

    public function login(Request $request)
    {
        $this->validator($request);

        //check if the user has too many login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            //fire the lockout event
            $this->fireLockOutEvent($request);
            //redirect the user back after lockout.
            return $this->sendLockoutResponse($request);
        }
        //attempt login
        if (Auth::guard('public')->attempt($request->only('email', 'password'))) {
            //Authentication passed.. then authenticated
            
            $user = Auth::guard('public')->user();
            if($user->email_verified_at == '' || $user->role != 'User' ){
            	Auth::guard('public')->logout();
	       	return redirect()
	            ->route('public.login')
	            ->with('error', 'You are not authorized to access this portal, You have not verified your account, check your email to verify your account!');
            }    
            $request->session()->regenerate();
            return redirect()
                ->route('public.home')
                ->with('status', 'You Are Logged in As Investor');
        }
        //keep track of login attempts from the user.
        $this->incrementLoginAttempts($request);
        //Authentication Failed..
        return $this->loginFailed();
    }

    public function logout(Request $request)
    {
        Auth::guard('public')->logout();

        $request->session()->invalidate();
        
        return redirect()
            ->route('public.login')
            ->with('status', 'Investor has been logged out !');
    }

    private function validator(Request $request)
    {
        //validation rules
        $rules = [
            'email' => 'required|email|exists:users|min:5|max:191',
            'password' => 'required | string | min:4 | max:255',
        ];

        //custom validation error messages
        $messages = [
            'email.exists' => 'Invalid email or password',
        ];

        //validate the request
        $request->validate($rules, $messages);
    }

    private function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Login Failed, Try Again !');
    }
}