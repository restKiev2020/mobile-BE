<?php


namespace App\Http\Presenters;

use Illuminate\Support\Collection;

interface IPresenter
{
    public function present(Collection $models): Collection;
}
