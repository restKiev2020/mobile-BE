<?php

namespace App\Http\Controllers\Api\Advert;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdvertRequest;
use App\Http\Requests\SearchAdvertRequest;
use App\Http\Transformers\PaginatorAppendsTransformer;
use App\Models\Advert;
use Illuminate\Support\Facades\Gate;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Auth;
use Throwable;

class AdvertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->query->get('perPage', 5);

        ini_set('memory_limit', '1024M');
        $adverts = PaginatorAppendsTransformer::transform(Advert::orderBy('created_at', 'DESC')->paginate($perPage), ['documents_ids']);

        return response()->json($adverts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateAdvertRequest $request
     * @return JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdvertRequest $request
     * @return JsonResponse
     */
    public function store(CreateAdvertRequest $request)
    {
        $advertRequest = $request->validated();
        $advert = Advert::create($advertRequest);

        return response()->json($advert->append('documents_ids'), 201);
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
        $advert = Advert::find($id);

        if(!$advert) {
            return response()->json('Advert not found', 404);
        }

        if(Gate::allows('view-full-advert', $advert)) {
            $advert->setVisible(Advert::OWNER_FIELDS);
        }

        return response()->json($advert->append(['documents_ids', 'user_phone']));
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
        Auth::setDefaultDriver('api');
        $user = Auth::user();

        $updateFields = $request->get('advert');

        if(!$updateFields) {
            return response()->json('Update fields weren\'t provided', 400);
        }

        /**
         * @var Advert $advert
         */
        $advert = Advert::findOrFail($id);

        if(!$user || !$advert || !Gate::allows('can-update-model', $advert->user_id)) {
            return response()->json('Not found', 404);
        }

        try {
            $advert->fill($updateFields)->save();
        }
        catch (Throwable $e) {
            \Log::debug($e);
            return response()->json('Not processed', (400));
        }

        return response()->json('Success');
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
        /** @var  Advert|null $advert */
        $advert = Advert::find($id);

        if(!$advert) {
            return response()->json('Advert not found', 404);
        }

        $advert->delete();

        return response()->json('Advert deleted', 204);
    }

    public function search(SearchAdvertRequest $request)
    {
        $query = $request->query->get('q');
        $perPage = $request->query->get('perPage', 5);

        $searchQuery = $request->validated()['search_query'];

        $adverts = PaginatorAppendsTransformer::transform(Advert::performSearch($searchQuery, $query, $perPage), ['documents_ids']);

        return response()->json($adverts);
    }

    public function personal(Request $request) {
        $user = Auth::guard('api')->user();

        if(!$user) {
            return response()->json('Forbidden', 403);
        }

        $adverts = Advert::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->get();

        return response()->json($adverts->append('documents_ids'));
    }

    public function byIds(Request $request) {
        $ids = $request->get('ids');

        if(!$ids) {
            return response()->json('No ids provided', 400);
        }

        $adverts = Advert::whereIn('id', $ids)->get();

        return response()->json($adverts->append('documents_ids'));
    }
}
