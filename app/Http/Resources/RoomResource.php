<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'room_type' => new RoomTypeResource($this->whenLoaded('roomType')),
            'bed_type' => $this->bed_type,
            'thumbnail_url' => $this->thumbnail_url,
            'availability_status' => $this->availability_status,
            'number_of_beds' => $this->number_of_beds,
            'description' => $this->description,
            'price_per_night' => $this->price_per_night,
            'capacity' => $this->capacity,
            'floor' => $this->floor,
            'room_size' => $this->room_size,
            'view' => $this->view,
            'smoking_allowed' => $this->smoking_allowed,
            'special_notes' => $this->special_notes,
        ];
    }
}
