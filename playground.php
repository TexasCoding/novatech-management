<?php
$cost = number_format(127.98 * 0.029 + 0.30 + 9.10 + 127.98, 2);

$payPal = $cost * 0.029 + 0.30;
$bonanza = $cost * 0.035;

$totalCost = $cost + $payPal + $bonanza;

echo number_format($totalCost / 0.93, 2);