<?php

namespace App\Repositories;

use App\Models\Room;

class RoomRepository
{
    /**
     * Get filtered and paginated rooms with room type.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilteredRooms(array $filters, $perPage = 15)
    {
        $query = Room::with('roomType');

        if (!empty($filters['room_type'])) {
            $query->where('room_type_id', $filters['room_type']);
        }
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $start = $filters['start_date'];
            $end = $filters['end_date'];
            $query->whereDoesntHave('reservations', function ($q) use ($start, $end) {
                $q->where(function ($q2) use ($start, $end) {
                    $q2->where('check_in', '<=', $end)
                        ->where('check_out', '>=', $start);
                });
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
