<?php

namespace App\Http\Controllers\Api\V1;

use App\Admin;
use App\Contestant;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Upload;
use Carbon\Carbon;
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
        $c1 = DB::table('users')->where('id', $user->id)->update(['live' => $request->trigger]);

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

    public function deleteUploads(Request $request)
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
        ]);

        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => 'You are not authorized to access this content'], 422);
        }

        $upload = DB::table('uploads')->where('verified', 'No')->where('id', $request->uploadId)->whereNull('deleted_at')->first();
        if ($upload) {
            if ($upload->uploadedBy == $user->contestId && $user->joined == 'Yes') {

                DB::table('uploads')->where('verified', 'No')->where('id', $request->uploadId)->update(['deleted_at' => Carbon::now()]);

                return response()->json([
                    'success' => true,
                    'message' => 'deleted successfully',
                ]);}
            return response()->json([
                'success' => true,
                'message' => 'Failed to delete',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Failed to delete',
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

                //    $imageMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/bmp', 'video/mp4', 'image/JPG'];

                //  $_filepath = public_path('user-images');
                //$file = $request->file('image');
                //$filename = 'Img' . now() . $user->username . $file->getClientOriginalExtension();

                //  $upload = $file->move($_filepath, $filename);

                //   $upload_path = $_filepath . '/' . $filename;

                // if (file_exists($upload_path)) {
                //     $image_filesize = filesize($upload_path);

                //     $contentType = mime_content_type($upload_path);
                //     if (in_array($contentType, $imageMimeTypes)) {
                //         ini_set('memory_limit', '256M');

                //         $artwork = Image::make($upload_path);
                //         $ext = $artwork->extension;
                //         $thumbnail = $artwork->filename . '640xAny.' . $ext;

                //         $artwork->resize(640, null, function ($constraint) {
                //             $constraint->aspectRatio();
                //             $constraint->upsize();
                //         });

                //         $thumbnail_path = $_filepath . '/' . $thumbnail;
                //         $artwork->save($thumbnail_path)->destroy();

                //         if (file_exists($thumbnail_path)) {
                //             $imageUrl = basename($thumbnail_path);
                //         }}}

                $u = new Upload();
                $u->type = 'Video';
                $u->contentUrl = $request->videoUrl;
                $u->title = $request->title;
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
                            $f = $a->id;
                            $ff = $a->created_at;
                            $firstL[] = $first;
                            $firstL[] = $f;
                            $firstL[] = $ff;
                        }

                        if ($a->video == 'Second') {
                            $second = 'Yes';
                            $s = $a->id;
                            $ss = $a->created_at;
                            $secondL[] = $second;
                            $secondL[] = $s;
                            $secondL[] = $ss;
                        }

                        if ($a->video == 'Task') {
                            $task = 'Yes';
                            $t = $a->id;
                            $tt = $a->created_at;
                            $taskL[] = $task;
                            $taskL[] = $t;
                            $taskL[] = $tt;
                        }
                    }
                    $no = 'No';
                    $fvf = (object) [

                        'totalVotes' => 'none',
                        'week' => $a->week,
                        'first' => $firstL ? $firstL[0] : $no,
                        'second' => $secondL ? $secondL[0] : $no,
                        'task' => $taskL ? $taskL[0] : $no,
                        'firstId' => $firstL ? $firstL[1] : $no,
                        'secondId' => $secondL ? $secondL[1] : $no,
                        'taskId' => $taskL ? $taskL[1] : $no,

                        'firstDate' => $firstL ? $firstL[2] : $no,
                        'secondDate' => $secondL ? $secondL[2] : $no,
                        'taskDate' => $taskL ? $taskL[2] : $no,

                    ];
                    $value[] = $fvf;
                }
                for ($i = 0; $i < 14 - $ii; $i++) {

                    $fvf = (object) [
                        'uploadId' => 'none',
                        'totalVotes' => 'none',
                        'week' => 'No',
                        'first' => 'No',
                        'second' => 'No',
                        'task' => 'No',
                        'firstId' => 'No',
                        'secondId' => 'No',
                        'taskId' => 'No',
                        'firstDate' => 'No',
                        'secondDate' => 'No',
                        'taskDate' => 'No',

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
            $categoryAll = Input::get('category', false);

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

            foreach ($co as $d) {
                $country = DB::table('users')->where('id', $d->userIds)->first();
                $coo = (object) [
                    "id" => $d->id,
                    "country" => $country->country,
                    "countryCode" => $country->countryCode,
                    "dpImage" => $d->dpImage,
                    "name" => $d->name,
                    "type" => $d->type,
                    "newCategory" => $d->newCategory,
                    "fanBaseName" => $d->fanBaseName,
                    "stageName" => $d->stageName,
                    "videoUrl" => $d->videoUrl,
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
                'count' => $count,
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

            $u = $request->file('videoUrl')->getSize();
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
        $yes = DB::table('contestants')->where('userIds', $request->userId)->where('name', $request->name)->where('subCategories', $request->subCategory)->where('newCategory', $request->category)->first();

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
            $week = Admin::query()->first();

            $uploadss = Upload::where('uploadedBy', $user->contestId)->where('week', '<', $week->week)->where('to', 'Upload')->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();

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
        //  try {

        $notification = DB::table('contestants')->where('status', 'Runner')->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
//        dd($notification);
        $grouped = DB::table('contestants')->where('newCategory', '!=', null)->select('newCategory', DB::raw('count(*) as total'))->groupBy('newCategory')->get();

        $groupedCount = DB::table('contestants')->count();

        $week1VoteCount = DB::table('contestants')->where('status', 'Runner')->sum('weekVote1');
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
        $all1 = [];
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

        $saturn1 = [];
        $saturn2 = [];
        $saturn3 = [];
        $saturn4 = [];
        $saturn5 = [];
        $saturn6 = [];
        $saturn7 = [];
        $saturn8 = [];
        $saturn9 = [];
        $saturn10 = [];
        $saturn11 = [];
        $saturn12 = [];
        $saturn13 = [];

        if ($notification) {

            foreach ($notification as $a) {
                if (intval($a->week) >= 1) {

                    if ($a->newCategory == 'Venus') {

                        $venus1[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus1[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn1[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune1[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars1[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter1[] = $a;

                    } else {}

                }}

            if ($mars1 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars1,
                ];
                $all1[] = $fvf;
            }if ($jupiter1 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter1,
                ];
                $all1[] = $fvf;
            }if ($venus1 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus1,
                ];
                $all1[] = $fvf;
            }if ($saturn1 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn1,
                ];
                $all1[] = $fvf;
            }if ($neptune1 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune1,
                ];
                $all1[] = $fvf;
            }if ($uranus1 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus1,
                ];
                $all1[] = $fvf;
            }

            $mmm1 = (object) [
                'week' => '1',
                'value' => $all1,
                'weekTotalCount' => $week1VoteCount,
            ];

            $value[] = $mmm1;

            foreach ($notification as $a) {
                if (intval($a->week) >= 2) {

                    if ($a->newCategory == 'Venus') {

                        $venus2[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus2[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn2[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune2[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars2[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter2[] = $a;

                    } else {}

                }}

            if ($venus2 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus2,
                ];
                $all2[] = $fvf;
            }if ($jupiter2 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter2,
                ];
                $all2[] = $fvf;
            }if ($mars2 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars2,
                ];
                $all2[] = $fvf;
            }if ($saturn2 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn2,
                ];
                $all2[] = $fvf;
            }if ($uranus2 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus2,
                ];
                $all2[] = $fvf;
            }if ($neptune2 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune2,
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

                    if ($a->newCategory == 'Venus') {

                        $venus3[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus3[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn3[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune3[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars3[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter3[] = $a;

                    } else {}

                }}

            if ($venus3 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus3,
                ];
                $all3[] = $fvf;
            }if ($jupiter3 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter3,
                ];
                $all3[] = $fvf;
            }if ($mars2 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars3,
                ];
                $all3[] = $fvf;
            }if ($saturn3 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn3,
                ];
                $all3[] = $fvf;
            }if ($uranus3 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus3,
                ];
                $all3[] = $fvf;
            }if ($neptune3 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune3,
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

                    if ($a->newCategory == 'Venus') {

                        $venus4[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus4[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn4[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune4[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars4[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter4[] = $a;

                    } else {}

                }}

            if ($venus4 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus4,
                ];
                $all4[] = $fvf;
            }if ($jupiter4 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter4,
                ];
                $all4[] = $fvf;
            }if ($mars4 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars4,
                ];
                $all4[] = $fvf;
            }if ($saturn4 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn4,
                ];
                $all4[] = $fvf;
            }if ($uranus4 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus4,
                ];
                $all4[] = $fvf;
            }if ($neptune4 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune4,
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

                    if ($a->newCategory == 'Venus') {

                        $venus5[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus5[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn5[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune5[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars5[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter5[] = $a;

                    } else {}

                }}

            if ($venus5 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus5,
                ];
                $all5[] = $fvf;
            }if ($jupiter5 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter5,
                ];
                $all5[] = $fvf;
            }if ($mars5 != null) {
                $fvf = (object) [
                    'category' => 'mar',
                    'contestants' => $mars5,
                ];
                $all5[] = $fvf;
            }if ($saturn5 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn5,
                ];
                $all5[] = $fvf;
            }if ($uranus5 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus5,
                ];
                $all5[] = $fvf;
            }if ($neptune5 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune5,
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

                    if ($a->newCategory == 'Venus') {

                        $venu6[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus6[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn6[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune6[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars6[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter6[] = $a;

                    } else {}

                }}

            if ($venus6 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus6,
                ];
                $all6[] = $fv6f;
            }if ($jupiter6 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter6,
                ];
                $all6[] = $fvf;
            }if ($mars6 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars6,
                ];
                $all6[] = $fvf;
            }if ($saturn6 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn6,
                ];
                $all6[] = $fvf;
            }if ($uranus6 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus6,
                ];
                $all6[] = $fvf;
            }if ($neptune6 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune6,
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

                    if ($a->newCategory == 'Venus') {

                        $venus7[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus7[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn7[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune7[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars7[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter7[] = $a;

                    } else {}

                }}

            if ($venus7 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus7,
                ];
                $all7[] = $fvf;
            }if ($jupiter7 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter7,
                ];
                $all7[] = $fvf;
            }if ($mars7 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars7,
                ];
                $all7[] = $fvf;
            }if ($saturn7 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn7,
                ];
                $all7[] = $fvf;
            }if ($uranus7 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus7,
                ];
                $all7[] = $fvf;
            }if ($neptune7 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune7,
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

                    if ($a->newCategory == 'Venus') {

                        $venus8[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus8[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn8[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune8[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars8[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter8[] = $a;

                    } else {}

                }}

            if ($venus8 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus8,
                ];
                $all8[] = $fvf;
            }if ($jupiter8 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter8,
                ];
                $all8[] = $fvf;
            }if ($mars8 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars8,
                ];
                $all8[] = $fvf;
            }if ($saturn8 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn8,
                ];
                $all8[] = $fvf;
            }if ($uranus8 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus8,
                ];
                $all8[] = $fvf;
            }if ($neptune8 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune8,
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

                    if ($a->newCategory == 'Venus') {

                        $venus9[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus9[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn9[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune9[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars9[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter9[] = $a;

                    } else {}

                }}

            if ($venus9 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus9,
                ];
                $all9[] = $fvf;
            }if ($jupiter9 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter9,
                ];
                $all9[] = $fvf;
            }if ($mars9 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars9,
                ];
                $all9[] = $fvf;
            }if ($saturn9 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn9,
                ];
                $all9[] = $fvf;
            }if ($uranus9 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus9,
                ];
                $all9[] = $fvf;
            }if ($neptune9 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune9,
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

                    if ($a->newCategory == 'Venus') {

                        $venus10[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus10[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn10[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune10[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars10[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter10[] = $a;

                    } else {}

                }}

            if ($venus10 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus10,
                ];
                $all10[] = $fvf;
            }if ($jupiter10 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter10,
                ];
                $all10[] = $fvf;
            }if ($mars10 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars10,
                ];
                $all10[] = $fvf;
            }if ($saturn10 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn10,
                ];
                $all10[] = $fvf;
            }if ($uranus10 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus10,
                ];
                $all10[] = $fvf;
            }if ($neptune10 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune10,
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

                    if ($a->newCategory == 'Venus') {

                        $venus11[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus11[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn11[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune11[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars11[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter11[] = $a;

                    } else {}

                }}

            if ($venus11 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus11,
                ];
                $all11[] = $fvf;
            }if ($jupiter11 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter11,
                ];
                $all11[] = $fvf;
            }if ($mars11 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars11,
                ];
                $all11[] = $fvf;
            }if ($saturn11 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn11,
                ];
                $all11[] = $fvf;
            }if ($uranus11 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus11,
                ];
                $all11[] = $fvf;
            }if ($neptune11 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune11,
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

                    if ($a->newCategory == 'Venus') {

                        $venus12[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus12[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn12[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune12[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars12[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter[] = $a;

                    } else {}

                }}

            if ($venus12 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus12,
                ];
                $all12[] = $fvf;
            }if ($jupiter12 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter12,
                ];
                $all12[] = $fvf;
            }if ($mars12 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars12,
                ];
                $all12[] = $fvf;
            }if ($saturn12 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn12,
                ];
                $all12[] = $fvf;
            }if ($uranus12 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus12,
                ];
                $all12[] = $fvf;
            }if ($neptune12 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune12,
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

                    if ($a->newCategory == 'Venus') {

                        $venus13[] = $a;
                    } else if ($a->newCategory == 'Uranus') {

                        $uranus13[] = $a;
                    } else if ($a->newCategory == 'Saturn') {

                        $saturn13[] = $a;
                    } else if ($a->newCategory == 'Neptune') {

                        $neptune13[] = $a;
                    } else if ($a->newCategory == 'Mars') {

                        $mars13[] = $a;
                    } else if ($a->newCategory == 'Jupiter') {

                        $jupiter13[] = $a;

                    } else {}

                }}

            if ($venus13 != null) {
                $fvf = (object) [
                    'category' => 'venus',
                    'contestants' => $venus13,
                ];
                $all13[] = $fvf;
            }if ($jupiter13 != null) {
                $fvf = (object) [
                    'category' => 'jupiter',
                    'contestants' => $jupiter13,
                ];
                $all13[] = $fvf;
            }if ($mars13 != null) {
                $fvf = (object) [
                    'category' => 'mars',
                    'contestants' => $mars13,
                ];
                $all13[] = $fvf;
            }if ($saturn13 != null) {
                $fvf = (object) [
                    'category' => 'saturn',
                    'contestants' => $saturn13,
                ];
                $all13[] = $fvf;
            }if ($uranus13 != null) {
                $fvf = (object) [
                    'category' => 'uranus',
                    'contestants' => $uranus13,
                ];
                $all13[] = $fvf;
            }if ($neptune13 != null) {
                $fvf = (object) [
                    'category' => 'neptune',
                    'contestants' => $neptune13,
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

        //  } catch (\Exception $e) {
        //     Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
        return response()->json(['error' => 'server error, try again later or contact support'], 500);
        // }
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
