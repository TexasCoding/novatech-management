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
            'description' => $this->description,
            'price' => $this->markup($this->cost_free_member_pro, $this->shipping_cost),
            'image1' => $this->image_url,
            'image2' => $this->image_url,
            'image3' => $this->image_url,
            'category' => $this->category->bonanza_category,
            'shipping_price' => 0,
            'shipping_type' => 'free',
            'sku' => $this->sku,
            'qty' => $this->qty,
            'trait' => $this->traits($this->manufacturer, $this->condition, $this->mpn, $this->upc_code),
            'force_update' => 'true'
        ];
    }

    private function title($name, $sku) {
        $sku_length = strlen($sku) + 1;
        $short_name = preg_replace('/\W\w+\s*(\W*)$/', '$1', substr($name, 0, -$sku_length));

        return $short_name . ' ' . $sku;
    }

    private function traits($brand, $condition, $mpn, $upc)
    {
        return $brand ? "[[brand: $brand]] " : ''
        . $condition ? "[[condition: $condition]] " : ''
        . $mpn ? "[[mpn: $mpn]] " : ''
        . $upc ? "[[upc: $upc]]" : '';
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
