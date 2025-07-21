<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/services",
     * summary="Menampilkan semua jasa",
     * tags={"Services"},
     * @OA\Response(
     * response=200,
     * description="Operasi berhasil",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ServiceResource"))
     * )
     * )
     */
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

    public function show(Service $service)
    {
        $service->load('user.profile', 'category');

        return new ServiceResource($service);
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        FacadesGate::authorize('update', $service);
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            // Hapus foto lama biar hemat tempat
            if ($service->photo) {
                Storage::disk('public')->delete($service->photo);
            }
            // Simpan foto baru
            $validated['photo'] = $request->file('photo')->store('service-photos', 'public');
        }

        // Update data di database
        $service->update($validated);

        // Kembalikan data yang sudah diupdate dengan format rapi
        return new ServiceResource($service);
    }
    public function destroy(Service $service)
    {
        // Satpam Otorisasi
        FacadesGate::authorize('delete', $service);

        // Hapus foto dari storage
        if ($service->photo) {
            Storage::disk('public')->delete($service->photo);
        }

        // Hapus data dari database
        $service->delete();

        // Beri pesan sukses
        return response()->json(['message' => 'Jasa berhasil dihapus']);
    }
}
