<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_jasa' => $this->id,
            'judul' => $this->title,
            'slug' => $this->slug,
            'harga_format' => 'Rp ' . number_format($this->price),
            'harga_angka' => $this->price,
            'deskripsi_singkat' => Str::limit($this->description, 100),
            'foto_url' => $this->photo ? asset('storage/'.$this->photo) : null,
            'kategori' => [
                'nama_kategori' => $this->category?->name,
                'slug_kategori' => $this->category?->slug,
            ],
            'talent' => [
                'nama_talent' => $this->user?->name,
                'kota' => $this->user?->profile?->city,
            ],
        ];
    }
}
