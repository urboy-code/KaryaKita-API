<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClientBookingController extends Controller
{
    //
    public function index(Request $request)
    {
        $client = $request->user();

        $bookings = $client->clientBookings()->with(['talent.profile', 'service'])->latest()->paginate(9);

        return BookingResource::collection($bookings);
    }

    public function initiatePayment(Request $request, Booking $booking)
    {
        Gate::authorize('pay', $booking);

        if ($booking->status !== 'accepted') {
            return response()->json([
                'meessage' => 'Booking ditolak.'
            ], 403);
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        $params = [
            'transaction_details' => [
                'order_id' => $booking->id,
                'gross_amount' => $booking->service->price,
            ],
            'customer_details' => [
                'first_name' => $booking->client->name,
                'email' => $booking->client->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'message' => 'Token pembayaran berhasil dibuat',
            'snap_token' => $snapToken,
        ]);
    }
}
