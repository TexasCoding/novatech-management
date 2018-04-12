<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BonanzaExportResource;
use App\Product;
use App\Http\Controllers\Controller;

class BonanzaExportController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '-1');
        return BonanzaExportResource::collection(
            Product::where('banned', '=', false)->where('qty', '>', 1)
                ->whereHas('category', function ($query) {
                    $query->where('bonanza_category', '>', 1);
                })->get()

        );
    }

    public function count()
    {
        return Product::where('banned', '=', false)->where('qty', '>', 1)
            ->whereHas('category', function ($query) {
                $query->where('bonanza_category', '>', 1);
            })->count();
    }
}
