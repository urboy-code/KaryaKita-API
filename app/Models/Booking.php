<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = [
        'client_id',
        'talent_id',
        'service_id',
        'booking_date',
        'notes',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function talent()
    {
        return $this->belongsTo(User::class, 'talent_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
