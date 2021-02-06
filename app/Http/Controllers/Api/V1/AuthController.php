<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Libraries\MailHandler;
use App\Libraries\SMSGateway;
use App\Notification;
use App\PasswordReset;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use DB;
use FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;
use JWTAuth;
use Log;

class AuthController extends Controller
{

    public function sendNotification(Request $request)
//    $user = auth()->user();
{

    $user = JWTAuth::parseToken()->toUser();
    if (!$user) {
        $o = (object) [
            "message"=>"failed",
            "value" => "You are not authorized to access this content",
             ];
            $k[]=$o;
            return $k;
        }
   
try {
        $friend = User::where('username', $request->username)->first();
          if ($user->username==$friend->username) {
            $o = (object) [
                "message"=>"failed",
                "value" => "Transfering to yourself not allowed",
                 ];
                $k[]=$o;
                return $k;
   }
        if ($friend != null) {
            $currency = $user->country == 'Nigeria' ? 'Naira' : 'Dollar';
            $friendscurrency = $friend->country == 'Nigeria' ? 'Naira' : 'Dollar';
            $myTransaction = Wallet::where('userId', $user->id)->where('type', $currency)->orderBy('id', 'DESC')->first();
            $friendsTransaction = Wallet::where('userId', $friend->id)->where('type', $currency)->orderBy('id', 'DESC')->first();

                if( $user->country == 'Nigeria'&&  $friend->country == 'Nigeria' ||$user->country != 'Nigeria' &&  $friend->country != 'Nigeria' ){
                
                    if ($myTransaction->newBalance < $request->amount) {
                        $o = (object) [
                            "message"=>"failed",
                            "value" => "Insufficient fund",
                             ];
                            $k[]=$o;
                            return $k;     
                         }

                 $value = $myTransaction->newBalance - $request->amount;

                $u = new Wallet();
                $u->userId = $user->id;
                $u->source = 'Share';
                $u->subtitle = 'to'.' '. $request->username;
                $u->amount =$request->amount;
                $u->oldBalance = $myTransaction->newBalance;
                $u->newBalance = $value;
                $u->transferedTo = $friend->name;
                $u->save();
                
                $newBalance = $friendsTransaction->newBalance + $request->amount;

                $uu = new Wallet();
                $uu->userId = $friend->id;
                $uu->source = 'Share';
                $uu->subtitle = 'to:'.' '.$user->username;
                $uu->amount =$request->amount;
                $uu->oldBalance = $friendsTransaction->newBalance;
                $uu->newBalance = $newBalance;
                $uu->transferedBy =  $user->name;
                $uu->save();

                $o = (object) [
                    "message"=>"success",
                    "value" => "Transfer is successfull",
                     ];
                    $k[]=$o;
                    return $k;

                }else if($user->country != 'Nigeria' &&  $friend->country == 'Nigeria'){
                
                    if ($myTransaction->newBalance < $request->amount) {
                        $o = (object) [
                            "message"=>"failed",
                            "value" => "Insufficient fund",
                             ];
                            $k[]=$o;
                            return $k;
                          }

                    $last = $newCalculate - $request->amount;
        
                    $u = new Wallet();
                    $u->userId = $user->id;
                    $u->source = 'Share';
                     $u->subtitle = 'to:'.' '. $request->username;
                    $u->amount =$request->amount;
                    $u->oldBalance = $myTransaction->newBalance;
                    $u->newBalance = $last;
                    $u->transferedTo = $friend->name;
                    $u->save();
                    
                    $newBalance = $friendsTransaction->newBalance + $request->amount;

                    $uu = new Wallet();
                    $uu->userId = $friend->id;
                     $uu->source = 'Share';
                     $uu->subtitle = 'from:'.' '. $user->username;
                    $uu->amount =$request->amount;
                    $uu->oldBalance = $friendsTransaction->newBalance;
                    $uu->newBalance = $newBalance;
                    $uu->transferedBy =  $user->name;
                    $uu->save();
                    
                    $o = (object) [
                        "message"=>"success",
                        "value" => "Transfer is successfull",
                         ];
                        $k[]=$o;
                        return $k;
                }
                   
                else if($user->country == 'Nigeria' &&  $friend->country != 'Nigeria'){  
                    $o = (object) [
                        "message"=>"failed",
                        "value" => "You can't transfer to out",
                         ];
                        $k[]=$o;
                        return $k;
                    
                }else{  
                    $o = (object) [
                        "message"=>"failed",
                        "value" => "Can not be completed!",
                         ];
                        $k[]=$o;
                        return $k;
        }
        } $o = (object) [
            "message"=>"failed",
            "value" => "User does not exist",
             ];
            $k[]=$o;
            return $k;
        
    } catch (\Exception $e) {
        Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
        $o = (object) [
            "message"=>"failed",
            "value" => "server error, try again later or contact support",
             ];
            $k[]=$o;
            return $k;
    }
}

       
    
    
    
