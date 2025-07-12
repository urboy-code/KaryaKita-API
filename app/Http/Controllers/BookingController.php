<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();
        $service = Service::findOrFail($validated['service_id']);
        $client = $request->user();

        if ($service->user_id === $client->id) {
            return response()->json(['message' => 'Anda tidak dapat melakukan booking untuk diri sendiri'], 403);
        }

        $booking = $client->clientBookings()->create([
            'talent_id' => $service->user_id,
            'service_id' => $service->id,
            'booking_date' => $validated['booking_date'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking berhasil dibuat',
            'data' => $booking
        ], 201);
    }
}
