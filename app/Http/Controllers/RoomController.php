<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\RoomType;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $rooms = Room::with('roomType')->get();
            return Inertia::render('Rooms', [
                'rooms' => $rooms
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $roomTypes = RoomType::all();
            return Inertia::render('Rooms/Create', [
                'roomTypes' => $roomTypes
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
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
        ]);
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        Room::create($validated);
        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
            $room = Room::findOrFail($id);
            $roomTypes = RoomType::all();
            return Inertia::render('Rooms/Edit', [
                'room' => $room,
                'roomTypes' => $roomTypes
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
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
        ]);
        $room = Room::findOrFail($id);
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            unset($validated['thumbnail']); // Don't overwrite with null if not uploading
        }
        $room->update($validated);
        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
