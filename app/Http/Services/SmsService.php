<?php

namespace App\Http\Services;

use Twilio\Rest\Client;

class SmsService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(TwilioClientService $twilioClientService)
    {
        $this->client = $twilioClientService->client();
    }

    public function send(string $phoneNumber, string $message)
    {
        $this->client->messages->create(
            $phoneNumber,
            [
                'from' => config('twilio.phone_number'),
                'body' => $message
            ]
        );
    }

}