    public function sendNotification66(Request $request)
    {
        //   try {
        $users = DB::table('users')->where('id', 101)->get();
//         $users = DB::table('users')->where('joined', 'Yes')->get();
//        $users = DB::table('users')->where('id',939)->get();
//        $users = DB::table('users')->whereNotNull('verifiedAt')->get();
//        $value=[];
//        $i=0;
        foreach ($users as $user) {
            
           
             
//
//
//                              $o = (object) [
//                              'id'=>$i,
//            'idd'=>$user->id,
//                              'name'=> $user->firstname .' '.$user->lastname,
//                              'phone'   =>   $user->countryCode . $user->phone,
//                          ];
//                         $value[]=$o;
//            $i++;

            //

            //
             $people = $user->firstname ?? $user->username;
            
            $bar = ucwords($people);
            

            $content =
'Dear '.$bar. ',
            We hope that this message meets you well. We are pleased to announce that that the wait for the Mhagic-Velocity talent competition is finally over!. Sequel to this, the Grand Opening Ceremony will go on tomorrow, January 31, from 7pm (WAT), you can only stream via your Mhagic app. Also, endeavour to update your Mhagic, more exciting features have been added! If you are yet to upload all your three videos (not more than 12mb portrait, each) for Week One, kindly do so, the window is still open. It promises to be 13 weeks of entertainment, creativity, innovation and resilience, your staying power will be tested week in, week out. Can you be last person standing? N25M  ($60, 000) cash prize awaits!. The world awaits your spell-bending talent and skills, make it happen!. The countdown is on...

Team Mhagic';
//
            $u = new Notification();
            $u->model = 'Single';
            $u->userId = $user->id;
            $u->title = 'Notice';
            $u->type = 'Text';
            $u->content = $content;
            // $u->contentUrl = 'Wk-1.mp4';
            $u->save();

        }
        return response()->json([
            'success' => true,
//                                'content' => $value,
            'message' => 'Sent..........................',
        ]);

        // } catch (\Exception $e) {
        //    Log::debug($e->getMessage());
        return response()->json(['error' => 'server error, try again later or contact support',
            'error value' => $e], 500);
        //}

    }

