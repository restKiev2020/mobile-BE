<?php


namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Controller;
use App\Http\Services\DocumentService;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Throwable;

class ProfilePictureController extends Controller
{
    public function create(Request $request, DocumentService $documentService)
    {
        $profilePicture = $request->get('profile_picture');

        if(!$profilePicture) {
            return response()->json('Profile picture wasn\'t provided', 400);
        }

        $document = $documentService->createDocument($profilePicture);

        /** @var  User $user*/
        $user = Auth::user();

        try {
            $user->profilePicture()->associate($document);
            $user->save();
            return response()->json($user->makeHidden(['documents_ids', 'profile_picture']), 200);
        }
        catch (Throwable $exception) {
            return response()->json('Wasn\'t able to assing profile picture to the user', 500);
        }
    }
}
