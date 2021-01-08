<?php


namespace App\Http\Controllers\Api\Address;


use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use App\Models\Street;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class AddressController
 * @package App\Http\Controllers\Api\Address
 */
class AddressController extends Controller
{
    /**
     * @param int $city
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cityStreet(int $city, Request $request)
    {
        $street = $request->query->get('q', '');
        /** @var Collection $streets */
        $streets = Street::where('name', 'like' , '%' . $street . '%')
            ->groupBy('name')
            ->limit(30)
            ->get();

        return response()->json(
            $streets->map(function (Street $s) {
                return $s->name;
            })->toArray()
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities(Request $request)
    {
        $city = $request->query->get('q', '');
        $regions = array_values(array_filter(explode(',', $request->query->get('regions', ''))));
        $streets = City::where('name', 'like' , '%' . $city . '%')
            ->limit(30);

        if ($regions && count($regions) > 0) {
            $streets->whereIn('region_id', $regions);
        }

        return response()->json(
            $streets->get()->map(function (City $s) {
                return $s->name;
            })->toArray()
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function regions(Request $request)
    {
        $region = $request->query->get('q', '');
        /** @var Collection $streets */
        $streets = Region::where('name', 'like' , '%' . $region . '%')
            ->limit(30)
            ->get();

        return response()->json(
            $streets->map(function (Region $s) {
                return [
                    'id' => $s->id,
                    'title' => $s->name,
                ];
            })->toArray()
        );
    }
}
