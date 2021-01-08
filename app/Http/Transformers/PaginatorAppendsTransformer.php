<?php

namespace App\Http\Transformers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorAppendsTransformer
{
    /**
     * @param LengthAwarePaginator $paginator
     * @param array $appends
     * @return LengthAwarePaginator
     */
    public static function transform($paginator, array $appends)
    {
        $coll = $paginator->getCollection()->each(static function (Model $model) use ($appends) {
            $model->setAppends($appends);
            return $model;
        });

        $paginator->setCollection($coll);

        return $paginator;
    }

}
