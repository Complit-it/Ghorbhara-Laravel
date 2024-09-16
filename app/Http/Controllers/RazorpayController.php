<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
class RazorpayController extends Controller
{
    private $razorpayId = 'rzp_live_yNTs8q4TxSKx67';
    private $razorpayKey = '8DxlSMiqgU7g3qrcDrPYlq4u';

    public function createOrder(Request $request)
    {
        $api = new Api($this->razorpayId, $this->razorpayKey);

        $order = $api->order->create([
            'receipt' => 'order_rcptid_11',
            'amount' => $request->amount * 100, // amount in the smallest currency unit
            'currency' => 'INR',
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount'],
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api($this->razorpayId, $this->razorpayKey);

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
