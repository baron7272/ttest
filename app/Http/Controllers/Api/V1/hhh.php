<?php

namespace App\Http\Controllers\Api\V1;

use App\Contestant;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Upload;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Image;
use JWTAuth;
use Log;
//use Illuminate\Support\Facades\Log;

 

class ExploreController extends Controller
{
    
    public function trigger(Request $request)
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
            'trigger' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => $error], 422);
        }
        $c1 = DB::table('users')->where('id', $user->id)->update(['live'=>$request->trigger]);

        return response()->json([
            'success' => true,
            'value' => $c1,
        ]);
    }
    
    
    
    public function allContestants(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        $c1 = DB::table('users')->where('joined', 'Yes')->whereNull('deleted_at')->get();

        return response()->json([
            'success' => true,
            'value' => $c1,
        ]);
    }
    
    public function allUsers(Request $request)
    {

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        $c1 = DB::table('users')->where('joined', 'No')->whereNull('deleted_at')->get();

        return response()->json([
            'success' => true,
            'value' => $c1,
        ]);
    }
    

    public function sponsor(Request $request)
    {

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        $c1 = DB::table('sponsors')->where('show', 'Yes')->whereNull('deleted_at')->get();

        return response()->json([
            'success' => true,
            'value' => $c1,
        ]);
    }

    public function makeMyUploads1(Request $request)
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
            $validator = Validator::make($request->all(), [
                'videoUrl' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:16640|required',
            ]);

            if ($validator->fails()) {
                $error = validatorMessage($validator->errors());
                return response()->json(['error' => 'Video size should not be more 15360kb'], 422);
            }

            if ($request->hasFile('videoUrl')) {

                $filenameWithExt = $request->file('videoUrl')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('videoUrl')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $destinationPath = public_path('video');
                $path = $request->file('videoUrl')->move($destinationPath, $fileNameToStore);

                if ($path) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Application is been reviewed',
                        'value' => $fileNameToStore,
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Upload Failed',
                ]);
            } else {

                return response()->json([
                    'success' => false,
                    'message' => 'Upload Failed',
                ]);

            }

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function makeMyUploads2(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'videoUrl' => 'required',
            'video' => 'required',

        ]);

        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => $error], 422);
        }

        try {

            $user = JWTAuth::parseToken()->toUser();
            if (!$user) {
                return response()->json([
                    'error' => 'You are not authorized to access this content',
                ]);
            }

            $contestant = DB::table('contestants')->where('id', $user->contestId)->whereNull('deleted_at')->first();
            $week = DB::table('admins')->first();

            if ($user->status == 'Accepted') {

                $imageMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/bmp', 'video/mp4', 'image/JPG'];

                $_filepath = public_path('user-images');

                $file = $request->file('image');
                $filename = 'Img' . now() . $user->username . $file->getClientOriginalExtension();

                $upload = $file->move($_filepath, $filename);

                $upload_path = $_filepath . '/' . $filename;
                if (file_exists($upload_path)) {
                    $image_filesize = filesize($upload_path);

                    $contentType = mime_content_type($upload_path);
                    if (in_array($contentType, $imageMimeTypes)) {
                        ini_set('memory_limit', '256M');

                        $artwork = Image::make($upload_path);
                        $ext = $artwork->extension;
                        $thumbnail = $artwork->filename . '640xAny.' . $ext;

                        $artwork->resize(640, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $thumbnail_path = $_filepath . '/' . $thumbnail;
                        $artwork->save($thumbnail_path)->destroy();

                        if (file_exists($thumbnail_path)) {
                            $imageUrl = basename($thumbnail_path);
                        }}}

                $u = new Upload();
                $u->type = 'Video';
                $u->contentUrl = $request->videoUrl;
                $u->contentImage = $imageUrl;
                $u->uploadedFrom = $user->username;
                $u->week = $week->week;
                $u->uploadedBy = $user->contestId;
                $u->uploadedAt = now();
                $u->video = $request->video;
                $u->from = $contestant->type;
                $u->save();

                if ($u) {

                    $uploadss = Upload::where('uploadedBy', $contestant->id)->whereNull('deleted_at')->select('week', DB::raw('count(*) as total'))->groupBy('week')->get();

                    $value = [];
                    $ii = 1;
                    foreach ($uploadss as $ay) {
                        $ii++;
                        $ab = Upload::where('uploadedBy', $contestant->id)->where('week', $ay->week)->whereNull('deleted_at')->get();
                        $firstL = [];
                        $secondL = [];
                        $taskL = [];

                        foreach ($ab as $a) {

                            if ($a->video == 'First') {
                                $first = 'Yes';
                                $firstL[] = $first;
                            }

                            if ($a->video == 'Second') {
                                $second = 'Yes';
                                $secondL[] = $second;
                            }

                            if ($a->video == 'Task') {
                                $task = 'Yes';
                                $taskL[] = $task;
                            }
                        }
                        $no = 'No';
                        $fvf = (object) [
                            'totalVotes' => 'none',
                            'week' => $a->week,
                            'first' => $firstL ? $firstL[0] : $no,
                            'second' => $secondL ? $secondL[0] : $no,
                            'task' => $taskL ? $taskL[0] : $no,
                        ];
                        $value[] = $fvf;
                    }

                    for ($i = 0; $i < 14 - $ii; $i++) {

                        $fvf = (object) [
                            'totalVotes' => 'none',
                            'week' => 'No',
                            'first' => 'No',
                            'second' => 'No',
                            'task' => 'No',
                        ];
                        $value[] = $fvf;
                    }

                    return response()->json([
                        'success' => true,
                        'value' => $value,

                        'message' => 'Upload was successfull',
                    ]);

                }

                return response()->json([
                    'success' => false,
                    'error' => 'Upload failed !',
                ]);
            }
            return response()->json([
                'success' => false,
                'error' => 'Failed please contact support!',
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function getMyUploads(Request $request)
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

            $contestant = DB::table('contestants')->where('id', $user->contestId)->whereNull('deleted_at')->first();
            if ($user->status != 'Accepted') {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed please contact support!',
                ]);
            }

            $uploadss = Upload::where('uploadedBy', $user->contestId)->whereNull('deleted_at')->select('week', DB::raw('count(*) as total'))->groupBy('week')->get();

            $value = [];

            if ($uploadss->isEmpty()) {

                for ($i = 0; $i < 14; $i++) {

                    $fvf = (object) [
                        'totalVotes' => 'none',
                        'week' => 'No',
                        'first' => 'No',
                        'second' => 'No',
                        'task' => 'No',
                    ];
                    $value[] = $fvf;
                }

                return response()->json([
                    'success' => true,
                    'value' => $value, 'contestant' => $contestant,
                ]);
            } else {

                $ii = 1;
                foreach ($uploadss as $ay) {
                    $ii++;
                    $ab = Upload::where('uploadedBy', $user->contestId)->where('week', $ay->week)->whereNull('deleted_at')->get();
                    $firstL = [];
                    $secondL = [];
                    $taskL = [];

                    foreach ($ab as $a) {

                        if ($a->video == 'First') {
                            $first = 'Yes';
                            $firstL[] = $first;
                        }

                        if ($a->video == 'Second') {
                            $second = 'Yes';
                            $secondL[] = $second;
                        }

                        if ($a->video == 'Task') {
                            $task = 'Yes';
                            $taskL[] = $task;
                        }
                    }
                    $no = 'No';
                    $fvf = (object) [
                        'totalVotes' => 'none',
                        'week' => $a->week,
                        'first' => $firstL ? $firstL[0] : $no,
                        'second' => $secondL ? $secondL[0] : $no,
                        'task' => $taskL ? $taskL[0] : $no,
                    ];
                    $value[] = $fvf;
                }
                for ($i = 0; $i < 14 - $ii; $i++) {

                    $fvf = (object) [
                        'totalVotes' => 'none',
                        'week' => 'No',
                        'first' => 'No',
                        'second' => 'No',
                        'task' => 'No',
                    ];
                    $value[] = $fvf;
                }

                return response()->json([
                    'success' => true,
                    'value' => $value, 'contestant' => $contestant,
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function getCategory()
    {
        try {
            $ca = Input::get('value', 'default value');
            $categoryAll = Input::get('newCategory', false);

            $user = JWTAuth::parseToken()->toUser();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'You are not authorized to access this content',
                    'message' => 'logOut',
                ]);
            }
               $all = [];
            $co = DB::table('contestants')->where('newCategory', $categoryAll)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(15);

                   foreach ($co as $d){
                $country = DB::table('users')->where('id', $d->userIds)->first();
                $coo = (object) [
            "id" => $d->id,
            "country" => $country->country,
            "countryCode" => $country->countryCode,
            "dpImage"=> $d->dpImage,
            "name"=> $d->name,
            "type"=> $d->type,
            "newCategory"=> $d->newCategory,
            "fanBaseName"=> $d->fanBaseName,
            "stageName"=> $d->stageName,
            "videoUrl"=> $d->videoUrl,
            "subCategories" => $d->subCategories,
            "about" => $d->about,
            "status" => $d->status,
            "userIds" => $d->userIds,
            "usersIds" => $d->usersIds,
            "contestant" => $d->contestant,
            "image" => $d->image,
            "week" => $d->week,
            "weekVote1" => $d->weekVote1,
            "weekVote2" => $d->weekVote2,
            "weekVote3" => $d->weekVote3,
            "weekVote4" => $d->weekVote4,
            "weekVote5" => $d->weekVote5,
            "weekVote6" => $d->weekVote6,
            "weekVote7" => $d->weekVote7,
            "weekVote8" => $d->weekVote8,
            "weekVote9" => $d->weekVote9,
            "weekVote10" => $d->weekVote10,
            "weekVote11" => $d->weekVote11,
            "weekVote12" => $d->weekVote12,
            "weekVote13" => $d->weekVote13,
            "last" => $d->last,
            "created_at" => $d->created_at,
                ];
             $all[] = $coo;
          }

                  $count = DB::table('contestants')->where('newCategory', $categoryAll)->whereNull('deleted_at')->count();
            return response()->json([
                'success' => true,
                'value' => $co,
                'value1' => $all,
                 'count'=>$count,
            ]);

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }

    }

    public function getUsers(Request $request)
    {
        try { $user = JWTAuth::parseToken()->toUser();
            if (!$user) {
                return response()->json([
                    'error' => 'You are not authorized to access this content',
                ]);
            }
          //  $e='obivvvsssssss';
          //  Log::error($e);
            
        
            if ($request->search == null) {
                $userss = DB::table('users')->where('verifiedAt', '!=', null)->get(['id', 'username', 'firstname', 'lastname', 'imageUrl']);
            } else {
                $userss = DB::table('users')->where('username', 'LIKE', '%' . $request->search . '%')->get();
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
    

    public function createContestant1(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'error' => 'You are not authorized to access this content',
            ]);
        }

        try {

            $validator = Validator::make($request->all(), [
                'videoUrl' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:52000000|required',
           ]);

            if ($validator->fails()) {
                $error = validatorMessage($validator->errors());
                return response()->json(['error' => 'Video size is above 520000kb'], 422);
            }
             
            $u=$request->file('videoUrl')->getSize();
            Log::error($u);
            
            if ($request->hasFile('videoUrl')) {

                $filenameWithExt = $request->file('videoUrl')->getClientOriginalName();
                $filename = 'Video' . now() . $user->username;
                $extension = $request->file('videoUrl')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $destinationPath = public_path('video');
                $path = $request->file('videoUrl')->move($destinationPath, $fileNameToStore);

                if ($path) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Application is been reviewed',
                        'value' => $fileNameToStore,
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Upload Failed',
                ]);
            } else {

                return response()->json([
                    'success' => false,
                    'message' => 'Upload Failed',
                ]);
            }

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }

    }

    public function createContestant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'videoUrl' => 'required',
            'type' => 'required',
            'fanBaseName' => 'required',
            'category' => 'required',
            'subCategory' => 'required',
            'userId' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => $error], 422);
        }
  //try {
        if ($request->type == 'Group') {
            


            $request->userIds;

            $bulk1 = $request->userIds;

            $bulk = str_replace("]", '', $bulk1);
            $bulk = str_replace("[", '', $bulk);

            $bulk2 = preg_split("/[,]/", $bulk);

            foreach ($bulk2 as $us) {
                $us = str_replace("\"", '', $us);
                $us = str_replace(' ', '', $us);

                $check = DB::table('users')->where('username', $us)->first();

                if ($check->status != 'Spectator') {
                    return response()->json([
                        'error' => $check->username . ' ' . 'has join a group for the contest',
                    ]);
                }
            }
            $user = JWTAuth::parseToken()->toUser();
            if (!$user) {
                return response()->json([
                    'error' => 'You are not authorized to access this content',
                ]);
            }

            $validator = Validator::make($request->all(), [
                'image2' => 'max:2084|required',
            ]);

            if ($validator->fails()) {
                $error = validatorMessage($validator->errors());
                return response()->json(['error' => 'Group image size should not be greater than 2084kb'], 422);
            }

            $created = DB::table('users')->where('id', $user->id)->first();

            $c = $created->firstname . ' ' . $created->lastname;
            $dd = $c . ' ' . 'Invited you to join' . ' ' . $request->stageName . ' ' . 'group.';
        }
      

            $imageMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/bmp', 'video/mp4', 'image/JPG'];

            $_filepath = public_path('user-images');

            $file = $request->file('image');
            $filename = 'upload-' . $request->id . time() . '.' . $file->getClientOriginalExtension();

            $upload = $file->move($_filepath, $filename);

            $upload_path = $_filepath . '/' . $filename;
            if (file_exists($upload_path)) {
                $image_filesize = filesize($upload_path);

                $contentType = mime_content_type($upload_path);
                if (in_array($contentType, $imageMimeTypes)) {
                    ini_set('memory_limit', '256M');

                    $artwork = Image::make($upload_path);
                    $ext = $artwork->extension;
                    $thumbnail = $artwork->filename . '640xAny.' . $ext;

                    $artwork->resize(640, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $thumbnail_path = $_filepath . '/' . $thumbnail;
                    $artwork->save($thumbnail_path)->destroy();

                    if (file_exists($thumbnail_path)) {
                        $imageUrl = basename($thumbnail_path);
                    }}}

            if ($request->type != 'Single') {
                $file = $request->file('image2');
                $filename = 'upload-' . $request->id . now() . '.' . $file->getClientOriginalExtension();

                $upload = $file->move($_filepath, $filename);

                $upload_path = $_filepath . '/' . $filename;
                if (file_exists($upload_path)) {
                    $image_filesize = filesize($upload_path);

                    $contentType = mime_content_type($upload_path);
                    if (in_array($contentType, $imageMimeTypes)) {
                        ini_set('memory_limit', '256M');

                        $artwork = Image::make($upload_path);
                        $ext = $artwork->extension;
                        $thumbnail = $artwork->filename . '640xAny.' . $ext;

                        $artwork->resize(640, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $thumbnail_path = $_filepath . '/' . $thumbnail;
                        $artwork->save($thumbnail_path)->destroy();

                        if (file_exists($thumbnail_path)) {
                            $imageUrl2 = basename($thumbnail_path);
                        }}}
            }

            $u = new Contestant();
            $u->type = $request->type;
            $u->videoUrl = $request->videoUrl;
            $u->image = $imageUrl;
            $u->dpImage = $imageUrl2 ?? '';
            $u->name = $request->name;
            $u->fanBaseName = $request->fanBaseName;
            $u->newCategory = $request->category;
            $u->subCategories = $request->subCategory;
            $u->stageName = $request->stageName;
            $u->userIds = $request->userId;
            $u->usersIds = $request->userIds;
            $u->save();
            $yes = DB::table('contestants')->where('userIds', $request->userId)->where('name',$request->name)->where('subCategories', $request->subCategory)->where('newCategory', $request->category)->first();

            if ($request->type == 'Group') {
                foreach ($bulk2 as $idd) {
                    $idd = str_replace("\"", '', $idd);
                    $idd = str_replace(' ', '', $idd);
                    if ($idd != $user->username) {
                        $get = DB::table('users')->where('username', $idd)->first();
                        $uj = new Notification();
                        $uj->type = 'Request';
                        $uj->userId = $get->id;
                        $uj->content = $dd;
                        $uj->value = $yes->id;
                        $uj->model = 'Single';
                        $uj->title = 'Notice';
                        $uj->save();}
                }}

            DB::table('users')->where('id', $request->userId)->update(['contestId' => $yes->id, 'status' => 'Review']);
            // $uj = new Notification();
            // $uj->type = 'Request';
            // $uj->userId = $get->id;
            // $uj->content = $dd;
            // $uj->value = $yes->id;
            // $uj->model = 'Single';
            // $uj->title = 'Notice';
            // $uj->save();
            $user = JWTAuth::parseToken()->toUser();

            if ($u) {
                $result = (object) null;
                $result->user = $user;
                return response()->json([
                    'success' => true,
                    'message' => 'Application is been reviewed',
                    'user' => $result,
                ]);
            }

            return response()->json([
                'error' => 'Upload failed !',
            ]);

      //  } catch (\Exception $e) {
      //      Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
       // }
    }

    public function exploreSponsorsPage()
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

            $notification = DB::table('adverts')->first();
            $p1 = DB::table('sponsors')->where('show', 'Yes')->get();
            $contestant = DB::table('contestants')->where('id', $user->contestId)->first();
            $all = DB::table('users')->where('contestId', $user->contestId)->get(['username']);

            return response()->json([
                'success' => true,
                'advert' => $notification->productImage,
                'value' => $p1,
                'contestInfo' => $contestant,
                'list' => $all,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function getUploads()
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
            $uploadss = Upload::where('uploadedBy', $user->contestId)->where('to','Upload')->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'value' => $uploadss,

            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function exploreApplicationPage()
    {

        /////////////////////  not finished

        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'uploadId' => 'required',
            'uploadOwnerId' => 'required',
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

            $u = new Contestant();
            $u->commentedBy = $user->id;
            $u->uploadId = $request->uploadId;
            $u->content = $request->content;
            $u->commented = $request->uploadOwnerId;
            $u->save();

            $notification = Upload::where('uploadedBy', $user->id)->get();

            return response()->json([
                'success' => true,
                'sent' => 'yes',
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }


    public function exploreClassPage()
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

            $notification = DB::table('contestants')->where('contestant', 'Yes')->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();

            $grouped = DB::table('contestants')->select('newCategory', DB::raw('count(*) as total'))->groupBy('newCategory')->get();

            $groupedCount = DB::table('contestants')->count();

            $week1VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote1');
            $week2VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote2');
            $week3VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote3');
            $week4VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote4');
            $week5VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote5');
            $week6VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote6');
            $week7VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote7');
            $week8VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote8');
            $week9VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote9');
            $week10VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote10');
            $week11VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote11');
            $week12VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote12');
            $week13VoteCount = DB::table('contestants')->where('contestant', 'Yes')->sum('weekVote13');

            $value = [];
            $all = [];
            $all2 = [];
            $all3 = [];
            $all4 = [];
            $all5 = [];
            $all6 = [];
            $all7 = [];
            $all8 = [];
            $all9 = [];
            $all10 = [];
            $all11 = [];
            $all12 = [];
            $all13 = [];

            $craft1 = [];
            $craft2 = [];
            $craft3 = [];
            $craft4 = [];
            $craft5 = [];
            $craft6 = [];
            $craft7 = [];
            $craft8 = [];
            $craft9 = [];
            $craft10 = [];
            $craft11 = [];
            $craft12 = [];
            $craft13 = [];

            $tech1 = [];
            $tech2 = [];
            $tech3 = [];
            $tech4 = [];
            $tech5 = [];
            $tech6 = [];
            $tech7 = [];
            $tech8 = [];
            $tech9 = [];
            $tech10 = [];
            $tech11 = [];
            $tech12 = [];
            $tech13 = [];

            $lifestyle1 = [];
            $lifestyle2 = [];
            $lifestyle3 = [];
            $lifestyle4 = [];
            $lifestyle5 = [];
            $lifestyle6 = [];
            $lifestyle7 = [];
            $lifestyle8 = [];
            $lifestyle9 = [];
            $lifestyle10 = [];
            $lifestyle11 = [];
            $lifestyle12 = [];
            $lifestyle13 = [];

            $arts1 = [];
            $arts2 = [];
            $arts3 = [];
            $arts4 = [];
            $arts5 = [];
            $arts6 = [];
            $arts7 = [];
            $arts8 = [];
            $arts9 = [];
            $arts10 = [];
            $arts11 = [];
            $arts12 = [];
            $arts13 = [];

            $music1 = [];
            $music2 = [];
            $music3 = [];
            $music4 = [];
            $music5 = [];
            $music6 = [];
            $music7 = [];
            $music8 = [];
            $music9 = [];
            $music10 = [];
            $music11 = [];
            $music12 = [];
            $music13 = [];

            $acting1 = [];
            $acting2 = [];
            $acting3 = [];
            $acting4 = [];
            $acting5 = [];
            $acting6 = [];
            $acting7 = [];
            $acting8 = [];
            $acting9 = [];
            $acting10 = [];
            $acting11 = [];
            $acting12 = [];
            $acting13 = [];

            $eadible1 = [];
            $eadible2 = [];
            $eadible3 = [];
            $eadible4 = [];
            $eadible5 = [];
            $eadible6 = [];
            $eadible7 = [];
            $eadible8 = [];
            $eadible9 = [];
            $eadible10 = [];
            $eadible11 = [];
            $eadible12 = [];
            $eadible13 = [];

            $tutor1 = [];
            $tutor2 = [];
            $tutor3 = [];
            $tutor4 = [];
            $tutor5 = [];
            $tutor6 = [];
            $tutor7 = [];
            $tutor8 = [];
            $tutor9 = [];
            $tutor10 = [];
            $tutor11 = [];
            $tutor12 = [];
            $tutor13 = [];

            $other1 = [];
            $other2 = [];
            $other3 = [];
            $other4 = [];
            $other5 = [];
            $other6 = [];
            $other7 = [];
            $other8 = [];
            $other9 = [];
            $other10 = [];
            $other11 = [];
            $other12 = [];
            $other13 = [];

            $task1 = [];
            $task2 = [];
            $task3 = [];
            $task4 = [];
            $task5 = [];
            $task6 = [];
            $task7 = [];
            $task8 = [];
            $task9 = [];
            $task10 = [];
            $task11 = [];
            $task12 = [];
            $task13 = [];
            
            
            
            
            
            
            
            
            
            
            
            
            
            $venus1 = [];
            $venus2 = [];
            $venus3 = [];
            $venus4 = [];
            $venus5 = [];
            $venus6 = [];
            $venus7 = [];
            $venus8 = [];
            $venus9 = [];
            $venus10 = [];
            $venus11 = [];
            $venus12 = [];
            $venus13 = [];

            $jupiter1 = [];
            $jupiter2 = [];
            $jupiter3 = [];
            $jupiter4 = [];
            $jupiter5 = [];
            $jupiter6 = [];
            $jupiter7 = [];
            $jupiter8 = [];
            $jupiter9 = [];
            $jupiter10 = [];
            $jupiter11 = [];
            $jupiter12 = [];
            $jupiter13 = [];

            $mars1 = [];
            $mars2 = [];
            $mars3 = [];
            $mars4 = [];
            $mars5 = [];
            $mars6 = [];
            $mars7 = [];
            $mars8 = [];
            $mars9 = [];
            $mars10 = [];
            $mars11 = [];
            $mars12 = [];
            $mars13 = [];

            $neptune1 = [];
            $neptune2 = [];
            $neptune3 = [];
            $neptune4 = [];
            $neptune5 = [];
            $neptune6 = [];
            $neptune7 = [];
            $neptune8 = [];
            $neptune9 = [];
            $neptune10 = [];
            $neptune11 = [];
            $neptune12 = [];
            $neptune13 = [];

            $uranus1 = [];
            $uranus2 = [];
            $uranus3 = [];
            $uranus4 = [];
            $uranus5 = [];
            $uranus6 = [];
            $uranus7 = [];
            $uranus8 = [];
            $uranus9 = [];
            $uranus10 = [];
            $uranus11 = [];
            $uranus12 = [];
            $uranus13 = [];
        
        
        $sarturn1 = [];
        $sarturn2 = [];
        $sarturn3 = [];
        $sarturn4 = [];
        $sarturn5 = [];
        $sarturn6 = [];
        $sarturn7 = [];
        $sarturn8 = [];
        $sarturn9 = [];
        $sarturn10 = [];
        $sarturn11 = [];
        $sarturn12 = [];
        $sarturn13 = [];
        
            
            
            
            
            

            if ($notification) {
                foreach ($notification as $a) {
                    if (intval($a->week) >= 1) {

                        if ($a->categories == 'Craft') {

                            $craft1[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech1[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle1[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts1[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music1[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting1[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible1[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task1[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other1[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor1[] = $a;

                        } else {}

                    }}

                if ($craft1 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft1,
                    ];
                    $all[] = $fvf;
                }if ($tech1 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech1,
                    ];
                    $all[] = $fvf;
                }if ($lifestyle1 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle1,
                    ];
                    $all[] = $fvf;
                }if ($arts1 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts1,
                    ];
                    $all[] = $fvf;
                }if ($music1 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music1,
                    ];
                    $all[] = $fvf;
                }if ($acting1 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting1,
                    ];
                    $all[] = $fvf;
                }if ($eadible1 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible1,
                    ];
                    $all[] = $fvf;
                }if ($task1 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task1,
                    ];
                    $all[] = $fvf;
                }if ($other1 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other1,
                    ];
                    $all[] = $fvf;
                }if ($tutor1 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor1,
                    ];
                    $all[] = $fvf;

                }

                $mmm1 = (object) [
                    'week' => '1',
                    'value' => $all,
                    'weekTotalCount' => $week1VoteCount,
                ];

                $value[] = $mmm1;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 2) {

                        if ($a->categories == 'Craft') {

                            $craft2[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech2[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle2[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts2[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music2[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting2[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible2[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task2[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other2[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor2[] = $a;

                        } else {}

                    }}

                if ($craft2 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft2,
                    ];
                    $all2[] = $fvf;
                }if ($tech2 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech2,
                    ];
                    $all2[] = $fvf;
                }if ($lifestyle2 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle2,
                    ];
                    $all2[] = $fvf;
                }if ($arts2 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts2,
                    ];
                    $all2[] = $fvf;
                }if ($music2 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music2,
                    ];
                    $all2[] = $fvf;
                }if ($acting2 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting2,
                    ];
                    $all2[] = $fvf;
                }if ($eadible2 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible2,
                    ];
                    $all2[] = $fvf;
                }if ($task2 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task2,
                    ];
                    $all2[] = $fvf;
                }if ($other2 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other2,
                    ];
                    $all2[] = $fvf;
                }if ($tutor2 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor2,
                    ];
                    $all2[] = $fvf;

                }

                $mmm2 = (object) [
                    'week' => '2',
                    'value' => $all2,
                    'weekTotalCount' => $week2VoteCount,
                ];

                $value[] = $mmm2;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 3) {

                        if ($a->categories == 'Craft') {

                            $craft3[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech3[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle3[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts3[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music3[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting3[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible3[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task3[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other3[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor3[] = $a;

                        } else {}

                    }}

                if ($craft3 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft3,
                    ];
                    $all3[] = $fvf;
                }if ($tech3 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech3,
                    ];
                    $all3[] = $fvf;
                }if ($lifestyle3 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle3,
                    ];
                    $all3[] = $fvf;
                }if ($arts3 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts3,
                    ];
                    $all3[] = $fvf;
                }if ($music3 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music3,
                    ];
                    $all3[] = $fvf;
                }if ($acting3 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting3,
                    ];
                    $all3[] = $fvf;
                }if ($eadible3 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible3,
                    ];
                    $all3[] = $fvf;
                }if ($task3 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task3,
                    ];
                    $all3[] = $fvf;
                }if ($other3 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other3,
                    ];
                    $all3[] = $fvf;
                }if ($tutor3 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor3,
                    ];
                    $all3[] = $fvf;

                }

                $mmm3 = (object) [
                    'week' => '3',
                    'value' => $all3,
                    'weekTotalCount' => $week3VoteCount,
                ];

                $value[] = $mmm3;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 4) {

                        if ($a->categories == 'Craft') {

                            $craft4[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech4[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle4[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts4[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music4[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting4[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible4[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task4[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other4[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor4[] = $a;

                        } else {}

                    }}

                if ($craft4 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft4,
                    ];
                    $all4[] = $fvf;
                }if ($tech4 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech4,
                    ];
                    $all4[] = $fvf;
                }if ($lifestyle4 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle4,
                    ];
                    $all4[] = $fvf;
                }if ($arts4 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts4,
                    ];
                    $all4[] = $fvf;
                }if ($music4 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music4,
                    ];
                    $all4[] = $fvf;
                }if ($acting4 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting4,
                    ];
                    $all4[] = $fvf;
                }if ($eadible4 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible4,
                    ];
                    $all4[] = $fvf;
                }if ($task4 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task4,
                    ];
                    $all4[] = $fvf;
                }if ($other4 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other4,
                    ];
                    $all4[] = $fvf;
                }if ($tutor4 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor4,
                    ];
                    $all4[] = $fvf;

                }

                $mmm4 = (object) [
                    'week' => '4',
                    'value' => $all4,
                    'weekTotalCount' => $week4VoteCount,
                ];

                $value[] = $mmm4;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 5) {

                        if ($a->categories == 'Craft') {

                            $craft5[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech5[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle5[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts5[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music5[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting5[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible5[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task5[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other5[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor5[] = $a;

                        } else {}

                    }}

                if ($craft5 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft5,
                    ];
                    $all5[] = $fvf;
                }if ($tech5 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech5,
                    ];
                    $all5[] = $fvf;
                }if ($lifestyle5 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle5,
                    ];
                    $all5[] = $fvf;
                }if ($arts5 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts5,
                    ];
                    $all5[] = $fvf;
                }if ($music5 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music5,
                    ];
                    $all5[] = $fvf;
                }if ($acting5 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting5,
                    ];
                    $all5[] = $fvf;
                }if ($eadible5 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible5,
                    ];
                    $all5[] = $fvf;
                }if ($task5 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task5,
                    ];
                    $all5[] = $fvf;
                }if ($other5 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other5,
                    ];
                    $all5[] = $fvf;
                }if ($tutor5 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor5,
                    ];
                    $all5[] = $fvf;

                }

                $mmm5 = (object) [
                    'week' => '5',
                    'value' => $all5,
                    'weekTotalCount' => $week5VoteCount,
                ];

                $value[] = $mmm5;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 6) {

                        if ($a->categories == 'Craft') {

                            $craft6[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech6[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle6[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts6[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music6[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting6[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible6[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task6[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other6[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor6[] = $a;

                        } else {}

                    }}

                if ($craft6 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft6,
                    ];
                    $all6[] = $fvf;
                }if ($tech6 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech6,
                    ];
                    $all6[] = $fvf;
                }if ($lifestyle6 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle6,
                    ];
                    $all6[] = $fvf;
                }if ($arts6 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts6,
                    ];
                    $all6[] = $fvf;
                }if ($music6 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music6,
                    ];
                    $all6[] = $fvf;
                }if ($acting6 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting6,
                    ];
                    $all6[] = $fvf;
                }if ($eadible6 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible6,
                    ];
                    $all6[] = $fvf;
                }if ($task6 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task6,
                    ];
                    $all6[] = $fvf;
                }if ($other6 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other6,
                    ];
                    $all6[] = $fvf;
                }if ($tutor6 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor6,
                    ];
                    $all6[] = $fvf;

                }

                $mmm6 = (object) [
                    'week' => '6',
                    'value' => $all6,
                    'weekTotalCount' => $week6VoteCount,
                ];

                $value[] = $mmm6;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 7) {

                        if ($a->categories == 'Craft') {

                            $craft7[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech7[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle7[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts7[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music7[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting7[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible7[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task7[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other7[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor7[] = $a;

                        } else {}

                    }}

                if ($craft7 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft7,
                    ];
                    $all7[] = $fvf;
                }if ($tech7 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech7,
                    ];
                    $all7[] = $fvf;
                }if ($lifestyle7 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle7,
                    ];
                    $all7[] = $fvf;
                }if ($arts7 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts7,
                    ];
                    $all7[] = $fvf;
                }if ($music7 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music7,
                    ];
                    $all7[] = $fvf;
                }if ($acting7 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting7,
                    ];
                    $all7[] = $fvf;
                }if ($eadible7 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible7,
                    ];
                    $all7[] = $fvf;
                }if ($task7 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task7,
                    ];
                    $all7[] = $fvf;
                }if ($other7 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other7,
                    ];
                    $all7[] = $fvf;
                }if ($tutor7 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor7,
                    ];
                    $all7[] = $fvf;

                }

                $mmm7 = (object) [
                    'week' => '7',
                    'value' => $all7,
                    'weekTotalCount' => $week7VoteCount,
                ];

                $value[] = $mmm7;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 8) {

                        if ($a->categories == 'Craft') {

                            $craft8[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech8[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle8[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts8[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music8[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting8[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible8[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task8[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other8[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor8[] = $a;

                        } else {}

                    }}

                if ($craft8 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft8,
                    ];
                    $all8[] = $fvf;
                }if ($tech8 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech8,
                    ];
                    $all8[] = $fvf;
                }if ($lifestyle8 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle8,
                    ];
                    $all8[] = $fvf;
                }if ($arts8 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts8,
                    ];
                    $all8[] = $fvf;
                }if ($music8 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music8,
                    ];
                    $all8[] = $fvf;
                }if ($acting8 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting8,
                    ];
                    $all8[] = $fvf;
                }if ($eadible8 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible8,
                    ];
                    $all8[] = $fvf;
                }if ($task8 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task8,
                    ];
                    $all8[] = $fvf;
                }if ($other8 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other8,
                    ];
                    $all8[] = $fvf;
                }if ($tutor8 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor8,
                    ];
                    $all8[] = $fvf;

                }

                $mmm9 = (object) [
                    'week' => '8',
                    'value' => $all8,
                    'weekTotalCount' => $week8VoteCount,
                ];

                $value[] = $mmm9;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 9) {

                        if ($a->categories == 'Craft') {

                            $craft9[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech9[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle9[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts9[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music9[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting9[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible9[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task9[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other9[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor9[] = $a;

                        } else {}

                    }}

                if ($craft9 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft9,
                    ];
                    $all9[] = $fvf;
                }if ($tech9 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech9,
                    ];
                    $all9[] = $fvf;
                }if ($lifestyle9 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle9,
                    ];
                    $all9[] = $fvf;
                }if ($arts9 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts9,
                    ];
                    $all9[] = $fvf;
                }if ($music9 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music9,
                    ];
                    $all9[] = $fvf;
                }if ($acting9 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting9,
                    ];
                    $all9[] = $fvf;
                }if ($eadible9 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible9,
                    ];
                    $all9[] = $fvf;
                }if ($task9 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task9,
                    ];
                    $all9[] = $fvf;
                }if ($other9 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other9,
                    ];
                    $all9[] = $fvf;
                }if ($tutor9 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor9,
                    ];
                    $all9[] = $fvf;

                }

                $mmm9 = (object) [
                    'week' => '9',
                    'value' => $all9,
                    'weekTotalCount' => $week9VoteCount,
                ];

                $value[] = $mmm9;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 10) {

                        if ($a->categories == 'Craft') {

                            $craft10[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech10[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle10[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts10[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music10[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting10[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible10[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task10[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other10[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor10[] = $a;

                        } else {}

                    }}

                if ($craft10 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft10,
                    ];
                    $all10[] = $fvf;
                }if ($tech10 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech10,
                    ];
                    $all10[] = $fvf;
                }if ($lifestyle10 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle10,
                    ];
                    $all10[] = $fvf;
                }if ($arts10 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts10,
                    ];
                    $all10[] = $fvf;
                }if ($music10 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music10,
                    ];
                    $all10[] = $fvf;
                }if ($acting10 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting10,
                    ];
                    $all10[] = $fvf;
                }if ($eadible10 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible10,
                    ];
                    $all10[] = $fvf;
                }if ($task10 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task10,
                    ];
                    $all10[] = $fvf;
                }if ($other10 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other10,
                    ];
                    $all[] = $fvf;
                }if ($tutor10 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor10,
                    ];
                    $all10[] = $fvf;

                }

                $mmm10 = (object) [
                    'week' => '10',
                    'value' => $all10,
                    'weekTotalCount' => $week10VoteCount,
                ];

                $value[] = $mmm10;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 11) {

                        if ($a->categories == 'Craft') {

                            $craft11[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech11[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle11[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts11[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music11[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting11[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible11[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task11[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other11[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor11[] = $a;

                        } else {}

                    }}

                if ($craft11 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft11,
                    ];
                    $all11[] = $fvf;
                }if ($tech11 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech11,
                    ];
                    $all11[] = $fvf;
                }if ($lifestyle11 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle11,
                    ];
                    $all11[] = $fvf;
                }if ($arts11 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts11,
                    ];
                    $all11[] = $fvf;
                }if ($music11 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music11,
                    ];
                    $all11[] = $fvf;
                }if ($acting11 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting11,
                    ];
                    $all11[] = $fvf;
                }if ($eadible11 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible11,
                    ];
                    $all11[] = $fvf;
                }if ($task11 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task11,
                    ];
                    $all11[] = $fvf;
                }if ($other11 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other11,
                    ];
                    $all11[] = $fvf;
                }if ($tutor11 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor11,
                    ];
                    $all11[] = $fvf;

                }

                $mmm11 = (object) [
                    'week' => '11',
                    'value' => $all11,
                    'weekTotalCount' => $week11VoteCount,
                ];

                $value[] = $mmm11;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 12) {

                        if ($a->categories == 'Craft') {

                            $craft12[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech12[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle12[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts12[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music12[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting12[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible12[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task12[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other12[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor12[] = $a;

                        } else {}

                    }}

                if ($craft12 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft12,
                    ];
                    $all12[] = $fvf;
                }if ($tech12 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech12,
                    ];
                    $all12[] = $fvf;
                }if ($lifestyle12 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle12,
                    ];
                    $all12[] = $fvf;
                }if ($arts12 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts12,
                    ];
                    $all12[] = $fvf;
                }if ($music12 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music12,
                    ];
                    $all12[] = $fvf;
                }if ($acting12 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting12,
                    ];
                    $all12[] = $fvf;
                }if ($eadible12 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible12,
                    ];
                    $all12[] = $fvf;
                }if ($task12 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task12,
                    ];
                    $all12[] = $fvf;
                }if ($other12 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other12,
                    ];
                    $all12[] = $fvf;
                }if ($tutor12 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor12,
                    ];
                    $all12[] = $fvf;

                }

                $mmm12 = (object) [
                    'week' => '12',
                    'value' => $all12,
                    'weekTotalCount' => $week12VoteCount,
                ];

                $value[] = $mmm12;

                foreach ($notification as $a) {
                    if (intval($a->week) >= 13) {

                        if ($a->categories == 'Craft') {

                            $craft13[] = $a;
                        } else if ($a->categories == 'Tech') {

                            $tech13[] = $a;
                        } else if ($a->categories == 'Lifestyle') {

                            $lifestyle13[] = $a;
                        } else if ($a->categories == 'Arts') {

                            $arts13[] = $a;
                        } else if ($a->categories == 'Music') {

                            $music13[] = $a;
                        } else if ($a->categories == 'Acting') {

                            $acting13[] = $a;
                        } else if ($a->categories == 'Eadible') {

                            $eadible13[] = $a;
                        } else if ($a->categories == 'Task') {

                            $task13[] = $a;
                        } else if ($a->categories == 'Others') {

                            $other13[] = $a;
                        } else if ($a->categories == 'Tutor') {

                            $tutor13[] = $a;

                        } else {}

                    }}

                if ($craft13 != null) {
                    $fvf = (object) [
                        'category' => 'craft',
                        'contestants' => $craft13,
                    ];
                    $all13[] = $fvf;
                }if ($tech13 != null) {
                    $fvf = (object) [
                        'category' => 'tech',
                        'contestants' => $tech13,
                    ];
                    $all13[] = $fvf;
                }if ($lifestyle13 != null) {
                    $fvf = (object) [
                        'category' => 'lifestyle',
                        'contestants' => $lifestyle13,
                    ];
                    $all13[] = $fvf;
                }if ($arts13 != null) {
                    $fvf = (object) [
                        'category' => 'arts',
                        'contestants' => $arts13,
                    ];
                    $all13[] = $fvf;
                }if ($music13 != null) {
                    $fvf = (object) [
                        'category' => 'music',
                        'contestants' => $music13,
                    ];
                    $all13[] = $fvf;
                }if ($acting13 != null) {
                    $fvf = (object) [
                        'category' => 'acting',
                        'contestants' => $acting13,
                    ];
                    $all13[] = $fvf;
                }if ($eadible13 != null) {
                    $fvf = (object) [
                        'category' => 'eadible',
                        'contestants' => $eadible13,
                    ];
                    $all13[] = $fvf;
                }if ($task13 != null) {
                    $fvf = (object) [
                        'category' => 'task',
                        'contestants' => $task13,
                    ];
                    $all13[] = $fvf;
                }if ($other13 != null) {
                    $fvf = (object) [
                        'category' => 'others',
                        'contestants' => $other13,
                    ];
                    $all13[] = $fvf;
                }if ($tutor13 != null) {
                    $fvf = (object) [
                        'category' => 'tutor',
                        'contestants' => $tutor13,
                    ];
                    $all13[] = $fvf;

                }

                $mmm13 = (object) [
                    'week' => '13',
                    'value' => $all13,
                    'weekTotalCount' => $week13VoteCount,
                ];

                $value[] = $mmm13;

                $picker = (object) [
                    'winnerImage' => 'winnerImg',
                    'winnerSubCategory' => 'winnerSubCategory',
                    'winnerFullname' => 'winnerName',
                ];

            }
            return response()->json([
                'success' => true,
                'categories' => $grouped,
                'groupedCount' => $groupedCount,
                'value' => $value,
                'winnerInfo' => $picker,

            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

}

if (!function_exists('validatorMessage')) {
    /**
     * @param string $validator_errors
     *
     * @return string
     */
    function validatorMessage($validator_errors)
    {
        $error = collect($validator_errors)->values()->flatten()->implode(', ');
        $message = str_replace('.', '', strtolower($error));
        return $message;
    }
}
