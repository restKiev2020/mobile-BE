<?php

namespace App\Http\Presenters;

use App\Models\UserReview;
use Illuminate\Support\Collection;

class UserReviewPresenter implements IPresenter
{
    public function present(Collection $models): Collection
    {
        return $models->map(function (UserReview $model) {
            $presented = $model->toArray();

            if($model->relationLoaded('user')) {
                $presented = array_merge($presented,
                    ['user' => [
                        'first_name' => $model->user->first_name ?? '',
                        'last_name' => $model->user->last_name ?? '',
                    ]]);
            }

            return $presented;
        });
    }
}
