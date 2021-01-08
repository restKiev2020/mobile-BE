<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $table = 'appointments';

    protected $fillable = [
        'user_id',
        'advert_id',
        'time',
        'status'
    ];

    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function advert() {
        return $this->belongsTo(Advert::class);
    }

    public static function getFullUserAppointments(int $userId) {
        $appointments = Appointment::with(['user', 'advert'])->where([
            'appointments.user_id' => $userId
        ])->orWhereHas('advert', static function ($q) use($userId)  {
            return $q->where(['adverts.user_id' => $userId]);
        })->orderBy('created_at', 'DESC')->get();

        return $appointments->map(static function (Appointment $appointment) use ($userId) {
            $appointment['forUser'] = $appointment->advert->user_id === $userId;
            $appointment->advert->append('documents_ids');
            $appointment->user->makeHidden('documents_ids');
            return $appointment;
        });
    }

    public function fillUpdate(array $fields) : void
    {
        if(isset($fields['time'])) {
            $fields['time'] = new Carbon($fields['time']);
        }

        $this->fill($fields)->save();
    }
}
