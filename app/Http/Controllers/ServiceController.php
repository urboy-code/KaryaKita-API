<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //
    public function index()
    {
        $services = Service::with(['user.profile', 'category'])->latest()->paginate(9);

        return ServiceResource::collection($services);
    }

    public function store(StoreServiceRequest $request)
    {
        $validated = $request->validated();

        // Handle file upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('service-photos', 'public');
            $validated['photo'] = $path;
        }

        // Buat service baru untuk user yang sedang login
        $service = $request->user()->service()->create($validated);

        return (new ServiceResource($service))->response()->setStatusCode(201);
    }
}
