<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|array|min:1',
            'guests.*.first_name' => 'required|string',
            'guests.*.last_name' => 'required|string',
            'guests.*.email' => 'nullable|email',
            'guests.*.phone' => 'nullable|string',
            'guests.*.date_of_birth' => 'nullable|date',
            'guests.*.gender' => 'nullable|in:male,female,other',
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'exists:rooms,id',
        ];
    }
}
