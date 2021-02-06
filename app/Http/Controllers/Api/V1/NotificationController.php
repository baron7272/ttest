<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Log;

class NotificationController extends Controller
{

    public function joinContest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            $error = validatorMessage($validator->errors());
            return response()->json(['error' => 'Network failed'], 422);
        }
        $user = JWTAuth::parseToken()->toUser();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'You are not authorized to access this content',
                'message' => 'logOut',
            ]);
        }

        if ($user->status != 'Spectator') {
            return response()->json([
                'success' => false,
                'error' => 'You are already in a group.',
                'message' => 'logOut',
            ]);
        }

        $ui = DB::table('notifications')->where('id', $request->id)->first();
        DB::table('users')->where('id', $user->id)->update(['contestId' => $ui->value, 'status' => 'Review']);

        return response()->json([
            'success' => true,
            'value' => 'sucess',
        ]);

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

            //  $notification = Notification::query()->get();
            $notification = DB::table('notifications')->orderBy('id', 'desc')->paginate(10);

            return response()->json([
                'success' => true,
                'value' => $notification,
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
