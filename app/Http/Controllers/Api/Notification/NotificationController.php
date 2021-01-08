<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Http\Services\NotificationService;
use App\Models\Advert;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    ///    public function sendMessage(string $title, string $text, $userId, array $data)
    public function send(Request $request, NotificationService $notificationService)
    {
        $message = $request->post('message', null);
        $userId = $request->post('userId', null);
        $advertId = $request->post('advertId', null);

        if(!$userId || !$advertId) {
            return response()->json('Missed the message title and receiver id', 400);
        }

        $advert = Advert::select('title')->where([
            'id' => $advertId
        ])->first();

        if(!$advert) {
            return response()->json('Cannot find advert with such id', 404);
        }

        $title = "[REST] Сообщение в чате $advert->title";

        try {
            $notificationService->sendMessage($title, $message ?? '', $userId, ['title'=> $title, 'advertId' => $advertId]);
            \Log::debug('MESSAGE SENT');
            return response()->json('', 204);
        }
        catch (\Throwable $exception) {
            \Log::error($exception->getMessage());
            return response()->json('', 500);
        }

    }
}
