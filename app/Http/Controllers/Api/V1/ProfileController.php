<?php

namespace App\Http\Controllers\Api\V1;

use App\Fan;
use App\Upload;
use App\Wallet;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Log;


class ProfileController extends Controller
{
    public function profilePage()
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
            $result->following = Fan::where('follower', $user->id)->where('deleted_at', null)->count();
            $result->followed = Fan::where('following', $user->id)->where('deleted_at', null)->count();
               
            $currency = $user->country == 'Nigeria' ? 'Naira' : 'Dollar';

            $amount = Wallet::where('userId', $user->id)->where('type', $currency)->first();

            $result->ballance = $amount->oldBallance - $amount->amount == $amount->newBallance ? $amount->newBallance : 'logOut';
            if ($ballance == 'logOut') {
                return response()->json([
                    'success' => false,
                    'error' => 'You are not authorized to access this content',
                    'message' => 'logOut',
                ]);
            }
            $result->uploads = Upload::where('uploadedBy', $user->id)->where('deletedAt', '')->count();

            return response()->json([
                'success' => true,
                'value' => $result,
            ]);

        } catch (\Exception $e) {

            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }

    public function profilePageList()
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
            $currency = $user->country == 'Nigeria' ? 'Naira' : 'Dollar';
            $transactions = Wallet::where('userId', $user->id)->where('type', $currency)->get();
            return response()->json([
                'success' => true,
                'value' => $transactions,
            ]);
        } catch (\Exception $e) {

            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        }
    }


}
