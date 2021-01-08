<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PwdRessetPreAuthRequest;
use App\Http\Requests\PwdRessetRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\VerificationCodeService;
use App\Models\User;
use Auth;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Throwable;

class PasswordResetController extends Controller
{

    //TODO: we have SmsController that does that kind of crap but its routes are authed. Need to recheck the logic.
    public function preAuthorize(PwdRessetPreAuthRequest $request, VerificationCodeService $codeVerification)
    {
        ['phone_number' => $phoneNumber, 'code' => $code] = $request->validated();

        /**
         * @var User $user
         */
        $user = User::where(['phone_number' => $phoneNumber])->first();

        if(!$user) {
            return response()->json('User not found', 404);
        }

        $isVerified = $codeVerification->verfiy($code);

        if(!$isVerified) {
            return response(\Lang::get('confirmation.code.verify'), 409);
        }

        $token = $user->getAccessToken();

        return response()->json(['access_token' => $token], 200);
    }

    public function recoverPassword(PwdRessetRequest $request)
    {
        $password = $request->validated()['password'];

        try {
            /** @var User $user*/
            $user = Auth::user();

            $user->password = $password;

            $user->save();

            return response()->json('Password was successfully updated', 200);
        }
        catch (Exception $exception) {
            return response()->json('Cannot update password for provided user', 500);
        }

    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        /** @var User $user*/
        $user = Auth::user();

        $credentials = $request->validated();

        if(!Gate::allows('can-update-model', $user->id)) {
            return response()->json('Not permitted', 403);
        }

        if(!$user->comparePasswordHash($credentials['oldPassword'])) {
            return response()->json('Incorrect password', 400);
        }

        try {
            $user->password = $credentials['newPassword'];
            $user->save();
            $user->tokens->each(static function($token) {
                $token->revoke();
            });

            return response()->json('Success', 200);
        }
        catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }


    //TODO: hotfix for admin to reset password
    public function resetPasswordAdmin($id, Request $request)
    {
        /** @var User $user*/
        $admin = Auth::user();

        $user = User::find($id);

        if(!$user) {
            return response()->json('Not found', 404);
        }

        $newPassword = $request->get('new_password');

        if(!Gate::allows('can-update-model', $admin->id)) {
            return response()->json('Not permitted', 403);
        }

        try {
            $user->password = $newPassword;
            $user->save();
            $user->tokens->each(static function($token) {
                $token->revoke();
            });

            return response()->json('Success', 200);
        }
        catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

}
