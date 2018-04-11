<?php

namespace App\Http\Controllers\Api;

use App\BonanzaCategory;
use App\Category;
use App\Http\Resources\BonanzaExportResource;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '-1');
        return BonanzaExportResource::collection(
            Product::where('banned', false)->where('qty', '>', 1)
                ->whereHas('category', function ($query) {
                $query->where('bonanza_category', '>', 1);
            })->get()

        );
    }

    public function count()
    {
        return Product::count();
    }

    public function create(Request $request)
    {

        $productArray = $request->all();

        for ($i = 0; $i < count($productArray); $i++) {
            // Make sure category is added first
            if ($this->addCategory($productArray[$i]['category_path'])) {
                $category = $this->getCatId($productArray[$i]['category_path']);
                if ($category > 0) {

                    // if the products exists only update certain columns
                    if (Product::where('sku', $productArray[$i]['sku'])->first()) {
                        // Update only for out of date csv
                        if (count($productArray[$i]) < 3) {
                            $prodArray = [
                                'qty' => $productArray[$i]['qty'],
                            ];
                        } // update these if the product exists and not out-of-date csv
                        else {
                            $prodArray = [
                                'cost_free_member' => $productArray[$i]['cost_free_member'],
                                'cost_pro_member' => $productArray[$i]['cost_pro_member'],
                                'map_price' => $productArray[$i]['map_price'],
                                'shipping_cost' => $productArray[$i]['shipping_cost'],
                                'upc_code' => $productArray[$i]['upc_code'],
                                'qty' => $productArray[$i]['qty'],
                                'image_url' => $productArray[$i]['image_url'],
                                'additional_images' => $productArray[$i]['additional_images'],
                                'category_id' => $category,
                            ];
                        }

                    } else {
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
                            'category_id' => $category,
                            'condition' => $productArray[$i]['condition'],
                            'banned' => $this->contains($productArray[$i]['name'], $productArray[$i]['description'], self::bannedWords()),
                        ];
                    }


                    try {
                        $product = Product::updateOrCreate(['sku' => $productArray[$i]['sku']], $prodArray);
                        return response()->json([$product->category_id], 200);
                    } catch (\Exception $e) {
                        return response()->json(['error' => $e->getMessage()], 400);
                    }
                }


            }
        }
        return response()->json(['error' => 'product_not_added'], 304);
    }

    private function getCatId($category_path)
    {
        $category = Category::where('category_path', $category_path)->first();

        return $category->id;
    }


    private function addCategory($category_path)
    {
        $catSubs = preg_split('/ > /', $category_path, -1, PREG_SPLIT_NO_EMPTY);

        $newCategory = [
            'category_path' => $category_path,
            'parent_category' => isset($catSubs[0]) ? $catSubs[0] : '',
            'sub_catOne' => isset($catSubs[1]) ? $catSubs[1] : '',
            'sub_catTwo' => isset($catSubs[2]) ? $catSubs[2] : '',
            'sub_catThree' => isset($catSubs[3]) ? $catSubs[3] : '',
            'sub_catFour' => isset($catSubs[4]) ? $catSubs[4] : '',
            'sub_catFive' => isset($catSubs[5]) ? $catSubs[5] : '',
            'sub_catSix' => isset($catSubs[6]) ? $catSubs[6] : '',
            'ebid_category' => 0,
            'bonanza_category' => 0,
        ];

        if (Category::where('category_path', $category_path)->first()) return true;

        try {
            Category::create($newCategory);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    private static function bannedWords()
    {
        return [
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
        ];
    }


    /**
     * @param $str
     * @param $str2
     * @param array $arr
     * @return bool
     */
    private function contains($str, $str2, array $arr)
    {
        foreach ($arr as $a) {
            if (stripos($str, $a) !== false) return true;
            if (stripos($str2, $a) !== false) return true;
        }
        return false;
    }

}
