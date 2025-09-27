<?php

namespace BehinInit\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Behin\Sms\Controllers\SmsController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpLoginController extends Controller
{
    public function view(string $phone)
    {
        $phone = convertPersianToEnglish($phone);

        return view('auth.verify-otp')->with(['phone' => $phone]);
    }

    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => ['required','string'],
        ]);
        $phone = convertPersianToEnglish($request->phone);

        $user = User::firstOrCreate(
            ['email' => $phone],
            [
                'name' => $phone,
                'password' => bcrypt(str()->random(12)),
                'role_id' => 3
            ]
        );
        $otp = random_int(100000, 999999);
        $user->reset_password_code = $otp;
        $user->save();
        $params = array([
            'name' => 'CODE',
            'value' => $otp
        ],
        [
            'name' => 'CODE',
            'value' => $otp
        ]);
        SmsController::sendByTemp($user->email, 755370, $params);

        return redirect()->route('otp.view', ['phone' => $phone])->with('success', 'کد تأیید ارسال شد.');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => ['required','string'],
            'otp' => ['required','string'],
        ]);

        $phone = convertPersianToEnglish($request->phone);
        $otp = convertPersianToEnglish($request->otp);

        $user = User::where('email', $phone)->first();
        if (! $user) {
            return redirect()->route('otp.view', ['phone' => $phone])->with('error', trans('auth.user not found'));
        }

        if ((string) $user->reset_password_code === (string) $otp) {
            $user->password = bcrypt(str()->random(12));
            $user->reset_password_code = null;
            $user->save();
            Auth::login($user, true);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('otp.view', ['phone' => $phone])->with('error', 'کد نامعتبر یا منقضی است');
    }
}
