<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'number' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'availability_status' => 'required|integer',
            'bed_type' => 'required|integer',
            'number_of_beds' => 'required|integer',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'price_per_night' => 'required|numeric',
            'capacity' => 'required|integer',
            'floor' => 'required|integer',
            'room_size' => 'nullable|string',
            'view' => 'nullable|string',
            'smoking_allowed' => 'required|boolean',
            'special_notes' => 'nullable|string',
        ];
    }
}
