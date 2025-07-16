<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_booking' => $this->id,
            'tanggal_booking' => $this->booking_date,
            'status' => $this->status,
            'jasa_dipesan' => [
                'id_jasa' => $this->service?->id,
                'judul' => $this->service?->title,
                'harga' => $this->service?->price,
            ],
            'klien' => [
                'id_klien' => $this->client?->id,
                'nama_klien' => $this->client?->name,
            ],
            'talent' => [
                'id_talent' => $this->talent?->id,
                'nama_talent' => $this->talent?->name,
            ]
        ];
    }
}
