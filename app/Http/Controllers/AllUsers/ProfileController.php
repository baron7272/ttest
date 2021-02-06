<?php

namespace App\Http\Controllers\AllUsers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\User;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    
    public function edit()
    {
        return view('Investors.edit');
    }

    
    public function displayProfile()
    {
    $d=auth()->user();
    $ref = User::where('id',$d->reff)->first();  
    $o = (object) [
        "id" => $d->id,
        "name" => $d->name,
        "role" => $d->role,
        "dob" => $d->dob,
        "email" =>$d->email,
        "phone" => $d->phone,
        "country" => $d->country,
        "state" =>$d->state,
        "bank_name" =>$d->bank_name,
        "account_number" => $d->account_number,
        "dollarAccount" => $d->dollarAccount,
        "dollarBank" =>$d->dollarBank,
        "referral_code" => $d->referral_code,
        "reff" => $ref->name,
        "kin_name" => $d->kin_name,
        "kin_phone" => $d->kin_phone  ,
        "kin_relationship" => $d->kin_relationship ,
        "isAgent" =>$d->isAgent ,
        "maxAmount" => $d->maxAmount ,
        "add_date" => $d->add_date  ,
    ];
         return view('Investors.userprofile', ['user' => $o]);
    }

  
    

    public function update(Request $request)
    {    $f=auth()->user();
        $check1 = User::where('account_number',$request->account_number)->where('id','!=',$f->id)->get(); 
        $check2 = User::where('dollarAccount',$request->dollarAccount)->where('id','!=',$f->id)->get(); 
        if($request->account_number != $f->account_number && count($check1)!=0 ||$request->dollarAccount != $f->dollarAccount && count($check2)!=0  )
        {
            return back()->withPasswordsError(_('Password incorrect.'));  
        }
        auth()->user()->update($request->all());
        return back()->withStatus(__('Profile successfully updated.'));
    }

    
    public function password(Request $request)
    {
         if( Hash::check($request->get('old_password'), auth()->user()->password)) 
            {
            auth()->user()->update(['password' => Hash::make($request->get('password'))]);
    
            return back()->withPasswordStatus(__('Password successfully updated.'));
            }else{
                  return back()->withPasswordError(_('Password incorrect.'));  
            }
        
    }
}
