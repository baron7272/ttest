<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Upload;
use App\Wallet;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Log;

class VoteController extends Controller
{

    public function voting(Request $request)
    {
        //////////////      1 vote is 10 naira
        /////////////       1usd is 30 voting powers
        $validator = Validator::make($request->all(), [
            'count' => 'required',
            'id' => 'required',
            'week' => 'required',
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

            $week = DB::table('admins')->first();

            if ($request->week == $week->week) {

                $uploadDetails = Upload::where('id', $request->id)->first();
                $result = (object) null;
                $currency = $user->country == 'Nigeria' ? 'Naira' : 'Dollar';

                $myTransaction = Wallet::where('userId', $user->id)->where('type', $currency)->first();

                if ($user->type == 'Dollar') {

                    $number = $myTransaction->newBallance / 30;

                    if ($number >= $request->count) {

                        $a = $number - $request->count;

                        if ($a > 1) {
                            $balance = $a / 30;
                        } else {
                            $balance = 0;}

                        $paid = $request->count / 30;

                        $u = new Wallet();
                        $u->userId = $user->id;
                        $u->source = 'Debit';
                        $u->subtitle = 'vote';
                        $u->amount = $paid;
                        $u->type = 'Dollar';
                        $u->oldBallance = $myTransaction->newBallance;
                        $u->newBallance = $balance;
                        $u->save();

                        $uu = new Vote();
                        $uu->votedBy = $user->id;
                        $uu->voteCount = $request->count;
                        $uu->week = $uploadDetails->week;
                        $uu->vote = $uploadDetails->vote;
                        $uu->save();

                        return response()->json([
                            'success' => false,
                            'error' => 'Voting was succesfull',
                        ]);

                    }
                    return response()->json([
                        'success' => false,
                        'error' => 'You have an insuficient fund',
                    ]);
                }

                $number = $myTransaction->newBallance / 10;

                if ($number >= $request->count) {

                    $a = $number - $request->count;

                    if ($a > 1) {
                        $balance = $a * 10;
                    } else {
                        $balance = 0;}

                    $paid = $request->count * 10;

                    $u = new Wallet();
                    $u->userId = $user->id;
                    $u->source = 'Debit';
                    $u->subtitle = 'vote';
                    $u->amount = $paid;
                    $u->type = 'Naira';
                    $u->oldBallance = $myTransaction->newBallance;
                    $u->newBallance = $balance;
                    $u->save();

                    $uu = new Vote();
                    $uu->votedBy = $user->id;
                    $uu->voteCount = $request->count;
                    $uu->week = $uploadDetails->week;
                    $uu->vote = $uploadDetails->vote;
                    $uu->save();

                    return response()->json([
                        'success' => false,
                        'error' => 'Voting was succesfull',
                    ]);

                }
                return response()->json([
                    'success' => false,
                    'error' => 'You have an insuficient fund',
                ]);

            }
            return response()->json(['error' => 'server error, try again later or contact support'], 500);
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString());
            return response()->json(['error' => 'server error, try again later or contact support', 'err' => $e], 500);
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
