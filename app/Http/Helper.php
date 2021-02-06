<?php
/**
 * Created by PhpStorm.
 * User: emnity
 * Date: 6/1/18
 * Time: 6:55 AM
 */

use App\Activity;
use App\Investment;
use App\Product;
use App\Setting;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use KingFlamez\Rave\Facades\Rave;

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

if (!function_exists('setActivity')) {
    /**
     *
     * @param $user
     * @param $tbl_name
     * @param $tbl_id
     * @param $description
     *
     * @return array
     */
    function setActivity($user, $tbl_name, $tbl_id, $action, $description = '')
    {
        $activity = Activity::create([
            'user_id' => $user,
            'tbl_name' => $tbl_name,
            'tbl_id' => $tbl_id,
            'action' => $action,
            'description' => $description,
        ]);

        return $activity;
    }
}

if (!function_exists('randomAlphabet')) {
    /**
     * @return string
     */
    function randomAlphabet($length, $mixed = false)
    {
        $permitted_chars = 'abcdefghijklmnopqrstuvwxyz';
        if ($mixed) {
            $permitted_chars .= '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        }

        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_character = $permitted_chars[mt_rand(0, strlen($permitted_chars) - 1)];
            $random_string .= $random_character;
        }

        return $mixed ? $random_string : strtoupper($random_string);
    }
}

