<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OtpLoginController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'phone' => ['required','string'],
        ]);

        $otp = random_int(100000, 999999);
        Cache::put('otp_'.$request->phone, $otp, now()->addMinutes(5));
        // In real implementation, send SMS here
        Log::info('OTP for '.$request->phone.': '.$otp);

        return response()->json(['message' => 'کد ارسال شد.']);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => ['required','string'],
            'otp' => ['required','string'],
        ]);

        $cached = Cache::get('otp_'.$request->phone);
        if ($cached && $cached == $request->otp) {
            $user = User::firstOrCreate(
                ['phone' => $request->phone],
                [
                    'name' => $request->phone,
                    'email' => $request->phone.'@example.com',
                    'password' => bcrypt(str()->random(12)),
                ]
            );
            Auth::login($user);
            Cache::forget('otp_'.$request->phone);
            return response()->json(['message' => 'ورود موفق']);
        }

        return response()->json(['message' => 'کد نامعتبر یا منقضی است.'], 422);
    }
}
