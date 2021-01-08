<?php

namespace App\Http\Controllers\Api\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->query->get('perPage', 25);
        $advert = $request->query->get('advert', null);
        if(!$advert) {
            return response()->json('Not all the fields are provided', 400);
        }
        $user = \Auth::user();

        $messages = Message::where(['advert_id'=>$advert])
            ->where(static function ($query) use($user) {
                $query->where(['sender_id' => $user->id])
                    ->orWhere(['receiver_id' => $user->id]);
            })
            ->orderBy('created_at', 'DESC')->paginate($perPage);

        return response()->json($messages);
    }

    public function usersChats()
    {
        /**
         * @var User $user
         */
        $user = \Auth::user();

        $messages = Message::where(static function ($query) use ($user) {
            $query->where(['sender_id' => $user->id])->orWhere(['receiver_id' => $user->id]);
        })->orderBy('created_at', 'DESC')->get();

        /*
         * TODO: Too much, extract that into some transformer
         */
        $chats = $messages->unique('advert_id')->load(['advert', 'sender', 'receiver'])
            ->map(static function (Message $message) use ($user) {
                $message->advert->append(['documents_ids', 'user_avatar']);
                $receiver = $message->sender->id === $user->id ? $message->receiver : $message->sender;
                $message->advert = [
                    'id' => $message->advert->id,
                    'title' => $message->advert->title,
                    'document_id' => $message->advert->documents_ids->first(),
                    'user_avatar' => $user->avatar,
                ];

                $message->unsetRelation('advert');
                $message->unsetRelation('sender');
                $message->unsetRelation('receiver');

                $message->receiver = [
                    'id' => $receiver->id,
                    'first_name' => $receiver->first_name,
                    'second_name' => $receiver->second_name,
                    'avatar' => $receiver->avatar
                ];
                return $message;
        });

        return response()->json($chats->values());
    }

    public function usersUnread()
    {
        $user = \Auth::user();

        $messages = Message::where(static function ($query) use ($user) {
            $query->where(['sender_id' => $user->id])->orWhere(['receiver_id' => $user->id]);
        })->where(['viewed' => false])->orderBy('created_at', 'DESC')->count();

        return response()->json($messages);
    }

    public function updateViewed($id)
    {
        try {
            $updated = Message::where(['id' => $id])->update(['viewed' => true]);

            return response()->json($updated,200);
        }
        catch (\Throwable $exception) {
            return response()->json('Could not update the message',500);
        }
    }
}
