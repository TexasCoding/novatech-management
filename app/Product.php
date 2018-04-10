<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'entity_id',
        'sku',
        'cost_free_member',
        'cost_pro_member',
        'manufacturer',
        'map_price',
        'model_number',
        'mpn',
        'name',
        'height',
        'length',
        'width',
        'shipping_cost',
        'ship_from_location',
        'upc_code',
        'warranty',
        'weight',
        'qty',
        'return_policy',
        'image_url',
        'additional_images',
        'condition_description',
        'description',
        'package_includes',
        'category_id',
        'condition',
        'banned'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo('App\Category');
    }
}
