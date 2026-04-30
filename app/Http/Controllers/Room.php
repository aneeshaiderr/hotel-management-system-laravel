<?php

namespace App\Http\Controllers;

use App\Models\Room as RoomModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Room extends Controller
{
    public function index(Request $request)
    {
        return view('Frontend/room');
    }

    public function dashboardIndex()
    {
        return view('dashboard.rooms.room');
    }

    public function datatable(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $rooms = RoomModel::query()->select([
            'id',
            'hotel_id',
            'room_number',
            'floor',
            'status',
            'beds',
            'max_guests',
            'created_at',
        ]);

        return DataTables::eloquent($rooms)
            ->editColumn('created_at', static fn (RoomModel $room) => $room->created_at?->format('Y-m-d H:i'))
            ->toJson();
    }
    public function create()
    {
        $hotels = \App\Models\Hotel::all();
        return view('dashboard.rooms.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required',
            'room_number' => 'required',
            'floor' => 'required',
            'beds' => 'required',
            'max_guests' => 'required',
            'status' => 'required',
        ]);

        try {
            RoomModel::create($request->all());
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Room created successfully.']);
            }
            return redirect()->route('dashboard.rooms')->with('success', 'Room created successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $room = RoomModel::findOrFail($id);
        $hotels = \App\Models\Hotel::all();
        return view('dashboard.rooms.edit', compact('room', 'hotels'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'hotel_id' => 'required',
            'room_number' => 'required',
            'floor' => 'required',
            'beds' => 'required',
            'max_guests' => 'required',
            'status' => 'required',
        ]);

        try {
            $room = RoomModel::findOrFail($request->id);
            $room->update($request->all());
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Room updated successfully.']);
            }
            return redirect()->route('dashboard.rooms')->with('success', 'Room updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $room = RoomModel::findOrFail($request->id);
            $room->delete();
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Room deleted successfully.']);
            }
            return redirect()->route('dashboard.rooms')->with('success', 'Room deleted successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return back()->with('error', $e->getMessage());
        }
    }
}