    public function mailbulk(Request $request)
    {

//        try {
        $mail = (object) null;
        $mail->template = 'email.pay';
        $mail->from_email = 'entry@mhagic.com';
        $mail->from_name = 'dume';
        $mail->to_email = 'dumenwobi@yahoo.com';
        $mail->to_name = 'Admin';
        $mail->subject = 'Confirm Payment';

        $mail->plan_name = 'kinkom';
        $mail->plan_amount = '7777777';

        $mail->investors_name = 'bloo';

        $send = (new MailHandler())->sendMail($mail);

        Log::error('sent: ' . json_encode($send));
//        } catch (\Exception $e) {
        //            Log::error($e->getMessage());
        //        }
        return back()->withStatus(_('Your investment will start running when payment is confirmed!'));
    }

//
    //    public function sendbulk(Request $request)
    //        {
    //           try {
    //                $users = DB::table('contestants')->where('class','Class4')->get();
    //                foreach ($users as $user) {
    //                  $u1 = DB::table('users')->where('contestId', $user->id)->whereNotNull('firstname')->first();
    //
    //                  if($u1){
    //
    //                    $people = $u1->firstname??$u1->username;
    //
    //       $one=   'Dear '.$people.',
    //          We are pleased to inform you that you have been selected to contest in the maiden season of the Mhagic-Velocity competition. It was a highly competitive selection process, and we believe that your inclusion would add value to the members of the audience, the Mhagic brand, Africa and the world at large.
    //
    //          Your journey to winning N25M ($60, 000) starts now, and we encourage you to give it your all.
    //
    //          Here are some of the actions you need to take right away:
    //
    //          i) Announce to your fans and connections that you have been selected to contest in the Mhagic-Velocity competition. Tag #themhagic on social media platforms, to identify with Mhagic official handles.
    //
    //          ii) Start building your fanbase immediately, you will need their support to progress each week.
    //
    //          iii) Prepare your first two videos for Week One, and must be uploaded on or before Saturday, 23rd, 10am, Lagos time. You will receive further notification with respect to the Week One Task video, all the three videos must be submitted on that date.
    //
    //          Here are guidelines on how to prepare your weekly videos:
    //
    //          Insert the guidelines here
    //
    //          This competition has a cash prize of N25M ($60, 000), therefore your work must show high level of diligence and seriousness, you cannot win by just showing up, you must demonstrate via the quality of your contents and videos that you are ready to compete and win. The contents, style and presentation must be excellent. Endeavour to always check the Notification page on your app for updates. Also go through the Rules, FAQs, T & C, Privacy Policies, you can access them via the Profile page within the app.
    //
    //          The Grand Opening Ceremony for this competition comes up on January 24th, 2021; it will be a live ceremony, to be watched via the app. Some contestants and members of the audience will have opportunity to take part in a live call with hosts and brand ambassadors. It will be a festival of innovation and entertainment, you have to live every moment of it.
    //
    //          Congratulations!
    //
    //          Regards,
    //          Team Mhagic';
    //
    //          $two = 'Dear '.$people.',
    //          Thank you for your interest in the Mhagic-Velocity talent/skill competition. This is a multi talent competition, where everyone has a voice, with an opportunity to participate from his/her location. We are pleased that our people have embraced the Mhagic brand wholeheartedly, we are grateful.
    //
    //          However, we regrettably wish to inform you that you are NOT selected to participate in this maiden season. We encourage you to follow the competition so as to enable you learn and improve on things that could make your application successful in the subsequent edition.
    //
    //          The competition promises a cash prize of N25M or $60, 000, and the quality of entry must reflect the diligence and seriousness expected of a competition of this magnitude.
    //
    //          At Mhagic, everyone has a voice, always make yours count. Good luck in your future endeavours.
    //
    //          Regards,
    //          Team Mhagic';
    //
    //      if($user->class!='Cancel' && $user->class!='None'){
    //
    //          if($user->class=='Class1'){
    //      $t='8am';
    //          }elseif($user->class=='Class2'){
    //              $t='10am';
    //          }elseif($user->class=='Class3'){
    //              $t='12pm';
    //          }elseif($user->class=='Class4'){
    //              $t='3pm';
    //          }
    //          else{
    //              $t='4pm';
    //          }
    //
    //
    //          DB::table('contestants')->where('id',$user->id)->update(['entry_at'=>$t]);
    //          $u = new Notification();
    //          $u->model = 'Single';
    //          $u->userId = $u1->id;
    //          $u->title = 'Notice';
    //          $u->type = 'text';
    //          $u->content = $one;
    //          $u->entry_at = $t;
    //          $u->save();
    //
    //      }
    //      else{
    //
    //          if($user->class=='Class1'){
    //      $t='8am';
    //          }elseif($user->class=='Class2'){
    //              $t='10am';
    //          }elseif($user->class=='Class3'){
    //              $t='12pm';
    //          }elseif($user->class=='Class4'){
    //              $t='3pm';
    //          }
    //          else{
    //              $t='4pm';
    //          }
    //          DB::table('contestants')->where('id',$user->id)->update(['evict_at'=>$t]);
    //          $u = new Notification();
    //          $u->model = 'Single';
    //          $u->userId = $u1->id;
    //          $u->title = 'Notice';
    //          $u->type = 'text';
    //          $u->evict_at = $t;
    //          $u->content = $two;
    //          $u->save();
    //
    //      }}
    //        }
    //        return response()->json([
    //            'success' => true,
    //            'message' => 'Sent..........................',
    //        ]);
    //
    //       } catch (\Exception $e) {
    //            Log::debug($e->getMessage());
    //            return response()->json(['error' => 'server error, try again later or contact support',
    //                'error value' => $e], 500);
    //       }
    //
    //        }

