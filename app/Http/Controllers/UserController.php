<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index');
    }

    public function table(User $model) 
    {  
        return view('admin.table', ['users' => $model->paginate(8)]);
    }


    public function tableSearch(Request $request)
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
                $userss= User::where('firstname', 'LIKE', '%'.$firstname.'%')->orderBy('id', 'desc')->paginate(8);
            
            if(count($userss)){
             return view('admin.table', ['users' => $userss]);
            }else{
            return back()->withInput()->with('error', _('No Information found.'));  
            } 
            }else{
            $userss = User::where('lastname', 'LIKE', '%'.$lastname.'%')->where('firstname', 'LIKE', '%'.$firstname.'%')->where('seen','yes')->orderBy('id', 'desc')->paginate(8);
            
            if(count($userss)){
                return view('admin.table', ['users' => $userss]);
            }else{
            return back()->withInput()->with('error', _('No Information found.'));  
            } 
        }
	    }else{
	    $userss = User::where('email',$request->search)->paginate(8);
	    if(count($userss)){
        // $email = User::where('user_id', $check_email[0]->id)->where('seen','yes')->orderBy('id', 'desc')->paginate(1000);
	    return view('admin.table', ['users' => $userss]);
	    }else{
	    return back()->withInput()->with('error', _('No Information found.'));  
        } 
    }
    
}
}
