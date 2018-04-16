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
        ini_set('max_execution_time', 300);
        return EbidExportResource::collection(
            Product::where('banned', '=', false)
                ->where('qty', '>', 2)
                ->whereHas('category', function ($query) {
                    $query->where('ebid_category', '>', 1);
                })
                ->get()

        );
    }

    public function count()
    {
        return Product::where('banned', '=', false)
            ->where('qty', '>', 2)
            ->whereHas('category', function ($query) {
                $query->where('ebid_category', '>', 1);
            })->count();
    }
}
