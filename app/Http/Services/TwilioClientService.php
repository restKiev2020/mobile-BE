<?php

namespace App\Http\Services;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class TwilioClientService
{
    protected $client;

    public function __construct()
    {
        $sid = config('twilio.twilio_sid');
        $token = config('twilio.twilio_token');

        $this->client = new Client($sid, $token);
    }

    /**
     * @return Client
     * @throws ConfigurationException
     */
    public function client()
    {
        return $this->client;
    }
}
