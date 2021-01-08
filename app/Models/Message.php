<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public function sender() {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function receiver() {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }

    public function advert() {
        return $this->hasOne(Advert::class, 'id', 'advert_id');
    }

}
