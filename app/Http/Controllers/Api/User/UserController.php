<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);

        if(!$user) {
            return response()->json('Unable to find user with such id', 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $updateFields = $request->get('user');

        if(!$updateFields) {
            return response()->json('Update fields weren\'t provided', 400);
        }

        if(isset($updateFields['password'])){
            unset($updateFields['password']);
        }

        $user = Auth::user();

        if(!$user) {
            return response()->json('User not found', 404);
        }

        if(!Gate::allows('can-update-model', $id) ) {
            return response()->json('Forbidden to change the user', 403);
        }

        try {
            $user->fill($updateFields);
            $user->save();

            return response()->json('Success', 200);
        }
        catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAdverts($id) {
        $user = User::with(['adverts'])->find($id);

        if(!$user) {
            return response()->json('Not found', 404);
        }

        $user->adverts->each(static function ($advert) {
            $advert->setAppends(['documents_ids']);
        });

        return response()->json($user, 200);
    }

    public function getAdvertRequests($id) {
        $user = User::with(['advertRequests'])->find($id);

        if(!$user) {
            return response()->json('Not found', 404);
        }

        $user->advertRequests->each(static function ($advert) {
            $advert->setAppends(['documents_ids']);
        });

        return response()->json($user, 200);
    }

    //TODO: refactor appends to transformers
    public function fullInfo($id) {
        $user = User::with(['adverts', 'advertRequests'])->find($id);

        if(!$user) {
            return response()->json('Not found', 404);
        }

        $user->adverts->each(static function ($advert) {
            $advert->setAppends(['documents_ids']);
        });

        $user->advertRequests->each(static function ($advert) {
            $advert->setAppends(['documents_ids']);
        });

        return response()->json($user, 200);
    }
}
