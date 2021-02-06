<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */




Auth::routes();

//Investor Routes
Route::name('public.')->namespace('AllUsers')->group(function () {
    Route::namespace('Auth')->group(function () {
        //Login Routes
       
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');

        //Register Routes
        Route::get('/register', 'RegisterController@showRegisterForm')->name('register');
        Route::post('/register', 'RegisterController@register');

        //Forgot Password Routes
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/resset/pin/{id}', 'ResetPasswordPasswordController@verify')->name('verify');
        Route::post('/resetpassword', 'ResetPasswordPasswordController@resetpassword');
        Route::post('/confirmpassword/{id}', 'ResetPasswordPasswordController@confirmpassword')->name('confirmpassword');
        Route::get('/resetpassword', 'ResetPasswordPasswordController@showforgetpass')->name('resetpassword');

        //Email Verification Routes
        Route::get('/email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    });


    Route::group(['middleware' => 'auth:public'], function () {

        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/all-plan', 'HomeController@plans')->name('all-plan');
        Route::get('/plan/{id}/details', 'HomeController@getPlan')->name('plan');
        Route::post('/investing', 'HomeController@investing')->name('investing');

        Route::post('/preinvest', 'HomeController@preinvest')->name('preinvest');
        Route::get('/my-investment', 'HomeController@myInvestment')->name('my-investment');

        Route::get('/referrals', 'HomeController@referral')->name('referrals');
        Route::get('/info/{id}', 'HomeController@getInfo')->name('info');
        Route::get('/pay/{id}', 'HomeController@pay')->name('pay');

        Route::get('View Profile', ['as' => 'userprofile', 'uses' => 'ProfileController@displayProfile']);
        Route::get('profile', ['as' => 'edit', 'uses' => 'ProfileController@edit']);
        Route::put('profile', ['as' => 'update', 'uses' => 'ProfileController@update']);
        Route::put('profile/password', ['as' => 'password', 'uses' => 'ProfileController@password']);
        Route::get('/comfirmPayment/{id}', 'HomeController@comfirmPayment')->name('comfirmPayment');
    });

    Route::get('/pdf', 'HomeController@pdf');
});

Route::prefix('/admin')->name('admin.')->group(function () {
    
    Route::get('/' , function(){
        return view('welcome');
    });
        Route::namespace('Auth')->group(function () {
//         //Login Routes
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/dashboard', function () {
            return view('dashboard');
        });

        Route::get('/table', 'UserController@table')->name('table');
       

        Route::put('/contestantSearch', 'ContestantController@search')->name('contestantSearch');
        Route::put('/showSearch', 'ShowController@search')->name('showSearch');
        Route::get('/tableSearch', 'UserController@tableSearch')->name('tableSearch');
        

        
        Route::get('/contestant', 'ContestantController@contestant')->name('contestant');
        Route::get('/show/{search}', 'ShowController@show')->name('show');
        Route::get('/eviction', 'EvictionController@eviction')->name('eviction');
        
        Route::get('/account', 'AccountController@account')->name('account');
        Route::get('/manage', 'ManageController@manage')->name('manage');

        Route::get('/setClass/{set}/{set1}', 'ShowController@setClass')->name('setClass');

        Route::get('/deselectClass/{set1}', 'ShowController@deselectClass')->name('deselectClass');

        // Route::get('/contest/{search}', 'InvestmentController@contest')->name('userprofile');

      
     
        
    });



});



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'indartisanex'])->name('home');
// Auth::routes();



Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

});
