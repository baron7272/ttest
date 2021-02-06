<?php

namespace App\Http\Controllers\Api\V1;

use App\Comment;
use App\Fan;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Stream;
use App\StreamCount;
use App\Upload;
use App\Vote;
use App\Wallet;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Log;

class HomeController extends Controller
{

    public function stream(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            
            
            $uploadDetails = Upload::where('id', $request->id)->first();
            $week = DB::table('admins')->first();

            if ($week->week == $uploadDetails->week) {

                $yes = Stream::where('streamed', $request->id)->where('streamedBy', $user->id)->first();

                if ($yes == null
//&& $user->contestId != $uploadDetails->uploadedBy
                ) {
                    $u = new Stream();
                    $u->streamedBy = $user->id;
                    $u->streamed = $uploadDetails->id;
                    $u->week = $uploadDetails->week;
                    $u->streamCount = 1;
                    $u->save();

                    $countD = Stream::where('streamed', $request->id)->where('streamedBy', $user->id)->get();
                    $wordCount = $countD->count();
                    if ($wordCount > 1) {
                        Stream::where('id', $countD->id)->delete();
                    }

                    return response()->json([
                        'success' => 'true',
                    ]);
                } else {
                    return response()->json([
                        'success' => 'true',
                    ]);
                }
            }return response()->json([
                'success' => 'true',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function reportOwner(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        $validator = Validator::make($request->all(), [
            'uploadId' => 'required',
            'mode'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        try {
         if($request->mode=='report'){
            $yes = Report::where('created_by', $user->id)->where('type',$request->mode)->where('uploadId',$request->uploadId)->first();
            if($yes){
            return response()->json([
                'success' => true,
            ], 200);
        }

            $getOwner = Upload::where('id',$request->uploadId)->first();
            
            $u = new Report();
            $u->ownerId = $getOwner->uploadedBy;
            $u->uploadId = $request->uploadId;
             $u->content = $request->content;
            $u->count =1;
            $u->type =$request->mode;
            $u->created_by =$user->id;
            $u->save();

            
             //////
             if($request->mode=='report'){
             $count = Report::where('type',$request->mode)->where('uploadId',$request->uploadId)->sum('count');
             
             if($count >5 ){
                 ///// please amil admin
             }
            }
             
             return response()->json([
                'success' => true,
            ], 200);
        
         }

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }




    public function getFullInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {

            $result = (object) null;
            $result->videos = Upload::where('uploadedBy', $request->id)->where('deleted_at', null)->get();

            $result->profile = DB::table('users')->where('id', $request->id)->first();

            $result->follower = Fan::where('following', $request->id)->where('deleted_at', null)->count();
            $result->following = Fan::where('follower', $request->id)->where('deleted_at', null)->count();
            $result->uploads = Upload::where('uploadedBy', $request->id)->where('deleted_at', null)->count();
            $check = Fan::where('follower', $user->id)->where('deleted_at', null)->first();

            if ($check) {
                $result->iAmFollowingHim = 'Yes';
            } else {
                $result->iAmFollowingHim = 'No';
            }

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function getUserInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {

            $value = [];
            $o1 = [];

            $all = DB::table('contestants')->where('id', $request->id)->first();

            $result = (object) null;
            $result->owners = DB::table('users')->where('contestId', $all->id)->get();

            $result->follower = Fan::where('following', $request->id)->where('type', 'Contestant')->count();
            $result->following = Fan::where('follower', $request->id)->where('type', 'Contestant')->count();
            $result->uploads = Upload::where('uploadedBy', $request->id)->where('deleted_at', null)->count();
            $check = Fan::where('follower', $user->id)->where('following', $request->id)->where('type', 'Contestant')->first();
            $result->video = Upload::where('uploadedBy', $request->id)->where('deleted_at', null)->get();

            //  $result->owners = $check;
            if ($check) {
                $result->iAmFollowingHim = 'Yes';
            } else {
                $result->iAmFollowingHim = 'No';
            }

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function getPrivateFollow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {

            $result = (object) null;

            $check = Fan::where('follower', $user->id)->where('type', 'Private')->first();
            if ($check) {
                $result->iAmFollowingHim = 'Yes';
            } else {
                $result->iAmFollowingHim = 'No';
            }
            $result->user = DB::table('users')->where('id', $request->id)->first();
            $result->follower = Fan::where('following', $request->id)->where('type', 'Private')->count();
            $result->following = Fan::where('follower', $request->id)->where('type', 'Private')->count();

            $check = Fan::where('follower', $user->id)->where('following', $request->id)->where('type', 'Private')->first();

            if ($check) {
                $result->iAmFollowingHim = 'Yes';
            } else {
                $result->iAmFollowingHim = 'No';
            }

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function followPrivate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {

            $result = (object) null;

            $u = new Fan();
            $u->follower = $user->id;
            $u->following = $request->id;
            $u->type = 'Private';
            $u->save();

            $result->follower = Fan::where('following', $request->id)->where('type', 'Private')->count();
            $result->following = Fan::where('follower', $request->id)->where('type', 'Private')->count();

            $check = Fan::where('follower', $user->id)->where('following', $request->id)->where('type', 'Private')->first();

            if ($check) {
                $result->iAmFollowingHim = 'Yes';
            } else {
                $result->iAmFollowingHim = 'No';
            }

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function follow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {

            $result = (object) null;

            $u = new Fan();
            $u->follower = $user->id;
            $u->following = $request->id;
            $u->type = 'Contestant';
            $u->save();

            $result->follower = Fan::where('following', $request->id)->where('type', 'Contestant')->count();
            $result->following = Fan::where('follower', $request->id)->where('type', 'Contestant')->count();

            $check = Fan::where('follower', $user->id)->where('following', $request->id)->where('type', 'Contestant')->first();

            if ($check) {
                $result->iAmFollowingHim = 'Yes';
            } else {
                $result->iAmFollowingHim = 'No';
            }

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function unFollowPrivate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $result = (object) null;
            Fan::where('follower', $user->id)->where('type', 'Private')->where('following', $request->id)->delete();
            $result->follower = Fan::where('following', $request->id)->where('type', 'Private')->count();
            $result->following = Fan::where('follower', $request->id)->where('type', 'Private')->count();

            $check = Fan::where('follower', $user->id)->where('following', $request->id)->where('type', 'Private')->first();

            if ($check) {
                $result->iAmFollowingHim = 'Yes';
            } else {
                $result->iAmFollowingHim = 'No';
            }

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function unFollow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $result = (object) null;
            Fan::where('follower', $user->id)->where('type', 'Contestant')->where('following', $request->id)->delete();
            $result->follower = Fan::where('following', $request->id)->where('type', 'Contestant')->count();
            $result->following = Fan::where('follower', $request->id)->where('type', 'Contestant')->count();

            $check = Fan::where('follower', $user->id)->where('following', $request->id)->where('type', 'Contestant')->first();

            if ($check) {
                $result->iAmFollowingHim = 'Yes';
            } else {
                $result->iAmFollowingHim = 'No';
            }

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function generalDetails()
    {

        $user = JWTAuth::parseToken()->toUser();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $result = (object) null;
               $result->paymentApk = DB::table('admin_accounts')->get();
               $result->commentCount = DB::table('notifications')->where('userId', $user->id)->where('readMessages', 'No')->count();
            $result->week = DB::table('admins')->first();
            return response()->json([
                'success' => true,
                'value' => $result,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error value' => $e, 'error' => 'server error, try again later or contact support'], 500);
        }

    }

    

    public function homeSelectedCategory()
    {
        $ca = Input::get('value', 'default value');
        $selectedCategory = Input::get('selectedCategory', false);

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $result = (object) null;
            $result->balance = DB::table('wallets')->where('userId', $user->id)->orderBy('id', 'desc')->whereNull('deleted_at')->first();

            $result->category = DB::table('contestants')->where('newCategory','!=',NULL)->select('newCategory', DB::raw('count(*) as total'))->groupBy('newCategory')->get();

            $contestant5 = DB::table('contestants')->where('newCategory', $selectedCategory)->where('newCategory','!=',NULL)->whereNull('deleted_at')->pluck('id');

            $upload = DB::table('uploads')->whereIn('uploadedBy', $contestant5)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(100);

            $result->week = DB::table('admins')->first();

            $aa = [];
            $v1 = [];
            $value = [];
            $OwnersInfo = [];
            foreach ($upload as $unit) {
                $votedBy = DB::table('votes')->where('voted', $unit->id)->where('votedBy', $user->id)->whereNull('deleted_at')->first();
                if ($votedBy) {
                    $voted = 'Yes';
                } else {
                    $voted = 'No';
                }

                $contestant = DB::table('contestants')->where('id', $unit->uploadedBy)->whereNull('deleted_at')->first();

                if ($contestant->type == 'Single') {
                    $type = 'Single';
                    $owners = DB::table('users')->where('id', $contestant->userIds)->whereNull('deleted_at')->first();
                    // $uploads = DB::table('uploads')->where('uploadedBy', $contestant->userIds)->whereNull('deleted_at')->orderByDesc('created_at')->get();
                    $OwnersInfo[] = $owners;

                } else {
                    $type = 'Group';
                    $bulk = str_replace("]", '', $contestant->usersIds);
                    $bulk = str_replace("[", '', $bulk);

                    $bulk2 = preg_split("/[,]/", $bulk);

                    $usr = str_replace("\"", '', $bulk2);
                    $usr = str_replace(" ", '', $usr);

                    foreach ($usr as $us) {

                        $check = DB::table('users')->where('username', $us)->where('contestId', $contestant->id)->first();
                        if ($check) {
                            $OwnersInfo[] = $check;
                        }
                    }
                }
                $o = (object) [
                    'category' => 'uploads',
                    'type' => $type,
                    'upload' => $unit,
                    "ownerInfo" => $OwnersInfo,

                    "contestantInfo" => $contestant,
                ];
                $value[] = $o;

            }

            $star = DB::table('contestants')->where('id', 151)->where('fanBaseName', '!=', '')->where('dpImage', '!=', '')->where('stageName', '!=', '')->first();
            $advert = DB::table('adverts')->first();

            $oo = (object) [
                'category' => 'star',
                'star' => $star,
                'advert' => $advert,
            ];

            $ooo = (object) [
                'category' => 'advert',
                'advert' => $advert,
            ];

            $count = 0;
            foreach ($value as $value1) {
                if ($count == 1) {
                    $aa[] = $value1;
                    $aa[] = $oo;

                } else if ($count == 3) {
                    $aa[] = $value1;
                    $aa[] = $ooo;
                } else {
                    $aa[] = $value1;
                }
                $count++;

            }
            //$result->list = $value;
            $result->list = $aa;

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error value' => $e, 'error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function homePage()
    {
        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {

                    
                    $result = (object) null;
                             $result->user = $user;
            $noBalance = DB::table('wallets')->where('userId', $user->id)->orderBy('id', 'desc')->whereNull('deleted_at')->first();
            if(!$noBalance){
                $u = new Wallet();
                $u->newBalance = '0';
                $u->oldBalance = '0';
                $u->amount = '0';
                $u->subtitle = 'New account';
                $u->userId = $user->id;
                $u->save();
            }
                             $result->balance = DB::table('wallets')->where('userId', $user->id)->orderBy('id', 'desc')->whereNull('deleted_at')->first();
            
                             $result->commentCount = DB::table('notifications')->where('userId', $user->id)->where('readMessages', 'No')->count();

                             $result->category = DB::table('contestants')->where('newCategory','!=',NULL)->select('newCategory', DB::raw('count(*) as total'))->groupBy('newCategory')->get();

                             $upload = DB::table('uploads')->where('to','Upload')->inRandomOrder()->whereNull('deleted_at')->orderBy('id', 'desc')->paginate(5000);
                             $counttt = DB::table('uploads')->whereNull('deleted_at')->orderBy('id', 'desc')->count();
                             $result->week = DB::table('admins')->first();

                             $aa = [];
                             $v1 = [];
                             $value = [];

                            foreach ($upload as $unit) {
                                $OwnersInfo = [];
                                $votedBy = DB::table('votes')->where('voted', $unit->id)->where('votedBy', $user->id)->whereNull('deleted_at')->first();
                                if ($votedBy) {
                                    $voted = 'Yes';
                                } else {
                                    $voted = 'No';
                                }
                                $contestant = DB::table('contestants')->where('id', $unit->uploadedBy)->whereNull('deleted_at')->first();

                                if ($contestant->type == 'Single') {
                                    $type = 'Single';
                                    $owners = DB::table('users')->where('id', $contestant->userIds)->whereNull('deleted_at')->first();
                                    $OwnersInfo[] = $owners;

                                } else {
                                    $type = 'Group';
                                    $usr = DB::table('users')->where('contestId', $contestant->id)->where('joined','Yes')->whereNull('deleted_at')->get();
                                    foreach ($usr as $us) {

                                     //    $check = DB::table('users')->where('username', $us)->where('contestId', $contestant->id)->first();
                                     //    if ($check) {
                                            $OwnersInfo[] = $us;
                                     //    }
                                    }

                                }
                                $o = (object) [
                                    'category' => 'uploads',
                                    'voted' => $voted,
                                    'type' => $type,
                                    'upload' => $unit,
                                    "ownerInfo" => $OwnersInfo,
                                    "contestantInfo" => $contestant,
                                ];
                                $value[] = $o;

                            }
                             $star = DB::table('contestants')->first();
                             //  $star = DB::table('contestants')->where('fanBaseName','!=','')->where('dpImage','!=','')->where('stageName','!=','')->get();
                             $advert = DB::table('adverts')->first();
                 //////please delete the two below it is for the intro
                               $va = DB::table('uploads')->where('to','Intro')->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(30);
                          
                      $counttt = DB::table('uploads')->where('to','Intro')->whereNull('deleted_at')->orderBy('id', 'desc')->count();

                             $oo = (object) [
                                 'category' => 'star',
                                 'star' => $star,
                                 'advert' => $advert,
                             ];

                             $ooo = (object) [
                                 'category' => 'advert',
                                 'advert' => $advert,
                             ];

                             foreach ($va as $vaa) {
                             $ooo11 = (object) [
                                     
                                     'image' => $vaa->contentImage,
                                      'videoUrl'=>$vaa->contentUrl,
                                 ];
                                 $ooo1 = (object) [
                                     'category' => 'intro',
                                     'intro' => $ooo11,
                                 ];
                                 $v1[] = $ooo1;
                             }
                            
                             $count = 0;
                             foreach ($value as $value1) {
                                 if ($count == 1) {
                                     $aa[] = $value1;
                                     $aa[] = $oo;

                                 } else if ($count == 3) {
                                     $aa[] = $value1;
                                     $aa[] = $ooo;
                                 } else {
                                     $aa[] = $value1;
                                 }
                                 $count++;

                             }
                            $result->list = $value;
                             // $result->list = $aa;
                             //    $result->list = $v1;

                             return response()->json([
                                 'pageCount' => $counttt,
                                 'success' => true,
                                 'value' => $result,

                             ]);
                

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error value' => $e, 'error' => 'server error, try again later or contact support'], 500);
        }
    }
    
    
    public function homeSearch()
    {
        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $category = Input::get('value', 'default value');
            $search = Input::get('search', false);
            $upload ='';
        $counttt='';
           // if($search[0] == '@'){
                if($search != null){
                
                //$h = ltrim ($search,'@');
                $info = DB::table('users')->where('username',$search)->whereIn('status',['Evicted','Winner','Accepted'])->first();
               
                if($info!= null){
                
                $detail = DB::table('contestants')->where('id',$info->contestId)->first();
         
                $upload = DB::table('uploads')->where('uploadedBy',$detail->id)->where('to','Upload')->whereNull('deleted_at')->orderBy('id', 'desc')->paginate(5);
                $counttt = DB::table('uploads')->where('uploadedBy',$detail->id)->whereNull('deleted_at')->orderBy('id', 'desc')->count();
}
            }


            $result = (object) null;
          //  $result->user = $user;

//            $upload = DB::table('uploads')->where('to','Upload')->whereNull('deleted_at')->orderBy('id', 'desc')->paginate(5);
//
//            $counttt = DB::table('uploads')->whereNull('deleted_at')->orderBy('id', 'desc')->count();
            $result->week = DB::table('admins')->first();

            $aa = [];
            $v1 = [];
            $value = [];
           if($upload!= null){
           foreach ($upload as $unit) {
               $OwnersInfo = [];
               $votedBy = DB::table('votes')->where('voted', $unit->id)->where('votedBy', $user->id)->whereNull('deleted_at')->first();
               if ($votedBy) {
                   $voted = 'Yes';
               } else {
                   $voted = 'No';
               }
               $contestant = DB::table('contestants')->where('id', $unit->uploadedBy)->whereNull('deleted_at')->first();
               
               if ($contestant->type == 'Single') {
                   $type = 'Single';
                   $owners = DB::table('users')->where('id', $contestant->userIds)->whereNull('deleted_at')->first();
                   $OwnersInfo[] = $owners;

               } else {
                   $type = 'Group';
                   $bulk = str_replace("]", '', $contestant->usersIds);
                   $bulk = str_replace("[", '', $bulk);

                   $bulk2 = preg_split("/[,]/", $bulk);

                   $usr = str_replace("\"", '', $bulk2);
                   $usr = str_replace(" ", '', $usr);

                   foreach ($usr as $us) {

                       $check = DB::table('users')->where('username', $us)->where('contestId', $contestant->id)->first();
                       if ($check) {
                           $OwnersInfo[] = $check;
                       }
                   }
                   
               }
               
               $o = (object) [
                   'category' => 'uploads',
                   'voted' => $voted,
                   'type' => $type,
                   'upload' => $unit,
                   "ownerInfo" => $OwnersInfo,
                   "contestantInfo" => $contestant,
               ];
               $value[] = $o;
           }

            $star = DB::table('contestants')->first();
            //  $star = DB::table('contestants')->where('fanBaseName','!=','')->where('dpImage','!=','')->where('stageName','!=','')->get();
            $advert = DB::table('adverts')->first();

            $oo = (object) [
                'category' => 'star',
                'star' => $star,
                'advert' => $advert,
            ];
            $ooo = (object) [
                'category' => 'advert',
                'advert' => $advert,
            ];

            $count = 0;
            foreach ($value as $value1) {
                if ($count == 1) {
                    $aa[] = $value1;
                    $aa[] = $oo;

                } else if ($count == 3) {
                    $aa[] = $value1;
                    $aa[] = $ooo;
                } else {
                    $aa[] = $value1;
                }
                $count++;
            }
           
             $result->list = $aa;
        }else{
            $result->list = [];
        }
            return response()->json([
                'pageCount' => $counttt,
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error value' => $e, 'error' => 'server error, try again later or contact support'], 500);
        }
    }

    
    
    public function getUsers1(Request $request)
    {
       try {
            $user = JWTAuth::parseToken()->toUser();
            if (!$user) {
                return response()->json([
                    'error' => 'You are not authorized to access this content',
                ]);
            }
        
            if ($request->search != null) {
                $userss = DB::table('users')->where('firstname','LIKE', '%'.$request->search.'%')->orWhere('lastname','LIKE', '%'.$request->search.'%')->where('verifiedAt', '!=', null)->get(['id', 'username', 'firstname', 'lastname', 'imageUrl']);
            }

            return response()->json([
                'success' => true,
                'value' => $userss,
            ]);

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }
    }
    
    
    public function searching()
    {
        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $result = (object) null;

            $upload = Upload::where('category', $request->categoryId)->get();

            $value = [];
            foreach ($upload as $unit) {
                $comment = Comment::where('uploadId', $unit->id)->where('deletedAt', ' ')->get();

                if ($comment) {
                    $o = (object) [
                        'upload' => $upload,
                        "comment" => $coment,
                    ];
                    $value[] = $o;
                } else {
                    $o = (object) [
                        'upload' => $upload,
                    ];
                    $value[] = $o;
                }
            }
            $result->list = $value;

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function getComment()
    {
        $category = Input::get('value', 'default value');
        $up = Input::get('uploadId', false);

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $comm = [];

            $co = DB::table('comments')->where('uploadId', $up)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(100000);

            if (!$co->isEmpty()) {

                foreach ($co as $comments) {

                    $info = DB::table('users')->where('id', $comments->commentedBy)->first();

                    $ddd = (object) [
                        'id' => $comments->id,
                        'content' => $comments->content,
                        'uploadId' => $comments->commented,
                        'created_at' => $comments->created_at,
                        'commentedBy' => $info->username,
                        'userId' => $info->id,
                        'image' => $info->imageUrl,
                    ];

                    $comm[] = $ddd;
                }

                return response()->json([
                    'success' => true,
                    'value' => $comm,
                ]);
            }
            return response()->json([
                'success' => true,
                'value' => $comm,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function createComment(Request $request)
    {
        $category = Input::get('value', 'default value');
        $up = Input::get('uploadId', false);
        $content = Input::get('content', false);

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $u = new Comment();
            $u->commentedBy = $user->id;
            $u->uploadId = $up;
            $u->content = $content;
            $u->save();

            $comm = [];

            $co = DB::table('comments')->where('uploadId', $up)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(5);

            if (!$co->isEmpty()) {

                foreach ($co as $comments) {

                    $info = DB::table('users')->where('id', $comments->commentedBy)->first();

                    $ddd = (object) [
                        'id' => $comments->id,
                        'content' => $comments->content,
                        'uploadId' => $comments->commented,
                        'created_at' => $comments->created_at,
                        'commentedBy' => $info->username,
                        'userId' => $info->id,
                        'image' => $info->imageUrl,
                    ];

                    $comm[] = $ddd;
                }

                return response()->json([
                    'success' => true,
                    'value' => $comm,
                ]);
            }
            return response()->json([
                'success' => true,
                'value' => $comm,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function voting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'counting' => 'required',
            'upload' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {
            $uploadDetails = Upload::where('id', $request->upload)->first();

            $result = (object) null;
            // $currency = $user->country == 'Nigeria' ? 'Naira' : 'Dollar';

            $myTransaction = Wallet::where('userId', $user->id)->orderBy('id', 'desc')->first();

            // if ($user->type == 'Dollar') {

            //     $number = $myTransaction->newBalance / 30;

            //     if ($number >= $request->counting) {

            //         $a = $number - $request->counting;

            //         if ($a > 1) {
            //             $balance = $a / 30;
            //         } else {
            //             $balance = 0;}

            //         $paid = $request->counting / 30;

            //         $u = new Wallet();
            //         $u->userId = $user->id;
            //         $u->source = 'Debit';
            //         $u->subtitle = 'Vote';
            //         $u->amount = $paid;
            //         $u->type = 'Dollar';
            //         $u->oldBalance = $myTransaction->newBalance;
            //         $u->newBalance = $balance;
            //         $u->save();

            //         $uuau = new Notification();
            //         $uuau->model = 'Single';
            //         $uuau->title = 'Notice';
            //         $uuau->content = 'USD' . '$paid' . ' ' . 'to your favorite contestant.';
            //         $uuau->type = 'Text';
            //         $uuau->save();

            //         $uu = new Vote();
            //         $uu->votedBy = $user->id;
            //         $uu->voteCount = $request->counting;
            //         $uu->week = $uploadDetails->week;
            //         $uu->vote = $uploadDetails->vote;
            //         $uu->save();

            //         return response()->json([
            //             'success' => true,
            //             'balance' => $u,
            //             'message' => 'Voting was succesfull',
            //         ]);

            //     }
            //     return response()->json([
            //         'success' => false,
            //         'error' => 'You have an insuficient fund',
            //     ]);
            // }

            $number = $myTransaction->newBalance ;

            if ($number >= $request->counting) {

                $a = $number - $request->counting;

                if ($a > 1) {
                    $balance = $a ;
                } else {
                    $balance = 0;}

                $paid = $request->counting;

                $u = new Wallet();
                $u->userId = $user->id;
                $u->source = 'Debit';
                $u->subtitle = 'Vote';
                $u->amount = $paid;
                // $u->type = 'Naira';
                $u->oldBalance = $myTransaction->newBalance;
                $u->newBalance = $balance;
                $u->save();

                $uuau = new Notification();
                $uuau->model = 'Single';
                $uuau->title = 'Notice';
                $uuau->content =  $paid . ' ' . 'votes to your favorite contestant.';
                $uuau->type = 'Text';
                $uuau->save();

                $uu = new Vote();
                $uu->votedBy = $user->id;
                $uu->voteCount = $request->counting;
                $uu->week = $uploadDetails->week;
                $uu->voted = $uploadDetails->id;
                $uu->save();

                return response()->json([
                    'success' => false,
                    'balance' => $u,
                    'message' => 'Voting was succesfull',
                    'error' => 'it has error',
                ]);

            }
            return response()->json([
                'success' => false,
                'error' => 'You have an insuficient fund',
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }
}

