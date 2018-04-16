<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EbidExportResource extends JsonResource
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
            'Username' => 'aegisaccessories',
            'Category id' => $this->category->ebid_category,
            'eBid Store Category' => '',
            'Barcode' => preg_replace("/[^0-9,.]/", "", $this->upc_code ),
            'Auction Title' => $this->title(
                $this->name,
                $this->sku
            ),
            'Image URL' => $this->image(),
            'Item Condition' => $this->condition($this->condition),
            'Quantity' => $this->qty > 1 ? $this->qty : 0,
            'Start' => 'immediate',
            'End' => 'run until sold',
            'Starting Bid' => '1.00',
            'Sales Tax' => '',
            'Reserve' => '',
            'Feature' => 'gallery',
            'YouTube Video ID' => '',
            'BuyNow Price' => $this->markup(
                $this->cost_pro_member,
                $this->shipping_cost,
                0.02,
                0.02
            ),
            'Brand' => $this->manufacturer,
            'Domestic Shipping' => '03=0.00',
            'International Shipping' => '01=0.00',
            'Payment Methods' => '5',
            'Auto Repost' => '0',
            'SKU' => $this->sku,
            'Dispatch Time' =>'2',
            'Return Policy' => '2',
            'Description' => $this->description(
                $this->name,
                $this->description,
                $this->package_includes,
                $this->condition_description,
                $this->warranty,
                $this->return_policy
            ),
            'Action' => 'ao',
            'end' => '##end##',
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
     * @param $current
     * @return string
     */
    private function condition($current) {
        if($current === 'Used; Like New') {
            $condition = 'used';
        } elseif ($current === 'Used') {
            $condition = 'used';
        } elseif ($current === 'Refurbished') {
            $condition = 'refurbished';
        } else {
            $condition = 'new';
        }
        return $condition;
    }

    /**
     * @return string
     */
    public function image()
    {
        $image_array = explode(',', $this->additional_images);


        $image1 = $this->image_url;

        if (isset($image_array[1])) {
            $image2 = '##' . $image_array[1];
        } else {
            $image2 = '';
        }

        if (isset($image_array[2])) {
            $image3 = '##' . $image_array[2];
        } else {
            $image3 = '';
        }

        if (isset($image_array[3])) {
            $image4 = '##' . $image_array[3];
        } else {
            $image4 = '';
        }

        return $image1 . $image2 . $image3 . $image4;
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

        for ($x = 0.00; $x <= $profit_goal; $percent += 0.00001) {
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
