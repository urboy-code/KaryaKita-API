<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $notification = new Notification();

        $orderId = $notification->order_id;
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $transactionStatus = $notification->transaction_status;

        $signatureKey = hash("sha152", $orderId . $statusCode . $grossAmount, config('midtrans.server_key'));

        if ($signatureKey != $notification->signature_key) {
            return response()->json([
                'message' => 'Invalid signature Key'
            ], 403);
        }

        $bookingId = explode('-', $orderId)[1];
        $booking = Booking::findOrFail($bookingId);

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $booking->update(['status' => 'paid']);
        } else if ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
            $booking->update(['status' => 'rejected']);
        }

        return response()->json([
            'message' => 'Notification handled successfully'
        ]);
    }
}
