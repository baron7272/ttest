<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;

use App\User;
use App\Libraries\MailHandler;

use App\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;
use PDF;
use Carbon\Carbon;
use Session;

class WalletController extends Controller
{
    
    
    public function buy(Request $request)
       {
           return view('allUser.buy');
       }
  

}
