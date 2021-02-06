<?php

namespace App\Http\Controllers;

use App\Upload;
use App\Contestant;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
class ShowController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
   

    public function show(Request $request) 
    {  
        
        if($request->search == 'new'){
            $cat=Contestant::get('newCategory')->unique('newCategory');
            
        $contestants = Contestant::where('newCategory', $cat[0]->newCategory)->where('deleted_at', null)->paginate(8);
        return view('admin.show', ['contestants' => $contestants]);
        }else{
            $contestants = Contestant::where('newCategory', $request->search)->where('deleted_at', null)->paginate(8);
      
            return view('admin.show', ['contestants' => $contestants]);

        }
    }

    public function setClass(Request $request) 
    {
        $user = Auth::guard('admin')->user();
        $cat=Contestant::where('id', $request->set1)->update(['class' => $request->set,'selectedBy'=>$user->username]);
        // return back()->withInput()->with('error', _('Payment could not be confirmed.'));
        return back();   
    }
    
    
    public function deselectClass(Request $request)
    {
        $cat=Contestant::where('id', $request->set1)->update(['class' => 'None']);
        
        return back();
    }
    
    

    public function showSearch(Request $request)
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
    
    
    public function newcategory(Request $request)
    {
        
        if($request->search == 'new'){
            $cat=Contestant::get('newCategory')->unique('newCategory');
            
        $contestants = Contestant::where('newCategory', $cat[0]->newCategory)->where('status','Runner')->where('deleted_at', null)->paginate(8);
      
        return view('admin.newcategory', ['contestants' => $contestants]);
        }else{
            $contestants = Contestant::where('newCategory', $request->search)->where('status','Runner')->where('deleted_at', null)->paginate(8);
      
            return view('admin.newcategory', ['contestants' => $contestants]);

        }
    }
    
    
    public function setCat(Request $request)
    {
        $contestants = Contestant::where('id', $request->id)->update(['newCategory' =>$request->newCategory]);
        return back();
    }
    
    
    public function displayUpload(Request $request)
    {
        if($request->search == 'new'){
            $cat=Contestant::get('newCategory')->unique('newCategory');
            $owner = Contestant::where('newCategory', $cat[0]->newCategory)->get(['id']);
            dd($owner);
            $uploads = upload::whereIn('uploadedBy', [$owner])->where('to','upload')->where('deleted_at', null)->paginate(8);
            dd($uploads);
// $output = $investment
// ->getCollection()
// ->map(function($unit) {
      
//     $percent = Plan::query()->where('id',$unit->plan_id)->first();
//     return [
//         'id' => $unit->id,
//         'percentage' => $percent->percentage,
//         "name"=> $unit->name,
//         "plan_name"   =>   $unit->plan_name,
//         "type"   =>   $unit->type,
//         "amount" => $unit->amount,
//         "status"=> $unit->status,
//         "start_date"=> $unit->start_date,
//     ];
// })->toArray();

// $value = new \Illuminate\Pagination\LengthAwarePaginator(
// $output,
// $investment->total(),
// $investment->perPage(),
// $investment->currentPage(), [
//     'path' => \Request::url(),
//     'query' => [
//         'page' => $investment->currentPage()
//     ]
// ]
// );  

// return view('admin.export', ['investments' => $value]);



            
           $r=$cat[0]->newCategory;
            return view('admin.displayUpload', ['uploads' => $uploads, 'catt'=>$r]);
        }else{
            $contestants = Contestant::where('newCategory', $request->search)->where('status','Runner')->where('deleted_at', null)->paginate(8);
      
            return view('admin.displayUpload', ['contestants' => $contestants]);

        }
    }
    
    
    public function verifyUpload(Request $request)
    {
        
        $user = Auth::guard('admin')->user();
        $contestants = upload::where('id', $request->set)->update(['verified' =>'Yes','verified_by'=>$user->id]);
        return back();

        
    }
    
}


