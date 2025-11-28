<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;


class MidtransCallbackController extends Controller
{
public function handle(Request $request)
{
$payment = Payment::where('order_code', $request->order_id)->firstOrFail();
$payment->update([
'transaction_status' => $request->transaction_status,
'transaction_id' => $request->transaction_id,
'payment_type' => $request->payment_type,
'payload' => $request->all()
]);


if ($request->transaction_status === 'settlement') {
$payment->order->update(['status' => 'paid']);
}


return response()->json(['message' => 'OK']);
}
}