<?php
    namespace App\Services;


use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Payment;


class MidtransService
{
public function __construct()
{
Config::$serverKey = config('midtrans.server_key');
Config::$isProduction = config('midtrans.is_production');
Config::$isSanitized = true;
Config::$is3ds = true;
}


public function createTransaction($order, Payment $payment)
{
$params = [
'transaction_details' => [
'order_id' => $payment->order_code,
'gross_amount' => $order->total_price,
],
'customer_details' => [
'first_name' => $order->buyer->name ?? 'Customer',
'email' => $order->buyer->email ?? 'example@mail.com',
],
'item_details' => $order->orderDetails->map(function ($item) {
return [
'id' => $item->product_id,
'price' => $item->price,
'quantity' => $item->quantity,
'name' => $item->product->name,
];
})->toArray()
];


return Snap::createTransaction($params);
}
}
?>