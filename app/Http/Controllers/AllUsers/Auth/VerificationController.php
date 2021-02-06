<?php

namespace App\Http\Controllers\Users\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
     */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';
    // protected $redirectTo = "investor.register";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:investor');
        // $this->middleware('signed')->only('verify');
        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $investor = User::where('id', $request->route('id'))->first();

        if ($investor && ($investor->email_verified_at != null || $investor->email_verified_at != '')) {
            return redirect()
                ->route('public.login')
                ->with('error', 'Email has already been verified!');
        }

        if ($request->input('token') == $investor->email_verified_token) {

            $investor->email_verified_token = null;
            $investor->email_verified_at = date('Y-m-d H:i:s');
            $investor->save();

            Auth::guard('public')->login($investor);

            $request->session()->regenerate();

            return redirect()
                ->route('public.home')
                ->with('status', 'Your email address has beeen verified successfully!');
        }

        return redirect()
            ->route('public.login')
            ->with('error', 'Invalid token');
    }
}