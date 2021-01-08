<?php

namespace App\Http\Controllers\Api\Verification;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendCodeRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\Services\VerificationCodeService;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SmsController extends Controller
{

    public function sendCode(SendCodeRequest $request, VerificationCodeService $codeVerification)
    {
        $phoneNumber = $request->validated()['phone_number'];

        if (!User::where(['phone_number' => $phoneNumber])->exists()) {
            return response()->json('User not found', 404);
        }

        $stripedPhone = preg_replace('/[\W]/m', '', $phoneNumber);
        if (Cache::has($stripedPhone)) {
            return response()->json('Cannot send phone verification more than once a minute', 429);
        }

        Cache::put($stripedPhone, Carbon::now()->addMinutes(1));

        $isSent = $codeVerification->send($phoneNumber);

        if (!$isSent) {
            return response(\Lang::get('confirmation.code.notSent'), 503);
        }

        return response(\Lang::get('confirmation.code.sent'), 200);
    }

    public function verifyCode(VerifyCodeRequest $request, VerificationCodeService $codeVerification)
    {
        $codeString = $request->validated()['code'];

        $isVerified = $codeVerification->verfiy($codeString);

        if(!$isVerified) {
            return response(\Lang::get('confirmation.code.verify'), 409);
        }

        Auth::user()->verify();

        return response('Confirmed', 200);
    }

}
