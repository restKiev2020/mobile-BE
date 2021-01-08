<?php

namespace App\Http\Controllers\Api\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Services\NotificationService;
use App\Models\Advert;
use App\Models\Appointment;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;


class AppointmentController extends Controller
{
    /**
     * Add appointment
     *
     * @param Request $request
     * @param int $advertId
     * @param NotificationService $notificationService
     * @return JsonResponse
     * @throws Exception
     */
    public function attach(Request $request, int $advertId, NotificationService $notificationService)
    {
        $time = $request->get('time', null);

        if(!$time) {
            return response()->json('Appointment time is not provided', 400);
        }
        /**
         * @var User $user
         */
        $user = Auth::user();

        $appointment = Appointment::create([
            'user_id' => $user->id,
            'advert_id' => $advertId,
            'time' => new Carbon($time)
        ]);

        $advert = Advert::find($advertId);

        $notificationService->sendMessage(
            'Запрос на просмотр',
            "Получен запрос на просмотр вашего объекта \nДата: " . $appointment->time->locale('ru')->isoFormat('Do MMMM  YYYY, h:mm:ss'),
            $advert->user_id,
            [
                'time' => $appointment->time,
                'advert' => $advert->toArray(),
                'appointment_id' => $appointment->id,
                'advert_id' => $appointment->advert_id,
                'user_id' => $appointment->user_id
            ]
        );

        return response()->json('Success');
    }

    /**
     * Remove appointment
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function detach($id)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        $user->appointments()->detach($id);

        return response()->json('Success');
    }

    /**
     * Get appointments for advert
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function advertsAppointments(int $id)
    {
        /**
         * @var Advert $advert
         */
        $advert = Advert::find($id);

        if(!$advert) {
            return response()->json('Not found', 404);
        }

        $appointments = $advert->appointments()->orderBy('created_at', 'DESC')->get();

        return response()->json($appointments);
    }

    public function update(int $id, Request $request, NotificationService $notificationService)
    {
        $user = Auth::user();
        $updateFileds = $request->get('appointment');

        /**
         * @var Appointment $appointment
         */
        $appointment = Appointment::find($id);

        if(!$user || !$appointment) {
            return response()->json('Not found', 404);
        }

        $advert = Advert::find($appointment->advert_id);

        try {
            $appointment->fillUpdate($updateFileds);
            $notificationService->sendMessage(
                'Запрос на просмотр',
                "Ваш запрос на просмотр обновлен",
                $appointment->user_id,
                [
                    'time' => $appointment->time,
                    'advert' => $advert->toArray(),
                    'appointment_id' => $appointment->id,
                    'advert_id' => $appointment->advert_id,
                    'user_id' => $appointment->user_id
                ]
            );
        }
        catch (Throwable $e) {
            \Log::debug($e->getMessage());
            return response()->json('Not processed', (400));
        }

        return response()->json('Success');
    }

    /**
     * Get appointments for user
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function usersAppointments()
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        if(!$user) {
            return response()->json('Not found', 404);
        }

        $id = $user->id;

        $appointments = Appointment::getFullUserAppointments($id);

        return response()->json($appointments);
    }

}
