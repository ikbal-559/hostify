<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display the specified reservation.
     */
    public function show($id)
    {
        $reservation = \App\Models\Reservation::with(['guests', 'rooms.roomType'])->findOrFail($id);
        return inertia('Reservation/Show', [
            'reservation' => $reservation
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $roomTypes = \App\Models\RoomType::all();
        $rooms = \App\Models\Room::with('roomType');

        // Apply filters if any
        if ($request->filled('room_type')) {
            $rooms->where('room_type_id', $request->input('room_type'));
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = $request->input('start_date');
            $end = $request->input('end_date');
            $rooms->whereDoesntHave('reservations', function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('check_in', '<=', $end)
                      ->where('check_out', '>=', $start);
                });
            });
        }

        $rooms = $rooms->get();

        return inertia('Reservation/Index', [
            'rooms' => $rooms,
            'roomTypes' => $roomTypes,
            'startDate' => ($request->has('start_date')) ? $request->get('start_date') : null,
            'endDate' => ($request->has('end_date')) ? $request->get('end_date') : null,
            'selectedRoomType' => ($request->has('room_type')) ? $request->get('room_type') : null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
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
            'room_ids.*' => 'exists:rooms,id'
        ]);

        // Create reservation
        $reservation = \App\Models\Reservation::create([
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Attach rooms with price_per_night
        $rooms = \App\Models\Room::whereIn('id', $validated['room_ids'])->get();
        $roomData = [];
        foreach ($rooms as $room) {
            $roomData[$room->id] = [
                'price_per_night' => $room->price_per_night,
            ];
        }
        $reservation->rooms()->attach($roomData);

        // Attach guests (create if not exist by email/phone)
        $guestIds = [];
        foreach ($validated['guests'] as $guestData) {
            $guest = \App\Models\Guest::firstOrCreate(
                [
                    'email' => $guestData['email'],
                    'phone' => $guestData['phone'],
                ],
                [
                    'first_name' => $guestData['first_name'],
                    'last_name' => $guestData['last_name'],
                    'date_of_birth' => $guestData['date_of_birth'] ?? null,
                    'gender' => $guestData['gender'] ?? null,
                ]
            );
            $guestIds[] = $guest->id;
        }
        $reservation->guests()->attach($guestIds);
        return redirect()->route('reservations.show', ['id' => $reservation->id]); 
    }

    /**
     * Display the specified resource.
     */
    public function book(string $id, Request $request)
    {
        $room = Room::findOrFail($id);
        return inertia('Reservation/Book', [
            'room' => $room,
            'startDate' => ($request->has('start_date')) ? $request->get('start_date') : null,
            'endDate' => ($request->has('end_date')) ? $request->get('end_date') : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
