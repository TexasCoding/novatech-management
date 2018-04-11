<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BonanzaExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->sku,
            'title' => $this->title($this->name, $this->sku),
            'description' => $this->description(
                $this->name,
                $this->description,
                $this->package_includes,
                $this->condition_description,
                $this->warranty,
                $this->return_policy
            ),
            'price' => $this->markup($this->cost_pro_member, $this->shipping_cost),
            'image1' => $this->image()['image1'],
            'image2' => $this->image()['image2'],
            'image3' => $this->image()['image3'],
            'category' => $this->category->bonanza_category,
            'shipping_price' => 0,
            'shipping_type' => 'free',
            'sku' => $this->sku,
            'qty' => $this->qty,
            'trait' => $this->traits(
                $this->manufacturer,
                $this->condition,
                $this->mpn,
                $this->upc_code
            ),
            'force_update' => 'true'
        ];
    }

    private function title($name, $sku)
    {
        $sku_length = strlen($sku) + 1;
        $short_name = preg_replace('/\W\w+\s*(\W*)$/', '$1', substr($name, 0, -$sku_length));

        return $short_name . ' ' . $sku;
    }

    public function image()
    {
        $image_array = explode(',', $this->additional_images);
        return [
            'image1' => $this->image_url,
            'image2' => isset($image_array[1]) ? $image_array[1] : '',
            'image3' => isset($image_array[2]) ? $image_array[2] : '',
        ];
    }

    private function description(
        $name,
        $description,
        $package_includes,
        $condition_description,
        $warranty,
        $return_policy
    )
    {
        $name = "<h2>$name</h2>";
        if ($package_includes !== '') {
            $package = "<h5>Package Includes</h5><p>$package_includes</p>";
        } else {
            $package = '';
        }
        if ($condition_description !== '') {
            $condition = "<h5>Condition Description</h5><p>$condition_description</p>";
        } else {
            $condition = '';
        }
        if ($warranty !== '') {
            $war = "<h5>Warranty Information</h5><p>$warranty</p>";
        } else {
            $war = '';
        }
        if ($return_policy !== '') {
            $return = "<h5>Return Policy</h5><p>$return_policy</p>";
        } else {
            $return = '';
        }

        return $name . $description . $package . $condition . $war . $return;
    }

    private function traits($brand, $condition, $mpn, $upc)
    {
        if ($brand !== '') {
            $brandTrait = "[[brand: $brand]] ";
        } else {
            $brandTrait = '';
        }

        if ($condition !== '') {
            $conditionTrait = "[[condition: $condition]] ";
        } else {
            $conditionTrait = '';
        }

        if ($mpn !== '') {
            $mpnTrait = "[[mpn: $mpn]] ";
        } else {
            $mpnTrait = '';
        }

        if ($upc) {
            $upcTrait = "[[upc: $upc]]";
        } else {
            $upcTrait = '';
        }

        return $brandTrait . $conditionTrait . $mpnTrait . $upcTrait;
    }

    /**
     * @param $cost
     * @param $shipping
     * @return string
     */
    private function markup($cost, $shipping)
    {
        $actualCost = $cost * 0.029 + 0.30 + $shipping + $cost;
        $payPal = $actualCost * 0.029 + 0.30;
        $bonanza = $actualCost * 0.035;
        $total = $actualCost + $payPal + $bonanza;
        return number_format($total / 0.93, 2);
    }
}