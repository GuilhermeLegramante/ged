<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CustomPaginator
{
    /**
     * @param $items
     * @param $perPage (itens por página)
     * @param $page (nullable)
     * @param $options = ['path' => env('PAGINATE_URL_DIVIDAS')];
     */
    public static function paginate($items, $perPage, $page, $options)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
