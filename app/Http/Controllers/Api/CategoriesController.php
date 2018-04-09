<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function setCategory(Request $request) {
        $firstCat = Category::where([['ebid_category', '=', 0], ['bonanza_category', '=', 0]])->get()->first();

        return response()->json(['category' => $firstCat], 200);
    }

    public function set(Request $request) {

        $fields = $request->all();

        $category = Category::find($fields['category_id']);

        $category->ebid_category = $fields['ebid_category'];
        $category->bonanza_category = $fields['bonanza_category'];

        try {
            $category->save();
            return response()->json(['success' => $category->id], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }


    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {

        $categoryArray = $request->all();

        for ($i = 0; $i < count($categoryArray); $i++) {

            $catSubs = preg_split('/ > /', $categoryArray[$i]['category_path'], -1, PREG_SPLIT_NO_EMPTY);

            $newCategory = [
                'category_path' => $categoryArray[$i]['category_path'],
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

            try {
                $category = Category::firstOrCreate($newCategory);
                return response()->json(['success' => $category->category_path], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

        }
        return response()->json(['error' => 'empty'], 304);
    }
}
