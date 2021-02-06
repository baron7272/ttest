<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
class HomeController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;

        $coin = DB::table('wallets')->where('userId', $id)->orderBy('id', 'desc')->whereNull('deleted_at')->first();
        $fans = DB::table('fans')->where('following', $id)->whereNull('deleted_at')->count();
        $follows = DB::table('fans')->where('follower', $id)->whereNull('deleted_at')->count();

        $uploads = DB::table('uploads')->orderBy('id', 'desc')->whereNull('deleted_at')->paginate(20);

        // $investment = Investment::where('plan_name',$request->plan)->where('status',$request->status)->WhereBetween('start_date',[$from, $to])->paginate(20000);
        $output = $uploads
            ->getCollection()
            ->map(function ($unit) {

                $comments = DB::table('comments')->where('uploadId', $upload->id)->whereNull('deleted_at')->get();

                return [
                    `id`=> $unit->id,
                    `contentUrl`=> $unit->contentUrl,
                    `contentImage`=> $unit->contentImage,
                    `uploadedBy`=> $unit->uploadedBy,
                    `uploadedAt`=> $unit->uploadedAt,
                    `week`=> $unit->week,
                    `created_at`=> $unit->created_at,
                    `comment`=> $comments,
                ];
            })->toArray();

        $value = new \Illuminate\Pagination\LengthAwarePaginator(
            $output,
            $uploads->total(),
            $uploads->perPage(),
            $uploads->currentPage(), [
                'path' => \Request::url(),
                'query' => [
                    'page' => $uploads->currentPage(),
                ],
            ]
        );

        return view('allUser.home', ['uploads'->$value, 'coins' => $coin->newBalance, 'fans' => $fans, 'follows' => $follows]);
    }

}
