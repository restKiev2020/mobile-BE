<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Services\JWTService;
use App\Http\Services\OAuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{

    private $authService;

    public function __construct(OAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function signIn(UserLoginRequest $request)
    {
        $loginRequest = $request->validated();

        if(!Auth::attempt($loginRequest)) {
            return new JsonResponse(['message' => \Lang::get('auth.failed')]);
        }

        /** @var User $user*/
        $user = Auth::user();

        if($user->blocked) {
            return new JsonResponse(['message' => \Lang::get('auth.failed.blocked')]);
        }

        $token = $this->authService->getTokenAndRefreshRoken($user->email, $request->get('password'));
        $jwt = JWTService::sign($user->id);

        return new JsonResponse(['user' => $user->append('web_token'), 'token' => $token, 'jwt'=>$jwt]);
    }

    /**
     * @param UserRegistrationRequest $request
     * @return JsonResponse
     */
    public function signUp(UserRegistrationRequest $request)
    {
        $registrationRequest = $request->validated();

        $user = User::create($registrationRequest);
        $token = $this->authService->getTokenAndRefreshRoken($user->email, $request->get('password'));

        return new JsonResponse(['user' => $user, 'token' => $token]);
    }
}
