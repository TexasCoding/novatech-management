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
            'Barcode' => $this->upc_code,
            'Auction Title' => $this->title(
                $this->name,
                $this->sku
            ),
            'Image URL' => $this->image(),
            'Item Condition' => $this->condition,
            'Quantity' => $this->qty,
            'Start' => 'Immediate',
            'End' => 'run until sold',
            'Starting Bid' => '1.00',
            'Sales Tax' => '',
            'Reserve' => '',
            'Feature' => 'Gallery',
            'YouTube Video ID' => '',
            'BuyNow Price' => $this->markup(
                $this->cost_pro_member,
                $this->shipping_cost
            ),
            'Brand' => $this->manufacturer,
            'Domestic Shipping' => '03=0.00',
            'International Shipping' => '01',
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

    private function title($name, $sku)
    {
        $sku_length = strlen($sku) + 1;
        $short_name = preg_replace('/\W\w+\s*(\W*)$/', '$1', substr($name, 0, -$sku_length));

        return $short_name . ' ' . $sku;
    }

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
     * @return string
     */
    private function markup($cost, $shipping)
    {
        $actualCost = $cost * 0.029 + 0.30 + $shipping + $cost;
        $payPal = $actualCost * 0.029 + 0.30;
        $bonanza = $actualCost * 0.02;
        $total = $actualCost + $payPal + $bonanza;
        return number_format($total / 0.93, 2);
    }


}
