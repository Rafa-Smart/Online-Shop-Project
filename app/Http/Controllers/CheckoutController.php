<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;


class CheckoutController extends Controller
{
public function checkout(Request $request, MidtransService $midtrans)
{
$order = Order::with('orderDetails.product', 'buyer')->findOrFail($request->order_id);


$code = 'INV-' . now()->format('YmdHis') . '-' . $order->id;


$payment = Payment::create([
'order_id' => $order->id,
'order_code' => $code,
'transaction_status' => 'pending'
]);


$midtransRes = $midtrans->createTransaction($order, $payment);


$payment->update([
'snap_token' => $midtransRes->token,
'snap_redirect_url' => $midtransRes->redirect_url,
]);


return response()->json([
'token' => $midtransRes->token,
'redirect_url' => $midtransRes->redirect_url,
]);
}
}