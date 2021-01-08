<?php

namespace App\Http\Controllers\Api\Favourite;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use Auth;

class FavouriteController extends Controller
{
    public function favouriteAdvert(int $id)
    {
        Auth::user()->favourites()->attach($id);

        return response()->json();
    }

    public function unFavouriteAdvert(int $id)
    {
        Auth::user()->favourites()->detach($id);

        return response()->json();
    }

    public function userFavourites()
    {
        $adverts = Auth::user()->favourites()->get();

        return response()->json($adverts->append('documents_ids'), 200);
    }

    public function usersAddFavourite($id)
    {
        /** @var Advert $advert*/
        $advert = Advert::find($id);

        if (!$advert) {
            return response()->json('Advert not found', 404);
        }

        $users = $advert->favourites()->get();

        return response()->json($users->append('documents_ids'), 200);
    }

}
