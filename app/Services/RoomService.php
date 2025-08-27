<?php

namespace App\Services;

use App\Models\Room;

class RoomService
{
    // Add your business logic related to Room here
    // Example: create, update, delete, or custom queries

    public function createRoom(array $data): Room
    {
        return Room::create($data);
    }

    public function updateRoom(Room $room, array $data): bool
    {
        return $room->update($data);
    }

    public function deleteRoom(Room $room): bool
    {
        return $room->delete();
    }

    /**
     * Handle thumbnail upload and return the stored path or null.
     */
    public function handleThumbnailUpload($request): ?string
    {
        if ($request->hasFile('thumbnail')) {
            return $request->file('thumbnail')->store('thumbnails', 'public');
        }
        return null;
    }
}
