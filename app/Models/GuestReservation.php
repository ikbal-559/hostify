<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GuestReservation extends Pivot
{
    protected $table = 'guest_reservation';
    protected $fillable = [
        'reservation_id',
        'guest_id',
    ];
}
