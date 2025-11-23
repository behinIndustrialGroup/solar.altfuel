<?php

namespace Behin\Sms\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Melipayamak\MelipayamakApi;
use Illuminate\Support\Facades\Http;

class SmsController2 extends Controller
{
    private $url;
    private $user;
    private $pass;
    private $org;

    public function __construct() {}
    public static function send($to, $msg)
    {
        $url = 'https://payamsms.com/services/rest/index.php';
        $data = array(
            'organization' => env('SMS_ORG'),
            'username' => env('SMS_USER'),
            'password' => env('SMS_PASS'),
            'method' => 'send',
            'messages' => array([
                'sender' => env('SMS_SENDER'),
                'recipient' => $to,
                'body' => $msg,
                'customerId' => 1,
            ])
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error($error);
            return false;
        }
        return true;
    }

}
