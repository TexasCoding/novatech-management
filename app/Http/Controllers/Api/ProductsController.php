<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::paginate(10));
    }

    public function count()
    {
        return Product::count();
    }

    public function create(Request $request)
    {

        $productArray = $request->all();

        for ($i = 0; $i < count($productArray); $i++) {
            if (count($productArray) < 3) {
                $prodArray = [
                    'qty' => $productArray[$i]['qty'],
                ];
            } elseif (Product::where('sku', $productArray[$i]['sku'])->first()) {
                $prodArray = [
                    'cost_free_member' => $productArray[$i]['cost_free_member'],
                    'cost_pro_member' => $productArray[$i]['cost_pro_member'],
                    'map_price' => $productArray[$i]['map_price'],
                    'shipping_cost' => $productArray[$i]['shipping_cost'],
                    'upc_code' => $productArray[$i]['upc_code'],
                    'qty' => $productArray[$i]['qty'],
                    'image_url' => $productArray[$i]['image_url'],
                    'additional_images' => $productArray[$i]['additional_images'],
                    'category_path' => $productArray[$i]['category_path'],
                    'condition' => $productArray[$i]['condition'],
                ];
            } else {
                $bannedWords = [
                    'knife',
                    'Knife',
                    'Knives',
                    'knives',
                    'blade',
                    'Blade',
                    'scope',
                    'Scope',
                    'Slingshot',
                    'slingshot',
                    'dagger',
                    'Dagger',
                    'Machete',
                    'machete',
                    'sword',
                    'Sword',
                    'axe',
                    'Axe',
                    'crossbow',
                    'Crossbow',
                    'arrow',
                    'Arrow',
                    'Broadhead',
                    'broadhead',
                    'Bow',
                    'bow'
                ];

                $prodArray = [
                    'entity_id' => $productArray[$i]['entity_id'],
                    'sku' => $productArray[$i]['sku'],
                    'cost_free_member' => $productArray[$i]['cost_free_member'],
                    'cost_pro_member' => $productArray[$i]['cost_pro_member'],
                    'manufacturer' => $productArray[$i]['manufacturer'],
                    'map_price' => $productArray[$i]['map_price'],
                    'model_number' => $productArray[$i]['model_number'],
                    'mpn' => $productArray[$i]['mpn'],
                    'name' => $productArray[$i]['name'],
                    'height' => $productArray[$i]['height'],
                    'length' => $productArray[$i]['length'],
                    'width' => $productArray[$i]['width'],
                    'shipping_cost' => $productArray[$i]['shipping_cost'],
                    'ship_from_location' => $productArray[$i]['ship_from_location'],
                    'upc_code' => $productArray[$i]['upc_code'],
                    'warranty' => $productArray[$i]['warranty'],
                    'weight' => $productArray[$i]['weight'],
                    'qty' => $productArray[$i]['qty'],
                    'return_policy' => $productArray[$i]['return_policy'],
                    'image_url' => $productArray[$i]['image_url'],
                    'additional_images' => $productArray[$i]['additional_images'],
                    'condition_description' => $productArray[$i]['condition_description'],
                    'description' => $productArray[$i]['description'],
                    'package_includes' => $productArray[$i]['package_includes'],
                    'category_path' => $productArray[$i]['category_path'],
                    'condition' => $productArray[$i]['condition'],
                    'banned' => $this->contains($productArray[$i]['name'], $bannedWords),
                ];
            }

            try {
                $product = Product::updateOrCreate(['sku' => $productArray[$i]['sku']], $prodArray);
                return response()->json(['success' => $product->sku], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

        }
        return response()->json(['error' => 'empty'], 304);
    }

    private function contains($str, array $arr)
    {
        foreach ($arr as $a) {
            if (stripos($str, $a) !== false) return true;
        }
        return false;
    }

}
