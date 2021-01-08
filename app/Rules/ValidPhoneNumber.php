<?php

namespace App\Rules;

use App\Http\Services\TwilioClientService;
use Illuminate\Contracts\Validation\Rule;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;

class ValidPhoneNumber implements Rule
{
    protected $client;

    /**
     * Create a new rule instance.
     *
     */
    public function __construct()
    {
        $this->client = (new TwilioClientService())->client();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws TwilioException
     */
    public function passes($attribute, $value)
    {
        try {
            $response = $this->client->lookups->v1->phoneNumbers($value)->fetch(['type' => ['carrier']]);
            if($response->carrier['error_code']) {
                return false;
            }
        }
        catch (RestException $e) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return \Lang::get('validation.custom.phone_number.invalid');
    }
}