    public function setChannel(Request $request)
    {
        try {
            $value = DB::table('agoras')->first();

            $u1 = DB::table('agoras')->where('id', $value->id)->update(['channel' => $request->channel]);

            $value = DB::table('agoras')->first();
            return response()->json([
                'success' => true,
                'message' => $value,
            ]);

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }

    }

    public function getChannel(Request $request)
    {
        try {

            $value = DB::table('agoras')->first();
            return response()->json([
                'success' => true,
                'message' => $value,
            ]);

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }

    }

//        public function updateAfterSeletion(Request $request)
    //        {
    //             try {
    //
    //                $contestants = DB::table('contestants')->get();
    //                foreach ($contestants as $contestant) {
    //
    //                    if($contestant->class=='None' ||$contestant->class=='Cancel' ){
    //                  $u1 = DB::table('users')->where('contestId', $contestant->id)->update(['status'=>'Evicted']);
    //                  $u1 = DB::table('contestants')->where('id', $contestant->id)->update(['status'=>'Disqualified']);
    //
    //                }else{
    //                    $u1 = DB::table('users')->where('contestId', $contestant->id)->update(['status'=>'Accepted','joined'=>'Yes']);
    //                    $u1 = DB::table('contestants')->where('id', $contestant->id)->update(['status'=>'Runner']);
    //
    //                }
    //            }
    //            return response()->json([
    //                'success' => true,
    //                'message' => 'completed  ..........................',
    //            ]);
    //
    //
    //       } catch (\Exception $e) {
    //           Log::debug($e->getMessage());
    //            return response()->json(['error' => 'server error, try again later or contact support',
    //                'error value' => $e], 500);
    //       }
    //
    //        }

