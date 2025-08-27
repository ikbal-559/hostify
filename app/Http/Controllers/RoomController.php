<?php

namespace App\Http\Controllers;

use App\Services\RoomService;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;

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
        $availabilityStatusOptions = Room::availabilityStatusOptions();
        $bedTypeOptions = Room::bedTypeOptions();
        return Inertia::render('Rooms', [
            'rooms' => $rooms,
            'availabilityStatusOptions' => $availabilityStatusOptions,
            'bedTypeOptions' => $bedTypeOptions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTypes = RoomType::all();
        $availabilityStatusOptions = Room::availabilityStatusOptions();
        $bedTypeOptions = Room::bedTypeOptions();
        return Inertia::render('Rooms/Create', [
            'roomTypes' => $roomTypes,
            'availabilityStatusOptions' => $availabilityStatusOptions,
            'bedTypeOptions' => $bedTypeOptions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @param StoreRoomRequest $request
     */
    public function store(StoreRoomRequest $request, RoomService $roomService)
    {
        try {
            $validated = $request->validated();
            $thumbnailPath = $roomService->handleThumbnailUpload($request);
            if ($thumbnailPath) {
                $validated['thumbnail'] = $thumbnailPath;
            }
            Room::create($validated);
            return redirect()->route('rooms.index')
                ->with('success', 'Room created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create room. Please try again.']);
        }
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
    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();
        $availabilityStatusOptions = Room::availabilityStatusOptions();
        $bedTypeOptions = Room::bedTypeOptions();
        return Inertia::render('Rooms/Edit', [
            'room' => $room,
            'roomTypes' => $roomTypes,
            'availabilityStatusOptions' => $availabilityStatusOptions,
            'bedTypeOptions' => $bedTypeOptions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @param UpdateRoomRequest $request
     */
    public function update(UpdateRoomRequest $request, Room $room, RoomService $roomService)
    {
        try {
            $validated = $request->validated();
            $thumbnailPath = $roomService->handleThumbnailUpload($request);
            if ($thumbnailPath) {
                $validated['thumbnail'] = $thumbnailPath;
            } else {
                unset($validated['thumbnail']); // Don't update thumbnail if not uploading a new one
            }
            $room->fill($validated);
            $room->save();
            return redirect()->route('rooms.index')
                ->with('success', 'Room updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update room. Please try again.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            return redirect()->route('rooms.index')
                ->with('success', 'Room deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete room. Please try again.']);
        }
    }
}
