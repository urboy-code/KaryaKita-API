<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TalentBookingController extends Controller
{
    //
    public function index(Request $request)
    {
        $talent = $request->user();

        $bookings = $talent->talentBookings()->with(['client', 'service'])->latest()->paginate(9);

        return BookingResource::collection($bookings);
    }

    public function accept(Request $request, Booking $booking)
    {
        Gate::authorize('update', $booking);

        $booking->update(['status' => 'accepted']);

        return new BookingResource($booking);
    }

    public function reject(Request $request, Booking $booking)
    {
        Gate::authorize('update', $booking);

        $booking->update(['status' => 'rejected']);

        return new BookingResource($booking);
    }
}
