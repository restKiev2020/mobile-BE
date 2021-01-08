<?php

namespace App\Http\Services;

use App\Models\ConfirmationCode;

class VerificationCodeService
{
    private $clientService;

    public function __construct(SmsService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function send(string $phoneNumber): bool
    {
        $code = ConfirmationCode::create();

        $message = 'Your verification code is ' . $code->code;

        try {
            $this->clientService->send($phoneNumber, $message);
            return true;
        }
        catch (\Exception $exception) {
            return false;
        }
    }

    public function verfiy($code)
    {
        return ConfirmationCode::where(['code' => $code])->notExpired()->first();
    }

}
