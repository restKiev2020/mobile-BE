<?php

namespace App\Http\Controllers\Api\AdvertRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestAdvertRequest;
use App\Models\AdvertRequest;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Throwable;

class AdvertRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->query->get('perPage', 5);

        ini_set('memory_limit', '1024M');
        $advertsRequests = AdvertRequest::orderBy('created_at', 'DESC')->paginate($perPage);

        return response()->json($advertsRequests);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequestAdvertRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequestAdvertRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $data['user_id'] ?? Auth::user()->id;

        $advertRequest = AdvertRequest::create($data);

        return response()->json($advertRequest, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        ini_set('memory_limit', '1024M');
        $advertRequest = AdvertRequest::find($id);

        if(!$advertRequest) {
            return response()->json('Advert request not found', 404);
        }

        return response()->json($advertRequest);
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
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $updateFields = $request->get('advertRequest');

        if(!$updateFields) {
            return response()->json('Update fields weren\'t provided', 400);
        }

        /**
         * @var AdvertRequest $advert
         */
        $advertRequest = AdvertRequest::findOrFail($id);

        if(!$user || !$advertRequest || !Gate::allows('can-update-model', $advertRequest->user_id)) {
            return response()->json('Not found', 404);
        }

        try {
            $advertRequest->fill($updateFields)->save();
        }
        catch (Throwable $e) {
            return response()->json('Not processed', (400));
        }

        return response()->json('Success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        /** @var AdvertRequest|null $advertRequest */
        $advertRequest = AdvertRequest::find($id);

        if(!$advertRequest) {
            return response()->json('Advert request not found', 404);
        }

        $advertRequest->delete();

        return response()->json('Advert request deleted', 204);
    }

    public function search(Request $request)
    {
        $query = $request->query->get('q');
        $perPage = $request->query->get('perPage', 5);

        $searchQuery = $request->get('search_query');

        $advertRequests = AdvertRequest::performSearch($searchQuery, $query, $perPage);

        return response()->json($advertRequests);
    }

    public function personal(Request $request) {
        $user = Auth::user();

        if(!$user) {
            return response()->json('Forbidden', 403);
        }

        $advertRequests = AdvertRequest::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->get();

        return response()->json($advertRequests, 200);
    }
}
