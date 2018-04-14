<?php
$cost = 350.99 * 0.029 + 0.30 + 11.98 + 350.99;

$payPal = $cost * 0.029 + 0.30;
$bonanza = $cost * 0.035;

$totalCost = $cost + $payPal + $bonanza;

echo number_format($totalCost / 0.95, 2);