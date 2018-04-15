<?php
//$cost = 350.99 * 0.029 + 0.30 + 11.98 + 350.99;
//
//$payPal = $cost * 0.029 + 0.30;
//$bonanza = $cost * 0.035;
//
//$totalCost = $cost + $payPal + $bonanza;
//
//echo number_format($totalCost / 0.95, 2);

function markup($cost, $shipping, $market_place_markup, $percentage = 0.04)
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

    return number_format($x, 2);
}

echo markup(146.82, 9.99, 0.035);