if (!function_exists('randomNumber')) {
    /**
     * @return string
     */
    function randomNumber($length)
    {
        $permitted_chars = '0123456789';

        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_character = $permitted_chars[mt_rand(0, strlen($permitted_chars) - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}

if (!function_exists('checkInput')) {
    /**
     * @return string
     */
    function checkInput($data, $key)
    {
        return isset($data[$key]) ? $data[$key] : NULL;
    }
}

if (!function_exists('getActivity')) {
    /**
     * @return string
     */
    function getActivity($name, $id)
    {
        switch ($name) {
            case 'products':
                $product = Product::with('user', 'category')->where('id', $id)->first();

                return $product;
            case 'transactions':
                $transaction = Transaction::with('user')->where('id', $id)->where('status', 1)->first();
                if ($transaction) {
                    $transaction->product = Product::with('user', 'category')->where('id', $transaction->product_id)->first();
                }

                return $transaction;
            case 'investments':
                $investment = Investment::with('user')->where('id', $id)->first();
                $investment->product = Product::with('category')->where('id', $investment->product_id)->first(['id', 'status', 'category_id']);

                return $investment;
            default:
                return null;
                break;
        }
    }
}

if (!function_exists('checkHoliday')) {
    /**
     * @param $date string
     * @return string
     */
    function checkHoliday($date)
    {
        $holidays = ['04-07', '23-12', '24-12', '25-12', '26-12', '27-12', '28-12', '29-12', '30-12', '31-12', '01-01'];
        if ($date instanceof \DateTime) {
            $date = $date->format('d-m');
            if (in_array($date, $holidays)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('addWorkingDays')) {
    /**
     * @return string
     */
    function addWorkingDays($date, $day)
    {
        if (!($date instanceof \DateTime) || is_string($date)) {
            $date = new \DateTime($date);
        }

        if ($date instanceof \DateTime) {
            $newDate = clone $date;

            if ($day == 0) {
                return $newDate;
            }

            $i = 1;
            while ($i <= abs($day)) {
                $newDate->modify(($day > 0 ? ' +' : ' -') . '1 day');
                $next_day_number = $newDate->format('N');
                if (!in_array($next_day_number, [6, 7])) {
                    if (!checkHoliday($newDate)) {
                        $i++;
                    }
                }
            }

            return $newDate->format('Y-m-d');
        }

        return null;
    }
}

if (!function_exists('addDays')) {
    /**
     * @return string
     */
    function addDays($date, $days)
    {
        if (!($date instanceof \DateTime) || is_string($date)) {
            $date = new \DateTime($date);
        }

        if ($date instanceof \DateTime) {
            $newDate = clone $date;
            $newDate->modify('+'.$days.' day');

            return $newDate->format('Y-m-d');
        }

        return null;
    }
}

if (!function_exists('getWorkingDay')) {
    /**
     * @return string
     */
    function getWorkingDay($date, $category, $return_time)
    {
        if (!($date instanceof \DateTime) || is_string($date)) {
            $date = new \DateTime($date);
        }

        if ($category == 'forex') {
            if ($date instanceof \DateTime) {
                $newDate = clone $date;

                $day_number = $newDate->format('N');
                if (!in_array($day_number, [6, 7])) {
                    if (!checkHoliday($newDate)) {
                        error_log('not-hols '.$newDate->format('d-m-y'));
                        return $newDate->format('Y-m-d');
                    }
                    else {
                        $h = 0;
                        do {
                            error_log('hols '.$newDate->format('d-m-y'));
                            $newDate->modify('+1 day');
                            $next_day_number = $newDate->format('N');
                            if (in_array($next_day_number, [6, 7])) {
                                $h++;
                            } else {
                                if (checkHoliday($newDate)) {
                                    $h++;
                                } else {
                                    $h = 0;
                                }
                            }
                        } while ($h != 0);

                        return $newDate->format('Y-m-d');
                    }
                } else {
                    // get next non weekend date
                    $j = 0;
                    do {
                        $newDate->modify('+1 day');
                        $next_day_number = $newDate->format('N');
                        if (in_array($next_day_number, [6, 7])) {
                            $j++;
                        } else {
                            if (checkHoliday($newDate)) {
                                $j++;
                            } else {
                                $j = 0;
                            }
                        }
                    } while ($j != 0);

                    return $newDate->format('Y-m-d');
                }
            }
        } elseif ($category == 'movie' || $category == 'agriculture') {
            if ($date instanceof \DateTime) {
                $newDate = clone $date;
                $newDate->modify('+1 day');

                return $newDate->format('Y-m-d');
            }
        }

        return null;
    }
}

if (!function_exists('getReturnDate')) {
    /**
     * @return string
     */
    function getReturnDate($date, $category, $return_time)
    {
        if (!($date instanceof \DateTime) || is_string($date)) {
            $date = new \DateTime($date);
        }

        if ($category == 'forex' && $return_time == '30-working-days') {
            if ($date instanceof \DateTime) {
                $newDate = clone $date;

                $day_number = $newDate->format('N');
                if (!in_array($day_number, [6, 7])) {
                    if (!checkHoliday($newDate)) {
                        error_log('not-hols '.$newDate->format('d-m-y'));
                        return $newDate->format('Y-m-d');
                    }
                    else {
                        $h = 0;
                        do {
                            error_log('hols '.$newDate->format('d-m-y'));
                            $newDate->modify('+1 day');
                            $next_day_number = $newDate->format('N');
                            if (in_array($next_day_number, [6, 7])) {
                                $h++;
                            } else {
                                if (checkHoliday($newDate)) {
                                    $h++;
                                } else {
                                    $h = 0;
                                }
                            }
                        } while ($h != 0);

                        return $newDate->format('Y-m-d');
                    }
                } else {
                    // get next non weekend date
                    $j = 0;
                    do {
                        $newDate->modify('+1 day');
                        $next_day_number = $newDate->format('N');
                        if (in_array($next_day_number, [6, 7])) {
                            $j++;
                        } else {
                            if (checkHoliday($newDate)) {
                                $j++;
                            } else {
                                $j = 0;
                            }
                        }
                    } while ($j != 0);

                    return $newDate->format('Y-m-d');
                }
            }
        } elseif ($category == 'movie' || $category == 'agriculture' || ($category == 'forex' && $return_time == '30-days')) {
            if ($date instanceof \DateTime) {
                $newDate = clone $date;
                $newDate->modify('+1 day');

                return $newDate->format('Y-m-d');
            }
        }

        return null;
    }
}

if (!function_exists('calcUnsoldOks')) {
    /**
     * @return string
     */
    function calcUnsoldOks($product)
    {
        $investments = Investment::where('product_id', $product->id)->get();
        $no_oks = 0;
        foreach ($investments as $investment) {
            $no_oks += $investment->no_of_oks;
        }

        $unsold = (int)$product->no_of_oks - $no_oks;

        return $unsold;
    }
}

if (!function_exists('sendNotification')) {
    /**
     * @return array
     */
    function sendNotification($tokens, $message)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = env('FIREBASE_API_KEY');
        Log::debug('Helper.php Line 305 start ----------------------------: ' . json_encode($tokens));

        $notification = array(
            'body' => $message,
            'title' => 'ThisOKs',
            'vibrate' => 1,
            'sound' => 1,
        );

        $payload = [
            'registration_ids' => $tokens,
            'notification' => $notification,
            'priority' => 'high',
        ];

        $headers = array(
            'Content-Type: application/json',
            'Authorization: key=' . $api_key
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $result = curl_exec($ch);
        Log::info('helper.php Line 335 '.json_encode($result));

        if (curl_error($ch) != '') {
            error_log(json_encode($ch));
            $error = curl_error($ch);
            curl_close($ch);
            return ['error' => $error];
        }

        curl_close($ch);
        return ['success' => 'sent'];
    }
}

if (!function_exists('numToOrdinalWord')) {
    function numToOrdinalWord($num)
    {
        $first_word = array('eth', 'First', 'Second', 'Third', 'Fouth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth');
        $second_word = array('', '', 'Twenty', 'Thirthy', 'Forty', 'Fifty');

        if ($num <= 20) {
            return $first_word[$num];
        }

        $first_num = substr($num, -1, 1);
        $second_num = substr($num, -2, 1);

        return $string = str_replace('y-eth', 'ieth', $second_word[$second_num] . '-' . $first_word[$first_num]);
    }
}

if (! function_exists('verifyRave')) {
    /**
     * Verify flutterwave transaction.
     *
     * @param  string $reference
     * @return null || object
     */
    function verifyRave($reference)
    {
        try {
            $transaction = Rave::verifyTransaction($reference);
            if ($transaction->status === "success"){
                return $transaction->data;
            }

            Log::error('Helper Line 454: payment verification failed: ' . json_encode($transaction));
            return null;
        } catch (\Exception $e) {
            Log::error($e->getLine() . ': ' . $e->getMessage() . ': ' . $e->getFile());
            return null;
        }
    }
}

if (! function_exists('getNamesList')) {
    /**
     * Possible user options.
     *
     * @param  App\User $user
     * @return array
     */
    function getNamesList($user)
    {
        $array = [
            strtolower($user->firstname.' '.$user->lastname),
            strtolower($user->lastname.' '.$user->firstname),
            strtolower($user->firstname.' '.$user->othername),
            strtolower($user->othername.' '.$user->firstname),
            strtolower($user->lastname.' '.$user->othername),
            strtolower($user->othername.' '.$user->lastname),
            strtolower($user->firstname.' '.$user->lastname.' '.$user->othername),
            strtolower($user->firstname.' '.$user->othername.' '.$user->lastname),
            strtolower($user->lastname.' '.$user->firstname.' '.$user->othername),
            strtolower($user->lastname.' '.$user->othername.' '.$user->firstname),
            strtolower($user->othername.' '.$user->firstname.' '.$user->lastname),
            strtolower($user->othername.' '.$user->lastname.' '.$user->firstname),
        ];

        return $array;
    }
}

if (! function_exists('compressImage')) {
    /**
     *
     * @param $source string
     * @param $destination string
     * @param $quality string
     *
     * @return string
     */
    function compressImage($source, $destination, $quality, $pngQuality)
    {
        try {
            $info = getimagesize($source);

            switch ($info['mime']) {
                case 'image/pjpeg':
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($source);
                    imagejpeg($image, $destination, $quality);
                    break;
                case 'image/png':
                case 'image/x-png':
                    $new_image = imagecreatefrompng($source);
                    imagealphablending($new_image , false);
                    imagesavealpha($new_image , true);
                    imagepng($new_image, $destination, $pngQuality);
                    break;
                case 'image/gif':
                    $new_image = imagecreatefromgif($source);
                    imagealphablending($new_image, false);
                    imagesavealpha($new_image, true);
                    imagegif($new_image, $destination);
                    break;
                default:
                    break;
            }

            return $destination;
        } catch (\Exception $e){
            error_log($e->getLine().': '.$e->getMessage());
            return $source;
        }
    }
}

if (! function_exists('checkAndSetBoarding')) {
    /**
     *
     * @param $product
     *
     * @return null || $product
     */
    function checkAndSetBoarding($product)
    {
        try {
            $expiration = Setting::where('user_id', 1)->where('name', 'expiration')->first();

            // check for onboarding
            $onboarding_product = Product::where('status', 'onboarding')->whereNotNull('onboarded_at')->where('approved', 1)->first();
            if($onboarding_product == null || ($onboarding_product && $onboarding_product->category_id != $product->category_id)){
                // next product
                $next_product = Product::where('status', 'next')->whereNull('onboarded_at')->where('approved', 1)->first();
                if ($next_product) {
                    $next_product->status = 'onboarding';
                    $next_product->onboarded_at = date('Y-m-d H:i:s');
                    $next_product->expiration = $expiration->value;
                    $next_product->expiration_at = Carbon::now()->addDays($expiration->value)->format('Y-m-d H:i:s');
                    $next_product->save();

                    return $next_product;
                }
            }

            return null;
        } catch (\Exception $e){
            error_log($e->getLine().': '.$e->getMessage());
            return null;
        }
    }
}

if (! function_exists('maskNumber')) {
    /**
     *
     * @param $number string
     *
     * @return string
     */
    function maskNumber($number)
    {
        $last4digits = substr($number, -4);
        return substr($number, 0, 2).'****'.$last4digits;
    }
}

if (! function_exists('inArray')) {
    /**
     *
     * @param array $account_names
     * @param array $mynames
     *
     * @return string
     *
     */
    function inArray($account_names, $mynames)
    {
        $returns = [];
        for ($i=0; $i<count($account_names); $i++){
            for ($j=0; $j<count($mynames); $j++){
                if($account_names[$i] == $mynames[$j]){
                    $returns[] = 1;
                }
                else {
                    $returns[] = 0;
                }
            }
        }

        return array_product($returns) == 1;
    }
}
