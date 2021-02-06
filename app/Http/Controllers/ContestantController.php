<?php

namespace App\Http\Controllers;

use App\Contestant;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class ContestantController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
  

    public function contestant(Request $request) 
    {  
        $contestants = Contestant::where('deleted_at', null)->paginate(8);
      
        return view('admin.contestant', ['contestants' => $contestants]);
    }

    public function contestantSearch(Request $request)
    {
    $findme   = '@';
    $findagain   = '.';
    $pos = strpos( $request->search, $findme);
    $posagain = strpos( $request->search, $findagain);
    if ($pos == false && $posagain ==false) {
    $split = explode(" ", $request->search);
            $firstname = array_shift($split);
            $lastname  = implode(" ", $split);

            if(!$lastname){
                $invv = Investment::where('name', 'LIKE', '%'.$lastname.'%')->orderBy('id', 'desc')->get();
            $inv = Investment::where('name', 'LIKE', '%'.$firstname.'%')->orderBy('id', 'desc')->paginate(1000);
        
            if(count($invv)){
             return view('admin.investment', ['investments' => $inv]);
            }else{
            return back()->withInput()->with('error', _('No Information found.'));  
            } 
            }else{
            $invv = Investment::where('name', $request->search)->where('seen','yes')->orderBy('id', 'desc')->get();
            $inv = Investment::where('name', $request->search)->where('seen','yes')->orderBy('id', 'desc')->paginate(1000);
            
            if(count($invv)){
             return view('admin.investment', ['investments' => $inv]);
            }else{
            return back()->withInput()->with('error', _('No Information found.'));  
            } 
        }
	    }else{
	    $check_email = User::where('email',$request->search)->get();
	    if(count($check_email)){
        $email = Investment::where('user_id', $check_email[0]->id)->where('seen','yes')->orderBy('id', 'desc')->paginate(1000);
	    return view('admin.investment', ['investments' => $email]);
	    }else{
	    return back()->withInput()->with('error', _('No Information found.'));  
        } 
    }
    
}
}
