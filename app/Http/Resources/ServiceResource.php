<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ServiceResource extends JsonResource
{
    /**
     * @OA\Schema(
     * schema="ServiceResource",
     * title="Service Resource",
     * description="Format data untuk satu jasa",
     * @OA\Property(property="id_jasa", type="integer", example=1),
     * @OA\Property(property="judul", type="string", example="Desain Logo"),
     * @OA\Property(property="slug", type="string", example="desain-logo"),
     * @OA\Property(property="harga_format", type="string", example="Rp 10.000"),
     * @OA\Property(property="harga_angka", type="integer", example=10000),
     * @OA\Property(property="deskripsi_singkat", type="string", example="Desain logo untuk perusahaan"),
     * @OA\Property(property="deskripsi_lengkap", type="string", example="Desain logo untuk perusahaan"),
     * @OA\Property(property="foto_url", type="string"),
     * @OA\Property(property="kategori", type="object"),
     * @OA\Property(property="talent", type="object"),
     * )
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
            'deskripsi_lengkap' => $this->description,
            'foto_url' => $this->photo ? asset('storage/' . $this->photo) : null,
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
