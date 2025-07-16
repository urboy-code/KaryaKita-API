<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;

class ClientBookingController extends Controller
{
    //
    public function index(Request $request){
        $client = $request->user();

        $bookings = $client->clientBookings()->with(['talent.profile', 'service'])->latest()->paginate(9);

        return StoreBookingRequest::collection($bookings);
    }
}
