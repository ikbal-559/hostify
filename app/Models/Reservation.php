<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'reservation_room')
            ->withPivot('price_per_night')
            ->withTimestamps();
    }

    public function guests()
    {
        return $this->belongsToMany(Guest::class, 'guest_reservation')
            ->withTimestamps();
    }
}
