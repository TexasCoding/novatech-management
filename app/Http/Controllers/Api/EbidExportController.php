<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EbidExportResource;
use App\Product;
use App\Http\Controllers\Controller;

class EbidExportController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '-1');
        return EbidExportResource::collection(
            Product::where('banned', '=', false)->where('qty', '>', 1)
                ->whereHas('category', function ($query) {
                    $query->where('ebid_category', '>', 1);
                })->limit(30)->get()

        );
    }

    public function count()
    {
        return Product::where('banned', '=', false)->where('qty', '>', 1)
            ->whereHas('category', function ($query) {
                $query->where('ebid_category', '>', 1);
            })->count();
    }
}
