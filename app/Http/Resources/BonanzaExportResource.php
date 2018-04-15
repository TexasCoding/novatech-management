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
            'price' => $this->markup(
                $this->cost_pro_member,
                $this->shipping_cost,
                0.035,
                0.03),
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

    /**
     * @param $name
     * @param $sku
     * @return string
     */
    private function title($name, $sku)
    {
        $sku_length = strlen($sku);

        $new_name = substr($name, 0, 80);

        $set_length = 79 - $sku_length;

        $short_name = substr($new_name, 0, $set_length);

        return $short_name . ' ' . $sku;
    }

    /**
     * @return array
     */
    public function image()
    {
        $image_array = explode(',', $this->additional_images);
        return [
            'image1' => $this->image_url,
            'image2' => isset($image_array[1]) ? $image_array[1] : '',
            'image3' => isset($image_array[2]) ? $image_array[2] : '',
        ];
    }

    /**
     * @param $name
     * @param $description
     * @param $package_includes
     * @param $condition_description
     * @param $warranty
     * @param $return_policy
     * @return string
     */
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

    /**
     * @param $brand
     * @param $condition
     * @param $mpn
     * @param $upc
     * @return string
     */
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

//    private function markup($cost, $shipping)
//    {
//        $actualCost = $cost * 0.029 + 0.30 + $shipping + $cost;
//        $payPal = $actualCost * 0.029 + 0.30;
//        $bonanza = $actualCost * 0.035;
//        $total = $actualCost + $payPal + $bonanza;
//        return number_format($total / 0.95, 2);
//    }

    /**
     * @param $cost
     * @param $shipping
     * @param $market_place_markup
     * @param float $percentage
     * @return string
     */
    private function markup($cost, $shipping, $market_place_markup, $percentage = 0.04)
    {
        $actualCost = $cost * 0.029 + 0.30 + $shipping + $cost;
        $profit_goal = $actualCost * $percentage >= 1.00 ? $actualCost * $percentage : 1.00;
        $percent = 0.10;

        for ($x = 0.00; $x <= $profit_goal; $percent += 0.000001) {
            $sale_price = ($actualCost * $percent) + $actualCost;
            $payPal = $sale_price * 0.029 + 0.30;
            $bonanza = $sale_price * $market_place_markup;
            $fee_total = $payPal + $bonanza;
            $total_cost = $actualCost + $fee_total;
            $x = $sale_price - $total_cost;
        }

        return number_format($sale_price, 2);
    }
}