    public function test(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'videoUrl' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:10040|required',
        ]);

        $watermark = public_path('user-images/AIHCALL2.png');

        $ffmpeg = "C:\\ffmpeg\\bin\\ffmpeg";
        $filenameWithExt = $request->file('videoUrl')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('videoUrl')->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $destinationPath = public_path('video');

        $format = new FFMpeg\Format\Video\X264('libmp3lame', 'libx264');

        if (!empty($watermark)) {
            $destinationPath->filters()
                ->watermark($watermark, array(
                    'position' => 'relative',
                    'top' => 25,
                    'right' => 50,
                ));
        }

        $format
            ->setKiloBitrate(1000)
            ->setAudioChannels(2)
            ->setAudioKiloBitrate(256);

        $randomFileName = rand() . ".$reqExtension";
        $saveLocation = getcwd() . '/video/' . $randomFileName;
        $video->save($format, $saveLocation);

        dd('lllll');

    }

    public function updatePics(Request $request)
    {
        try {

            $token = (string) JWTAuth::getToken();
            if (!$token) {
                return response()->json([
                    'success' => true,
                    'error' => 'You are not authorized to access this content',
                ]);
            }

            $validator = Validator::make($request->all(), [
                'image' => 'max:2084|required',
            ]);

            if ($validator->fails()) {
                $error = validatorMessage($validator->errors());
                return response()->json(['error' => 'Image size should not be greater than 2084kb'], 422);
            }

            $user = JWTAuth::parseToken()->toUser();
            $imageMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/bmp', 'video/mp4', 'image/JPG'];

            $_filepath = public_path('user-images');

            $file = $request->file('image');
            $filename = 'IMG-App-' . $request->id . time() . '.' . $file->getClientOriginalExtension();

            $upload = $file->move($_filepath, $filename);

            $upload_path = $_filepath . '/' . $filename;
            if (file_exists($upload_path)) {
                $image_filesize = filesize($upload_path);
                if ($image_filesize > 4245330) {
                    return response()->json(['error' => 'reduce your file size and try again'], 422);
                }

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
                        $url = basename($thumbnail_path);

                        $detail = User::where('id', $user->id)->update([
                            'imageUrl' => $url,
                        ]);
                        $detail = User::where('id', $user->id)->first();

                        if ($detail) {
                            return response()->json([
                                'success' => true,
                                'userDetails' => $detail,
                            ], 200);}
                    }

                    return response()->json([
                        'error' => 'Upload failed',
                    ], 200);
                }
                return response()->json([
                    'success' => false,
                    'userDetails' => 'File Exist',
                ], 200);}
        } catch (\Exception $e) {
            print($e);
            return response()->json(['error' => 'Invalid file format, try again'], 422);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:4|max:255',
        ]);

        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => $error], 422);
        }

        $user = DB::table('users')->where('username', $request->username)->first();

        if (!$user) {
            return response()->json(['error' => 'user not found'], 422);
        }
        try {
            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Incorrect username or password'], 422);
            }

            if ($user->verifiedAt == null) {

                $token = rand(11111, 99999);
                $phone = $user->countryCode . $user->phone;

                $message = "<#> Your OTP is" . " " . $token . " " . "0wup7y9dGx5";

                $resultt = (new SMSGateway())->twilio($phone, $message);

                //$response = file_get_contents("https://kullsms.com/customer/api/?username=thisoksltd@gmail.com&password=1MillionOKs&message=$message&sender=mhagicLtd&mobiles=$phone");
                //$response = json_decode($response, true);

                if ($resultt) {
                    $u = new PasswordReset();
                    $u->userId = $user->id;
                    $u->token = $token;
                    $u->save();

                    $input = $request->only('username', 'password');

                    $result = (object) null;
                    $jwt_token = null;
                    if (!$jwt_token = JWTAuth::attempt($input)) {
                        return response()->json(['error' => 'login failed!'], 401);
                    }

                    $result->token = $jwt_token;
                    $result->user = $user;

                    return response()->json([
                        'success' => true,
                        'details' => $result,
                        'message' => 'Not verified',
                    ], 200);
                }
                return response()->json([
                    'error' => 'Verification code could not be sent to this Phone number',
                ], 200);
            }

            $user = User::where('username', $request->username)->whereNotNull('verifiedAt')->first();

            $input = $request->only('username', 'password');

            $jwt_token = null;
            if (!$jwt_token = JWTAuth::attempt($input)) {
                return response()->json(['error' => 'login failed!'], 401);
            }
            $result = (object) null;
            $result->token = $jwt_token;
            $result->user = $user;
            return response()->json([
                'success' => true,
                'details' => $result,
            ], 200);
        } catch (\Exception $e) {

            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'countryCode' => 'required',
            'country' => 'required',
            'phone' => 'required|unique:users',
            'password' => 'required|string|min:4|max:255',
        ]);

        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => $error], 422);
        }

        try {
            $user = new User();
            $user->status = 'Evicted';
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->country = $request->country;
            $user->countryCode = $request->countryCode;
            $user->password = bcrypt($request->password);
            $user->save();

            $u = new Wallet();
            $u->newBalance = '0';
            $u->oldBalance = '0';
            $u->amount = '0';
            $u->pending = '0';
            $u->subtitle = 'New account';
            $u->userId = $user->id;
            $u->save();

            $token = rand(11111, 99999);
            $phone = $user->countryCode . $user->phone;

            $message = "<#> Your OTP is" . " " . $token . " " . "0wup7y9dGx5";

            $resultt = (new SMSGateway())->twilio($phone, $message);

            //$response = file_get_contents("https://kullsms.com/customer/api/?username=thisoksltd@gmail.com&password=1MillionOKs&message=$message&sender=mhagicLtd&mobiles=$phone");
            //$response = json_decode($response, true);

            if ($resultt) {

                $u = new PasswordReset();
                $u->userId = $user->id;
                $u->token = $token;
                $u->save();

                $input = $request->only('username', 'password');
                $result = (object) null;
                $jwt_token = null;
                if (!$jwt_token = JWTAuth::attempt($input)) {
                    return response()->json(['error' => 'Registeration failed!'], 401);
                }

                $result->token = $jwt_token;
                $result->user = $user;

                return response()->json([
                    'success' => true,
                    'details' => $result,
                ], 200);

            } else {return response()->json([
                'error' => 'Failed to send Message',
            ], 401);
            }

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }
    }

    public function resend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => $error], 422);
        }

        $unique = DB::table('users')->where('username', $request->username)->first();

        try {
            if ($unique) {

                $token = rand(11111, 99999);

                $phone = $unique->countryCode . $unique->phone;
                $message = "<#> Your OTP is" . " " . $token . " " . "0wup7y9dGx5";

                $resultt = (new SMSGateway())->twilio($phone, $message);

                // $response = file_get_contents("https://kullsms.com/customer/api/?username=thisoksltd@gmail.com&password=1MillionOKs&message=$message&sender=mhagicLtd&mobiles=$phone");
                // $response = json_decode($response, true);

                if ($resultt) {

                    $u = new PasswordReset();
                    $u->userId = $unique->id;
                    $u->token = $token;
                    $u->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'sent',
                    ], 200);

                } else {return response()->json([
                    'error' => 'Failed to send Message',
                ], 401);
                }}
            return response()->json([
                'error' => 'Can not be completed',
            ], 401);
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }}

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|numeric',
            'username' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        try {
            $user = User::where('username', $request->username)->first();
            $t = DB::table('password_resets')->where('userId', $user->id)->where('token', $request->token)->delete();

            if (!$t) {return response()->json([
                'error' => 'Invalid code',
            ], 401);
            }

            DB::table('users')->where('username', $request->username)->update(['verifiedAt' => Carbon::now()]);
            $user = User::where('username', $request->username)->first();
            $token = (string) JWTAuth::getToken();

            $result = (object) null;
            $result->user = $user;
            $result->token = $token;
            return response()->json([
                'success' => true,
                'details' => $result,
            ], 200);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }
    }

    public function forgotPassword(Request $request) //stage 1

    {

        $validator = Validator::make($request->all(), [

            'userDetail' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        try {
            $check = DB::table('users')->where('username', $request->userDetail)->where('verifiedAt', '!=', null)->first();
            if ($check) {

                $token = rand(11111, 99999);

                $phone = $check->countryCode . $check->phone;

                $message = "<#> Your OTP is" . " " . $token . " " . "0wup7y9dGx5";

                $resultt = (new SMSGateway())->twilio($phone, $message);

                // $response = file_get_contents("https://kullsms.com/customer/api/?username=thisoksltd@gmail.com&password=1MillionOKs&message=$message&sender=mhagicLtd&mobiles=$phone");
                //$response = json_decode($response, true);

                if ($resultt) {
                    $u = new PasswordReset();
                    $u->userId = $check->id;
                    $u->token = $token;
                    $u->save();

                    $result = (object) null;
                    $result->user = $check;

                    return response()->json([
                        'success' => true,
                        'details' => $result,
                    ], 200);
                }
            }return response()->json([
                'error' => 'User not found',
            ], 200);

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }
    }

    public function verifvyAll(Request $request) //second stage

    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }

        try {

            $token = (string) JWTAuth::getToken();

            $done = PasswordReset::where('userId', $request->id)->where('token', $request->otp)->delete();
            if (!$done) {
                return response()->json([
                    'error' => 'Invalid code',
                ], 401);}

            $user = User::where('id', $request->id)->first();

            return response()->json([
                'success' => true,
                'userDetails' => $user->username,

            ], 200);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }

    }

    public function verifyAll(Request $request) ///stage 3

    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'token' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }
        try {
            $us = DB::table('users')->where('username', $request->username)->first();
            $done = PasswordReset::where('userId', $us->id)->where('token', $request->token)->delete();
            if (!$done) {
                return response()->json([
                    'error' => 'Invalid code',
                ], 401);}

            $check = DB::table('users')->where('username', $request->username)->update(['password' => Hash::make($request->get('password'))]);
            if ($check) {
                $user = DB::table('users')->where('username', $request->username)->first();
                $input = $request->only('username', 'password');

                $jwt_token = null;
                if (!$jwt_token = JWTAuth::attempt($input)) {
                    return response()->json(['error' => 'login failed!'], 401);
                }

                $result = (object) null;
                $result->token = $jwt_token;
                $result->user = $user;
                return response()->json([
                    'success' => true,
                    'details' => $result,
                ], 200);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }
    }

    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'password' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Could not be completed',
            ], 401);
        }
        try {
            $user = JWTAuth::parseToken()->toUser();
            if (!$user) {
                return response()->json([
                    'error' => 'You are not authorized to access this content',
                ]);
            }
            $check = DB::table('users')->where('phone', $request->phone)->where('verifiedAt', '!=', null)->first();
            if (Hash::check($request->get('oldPassword'), $check->password)) {
                auth()->user()->update(['password' => Hash::make($request->get('password'))]);
                return response()->json([
                    'success' => true,
                    'message' => 'Password successfully updated.',
                ], 200);
            } else {
                return response()->json([
                    'error' => 'You added a wrong password',
                ], 401);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
        }
    }

    public function updateUser(Request $request)
    {

        try {
            $user = JWTAuth::parseToken()->toUser();
            if (!$user) {
                return response()->json([
                    'error' => 'You are not authorized to access this content',
                ]);
            }

            if ($request->phone == $user->phone) {
                $detail = User::where('id', $user->id)->update([
                    'country' => $request->country ?? $user->country,
                    'phone' => $request->phone ?? $user->phone,
                    'email' => $request->email ?? $user->email,
                    'age' => $request->age ?? $user->age,
                    'about' => $request->about ?? $user->about,
                    'gender' => $request->gender ?? $user->gender,
                    'username' => $request->username ?? $user->username,
                    'firstname' => $request->firstname ?? $user->firstname,
                    'lastname' => $request->lastname ?? $user->lastname,
                    'occupation' => $request->occupation ?? $user->occupation,
                    'countryCode' => $request->countryCode ?? $user->countryCode,
                    'facebook' => $request->facebook ?? $user->facebook,
                    'tiktok' => $request->tiktok ?? $user->tiktok,
                    'twitter' => $request->twitter ?? $user->twitter,
                    'instagram' => $request->instagram ?? $user->instagram,
                    'linkedin' => $request->linkedin ?? $user->linkedin,

                ]);
                $detail = User::where('id', $user->id)->get();

                return response()->json([
                    'success' => true,
                    'userDetails' => $detail,
                ], 200);
            }
            return response()->json([
                'failed' => false,
                'error' => 'failed',
            ], 200);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['error' => 'server error, try again later or contact support',
                'error value' => $e], 500);
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

if (!function_exists('voip')) {
    /**
     * @param string $validator_errors
     *
     * @return string
     */
    function voip($value)
    {
        if ($value != null) {return true;} else {return false;}
    }
}

if (!function_exists('random_strings')) {
    /**
     * @param string $validator_errors
     *
     * @return string
     */
    function random_strings($length_of_string)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}
