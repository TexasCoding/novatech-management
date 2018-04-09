<?php

namespace App\Http\Controllers\Api;

use App\BonanzaCategory;
use App\Http\Resources\BonanzaCategoryResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BonanzaCategoriesController extends Controller
{
    public function index()
    {
        return BonanzaCategoryResource::collection(BonanzaCategory::all());
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {

        $categoryArray = $request->all();

        for ($i = 0; $i < count($categoryArray); $i++) {

            $catSubs = preg_split('/ >> /', $categoryArray[$i]['category_path'], -1, PREG_SPLIT_NO_EMPTY);

            $newCategory = [
                'category_path' => $categoryArray[$i]['category_path'],
                'category_id' => $categoryArray[$i]['category_id'],
                'parent_category' => isset($catSubs[0]) ? $catSubs[0] : '',
                'sub_catOne' => isset($catSubs[1]) ? $catSubs[1] : '',
                'sub_catTwo' => isset($catSubs[2]) ? $catSubs[2] : '',
                'sub_catThree' => isset($catSubs[3]) ? $catSubs[3] : '',
                'sub_catFour' => isset($catSubs[4]) ? $catSubs[4] : '',
                'sub_catFive' => isset($catSubs[5]) ? $catSubs[5] : '',
                'sub_catSix' => isset($catSubs[6]) ? $catSubs[6] : '',
            ];

            try {
                $category = BonanzaCategory::firstOrCreate($newCategory);
                return response()->json(['success' => $category->category_path], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 200);
            }

        }
        return response()->json(['error' => 'empty'], 304);
    }
}
