<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbidCategory extends Model
{
    protected $fillable = [
        'category_path',
        'category_id',
        'parent_category',
        'sub_catOne',
        'sub_catTwo',
        'sub_catThree',
        'sub_catFour',
        'sub_catFive',
        'sub_catSix',
    ];
}
