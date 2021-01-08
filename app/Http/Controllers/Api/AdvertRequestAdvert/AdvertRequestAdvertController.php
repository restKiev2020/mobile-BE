<?php

namespace App\Http\Controllers\Api\AdvertRequestAdvert;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestAdvertRequest;
use App\Http\Services\NotificationService;
use App\Models\Advert;
use App\Models\AdvertRequest;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AdvertRequestAdvertController extends Controller
{
    /**
     * Add appointment
     *
     * @param Request $request
     * @param NotificationService $notificationService
     * @return JsonResponse
     */
    public function attach(Request $request, NotificationService $notificationService)
    {
        $toAttach = $request->get('toAttach', null);

        if(!$toAttach || !is_array($toAttach) || count($toAttach) !== 2) {
            return response()->json('Wrong attach params', 400);
        }

        /**
         * @var Advert $advert
         */
        $advert = Advert::find($toAttach['advertId']);

        if(!$advert) {
            return response()->json('Advert or advert request not found', 404);
        }

        $advert->requests()->attach($toAttach['advertRequestId']);

        AdvertRequest::where([
            'id' => $toAttach['advertRequestId']
        ])->increment('attached_adverts');

        /** @var AdvertRequest $advertRequest */
        $advertRequest = AdvertRequest::find($toAttach['advertRequestId']);

        $notificationService->sendMessage(
            'Вам предложили объект',
            'Вам предожили объект ' . $advert->title,
            $advertRequest->user_id,
            [
                'advertRequestId' => $advertRequest->id,
            ]
        );

        return response()->json($advert->append(['requests_ids', 'documents_ids']));
    }

    /**
     * Remove appointment
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function detach(Request $request)
    {
        $toDetach = $request->get('toDetach', null);

        if(!$toDetach || !is_array($toDetach) || count($toDetach) !== 2) {
            return response()->json('Wrong detach params', 400);
        }

        /**
         * @var Advert $advert
         */
        $advert = Advert::find($toDetach['advertId']);

        if(!$advert) {
            return response()->json('Advert or advert request not found', 404);
        }

        $advert->requests()->detach($toDetach['advertRequestId']);
        AdvertRequest::where([
            'id' => $toDetach['advertRequestId']
        ])->decrement('attached_adverts');

        return response()->json($advert->append(['requests_ids', 'documents_ids']));
    }

    /**
     * Get adverts by AdvertRequest id
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function advertRequestsAdverts(int $id)
    {
        /**
         * @var AdvertRequest $advertRequest
         */
        $advertRequest = AdvertRequest::find($id);

        if(!$advertRequest) {
            return response()->json('Not found', 404);
        }

        $adverts = $advertRequest->adverts()->pluck('adverts.id');

        return response()->json($adverts);
    }

    /**
     * Get AdvertRequests by Advert id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function advertsAdvertRequests(int $id)
    {
        /**
         * @var Advert $advert
         */
        $advert = Advert::find($id);

        if(!$advert) {
            return response()->json('Not found', 404);
        }

        $advertRequests = $advert->requests()->pluck('advert_requests.id');

        return response()->json($advertRequests);
    }
}
