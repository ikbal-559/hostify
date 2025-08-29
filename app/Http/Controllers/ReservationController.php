<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Repositories\RoomRepository;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Facades\DB;
use App\Models\RoomType;

class ReservationController extends Controller
{
    protected $roomRepo;

    public function __construct()
    {
        $this->roomRepo = new RoomRepository();
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validate filter input
        $validated = $request->validate([
            'room_type' => 'nullable|exists:room_types,id',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $rooms = $this->roomRepo->getFilteredRooms($validated, 15);
        return inertia('Reservation/Index', [
            'rooms' => $rooms,
            'roomTypes' =>  RoomType::all(),
            'startDate' => $validated['start_date'] ?? null,
            'endDate' => $validated['end_date'] ?? null,
            'selectedRoomType' => $validated['room_type'] ?? null,
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object) [],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

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

            // Handle guests
            $guestIds = $this->handleGuests($validated['guests']);
            $reservation->guests()->attach($guestIds);

            DB::commit();
            return redirect()->route('reservations.show', ['id' => $reservation->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            // Optionally, log the error: \Log::error($e);
            return back()->withErrors(['error' => 'Failed to create reservation. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function book(string $id, Request $request)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        // Optionally, check room availability here
        // $isAvailable = $room->isAvailable($validated['start_date'] ?? null, $validated['end_date'] ?? null);

        return inertia('Reservation/Book', [
            'room' => $room,
            'startDate' => $validated['start_date'] ?? null,
            'endDate' => $validated['end_date'] ?? null,
            // 'isAvailable' => $isAvailable, // Uncomment if availability logic is added
        ]);
    }


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
     * Handle guest creation, update, and lookup for reservation.
     * @param array $guests
     * @return array $guestIds
     */
    private function handleGuests(array $guests): array
    {
        $guestIds = [];
        foreach ($guests as $guestData) {
            $guest = null;
            if (!empty($guestData['email']) || !empty($guestData['phone'])) {
                $query = \App\Models\Guest::query();
                if (!empty($guestData['email']) && !empty($guestData['phone'])) {
                    $query->where('email', $guestData['email'])
                        ->where('phone', $guestData['phone']);
                } elseif (!empty($guestData['email'])) {
                    $query->where('email', $guestData['email']);
                } elseif (!empty($guestData['phone'])) {
                    $query->where('phone', $guestData['phone']);
                }
                $guest = $query->first();
            }
            if ($guest) {
                $updated = false;
                foreach (['first_name', 'last_name', 'date_of_birth', 'gender'] as $field) {
                    if (isset($guestData[$field]) && $guest->$field !== $guestData[$field]) {
                        $guest->$field = $guestData[$field];
                        $updated = true;
                    }
                }
                if ($updated) {
                    $guest->save();
                }
            } else {
                $guest = \App\Models\Guest::create([
                    'first_name' => $guestData['first_name'],
                    'last_name' => $guestData['last_name'],
                    'email' => $guestData['email'] ?? null,
                    'phone' => $guestData['phone'] ?? null,
                    'date_of_birth' => $guestData['date_of_birth'] ?? null,
                    'gender' => $guestData['gender'] ?? null,
                ]);
            }
            $guestIds[] = $guest->id;
        }
        return $guestIds;
    }
}
