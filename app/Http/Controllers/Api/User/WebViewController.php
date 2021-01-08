<?php


namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Models\User;

class WebViewController
{

    public function getUserInfo(Request $request)
    {
        $token = $request->query->get('token');

        if(!$token) {
            return response()->json('Token not provided', 400);
        }

        $user = User::find(User::getIdFromWebToken($token));

        if(!$user) {
            return response()->json('User not found', 404);
        }

        return response()->json([
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'phoneNumber' => $user->phone_number
        ], 200);
    }

}
