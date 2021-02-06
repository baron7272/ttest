<?php

namespace App\Http\Controllers\Api\V1;

use App\Fan;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Upload;
use App\Wallet;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Log;
use Illuminate\Support\Facades\Hash;
use Unirest\Request\Body;
class WalletController extends Controller
{

    public function walletList()
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
              $result->balance = DB::table('wallets')->where('userId', $user->id)->orderBy('id', 'desc')->whereNull('deleted_at')->first();
            $result->fan = Fan::where('following', $user->id)->where('deleted_at', null)->count();
            $result->following = Fan::where('follower', $user->id)->where('deleted_at', null)->count();
            if ($user->contestId != null && $user->joined == 'Yes') {
                $result->upload = Upload::where('uploadedBy', $user->contestId)->where('deleted_at', null)->count();

            } else { $result->upload = '0';}

             $pageCount = DB::table('wallets')->where('userId', $user->id)->where('subtitle','!=','New account')->orderBy('id', 'desc')->whereNull('deleted_at')->count();
            $result->notification = DB::table('wallets')->where('userId', $user->id)->where('subtitle','!=','New account')->orderBy('id', 'desc')->whereNull('deleted_at')->paginate(5);
            
            return response()->json([
                'success' => true, 
                'pageCount'=>$pageCount,
               'value' => $result,
                 
            ]);
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function notificationPage()
    {

        $category = Input::get('value', 'default value');
        $id = Input::get('id', false);

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }
        try {

            $notification = DB::table('notifications')->paginate(4);

            return response()->json([
                'success' => true,
                'value' => $notification,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function verifyPayment(Request $request)
    {

        $validator = Validator::make($request->all(), [
          //  'flwRef' => 'required',
              'amount' => 'required',
            'txRef' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => $error], 422);
        }

        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }

//
       $data = [
           'txref' => $request->txRef,
          // 'SECKEY' =>$request->flwRef,
'SECEY'=>'6b2090cc57ad177a08a66f23',
'FLWPUBK-cedd1e6b0c128cb5e4e4add60b34e894-X',
       ];

       $headers = array('Content-Type' => 'application/json');
       try {
           $body = Body::json($data);
           $url = 'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify';
           $url = "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify";

           $response = \Unirest\Request::post($url, $headers, $body);

           $responseBody = $response->raw_body;


//dd( '$responseBody');

           if (($response->body->data->status === "successful") &&
               ($response->body->data->chargecode === "00" || $response->body->data->chargecode === "0")
           ) {

            //    $amountPayable = $batch->fee;
               $amountPaid = $response->body->data->amount;
            //    if ($amountPaid == $amountPayable) {

                    $result = (object) null;
                    $currency = $user->country == 'Nigeria' ? 'Naira' : 'Dollar';

                    $myTransaction = Wallet::where('userId', $user->id)->orderBy('id','desc')->where('type', $currency)->first();

                    if ($user->type == 'Dollar') {

                      //  $total = $myTransaction->newBalance + $amountPaid;
                           $total = $myTransaction->newBalance + $request->amount;
                        $u = new Wallet();
                        $u->userId = $user->id;
                        $u->source = 'Bought';
                        $u->subtitle = 'self';
                        $u->amount = $request->amount;
                        //$u->amount = $amountPaid;
                        $u->type = 'Dollar';
                        $u->oldBalance = $myTransaction->newBalance;
                        $u->newBalance = $total;
                        $u->save();
                           $myTransaction = Wallet::where('userId', $user->id)->orderBy('id','desc')->where('type', $currency)->first();

                        $uuu = new Notification();
                        $uuu->model = 'Single';
                        $uuu->title = 'Notice';
                        //$uuu->content = 'You credited your account with' . ' ' . $amountPaid . 'USD';
                        $uuu->content = 'You credited your account with' . ' ' . $request->amount . 'USD';
                        $uuu->type = 'Text';
                        $uuu->userId = $user->id;
                        $uuu->save();

                        if ($uuu) {

                            return response()->json([
                                'success' => true,
                                'balance' => $myTransaction,
                                'message' => 'Succesfully credited your account',
                            ]);
                        }
                        return response()->json([
                            'success' => false,
                            'error' => 'Payment Failed, please contact support',
                        ]);
                    } else {

                        //$total = $myTransaction->newBalance + $amountPaid;
                       $total = $myTransaction->newBalance + $request->amount;


                        $u = new Wallet();
                        $u->userId = $user->id;
                        $u->source = 'Bought';
                        $u->subtitle = 'self';
                       // $u->amount = $amountPaid;
                        $u->amount = $request->amount;
                        $u->type = 'Naira';
                        $u->oldBalance = $myTransaction->newBalance;
                        $u->newBalance = $total;
                        $u->save();
                             $myTransaction = Wallet::where('userId', $user->id)->orderBy('id','desc')->where('type', $currency)->first();
                        $uuu = new Notification();
                        $uuu->model = 'Single';
                        $uuu->title = 'Notice';
                       // $uuu->content = 'You credited your account with' . ' ' . 'N' . $amountPaid;
                       $uuu->content = 'You credited your account with' . ' ' . 'N' . $request->amount;
                        $uuu->type = 'Text';
                        $uuu->userId = $user->id;
                        $uuu->save();

                        if ($uuu) {

                            return response()->json([
                                'success' => true,
                                'balance' => $myTransaction,
                                'message' => 'Succesfully credited your account',
                            ]);
                        }
                        return response()->json([
                            'success' => false,
                            'error' => 'Payment Failed, please contact support',
                        ]);
                    }

            //    }

            //    return response()->json([
            //        'error' => false,
            //        'message' => 'Payment Failed, please contact support',
            //    ]);

           }
           return response()->json([
               'error' => false,
               'message' => 'Payment Failed, please contact support',
           ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'server error, try again later or contact support',], 500);
        }
    }

    public function checkUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => $error], 422);
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
            $get = DB::table('users')->where('username', $request->username)->first();
            if ($get) {
                return response()->json([
                    'success' => true,
                    'details' => $get,
                ]);
            }
            return response()->json([
                
                'error' => 'User not found',
            ]);
        } catch (\Exception $e) {
            return $this->withMessage($e->getMessage(), 500);
        }
    }


    public function walletTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'amount' => 'required',
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
            $friend = User::where('username', $request->username)->first();
              if ($user->username==$friend->username) {
            return response()->json([
                'success' => false,
                'message' => 'Transfering to yourself not allowed',
            ]);
        }

            if ($friend != null) {
                $currency = $user->country == 'Nigeria' ? 'Naira' : 'Dollar';
                $friendscurrency = $friend->country == 'Nigeria' ? 'Naira' : 'Dollar';
                $myTransaction = Wallet::where('userId', $user->id)->where('type', $currency)->orderBy('id', 'DESC')->first();
                $friendsTransaction = Wallet::where('userId', $friend->id)->where('type', $currency)->orderBy('id', 'DESC')->first();

                    if( $user->country == 'Nigeria'&&  $friend->country == 'Nigeria' ||$user->country != 'Nigeria' &&  $friend->country != 'Nigeria' ){
                    
                        if ($myTransaction->newBalance < $request->amount) {
                            return response()->json([
                    'success' => false,
                    'message' => 'Insufficient fund',
                ]);
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

                    return response()->json([
                        'success' => true,
                        'value' => $u,
                         'message'=>'Transfer was successfull',
                    ]);


                    }else if($user->country != 'Nigeria' &&  $friend->country == 'Nigeria'){

                    $newCalculate=$myTransaction->newBalance;

                        if ($newCalculate < $request->amount) {
                            return response()->json([
                    'success' => false,
                    'message' => 'Insufficient fund',
                ]);
                        }
                        $value = $newCalculate - $request->amount;
                        $last=$value;

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
                        
                        return response()->json([
                            'success' => true,
                            'value' => $u,
                        ]);
                    }  
                       
                    else if($user->country == 'Nigeria' &&  $friend->country != 'Nigeria'){  return response()->json([
                        'error' => 'You cant transfer to Dollar',
                    ], 401);}else{  return response()->json([
                        'error' => 'Can not be completed',
                    ], 401
                );
            }

            }return response()->json([
                'success' => false,
                'message' => 'User does not exist',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }


    public function creditWallet()
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
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
                if ($request->id) {
                    $myTransaction = Wallet::where('userId', $user->id)->orderBy('id', 'desc')->first();

                    if($user->country=='Nigeria'){

                    $v = $request->amount / 10;

                    $newBalance = $myTransaction->oldBalance + $v;
                    }else{
                        $v = $request->amount * 30;
                        $newBalance = $myTransaction->oldBalance + $v;
                    }
                    $u = new Wallet();
                    $u->userId = $user->id;
                    $u->source = 'Bought';
                    $u->amount =$request->amount;
                    $u->oldBalance = $myTransaction->newBalance;
                    $u->newBalance = $newBalance;
                    $u->save();

                  
                    // $myTransaction = Wallet::where('userId', $friend->id)->update([ 'source' => 'Bought', 'amount' => $request->amount, 'oldBalance' => $myTransaction->newBalance, 'newBalance' => $newBalance]);

                    return response()->json([
                        'success' => true,
                        'value' => $u,
                    ]);
        
                    }
                    return response()->json([
                        'success' => false,
                        'message' => 'failed',
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
