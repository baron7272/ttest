<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
Route::get('/forum', function () {
    echo 'Forum Index';
});

Route::namespace ('Api\V1')->group(function () {

    Route::prefix('v1')->group(function () {
        Route::prefix('auth')->group(function () {
            //Route::post('logindd', 'AuthController@logindd'); 
            Route::post('register', 'AuthController@register'); 
            Route::post('resend', 'AuthController@resend'); 
            Route::post('verifyAll', 'AuthController@verifyAll'); 
            Route::post('verify', 'AuthController@verify'); 
            Route::post('login', 'AuthController@login'); 
            Route::post('forgotPassword', 'AuthController@forgotPassword'); 

            Route::post('makeMyUploads1', 'ExploreController@makeMyUploads1');
        });

        Route::group(['middleware' => ['api', 'auth.jwt']], function () {
            Route::get('updateUser', 'AuthController@updateUser'); 

            Route::post('updatePics', 'AuthController@updatePics'); 
            Route::post('updateUser', 'AuthController@updateUser'); 
            Route::post('generalDetails', 'HomeController@generalDetails');

            Route::post('getUploads', 'ExploreController@getUploads');

            Route::post('explorePage', 'ExploreController@explorePage'); 
            Route::post('exploreApplicationPage', 'ExploreController@exploreApplicationPage');
            Route::post('exploreClassPage', 'ExploreController@exploreClassPage');
            Route::post('exploreSponsorsPage', 'ExploreController@exploreSponsorsPage');

            Route::post('getMyUploads', 'ExploreController@getMyUploads');
            Route::post('makeMyUploads1', 'ExploreController@makeMyUploads1');
            Route::post('makeMyUploads2', 'ExploreController@makeMyUploads2');

            Route::post('createContestant', 'ExploreController@createContestant');
            Route::post('createContestant1', 'ExploreController@createContestant1');
            Route::post('getUsers', 'ExploreController@getUsers');
            Route::post('sponsor', 'ExploreController@sponsor');

            Route::post('resetPassword', 'AuthController@resetPassword'); 
            Route::post('getUserInfo', 'HomeController@getUserInfo');
            Route::post('unFollow', 'HomeController@unFollow');
            Route::post('follow', 'HomeController@follow');

            Route::post('getFullInfo', 'HomeController@getFullInfo');
            Route::get('homePage', ['as' => 'item', 'uses' => 'HomeController@homePage']);
            Route::post('checkUser', 'WalletController@checkUser');

            Route::post('searching', 'HomeController@searching');
            Route::post('stream', 'HomeController@stream');
            Route::post('getComment', 'HomeController@getComment'); 
            Route::post('createComment', 'HomeController@createComment'); 

            Route::post('unFollowPrivate', 'HomeController@unFollowPrivate'); 

            Route::post('followPrivate', 'HomeController@followPrivate'); 

            Route::post('getPrivateFollow', 'HomeController@getPrivateFollow'); 

            Route::post('voting', 'HomeController@voting'); 
            Route::get('notificationPage', ['as' => 'item', 'uses' => 'NotificationController@notificationPage']);
            Route::get('walletList', ['as' => 'item', 'uses' => 'WalletController@walletList']);
            Route::get('getComment', ['as' => 'item', 'uses' => 'HomeController@getComment']);
            Route::get('createComment', ['as' => 'item', 'uses' => 'HomeController@createComment']);

            Route::get('homeSelectedCategory', ['as' => 'item', 'uses' => 'HomeController@homeSelectedCategory']);

            Route::get('getCategory', ['as' => 'item', 'uses' => 'ExploreController@getCategory']);

            Route::post('joinContest', 'NotificationController@joinContest');
            Route::post('profilePage', 'ProfileController@profilePage');
            Route::post('profilePageList', 'ProfileController@profilePageList');
            Route::post('walletTransfer', 'WalletController@walletTransfer');
            Route::post('creditWallet', 'WalletController@creditWallet');

        });

        Route::get('/', function () {
            return response()->json(['message' => 'Mhagic']);
        });
    });

});
