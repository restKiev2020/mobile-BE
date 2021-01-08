<?php

namespace App\Http\Services;

use Firebase\JWT\JWT;

class JWTService
{

    public static function sign($userId) {
        $path = base_path('keys/private.key');
        $privateKey = file_get_contents($path);

        $options = [
            'iss' => 'Nedvibot/ws',
            'aud' => 'Nedvibot/fe',
            'sub' => $userId,
            'iat' => \Carbon\Carbon::now()->getTimestamp(),
            'exp' => \Carbon\Carbon::now()->addDays(15)->getTimestamp()
        ];

        return JWT::encode($options, $privateKey, 'RS256');
    }

    public static function verify($jwt) {
        $path = base_path('keys/public.key');
        $publicKey = file_get_contents($path);

        try {
            JWT::decode($jwt, $publicKey, ['RS256']);
            return true;
        }
        catch (\Throwable $exception) {
            return false;
        }
    }

}
