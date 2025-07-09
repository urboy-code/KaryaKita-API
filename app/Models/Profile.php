<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'city',
        'profile_photo',
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
