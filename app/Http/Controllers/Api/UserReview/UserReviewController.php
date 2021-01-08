<?php

namespace App\Http\Controllers\Api\UserReview;

use App\Http\Controllers\Controller;
use App\Http\Presenters\UserReviewPresenter;
use App\Http\Requests\CreateUserReviewRequest;
use App\Models\UserReview;
use Auth;
use Throwable;

class UserReviewController extends Controller
{

    public function index()
    {
        $reviews = (new UserReviewPresenter())->present(UserReview::with('user')->get());
        return response()->json($reviews);
    }

    public function create(CreateUserReviewRequest $request)
    {
        $user = Auth::user();

        $newReview = $request->validated();

        try {
            $userReview = UserReview::create(array_merge(
                $newReview,
                ['user_id' => $user->id]
            ));

            return response()->json($userReview, 200);
        }
        catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function destroy(int $id)
    {
        $userReview = UserReview::find($id);

        if(!$userReview) {
            return response()->json('Review wasn\'t found', 404);
        }

        try {
            $userReview->delete();
            return response()->json('', 204);
        }
        catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

}
