<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;

class TalentBookingController extends Controller
{
    //
    public function index(Request $request)
    {
        $talent = $request->user();

        $bookings = $talent->talentBookings()->with(['client', 'service'])->latest()->paginate(9);

        return BookingResource::collection($bookings);
    }
}
