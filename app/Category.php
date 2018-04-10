<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_path',
        'parent_category',
        'sub_catOne',
        'sub_catTwo',
        'sub_catThree',
        'sub_catFour',
        'sub_catFive',
        'sub_catSix',
        'ebid_category',
        'bonanza_category',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany('App\Product');
    }
}
