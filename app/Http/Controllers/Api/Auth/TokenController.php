<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\OAuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nedvibot\Realtor\Model\RealtorEloquent;

/**
 * Class TokenController
 * @package App\Http\Controllers\Auth
 */
class TokenController extends Controller
{
    /**
     * @param Request $request
     * @param OAuthService $authService
     * @return JsonResponse
     */
    public function refresh(Request $request, OAuthService $authService)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->token()->revoke();

        return new JsonResponse([
            'token' => $authService->refreshToken($request->get('refresh_token'))
        ]);
    }
}
