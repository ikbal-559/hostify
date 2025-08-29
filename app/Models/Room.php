<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    public const SINGLE_BED = 1;
    public const DOUBLE_BED = 2;
    public const TWO_SINGLE_BEDS = 3;
    public const FAMILY_ROOM = 4;

    public const STATUS_AVAILABLE = 1;
    public const STATUS_OCCUPIED = 2;
    public const STATUS_MAINTENANCE = 3;

    protected $fillable = [
        'number',
        'room_type_id',
        'availability_status',
        'bed_type',
        'number_of_beds',
        'description',
        'thumbnail',
        'price_per_night',
        'capacity',
        'floor',
        'room_size',
        'view',
        'smoking_allowed',
        'special_notes',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

        /**
     * Get the available status options for a room.
     *
     * @return array
     */
    public static function availabilityStatusOptions(): array
    {
        return [
            [
                'value' => self::STATUS_AVAILABLE,
                'label' => 'Available',
            ],
            [
                'value' => self::STATUS_OCCUPIED,
                'label' => 'Occupied',
            ],
            [
                'value' => self::STATUS_MAINTENANCE,
                'label' => 'Maintenance',
            ],
        ];
    }

    public static function bedTypeOptions(): array
    {
        return [
            [
                'value' => self::SINGLE_BED,
                'label' => 'Single Bed',
            ],
            [
                'value' => self::DOUBLE_BED,
                'label' => 'Double Bed',
            ],
            [
                'value' => self::TWO_SINGLE_BEDS,
                'label' => 'Two Single Beds',
            ],
            [
                'value' => self::FAMILY_ROOM,
                'label' => 'Family Room',
            ],
        ];
    }

    // Accessor for thumbnail_url
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            // If already a full URL, return as is
            if (preg_match('/^https?:\/\//', $this->thumbnail)) {
                return $this->thumbnail;
            }
            // Otherwise, assume it's a path in storage/app/public/rooms
            return asset('storage/rooms/' . ltrim($this->thumbnail, '/'));
        }
        return null;
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_room')
            ->withPivot('price_per_night')
            ->withTimestamps();
    }
    

}
