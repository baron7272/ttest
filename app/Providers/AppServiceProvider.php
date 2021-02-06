<?php

namespace App\Providers;

use Auth;
use DB;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts.headers.cards', function ($view) {
            //investor
            // $a = DB::table('investments')->where('user_id', auth()->user()->id)->where('type','naira')->where('status','!=','Topped Up')->where('seen', 'yes')->sum('amount');
            // $b = DB::table('investments')->where('user_id', auth()->user()->id)->where('type','dollar')->where('status','!=','Topped Up')->where('seen', 'yes')->sum('amount');

            // $c= DB::table('investments')->where('user_id', auth()->user()->id)->where('type','naira')->where('status','!=','Topped Up')->where('seen', 'yes')->count();
            // $d = DB::table('investments')->where('user_id', auth()->user()->id)->where('type','dollar')->where('status','!=','Topped Up')->where('seen', 'yes')->count();
            // dd($b);
            // $m = DB::table('invest_drop_downs')->where('user_id', auth()->user()->id)->where('type','naira')->whereIn('status',['Paid','Ended'])->sum('per_month_or_bonus');
            // $mm = DB::table('invest_drop_downs')->where('user_id', auth()->user()->id)->where('type','dollar')->whereIn('status',['Paid','Ended'])->sum('per_month_or_bonus');
            // // dd($c);
            // $d = DB::table('invest_drop_downs')->where('user_id', auth()->user()->id)->where('status', 'Running')->where('type','naira')->sum('per_month_or_bonus');
            //  $dd = DB::table('invest_drop_downs')->where('user_id', auth()->user()->id)->where('status', 'Running')->where('type','dollar')->sum('per_month_or_bonus');
          
          
         

        //    $view->with(['total0' => $a , 'total1' => $b , 'total2' => $c, 'total3' => $d , 'total4' => $e , ]
        
        // );

        });

    }
}