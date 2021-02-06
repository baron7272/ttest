<?php

namespace App\Http\Controllers\Users\Auth;

use Auth;
use Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    //Only guest for admin guard are allowed except for logout
    public function __construct(){
        $this->middleware('guest:admin');
    }

    //show the reset email form
    public function showLinkRequestForm(){
        return view('auth.passwords.email', [
            'title' => 'Investor Password Reset',
            'passwordEmailRoute' => 'public.password.email',
        ]);
    }
}
