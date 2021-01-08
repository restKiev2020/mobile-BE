<?php


namespace App\Http\Services;

use Laravel\Passport\Client as OClient;
use GuzzleHttp\Client;

class OAuthService
{
    private $oClient;

    private $http;

    public function __construct()
    {
        $this->oClient = OClient::where(['password_client' => 1])->first();
        $this->http = new Client() ;
    }

    public function getTokenAndRefreshRoken(string $email, string $password)
    {

        $response = $this->http->post(\url('/oauth/token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->oClient->id,
                'client_secret' => $this->oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function refreshToken(string $refreshToken)
    {
        $response = $this->http->post(\url('/oauth/token'), [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => 'the-refresh-token',
                'client_id' => $this->oClient->id,
                'client_secret' => $this->oClient->secret,
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
